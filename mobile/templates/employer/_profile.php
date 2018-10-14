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
    .consistent-p{
        position: relative;
    }
    .consistent{
        position:absolute;
        bottom: 0;
        right: 0;
        margin-bottom: .5em;
        margin-right: .8em;
        display: block;
    }
</style>
<div class="row pseudo-meta">
    <img src="../images/profiles/<?php echo $me->displayPic; ?>" height="60" width="60">
    <p>
        <b><?php echo $me->fullName; ?></b>
    </p>
    <p><?php echo $me->email; ?></p>
    <p>
        <span class="fa fa-map-marker"></span> <?php echo $me->location; ?>
    </p>
</div>
<?php
if($me->userID !== $user->userID){
    header("location: user/".$user->userID);
    exit;
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