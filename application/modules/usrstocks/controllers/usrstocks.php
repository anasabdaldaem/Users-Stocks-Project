<?php

class usrstocks extends MY_Controller{

    public function __construct()
    {
        parent::__construct();
        $this->load->library(array(['form_validation','session']));
        $this->load->module(array(['Template']));
        $this->load->model('usrstocks_model');


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
    public function get_usrstocks()
    {
        $draw=intval($this->input->get("draw"));
        $start=intval($this->input->get("start"));
        $length=intval($this->input->get("length"));
        $users= $this->usrstocks_model->get_all('users')->result();
        $stocks= $this->usrstocks_model->get_all('stocks')->result();
        $query=$this->usrstocks_model->get_all('users_stocks');
        $data= [];
        foreach($query->result() as $r) {
            $row = array();
            $row[] = $r->id;
            foreach ($users as $user)
                if($user->id==$r->user_id)
                    $row[] = $user->name;
            foreach ($stocks as $stock)
                if($stock->id==$r->stock_id)
                    $row[] = $stock->name;
            $row[] = $r->stockcount;
            $row[] = $r->stock_price;
            $row[] = $r->extRate;
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
        $this->form_validation->set_rules("username","User Name","required");
        $this->form_validation->set_rules("stockname","Stock Name","required");
        $this->form_validation->set_rules("stockcount","Stock Count","required");
        $this->form_validation->set_rules("stockprice","Stock Price","required");

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
            $da = [
                'user_id' => $data['username'] ,
                'stock_id' => $data['stockname'],
                'stockcount' => $data['stockcount'],
                'stock_price' => $data['stockprice'],
                'extRate' => $data['extRate']
            ];
            if($this->usrstocks_model->update($id,'users_stocks', $da)) {
                $this->session->set_flashdata('success', "user balance updated successfully");
                redirect('main/admin/usrstocks');

            }
            else{
                $this->session->set_flashdata('error',"Please check the data you entered");
                redirect(base_url('main/admin/usrstocks/edit/').$id);
            }
        }
    }
    public function edit($id)
    {
        if(!$this->checksession()){
            if($this->usrstocks_model->get($id,'users_stocks')){
                $data['data']= $this->usrstocks_model->get($id,'users_stocks');
                $data['users']= $this->usrstocks_model->get_all('users')->result();
                $data['stocks']= $this->usrstocks_model->get_all('stocks')->result();
                $this->load->view('template/Header');
                $this->load->view('template/Sidebar');
                $this->load->view('header');
                $this->load->view('edit_view',$data);
                $this->load->view('footer');
                $this->load->view('template/Footer');

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
        if($this->usrstocks_model->delete($id,'users_stocks')) {
            $this->session->set_flashdata('success', "balance has been deleted successfully");
            redirect('main/admin/usrstocks','refresh');

        }
        else{
            $this->session->set_flashdata('error',"ensure that the data you try to delete isn't deleted");
            redirect(base_url('main/admin/usrstocks'),'refresh');
        }

    }
    public function new()
    {
        $this->checksession();
        $data['users']= $this->usrstocks_model->get_all('users')->result();
        $data['stocks']= $this->usrstocks_model->get_all('stocks')->result();
        $this->load->view('template/Header');
        $this->load->view('template/Sidebar');
        $this->load->view('header');
        $this->load->view('create_view',$data);
        $this->load->view('footer');
        $this->load->view('template/Footer');

    }
    public function create()
    {
        $this->checksession();
        $this->form_validation->set_rules("username","User Name","required");
        $this->form_validation->set_rules("stockname","Stock Name","required");
        $this->form_validation->set_rules("stockcount","Stock Count","required");
        $this->form_validation->set_rules("stockprice","Stock Price","required");

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
            $da = [
                'user_id' => $data['username'] ,
                'stock_id' => $data['stockname'],
                'stockcount' => $data['stockcount'],
                'stock_price' => $data['stockprice'],
                'extRate' => $data['extRate']
            ];
            if($this->usrstocks_model->store('users_stocks', $da)) {
                $this->session->set_flashdata('success', "stocks has been added to user successfully");
                redirect('main/admin/usrstocks');

            }
            else{
                $this->session->set_flashdata('error',"Please check the data you entered");
                redirect(base_url('main/admin/usrstocks/new'),'refresh');
            }
        }

    }
}


