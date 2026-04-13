=== LeadConnector Pro ===
Contributors: leadconnectorpro
Tags: gohighlevel, highlevel, ghl, crm, leadconnector, forms, chat widget, contacts, custom fields, funnels, smtp
Requires at least: 5.8
Tested up to: 6.9
Stable tag: 1.0.0
Requires PHP: 7.4
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

LeadConnector Pro connects your WordPress site to Go High Level (GHL) so you can quickly access forms, chat widget, custom fields, custom values, contacts, and more.

== Description ==

LeadConnector Pro is for connecting your WordPress site to GHL Go High Level so you can quickly access forms, chat widget, custom fields, custom values, contacts, and more. It is based on the previously in-secure LeadConnector plugin but upgraded to fix cron issues and security holes.

**Key Features:**

* Connect your WordPress site to your Go High Level account via OAuth
* Embed GHL forms anywhere using the `[lc_form id="..."]` shortcode
* Display phone number pools with the `[lc_phone_number_pool id="..."]` shortcode
* Manage your chat widget directly from WordPress
* Sync funnels and landing pages from GHL to WordPress
* Configure SMTP email delivery through GHL
* View and manage contacts from your GHL account
* Built-in cron fix tool to resolve legacy scheduling conflicts

**Security Improvements over original LeadConnector plugin:**

* Fixed CVE-2026-1890: All REST API endpoints now enforce proper authorization — unauthenticated callers are explicitly rejected (CWE-862 fix)
* Fixed CVE-2024-1371 / CVE-2024-34378: The `wp_delete_post` endpoint is now POST-only, validates post type (only LC funnel posts can be deleted), and sanitizes input — preventing arbitrary post deletion by authenticated or unauthenticated actors
* Removed sensitive data leak: API keys, OAuth access tokens, and raw plugin options are no longer returned in REST API responses
* Fixed SSRF risk: Outbound HTTP requests via the proxy endpoint are restricted to an approved allowlist of LeadConnector domains only
* REST API namespace renamed from `lc_public_api` to `lcpro_api` to isolate from vulnerable legacy installations
* Admin tool pages use nonce verification on all state-changing POST actions
* Cron cleanup runs automatically on init to remove legacy `lc_twicedaily_refresh_req` jobs that caused performance issues

== Installation ==

1. Upload the `leadconnector-pro` folder to the `/wp-content/plugins/` directory, or install directly through the WordPress plugin screen.
2. Activate the plugin through the **Plugins** screen in WordPress.
3. Navigate to **LeadConnector Pro** in the WordPress admin menu.
4. Connect your Go High Level account using OAuth.
5. Configure your desired features (chat widget, forms, SMTP, etc.) from the dashboard.

**Note:** If you are migrating from the original LeadConnector plugin, deactivate and delete it first. LeadConnector Pro uses a separate options key (`leadconnector_pro_plugin_options`) so you will need to reconnect your GHL account after switching.

== Frequently Asked Questions ==

= Is this compatible with the original LeadConnector plugin? =

No — you should deactivate the original LeadConnector plugin before activating LeadConnector Pro. Running both simultaneously may cause conflicts. You will need to reconnect your GHL account after switching.

= Why was the original plugin insecure? =

The original LeadConnector plugin had multiple publicly disclosed CVEs (CVE-2024-1371, CVE-2024-34378, CVE-2026-1890) related to missing authorization checks on REST API endpoints, allowing unauthenticated users to delete posts, overwrite data, and access sensitive credentials. LeadConnector Pro addresses all of these.

= What is the cron fixer tool? =

Older versions of LeadConnector used a cron hook called `lc_twicedaily_refresh_req` that could accumulate thousands of stale scheduled jobs, severely degrading WordPress performance. LeadConnector Pro automatically cleans these up on activation and provides a manual tool under **Tools → LC Pro Cron Fixer** if needed.

= Does this work with WordPress Multisite? =

The plugin has not been officially tested on Multisite. Use with caution in Multisite environments and ensure each sub-site's LeadConnector Pro instance is configured independently.

= Where do I find my GHL Location ID and OAuth credentials? =

Log in to your Go High Level account and navigate to **Settings → Integrations → WordPress Plugin** to find your credentials and initiate OAuth.

== Screenshots ==

1. LeadConnector Pro dashboard — connect your GHL account via OAuth.
2. Funnels management — sync and manage your GHL funnels from WordPress.
3. Forms — embed GHL forms on any post or page using shortcodes.
4. Chat widget — configure and preview your GHL chat widget.
5. Email / SMTP — route WordPress emails through your GHL SMTP settings.

== Changelog ==

= 1.0.0 =
* Initial release of LeadConnector Pro
* Rebranded and forked from LeadConnector 3.0.10.4
* **Security fix (CVE-2026-1890):** All REST API endpoints now require `manage_options` capability; unauthenticated requests return HTTP 403
* **Security fix (CVE-2024-1371 / CVE-2024-34378):** `wp_delete_post` endpoint restricted to POST method only, validates post type before deletion, sanitizes post ID input
* **Security fix — data leak:** Removed `access_token`, `api_key`, and full options array from `wp_validate_auth_state` REST response
* **Security fix — SSRF:** Outbound proxy requests restricted to approved LeadConnector domains; arbitrary URLs are rejected with HTTP 403
* **Cron fix merged:** Legacy `lc_twicedaily_refresh_req` cron jobs are automatically detected and removed on init
* **Cron fixer tool:** Admin Tools page added at Tools → LC Pro Cron Fixer with nonce-protected POST action
* REST namespace changed from `lc_public_api/v1` to `lcpro_api/v1`
* WordPress admin menu slug changed from `lc-plugin` to `lcpro-plugin`
* Cron hook renamed from `lc_twicedaily_refresh_req_v2` to `lcpro_twicedaily_refresh_req`
* Options key changed from `lead_connector_plugin_options` to `leadconnector_pro_plugin_options`
* Text domain changed from `leadconnector` to `leadconnector-pro`

== Upgrade Notice ==

= 1.0.0 =
Initial release. Migrating from the original LeadConnector plugin requires deactivating the old plugin and reconnecting your GHL account. All known CVEs from the original plugin have been resolved in this release.
