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

<script src="<?php echo base_url('assets/js/scripts.js')?>"></script>
<script src="<?php echo base_url('assets/js/bootstrap.bundle.min.js')?>"></script>
<script src="<?php echo base_url('assets/js/jquery.min.js')?>"></script>
<script src="<?php echo base_url('assets/js/all.js')?>" crossorigin="anonymous"></script>
<script src="<?php echo base_url('assets/js/jquery.validate.min.js')?>" crossorigin="anonymous"></script>
<script src="<?php echo base_url().'assets/js/sweetalert2.all.min.js'?>"></script>
<script>

    $(document).ready(function () {
        $("#frm_login").validate({
            // in 'rules' user have to specify all the constraints for respective fields
            rules: {
                inputPassword: {
                    required: true,
                    minlength: 8
                },
                inputEmail: {
                    required: true,
                    email: true
                }
            },
            // in 'messages' user have to specify message as per rules
            messages: {
                inputPassword: {
                    required: " Please enter a password",
                    minlength: " Your password must be consist of at least 8 characters"
                },
                inputEmail:{
                    required: " Please enter an Email",
                    email: "Please enter a valid Email"
                }
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
        })
        <?php
        if($this->session->flashdata('error'))
        { ?>
        errormsg='<?php echo str_replace("\n", "", $this->session->flashdata('error'));?>';
        error.fire({
            icon: 'error',
            title: errormsg
        })
        <?php } unset($_SESSION['success']);unset($_SESSION['error']);?>
    });
</script>

</body>
</html>

