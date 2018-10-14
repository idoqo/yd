<?php
/*
if(isset($_GET['with'])) {
    $myId = $me->userID;
    //avoid sending message to self
    if($myId == $_GET['with']){
        $_GET['with'] = "";
    }
}*/
?>
<div style=" min-height: 100%; width: 100%;border: 1px solid; border-color: #e7e7e7 #e7e7e7 #f7f7f7;background-color: #e5eaee">
    <p style="padding: 10px;font-size: 110%;">Messages</p>
    <div style="width: 100%; min-height: 600px;">
        <div class="chat-head-wrapper" style="height: 100%; width: 33%; float: left; background: #f7f7f7;" id="name">
            <div class="input-container" style="width: 96%; margin: 10px auto; background: #2573A6">
                <form>
                    <label for="q">
                        <input type="text" style="margin: 0;padding: 10px 5px; position:relative;width: 88%;border-radius: 0" name="q"/>
                    </label>
                    <button type="submit" style="position: absolute;">
                        <span class="fa fa-search"></span>
                    </button>
                </form>
            </div>
            <?php
            $convoHeads = Message::getChatHeads($me->userID, $chat_head_page_num);
            if ($convoHeads['num_rows'] > 0) {
            foreach ($convoHeads['result'] as $convoHead) {
                if ($convoHead['sender'] === $me->userID) {
                    $head = $convoHead['receiver'];
                } else {
                    $head = $convoHead['sender'];
                }
                $partner = User::getUser($head);
                echo '<div class="cl-chat-head name">';
                echo '<a href="?controller=user&action=messages&with='. $head . '" class="chat-head-link">
                      <b>' . $partner->fullName . '</b>
                      </a>';
                echo '</div>';
            }
        }
            else {
            echo "No chat started";
            }
            ?>
        </div>
        <div class="chat-msgs" style="height: 80vh; width: 66%; float: right; background: #f7f7f7;">
            <div class="chat-msgs-wrapper">
            <?php
            if (isset($_GET['with']) && (User::getUser($_GET['with']) != false)) {
                $pageNum = isset($_GET['aftercursor']) ? $_GET['aftercursor'] : 1; //page number

                $partner = preg_replace('/[^0-9]+/', '', $_GET['with']);
                $partnerDetails = User::getUser($partner);
                $pageTitle = "Messages - " . $partnerDetails->fullName;
                $limit = 6;
                echo "<div class='cl-chats-wrapper'>";
                $myId = $me->userID;
                $convos = Message::getConvo($myId, $partner, $limit, $pageNum);

                $total = array_shift($convos); //remove the first element...it is the total messages.
                $check = ceil($total/$limit);
                $nextPage = $pageNum + 1;
                $convos = array_reverse($convos);
                ?>
                <p style='padding: 5px; border-bottom: 1px solid #fff'>
                    <a href="?controller=user&mp;action=messages&amp;with=<?php echo htmlspecialchars($partnerDetails->userID);?>">
                        <?= $partnerDetails->fullName ?>
                    </a>
                    <span style='float: right;'>
                        <a href='?controller=user&amp;action=messages&amp;with=<?=$partnerDetails->userID;?>&amp;=aftercursor=<?= $nextPage ?>'>
                            Older Messages
                        </a>
                    </span>
                </p>
            <?php
                foreach ($convos as $convo) {
                    if ($convo['sender'] == $myId) {
                        echo '<div class="from_me">';
                        echo strip_tags($convo['message']);
                        echo '</div>';
                    } else {
                        $sender = $partner;
                        echo '<div class="to_me">';
                        echo strip_tags($convo['message']);
                        echo '</div>';
                    }
                }
                echo "</div>";
            }
            ?>
        </div>
        <div style="width: 100%;">
            <form class="msg-form" action="?controller=user&action=sendMessage" method="post" enctype="multipart/form-data">
                <div class="col-4">
                    <textarea name="message" placeholder="Type your message here"></textarea>
                    <?php if($partnerDetails != null) {
                        ?>
                        <input type="hidden" name="to" id="cl-partner-token"
                               value="<?php echo $partnerDetails->userID ?>"/>
                        <button type="submit" style="float: right; margin: 10px;margin-top: -75px;border-radius: 30px; "
                                name="send" value="Send">
                            <span class="fa fa-send" style=" padding: 20px;border-radius: 30px;"></span>
                        </button>
                        <?php
                    }
                    ?>
            </form>
            <?php
            if(isset($_SESSION['error'])){
                echo "<p style='color: #a41a1a;'>";
                echo($_SESSION['error']);
                echo "</p>";
                unset($_SESSION['error']);
            }
            ?>
        </div>
    </div>
</div>
    </div>
<style type="text/css">
    .cl-chat-head{
        width: 94%;
        padding: 3%;
        min-height: 2em;
    }
    .chat-msgs-wrapper{
        position: relative;
        height: 70%;
        width: 100%;
        float: right;
        background: #f7f7f7;
        overflow-y: scroll;
        margin-bottom: 15px;
        padding-bottom: 10px;
        border-bottom: 2px solid #e5eaee;
    }
    .from_me, .to_me{
        max-width: 60%;
        padding: 10px;
        margin: 10px;
        clear: both;
        border-radius: 3px;
        position: relative;
    }
    .from_me:before, .to_me:before{
        position: absolute;
        content: "";
        border: 8px solid transparent;
        top: 5px;
    }
    .from_me{
        background: #f9bfbb;
        float: right;
        margin-right: 20px;
    }
    .from_me:before{
        border-left: 12px solid #f9bfbb;
        left: 99%;
    }
    .to_me{
        background: #fff;
        float: left;
        margin-left: 25px;
    }
    .to_me:before{
        border-right: 12px solid #fff;
        right: 99%;
    }
    .msg-form textarea{
        width: 70%;
        margin: 1%;
        border: 1px solid #c8c8c8;
        height: 5em;
        resize: none;
        padding: 5px;
    }
    form button[type="submit"] .fa{
        font-size: 1.2em; background: #2573A6; color: #fff;border-radius: 5px;
    }
    form button.disabled .fa{
        background: lightblue;
    }
</style>
<script type="text/javascript">
    var options = {
        valueNames: ['name' 'message']
    };

    var chatHeads = new List('chat-head', options);
</script>