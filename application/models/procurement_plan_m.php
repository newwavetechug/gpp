<?php
class Procurement_plan_m extends MY_Model
{
    public $_tablename='procurement_plans';
    public $_primary_key='id';
    function __construct()
    {
        parent::__construct();

        $this->load->model('users_m');
        $this->load->model('pde_m');

    }

    //validate procurement plan form
    public $validate_plan=array
    (
		array
		(
			'field'   => 'start_year',
			'label'   => 'Start year',
			'rules'   => 'required'
		),
		array
		(
			'field'   => 'end_year',
			'label'   => 'End year',
			'rules'   => 'required'
		)
    );

    //validate procurement plan form
    public $validate_edit_plan=array
    (

        array
        (
            'field'   => 'title',
            'label'   => 'title',
            'rules'   => 'required'
        ),
    );

    //visible and trashed
    public function get_all_procurement_plans()//visible is either y or n
    {
        $this->db->cache_on();
        $query=$this->db->select()->from($this->_tablename)->order_by($this->_primary_key,'DESC')->get();
        //echo $this->db->last_query();
        return $query->result_array();
    }


    //get by passed parameters
    public function get_where($where)
    {
        $this->db->cache_on();
        $query=$this->db->select()->from($this->_tablename)->where($where)->order_by($this->_primary_key,'DESC')->get();


        return $query->result_array();
    }




    public function get_paginated($num=20,$start)
    {
        //echo $this->$_primary_key.'foo';
        //build query
        $this->db->cache_on();
        $q=$this->db->select()->from($this->_tablename)->limit($num,$start)->where('trash','n')->order_by($this->_primary_key,'DESC')->get();
        //echo $this->db->last_query();

        //return result
        return $q->result_array();

    }

    //get paginated
    public function get_paginated_by_criteria($num=20,$start,$criteria)
    {
        //build query
        $this->db->cache_on();
        $q=$this->db->select()->from($this->_tablename)->limit($num,$start)->where($criteria)->order_by($this->_primary_key,'DESC')->get();
        //echo $this->db->last_query();

        //return result
        return $q->result_array();

    }
    //create
    public function create($data)
    {
        $this->db->insert($this->_tablename,$data);
        //echo $this->db->last_query();
        $this->db->cache_delete_all();
        return $this->db->insert_id();

    }

    public function get_procurement_plan_info($plan_id,$param)
    {
        $this->db->cache_on();
        $query=$this->db->select()->from($this->_tablename) ->where($this->_primary_key,$plan_id)->get();
        
       # print_array($this->db->last_query());
       # print_r($this->_tablename); exit();

        $info_array=$query->result_array();



        //if there is a result
        if(count($info_array))
        {

            foreach($info_array as $row)
            {
                switch ($param)
                {
                    case 'financial_year':
                        $result=$row['financial_year'];
                        break;
                    case 'title':
                        $result=$row['title'];
                        break;
                    case 'pde_id':
                        $result=$row['pde_id'];
                        break;
                    case 'pde':
                        $result=get_pde_info_by_id($row['pde_id'],'title');
                        break;
                    case 'description':
                        $result=$row['description'];
                        break;
                    case 'author_id':
                        $result=$row['author'];
                        break;
                    case 'author':
                        $result=get_user_info_by_id($row['author'],'fullname');
                        break;
                    case 'isactive':
                        $result=$row['active'];
                        break;
                    case 'dateadded':
                        $result=$row['dateadded'];
                        break;
                    default:
                        //no parameter is passed display all user info
                        $result=$info_array;
                }
            }

            return $result;

        }
        else
        {
            return NULL;
        }

    }


    //get by id
    public function get_by_id($id='')
    {
        //if its empty get all visible
        if($id=='')
        {
            return NULL;
        }
        else
        {
            $data=array
            (
                'id'        =>$id
            );
            $this->db->cache_on();
            $query=$this->db->select()->from($this->_tablename)->where($data)->order_by($this->_primary_key,'DESC')->get();

        }
        //echo $this->db->last_query();

        return $query->result_array();
    }

    public function update($id,$data)
    {
        $this->db->where('id', $id);
        $this->db->update($this->_tablename, $data);

        //echo $this->db->last_query();

        return $this->db->affected_rows();
        $this->db->cache_delete_all();
    }

    //update by
    public function update_by($key,$key_value,$data)
    {
        $this->db->where($key, $key_value);
        $this->db->update($this->_tablename, $data);

        //echo $this->db->last_query();
        $this->db->cache_delete_all();

        return $this->db->affected_rows();

    }
    
    
    //pdes with procurement plans
    public function compliant_pdes($where=''){
        if(is_array($where)){
            $this->db->select('*');
            $this->db->from('pdes');
            $this->db->join('procurement_plans', 'pdes.pdeid = '.$this->_tablename.'.pde_id');
            $this->db->where($where);
            //$this->db->join('table3', 'table1.id = table3.id');


        }else{
            $this->db->select('*');
            $this->db->from('pdes');
            $this->db->join('procurement_plans', 'pdes.pdeid = '.$this->_tablename.'.pde_id');
            //$this->db->join('table3', 'table1.id = table3.id');


        }
        $query = $this->db->get();


        return $query->result_array();

    }





}