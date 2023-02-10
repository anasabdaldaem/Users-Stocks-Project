<?php

class stkprices extends MY_Controller{

    public function __construct()
    {
        parent::__construct();
        $this->load->library(array(['form_validation','session']));
        $this->load->module(array(['Template']));
        $this->load->model('stkprices_model');


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
    public function get_stkprices()
    {
        $draw=intval($this->input->get("draw"));
        $start=intval($this->input->get("start"));
        $length=intval($this->input->get("length"));
        $currencies= $this->stkprices_model->get_all('currencies')->result();
        $stocks= $this->stkprices_model->get_all('stocks')->result();
        $query=$this->stkprices_model->get_all('stocks_prices');
        $data= [];
        foreach($query->result() as $r) {
            $row = array();
            $row[] = $r->id;
            foreach ($stocks as $stock)
                if($stock->id==$r->stock_id)
                    $row[] = $stock->name;
            $row[] = $r->price;
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
        $this->form_validation->set_rules("currency","Currency","required");
        $this->form_validation->set_rules("stockname","Stock Name","required");
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
                'stock_id' => $data['stockname'],
                'price' => $data['stockprice'],
                'extRate' => $data['extRate']
            ];
            if($this->stkprices_model->update($id,'stocks_prices', $da)) {
                $this->session->set_flashdata('success', "stock Price info updated successfully");
                redirect('main/admin/stkprices');

            }
            else{
                $this->session->set_flashdata('error',"Please check the data you entered");
                redirect(base_url('main/admin/stkprices/edit/').$id);
            }
        }
    }
    public function edit($id)
    {
        if(!$this->checksession()){
            if($this->stkprices_model->get($id,'stocks_prices')){
                $data['data']= $this->stkprices_model->get($id,'stocks_prices');
                $data['currencies']= $this->stkprices_model->get_all('currencies')->result();
                $data['stocks']= $this->stkprices_model->get_all('stocks')->result();
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
        if($this->stkprices_model->delete($id,'stocks_prices')) {
            $this->session->set_flashdata('success', "stock has been deleted successfully");
            redirect('main/admin/stkprices','refresh');

        }
        else{
            $this->session->set_flashdata('error',"ensure that the data you try to delete isn't deleted");
            redirect(base_url('main/admin/stkprices'),'refresh');
        }

    }
    public function new()
    {
        $this->checksession();
        $data['currencies']= $this->stkprices_model->get_all('currencies')->result();
        $data['stocks']= $this->stkprices_model->get_all('stocks')->result();
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
        $this->form_validation->set_rules("currency","Currency","required");
        $this->form_validation->set_rules("stockname","Stock Name","required");
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
                'stock_id' => $data['stockname'],
                'price' => $data['stockprice'],
                'extRate' => $data['extRate']
            ];
            if($this->stkprices_model->store('stocks_prices', $da)) {
                $this->session->set_flashdata('success', "stocks has been added to user successfully");
                redirect('main/admin/stkprices');

            }
            else{
                $this->session->set_flashdata('error',"Please check the data you entered");
                redirect(base_url('main/admin/stkprices/new'),'refresh');
            }
        }

    }
}


