<?php
if(isset($_POST['save'])){
    $startDay = trim($_POST['start_day']);
    $startMonth = trim($_POST['start_month']);
    $startYear = trim($_POST['start_year']);

    $endDay = trim($_POST['end_day']);
    $endMonth = trim($_POST['end_month']);
    $endYear = trim($_POST['end_year']);

    if(trim($_POST['title']) == ""){
        $_SESSION['error'] = "Job title cannot be blank";
        header("location: ".$_SERVER['REQUEST_URI']);
        exit;
    }
    if(trim($_POST['employer']) == ""){
        $_SESSION['error'] = "Please include the employer";
        header("location: ".$_SERVER['REQUEST_URI']);
        exit;
    }
    if(trim($_POST['description']) == ""){
        $_SESSION['error'] = "Give insights on your accomplishments...";
        header("location: ".$_SERVER['REQUEST_URI']);
        exit;
    }

    if(($startDay == "") || ($startMonth == "") || ($startYear == ""))
    {
        $_SESSION['error'] = "Date started seems to be invalid and/or blank";
        header("location: ".$_SERVER['REQUEST_URI']);
        exit;
    }
    $startDate = $_POST['start_day']."-".$_POST['start_month']."-".$_POST['start_year'];
    $startDate = dateToYMD($startDate, 'Y-m-d');
    if($_POST['end_day'] != "Present"){
        if(($endDay == "") || ($endMonth == "") || ($endYear == "")) {
            $_SESSION['error'] = "Date ended/ending seems to be blank";
            header("location: ".$_SERVER['REQUEST_URI']);
            exit;
        }
    }
    $endDate = $_POST['end_day']."-".$_POST['end_month']."-".$_POST['end_year'];
    $endDate = dateToYMD($endDate, "Y-m-d");

    if($endDate < $startDate){
        $_SESSION['error'] = "Date started cannot be before end date";
        header("location".$_SERVER['REQUEST_URI']);
        exit;
    }

    $_POST['started_date'] = $startDate;
    $_POST['end_date'] = $endDate;

    if($me->createPortfolio($_POST) !== true){
        $_SESSION['error'] = "Unable to complete request. Please try later";
    }
    header("location: ".$_SERVER['REQUEST_URI']);
    exit;
}

if(isset($_POST['remove'])){
    $item = $_POST['item_id'];
    if(preg_match('/[0-9]+/', $item)){
        $rem = $me->removePortfolio($item);
        if($rem !== true){
            $_SESSION['error'] = "Unable to complete request";
        }
        header("location: ".$_SERVER['REQUEST_URI']);
        exit;
    }
    $_SESSION['error'] = "Could not complete request";
    header("location: ".$_SERVER['REQUEST_URI']);
    exit;
}
?>
<article class="col-4">
    <?php
    if(isset($_SESSION['error'])){
        echo "<div class='error'>{$_SESSION['error']}</div>";
        unset($_SESSION['error']);
    }
    ?>
    <form action="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']); ?>" method="post" accept-charset="utf-8">
        <label for="title">
            <input type="text" name="title" placeholder="Job Title"/>
        </label>
        <label for="employer">
            <input type="text" name="employer" placeholder="Company/Organization"/>
        </label>
        <label for="desc">
            <textarea name="description" class="input-container" style="height: 120px;" placeholder="Job Accomplishments"></textarea>
        </label>
        <p><b>Dates:</b></p>
        <div class="row">
            <div class="col-3">
                <div class="row">
                    <p>Started</p>
                    <label for="start_day">
                        <select name="start_day" class="mini">
                            <option value="">Day</option>
                            <?php
                            for($i=1;$i<=31;$i++){
                                echo "<option value='$i'>$i</option>";
                            }
                            ?>
                        </select>
                    </label><label for="start_day">
                        <select name="start_month" class="mini">
                            <option value="">Month</option>
                            <?php
                            for($i=1;$i<=12;$i++){
                                echo "<option value='$i'>$i</option>";
                            }
                            ?>
                        </select>
                    </label><label for="start_year">
                        <select name="start_year" class="mini">
                            <option value="">Year</option>
                            <?php
                            for($i=2005;$i<=date('Y');$i++){
                                echo "<option value='$i'>$i</option>";
                            }
                            ?>
                        </select>
                    </label>
                </div>
                <div class="row" style="margin-top: 20px;">
                    <p>Ended/Ending</p>
                    <label for="end_day">
                        <select name="end_day" class="mini">
                            <option value="">Day</option>
                            <?php
                            for($i=1;$i<=31;$i++){
                                echo "<option value='$i'>$i</option>";
                            }
                            ?>
                        </select>
                    </label>
                    <label for="end_month">
                        <select name="end_month" class="mini">
                            <option value="">Month</option>
                            <?php
                            for($i=1;$i<=12;$i++){
                                echo "<option value='$i'>$i</option>";
                            }
                            ?>
                        </select>
                    </label><label for="end_year">
                        <select name="end_year" class="mini">
                            <option value="">Year</option>
                            <?php
                            for($i=2005;$i<=2025;$i++){
                                echo "<option value='$i'>$i</option>";
                            }
                            ?>
                        </select>
                    </label>
                </div>
            </div>
        </div>
        <input type="submit" name="save" value="Update" style="width: 100px;">
    </form>
    <div class="row">
        <h3 class="section-title">Work History</h3>
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
                        <button type="submit" name="remove" value="remove" style="float: right;">
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
    </div>
</article>
<style type="text/css">
    form input[type="text"]{
        width: 100%;
        padding: .5em;
        margin-bottom: .3em;
    }
</style>