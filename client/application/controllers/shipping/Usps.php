<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Usps extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		
		$this->lang->load('shipping/usps');
		
		$this->load->model('setting/setting_model');
		
		$this->load->library('form_validation');
	}
	
	public function index()
	{
		if(($this->input->server('REQUEST_METHOD') == 'POST') && $this->validate())
		{
			$data = array(
				'usps_user_id'               => $this->input->post('usps_user_id'),
				'usps_time_zone'             => $this->input->post('usps_time_zone'),
				'usps_owner'                 => $this->input->post('usps_owner'),
				'usps_first_name'            => $this->input->post('usps_first_name'),
				'usps_last_name'         	 => $this->input->post('usps_last_name'),
				'usps_company'     			 => $this->input->post('usps_company'),
				'usps_phone'     			 => $this->input->post('usps_phone'),
				'usps_street'        		 => $this->input->post('usps_street'),
				'usps_street2'     			 => $this->input->post('usps_street2'),
				'usps_city'     		     => $this->input->post('usps_city'),
				'usps_state'     			 => $this->input->post('usps_state'),
				'usps_country'     			 => $this->input->post('usps_country'),
				'usps_postcode'     		 => $this->input->post('usps_postcode'),
				'usps_status'     			 => $this->input->post('usps_status'),
				'usps_sort_order'            => $this->input->post('usps_sort_order'),
				'usps_stamps_username'       => $this->input->post('usps_stamps_username'),
				'usps_stamps_password'       => $this->input->post('usps_stamps_password'),
				'usps_stamps_integration_id' => $this->input->post('usps_stamps_integration_id'),
				'usps_stamps_wsdl_file'      => $this->input->post('usps_stamps_wsdl_file'),
				'usps_service'               => $this->input->post('usps_service')
			);
			
			$this->setting_model->edit_setting('usps', $data);
			
			$this->session->set_flashdata('success', $this->lang->line('text_usps_edit_success'));
			
			redirect(base_url() . 'extension/shipping', 'refresh');
		}
		
		if($this->input->post('usps_user_id')) 
		{
			$data['usps_user_id'] = $this->input->post('usps_user_id');
		} 
		else 
		{
			$data['usps_user_id'] = $this->config->item('usps_user_id');
		}
		
		if($this->input->post('usps_time_zone')) 
		{
			$data['usps_time_zone'] = $this->input->post('usps_time_zone');
		} 
		else 
		{
			$data['usps_time_zone'] = $this->config->item('usps_time_zone');
		}
		
		if($this->input->post('usps_owner')) 
		{
			$data['usps_owner'] = $this->input->post('usps_owner');
		} 
		else 
		{
			$data['usps_owner'] = $this->config->item('usps_owner');
		}
		
		if($this->input->post('usps_first_name')) 
		{
			$data['usps_first_name'] = $this->input->post('usps_first_name');
		} 
		else 
		{
			$data['usps_first_name'] = $this->config->item('usps_first_name');
		}
		
		if($this->input->post('usps_last_name')) 
		{
			$data['usps_last_name'] = $this->input->post('usps_last_name');
		} 
		else 
		{
			$data['usps_last_name'] = $this->config->item('usps_last_name');
		}
		
		if($this->input->post('usps_company')) 
		{
			$data['usps_company'] = $this->input->post('usps_company');
		} 
		else 
		{
			$data['usps_company'] = $this->config->item('usps_company');
		}
		
		if($this->input->post('usps_phone')) 
		{
			$data['usps_phone'] = $this->input->post('usps_phone');
		} 
		else 
		{
			$data['usps_phone'] = $this->config->item('usps_phone');
		}
		
		if($this->input->post('usps_street')) 
		{
			$data['usps_street'] = $this->input->post('usps_street');
		} 
		else 
		{
			$data['usps_street'] = $this->config->item('usps_street');
		}
		
		if($this->input->post('usps_street2')) 
		{
			$data['usps_street2'] = $this->input->post('usps_street2');
		} 
		else 
		{
			$data['usps_street2'] = $this->config->item('usps_street2');
		}
		
		if($this->input->post('usps_city')) 
		{
			$data['usps_city'] = $this->input->post('usps_city');
		} 
		else 
		{
			$data['usps_city'] = $this->config->item('usps_city');
		}
		
		if($this->input->post('usps_state')) 
		{
			$data['usps_state'] = $this->input->post('usps_state');
		} 
		else 
		{
			$data['usps_state'] = $this->config->item('usps_state');
		}
		
		if($this->input->post('usps_country')) 
		{
			$data['usps_country'] = $this->input->post('usps_country');
		} 
		else 
		{
			$data['usps_country'] = $this->config->item('usps_country');
		}
		
		if($this->input->post('usps_postcode')) 
		{
			$data['usps_postcode'] = $this->input->post('usps_postcode');
		} 
		else 
		{
			$data['usps_postcode'] = $this->config->item('usps_postcode');
		}
		
		if($this->input->post('usps_status')) 
		{
			$data['usps_status'] = $this->input->post('usps_status');
		} 
		else 
		{
			$data['usps_status'] = $this->config->item('usps_status');
		}
		
		if($this->input->post('usps_sort_order')) 
		{
			$data['usps_sort_order'] = $this->input->post('usps_sort_order');
		} 
		else 
		{
			$data['usps_sort_order'] = $this->config->item('usps_sort_order');
		}
		
		
		if($this->input->post('usps_stamps_username')) 
		{
			$data['usps_stamps_username'] = $this->input->post('usps_stamps_username');
		} 
		else 
		{
			$data['usps_stamps_username'] = $this->config->item('usps_stamps_username');
		}
		
		if($this->input->post('usps_stamps_password')) 
		{
			$data['usps_stamps_password'] = $this->input->post('usps_stamps_password');
		} 
		else 
		{
			$data['usps_stamps_password'] = $this->config->item('usps_stamps_password');
		}
		
		if($this->input->post('usps_stamps_integration_id')) 
		{
			$data['usps_stamps_integration_id'] = $this->input->post('usps_stamps_integration_id');
		} 
		else 
		{
			$data['usps_stamps_integration_id'] = $this->config->item('usps_stamps_integration_id');
		}
		
		if($this->input->post('usps_stamps_wsdl_file')) 
		{
			$data['usps_stamps_wsdl_file'] = $this->input->post('usps_stamps_wsdl_file');
		} 
		else 
		{
			$data['usps_stamps_wsdl_file'] = $this->config->item('usps_stamps_wsdl_file');
		}
				
		if($this->input->post('usps_service')) 
		{
			$data['usps_services'] = $this->input->post('usps_service');
		} 
		else 
		{
			$data['usps_services'] = $this->config->item('usps_service');
		}
		
		$data['error'] = validation_errors();
		
		$this->load->view('common/header');
		$this->load->view('shipping/usps', $data);
		$this->load->view('common/footer');
	}
	
	protected function validate() 
	{
		$this->form_validation->set_rules('usps_user_id', $this->lang->line('text_usps_user_id'), 'required');
		$this->form_validation->set_rules('usps_time_zone', $this->lang->line('text_usps_time_zone'), 'required');
		$this->form_validation->set_rules('usps_owner', $this->lang->line('text_usps_owner'), 'required');
		$this->form_validation->set_rules('usps_first_name', $this->lang->line('text_usps_first_name'), 'required');
		$this->form_validation->set_rules('usps_last_name', $this->lang->line('text_usps_last_name'), 'required');
		$this->form_validation->set_rules('usps_company', $this->lang->line('text_usps_company'), 'required');
		$this->form_validation->set_rules('usps_phone', $this->lang->line('text_usps_phone'), 'required');
		$this->form_validation->set_rules('usps_street', $this->lang->line('text_usps_street'), 'required');
		$this->form_validation->set_rules('usps_street2', $this->lang->line('text_usps_street2'), 'required');
		$this->form_validation->set_rules('usps_city', $this->lang->line('text_usps_city'), 'required');
		$this->form_validation->set_rules('usps_state', $this->lang->line('text_usps_state'), 'required');
		$this->form_validation->set_rules('usps_country', $this->lang->line('text_usps_country'), 'required');
		$this->form_validation->set_rules('usps_postcode', $this->lang->line('text_usps_postcode'), 'required');		
		$this->form_validation->set_rules('usps_status', $this->lang->line('text_usps_status'), 'required');
		$this->form_validation->set_rules('usps_sort_order', $this->lang->line('text_usps_sort_order'), 'required');
		$this->form_validation->set_rules('usps_stamps_username', $this->lang->line('text_usps_stamps_username'), 'required');
		$this->form_validation->set_rules('usps_stamps_password', $this->lang->line('text_usps_stamps_password'), 'required');
		$this->form_validation->set_rules('usps_stamps_integration_id', $this->lang->line('text_usps_stamps_integration_id'), 'required');
		$this->form_validation->set_rules('usps_stamps_wsdl_file', $this->lang->line('text_usps_stamps_wsdl_file'), 'required');

		return $this->form_validation->run();
	}
}


