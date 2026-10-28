<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.14.0/jquery.validate.js"></script>
      <!-- <script src="<?php echo base_url() ?>authordashboard/assets/js/jquery.min.js"></script> -->
      <script src="<?php echo base_url() ?>authordashboard/assets/js/popper.min.js"></script>
      <script src="<?php echo base_url() ?>authordashboard/assets/js/bootstrap.bundle.min.js"></script>

      <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script>
 <script>
 $("input").on("keypress", function(e) {
    if (e.which === 32 && !this.value.length)
        e.preventDefault();
});
</script>
   <footer class="pt-5">
  <div class="container">
    <div class="row">
      <div class="col-md-12 text-center">
        <p>Copyright © BFC Publications - <?php echo date('Y')?></p>
    </div>
  </div>
</footer>

     