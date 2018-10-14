<?php
$__directives = array("<link href='cv_themes/css/fancy.css'");
?>
<div class="col-4 centered">
    <article>
        <div class="row tacked-p" style="border: none;">
            <div class="col-1" style="border: none;">
                <img src="images/profiles/<?php echo $user->displayPic; ?>" style="height: 150px; width: 150px;"/>
            </div>
            <div class="col-4"  style="border: none; min-height: 120px;">
                <h3><?php echo $user->fullName; ?></h3>
                <p><?php echo $user->email; ?></p>
                <p><?php echo $user->location; ?></p>
                <br/>
                <p class="val" data-input="txt" data-name="overview">
                    <?php echo $user->overview; ?>
                </p>
            </div>
        </div>
        <div class="row tacked-p">
            <section class="col-1">
                <h2 class="head-edu">Education</h2>
            </section>
            <section class="col-4">
                <?php
                $edu = $user->getEduBg();
                if(count($edu) < 1){
                    ?>
                    <div class="col-4 centered blank">
                        No educational history found.
                    </div>
                    <?php
                }
                else{
                    //$iterator = 0x00E032; //bullshit integer to differentiate forms
                    foreach($edu as $ed){
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
                            <b><?php echo $award." in ".$major; ?></b><br/>
                            <?php echo $inst.", ".$location; ?><br/>
                            <?php echo $started. " to ".$ending; ?>
                        </p>
                        <?php
                    }
                }
                ?>
            </section>
        </div>
        <div class="row tacked-p">
            <section class="col-1">
                <h2 class="head-work">Work history</h2>
            </section>
            <section class="col-4">
                <?php
                $works = $user->getPortfolio();
                if(empty($works)){
                    ?>
                    <div class="col-4 centered blank">
                        None Available
                    </div>
                    <?php
                }
                else{
                    foreach($works as $work){
                        $started = new DateTime($work['started_date']);
                        $started = $started->format('F Y');

                        $ending = new DateTime($work['end_date']);
                        $ending = $ending->format('F Y');
                        ?>
                        <p style="padding-bottom: 10px;">
                            <b><?php echo $work['title']; ?></b><br/>
                            <?php echo $work['employer']; ?><br/>
                            <?php echo $started. " to ".$ending; ?><br/>
                            <span><?php echo $work['description']; ?></span>
                        </p>
                        <?php
                    }
                    ?>
                    <?php
                }
                ?>
            </section>
        </div>
        <div class="row tacked-p">
            <section class="col-1">
                <h2>Notifications</h2>
            </section>
            <section class="col-4 body-name">
                <?php
                $currentSkills = $user->getSkills();
                if(!empty($currentSkills)) {
                    foreach ($currentSkills as $cs) {
                        ?>
                        <span class="skill-tag">
                            <?php echo $cs['skill']; ?>
                        </span>
                        <?php
                    }
                }
                else{
                    ?>
                    <p>This user has not turned on notifications for any field</p>
                <?php } ?>
            </section>
        </div>
    </article>
</div>
<style>
    article > div{
        min-height: 2em;
        position: relative;
        padding-bottom: .6em;
    }
    article .col-1{
        padding: 0 10px 0 0;
    }
    article h2{
        width: auto;
        padding: 3px 10px;
    }
    html{
        /**was over-ridden in fancy.css**/
        min-width: 900px;
    }
    .body-basics p{
        line-height: 1.5;
    }
    .tacked-p{
        position: relative;
    }
    .tacked{
        position: absolute;
        bottom: 5px;
        right: 0;
    }
</style>