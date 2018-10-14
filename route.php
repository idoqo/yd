<?php
function call($controller, $action, $params=array()){
    $controllerFullName = ucfirst($controller)."Controller.php";
    $actionMethod = "action".ucfirst($action);

    require_once "controllers/".$controllerFullName;

    switch($controller){
        case 'site':
            $controller = new SiteController();
            break;
        case 'student':
            $controller = new StudentController();
            break;
        case 'employer':
            $controller = new EmployerController();
            break;
        case 'user':
            $controller = new UserController();
            break;
        case 'job':
            $controller = new JobController();
            break;
    }
    $controller->{$actionMethod}();
}

call($controller, $action);
