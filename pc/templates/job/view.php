<style>
    .details{
        width: 90%;
    }
    h3{
        font-weight: normal;
        line-height: 2;
    }
    .col-5{
        text-align: justify;
        padding: 10px 15px;
    }
    .col-5 header{
        margin-bottom: 10px;
        padding: 10px 5px;
        border-bottom: 2px solid #e7e7e7;
        line-height: 1.5;
        min-height: 7em;
    }
    .col-5 section.bottom{
        border-top: 2px solid #e7e7e7;
    }
    .col-5 header p span{
        margin-right: 1.5em;
    }
    .col-5 header p span i{
        margin-right: .5em;
    }
    p i{
        margin-right: 1em;
    }
    .section-title{
        height: 1em;
        padding: .5em;
        background-image: -webkit-gradient(linear, 50% 100%, 50% 0%, from(#e7e7e7), to(#fff));
        background-image: -moz-linear-gradient(#fff, #e7e7e7);
        background: #fff;
        color: #123148;
        border-bottom: 1px solid #da534f;
        position: relative;
    }
    .bookmark-mimic:after{
        content: "";
        position: absolute;
        border: 10px solid transparent;
        border-left:15px solid #782b28;
        left: 93%;
        top: 60%;
        z-index: -999;
    }
    .social{
        background: yellow;
        padding: 8px;
        margin: 10px;
    }
    .social .fa{
        margin-right: .5em;
    }
    .social a{
        color: #fff;
    }
    .social.facebook{
        background: #3a5795;
    }
    .social.whatsapp{
        background: #68ae87;
    }
    .social.twitter{
        background: #55acee;
    }
</style>

<div class="sidebar " style="background: #fff;min-height: 100%; box-shadow: 1px 2px 4px #c8c8c8; padding: 5px; text-align: center">
    <p class="section-title bookmark-mimic" style="color: #fff;position: relative;background-color: #da534f; position: relative;left: 15px;"><b>About the Client</b></p>
    <br />
    <p><?php echo $employer->fullName; ?></p>
    <p>
        <img src="/static/img/profiles/<?php echo $employer->displayPic; ?>" height="80" width="80" style="margin: 10px auto;">
    </p>
    <p><span class="fa fa-map-marker"></span> <?php echo $employer->location; ?></p>
    <br />
    <div style="text-align: left; margin-top: 15px;border: 1px solid; border-color: #f7f7f7 #f7f7f7 #e7e7e7;">
        <p class="section-title" style="background-color: #F7F7F7;border-bottom: 1px solid #e7e7e7;padding: 1em;">Company Overview</p>
        <div style="width: 94%; margin: auto;">
            <?php
            if($employer->overview == ""){
                echo "<h1 style='padding: 10px 0; color: #f7f7f7; text-align: center;'>N/A</h1>";
            }
            else{
                echo $employer->overview;
            }
            ?>
        </div>
    </div>
    <div style="text-align: left; margin-top: 15px;border: 1px solid; border-color: #f7f7f7 #f7f7f7 #e7e7e7;">
        <p class="section-title" style="background-color: #F7F7F7;border-bottom: 1px solid #e7e7e7;padding: 1em;">OTHER PROJECTS</p>
        <div style="width: 94%; margin: auto;">
            <?php
            $others = $employer->getCreatedJobs();
            if(!empty($others)) {
                foreach ($others as $otherJob) {
                    if ($otherJob->jobId == $details->jobId) {
                        continue;
                    }
                    $url = "?controller=job&action=view&job_id=".$otherJob->jobId;
                    ?>
                    <p style='padding: 10px 0;border-bottom: 1px solid #e7e7e7;min-height: 30px;'>
                        <a href='<?php echo $url ?>'><?php echo $otherJob->title ?></a>
                    </p>
                    <span style='float: right; margin-top: -15px;'>
                        <?php
                        echo ($otherJob->status == 1) ?
                            "<i class='fa fa-folder-open' style='color: #42b28c;'></i>" :
                            "<i class='fa fa-folder' style='color: #da534f;'></i>"
                        ?>
                    </span>
                    <?php
                }
            }
            ?>
        </div>
    </div>
</div>
<div class="bigger-box">
    <div class="col-5">
        <header>
            <h3><?php echo $details->title; ?></h3>
            <p>
                <b><?php echo $employer->fullName; ?></b>
            </p>
            <p style="margin-top: 1em; font-size: .8em;">
                <span><i class="fa fa-database"  title="Applications"></i><?php echo $num_applications; ?></span>
                <?php if($format && $format < 300){ ?><span><i class="fa fa-calendar" title="Expires in"></i><?php echo $format." days"; ?></span><?php } ?>
                <span><i class="fa fa-money" title="Budget"></i>GHC <?php echo $details->budget; ?></span>
                <span><i class="fa fa-clock-o" title="Job type"></i><?php echo ucfirst($details->type); ?></span>
                <?php
                if(!$format){
                    echo '<span class="ui-gloss-btn" style="background: #a91111;">Expired</span>';
                }
                else {
                    if ($haveApplied) {
                        echo '<span class="ui-gloss-btn">Bid sent</span>';
                    } else {
                        echo '<span class="ui-gloss-btn"><a href="apply.php?job_id=' . $details->jobId . '" class="apply">Apply</a></span>';
                    }
                }
                ?>
            </p>
        </header>
        <p><b>Description</b></p>
        <p><?php echo strip_tags($details->description, "<a><ul><li><ol><b>"); ?></p>
        `<br />
        <p><b>Requirements</b></p>
        <p><?php echo strip_tags($details->requirements, "<a><ul><li><ol><b>"); ?></p><br/>
        <section class="bottom">
            <p style="margin-top: 15px;">
                Share This:
               <span class="social facebook">
                   <a href="<?=$fbUrl?>" target="_blank"><i class="fa fa-facebook"></i> Facebook </a>
               </span>
               <span class="social twitter">
                   <a href="<?=$twitterUrl?>" target="_blank"><i class="fa fa-twitter"></i> Twitter </a>
               </span>
            </p>
        </section>
    </div>
</div>