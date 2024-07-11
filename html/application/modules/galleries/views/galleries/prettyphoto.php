
<!-- Construct the gallery HTML -->
<div id="<?php echo $unique_id; ?>" class="prettyphoto-gallery" data-options=<?php echo json_encode($options); ?>>

    <?php foreach($images as $image): ?>

        <a class="prettyphoto" href="<?php echo $image['image']; ?>" rel="prettyPhoto[pp_gal]" title="<?php echo $image['title']; ?>">
            <figure>
                <img src="<?php echo image_thumb($image['image'], $thumb_width, $thumb_height, true); ?>" alt="<?php echo $image['title']; ?>" />
            </figure>
        </a>

    <?php endforeach; ?>

</div>


<!-- Initialise the gallery -->
<script type="text/javascript">

    jQuery(document).ready(function() {

        var uniqueId = "#<?php echo $unique_id; ?>";

        // Get a handle to this instance of the gallery and extract its options from the data object
        var galleryHandle = uniqueId + " a[rel^='prettyPhoto']";
        var options = jQuery(uniqueId).data('options');

        jQuery(galleryHandle).prettyPhoto(options);
    });

</script>
