<?php
class JobController extends Controller
{
    protected $views_dir = "job/";

    public function actionCreate(){
        //validate form
        //$this->prepareForm();
        $loggedUser = new EmployerController();
        if($loggedUser->me == "guest"){
            return;
        }
        $me = $loggedUser->me;
        if(isset($_POST['create'])) {
            $job = new Job($_POST);
            $job->postedBy = $me->userID;
            $job->skills = $_POST['skills'];
            $job->type = ($_POST['type']) ? "Paid" : "Non-paid";
            if ($job->create() === true) {
                //go to user projects
                $_SESSION['error'] = "Created";
            } else {
                $_SESSION['error'] = "Unable tp create job. Please try later";
            }
        }
        $page="new";
        include __VIEWPATH__."user/_dashboard.php";
    }

    public function actionView(){
        $jobId = isset($_GET['job_id']) ? $_GET['job_id'] : "";
        $details = Job::getById($jobId);
        //stub values...But believe you need them
        $page_num = 1;
        $limit = 15;

        if($details == null){
            $this->actionSearch();
            return;
        }

        $employer = $details->getEmployer();
        $url = $details->jobId . "/" . cleanUrl($details->title);
        $fb = urlencode("http://www.yedoe.com/pc/project/".$url);
        $fbUrl = "http://facebook.com/sharer/sharer.php?u=http://www.yedoe.com/project/".$fb;
        $twitterText = $details->title;
        $twitterVia = "yedoe";
        $twitterUrl = "http://twitter.com/intent/tweet/?text=$twitterText&url=$fb&via=$twitterVia";

        //calculate time till expiry
        $created = $details->postedDate;
        $expires = !is_null($details->expiryDate) ? $details->expiryDate : "";
        $format = "";
        if($expires != "") {
            $from = new DateTime($created);
            $till = new DateTime($expires);
            $now = new DateTime(date('Y-m-d'));
            if ($till < $now) {
                $format = false;
            } else {
                $interval = $from->diff($till);
                $format = $interval->format('%a');
            }
        }

        $loggedUser = new StudentController();

        $applications = $details->getBids($page_num, $limit);
        $haveApplied = !(Application::userJobPairExists($details->jobId, $loggedUser->me->userID));
        $num_applications = $applications['num_rows'];

        include __VIEWPATH__.$this->views_dir."view.php";
    }

    public function actionSearch(){

    }

    public function actionIndex(){
        $page = isset($_GET['page_num']) ? $_GET['page_num'] : 1;
        $limit = isset($_GET['limit']) ? $_GET['limit'] : 15;

        $jobs = Job::archives($page, $limit);
        $numResults = $jobs['num_rows'];

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

    public function actionEdit(){
        if(!isset($_GET['job_id']) || $_GET['job_id'] == ""){
            return;
        }
        $jobId = $_GET['job_id'];
        $job = Job::getById($jobId);
        if($job == null)
            return;
        //@todo verify that the user is of employer type first!!
        $loggedUser = new EmployerController();
        if($loggedUser->me->userID != $job->postedBy){ //IMPOSTOR!
            return;
        }

        if(isset($_POST['update'])){
            $project = new Job($_POST);
            foreach($_POST as $p => $q){
                if($p == "update"){
                    continue;
                }
                if($project->updateField($p, $q) != true){
                    $_SESSION['error'] = $project->updateField($p, $q);
                    $error[] = "An error occurred. Please try later";
                }
            }
            if(!empty($error))
                $_SESSION['error'] = $error;

            header("location: ".$_SERVER['REQUEST_URI']);
        }


        $page = "editor";
        $me = $loggedUser->me;
        $project = $job;
        include  __VIEWPATH__."user/_dashboard.php";
    }

    /*private function prepareForm()
    {
        if (isset($_POST['post']) && $_POST['post'] == "Post") {
            $title = htmlspecialchars($_POST['title']);
            $desc = htmlspecialchars($_POST['description']);
            $req = htmlspecialchars($_POST['requirements']);

            if (trim($title) == "") {
                $_SESSION['error'] = "Job title cannot be blank";
                header("location: " . $_SERVER['REQUEST_URI']);
                exit;
            }
            if (trim($desc) == "") {
                $_SESSION['error'] = "Please include a job description";
                header("location: " . $_SERVER['REQUEST_URI']);
                exit;
            }
            if ($_POST['expiry_date'] == "") {
                $_SESSION['error'] = "Expiry date should not be blank";
                header("location: " . $_SERVER['REQUEST_URI']);
                exit;
            }
            if (empty($_POST['skills'])) {
                $_SESSION['error'] = "Please choose the project's  field";
                header("location: " . $_SERVER['REQUEST_URI']);
                exit;
            }
            $expiry = new DateTime();
            $expiry = $expiry->createFromFormat("Y-m-d", $_POST['expiry_date']);
            if ($expiry < date('Y-m-d')) {
                $_SESSION['error'] = "Expiry date is invalid";
                header("location: " . $_SERVER['REQUEST_URI']);
                exit;
            }
            if ((trim($_POST['sRange']) != "") && (!preg_match('/[0-9\.]+/', $_POST['sRange']))) {
                $_SESSION['error'] = "Salary range seems to be invalid";
                header("location: " . $_SERVER['REQUEST_URI']);
                exit;
            }
            if ((trim($_POST['eRange']) != "") && (!preg_match('/[0-9\.]+/', $_POST['eRange']))) {
                $_SESSION['error'] = "Salary range seems to be invalid";
                header("location: " . $_SERVER['REQUEST_URI']);
                exit;
            }

            $_POST['budget'] = $_POST['sRange'] . "-" . $_POST['eRange'];
        }
    }*/
}