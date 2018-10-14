<?php
$apps = $me->getApplications();
//if a DB error occurs...
if(!is_array($apps)){
    //do stuffs and..
    die();
}
$total = $apps['num_rows'];
if(isset($_POST['remove_app'])){
    if($me->retractApp($_POST['app_id']) !== true){
        $_SESSION['error'] = "Unable to complete request";
    }
    header("location: ".$_SERVER['REQUEST_URI']);
    exit;
}
?>
<div>
    <?php
    if(isset($_SESSION['error'])){
        echo "<div class='feedback error'>{$_SESSION['error']}</div>";
        unset($_SESSION['error']);
    }
    if(!empty($total > 0)){
        foreach($apps['result'] as $app){
            $job = Job::getById($app['jobID']);
            $employer = Employer::getUser($job->postedBy);
            $jobExpiry = dateToYMD($job->expiryDate, "Y-m-d");
            $jobUrl = "project/".$job->jobId."/".cleanUrl($job->title);
            ?>
            <form action="<?= htmlspecialchars($_SERVER['REQUEST_URI']); ?>" method="post">
            <div class="feed-element row rug-p">
                <h3><a href="<?php echo $jobUrl; ?>"><?php echo $job->title;  ?></a></h3>
                <p style="font-size: .8em;"><b><?php echo $employer->fullName; ?></b></p>
                <section class="rug">
                    <span class="ui-grey-btn">
                        <?php
                        if($jobExpiry < date("Y-m-d")){
                            echo "Expired";
                        }
                        else{
                            if($app['status'] == 3){
                                echo "Rejected";
                            }else{
                                echo "Pending";
                            }
                        }
                        ?>
                    </span>
                    <input type="hidden" name="app_id" value="<?= $app['id']; ?>">
                    <button type="submit" name="remove_app" class="remover" value="remove">
                        <span class="fa fa-remove"></span>
                    </button>
                </section>
            </div>
            </form>
            <?php
        }
    }
    else{
        echo "<div class='feed-element'>No Application sent yet</div>";
    }
    ?>
