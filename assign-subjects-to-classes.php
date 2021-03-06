<?php
wp_enqueue_style('style-name', plugins_url('/css/bootstrap.min.css', __FILE__));
wp_enqueue_style('style-name', plugins_url('/css/bootstrap.min.css', __FILE__));
wp_enqueue_script('the_js', plugins_url('/js/multiselect.js', __FILE__));
$instituteID = 0;
if (isset($_GET['institute'])) {
    $instituteID = $_GET['institute'];
}
$batchID = 0;
$batchID2 = 0;
if (isset($_GET['batch'])) {
    $exp = explode('_', $_GET['batch']);
    $batchID = $exp[0];
    $batchID2 = $exp[1];
}
$classID = 0;
$classID2 = 0;
$exp = '';
if (isset($_GET['class'])) {
    $exp = explode('_', $_GET['class']);
    $classID = $exp[0];
    $classID2 = $exp[1];
}

global $wpdb;

if (isset($_POST['save'])) {

    $wpdb->delete('class_has_subject', array('class_id' => $classID));

    if (isset($_POST['assgined']))
        foreach ($_POST['assgined'] as $val) {
            if ($wpdb->insert('class_has_subject', array('class_id' => $classID, 'subject_id' => $val))) {
                flash('success', 'Data Saved');
            } else {
                flash('error', 'Error!');
            }
        }
}
?>
<style>
    .row{
        margin: 0px !important;
    }
</style>

<div class="row">
    <div class="col-xs-10">
        <h1>Assign Subjects to Classes</h1>
    </div>
</div>
<div class="row">
    <div class="col-xs-12">
        <?php flashShow(); ?>
    </div>
</div>
<form method="post" >

    <div class="row">
        <div class="col-xs-2">
            <h4>Select Institute</h4>
        </div>
        <div class="col-xs-2">
            <h4>
                <select name="institute" id="institute" class="form-control">
                    <option value=0>Select Institute</option>
                    <?php
                    $batch = query_posts(array('post_type' => 'post_type_institute'));
                    while (have_posts()) {
                        the_post();
                        ?>
                        <option value="<?php echo get_the_ID() ?>" <?php echo get_the_ID() == $instituteID ? 'selected' : ''; ?>><?php echo get_the_title() ?></option>
                        <?php
                    }
                    wp_reset_query();
                    ?>
                </select>
            </h4>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-2">
            <h4>Select Batch</h4>
        </div>
        <div class="col-xs-2">
            <h4>

                <select name="batch" id="batch" class="form-control">
                    <option value=0>Select Batch</option>
                    <?php
                    $batchs = getPostTypeData('post_type_batch');
                    $query = $wpdb->get_results("select * from instiute_has_batch where institute_id = " . $instituteID);
                    foreach ($query as $val) {
                        if (isset($batchs[$val->batch_id])) {
                            ?>
                            <option value="<?php echo $val->id . "_" . $val->batch_id; ?>" <?php echo $batchID2 == $val->batch_id ? "selected" : ""; ?>><?php echo $batchs[$val->batch_id] ?></option>
                            <?php
                        }
                    }
                    wp_reset_query();
                    ?>
                </select>
            </h4>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-2">
            <h4>Select Class</h4>
        </div>
        <div class="col-xs-2">
            <h4>
                <select name="class" id="class" class="form-control">
                    <option value=0>Select Batch</option>
                    <?php
                    $classes = getPostTypeData('post_type_class');
                    $query = $wpdb->get_results("select * from batch_has_classes  where  batch_id= " . $batchID);

                    foreach ($query as $val) {
                        if (isset($classes[$val->class_id])) {
                            ?>
                            <option value="<?php echo $val->id . "_" . $val->class_id; ?>" <?php echo $classID2 == $val->class_id ? "selected" : ""; ?>><?php echo $classes[$val->class_id]; ?></option>
                            <?php
                        }
                    }
                    wp_reset_query();
                    ?>
                </select>
            </h4>
        </div>
    </div>


    <div class="row">
        <div class="col-xs-5">
            <div class="alert alert-success">
                Assigned
            </div>
        </div>
        <div class="col-xs-2"></div>
        <div class="col-xs-5">
            <div class="alert alert-danger">
                Unassigned
            </div>
        </div>
    </div>



    <div class="row">
        <div class="col-xs-5">
            <?php
            $subjects = getPostTypeData('post_type_subject');
            $query = $wpdb->get_results("select * from class_has_subject  where class_id = " . $classID);
            $available = array();
            ?>
            <select name="assgined[]" id="multiselect" class="form-control" size="10" multiple="multiple">
                <?php
                foreach ($query as $value) {

                    if (isset($subjects[$value->subject_id])) {
                        ?>
                        <option value="<?php echo $value->subject_id ?>"><?php echo $subjects[$value->subject_id]; ?></option>
                        <?php
                        $available[$value->subject_id] = $value->subject_id;
                    }
                }
                ?>
            </select>
        </div>
        <div class="col-xs-2">
            <button type="button" id="multiselect_rightAll" class="btn btn-block"><i class="glyphicon glyphicon-forward"></i></button>
            <button type="button" id="multiselect_rightSelected" class="btn btn-block"><i class="glyphicon glyphicon-chevron-right"></i></button>
            <button type="button" id="multiselect_leftSelected" class="btn btn-block"><i class="glyphicon glyphicon-chevron-left"></i></button>
            <button type="button" id="multiselect_leftAll" class="btn btn-block"><i class="glyphicon glyphicon-backward"></i></button>
        </div>

        <div class="col-xs-5">
            <select name="unassigned[]" id="multiselect_to" class="form-control" size="10" multiple="multiple">
                <?php
                foreach ($subjects as $key => $value) {
                    if (!isset($available[$key])) {
                        ?>
                        <option value="<?php echo $key ?>"><?php echo $value; ?></option>    
                        <?php
                    }
                }

                function my_admin_error_notice() {
                    $class = "update-nag";
                    $message = "your message";
                    echo"<div class=\"$class\"> <p>$message</p></div>";
                }

                add_action('admin_notices', 'my_admin_error_notice');
                ?>
            </select>
        </div>
    </div>




    <div class="row" style="margin-top: 10px !important">
        <div class="col-xs-5">
            <input type="submit" id="saveData" name="save" value="Save" class="btn btn-success <?php echo!$classID ? 'disabled' : 'dxx' ?>"> 
        </div>
    </div>


</form>



<script>
    $ = jQuery;
    $(document).ready(function () {
        setTimeout(function () {
            val = $('#class').val();
            val = parseInt(val);
            if (val == 0) {
                $('#saveData').addClass('disabled')
            }
        }, 500)


        $('#institute').on('change', function () {
            val = $('#institute').val()
            window.location = '<?php echo admin_url('admin.php?page=manag-subjects&institute=') ?>' + val + "&batch=0&class=0";
        })

        $('#batch').on('change', function () {
            val = $('#institute').val()
            batch = $('#batch').val();
            window.location = '<?php echo admin_url('admin.php?page=manag-subjects&institute=') ?>' + val + "&batch=" + batch + "&class=0";

        })
        $('#class').on('change', function () {
            val = $('#institute').val()
            batch = $('#batch').val();
            classx = $('#class').val();
            window.location = '<?php echo admin_url('admin.php?page=manag-subjects&institute=') ?>' + val + "&batch=" + batch + "&class=" + classx;
        })


        $('#multiselect').multiselect();


    })
</script>