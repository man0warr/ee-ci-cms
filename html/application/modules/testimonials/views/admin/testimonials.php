<div class="box">
    <div class="heading">
        <h1><img alt="" src="<?php echo theme_url('assets/images/icons/testimonials.png'); ?>"> Testimonials</h1>

        <div class="buttons">
            <a class="button" href="<?php echo site_url(ADMIN_PATH . "/testimonials/edit"); ?>"><span>Add Testimonial</span></a>
            <a class="button delete" href="#"><span>Delete</span></a>
        </div>
    </div>
    <div class="content">

        <?php echo form_open(null, 'id="form"'); ?>
        <table id="testimonial_table" class="list">
            <thead>
                <tr class="nodrag nodrop">
                    <th style="width: 10px;"></th>
                    <th width="1" class="center"><input type="checkbox" onClick="$('input[name*=\'selected\']').attr('checked', this.checked);" /></th>
                    <th class="sortable">By</th>
                    <th class="right">#ID</th>
                    <th class="right">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($Testimonials->exists()): ?>
                    <?php foreach($Testimonials as $Testimonial):?>
                    <tr id="<?php echo $Testimonial->id; ?>">
                        <td class="drag_handle"></td>
                        <td class="center"><input type="checkbox" value="<?php echo $Testimonial->id ?>" name="selected[]" /></td>
                        <td><?php echo $Testimonial->by; ?></td>
                        <td class="right"><?php echo $Testimonial->id; ?></td>
                        <td class="right">[ <a href="<?php echo site_url(ADMIN_PATH . '/testimonials/edit/' . $Testimonial->id) ?>">Edit</a> ]</td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td class="center" colspan="5">No testimonials have been added.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        <?php echo form_close(); ?>

    </div>
</div>

<script>
$(document).ready(function() {

    initDnD = function() {
        // Sort images (table sort)
        $('#testimonial_table').tableDnD({
            onDrop: function(table, row) {
                show_status('Saving...', false, true);
                order = $('#testimonial_table').tableDnDSerialize()
                $.post('<?php echo site_url(ADMIN_PATH . '/testimonials/order') ?>', order, function() {
                    show_status('Saved', true, false);
                } );
            },
            dragHandle: "drag_handle"
        });
    }

    // Delete
    $('.delete').click(function() {
        if (confirm('Delete cannot be undone! Are you sure you want to do this?'))
        {
            $('#form').attr('action', '<?php echo site_url(ADMIN_PATH . '/testimonials/delete'); ?>').submit();
        }
        else
        {
            return false;
        }
    });

    initDnD();
});
</script>