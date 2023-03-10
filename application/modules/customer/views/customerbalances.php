<h2 class="text-center mt-5 mb-3">Users Balances Table</h2>
<div class="card">
    <div class="card-header">
        <a href="<?php echo base_url('main/customer/newsell') ?>" data-toggle="modal" data-target="#add-user" class="float-right btn btn-primary btn-sm" style="margin: 4px;"><i class="fa fa-plus"></i>Sell Stocks</a>
    </div>
    <div class="card-body">

        <table id="usrstocks-list" class="table table-bordered table-hover small">
            <thead>
            <tr>
                <th scope="col">User Name</th>
                <th scope="col">Stock Name</th>
                <th scope="col">Stock Count</th>
                <th scope="col">Stock Buy Price</th>
                <th scope="col">Exchange Buy Rate</th>
                <th scope="col">Total Buy Price in TL</th>
                <th scope="col">Total Buy Price in USD</th>
                <th scope="col">Stock Price Now</th>
                <th scope="col">Exchange Rate Now</th>
                <th scope="col">Total Price in TL Now</th>
                <th scope="col">Total Price in USD Now</th>

            </tr>
            </thead>
        </table>
    </div>
</div>


