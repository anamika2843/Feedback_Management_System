<?php echo $this->extend('theme/theme'); ?>
<?php echo $this->section('content'); ?>
<div class="card mb-4">

	<div class="card-body">
		<div class="tab-content rounded-bottom">
			<div class="tab-pane p-3 active preview" role="tabpanel" id="preview-337">
				<table class="table table-hover table-striped table-bordered roadmap-dataTable-ajax" id="table" >
					<thead>
						<tr>
							<th><?php echo app_lang('sr_no'); ?></th>
							<th><?php echo app_lang('roadmap-value'); ?></th>
							<th><?php echo app_lang('roadmap-action'); ?></th>
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
<?php echo $this->section('modals'); ?>
<div class="modal fade" id="roadmap_modal"  tabindex="-1" role="dialog"
aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog" role="document">
	<div class="modal-content">
		<div class="modal-header">
			<h5 class="modal-title" id="exampleModalLabel"><?php echo app_lang('roadmap_edit'); ?></h5>
			<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
			</button>
		</div>
		<?php echo form_open('admin/roadmap/update', ['id'=>'frm_roadmap']); ?>
		<div class="modal-body">
		<div id="error_div"></div>
			<p class="mb-0">
				<input class="form-control" type="text" name="roadmap_name" placeholder="<?php echo app_lang('roadmap-value'); ?>">
				<?php echo form_hidden('id'); ?>
			</p>
		</div>
		<div class="modal-footer">
			<button type="button" class="mb-2 me-2 btn btn-shadow btn-secondary" data-bs-dismiss="modal"><?php echo app_lang('roadmap_editclose'); ?></button>
			<button type="submit" class="mb-2 me-2 btn btn-shadow btn-primary"><?php echo app_lang('roadmap_editsave'); ?></button>
		</div>
		<?php echo form_close(); ?>
	</div>
</div>
</div>
<?php echo $this->endSection(); ?>
<?php echo $this->section('scripts'); ?>
<script>
	"use strict";
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
			url: 'roadmap/table',
			type:'post',
		},
		columns: [
		{data: 'no', orderable: false},
		{data: 'value', name: 'value'},
		{data: 'action', name: 'action'}
		],
		aoColumnDefs: [
		{
			bSortable: false,
			aTargets: [ -1 ]
		}
		]
	});
	$(document).ready(function(){
		$("#table").on('click','.edit-roadmap',function(e){
			e.preventDefault();
			var name = $(this).data('value');
			var id = $(this).data('id');
			$("#roadmap_modal").find('input[name="roadmap_name"]').val(name);
			$("#roadmap_modal").find('input[name="id"]').val(id);
			$("#roadmap_modal").modal('show');
		});
		$('#frm_roadmap').on('submit',function(e){
			e.preventDefault();
			var dataString =  $(this).serialize();
			var action = $(this).attr('action');
			$.post({
				url: action,
				type: 'post',
				dataType: 'json',
				data:dataString,
			})
			.done(function(response) {
				if(response.status=="error"){
					var html = '<div class="alert alert-danger">';
					html+=response.message;
					html+="</div>";
					$('#error_div').html(html);
				}else{
					alert_float('success','Roadmap',response.message);
					$("#roadmap_modal").modal('hide');
					$("#table").DataTable().ajax.reload();
					$('#error_div').html('');
				}
			});
		});
	});
</script>
<?php echo $this->endSection(); ?>