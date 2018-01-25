<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Balance extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		
		$this->lang->load('finance/balance');
		
		$this->load->model('finance/balance_model');
	}
	
	function index()
	{		                 	
 		if($this->input->get('filter_client'))
		{
			$filter_client = $this->input->get('filter_client');
		} 
		else 
		{
			$filter_client = '';
		}
		
		if($this->input->get('filter_amount'))
		{
			$filter_amount = $this->input->get('filter_amount');
		} 
		else 
		{
			$filter_amount = '';
		}
		
		if($this->input->get('sort')) 
		{
			$sort = $this->input->get('sort');
		} 
		else 
		{
			$sort = 'balance.date_added';
		}

		if($this->input->get('order')) 
		{
			$order = $this->input->get('order');
		} 
		else 
		{
			$order = 'DESC';
		}
		
		if($this->input->get('limit'))
		{
			$limit = $this->input->get('limit');
		} 
		else 
		{
			$limit = $this->config->item('config_page_limit');
		}
		
		if($this->input->get('page')) 
		{
			$page = $this->input->get('page');
		} 
		else 
		{
			$page = 1;
		}
		
		$filter_data = array(
			'filter_client'    => $filter_client,
			'filter_amount'    => $filter_amount,
			'sort'             => $sort,
			'order'            => $order,
			'start'            => ($page - 1) * $limit,
			'limit'            => $limit
		);
		
		$balances = $this->balance_model->get_balances($filter_data);	
		$balance_total = $this->balance_model->get_balance_total($filter_data);
		
		$data['balances'] = array();
		
		if($balances) 
		{
			foreach($balances as $balance)
			{	
				$data['balances'][] = array(
					'id'        => $balance['id'],
					'name' 		=> $balance['name'],
					'amount'    => $balance['amount']
				);
			}
		}
		
		$url = '';
		
		if($this->input->get('filter_client')) 
		{
			$url .= '&filter_client=' . $this->input->get('filter_client');
		}
		
		if($this->input->get('filter_amount')) 
		{
			$url .= '&filter_amount=' . $this->input->get('filter_amount');
		}
		
		if($this->input->get('sort')) 
		{
			$url .= '&sort=' . $this->input->get('sort');
		}
		
		if ($this->input->get('limit')) 
		{
			$url .= '&limit=' . $this->input->get('limit');
		}
		
		if($this->input->get('order')) 
		{
			$url .= '&order=' . $this->input->get('order');
		}
	
		$this->pagination->total  = $balance_total;
		$this->pagination->page   = $page;
		$this->pagination->limit  = $limit;
		$this->pagination->url    = base_url().'finance/balance?page={page}'.$url;
		$data['pagination']       = $this->pagination->render();
		$data['results']          = sprintf($this->lang->line('text_pagination'), ($balance_total) ? (($page - 1) * $limit) + 1 : 0, ((($page - 1) * $limit) > ($balance_total - $limit)) ? $balance_total : ((($page - 1) * $limit) + $limit), $balance_total, ceil($balance_total / $limit));

		$url = '';
		
		if($this->input->get('filter_client')) 
		{
			$url .= '&filter_client=' . $this->input->get('filter_client');
		}
		
		if($this->input->get('filter_amount')) 
		{
			$url .= '&filter_amount=' . $this->input->get('filter_amount');
		}
		
		if($this->input->get('sort')) 
		{
			$url .= '&sort=' . $this->input->get('sort');
		}
		
		if($this->input->get('order')) 
		{
			$url .= '&order=' . $this->input->get('order');
		}
		
		$data['limit_10']  = base_url().'finance/balance?limit=10'.$url;
		$data['limit_15']  = base_url().'finance/balance?limit=15'.$url;
		$data['limit_50']  = base_url().'finance/balance?limit=50'.$url;
		$data['limit_100'] = base_url().'finance/balance?limit=100'.$url;
	
		$url = '';
		
		if($this->input->get('filter_client')) 
		{
			$url .= '&filter_client=' . $this->input->get('filter_client');
		}
		
		if($this->input->get('filter_amount')) 
		{
			$url .= '&filter_amount=' . $this->input->get('filter_amount');
		}
			
		if($this->input->get('limit')) 
		{
			$url .= '&limit=' . $this->input->get('limit');
		}
		
		if($order == 'ASC') 
		{
			$url .= '&order=DESC';
		} 
		else 
		{
			$url .= '&order=ASC';
		}
		
		$data['sort_client']  = base_url().'finance/balance?sort=name'.$url;
		$data['sort_amount'] = base_url().'finance/balance?sort=balance.amount'.$url;

		$url = '';
		
		if ($this->input->get('limit')) 
		{
			$url .= '?limit=' . $this->input->get('limit');
		}
		else
		{
			$url .= '?limit=' . $this->config->item('config_page_limit');
		}
		
		if($this->input->get('sort')) 
		{
			$url .= '&sort=' . $this->input->get('sort');
		}
		
		$data['filter_url'] = base_url().'finance/balance'.$url;
	
		$data['sort']  = $sort;
		$data['order'] = $order;
		$data['limit'] = $limit;
		
		$data['filter_client'] = $filter_client;
		$data['filter_amount'] = $filter_amount;
		
		$this->load->view('common/header');
		$this->load->view('finance/balance_list', $data);
		$this->load->view('common/footer');
	}
}


