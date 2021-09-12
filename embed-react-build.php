<?php

/**
 * Plugin Name: Embed React Build
 * Plugin URI: https://github.com/nurullah/embed-react-build
 * Description: This plugin allows the ReactJS build to work embedded in wordpress.
 * Version: 1.0.2
 * Author: Nurullah Sevinctekin
 * Author URI: https://github.com/nurullah/
 * License: GPLv3
 * License URI: https://www.gnu.org/licenses/gpl-3.0.html
 */

// do not allow direct access to the file.
if (! defined( 'ABSPATH' )) exit;

class EmbedReactBuild {

  public $name;
  public $version;

  function __construct() {
    $this->name = $this->plugin_data( 'name' );
    $this->version = $this->plugin_data( 'version' );

    add_shortcode( 'embed_react_build', array( $this, 'shortcode_callback' ) );
  }

  /**
   * Shortcode callback.
   *
   * @param  array $attr Shortcode attributes
   * @return void
   */
  public function shortcode_callback( $attr ) {
    extract( shortcode_atts( array(
      'application_id' => 'root',
      'url' => '',
      'staging_url' => ''
    ), $attr ) );

    // Production URL
    $url = rtrim( $url, '/' );

    // Staging URL
    if ( isset($_GET['test']) && isset($staging_url) ) {
        $url = rtrim( $staging_url, '/' );
    }

    // Manifest URL
    $manifest_url = $url . '/manifest.json';

    // validate the url.
    if (! wp_http_validate_url( $url )) {
      return 'The Build URL is not validated.';
    }

    // get dependencies.
    $dependencies = $this->get_entrypoints( $url );
    if (! $dependencies['success']) {
      return $dependencies['message'];
    }

    // add dependencies to the page.
    foreach( $dependencies['data'] as $key => $values ) {
      foreach( $values as $dependency ) {
        $path = array_keys( $dependency )[0];
        $path_array = explode( '/', $path );
        $file = end( $path_array );
        $filename = implode( array_slice( explode( '.', $file), 0, -1 ) );

        // enqueue variables
        $handle = "react-$application_id-$filename";
        $src = array_values( $dependency )[0];

        // add dependencies to the page by type
        switch ( $key ) {
          case 'css':
            wp_enqueue_style( $handle, $src );
            break;
          case 'js':
            wp_enqueue_script( $handle, $src );
            break;
          default:
            break;
        }
      }
    }

    // load manifest.json after runtime.
    wp_add_inline_script(
      "react-$application_id-runtime-main",
      <<<EOL
        var manifest=document.createElement("link");
        manifest.rel="manifest";
        manifest.href="$manifest_url"
        document.head.append(manifest);
      EOL
    );

    return "<div id=\"$application_id\"></div>";
  }

  /**
   * Retrieves the dependencies needed for the React application to stand up.
   *
   * @param  string $url The URL of React build.
   * @return array
   */
  public function get_entrypoints( $url ) {

    // validate the assets url.
    $assets_url = $url . '/asset-manifest.json';
    if (! wp_http_validate_url( $assets_url )) {
        return array(
          'success' => false,
          'message' => 'The Build URL containing the `asset-manifest.json` is not validated.'
        );
    }

    // get build assets.
    $response = wp_remote_get( $assets_url );
    if ( is_wp_error( $response ) || wp_remote_retrieve_response_code( $response) !== 200 ) {
        return array(
          'success' => false,
          'message' => 'File `asset-manifest.json` not found at Build URL.'
        );
    }

    // convert response body from json to object.
    $assets = json_decode( $response['body'], true );

    // prepare the entrypoints.
    $entrypoints = [];
    foreach( $assets['entrypoints'] as $path ) {
      $path_array = explode( '/', $path );
      $file = explode( '.', end( $path_array ) );

      // file info
      $filename = array_slice( $file, 0, -1 );
      $extension = end( $file );
      $file_url = array_filter( $assets['files'], function($value) use ($path) {
        if (preg_match( "#/.*\/($path)$#", $value ))
          return true;
      },  );

      // return the dependency.
      $entrypoints[ $extension ][] = $file_url;
    }

    return array(
      'success' => true,
      'data' => $entrypoints
    );
  }

  /**
   * Retrieves the information in the plugin header.
   *
   * @param  string $key
   * @return array
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
