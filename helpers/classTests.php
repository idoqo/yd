<?php
if(isset($_POST['save'])){
    $f = $_FILES['pic'];
    var_dump($f['type']);

    if($f['error'] !== UPLOAD_ERR_OK){
        die("Unable to upload file");
    }

    $fInfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime = finfo_file($fInfo, $f['tmp_name']);
        var_dump($f['name']);
}
?>
<form action="classTests.php" method="post" enctype="multipart/form-data">
    <input type="file" name="pic">
    <input type="submit" name="save" value="Upload">
</form>