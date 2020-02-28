<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<div id="AdvanceUsertabs">
  <ul>
    <li><a href="#tabs-export-advance">Export Users</a></li>
    <li><a href="#tabs-import-advance">Import Users</a></li>
   
  </ul>
  <div id="tabs-export-advance">
    <?php  include ADVANCEWPUSER_PLUGIN_PATH . 'main/include/ADVANCEWPUSERAdminExport.php'; ?>
  </div>
  <div id="tabs-import-advance">
  <?php  include ADVANCEWPUSER_PLUGIN_PATH . 'main/include/ADVANCEWPUSERAdminImport.php'; ?>
  </div>
 
</div>