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
    <img src="../images/profiles/<?php echo $user->displayPic; ?>" height="60" width="60">
    <p>
        <b><?php echo $user->fullName; ?></b>
    </p>
    <p><?php echo $user->email; ?></p>
    <p>
        <span class="fa fa-map-marker"></span> <?php echo $user->location; ?>
    </p>
    <span class="ui-btn consistent">
      <?php
         if($me !== "guest" && ($me->userID === $user->userID)){
             echo "<a href='settings/profile'>Edit</a>";
         }
         else{
             if($user->utype == "emp"){
                 echo "<a href='#'>Hire</a>";
             }
             else{
                 echo "<a href='#'>Invite</a>";
             }
         }
      ?>
    </span>
</div>
<?php
    if($me->userID === $user->userID){
        echo '<div class="feed-element pointer">';
        echo '<a href="">Dashboard<span>&raquo;</span></a>';
        echo '</div>';
    }
?>

<div class="row">
    <p class="section-title">Notifications</p>
    <section class="feed-element consistent-p">
        <?php
        $currentSkills = $me->getSkills();
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
            <p>You are not following any field/industry</p>
        <?php } ?>
        <p class="ui-btn consistent">
            <a href="settings/skills">Edit</a>
        </p>
    </section>
</div>

<div class="row">
    <p class="section-title">Education</p>
    <div class="feed-element consistent-p">
    <?php
    $edu = $me->getEduBg();
    if(count($edu) < 1){
        ?>
        <p>Add your education details. Remember NOT to add high school!</p>
        <p class="ui-btn consistent">
            <a href="settings/education">Edit</a>
        </p>
    <?php
    }
    else{
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
</div>
</div>

<div class="row">
    <p class="section-title">About Me</p>
    <div class="feed-element consistent-p">
        <p><?php echo ($user->overview != "") ? $user->overview : "Sell yourself in your own words. Tell employers your career objectives and how you hope to GET THERE"; ?></p>
        <p class="ui-btn consistent">
            <a href="settings/profile">Edit</a>
        </p>
    </div>
</div>

<div class="row">
    <p class="section-title">Work History</p>
    <section class="feed-element consistent-p">
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
                <p style="padding-bottom: 10px;">
                    <b><?php echo $work['title']; ?></b><br/>
                    <?php echo $work['employer']; ?><br/>
                    <?php echo $started. " to ".$ending; ?><br/>
                    <span>
                        <?php echo $work['description']; ?>
                    </span>
                </p>
                <?php
            }
            ?>
            <?php
        }
        ?>
        <p class="ui-btn consistent">
            <a href="settings/work">Edit</a>
        </p>
    </section>
</div>