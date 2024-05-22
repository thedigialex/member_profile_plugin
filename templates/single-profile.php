<?php get_header(); ?>

<style>
    .profile-container {
        margin: 32px;
        padding: 32px;
    }
	.profile-image {
		border-radius: 16px;
	}
    .profile-details {
        display: grid;
        grid-template-columns: 1fr 2fr;
        gap: 20px;
    }
    .details-left, .details-right {
        padding: 15px;
    }
    .images-container {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 10px;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .profile-details {
            grid-template-columns: 1fr; 
        }
        .images-container {
            grid-template-columns: repeat(2, 1fr); 
        }
    }

    @media (max-width: 480px) {
        .profile-container {
            margin: 16px;
            padding: 16px;
        }
        .images-container {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="profile-container">
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <div class="profile-details">
            <div class="details-left">
                <?php if (has_post_thumbnail()) : ?>
                    <div class="profile-image">
                        <?php the_post_thumbnail('large'); ?>
                    </div>
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
                </div>
            </div>
            <div class="details-right" style="background: #f0f0f0;">
    <?php
    $gallery = get_post_meta(get_the_ID(), 'profile_gallery', true); 
    if (!empty($gallery) && is_array($gallery)) { 
        echo '<div class="images-container">'; 
        foreach ($gallery as $image_id) {
            echo wp_get_attachment_image($image_id, 'medium');  
        }
        echo '</div>';
    }
    ?>
</div>

        </div>
	
    <?php endwhile; endif; ?>
</div>

<?php get_footer(); ?>
