<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Label extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		
		$this->lang->load('sale/sale');
		
		$this->load->model('sale/sale_model');
	}
	
	public function index()
	{
		$data['sale_id'] = $this->input->get('sale_id');
		
		$this->load->view('sale/sale_label', $data);
	}
	
	public function check()
	{
		$this->load->model('sale/sale_model');
		$this->load->model('inventory/inventory_model');
		
		$sale_id = $this->input->post('sale_id');
		
		$sale = $this->sale_model->get_sale($sale_id);
		
		//no shipping provider
		if(empty($sale['shipping_provider']))
		{
			$outdata = array(
				'success'  => false,
				'message'  => $this->lang->line('error_shipping_provider_not_set')
			);
			
			echo json_encode($outdata);
			die();
		}
		
		//no shipping method
		if(empty($sale['shipping_service']))
		{
			$outdata = array(
				'success'  => false,
				'message'  => $this->lang->line('error_shipping_method_not_set')
			);
			
			echo json_encode($outdata);
			die();
		}
		
		//now ok
		$outdata = array(
			'success'  => true
		);
		
		echo json_encode($outdata);
		die();				
	}
	
	public function execute()
	{
		$this->load->model('sale/sale_model');
		$this->load->model('store/store_model');
		$this->load->model('finance/transaction_model');
		
		if($this->input->post('sale_id'))
		{
			$sale_id = $this->input->post('sale_id');
			
			$sale = $this->sale_model->get_sale($sale_id);
			
			$code = $sale['shipping_provider'];
			
			$this->load->model('shipping/'. $code .'_model');

			$result = $this->{$code . '_model'}->generate_sale_label($sale_id);
			
			if(!isset($result['error']))
			{	
				if(!$this->config->item($code . '_debug_mode'))
				{
					//update sale
					$this->sale_model->update_label($sale_id, $result['label_img']);
				
					$this->sale_model->update_tracking($sale_id, $result['tracking']);
					
					//fee
					$store = $this->store_model->get_store($sale['store_id']);	
					
					if($store)
					{
						$client_id = $store['client_id'];
						
						if($this->config->item($code . '_fee_type'))
						{
							$ratio = $this->get_client_fee_value($client_id, $code);
							
							$markup = $result['amount'] * $ratio;
						}
						else 
						{
							$markup = $this->get_client_fee_value($client_id, $code);
						}					
							
						$amount = $result['amount'] + $markup;	
							
						if($sale['store_sale_id']) 
							$comment = sprintf($this->lang->line('text_label_fee_note1'), $sale_id, $sale['store_sale_id']);
						else
							$comment = sprintf($this->lang->line('text_label_fee_note2'), $sale_id);
							
						$transaction_data = array(					
							'client_id'		  => $client_id,
							'type'		      => 'sale',
							'type_id'         => $sale_id,
							'cost'            => $result['amount'],
							'markup'          => $markup,
							'amount'   		  => $amount,
							'comment'         => $comment
						);
											
						$this->transaction_model->add_transaction($transaction_data);							
					}
				}
				
				//display info
				$data['label_img'] = base_url() . $result['label_img'];
				
				$data['width']       = $this->config->item('config_label_width');
				$data['width_type']  = $this->config->item('config_label_width_type');
				$data['margin_top']  = $this->config->item('config_label_posy');
				
				$this->load->view('sale/label_success', $data);
			}
			else 
			{
				$data['message'] = $result['error'];
				
				$this->load->view('sale/label_error', $data);
			}
		}
	}
	
	public function execute_d()
	{
		$this->load->library('pdf');
		$this->load->library('file');
		$this->load->library('printnode');
		
		$this->load->model('sale/sale_model');
		$this->load->model('store/store_model');
		$this->load->model('finance/transaction_model');
		
		if($this->input->post('sale_id'))
		{
			$sale_id = $this->input->post('sale_id');
			
			$sale = $this->sale_model->get_sale($sale_id);
			
			$code = $sale['shipping_provider'];
			
			$this->load->model('shipping/'. $code .'_model');

			$result = $this->{$code . '_model'}->generate_sale_label($sale_id);
			
			if(!isset($result['error']))
			{	
				if(!$this->config->item($code . '_debug_mode'))
				{
					//update sale
					$this->sale_model->update_label($sale_id, $result['label_img']);
					
					$this->sale_model->update_tracking($sale_id, $result['tracking']);
					
					//fee
					$store = $this->store_model->get_store($sale['store_id']);	
					
					if($store)
					{
						$client_id = $store['client_id'];
						
						if($this->config->item($code . '_fee_type'))
						{
							$ratio = $this->get_client_fee_value($client_id, $code);
							
							$markup = $result['amount'] * $ratio;
						}
						else 
						{
							$markup = $this->get_client_fee_value($client_id, $code);
						}					
							
						$amount = $result['amount'] + $markup;	

						if($sale['store_sale_id']) 
							$comment = sprintf($this->lang->line('text_label_fee_note1'), $sale_id, $sale['store_sale_id']);
						else
							$comment = sprintf($this->lang->line('text_label_fee_note2'), $sale_id);						
										
						$transaction_data = array(					
							'client_id'		  => $client_id,
							'type'		      => 'sale',
							'type_id'         => $sale_id,
							'cost'            => $result['amount'],
							'markup'          => $markup,
							'amount'   		  => $amount,
							'comment'         => $comment
						);
											
						$this->transaction_model->add_transaction($transaction_data);							
					}
				}
				
				//submit print job
				$image_path = FCPATH . $result['label_img'];
				
				$filename = $this->file->get_filename($image_path);
				
				$dest_path = FCPATH . 'assets/pdf/' . $filename . '.pdf';
				
				$attrs = array(
					'position_x'   => $this->config->item('config_printnode_position_x'),
					'position_y'   => $this->config->item('config_printnode_position_y'),
					'width'        => $this->config->item('config_printnode_width')
				);
												
				if($this->pdf->convert_image($image_path, $dest_path, $attrs))
				{
					$this->printnode->submit_print_job($dest_path);
					
					$outdata = array(
						'success'   => true,
						'tracking'  => $result['tracking']
					);
				}
				else
				{
					$outdata = array(
						'success'   => false,
						'message'   => $this->lang->line('error_not_able_convert_image_to_pdf')
					);
				}
			}
			else 
			{
				$outdata = array(
					'success'   => false,
					'message'   => $result['error']
				);
			}
			
			echo json_encode($outdata);
			die();	
		}
	}
	
	private function get_client_fee_value($client_id, $shipping_provider)
	{		
		$client_fee_value = $this->config->item($shipping_provider . '_fee_value');
		
		$client_fees = $this->config->item($shipping_provider . '_client_fee');
		
		if($client_fees)
		{
			foreach($client_fees as $client_fee)
			{
				if($client_fee['client_id'] == $client_id)
				{
					$client_fee_value = $client_fee['fee'];
					break;
				}
			}
		}
		
		return $client_fee_value;
	}
}


















