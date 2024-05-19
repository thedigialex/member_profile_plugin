<?php get_header(); ?>

<div class="featured-profiles">
    <?php
    $featured_args = array(
        'post_type' => 'profile',
        'meta_key' => 'is_featured', // Assuming you have a custom field 'is_featured'
        'meta_value' => '1',
    );
    $featured_query = new WP_Query($featured_args);

    if ($featured_query->have_posts()) : while ($featured_query->have_posts()) : $featured_query->the_post(); ?>
        <div class="featured-profile">
            <?php if (has_post_thumbnail()) : ?>
                <div class="profile-image">
                    <?php the_post_thumbnail('medium'); ?>
                </div>
            <?php endif; ?>
            <h2 class="profile-name"><?php the_title(); ?></h2>
            <a href="<?php the_permalink(); ?>">View Profile</a>
        </div>
    <?php endwhile; wp_reset_postdata(); endif; ?>
</div>

<div class="profile-list">
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <div class="profile-item">
            <?php if (has_post_thumbnail()) : ?>
                <div class="profile-image">
                    <?php the_post_thumbnail('medium'); ?>
                </div>
            <?php endif; ?>
            <h2 class="profile-name"><?php the_title(); ?></h2>
            <a href="<?php the_permalink(); ?>">View Profile</a>
        </div>
    <?php endwhile; endif; ?>
</div>

<?php get_footer(); ?>
