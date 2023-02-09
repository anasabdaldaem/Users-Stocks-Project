</div>
<script>
    $.fn.dataTable.ext.errMode = function ( settings, helpPage, message ) {
        error.fire({
            icon: 'error',
            title: "no data for this user on this stock"
        });
    };
    function confirm2() {
        user=$('#username').val();
        stock=$('#stockname').val();
        $('#usrstocks-list').DataTable({
            "destroy": true,
            "lengthChange": false,
            "paging": true,
            "searching": false,
            "processing": true,
            "ordering": false,
            "serverSide": true,
            "ajax": {
                url :"<?php echo base_url('get_userprofit/'); ?>"+user+"/"+stock,
                type :'GET',

            },"columns": [
                {
                    "data":undefined,
                    "defaultContent": "N/A"
                },{
                    "data":undefined,
                    "defaultContent": "N/A"
                },{
                    "data":undefined,
                    "defaultContent": "N/A"
                },{
                    "data":undefined,
                    "defaultContent": "N/A"
                },{
                    "data":undefined,
                    "defaultContent": "N/A"
                },{
                    "data":undefined,
                    "defaultContent": "N/A"
                },{
                    "data":undefined,
                    "defaultContent": "N/A"
                },{
                    "data":undefined,
                    "defaultContent": "N/A"
                },{
                    "data":undefined,
                    "defaultContent": "N/A"
                },{
                    "data":undefined,
                    "defaultContent": "N/A"
                },{
                    "data":undefined,
                    "defaultContent": "N/A"
                },{
                    "data":undefined,
                    "defaultContent": "N/A"
                }
            ],
            "fnCreatedRow": function( nRow, aData, iDataIndex ) {
                $(nRow).attr('id', aData[0]);
            }
        });
    }
    function confirm() {
        user=$('#username').val();
        stock=$('#stockname').val();
        $('#usrstocks-list').DataTable({
            "destroy": true,
            "lengthChange": false,
            "paging": true,
            "searching": false,
            "processing": true,
            "ordering": false,
            "serverSide": true,
            "ajax": {
                url :"<?php echo base_url('get_userbalance/'); ?>"+user+"/"+stock,
                type :'GET',

            },"columns": [
                {
                    "data":undefined,
                    "defaultContent": "N/A"
                },{
                    "data":undefined,
                    "defaultContent": "N/A"
                },{
                    "data":undefined,
                    "defaultContent": "N/A"
                },{
                    "data":undefined,
                    "defaultContent": "N/A"
                },{
                    "data":undefined,
                    "defaultContent": "N/A"
                },{
                    "data":undefined,
                    "defaultContent": "N/A"
                },{
                    "data":undefined,
                    "defaultContent": "N/A"
                },{
                    "data":undefined,
                    "defaultContent": "N/A"
                },{
                    "data":undefined,
                    "defaultContent": "N/A"
                },{
                    "data":undefined,
                    "defaultContent": "N/A"
                },{
                    "data":undefined,
                    "defaultContent": "N/A"
                }
                ],
            "fnCreatedRow": function( nRow, aData, iDataIndex ) {
                $(nRow).attr('id', aData[0]);
            }
        });
        }

</script>



