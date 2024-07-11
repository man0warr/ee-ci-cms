<div class="row">
	<div class="col-xs-6">

		<h1>Register</h1>

		<?php echo validation_errors(); ?>

		<?php echo form_open(); ?>
		    <div class="form-group">
				<label for="email"><span class="required">*</span> E-mail:</label>
    			<input type="email" name="email" value="<?php set_value('email'); ?>" placeholder="E-mail" class="form-control">
		    </div>
		    <div class="form-group">
			    <label for="password"><span class="required">*</span> Create Password:</label>
			    <input type="password" name="password" value="<?php set_value('password'); ?>" placeholder="Password" class="form-control">
		    </div>
		    <div class="form-group">
			    <label for="confirm_password"><span class="required">*</span> Confirm Password:</label>
			    <input type="password" name="confirm_password" value="<?php set_value('confirm_password'); ?>" placeholder="Confirm Password" class="form-control">
		    </div>
		    <div class="form-group">
				<label for="first_name"><span class="required">*</span> First Name:</label>
    			<input type="text" name="first_name" value="<?php set_value('first_name'); ?>" placeholder="First Name" class="form-control">
		    </div>
		    <div class="form-group">
				<label for="last_name"><span class="required">*</span> Last Name:</label>
    			<input type="text" name="last_name" value="<?php set_value('last_name'); ?>" placeholder="Last Name" class="form-control">
		    </div>
		    <div class="form-group">
				<label for="phone">Phone:</label>
    			<input type="text" name="phone" value="<?php set_value('phone'); ?>" placeholder="Phone" class="form-control">
		    </div>
		    <div class="form-group">
				<label for="address">Address:</label>
    			<input type="text" name="address" value="<?php set_value('address'); ?>" placeholder="Address" class="form-control">
		    </div>
		    <div class="form-group">
				<label for="address2">Address 2:</label>
    			<input type="text" name="address2" value="<?php set_value('address2'); ?>" placeholder="Address 2" class="form-control">
		    </div>
		    <div class="form-group">
				<label for="city">City:</label>
    			<input type="text" name="city" value="<?php set_value('city'); ?>" placeholder="City" class="form-control">
		    </div>
		    <div class="form-group">
		    	<label for="state">State:</label>
		        <?php echo form_dropdown('state', $states, set_value('state'), 'class="form-control"'); ?>
		    </div>
		    <div class="form-group">
				<label for="zip">ZIP Code:</label>
    			<input type="text" name="zip" value="<?php set_value('zip'); ?>" placeholder="ZIP Code" class="form-control">
		    </div>
		    <div class="hidden">
		        <?php echo form_label('<span class="required">*</span> Spam Check:', 'spam_check')?>
		        <?php echo form_input(array('id' => 'spam_check', 'name' => 'spam_check', 'value' => set_value('spam_check'))); ?>
		    </div>
		    <button type="submit" class="btn btn-default">Register</button>
		<?php echo form_close(); ?>

		<hr>
		<p>
		    Already a Member? <?php echo anchor('/users/login', 'Login'); ?>
		</p>

	</div>
</div>