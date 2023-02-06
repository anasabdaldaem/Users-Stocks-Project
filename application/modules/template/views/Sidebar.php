<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
            <div class="sb-sidenav-menu">
                <div class="nav">
                    <div class="sb-sidenav-menu-heading">Core</div>
                    <a class="nav-link" href="<?php echo base_url('main');?>">
                        <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                        Dashboard
                    </a>
                    <?php if($this->session->userdata('data')) {
                        $data = $this->session->userdata('data');}else{redirect('login');}



                        $html="";
                        switch ($data->privilege) {
                            case 1:
                                $link1 = base_url('main/admin/users');
                                $link2 = base_url('main/admin/usrstocks');
                                $link3 = base_url('main/admin/stocks');
                                $link4 = base_url('main/admin/currencies');
                                $link5 = base_url('main/admin/stkprices');
                                $html = '<div class="sb-sidenav-menu-heading">Admin</div>
                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                        <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                        Edit
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link" href="' . $link1 . '">Users</a>
                            <a class="nav-link" href="' . $link2 . '">Users Balances</a>
                            <a class="nav-link" href="' . $link3 . '">Stocks</a>
                            <a class="nav-link" href="' . $link4 . '">Currencies</a>
                            <a class="nav-link" href="' . $link5 . '">Stocks Prices</a>

                        </nav>
                    </div>';
                                break;
                            case 2:
                                $link1 = base_url('main/agent/settings');
                                $link2 = base_url('main/agent/customers');
                                $html = '<div class="sb-sidenav-menu-heading">Interface</div>
                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                        <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                        Layouts
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link" href="' . $link1 . '">Static Navigation</a>
                            <a class="nav-link" href="' . $link2 . '">Light Sidenav</a>
                        </nav>
                    </div>';
                                break;
                            case 3:
                                $link1 = base_url('main/customer/balance');
                                $link2 = base_url('main/customer/stocks');
                                $html = '<div class="sb-sidenav-menu-heading">Interface</div>
                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                        <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                        Layouts
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link" href="' . $link1 . '">Balances</a>
                            <a class="nav-link" href="' . $link2 . '">Stocks Prices</a>
                        </nav>
                    </div>';
                                break;
                        }
                        echo $html;

                    ?>
                   <!-- <div class="sb-sidenav-menu-heading">Addons</div>
                    <a class="nav-link" href="charts.html">
                        <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                        Charts
                    </a>
                    <a class="nav-link" href="tables.html">
                        <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                        Tables
                    </a>-->
                </div>
            </div>
            <div class="sb-sidenav-footer">
                <div class="small">Logged in as:</div>
                <?php echo  $data->name;?>
            </div>
        </nav>
    </div>
    <div id="layoutSidenav_content">
