<!-- meta-box-profile-gallery.php -->
<div id="profile-gallery-container">
    <ul class="profile-gallery-images">
        <?php if ($gallery): ?>
            <?php foreach ($gallery as $image_id): ?>
                <li>
                    <?php echo wp_get_attachment_image($image_id, 'thumbnail'); ?>
                    <button type="button" class="remove-image" data-image-id="<?php echo esc_attr($image_id); ?>">Remove</button>
                </li>
            <?php endforeach; ?>
        <?php endif; ?>
    </ul>
    <button type="button" id="add-gallery-image" class="button">Edit Gallery</button>
    <input type="hidden" id="profile_gallery" name="profile_gallery" value="<?php echo esc_attr(implode(',', (array) $gallery)); ?>">
</div>
