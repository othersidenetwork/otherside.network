<?php
/*
Plugin Name:       Tools from the Other Side
Plugin URI:        https://github.com/othersidenetwork/otherside.network
Description:       Tools and widgets for members of The Other Side Podcast Network.
Version:           1.0.7
Require WP:        4.4
Require PHP:       5.3.0
Author:            Yannick Mauray
Author URI:        https://github.com/ymauray
License:           GNU General Public License v3
License URI:       http://www.gnu.org/licenses/gpl-3.0.html
Domain Path:       /languages
Text Domain:       otherside_plugin_domain
GitHub Plugin URI: https://github.com/othersidenetwork/otherside.network
GitHub Branch:     master
*/

const JSON = "otherside.network.json";
const REMOTE_JSON = "http://otherside.network/shows/json";

$otherside_network_config = get_transient(JSON);
if ($otherside_network_config === false) {
    error_log("otherside.network: json transient not found, fetching live data from " . REMOTE_JSON . ".");
    $otherside_network_config = file_get_contents(REMOTE_JSON);
    set_transient(JSON, $otherside_network_config, 30 * MINUTE_IN_SECONDS);
}

$otherside_network_config_object = false;
if ($otherside_network_config !== false) {
	$otherside_network_config_object = json_decode($otherside_network_config);
}

require_once('lib/widget.php');
require_once('lib/banner.php');

?>