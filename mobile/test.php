<title>Test page</title>
<?php
require_once "lib/settings.config.inc";
require_once "lib/lib.php";
require_once "lib/users.class.php";
require_once "lib/jobs.class.php";
require_once "lib/activity.class.php";

$prevMsgs = Activity::pullActivity(4);
$msg = array(
         array("fuck", "earn", "sleep", "pray"),
         array("php", "javascript", "c++"),
         array("phy", "bio", "chem"),
         array("dice", "eaweb", "swag", "supreme", "nature")
        );
$msgCount = count($msg);
$listCount = count($prevMsgs);
for($i=0;$i<$listCount;$i++){
    $prevMsgs[$i]->message = $msg[$i];
}
var_dump($prevMsgs);