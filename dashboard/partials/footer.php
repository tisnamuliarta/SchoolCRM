		</section>
	</div>
	<footer class="main-footer">
	    <strong>Copyright &copy; 2014-2016 <a href="javascript:void(0)">TK SINAR PRIMA</a>.</strong> All rights
	    reserved.
	</footer>
</div>
<script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
<script src="plugins/jQueryUI/jquery-ui.min.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>
<script src="dist/js/moment.min.js"></script>
<script src="plugins/datatables/jquery.dataTables.js"></script>
<script src="plugins/datatables/dataTables.bootstrap.min.js"></script>
<script src="plugins/daterangepicker/daterangepicker.js"></script>
<script src="plugins/datepicker/bootstrap-datepicker.js"></script>
<script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
<script src="plugins/fastclick/fastclick.js"></script>
<script src="plugins/iCheck/icheck.min.js"></script>
<script src="plugins/chartjs/Chart.bundle.min.js"></script>
<script src="dist/js/app.min.js"></script>
<script src="dist/js/script.js"></script>
<script src="plugins/datatables/extensions/Buttons/js/dataTables.buttons.min.js"></script>
<script src="plugins/datatables/extensions/Buttons/js/buttons.bootstrap.min.js"></script>
<script src="plugins/datatables/extensions/Buttons/js/buttons.flash.min.js"></script>
<script src="plugins/extra/jszip.min.js"></script>
<script src="plugins/extra/pdfmake.min.js"></script>
<script src="plugins/extra/vfs_fonts.js"></script>
<script src="plugins/datatables/extensions/Buttons/js/buttons.html5.min.js"></script>
<script src="plugins/datatables/extensions/Buttons/js/buttons.print.min.js"></script>
<script src="plugins/select2/select2.full.min.js"></script>
<!-- <script src="dist/js/script.js"></script> -->
<script type="text/javascript">
	$(function(){
		var url = window.location.href.substr(window.location.href.lastIndexOf("/")+1);
		$('ul.treeview-menu li a[href="' + url + '"]').parent().parent().parent().addClass('active');
		$('ul.treeview-menu li a[href="' + url + '"]').parent().addClass('active');
	    $('li#link-sidebar a[href="' + url + '"]').parent().addClass('active');

	    // radio
	    // $('input').iCheck({
	    //   checkboxClass: 'icheckbox_square-blue',
	    //   radioClass: 'iradio_square-blue',
	    //   increaseArea: '20%' // optional
	    // });	   
		
	})
</script>
</body>
</html>
