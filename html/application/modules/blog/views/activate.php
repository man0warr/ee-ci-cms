
<div id="blog-activation">

    <h1>Activation</h1>

    <?php if ($new_activation): ?>
        <p class="activation-message">
            Congratulations <?php echo $Comment->name ?>! Your comment is now <strong>ACTIVE</strong> and pending approval. Once approved, follow the link below to view your comment.
        </p>
    <?php elseif ($Comment->approved == 'NO'): ?>
        <p class="activation-message">
           Your comment has already been activated. It is currently pending approval. Once approved, follow the link below to view your comment.
        </p>
    <?php else: ?>
        <p class="activation-message">
           Your comment has already been activated. To view your comment please follow the link below.
        </p>
    <?php endif; ?>

    <p class="view-comment">
        <a href="<?php echo site_url('/blog/post/view/' . $Comment->blog_post_id); ?>">View Comment</a>
    </p>

</div>
