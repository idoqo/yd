<?php
//edit and save the skill set for an intern
if($me == "guest"){
    header("location: signin");
    exit();
}

if((isset($_POST['set_skills'])) && ($_POST['set_skills'] == "Save")){
    $skillArray = $_POST['skill'];
    foreach($skillArray as $r){
        if($me->setSkill($r) != true){
            echo "Sorry, your skills could not be updated. Please try later";
            break;
        }
    }
}

if(isset($_POST['remove_sk'])){
    //remove a skill from the set
    $skill = $_POST['sk_item'];
    if($me->removeSkill($skill) !== true){
        $_SESSION['error'] = "Request could not be completed";
    }
    header("location: ".$_SERVER['REQUEST_URI']);
    exit;
}

$conn = new PDO(DB_DSN, DB_USER, DB_PASS);
$sql = "SELECT * FROM skills ORDER BY skill";
$st = $conn->prepare($sql);
try{
    $st->execute();
    $cats = array();
    while($rs = $st->fetch(PDO::FETCH_ASSOC)){
        $cats[] = $rs;
    }
}
catch(PDOException $e){
    echo "Unable to retrieve skills. Please try later";
}

$currentSkills = $me->getSkills();
$currentSkillIds = array();
if(!empty($currentSkills)) {
    foreach ($currentSkills as $c) {
        $currentSkillIds[] = $c['skill_id'];
    }
}
?>
<div class="col-5">
    <?php
    if(isset($_SESSION['error'])){
        echo "<div class='col-6 error'>{$_SESSION['error']}</div>";
        unset($_SESSION['error']);
    }
    ?>
    <div class="row" style="margin-bottom: 3em;">
        <p class="section-title">Current Skill sets</p>
        <div class="col-6">
            <?php
            if(!empty($currentSkills)){
                foreach($currentSkills as $cs){
                    ?>
                    <form class="removal_form" action="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']); ?>" method="post" style="display: inline;">
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
            ?>
        </div>
    </div>
    <div class="row">
        <p class="section-title">Choose your expertise</p>
        <form accept-charset="utf-8" method="post" action="<?php echo $_SERVER['REQUEST_URI'] ?>">
            <label for="skill">
                <select name="skill[]" id="skill" multiple>
                    <?php
                    $i = 1;
                    foreach($cats as $cat){
                        echo "<option value='{$cat['skill_id']}'>{$cat['skill']}</option>";
                        $i++;
                    }
                ?>
                </select>
            </label>
            <input type="submit" name="set_skills" value="Save">
        </form>
    </div>
</div>