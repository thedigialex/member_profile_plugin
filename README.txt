=== Member Profiles Plugin ===
Contributors: Alejandro Martinez
Tags: profiles, custom post type, member profiles
Requires at least: 4.6
Tested up to: 5.7
Stable tag: 1.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

== Description ==

The Member Profiles plugin allows users to create a custom post type called "Profiles". This plugin displays all profiles on an index page and allows for individual profile view pages.

== Installation ==

1. Upload the `member-profiles` folder to the `/wp-content/plugins/` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Go to **Settings > Permalinks** and click "Save Changes" to flush the rewrite rules.

== Usage ==

1. Navigate to **Profiles > Add New** to create a new profile.
2. Fill in the profile details including the title, content, and featured image.
3. Use the custom meta box to set whether the profile is enabled.
4. Publish the profile.
5. To view the index of all profiles, go to `http://yourdomain.com/profiles/`.
6. To view a single profile, click on the profile title or go to `http://yourdomain.com/profiles/profile-name/`.

== Custom Fields ==

This plugin adds a custom meta box to the profile post type for the following field:

- **Is Enabled:** Select whether the profile is enabled. Options are "Yes" or "No".

== Template Files ==

The plugin includes custom templates for displaying profiles:

- **single-profile.php:** Template for individual profile view pages.

These template files are located in the `templates` folder within the plugin directory.

== Changelog ==

= 1.0 =
* Initial release.

== Frequently Asked Questions ==

= How do I display profiles on my site? =
After creating profiles, visit `http://yourdomain.com/profiles/` to see the profiles index page. Click on a profile to view its details.

= Do I need to modify my theme? =
No, the plugin includes template files that are used to display the profiles index and individual profile pages.

= Can I customize the templates? =
Yes, you can modify the `single-profile.php` files in the `templates` folder to fit your theme's design.

== License ==

This plugin is licensed under the GPLv2 or later. See the LICENSE file for more details.
