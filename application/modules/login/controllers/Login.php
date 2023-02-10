<?php

Class Login extends MY_Controller{

    Public function __construct()
    {
        parent::__construct();

        $this->load->library(array(['form_validation','session']));
        $this->load->model('Login_model');
        $this->load->helper('cookie');
    }

    Public function index()
    {
        $remember= get_cookie('remember_me_token');
        $user= get_cookie('user_id');
        if(!empty($remember)&&!empty($user))
        {
            $data=$this->Login_model->getbyid('users',$user);

            if($data->remember_me_token==$remember) {
                $this->session->set_userdata('data', $data);
                $da = [
                    'last_login' => date("Y-m-d H:i:s")
                ];
                $this->Login_model->update('users', $user, $da);
                redirect('main');
            }
        }
        $this->load->view('login');
        $this->session->sess_destroy();
    }
    Public function login_submit_fun(){
        date_default_timezone_set('Europe/Istanbul');
        $random=random_string('alpha',40);
        $this->form_validation->set_rules("inputEmail","Email","required|min_length[6]|valid_email");
        $this->form_validation->set_rules("inputPassword","Password","trim|required|min_length[8]");

        if($this->form_validation->run() === false)
        {
            $this->load->view('login');
        }
        else
        {
            $form_data=$this->input->post();
            if($form_data['inputRememberPassword']=='on') {
                $remember = array(
                    'name' => 'remember_me_token',
                    'value' => $random,
                    'expire' => '12051525',  // Two weeks
                    'domain' => 'dashboard',
                    'path' => '/'
                );

                set_cookie($remember);
            }
            $data = $this->Login_model->get_all('users');
            foreach ($data as $row)
            {
                $this->session->set_userdata('data', $row);
                if($this->auth($form_data, $row))
                {
                    if($form_data['inputRememberPassword']=='on') {
                        $da = [
                            'last_login' => date("Y-m-d H:i:s"),
                            'remember_me_token'=>$random
                        ];
                    }else {
                        $da = [
                            'last_login' => date("Y-m-d H:i:s")
                        ];
                    }
                    $this->Login_model->update('users', $row->id, $da);
                    redirect('main');

                }
            }
                $this->session->set_flashdata('error',"Please check your Email and Password");
                redirect('login');

        }
    }

    public  function auth($form_data,$user_data)
    {
        if($form_data['inputEmail'] == $user_data->email && md5($form_data['inputPassword']) == $user_data->password)
        {
                $user = array(
                    'name' => 'user_id',
                    'value' => $user_data->id,
                    'expire' => '12051525',  // Two weeks
                    'domain' => 'dashboard',
                    'path' => '/'
                );
                set_cookie($user);
                return true;
        }
        else{
            return false;
        }

    }
}

?>
