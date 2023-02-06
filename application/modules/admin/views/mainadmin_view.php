<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Dashboard</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Dashboard</li>
        </ol>
        <div class="container mt-4 mb-4 p-3 d-flex justify-content-center">
            <div class="card p-4"> <div class=" image d-flex flex-column justify-content-center align-items-center">
                    <img class="rounded-circle" width="150px" src="https://st3.depositphotos.com/15648834/17930/v/600/depositphotos_179308454-stock-illustration-unknown-person-silhouette-glasses-profile.jpg">
                    <span class="name mt-3"><?php echo $data->name; ?></span>
                    <div class=" d-flex mt-2">
                        <button onclick="window.location.href='<?php echo base_url('settings');?>'" class="btn1 btn-dark">Edit Profile</button>
                    </div>
                    <div class="text mt-3">
                        <span><?php echo $data->email; ?></span>
                    </div>
                    <div class=" px-2 rounded mt-4 date ">
                        <span class="join"><?php echo "joined at ".$data->date_of_create; ?></span>
                    </div>
                </div>
            </div>
        </div>
