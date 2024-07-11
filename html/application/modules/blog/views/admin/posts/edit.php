<div class="box">
    <div class="heading">
        <h1><img alt="" src="<?php echo theme_url('assets/images/icons/blog-posts.png'); ?>"> <?php echo ($edit_mode) ? 'Edit' : 'Add' ?> Posts</h1>

        <div class="buttons">
            <a class="button" href="#" onClick="$('#blog_post_form').submit();"><span>Save</span></a>
        </div>
    </div>
    <div class="content">

        <?php echo form_open(null, 'id="blog_post_form"')?>

        <div class="form">
            <div>
                <?php echo form_label('<span class="required">*</span> Title:', 'title')?>
                <?php echo form_input(array('name' => 'title', 'value' => set_value('title', isset($Blog_post->title) ? $Blog_post->title : '')))?>
            </div>

            <div>
                <?php echo form_label('<span class="required">*</span> Content:', 'content'); ?>
                <div style="display: inline-block;">
                    <?php echo form_textarea(array( 'name' => 'content', 'id' => 'content', 'value' => set_value('content', isset($Blog_post->content) ? $Blog_post->content : ''))); ?>
                </div>
            </div>

            <div>
                <?php echo form_label('Image:', 'image_filename'); ?>
                <input type="hidden" value="<?php echo set_value('image_filename', isset($Blog_post->image_filename) ? $Blog_post->image_filename : ''); ?>" name="image_filename" id="image_filename" />

                <!-- add image -->
                <span id="add_image_span" style="<?php echo(isset($Blog_post->image_filename) ? 'display: none;' : ''); ?>">
                    <input type="button" name="add_image" id="add_image" value="Add image" />
                </span>

                <!-- change/delete image -->
                <span id="remove_image_span" style="<?php echo(isset($Blog_post->image_filename) ? '' : 'display: none;'); ?>">
                    <a id="change_image" href="javascript:void(0)"><img id="image" src="<?php echo image_thumb($Blog_post->image_filename, 100, 100); ?>" /></a>
                    <input type="button" name="remove_image" id="remove_image" value="Remove image" />
                </span>
            </div>

            <div>
                <?php echo form_label('Alternative Text:', 'image_alt'); ?>
                <?php echo form_input(array( 'name' => 'image_alt', 'value' => set_value('image_alt', isset($Blog_post->image_alt) ? $Blog_post->image_alt : ''))); ?>
            </div>

            <div>
                <?php echo form_label('<span class="required">*</span> Posted Date:', 'posted_date'); ?>
                <?php echo form_input(array('name' => 'posted_date', 'id' => 'posted_date', 'class' => 'datetime', 'value' => set_value('posted_date', isset($Blog_post->posted_date) ? date('m/d/Y h:i:s a', strtotime($Blog_post->posted_date)) : date('m/d/Y h:i:s a')))); ?>
            </div>

            <div>
                <?php echo form_label('<span class="required">*</span> Posted By:', 'posted_by')?>
                <?php echo form_input(array('name' => 'posted_by', 'value' => set_value('posted_by', isset($Blog_post->posted_by) ? $Blog_post->posted_by : '')))?>
            </div>
        </div>

        <div class="clear"></div>

        <?php echo form_close(); ?>
    </div>
</div>

<script type="text/javascript">
    $(document).ready( function() {

        $( ".datetime" ).datetimepicker({
            showSecond: true,
            timeFormat: 'hh:mm:ss tt',
            ampm: true
        });

        // Wrap datepicker popup with a class smoothness for styleing
        $('body').find('#ui-datepicker-div').wrap('<div class="smoothness"></div>');

        $('#add_image').click( function() {
            /* Call the change image handler. */
            $('#change_image').click();
        });

        $('#remove_image').click( function() {
            /* Clear the image holders. */
            $('#image').attr('src', '');
            $('#image_filename').attr('value', '');

            /* Clear the image alt text. */
            $('input[name="image_alt"]').val('');

            /* Switch to the add image form. */
            $('#add_image_span').show();
            $('#remove_image_span').hide();
        });


        $('#change_image').click( function() {
            window.KCFinder = {
                callBack: function(url) {
                    window.KCFinder = null;
                    $.post('<?php echo site_url(ADMIN_PATH . '/blog/posts/create-thumb'); ?>', {'image_path': url}, function(image_path) {
                        $('#image').attr('src', image_path);
                        $('#image_filename').attr('value', url);

                        /* Switch to the remove image form. */
                        $('#add_image_span').hide();
                        $('#remove_image_span').show();
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


        var full_config = {
                toolbar : [
                                { name: 'styles', items : [ 'Styles','Format','Font','FontSize' ] },
                                { name: 'colors', items : [ 'TextColor','BGColor' ] },
                                { name: 'paragraph', items : [ 'NumberedList','BulletedList','-','Outdent','Indent','-','Blockquote','CreateDiv','- ','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock' ] },
                                { name: 'tools', items : [ 'Maximize' ] },
                                                '/',
                                { name: 'basicstyles', items : [ 'Bold','Italic','Underline','Subscript','Superscript','Strike','-','RemoveFormat' ] },
                                { name: 'clipboard', items : [ 'Cut','Copy','Paste','PasteText','PasteFromWord','-','Undo','Redo' ] },
                                { name: 'editing', items : [ 'Find','Replace','-','Scayt' ] },
                                { name: 'insert', items : [ 'Image','MediaEmbed','Table','HorizontalRule','SpecialChar','Iframe' ] },
                                { name: 'links', items : [ 'Link','Unlink','Anchor' ] },
                                { name: 'document', items : [ 'Source' ] }
                            ],
                entities : true,
                extraPlugins : 'stylesheetparser,mediaembed',
                height : '200px',
                filebrowserBrowseUrl : '/application/themes/admin/assets/js/kcfinder/browse.php?type=files',
                filebrowserImageBrowseUrl : '/application/themes/admin/assets/js/kcfinder/browse.php?type=images',
                filebrowserFlashBrowseUrl : '/application/themes/admin/assets/js/kcfinder/browse.php?type=flash',
                filebrowserUploadUrl : '/application/themes/admin/assets/js/kcfinder/upload.php?type=files',
                filebrowserImageUploadUrl : '/application/themes/admin/assets/js/kcfinder/upload.php?type=images',
                filebrowserFlashUploadUrl : '/application/themes/admin/assets/js/kcfinder/upload.php?type=flash'
            };


        $('textarea#content').ckeditor(full_config);
    });
</script>
