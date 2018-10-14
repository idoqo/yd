<!DOCTYPE html>
<html>
<head>
<base href="<?php echo __BASE."mobile/"?>"/>
<meta name="viewport" content="width=device-width, user-scalable=false">
<title>Thruggs Sign Up</title>
<link href="../styles/css/font-awesome.min.css" rel="stylesheet">
<link href="../styles/internshub.css" rel="stylesheet">
<link href="../styles/entrance.css" rel="stylesheet">
<style type="text/css">
</style>
<style>
    form{
        text-align: center;
        margin: auto;
        margin-top: 1em;
        border-radius: 3px;
        border:1px solid #fff;
        width: 90%;
    }
    form input[type="text"], form input[type="password"], form input[type="number"], form select{
        border-top: 1px solid #e7e7e7;
        padding: 10px 1em;
        width: 90%;
        color: rgba(0, 0,0,0.6);
    }
    form input[type="text"], form input[type="password"]{
        border-bottom: 1px solid #fff;
    }
    form input[type="submit"]{
        width: 90%;
        border-radius: 3px;
        margin: 1em 0;
        padding: 10px;
        color: #fff;
        background: #42B28C;
        border: none;
    }
    form input .first{
        border: none;
    }
    .ui-btn{
        width: 90%;
        border-radius: 3px;
        margin:10px auto 20px;
        padding: 10px;
        color: #fff;
        background: #42B28C;
        border: none;
    }
    .ui-btn a{
        color: #fff;
    }
    .error-msg{
        color: #da534f;
    }
</style>