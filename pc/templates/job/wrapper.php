<div class="bigger-box">
<div class="col-1" style="height: 400px;">
    <form accept-charset="utf-8" action="" method="get">
        <input type="text" name="query" placeholder="Press ENTER to search" size="45" style="padding: 8px 5px; border-radius: 4px 0 0 4px; border: 1px solid #1e5d7a;" value="<?php echo isset($query) ? $query :""; ?>">
        <p style="text-align: center;">Or search by: </p>
        <p class="section-title mini">Location</p>
        <p class="section-title mini">Expertise</p>
        <ul class="filters col-5 centered">
            <?php
            $skills = getSkills();
            foreach($skills as $skill){ ?>
                <li <?php if(strcasecmp($cat, $skill['skill']) == 0){echo "id='active'";} ?>>
                    <a href=""></a>
                </li>
            <?php }
            ?>
        </ul>
    </form>
</div>
    <?php include "home.php"; ?>
</div>