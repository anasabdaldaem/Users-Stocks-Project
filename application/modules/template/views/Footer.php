<footer class="py-4 bg-light mt-auto">
    <div class="container-fluid px-4">
        <div class="d-flex align-items-center justify-content-between small">
            <div class="text-muted">Copyright &copy; Your Website 2022</div>
            <div>
                <a href="#">Privacy Policy</a>
                &middot;
                <a href="#">Terms &amp; Conditions</a>
            </div>
        </div>
    </div>
</footer>
</div>
</div>
<script src="<?php echo base_url().'assets/js/scripts.js'?>"></script>
<script src="<?php echo base_url().'assets/js/all.js'?>"></script>
<script src="<?php echo base_url().'assets/js/bootstrap.bundle.min.js'?>"></script>
<script src="<?php echo base_url().'assets/js/jsdeliver.js'?>"></script>
<script>
    $(document).ready(function() {
        var referrer =  document.referrer;
        if(referrer=='http://dashboard:8080/login'){
            success.fire({
                icon: 'success',
                title: successmsg
            });
        }
    });
</script>
</body>
</html>

