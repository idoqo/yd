<?php
if($me == "guest"){
    $_SESSION['goto'] = "resume.php"; //BETA!! lol
    header("location: signin");
    exit();
}
$m = isset($_GET['m']) ? $_GET['m'] : "upload";
switch($m){
    case "build":
        $theme = isset($_GET['template']) ? $_GET['template'] : "";
        header("location: buildresume.php");
        break;

    case "upload":
        default:
?>
<div class="details-custom">
    <div class="col-4 centered" style="background: #fff;">
        <ul class="ui-list">
            <li>
                <b>No resume yet?</b><br />
                Try our <a href="welcome.php?option=cv&m=build">Resume builder</a>
            </li>
            <li>
                <b>Not sure how your resume fare?</b><br/>
                See our guide to the<a href="#"> Perfect Resume</a>
            </li>
            <li>Resume files should be PDF or Microsoft Word document</li>
        </ul>
        <form action="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']); ?>" method="post" enctype="multipart/form-data">
            <?php
            if($me->getResumeFile() != false){
                echo '<p class="warning">';
                echo '<span class="fa fa-warning"> You have an existing resume. Adding a new one will override the existing file.</span>';
            }
            ?>
            <div class="fileUpload">
                <span class="fa fa-folder-open"> Browse</span>
                <label for="inputFile"></label>
                <input type="text" name="" value="Choose a file" disabled="disabled" style="padding: 10px;" id="inputFile">
                <label for="uploadInput"><input type="file" id="uploadInput" class="uploadInput" name="resumeFile" value="upload"/></label>
                <label for="upload"><input type="submit" name="upload" value="Upload" id="upload" style="float: right;"/></label>
            </div>
            <?php if(isset($_SESSION['error'])){
                echo "<p class='error'>
                        <span class='fa fa-warning error'></span>
                        {$_SESSION['error']}
                     </p>";
                unset($_SESSION['error']);}
            ?>
        </form>
    </div>
</div>
<?php
        break;
}

?>
<style>
    .details-custom h1{
        color: #353535;
        padding: 10px;
        border-bottom: 1px solid #e0e0e0;
    }
    form{
        padding: 2em;
    }
    .fileUpload{
        position: relative;
        overflow: hidden;
        margin: 10px;
    }
    .fileUpload span{
        background: #d7d7d7;
        border-radius: 5px;
        border: 1px solid rgba(0,0,0,0.35);
        box-shadow: inset 0 1px 0 rgba(120,120,230,.5),0 1px 0 rgba(0,0,0,.15);
        color: #222;
        font-family: FontAwesome, Roboto;
        padding: 8px 12px;
    }
    .fileUpload input.uploadInput{
        position: absolute;
        top: 0;
        right: 0;
        left: 0;
        bottom: 0;
        border: 0;
        opacity: 0;
    }
    .ui-list{
        list-style: none;
        margin-bottom: 3em;
    }
    .ui-list li{
        margin-left: 1em;
        padding: 15px 0;
    }
    .ui-list li:before{
        content: "\f0a4";
        font-family: FontAwesome;
        margin:-8px 1em;
        float: left;
        clear: both;
        border-radius: 30px;
        border:1px solid #353535;
        padding: 10px;
    }
    .ui-grid li{
        display: inline-table;
        height: 350px;
        width: 30%;
        border: 1px solid #e0e0e0;
        box-shadow: 1px -1px 1px #e0e0e0;
        margin: 20px 10px;
    }
    .ui-grid li img{
        width: 100%;
        height: 320px;
        background: #fff;
    }
    .ui-grid li p{
        margin: 5px;
        text-align: center;
        font-weight: bold;
    }
</style>
<script type="text/javascript">
    $(document).ready(function(){
        document.getElementById("uploadInput").onchange = function () {
            document.getElementById("inputFile").value = this.value.split('\\').pop();
        };
    })
</script>