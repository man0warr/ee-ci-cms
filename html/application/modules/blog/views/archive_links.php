
<ul id="archive-links">

    <li><a href="javascript:void(0)" data-action="show-all">Show All</a></li>

    <?php foreach($archive_links as $archive_link): ?>
        <li>
            <a href="javascript:void(0)" data-month="<?php echo $archive_link['month']; ?>" data-year="<?php echo $archive_link['year']; ?>">
                <?php echo $archive_link['title']; ?>
            </a>
        </li>
    <?php endforeach; ?>

</ul>

<script>
jQuery(document).ready(function() {

    $('#archive-links a').click(function(e) {

        e.preventDefault();

        // Clear any previous active links
        $('#blog-posts li').show();

        // Ensure all posts are visible before starting to hide posts
        $('#archive-links a').removeClass('active');

        // Do not continue any further if the show all link was clicked
        if ($(this).data('action') == 'show-all') {
            return;
        }

        // Make the link that was clicked on active
        $(this).addClass('active');

        // Get the archive date which is encoded in the link
        var filter_month = $(this).data('month');
        var filter_year = $(this).data('year');

        // Each blog post should have a time tag representing the posted date
        $('#blog-posts > li > time').each(function() {

            // Extract the time tag
            var date_string = $(this).attr('datetime');
            var posted_date = new Date(date_string);

            // Javascript months are zero-based and php months are one-based
            var post_month = posted_date.getMonth() + 1;
            var post_year = posted_date.getFullYear();

            if ((post_month != filter_month) || (post_year != filter_year)) {

                // Hide any blog posts that do not match the archive link that was clicked
                $(this).parents('.blog-post').hide();
            }
        });

    });
});
</script>
