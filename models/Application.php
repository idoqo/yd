<?php
class Application extends Model
{
    private $id;
    private $jobId;
    private $userId;
    private $attachment;
    private $status;

    private $deleted = false;
    private $seenByEmp = false;

    public function create(){
        $conn = $this->connect();
        $sql = "INSERT INTO applications(jobID, userID,app_date) VALUES (:job, :user, NOW())";
        $st = $conn->prepare($sql);
        $params = array(':job'=>$this->jobId, ":user"=>$this->userId);
        if($st->execute()){
            return true;
        }
        return false;
    }

    public function removeApp(){
        $conn = $this->connect();
        $sql = "DELETE FROM applications WHERE id = :id";
        $sst = $conn->prepare($sql);
        $params = array("id"=>$this->id);
        if($sst->execute($params)){
            return true;
        }
        return false;
    }

    public function verifyOwner($controlId){
        return $this->userId == $controlId;
    }

    public static function userJobPairExists($jobId, $userId){
        $conn = parent::connect();
        $sql = "SELECT jobID, userID FROM applications WHERE userID = :user AND jobID = :job";
        $st = $conn->prepare($sql);
        $params = array(":user"=>$userId, ":job"=>$jobId);
        $st->execute($params);

        $result = $st->fetch(PDO::FETCH_ASSOC);
        if(!empty($rs)){
            return true;
        }
        return false;
    }

    public static function getById($id){
        $sql = "SELECT * FROM applications WHERE id = :id";
        $conn = parent::connect();
        $params = array(":id"=>$id);
        $st = $conn->prepare($sql);
        if($st->execute($params)){
            $rows = $st->fetch(PDO::FETCH_ASSOC);
            if(!empty($rows)){
                return new Application();
            }
            return null;
        }
        return null;
    }

    public static function getAppsFrom($userId, $page, $limit){
        $conn = parent::connect();
        $sql = "SELECT * FROM applications WHERE userID = :id AND status <> 2 ORDER BY id DESC";

        $pp = new OKPager($sql, $limit);
        $pp->conn = $conn;

        $params = array(":id"=>$userId);

        $retval = array();
        $retval['num_rows'] = $pp->countTotalRows($params);

        $result = $pp->fetchData($page, $params);
        foreach($result as $ret){
            $retval['result'][] = $ret;
        }
        return $retval;
    }

    public static function getAppFor($jobId, $page, $limit){
        $conn = parent::connect();
        $sql = "SELECT * FROM applications WHERE jobID = :id ORDER BY id DESC";
        $pager = new OKPager($sql, $limit);
        $pager->conn = $conn;
        $params = array(':id'=> $jobId);
        $totalRows = $pager->countTotalRows($params);
        $resultSet = $pager->fetchData($page, $params);
        $rs = array();
        $rs['num_rows'] = $totalRows;
        foreach($resultSet as $result){
            $rs['result'][] = $result;
        }
        return $rs;
    }
}