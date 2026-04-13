<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://leadconnectorhq.com
 * @since             1.0.0
 * @package           LeadConnectorPro
 *
 * @wordpress-plugin
 * Plugin Name:       LeadConnector Pro
 * Plugin URI:        https://www.leadconnectorhq.com/wp_plugin
 * Description:       LeadConnector Pro is for connecting your wordpress site to GHL Go High Level so you can quickly access forms, chat widget, custom fields, custom values, contacts, and more. It is based on the previously in-secure LeadConnector plugin but upgraded to fix cron issues and security holes.
 * Version:           1.0.0
 * Author:            LeadConnector Pro
 * Author URI:        https://www.leadconnectorhq.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       leadconnector-pro
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

if (file_exists(__DIR__ . '/config.php')) {
    require_once __DIR__ . '/config.php';
} else {
    define('LEAD_CONNECTOR_VERSION', '1.0.0');
    define('LEAD_CONNECTOR_PLUGIN_NAME', 'LeadConnectorPro');
    define('LEAD_CONNECTOR_OPTION_NAME', 'leadconnector_pro_plugin_options');
    define('LEAD_CONNECTOR_CDN_BASE_URL', 'https://widgets.leadconnectorhq.com/');
    define('LEAD_CONNECTOR_BASE_URL', 'https://rest.leadconnectorhq.com/');
    define('LEAD_CONNECTOR_DISPLAY_NAME', 'LeadConnector Pro');
    define('LEAD_CONNECTOR_OAUTH_CLIENT_ID', '6795e754aa3b9f3863f495eb-m6dbf7pz');
}

/**
 * Add custom query variables to WordPress
 */
function lead_connector_pro_add_custom_query_vars($vars) {
    $vars[] = 'code';
    $vars[] = 'lc_code';
    return $vars;
}
add_filter('query_vars', 'lead_connector_pro_add_custom_query_vars');

/**
 * The code that runs during plugin activation.
 */
function activate_lead_connector_pro()
{
    require_once plugin_dir_path(__FILE__) . 'includes/class-lc-activator.php';
    LeadConnector_Activator::activate();
    lead_connector_pro_add_custom_query_vars(array());
    flush_rewrite_rules();
}

/**
 * The code that runs during plugin deactivation.
 */
function deactivate_lead_connector_pro()
{
    require_once plugin_dir_path(__FILE__) . 'includes/class-lc-deactivator.php';
    LeadConnector_Deactivator::deactivate();
    flush_rewrite_rules();
}

register_activation_hook(__FILE__, 'activate_lead_connector_pro');
register_deactivation_hook(__FILE__, 'deactivate_lead_connector_pro');

/**
 * The core plugin class.
 */
require plugin_dir_path(__FILE__) . 'includes/class-lc.php';

/**
 * Begins execution of the plugin.
 *
 * @since    1.0.0
 */
function run_lead_connector_pro()
{
    $plugin = new LeadConnector();
    $plugin->run();
}
run_lead_connector_pro();

register_uninstall_hook(__FILE__, 'lead_connector_pro_uninstall_plugin');

function lead_connector_pro_uninstall_plugin() {
    require_once plugin_dir_path(__FILE__) . 'includes/State/StateUpdate.php';

    $options = get_option(LEAD_CONNECTOR_OPTION_NAME);
    try {
        if (isset($options[lead_connector_constants\lc_options_location_id])) {
            $event = new StateUpdate("WORDPRESS LC PRO PLUGIN UNINSTALLED", [
                "locationId" => $options[lead_connector_constants\lc_options_location_id],
            ]);
            $event->send();
        }
    } catch(Exception $e) {
        // Log error if needed
    }
}
