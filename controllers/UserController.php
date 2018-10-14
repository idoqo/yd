<?php
class UserController extends Controller
{

    protected $views_dir = "user/";

    public $me;

    public function __construct()
    {
        if ((!isset($_COOKIE['logged'])) || (!isset($_COOKIE['_intseid']))) {
            $this->me = "guest";
        }
        else {
            $emailCookie = $_COOKIE['logged'];
            $passCookie = $_COOKIE['_intseid'];

            if ((!filter_var($emailCookie, FILTER_VALIDATE_EMAIL)) || User::getUser(false, $emailCookie) == false) {
                $this->me = "guest";
            }else {
                $this->me = User::getUser(false, $emailCookie);
            }
        }
    }

    public function actionSignin()
    {
        if (isset($_POST['login']) && $_POST['login'] == "Login") {
            $em = trim($_POST['email']);
            $pass = trim($_POST['password']);
            $err = array();
            if ($em == "") {$err[] = "E-Mail field cannot be empty";}
            if ($pass == "") {$err[] = "Password Field cannot be empty";}
            if (!filter_var($em, FILTER_VALIDATE_EMAIL)) {$err[] = "The E-Mail you provided is invalid";}

            $email_exists = User::checker($em);
            if ($email_exists == 0) {
                $err[] = "The email you provided does not exist!";
            } else {
                $details = User::getUser(false, $em);
                if ($details == false) {
                    $_SESSION['error'] = "An error occurred with the email you provided. Please check and try again";
                    header("location: " . $_SERVER['REQUEST_URI']);
                }
                if (!password_verify($pass, $details->getPassword())) {
                    $err[] = "The password is incorrect. Forgot it? Request a new one";
                } else {
                    try {
                        $details->logUser();
                        $this->me = $details; //set me to this user...
                        $goto = isset($_SESSION['goto']) ? $_SESSION['goto'] : "?controller={$details->utype}";
                        header("location: $goto");
                        unset($_SESSION['goto']);
                    } catch (PDOException $e) {
                        $_SESSION['error'] = $details->logUser();
                        header("location: " . $_SERVER['REQUEST_URI']);
                        exit;
                    }
                }
            }
        }

        //hardcoded user directory since the property is overridden by children classes
        include __VIEWPATH__ . "user/login.php";
    }

    public function actionLogout(){
        setcookie('logged', '', time()-3600);
        setcookie('_intseid', '', time()-3600);
        UserController::redirectToLogin("You have been logged out");
    }

    public static function getLoggedUser(){
        //Snippet for checking if user is logged in or nay.
        $email = isset($_COOKIE['logged']) ? $_COOKIE['logged'] : "";
        $token = isset($_COOKIE['_intseid']) ? $_COOKIE['_intseid'] : "";
        //todo sanitize data
        if($email != "" && $token != ""){
            $me = User::getUser(false, $email);
            return $me;
        }
        else {
            return null;
        }
    }

    public function actionCheckEmail(){
        /*Update from ajax call...*/
        if(isset($_GET['email'])) {
            $ans = User::checker($_GET['email']);
            switch ($ans) {
                //todo return json data to avoid adding the entire page to the field
            }
            die();
        }
    }

    public static function redirectToLogin($msg = "Please login to continue"){
        $_SESSION['message'] = $msg;
        header("location: ?controller=user&action=signin");
        exit();
    }

    public function actionMessages(){
        $logged = $this->me->userID;
        $chat_head_page_num = isset($_GET['r']) ? $_GET['r'] : 1;

        $convoHeads = Message::getChatHeads($this->me->userID, $chat_head_page_num);
        if (isset($_GET['with']) && (User::getUser($_GET['with']) != false)) {
            $pageNum = isset($_GET['aftercursor']) ? $_GET['aftercursor'] : 1; //page number
            $limit = 8;
            $myId = $this->me->userID;
            $partner = preg_replace('/[^0-9]+/', '', $_GET['with']);
            $partnerDetails = User::getUser($partner);

            $convos = Message::getConvo($myId, $partner, $limit, $pageNum);
        } else{
            $partnerDetails = null;
        }
        $me = $this->me;
        $page = "messages";
        include __VIEWPATH__."user/_dashboard.php";
    }

    public function actionSendMessage(){
        if(isset($_POST['send'])){
            if($this->me == "guest"){
                header("location: signin");
                exit;
            }
            if(!isset($_POST['to']) || $_POST['to'] == ""){
                $_SESSION['error'] = "No recipient selected";
                header("location: ".$_SERVER['HTTP_REFERER']);
                exit;
            }
           $message = new Message();
            $message->parse($_POST);
            $message->setReceiver($_POST['to']);
            $message->setSender($this->me->userID);

            if(trim($_POST['message']) == ""){
                $_SESSION['error'] = "Cannot send blank message";
                header("location: ".$_SERVER['HTTP_REFERER']);
                exit;
            }

            if($message->create() !== true){
                $_SESSION['error'] = "Your message could not be sent. Please try later";
            }
            header("location: ".$_SERVER['HTTP_REFERER']);
            exit;
        }
    }
}