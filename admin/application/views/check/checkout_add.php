<?php echo $header; ?>
<div class="row wrapper border-bottom white-bg page-heading">
  <div class="col-lg-12">
	<h2><?php echo $this->lang->line('text_checkout_add'); ?></h2>
	<ol class="breadcrumb">
	  <li><a href="<?php echo base_url(); ?>"><?php echo $this->lang->line('text_home'); ?></a></li>
	  <li><a href="<?php echo base_url(); ?>check/checkout"><?php echo $this->lang->line('text_checkout'); ?></a></li>
	  <li class="active"><strong><?php echo $this->lang->line('text_checkout_add'); ?></strong></li>
	</ol>
  </div>
  <div class="button-group tooltip-demo">
    <button data-toggle="tooltip" data-placement="top" title="<?php echo $this->lang->line('text_save'); ?>" class="btn btn-primary btn-submit" onclick="$('form').submit()"><i class="fa fa-save"></i></button>
    <a href="<?php echo base_url(); ?>check/checkout" data-toggle="tooltip" data-placement="top" title="<?php echo $this->lang->line('text_cancel'); ?>" class="btn btn-default btn-return"><i class="fa fa-reply"></i></a>
  </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
  <div class="row">
	<div class="col-lg-12">
	  <?php if($error) { ?>
        <div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button><?php echo $error; ?></div>
      <?php } ?>
      <div id="alert-error" class="alert alert-danger" style="display:none;"><span></span><button type="button" class="close" onclick="$('#alert-error').hide()">&times;</button></div>
	</div>
  </div>
  <div class="row">
    <div class="col-lg-12">
	<form method="post" class="form-horizontal">
      <div class="tabs-container">
	    <ul class="nav nav-tabs">
		  <li class="active"><a data-toggle="tab" href="#general"><?php echo $this->lang->line('tab_general'); ?></a></li>
		  <li class=""><a data-toggle="tab" href="#shipping"><?php echo $this->lang->line('tab_shipping'); ?></a></li>
		  <li class=""><a data-toggle="tab" href="#fee"><?php echo $this->lang->line('tab_fee'); ?></a></li>
		  <li class=""><a data-toggle="tab" href="#note"><?php echo $this->lang->line('tab_note'); ?></a></li>
		</ul>
		<div class="tab-content">
		  <div id="general" class="tab-pane active">
			<div class="panel-body tab-panel">
			  <div class="container-fluid">
			    <div class="row">
				  <div class="col-lg-7">
				    <div class="form-group">
					  <label class="col-sm-2 control-label"><?php echo $this->lang->line('entry_sale_id'); ?></label>
					  <div class="col-sm-10">
					    <div class="input-group">
					      <span class="input-group-addon">#</span>
						  <input type="text" name="sale_id" value="<?php echo $sale_id; ?>" class="form-control">
					    </div>
					  </div>
				    </div>
				    <div class="hr-line-dashed"></div>
				    <div class="form-group">
					  <label class="col-sm-2 control-label"><?php echo $this->lang->line('entry_tracking'); ?></label>
					  <div class="col-sm-10"><input name="tracking" value="<?php echo $tracking; ?>" class="form-control" ></div>
				    </div>
				    <div class="hr-line-dashed"></div>
					<div class="form-group">
					  <label class="col-sm-2 control-label"><?php echo $this->lang->line('entry_status'); ?></label>
					  <div class="col-sm-10">
					    <select name="status" class="form-control">
						  <?php if($status == 1) { ?>
						  <option value="1" selected><?php echo $this->lang->line('text_pending'); ?></option>
						  <option value="2"><?php echo $this->lang->line('text_completed'); ?></option>
						  <?php } else if($status == 2) { ?>
						  <option value="1"><?php echo $this->lang->line('text_pending'); ?></option>
						  <option value="2" selected><?php echo $this->lang->line('text_completed'); ?></option>
						  <?php } else { ?>
						  <option value="1"><?php echo $this->lang->line('text_pending'); ?></option>
						  <option value="2"><?php echo $this->lang->line('text_completed'); ?></option>
						  <?php } ?>
					    </select>
					  </div>
				    </div>
					<div class="hr-line-dashed"></div>
				  </div>
				  <div class="col-lg-5">
				    <div class="code-box">
					  <input name="code" placeholder="<?php echo $this->lang->line('text_code_hint'); ?>" class="form-control">
					</div>
				  </div>
			    </div>
			    <div class="row">
				  <div class="col-lg-12">     
				    <table id="checkout-product" class="table table-bordered">
					  <thead>
					    <tr>
						  <th style="width: 22%"><?php echo $this->lang->line('column_product_name'); ?></th>
						  <th style="width: 15%"><?php echo $this->lang->line('column_upc'); ?></th>
						  <th style="width: 15%"><?php echo $this->lang->line('column_sku'); ?></th>
						  <th style="width: 12%"><?php echo $this->lang->line('column_quantity'); ?></th>
						  <th style="width: 18%"><?php echo $this->lang->line('column_location'); ?></th>
						  <th></th>
					    </tr>
					  </thead>
					  <tbody>
					    <?php $checkout_product_row = 0; ?>
					    <?php if($checkout_products) { ?>
						  <?php foreach($checkout_products as $checkout_product) { ?>
						  <tr id="row<?php echo $checkout_product_row; ?>">
						  <td class="text-left"><input name="checkout_product[<?php echo $checkout_product_row; ?>][product_id]" type="hidden" value="<?php echo $checkout_product['product_id']; ?>" class="product_id"><div style="text-align:left;"><?php echo $checkout_product['name']; ?></div></td>
						  <td class="text-left"><?php echo $checkout_product['upc']; ?></td>
						  <td class="text-left"><?php echo $checkout_product['sku']; ?></td>
						  <td><input class="form-control text-center quantity" name="checkout_product[<?php echo $checkout_product_row; ?>][quantity]" value="<?php echo $checkout_product['quantity']; ?>" onClick="this.select();"></td>
						  <td>
						    <select name="checkout_product[<?php echo $checkout_product_row; ?>][inventory_id]" class="form-control">
							  <?php foreach($checkout_product['inventories'] as $inventory) { ?>
							    <?php if($inventory['inventory_id'] == $checkout_product['inventory_id']) { ?>
								<option value="<?php echo $inventory['inventory_id']; ?>" selected><?php echo $inventory['location_name']; ?></option>
								<?php } else { ?>
								<option value="<?php echo $inventory['inventory_id']; ?>"><?php echo $inventorys['location_name']; ?></option>
								<?php } ?>
							  <?php } ?>
							</select>
						  </td> 
						  <td class="text-center"><button type="button" class="btn btn-danger btn-delete"><i id="<?php echo $checkout_product_row; ?>" class="fa fa-minus-circle"></i></button></td>
						  <?php $checkout_product_row ++; ?>
						  <?php } ?>
					    <?php } ?>
					  </tbody>
				    </table>  
				  </div>
		        </div> 
              </div>
            </div>	
          </div>
		  <div id="shipping" class="tab-pane">
		    <div class="panel-body">
			  <div class="form-group">
			    <label class="col-sm-2 control-label"><?php echo $this->lang->line('entry_length'); ?></label>
			    <div class="col-sm-10"><input type="text" name="length" value="<?php echo $length; ?>" class="form-control"></div>
			  </div>
			  <div class="hr-line-dashed"></div>
			  <div class="form-group">
			    <label class="col-sm-2 control-label"><?php echo $this->lang->line('entry_width'); ?></label>
			    <div class="col-sm-10"><input type="text" name="width" value="<?php echo $width; ?>" class="form-control"></div>
			  </div>
			  <div class="hr-line-dashed"></div>
			  <div class="form-group">
			    <label class="col-sm-2 control-label"><?php echo $this->lang->line('entry_height'); ?></label>
			    <div class="col-sm-10"><input type="text" name="height" value="<?php echo $height; ?>" class="form-control"></div>
			  </div> 
			  <div class="hr-line-dashed"></div>
			  <div class="form-group">
			    <label class="col-sm-2 control-label"><?php echo $this->lang->line('entry_length_class'); ?></label>
			    <div class="col-sm-10">
				  <select name="length_class_id" class="form-control">
				    <?php if($length_class_id) { ?>
					  <?php foreach($length_classes as $length_class) { ?>
					    <?php if($length_class['id'] == $length_class_id) { ?>
					    <option value="<?php echo $length_class['id']; ?>" selected><?php echo $length_class['unit']; ?></option>
					    <?php } else { ?>
					    <option value="<?php echo $length_class['id']; ?>"><?php echo $length_class['unit']; ?></option>
					  <?php } ?>
				    <?php } ?>
				    <?php } else { ?>
					  <?php foreach($length_classes as $length_class) { ?>
					    <?php if($length_class['id'] == $this->config->item('config_length_class_id')) { ?>
					    <option value="<?php echo $length_class['id']; ?>" selected><?php echo $length_class['unit']; ?></option>
					    <?php } else { ?>
					    <option value="<?php echo $length_class['id']; ?>"><?php echo $length_class['unit']; ?></option>
					    <?php } ?>
					  <?php } ?>
				    <?php } ?>
				  </select>
			    </div>
			  </div>
			  <div class="hr-line-dashed"></div>
			  <div class="form-group">
			    <label class="col-sm-2 control-label"><?php echo $this->lang->line('entry_weight'); ?></label>
			    <div class="col-sm-10"><input type="text" name="weight" value="<?php echo $weight; ?>" class="form-control"></div>
			  </div>
			  <div class="hr-line-dashed"></div>
			  <div class="form-group">
			    <label class="col-sm-2 control-label"><?php echo $this->lang->line('entry_weight_class'); ?></label>
			    <div class="col-sm-10">
				  <select name="weight_class_id" class="form-control">
				    <?php if($weight_class_id) { ?>
					  <?php foreach($weight_classes as $weight_class) { ?>
					    <?php if($weight_class['id'] == $weight_class_id) { ?>
					    <option value="<?php echo $weight_class['id']; ?>" selected><?php echo $weight_class['unit']; ?></option>
					    <?php } else { ?>
					    <option value="<?php echo $weight_class['id']; ?>"><?php echo $weight_class['unit']; ?></option>
					  <?php } ?>
				    <?php } ?>
				    <?php } else { ?>
					  <?php foreach($weight_classes as $weight_class) { ?>
					    <?php if($weight_class['id'] == $this->config->item('config_weight_class_id')) { ?>
					    <option value="<?php echo $weight_class['id']; ?>" selected><?php echo $weight_class['unit']; ?></option>
					    <?php } else { ?>
					    <option value="<?php echo $weight_class['id']; ?>"><?php echo $weight_class['unit']; ?></option>
					    <?php } ?>
					  <?php } ?>
				    <?php } ?>
				  </select>
			    </div>
			  </div>				
			  <div class="hr-line-dashed"></div> 
			  <div class="form-group">
			    <label class="col-sm-2 control-label"><?php echo $this->lang->line('entry_shipping_provider'); ?></label>
			    <div class="col-sm-10">
				  <select name="shipping_provider" class="form-control">
				    <option value=""></option>
				    <?php foreach($shipping_providers as $provider) { ?>
					  <?php if($provider['code'] == $shipping_provider) { ?>
					  <option value="<?php echo $provider['code']; ?>" selected><?php echo $provider['name']; ?></option>
					  <?php } else { ?>
					  <option value="<?php echo $provider['code']; ?>"><?php echo $provider['name']; ?></option>
					  <?php } ?>
				    <?php } ?>
				  </select>
			    </div>
			  </div> 
			  <div class="hr-line-dashed"></div>
			  <div class="form-group">
			    <label class="col-sm-2 control-label"><?php echo $this->lang->line('entry_shipping_service'); ?></label>
			    <div class="col-sm-10">
				  <select name="shipping_service" class="form-control">
				    <option value=""></option>
				    <?php foreach($shipping_services as $service) { ?>
				    <?php if($service['code'] == $shipping_service) { ?>
				    <option value="<?php echo $service['code']; ?>" selected><?php echo $service['name']; ?></option>
				    <?php } else { ?>
				    <option value="<?php echo $service['code']; ?>"><?php echo $service['name']; ?></option>
				    <?php } ?>
				    <?php } ?>
				  </select>
			    </div>
			  </div>
			  <div class="hr-line-dashed"></div>
		    </div>
		  </div>
		  <div id="fee" class="tab-pane">
			<div class="panel-body">
			  <div class="table-responsive">
                <table id="checkout_fees" class="table table-striped table-bordered table-hover">
				  <thead>
					<tr>
					<td class="text-left" style="width: 60%;"><?php echo $this->lang->line('column_name') ?></td>
					<td></td>
					</tr>
				  </thead>
				  <tbody>
				    <?php $checkout_fee_row = 0; ?>
					<?php if($checkout_fees) { ?>
					  <?php foreach ($checkout_fees as $checkout_fee) { ?>
					  <tr id="checkout-fee-row<?php echo $checkout_fee_row; ?>">
					    <td class="text-right">
					      <select name="checkout_fee[<?php echo $checkout_fee_row; ?>]" class="form-control">
						  <option value=""></option>
						  <?php if($fees) { ?>
						  <?php foreach($fees as $fee) { ?>
						  <?php if($fee['fee_id'] == $checkout_fee['fee_id']) { ?>
						  <option value="<?php echo $fee['fee_id']; ?>" selected><?php echo $fee['name']; ?>&nbsp;(<?php echo $fee['amount']; ?>)</option>
						  <?php } else { ?>
						  <option value="<?php echo $fee['fee_id']; ?>"><?php echo $fee['name']; ?>&nbsp;(<?php echo $fee['amount']; ?>)</option>
						  <?php } ?>
						  <?php } ?>
						  <?php } ?>
						</select>
						</td>
						<td class="text-left"><button type="button" onclick="$('#checkout-fee-row<?php echo $checkout_fee_row; ?>').remove();" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>
					  </tr>
					  <?php $checkout_fee_row ++; ?>
					  <?php } ?>
					<?php } ?>
				  </tbody>
				  <tfoot>
					<tr>
					  <td colspan="1"></td>
					  <td class="text-left"><button type="button" onclick="add_checkout_fee();" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>
					</tr>
				  </tfoot>
                </table>
              </div>
			</div>
		  </div>
		  <div id="note" class="tab-pane">
			<div class="panel-body">
		      <div class="form-group">
			    <div class="col-sm-12"><textarea name="note" rows="8" cols="50" class="form-control summernote"><?php echo $note; ?></textarea></div>
			  </div>
		      <div class="hr-line-dashed"></div>
		    </div>
		  </div>		  
	    </div>
	  </div>
	</form>
	</div>
  </div>  
</div>
<script>
function refresh_volume() {
	data = new FormData();
				
	$('#checkout-product tbody tr').each(function(index) {
		product_id = $(this).find('.product_id').val();
		quantity = $(this).find('.quantity').val();
		
		data.append('product[' + product_id + ']', quantity);
	});
	
	$.ajax({
		url: '<?php echo base_url(); ?>catalog/product_ajax/get_products_volume',
		type: 'post',
		data: data,
		cache: false,
		contentType: false,
		processData: false,
		dataType: 'json',
		success: function(json) {					
			$('input[name=\'length\']').val(json.length);
			$('input[name=\'width\']').val(json.width);
			$('input[name=\'height\']').val(json.height);
			$('select[name=\'length_class_id\']').val(json.length_class_id);
		},
		error: function(xhr, ajaxOptions, thrownError) {
			console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
}
</script>
<script>
function refresh_weight() {
	data = new FormData();
		
	$('#checkout-product tbody tr').each(function(index) {		
		product_id = $(this).find('.product_id').val();
		quantity = $(this).find('.quantity').val();
								
		data.append('product[' + product_id + ']', quantity);
	});
		
	$.ajax({
		url: '<?php echo base_url(); ?>catalog/product_ajax/get_products_weight',
		type: 'post',
		data: data,
		cache: false,
		contentType: false,
		processData: false,
		dataType: 'json',
		success: function(json) {					
			$('input[name=\'weight\']').val(json.weight);
			$('select[name=\'weight_class_id\']').val(json.weight_class_id);
		},
		error: function(xhr, ajaxOptions, thrownError) {
			console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
}
</script>
<script>
checkout_fee_row = <?php echo $checkout_fee_row; ?>;

function add_checkout_fee(name, amount) {
	html  = '<tr id="checkout-fee-row' + checkout_fee_row + '">';
	html += '<td class="text-right">';
	html += '<select name="checkout_fee[' + checkout_fee_row + ']" class="form-control">';
	html += '<option value=""></option>';
	
	<?php foreach($fees as $fee) { ?>
	html += '<option value="<?php echo $fee['fee_id']; ?>"><?php echo $fee['name']; ?>&nbsp;(<?php echo $fee['amount']; ?>)</option>';
	<?php } ?>
	
	html += '</select>';
	html += '<td class="text-left"><button type="button" onclick="$(\'#checkout-fee-row' + checkout_fee_row  + '\').remove();" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
	html += '</tr>';

	$('#checkout_fees tbody').append(html);

	checkout_fee_row++;
}
</script>
<script>
$(document).ready(function() {

	checkout_product_row = <?php echo $checkout_product_row; ?>;
	
	$('input[name=\'code\']').autocomplete({  
		'source': function(request, response) {
			code = $('input[name=\'code\']').val();
					
			data = new FormData();
			data.append('code', code);
			
			$.ajax({
				url: '<?php echo base_url(); ?>check/checkout_ajax/get_product',
				type: 'post',
				data: data,
				cache: false,
				contentType: false,
				processData: false,
				dataType: "json",
				success: function(json) {
					if(json.success)
					{
						response($.map(json.products, function(item) {					
							return {
								label:       item['label'],
								product_id:  item['product_id'],
								upc:         item['upc'],
								sku:         item['sku'],
								name:        item['name'],
								fees:        item['fees'],
								inventories: item['inventories']
							}
						}));
					}
				}
			});
		},
		'select': function(event, ui) {			
			product = ui.item;
			
			if($('input[name$="[product_id]"][value="' + product.product_id + '"]').length > 0) 
			{
				quantity = $('input[name$="[product_id]"][value="' + product.product_id + '"]').parent('td').parent('tr').find('input[name$="[quantity]"]');
				quantity.val(parseInt(quantity.val()) + 1);
			}
			else 
			{
				new_tr = $('<tr id="row_' + checkout_product_row + '"></tr>');
				
				html  = '<td><input name="checkout_product[' + checkout_product_row + '][product_id]" type="hidden" value="' + product.product_id + '" class="product_id"><div class="text-left">' + product.name + '</div></td>';
				html += '<td class="text-left">' + product.upc + '</div></td>';
				html += '<td class="text-left">' + product.sku + '</div></td>';
				html += '<td><input class="form-control text-center quantity" name="checkout_product[' + checkout_product_row + '][quantity]" type="text" value="1" onClick="this.select();"></td>';
				html += '<td><select name="checkout_product[' + checkout_product_row + '][inventory_id]" class="form-control">';
				
				$.each(product.inventories, function(index, inventory) {
					html += '<option value="' + inventory.inventory_id + '">' + inventory.location_name + '</optioin>';
				});
				
				html += '</select></td>';
				html += '<td class="text-center"><button type="button" class="btn btn-danger btn-delete"><i class="fa fa-minus-circle"></i></button></td>';
				
				new_tr.html(html);
				$("#checkout-product").append(new_tr);
			}
			
			checkout_product_row ++;
			
			$(this).val(''); 
			
			refresh_volume();
			refresh_weight();
			
			return false;
		}
	});
	
	//remove product
	$('#checkout-product').on('click', '.btn-delete', function() {		
		$(this).closest('tr').remove();		
		
		refresh_volume();
		refresh_weight();
	});
});
</script>
<script>
$(document).ready(function() {
	$('select[name=\'shipping_provider\']').on('change', function() {
		code = $(this).val();
	
		if(code) 
		{
			$.ajax({
				url: '<?php echo base_url(); ?>extension/shipping/get_shipping_services?code=' + code,
				dataType: "json",
				beforeSend: function() {
					$('#alert-error').hide();
				},
				success: function(json) {					
					if(json.success) 
					{	
						shipping_service_html = '';
					
						$.each(json.shipping_services, function(index, shipping_serivce) {							
							shipping_service_html += '<option value="'+ shipping_serivce.code +'">' + shipping_serivce.name + '</option>';
						});
				
						$('select[name=\'shipping_service\']').html(shipping_service_html);
					}
					else 
					{
						$('#alert-error span').html(json.msg);		
						$('#alert-error').show();
					}
				},
				error: function(xhr, ajaxOptions, thrownError) {
					console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
				}
			});
		}
		else
		{
			shipping_service_html = '<option value=""></option>';
			
			$('select[name=\'shipping_service\']').html(shipping_service_html);
		}
	});
});
</script>
<script>
$(document).ready(function() {
	$(document).on('input', '.quantity', function() {
		refresh_volume();
		refresh_weight();
	});
});
</script>
<script>
$(document).ready(function() {
	$('.summernote').summernote({
		height: 580
	});
});
</script>
<?php echo $footer; ?>