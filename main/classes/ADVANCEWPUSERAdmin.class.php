<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
class ADVANCEWPUSERAdmin
{
    public function __construct()
    {
        if(current_user_can( 'manage_options' ))
        {
                if(wp_verify_nonce($_POST['_wpnonce'], 'AdvacneWPUserExportAction') && isset($_POST["AdvanceWPUserExport"])  && (sanitize_text_field($_POST['AdvanceWPUserExport'])) != '')
                {
                    $fileName_1 = 'UsersData'.date("Y-m-d H:i:s").'.csv';
                    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
                    header('Content-Description: File Transfer');
                    header("Content-type: text/csv");
                    header("Content-Disposition: attachment; filename={$fileName_1}");
                    header("Expires: 0");
                    header("Pragma: public");
                    include ADVANCEWPUSER_PLUGIN_PATH . 'main/include/ADVANCEWPUSERDatabase.php';
                }
                if(wp_verify_nonce($_POST['_wpnonce'], 'AdvacneWPUserImportAction') && isset($_POST['AdvanceWPUserImport']) && (sanitize_text_field($_POST['AdvanceWPUserImport'])) != '')
                {
                    include ADVANCEWPUSER_PLUGIN_PATH . 'main/include/ADVANCEWPUSERDatabase.php';            
                }
        }
        add_action( 'admin_menu',array($this, 'ADVANCEWPUSERAdminSettings' ));
    }
    public function ADVANCEWPUSERAdminSettings()
    {
        add_menu_page(
            __( 'ADVANCE WP USER', 'textdomain' ),
            'ADVANCE WP USER',
            'manage_options',
            'advance-wpuser',
            array($this,'ADVANCEWPUSERAdminSettingsHandler'),
            '',
            6
        );
        
    }
    public function ADVANCEWPUSERAdminSettingsHandler()
    {
        wp_register_style( 'AdvanceWPuserTabs',ADVANCEWPUSER_PLUGIN_URL.'/assets/admin/css/Advance_admin.css', array(), "", "" );
    
        wp_enqueue_script( 'jquery-ui-core' );
        wp_enqueue_style( 'jquery-ui-core' );
        wp_enqueue_style( 'jquery-ui-core' );
        wp_enqueue_script( 'jquery-ui-widget' );
        wp_enqueue_script( 'jquery-ui-tabs' );
        wp_enqueue_style( 'AdvanceWPuserTabs' );
        wp_register_script( 'AdvanceWPuserTabsJS', ADVANCEWPUSER_PLUGIN_URL.'/assets/admin/js/Advance_admin.js'  ,array(),time());
        wp_enqueue_script("AdvanceWPuserTabsJS");
       
        include ADVANCEWPUSER_PLUGIN_PATH . 'main/include/ADVANCEWPUSERAdmin.php';
        
    }
}
$ADVANCEWPUSERAdmin = new ADVANCEWPUSERAdmin;
