<?php
wp_enqueue_style('style-name', plugins_url('/css/bootstrap.min.css', __FILE__));
wp_enqueue_style('style-name', plugins_url('/css/bootstrap.min.css', __FILE__));

wp_enqueue_script('the_js', plugins_url('/js/multiselect.js', __FILE__));
$batchId = 0;
if (isset($_GET['val'])) {
    $batchId = $_GET['val'];
}

$postBatch = 0;
$postBatch2 = 0;
if (isset($_GET['batch'])) {
    $exp = explode('_', $_GET['batch']);
    if (is_array($exp)) {
        $postBatch = $exp[0];
        $postBatch2 = $exp[1];
    }
}

global $wpdb;

if (isset($_POST['save'])) {

    $exploded = explode('_', $_POST['batch']);

    $wpdb->delete('batch_has_classes', array('batch_id' => $postBatch));
    if (isset($_POST['assgined']))
        foreach ($_POST['assgined'] as $val) {
            $wpdb->insert('batch_has_classes', array('batch_id' => $postBatch, 'class_id' => $val), array("%d", "%d"));
        }
    flash('success', 'Saved!');
}
?>
<style>
    .row{
        margin: 0px !important;
    }
</style>
<div class="row">
    <div class="col-xs-10">
        <h1>Assign Classes to Batches</h1>
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
                        <option value="<?php echo get_the_ID() ?>" <?php echo get_the_ID() == $batchId ? 'selected' : ''; ?>><?php echo get_the_title() ?></option>
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

                    $query = $wpdb->get_results("select * from instiute_has_batch where institute_id = " . $batchId);

                    foreach ($query as $val) {
                        if (isset($batchs[$val->batch_id])) {
                            ?>
                            <option value="<?php echo $val->id . "_" . $val->batch_id; ?>" <?php echo $postBatch2 == $val->batch_id ? "selected" : ""; ?>><?php echo $batchs[$val->batch_id] ?></option>

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
            $classes = getPostTypeData('post_type_class');

            $query = $wpdb->get_results("select * from batch_has_classes  where batch_id = " . $postBatch);
            $available = array();
            ?>
            <select name="assgined[]" id="multiselect" class="form-control" size="10" multiple="multiple">
                <?php
                foreach ($query as $value) {

                    if (isset($classes[$value->class_id])) {
                        ?>
                        <option value="<?php echo $value->class_id ?>"><?php echo $classes[$value->class_id]; ?></option>
                        <?php
                        $available[$value->class_id] = $value->class_id;
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
                foreach ($classes as $key => $value) {
                    if (!isset($available[$key])) {
                        ?>
                        <option value="<?php echo $key ?>"><?php echo $value; ?></option>    
                        <?php
                    }
                }
                ?>
            </select>
        </div>
    </div>

    <div class="row" style="margin-top: 10px !important">
        <div class="col-xs-5">
            <input type="submit" id="saveData" name="save" value="Save" class="btn btn-success <?php echo!$postBatch ? 'disabled' : 'dxx' ?>"> 
        </div>
    </div>
</form>
<script>
    $ = jQuery;
    $(document).ready(function () {
        setTimeout(function () {
            val = $('#batch').val();
            val = parseInt(val);
            if (val == 0) {
                $('#saveData').addClass('disabled')
            }
        }, 500)

        $('#institute').on('change', function () {
            val = $('#institute').val()
            batch = 0;
            window.location = '<?php echo admin_url('admin.php?page=manag-classes&val=') ?>' + val + "&batch=" + batch;
        })

        $('#batch').on('change', function () {
            val = $('#institute').val()
            batch = $('#batch').val();
            window.location = '<?php echo admin_url('admin.php?page=manag-classes&val=') ?>' + val + "&batch=" + batch;
        })
        $('#multiselect').multiselect();
    })
</script>