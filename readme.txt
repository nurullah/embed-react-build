=== Embed React Build ===
Contributors:
Donate link:
Tags: react, build, embed
Requires at least: 4.7
Tested up to: 5.8.1
Stable tag: 1.0.2
Requires PHP: 7.0
License: GPLv3
License URI: https://www.gnu.org/licenses/gpl-3.0.html

It is a plugin that allows you to integrate your ReactJS builds into wordpress.

== Description ==

This plugin reads the `asset-manifest.json` file in your ReactJS build and includes it in wordpress and allows you to run your application anywhere in wordpress.

== Usage ==
You can run your application embedded in wordpress by typing the following shortcode in the Wordpress text editor.

`
[embed_react_build 
  application_id="root" 
  url="https://react-default.netlify.app"]
`

== Shortcode Parameters ==
* `application_id` — The name of the container where the React application is mounted.
(default: root) (required)
* `url` — The URL address of the React Build.
 (required)
* `staging_url` — The URL address of the React Staging Build. Once defined, you can access the staging build by typing `?test=true` at the end of the url.
(optional)

== Frequently Asked Questions ==
= Is there a requirement for the plugin? =
The only requirement for the plugin is that React Build with the following conditions.

1. You need to compile with a version higher than 3.2.0 of the [Create React App](https://create-react-app.dev/) tool so that your build dependencies are read and understood by the plugin.
2. You need to define `PUBLIC_URL` in the `.env` file for the structure dependencies to be properly integrated into the page.
**For example:** [https://github.com/nurullah/react-default/blob/master/.env](https://github.com/nurullah/react-default/blob/master/.env)

= Where can I embed React Build? =
You can run the React Build by typing the shortcode in the text editor from within the post, page or widgets.

= Will I always need to prepare the shortcode manually? =
In the new versions of the plugin, component/block will be created for page builders such as Gutenberg, WPBakery, Elementor. After those versions, you will be able to integrate your React application more easily.


== Screenshots ==


== Changelog ==

= 1.0.2 =
* Wordpress 5.8 compability tested.

= 1.0.1 =
* Readme.txt updated.

= 1.0.0 =
* Plugin name renamed.

= 0.4.4 =
* Readme.txt updated.

= 0.4.3 =
* Readme.md updated.

= 0.4.2 =
* Readme files created.

= 0.4.1 =
* Staging URL parameter added to the shortcode.

= 0.4 =
* The manifest.json file is loaded after runtime.

= 0.3.1 =
* PHP notice fixed.

= 0.3 =
* Shortcode created.

= 0.2 =
* Class created for plugin.

= 0.1 =
* Initial

== Upgrade Notice ==
