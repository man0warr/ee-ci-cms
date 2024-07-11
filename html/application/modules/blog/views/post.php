
<div id="single-blog-post">

    <h1>Blog</h1>

    <!-- Display any thank you messages. -->
    <?php if ($thank_you): ?>
        <p class="success">Your comment has been successfully submitted. You will receive an email shortly to confirm your email address.</p>
    <?php endif; ?>

    <!-- Display the Blog Post. -->
    <article class="blog-post">
        <h2><?php echo $Blog_post->title; ?></h2>

        <div class="post-details">
            Posted by <span class="posted-by"><?php echo $Blog_post->posted_by; ?></span>
            <time datetime="<?php echo $Blog_post->posted_date; ?>">
                on <span class="posted-date"><?php echo date("jS F Y", strtotime($Blog_post->posted_date)); ?></span>
            </time>
        </div>

        <?php if ($Blog_post->image_filename): ?>
            <figure><img src="<?php echo $Blog_post->image_filename; ?>" alt="<?php echo $Blog_post->image_alt; ?>" /></figure>
        <?php endif; ?>

        <div class="blog-content">
            <?php echo $Blog_post->content; ?>
        </div>
    </article>

    <?php if ($display_comments): ?>

        <br />

        <!-- List any existing comments. -->
        <?php if ($Comments->where('approved', 'YES')->count() > 0): ?>

            <section class="blog-comments">
                <h2>Comments:</h2>

                <ul>
                    <?php foreach($Comments as $Comment): ?>
                        <li>
                            <small>
                                <?php echo $Comment->comment_date; ?> |
                                <strong><?php echo $Comment->name; ?></strong> (<?php echo $Comment->email; ?>)
                            </small>
                            <p>
                                <em><?php echo $Comment->content; ?></em>
                            </p>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </section>

        <?php endif; ?>

        <br />

        <!-- Display the form to submit comments. -->
        <section class="comments-message">
            <?php if ($Comments->where('approved', 'YES')->count() > 0): ?>
                <h2>Leave a comment...</h2>
            <?php else: ?>
                <h2>Be the first to leave a comment...</h2>
            <?php endif; ?>
        </section>

        <br />

        <?php echo validation_errors()?>

        <?php echo form_open('/blog/post/add', 'id="add_comment_form"')?>
            <div>
                <?php echo form_label('<span class="required">*</span> Name:', 'name')?>
                <?php echo form_input(array('name' => 'name', 'value' => set_value('name', isset($New_Comment->name) ? $New_Comment->name : '')))?>
            </div>
            <div>
                <?php echo form_label('<span class="required">*</span> Email:', 'email')?>
                <?php echo form_input(array('name' => 'email', 'value' => set_value('email', isset($New_Comment->email) ? $New_Comment->email : '')))?>
            </div>
            <div>
                <?php echo form_label('<span class="required">*</span> Comment:', 'comment')?>
                <?php echo form_textarea(array('name' => 'comment', 'rows' => '4', 'value' => set_value('comment', isset($New_Comment->content) ? $New_Comment->content : '')))?>
            </div>
            <div>
                <?php echo form_label('&nbsp;', 'captcha_image')?>
                <img src="<?php echo site_url('contact/captcha'); ?>">
            <div>
            </div>
                <?php echo form_label('<span class="required">*</span> Please enter the characters:', 'captcha_input')?>
                <?php echo form_input(array('name' => 'captcha_input', 'value' => ''))?>
            </div>
            <div>
                <?php echo form_label('', 'submit')?>
                <?php echo form_input(array('name' => 'blog_post_id', 'type' => 'hidden', 'value' => $Blog_post->id))?>
                <?php echo form_input(array('name' => 'submit', 'type' => 'submit', 'value' => 'Submit', 'class' => 'submit'))?>
            </div>
            <div class="clear"></div>
        <?php echo form_close(); ?>

    <?php endif; ?>

</div>
