/*----------------------------------------------------*/
/*	Tiny MCE Editor
/*----------------------------------------------------*/
tinymce.init({
	forced_root_block: false, // Start tinyMCE without any paragraph tag
	theme: "modern",
    plugins: [
        "advlist autolink lists link image charmap print preview hr anchor pagebreak",
        "searchreplace wordcount visualblocks visualchars code fullscreen",
        "insertdatetime media nonbreaking save table contextmenu directionality",
        "emoticons template paste textcolor colorpicker textpattern"
    ],
    toolbar1: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
    toolbar2: "| print preview media | forecolor backcolor emoticons",
    image_advtab: true,
    entity_encoding : "raw",
	mode: "exact",
	elements: "pages_body" 
 });