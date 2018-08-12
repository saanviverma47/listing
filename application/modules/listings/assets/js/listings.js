/*----------------------------------------------------*/
/*	Tiny MCE Editor
/*----------------------------------------------------*/
tinymce.init({
	theme: "modern",
    plugins: [
        "advlist autolink lists link image charmap print preview hr anchor pagebreak",
        "searchreplace wordcount visualblocks visualchars code fullscreen",
        "insertdatetime media nonbreaking save table contextmenu directionality",
        "emoticons template paste textcolor colorpicker textpattern"
    ],
    toolbar1: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
    toolbar2: "print preview media | forecolor backcolor emoticons",
    image_advtab: true,
	mode: "exact",
	elements: "products_description, listings_description"
 });

$('.dropdown-menu li').click(function () {
    var eid = $(this).attr("data-id");
    var $frm = $('#listing_form');
    //set the value of the hidden element
    $frm.find('input[name="order_by"]').val(eid);
    //submit the form
    $frm.submit();
});