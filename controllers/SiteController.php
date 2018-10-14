<?php
class SiteController extends Controller
{
    public function actionIndex(){
        if(UserController::getLoggedUser() !== null){
            $user = UserController::getLoggedUser();
            if($user->utype == "employer"){
                header("location: ?controller=employer&action=index");
            } else{
                header("location: ?controller=student&action=index");
            }
        }
        include __VIEWPATH__."default.php";
    }
}