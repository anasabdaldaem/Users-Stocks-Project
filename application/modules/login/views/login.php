<?php $this->load->view('header'); ?>
<body class="bg-primary">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-5">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4">Login</h3></div>
                                    <div class="card-body">
                                        <form action="<?php echo site_url('login/login_submit')  ?>" method="post" name="frm_login" id="frm_login">
                                            <div class="form-group">
                                                <label for="inputEmail">Email address</label>
                                                <input class="form-control" name="inputEmail" value="<?php echo set_value('inputEmail'); ?>" id="inputEmail" type="email" required placeholder="name@example.com" />
                                                <p><?php echo form_error("inputEmail"); ?></p>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputPassword">Password</label>
                                                <input class="form-control" name="inputPassword" value="<?php echo set_value('inputPassword'); ?>" id="inputPassword" required type="password"  placeholder="Password" />
                                                <p><?php echo form_error("inputPassword"); ?></p>
                                            </div>
                                            <div class="form-check mb-3">
                                                <input class="form-check-input" id="inputRememberPassword" name="inputRememberPassword" type="checkbox" />
                                                <label class="form-check-label" for="inputRememberPassword">Remember Password</label>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                                <button type="submit" class="btn btn-primary" id="submitbtn">Submit</button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="card-footer text-center py-3">
                                        <div class="small"><a href="<?php echo base_url('register');?>">Need an account? Sign up!</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>


            <?php $this->load->view('footer'); ?>
