<?php
if($jobs['num_rows'] < 1) {
    echo "<h1>Nothing to show</h1>";
}
else{
?>
<div class="col-4">
    <?php
    foreach ($jobs['result'] as $match) {
        $employer = $match->getEmployer();
        //$url = $match->jobId . "/" . cleanUrl($match->title);
        $url = "?controller=job&action=view&job_id=".$match->jobId;
        $skills = array();
        foreach ($match->getSkillsRequired() as $sk) {
            $skills = $sk['skills'];
        }
        ?>
        <div class="result">
            <div class="emp-logo" style="float: left; clear: both;margin: 10px 20px;">
                <img src="/static/img/profiles/<?php echo $employer->displayPic; ?>" height="135" width="135"
                     style="border-radius: 80px;border: 1px solid #e6e6e6;">
            </div>
            <h3><a href="<?php echo $url; ?>"><?php echo $match->title; ?></a></h3>

            <p style="font-size: 1em;"><b><?php echo $employer->fullName; ?></b></p>

            <p style="font-size: .8em;"><b><?php echo $match->type; ?></b></p>

            <p><?php echo truncate($match->description, 200, "..."); ?></p>
        </div>
        <?php
    }
    echo "<p class='pager'>$pageCtrls</p>";
    ?>
</div>
<?php
}
?>
<style>
    p{
        margin-top: 8px;
    }
    /*may have to globalize this...*/
    .pager{
        float: right;
    }
    .pager a, .pager span{
        padding: 3px 10px;
        margin-right: 5px;
    }
    .pager a{
        color: #fff;
        background: #123168;
    }
    .pager a:hover{
        text-decoration: none;
    }
    .result{
        width: 70%;
        min-height: 140px;
        padding: 15px;
        background:#fff;
        margin: auto;
        border: 1px solid;
        border-color: #edecec #edecec #e7e7e7;
        font-size: .9em;
    }
    .result + .result{
        border-top: none;
    }
    .result h3 a{
        color: #319f7a;
    }
    .result:hover{
        background: #F7F7F7;
    }
    .result a:hover, .result a:focus{
        text-decoration: underline;
    }
    form input{
        margin-top: 0;
        padding: 0;
        border: 0;
        border-radius: 5px;
    }
    .filters li#active{
        font-weight: bold;
    }
</style>
