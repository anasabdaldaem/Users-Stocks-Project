</div>
<script>
    $('#usrstocks-list').DataTable({
        "lengthChange": false,
        "paging": true,
        "searching": false,
        "processing": false,
        "ordering": true,
        "serverSide": true,
        "ajax": {
            url :"<?php echo base_url('get_balances'); ?>",
            type :'GET'
        },"columns": [
            null,
            null,
            null,
            null,
            null,

        ],
        "fnCreatedRow": function( nRow, aData, iDataIndex ) {
            $(nRow).attr('id', aData[0]);
        }
    });
</script>
</body>


