<div class="row">
	<div class="col-xs-6">

		<h1>Login</h1>

		<?php echo validation_errors(); ?>
		<?php echo $this->session->flashdata('message'); ?>

		<?php echo form_open(); ?>
		    <div class="form-group">
				<label for="email">E-mail:</label>
    			<input type="email" name="email" value="<?php set_value('email'); ?>" placeholder="E-mail" class="form-control">
		    </div>
			<div class="form-group">
			    <label for="password">Password:</label>
			    <input type="password" name="password" value="<?php set_value('password'); ?>" placeholder="Password" class="form-control">
			</div>
		    <button type="submit" class="btn btn-default">Login</button>
		<?php echo form_close(); ?>

		<hr>
	    <p>
	        <?php echo anchor('/users/forgot-password', 'Forgot Password'); ?>
	        <?php if ($this->settings->users_module->enable_registration): ?>
	            &nbsp;|&nbsp; <?php echo anchor('/users/register', 'Register Now'); ?>
	        <?php endif; ?>
	    </p>

	</div>
</div>