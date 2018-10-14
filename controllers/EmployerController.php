<?php
class EmployerController extends UserController
{
    public $user_type = "employer";
    protected $views_dir = "employer/";

    public function __construct(){
        parent::__construct();
    }

    public function actionSignup(){
        if(isset($_POST['register'])){
            if(trim($_POST['compName']) == ""){
                $_SESSION['compName'] = $_POST['compName'];
                $_SESSION['error'] = "Please provide your company or individual name";
                header("location: {$_SERVER['HTTP_REFERER']}");
                exit();
            }
            if(trim($_POST['password']) == ""){
                $_SESSION['error'] = "Password field cannot be blank!";
                header("location: {$_SERVER['HTTP_REFERER']}");
                exit();
            }
            if($_POST['location'] == ""){
                $_SESSION['error'] = "Specify your location";
                header("location: {$_SERVER['HTTP_REFERER']}");
                exit();
            }

            if(trim($_POST['email']) == "" || (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) == false)){
                $_SESSION['email'] = $_POST['email'];
                $_SESSION['error'] = "The email you provided was invalid";
                header("location: {$_SERVER['HTTP_REFERER']}");
                exit();
            }

            if(!ctype_alnum($_POST['location'])){
                $_SESSION['error'] = "Location is NOT sensible!";
                header("location: {$_SERVER['HTTP_REFERER']}");
                exit();
            }

            if(User::checker($_POST['email']) != 0){
                $_SESSION['error'] = "Sorry, a user already exists with the email you provided. Forgot your password? <a href='#'>Get a new one</a>";
                header("location: {$_SERVER['HTTP_REFERER']}");
                exit();
            }
            if(trim($_POST['tel']) != "") {
                if(!isPhoneNumber($_POST['tel'])){
                    $_SESSION['tel'] = $_POST['tel'];
                    $_SESSION['error'] = "Invalid phone number";
                    header("location: {$_SERVER['HTTP_REFERER']}");
                    exit();
                }
            }

            $x = new Employer($_POST);
            $x->utype = $this->user_type;

            if(!$x->create()){
                //Log the next line and simply show an error message
                $_SESSION['error'] = "Oops! Something went wrong!";
            }
            else {
                UserController::redirectToLogin("Account has been created. Please login to continue");
                exit();
            }
        }
        $type = $this->user_type; //passed to the view for toggling

        include __VIEWPATH__."employer/signup.php";
    }

    public function actionIndex(){
        if ($this->me == "guest") {
            $this->actionSignin();
            return;
        }
        $feeds = $this->me->feed();
        $recommended = $this->me->recommendUsers();
        $page = isset($_GET['page']) ? $_GET['page'] : "home";
        $me = $this->me;

        include __VIEWPATH__."user/_dashboard.php";
    }

    public function actionProjects(){
        $jobs = $this->me->getCreatedJobs();

        $page = "projects";
        $me = $this->me;
        include __VIEWPATH__."user/_dashboard.php";
    }

    public function actionProfile(){
        $loggedUser = new EmployerController();
        if($loggedUser->me == "guest") {
            $this->actionSignin();
            return;
        }
        $me = $loggedUser->me;
        $page = "profile";
        $about = $me->getInfo();
        include __VIEWPATH__.$this->views_dir."profile.php";
    }
}