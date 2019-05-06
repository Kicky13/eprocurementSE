<script src="<?=base_url('ast11/app-assets/js/scripts/forms/wizard-steps.js')?>" type="text/javascript"></script>
<script src="<?= base_url() ?>ast11/app-assets/vendors/js/pickers/dateTime/moment-with-locales.min.js"  type="text/javascript"></script>
<script src="<?= base_url() ?>ast11/app-assets/vendors/js/pickers/dateTime/bootstrap-datetimepicker.min.js"  type="text/javascript"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$(".dp").datetimepicker({
			icons: {
				time: "icon-clock",
				date: "icon-calendar",
				up: "fa fa-arrow-up",
				down: "fa fa-arrow-down"
			},
			format:'YYYY-MM-DD HH:mm'
		});
		$(".tgl-aja").datetimepicker({
			icons: {
				date: "icon-calendar",
				up: "fa fa-arrow-up",
				down: "fa fa-arrow-down"
			},
			format:'YYYY-MM-DD'
		});
	});
</script>