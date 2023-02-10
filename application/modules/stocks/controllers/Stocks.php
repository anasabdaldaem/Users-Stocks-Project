<?php

class Stocks extends MY_Controller{

    public function __construct()
    {
        parent::__construct();
        $this->load->library(array(['form_validation','session']));
        $this->load->module(array(['Template']));
        $this->load->model('Stocks_model');

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
    public function get_stocks()
    {
        $draw=intval($this->input->get("draw"));
        $start=intval($this->input->get("start"));
        $length=intval($this->input->get("length"));
        $query=$this->Stocks_model->get_all('stocks');
        $data= [];
        foreach($query->result() as $r) {
            $row = array();
            $row[] = $r->id;
            $row[] = $r->name;
            $row[] = $r->describ;
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
        $this->form_validation->set_rules("inputName","Name","required|min_length[3]");
        $this->form_validation->set_rules("inputDescription","Description","required|min_length[10]");

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
                'name' => $data['inputName'] ,
                'describ' => $data['inputDescription']
            ];
            if($this->Stocks_model->update($id,'stocks', $da)) {
                $this->session->set_flashdata('success', "stock info updated successfully");
                redirect('main/admin/stocks');

            }
            else{
                $this->session->set_flashdata('error',"Please check the data you entered");
                redirect(base_url('main/admin/stocks/edit/').$id);
            }
        }
    }
    public function edit($id)
    {
        if(!$this->checksession()){
            if($this->Stocks_model->get($id,'stocks')){
                $data['data']= $this->Stocks_model->get($id,'stocks');
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
        if($this->Stocks_model->delete($id,'stocks')) {
            $this->session->set_flashdata('success', "stock has been deleted successfully");
            redirect('main/admin/stocks','refresh');

        }
        else{
            $this->session->set_flashdata('error',"ensure that the data you try to delete isn't deleted");
            redirect(base_url('main/admin/stocks'),'refresh');
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
        $this->form_validation->set_rules("inputName","Name","required|min_length[3]");
        $this->form_validation->set_rules("inputDescription","Description","required|min_length[10]");

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
                'name' => $data['inputName'] ,
                'describ' => $data['inputDescription']
            ];
            if($this->Stocks_model->store('stocks', $da)) {
                $this->session->set_flashdata('success', "stock has been created successfully");
                redirect('main/admin/stocks');

            }
            else{
                $this->session->set_flashdata('error',"Please check the data you entered");
                redirect(base_url('main/admin/stocks/new'),'refresh');
            }
        }

    }
}


