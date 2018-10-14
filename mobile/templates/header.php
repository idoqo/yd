<?php
    session_start();
    ob_start();
    $email = isset($_COOKIE['logged']) ? $_COOKIE['logged'] : "";
    $token = isset($_COOKIE['_intseid']) ? $_COOKIE['_intseid'] : "";
    
    if($email == "" || $token == ""){
        $me = "guest";
    }
    else{
        $me = User::getUser(false, $email);
    }
?>
<!DOCTYPE html>
<html>
<head>
    <?php $pageTitle = isset($title) ? $title : "Yedoe - Be Discovered"; ?>
    <title><?php echo $pageTitle ?></title>
    <meta name="description" content="Click your way to experience">
    <base href="<?php echo __BASE."mobile/" ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=false">
    <meta name="keywords" content="intern, internships, jobs, entry jobs, students, vacancies, college,
                campus jobs, work from school,university" />
    <meta name="description" content="Access the latest internship opportunities in Ghana." />
    <link href="favicon.png" rel="icon" type="image/png">
    <script src="scripts/jquery.js"></script>
    <script type="text/javascript" src="scripts/internshub.js"></script>
    <link href="styles/css/font-awesome.min.css" rel="stylesheet">
    <link href="styles/fonts/icomoon/style.css" rel="stylesheet"/>
    <link href="../styles/base.css" rel="stylesheet">
    <link href="styles/internshub.css" rel="stylesheet">
    <link href="styles/forms.css" rel="stylesheet">
</head>
<style>
/*MOVE TO INSIDE OF HEAD TAG LATER*/
.header{
    height: 5em;
    background: #fff;
    border-top: 10px solid #426bb3;
}
.header .tiny-liner-nav{
    color: #fff;
    margin: .3em.5em;
}
.header .tiny-liner-nav{
    color: #124168;
}
.header form{
    border-bottom: 1px solid #e7e7e7;
}
    .icon-nav{
        position: absolute; margin: 10px;
        top: 35px;
        width: 98%;
        padding: 10px;
    }
    .icon-nav a{
        padding: 5px;
        font-size: 1.5em;
        margin: 3%;
    }
</style>
<body>
<div data-theme="a" id="main_wrapper">
  <div class="header" data-role="header">
    <?php
        if($me == "guest"){
            echo '<p style="float: right; margin-top: .5em;">';
              echo '<span><a href="signin" class="tiny-liner-nav" >Login</a></span>';
              echo "<span style='color: #123168'>|</span>";
              echo '<span><a href="signup" class="tiny-liner-nav">Sign Up</a></span>';
            echo '</p>';
        }
        else{
    ?>
      <form style="float: left; position: relative;width: 85%; border-right: 1px solid #e7e7e7;height: 100%;" action="search.php" method="get">
            <input type="text" name="query" style="width: 75%;float: left; border: 1px solid #c8c8c8; margin: 5px; height: 2em;">
            <button type="submit" style="background-color: #124168;color: #fff; padding: 2px 4px;margin-top: 5px;position:absolute;">Search</button>
      </form>
    <h4>
       <a href="#"><span style="float: right; color: #123168; margin: 10px;cursor: pointer;font-size: 1.5em;" id="menu-launcher" class="icon-list2"></span></a>
    </h4>
      <br />
        <nav class="icon-nav">
          <a href="profile"><span class="icon-profile"></span> </a>
          <a href="messages"><span class="icon-bubbles3"></span> </a>
          <a href="search.php"><span class="icon-podcast"></span> </a>
          <a href="myprojects"><span class="icon-folder"></span> </a>
        </nav>
  </div>
    <div id="menu_list" name="menu" class="menu_list">
    <ul>
        <li><a href="dashboard.php"><i class="fa fa-dashboard"></i>Dashboard</a></li>
      <li><a href="profile"><i class="icon-user-tie"></i>Profile</a></li>
      <li><a href=""><i class="icon-envelope"></i>Messages</a></li>
      <?php
          if($me->utype=="student"){
              echo '<li><a href="search.php"><i class="fa fa-search"></i>Browse Projects</a></li>';
          }
          else{
              echo '<li><a href="addproject"><i class="fa fa-pencil"></i>Create Project</a></li>';
          }
      ?>
        <li><a href="settings"><i class="fa fa-cogs"></i> Settings</a></li>
    <?php
        }
    ?>
    </ul>
  </div>
<div class="content">