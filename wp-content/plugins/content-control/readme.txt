=== Content Control - The Ultimate Content Restriction Plugin! Restrict Content, Create Conditional Blocks & More ===
Contributors: codeatlantic, danieliser
Author URI: https://code-atlantic.com/?utm_campaign=upgrade-to-pro&utm_source=plugins-page&utm_medium=plugin-ui&utm_content=action-links-upgrade-text
Plugin URI: https://contentcontrolplugin.com/?utm_campaign=plugin-info&utm_source=readme-header&utm_medium=plugin-ui&utm_content=author-uri
Donate link: https://code-atlantic.com/donate/?utm_campaign=donations&utm_source=readme-header&utm_medium=plugin-ui&utm_content=donate-link
Tags: access control, content, content restriction, permission, private, restrict, restrict access, restriction, user, visibility, widget, block visibility, user access, coming soon, maintenance mode, access manager, paywall
Requires at least: 5.6
Tested up to: 6.4
Stable tag: 2.0.12
Requires PHP: 5.6
License: GPLv3 (or later)

Restrict content based on login status, user roles, device type & more. Monetize your content with a paywall or members-only content.

== Description ==

Content Control is a transformative plugin, allowing you to fine-tune every aspect of your WordPress website's content. Decide who gets to see what, where, and when - be it pages, posts, widgets, or individual block visibility using our handy shortcode. Your content, your rules, executed perfectly!

Content Control is intuitive and powerful, designed for all users—whether logged in, holding specific roles, or even guests. Need top-tier content restriction or a dependable access manager for your site? Look no further. We've expanded our controls to include Gutenberg and Full Site Editor, giving you unmatched command.

= Key Features =

Discover what Content Control brings to your table:

- Full control over your site's content, restrict user access with ease!.
- Set up a seamless paywall for your content, providing teasers for users and prompting them to purchase access.
- Per block controls for Gutenberg and Full Site Editor, including user roles, device type, and more.
  - Responsive block controls with customizable breakpoints.
  - Control block visibility by user status, roles, device type & more.
- Restrict access to pages, posts, widgets, and individual blocks based on user status, roles, device type & more.
- Offer membership tools for crafting membership access and members-only content.
- Provide responsive block designs that adapt to varying device sizes.
- Lockdown content selectively for improved user experiences.
- Implement role-based redirections to guide users effectively.
- Unlock the power of subscription content and monetization strategies.
- Safeguard specific categories, tags, custom post types, and custom taxonomies.
- Manage access to [media attachment pages](https://www.hongkiat.com/blog/wordpress-attachment-pages/) for logged in/out users or specific user roles.
- Display a custom message to users who do not have permission to view the content.
- Display specific content on a page or post to logged in users only, specific user roles, or logged out users.
- Redirect users without access permission to a login page, website homepage, or a custom URL.
- Highlight subscriber-only content for premium users.
- Use the `[content_control]` shortcode to protect content inline and cater to subscriber preferences.
- Control widget visibility by selecting the user type that can view each widget.
- Conditionally show coming soon or maintenance mode pages based on various rules.

[Content Control Documentation](https://contentcontrolplugin.com/docs/?utm_campaign=plugin-info&utm_source=readme-description&utm_medium=wordpress&utm_content=documentation-link)

= Pro Features = 

Coming soon: Content Control Pro, with advanced features like:

- Content Teasers for Paywalls, giving your users a sneak peek, leaving them wanting more.
- Optimize your WooCommerce & Easy Digital Downloads (EDD) experiences with advanced rules.
- Schedule blocks, controlling content visibility timings using customizable scheduling rules.
- Dive deeper with advanced block rules and a boolean editor.
- Customize login, registration & recovery page urls. Custom login urls give a more personalized user experience.

**Note**: Content Control handles media access via content on media attachment pages but won't restrict direct server-level access to media files.

= Passionately Crafted by Code Atlantic =

At [Code Atlantic][codeatlantic], we're passionate about crafting tools that empower your digital journey. Content Control is a testament to our commitment to quality.

Dive into some of our renowned plugins:

- **[Popup Maker][popupmaker]** - The #1 Popup & Marketing Plugin for WordPress
- **[User Menus][usermenus]** - Innovatively Show, Hide & Customize Menu Items

[codeatlantic]: https://code-atlantic.com "Code Atlantic - High Quality WordPress Plugins"
[popupmaker]: https://wppopupmaker.com "#1 Popup & Marketing Plugin for WordPress"
[usermenus]: https://wordpress.org/plugins/user-menus/ "Show, Hide & Customize Menu Items For Different Users"

== Installation ==

- Install Content Control either via the WordPress.org plugin repository or by uploading the files to your server.
- Activate Content Control.

If you need help getting started with Content Control please see [FAQs][faq page] which explains how to use the plugin.

[faq page]: https://wordpress.org/plugins/content-control/faq/ "Content Control FAQ"

== Frequently Asked Questions ==

= Where can I get support? =

If you get stuck, you can ask for help in the [Content Control Plugin Forum](http://wordpress.org/support/plugin/content-control).

= Where can I report bugs or contribute to the project? =

Bugs can be reported either in our support forum or we are happy to accept PRs on the [Content Control GitHub repo](https://github.com/code-atlantic/content-control/issues).

== Screenshots ==

1. Restrict access to individual blocks.
2. Create unlimited restriction sets.
3. Choose who can see the restricted content.
4. Display a message in place of restricted content.
5. Redirect users to log in or to another page if they access restricted content.
6. Choose any content you can think of to protect.
7. Use shortcodes to protect content inline.
8. Restrict widgets as well.

== Changelog ==

= v2.0.12 - 10/26/2023 =

- Fix: Prevent extra 301 redirect due to missing trailing slash on some URLs.
- Fix: Issue with Custom Message replacement not always working on pages built with Elementor.

= v2.0.11 - 10/04/2023 =

- Improvement: Query Monitor integration to show which restrictions are active on a page.
  - Shows global settings that may be affecting the page.
  - Shows which restrictions are active on the page.
  - Shows which posts are being filtered out of queries and by which restriction.
- Tweak: Ensure upgrade stream doesn't send headers if they were already sent.
- Tweak: Make second arg on get_the_excerpt filter optional to prevent errors with some plugins.
- Fix: Bug when using `content_control/check_all_restrictions` filter that caused rules to not compare properly.

= v2.0.10 - 10/01/2023 =

- Improvement: If no v1 global restrictions existed, skip the migration step entirely.
- Improvement: Default to late init of post query filtering until after plugins_loaded should be finished. This should prevent help prevent random errors due to restrictions being checked before plugins have had a chance to register their post types, and thus restrictions won't properly match those post type rules.
- Improvement: Add check to prevent restriction checks for **WP CLI** requests.
- Improvement: Add notice to indicate is when waiting for post/page search results in the restriction editor fields.
- Tweak: Fix issue in build that caused autoloader to not fully use optimized classmap, should result in improved performance.
- Fix: Ensure `$wp_rewrite` is available before calling `is_rest()` -> `get_rest_url()`. This should prevent errors when using the plugin with **WP CLI** and when plugins make `WP_Query` calls during `plugins_loaded`.
- Fix: Don't attempt to initialize side query filtering until after_theme_setup hook. This should prevent errors when plugins make `WP_Query` calls during `plugins_loaded`, and allow further delaying initialization if needed from themes `functions.php` file.
- Fix: Backward compatibility issue with WP versions <6.2 that made settings page not render.
- Fix: Bug where Block Controls didn't work on WooCommerce pages. This was filtering `pre_render_block` but not returning a value. Now we run our check after theirs to ensure that bug has no effect on our plugin. [Report](https://github.com/woocommerce/woocommerce-blocks/issues/11077)

= v2.0.9 - 09/24/2023 =

- Improvement: Better handling of restriction titles & content. Admins with priv can insert any content into the restriction messages.
- Improvement: Added new filter `content_control/query_filter_init_hook` to allow delaying query filtering for compatibility with plugins that make custom queries before `template_redirect` action.

```
add_filter( 'content_control/query_filter_init_hook', function () {
    return 'init'; // Try setup_theme, after_theme_setup, init or wp_loaded
} );
```

- Tweak: Ensure our restriction checks work within a nested post loop.
- Tweak: Change how restriction title & descriptions were sent/received over Rest API.
- Fix: Bug that caused some shortcodes to not render properly.
- Fix: Bug where override message wasn't used.
- Fix: Bug where Elementor Post loop would render incorrectly when using ACF fields in the loop template.

= v2.0.8 - 09/22/2023 =

- Tweak: Ignore many Elementor queries from being restricted.
- Fix: Error when required upgrade was marked as complete.
- Fix: Bug that caused secondary queries to be handled like main queries.

= v2.0.7 - 09/21/2023 =

- Tweak: Only log each unique plugin debug notice once to prevent filling log files quickly.
- Tweak: Replace usage of `wp_upload_dir` with `wp_get_upload_dir` which is more performant.
- Fix: Error in upgrades when no data is found to migrate.
- Fix: Error when function is called early & global $wp_query is not yet available.
- Fix: Conditional check that could always return false.
- Developer: Implemented PHP Static Analysis to catch more bugs before they happen. Currently clean on lvl 6.

= v2.0.6 - 09/19/2023 =

- Improvement: Added data backup step to upgrade process that stores json export in the media library.
- Improvement: Better error handling in the data upgrade process.
- Fix: Fix bug in data upgrade process that caused it to never finish.
- Fix: Possible error when no restriction match found in some custom` queries.

= v2.0.5 - 09/18/2023 =

- Fix: Fix errors on some sites with custom conditions due to registering all rules too early.

= v2.0.4 - 09/18/2023 =

- Fix: Error when WP Query vars include anonymous function closures.

= v2.0.3 - 09/18/2023 =

- Fix: Log errors instead of throwing exceptions to prevent uncaught exceptions turning into fatal errors.

= v2.0.2 - 09/18/2023 =

- Fix: Fatal error from error logger on systems without write access.

= v2.0.1 - 09/17/2023 =

- Fix: Fatal error from unregistered or unknown rule types from 3rd party plugins/themes or custom code. Now they are logged in plugin settings page.

= v2.0.0 - 09/17/2023 =

- Feature: Restrict individual blocks in the Gutenberg editor.
- Feature: Restrict individual blocks in the Full Site Editor.
- Feature: Use a custom page template for restricted content.
- Feature: Restrict blocks by device type with customizable breakpoints.
- Feature: Restrict blocks by user status & role.
- Feature: Global restrictions now offer more control over how restricted content is handled.
  - Choose to redirect or replace content with a custom page.
  - Filter or hide posts in archives or custom loops.
  - Secondary controls for posts if found in an archive.
- Improvement: Match or exclude specific roles.
- Improvement: Updated interface with intuitive and responsive controls.
- Improvement: Boolean editor improvements.
- Improvement: Control who can modify plugin settings.
- Improvement: Upgraded tooling & Code quality improvements.

= v1.1.10 - 12/28/2022 =

- Security: Fix unescaped output for CSS classname in the [contentcontrol] shortcode allowing users with the ability to edit posts to inject code into the page.

= v1.1.9 - 09/30/2021 =

- Fix: Error when using Gutenberg Preview.

= v1.1.8 - 07/17/2021 =

- Fix: Error when Elementor instance preview proptery was null.

= v1.1.7 - 07/17/2021 =

- Fix: Prevent warning if widget settings don't exist in options table.
- Fix: Arbitrary limit of 10 on current items listed in Restriction Editor due to WP query default args.
- Fix: Prevent restrictions from activating when using the Elementor page builder.

= v1.1.6 - 03/21/2021 =

- Fix: Nonce validation was preventing 3rd party plugin from saving widget settings when it failed. Thanks @jacobmischka
- Fix: Prevent corrupted options from preventing saving of settings.

= v1.1.5 - 02/22/2021 =

- Fix: Issue where roles with `-` would not save when checked.

= v1.1.4 - 03/24/2020 =

- Improvement: Added gettext handling for several strings that were not translatable.
- Tweak: Process shortcodes in default denial message contents.
- Tweak: Various improvements in form reliability & user experience.
- Fix: Issues with ajax search fields not retaining their values after save.
- Fix: Issue where only would show 10 pages.
- Fix: PHP 7.4 compatibility fixes.

= v1.1.3 - 12/03/2019 =

- Fix: Custom post type conditions were not always registered.

= v1.1.2 - 11/10/2019 =

- Tweak: Remove erroneous console.log messages in admin.
- Fix: Fatal error when empty shortcode used.

= v1.1.1 - 10/15/2019 =

- Fix: Bugs where variables were not always the expected type.

= v1.1.0 =

- Improvement: Added default denial message to shortcode.
- Improvement: Render nested shortcodes in the [content_control] shortcode.
- Fix: Bug where multiple roles checked together in restriction editor.

= v1.0.3 =

- Fix: Minor notice on activation.

= v1.0.2 =

- Fix: Call to undefined function.

= v1.0.1 =

- Fix: Non static method called statically
- Fix: Bug when using invalid variable type.

= v1.0.0 =

- Initial Release
