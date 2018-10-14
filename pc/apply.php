<?php
/*apply for a job. No template required*/
require "../helpers/functions.php";
require "../helpers/settings.config.inc";
require "../helpers/user.class.php";
require "../helpers/Job.php";
function crash($msg = false){
    ?>
    <div class="col-4 centered error">
        <?php
        if($msg){
            echo $msg;
        }
        else{
        ?>
            Your request could not be completed.
            Maybe you do not have the privileges to do that
            after all...or our servers misunderstood you.
            <?php } ?>
    </div>
<?php
    die();
}
$jobId = isset($_GET['job_id']) ? $_GET['job_id'] : "";
$details = Job::getById($jobId);
if($details == null){
    crash();
}


if($me == "guest"){
    crash();
}
if($me->utype == "emp"){
    crash();
}
$apply = $me->apply($jobId);
if($apply != "ok"){
    crash("Unable to complete your request. Please try later");
}
else{
    header("location: myprojects");
}

