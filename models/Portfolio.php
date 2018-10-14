<?php
class Portfolio extends Model
{
    private $id;
    private $employer;
    private $ownerId;
    private $endDate;
    private $startDate;

    public $title;
    public $description;
    public $employerReview;

    function __construct($data){

        $this->id = isset($data['id']) ? $data['id'] : null;
        $this->employer = isset($data['employer']) ? $data['employer'] : "";
        $this->owner = isset($data['userID']) ? $data['userID'] : null;
        $this->startDate = isset($data['started_date']) ? $data['started_date'] : "";
        $this->endDate = isset($data['end_date']) ? $data['end_date'] : "";
        $this->description = isset($data['description']) ? $data['description'] : "";
        $this->employerReview = isset($data['emp_review']) ? $data['emp_review'] : "";
        $this->title = isset($data['title']) ? $data['title']: "";
    }

    public function create(){
        $conn = $this->connect();
        $sql = "INSERT INTO portfolios(title, employer, end_date, started_date, userID, description)
                VALUES(:title, :emp, :end, :start, :id, :desc)";

        $params = array(
            ':title'=>$this->title,
            ':emp'=>$this->employer,
            ':end'=>$this->endDate,
            ':start'=>$this->startDate,
            ':id'=>$this->ownerId,
            ':desc'=>$this->description
            );

        $st = $conn->prepare($sql);
        if($st->execute($params)){
            return true;
        }
        return false;
    }

    public static function getPfFor($id){
        $conn = parent::connect();

        $sql = "SELECT * FROM portfolios WHERE userID = :id ORDER BY id DESC";
        $st = $conn->prepare($sql);
        $st->bindParam(":id", $id);
        try{
            $st->execute();
            $portfolios = array();
            while($rs = $st->fetch(PDO::FETCH_ASSOC)){
                //@todo make this an array of Portfolio objects
                $portfolios[] = $rs;
            }
            return $portfolios;
        }
        catch(PDOException $e){
            return $e->getMessage();
        }
    }

    public static function getPfById($id){
        $conn = parent::connect();
        $ssql = "SELECT * FROM portfolios WHERE id = :id";
        $sst = $conn->prepare($ssql);
        if($sst->execute(array(":id"=>$id))){
            $row = $sst->fetch(PDO::FETCH_ASSOC);
            if(!empty($row))
                return new Portfolio($row);
            //return "Failed to get result";
            return false;
        }
        return false;
    }

    public function removePf(){
        $conn = $this->connect();
        $sql = "DELETE FROM portfolios WHERE id = :id";
        $st= $conn->prepare($sql);
        if($st->execute(array(":id"=>$this->id))){
            return true;
        }
        return false;
    }

    public function verifyOwner($controlId){
        return $this->ownerId == $controlId;
    }
}