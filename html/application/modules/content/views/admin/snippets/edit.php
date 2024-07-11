<div class="box">
    <div class="heading">
        <h1>
            <img alt="" src="<?php echo theme_url('assets/images/icons/snippets.png'); ?>">Code Snippet
            <?php if ( ! $edit_mode): ?>
                Add
            <?php else: ?>
                Edit - <?php echo $Snippet->title; ?> (<?php echo $Snippet->short_name; ?>)
            <?php endif; ?>
        </h1>

        <div class="buttons">
            <a class="button" href="javascript:void(0);" id="save"><span>Save</span></a>
            <a class="button" href="javascript:void(0);" id="save_exit"><span>Save &amp; Exit</span></a>
            <a class="button" href="<?php echo site_url(ADMIN_PATH . '/content/snippets'); ?>"><span>Cancel</span></a>
        </div>
    </div>
    <div class="content">

        <?php echo form_open('', 'id="snippet_edit"'); ?>
        <div class="form">
            <div>
                <?php echo form_label('<span class="required">*</span> Title', 'title'); ?>
                <?php echo form_input(array('name' => 'title', 'id' => 'title', 'value' => set_value('snippet', !empty($Snippet->title) ? $Snippet->title : ''))); ?>
            </div>
            <div>
                <?php echo form_label('<span class="required">*</span> Short Name:', 'short_name'); ?>
                <?php echo form_input(array('name' => 'short_name', 'id' => 'short_name', 'value' => set_value('snippet', !empty($Snippet->short_name) ? $Snippet->short_name : ''))); ?>
            </div>
        </div>
        <br />
        <div>
        	<div id="snippet-tab">
                <?php echo form_textarea(array('name'=>'snippet', 'id'=>'snippet', 'value'=>set_value('snippet', !empty($Snippet->snippet) ? $Snippet->snippet : ''))); ?>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        var editor = CodeMirror.fromTextArea(document.getElementById("snippet"), {
            lineNumbers: true,
            matchBrackets: true,
            mode: "application/x-httpd-php",
            indentUnit: 4,
            indentWithTabs: true,
            enterMode: "keep",
            tabMode: "shift"
        });

        <?php if ( ! $edit_mode): ?>
            // Auto Generate Url Title
            $('#title').keyup( function(e) {
                $('#short_name').val($(this).val().toLowerCase().replace(/\s+/g, '_').replace(/[^a-z0-9\-_]/g, ''))
            });
        <?php endif; ?>

        // Save Content
        $("#save, #save_exit").click( function() {
            if ($(this).attr('id') == 'save_exit')
            {
                $('<input>').attr({
                    type: 'hidden',
                    name: 'save_exit',
                    value: '1'
                }).appendTo('#snippet_edit');

                $('#snippet_edit').submit();
            }
            else
            {
                $('#snippet_edit').submit();
            }
        });
    });
</script>
