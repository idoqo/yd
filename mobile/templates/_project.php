<style>
  body{
      color: #373737;
  }
  .ui-btn{
      padding: .1em .7em;
      background: #42B28C;
      border-radius: 2px;
      border: none;
      color: #fff;
  }
  .ui-btn a{
      color: #fff;
  }
  p i{
      margin-right: 10px;
  }
  p .vxDe{
      font-size: .8em;
  }
</style>
<div class="feed-element" style="margin: 0; min-height: 4em; padding-bottom: 15px;">
    <h3><?php echo $details->title; ?></h3>
    <?php
    //calculate time till expiry
    $created = $details->postedDate;
    $expires = !is_null($details->expiryDate) ? $details->expiryDate : "";
    $format = "";
    if($expires != ""){
        $from = new DateTime($created);
        $till = new DateTime($expires);
        $interval = $from->diff($till);
        $format = $interval->format('%a days');
    }
    ?>
    <p class="vvSed"><i class="icon-calendar"></i> <span class="vxDe">Expires in: </span><?php echo $format; ?></p>
    <p class="vvSed"><i class="icon-wallet"></i> <span class="vxDe">Budget: </span> GHC <?php echo $details->budget; ?></p>
    <p class="vvSed" style="margin-bottom: 1.5em;"><i class="icon-clock"></i> <span class="vxDe">Type:</span> <?php echo $details->type; ?></p>
    <?php
    if(!$format){
        echo '<span class="ui-gloss-btn" style="background: #a91111;">Expired</span>';
    }
    else {
        if ($me != "guest") {
            $apps = $details->getBids();
            $haveApplied = false;
            if ($apps['num_rows'] > 0) {
                foreach ($apps['result'] as $app) {
                    if ($app['userID'] == $me->userID) {
                        $haveApplied = true;
                        break;
                    }
                }
            }
            if ($haveApplied) {
                echo '<span class="ui-gloss-btn">Bid sent</span>';
            } else {
                echo '<span class="ui-gloss-btn"><a href="apply.php?job_id=' . $details->jobId . '" class="apply">Apply</a></span>';
            }
        }
        else{
            echo "<p>No Info to show</p>";
            echo '<span class="ui-gloss-btn" style="width: 100px;"><a href="signin" class="apply">Login to Apply</a></span>';
        }
    }
    ?>
</div>
<div class="feed-element pointer">
    <a href="">About Employer<span style="float: right;">&raquo;</span></a>
</div>
<div class="feed-element" style="margin-top: .5em;">
   <p><b>Description</b></p>
      <p><?php echo strip_tags($details->description, "<b><ul><li><i><u><ol>") ?></p>
      <br />
   <p><b>Requirements</b></p>
   <p><?php echo strip_tags($details->requirements, "<b><ul><li><i><u><ol>") ?></p>
</div>