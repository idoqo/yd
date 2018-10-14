<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8" />
    <style type="text/css">
        #header-nav li, .ref-icon{
            position: relative;
        }
        #header-nav li > div{
            position: absolute;
        }
        .close-head img{
            margin: -10px;
            float: left;
        }
    </style>
    <base href="/">
    <title><?php echo isset($pageTitle) ? $pageTitle : "Yedoe"; ?></title>
    <meta name="keywords" content="intern, internships, jobs, entry jobs, students, vacancies, college,
                campus jobs, work from school,university" />
    <meta name="description" content="Access the latest internship opportunities in Ghana." />
    <link href="static/css/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="static/css/base.css" rel="stylesheet">
    <link href="static/pc/forms.css" rel="stylesheet">
    <link href="static/pc/internsHub.css" rel="stylesheet">
    <link href="static/pc/entrance.css" rel="stylesheet">
    <script type="text/javascript" src="static/js/jquery.js"></script>
    <script type="text/javascript" src="static/js/xWssDFQ6Z.js"></script>
    <script type="text/javascript" src="static/js/list.js"></script>
    <?php
    if(isset($__directives)){
        //use this variable to dynamically include other files that ought to be within <head></head>
        foreach($__directives as $__directive){
            echo $__directive;
        }
    }
    ?>
</head>
<body>
<div id="global-container row">
    <nav class="tiny-liner">
        <a href="/">
            <img src="/static/img/ddd.png" height="100" width="100" id="logo">
        </a>
        <span class="resp-menu fa fa-bars"></span>
        <?php
        if($me == "guest"){
            $url = "?controller=user&action=signin";
        }
        elseif($me->utype == "emp"){
            $url = "dashboard";
        }
        else{
            $url = "profile/";
        }
        ?>
        <a href="<?php echo $url; ?>"><img src="/static/img/profiles/<?php echo $photo; ?>" height="40" width="40" class="ref-icon"></a>
        <ul id="header-nav">
            <li><a href="?controller=job"><span class="fa fa-search"></span> Browse</a></li>
            <?php
            if($me != "guest"){
                ?>
                <li><a href="?controller=user&amp;action=messages"><span class="fa fa-comments"></span> Messages</a>
                </li>
                <?php
            }
            else{
                echo '<li><a href="?controller=student&action=signup"><span class="fa fa-user-plus"></span> Sign Up</a></li>';
            }
            ?>
            <li>
                <?php
                if($me == "guest"){
                    if(!isset($thispage) || $thispage !== "index"){
                        echo '<a href="?controller=student&action=signin"><span class="fa fa-sign-in"></span> Login</a>';
                    }
                    else{
                        echo '<a href="javascript:void(0)" id="xWsdg"><span class="fa fa-sign-in"></span> Login</a>';
                    }
                }
                else{echo '<a href="?controller=user&amp;action=logout"><span class="fa fa-sign-out"></span> Logout</a>';}
                ?>
            </li>
        </ul>
        <?php

        ?>
    </nav>
    <div id="body-container grid-container"> <!--close in footer.php-->
        <?php
        include "route.php";
        include __VIEWPATH__."footer.php";
        ?>
