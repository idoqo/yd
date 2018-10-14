<?php
if(isset($_GET['k'])){
    var_dump($_GET['k']);
}
/**handles the employer management of applications of a given project...**/
if(!ctype_digit($_GET['focus']) || $_GET['focus'] == ""){
    header("location: ../myprojects");
    exit;
}
if($me == "guest"){
    header("location: signin");
    exit;
}
$id = $_GET['focus'];
$project = Job::getById($id);
if(($project == false) || ($project->postedBy != $me->userID)){
    header("location: ../myprojects");
    exit;
}
if(isset($_POST['delete'])){
    $item = $_POST['item'];
    //3 is used for rejected
    $removed = $me->respondToApp($item, 3);
    if($removed !== true){
        $_SESSION['error'] = "Unable to complete request";
    }
    header("location: ".$_SERVER['REQUEST_URI']);
    exit;
}
$apps = $project->getBids();
?>
<div class="col-6">
    <form action="<?php htmlspecialchars($_SERVER['REQUEST_URI']); ?>" method="get">
        <div class="col-6">
            <div class="col-4">
                <label for="k">
                    <input type="text" name="k" placeholder="Keyword" id="k" style="padding: 10px; width: 70%; border: 1px solid rgba(0,0,0,0.35);">
                </label>
                <button type="submit" name="go" value="Go" class="button">Go</button>
            </div>
        </div>
    </form>
    <?php
    if(isset($_SESSION['error'])){
        echo "<div class='error'>{$_SESSION['error']}</div>";
        unset($_SESSION['error']);
    }
    ?>
    <form action="" method="post" class="removal_form">
    <table cellspacing="0">
        <thead>
        <tr>
            <th scope="col" style="text-align: center">
                <label>
                    <input type="checkbox" name="all" id="check-all" class="selector" disabled/>
                </label>
            </th>
            <th scope="col">Name</th>
            <th scope="col">Overview</th>
            <th scope="col">Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach($apps['result'] as $app){
            $sender = Student::getUser($app['userID']);
            ?>
            <tr>
                <td>
                    <label for="check"></label>
                    <input id="check" type="checkbox" name="item_selected" class="selector" value="<?php echo $app->id; ?>"/>
                </td>
                <td>
                    <a href="user/<?php echo $sender->userID; ?>"><?php echo $sender->fullName; ?></a>
                </td>
                <td>
                    <?php echo truncate($sender->overview, 200, "..."); ?>
                </td>
                <td>
                    <span class="">
                        <a href="message/<?=$sender->userID;?>">
                            <i class="fa fa-envelope-o"></i>
                        </a>
                    </span>
                    <span class="">
                        <a href="">
                            <i class="fa fa-eye"></i>
                        </a>
                    </span>
                    <button type="submit" name="delete" style="background: none; color:#062f55">
                        <i class="fa fa-remove"></i>
                    </button>
                </td>
            </tr>
                <input type="hidden" name="item" value="<?php echo $app['id']; ?>">
        <?php }
        ?>
        </tbody>
    </table>
    </form>
</div>
