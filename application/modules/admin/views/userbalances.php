<h2 class="text-center mt-5 mb-3">Users Balances Table</h2>
<div class="row">
    <div class="col-sm">
        <div class="form-group">
            <label for="username">User Name</label>
            <select class="form-select" name="username" id="username">
                <?php foreach ($users as $user)
                {
                    if($data->user_id==$user->id)
                        echo '<option value="'. $user->id .'" selected >'. $user->name .'</option>';
                    else
                        echo '<option value="'. $user->id .'" >'. $user->name .'</option>';
                }
                ?>
            </select>
        </div>
    </div>
    <div class="col-sm">
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
    </div>
    <div class="col-sm">
        <div class="mt-4 mb-0">
            <div class="d-grid"><a href="javascript:;" onclick="confirm();" class="btn btn-primary btn-block" id="getuser" name="getuser">Update</a></div>
        </div>
    </div>
</div>
<div class="card">

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


