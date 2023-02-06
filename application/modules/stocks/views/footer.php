</div>
<script>
$(document).ready(function (){
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
  $('#stocks-list').DataTable({
      "lengthChange": false,
      "paging": true,
      "searching": false,
      "processing": false,
      "ordering": true,
      "serverSide": true,
      "ajax": {
        url :"<?php echo base_url('get_stocks'); ?>",
        type :'GET'
    },"columns": [
          null,
          null,
          null,
          {
              mRender: function (data, type, row) {
                  var bindHtml = '';
                  bindHtml += '<a href="<?php echo base_url('main/admin/stocks/edit/')?>'+row[0]+'" title="Edit" class="update-staff-details ml-1 btn-ext-small btn btn-sm btn-primary"><i class="fas fa-edit"></i></a>';
                  bindHtml += '<a onclick="return confirm('+row[0]+');" href="javascript:;"  title="Delete" class="delete-staff-details ml-1 btn-ext-small btn btn-sm btn-danger"><i class="fas fa-times"></i></a>';
                  return bindHtml;
              }
          },

      ],
      "fnCreatedRow": function( nRow, aData, iDataIndex ) {
          $(nRow).attr('id', aData[0]);
      }
  });
function confirm(staffname){
    Swal.fire({
        title: 'Are You Sure You Want To Delete This?',
        showDenyButton: true,
        confirmButtonText: 'Yes',
        denyButtonText: 'No Stop it',
    }).then((result) => {
        /* Read more about isConfirmed, isDenied below */
        if (result.isConfirmed) {
            window.location.href = "<?php echo base_url('main/admin/stocks/delete/');?>" + staffname;
        } else if (result.isDenied) {
            Swal.fire('Delete process is stop', '', 'info')
        }
    });
}
</script>
</body>


