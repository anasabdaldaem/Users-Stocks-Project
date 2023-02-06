<?php

class Users extends MY_Controller{

    public function __construct()
    {
        parent::__construct();
        $this->load->library(array(['form_validation','session']));
        $this->load->module(array(['Template']));
        $this->load->model('Users_model');


    }

    public function user_settings()
    {
        if(!$this->checksession()) {
            $in = $this->session->userdata('data');
            $this->session->set_userdata('data',$in);
            $this->load->view('template/Header');
            $this->load->view('template/Sidebar');
            $this->load->view('users/user_settings');
            $this->load->view('template/Footer');
        }

    }
    public function index(){
        if(!$this->checksession()) {
            $this->load->view('template/Header');
            $this->load->view('template/Sidebar');
            $this->load->view('header');
            $this->load->view('index');
            $this->load->view('footer');
            $this->load->view('template/Footer');
        }
    }
    public function get_users()
    {
        $draw=intval($this->input->get("draw"));
        $start=intval($this->input->get("start"));
        $length=intval($this->input->get("length"));
        $query=$this->Users_model->get_all('users');
        $data= [];
        foreach($query->result() as $r) {
            switch ($r->privilege) {
                case '1':
                    $priv = 'admin';
                    break;
                case '2':
                    $priv = 'agent';
                    break;
                case '3':
                    $priv = 'customer';
                    break;
            }
            $row = array();
            $row[] = $r->id;
            $row[] = $r->name;
            $row[] = $r->email;
            $row[] = $priv;
            $row[] = $r->last_login;
            $data[] = $row;

        }
        $result=array(
            "draw"=>$draw,
            "recordsTotal"=>$query->num_rows(),
            "recordsFiltered"=>$query->num_rows(),
            "data"=>$data
        );
        echo json_encode($result);
        exit();
    }
    public function store($id)
    {
        $this->checksession();
        $this->form_validation->set_rules("inputFirstName","fname","required|min_length[3]");
        $this->form_validation->set_rules("inputLastName","lname","required|min_length[3]");
        $this->form_validation->set_rules("inputEmail","Email","required|min_length[6]|valid_email");
        $this->form_validation->set_rules("inputPassword","pass","trim|required|min_length[8]");
        $this->form_validation->set_rules("inputPasswordConfirm","passconfirm","trim|required|min_length[8]|matches[inputPassword]");
        $this->form_validation->set_rules("privilege","privilege","required");

        if($this->form_validation->run() === false)
        {
            $erorr=str_replace('<p>','',$this->form_validation->error_string());
            $erorr=str_replace('</p>','',$erorr);
            $erorr = trim(preg_replace('/\s\s+/', ' ', $erorr));
            $this->session->set_flashdata('error',$erorr);
            $this->edit($id);
        }
        else {
            $data = $this->input->post();
            $users=$this->Users_model->get_all('users')->result();
            foreach ($users as $user)
            {
                if($user->email==$data['inputEmail'])
                {
                    $this->session->set_flashdata('error',"this email is used for another account");
                    redirect(base_url('main/admin/users/new'),'refresh');
                }
            }
            $da = [
                'name' => $data['inputFirstName'] . ' ' . $data['inputLastName'],
                'email' => $data['inputEmail'],
                'password' => md5($data['inputPassword']),
                'privilege'=>$data['privilege'],
                'last_login' => date("yyyy-mm-dd")
            ];
            if($this->Users_model->update($id,'users', $da)) {
                $this->session->set_flashdata('success', "User info updated successfully");
                redirect('main/admin/users');

            }
            else{
                $this->session->set_flashdata('error',"Please check the data you entered");
                redirect(base_url('main/admin/users/edit/').$id);
            }
        }
    }
    public function edit($id)
    {
        if(!$this->checksession()){
            if($this->Users_model->get($id,'users')){
                $data['data']= $this->Users_model->get($id,'users');
                $this->load->view('template/Header');
                $this->load->view('template/Sidebar');
                $this->load->view('header');
                $this->load->view('edit_view',$data);
                $this->load->view('footer');
                $this->load->view('template/Footer');

            }
        }
    }
    public function update()
    {
        $this->checksession();
        $this->form_validation->set_rules("inputFirstName","fname","required|min_length[3]");
        $this->form_validation->set_rules("inputLastName","lname","required|min_length[3]");
        $this->form_validation->set_rules("inputEmail","Email","required|min_length[6]|valid_email");
        $this->form_validation->set_rules("inputPassword","pass","trim|required|min_length[8]");
        $this->form_validation->set_rules("inputPasswordConfirm","passconfirm","trim|required|min_length[8]|matches[inputPassword]");
        if($this->form_validation->run() === false)
        {
            $erorr=str_replace('<p>','',$this->form_validation->error_string());
            $erorr=str_replace('</p>','',$erorr);
            $erorr = trim(preg_replace('/\s\s+/', ' ', $erorr));
            $this->session->set_flashdata('error',$erorr);
            redirect(base_url('settings'),'refresh');
        }
        else {
            $in = $this->session->userdata('data');
            $data = $this->input->post();
            $da = [
                'name' => $data['inputFirstName'] . ' ' . $data['inputLastName'],
                'email' => $data['inputEmail'],
                'password' => md5($data['inputPassword']),
                'last_login' => date("yyyy-mm-dd")
            ];
            if($this->Users_model->update($in->id,'users', $da)) {

                $in->name = $da ['name'];
                $in->email = $da ['email'];
                $in->password = $da ['password'];
                $in->last_login = $da ['last_login'];
                $this->session->set_userdata('data', $in);
                $this->session->set_flashdata('success', "Your info updated successfully");
                redirect(base_url('settings'), 'refresh');

            }
            else{
                $this->session->set_flashdata('error',"Please check the data you entered");
                redirect(base_url('settings'), 'refresh');
            }
        }
    }
    public function checksession(): bool
    {
        if(!($this->session->userdata('data'))) {
            $this->session->set_flashdata('error',"you must sign in first");
            redirect('login');
            return true;
        }
        else
        {
            return false;
        }
    }
    public function delete($id)
    {
        $this->checksession();
        if($this->Users_model->delete($id,'users')) {
            $this->session->set_flashdata('success', "User has been deleted successfully");
            redirect('main/admin/users','refresh');

        }
        else{
            $this->session->set_flashdata('error',"Please check the data you entered");
            redirect(base_url('main/admin/users'),'refresh');
        }

    }
    public function new()
    {
        $this->checksession();
        $this->load->view('template/Header');
        $this->load->view('template/Sidebar');
        $this->load->view('header');
        $this->load->view('create_view');
        $this->load->view('footer');
        $this->load->view('template/Footer');

    }
    public function create()
    {
        $this->checksession();
        $this->form_validation->set_rules("inputFirstName","fname","required|min_length[3]");
        $this->form_validation->set_rules("inputLastName","lname","required|min_length[3]");
        $this->form_validation->set_rules("inputEmail","Email","required|min_length[6]|valid_email");
        $this->form_validation->set_rules("inputPassword","pass","trim|required|min_length[8]");
        $this->form_validation->set_rules("inputPasswordConfirm","passconfirm","trim|required|min_length[8]|matches[inputPassword]");
        $this->form_validation->set_rules("privilege","privilege","required");
        if($this->form_validation->run() === false)
        {
            $erorr=str_replace('<p>','',$this->form_validation->error_string());
            $erorr=str_replace('</p>','',$erorr);
            $erorr = trim(preg_replace('/\s\s+/', ' ', $erorr));
            $this->session->set_flashdata('error',$erorr);
            $this->new();
        }
        else {
            $data = $this->input->post();
            $users=$this->Users_model->get_all('users')->result();
            foreach ($users as $user)
                {
                    if($user->email==$data['inputEmail'])
                    {
                        $this->session->set_flashdata('error',"this email is used for another account");
                        redirect(base_url('main/admin/users/new'),'refresh');
                    }
                }
            $da = [
                'name' => $data['inputFirstName'] . ' ' . $data['inputLastName'],
                'email' => $data['inputEmail'],
                'password' => md5(trim($data['inputPassword'])),
                'privilege'=>$data['privilege'],
                'last_login' => date("yyyy-mm-dd")
            ];
            if($this->Users_model->store('users', $da)) {
                $this->session->set_flashdata('success', "User has been created successfully");
                redirect('main/admin/users');

            }
            else{
                $this->session->set_flashdata('error',"Please check the data you entered");
                redirect(base_url('main/admin/users/new'),'refresh');
            }
        }

    }
}


