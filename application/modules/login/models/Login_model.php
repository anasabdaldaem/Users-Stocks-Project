<?php
class Login_model extends CI_Model{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->helper('url');
    }

    /*
    Get all the records from the database
    */
    public function get_all($table)
    {
        return $this->db->get($table)->result();
    }

    /*
    Store the record in the database
    */
    public function store($table,$data)
    {
        return $this->db->insert($table, $data);
    }

    /*
    Get an specific record from the database
    */
    public function getbyid($table,$id)
    {
        return $this->db->get_where($table, ['id' => $id ])->row();
    }


    /*
    Update or Modify a record in the database
    */
    public function update($table,$id,$data)
    {
        return $this->db->where('id',$id)->update($table,$data);

    }

    /*
    Destroy or Remove a record in the database
    */
    public function delete($table,$id)
    {
        return $this->db->delete($table, array('id' => $id));
    }

}

