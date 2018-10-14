<?php
$option = isset($_GET['v']) ? $_GET['v'] : "";
switch($option){
    case "overview":

        if(isset($_POST['save']) && $_POST['save'] == "Save"){
            if($me == "guest"){
                header("location: signin");
                exit;
            }
            $newOverview = htmlspecialchars($_POST['overview']);
            if($me->updateField("overview", $newOverview)){
                header("location: profile/");
                exit;
            }
            else{
                $_SESSION['error'] = "Failed to save changes";
                header("location: ".$_SERVER['REQUEST_URI']);
                exit();
            }
        }

        if(isset($_SESSION['error'])){
            echo "<p class='error'>{$_SESSION['error']}</p>";
            unset($_SESSION['error']);
        }
        ?>
    <form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
        <label for="overview"></label>
        <textarea name="overview" id="overview"><?php echo $me->overview; ?></textarea>
        <span class="passive"><a href="profile">Cancel</a></span>
        <input type="submit" name="save" value="Save">
    </form>
<?php
    break;

    case "skills":
        header("location: welcome/skills");
        exit();
    break;

    case "education":
    case "edu":
        if(isset($_POST['save']) && $_POST['save'] == "Save") {
            $college = $_POST['institution'];
            $award = $_POST['award'];
            $started = $_POST['started'];
            $ending = $_POST['ending'];

            if ($me == "guest") {
                header("location: signin");
                exit;
            }
            /**SANITIZE**/
            var_dump($me->setEduBg($_POST));
        }
            ?>

        <form action="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']); ?>" method="post" class="body-form">
            <label for="inst"></label>
            <input id="inst" name="institution" placeholder="Institution" type="text"/>

            <label for="major"></label>
            <input type="text" name="major" placeholder="Major" id="major"/>

            <label for="award"></label>
            <select id="award" name="award">
                <option value="">Award</option>
                <option value="bsc">BSc</option>
                <option value="diploma">Diploma</option>
                <option value="">Award</option>
            </select>
            <br/>
            <br/>
            <label for="date_started"></label>
            From
            <select name="date_started" id="started">
                <option value="">Started</option>
                <?php
                for($i=date("Y");$i>2000;$i--){
                    echo "<option value='$i'>$i</option>";
                }
                ?>
            </select>
            To
            <label for="date_ending"></label>
            <select name="date_ending" id="date_ending">
                <option value="">Ending</option>
                <?php
                for($i=2022;$i>2014;$i--){
                    echo "<option value='$i'>$i</option>";
                }
                ?>
            </select>
            <br/>
            <br/>
            <span class="button passive"><a href="profile/">Cancel</a></span>
            <input type="submit" name="save" value="Save" />
        </form>
        <?php

    break;

    case "work":
        if(isset($_POST['save']) && $_POST['save'] == "Save"){
            if($me == "guest"){
                header("location: signin");
                exit;
            }
            var_dump($me->createPortfolio($_POST));
        }
        ?>
        <form action="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']); ?>" method="post" class="body-form">
            <label for="employer"></label>
            <input type="text" name="employer" id="employer" placeholder="Employer" />

            <label for="title"></label>
            <input type="text" name="title" id="title" placeholder="Job Title">

            <label for="description"></label>
            <textarea name="description" id="description" placeholder="Write briefly about the work"></textarea>

            <br/>
            <br/>

            <label for="started"></label>
            <select name="start_date" id="started">
                <option value="">Started</option>
                <?php
                for($i=date("Y");$i>2000;$i--){
                    echo "<option value='$i'>$i</option>";
                }
                ?>
            </select>

            <label for="ended"></label>
            <select name="end_date" id="ended" style="margin-left: 2em;">
                <option value="">Ending</option>
                <?php
                for($i=2022;$i>2014;$i--){
                    echo "<option value='$i'>$i</option>";
                }
                ?>
            </select>
            <br/>
            <br/>
            <span class="ui-btn passive"><a href="profile/">Cancel</a></span>
            <input type="submit" name="save" value="Save" />
        </form>

    <?php

}
?>
<style type="text/css">
    textarea{
        width: 95%;
        padding: 5px;
        height: 300px;
    }
    .body-form input[type="text"], .body-form input[type="number"]{
        border:1px solid rgba(0,0,0,0.11);
        padding: 8px .1em;
        width: 100%;
        color: rgba(0, 0,0,0.6);
        margin: .5em 0;
    }
    .body-form select{
        width: auto;
        padding: 8px .1em;
    }
    .passive{
        padding: 8px 5px
    }
</style>