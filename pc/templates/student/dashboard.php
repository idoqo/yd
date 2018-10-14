<h1>Welcome, <?php echo $me->fname; ?></h1>
<div>
    <div style="width: 30%; min-height: 600px;box-shadow: 0 1px 3px #c8c8c8;float: right;margin-right: -1em;" class="right-banner">
        <p class="section-title tooltip">
            <span class="fa fa-newspaper-o"></span>
            <span><b>Activity Feeds</b></span>
        </p>
        <div class="col-4">
            No new Activity
        </div>
    </div>
</div>
<div>
    <ul class="ui-grid-large portfolio-container">
        <li style="margin-top: -5px;">
            <div>
                <img src="/static/img/bannerr.jpg" />
            </div>
        </li>
        <li style="min-height: 300px;">
            <p class="section-title tooltip">
                <span class="fa fa-rss" ></span ><span ><b > New Listings</b ></span >
            </p >
            <div style = "width: 94%; margin: auto; margin-top: 1em; color: #818181;" >
                <?php
                if( $count > 0) {
                    foreach ($newListings['result'] as $newListing) {
                        $url = "project"."/".$newListing->jobId."/".cleanUrl($newListing->title);
                        ?>
                        <div class="new-listing feed-element">
                            <p>
                                <a href="<?php echo $url; ?>"><?php echo $newListing->title; ?></a>
                            </p>
                            <span><?php echo $newListing->getEmployer()->fullName; ?></span>
                            <p><?php echo truncate($newListing->description, 120, "..."); ?></p>
                        </div>
                        <?php
                    }
                    echo '<p style="text-align: center; margin-top: 2em;"><a href="search.php">View More</a>';
                }
                else{
                    ?>
                    <p>
                        <?= empty($following) ?
                            "Jobs that appear here are tailored based on your
                     expertise and interests"
                            :
                            "No new project requiring your expertise.";
                        ?>
                    </p>
                    <br />
                    <?php
                    echo "<p style='text-align: center'>";
                    echo "<span class='button'><a href='settings/skills'>Add Interests</a></span>";
                    echo "</p>";
                }
                ?>
            </div>
        </li>
    </ul>
</div>
    <?php
/**
 * the $style variable (without the underscore are used in somewhat mini files and
 * utilized by the file including them to make up the $__styles variable
 * to be outputted by footer.php)
 */
    ?>
<style type="text/css">
    .section-title + div{
        width: 94%; margin: auto; margin-top: 1em; color: #818181;
    }
    li > div{
        padding: 10px;
        margin: auto;
    }
    .pseudo-meta li > div{
        height: 60%;
        font-weight: normal;
        font-size: 300%;
    }
    .pseudo-meta div .fa{
        font-size: 60%;
        background: #3498DB;
        text-shadow: none;
        padding: 10px;
        border-radius: 30px;
    }
    .pseudo-meta li > div h4{
        float: right;
    }
    .ui-grid-large{
        padding: 15px;
        width: 65%;
        float: left;
        margin-left: -1em;
    }
    .ui-grid-large li{
        display: inline-block;
        width: 94%;
        min-height: 150px;
        margin-top: 1.5em;
        padding-bottom: 10px;
        border: 1px solid;
        border-color: #eee #eee rgba(0, 0,0, 0.2);
        font-size: .95em;
    }
    .ui-grid-large li img{
        height: 280px;
        width: 100%;
    }
    .new-listing{
        position: relative;
        padding: 5px 0 5px 8%;
        font-size: .8em;
    }
    .new-listing:before{
        font-family: FontAwesome;
        content: '\f0da';
        color: #da534f;
        font-size: 100%;
        position: absolute;
        top: 40%;
        width: 2%;
        margin-left: -8%;
    }
    .section-title{
        text-transform: none;
    }
</style>