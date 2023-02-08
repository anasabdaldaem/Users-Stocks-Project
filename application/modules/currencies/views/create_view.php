<main>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-7">
                <div class="card shadow-lg border-0 rounded-lg mt-5">
                    <div class="card-header"><h3 class="text-center font-weight-light my-4">Create currency</h3></div>
                    <div class="card-body">
                        <form method="post" action="<?php echo site_url('main/admin/currencies/create')?>" name="frm_create" id="frm_create">
                            <div class="row mb-3">
                                <div class="form-group">
                                    <label for="inputName">Currency Full Name</label>
                                    <input class="form-control" id="inputName" name="inputName" required type="text" placeholder="Enter your first name" />
                                </div>


                                <div class="form-group">
                                    <label for="inputCode">Currency code</label>
                                    <input class="form-control" id="inputCode" name="inputCode"  required type="text" placeholder="Enter your currency code" />
                                </div>
                                <div class="form-group">
                                    <label for="extRate">Exchange Rate</label>
                                    <input class="form-control" id="extRate" name="extRate"  required type="number" step="0.00001" placeholder="Enter your USD Exchange Rate" />
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
        $("#frm_update").validate({
            // in 'rules' user have to specify all the constraints for respective fields
            rules: {
                inputName:{
                    required: true,
                    minlength: 3
                },
                inputCode:{
                    required: true,
                    maxlength: 3,
                    minlength: 3
                },extRate:{
                    required: true
                }
            },
            // in 'messages' user have to specify message as per rules
            messages: {
                inputName: {
                    required: " Please enter a currency name",
                    minlength: " the currency name must be more than 2 characters"
                },inputCode: {
                    required: " Please enter a currency code",
                    maxlength: " currency code must be 3 characters",
                    minlength: " currency code must be 3 characters"
                },extRate: {
                    required: " Please enter a Exchange Rate to USD"
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
        errormsg='<?php echo str_replace("\n", "", $this->session->flashdata('error'));?>';
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
