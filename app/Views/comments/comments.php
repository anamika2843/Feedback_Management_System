<?php echo $this->extend('theme/theme'); ?>
<?php echo $this->section('content'); ?>
<div class="col-12">
	<div class="card mb-4">
		<div class="card-header"><strong><?php echo app_lang('feedback-all-comments'); ?></strong></div>
		<div class="card-body">
			<?php echo form_open(site_url('admin/comment/'.$comment->id.'/edit')); ?>			
			<div class="tab-content rounded-bottom">
				<div class="tab-pane p-3 active preview" role="tabpanel" id="preview-237">
					<div class="mb-3">
						<label for="email"><?php echo app_lang('feedback-comments-description'); ?></label>
						<textarea name="comment_description" class="form-control"><?= $comment->description ?></textarea>
					</div>					
					<div class="row">
						<div class="col-3">
							<label for="email"><?php echo app_lang('feedback-status'); ?></label>
							<select class='feedback-comment-status-table form-select form-control-sm form-control' name="approved">
								<option value='0' <?= ($comment->approved=="0" ? 'selected' : '') ?> ><?= app_lang('pending_moderation') ?></option>
								<option value='1' <?= ($comment->approved=="1" ? 'selected' : '') ?> ><?= app_lang('approved') ?></option>
								<option value='2' <?= ($comment->approved=="2" ? 'selected' : '') ?> ><?= app_lang('dis_approved') ?></option>
							</select>
						</div>
						<div class="col-3">
							<label for=""><?= app_lang('user_editusername') ?></label>
							<input type="text" disabled value="<?= $comment->user_name ?>" class="form-control">
						</div>
						<div class="col-3">
							<label for=""><?= app_lang('user_edituseremail') ?></label>
							<input type="text" disabled value="<?= $comment->user_email ?>" class="form-control">
						</div>
						<div class="col-3">
							<label for=""><?= app_lang('feedback_comments_dateadded') ?></label>
							<input type="text" disabled value="<?= date('Y-m-d g:i:s A',strtotime($comment->created_at)) ?>" class="form-control">
						</div>
					</div>
				</div>
				<div class="p-3" >
					<button type="submit" class=" btn btn-shadow btn-primary"><?php echo app_lang('save'); ?></button>
				</div>
			</div>
			<?php echo form_close(); ?>			
		</div>
	</div>
	<div class="card mb-4">
		<div class="card-header"><strong><?php echo app_lang('feedback'); ?></strong></div>
		<div class="card-body">				
			<div class="tab-content rounded-bottom">
				<div class="tab-pane p-3 active preview" role="tabpanel" id="preview-237">
					<div class="mb-3">
						<table class="table table-striped table-bordered table-hover">
							<thead>
								<th><?= app_lang('feedback_editdescription') ?></th>
								<th><?= app_lang('user_editusername') ?></th>
								<th><?= app_lang('user_edituseremail') ?></th>
								<th><?= app_lang('feedback-status') ?></th>
								<th><?= app_lang('feedback-category') ?></th>
								<th><?= app_lang('feedback-approvalstatus') ?></th>
							</thead>
							<tbody>
								<tr>
									<td><?= $feedback->feedback_description ?></td>
									<td><?= $feedback->user_name ?></td>
									<td><?= $feedback->user_email ?></td>
									<td><?= get_row('roadmap',$feedback->status)->value ?></td>
									<td><?= get_row('category',$feedback->category)->title ?></td>
									<td>
										<?php
											if($feedback->approval_status){
												?>
												<label class="label text-success label-success"><?= app_lang('approved') ?></label>
												<?php
											}else{
												?>
												<label class="label text-danger label-success"><?= app_lang('dis_approved') ?></label>
												<?php
											}
										?>
									</td>
								</tr>
							</tbody>		
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php echo $this->endSection(); ?>
