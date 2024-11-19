<?php echo $this->extend('theme/theme'); ?>
<?php echo $this->section('content'); ?>
<div class="card mb-4">
	<div class="card-header">
		<a href="<?php echo site_url('admin/members/show'); ?>" class="m-2 btn btn-shadow btn-primary"><i class="lnr-plus-circle"></i> <?php echo app_lang('add_member'); ?> </a>
	</div>
	<div class="card-body">
		<div class="tab-content rounded-bottom">
			<div class="tab-pane p-3 active preview" role="tabpanel" id="preview-337">
				<table class="table table-hover table-striped table-bordered roadmap-dataTable-ajax" id="table" >
					<thead>
						<tr>
							<th><?php echo app_lang('sr_no'); ?></th>
							<th><?php echo app_lang('user-name'); ?></th>
							<th><?php echo app_lang('user-email'); ?></th>
							<th><?php echo app_lang('user-action'); ?></th>
						</tr>
					</thead>
					<tbody>

					</tbody>
				</table>
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
			processing:true,
			serverSide: true,
			responsive: responsive_table,
			lengthMenu: [
		        length_options,
		        length_options_names
		    ],
		    iDisplayLength:default_length,
			order:[],
			ajax:{
				url: 'members/table',
				type:'post',
			},
			columns: [
			{data: 'no', orderable: false},
			{data: 'username', name: 'username'},
			{data: 'email', name: 'email'},
			{data: 'action', name: 'action'}
			],
			aoColumnDefs: [
			{
				bSortable: false,
				aTargets: [ -1 ]
			}
			]
		});
	});
</script>
<?php $this->endsection(); ?>