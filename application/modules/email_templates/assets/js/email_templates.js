/*----------------------------------------------------*/
/*	CKEditor for Message
/*----------------------------------------------------*/ 
if( !('email_templates_message' in CKEDITOR.instances)) {
    CKEDITOR.replace( 'email_templates_message', {
toolbar: 'Basic'
});
}