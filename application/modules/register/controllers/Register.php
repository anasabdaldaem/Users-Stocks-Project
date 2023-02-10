<?php

class Register extends MY_Controller{

    public function __construct()
    {
        parent::__construct();
        $this->load->library(array(['form_validation','session']));
        $this->load->model('Reg_model');


    }

    Public function index()
    {
        $this->load->view('register');
        $this->session->sess_destroy();
    }
    Public function reg_submit_fun()
    {
        date_default_timezone_set('Europe/Istanbul');

            $this->form_validation->set_rules("inputFirstName","fname","required|min_length[3]");
            $this->form_validation->set_rules("inputLastName","lname","required|min_length[3]");
            $this->form_validation->set_rules("inputEmail","Email","required|min_length[6]|valid_email");
            $this->form_validation->set_rules("inputPassword","pass","trim|required|min_length[8]");
            $this->form_validation->set_rules("inputPasswordConfirm","passconfirm","trim|required|min_length[8]|matches[inputPassword]");
        if($this->form_validation->run() === false)
        {
            $this->load->view('register');
        }
        else
        {
            $form_data=$this->input->post();
            //print_r($form_data);
            $data =[
                'name' => $form_data['inputFirstName'].' '.$form_data['inputLastName'],
                'email'=>$form_data['inputEmail'],
                'password'=>md5($form_data['inputPassword']),
                'last_login'=>date("yyyy-mm-dd")
            ];
                if($this->Reg_model->store('users',$data))
                {
                    redirect('Login/index');
                }
                else
                {
                    $this->session->set_flashdata('error',"Please check the data you entered");
                    redirect('register');
                }
            }
    }
}


