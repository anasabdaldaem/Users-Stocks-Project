<?php

class Admin extends MY_Controller{

    public function __construct()
    {
        parent::__construct();
        $this->load->module(array(['template']));
        $this->load->model('admin_model');
    }
    public function newsell()
    {
        $this->checksession();
        $data['users']= $this->admin_model->get_all('users');
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
        $this->checksession();
        $this->form_validation->set_rules("username","User Name","required");
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
                if(($balance->user_id==$data['username'])&&($balance->stock_id==$data['stockname']))
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
                        if (($balance->user_id == $data['username']) && ($balance->stock_id == $data['stockname'])) {
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
                        'user_id' => $data['username'],
                        'stock_id' => $data['stockname'],
                        'stockcount' => $data['stockcount'],
                        'stock_price' => $data['stockprice'],
                        'extRate' => $data['extRate']
                    ];
                    if ($this->admin_model->store('stocks_sell', $da)) {
                        $this->session->set_flashdata('success', "stocks has been added to user successfully");
                        redirect('main/admin/userbalance');

                    } else {
                        $this->session->set_flashdata('error', "Please check the data you entered");
                        redirect(base_url('main/admin/newsell'), 'refresh');
                    }
                }
            }

        }

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

            foreach ($users as $user)
                if(($user->id==$r->user_id)&&($r->user_id==$user_id)) {
                    $row = array();
                    foreach ($stocks as $stock)
                        if (($stock->id == $r->stock_id) && ($r->stock_id == $stock_id)) {
                            $row[] = $user->name;
                            $row[] = $stock->name;
                            $row[] = $r->stockcount;
                            $row[] = $r->stock_price;
                            $row[] = $r->extRate;
                            $row[] = $r->stockcount * $r->stock_price;
                            $row[] = $r->stockcount * $r->stock_price * $r->extRate;
                            foreach ($prices as $price)
                                if (($price->stock_id == $r->stock_id) && ($r->stock_id == $stock_id)) {
                                    $row[] = $price->price;
                                    $row[] = $price->extRate;
                                    $row[] = $r->stockcount * $price->price;
                                    $row[] = $r->stockcount * $price->price * $price->extRate;
                                }
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
    public function get_userprofit($user_id,$stock_id)
    {
        $this->checksession();
        $draw=intval($this->input->get("draw"));
        $start=intval($this->input->get("start"));
        $length=intval($this->input->get("length"));
        $users= $this->admin_model->get_all('users');
        $stocks= $this->admin_model->get_all('stocks');
        $sells=$this->admin_model->get_all('stocks_sell');
        $prices=$this->admin_model->get_all('stocks_prices');
        $databalances= [];
        foreach ($sells as $sell) {
            $row2 = array();
            if (($sell->user_id == $user_id) && ($sell->operation == 1)) {
                foreach ($users as $user)
                    if (($user->id == $sell->user_id)) {

                        foreach ($stocks as $stock)
                            if (($stock->id == $sell->stock_id) && ($stock_id==$sell->stock_id)) {
                                $row2['user_id'] = $user->id;
                                $row2['stock_id'] = $stock->id;
                                $row2['stockcount'] = $sell->stockcount;
                                $row2['stockprice'] = $sell->stock_price;
                                $row2['buyextrate'] = $sell->extRate;
                                $row2['buytotalprice'] = $sell->stockcount * $sell->stock_price;
                                $row2['buytotalusd'] = $sell->stockcount * $sell->stock_price / $sell->extRate;
                            }
                    }
            }
            $databalances[] = $row2;
        }
        $datasells= [];
        foreach ($sells as $sell) {
            $row1 = array();
            if (($sell->user_id == $user_id) && ($sell->operation == 0)) {
                foreach ($users as $user)
                    if (($user->id == $sell->user_id)) {

                        foreach ($stocks as $stock)
                            if (($stock->id == $sell->stock_id)&& ($stock_id==$sell->stock_id)) {
                                $row1['user_id'] = $user->id;
                                $row1['stock_id'] = $stock->id;
                                $row1['stockcount'] = $sell->stockcount;
                                $row1['stockprice'] = $sell->stock_price;
                                $row1['buyextrate'] = $sell->extRate;
                                $row1['buytotalprice'] = $sell->stockcount * $sell->stock_price;
                                $row1['buytotalusd'] = $sell->stockcount * $sell->stock_price / $sell->extRate;
                            }
                    }
            }
            $datasells[] = $row1;
        }
        $data=[];
        $data['count']=0;
        $data['stockcount']=0;
        $data['stockprice']=0;
        $data['buyextrate']=0;
        $data['buytotalprice']=0;
        $data['buytotalusd']=0;
        foreach ($databalances as $databalance)
        {
            if(!empty($databalance)) {
                $data['stock_id'] = $stock_id;
                $data['stockcount'] += $databalance['stockcount'];
                $data['stockprice'] += $databalance['stockprice'];
                $data['buyextrate'] += $databalance['buyextrate'];
                $data['buytotalprice'] += $databalance['buytotalprice'];
                $data['buytotalusd'] += $databalance['buytotalusd'];
                $data['count'] += 1;
            }
        }
        $data1=[];
        $data1['count']=0;
        $data1['stockcount']=0;
        $data1['stockprice']=0;
        $data1['buyextrate']=0;
        $data1['buytotalprice']=0;
        $data1['buytotalusd']=0;
        foreach ($datasells as $datasell)
        {
            if(!empty($datasell)) {
                $data1['stock_id'] = $stock_id;
                $data1['stockcount'] += $datasell['stockcount'];
                $data1['stockprice'] += $datasell['stockprice'];
                $data1['buyextrate'] += $datasell['buyextrate'];
                $data1['buytotalprice'] += $datasell['buytotalprice'];
                $data1['buytotalusd'] += $datasell['buytotalusd'];
                $data1['count'] += 1;
            }
        }
        $avgbuyprice=$data['stockprice']/$data['count'];
        $avgbuyExtrate=$data['buyextrate']/$data['count'];
        $avgsellprice=$data1['stockprice']/$data1['count'];
        $avgsellExtrate=$data1['buyextrate']/$data1['count'];
        $totalbuy=$avgbuyprice*$data['stockcount'];
        $totalusdbuy=$avgbuyprice*$data['stockcount']/$avgbuyExtrate;
        $totalsell=$avgsellprice*$data1['stockcount'];
        $totalusdsell=$avgsellprice*$data1['stockcount']/$avgsellExtrate;
        $datatabel[0]=[
            $data['stockcount'],
            round($avgbuyprice, 4),
            round($data['buyextrate']/$data['count'], 4),
            $totalbuy,
            round($totalusdbuy, 4),
            $data1['stockcount'],
            round($avgsellprice, 4),
            round($data1['buyextrate']/$data1['count'], 4),
            $totalsell,
            round($totalusdsell, 4),
            $data['stockcount']- $data1['stockcount'],
            round(($data['stockcount']- $data1['stockcount'])*$avgbuyprice, 4)
        ];
        $result=array(
            "draw"=>$draw,
            "recordsTotal"=>1,
            "recordsFiltered"=>1,
            "data"=>$datatabel
        );
        echo json_encode($result);
        exit();
    }
    public function profits()
    {
        $this->checksession();
        $users= $this->admin_model->get_all('users');
        $stocks= $this->admin_model->get_all('stocks');
        $data['users']=$users;
        $data['stocks']=$stocks;
        $this->load->view('template/Header');
        $this->load->view('template/Sidebar');
        $this->load->view('header');
        $this->load->view('profits',$data);
        $this->load->view('footer');
        $this->load->view('template/Footer');
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
