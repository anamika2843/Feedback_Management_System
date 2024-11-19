<p>Someone requested a password reset at this email address for <?php echo site_url(); ?>.</p>

<p>To reset the password use this code or URL and follow the instructions.</p>

<p>Your Code: <?php echo $hash; ?></p>

<p>Visit the <a href="<?php echo site_url('admin/reset-password').'?token='.$hash; ?>">Reset Form</a>.</p>

<br>

<p>If you did not request a password reset, you can safely ignore this email.</p>
