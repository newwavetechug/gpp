<?php
class Pde_department_m extends CI_Model
{
    public $_tablename='pde_departments';
    public $_primary_key='id';
    function __construct()
    {
        parent::__construct();

        $this->load->model('users_m');

    }

    //visible and trashed
    public function get_all()//visible is either y or n
    {
        $query=$this->db->select()->from($this->_tablename)->order_by($this->_primary_key,'DESC')->get();
        //echo $this->db->last_query();
        return $query->result_array();
    }

    //get procurement method details
    function get_pde_department_info($id='',$param='')
    {
        if($id=='')
        {
            return NULL;
        }
        else
        {
           $query=$this->db->select()->from($this->_tablename) ->where($this->_primary_key,$id)->get();
        }

        if($query->result_array())
        {
            foreach($query->result_array() as $row)
            {
                switch($param)
                {
                    case 'title':
                        $result=$row['title'];
                        break;

                    case 'author_id':
                        $result=$row['author'];
                        break;
                    case 'author':
                        $result=get_user_info($row['author'],'fullname');
                        break;
                    case 'isactive':
                        $result=$row['active'];
                        break;
                    case 'dateadded':
                        $result=$row['dateadded'];
                        break;
                    default:
                        $result=$query->result_array();
                }
            }

            return $result;
        }
        else
        {
           return NULL;
        }




    }



    //get by passed parameters
    public function get_where($where)
    {
        $query=$this->db->select()->from($this->_tablename)->where($where)->order_by($this->_primary_key,'DESC')->get();

        return $query->result_array();
    }






}
 