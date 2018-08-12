/*----------------------------------------------------*/
/*	Page Sorting
/*----------------------------------------------------*/ 
$('.sortable').nestedSortable({
     handle: 'div',
     items: 'li',
     toleranceElement: '> div',
     maxLevels: 2
});
    
$('.disclose').on('click', function() {
	$(this).closest('li').toggleClass('mjs-nestedSortable-collapsed').toggleClass('mjs-nestedSortable-expanded');
})

$(function() {
	$.post('<?php echo site_url(SITE_AREA .'/content/pages/order_ajax'); ?>', {'<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'}, function(data){
		$('#orderResult').html(data);
	});

		$('#save').click(function(){
			oSortable = $('.sortable').nestedSortable('toArray');

			$('#orderResult').slideUp(function(){
				$.post('<?php echo site_url(SITE_AREA .'/content/pages/order_ajax'); ?>', { sortable: oSortable, '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>' }, function(data){
					$('#orderResult').html(data);
					$('#orderResult').slideDown();
				});
			});

		});
});