<?php

class Main extends MY_Controller {


    public function __construct()
    {
        // Load the constructer from MY_Controller
        parent::__construct();
        $this->load->library(array(['form_validation','session']));

    }

	public function index()
	{
        if($this->session->userdata('data')) {
            $in = $this->session->userdata('data');
            $this->session->set_userdata('data', $in);
            if ($in->privilege == 1) {
                redirect('main/admin');
            }
            if ($in->privilege == 2) {
                redirect('main/agent');
            }
            if ($in->privilege == 3) {
                redirect('main/customer');
            }
        }
        else
        {
            $this->session->set_flashdata('error',"you must sign in first");
            redirect('login');
        }
	}
    public function logout()
    {
        delete_cookie('remember_me_token','dashboard','/');
        redirect('login');
    }
}
