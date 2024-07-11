<div class="box">
    <div class="heading">
        <h1><img alt="" src="<?php echo theme_url('assets/images/icons/testimonials.png'); ?>"> <?php echo ($edit_mode) ? 'Edit' : 'Add' ?> Testimonial</h1>

        <div class="buttons">
            <a class="button" href="#" onClick="$('#testimonials_form').submit();"><span>Save</span></a>
        </div>
    </div>
    <div class="content">

        <?php echo form_open(null, 'id="testimonials_form"')?>

        <div class="form">
            <div>
                <?php echo form_label('<span class="required">*</span> Quotation:', 'quotation')?>
                <div style="display: inline-block;">
                    <?php echo form_textarea(array( 'name' => 'quotation', 'id' => 'quotation', 'value' => set_value('quotation', isset($Testimonial->quotation) ? $Testimonial->quotation : ''))); ?>
                </div>
            </div>
            <div>
                <?php echo form_label('<span class="required">*</span> By:', 'by')?>
                <?php echo form_input(array('name' => 'by', 'value' => set_value('by', isset($Testimonial->by) ? $Testimonial->by : '')))?>
            </div>
        </div>

        <div class="clear"></div>

        <?php echo form_close(); ?>
    </div>
</div>
