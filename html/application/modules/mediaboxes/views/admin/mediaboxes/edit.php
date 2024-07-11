<div class="box">

    <div class="heading">
        <h1><img alt="" src="<?php echo theme_url('assets/images/icons/mediaboxes.png'); ?>"> <?php echo ($edit_mode) ? 'Edit' : 'Add' ?> Media Box</h1>
        <div class="buttons">
            <a class="button" href="#" onClick="$('#mediaboxes_form').submit();"><span>Save</span></a>
        </div>
    </div>

    <div class="content">
        <?php echo form_open(null, 'id="mediaboxes_form"')?>
	        <div class="form">
	            <div>
	                <?php echo form_label('Title:', 'title')?>
	                <?php echo form_input(array('name' => 'title', 'value' => set_value('title', isset($Mediabox->title) ? $Mediabox->title : ''), 'size' => 50))?>
	            </div>
	        </div>
	        <div class="clear"></div>
        <?php echo form_close(); ?>
    </div>

</div>