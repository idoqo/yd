<style type="text/css">
  .feed-element{
      min-height: 10em;
      background: #fff;
      border-bottom: 1px solid #c8c8c8;
      margin-bottom: .5em;
      padding: 10px;
  }
  h4 a{
      color: #42b28c;
      font-weight: bold;
  }
    .pager a, .pager span{
        margin: 0 5px;
    }
</style>
<p style="margin: .5em 0;">
</p>
<?php
if($show == "users") {
    if ($numResults > 0) {
        foreach ($results['result'] as $result) {
            $url = "user/" . $result->userID;
            ?>
            <div class="feed-element" style="position:relative;">
                <h4>
                    <a href="<?php echo $url; ?>"><?php echo $result->fullName ?></a>
                </h4>
                <p style="font-size: .8em; color: #c8c8c8;">
                    <b><?php echo $result->location; ?></b>
                </p>
                <p style="margin-top: .5em;">
                    <?php echo truncate($result->overview, 80, "...", " "); ?>
                </p>
                <p style="position: absolute; bottom: 0.8em;">
                    <span class="ui-grey-btn"><a href="messages/<?= $result->userID; ?>">Message</a></span>
                    <span class="ui-grey-btn"><a href="users/<?= $result->userID; ?>">View Profile</a></span>
                </p>
            </div>
            <?php
        }
        echo "<p class='pager'></p>";
        echo $pageCtrls;
        echo "</p>";
    }
    else{
        echo "<div class='blank'>No match found</div>";
    }
}
else{
    if($numResults > 0) {
        foreach ($matches['result'] as $match) {
            $url = "project/" . $match->jobId . "/" . cleanUrl($match->title);
            $employer = Employer::getUser($match->getEmployer());
            ?>
            <div class="feed-element">
                <h4><a href="<?php echo $url; ?>">
                        <?php echo truncate($match->title, 20, "...", " "); ?></a>
                </h4>

                <p style="font-size: .8em; color: #c8c8c8;"><b><?php echo $employer->fullName; ?></b></p>

                <p style="margin-top: .5em;">
                    <?php echo truncate($match->description, 80, "<a href='project/$url'> ...more</a>", " "); ?>
                </p>

                <p style="position: relative; top: .5em;">
                    <span></span>
                </p>
            </div>
            <?php
        }
        echo "<p class='pager'></p>";
        echo $pageCtrls;
        echo "</p>";
    } else {
        echo "<div class='blank'>No match found</div>";
    }
}
?>