<?php get_header(); ?>

<div class="profile-container">
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
            <div class="profile-details">
                <div class="details-left">
                    <?php if (has_post_thumbnail()) : ?>

                        <?php the_post_thumbnail('large', ['class' => 'profile-image']); ?>


                    <?php endif; ?>
                </div>
                <div class="details-right" style=" background: #f0f0f0;">
                    <h1 class="profile-name"><?php the_title(); ?></h1>
                    <h2 class="profile-role"><?php echo esc_html(get_post_meta(get_the_ID(), 'sub_heading', true)); ?></h2>
                    <div class="profile-content">
                        <?php the_content(); ?>
                    </div>

                </div>
            </div>
            <div class="profile-details">
                <div class="details-left" style=" background: #f0f0f0;">
                    <div class="location-details">
                        <p>Location details</p>
                        <p><?php echo esc_html(get_post_meta(get_the_ID(), 'location', true)); ?></p>
                    </div>
                </div>
                <div class="details-right" style="background: #f0f0f0;">
                    <?php
                    $gallery = get_post_meta(get_the_ID(), 'profile_gallery', true);
                    if (!empty($gallery) && is_array($gallery)) {
                        echo '<div id="gallery-container" class="images-container">';
                        echo '<button id="prev-btn" class="gallery-btn">❮</button>';  // Left navigation button
                        foreach ($gallery as $image_id) {
                            echo '<img class="gallery-image" src="' . wp_get_attachment_url($image_id) . '" />';
                        }
                        echo '<button id="next-btn" class="gallery-btn">❯</button>';  // Right navigation button
                        echo '</div>';
                    }
                    ?>

                </div>
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const container = document.getElementById('gallery-container');
                        const images = Array.from(container.getElementsByClassName('gallery-image'));
                        let index = 0;

                        function updateGallery() {
                            const containerWidth = container.offsetWidth;
                            const imageWidth = images[0].offsetWidth;
                            const shift = index * imageWidth;
                            images.forEach(img => img.style.transform = `translateX(-${shift}px)`);
                        }

                        document.getElementById('prev-btn').addEventListener('click', function() {
                            if (index > 0) {
                                index--;
                                updateGallery();
                            }
                        });

                        document.getElementById('next-btn').addEventListener('click', function() {
                            if (index < images.length - 1) {
                                index++;
                                updateGallery();
                            }
                        });
                    });
                </script>

            </div>

    <?php endwhile;
    endif; ?>
</div>

<?php get_footer(); ?>