<div class="box">
    <div class="heading">
        <h1><img alt="" src="<?php echo theme_url('assets/images/icons/blog-posts.png'); ?>"> Posts</h1>

        <div class="buttons">
            <a class="button" href="<?php echo site_url(ADMIN_PATH . "/blog/posts/edit"); ?>"><span>Add Post</span></a>
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
                    <th class="sortable">Image</th>
                    <th class="sortable">By</th>
                    <th class="sortable">Date</th>
                    <th class="sortable">Number of Activated Comments</th>
                    <th class="right">#ID</th>
                    <th class="right">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($Blog_posts->exists()): ?>
                    <?php foreach($Blog_posts as $Blog_post):?>
                    <tr>
                        <td class="center"><input type="checkbox" value="<?php echo $Blog_post->id ?>" name="selected[]" /></td>
                        <td><?php echo $Blog_post->title; ?></td>
                        <td><?php echo ($Blog_post->image_filename) ? 'Yes' : 'No'; ?></td>
                        <td><?php echo $Blog_post->posted_by; ?></td>
                        <td><?php echo $Blog_post->posted_date; ?></td>
                        <td><?php echo $Blog_post->comments->where('activated', 'YES')->count(); ?></td>
                        <td class="right"><?php echo $Blog_post->id; ?></td>
                        <td class="right">[ <a href="<?php echo site_url(ADMIN_PATH . '/blog/posts/edit/' . $Blog_post->id) ?>">Edit</a> ] [ <a href="<?php echo site_url(ADMIN_PATH . '/blog/comments/index/' . $Blog_post->id) ?>">Comments</a> ]</td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td class="center" colspan="8">No posts have been added.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        <?php echo form_close(); ?>

    </div>
</div>

<script>
$(document).ready(function() {

    // Delete
    $('.delete').click(function() {
        if (confirm('Delete cannot be undone! Images will remain on the server. Are you sure you want to do this?'))
        {
            $('#form').attr('action', '<?php echo site_url(ADMIN_PATH . '/blog/posts/delete'); ?>').submit();
        }
        else
        {
            return false;
        }
    });

});
</script>