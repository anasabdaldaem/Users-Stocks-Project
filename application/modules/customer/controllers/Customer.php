<?php

class Customer extends MY_Controller{

    var $sessiondata;
    public function __construct()
    {
        parent::__construct();
        $this->load->module(array(['template']));
        $this->load->model('customer_model');
        $sessiondata['data']= $this->session->userdata('data');
    }
    public function customerbalance()
    {

        $this->checksession();
        $this->load->view('template/Header');
        $this->load->view('template/Sidebar');
        $this->load->view('header');
        $this->load->view('customerbalances');
        $this->load->view('footer');
        $this->load->view('template/Footer');
    }

    public function get_customerbalance()
    {
        $this->checksession();
        $session['data'] = $this->session->userdata('data');
        $draw=intval($this->input->get("draw"));
        $start=intval($this->input->get("start"));
        $length=intval($this->input->get("length"));
        $user=$this->customer_model->get($session['data']->id,'users');
        $stocks= $this->customer_model->get_all('stocks');
        $query=$this->customer_model->get_all('users_stocks');
        $prices=$this->customer_model->get_all('stocks_prices');
        $data= [];
        foreach($query as $r) {
            $row = array();
                if(($user->id==$r->user_id)) {
                    $row[] = $user->name;
                    foreach ($stocks as $stock)
                        if (($stock->id == $r->stock_id)) {
                            $row[] = $stock->name;
                        }
                    $row[] = $r->stockcount;
                    $row[] = $r->stock_price;
                    $row[] = $r->extRate;
                    $row[] = $r->stockcount*$r->stock_price;
                    $row[] = $r->stockcount*$r->stock_price*$r->extRate;
                    foreach ($prices as $price)
                        if (($price->stock_id == $r->stock_id)) {
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
        $this->load->view('header');

        $this->load->view('maincustomer_view',$data);
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
    public function newsell()
    {
        $this->checksession();
        $data['stocks']= $this->admin_model->get_all('stocks');
        $this->load->view('template/Header');
        $this->load->view('template/Sidebar');
        $this->load->view('header');
        $this->load->view('sell_form',$data);
        $this->load->view('footer');
        $this->load->view('template/Footer');

    }
    public function createsell()
    {
        $sessiondata['data']= $this->session->userdata('data');
        $this->checksession();
        $this->form_validation->set_rules("stockname","Stock Name","required");
        $this->form_validation->set_rules("stockcount","Stock Count","required");
        $this->form_validation->set_rules("stockprice","Stock Price","required");
        $this->form_validation->set_rules("extRate","Exchange Rate","required");

        if($this->form_validation->run() === false)
        {
            $erorr=str_replace('<p>','',$this->form_validation->error_string());
            $erorr=str_replace('</p>','',$erorr);
            $erorr = trim(preg_replace('/\s\s+/', ' ', $erorr));
            $this->session->set_flashdata('error',$erorr);
            $this->newsell();
        }
        else {
            $data = $this->input->post();
            $balances=$this->admin_model->get_all('users_stocks');
            $totalstocks=0;
            $stockcount=$data['stockcount'];
            foreach ($balances as $balance)
            {
                if(($balance->user_id==$sessiondata['data']->id)&&($balance->stock_id==$data['stockname']))
                {
                    $totalstocks+=$balance->stockcount;
                }

            }
            if($totalstocks==0) {
                $this->session->set_flashdata('error', 'the user do not have any balance of this stock');
                $this->newsell();
            }
            foreach ($balances as $balance) {
                if($stockcount != 0) {
                    if (($totalstocks >= $stockcount)) {
                        if (($balance->user_id == $sessiondata['data']->id) && ($balance->stock_id == $data['stockname'])) {
                            if ($balance->stockcount <= $stockcount) {
                                $updated_balance = [
                                    'user_id' => $balance->user_id,
                                    'stock_id' => $balance->stock_id,
                                    'stockcount' => 0,
                                    'stock_price' => $balance->stock_price,
                                    'extRate' => $balance->extRate
                                ];
                                $totalstocks -= $balance->stockcount;
                                $stockcount -= $balance->stockcount;
                                $this->admin_model->update($balance->id, 'users_stocks', $updated_balance);

                            } else {
                                $updated_balance = [
                                    'user_id' => $balance->user_id,
                                    'stock_id' => $balance->stock_id,
                                    'stockcount' => $balance->stockcount - $stockcount,
                                    'stock_price' => $balance->stock_price,
                                    'extRate' => $balance->extRate
                                ];
                                $totalstocks -= $stockcount;
                                $stockcount -= $stockcount;
                                $this->admin_model->update($balance->id, 'users_stocks', $updated_balance);
                            }
                        }
                    } else {
                        $this->session->set_flashdata('error', 'the stock count you entered more than the balance of the user');
                        $this->newsell();
                    }
                }
                else
                {
                    $da = [
                        'operation' => 0,
                        'user_id' => $sessiondata['data']->id,
                        'stock_id' => $data['stockname'],
                        'stockcount' => $data['stockcount'],
                        'stock_price' => $data['stockprice'],
                        'extRate' => $data['extRate']
                    ];
                    if ($this->admin_model->store('stocks_sell', $da)) {
                        $this->session->set_flashdata('success', "stocks has been added to user successfully");
                        redirect('main/customer/customerbalance');

                    } else {
                        $this->session->set_flashdata('error', "Please check the data you entered");
                        redirect(base_url('main/customer/newsell'), 'refresh');
                    }
                }
            }

        }

    }
}
