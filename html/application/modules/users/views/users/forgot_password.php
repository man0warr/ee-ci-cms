<div class="row">
	<div class="col-xs-6">

		<h1>Forgot Password</h1>

		<?php echo validation_errors(); ?>

		<?php echo form_open(); ?>
		    <div class="form-group">
				<label for="email">Enter your E-mail:</label>
    			<input type="email" name="email" value="<?php set_value('email'); ?>" placeholder="Email" class="form-control">
		    </div>
		    <button type="submit" class="btn btn-default">Submit</button>
		<?php echo form_close(); ?>

	</div>
</div>