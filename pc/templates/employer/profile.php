<div class="col-4 centered">
    <article>
        <div class="col-2 centered" style="border: none;">
            <img src="/static/img/profiles/<?php echo $me->displayPic; ?>" style="height: 150px; width: 150px;"/>
        </div>
        <div class="row">
            <section class="col-1">
                <h2>Name</h2>
            </section>
            <section class="col-4 body-name">
                <p data-input="input" data-name="compName" class="val"><?php echo $me->fullName; ?></p>
            </section>
        </div>
        <div class="row">
            <section class="col-1">
                <h2>E-Mail</h2>
            </section>
            <section class="col-4 body-name">
                <p data-name="email" data-input="input" class="val"><?php echo $me->email; ?></p>
            </section>
        </div>
        <div class="row">
            <section class="col-1">
                <h2>Website</h2>
            </section>
            <section class="col-4 body-name">
                <p class="val" data-name="website" data-input="input">
                    <?php echo ($me->website != "") ? "<a target='_blank' href='{$me->website}'>{$me->website}</a>" : "N/A"; ?>
                </p>
            </section>
        </div>
        <div id="overview" class="row">
            <section class="col-1">
            <h2 class="head-obj">Overview</h2>
            </section>
            <section class="body-ov col-3">
                <p class="val" data-input="txt" data-name="overview">
                    <?php echo ($me->overview != "") ? $me->overview : "N/A"; ?>
                </p>
            </section>
        </div>

        <div class="row">
            <section class="col-1">
                <h2 class="head-loc">Location</h2>
            </section>
            <section class="body-edu col-3">
                <p data-name="location" data-input="input" class="val"><?php echo $me->location; ?></p>
            </section>
        </div>

        <div class="row">
            <h2 class="head-work">Why work with us?</h2>
            <section class="col-3">
                <p data-name="teaser" data-input="txt" class="val">
                    <?= $about['teaser'] ?>
                </p>
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
</style>