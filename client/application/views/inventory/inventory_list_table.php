<div class="form-horizontal">
  <div class="row">
    <div class="col-md-2">
	  <div class="form-group">
	    <label class="col-sm-4 control-label"><?php echo $this->lang->line('entry_warehouse'); ?></label>
	    <div class="col-sm-8">
		  <select name="warehouse_id" class="form-control">
		    <?php if($warehouses) { ?>
			  <option value=""></option>
			  <?php foreach($warehouses as $warehouse) { ?>
			  <?php if($warehouse['warehouse_id'] == $filter_warehouse_id) { ?>
			  <option value="<?php echo $warehouse['warehouse_id']; ?>" selected><?php echo $warehouse['name']; ?></option>
			  <?php } else { ?>
			  <option value="<?php echo $warehouse['warehouse_id']; ?>"><?php echo $warehouse['name']; ?></option>
			  <?php } ?>
			  <?php } ?>
		    <?php } ?>
		  </select>
	    </div>
	  </div>
    </div>
    <div class="col-md-2">
	  <div class="form-group">
	    <label class="col-sm-4 control-label"><?php echo $this->lang->line('entry_location'); ?></label>
	    <div class="col-sm-8"><input name="location" class="form-control" value="<?php echo $filter_location; ?>"></div>
	  </div>
    </div>
    <div class="col-md-2">
	  <div class="form-group">
	    <label class="col-sm-3 control-label"><?php echo $this->lang->line('entry_sku'); ?></label>
	    <div class="col-sm-9"><input name="sku" class="form-control" value="<?php echo $filter_sku; ?>"></div>
	  </div>
    </div>
	<div class="col-md-2">
	  <div class="form-group">
	    <label class="col-sm-3 control-label"><?php echo $this->lang->line('entry_upc'); ?></label>
	    <div class="col-sm-9"><input name="upc" class="form-control" value="<?php echo $filter_upc; ?>"></div>
	  </div>
    </div>
    <div class="col-md-3">
	  <button id="btn-search" class="btn btn-success" onclick="filter()"><i class="fa fa-search"></i>&nbsp;<?php echo $this->lang->line('text_search'); ?></button>
    </div>
  </div>
</div>
<div class="table-responsive">
  <table class="table table-striped table-bordered table-hover table-non-batch dataTables-example" >
    <thead>
	  <?php if($sort == 'product.name') { ?>
	  <th style="width: 16%;" class="sorting_<?php echo strtolower($order); ?>">
	    <a href="<?php echo $sort_product; ?>"><?php echo $this->lang->line('column_product'); ?></a>
	  </th>
	  <?php } else { ?>
	  <th style="width: 16%;" class="sorting">
	    <a href="<?php echo $sort_product; ?>"><?php echo $this->lang->line('column_product'); ?></a>
	  </th>
	  <?php } ?>
	  <?php if($sort == 'product.upc') { ?>
	  <th style="width: 14%;" class="sorting_<?php echo strtolower($order); ?>">
	    <a href="<?php echo $sort_upc; ?>"><?php echo $this->lang->line('column_upc'); ?></a>
	  </th>
	  <?php } else { ?>
	  <th style="width: 14%;" class="sorting">
	    <a href="<?php echo $sort_upc; ?>"><?php echo $this->lang->line('column_upc'); ?></a>
	  </th>
	  <?php } ?>
	  <?php if($sort == 'product.sku') { ?>
	  <th style="width: 14%;" class="sorting_<?php echo strtolower($order); ?>">
	    <a href="<?php echo $sort_sku; ?>"><?php echo $this->lang->line('column_sku'); ?></a>
	  </th>
	  <?php } else { ?>
	  <th style="width: 14%;" class="sorting">
	    <a href="<?php echo $sort_sku; ?>"><?php echo $this->lang->line('column_sku'); ?></a>
	  </th>
	  <?php } ?>
	  <?php if($sort == 'location.name') { ?>
	  <th style="width: 14%;" class="sorting_<?php echo strtolower($order); ?>">
	    <a href="<?php echo $sort_location; ?>"><?php echo $this->lang->line('column_location'); ?></a>
	  </th>
	  <?php } else { ?>
	  <th style="width: 14%;" class="sorting">
	    <a href="<?php echo $sort_location; ?>"><?php echo $this->lang->line('column_location'); ?></a>
	  </th>
	  <?php } ?>
	  <?php if($sort == 'warehouse.name') { ?>
	  <th style="width: 14%;" class="sorting_<?php echo strtolower($order); ?>">
	    <a href="<?php echo $sort_warehouse; ?>"><?php echo $this->lang->line('column_warehouse'); ?></a>
	  </th>
	  <?php } else { ?>
	  <th style="width: 14%;" class="sorting">
	    <a href="<?php echo $sort_warehouse; ?>"><?php echo $this->lang->line('column_warehouse'); ?></a>
	  </th>
	  <?php } ?>
	  <?php if($sort == 'inventory.quantity') { ?>
	  <th style="width: 12%;" class="sorting_<?php echo strtolower($order); ?>">
	    <a href="<?php echo $sort_quantity; ?>"><?php echo $this->lang->line('column_quantity'); ?></a>
	  </th>
	  <?php } else { ?>
	  <th style="width: 12%;" class="sorting">
	    <a href="<?php echo $sort_quantity; ?>"><?php echo $this->lang->line('column_quantity'); ?></a>
	  </th>
	  <?php } ?>
    </thead>
    <tbody>
	  <?php if($inventories) { ?>
	    <?php $offset = 0; ?>
	    <?php foreach($inventories as $inventory) { ?>
		  <tr>
		    <td>
			  <a href="<?php echo base_url(); ?>catalog/product/edit?product_id=<?php echo $inventory['product_id']; ?>" target="_blank"><?php echo $inventory['product']; ?></a>
			  <div class="detail" style="top: <?php echo $offset * 50 + 170; ?>px;">
			    <table class="table">
				  <thead>
				    <th style="width: 50%;"><?php echo $this->lang->line('column_upc'); ?></th>
				    <th style="width: 50%;"><?php echo $this->lang->line('column_sku'); ?></th>
				  </thead>
				  <tbody>
				    <tr>
					  <td><?php echo $inventory['upc']; ?></td>
					  <td><?php echo $inventory['sku']; ?></td>
				    </tr>
				  </tbody>
			    </table>
			  </div>
		    </td>
		    <td><?php echo $inventory['upc']; ?></td>
		    <td><?php echo $inventory['sku']; ?></td>
		    <td><?php echo $inventory['location']; ?></td>
		    <td><?php echo $inventory['warehouse']; ?></td>
		    <td><?php echo $inventory['quantity']; ?></td>			
		  </tr>
		  <?php $offset++; ?>
	    <?php } ?>
	  <?php } ?>
    </tbody>			  
  </table>
</div>
<div class="pagination-block">
  <div class="pull-left"><?php echo $results; ?></div>
  <div class="pull-right"><?php echo $pagination; ?></div>
</div>
	   