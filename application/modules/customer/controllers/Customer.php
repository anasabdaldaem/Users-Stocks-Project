<?php

class Customer extends MY_Controller{

    public function __construct()
    {
        parent::__construct();
        $this->load->module(array(['template']));
        $this->load->model('customer_model');
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
        $this->load->view('maincustomer_view',$data);
        $this->load->view('template/Footer');

    }
    public function balances()
    {
        $this->checksession();
        $this->load->view('template/Header');
        $this->load->view('template/Sidebar');
        $this->load->view('header');
        $this->load->view('balance');
        $this->load->view('footer');
        $this->load->view('template/Footer');
    }
    public function get_balances()
    {
        $session['data'] = $this->session->userdata('data');
        $user=$this->customer_model->get($session['data']->id,'users');
        $balances=$this->customer_model->get_all('users_stocks');
        $query=[];
        foreach ($balances as $balance)
        {
            if($balance->user_id==$user->id)
                $query[]=$balance;
        }
        $draw=intval($this->input->get("draw"));
        $start=intval($this->input->get("start"));
        $length=intval($this->input->get("length"));
        $users= $this->customer_model->get_all('users');
        $stocks= $this->customer_model->get_all('stocks');
        $data= [];
        foreach($query as $r) {
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
            $data[] = $row;

        }
        $result=array(
            "draw"=>$draw,
            "recordsTotal"=>count($query),
            "recordsFiltered"=>count($query),
            "data"=>$data
        );
        echo json_encode($result);
        exit();


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
}
