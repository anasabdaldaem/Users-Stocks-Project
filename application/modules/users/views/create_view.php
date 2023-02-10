<main>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-7">
                <div class="card shadow-lg border-0 rounded-lg mt-5">
                    <div class="card-header"><h3 class="text-center font-weight-light my-4">Create User Account</h3></div>
                    <div class="card-body">
                        <form method="post" action="<?php echo site_url('main/admin/users/create')?>" name="frm_create" id="frm_create">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="inputFirstName">First name</label>
                                        <input class="form-control" id="inputFirstName" name="inputFirstName" required type="text" placeholder="Enter your first name" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="inputLastName">Last name</label>
                                        <input class="form-control" id="inputLastName" name="inputLastName" required type="text" placeholder="Enter your last name" />
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail">Email address</label>
                                <input class="form-control" id="inputEmail" name="inputEmail" required type="email" placeholder="name@example.com" />
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="inputPassword">Password</label>
                                        <input class="form-control" id="inputPassword" name="inputPassword" required type="password" placeholder="Create a password" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="inputPasswordConfirm">Confirm Password</label>
                                        <input class="form-control" id="inputPasswordConfirm" name="inputPasswordConfirm" required type="password" placeholder="Confirm password" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="privilege">Privilege</label>
                                    <select class="form-select" name="privilege" id="privilege">
                                        <option value="1" >Admin</option>
                                        <option value="2" >Agent</option>
                                        <option value="3" >Customer</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mt-4 mb-0">
                                <div class="d-grid"><button type="submit" class="btn btn-primary btn-block" id="submit" name="submit">Create</button></div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<script>

    $(document).ready(function () {
        $("#frm_create").validate({
            // in 'rules' user have to specify all the constraints for respective fields
            rules: {
                inputFirstName:{
                    required: true,
                    minlength: 3
                },
                inputLastName:{
                    required: true,
                    minlength: 3
                },
                inputPassword: {
                    required: true,
                    minlength: 8
                },
                inputPasswordConfirm:{
                    required: true,
                    minlength: 8,
                    equalTo:'#inputPassword'
                },
                inputEmail: {
                    required: true,
                    email: true
                },
                privilege:{
                    required: true
                }
            },
            // in 'messages' user have to specify message as per rules
            messages: {
                inputPassword: {
                    required: " Please enter a password",
                    minlength: " Your password must be consist of at least 8 characters"
                },
                inputPasswordConfirm: {
                    required: " Please enter a password confirm",
                    minlength: " Your password confirm must be consist of at least 8 characters",
                    equalTo: "Your password confirm must be the same of the password"
                },inputFirstName: {
                    required: " Please enter a first name",
                    minlength: " Your first name must be more than 2 characters"
                },inputLastName: {
                    required: " Please enter a last name",
                    minlength: " Your last name must be more than 2 characters"
                },
                inputEmail:{
                    required: " Please enter an Email",
                    email: "Please enter a valid Email"
                },
                privilege:{
                    required: " Please select user privilege"
                }
            }
        });
        const success = Swal.mixin({
            toast: true,
            position: 'top',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });
        const error = Swal.mixin({
            toast: true,
            position: 'top',
            showConfirmButton: false,
            timer: 5000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });
        <?php
        if($this->session->flashdata('error'))
        { ?>
        errormsg='<?php echo str_replace("\n", "", $this->session->flashdata('error')); ?>';
        error.fire({
            icon: 'error',
            title: errormsg
        });
        <?php }elseif($this->session->flashdata('success'))
        { ?>
        successmsg='<?php echo $this->session->flashdata('success');?>';
        success.fire({
            icon: 'success',
            title: successmsg
        });
        <?php }unset($_SESSION['success']);unset($_SESSION['error']); ?>
    });
</script>
