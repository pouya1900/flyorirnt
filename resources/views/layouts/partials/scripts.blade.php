


	<!-- DataTables -->
	<script src="js/panel/jquery.dataTables.min.js"></script>
	<script src="js/panel/dataTables.bootstrap.min.js"></script>
	<script src="https://cdn.datatables.net/responsive/2.2.0/js/dataTables.responsive.min.js"></script>
	<script src="https://cdn.datatables.net/responsive/2.2.0/js/responsive.bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.4.2/js/buttons.bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.4.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.4.2/js/buttons.print.min.js"></script>
    <!-- Bootstrap Tags Input-->
{{--    <script src="https://cdn.jsdelivr.net/bootstrap.tagsinput/0.8.0/bootstrap-tagsinput.min.js"></script>--}}
	<!-- bootstrap datetimepicker -->
	<script type="text/javascript" src="js/panel/bootstrap-datetimepicker.min.js" charset="UTF-8"></script>
    <!-- Select2 -->
    <script src="js/panel/select2.full.min.js"></script>
	<!-- AdminLTE App -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
	<script src="js/panel/adminlte.min.js"></script>


    <script type="text/javascript" src="js/sticky-sidebar.js"></script>
    <script src="js/custom.js"></script>
<script src="js/owl.carousel.min.js"></script>
    <script type="text/javascript" src="js/jquery-ui.js"></script>
    <script type="text/javascript" src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/swiper.min.js"></script>

	<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
	<script>
	  $.widget.bridge('uibutton', $.ui.button);
	  $('#table').DataTable();
	  $('.select2').select2();
	  //DateTimepicker
	  $('#datetimepicker').datetimepicker({
	        weekStart: 1,
	        todayBtn:  1,
			autoclose: 1,
			todayHighlight: 1,
			startView: 2,
			forceParse: 0,
	        showMeridian: 1
	    });

	</script>