<?php get_header(); ?>

<div class="single-profile">
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <h1 class="profile-name"><?php the_title(); ?></h1>
        <?php if (has_post_thumbnail()) : ?>
            <div class="profile-image">
                <?php the_post_thumbnail('large'); ?>
            </div>
        <?php endif; ?>
        <div class="profile-content">
            <?php the_content(); ?>
        </div>
    <?php endwhile; endif; ?>
</div>

<?php get_footer(); ?>
