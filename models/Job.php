<?php
class Job extends Model
{
    public $jobId = null;
    public $title = null;
    public $postedBy = null;
    public $postedDate = null;
    public $expiryDate = null;
    public $status = null;
    public $budget = null;
    public $description = null;
    public $requirements = null;
    public $type = null;
    public $skills = array();

    public function __construct($info){
      $this->jobId = isset($info['jobID']) ?$info['jobID'] : "";
      $this->title = isset($info['title']) ? $info['title'] : "";
      $this->postedBy = isset($info['posted_by'])?$info['posted_by']: "";
      $this->postedDate = isset($info['posted_date']) ? $info['posted_date'] : "";
      $this->expiryDate = isset($info['expiry_date']) ? $info['expiry_date']: "";
      $this->budget = isset($info['budget']) ? $info['budget'] : "";
      $this->description = isset($info['description']) ? $info['description'] : "";
      $this->requirements = isset($info['requirements']) ? $info['requirements']: "";
      $this->type = isset($info['type']) ? $info['type'] : "";
      $this->status = isset($info['status']) ? $info['status'] : "";
    }

    public function create(){
      $conn =  $this->connect();
      $sql = "INSERT INTO jobs(title, description, requirements, posted_by, budget, type, posted_date, expiry_date)
                VALUES(:title, :des, :req, :posted_by, :budget, :type, NOW(), :expires)";
      $st = $conn->prepare($sql);
      $st->bindParam(":title", $this->title);
      $st->bindParam("des", $this->description);
      $st->bindParam(":req", $this->requirements);
      $st->bindParam(":posted_by", $this->postedBy);
      $st->bindParam(":budget", $this->budget);
      $st->bindParam(":type", $this->type);
      $st->bindParam(":expires", $this->expiryDate);
      
      try{
          $st->execute();
          $this->jobId = $conn->lastInsertId();
          $this->setSkillsRequired($this->skills);
          return true;
      }
      catch(PDOException $e){
          return "A".$e->getMessage();
      }
    }

    /*
     * sets the expertise for a job on creation
     */
    private function setSkillsRequired($skills=array()){
        $failed =array();
        foreach($skills as $skill){
            $skill = Skill::getById($skill);
            if($skill == null){
                return false;
            }
            $add = $skill->addSkillForJob($this->jobId);
            if(!$add){$failed[] = $skill->skillId;}
        }
        if(!empty($failed)){
            //log stuffs about error...
        }
        return true;
    }

    public function updateField($colName, $newValue){
        $conn = new PDO(DB_DSN, DB_USER, DB_PASS);
        $sql = "UPDATE jobs SET $colName = :new WHERE jobID = :job";
        $st = $conn->prepare($sql);
        $st->bindParam(":new", $newValue);
        $st->bindParam(":job", $this->jobId);

        try{
            //Check for equivalence here...
            if($st->execute()){
                return true;
            }
            return $st->errorInfo();
        }
        catch(PDOException $e){
            return $e->getMessage();
        }
    }

    public function getBids($page, $limit){
        return Application::getAppFor($this->jobId, $page, $limit);
    }

    public function getEmployer(){
        $conn = $this->connect();
        $sql = "SELECT posted_by FROM jobs WHERE jobID = :id";
        $st = $conn->prepare($sql);
        $st->bindParam(":id", $this->jobId);
        if($st->execute()){
            $row = $st->fetch(PDO::FETCH_ASSOC);
            if(empty($row))
                return null;
            $employer = Employer::getUser($row['posted_by']);
            return $employer;
        }
        return null;
    }

    public static function searchByQuery($query, $page, $limit){
        $conn = parent::connect();
        $sql = "SELECT jobID FROM jobs WHERE MATCH(title, description, requirements) AGAINST(:query) ORDER BY posted_date";
        $param = array(':query'=>$query);

        $pp = new OKPager($sql, $limit);
        $pp->conn = $conn;
        $totalRows = $pp->countTotalRows();
        $matches = array();

        $matches['num_rows'] = $totalRows;
        foreach($pp->fetchData($page) as $res){
            $matches['results'][] = new Job($res);
        }
        return $matches;
    }
 
    public function getSkillsRequired(){
        $conn = $this->connect();
        $query = "SELECT GROUP_CONCAT(skills.skill) AS skills FROM skills LEFT JOIN
            job_skills ON job_skills.skill = skills.skill_id
            WHERE job_skills.job = :id";
        $st = $conn->prepare($query);
        $st->bindParam(":id", $this->jobId);
        $skills = array();
        if($st->execute()) {
            while ($rows = $st->fetch(PDO::FETCH_ASSOC)) {
                $skills[] = $rows;
            }
            return $skills;
        }
        return null;
   }

    /*public static function fetchMatchedJobs($query, $page=1,$limit){
        $conn = $this->connect();
        $skillRes = Job::searchBySkill($query);
        $queryRes = Job::searchByQuery($query);
        $unique = array_unique(array_merge($skillRes, $queryRes));
        $unique = implode(", ", $unique);
        $sql = "SELECT * FROM jobs WHERE jobID IN ($unique) ORDER BY jobId DESC";
        try{
            $pp = new OKPager($sql, 15);
            $pp->conn = $conn;
            $totalRows = $pp->countTotalRows();
            $matches = array();
            $matches['num_rows'] = $totalRows;
            foreach($pp->fetchData($page) as $res){
                $matches['result'][] = new Job($res);
            }
            return $matches;
        }
        catch(Exception $e){
            return $e->getMessage();
        }
    }*/

    public static function getById($id){
        $conn = parent::connect();
        $sql = "SELECT * FROM jobs WHERE jobID = :id";
        $st = $conn->prepare($sql);
        $st->bindParam(":id", $id);
        if($st->execute()){
            $rows = $st->fetch(PDO::FETCH_ASSOC);
            if(empty($rows)){
                return null;
            }
            if($rows['emp_deleted'] == true){
                return null;
            }
            return new Job($rows);
        }
        return null;
    }

    public static function findJobWithSkills($page, $skills = array()){
        $skill_list = implode(", ",$skills);
        //trying to figure out how on earth this can't be on searchBySkills()
        //it is actually supposed to pick all jobs matching a given skill array
        $sql = "SELECT DISTINCT jobs.jobID, jobs.title, jobs.posted_by, jobs.description, jobs.posted_date, jobs.status
              FROM jobs LEFT JOIN job_skills ON job_skills.job = jobs.jobID
              WHERE job_skills.skill IN($skill_list) ORDER BY posted_date DESC";
        $conn = parent::connect();
        $pp = new OKPager($sql);
        $pp->conn = $conn;
        $totalRows = $pp->countTotalRows();
        $listings = array();
        $listings['num_rows'] = $totalRows;
        foreach($pp->fetchData($page) as $result){
            $listings['result'][] = new Job($result);
        }
        return $listings;
    }

    public static function archives($page=1, $limit=15){
        $conn = new PDO(DB_DSN, DB_USER, DB_PASS);
        $sql = "SELECT * FROM jobs WHERE emp_deleted = '0' AND status = '1' ORDER BY jobID DESC";
        try{
            $pager = new OKPager($sql);
            $pager->conn = $conn;
            $totalRows = $pager->countTotalRows();
            $resultSet = $pager->fetchData($page);
            $rs = array();
            $rs['num_rows'] = $totalRows;
            foreach($resultSet as $result){
                $rs['result'][] = new Job($result);
            }
            return $rs;
        }
        catch(PDOException $e){
            return $e->getMessage();
        }
        catch(Exception $E){
            return $E->getMessage();
        }
    }
}
