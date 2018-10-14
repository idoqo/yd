<?php
if($students['num_rows'] < 1) {
    echo "Nothing to show";
}
else{
    foreach ($students['result'] as $result) {
        ?>
        <div class="result">
            <div class="col-1">
                <div class="row">
                    <img src="/static/img/profiles/<?php echo $result->displayPic; ?>" height="50" width="50">
                </div>
            </div>
            <div class="col-4">
                <h3>
                    <a href=""></a>
                </h3>
                <p style="float: right; margin-top: -1em;">
                        <span class="ui-grey-btn">
                            <a href="">Message</a>
                        </span>
                        <span class="ui-grey-btn">
                            <a href="">View Profile</a>
                        </span>
                </p>
                <p style=" margin-top: -.09em;">
                    <span class="fa fa-map-marker"></span> <?php echo $result->location; ?>
                </p>
                <p><?php echo truncate($result->overview, 120, "..."); ?></p>
            </div>
        </div>
        <?php
    }
    echo "<p class='pager'>{$pageCtrls}</p>";
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