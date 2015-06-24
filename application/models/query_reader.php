<?php
#Picks queries from the database, inserts requested data and then returns the query for processing
class Query_reader extends CI_Model{
	
	#a variable to hold the cached queries to prevent pulling from the DB for each request
    private $cachedQueries=array();
	
	#Constructor
	function Query_reader()
	{
		parent::__construct();
		$this->load->database();
		
		#Use the query cache if its enabled
		$this->load->helper('queries_list');
	}
	
	#Function which picks the queries from the database
	function get_query_by_code($queryCode, $queryData = array())
	{
		#$cachedQuery = ENABLE_QUERY_CACHE? get_sys_query($queryCode):'';
		#$queryString = (!empty($cachedQuery) && ENABLE_QUERY_CACHE)? $cachedQuery: $this->get_raw_query_string($queryCode);
		
		$queryString = $this->get_raw_query_string($queryCode);
		
		return !empty($queryString)? $this->populate_template($queryString, $queryData): $queryString;
	}
	


	# Populate the query template with the provided values
	function populate_template($template, $queryData = array())
	{
		$query = $template;
		# Process the query data to fit the field format expected by the query
		$queryData = $this->format_field_for_query($queryData);
		
		#replace place holders with actual data required in the string
		foreach($queryData AS $key => $value)
		{
			$query = str_replace("'".$key."'", "'".$value."'", $query);
		}
			
		#Then replace any other keys without quotes
		foreach($queryData AS $key => $value)
		{
			$query = str_replace($key, ''.$value, $query);
		}
		
		return $query;
	}
	

	#Load queries into the cache file
	private function load_queries_into_cache()
	{
		$queries = $this->db->query("SELECT * FROM appqueries")->result_array();
		
		#Now load the queries into the file
		file_put_contents(QUERY_FILE, "<?php ".PHP_EOL."global \$sysQuery;".PHP_EOL); 
		foreach($queries AS $query)
		{
			$queryString = "\$sysQuery['".$query['querycode']."'] = \"".str_replace('"', '\"', $query['query'])."\";".PHP_EOL;  
			file_put_contents(QUERY_FILE, $queryString, FILE_APPEND);
		}
		
		file_put_contents(QUERY_FILE, PHP_EOL.PHP_EOL." function get_sys_query(\$code) { ".PHP_EOL."global \$sysQuery; ".PHP_EOL."return !empty(\$sysQuery[\$code])? \$sysQuery[\$code]: '';".PHP_EOL." }".PHP_EOL, FILE_APPEND); 
	}
	
	
	# Returns the raw query string
	private function get_raw_query_string($queryCode)
	{
		# Get the query from the database by the query code
		$qresultArray = $this->db->query("SELECT query FROM appqueries WHERE querycode = '".$queryCode."'")->row_array();
		return !empty($qresultArray['query'])? $qresultArray['query']: '';
	}	
	
	# Returns all fields in the format array('_FIELDNAME_', 'fieldvalue') which is expected by the database 
	# query processing function
	function format_field_for_query($query_data)
	{	
		$data_for_query = array();
	
		foreach($query_data AS $key => $value)
		{
			#e.g., $query_data['_LIMIT_'] = "10";
			$data_for_query['_'.strtoupper($key).'_'] = $value;
		}
		
		return $data_for_query;
	}
	
	# Used if only one row is expected from the query being requested
	# Returns results as an array from the database
	function get_row_as_array($query_code, $field_array)
	{
		# Array to store the result data
		$this_row_array = array();
		$this_query = "";
		 
		$this_query = $this->get_query_by_code($query_code, $field_array);
		
		#echo "<br>QUERY [".$query_code."]: ".$this_query;
		if($this_query != "")
		{
			$this_result = $this->db->query($this_query);
			
			# Only get an array if there is a satisfying result
			if($this_result->num_rows() > 0)
			{
				foreach($this_result->result_array() AS $this_dbrow)
				{
					$this_row_array = $this_dbrow;
					break;
				}
			}
		}
		
		return $this_row_array;
	}
	
	//build insert string
	function dbinsert_str($table, $data)
	{
		$insert_str = 'INSERT INTO `' . $table . '` SET ';
		$fieldmap = '';
		foreach($data as $col => $val)
			$fieldmap .= ($fieldmap == '')? "`" . $col . "`='" . $val . "'" : ",`" . $col . "`='" . $val . "'" ;
			
		return $insert_str . $fieldmap;
	}
	
	//build update string
	function dbupdate_str($table, $data, $editid, $editid_column)
	{
		$update_str = 'UPDATE `' . $table . '` SET ';
		$fieldmap = '';
		foreach($data as $col => $val)
			$fieldmap .= ($fieldmap == '')? "`" . $col . "`='" . $val . "'" : ",`" . $col . "`='" . $val . "'" ;
			
		return $update_str . $fieldmap . ' WHERE `' . $editid_column . '`="' . $editid . '"';
	}
}


?>