<main>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-7">
                <div class="card shadow-lg border-0 rounded-lg mt-5">
                    <div class="card-header"><h3 class="text-center font-weight-light my-4">Edit Stock</h3></div>
                    <div class="card-body">
                        <form method="post" action="<?php echo site_url('main/admin/stocks/store')."/".$data->id?>" name="frm_update" id="frm_update">
                            <div class="row mb-3">

                                    <div class="form-group">
                                        <label for="inputName">Stock Name</label>
                                        <input class="form-control" id="inputFirstName" name="inputName" value="<?php echo $data->name; ?>" required type="text" placeholder="Enter your first name" />
                                    </div>


                                    <div class="form-group">
                                        <label for="inputDescription">Stock Description</label>
                                        <textarea class="form-control" id="inputDescription" name="inputDescription" rows="3"><?php echo $data->describ; ?></textarea>
                                    </div>
                            </div>
                            <div class="mt-4 mb-0">
                                <div class="d-grid"><button type="submit" class="btn btn-primary btn-block" id="submit" name="submit">Update</button></div>
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
                inputDescription:{
                    required: true,
                    minlength: 10
                }
            },
            // in 'messages' user have to specify message as per rules
            messages: {
                inputName: {
                    required: " Please enter a stock name",
                    minlength: " the stock name must be more than 2 characters"
                },inputDescription: {
                    required: " Please enter a stock description",
                    minlength: " stock description must be more than 10 characters"
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
        errormsg='<?php echo $this->session->flashdata('error');?>';
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
