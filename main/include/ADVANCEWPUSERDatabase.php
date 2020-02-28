<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
$ErrorString = '';
if(wp_verify_nonce($_POST['_wpnonce'], 'AdvacneWPUserImportAction') && isset($_POST['AdvanceWPUserImport']) && (sanitize_text_field($_POST['AdvanceWPUserImport'])) != '')
{
    if(sanitize_text_field($_FILES["ImportFile"]["tmp_name"]))
    {
        $allowed = array('csv');
        $filename = sanitize_text_field($_FILES['ImportFile']['name']);
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        if (!in_array($ext, $allowed)) {
             $ErrorString = "Please Upload Csv File";
           
        }
        else 
        {
            $file = fopen(sanitize_text_field($_FILES["ImportFile"]["tmp_name"]),"r");
            $CSVUserData = (fgetcsv($file));
            $CsvDefaultHeaders = array('user_login','user_pass','user_nicename','user_email','user_url','user_registered','display_name','first_name','last_name','roles');
            $UserToImport = array();
            if ($CsvDefaultHeaders == $CSVUserData) 
            {
                while (($data = fgetcsv($file, 1000, ",")) !== FALSE) {
                    $num = count($data);
                    $tempArray = array();
                    $row++;
                    for ($c=0; $c < $num; $c++) {
                        array_push($tempArray, $data[$c]);
                    }
                    array_push($UserToImport, $tempArray);
                }
                for($UserToImportCounter = 0;$UserToImportCounter < count($UserToImport);$UserToImportCounter++)
                {
                    if(!email_exists($UserToImport[$UserToImportCounter][3]) && !username_exists($UserToImport[$UserToImportCounter][0]))
                    {
                        if($UserToImport[$UserToImportCounter][9] == "")
                            $role = "subscriber";
                        else 
                            $role = $UserToImport[$UserToImportCounter][9];    
                        $userdata = array(
                            'user_pass'             => sanitize_text_field($UserToImport[$UserToImportCounter][1]),   //(string) The plain-text user password.
                            'user_login'            => sanitize_text_field($UserToImport[$UserToImportCounter][0]),   //(string) The user's login username.
                            'user_nicename'         => sanitize_text_field($UserToImport[$UserToImportCounter][2]),   //(string) The URL-friendly user name.
                            'user_url'              => sanitize_text_field($UserToImport[$UserToImportCounter][4]),   //(string) The user URL.
                            'user_email'            => sanitize_email($UserToImport[$UserToImportCounter][3]),   //(string) The user email address.
                            'display_name'          => sanitize_text_field($UserToImport[$UserToImportCounter][6]),   //(string) The user's display name. Default is the user's username.
                            'first_name'            => sanitize_text_field($UserToImport[$UserToImportCounter][7]),   //(string) The user's first name. For new users, will be used to build the first part of the user's display name if $display_name is not specified.
                            'last_name'             => sanitize_text_field($UserToImport[$UserToImportCounter][8]),   //(string) The user's last name. For new users, will be used to build the second part of the user's display name if $display_name is not specified.
                            'user_registered'       => sanitize_text_field($UserToImport[$UserToImportCounter][5]),   //(string) Date the user registered. Format is 'Y-m-d H:i:s'.
                            'role'                  => sanitize_text_field($role),   //(string) User's role.
                            
                        );
                        $user_id = wp_insert_user( $userdata ) ;
                    }
                }
            }
            else{
                $ErrorString = "Please Upload In the Format of Sample File";
            }
            fclose($file);
        }
    }
}
if(wp_verify_nonce($_POST['_wpnonce'], 'AdvacneWPUserExportAction') && isset($_POST["AdvanceWPUserExport"])  && (sanitize_text_field($_POST['AdvanceWPUserExport'])) != '')
{
  $AdvanceWPUsersDataSettings = array(
      'exportRoles'=>sanitize_text_field($_POST["exportRoles"]),
      'exportLimitRegisterStartDate'=>sanitize_text_field($_POST["exportLimitRegisterStartDate"]),
      'exportLimitRegisterEndDate'=>sanitize_text_field($_POST["exportLimitRegisterEndDate"]),
      'exportLimit'=>sanitize_text_field($_POST["exportLimit"]),
      'exportOffset'=>sanitize_text_field($_POST["exportOffset"]),
      'exportFilterMetaValue'=>sanitize_text_field($_POST["exportFilterMetaValue"]),
      'exportFilterMetaKeys'=>sanitize_text_field($_POST["exportFilterMetaKeys"]),
      'exportDefaultUserColumns'=>array_map( 'sanitize_text_field', wp_unslash($_POST['exportDefaultUserColumns'])),
      'exportDefaultUserColumnsNames'=>array_map( 'sanitize_text_field', wp_unslash($_POST['exportDefaultUserColumnsNames'])),
      'exportCustomUserColumns'=>array_map( 'sanitize_text_field', wp_unslash($_POST['exportCustomUserColumns'])),
      'exportCustomUserColumnsNames'=>array_map( 'sanitize_text_field', wp_unslash($_POST['exportCustomUserColumnsNames']))
  );
  update_option("AdvanceWPUsersDataSettings",$AdvanceWPUsersDataSettings); 
  global $wpdb;
  $getAllMetaKeys = $wpdb->get_results("select DISTINCT meta_key from ".$wpdb->prefix."usermeta");
  $default_exclude_user_meta = array('rich_editing','syntax_highlighting','comment_shortcuts','admin_color','use_ssl','show_admin_bar_front','locale','wp_capabilities','wp_user_level','dismissed_wp_pointers','show_welcome_panel','session_tokens','wp_dashboard_quick_press_last_post_id');
  $MetaQueryArray = array();
  for($exportFilterMetaKeysCounter = 0; $exportFilterMetaKeysCounter <  count($_POST["exportFilterMetaKeys"]);$exportFilterMetaKeysCounter++)
  {
      if($_POST["exportFilterMetaKeys"][$exportFilterMetaKeysCounter] != "")
      {
      array_push($MetaQueryArray,array('key'     => $_POST["exportFilterMetaKeys"][$exportFilterMetaKeysCounter],
      'value'   => $_POST["exportFilterMetaValue"],
      'compare' => 'LIKE'));
      }
  }
  if(sanitize_text_field($_POST["exportLimit"]) == "-1")
    $limit = '-1';
  else 
    $limit = sanitize_text_field($_POST["exportLimit"]);  
  if(sanitize_text_field($_POST["exportOffset"]) == "" || sanitize_text_field($_POST["exportOffset"]) < 0)
    $offset = '0';
  else 
    $offset = $_POST["exportOffset"];    
  if(sanitize_text_field($_POST["exportRoles"]) == "all")
  {
      $args = array (
      'order' => 'DESC',
      'number'=> $limit,
        "offset"=>$offset,
  );
  }
  else 
  {
      $args = array (
        'role' => sanitize_text_field($_POST["exportRoles"]),
        'order' => 'DESC',
        'number'=> $limit,
        "offset"=>$offset,
    );
  }
  if(!empty($MetaQueryArray))
    $args['meta_query'] = array($MetaQueryArray);

 
$data = array();
// Create the WP_User_Query object
$UsersData = new WP_User_Query($args);

foreach ($UsersData->get_results() as $author)
    {
        $temp_arr = array();
       
        for($count=0;$count < count(array_map( 'sanitize_text_field', wp_unslash($_POST['exportDefaultUserColumnsNames'])));$count++)
        {
            if(sanitize_text_field($_POST['exportDefaultUserColumns'][$count]) == "ID")
            {
                $temp_arr[sanitize_text_field($_POST['exportDefaultUserColumnsNames'][0])] = $author->ID;
            }
            if(sanitize_text_field($_POST['exportDefaultUserColumns'][$count]) == "user_login")
            {
                $temp_arr[sanitize_text_field($_POST['exportDefaultUserColumnsNames'][1])] = $author->user_login;
            }  
            if(sanitize_text_field($_POST['exportDefaultUserColumns'][$count]) == "user_pass")
            {
                $temp_arr[sanitize_text_field($_POST['exportDefaultUserColumnsNames'][2])] = $author->user_pass;
            } 
            if(sanitize_text_field($_POST['exportDefaultUserColumns'][$count]) == "user_nicename")
            {
                $temp_arr[sanitize_text_field($_POST['exportDefaultUserColumnsNames'][3])] = $author->user_nicename;
            } 
            if(sanitize_text_field($_POST['exportDefaultUserColumns'][$count]) == "user_email")
            {
                $temp_arr[sanitize_text_field($_POST['exportDefaultUserColumnsNames'][4])] = $author->user_email;
            } 
            if(sanitize_text_field($_POST['exportDefaultUserColumns'][$count]) == "user_url")
            {
                $temp_arr[sanitize_text_field($_POST['exportDefaultUserColumnsNames'][5])] = $author->user_url;
            } 
            if(sanitize_text_field($_POST['exportDefaultUserColumns'][$count]) == "user_registered")
            {
                $temp_arr[sanitize_text_field($_POST['exportDefaultUserColumnsNames'][6])] = $author->user_registered;
            } 
            if(sanitize_text_field($_POST['exportDefaultUserColumns'][$count]) == "user_status")
            {
                $temp_arr[sanitize_text_field($_POST['exportDefaultUserColumnsNames'][7])] = $author->user_status;
            }  
            if(sanitize_text_field($_POST['exportDefaultUserColumns'][$count]) == "display_name")
            {
                $temp_arr[sanitize_text_field($_POST['exportDefaultUserColumnsNames'][8])] = $author->display_name;
            }  
            for($getAllMetaKeysCounter = 0;$getAllMetaKeysCounter < count($getAllMetaKeys);$getAllMetaKeysCounter++)
            {
               if(!in_array($getAllMetaKeys[$getAllMetaKeysCounter]->meta_key,$default_exclude_user_meta))
               {
                   
                $ArrayExport =$_POST["exportCustomUserColumns"] ;
                if(isset($ArrayExport) && in_array($getAllMetaKeys[$getAllMetaKeysCounter]->meta_key,$ArrayExport))
                {
                    $UserMeta = get_user_meta($author->ID,$getAllMetaKeys[$getAllMetaKeysCounter]->meta_key,true);
                    $temp_arr[sanitize_text_field($_POST['exportCustomUserColumnsNames'][$getAllMetaKeys[$getAllMetaKeysCounter]->meta_key])] = $UserMeta;
                }
               }
            }  
        }   
        array_push($data,$temp_arr);
    }
   
$fh1 = @fopen( 'php://output', 'w' );
$headerDisplayed1 = false;
foreach ( $data as $data1 ) {
    // Add a header row if it hasn't been added yet
    if ( !$headerDisplayed1 ) {
        // Use the keys from $data as the titles
        fputcsv($fh1, array_keys($data1));
        $headerDisplayed1 = true;
    }
    // Put the data into the stream
    fputcsv($fh1, $data1);
}
// Close the file 
fclose($fh1);
exit;
} 

?>