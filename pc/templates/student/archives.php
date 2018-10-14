<?php
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
    ?>
    <form action="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']); ?>" method="post">
        <table>
            <thead>
            <tr>
                <th style="text-align: center;"><input type="checkbox" name="" id="check_all" disabled></th>
                <th>Title</th>
                <th>Employer</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
                <?php
                if(!empty($total > 0)){
                    foreach($apps['result'] as $app){
                        $job = Job::getById($app['jobID']);
                        $employer = Employer::getUser($job->postedBy);
                        $jobExpiry = dateToYMD($job->expiryDate, "Y-m-d");
                        $jobUrl = "project/".$job->jobId."/".cleanUrl($job->title);
                        ?>
                <tr>
                    <td>
                        <input type="checkbox" id="" value="<?php echo $app['id']; ?>">
                    </td>
                    <td>
                        <a href="<?php echo $jobUrl; ?>"><?php echo $job->title;  ?></a>
                    </td>
                    <td>
                        <p><?php echo $employer->fullName; ?></p>
                    </td>
                    <td>
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
                    </td>
                    <td>
                        <span>
                            <a href="<?= $jobUrl; ?>"><i class="fa fa-eye"></i></a>
                        </span>
                        <input type="hidden" name="app_id" value="<?= $app['id']; ?>">
                        <button type="submit" name="remove_app" class="remove" value="remove">
                            <span class="fa fa-remove"></span>
                        </button>
                    </td>
                </tr>
                <?php
                    }
                }
                ?>
            </tbody>
        </table>
    </form>
</div>