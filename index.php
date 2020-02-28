<?php
/*
Plugin Name:       Advance WP User Export/Import
Plugin URI:        https://vividwebsolutions.in/
Description:       This plugin provides you facility to import Users with custom meta fields. Also allows you to import users
Version:           1.0
Requires at least: 5.2
Requires PHP:      7.0.
Author:            Megha Dhebariwala
Author URI:        https://profiles.wordpress.org/meghadhebariwala/
License:           GPL v2 or later
License URI:       https://www.gnu.org/licenses/gpl-2.0.html
Text Domain:       advance-wpuser

Advance WP User Export/Import is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.

Advance WP User Export/Import is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Advance WP User Export/Import. If not, see https://www.gnu.org/licenses/gpl-2.0.html
*/

defined('ABSPATH') or die('Nope, not accessing this');
define('ADVANCEWPUSER_PLUGIN_URL', plugins_url('', __FILE__  ));
define('ADVANCEWPUSER_PLUGIN_PATH', plugin_dir_path(__FILE__));

add_action("init","ADVANCEWPUSERPluginFiles");
function ADVANCEWPUSERPluginFiles()
{

    include ADVANCEWPUSER_PLUGIN_PATH . 'main/classes/ADVANCEWPUSERAdmin.class.php';
}