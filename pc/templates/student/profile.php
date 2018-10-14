<div class="col-4 centered">
    <article>
        <div class="row tacked-p" style="border: none;">
            <div class="col-1" style="border: none;">
                <img src="/static/img/profiles/<?php echo $me->displayPic; ?>" style="height: 150px; width: 150px;"/>
            </div>
            <div class="col-4"  style="border: none; min-height: 120px;">
                <h3><?php echo $me->fullName; ?></h3>
                <p><?php echo $me->email; ?></p>
                <p><?php echo $me->location; ?></p>
                <br/>
                <p class="val" data-input="txt" data-name="overview">
                    <?php echo $me->overview; ?>
                </p>
            </div>
            <span class="tacked">
                <a href="settings/profile"><i class="fa fa-pencil"></i></a>
            </span>
        </div>
        <div class="row tacked-p">
            <section class="col-1">
                <h2 class="head-edu">Education</h2>
            </section>
            <section class="col-4">
                <?php
                $edu = $me->getEduBg();
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
                        <form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post" class="removal_form">
                            <p style="padding-bottom: 10px;">
                                <b><?php echo $award." in ".$major; ?></b><br/>
                                <?php echo $inst.", ".$location; ?><br/>
                                <?php echo $started. " to ".$ending; ?>
                                <input type="hidden" name="item_id" value="<?php echo $ed['id']; ?>" >
                                <button type="submit" name="remove_edu" value="remove_edu" style="float: right;">
                                    <span class="fa fa-close"></span>
                                </button>
                            </p>
                        </form>
                        <?php
                    }
                }
                ?>
            </section>
            <span class="tacked">
                <a href="settings/education"><i class="fa fa-pencil"></i></a>
            </span>
        </div>
        <div class="row tacked-p">
            <section class="col-1">
                <h2 class="head-work">Work history</h2>
            </section>
            <section class="col-4">
                <?php
                $works = $me->getPortfolio();
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
                        <form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post" class="removal_form">
                            <p style="padding-bottom: 10px;">
                                <b><?php echo $work['title']; ?></b><br/>
                                <?php echo $work['employer']; ?><br/>
                                <?php echo $started. " to ".$ending; ?><br/>
                        <span>
                            <?php echo $work['description']; ?>
                        </span>
                                <input type="hidden" name="item_id" value="<?php echo $work['id']; ?>" >
                                <button type="submit" name="remove_work" value="remove" style="float: right;">
                                    <span class="fa fa-close"></span>
                                </button>
                            </p>
                        </form>
                        <?php
                    }
                    ?>
                    <?php
                }
                ?>
            </section>
            <span class="tacked">
                <a href="settings/work"><i class="fa fa-pencil"></i></a>
            </span>
        </div>
        <div class="row tacked-p">
            <section class="col-1">
                <h2>Notifications</h2>
            </section>
            <section class="col-4 body-name">
                <?php
                $currentSkills = $me->getSkills();
                if(!empty($currentSkills)) {
                    foreach ($currentSkills as $cs) {
                        ?>
                        <form class="removal_form" action="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']); ?>"
                              method="post" style="display: inline;">
                            <input type="hidden" name="sk_item" value="<?php echo $cs['skill_id']; ?>">
                    <span class="skill-tag removable">
                        <?php echo $cs['skill']; ?>
                        <button type="submit" name="remove_sk">
                            <i class="fa fa-remove"></i>
                        </button>
                    </span>
                        </form>
                        <?php
                    }
                }
                else{
                    ?>
                    <p>You are not following any field/industry</p>
                <?php } ?>
            </section>
            <span class="tacked">
                <a href="settings/skills"><i class="fa fa-pencil"></i></a>
            </span>
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