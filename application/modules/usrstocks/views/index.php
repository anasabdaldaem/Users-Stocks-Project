<h2 class="text-center mt-5 mb-3">Users Balances Table</h2>
<div class="card">
    <div class="card-header">
        <a href="<?php echo base_url('main/admin/usrstocks/new') ?>" data-toggle="modal" data-target="#add-user" class="float-right btn btn-primary btn-sm" style="margin: 4px;"><i class="fa fa-plus"></i> Add Stocks to User</a>
    </div>
    <div class="card-header">
        <a href="<?php echo base_url('main/admin/newsell') ?>" data-toggle="modal" data-target="#add-user" class="float-right btn btn-primary btn-sm" style="margin: 4px;"><i class="fa fa-plus"></i> Sell Stocks from User</a>
    </div>
    <div class="card-body">

        <table id="usrstocks-list" class="table table-bordered table-hover small">
        <thead>
        <tr>
            <th scope="col">ID</th>
            <th scope="col">User Name</th>
            <th scope="col">Stock Name</th>
            <th scope="col">Stock Count</th>
            <th scope="col">Stock Price</th>
            <th scope="col">Exchange Rate</th>
            <th scope="col">Action</th>

        </tr>
        </thead>
        <tbody>
        </tbody>
        </table>
    </div>
</div>

