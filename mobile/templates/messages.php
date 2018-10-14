<?php
if(isset($_POST['send'])){
    if($me == "guest"){
        header("location: signin");
        exit;
    }
    if(!isset($_GET['with'])){
        $_SESSION['error'] = "No recipient selected";
        header("location: ".$_SERVER['REQUEST_URI']);
        exit;
    }
    if(trim($_POST['message']) == ""){
        $_SESSION['error'] = "Cannot send blank message";
        header("location: ".$_SERVER['REQUEST_URI']);
        exit;
    }
    $message = new Message();
    $message->parse($_POST);
    $message->setReceiver($_GET['with']);
    $message->setSender($me->userID);

    if($message->create() !== true){
        $_SESSION['error'] = "Failed to send message";
        var_dump($message->create());
    }
    header("location: ".$_SERVER['REQUEST_URI']);
    exit;
}

$pageTitle = "Messages";
$limit = 6;
if($partner != false){
    $pageNum = isset($_GET['aftercursor']) ? $_GET['aftercursor'] : 1; //page number
    $convos = Message::getConvo($me->userID, $partner->userID, $limit, $pageNum);
    //remove the first element...it is the total messages.
    $total = array_shift($convos);
    $nextPage = $pageNum + 1;
    $check = ceil($total / 10); //10 is set while calling getConvo method
    if ($nextPage > $check) {
        $nextPage = 1;
    }
    $convos = array_reverse($convos);
    if(empty($convos) && $me->utype != "emp"){
        //ensure that only employers can send new messages
    }
else{
?>
    <div class="cl-chats-wrapper">
        <p class="cl-chat-partner" style="padding-bottom: 10px; border-bottom: 1px solid #d7d7d7;">
            <b style="font-size: .8em;"><?= $partner->fullName; ?></b>
            <span style="float: right;">
                <a href="messages/<?= $partner->userID ?>?aftercursor=<?= $nextPage; ?>">Older Messages</a>
            </span>
        </p>
        <div class="row">
            <?php
            foreach ($convos as $convo) {
                if ($convo['sender'] == $me->userID) {
                    echo '<div class="from_me">';
                    echo htmlentities($convo['message']);
                    echo '</div>';
                } else {
                    $sender = $partner;
                    echo '<div class="to_me">';
                    echo htmlentities($convo['message']);
                    echo '</div>';
                }
            }
            if(isset($_SESSION['error'])){
                echo "<div class='error-msg'>{$_SESSION['error']}</div>";
                unset($_SESSION['error']);
            }
            ?>
        </div>
        <div class="row">
            <form action="" method="post" enctype="multipart/form-data">
                <textarea placeholder="Type your message" name="message"></textarea>
                <input type="submit" name="send" value="Send" />
            </form>
        </div>
        <?php
        }
        }
        else{
            $convoHeads = Message::getChatHeads($me->userID);
            if($convoHeads['num_rows'] > 0) {
                if (!empty($convoHeads)) {
                    if(!isset($_GET['with'])){
                    //Another attempt to set the WITH variable
                }
                foreach ($convoHeads['result'] as $convoHead) {
                    if ($convoHead['sender'] === $me->userID) {
                        $head = $convoHead['receiver'];
                    } else {
                        $head = $convoHead['sender'];
                    }
                    $partner = User::getUser($head); ?>
                    <div class="row cl-chat-head">
                        <a href="messages/<?= $head ?>" class="chat-head-link">
                            <b><?= $partner->fullName ?></b>
                        </a>
                    </div>
                <?php }
            }
    }
            else {
                echo "No chat started";
            }
        }
?>
    </div>
<style type="text/css">
    form{
        position: relative;
    }
    .cl-chats-wrapper{
        position: relative;
        min-height: 100%;
        height: auto;
        margin-bottom: auto;
    }
    .cl-chat-head{
        margin: .8em 0;
        border-bottom: 1px solid #c8c8c8;
    }
    .from_me, .to_me{
        clear: both;
        max-width: 65%;
        padding: 5px;
        margin: 5px 10px;
        border-radius: 5px;
    }
    .to_me{
        float: left;
        border: 1px solid #fff;
        background: #fff;
    }
    .from_me{
        border: 1px solid #f9bfbb;
        background: #f9bfbb;
        float: right;
    }

</style>