<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
 
 
 
 
 
 
 
 
 
 
 
 

/**
 * Tags controller
 */
class Content extends Admin_Controller
{
	/**
	 * Constructor
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();

		$this->auth->restrict('Tags.Content.View');
		$this->load->model('tags_model', null, true);
		$this->lang->load('datatable');
		
		//SEARCH TAGS
		Assets::add_js(Template::theme_url('js/bootstrap.js'));
		Assets::add_js($this->load->view('content/tags_js', null, true), 'inline');
		
		Assets::add_js( array ( Template::theme_url('js/jquery.dataTables.min.js' )) );
		Assets::add_js( array ( Template::theme_url('js/bootstrap-dataTables.js' )) );
		Assets::add_css( array ( Template::theme_url('css/datatable.css') ) ) ;
		Assets::add_css( array ( Template::theme_url('css/bootstrap-dataTables.css') ) ) ;
	}

	//--------------------------------------------------------------------


	/**
	 * Displays a list of form data.
	 *
	 * @return void
	 */
	public function index($filter='all', $offset=0, $id = NULL) {
		// Do we have any actions?
		if (isset($_POST['activate']))    $action = '_activate';
		if (isset($_POST['deactivate']))  $action = '_deactivate';
		
		if (isset($action)) {
			$checked = $this->input->post('checked');		
			if (!empty($checked)) {
				foreach($checked as $tag_id) {
					$this->$action($tag_id);
				}
			} else {
				Template::set_message(lang('ls_empty_id'), 'error');
			}
		}

		$where = '';
		// Filters
		$filter_type = $filter;
		
		switch($filter_type) {
			case 'active':
				$where['tags.active'] = 1;
				break;
				
			case 'inactive':
				$where['tags.active'] = 0;
				break;
				
			case 'first_letter':
				$where['SUBSTRING( LOWER(name), 1, 1)='] = $first_letter;
				break;
				
			case 'all':
			// Nothing to do
				break;
				
			default:
				show_404("tags/index/$filter/");
		}
		// Deleting anything?
		if (isset($_POST['delete'])) {
			$checked = $this->input->post('checked');
			if (is_array($checked) && count($checked)) {
				$result = FALSE;
				foreach ($checked as $pid) {
					$result = $this->tags_model->delete($pid);
					// Purge any tags for this listing, also.
					$this->db->where('tag_id', $pid)->delete('listing_tags');
				}

				if ($result) {
					Template::set_message(count($checked) .' '. lang('delete_success'), 'success');
				} else {
					Template::set_message(lang('delete_failure') . $this->tags_model->error, 'error');
				}
			}
		}
		
		if (isset($_POST['search'])) {
			$searchterm = $this->input->post('search');
			$this->db->or_like(array(
				'id' => $searchterm,
				'name' => $searchterm,
				'created_on' => $searchterm
			));
		}
		$this->tags_model->limit($this->limit, $offset)->where($where);
		$records = $this->tags_model->order_by('id', 'desc')->find_all();		
		
		// Pagination
		$this->load->library('pagination');
		$this->tags_model->where($where);
		$total_tags = $this->tags_model->count_all();
		
				
		$this->pager['base_url'] = site_url(SITE_AREA ."/content/tags/index/$filter/");
		$this->pager['uri_segment']	= 6;
		$this->pager['total_rows'] = $total_tags;
		$this->pager['per_page'] = $this->limit;
		
		
		$this->pagination->initialize($this->pager);
		
		Template::set('index_url', site_url(SITE_AREA .'/content/tags/index/'));
		Template::set('filter_type', $filter_type);		
		
		if (isset($_POST['save'])) {
			if($id == NULL) {
				if ($insert_id = $this->save_tags()) {
					// Log the activity
					log_activity($this->current_user->id, lang('act_create_record') .': '. $insert_id .' : '. $this->input->ip_address(), 'tags');
			
					Template::set_message(lang('create_success'), 'success');
					if($this->uri->segment(5) && ($this->uri->segment(6))) {
						redirect(site_url(SITE_AREA .'/content/tags/index/'.$this->uri->segment(5).'/'.$this->uri->segment(6).'/'));
					} elseif($this->uri->segment(5)) {
						redirect(site_url(SITE_AREA . '/content/tags/index/'.$this->uri->segment(5).'/'));
					} else {										
						redirect(site_url(SITE_AREA . '/content/tags/index/all/0/'));
					}
				} else {
					Template::set_message(lang('create_failure') . $this->tags_model->error, 'error');
				}
			} else {
				$this->auth->restrict('Tags.Content.Edit');				
				if ($this->save_tags('update', $id))
				{
					// Log the activity
					log_activity($this->current_user->id, lang('act_edit_record') .': '. $id .' : '. $this->input->ip_address(), 'tags');
				
					Template::set_message(lang('edit_success'), 'success');
					if($this->uri->segment(5) && ($this->uri->segment(6))) {
						redirect(site_url(SITE_AREA .'/content/tags/index/'.$this->uri->segment(5).'/'.$this->uri->segment(6).'/'));
					} elseif($this->uri->segment(5)) {
						redirect(site_url(SITE_AREA . '/content/tags/index/'.$this->uri->segment(5).'/'));
					} else {
						redirect(site_url(SITE_AREA . '/content/tags/index/all/0/'));
					}					
				} else {
					Template::set_message(lang('edit_failure') . $this->tags_model->error, 'error');
				}
			}
		}

		Template::set('records', $records);
		if($id != NULL) {
			$tag_info = $this->tags_model->find($id);
			if($tag_info) {
				Template::set('tags', $tag_info);
			} else {
				redirect(site_url(SITE_AREA. '/content/tags'));
			}
		}		
		Template::set('toolbar_title', 'Manage Tags');
		Template::render();
	}

	//--------------------------------------------------------------------
	// !PRIVATE METHODS
	//--------------------------------------------------------------------

	/**
	 * Summary
	 *
	 * @param String $type Either "insert" or "update"
	 * @param Int	 $id	The ID of the record to update, ignored on inserts
	 *
	 * @return Mixed    An INT id for successful inserts, TRUE for successful updates, else FALSE
	 */
	private function save_tags($type='insert', $id=0)
	{
		if ($type == 'update')
		{
			$_POST['id'] = $id;
		}

		// make sure we only pass in the fields we want
		
		$data = array();
		$data['name']        = strtolower($this->input->post('tags_name'));
		$data['active']      = 1;

		if ($type == 'insert')
		{
			$id = $this->tags_model->insert($data);

			if (is_numeric($id))
			{
				$return = $id;
			}
			else
			{
				$return = FALSE;
			}
		}
		elseif ($type == 'update')
		{
			$return = $this->tags_model->update($id, $data);
		}

		return $return;
	}
	
	/**
	 * Make tag active or inactive
	 * @param number $id
	 */
	public function change_status($id)
	{
		//Return old status
		$this->db->select ( 'active' );
		$this->db->where('id', $id);
		$query = $this->db->get ( 'tags' );
	
		$value = 0; //declare variable to store returned result
	
		//Run loop and store integer value in variable
		foreach($query->result() as $row) {
			$value = $row->active;
		}
	
		//Compare values
		if($value == 0) {
			$data['active'] = 1;
		} else {
			$data['active'] = 0;
		}
		//Update status
		$this->db->where('id', $id);
		$this->db->update('tags', $data);
		redirect(SITE_AREA .'/content/tags/');
		//$this->products_model->update(array('id' => $id), array('active' => 0));
	}
	
	//--------------------------------------------------------------------
	// ACTIVATION METHODS
	//--------------------------------------------------------------------
	/**
	 * Activates selected tag
	 */
	private function _activate($tag_id)
	{
		$this->tag_status($tag_id,1,0);
	
	}
	/**
	 * Deactivates selected tag.
	 */
	private function _deactivate($tag_id)
	{
		$this->tag_status($tag_id,0,0);
	
	}
	
	/**
	 * For bulk update
	 * @param string $tag_id
	 * @param number $status
	 * @param number $supress_email
	 */
	private function tag_status($tag_id = false, $status = 1, $supress_email = 0)
	{
		$supress_email = (isset($supress_email) && $supress_email == 1 ? true : false);
	
		if ($tag_id !== false && $tag_id != -1)
		{
			$result = false;
			$type = '';
			if ($status == 1) {
				$result = $this->tags_model->tag_activation($tag_id);
				$type = lang('bf_action_activate');
			}
			else {
				$result = $this->tags_model->tag_deactivation($tag_id);
				$type = lang('bf_action_deactivate');
			}
	
			$tag = $this->tags_model->find($tag_id);
			//log_activity($this->current_user->id, lang('us_log_status_change') . ': '.$log_name . ' : '.$type."ed", 'users');
			
		}
		else
		{
			Template::set_message(lang('ls_err_no_id'),'error');
		}//end if
	
	}//end tag_status()
	
	

}