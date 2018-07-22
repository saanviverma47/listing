
<!-- end - This is for export functionality only -->
<script	src="<?= base_url('assets/assets/plugins/datatables/datatables.min.js')?>"></script>
<script src="<?= base_url('assets/assets/plugins/switchery/dist/switchery.min.js')?>"></script>
<script	src="<?= base_url('assets/assets/plugins/styleswitcher/jQuery.style.switcher.js')?>"></script>
<script>
var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
$('.js-switch').each(function() {  new Switchery($(this)[0], $(this).data()); });
$('#category').DataTable({ dom: 'Bfrtip'});
$(".switchery").on({
  click: function() {
	  var isChecked = $(this).val();
	   alert(isChecked);
	}
});
</script>

<!-- ============================================================== -->
<!-- Style switcher -->
<!-- ============================================================== -->
<script src="<?= base_url('assets/assets/plugins/styleswitcher/jQuery.style.switcher.js')?>"></script>
