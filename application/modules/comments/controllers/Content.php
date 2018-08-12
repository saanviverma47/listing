<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
 
 
 
 
 
 
 
 
 
 
 
 

/**
 * Comments controller
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

		$this->auth->restrict('Comments.Content.View');
		$this->load->model('comments_model', null, true);
				
		//LOAD RATINGS JAVASCRIPT AND CSS FILE
		Assets::add_module_js('comments', '../ratings/js/star-rating.js');
		Assets::add_module_js('comments', '../ratings/js/star-rating.min.js');
		Assets::add_module_css('comments', '../ratings/css/star-rating.css');
		Assets::add_module_css('comments', '../ratings/css/star-rating.min.css');
		
		Template::set_block('sub_nav', 'content/_sub_nav');
	}

	/**
	 * Displays a list of comments to the user.
	 *
	 * @return void
	 */
	public function index($filter='all', $offset=0)
	{
		// Do we have any actions?
        if ($action = $this->input->post('submit')) {
            $checked = $this->input->post('checked');

            switch(strtolower($action)) {
                case 'approve':
                    $this->change_status($checked, 1);
                    break;
                    
                case 'disapprove':
                   	$this->change_status($checked, 0);
                   	break;
                    
                case 'flag':
                    $this->change_status($checked, 2);
                    break;
                    
                case 'mark as spam':
                    $this->change_status($checked, 3);
                    break;
                
                case 'reject':
                  	$this->change_status($checked, 4);
                  	break;
                    
                case 'delete':
                    $this->delete($checked);
                    break;
                
                case 'purge':
                  	$this->purge($checked);
                   	break;
                
                case 'restore':
                	$this->restore($checked);
                	break;
            }
        }

		// Actions done, now display the view
		$where = array('comments.deleted' => 0);

		// Filters
		$filter_type = $filter;
	
		switch($filter_type) {
			case 'inactive':
				$where['comments.status'] = 0;
				break;
				
			case 'active':
				$where['comments.status'] = 1;
				break;
			
			case 'flagged':
				$where['comments.status'] = 2;
				break;

			case 'spammed':
				$where['comments.status'] = 3;
				break;
		
			case 'rejected':
				$where['comments.status'] = 4;
				break;

			case 'deleted':
				$where['comments.deleted'] = 1;
				break;
			
			case 'all':
				// Nothing to do
				break;
				

			default:
				show_404("comments/index/$filter/");
		}

		if (isset($_POST['search'])) {
			$searchterm = $this->input->post('search');
			$this->db->or_like(array(
					'comments.id' => $searchterm,
					'comments.username' => $searchterm,
					'comments.title' => $searchterm,
					'comments.created_on' => $searchterm,
					'listings.title' => $searchterm
			));
		}
		
		// Fetch the users to display
		$this->comments_model->limit($this->limit, $offset)->where($where);
		$records = $this->comments_model->get_comments();

		Template::set('records', $records);
		
		// Pagination
		$this->load->library('pagination');
		
		$this->comments_model->where($where);
		$total_comments = $this->comments_model->count_all();
		
		$this->pager['base_url'] = site_url(SITE_AREA ."/content/comments/index/$filter/");
		$this->pager['total_rows'] = $total_comments;
		$this->pager['per_page'] = $this->limit;
		$this->pager['uri_segment']	= 6;
		
		$this->pagination->initialize($this->pager);
		
		Template::set('index_url', site_url(SITE_AREA .'/content/comments/index/') .'/');
		Template::set('filter_type', $filter_type);

		Template::set('toolbar_title', 'Manage Comments');
		Template::render();
	}

	/**
	 * Allow admin to change comment status
	 * @param string $comments
	 * @param number $status
	 */
	private function change_status($comments=false, $status = 1)
	{
		if (!$comments) {
			return;
		}
		$this->auth->restrict('Comments.Content.Edit');
		if ($this->comments_model->update_comment($comments, array('status' => $status))) {
			Template::set_message(lang('comments_status_success'), 'success');
		}
		else {
			Template::set_message(lang('comments_status_error'). $this->comments_model->error, 'error');
		}		
	}
	
	/**
	 * Allows editing of Comments data.
	 *
	 * @return void
	 */
	public function edit()
	{
		$id = $this->uri->segment(5);

		if (empty($id)) {
			Template::set_message(lang('comments_invalid_id'), 'error');
			redirect(SITE_AREA .'/content/comments');
		}

		if (isset($_POST['save'])) {
			$this->auth->restrict('Comments.Content.Edit');

			if ($this->save_comments('update', $id)) {
				// Log the activity
				log_activity($this->current_user->id, lang('act_edit_record') .': '. $id .' : '. $this->input->ip_address(), 'comments');

				Template::set_message(lang('edit_success'), 'success');
				redirect(site_url(SITE_AREA .'/content/comments/'));
			} else {
				Template::set_message(lang('edit_failure') . $this->comments_model->error, 'error');
			}
		}
		else if (isset($_POST['delete']))
		{
			$this->auth->restrict('Comments.Content.Delete');

			if ($this->comments_model->delete($id)) {
				// Log the activity
				log_activity($this->current_user->id, lang('act_delete_record') .': '. $id .' : '. $this->input->ip_address(), 'comments');

				Template::set_message(lang('delete_success'), 'success');

				redirect(SITE_AREA .'/content/comments');
			} else {
				Template::set_message(lang('delete_failure') . $this->comments_model->error, 'error');
			}
		}
		Template::set('comments', $this->comments_model->get_comment($id));
		Template::set('toolbar_title', lang('edit') .' '.lang('label_comment'));
		Template::set_view('content/comments_edit.php');
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
	private function save_comments($type='update', $id=0)
	{
		$_POST['id'] = $id;
		$data = array();
		$data['comment']        = $this->input->post('comments_comment');
		$data['status']        = $this->input->post('comments_status');

		$return = $this->comments_model->update($id, $data);
		return $return;
	}

	/**
	 * Delete a comment or group of comments
	 * @access private
	 * @param int $id User to delete
	 * @return void
	 */
	private function delete($id)
	{
		if ($this->comments_model->delete_comment($id)) {
			Template::set_message(lang('delete_success'), 'success');
		}
		else {
			Template::set_message(lang('delete_failure'). $this->comments_model->error, 'error');
		}
	
	}//end _delete()
		
	/**
	 * Purge the selected comments which are already marked as deleted
	 * @param int $id Comment to purge
	 */
	private function purge($id)
	{
		$this->comments_model->delete_comment($id, TRUE);
		Template::set_message(lang('comments_action_purged'), 'success');
	}//end _purge()
	
	
	/**
	 * Restore the deleted comment
	 */
	private function restore($id)
	{
		if ($this->comments_model->update_comment($id, array('comments.deleted'=>0))) {
			Template::set_message(lang('comments_restored_success'), 'success');
		}
		else {
			Template::set_message(lang('comments_restored_error'). $this->comments_model->error, 'error');
		}
		
	
	}//end restore()
}