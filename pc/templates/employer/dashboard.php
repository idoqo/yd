<style type="text/css">
    .feed-element:last-child{
        border: none;
    }
    .ad-banner img{
        height: 20em;
        width: 100%;
    }
</style>
<h1><?php echo $me->fullName; ?></h1>
<div class="details" style="padding: 0;">    <div class="detail ad-banner" style="margin-bottom: 1em;">
        <img src="images/emp-banner.jpg" alt=""/>
    </div>
    <div>
        <p class="section-title"><span class="fa fa-wifi"></span> <span>Activity Feed</span></p>
        <div style="border: 1px solid #e7e7e7;">
            <?php
            if($feeds != false) {
                foreach ($feeds['apps'] as $feed) {
                    $feedFrom = Student::getUser($feed['userID']);
                    $job = Job::getById($feed['jobID']);
                    echo "<div class='feed-element app'>";
                    echo "New application from <a href='user/{$feedFrom->userID}'>{$feedFrom->fullName}</a> for {$job->title}&raquo; <br/><a href='myproject/{$job->jobId}'>View now</a>";
                    echo "</div>";
                }
            }
            else{
                ?>
                <div  style="height: 120px; text-align: center;">
                    <h2 style="color: #d7d7d7;">No Activity</h2>
                </div>
            <?php
            }
            ?>
        </div>
    </div>
</div>
<div id="right-sidebar">
    <p class="section-title" style="text-transform: none; background: none; color: rgba(0,0,0,0.7); font-weight: bold;">Recommended profiles</p>
    <div>
    <?php
    if($recommended != false) {
        foreach ($recommended as $bull) {
            foreach ($bull as $reco) {
                if (is_int($reco))
                    continue;
                $profileUrl = "profile/" . $reco->userID . "/" . htmlentities(str_replace(" ", "-", $reco->fullName));
                echo "<div class='feed-element new-listing'>";
                echo "<a href='profile/{$reco->userID}'>{$reco->fullName}</a>";
                echo "<p style='font-size: .8em;'>$reco->title</p>";
                echo "<p>";
                echo truncate($reco->overview, 100, " ...");
                echo "</p>";
                echo "</div>";
            }
        }
    }
    else{
        echo "<div class='blank' style='padding: 15px;'>No recommendation yet</div>";
    }
    echo "<span class='fa fa-search' style='padding: 5px 8px; background: #da534f;color: #fff; border-radius: 3px; margin: 2em 5em;'>
            <a href='search.php' style='color: #fff'>Browse all</a>
        </span>"

    ?>
    </div>
</div>