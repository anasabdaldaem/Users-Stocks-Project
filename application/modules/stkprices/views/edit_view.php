<main>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-7">
                <div class="card shadow-lg border-0 rounded-lg mt-5">
                    <div class="card-header"><h3 class="text-center font-weight-light my-4">Edit Stock Price</h3></div>
                    <div class="card-body">
                        <form method="post" action="<?php echo site_url('main/admin/stkprices/store')."/".$data->id?>" name="frm_update" id="frm_update">
                            <div class="row mb-3">


                                <div class="form-group">
                                    <label for="stockname">Stock Name</label>
                                    <select class="form-select" name="stockname" id="stockname">
                                        <?php foreach ($stocks as $stock)
                                            {
                                                if($data->stock_id==$stock->id)
                                                    echo '<option value="'. $stock->id .'" selected >'. $stock->name .'</option>';
                                                else
                                                    echo '<option value="'. $stock->id .'" >'. $stock->name .'</option>';
                                            }
                                            ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="stockprice">Stock Price</label>
                                    <input class="form-control" id="stockprice" name="stockprice" value="<?php echo $data->price; ?>" required type="number" step="0.0001"/>
                                </div><div class="form-group">
                                    <label for="extRate">Stock Price</label>
                                    <input class="form-control" id="extRate" name="extRate" value="<?php echo $data->extRate; ?>" required type="number" step="0.00001"/>
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
                extRate:{
                    required: true
                },
                stockname:{
                    required: true
                },
                stockprice:{
                    required: true
                }
            },
            // in 'messages' user have to specify message as per rules
            messages: {
                extRate: {
                    required: " Please choose a Exchange Rate to USD"
                },stockname: {
                    required: " Please choose a stock name"
                },
                stockprice: {
                    required: " Please enter the price of stocks"
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
