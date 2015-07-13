</div>
<footer class="container-fluid footer">
	Copyright © 2014 <a href="<?php echo base_url()?>" target="_blank"><?php echo site_name()?></a>
	<a href="#" class="pull-right scrollToTop"><i class="fa fa-chevron-up"></i></a>
</footer>
</section>

<!-- Content Block Ends Here (right box)-->

<!-- bootsrtap components -->
<script src="<?php echo template_path('assets/bootstrap/components/bootbox-v4.4.0/bootbox.min.js')?>"></script>
<!-- bootsrtap components -->

<!-- Globalize -->
<script src="<?php echo template_path('donee/assets/js/globalize/globalize.min.js')?>"></script>
<!-- NanoScroll -->
<script src="<?php echo template_path('donee/assets/js/plugins/nicescroll/jquery.nicescroll.min.js')?>"></script>
<?php /*
<!-- Chart JS -->
<script src="<?php echo template_path('donee/assets/js/plugins/DevExpressChartJS/dx.chartjs.js')?>"></script>
<script src="<?php echo template_path('donee/assets/js/plugins/DevExpressChartJS/world.js')?>"></script>
<!-- For Demo Charts -->
<script src="<?php echo template_path('donee/assets/js/plugins/DevExpressChartJS/demo-charts.js')?>"></script>
<script src="<?php echo template_path('donee/assets/js/plugins/DevExpressChartJS/demo-vectorMap.js')?>"></script>

<!-- Sparkline JS -->
<script src="<?php echo template_path('donee/assets/js/plugins/sparkline/jquery.sparkline.min.js')?>"></script>
<!-- For Demo Sparkline -->
<script src="<?php echo template_path('donee/assets/js/plugins/sparkline/jquery.sparkline.demo.js')?>"></script>

<!-- Angular JS -->
<!-- <script src="../../../ajax.googleapis.com/ajax/libs/angularjs/1.3.0-beta.14/angular.min.js')?>"></script> -->
<!-- ToDo List Plugin -->
<script src="<?php echo template_path('donee/assets/js/angular/todo.js')?>"></script>

<!-- Calendar JS -->
<script src="<?php echo template_path('donee/assets/js/plugins/calendar/calendar.js')?>"></script>
<!-- Calendar Conf -->
<script src="<?php echo template_path('donee/assets/js/plugins/calendar/calendar-conf.js')?>"></script>

*/ ?>

<!-- Wysihtml5 -->
<script src="<?php echo template_path('donee/assets/js/plugins/bootstrap-wysihtml5/wysihtml5-0.3.0.min.js')?>"></script>
<script src="<?php echo template_path('donee/assets/js/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.js')?>"></script>


<!-- datepicker -->
<link rel="stylesheet" href="<?=template_path('assets/jquery/ui/datepicker_1.11.4/themes/smoothness/jquery-ui.css')?>">
<script src="<?=template_path('assets/jquery/ui/datepicker_1.11.4/jquery-ui.js')?>"></script>
<!-- datepicker -->


<!-- Custom JQuery -->
<script src="<?php echo template_path('donee/assets/js/app/custom.js')?>" type="text/javascript"></script>
<script src="<?php echo template_path('assets/js/campaign.js')?>" type="text/javascript"></script>

<script type="text/javascript">
	$(function(){

		$( "#starting_at" ).datepicker({
			dateFormat: 'dd-mm-yy',
			minDate: new Date(),
			stepMonths: 0,
			onClose: function( selectedDate ) {
				$( "#ending_at" ).datepicker( "option", "minDate", selectedDate );
			}
		});
		$( "#ending_at" ).datepicker({
			dateFormat: 'dd-mm-yy',
			numberOfMonths: 2,
			stepMonths: 0,
			onClose: function( selectedDate ) {
				$( "#ending_at" ).datepicker( "option", "maxDate", selectedDate );
			}
		});
		$("#starting_at").datepicker('setDate', new Date());

		$('#add_more').click(function(e){
			e.preventDefault();
			var section='<div class="form-group">';
			section+='<input type="file" class="photos" name="photos[]"  style="float:left">';
			section+='<a href="#" class="remove btn btn-danger  btn-xs">Remove</a>';
			section+='</div>';
			$('#add_remove .form-group:last').after(section);
			$('#remove_all').toggle(true);
			console.log(this);
		});

		$('#remove_all').click(function(e){
			e.preventDefault();
			$("#add_remove div.form-group:not(:first)").remove();
			$('#remove_all').toggle(false);
		});

		$( "body" ).on( "click", "a.remove", function(e) {
			e.preventDefault();
			$(this).parent().remove();
			$('#remove_all').toggle($(".photos").length==0?false:true);
		});

		$('#remove_all').toggle($(".photos").length==0?false:true);

		var tab='<?php echo get_session("tab")?>';
		tab=tab?tab:'tab-1';
		$('.nav-tabs a[href="#' + tab + '"]').tab('show');

		$('#url_link').keyup(function() {
			var val = $(this).val();
			val = val.toLowerCase();
			val = val.replace(/[^a-z0-9 ]+/g, '');
			val = val.replace('  ', ' ');
			var url = val.replace(/\s/g, '-') ;
			$('#your_url').html("/"+url);
		});


		$('a.delete').on("click", function(e) {
			e.preventDefault();
			var url = $(this).attr('href');
			bootbox.confirm("Are you sure?", function(result) {
				if(result){
					window.location=url;
				}
			});
		});

	});
</script>
</body>
</html>
