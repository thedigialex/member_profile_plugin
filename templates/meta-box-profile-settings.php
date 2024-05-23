<!-- meta-box-profile-settings.php -->
<p>
    <label for="is_featured"><?php _e('Is Featured:', 'textdomain'); ?></label>
    <select name="is_featured" id="is_featured">
        <option value="1" <?php selected($is_featured, '1'); ?>><?php _e('Yes', 'textdomain'); ?></option>
        <option value="0" <?php selected($is_featured, '0'); ?>><?php _e('No', 'textdomain'); ?></option>
    </select>
</p>
<p>
    <label for="sub_heading"><?php _e('Sub Heading', 'textdomain'); ?></label>
    <input type="text" name="sub_heading" id="sub_heading" value="<?php echo esc_attr($sub_heading); ?>">
</p>
<p>
    <label for="location"><?php _e('Location', 'textdomain'); ?></label>
    <input type="text" name="location" id="location" value="<?php echo esc_attr($location); ?>">
</p>