<?php
class Message
{
    private $sender = null;     # message sender id
    private $msgID = null;      # message id
    private $receiver = null;   # message receiver id
    private $attachment = "";

    public $message = "";
    public $subject = "No Subject";
    public $sentDate = "";

    public function getSender(){
        return $this->sender;
    }
    public function getReceiver(){
        return $this->receiver;
    }

    public function setReceiver($recId){
        $this->receiver = $recId;
    }
    public function setSender($senderId){
        $this->sender = $senderId;
    }

    /*
     * adds a new message to the db
     * @param String attachment file name of file to be attached, defaults to false
     * @return bool|array
     *
     */
    public function create($attachment = false){
        $conn = new PDO(DB_DSN, DB_USER, DB_PASS);
        if($attachment){
            $sql = "INSERT INTO messages(sender, receiver, attachment, date_sent)
                    VALUES(:sender, :receiver, :attachment, NOW())";
        }
        else {
            $sql = "INSERT INTO messages(sender, receiver, message, date_sent)
               VALUES(:sender, :receiver, :msg, NOW())";
        }
        $st = $conn->prepare($sql);
        if($attachment){
            $st->bindParam(":attachment", $attachment);
        }
        $st->bindParam(":sender", $this->sender);
        $st->bindParam(":receiver", $this->receiver);
        $st->bindParam(":msg", $this->message);
        if($st->execute()){
                return true;
            }
            else{
                return $st->errorInfo();
            }
    }

    public function parse($info=array()){
        if(empty($info)){
            return;
        }
        $this->msgID = isset($info['msg_id']) ? $info['msg_id'] : "";
        $this->sender = isset($info['sender']) ? $info['sender'] : null;
        $this->receiver = isset($info['receiver']) ? $info['receiver'] : null;
        $this->subject = isset($info['subject']) ? $info['subject'] : "No Subject";
        $this->message = isset($info['message']) ? htmlentities($info['message']) : "";
        $this->sentDate = isset($info['date_sent']) ? $info['date_sent'] : "";
    }

    /**just basic file uploading and giving back the file name
     * @param $file file
     * @param $path string
     * @return string
     */
    public function addAttachment($file, $path){
        $allowed = array("image/jpeg", "image/jpg", "image/png", "image/gif",
            "application/pdf", "application/x-pdf", "text/pdf", "application/acrobat",
            "application/vnd.pdf", "application/msword",
            "application/vnd.openxmlformats-officedocument.wordprocessingml.document",);
        $pad = uniqid('msg_file_', true);
        $attempt = upload($path, $file, $pad, $allowed);
        if(!is_array($attempt)){
            return $attempt;
        }

        if((!array_key_exists("main_name", $attempt)) || !array_key_exists("new_name", $attempt)){
            return $attempt;
        }
    }


    /**
     * get the chats between a two parties
     * @param int $sender sender's id
     * @param $rec
     * @param int $limit
     * @param int $pageNum
     * @return array|string
     */
    public static function getConvo($sender, $rec, $limit = 10,$pageNum=1)
    {
        $conn = new PDO(DB_DSN, DB_USER, DB_PASS);
        $sql = "SELECT m.*, s.userID, s.fname, s.lname, s.compName, r.userID, r.fname, r.lname, r.compName
                FROM messages m, userlist s, userlist r
                WHERE (r.userID = m.receiver) AND (s.userID = m.sender) AND
                ((r.userID = :rec AND s.userID = :send) OR (r.userID = :send AND s.userID = :rec)) ORDER BY msg_id DESC";

        $st = $conn->prepare($sql);
        $pp = new OKPager($sql, $limit);
        $bounded = array(":send" => $sender, ":rec" => $rec);
        try {
            $pp->conn = $conn;
            $msgs = array();
            $count = $pp->countTotalRows($bounded);
            $msgs[] = $count; //First array element is the total
            $msg = $pp->fetchData($pageNum, $bounded);
            foreach ($msg as $ms) {
                $msgs[] = $ms;
            }
            return $msgs;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    /**
     * Returns an array of all conversations involving the user with $ID
     * Using the receiver index returned, the corresponding user info should
     * be obtained from the users table.
     * @param $id int
     * @param $page int
     * @return array|string
     */
    public static function getChatHeads($id, $page = 1){
        $conn = new PDO(DB_DSN, DB_USER, DB_PASS);
        //this query gotta be bad ass!!!
        $sql = "SELECT messages.sender, messages.receiver, messages.message FROM
                (SELECT MAX(msg_id) AS msg_id
                FROM messages
                WHERE :id IN (sender, receiver)
                GROUP BY IF(:id = sender, receiver,sender)) AS latest
                LEFT JOIN messages USING (msg_id) ORDER BY msg_id DESC ";
        try{
            /*$st = $conn->prepare($sql);
            $st->bindParam(":id", $id);
            if(!$st->execute()){
                //log and return false
                return $st->errorInfo();
                //return false;
            }
            else {
                $res = array();
                while ($rows = $st->fetch(PDO::FETCH_ASSOC)) {
                    $res[] = $rows;
                }
                return $res;
            }*/
            $pp = new OKPager($sql, $limit = 15);
            $pp->conn = $conn;
            $params = array(":id"=>$id);
            $msg = array();
            $msg['num_rows'] = $pp->countTotalRows($params);
            foreach($pp->fetchData($page, $params) as $packet){
                $msg['result'][] = $packet;
            }
            return $msg;
        }
        catch(Exception $e){
            return $e->getMessage();
        }
    }
}