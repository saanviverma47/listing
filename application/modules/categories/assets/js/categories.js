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
	elements: "categories_description"
 });

var site_url = $('#site_url').val();
var listings_categories_level = $('#listings_categories_level').val();
//CATEGORY AND SUBCATEGORY AJAX FUNCTION
var csrf_token = $.cookie('ci_csrf_token');
if(listings_categories_level == 3) {
$('#categories_parent_id').change(function(){ //any select change on the dropdown with id options trigger this code
	$("#listings_subcategory_id > option").remove(); //first of all clear select items
    $("#listings_subcategory_id").html("<option value=''>-- Select Sub Category --</option>");
    var option = $('#categories_parent_id').val();  // here we are taking option id of the selected one.
    $("#listings_subcategory_id").removeAttr('disabled'); // enable dropdown if there is subcategory

    if(option == ''){
      	 $("#listings_subcategory_id").html("<option value=''>-- Select Sub Category --</option>"); //If parent category is null set text of parent category
       	 $("#listings_subcategory_id").attr('disabled', true); // disable subcategory dropdown        	 
       	 return false; // return false after clearing sub options if 'please select was chosen'
    }
    $.ajax({
         type: "POST",
         url: site_url + "/content/listings/get_sub_categories/"+option, //here we are calling our dropdown controller and getsuboptions method passing the option
         data: 'ci_csrf_token=' + csrf_token,
         success: function(suboptions) //we're calling the response json array 'suboptions'
         {
           	if(suboptions != undefined){
            $.each(suboptions,function(id,value) //here we're doing a foeach loop round each sub option with id as the key and value as the value
            {               	
               var opt = $('<option />'); // here we're creating a new select option for each suboption
               opt.val(id);
               opt.text(value);
               $('#listings_subcategory_id').append(opt); //here we will append these new select options to a dropdown with the id 'suboptions
            });
            }}
   });
});
} 