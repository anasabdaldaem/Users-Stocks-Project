<?php
class Template extends MY_Controller {


    public function __construct()
    {
        // Load the constructer from MY_Controller
        parent::__construct();
        $this->load->library(array(['form_validation','session']));
    }


}
