<?php
$edu = $me->getEduBg();
if((count($edu)) >= 10){
    ?>
    <div class="col-3 centered">
        You cannot have more than ten educational history in your resume at a time.
        You could try removing some.
    </div>
<?php
}
else{
if (isset($_POST['save'])) {
    $institution = trim($_POST['institution']); //not passed to the method. Just used for validation
    $yEnd = $_POST['year_ending'];
    $yStart = $_POST['year_started'];
    $mEnd = $_POST['month_ending'];
    $mStart = $_POST['month_started'];

    if (($institution == "")) {
        $_SESSION['error'] = "Institution name cannot be blank.";
        header("location: ".$_SERVER['REQUEST_URI']);
        exit;
    }
    if($_POST['award'] == ""){
        $_SESSION['error'] = "No qualification chosen.";
        header("location: ".$_SERVER['REQUEST_URI']);
        exit;
    }
    if($_POST['major'] == ""){
        $_SESSION['error'] = "Please choose your programme/course.";
        header("location: ".$_SERVER['REQUEST_URI']);
        exit;
    }
    if (($mStart < 1) || ($mStart > 12)) {
        $_SESSION['error'] = "WTF? Start month is invalid.";
        header("location: ".$_SERVER['REQUEST_URI']);
        exit;
    }
    if (($yStart < 2000) || ($yStart > 2015)) {
        $_SESSION['error'] = "Start year is out of range";
        header("location: ".$_SERVER['REQUEST_URI']);
        exit;
    }
    if (($mEnd < 1) || $mEnd > 12) {
        $_SESSION['error'] = "WTF? End month is invalid";
        header("location: ".$_SERVER['REQUEST_URI']);
        exit;
    }
    if (($yEnd < 2000) || $yEnd > 2025) {
        $_SESSION['error'] = "End year is out of range";
        header("location: ".$_SERVER['REQUEST_URI']);
        exit;
    }
    //this seems like the quickest idea to get the dates working
    //reflected in the db table
    $dateStart = new DateTime();
    $dateEnd = new DateTime();

    $dateStart = $dateStart->createFromFormat("Y-m-d", $yStart. "-".$mStart . "-01");
    $dateEnd = $dateEnd->createFromFormat("Y-m-d", $yEnd. "-". $mEnd . "-01");

    if($dateStart >= $dateEnd){
        $_SESSION['error'] = "Date started cannot be before or the same as date ended!";
        header("location: ".$_SERVER['REQUEST_URI']);
        exit;
    }

    $_POST['date_started'] = $dateStart->format("Y-m-d");
    $_POST['date_ending'] = $dateEnd->format("Y-m-d");

    if($me->setEduBg($_POST) === true){
        $_SESSION['success'] = "Info Updated";
    }
    else{
        $_SESSION['error'] = "Unable to update info. Please try later";
    }
    header("location: ".$_SERVER['REQUEST_URI']);
}

if(isset($_POST['remove_edu'])){
    if($me->removeEduBg($_POST['item_id']) != true){
        $_SESSION['error'] = "Unable to complete your request. Please try later";
    }
    header("location: ".$_SERVER['REQUEST_URI']);
    exit;
}
?>
<article class="col-4">
    <?php
    if(isset($_SESSION['error'])) {
        echo "<div class='error'>{$_SESSION['error']}</div>";
        unset($_SESSION['error']);
    }

    if(isset($_SESSION['success'])) {
        echo "<div class='success'>{$_SESSION['success']}</div>";
        unset($_SESSION['success']);
    }
    ?>
    <form action="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']) ?>" method="post">
        <div class="input-container">
            <label for="institution"></label>
            <span class="fa fa-graduation-cap"></span>
            <input type="text" name="institution" id="institution" placeholder="Name of Institution">
        </div>
        <div class="row">
            <label for="award">
                <select name="award">
                    <option value="">Qualification</option>
                    <option value="MSc.">MSc</option>
                    <option value="BSc.">BSc</option>
                    <option value="">Other</option>
                </select>
            </label>
        </div>
        <div class="row">
            <label for="major">
                <select name="major">
                    <option value="">Major/Course</option>
                    <?php
                    $fp = file("../core/courseware.txt");
                    foreach($fp as $line) {
                        ?>
                        <option value="<?= $line ?>"> <?= $line ?></option>
                    <?php } ?>
                </select>
            </label>
        </div>
        <div class="col-2" style="height: 100px;">
            <p><b>Commencement</b></p>
            <label for="started"></label>
            <select id="started" name="month_started">
                <option value="">Month</option>
                <?php
                for ($i = 1; $i <= 12; $i++) {
                    echo "<option value='$i'>$i</option>";
                }
                ?>
            </select>
            <select id="started" name="year_started">
                <option value="">Year</option>
                <?php
                $max_beg_year = 2015;
                for ($i = 2000; $i <= $max_beg_year; $i++) {
                    echo "<option value='$i'>$i</option>";
                }
                ?>
            </select>
        </div>
        <div class="col-2" style="height: 100px;">
            <p><b>Completion</b></p>
            <label for="ending"></label>
            <select id="ending" name="month_ending">
                <option value="">Month</option>
                <?php
                for ($i = 1; $i <= 12; $i++) {
                    echo "<option value='$i'>$i</option>";
                }
                ?>
            </select>
            <select id="ending" name="year_ending">
                <option value="">Year</option>
                <?php
                for ($i = 2000; $i <= 2025; $i++) {
                    echo "<option value='$i'>$i</option>";
                }
                ?>
            </select>
        </div>
        <div class="row">
            <input type="submit" name="save" value="Save"/>
        </div>
    </form>
    <?php
    }
    ?>
    <div class="row" style="min-height: 300px;">
        <h3 class="section-title">Current Education details</h3>
        <div class="col-6">
            <?php
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
                        <button type="submit" name="remove_edu" value="remove" style="float: right;">
                            <span class="fa fa-close"></span>
                        </button>
                    </p>
                        </form>
                    <?php
                }
            }
            ?>
        </div>
    </div>
</article>
