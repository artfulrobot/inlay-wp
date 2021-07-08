<?php
/*
Plugin Name: CiviCRM Inlay integration
Plugin URI:  https://artfulrobot.uk
Description: Provides shortcodes for inlay scripts
Version:     20201113
Author:      Rich Lott / Artful Robot
Author URI:  https://artfulrobot.uk
License:     AGPL-3.0
License URI: https://www.gnu.org/licenses/agpl-3.0.html
Text Domain: inlay
*/

defined( 'ABSPATH' ) or die();

// CiviCRM admin settings screen.
add_action('admin_menu', 'inlay_admin_menu');
add_action('admin_init', 'inlay_admin_init');

// Add an action link pointing to the options page.
add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'inlay_admin_add_action_links');

/**
 * Implements admin_menu hook.
 */
function inlay_admin_menu() {
  //                $page_title,                  $menu_title,  $capability,      $menu_slug, $function
  add_options_page('CiviCRM Inlays Integration', 'Inlays',      'manage_options', 'inlay', 'inlay_admin_options');
}

/**
 * Add settings action link to the plugins page
 */
function inlay_admin_add_action_links( $links ) {

  return array_merge(
    array(
      'settings'	 => '<a href="' . admin_url( 'options-general.php?page=inlay' ) . '">' . __( 'Settings' ) . '</a>',
    ), $links
  );
}

function inlay_admin_init() {
  $settings_group_name = 'inlay';

  // optional 3rd arg is validation callback
  register_setting($settings_group_name, 'inlay_url_prefix', ['type' => 'string', 'sanitize_callback' => 'inlay_admin_options_validate_url_prefix']);
}

/**
 * Provides the options page.
 */
function inlay_admin_options() {
    if (!current_user_can('manage_options')) {
      wp_die(('You are not allowed to do that.'));
    }

    ?>
      <div class="wrap">
      <h1>CiviCRM Inlay integration configuration</h1>
      <form method="post" action="options.php">
        <?php
          settings_fields("inlay");
          do_settings_sections("inlay");
        ?>
        <div>
          <label for="inlay_url_prefix" >URL prefix</label><br />
          <input id="inlay_url_prefix" type="text" name="inlay_url_prefix" value="<?php echo esc_attr( get_option('inlay_url_prefix') ); ?>" size=80 />
          <p>You can copy and paste Inlay code here and it will extract the bit it needs.</p>
        </div>

        <?php
          submit_button();
        ?>
      </form>
    </div>
  <?php
}
/**
 * Coerce the input into an integer.
 */
function inlay_admin_options_validate_url_prefix($input) {

  if (preg_match('@<script src="([^"]+/)(?:inlay-[a-z0-9]+\.js") .*</script>$@s', $input, $matches)) {
    // They pasted a whole inlay script in, e.g.
    // <script src="https://example.org/sites/default/files/civicrm/inlay-abcdef012345.js" data-inlay-id="abcdef012345" ></script>
    // Just extract the bit we need.
    $input = $matches[1];
  }

  if (preg_match('@^https?://.*/$@', $input)) {
    // Looks ok.
    return $input;
  }

  return '';
}


//             ↓ shortcode   ↓ callback
add_shortcode( 'inlay', 'inlay_shortcodes' );
/**
 * Provide the shortcode for inlays.
 *
 * e.g. [inlay id="aabbccddeeff88"]
 */
function inlay_shortcodes($atts) {
  $atts = shortcode_atts([ 'id' => '' ], $atts);
  if (preg_match('/^[a-z0-9]+$/', $atts['id'])) {
    $url = get_option( 'inlay_url_prefix', '' );
    if ($url) {
      $output = "<script src='{$url}inlay-$atts[id].js' data-inlay-id='$atts[id]'></script><noscript>(This part of the page requires Javascript)</noscript>";
    }
    else {
      $output = "(A misconfiguration is preventing the form from showing - check inlay plugin settings)";
    }
  }
  else {
    $output = "(A misconfiguration is preventing the form from showing - invalid inlay shortcode)";
  }
  return $output;
}
