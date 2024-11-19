<?php $this->extend('theme/theme'); ?>
<?php $this->section('content'); ?>
<?= form_hidden('feedback_id',$feedback->id ?? ""); ?>
<div class="card">
	<div class="card-body">
		<div class="tab-content rounded-bottom">
			<div class="tab-pane p-3 active preview" >				
				<table class="table table-hover table-striped table-bordered feedback-dataTable-ajax table-width" id="table">
					<thead>
						<tr>
							<th><?php echo app_lang('comment_id'); ?></th>
							<th><?php echo app_lang('feedback-all-comments'); ?></th>
							<th><?php echo app_lang('feedback-username'); ?></th>
							<th><?php echo app_lang('feedback-useremail'); ?></th>							
							<th><?php echo app_lang('admin_feedback_status'); ?></th>							
							<th><?php echo app_lang('feedback-action'); ?></th>							
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
		var feedback_id = $('input[name="feedback_id"]').val();
		$('#table').DataTable({
			processing: true,
			serverSide: true,
			responsive: responsive_table,
			lengthMenu: [
		        length_options,
		        length_options_names
		    ],
		    iDisplayLength:default_length,
			order:[],
			ajax:{
				url: '<?= site_url('admin/feedback/comments/table') ?>',
				type:'post',
				dataSrc:'data',
				data: function(d){
					d.feedback_id = feedback_id;
				},
			},
			columns: [
			{data: 'id', name: 'id'},
			{data: 'description', name: 'description'},
			{data: 'username', name: 'username'},
			{data: 'useremail', name: 'useremail'},			
			{data: 'status', name: 'status'},			
			{data: 'action', name: 'action'},			
			],
			columnDefs: [
			{ width: "5%", targets: 0 },
			{ width: "15%", targets: 1 },
			{ width: "10%", targets: 2 },
			{ width: "10%", targets: 3 },
			{ width: "15%", targets: 4 },
			{ width: "5%", targets: 5 },
			{bSortable:false, aTargets: [ -1,-2]}
			],

		});
	});
	$('#table').on('change','.feedback-comment-status-table',function(e){
		e.preventDefault();
		var value = $(this).val();
		var id = $(this).data('id');
		$.ajax({
			url: site_url+'admin/change/comment/status',
			type: 'POST',
			dataType: 'json',
			data: {status:value,id:id},
			headers:{
				'X-CSRF-TOKEN':$('meta[name="X-CSRF-TOKEN"]').attr('content')
			}
		})
		.done(function(response) {
			alert_float(response.status,response.title,response.message)
			$('#table').DataTable().ajax.reload();
		});
	});	
</script>
<?php $this->endsection(); ?>