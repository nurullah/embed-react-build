<?php

/**
 * Plugin Name: Embed React Build in Wordpress
 * Plugin URI: https://github.com/nurullah/embed-react-build-in-wordpress
 * Description: This plugin enables ReactJS project builds to work in wordpress.
 * Version: 0.1.0
 * Author: Nurullah Sevinctekin
 * Author URI: https://github.com/nurullah/
 * License: GPLv3
 * License URI: https://www.gnu.org/licenses/gpl-3.0.html
 */

// do not allow direct access to the file.
if (! defined( 'ABSPATH' )) exit;

class EmbedReactBuild {

  public $name = '';
  public $version = '';

  function __construct() {
    $this->name = $this->plugin_data( 'name' );
    $this->version = $this->plugin_data( 'version' );

    // ...
  }

  /**
   * Retrieves the information in the plugin header.
   * @param  [type] $key [description]
   * @return [type]      [description]
   */
  public function plugin_data( $key ) {
    return get_file_data(
      __FILE__,
      array(
        'name' => 'Plugin Name',
        'version' => 'Version'
      ),
      'plugin'
    )[ $key ];
  }

}

new EmbedReactBuild();
