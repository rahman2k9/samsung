<?php 
//function fazko_install() {
//    echo "done here.";
//    global $wpdb;
//    $table_name = $wpdb->prefix . 'liveshoutbox';
//     
//    $tbl1 = "CREATE TABLE batch_has_classes (
//                batch_id INT(11) NOT NULL,
//                class_id INT(11) NOT NULL,
//                PRIMARY KEY (batch_id,class_id)
//              ) ;";
//
//    $tbl2 = "CREATE TABLE class_has_subject (
//                class_id INT(11) NOT NULL,
//                subject_id INT(11) NOT NULL,
//                PRIMARY KEY (class_id,subject_id)
//              ) ;";
//
//    $tbl3 = "CREATE TABLE instiute_has_batch (
//                institute_id INT(11) NOT NULL,
//                batch_id INT(11) DEFAULT NULL,
//                PRIMARY KEY (institute_id)
//              ) ;";
//    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
//
//    dbDelta($tbl1);
//    dbDelta($tbl2);
//    dbDelta($tbl3);
//}
//
//function deactivate() {
//       global $wpdb; //required global declaration of WP variable
//
//    $sql1 = "DROP TABLE batch_has_classes";
//    $sql2 = "DROP TABLE class_has_subject";
//    $sql3 = "DROP TABLE instiute_has_batch";
//
//    $wpdb->query($sql1);
//    $wpdb->query($sql2);
//    $wpdb->query($sql3);
//}
//register_activation_hook(__FILE__, 'fazko_install');
//register_deactivation_hook( __FILE__, 'deactivate');

