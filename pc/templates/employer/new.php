<style type="text/css">
    .col-4{
        background: rgba(0,0,0,0.04);
        border: 1px solid rgba(0,0,0,0.1);
        min-height: 550px;
    }
    form *{
      line-height: 2;
    }
    form input[type="text"], form input[type="number"],form input[type="password"],form input[type="date"], textarea{
        padding: 5px 10px;
        width: 80%;
    }
    form input[type="checkbox"]{
        margin: 0;
        padding: 0;
        border: 0;
    }
    form select{
        color: black;
    }
    textarea{
        height: 150px;
        margin-left: 3em;
        resize: none;
    }
    #range{
        margin-bottom: 100px;
    }
    #range .col-2{
        padding: 0;
        margin-bottom: 1em;
    }
</style>

<form action="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']); ?>" method="post" enctype="multipart/form-data">
<div class="col-4">
    <?php
    if(isset($_SESSION['error'])){
        echo "<div class='error'>{$_SESSION['error']}</div>";
        unset($_SESSION['error']);
    }
    ?>
    <div class="col-6">
        <label for="title">Title:
            <input type="text" name="title" placeholder="Title" <?php if(isset($_SESSION['title'])){echo 'value="'.$_SESSION['title'].'"';unset($_SESSION['title']);} ?>>
        </label>
        <label for="description"></label>
        <p>Description: </p>
        <textarea id="description" name="description"><?php if(isset($_SESSION['desc'])){echo $_SESSION['desc']; unset($_SESSION['desc']);} ?></textarea>
        <label for="req"></label>
        <p>Requirements:</p>
        <textarea id="req" name="requirements"><?php if(isset($_SESSION['desc'])){echo $_SESSION['req']; unset($_SESSION['req']);} ?></textarea>
    </div>
</div>
<div id="right-sidebar" style="">
    <p class="section-title">Preferences</p>
    <div class="col-6">
        <p class="section-title mini">Field</p>
        <label for="skills">
            <select name="skills[]" id="skills">
                <option value="">Choose field</option>
                <?php
                foreach($cats as $cat){
                    echo "<option value='{$cat['skill_id']}'>{$cat['skill']}</option>";
                }
                ?>
            </select>
        </label>
        <p class="section-title mini">Benefits</p>
        <label for="type">
            <input type="checkbox" id="type" name="type"> Paid Internship
        </label>
        <div id="range">
            <p><b>Range </b></p>
            <div class="col-2" style="margin-right: 10px;">
                <p>From:</p>
                <label>
                    <input type="number" name="sRange">
                </label>
            </div>
            <div class="col-2" style="">
                <p>To:</p>
                <label>
                    <input type="number" name="eRange">
                </label>
            </div>
        </div>
        <p class="section-title mini">Expiry</p>
        <label for="expiry"></label>
        <input type="date" name="expiry_date" id="expiry">
    </div>
    <input type="submit" name="post" value="Post" style="line-height: 1.2; border-radius: 1px;"/>
</div>
</form>