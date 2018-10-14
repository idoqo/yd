<style type="text/css">
    .meta img{
        border-radius:3px;
        box-shadow: 0px 1px 3px #c1c1c1;
        margin-bottom: 15px;
    }
    a:hover{
        text-decoration: none;
    }
    h1{
        padding: 10px;
        margin-top: 10px;
        border-radius: 2px;
    }
    .section-title span{
        margin-right: 1em;
    }
    .sidebar ul{
        list-style: none;
        margin-top: 30px;
        width: 95%;
        box-shadow: -1px 1px 3px rgba(0, 0, 0, 0.8);
        position: relative;
        background: #d7d7d7;
    }
    .sidebar ul li{
        padding: 2.1em 1.5em;
        background: #e7e7e7;
        margin-top: .1em;
        background-image: -webkit-gradient(linear, 50% 100%, 50% 0%, from(#e7e7e7), to(#f7f7f7));
        background-image: -moz-linear-gradient(#f7f7f7,#e7e7e7);
    }
    .sidebar li.current{
        position: relative;
        background: #d7d7d7;
    }
    .sidebar li.current:before{
        position: absolute;
        content: "";
        border: 13px solid transparent;
        border-left-color:#d7d7d7;
        left: 100%;
    }
    .sidebar li span{
        margin-right: 1em;
        color: #1a52a7;
    }
    .sidebar li a{
        color: #1a52a7;
    }
</style>
<?php
if($me->utype == "student"){
    ?>
    <div class="sidebar">
        <div class="meta">
            <img src="/static/img/profiles/<?php echo $me->displayPic; ?>" width="100" height="100">
        </div>
        <ul>
            <li <?php if($page == "home")echo "class='current'"; ?>>
                <span class="fa fa-home"></span><a href="?controller=student">Home</a>
            </li>
            <li>
                <span class="fa fa-user"></span><a href="?controller=student&amp;action=profile">My Profile</a>
            </li>
            <li <?php if($page == "messages")echo "class='current'"; ?>>
                <span class="fa fa-envelope"></span><a href="?controller=student&amp;action=messages">Messages</a>
            </li>
            <li <?php if($page == "applications")echo "class='current'"; ?>>
                <span class="fa fa-archive"></span><a href="?controller=student&amp;action=applications"> Applications</a>
            </li>
            <li <?php if($page == "settings")echo "class='current'"; ?>>
                <span class="fa fa-cogs"></span><a href="?controller=student&amp;action=settings">Settings</a>
            </li>
            <li><span class="fa fa-question-circle"></span><a href="?controller=site&amp;action=help">Help</a></li>
        </ul>
    </div>
    <div class="bigger-box">
        <div class="routed">
            <?php
            //decide what to include in div to show...
            switch($page){
                case "applications":
                    include __VIEWPATH__."student/archives.php";
                    break;
                case "settings":
                    include "student/settings.php";
                    break;
                case "messages":
                    include __VIEWPATH__. "user/messages.php";
                    break;
                case "projects":
                    include "student/archives.php";
                    break;
                case "home":
                default:
                    include __VIEWPATH__."student/dashboard.php";
                    break;
            }
            ?>
        </div>
    </div>
    <?php
}
else{
?>
    <div class="sidebar">
        <div class="meta">
            <img src="/static/img/profiles/<?php echo $me->displayPic; ?>" width="100" height="100">
        </div>
        <ul>
            <li <?php if(($page == "home") || ($page == ""))echo "class='current'"; ?>>
                <span class="fa fa-home"></span><a href="?controller=employer">Home</a>
            </li>
            <li <?php if($page == "projects")echo "class='current'"; ?>>
                <span class="fa fa-archive"></span><a href="?controller=employer&amp;action=projects">Openings</a>
            </li>
            <li <?php if($page == "new")echo "class='current'"; ?>>
                <span class="fa fa-plus"></span><a href="?controller=job&amp;action=create">Add New Project</a>
            </li>
            <li <?php if($page == "profile")echo "class='current'"; ?>>
                <span class="fa fa-flag"></span><a href="?controller=employer&amp;action=profile">Profile</a>
            </li>
            <li <?php if($page == "messages")echo "class='current'"; ?>>
                <span class="fa fa-envelope"></span><a href="?controller=employer&amp;action=messages">Messages</a>
            </li>
            <li <?php if($page == "edit")echo "class='current'"; ?>>
                <span class="fa fa-pencil"></span><a href="?controller=job&amp;action=edit">Job Editor</a>
            </li>
            <li <?php if($page == "settings")echo "class='current'"; ?>>
                <span class="fa fa-cogs"></span><a href="?controller=employer&amp;action=settings">Settings</a>
            </li>
            <li>
                <span class="fa fa-question-circle"></span><a href="?contrller=site&amp;action=help">Help</a>
            </li>
        </ul>
    </div>
    <div class="bigger-box">
        <div class="routed">
            <?php
            switch($page){
                case "new":
                    include __VIEWPATH__."employer/new.php";
                    break;
                case "editor":
                    include __VIEWPATH__."employer/editjob.php";
                    break;
                case "settings":
                    $info = $me->getInfo();
                    include "employer/settings.php";
                    break;
                case "messages":
                    include __VIEWPATH__."user/messages.php";
                    break;
                case "projects":
                    if(isset($_GET['focus'])){
                        include "employer/focus.php";
                    }
                    else {
                        include __VIEWPATH__."employer/archives.php";
                    }
                    break;
                case "home":
                default:
                    include __VIEWPATH__."employer/dashboard.php";
                    break;
            }
            ?>
        </div>
    </div>
    <?php
}
?>