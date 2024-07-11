<div class="box">

    <div class="heading">
        <h1><img alt="" src="<?php echo theme_url('assets/images/icons/mediaboxes.png'); ?>"> Media Boxes</h1>
        <div class="buttons">
            <a class="button" href="<?php echo site_url(ADMIN_PATH . "/mediaboxes/edit"); ?>"><span>Add Media Box</span></a>
            <a class="button delete" href="#"><span>Delete</span></a>
        </div>
    </div>

    <div class="content">
        <?php echo form_open(null, 'id="form"'); ?>
	        <table class="list">
	            <thead>
	                <tr>
	                    <th width="1" class="center"><input type="checkbox" onClick="$('input[name*=\'selected\']').attr('checked', this.checked);" /></th>
	                    <th class="sortable">Title</th>
	                    <th class="right">#ID</th>
	                    <th class="right">Action</th>
	                </tr>
	            </thead>
	            <tbody>
                <?php if ($Mediaboxes->exists()): ?>

                    <?php foreach($Mediaboxes as $Mediabox):?>
                    <tr>
                        <td class="center"><input type="checkbox" value="<?php echo $Mediabox->id ?>" name="selected[]" /></td>
                        <td><?php echo $Mediabox->title; ?></td>
                        <td class="right"><?php echo $Mediabox->id; ?></td>
                        <td class="right">[ <a href="<?php echo site_url(ADMIN_PATH . '/mediaboxes/edit/' . $Mediabox->id) ?>">Rename</a> ] [ <a href="<?php echo site_url(ADMIN_PATH . '/mediaboxes/items/index/' . $Mediabox->id) ?>">Edit</a> ]</td>
                    </tr>
                    <?php endforeach; ?>

                <?php else: ?>

                    <tr>
                        <td class="center" colspan="4">No mediaboxes have been added.</td>
                    </tr>

                <?php endif; ?>
	            </tbody>
	        </table>
        <?php echo form_close(); ?>
    </div>

</div>

<script>
$(document).ready(function() {

	/* Delete Media Box */
    $('.delete').click(function() {
        if (confirm('Delete cannot be undone! Are you sure you want to do this?\n\n NOTE: Any images or files will remain on the server.')) {
            $('#form').attr('action', '<?php echo site_url(ADMIN_PATH . '/mediaboxes/delete'); ?>').submit();
        } else {
            return false;
        }
    });

});
</script>
