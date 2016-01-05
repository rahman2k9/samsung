<?php
wp_enqueue_style('style-name', 'http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css');
wp_enqueue_style('style-name', plugins_url('/css/bootstrap.min.css', __FILE__));
wp_enqueue_script('the_js', plugins_url('/js/multiselect.js', __FILE__));
$batchId = 0;
if (isset($_GET['val'])) {
    $batchId = $_GET['val'];
}
global $wpdb;
if (isset($_POST['save'])) {
    $wpdb->delete('instiute_has_batch', array('institute_id' => $_POST['institute']));
    if (isset($_POST['assgined']))
        foreach ($_POST['assgined'] as $val) {
            $wpdb->insert('instiute_has_batch', array('institute_id' => $_POST['institute'], 'batch_id' => $val), array("%d", "%d"));
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
        <h1>Assign Batches to Institutes</h1>

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
                    <option value=0>Select Class</option>
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
            $classes = getPostTypeData('post_type_batch');
            $query = $wpdb->get_results("select * from instiute_has_batch where institute_id = " . $batchId);
            $available = array();
            ?>
            <select name="assgined[]" id="multiselect" class="form-control" size="10" multiple="multiple">
                <?php
                foreach ($query as $value) {
                    ?>
                    <option value="<?php echo $value->batch_id ?>"><?php echo $classes[$value->batch_id]; ?></option>
                    <?php
                    $available[$value->batch_id] = $value->batch_id;
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
            <input type="submit" id="saveData" name="save" value="Save" class="btn btn-success <?php echo!$batchId ? 'disabled' : 'dxx' ?>"> 
        </div>
    </div>
</form>
<script>
    $ = jQuery;
    $(document).ready(function () {
        setTimeout(function () {
            val = $('#institute').val();
            val = parseInt(val);
            if (val == 0) {
                $('#saveData').addClass('disabled')
            }
        }, 500)


        $('#institute').on('change', function () {
            val = $(this).val()
            window.location = '<?php echo admin_url('admin.php?page=manage-batches&val=') ?>' + val;
        })

        $('#institute').on('change', function () {
            val = $(this).val()
            window.location = '<?php echo admin_url('admin.php?page=manage-batches&val=') ?>' + val;
        })
        $('#multiselect').multiselect();
    })
</script>