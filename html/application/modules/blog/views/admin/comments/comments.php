<div class="box">
    <div class="heading">

        <?php if ($Blog_post): ?>
            <h1>
                <img alt="" src="<?php echo theme_url('assets/images/icons/blog-comments.png'); ?>">
                <?php echo $Blog_post->title; ?> (#<?php echo $Blog_post->id; ?>) &ndash; Comments
            </h1>
            <div class="buttons">
                <a class="button viewall" href="#"><span>View All Un-Approved Comments</span></a>
            </div>
        <?php else: ?>
            <h1>
                <img alt="" src="<?php echo theme_url('assets/images/banner.png'); ?>">
                <?php echo "Viewing All Un-Approved Comments"; ?>
            </h1>
        <?php endif; ?>
    </div>
    <div class="content">

        <?php echo form_open(null, 'id=view_comments_form'); ?>
        <table class="list">
            <thead>
                <tr>
                    <th width="50%">Post Title</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Approved</th>
                    <th>#ID</th>
                    <th class="right">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($Comments->exists()): ?>
                    <?php foreach($Comments as $Comment):?>
                    <tr>
                        <td><?php echo ($Blog_post) ? $Blog_post->title : $Comment->blog_post_title; ?></td>
                        <td><?php echo $Comment->name; ?></td>
                        <td><?php echo $Comment->email; ?></td>
                        <td><?php echo ucfirst(strtolower($Comment->approved)); ?></td>
                        <td><?php echo $Comment->id; ?></td>
                        <td class="right">[ <a href="<?php echo site_url(ADMIN_PATH . '/blog/comments/view/'.$Comment->id); ?>">View</a> ]</td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="center">No comments have been added.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        <?php echo form_close(); ?>

    </div>
</div>

<script>
$(document).ready(function() {

    // Approve
    $('.viewall').click(function() {

        $('#view_comments_form').attr('action', '<?php echo site_url(ADMIN_PATH . "/blog/comments"); ?>').submit();
    });


});
</script>