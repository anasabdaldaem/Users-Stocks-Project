<?php


class usrstocks_model extends CI_Model{

    public function __construct()
    {
        $this->load->database();
        $this->load->helper('url');
    }

    /*
        Get all the records from the database
    */
    public function get_all($table)
    {

        $data=$this->db->get($table);
        return  $data;
    }

    /*
        Store the record in the database
    */
    public function store($table , $data)
    {
        return $this->db->insert($table, $data);
    }

    /*
        Get an specific record from the database
    */
    public function get($id,$table)
    {

        $data=$this->db->get_where($table, ['id' => $id ])->row();
        return $data;
    }


    /*
        Update or Modify a record in the database
    */
    public function update($id ,$table,$data)
    {


        return $this->db->where('id',$id)->update($table,$data);

    }

    /*
        Destroy or Remove a record in the database
    */
    public function delete($id ,$table)
    {
        return $this->db->delete($table, array('id' => $id));
    }

}
?>
