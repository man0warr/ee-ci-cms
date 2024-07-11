
<!-- Construct the gallery HTML -->
<div id="<?php echo $unique_id; ?>" class="fancybox-gallery" data-options=<?php echo json_encode($options); ?>>

    <a class="fancybox open" href="<?php echo $images[0]['image']; ?>" title="<?php echo $images[0]['title']; ?>">
        <figure>
            <img src="<?php echo image_thumb($images[0]['image'], $thumb_width, $thumb_height, true); ?>" alt="<?php echo $images[0]['title']; ?>" />
        </figure>
    </a>

</div>


<!-- Initialise the gallery -->
<script type="text/javascript">

    jQuery(document).ready(function() {

        var uniqueId = "#<?php echo $unique_id; ?>";

        // Get a handle to this instance of the gallery
        var galleryHandle = uniqueId + " .fancybox.open";

        // Accept an array of images from the server and extract the options from the data object
        var images = <?php echo json_encode($single_images); ?>;
        var options = jQuery(uniqueId).data('options');

        // Manually open the fancyBox gallery when the target is clicked on
        jQuery(galleryHandle).click(function() {

            jQuery.fancybox.open(images, options);
            return false;
        });

    });

</script>
