
<!-- end - This is for export functionality only -->
<script	src="<?= base_url('assets/assets/plugins/datatables/datatables.min.js')?>"></script>
<script	src="<?= base_url('assets/assets/plugins/bootstrap-switch/bootstrap-switch.min.js')?>"></script>
<script>
$('#category').DataTable({ dom: 'Bfrtip'});

$(".bt-switch input[type='checkbox']").bootstrapSwitch();
var radioswitch = function() {
    var bt = function() {
        $(".radio-switch").on("switch-change", function() {
           alert("hello"); 
        });
    };
    return {
        init: function() {
            bt()
        }
    }
}();
$(document).ready(function() {
    radioswitch.init();
});
function toggleOffByInput() {
	alert("hello");
   // $('#toggle-trigger').prop('checked', false).change()
}
</script>

<!-- ============================================================== -->
<!-- Style switcher -->
<!-- ============================================================== -->
<script src="<?= base_url('assets/assets/plugins/styleswitcher/jQuery.style.switcher.js')?>"></script>
