<?php

/*
  Plugin Name: FAZKO
  Description: FAZKO edu plugin
  Version: 1.0
  Author: Abdul Rahman
 */
if (!session_id()) {
    session_start();
}
//////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////
/////////   CALLING PARENT STYLE SHEET AND OWN
//  DON'T EVER TRY TO CHANGE PARENT FUNCTIONS
//////////////////////////////////////////////////////////////
//FILE INCLUSION
$pluginDirectory = plugin_dir_path(__FILE__);

require_once $pluginDirectory . "batch-post-type.php";
require_once $pluginDirectory . "instiute-post-type.php";
require_once $pluginDirectory . "class-post-type.php";
require_once $pluginDirectory . "subjects-post-type.php";
////////////////////////////////////////////////////

add_action('admin_menu', 'administration_pages');

function administration_pages() {
    add_menu_page('Manage Fazko', 'Manage Fazko', 'manage_options', 'manage-batches', 'callback_batch', '', 98);
    add_submenu_page('manage-batches', 'Assign Batches', 'Assign Batches', 'manage_options', 'manage-batches');
    add_submenu_page('manage-batches', 'Assign Classes', 'Assign Classes', 'manage_options', 'manag-classes', 'callback_classes');
    add_submenu_page('manage-batches', 'Assign Subjects', 'Assign Subjects', 'manage_options', 'manag-subjects', 'callback_subjects');
    add_submenu_page('manage-batches', 'Assign Students', 'Assign Students', 'manage_options', 'manag-students', 'callback_students');
}

////////////////////////////////////////////////////////////////
function callback_batch() {
    require_once $pluginDirectory . "assign-batches-to-institutes.php";
}

function callback_classes() {
    require_once $pluginDirectory . "assign-classes-to-batches.php";
}

function callback_subjects() {
    require_once $pluginDirectory . "assign-subjects-to-classes.php";
}

function callback_students() {
    require_once $pluginDirectory . "assign-students-to-classes.php";
}

function getPostTypeData($postType = '') {
    $dummy = array();
    if ($postType != '') {
        $batch = query_posts(array('post_type' => $postType));
        while (have_posts()) {
            the_post();
            $dummy[get_the_ID()] = get_the_title();
        }
        wp_reset_query();
    }
    return $dummy;
}

function fazko_install() {
    global $wpdb;
    $tbl1 = "CREATE TABLE batch_has_classes (
                batch_id INT(11) NOT NULL,
                class_id INT(11) NOT NULL,
                id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
                PRIMARY KEY (batch_id,class_id),
                KEY id (id)
              );";

    $tbl2 = "CREATE TABLE class_has_subject(
                class_id INT(11) NOT NULL,
                subject_id INT(11) NOT NULL,
                id INT(11) NOT NULL AUTO_INCREMENT,
                PRIMARY KEY (class_id,subject_id),
                KEY id (id)
              );";

    $tbl3 = "CREATE TABLE instiute_has_batch (
                institute_id INT(11) NOT NULL,
                batch_id INT(11) NOT NULL,
                id INT(10) NOT NULL AUTO_INCREMENT,
                PRIMARY KEY (institute_id,batch_id),
                KEY id (id)
              );";
    
    $tbl4 = "CREATE TABLE students_to_classes (
                student_id INT(11) NOT NULL,
                class_id INT(11) NOT NULL,
                id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
                PRIMARY KEY (student_id,class_id),
                KEY id (id)
              ) ";
    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

    dbDelta($tbl1);
    dbDelta($tbl2);
    dbDelta($tbl3);
    dbDelta($tbl4);
}

function deactivate() {
    global $wpdb; //required global declaration of WP variable

    $sql1 = "DROP TABLE batch_has_classes";
    $sql2 = "DROP TABLE class_has_subject";
    $sql3 = "DROP TABLE instiute_has_batch";
    $sql4 = "DROP TABLE students_to_classes";

    $wpdb->query($sql1);
    $wpdb->query($sql2);
    $wpdb->query($sql3);
    $wpdb->query($sql4);
}

function flash($name = '', $message = '') {
    //We can only do something if the name isn't empty

    if ($name && $message) {
        switch ($name):
            case 'success':
                $class = 'alert-success';
                $alert = 'Done!';
                break;
            case 'error':
                $class = 'alert-danger';
                $alert = 'Error!';
                break;
            default:
                $class = 'alert-warning';
                $alert = 'Warning!';
                break;
        endswitch;
    }
    $msg = '<div class="alert ' . $class . ' alert-dismissible" role="alert">';
    $msg .= '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
    $msg .= '<strong>' . $alert . '!</strong> ' . $message;
    $msg .= '</div>';

    $_SESSION['msg'] = $msg;
}

function flashShow() {
    echo $_SESSION['msg'];
    unset($_SESSION['msg']);
}

register_activation_hook(__FILE__, 'fazko_install');
register_deactivation_hook(__FILE__, 'deactivate');
?>