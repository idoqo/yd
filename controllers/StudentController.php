<?php
class StudentController extends UserController
{
    protected $user_type = "student";
    protected $views_dir = "student/";

    public function __construct(){
        parent::__construct();
    }

    public function actionSignup(){
       if(isset($_POST['register'])){
            if(isValidName($_POST['fname']) != "ok"){
                $_SESSION['err_code'] = 5;
                $_SESSION['fname'] = $_POST['fname'];
                $_SESSION['error'] = isValidName($_POST['fname']);
                header("location: {$_SERVER['HTTP_REFERER']}");
                exit();
            }

            if(isValidName($_POST['lname']) != "ok"){
                $_SESSION['err_code'] = 6;
                $_SESSION['lname'] = $_POST['lname'];
                $_SESSION['error'] = isValidName($_POST['lname']);
                //header("location: {$_SERVER['HTTP_REFERER']}");
                exit();
            }
            if(trim($_POST['email']) == "" || (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) == false)){
                $_SESSION['err_code'] = 7;
                $_SESSION['email'] = $_POST['email'];
                $_SESSION['error'] = "Invalid email provided";
                header("location: {$_SERVER['HTTP_REFERER']}");
                exit();
            }

            if(User::checker($_POST['email']) != 0){
                $_SESSION['error'] = "Sorry, a user already exists with the email you provided. Forgot your password? <a href='#'>Get a new one</a>";
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

            if(isset($_POST['tel'])){
                if(trim($_POST['tel']) != "" && isPhoneNumber($_POST['tel'] != true)) {
                    $_SESSION['err_code'] = 8;
                    $_SESSION['tel'] = $_POST['tel'];
                    $_SESSION['error'] = isPhoneNumber($_POST['tel']);
                    header("location: {$_SERVER['HTTP_REFERER']}");
                    exit();
                }
            }

            $x = new Student($_POST);
            $x->utype = $this->user_type;
            if($x->create() !== true){
                $_SESSION['error'] = "Ooops! Something went wrong! Please try later";
            }
            else{
                UserController::redirectToLogin("Account has been created. Please signin to continue");
            }
            header("location: {$_SERVER['HTTP_REFERER']}");
            exit();
        }
        $type = $this->user_type; //passed to the view for toggling

        include __VIEWPATH__."student/signup.php";
    }

    public function actionIndex(){
        if($this->me == "guest"){
            $this->actionSignin();
            return;
        }
        $page_num = 1; //if page is exceeding this, take the user to the full job listings
        $jobs_max_limit = 5;
        $newListings = $this->me->newListings($page_num,$jobs_max_limit);
        $count = $newListings['num_rows'];
        $following = $this->me->getSkills();
        $page = isset($_GET['page']) ? $_GET['page'] : "home";
        $me = $this->me;
        //this file wraps up dashboard for both employer and student
        include __VIEWPATH__ ."user/_dashboard.php";
    }

    public function actionView(){
        if($this->me == "guest"){
            $this->actionSignin();
            return;
        }
        if(!(isset($_GET['user_id'])) || ($_GET['user_id']) == ""){
            return;
        }
        if(!preg_match('/[0-9]+/', $_GET['user_id'])){
            return;
        }

        $user_id = $_GET['user_id'];
        $user = User::getUser($user_id);

        if($user == false){
            return;
        }
        if($user->userID == $this->me->userID){
            $self = true;
        }

        include __VIEWPATH__.$this->views_dir."view.php";
    }

    public function actionSearch(){
        $results = Student::matchUsers($query, $page, $resPerPage);
        $numResults = $results['num_rows'];
    }

    public function actionList(){
        $page = isset($_GET['page_num']) ? $_GET['page_num'] : 1;
        $limit = isset($_GET['limit']) ? $_GET['limit'] : 15;

        $students = Student::archives($page, $limit);
        $numResults = $students['num_rows'];

        $lastPage = ceil($numResults/$limit);
        //Sanitizing...
        if($lastPage < 1){$lastPage = 1;}
        if($page < 1){$page = 1;}
        if($page > $lastPage){$page = $lastPage;}
        $pageCtrls = "";
        if($lastPage != 1){
            if($page > 1){
                $prev = $page - 1;
                for($i=$page-3;$i<$page;$i++){
                    if($i > 0){
                        $pageCtrls .= "<a href=''></a>";
                    }
                }
            }
            $pageCtrls .= "<span>".$page."&nbsp;</span>";
            for($i=$page+1;$i<=$lastPage;$i++){
                if($i >= $page+=4){break;}
                $pageCtrls .= "<a href=''></a>";
            }
        }
        include __VIEWPATH__.$this->views_dir."home.php";
    }

    private function removeEducation($user, $item){
        if($user->removeEduBg($item) != true){
            $_SESSION['error'] = "Unable to complete your request. Please try later";
        }
        header("location: ".$_SERVER['REQUEST_URI']);
        exit;
    }
    private function removeWork($user, $item){
        if(preg_match('/[0-9]+/', $item)){
            $rem = $user->removePortfolio($item);
            if($rem !== true){
                $_SESSION['error'] = "Unable to complete request";
            }
            header("location: ".$_SERVER['REQUEST_URI']);
            exit;
        }
        $_SESSION['error'] = "Could not complete request";
        header("location: ".$_SERVER['REQUEST_URI']);
        exit;
    }
    private function removeSkill($user, $item){
        if($user->removeSkill($item) !== true){
            $_SESSION['error'] = "Request could not be completed";
        }
        header("location: ".$_SERVER['REQUEST_URI']);
        exit;
    }

    public function actionProfile(){

        if($this->me == "guest"){
            $this->actionSignin();
            return;
        }
        $me = $this->me;

        if(isset($_POST['remove_sk'])){
            $this->removeSkill($me, $_POST['skill_item']);
        }
        if(isset($_POST['remove_work'])){
            $this->removeWork($me, $_POST['portfolio_item']);
        }
        if(isset($_POST['remove_edu'])){
            $this->removeEducation($me, $_POST['education_item']);
        }

        include __VIEWPATH__.$this->views_dir."profile.php";
    }

    public function actionApplications(){
        $user = UserController::getLoggedUser();
        if($user == null){
            UserController::redirectToLogin();
        }
        if($user->utype == "employer"){
            header("location: ?controller=employer&action=index");
            exit();
        }

        $apps = $user->getApplications();
        $page = "applications";
        $me = $user;
        //this file wraps up dashboard for both employer and student
        include __VIEWPATH__ ."user/_dashboard.php";
    }
}