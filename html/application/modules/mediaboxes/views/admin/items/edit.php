<div class="box">

    <div class="heading">
        <h1><img alt="" src="<?php echo theme_url('assets/images/icons/mediabox-items.png'); ?>">Item Edit</h1>
        <div class="buttons">
            <a class="button" href="#" onClick="$('#item_form').submit()"><span>Save</span></a>
            <a class="button" href="<?php echo site_url(ADMIN_PATH . '/mediaboxes/items/index/' . $mediabox_id); ?>"><span>Cancel</span></a>
        </div>
    </div>

    <div class="content">
        <div class="form">
            <?php echo form_open(null, 'id="item_form"'); ?>
	            <div>
	                <?php echo form_label('<span class="required">*</span> Title:', 'title'); ?>
	                <?php echo form_input(array( 'name' => 'title', 'value' => set_value('title', isset($Item->title) ? $Item->title : ''), 'size' => 50)); ?>
	            </div>

	            <div>
	                <?php echo form_label('Subtitle:', 'subtitle'); ?>
	                <?php echo form_input(array( 'name' => 'subtitle', 'value' => set_value('subtitle', isset($Item->subtitle) ? $Item->subtitle : ''), 'size' => 80)); ?>
	            </div>

	            <div>
	                <?php echo form_label('Text 1:', 'text_1'); ?>
	                <?php echo form_input(array( 'name' => 'text_1', 'value' => set_value('text_1', isset($Item->text_1) ? $Item->text_1 : ''), 'size' => 80)); ?>
	            </div>

	            <div>
	                <?php echo form_label('Text 2:', 'text_2'); ?>
	                <?php echo form_input(array( 'name' => 'text_2', 'value' => set_value('text_2', isset($Item->text_2) ? $Item->text_2 : ''), 'size' => 80)); ?>
	            </div>

	            <div>
	                <?php echo form_label('Image:', 'image_path'); ?>
				    <a class="choose_image" href="javascript:void(0);" style="display: inline-block; margin-bottom: 5px;">
				        <img class="image_thumb" src="<?php echo image_thumb(set_value('image_path', $Item->image_path), 150, 150, FALSE, array('no_image_image' => ADMIN_NO_IMAGE)); ?>" />
				    </a>
				    <br>
				    <label>&nbsp;</label>
				    <a class="remove_image" href="javascript:void(0);">Remove Image</a> |
				    <a class="choose_image" href="javascript:void(0);">Add Image</a>
				    <input type="hidden" name="image_path" value="<?php echo set_value('image_path', isset($Item->image_path) ? $Item->image_path : ''); ?>" class="hidden_file" id="image-path" />
	            </div>

	            <div>
	                <?php echo form_label('Image Alternate Text:', 'image_alt'); ?>
	                <?php echo form_input(array( 'name' => 'image_alt', 'value' => set_value('image_alt', isset($Item->image_alt) ? $Item->image_alt : ''), 'size' => 50)); ?>
	            </div>

	            <div>
	                <?php echo form_label('Description:', 'description', array('style' => 'line-height: 285px; vertical-align: 45%;')); ?>
	                <div style="display: inline-block;">
	                    <?php echo form_textarea(array( 'name' => 'description', 'id' => 'description', 'value' => set_value('description', isset($Item->description) ? $Item->description : ''))); ?>
	                </div>
	            </div>

	            <div id="link-type">
	                <?php echo form_label('<span class="required">*</span> Link Type:', 'link_type'); ?>
                    <span>
						<label><?php echo form_radio(array('name' => 'link_type', 'value' => 'NONE', 'checked' => set_radio('link_type', 'NONE', (! $Item->link_type || $Item->link_type == 'NONE') ? TRUE : FALSE))); ?> None</label>
						<label><?php echo form_radio(array('name' => 'link_type', 'value' => 'INTERNAL', 'checked' => set_radio('link_type', 'INTERNAL', ($Item->link_type == 'INTERNAL') ? TRUE : FALSE))); ?> Internal Link</label>
						<label><?php echo form_radio(array('name' => 'link_type', 'value' => 'EXTERNAL', 'checked' => set_radio('link_type', 'EXTERNAL', ($Item->link_type == 'EXTERNAL') ? TRUE : FALSE))); ?> External Link</label>
						<label><?php echo form_radio(array('name' => 'link_type', 'value' => 'IMAGE', 'checked' => set_radio('link_type', 'IMAGE', ($Item->link_type == 'IMAGE') ? TRUE : FALSE))); ?> Link to above Image</label>
						<label><?php echo form_radio(array('name' => 'link_type', 'value' => 'FILE', 'checked' => set_radio('link_type', 'FILE', ($Item->link_type == 'FILE') ? TRUE : FALSE))); ?> Link to Document</label>
					</span>
	            </div>

				<section>
		            <div id="link-internal" style="display: none;">
		                <?php echo form_label('<span class="required">*</span> Page:', 'link_internal'); ?>
		                <?php echo form_dropdown('link_internal', $Pages, set_value('link_internal', isset($Item->link_internal) ? ltrim($Item->link_internal, '/') : ''))?>
		            </div>
		            <div id="link-external" style="display: none;">
		                <?php echo form_label('<span class="required">*</span> URL:', 'link_external'); ?>
		                <?php echo form_input(array( 'name' => 'link_external', 'value' => set_value('link_external', isset($Item->link_external) ? $Item->link_external : ''), 'size' => 80)); ?>
		            </div>
		            <div id="link-file" style="display: none;">
		            	<?php echo form_label('<span class="required">*</span> Document:', 'link_file'); ?>
		                <div class="filename" href="javascript:void(0);" style="display: inline-block; margin-bottom: 8px; font-weight: bold;">
		                	<?php echo set_value('link_file', ($Item->link_file == '') ? 'No File Added' : urldecode(basename($Item->link_file))); ?>
		                </div>
		                <br>
		                <label>&nbsp;</label>
					    <a class="remove_file" href="javascript:void(0);">Remove File</a> |
					    <a class="choose_file" href="javascript:void(0);">Add File</a>
					    <input type="hidden" name="link_file" value="<?php echo set_value('link_file', isset($Item->link_file) ? $Item->link_file : ''); ?>" class="hidden_file" />
		            </div>
	            </section>

	            <div id="link-target">
	                <?php echo form_label('Link Target:', 'link_target'); ?>
	                <?php echo form_dropdown('link_target', array('_blank' => '_blank', '_self' => '_self', '_parent' => '_parent', '_top' => '_top'), set_value('link_target', isset($Item->link_target) ? $Item->link_target : '_self')); ?>
	            </div>

	            <div>
	                <?php echo form_label('Hide Item:', 'hide')?>
	                <span>
	                    <label><?php echo form_checkbox(array( 'name' => 'hide', 'id' => 'hide', 'value' => '1', 'checked' => set_checkbox('hide', '1', (isset($Item->hide) && $Item->hide) ? TRUE : FALSE))); ?> <span style="display: inline;" class="help">(Item will not be shown)<span></label>
	                </span>
	            </div>
	            <div class="clear"></div>
            <?php echo form_close(); ?>
        </div>
    </div>

</div>

<script type="text/javascript">
    $(document).ready( function() {

    	/* Configure the thin version of the CKEditor. */
        var thin_config = {
            toolbar : [
                        { name: 'basicstyles', items : [ 'Bold','Italic','-','NumberedList','BulletedList','-','Link','Unlink'] },
                        { name: 'document', items : [ 'Source' ] }
                    ],
            entities : false,
            resize_maxWidth : '400px',
            width : '800px',
            height : '180px'
        };

        $('textarea#description').ckeditor(thin_config);


        /* Link Type Changes. */
        changeLinkType = function() {

        	var linkType = $("#link-type input[type='radio']:checked").val();

			if (linkType == 'NONE') {
				$('#link-internal').hide();
				$('#link-external').hide();
				$('#link-file').hide();
				$('#link-target').hide();

			} else {

				if (linkType == 'INTERNAL') {
					$('#link-internal').show();
					$('#link-external').hide();
					$('#link-file').hide();

				} else if (linkType == 'EXTERNAL') {
					$('#link-internal').hide();
					$('#link-external').show();
					$('#link-file').hide();

				} else if (linkType == 'IMAGE') {
					$('#link-internal').hide();
					$('#link-external').hide();
					$('#link-file').hide();

				} else if (linkType == 'FILE') {
					$('#link-internal').hide();
					$('#link-external').hide();
					$('#link-file').show();
				}

				$('#link-target').show();
        	}
        };

        $('#link-type input[type="radio"]').change(function() {
        	changeLinkType();
        });

        changeLinkType();

    });
</script>