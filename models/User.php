<?php
class User extends Model
{
    public $userID;
    public $email;
    public $location;
    public $tel;
    public $overview;
    public $utype;
    public $displayPic;
    public $fullName;
    public $website;
    protected $password;
    protected $hashed;

    public function __construct($data=array()){
        $this->userID = isset($data['userID']) ? $data['userID'] : null;
        $this->email = isset($data['email']) ? $data['email'] : "";
        $this->location = isset($data['location']) ? $data['location'] : "";
        $this->tel = isset($data['tel']) ? $data['tel'] : "";
        $this->overview = isset($data['overview']) ? $data['overview'] : "";
        $this->utype = isset($data['utype']) ? $data['utype'] : "";
        $this->website = isset($data['website']) ? $data['website'] : "";
        $this->displayPic = isset($data['displayPic']) ? $data['displayPic'] : "";
        $this->password = isset($data['password']) ? $data['password'] : "";
        $this->hashed = password_hash($this->password, PASSWORD_DEFAULT);
    }

    public function logUser(){
        try{
            $conn = new PDO(DB_DSN, DB_USER, DB_PASS);
            $st = $conn->prepare("UPDATE userlist SET last_logged = NOW() WHERE userId = :id");
            $st->bindParam(":id", $this->userID);
            $st->execute();

            $hashed = password_hash($this->password, PASSWORD_DEFAULT);
            setcookie("logged", $this->email, time() + 12000, "/");
            setcookie("_intseid", $hashed, time() + 12000, "/");
            return true;
        }
        catch(PDOException $x){
            return $x->getMessage();
        }
        catch(Exception $e){
            //return false and show guide to set cookies
            return $e->getMessage();
        }
    }

    public function getPassword(){
        return $this->password;
    }

    /**
     * Gets details of this User from the DB
     * return value is an Object of type employer or student depending on $this->utype
     * parameter id is alternative to email if not for the currently logged user and should be an integer
     * parameter email should only be derived from a cookie/session value
     * @param mixed
     * @param mixed
     * @return Object
     */
    public static function getUser($id=false, $em=false){
        $conn = new PDO(DB_DSN, DB_USER, DB_PASS);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        if(!$id && !$em){
            return false;
        }
        if($id){
            #THIS IS FLAGGED. SHOULD BE CTYPE_ALNUM OR CTYPE_ALPHA UPON REDIRECTION
            if(ctype_digit($id) == false){
                return false;
            }
            $sql = "SELECT * FROM userlist WHERE userID = :id";
        }
        elseif($em) {
            if (filter_var($em, FILTER_VALIDATE_EMAIL) == false) {
                return false;
            }
            $sql = "SELECT * FROM userlist WHERE email = :email";
        }
        $st = $conn->prepare($sql);
        if($id)$st->bindParam(":id", $id);
        if($em)$st->bindParam(":email", $em);
        try {
            $st->execute();
            $rs = $st->fetch(PDO::FETCH_ASSOC);
            if(empty($rs)) {
                return false;
            }
            if ($rs['utype'] == "student") {
                return new Student($rs);
            } else {
                return new Employer($rs);
            }
        }
        catch(PDOException $e){
            /*log this error and return false*/
            return $e->getMessage();
        }
    }

    /**
     * Checks if a use with same email already exists
     * returns 0 if none exists thus permitting the new user
     * @param string $str E-mail to check
     * @return int 0 if email is not taken yet
     */
    public static function checker($str){
        if(filter_var($str, FILTER_VALIDATE_EMAIL) == false){
            return 2;
        }
        $conn = new PDO(DB_DSN, DB_USER, DB_PASS);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        if($fsql = $conn->query("SELECT email FROM userlist WHERE email LIKE '%$str%'")){
            $rows = $fsql->fetch(PDO::FETCH_ASSOC);
            if(empty($rows)){
                return 0;
            }
            else{
                return 1;
            }
        }
        return $fsql->errorInfo();
    }

    public function getRegDate(){
        $conn = new PDO(DB_DSN, DB_USER, DB_PASS);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql= "SELECT reg_date FROM userlist WHERE userID = :id";
        $st = $conn->prepare($sql);
        $st->bindParam(":id", $this->userID);
        try{
            $st->execute();
            $rs = $st->fetch(PDO::FETCH_ASSOC);
            $regDate = new DateTime($rs['reg_date']);
            $now = new DateTime(date('Y-m-d'));
            $space = $regDate->diff($now);
            $sinceReg = $space->format('%a');
            return $sinceReg;
        }
        catch(PDOException $e){
            return $e->getMessage();
        }
    }

    public function changeDP($img, $mainPath){
        if(!isset($_POST)){
            return "Upload attempt Failed";
        }
        $image_temp = $img['tmp_name'];
        $pad = str_replace(" ", "_", $this->fullName);

        $types = array("image/jpeg", "image/jpg", "image/png", "image/gif");
        $attempt = upload($mainPath, $img, $pad, $types);
        if(!is_array($attempt)){
            return $attempt;
        }
        if((!array_key_exists("main_name", $attempt)) || !array_key_exists("new_name", $attempt)){
            return $attempt;
        }
        else{
            $newName = $attempt["new_name"];
            $conn = new PDO(DB_DSN, DB_USER, DB_PASS);
            $sql = "UPDATE userlist SET displayPic = :str WHERE userID = :id";
            $st = $conn->prepare($sql);
            $st->bindParam(":str", $newName);
            $st->bindParam(":id", $this->userID);
            try{
                if($st->execute()){
                    //check for equivalence when comparing not just equality
                    return "ok";
                }
                else {
                    return $st->errorInfo();
                }
            }
            catch(PDOException $e){
                //return "An error prevented your image from been uploaded.";
                return $e->getMessage();
            }
        }
    }

    public function updateField($colName, $newValue){
        $conn = new PDO(DB_DSN, DB_USER, DB_PASS);
        $sql = "UPDATE userlist SET $colName = :new WHERE userID = :userId";
        $st = $conn->prepare($sql);
        $st->bindParam(":new", $newValue);
        $st->bindParam(":userId", $this->userID);

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

}

class Academia extends User
{

}