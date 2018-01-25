<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Checkout_scan extends CI_Controller 
{
	function __construct()
	{
		parent::__construct();
		
		$this->lang->load('check/checkout');
		
		$this->load->model('check/checkout_model');
	}
	
	public function index()
	{
		$this->load->view('common/header');
		$this->load->view('check/checkout_scan');
		$this->load->view('common/footer');	
	}

	function get_product()
	{
		if($this->input->post('code'))
		{
			$code = $this->input->post('code');
		
			$code = trim($code);		
			
			$this->load->model('catalog/product_model');
			$this->load->model('inventory/inventory_model');
			
			$result = $this->product_model->get_product_by_upc($code);
			
			if(!$result) 
			{
				$result = $this->product_model->get_product_by_sku($code);
			}
			
			if(!$result) 
			{
				$result = $this->product_model->get_product_by_asin($code);
			}
			
			if(!$result) 
			{
				$result = $this->product_model->get_product_by_name($code);
			}
			
			if(!$result)
			{
				$outdata = array(
					'success'   => false,
					'message'   => $this->lang->line('error_product_not_found')
				);
			}
			else
			{
				$product_id = $result['id'];
				
				$inventories = $this->inventory_model->get_inventories_by_product($product_id);

				if(!$inventories)
				{
					$outdata = array(
						'success'   => false,
						'message'   => $this->lang->line('error_inventory_not_found')
					);
				}
				else
				{
					$checkout_locations = array();
					
					foreach($inventories as $inventory)
					{
						$checkout_locations[] = array(
							'location_id'    => $inventory['location_id'],
							'location_name'  => $inventory['location_name']
						);
					}
					
					$product = array(
						'product_id'  		 => $result['id'],
						'upc'         		 => $result['upc'],
						'sku'         		 => $result['sku'],
						'asin'        		 => $result['asin'],
						'name'        		 => $result['name'],
						'checkout_locations' => $checkout_locations
					);
					
					$outdata = array(
						'success'     => true,
						'product'     => $product
					);
				}
			}
		}
		else
		{
			$outdata = array(
				'success'   => false,
				'msg'       => $this->lang->line('error_code_empty')
			);
		}

		echo json_encode($outdata);
		die();
	}
	
	function add_checkout()
	{
		$this->load->library('form_validation');
				
		$this->form_validation->set_rules('status', $this->lang->line('text_status'), 'required');
		$this->form_validation->set_rules('tracking', $this->lang->line('text_tracking'), 'callback_validate_tracking');
		$this->form_validation->set_rules('checkout_product', $this->lang->line('text_checkout_product'), 'callback_validate_checkout_product');
			
		$data = array(
			'tracking'          => $this->input->post('tracking'),
			'status'            => $this->input->post('status'),
			'note'              => '',
			'checkout_products'  => $this->input->post('checkout_product'),
			'checkout_fees'      => array(),
		);
		
		if($this->form_validation->run() == true)
		{
			$this->checkout_model->add_checkout($data);	

			$outdata = array(
				'success'   => true,
				'message'   => $this->lang->line('text_checkout_add_success')
			);			
		}
		else
		{
			$outdata = array(
				'success'   => false,
				'message'   => validation_errors()
			);
		}
	
		echo json_encode($outdata);
		die();
	}
	
	function validate_tracking($tracking)
	{
		if($tracking)
		{
			$result = $this->checkout_model->get_checkout_by_tracking($tracking);
	
			if($result)
			{
				$this->form_validation->set_message('validate_tracking', $this->lang->line('error_tracking_is_used'));
			
				return false;
			}
			else
			{
				return true;
			}
		}
		else
		{
			return true;
		}
	}

	function validate_checkout_product($checkout_products)
	{		
		if($this->input->post('checkout_product'))
		{
			$this->load->model('catalog/product_model');
			$this->load->model('warehouse/location_model');
			$this->load->model('inventory/inventory_model');

			$validated = true;
			
			$checkout_products = $this->input->post('checkout_product');
			
			$error_message = '';
			
			foreach($checkout_products as $checkout_product)
			{
				$product_id   = $checkout_product['product_id'];
				$quantity     = $checkout_product['quantity'];
				$location_id  = $checkout_product['location_id'];
				
				$product = $this->product_model->get_product($product_id);
				
				if(!$quantity || !$location_id || ($quantity < 0))
				{
					if(!$quantity)
					{
						$error_message .= sprintf($this->lang->line('error_checkout_product_quantity_required'), $product['name']);
						$error_message .= '<br>';
						
						if($validated) $validated = false;
					}
					
					if($quantity < 0)
					{
						$error_message .= sprintf($this->lang->line('error_checkout_product_quantity_negative'), $product['name']);
						$error_message .= '<br>';
						
						if($validated) $validated = false;
					}
					
					if(!$location_id)
					{
						$error_message .= $this->lang->line('error_checkout_product_location_required');
						$error_message .= '<br>';
						
						if($validated) $validated = false;
					}
				}
				else
				{
					$inventory = $this->inventory_model->get_inventory_by_location_product($location_id, $product_id);
					
					if($inventory['quantity'] < $quantity)
					{
						$location = $this->location_model->get_location($location_id);

						$error_message .= sprintf($this->lang->line('error_checkout_product_inventory_insufficient'), $product['name'], $location['name'], $inventory['quantity']);
						$error_message .= '<br>';
						
						if($validated) $validated = false;
					}
				}
			}
			
			if(!$validated)
			{
				$this->form_validation->set_message('validate_checkout_product', $error_message);
				
				return false;
			}
			else
			{
				return true;
			}
		}
		else
		{
			$this->form_validation->set_message('validate_checkout_product', $this->lang->line('error_checkout_product_required'));
			
			return false;
		}	
	}
}


