<?php
class Employer extends User
{
    public $compName = "";
    public function __construct($data=array()){
        parent::__construct($data);
        $this->compName = isset($data['compName']) ? $data['compName'] : "";
        $this->fullName = $this->compName;
        $this->utype = "employer";
        if($this->displayPic == "default_dp.png"){
            $this->displayPic = "briefcase.png";
        }
    }

    /**
     * add new user. Never call this before parent::checker
     * @return bool|array
     */
    public function create(){
        $conn = new PDO(DB_DSN, DB_USER, DB_PASS);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        $sql = "INSERT INTO userlist(utype, email, tel, location, password, compName, reg_date)
        VALUES(:utype, :email, :tel, :location, :password, :compName, NOW())";
        $stmt = $conn->prepare($sql);

        $stmt->bindParam(":utype", $this->utype, pdo::PARAM_STR);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":tel", $this->tel, PDO::PARAM_INT);
        $stmt->bindParam(":location", $this->location, PDO::PARAM_STR);
        $stmt->bindParam(":password", $this->hashed);
        $stmt->bindParam("compName", $this->compName);

        if($stmt->execute()){
            return true;
        }
        else{
            return $conn->errorInfo();
        }
    }

    public function getCreatedJobs(){
        $conn = new PDO(DB_DSN, DB_USER, DB_PASS);
        $sql = "SELECT jobID, title, description, requirements, posted_by, budget, type, posted_date, expiry_date,
       status FROM jobs WHERE posted_by = :id AND emp_deleted = 0 ORDER BY  jobID DESC";
        $st = $conn->prepare($sql);
        $st->bindParam(":id", $this->userID);
        try{
            $st->execute();
            $listings = array();
            while($rs = $st->fetch(PDO::FETCH_ASSOC)){
                $listings[] = new Job($rs);
            }
            return $listings;
        }
        catch(PDOException $e){
            //return $e->getMessage();
            return "Error while fetching listings";
        }
    }

    /**
     * Almost the same as retractApp() in Student
     * responds an application based on ID
     * $newStatus determines the response...3 is for rejected
     * @param $id int
     * @param int
     * @return bool|array
     */
    public function respondToApp($id, $newStatus){
        if(!ctype_digit($id)){
            return false;
        }
        $conn = new PDO(DB_DSN, DB_USER, DB_PASS);
        $sst = $conn->prepare("SELECT * FROM applications WHERE id = :id");
        if($sst->execute(array(":id"=>$id))){
            if($sst->rowCount() < 1){
                return false;
            }
            $rows = $sst->fetch(PDO::FETCH_ASSOC);
            $job = Job::getById($rows['jobID']);
            if($job != false) {
                $employer = $job->getEmployer();
                if($employer == $this->userID){
                    //finally remove it
                    $sql = "UPDATE applications SET status = 3 WHERE id = :id";
                    $st = $conn->prepare($sql);
                    if($st->execute(array(":id"=>$id))){
                        return true;
                    }
                }
            }
        }
        //the bitch can't not serious...report an error and leave the rest
        return false;
    }

    /**
     * Update an employer-specific field.
     * Just like updateField() in the parent class but targets a different table
     * @param string
     * @param mixed
     * @return bool | string
     */
    public function updateEmpField($column, $newValue){
        $conn = new PDO(DB_DSN, DB_USER, DB_PASS);
        $currentInfo = $this->getInfo();
        if($currentInfo == false){
            $sql = "INSERT INTO employer(userId, $column) VALUES (:id, :val)";
            $st = $conn->prepare($sql);
            if($st->execute(array(":id"=>$this->userID, ":val" => $newValue))){
                return true;
            }
            return $st->errorInfo();
        }
        else {
            $sql = "UPDATE employer SET $column = :new WHERE userId = :id";
            $st = $conn->prepare($sql);
            if($st->execute(array(":new"=>$newValue, ":id"=>$this->userID))){
                return true;
            }
            return $st->errorInfo();
        }
    }

    public function getInfo(){
        $conn = new PDO(DB_DSN, DB_USER, DB_PASS);
        $st = $conn->prepare("SELECT * FROM employer WHERE userId = :id");
        if($st->execute(array(":id"=>$this->userID))){
            return $st->fetch(PDO::FETCH_ASSOC);
        }
        return $st->errorInfo(); //log!!!.
    }

    /**
     * Here is a very stupid method...view at own risk of ranting
     * Recommends profiles to an employer using the skills required for the
     * most recent project posted. This could be tweaked to recommend based
     * on and average skill requirements after determining the kinda of company
     *a certain idiot is running
     * @return array|bool
     */
    public function recommendUsers(){
        $myJobs = $this->getCreatedJobs();
        if(is_array($myJobs) && !empty($myJobs)){
            $caseStudy = array_shift($myJobs);
            $allMatchedUsers = array();
            $skills = $caseStudy->getSkillsRequired();
            if($skills != null){
                foreach($skills as $skill){
                    $skill = $skill["skills"];
                    $sk = explode(",", $skill);
                    foreach($sk as $s){
                        if($s == null)
                            continue;
                        $matched = Student::matchUsers($s);
                        if(is_array($matched)){
                            $allMatchedUsers[] = $matched;
                        }
                    }
                }
            }
            return $allMatchedUsers;
        }
        else{
            return false;
        }
    }

    public function feed(){
        $page = 1; $limit = 15;
        $jobs = $this->getCreatedJobs();
        if(is_array($jobs) && !empty($jobs)){
            $apps = array();
            $reviews = array();
            $i = 0;
            foreach($jobs as $job){
                $bids = $job->getBids($page,$limit);
                if((!is_array($bids)) || empty($bids)) {
                    continue;
                }
                if($i >= 10) {
                    break;
                }
                if($bids['num_rows'] > 0){
                    foreach($bids['result'] as $bid){
                        $apps[] = $bid;
                    }
                }
                $i++;
            }
            $feedContent = array();
            $feedContent["apps"] = $apps;
            return $feedContent;
        }
        else{
            return false; //show random bullshits
        }
    }

}