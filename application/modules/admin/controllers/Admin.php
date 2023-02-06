<?php

class Admin extends MY_Controller{

    public function __construct()
    {
        parent::__construct();
        $this->load->module(array(['template']));
    }

    public function index()
    {
        $data['data'] = $this->session->userdata('data');
        if($this->session->userdata('data')) {
            $data['data'] = $this->session->userdata('data');
        }
        else
        {
            $this->session->set_flashdata('error',"you must sign in first");
            redirect('login');
        }
        $this->load->view('template/Header');
        $this->load->view('template/Sidebar');
        $this->load->view('mainadmin_view',$data);
        $this->load->view('template/Footer');
    }

}
