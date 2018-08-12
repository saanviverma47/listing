/*----------------------------------------------------*/
/*	Check All
/*----------------------------------------------------*/
$('.check-all').click(function(){
	$('table input:checkbox').not(this).prop('checked', this.checked);
});

/*----------------------------------------------------*/
/*	Set Focus on the First Form Field
/*----------------------------------------------------*/
$(":input:visible:first").focus();
$('#products_type').selectize();

/*----------------------------------------------------*/
/*	DESCRIPTION EDITOR
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
	elements: "products_description, listings_description",
	setup: function(ed) {
        var text = '';
        var htmlcount = '';
        var wordlimit = parseInt($('#'+(ed.id)).attr("maxlength"));
        /** handler for keydown event to prevent < 200 character limit */
        ed.on('keydown',function(e) {
            text = ed.getContent({format : 'text'}).replace(/(< ([^>]+)<)/g,"").length;
            wordcount = wordlimit - text;
            
            //setting up the text string that will display in the path area
            htmlcount = "Character Count: " + (wordlimit-text);
            
               if(wordcount <= 0 && e.keyCode != 8) {                   
                   	// prevent insertion of typed character
                    e.preventDefault();
                    e.stopPropagation();
                    return false;
               }
               // place text string in path bar
               if ( $('#max_char_string').size() ){
                 $('#max_char_string').html( '&nbsp;' + htmlcount);
               }
               else {
                 $("div#"+ed.id+"_path_row").append('<span id="max_char_string">&nbsp;'+htmlcount+'</span>')
               }
        });
        /** handler for headline text changes */
        ed.on('change redo undo',function(e) {
            var content = tinyMCE.get(ed.id).getContent();
            var escapedClassName = ed.id.replace(/(\[|\])/g, '\\$&');
            $('.'+escapedClassName).html(content);
        });
   }
 });