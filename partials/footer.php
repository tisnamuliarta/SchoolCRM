		</section>
	</div>
	<footer class="main-footer">
	    <strong>Copyright &copy; 2014-2016 <a href="javascript:void(0)">TK SINAR PRIMA</a>.</strong> All rights
	    reserved.
	</footer>
</div>
<script src="dashboard/plugins/jQuery/jquery-2.2.3.min.js"></script>
<script src="dashboard/plugins/jQueryUI/jquery-ui.min.js"></script>
<script src="dashboard/bootstrap/js/bootstrap.min.js"></script>
<script src="dashboard/dist/js/moment.min.js"></script>
<script src="dashboard/plugins/daterangepicker/daterangepicker.js"></script>
<script src="dashboard/plugins/datepicker/bootstrap-datepicker.js"></script>
<script src="dashboard/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<script src="dashboard/plugins/fastclick/fastclick.js"></script>
<script src="dashboard/dist/js/app.min.js"></script>
<script src="dashboard/dist/js/script.js"></script>
<script type="text/javascript">
	$(function(){
		<?php if (date('d-m-Y')=='22-12-2012') { ?>
		alert('love u indah');
		<?php } ?>
		var url = window.location.href.substr(window.location.href.lastIndexOf("/")+1);
		$('ul.navbar-nav li a[href="' + url + '"]').parent().addClass('active');
	    $('li#link-sidebar a[href="' + url + '"]').parent().addClass('active');
	    $('#slide1').addClass('active');

	    console.log($('#innerCarousel').children())
	})
</script>
</body>
</html>
