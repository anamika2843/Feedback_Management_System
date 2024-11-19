<?php echo $this->extend('theme/theme'); ?>
<?php echo $this->section('content'); ?>
<div class="card mb-4">
	<div class="card-header"><a href="<?php echo 'category/create'; ?>" class="m-2 btn btn-shadow btn-primary"><i class="lnr-plus-circle"></i> <?php echo app_lang('create-category'); ?> </a></div>
	<div class="card-body">
		<div class="tab-content rounded-bottom">
			<div class="tab-pane p-3 active preview" role="tabpanel" id="preview-337">
				<table class="table table-hover table-striped table-bordered category-dataTable-ajax" id="table" >
					<thead>
						<tr>
							<th><?php echo app_lang('sr_no'); ?></th>
							<th><?php echo app_lang('category-title'); ?></th>
							<th><?php echo app_lang('category-description'); ?></th>
							<th><?php echo app_lang('category-action'); ?></th>
						</tr>
					</thead>
					<tbody>

					</tbody>
				</table>
			</div>
			<div class="tab-pane pt-1" role="tabpanel" id="code-337">

			</div>
		</div>
	</div>
</div>
<?php echo $this->endSection(); ?>
<?php echo $this->section('scripts'); ?>
<script>
	"use strict";
	$(document).ready(function(){
		$('#table').DataTable({
			processing: true,
  			serverSide: true,
  			responsive: responsive_table,
			lengthMenu: [
		        length_options,
		        length_options_names
		    ],
		    iDisplayLength:default_length,
  			order: [],
			ajax:{
				url: 'category/table',
				type:'post',
			},
			columns: [
			 {data: 'no', orderable: false},
			{data: 'title', name: 'title'},
			{data: 'description', name: 'description'},
			{data: 'action', name: 'action'}
			],

			columnDefs: [
            { width: 150, targets: 1 },
            { width: 75, targets: 3 },
            {bSortable: false,aTargets: [ -1 ]},
        ],
		});
	});
</script>
<?php echo $this->endSection(); ?>