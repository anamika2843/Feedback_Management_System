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
		<?php echo $this->section('modals'); ?>
		<div class="modal fade" id="user_modal"  tabindex="-1" role="dialog"
		aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel"><?php echo app_lang('user_edit'); ?></h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
					</button>
				</div>
				<?php echo form_open('admin/users/update', ['id'=>'frm_user']); ?>
				<div class="modal-body">
					<div id="error_div"></div>
					<div class="row">
						<div class="mb-3 col-12">
							<label class="form-label"><?php echo app_lang('user_editusername'); ?></label>
							<input class="form-control" type="text" name="name" id="name" placeholder="<?php echo app_lang('front-username'); ?>" value="<?php echo $data->name ?? old('name'); ?>">
						</div>
						<div class="mb-3 col-12">
							<label class="form-label"><?php echo app_lang('user_edituseremail'); ?></label>
							<input class="form-control" type="text" name="email" id="email" placeholder="<?php echo app_lang('front-useremail'); ?>" value="<?php echo $data->email ?? old('email'); ?>">
						</div>
						<?php echo form_hidden('id'); ?>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?php echo app_lang('user_editclose'); ?></button>
					<button type="submit" class="btn btn-primary"><?php echo app_lang('user_editsave'); ?></button>
				</div>
				<?php echo form_close(); ?>
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
				url: 'users/table',
				type:'post',
			},
			columns: [
			{data: 'no', orderable: false},
			{data: 'name', name: 'name'},
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
		$("#table").on('click','.edit-users',function(e){
			e.preventDefault();

			var row = $(this).data('value')
			$.each(row,function(key,val){
			    var elem = "#user_modal #"+key;
			    if($(elem).length > 0){
			       $(elem).val(val);
			    }
			 });
			$("#user_modal").modal('show');


			var id = $(this).data('id');
			$("#user_modal").find('input[name="id"]').val(id);
			$("#user_modal").modal('show');
		});
		$('#frm_user').on('submit',function(e){
			e.preventDefault();
			var dataString =  $(this).serialize();
			var action = $(this).attr('action');
			$.post({
				url: action,
				type: 'POST',
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
					alert_float('success','User',response.message);
					$("#user_modal").modal('hide');
					window.location.reload();
				}
			});
		});
	});

</script>
<?php $this->endsection(); ?>