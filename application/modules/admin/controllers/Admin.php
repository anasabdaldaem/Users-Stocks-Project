<?php

class Admin extends MY_Controller{

    public function __construct()
    {
        parent::__construct();
        $this->load->module(array(['template']));
        $this->load->model('admin_model');
    }

    public function userbalance()
    {

        $this->checksession();
        $users= $this->admin_model->get_all('users');
        $stocks= $this->admin_model->get_all('stocks');
        $data['users']=$users;
        $data['stocks']=$stocks;
        $this->load->view('template/Header');
        $this->load->view('template/Sidebar');
        $this->load->view('header');
        $this->load->view('userbalances',$data);
        $this->load->view('footer');
        $this->load->view('template/Footer');
    }

    public function get_userbalance($user_id,$stock_id)
    {
        $this->checksession();
        $draw=intval($this->input->get("draw"));
        $start=intval($this->input->get("start"));
        $length=intval($this->input->get("length"));
        $users= $this->admin_model->get_all('users');
        $stocks= $this->admin_model->get_all('stocks');
        $query=$this->admin_model->get_all('users_stocks');
        $prices=$this->admin_model->get_all('stocks_prices');
        $data= [];
        foreach($query as $r) {
            $row = array();
            foreach ($users as $user)
                if(($user->id==$r->user_id)&&($r->user_id==$user_id)) {
                    $row[] = $user->name;
                    foreach ($stocks as $stock)
                        if (($stock->id == $r->stock_id) && ($r->stock_id == $stock_id)) {
                            $row[] = $stock->name;
                        }
                    $row[] = $r->stockcount;
                    $row[] = $r->stock_price;
                    $row[] = $r->extRate;
                    $row[] = $r->stockcount*$r->stock_price;
                    $row[] = $r->stockcount*$r->stock_price*$r->extRate;
                    foreach ($prices as $price)
                        if (($price->stock_id == $r->stock_id) && ($r->stock_id == $stock_id)) {
                            $row[] = $price->price;
                            $row[] = $price->extRate;
                            $row[] = $r->stockcount * $price->price;
                            $row[] = $r->stockcount * $price->price * $price->extRate;
                        }
                }





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
    public function index()
    {

        if(!$this->checksession()) {
            $data['data'] = $this->session->userdata('data');
        }
        else
        {
            $this->session->set_flashdata('error',"you must sign in first");
            redirect('login');
        }
        $this->load->view('template/Header');
        $this->load->view('template/Sidebar');
        $this->load->view('header');
        $this->load->view('mainadmin_view',$data);
        $this->load->view('footer');
        $this->load->view('template/Footer');
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
