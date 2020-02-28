<?php 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
global $wp_roles;
$AdvanceWPUserRolesNames = $wp_roles->roles; 
$AdvanceWPUsersDataSettings = get_option("AdvanceWPUsersDataSettings",true); 
global $wpdb;
$getAllMetaKeys = $wpdb->get_results("select DISTINCT meta_key from ".$wpdb->prefix."usermeta");
$default_exclude_user_meta = array('rich_editing','syntax_highlighting','comment_shortcuts','admin_color','use_ssl','show_admin_bar_front','locale','wp_capabilities','wp_user_level','dismissed_wp_pointers','show_welcome_panel','session_tokens','wp_dashboard_quick_press_last_post_id');
?>
<form method="post" name="AdvacneWPUserExport" id="AdvacneWPUserExport">
<?php wp_nonce_field('AdvacneWPUserExportAction'); ?>
  <table class="form-table">
    <tbody>
        <tr class="form-field form-required">
          <th scope="row"><label for="exportRoles"><?php echo esc_html(__( 'User Roles', 'advance-wpuser' )); ?></label></th>
          <td>
            <select id="exportRoles" name="exportRoles">
              <option value="all" <?php if(isset($AdvanceWPUsersDataSettings["exportRoles"]) && $AdvanceWPUsersDataSettings["exportRoles"] == "all") { echo "selected"; }  ?>><?php echo __( 'All Roles', 'advance-wpuser' ); ?></option>
              <?php foreach($AdvanceWPUserRolesNames as $key=>$value) { ?> 
                <option value="<?php echo $key; ?>" <?php if(isset($AdvanceWPUsersDataSettings["exportRoles"]) && $AdvanceWPUsersDataSettings["exportRoles"] == $key) { echo "selected"; }  ?>><?php echo __( $AdvanceWPUserRolesNames[$key]["name"], 'advance-wpuser' ); ?></option>
              <?php } ?>
            </select>
            <p class="description" id="exportRoles-description">
            <?php echo esc_html(__( 'Users of specific role to Export', 'advance-wpuser' )); ?>
            </p>
          </td>
          
        </tr>
        <tr class="form-field form-required">
          <th scope="row"><label for="exportLimitRegisterStartDate"><?php echo esc_html(__( 'Registered Start Date', 'advance-wpuser' )); ?></label></th>
          <td>
            <?php 
            if(isset($AdvanceWPUsersDataSettings["exportLimitRegisterStartDate"]))
            {
              $exportLimitRegisterStartDate = $AdvanceWPUsersDataSettings["exportLimitRegisterStartDate"];
            }
            else 
            {
              $exportLimitRegisterStartDate = 0;
            }
            ?>
            <input name="exportLimitRegisterStartDate" type="text" id="exportLimitRegisterStartDate" value="<?php echo $exportLimitRegisterStartDate; ?>">
            <p class="description" id="exportLimitRegisterStartDate-description">
            <?php echo esc_html(__( 'Users Registered Between Start and End Date', 'advance-wpuser' )); ?>
            </p>
          </td>
          
        </tr>
        <tr class="form-field form-required">
          <th scope="row"><label for="exportLimitRegisterEndDate"><?php echo esc_html(__( 'Registered End Date', 'advance-wpuser' )); ?></label></th>
          <td>
          <?php 
            if(isset($AdvanceWPUsersDataSettings["exportLimitRegisterEndDate"]))
            {
              $exportLimitRegisterEndDate = $AdvanceWPUsersDataSettings["exportLimitRegisterEndDate"];
            }
            else 
            {
              $exportLimitRegisterEndDate = 0;
            }
            ?>
            <input name="exportLimitRegisterEndDate" type="text" id="exportLimitRegisterEndDate" value="<?php echo $exportLimitRegisterEndDate; ?>">
            <p class="description" id="exportLimitRegisterEndDate-description">
            <?php echo esc_html(__( 'Users Registered Between Start and End Date', 'advance-wpuser' )); ?>
            </p>
          </td>
          
        </tr>
        <tr class="form-field form-required">
          <th scope="row"><label for="exportRoles"><?php echo esc_html(__( 'Filter By Meta Key', 'advance-wpuser' )); ?></label></th>
          <td>
          <?php 
          if($AdvanceWPUsersDataSettings["exportFilterMetaKeys"] == "")
            $AdvanceWPUsersDataSettings["exportFilterMetaKeys"] = array(); 
           ?>
            <select id="exportFilterMetaKeys[]" name="exportFilterMetaKeys[]" multiple>
              <option value="" <?php if((isset($AdvanceWPUsersDataSettings["exportFilterMetaKeys"]) && in_array("",$AdvanceWPUsersDataSettings["exportFilterMetaKeys"])) || $AdvanceWPUsersDataSettings["exportFilterMetaKeys"] == "") { echo "selected"; }  ?>><?php echo __( 'None', 'advance-wpuser' ); ?></option>
              <?php 
              for($getAllMetaKeysCounter = 0;$getAllMetaKeysCounter < count($getAllMetaKeys);$getAllMetaKeysCounter++)
              {
                  if(!in_array($getAllMetaKeys[$getAllMetaKeysCounter]->meta_key,$default_exclude_user_meta))
                  { 
                    ?> 
                      <option value="<?php echo $getAllMetaKeys[$getAllMetaKeysCounter]->meta_key; ?>" <?php if(isset($AdvanceWPUsersDataSettings["exportFilterMetaKeys"]) && in_array($getAllMetaKeys[$getAllMetaKeysCounter]->meta_key,$AdvanceWPUsersDataSettings["exportFilterMetaKeys"]) == $getAllMetaKeys[$getAllMetaKeysCounter]->meta_key) { echo "selected"; }  ?>><?php echo __( $getAllMetaKeys[$getAllMetaKeysCounter]->meta_key, 'advance-wpuser' ); ?></option>
                    <?php 
                  }
              } ?> 
            </select>
            <p class="description" id="exportFilterMetaKeys-description">
            <?php echo esc_html(__( 'Filter By Meta Key with Specific Value', 'advance-wpuser' )); ?>
            </p>
          </td>
          
        </tr>
        <tr class="form-field form-required">
          <th scope="row"><label for="exportFilterMetaValue"><?php echo esc_html(__( 'Filter Value', 'advance-wpuser' )); ?></label></th>
          <td>
          <?php 
            if(isset($AdvanceWPUsersDataSettings["exportFilterMetaValue"]))
            {
              $exportFilterMetaValue = $AdvanceWPUsersDataSettings["exportFilterMetaValue"];
            }
            else 
            {
              $exportFilterMetaValue = 0;
            }
            ?>
            <input name="exportFilterMetaValue" type="text" id="exportFilterMetaValue" value="<?php echo $exportFilterMetaValue; ?>">
            <p class="description" id="exportFilterMetaValue-description">
            <?php echo esc_html(__( 'Add value which should match with select Filter Meta key at above (it will match the exact value that you write here)', 'advance-wpuser' )); ?>
            </p>
          </td>
          
        </tr>
        <tr class="form-field form-required">
          <th scope="row"><label for="exportLimit"><?php echo esc_html(__( 'Limit', 'advance-wpuser' )); ?></label></th>
          <td>
          <?php 
            if(isset($AdvanceWPUsersDataSettings["exportLimit"]))
            {
              $exportLimit = $AdvanceWPUsersDataSettings["exportLimit"];
            }
            else 
            {
              $exportLimit = -1;
            }
            ?>
            <input name="exportLimit" type="text" id="exportLimit" value="<?php echo $exportLimit;  ?>">
            <p class="description" id="exportLimit-description">
            <?php echo esc_html(__( 'Default will be -1( It mean All users )', 'advance-wpuser' )); ?>
            </p>
          </td>
          
        </tr>
        <tr class="form-field form-required">
          <th scope="row"><label for="exportOffset"><?php echo esc_html(__( 'Offset', 'advance-wpuser' )); ?></label></th>
          <td>
          <?php 
            if(isset($AdvanceWPUsersDataSettings["exportOffset"]))
            {
              $exportOffset = $AdvanceWPUsersDataSettings["exportOffset"];
            }
            else 
            {
              $exportOffset = 0;
            }
            ?>
            <input name="exportOffset" type="text" id="exportOffset" value="<?php echo $exportOffset; ?>">
            <p class="description" id="exportOffset-description">
            <?php echo esc_html(__( 'Default will be 0', 'advance-wpuser' )); ?>
            </p> 
          </td>
        </tr>
        <tr class="form-field form-required">
          <th scope="row"><label for="exportColumnsHeading"><?php echo esc_html(__( 'Columns', 'advance-wpuser' )); ?></label></th>      
        </tr>
        <tr class="form-field form-required">
          <th scope="row"><label for="exportColumn"><?php echo esc_html(__( 'Column', 'advance-wpuser' )); ?></label></th>      
          <th scope="row"><label for="exportColumnname"><?php echo esc_html(__( 'Column name', 'advance-wpuser' )); ?></label></th>      
        </tr>
        <tr class="form-field form-required">
          <td>
          <?php 
            if(isset($AdvanceWPUsersDataSettings["exportDefaultUserColumns"]) && in_array("ID",$AdvanceWPUsersDataSettings["exportDefaultUserColumns"]))
            {
              $is_checked = "checked=checked";
            }
            else 
            {
              $is_checked = "";;
            }
            if(isset($AdvanceWPUsersDataSettings["exportDefaultUserColumnsNames"][0]))
            {
              $ColumnValue = $AdvanceWPUsersDataSettings["exportDefaultUserColumnsNames"][0];
            }
            else 
            {
              $ColumnValue = "ID";
            }
            ?>
            <input name="exportDefaultUserColumns[]" <?php echo $is_checked; ?> value="ID" type="checkbox" id="exportDefaultUserColumnsID" value="0">
            <label><?php echo esc_html(__( 'ID', 'advance-wpuser' )); ?></label>
          </td>
          <td>
            <input name="exportDefaultUserColumnsNames[]" type="text" id="exportDefaultUserColumnsIDName" value="<?php echo $ColumnValue; ?>">
          </td>
        </tr>
        <tr class="form-field form-required">
          <td>
           <?php 
            if(isset($AdvanceWPUsersDataSettings["exportDefaultUserColumns"]) && in_array("user_login",$AdvanceWPUsersDataSettings["exportDefaultUserColumns"]))
            {
              $is_checked = "checked=checked";
            }
            else 
            {
              $is_checked = "";;
            }
            if(isset($AdvanceWPUsersDataSettings["exportDefaultUserColumnsNames"][1]))
            {
              $ColumnValue = $AdvanceWPUsersDataSettings["exportDefaultUserColumnsNames"][1];
            }
            else 
            {
              $ColumnValue = "User Login";
            }
            ?>
            <input name="exportDefaultUserColumns[]" <?php echo $is_checked; ?>  value="user_login" type="checkbox" id="exportDefaultUserColumnsLogin" value="0">
            <label><?php echo esc_html(__( 'User Login', 'advance-wpuser' )); ?></label>
          </td>
          <td>
            <input name="exportDefaultUserColumnsNames[]" type="text" id="exportDefaultUserColumnsLoginName" value="<?php echo $ColumnValue; ?>">
          </td>
        </tr>
        <tr class="form-field form-required">
          <td>
          <?php 
            if(isset($AdvanceWPUsersDataSettings["exportDefaultUserColumns"]) && in_array("user_pass",$AdvanceWPUsersDataSettings["exportDefaultUserColumns"]))
            {
              $is_checked = "checked=checked";
            }
            else 
            {
              $is_checked = "";;
            }
            if(isset($AdvanceWPUsersDataSettings["exportDefaultUserColumnsNames"][2]))
            {
              $ColumnValue = $AdvanceWPUsersDataSettings["exportDefaultUserColumnsNames"][2];
            }
            else 
            {
              $ColumnValue = "Password";
            }
            ?>
            <input name="exportDefaultUserColumns[]" <?php echo $is_checked; ?> value="user_pass" type="checkbox" id="exportDefaultUserColumnsPass" value="0">
            <label><?php echo esc_html(__( 'User Password', 'advance-wpuser' )); ?></label>
          </td>
          <td>
            <input name="exportDefaultUserColumnsNames[]" type="text" id="exportDefaultUserColumnsPass" value="<?php echo $ColumnValue; ?>">
          </td>
        </tr>
        <tr class="form-field form-required">
          <td>
          <?php 
            if(isset($AdvanceWPUsersDataSettings["exportDefaultUserColumns"]) && in_array("user_nicename",$AdvanceWPUsersDataSettings["exportDefaultUserColumns"]))
            {
              $is_checked = "checked=checked";
            }
            else 
            {
              $is_checked = "";;
            }
            if(isset($AdvanceWPUsersDataSettings["exportDefaultUserColumnsNames"][3]))
            {
              $ColumnValue = $AdvanceWPUsersDataSettings["exportDefaultUserColumnsNames"][3];
            }
            else 
            {
              $ColumnValue = "Nice Name";
            }
            ?>
            <input name="exportDefaultUserColumns[]" <?php echo $is_checked; ?> value="user_nicename" type="checkbox" id="exportDefaultUserColumnsNiceName" value="0">
            <label><?php echo esc_html(__( 'User Nice Name', 'advance-wpuser' )); ?></label>
          </td>
          <td>
            <input name="exportDefaultUserColumnsNames[]" type="text" id="exportDefaultUserColumnsNiceName" value="<?php echo $ColumnValue; ?>">
          </td>
        </tr>
        <tr class="form-field form-required">
          <td>
          <?php 
            if(isset($AdvanceWPUsersDataSettings["exportDefaultUserColumns"]) && in_array("user_email",$AdvanceWPUsersDataSettings["exportDefaultUserColumns"]))
            {
              $is_checked = "checked=checked";
            }
            else 
            {
              $is_checked = "";;
            }
            if(isset($AdvanceWPUsersDataSettings["exportDefaultUserColumnsNames"][4]))
            {
              $ColumnValue = $AdvanceWPUsersDataSettings["exportDefaultUserColumnsNames"][4];
            }
            else 
            {
              $ColumnValue = "User Email";
            }
            ?>
            <input name="exportDefaultUserColumns[]" <?php echo $is_checked; ?> value="user_email" type="checkbox" id="exportDefaultUserColumnsEmail" value="0">
            <label><?php echo esc_html(__( 'User Email', 'advance-wpuser' )); ?></label>
          </td>
          <td>
            <input name="exportDefaultUserColumnsNames[]" type="text" id="exportDefaultUserColumnsEmail" value="<?php echo $ColumnValue; ?>">
          </td>
        </tr>
        <tr class="form-field form-required">
          <td>
          <?php 
            if(isset($AdvanceWPUsersDataSettings["exportDefaultUserColumns"]) && in_array("user_url",$AdvanceWPUsersDataSettings["exportDefaultUserColumns"]))
            {
              $is_checked = "checked=checked";
            }
            else 
            {
              $is_checked = "";;
            }
            if(isset($AdvanceWPUsersDataSettings["exportDefaultUserColumnsNames"][5]))
            {
              $ColumnValue = $AdvanceWPUsersDataSettings["exportDefaultUserColumnsNames"][5];
            }
            else 
            {
              $ColumnValue = "User URL";
            }
            ?>
            <input name="exportDefaultUserColumns[]" <?php echo $is_checked; ?> value="user_url" type="checkbox" id="exportDefaultUserColumnsURL" value="0">
            <label><?php echo esc_html(__( 'User URL', 'advance-wpuser' )); ?></label>
          </td>
          <td>
            <input name="exportDefaultUserColumnsNames[]" type="text" id="exportDefaultUserColumnsURL" value="<?php echo $ColumnValue; ?>">
          </td>
        </tr>
        <tr class="form-field form-required">
          <td>
          <?php 
            if(isset($AdvanceWPUsersDataSettings["exportDefaultUserColumns"]) && in_array("user_registered",$AdvanceWPUsersDataSettings["exportDefaultUserColumns"]))
            {
              $is_checked = "checked=checked";
            }
            else 
            {
              $is_checked = "";;
            }
            if(isset($AdvanceWPUsersDataSettings["exportDefaultUserColumnsNames"][6]))
            {
              $ColumnValue = $AdvanceWPUsersDataSettings["exportDefaultUserColumnsNames"][6];
            }
            else 
            {
              $ColumnValue = "User Registered Date";
            }
            ?>
            <input name="exportDefaultUserColumns[]" <?php echo $is_checked; ?> value="user_registered" type="checkbox" id="exportDefaultUserColumnsRegistered" value="0">
            <label><?php echo esc_html(__( 'User Registered Date' , 'advance-wpuser' )); ?></label>
          </td>
          <td>
            <input name="exportDefaultUserColumnsNames[]" type="text" id="exportDefaultUserColumnsRegistered" value="<?php echo $ColumnValue; ?>">
          </td>
        </tr>
        <tr class="form-field form-required">
          <td>
          <?php 
            if(isset($AdvanceWPUsersDataSettings["exportDefaultUserColumns"]) && in_array("user_status",$AdvanceWPUsersDataSettings["exportDefaultUserColumns"]))
            {
              $is_checked = "checked=checked";
            }
            else 
            {
              $is_checked = "";;
            }
            if(isset($AdvanceWPUsersDataSettings["exportDefaultUserColumnsNames"][7]))
            {
              $ColumnValue = $AdvanceWPUsersDataSettings["exportDefaultUserColumnsNames"][7];
            }
            else 
            {
              $ColumnValue = "User Status";
            }
            ?>
            <input name="exportDefaultUserColumns[]"  <?php echo $is_checked; ?> value="user_status" type="checkbox" id="exportDefaultUserColumnsStatus" value="0">
            <label><?php echo esc_html(__( 'User Status', 'advance-wpuser' )); ?></label>
          </td>
          <td>
            <input name="exportDefaultUserColumnsNames[]" type="text" id="exportDefaultUserColumnsStatus" value="<?php echo $ColumnValue; ?>">
          </td>
        </tr>
        <tr class="form-field form-required">
          <td>
          <?php 
            if(isset($AdvanceWPUsersDataSettings["exportDefaultUserColumns"]) && in_array("display_name",$AdvanceWPUsersDataSettings["exportDefaultUserColumns"]))
            {
              $is_checked = "checked=checked";
            }
            else 
            {
              $is_checked = "";;
            }
            if(isset($AdvanceWPUsersDataSettings["exportDefaultUserColumnsNames"][8]))
            {
              $ColumnValue = $AdvanceWPUsersDataSettings["exportDefaultUserColumnsNames"][8];
            }
            else 
            {
              $ColumnValue = "User Display Name";
            }
            ?>
            <input name="exportDefaultUserColumns[]" <?php echo $is_checked; ?> value="display_name" type="checkbox" id="exportDefaultUserColumnsDisplayName" value="0">
            <label><?php echo esc_html(__( 'User Display Name', 'advance-wpuser' )); ?></label>
          </td>
          <td>
            <input name="exportDefaultUserColumnsNames[]" type="text" id="exportDefaultUserColumnsDisplayName" value="<?php echo $ColumnValue; ?>">
          </td>
        </tr>
        <tr class="form-field form-required">
          <th scope="row"><label for="exportColumnsHeading"><?php echo esc_html(__( 'Custom Meta', 'advance-wpuser' )); ?></label>
          <p class="description" id="exportLimit-description">
            <?php echo esc_html(__( 'This will display all custom user meta (For this you should be able to know which meta is used for which purpose in website)', 'advance-wpuser' )); ?>
            </p>
          </th>      
        </tr>
        <tr class="form-field form-required">
          <th scope="row"><label for="exportColumn"><?php echo esc_html(__( 'Meta Column', 'advance-wpuser' )); ?></label></th>      
          <th scope="row"><label for="exportColumnname"><?php echo esc_html(__( 'Meta Column name', 'advance-wpuser' )); ?></label></th>      
        </tr>
       <?php
       $AdvacneCustomCounter = 0;
       for($getAllMetaKeysCounter = 0;$getAllMetaKeysCounter < count($getAllMetaKeys);$getAllMetaKeysCounter++)
       {
          if(!in_array($getAllMetaKeys[$getAllMetaKeysCounter]->meta_key,$default_exclude_user_meta))
          {
            if(isset($AdvanceWPUsersDataSettings["exportCustomUserColumns"]) && in_array($getAllMetaKeys[$getAllMetaKeysCounter]->meta_key,$AdvanceWPUsersDataSettings["exportCustomUserColumns"]))
            {
              $is_checked = "checked=checked";
            }
            else 
            {
              $is_checked = "";;
            }
            if(isset($AdvanceWPUsersDataSettings["exportCustomUserColumnsNames"][$getAllMetaKeys[$getAllMetaKeysCounter]->meta_key]))
            {
              $ColumnValue = $AdvanceWPUsersDataSettings["exportCustomUserColumnsNames"][$getAllMetaKeys[$getAllMetaKeysCounter]->meta_key];
            }
            else 
            {
              $ColumnValue = $getAllMetaKeys[$getAllMetaKeysCounter]->meta_key;
            }
       ?>     
        <tr class="form-field form-required">
          <td>
          
            <input name="exportCustomUserColumns[<?php echo $getAllMetaKeys[$getAllMetaKeysCounter]->meta_key; ?>]" <?php echo $is_checked; ?> value="<?php echo $getAllMetaKeys[$getAllMetaKeysCounter]->meta_key; ?>" type="checkbox" id="exportCustomUserColumnsDisplayName" value="0">
            <label><?php echo esc_html(__( $getAllMetaKeys[$getAllMetaKeysCounter]->meta_key, 'advance-wpuser' )); ?></label>
          </td>
          <td>
            <input name="exportCustomUserColumnsNames[<?php echo $getAllMetaKeys[$getAllMetaKeysCounter]->meta_key; ?>]" type="text" id="exportCustomUserColumnsDisplayName" value="<?php echo $ColumnValue; ?>">
          </td>
        </tr>
        <?php 
         }
        }
        ?>    
    </tbody>
  </table>
  <p class="submit"><input type="submit" name="AdvanceWPUserExport" id="AdvanceWPUserExport" class="button button-primary" value="<?php echo esc_html(__( 'Export Users', 'advance-wpuser' )); ?>"></p>
</form>