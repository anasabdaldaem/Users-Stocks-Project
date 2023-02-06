<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Register - SB Admin</title>
        <?php
        echo link_tag('assets/css/styles.css');
        ?>
    </head>
    <body class="bg-primary">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-7">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4">Create Account</h3></div>
                                    <div class="card-body">
                                        <?php
                                        if($this->session->flashdata('error'))
                                        {
                                            echo "<h4 style='color: red;'>".$this->session->flashdata('error')."</h4>";
                                        }
                                        ?>
                                        <form method="post" action="<?php echo site_url('register/reg_submit')?> " name="frm_reg" id="frm_reg">
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="inputFirstName">First name</label>
                                                        <input class="form-control" id="inputFirstName" name="inputFirstName" required type="text" placeholder="Enter your first name" />
                                                        <p><?php echo form_error("inputFirstName"); ?></p>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="inputLastName">Last name</label>
                                                        <input class="form-control" id="inputLastName" name="inputLastName" required type="text" placeholder="Enter your last name" />
                                                        <p><?php echo form_error("inputLastName"); ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputEmail">Email address</label>
                                                <input class="form-control" id="inputEmail" name="inputEmail" required type="email" placeholder="name@example.com" />
                                                <p><?php echo form_error("inputEmail"); ?></p>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="inputPassword">Password</label>
                                                        <input class="form-control" id="inputPassword" name="inputPassword" required type="password" placeholder="Create a password" />
                                                        <p><?php echo form_error("inputPassword"); ?></p>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="inputPasswordConfirm">Confirm Password</label>
                                                        <input class="form-control" id="inputPasswordConfirm" name="inputPasswordConfirm" required type="password" placeholder="Confirm password" />
                                                        <p><?php echo form_error("inputPasswordConfirm"); ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mt-4 mb-0">
                                                <div class="d-grid"><button type="submit" class="btn btn-primary btn-block" id="submit" name="submit">Create</button></div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="card-footer text-center py-3">
                                        <div class="small"><a href="<?php echo base_url('login');?>">Have an account? Go to login</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
            <div id="layoutAuthentication_footer">
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Your Website 2022</div>
                            <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <?php
        $this->load->view('scripts');
        ?>
    </body>
</html>
