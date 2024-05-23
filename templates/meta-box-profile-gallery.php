<div id="profile-gallery-container">
    <ul class="profile-gallery-images">
        <?php if ($gallery) : ?>
            <?php foreach ($gallery as $image_id) : ?>
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
<script>
    jQuery(document).ready(function($) {
        $('#add-gallery-image').on('click', function(e) {
            e.preventDefault();
            var frame = wp.media({
                title: 'Select or Upload Images for Profile Gallery',
                button: {
                    text: 'Use these images'
                },
                multiple: 'add'
            }).open().on('select', function() {
                var attachment = frame.state().get('selection').map(function(attachment) {
                    attachment.toJSON();
                    return attachment;
                });
                var galleryIds = [];
                attachment.forEach(function(item) {
                    $('#profile-gallery-container .profile-gallery-images').append('<li><img style="width:120px; height:120px;" src="' + item.attributes.url + '" /><button type="button" class="remove-image" data-image-id="' + item.id + '">Remove</button></li>');
                    galleryIds.push(item.id);
                });
                $('#profile_gallery').val(galleryIds.join(','));
            });
        });

        // Remove image from gallery
        $('body').on('click', '.remove-image', function() {
            $(this).parent().remove();
            var updatedGallery = [];
            $('#profile-gallery-container .profile-gallery-images li').each(function() {
                updatedGallery.push($(this).find('.remove-image').data('image-id'));
            });
            $('#profile_gallery').val(updatedGallery.join(','));
        });
    });
</script>