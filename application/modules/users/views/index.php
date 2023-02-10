<h2 class="text-center mt-5 mb-3">Users Table</h2>
<div class="card">
    <div class="card-header">
        <a href="<?php echo base_url('main/admin/users/new') ?>" data-toggle="modal" data-target="#add-user" class="float-right btn btn-primary btn-sm" style="margin: 4px;"><i class="fa fa-plus"></i> Create new User</a>
    </div>
    <div class="card-body">

        <table id="users-list" class="table table-bordered table-hover small">
        <thead>
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Name</th>
            <th scope="col">EMAIL</th>
            <th scope="col">Privilege</th>
            <th scope="col">Last Login</th>
            <th scope="col">Action</th>

        </tr>
        </thead>
        <tbody>
        </tbody>
        </table>
    </div>
</div>

