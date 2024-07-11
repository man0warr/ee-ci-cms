<div class="box">

    <div class="heading">
        <h1><img alt="" src="<?php echo theme_url('assets/images/icons/mediabox-items.png'); ?>"> <?php echo $Mediabox->title; ?> (#<?php echo $Mediabox->id; ?>) &ndash; Items</h1>
        <div class="buttons">
            <a class="button" href="<?php echo site_url(ADMIN_PATH . "/mediaboxes/items/edit/{$mediabox_id}"); ?>"><span>Add Items</span></a>
            <a class="button delete" href="#"><span>Delete</span></a>
        </div>
    </div>

    <div class="content">
        <?php echo form_open(null, 'id=form'); ?>
	        <table id="item_table" class="list">
	            <thead>
	                <tr class="nodrag nodrop">
	                    <th style="width: 10px;"></th>
	                    <th width="1" class="center"><input type="checkbox" onClick="$('input[name*=\'selected\']').attr('checked', this.checked);" /></th>
	                    <th width="35%">Title</th>
	                    <th>Link Type</th>
	                    <th>Hidden</th>
	                    <th class="right">Action</th>
	                </tr>
	            </thead>
	            <tbody>
                <?php if ($Items->exists()): ?>

                    <?php foreach($Items as $Item):?>
                    <tr id="<?php echo $Item->id; ?>">
                        <td class="drag_handle"></td>
                        <td class="center"><input type="checkbox" value="<?php echo $Item->id; ?>" name="selected[]" /></td>
                        <td><?php echo $Item->title; ?></td>
                        <td><?php echo $Item->link_type; ?></td>
                        <td><?php echo ($Item->hide) ? 'Yes' : 'No'; ?></td>
                        <td class="right">[ <a href="<?php echo site_url(ADMIN_PATH . '/mediaboxes/items/edit/'.$mediabox_id.'/'.$Item->id); ?>">Edit</a> ]</td>
                    </tr>
                    <?php endforeach; ?>

                <?php else: ?>

                    <tr>
                        <td colspan="6" class="center">No items have been added.</td>
                    </tr>

                <?php endif; ?>
	            </tbody>
	        </table>
        <?php echo form_close(); ?>
    </div>

</div>

<script>
$(document).ready(function() {

    /* Delete item */
    $('.delete').click( function() {
        if (confirm('Delete cannot be undone! Any images or files will remain on the server. Are you sure you want to do this?')) {
            $('#form').attr('action', '<?php echo site_url(ADMIN_PATH . '/mediaboxes/items/delete/' . $Mediabox->id); ?>').submit();
        } else {
            return false;
        }
    });

	/* Item sort (drag & drop) */
    initDnD = function() {
        $('#item_table').tableDnD({
            onDrop: function(table, row) {
                show_status('Saving...', false, true);
                order = $('#item_table').tableDnDSerialize();
                $.post('<?php echo site_url(ADMIN_PATH . '/mediaboxes/items/order') ?>', order, function() {
                    show_status('Saved', true, false);
                });
            },
            dragHandle: "drag_handle"
        });
    };

    /* Call Drag & Drop on startup. */
    initDnD();

});
</script>
