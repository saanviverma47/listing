<?php

echo get_ol($categories);

function get_ol ($array, $child = FALSE)
{
	$str = '';
	
	if (count($array)) {
		$str .= $child == FALSE ? '<ol class="sortable">' : '<ol>';
		
		foreach ($array as $item) {
			//SET DIVCLASS FOR EXPAND
			$divclass = "mjs-nestedSortable-leaf";
			if(isset($item['children']) && count($item['children'])) {
				$divclass = "mjs-nestedSortable-branch mjs-nestedSortable-collapsed";
			}
			
			$str .= '<li id="list_' . $item['id'] .'" class="'. $divclass .'" >';
			$str .= '<div><span class="disclose"><span></span></span>' . $item['name'] .'</div>';
			
			// Do we have any children?
			if (isset($item['children']) && count($item['children'])) {
				$str .= get_ol($item['children'], TRUE);
			}
			
			$str .= '</li>' . PHP_EOL;
		}
		
		$str .= '</ol>' . PHP_EOL;
	}
	
	return $str;
}
?>
<script>
$(document).ready(function(){

    $('.sortable').nestedSortable({
        handle: 'div',
        items: 'li',
        toleranceElement: '> div',
        maxLevels: 2
    });

    $('.disclose').on('click', function() {
		$(this).closest('li').toggleClass('mjs-nestedSortable-collapsed').toggleClass('mjs-nestedSortable-expanded');
	})

});
</script>