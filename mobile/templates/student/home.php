<style type="text/css">
.meta img{
    border-bottom: 2px solid gray;
    border-right: 1px solid gray;
    border-radius: 3px;
    background: #fff;
}
.feeds-wrapper{
     margin-bottom: 1em;
}
</style>
<div style="min-width: 200px; height: 100px; margin; 5px 10px;" class="meta">
    <img src="../images/profiles/<?php echo $me->displayPic; ?>" alt="<?php $user->fullName; ?>" height="80" width="80">
</div>
<?php
//If the registration is less than 2 days...show welcome and stuffs
if($me->getRegDate() < 2){
    ?>
    <div class="feed-element" style="min-height: 2em;">
        <p>
            <span style="padding-bottom: 15px; background: #da534f;color: #fff;float:left;margin-right: .5em;">&#9733;</span>
            Help employers find you. <a href="profile">Build your profile now.</a>
        </p>
    </div>
    <?php
}
?>

<div class="feeds-wrapper" id="feeds-wrapper"">
    <?php
if($listings > 0){
        foreach ($newListings['result'] as $newListing) {
            $url = "project"."/".$newListing->jobId."/".cleanUrl($newListing->title);
            $employer = User::getUser($newListing->getEmployer());
            ?>
            <div class="feed-element">
                <p>
                    <a href="<?php echo $url; ?>"><?php echo $newListing->title; ?></a>
                </p>
                <span>
                    <?php echo $employer->fullName; ?></span>
                <p><?php echo truncate($newListing->description, 120, "..."); ?></p>
            </div>
        <?php
        }
        echo '<p style="text-align: center; margin-top: 2em;"><a href="search.php">View More</a>';
    }
    else {
        echo "<div class='feed-element'>";
        echo "No tailored job to show.";
        echo '<br />';
        echo '<br />';
        echo "<span class='ui-btn'><a href='search.php'>Browse All</a></span>
            Or
            <span class='ui-btn'><a href='settings/skills'>Edit Skills</a></span>";
        echo "</div>";
    }