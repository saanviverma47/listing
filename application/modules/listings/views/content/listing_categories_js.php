  <?php  
  	$this->load->model('categories/categories_model');
  	// Categories Information
  	$parents = $this->categories_model->select('id, name')->find_all_by('parent_id', 0);
  	$subs = $this->categories_model->select('id, parent_id, name')->find_all_by('parent_id >', 0);
  	
  	//POST BACK HANDLING
  	if(!empty($_POST['selected_categories'])) {
  		$selected_categories = str_replace('/', ',', $_POST['selected_categories']);
  		$selected_categories = explode(',', $selected_categories);
  	}
  	
   	//CHECK WHETHER REQUEST IS FROM EDIT PAGE OR CREATE PAGE
  	$id = $this->uri->segment(5);
  	if($id) { //IF EDIT
  		$this->db->where('listing_id', 1);
  		$query = $this->db->get('listing_categories');
  		$listing_categories = array();
  		foreach($query->result() as $listing_category) {
  			$listing_categories[] = array(
  					'parent_id' => $listing_category->parent_id,
  					'sub_id' => $listing_category->sub_id,
  					'subsub_id' => $listing_category->subsub_id
  			);
  		}
   }
  ?>
  var treeData = [
  	<?php foreach($parents as $parent) { ?>
    {title: "<?php echo $parent->name; ?>", isFolder: true, select: 
    <?php // select category if already exist and parent has no children
        $value = 'false'; //DEFAULT FALSE
        if(!empty($_POST['selected_categories'])) {
        	if(in_array($parent->id, $selected_categories)) { $value = 'true'; }
        } elseif(isset($listing_categories) && $listing_categories) { //IF RESULT IS NOT EMPTY
	        foreach($listing_categories as $listing_parent) {					
					if($listing_parent['parent_id'] == $parent->id) { $value = 'true'; } //SET VALUE TO TRUE
				}
		}
		//PRINT VALUE
		echo $value; ?>, key: "<?php echo $parent->id; ?>",    
      children: [
      <?php foreach($subs as $sub) {
      		if($sub->parent_id == $parent->id) {?>
        {title: "<?php echo $sub->name; ?>", key: "<?php echo $sub->id; ?>", isFolder: <?php echo settings_item('lst.categories_level') == 3 ? 'true': 'false';?>, select: <?php 
        $sub_value = 'false'; //DEFAULT FALSE
        if(!empty($_POST['selected_categories'])) {
				if(in_array($sub->id, $selected_categories)) { $sub_value = 'true'; }
		} elseif (!empty($listing_categories)) { //IF RESULT IS NOT EMPTY
	        foreach($listing_categories as $listing_sub) {					
					if($listing_sub['sub_id'] == $sub->id) { $sub_value = 'true'; } //SET VALUE TO TRUE
				}
		}
		//PRINT VALUE
		echo $sub_value; 
			?><?php if(settings_item('lst.categories_level') == 3):?>,
			children: [
			<?php foreach($subs as $subsub) {
      		if($subsub->parent_id == $sub->id) {?>
			 {title: "<?php echo $subsub->name; ?>", key: "<?php echo $subsub->id; ?>", isFolder: true, select: <?php
				 $selected_subsub_value = 'false'; //DEFAULT FALSE
				 if(!empty($_POST['selected_categories'])) {
				 	if(in_array($subsub->id, $selected_categories)) { $selected_subsub_value = 'true'; }
				 } elseif(isset($listing_categories) && $listing_categories) { //IF RESULT IS NOT EMPTY
	        		foreach($listing_categories as $listing_subsub) {					
						if($listing_subsub['subsub_id'] == $subsub->id) { $selected_subsub_value = 'true'; } //SET VALUE TO TRUE
					}
				}
				 //PRINT VALUE
				 echo $selected_subsub_value; ?>
			},
			<?php } //end of $subsub->state_id if loop
       		} // end of $subsub foreach loop?> 
		]<?php endif;?>
		}, 
       <?php } //end of $sub->parent if loop
       } // end of $subs foreach loop?>
      ] 
    },<?php }?>
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
      keyPathSeparator: "/",
      onSelect: function(select, node) {
      	
        // Get a list of all selected nodes, and convert to a key array:
        var selKeys = $.map(node.tree.getSelectedNodes(), function(node){
          return node.data.key;
        });
        
        if (selKeys.length >= 6) {
        	node.select(false);
        	alert('You are exceeding allowed categories limit.'); //You can assign your business to maximum 2 categories. Select subcategories');
        }
        //$("#selected_categories").val(selKeys);
        $('#on_post_selected_categories').val(1);
        
        var selKeysPath = $.map(node.tree.getSelectedNodes(), function(node){
          return node.getKeyPath();
        });
        $("#selected_categories").val(selKeysPath);        
      },
      onClick: function (node, event) {
		  var selNodes = node.tree.getSelectedNodes();
	      var selTitles = $.map(selNodes, function (node) {
	          return node.data.title;
	      });
	      if (node.getEventTargetType(event) == "title") {
	      // click on a title
	      	if (selTitles.length >= 5 && !node.isSelected()) {
	        //disable toggle if limit is exceeded and node is not a selected one
	        	return false;
	   		} else {
	          	node.toggleSelect();
	        }
	      } else if (node.getEventTargetType(event) == "checkbox") {
	     	// click on a checkbox
	        	if (selTitles.length >= 5 && !node.isSelected()) {
	            //disable selection if hospital limit is exceeded and node is not a selected one
	            	return false;
	            }                   
	      }
        },
        onKeydown: function (node, event) {
            if (event.which == 32) {
			var selNodes = node.tree.getSelectedNodes();
            var selTitles = $.map(selNodes, function (node) {
            	return node.data.title;
      		});           
            if (selTitles.length >= 5 && !node.isSelected()) {
            	return false;
            } else {
                node.toggleSelect();
                return false;
              }
            }
        }     
    });
    
    //TOGGLE SELECT FUNCTION
    /*$("#btnToggleSelect").click(function(){
      $("#categories_tree").dynatree("getRoot").visit(function(node){
        node.toggleSelect();
      });
      return false;
    });*/
    
    //DESELECT ALL OPTION
    $("#btnDeselectAll").click(function(){
      $("#categories_tree").dynatree("getRoot").visit(function(node){
        node.select(false);
      });
      return false;
    });
    
    //SELECT ALL OPTION
    /*$("#btnSelectAll").click(function(){
      $("#categories_tree").dynatree("getRoot").visit(function(node){
        node.select(true);
      });
      return false;
    });*/
});