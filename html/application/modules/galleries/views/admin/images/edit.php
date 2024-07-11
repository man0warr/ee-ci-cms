<div class="box">
    <div class="heading">
        <h1><img alt="" src="<?php echo theme_url('assets/images/icons/gallery-images.png'); ?>">Image Edit</h1>

        <div class="buttons">
            <a class="button" href="#" onClick="$('#image_form').submit()"><span>Save</span></a>
            <a class="button" href="<?php echo site_url(ADMIN_PATH . '/galleries/images/index/' . $Image->gallery_id); ?>"><span>Cancel</span></a>
        </div>
    </div>
    <div class="content">

        <div class="form">
            <?php echo form_open(null, 'id="image_form"'); ?>
            <div>
                <?php echo form_label('<span class="required">*</span> Title:', 'title'); ?>
                <?php echo form_input(array( 'name' => 'title', 'value' => set_value('title', isset($Image->title) ? $Image->title : ''), 'size' => 50)); ?>
            </div>

            <div>
                <?php echo form_label('Text 1:', 'text_1'); ?>
                <?php echo form_input(array( 'name' => 'text_1', 'value' => set_value('text_1', isset($Image->text_1) ? $Image->text_1 : ''), 'size' => 80)); ?>
            </div>

            <div>
                <?php echo form_label('Text 2:', 'text_2'); ?>
                <?php echo form_input(array( 'name' => 'text_2', 'value' => set_value('text_2', isset($Image->text_2) ? $Image->text_2 : ''), 'size' => 80)); ?>
            </div>

            <div>
                <?php echo form_label('Text 3:', 'text_3'); ?>
                <?php echo form_input(array( 'name' => 'text_3', 'value' => set_value('text_3', isset($Image->text_3) ? $Image->text_3 : ''), 'size' => 80)); ?>
            </div>

            <div>
                <?php echo form_label('<span class="required">*</span> Image:', 'filename'); ?>
                <a id="change_image" href="javascript:void(0)"><img id="image" src="<?php echo image_thumb($Image->filename, 100, 100); ?>" /></a>
                <input type="hidden" value="<?php echo set_value('filename', isset($Image->filename) ? $Image->filename : ''); ?>" name="filename" id="filename" />
            </div>

            <div>
                <?php echo form_label('Alternative Text:', 'alt'); ?>
                <?php echo form_input(array( 'name' => 'alt', 'value' => set_value('alt', isset($Image->alt) ? $Image->alt : ''), 'size' => 50)); ?>
            </div>

            <div>
                <?php echo form_label('Description:', 'description', array('style' => 'line-height: 285px; vertical-align: 45%;')); ?>
                <div style="display: inline-block;">
                    <?php echo form_textarea(array( 'name' => 'description', 'id' => 'description', 'value' => set_value('description', isset($Image->description) ? $Image->description : ''))); ?>
                </div>
            </div>

            <div>
                <?php echo form_label('URL:', 'url'); ?>
                <?php echo form_input(array( 'name' => 'url', 'value' => set_value('url', isset($Image->url) ? $Image->url : ''), 'size' => 80)); ?>
            </div>

            <div>
                <?php echo form_label('Target:', 'target'); ?>
                <?php echo form_dropdown('target', array('_blank' => '_blank', '_self' => '_self', '_parent' => '_parent', '_top' => '_top'), set_value('target', isset($Image->target) ? $Image->target : '_self')); ?>
            </div>

            <div>
                <?php echo form_label('', '')?>
                <span>
                    <label><?php echo form_checkbox(array( 'name' => 'hide', 'id' => 'hide', 'value' => '1', 'checked' => set_checkbox('hide', '1', (isset($Image->hide) && $Image->hide) ? TRUE : FALSE))); ?> Hide Image <span style="display: inline;" class="help">(Will not be shown in gallery)<span></label>
                </span>
            </div>

            <div class="clear"></div>

            <?php echo form_close(); ?>
        </div>
    </div>

</div>

<script type="text/javascript">
    $(document).ready( function() {

        $('#change_image').click( function() {
            window.KCFinder = {
                callBack: function(url) {
                    window.KCFinder = null;
                    $.post('<?php echo site_url(ADMIN_PATH . '/galleries/images/create-thumb'); ?>', {'image_path': url}, function(image_path) {
                        $('#image').attr('src', image_path);
                        $('#filename').attr('value', url);
                    });
                }
            };
            var left = (screen.width/2)-(800/2);
            var top = (screen.height/2)-(600/2);
            window.open('/application/themes/admin/assets/js/kcfinder/browse.php?type=images',
                'kcfinder_image', 'status=0, toolbar=0, location=0, menubar=0, ' +
                'directories=0, resizable=1, scrollbars=0, width=800, height=600, top=' + top + ', left=' + left
            );
        });


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
    });
</script>
