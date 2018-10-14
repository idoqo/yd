<?php
require "../../helpers/settings.config.inc";
require "../../helpers/user.class.php";
require "../../helpers/Job.php";
require "../../helpers/ratings.class.php";
require "../../helpers/functions.php";

$user = isset($_GET['user']) ? $_GET['user'] : "";
if(!preg_match('/[0-9]+/', $user)){
    header("location: 404.php");
    exit;
}
$user = User::getUser($user);
if(!$user){
    header("location: 404.php");
    exit;
}
$pageTitle = $user->fullName." on Yedoe";
require "header.php";
?>
<style>
    .pseudo-meta{
        min-height: 8em;
        background: #fff;
        border-bottom: 1px solid #c8c8c8;
        position: relative;
        padding: 5px;
    }
    .pseudo-meta img{
        float: left;
        clear: none;
        margin-right: 1em;
    }
</style>
<div class="row pseudo-meta">
    <img src="../images/profiles/<?php echo $user->displayPic; ?>" height="60" width="60">
    <p>
        <b><?php echo $user->fullName; ?></b>
    </p>
    <p><?php echo $user->email; ?></p>
    <p><a target="_blank" href="<?php echo $user->website; ?>"><?php echo $user->website; ?></a></p>
    <p>
        <span class="fa fa-map-marker"></span> <?php echo $user->location; ?>
    </p>
</div>
<?php
if($user->utype == "student") {
    ?>
    <div class="row">
        <p class="section-title">Following</p>
        <section class="feed-element consistent-p">
            <?php
            $currentSkills = $user->getSkills();
            if (!empty($currentSkills)) {
                foreach ($currentSkills as $cs) {
                    ?>
                    <span class="skill-tag removable">
                    <?php echo $cs['skill']; ?>
                </span>
                    <?php
                }
            } else {
                ?>
                <p>This user has not turned on notifications for any field</p>
            <?php } ?>
        </section>
    </div>

    <div class="row">
        <p class="section-title">Education</p>

        <div class="feed-element consistent-p">
            <?php
            $edu = $user->getEduBg();
            if (count($edu) < 1) {
                ?>
                <p>No education history to show</p>
                <?php
            } else {
                foreach ($edu as $ed) {
                    $inst = $ed['institution'];
                    $started = new DateTime($ed['date_started']);
                    $started = $started->format('F Y');

                    $ending = new DateTime($ed['date_ending']);
                    $ending = $ending->format('F Y');

                    $location = $ed['location'];
                    $major = $ed['major'];
                    $award = $ed['award'];
                    ?>
                    <p style="padding-bottom: 10px;">
                        <b><?php echo $award . " in " . $major; ?></b><br/>
                        <?php echo $inst . ", " . $location; ?><br/>
                        <?php echo $started . " to " . $ending; ?>
                    </p>
                    <?php
                }
            }
            ?>
        </div>
    </div>
    <div class="row">
        <p class="section-title">About Me</p>

        <div class="feed-element consistent-p">
            <p><?php echo $user->overview; ?>
        </div>
    </div>
    <div class="row">
        <p class="section-title">Work History</p>
        <section class="feed-element consistent-p">
            <?php
            $works = $user->getPortfolio();
            if (empty($works)) {
                ?>
                <div class="col-4 centered blank">
                    No work history to show.
                </div>
                <?php
            } else {
                foreach ($works as $work) {
                    $started = new DateTime($work['started_date']);
                    $started = $started->format('F Y');

                    $ending = new DateTime($work['end_date']);
                    $ending = $ending->format('F Y');
                    ?>
                    <p style="padding-bottom: 10px;">
                        <b><?php echo $work['title']; ?></b><br/>
                        <?php echo $work['employer']; ?><br/>
                        <?php echo $started . " to " . $ending; ?><br/>
                        <span><?php echo $work['description']; ?></span>
                    </p>
                    <?php
                }
            }
            ?>
        </section>
    </div>
    <?php
}
elseif($user->utype == "emp"){
    $about = $user->getInfo();
    $industry = array();
    if($about['industry'] != ""){
        $industry = getSkills($about['industry']);
        foreach($industry as $ind){
            //$industry[] = $ind['skill'];
            $industry = $ind['skill'];
        }
    }
    ?>
    <div class="row">
        <p class="section-title">Industry</p>
        <section class="feed-element consistent-p">
            <?php
            echo ($industry) ? $industry : "Not available";
            ?>
        </section>
    </div>

    <div class="row">
        <p class="section-title">Overview</p>
        <div class="feed-element consistent-p">
            <p><?php echo ($me->overview != "") ? $me->overview : "Not available"; ?></p>
        </div>
    </div>

    <div class="row">
        <p class="section-title">Why Work with Us?</p>
        <div class="feed-element consistent-p">
            <p><?php echo ($about['teaser'] != "") ? $about['teaser'] : ""; ?></p>
        </div>
    </div>
<?php
}