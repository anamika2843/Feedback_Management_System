<?php echo $this->extend('theme/theme'); ?>
<?php echo $this->section('content'); ?>
<div class="col-12">
	<div class="card mb-4">
		<div class="card-header"><strong><?php echo app_lang('members'); ?></strong></div>
		<div class="card-body">
			<?php echo form_open(site_url('admin/members/store'.(isset($user) ? '/'.$user->id : ''))); ?>
			<?php echo form_hidden('id', $user->id ?? ''); ?>
			<div class="tab-content rounded-bottom">
				<div class="tab-pane p-3 active preview" role="tabpanel" id="preview-237">
					<div class="mb-3">
						<label for="email"><?php echo app_lang('Auth.email'); ?></label>
						<input type="email" class="form-control <?php if (session('errors.email')) { ?>is-invalid<?php } ?>"
						name="email" aria-describedby="emailHelp" placeholder="<?php echo app_lang('Auth.email'); ?>" value="<?php echo old('email') ?? $user->email ?? ''; ?>">
						<div class="invalid-feedback">
			              <?php echo session('errors.email'); ?>
			            </div>
					</div>

					<div class="mb-3">
						<label for="username"><?php echo app_lang('Auth.username'); ?></label>
						<input type="text" class="form-control <?php if (session('errors.username')) { ?>is-invalid<?php } ?>" name="username" placeholder="<?php echo app_lang('Auth.username'); ?>" value="<?php echo old('username') ?? $user->username ?? ''; ?>">
						<div class="invalid-feedback">
			              <?php echo session('errors.username'); ?>
			            </div>
					</div>

					<div class="mb-3">
						<label for="password"><?php echo app_lang('Auth.password'); ?></label>
						<input type="password" name="password" class="form-control <?php if (session('errors.password')) { ?>is-invalid<?php } ?>" placeholder="<?php echo app_lang('Auth.password'); ?>" autocomplete="off">
						<div class="invalid-feedback">
			              <?php echo session('errors.password'); ?>
			            </div>
					</div>

					<div class="mb-3">
						<label for="pass_confirm"><?php echo app_lang('Auth.repeatPassword'); ?></label>
						<input type="password" name="pass_confirm" class="form-control <?php if (session('errors.pass_confirm')) { ?>is-invalid<?php } ?>" placeholder="<?php echo app_lang('Auth.repeatPassword'); ?>" autocomplete="off">
						<div class="invalid-feedback">
			              <?php echo session('errors.pass_confirm'); ?>
			            </div>
					</div>

					<div class="mb-3">
						<label for="role"><?php echo app_lang('member_role'); ?></label>
						<select name="role" id="role" class="form-select <?php if (session('errors.role')) { ?>is-invalid<?php } ?>">
							<option value="" selected>Select Role</option>
							<?php foreach ($roles as $key => $value) { ?>
								<option value="<?php echo $value->id; ?>" <?php if (isset($user_group) && isset($user_group[0]) && $value->id == $user_group[0]['group_id']) {
    echo 'selected';
}?>><?php echo $value->name; ?></option>
							<?php } ?>
						</select>
						<div class="invalid-feedback">
			              <?php echo session('errors.role'); ?>
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
</div>
<?php echo $this->endSection(); ?>
