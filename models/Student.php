<?php
class Student extends User {
    public $fname = "";
    public $lname = "";
    public $title = "";

    public function __construct($data=array()){
        parent::__construct($data);
        $this->utype = "student";
        $this->fname = isset($data['fname']) ? trim($data['fname']) : "";
        $this->lname = isset($data['lname']) ? trim($data['lname']) : "";
        $this->fullName = $this->fname." ".$this->lname;
        $this->title = isset($data['title']) ? $data['title'] :"";
    }

    public function create(){
        try{
            $conn = new PDO(DB_DSN, DB_USER, DB_PASS);
        }
        catch(PDOException $e){
            return false;
        }
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        $sql = "INSERT INTO userlist(utype, fname, lname, email, tel, location, password, reg_date)
        VALUES(:utype, :fname, :lname, :email, :tel, :location, :password, NOW())";
        $stmt = $conn->prepare($sql);

        $stmt->bindParam(":utype", $this->utype, PDO::PARAM_STR);
        $stmt->bindParam(":fname", $this->fname, PDO::PARAM_STR);
        $stmt->bindParam(":lname", $this->lname, PDO::PARAM_STR);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":tel", $this->tel, PDO::PARAM_INT);
        $stmt->bindParam(":location", $this->location, PDO::PARAM_STR);
        $stmt->bindParam(":password", $this->hashed);

        if($stmt->execute()){
            return true;
        }
        else{
            return false;
        }
    }

    public function createPortfolio($data = array()){
        $pf = new Portfolio($data);
        return $pf->create();
    }

    public function getPortfolio(){
        return Portfolio::getPfFor($this->userID);
    }

    public function removePortfolio($id){
        $pf = Portfolio::getPfById($id);
        if($pf && $pf->verifyOwner($this->userID)){
            return $pf->removePf();
        }
        return false;
    }

    public function uploadResume($file, $pdfPath, $thumbPath){
        $types = array("application/pdf", "application/x-pdf", "text/pdf", "application/acrobat", "application/vnd.pdf",
            "application/msword", "application/vnd.openxmlformats-officedocument.wordprocessingml.document");
        $pad = str_replace(" ", "_", $this->fullName);

        $attempt = upload($pdfPath, $file, $pad, $types);
        if(!is_array($attempt)){
            return $attempt;
        }

        if((!array_key_exists("main_name", $attempt)) || !array_key_exists("new_name", $attempt)){
            return $attempt;
        }

        $newName = $attempt['new_name'];
        $conn = new PDO(DB_DSN, DB_USER, DB_PASS);
        $sql = "INSERT INTO seekers(userID, cv_file) VALUES(:id, :file)";
        if($this->getResumeFile()){
            $sql = "UPDATE seekers SET cv_file = :file WHERE userID = :id";
        }
        $st = $conn->prepare($sql);
        $st->bindParam(":id", $this->userID);
        $st->bindParam(":file", $newName);
        try{
            if(!$st->execute()) {
                unlink($pdfPath.$newName);
                return $st->errorInfo();
            }
            else {
                $mainFile = $pdfPath . $newName;
                $thumb = $newName . ".jpg";
                //execute ImageMagick's convert command
                //exec("covert \"{$mainFile[0]}\" -colorspace RGB -geometry 400 $thumbPath$thumb");
                return true;
            }
        }
        catch(PDOException $e){
            return $e->getMessage();
        }
    }

    public function getResumeFile(){
        $conn = new PDO(DB_DSN, DB_USER, DB_PASS);
        $sql = "SELECT cv_file FROM seekers WHERE userID = :id";
        $st = $conn->prepare($sql);
        $st->bindParam(":id", $this->userID);
        if($st->execute()){
            $rows = $st->fetch(PDO::FETCH_ASSOC);
            if(count($rows) < 1){
                return false;
            }
            else{
                return $rows['cv_file'];
            }
        }
        else{
            return false;
        }
    }

    /**
     * Parameters are preferably passed by $_POST with the fields named accordingly.
     * @set the educational background of a user.
     * @param array $data
     * @return bool|string
     */
    public function setEduBg($data = array()){
        $conn =new PDO(DB_DSN, DB_USER, DB_PASS);
        $sql = "INSERT INTO seeker_edu(userID, institution, major, date_started, date_ending, award, description)
                VALUES(:id, :inst, :major, :started, :ending, :award, :desc)";

        $params = array(
            ":id" => $this->userID,
            ":inst" => isset($data['institution']) ? $data['institution']: "",
            ":major" => isset($data['major']) ? $data['major'] : "",
            ":started" =>  isset($data['date_started']) ? $data['date_started'] : "",
            ":ending" => isset($data['date_ending']) ? $data['date_ending'] : "",
            ":award" => isset($data['award']) ? $data['award'] : "",
            ":desc" => isset($data['description']) ? $data['description'] : ""
        );

        $st = $conn->prepare($sql);
        try{
            $st->execute($params);
            return true;
        }
        catch(PDOException $e){
            return $e->getMessage();
        }
    }

    public function getEduBg(){
        $conn =new PDO(DB_DSN, DB_USER, DB_PASS);
        $st = $conn->prepare("SELECT * FROM seeker_edu WHERE userID = :ID");
        if($st->execute(array(":ID"=>$this->userID))){
            $edu = array();
            while($rows = $st->fetch(PDO::FETCH_ASSOC)){
                $edu[] = $rows;
            }
            return $edu;
        }
        return $st->errorInfo();
    }

    public function removeEduBg($itemId){
        $conn = new PDO(DB_DSN, DB_USER, DB_PASS);
        $sst = $conn->prepare("SELECT * FROM seeker_edu WHERE id = :id");
        if($sst->execute(array(":id"=>$itemId))){
            $rows = $sst->fetch(PDO::FETCH_ASSOC);
            if(($rows['userID']) != $this->userID){
                return false;
            }
        }
        $st = $conn->prepare("DELETE FROM seeker_edu WHERE id = :id");
        if($st->execute(array(":id"=>$itemId))){
            if($st->rowCount() < 1){
                return false;
            }
            return true;
        }
        //return false;
        return $st->errorInfo();
    }

    public function watch(Employer $emp){
        $conn =new PDO(DB_DSN, DB_USER, DB_PASS);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        if($this->utype == "emp"){
            return "failed";
        }
        $sql = "INSERT INTO watchlist(watcher, watchee) VALUES(:me, :emp)";
        $st = $conn->prepare($sql);
        $st->bindParam(":id", $this->userID);
        $st->bindParam(":emp", $emp->userID);
        try{
            $st->execute();
            return 0;
        }
        catch(PDOException $e){
            return $e->getMessage();
        }
    }

    public function apply($jobId){
        if(Application::userJobPairExists($jobId, $this->userID)){
            return false;
        }
        $app = new Application();
    }

    public function retractApp($id){
        $app = Application::getById($id);
        if($app == null){
            return false;
        }
        if($app->verifyOwner($this->userID)){
            $app->removeApp();
            return true;
        }
        return false;
    }

    public function getApplications($page = 1, $limit = 15){
        return Application::getAppsFrom($this->userID, $page, $limit);
    }

    public static function searchByQuery($query = false, $page, $limit){
        $conn = parent::connect();
        if($query == ""){
            return Student::archives($page, $limit);
        }
        $matchedUsers = Skill::getUserIdByQuery($query);
        if(empty($matchedUsers)){
            return null;
        }
        //concatenate matchedUsers with a comma so it can be used with mysql 'IN'
        $userlist = implode(", ",$matchedUsers);
        $sql = "SELECT * FROM userlist WHERE userID IN ($userlist);";

        $pp = new OKPager($sql, $limit);
        $pp->conn = $conn;
        $totalRows = $pp->countTotalRows();
        $matches['num_rows'] = $totalRows;

        foreach ($pp->fetchData($page) as $res) {
            $matches['result'][] = new Student($res);
        }
        return $matches;
    }

    public function setSkill($skillId){
        $skill = Skill::getById($skillId);
        if($skill != null){
            return $skill->addSkillForUser($this->userID);
        }
        return false;
    }

    public function removeSkill($skId){
        $skill = Skill::getById($skId);
        if($skill == null) {
            return false;
        }

    }

    public function getSkills(){
        return Skill::getSkillsFor($this->userID);
    }

    private function getSkillsId(){
        $skills = Skill::getSkillsFor($this->userID);
        if($skills == null){
            return null;
        }
        $sk_ids = array();
        foreach($skills as $sk){
            $sk_ids[] = $sk['skill_id'];
        }
        return $sk_ids;
    }

    public function newListings($page, $limit){
        $skillIds = $this->getSkillsId();
        if($skillIds == null){
            return null;
        }
        return Job::findJobWithSkills($page, $skillIds);
    }

    public static function archives($page = 1, $limit = 10){
        $conn = new PDO(DB_DSN, DB_USER, DB_PASS);
        $sql  = "SELECT * FROM userlist WHERE utype = 'student' ORDER BY userID DESC";
        try{
            $pp = new OKPager($sql, $limit);
            $pp->conn = $conn;
            $totalRows = $pp->countTotalRows();
            $matches = array();
            $matches['num_rows'] = $totalRows;
            foreach($pp->fetchData($page) as $res){
                $matches['result'][] = new Student($res);
            }
            return $matches;
        }
        catch(PDOException $e){
            //Log this Bit...CH
            return "Error while Searching Users: ".$e->getMessage();
        }
    }
}