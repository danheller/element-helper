=== Element Helper ===
Contributors: phoenixdigi, namncn, danheller
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl.html
Tags: elementor
Tested up to: 5.0.3
Requires PHP: 5.6

Adds a set of custom Elementor blocks.

== Description ==

Adds a set of custom Elementor blocks.

== Installation ==

=== Manually ===

1. Upload the `element-helper` folder to the `/wp-content/plugins/` directory
2. Activate the Element Helper plugin through the 'Plugins' menu in WordPress
3. Go to "after activation" below.

== History ==

This plugin was created and previously maintained by Sabber Hossain, and information about it was hosted at (http://sabberhossain.com/plugins/elh-elementor/). Since the plugin hasn't been updated and had conflicts that were causing errors in current versions of Elementor, this is a forked plugin version to correct those errors.


== Changelog ==

= 1.0.0 =
* First release.

= 1.0.1 =
* Fork to fix bugs affecting the Elementor editing screen
* Swap out the deprecated typography module for the newer typography module (post-tab-widget.php)
* Correct javascript error caused by editor.min.js referencing an uninitialized "elementor" object. (editor.min.js)
* Check whether "$customize_cat_id" variable is set before referencing it (post-list-widget.php
