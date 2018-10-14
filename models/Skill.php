<?php
class Skill extends Model
{
    public $skill;
    public $skillId;

    public static function getUserIdByQuery($query){
        $conn = parent::connect();

        $sql = "SELECT user_skills.user_id FROM user_skills LEFT JOIN skills ON
       skills.skill_id = user_skills.skill_id WHERE skills.skill = :query";
        $params = array(":query"=>$query);

        $st = $conn->prepare($sql);
        if($st->execute()) {
            $matchedUserIds = array();
            while ($rows = $st->fetch(PDO::FETCH_ASSOC)) {
                $matchedUserIds[] = $rows['user_id'];
            }
            return $matchedUserIds;
        }
        return null;
    }

    public function addSkillForUser($userId){
        $conn = $this->connect();

        $sql = "INSERT INTO user_skills(user_id, skill_id) VALUES (:userId, :skillId)";
        $params = array(":userId"=>$userId, ":skillId"=>$this->skillId);

        $st = $conn->prepare($sql);
        if($st->execute($params)){
            return true;
        }
        return false;
    }

    public function addSkillForJob($jobId){
        $conn = $this->connect();
        $sql = "INSERT INTO job_skills(job, skill) VALUES(:job, :skill)";
        $p = array(':job'=>$jobId, ':skill'=>$this->skillId);
        $st = $conn->prepare($sql);

        if($st->execute($p)){
            return true;
        }
        return false;
    }

    public static function getById($id){
        $conn = parent::connect();
        $p = array(":id"=>$id);
        $st = $conn->prepare("SELECT * FROM skills WHERE skill_id = :id");
        if($st->execute()){
            $rows = $st->fetch(PDO::FETCH_ASSOC);
            if(!empty($rows)){
                return new Skill();
            }
            return null;
        }
        return null;
    }

    public function removeSkillForUser($userId){
        $conn = $this->connect();
        $st = $conn->prepare("DELETE FROM user_skills WHERE skill_id = :skill AND user_id = :user");
        $param = array(
            ':skill'=>$this->skillId,
            ':user'=>$userId
        );
        if($st->execute($param)){
            return true;
        }
        return false;
    }

    public static function getSkillsFor($userId){
        $conn = parent::connect();
        $sql = "SELECT skills.skill, skills.skill_id  FROM skills LEFT JOIN user_skills ON user_skills.skill_id = skills.skill_id WHERE user_skills.user_id = :id";
        $param = array(":id"=>$userId);
        $st = $conn->prepare($sql);
        if($st->execute($param)){
            $skills = array();
            while($rows = $st->fetch(PDO::FETCH_ASSOC)) {
                if (!empty($rows)) {
                    $skills[] = $rows;
                }
            }
            return $skills;
        }
        return null;
    }
}