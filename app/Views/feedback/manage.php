<?php $this->extend('theme/theme'); ?>
<?php $this->section('content'); ?>
<div class="card">
	<div class="card-body">
		<div class="tab-content rounded-bottom">
			<div class="tab-pane p-3 active preview" >
				<div class="row form-group mb-3">
					<div class="col-md-3">
						<select name="board" id="board" class="form-select form-control-lg form-control">
							<option value="" selected><?php echo app_lang('select_boards'); ?></option>
							<?php foreach ($boards as $key => $board) { ?>
								<option value="<?php echo $board->id; ?>"><?php echo $board->name; ?></option>
							<?php } ?>
						</select>
					</div>
					<?php if (has_permission('admin')) {
    ?>
						<div class="col-md-9">
							<a href="<?php echo 'feedback/create'; ?>" class="m-2 btn btn-shadow btn-primary float-end"><i class="lnr-plus-circle"></i> <?php echo app_lang('admin_feedback_title'); ?></a>
						</div>
						<?php
}
                    ?>
				</div>
				<table class="table table-hover table-striped table-bordered feedback-dataTable-ajax table-width" id="table">
					<thead>
						<tr>
							<th><?php echo app_lang('sr_no'); ?></th>
							<th><?php echo app_lang('feedback-username'); ?></th>
							<th><?php echo app_lang('feedback-useremail'); ?></th>
							<th><?php echo app_lang('feedback-status'); ?></th>
							<th><?php echo app_lang('feedback-category'); ?></th>
							<th><?php echo app_lang('feedback-approvalstatus'); ?></th>
							<th><?php echo app_lang('feedback-total-comments'); ?></th>
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
<?php echo $this->section('modals'); ?>
<div class="modal fade" id="feedback_modal"  tabindex="-1" role="dialog"
aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog modal-lg" role="document">
	<div class="modal-content">
		<div class="modal-header">
			<h5 class="modal-title" id="exampleModalLabel"><?php echo app_lang('feedback_edittitle'); ?></h5>
			<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
			</button>
		</div>
		<?php echo form_open('admin/feedback/update', ['id'=>'frm_feedback']); ?>
		<div class="modal-body">
			<div id="error_div"></div>
			<div class="row">
				<div class="mb-3 col-12">
					<label class="form-label"><?php echo app_lang('feedback_editusername'); ?>

				</label>
				<input class="form-control" type="text" disabled name="user_name" id="user_name" placeholder="<?php echo app_lang('feedback_editusername'); ?>" >
			</div>
			<div class="mb-3 col-12">
				<label class="form-label"><?php echo app_lang('feedback_edituseremail'); ?></label>
				<input class="form-control" type="text" disabled name="user_email" id="user_email" placeholder="<?php echo app_lang('feedback_edituseremail'); ?>" >
			</div>
			<div class="mb-3 col-12">
				<label class="form-label"><?php echo app_lang('feedback_editdescription'); ?></label>
				<textarea rows="5" class="form-control" type="text" name="feedback_description" id="feedback_description" placeholder="<?php echo app_lang('feedback_editdescription'); ?>" ></textarea>
			</div>
			<div class="mb-3 col-6">
				<label class="form-label"><?php echo app_lang('feedback_editdestatus'); ?></label>
				<select class="form-select form-control-sm form-control" name="status" id="status">
					<?php foreach ($status as $value) { ?>
						<option value="<?php echo $value->id; ?>"><?php echo $value->value; ?></option>
					<?php }?>
				</select>
			</div>
			<div class="mb-3 col-6">
				<label class="form-label"><?php echo app_lang('feedback_editcategory'); ?></label>
				<select class="form-select form-control-sm form-control" name="category" id="category">
					<option value=""><?php echo app_lang('select_category'); ?></option>
					<?php foreach ($category as $value) { ?>
						<option value="<?php echo $value->id; ?>"><?php echo $value->title; ?></option>
					<?php }?>
				</select>
			</div>
			<div class="mb-3 mt-2">
				<input type="checkbox" name="approval_status" value="1" id="approval_status" class="form-check-input status">
				<label class="form-label"><?php echo app_lang('feedback_editapprovalstatus'); ?></label>
			</div>
			<?php echo form_hidden('id'); ?>
		</div>
	</div>
<div class="modal-footer">
	<a href="" class='mb-2 me-2 btn btn-shadow btn-danger' id="request_more_info"><?php echo app_lang('request_more_info'); ?></a>
	<button type="button" class="mb-2 me-2 btn btn-shadow btn-secondary" data-bs-dismiss="modal"><?php echo app_lang('feedback_editclose'); ?></button>
	<button type="submit" class="mb-2 me-2 btn btn-shadow btn-primary"><?php echo app_lang('feedback_editsave'); ?></button>
</div>
<?php echo form_close(); ?>
</div>
</div>
</div>
<?php echo $this->endSection(); ?>

<?php echo $this->section('modals'); ?>
<div class="modal fade" id="feedback_view_info_modal"  tabindex="-1" role="dialog"
aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog modal-lg" role="document">
	<div class="modal-content">
		<div class="modal-header">
			<h5 class="modal-title" id="exampleModalLabel"><?php echo app_lang('feedback_view_info_title'); ?></h5>
			<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
			</button>
		</div>
		<div class="modal-body">
			<div id="error_div"></div>
			<div class="row">
				<div class="mb-3 col-12">
					<label class="form-label"><?php echo app_lang('feedback_editusername'); ?>

				</label>
				<input class="form-control" type="text" disabled name="user_name" id="user_name" placeholder="<?php echo app_lang('feedback_editusername'); ?>" >
			</div>
			<div class="mb-3 col-12">
				<label class="form-label"><?php echo app_lang('feedback_edituseremail'); ?></label>
				<input class="form-control" type="text" disabled name="user_email" id="user_email" placeholder="<?php echo app_lang('feedback_edituseremail'); ?>" >
			</div>
			<div class="mb-3 col-12">
				<label class="form-label"><?php echo app_lang('feedback_editdescription'); ?></label>
				<textarea rows="5" class="form-control" type="text" name="feedback_description" disabled id="feedback_description" placeholder="<?php echo app_lang('feedback_editdescription'); ?>" ></textarea>
			</div>
			<div class="mb-3 col-4">
				<label class="form-label"><?php echo app_lang('feedback_editdestatus'); ?></label>
				<select disabled class="form-control-sm form-control" name="status" id="status">
					<?php foreach ($status as $value) { ?>
						<option value="<?php echo $value->id; ?>"><?php echo $value->value; ?></option>
					<?php }?>
				</select>
			</div>
			<div class="mb-3 col-4">
				<label class="form-label"><?php echo app_lang('feedback_editcategory'); ?></label>
				<select disabled class="form-control-sm form-control" name="category" id="category">
					<option value=""><?php echo app_lang('select_category'); ?></option>
					<?php foreach ($category as $value) { ?>
						<option value="<?php echo $value->id; ?>"><?php echo $value->title; ?></option>
					<?php }?>
				</select>
			</div>
			<div class="mb-3 col-4">
				<label class="form-label"><?php echo app_lang('feedback_board_title'); ?></label>
				<select disabled class="form-control-sm form-control" name="board_id" id="board_id">
					<option value=""><?php echo app_lang('select_category'); ?></option>
					<?php foreach ($boards as $value) { ?>
						<option value="<?php echo $value->id; ?>"><?php echo $value->name; ?></option>
					<?php }?>
				</select>
			</div>
			<div class="mb-3 mt-2">
				<input disabled type="checkbox" name="approval_status" value="1" id="approval_status" class="form-check-input status">
				<label class="form-label"><?php echo app_lang('feedback_editapprovalstatus'); ?></label>
			</div>
			<?php echo form_hidden('id'); ?>
		</div>
	</div>
<div class="modal-footer">
	<button type="button" class="mb-2 me-2 btn btn-shadow btn-secondary" data-bs-dismiss="modal"><?php echo app_lang('feedback_editclose'); ?></button>
</div>
</div>
</div>
</div>
<?php echo $this->endSection(); ?>

<?php echo $this->section('scripts'); ?>
<script>
	"use strict";
	$(document).ready(function(){
		var board_id = "";
		$('select[name="board"]').on('change',function(e){
			e.preventDefault();
			board_id = $(this).val();
			$("#table").DataTable().ajax.reload();
		});

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
				url: 'feedback/table',
				type:'post',
				dataSrc:'data',
				data: function(d){
					d.board_id = board_id;
				},
			},
			columns: [
			{data: 'no', orderable: false},
			{data: 'user_name', name: 'user_name'},
			{data: 'user_email', name: 'user_email'},
			{data: 'status', name: 'status'},
			{data: 'category', name: 'category'},
			{data: 'approval_status', name: 'approval_status'},
			{data: 'total_comments', name: 'total_comments'},
			{data: 'action', name: 'action'}
			],
			columnDefs: [
			{ width: 100, targets: 1 },
			{ width: 120, targets: 3 },
			{ width: 150, targets: 4 },
			{bSortable: false, aTargets: [ -1 ]}
			],

		});

		/*$("#table").on('click','.edit-feedback',function(e){
			var id=$(this).data('id');
			$.ajax({
				url: 'feedback/edit/'+id,
				type: 'get',
				dataType: 'json',
			})
			.done(function(data) {
				$("#ideas").html("");
				$("#ideas").html(data.html);

			})
		});*/

		$("#table").on('click','.edit-feedback',function(e){
			e.preventDefault();

			var row = $(this).data('value')
			$.each(row,function(key,val){
				var elem = "#feedback_modal #"+key;
				if($(elem).length > 0){
					$(elem).val(val);
				}
				if(key=="approval_status" && val=="1"){
					$(elem).prop('checked',true);
				}else{
					$(elem).prop('checked',false);
				}
			});
			$("#feedback_modal").modal('show');


			var id = $(this).data('id');
			$("#feedback_modal").find('input[name="id"]').val(id);
			var request_info = site_url+"admin/feedback/request_more_info/"+id;
			$('#request_more_info').attr('href', request_info);

			$("#feedback_modal").modal('show');
		});

		$("#table").on('click','.view-info',function(e){
			e.preventDefault();

			var row = $(this).data('value');
			$.each(row,function(key,val){
				var elem = "#feedback_view_info_modal #"+key;
				if($(elem).length > 0){
					$(elem).val(val);
				}
				if(key=="approval_status" && val=="1"){
					$(elem).prop('checked',true);
				}else{
					$(elem).prop('checked',false);
				}
			});
			$("#feedback_view_info_modal").modal('show');
		});


		$("#table").on('change','.table_status_dropdown',function(e){
			e.preventDefault();
			var feedback_id=$(this).data('feedback-id');
			var dataString =  {};

			dataString.status_id = $(this).val();
			dataString.feedback_id = feedback_id;


			$.ajax({
				url: site_url+'/admin/feedback/status_edit/'+feedback_id,
				type: 'post',
				dataType: 'json',
				data:{dataString:dataString , [csrfName]:csrfHash},
			})
			.done(function(response) {
				alert_float('success','Feedback',response.message);
				$("#table").DataTable().ajax.reload();
			})
			.fail(function() {
				console.log("error");
			});

		});

		$("#table").on('change','.table_category_dropdown',function(e){
			e.preventDefault();
			var feedbacks_id=$(this).data('feedbacks-id');
			var dataString =  {};

			dataString.category_id = $(this).val();
			dataString.feedbacks_id = feedbacks_id;


			$.ajax({
				url: site_url+'/admin/feedback/category_edit/'+feedbacks_id,
				type: 'post',
				dataType: 'json',
				data:{dataString:dataString , [csrfName]:csrfHash},
			})
			.done(function(response) {
				if(response.status=="error")
				{
					alert_float('error','Feedback',response.message);
					$("#table").DataTable().ajax.reload();
				}
				else
				{
					alert_float('success','Feedback',response.message);
					$("#table").DataTable().ajax.reload();
				}

			})
			.fail(function() {
				console.log("error");
			});

		});


		$('#frm_feedback').on('submit',function(e){
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
					alert_float('danger',"Category",'select at least one category');
				}else{
					alert_float('success','Feedback',response.message);
					$("#feedback_modal").modal('hide');
					$("#table").DataTable().ajax.reload();
				}
			});
		});		
	});

</script>
<?php $this->endsection(); ?>