  <?php  
  	// CATEGORIES INFORMATION
  	$parents = $this->banners_model->get_parents();
  	$subs = $this->banners_model->get_subs();
  	
  	// LOCATIONS INFORMATION
  	$countries_info = $this->countries_model->select('iso, name')->find_all();
  	$states_info = $this->states_model->select('id, country_iso, name')->find_all();
  	$cities_info = $this->cities_model->select('id, state_id, name')->find_all();
  	
  	//CHECK WHETHER REQUEST IS FROM EDIT PAGE OR CREATE PAGE
  	$id = $this->uri->segment(5);
  	if($id) { //IF EDIT
  		$selected = $this->banners_model->select('category_id')->get_banner_categories($id);
  		$selected_locations = $this->banners_model->select('city_id, state_id, country_iso')->get_banner_locations($id);
  	}
  ?>
  var treeData = [
  	<?php foreach($parents as $parent) { ?>
    {title: "<?php echo $parent->name; ?>", isFolder: true, select: 
    <?php // select category if already exist and parent has no children
        $value = 'false'; //DEFAULT FALSE
        if(isset($selected) && $selected) { //IF RESULT IS NOT EMPTY
	        foreach($selected as $true) {
					if($true->category_id == $parent->id) { $value = 'true'; } //SET VALUE TO TRUE
				}
		}
		//PRINT VALUE
		echo $value; ?>, key: "<?php echo $parent->id; ?>",    
      children: [
      <?php foreach($subs as $sub) {
      		if($sub->parent_id == $parent->id) {?>
        {title: "<?php echo $sub->name; ?>", key: "<?php echo $sub->id; ?>", select: <?php 
        $value = 'false'; //DEFAULT FALSE
        if(isset($selected) && $selected) { //IF RESULT IS NOT EMPTY
	        foreach($selected as $true) {
					if($true->category_id == $sub->id) { $value = 'true'; } //SET VALUE TO TRUE
				} // end of $true foreach loop
		} // end of $selected if
		//PRINT VALUE
		echo $value; 
			?>}, 
       <?php } //end of $sub->parent if loop
       } // end of $subs foreach loop?>
      ] 
    },<?php }?>
  ]; 
  
  
  	var locationData = [
  	<?php foreach($countries_info as $country_info) { ?>
  	{title: "<?php echo $country_info->name; ?>", isFolder: true, select: 
  	<?php // select country if already exist and has no states
        $selected_country_value = 'false'; //DEFAULT FALSE
        if(isset($selected_locations) && $selected_locations) { //IF RESULT IS NOT EMPTY
	        foreach($selected_locations as $selected_location) {
					if($selected_location->country_iso == $country_info->iso) { $selected_country_value = 'true'; } //SET VALUE TO TRUE
				}
		}
		//PRINT VALUE
		echo $selected_country_value; ?>, key: "<?php echo $country_info->iso; ?>",
		children: [
      <?php foreach($states_info as $state_info) {
      		if($state_info->country_iso == $country_info->iso) {?>
        {title: "<?php echo $state_info->name; ?>", key: "<?php echo $state_info->id; ?>", isFolder: true, select: <?php 
        $selected_state_value = 'false'; //DEFAULT FALSE
        if(isset($selected_locations) && $selected_locations) { //IF RESULT IS NOT EMPTY
	        foreach($selected_locations as $selected_state) {
					if($selected_state->state_id == $state_info->id) { $selected_state_value = 'true'; } //SET VALUE TO TRUE
				} // end of $true foreach loop
		} // end of $selected if
		//PRINT VALUE
		echo $selected_state_value; 
			?>,
			children: [
			<?php foreach($cities_info as $city_info) {
      		if($city_info->state_id == $state_info->id) {?>
			 {title: "<?php echo $city_info->name; ?>", key: "<?php echo $city_info->id; ?>", isFolder: true, select: <?php
				 $selected_city_value = 'false'; //DEFAULT FALSE
				 if(isset($selected_locations) && $selected_locations) { //IF RESULT IS NOT EMPTY
				 	foreach($selected_locations as $selected_city) {
				 		if($selected_city->city_id == $city_info->id) { $selected_city_value = 'true'; } //SET VALUE TO TRUE
				 	} // end of $true foreach loop
				 } // end of $selected if
				 //PRINT VALUE
				 echo $selected_city_value; ?>
			},
			<?php } //end of $city_info->state_id if loop
       		} // end of $city_info foreach loop?> 
		]
		},
       <?php } //end of $state_info if loop
       } // end of $state_info foreach loop?>
      ] 
    },
    <?php }?>   
  ];
/*  ------------------------------------------------------------
	CATEGORY TREE
	------------------------------------------------------------ */
   $(function(){
    $("#categories_tree").dynatree({
      checkbox: true,
      debugLevel: 0,
      selectMode: 3,
      children: treeData,
      onSelect: function(select, node) {
        // Get a list of all selected nodes, and convert to a key array:
        var selKeys = $.map(node.tree.getSelectedNodes(), function(node){
          return node.data.key;
        });
        $("#selected_categories").val(selKeys);
        $('#on_post_selected_categories').val(1);
      },
      onDblClick: function(node, event) {
        node.toggleSelect();
      },
      onKeydown: function(node, event) {
        if( event.which == 32 ) {
          node.toggleSelect();
          return false;
        }
      },
      // only required, if we have more than one tree on one page
      cookieId: "categorytree-GC",
      idPrefix: "categorytree-GC-"      
    });
    
    //TOGGLE SELECT FUNCTION
    $("#btnToggleSelect").click(function(){
      $("#categories_tree").dynatree("getRoot").visit(function(node){
        node.toggleSelect();
      });
      return false;
    });
    
    //DESELECT ALL OPTION
    $("#btnDeselectAll").click(function(){
      $("#categories_tree").dynatree("getRoot").visit(function(node){
        node.select(false);
      });
      return false;
    });
    
    //SELECT ALL OPTION
    $("#btnSelectAll").click(function(){
      $("#categories_tree").dynatree("getRoot").visit(function(node){
        node.select(true);
      });
      return false;
    });
    
/*  ------------------------------------------------------------
	LOCATION TREE
	------------------------------------------------------------ */
    $("#locations_tree").dynatree({
      checkbox: true,
      debugLevel: 0,
      selectMode: 3,
      children: locationData,
      keyPathSeparator: "/",
      onSelect: function(select, node) {
        // Get a list of all selected nodes, and convert to a key array:
        var selKeys = $.map(node.tree.getSelectedNodes(), function(node){
          return node.data.key;
        });
        
        // When user deselect all locations, set this hidden field value to 1 and it will be updated only if user deselect or select something
        $('#on_post_selected_locations').val(1); // To deal with post data
        
        var selKeysPath = $.map(node.tree.getSelectedNodes(), function(node){
          return node.getKeyPath();
        });
        $("#selected_locations").val(selKeysPath);
      },

      onDblClick: function(node, event) {
        node.toggleSelect();
      },
      onKeydown: function(node, event) {
        if( event.which == 32 ) {
          node.toggleSelect();
          return false;
        }
      },
      // only required, if we have more than one tree on one page
      cookieId: "locationtree-GC",
      idPrefix: "locationtree-GC-" 
    });
    
    //TOGGLE SELECT FUNCTION
    $("#btnToggleLocationsSelect").click(function(){
      $("#locations_tree").dynatree("getRoot").visit(function(node){
        node.toggleSelect();
      });
      return false;
    });
    
    //DESELECT ALL OPTION
    $("#btnLocationsDeselectAll").click(function(){
      $("#locations_tree").dynatree("getRoot").visit(function(node){
        node.select(false);
      });
      return false;
    });
    
    //SELECT ALL OPTION
    $("#btnLocationsSelectAll").click(function(){
      $("#locations_tree").dynatree("getRoot").visit(function(node){
        node.select(true);
      });
      return false;
    });
   });

/*  ------------------------------------------------------------
	START AND END DATE TIME PICKER
	------------------------------------------------------------ */
	
$('#banners_start_date').datepicker({ dateFormat: 'yy-mm-dd'}); //DATE PICKER
$('#banners_end_date').datepicker({ dateFormat: 'yy-mm-dd'}); //DATE PICKER

/*  ------------------------------------------------------------
	HIDE FIELDS FROM BANNER FORM
	------------------------------------------------------------ */
$('#banners_type_id').change(function () {
	var selected_value = $('#banners_type_id').val();
	$.post('<?php echo site_url(SITE_AREA .'/settings/banners/get_banner_type/');?>', { banner_type_id: selected_value, '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>' }, function(data) {
		$('#banners_type').val(data);
		if(data == '') {
            $('#image-fields').hide();
        } else {
            $('#image-fields').toggle((data == 'image') || (data == 'slider'));
            $('#html-text-fields').toggle((data == 'text') || (data == 'html') || (data == 'slider'));
            $('#common-fields').toggle((data == 'image') || (data == 'text') || (data == 'html'));
            $('#slider-fields').toggle(data == 'slider');
        }
	});	
})

/*  ------------------------------------------------------------
	HIDE FIELDS FROM BANNER_TYPE FORM
	------------------------------------------------------------ */
$('#type').change(function () {
	var selected_value = $('#type').val();
		if(selected_value == '') {
            $('#image-fields').hide();
        } else {
            $('#image-fields').toggle(selected_value == 'image');
        }
});