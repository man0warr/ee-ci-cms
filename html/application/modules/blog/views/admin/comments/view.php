<div class="box">
    <div class="heading">
        <h1><img alt="" src="<?php echo theme_url('assets/images/icons/blog-comments.png'); ?>"> Viewing Comment (#<?php echo $Comment->id; ?>)</h1>

        <div class="buttons">
            <a class="button approve" href="#"><span>Approve</span></a>
            <a class="button delete" href="#"><span>Delete</span></a>
        </div>
    </div>
    <div class="content">

        <?php echo form_open(null, 'id="view_comment_form"')?>

        <div class="form">
            <div>
                <label>Name:</label>
                <span><?php echo $Comment->name; ?></span>
            </div>
            <div>
                <label>Email:</label>
                <span><?php echo $Comment->email; ?></span>
            </div>
            <div>
                <label>Comment:</label>
                <span><?php echo $Comment->content; ?></span>
            </div>
            <div>
                <label>Date:</label>
                <span><?php echo date("jS F Y", strtotime($Comment->comment_date)); ?></span>
            </div>
            <div>
                <label>Activated:</label>
                <span><?php echo ucfirst(strtolower($Comment->activated)); ?></span>
            </div>
            <div>
                <label>Approved:</label>
                <span><?php echo ucfirst(strtolower($Comment->approved)); ?></span>
            </div>
        </div>

        <div class="clear"></div>

        <?php echo form_close(); ?>
    </div>
</div>

<script>
$(document).ready(function() {

    // Approve
    $('.approve').click(function() {

        if ("<?php echo $Comment->activated; ?>" == 'NO') {
            alert("Comment can not be aproved before it has been activated.");
            return false;
        }

        if ("<?php echo $Comment->approved; ?>" == 'YES') {
            alert("Comment already approved.");
            return false;
        }

        $('#view_comment_form').attr('action', '<?php echo site_url(ADMIN_PATH . "/blog/comments/approve/" . $Comment->id); ?>').submit();
    });

    // Delete
    $('.delete').click(function() {
        if (confirm('Delete cannot be undone! Are you sure you want to do this?'))
        {
            $('#view_comment_form').attr('action', '<?php echo site_url(ADMIN_PATH . "/blog/comments/delete/" . $Comment->id); ?>').submit();
        }
        else
        {
            return false;
        }
    });

});
</script>