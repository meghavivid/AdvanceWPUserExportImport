<?php 
if ( ! defined( 'ABSPATH' ) ) 
    exit; // Exit if accessed directly
?>
<form method="post" name="AdvacneWPUserImportForm" enctype="multipart/form-data" id="AdvacneWPUserImport">
<?php wp_nonce_field('AdvacneWPUserImportAction'); ?>
<input type="file" name="ImportFile" value="" accept=".csv"/>
<p class="description" id="exportLimit-description">
            <?php echo esc_html(__( sprintf("Please see the sample attached file <a href='%s'>Download Sample File</a> (Please follow the same headers)",ADVANCEWPUSER_PLUGIN_URL.'/Sample_Users.csv'), 'advance-wpuser' )); ?>
            </p>
<p class="submit"><input type="submit" name="AdvanceWPUserImport" id="AdvanceWPUserImport" class="button button-primary" value="<?php echo esc_html(__( 'Import Users', 'advance-wpuser' )); ?>"></p>
</form>