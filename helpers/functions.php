<?php
/**STRING HANDLING**/
/**
* validate name [can be twisted for usernames, screen names, etc...]
* 
* @param string $data
* @return mixed  [string 'ok' if vaildation succeeds]
*/
function isValidName($data)
{
    $data = htmlspecialchars($data) ? htmlspecialchars($data) : "";
    if(empty($data) || (trim($data) == "")){
        $nameErr = "Name fields cannot be empty";
        return $nameErr;
    }else{
        $pattern = "/^[a-z -]+$/i";
        if(!preg_match($pattern, $data)){
            $nameErr = "Please Check for invalid characters";
            return $nameErr;
        }
    }
    if(strlen($data) > 30){
        $nameErr = "Your name may be too long...Maybe you should give us a shorter version.";
        return $nameErr;
    }
  return "ok";
}

function sanitize($data){
    $data = htmlspecialchars($data, ENT_QUOTES);
    $data = str_replace("\n\r", "\n", $data);
    $data = str_replace("\r\n", "\n", $data);
    $data = str_replace("<br>", "\n", $data);
    return $data;
}
/**truncate a long string
 * @param string string to be truncated
* @param int $limit to start truncation
 * @param string $pad string to be attached at the end. Defaults to ellipsis
 * @param string $delimiter breaks the string at the first delimiter after the limit. Defaults to whitespace
 * @return mixed truncated string
 */
function truncate($string, $limit, $pad,  $delimiter = " "){
    if(strlen($string) <= $limit){
        return $string;
    }
    if(($breakpoint = strpos($string, $delimiter, $limit)) !== false){
        if($breakpoint < strlen($string)-1){
            $string = substr($string, 0, $breakpoint).$pad;
        }
    }
    return $string;
}

function stripQuotes($s){
    $result = preg_replace("/[^a-zA-Z0-9] -+/", "", html_entity_decode($s, ENT_QUOTES));
    return $result;
}

function validLocation($string){
    $pattern = '/(a-z0-9_\*\.,\')/i';
    return preg_match($pattern,$string);
}

/**IMAGE HANDLING**/
 /**
 * Round image borders depending on radius
 * @param string $source path or url of a valid[gif/jpeg/png] image -- enable php fopen url wrapper
 * @param int $radius corner radius in pixels, default is 10px
 * @param int[HEX FORMAT] $color corner color in rgb hex format -- default is FFFFFF(white)
 */
function curve($image, $radius = 10, $color = "FFFFFF")
{
    list($img_width, $img_height, $img_type) = getimagesize($image);
    switch($img_type){
        case IMAGETYPE_GIF:
            $img = imagecreatefromgif($image);
            break;
        case IMAGETYPE_PNG:
            $img = imagecreatefrompng($image);
            break;
        case IMAGETYPE_JPEG:
            $img = imagecreatefromjpeg($image);
            break;
    }
    /*****Mask for top-left corner in memory(variable)******/
    $corner_image = imagecreatetruecolor($radius, $radius);
    $clear_color = imagecolorallocate($corner_image, 0, 0, 0);
    $solid_color = imagecolorallocate($corner_image,
                                    hexdec(substr($color, 0, 2)),
                                    hexdec(substr($color, 2, 2)),
                                    hexdec(substr($color, 4, 2))
                                    );
    imagecolortransparent($corner_image, $clear_color);
    imagefill($corner_image, 0, 0, $solid_color);
    imagefilledellipse($corner_image, $radius, $radius, $radius * 2, $radius * 2, $clear_color);

    /******Create the top-left, top-right, bottom-left and bottom-right masks by rotating and copying the mask********/
    imagecopymerge($img, $corner_image, 0, 0, 0, 0, $radius, $radius, 100);
    $corner_image = imagerotate($corner_image, 90, 0);

    imagecopymerge($img, $corner_image, 0, $img_height - $radius, 0, 0, $radius, $radius, 100);
    $corner_image = imagerotate($corner_image, 90, 0);


    imagecopymerge($img, $corner_image, $img_width - $radius, $img_height - $radius, 0, 0, $radius, $radius, 100);
    $corner_image = imagerotate($corner_image, 90, 0);

    imagecopymerge($img, $corner_image, $img_width - $radius, 0, 0, 0, $radius, $radius, 100);
    imagepng($img, "http://localhost/internshub".$image.".png", 8);
}

function thumbnail($src, $def_width)
{
    $source_image = imagecreatefromjpeg($src);
    $width = imagesx($source_image);
    $height = imagesy($source_image);

    $def_height = floor($height * ($def_width/$width));
    $tmpImage = imagecreatetruecolor($def_width, $def_height);

    imagecopyresampled($tmpImage, $source_image, 0,0,0,0,$def_width, $def_height,$width, $height);
    $imgInfo = pathinfo($src);
    $imgFile = $imgInfo['basename'];
    imagejpeg($tmpImage, "images/thumbnails/".$imgFile, 80);
    return true;
}

function crop_image_square($source, $destination, $image_type, $square_size, $image_width, $image_height, $quality){
    if($image_width <= 0 || $image_height <= 0){return false;} //return false if nothing to resize

    if( $image_width > $image_height )
    {
        $y_offset = 0;
        $x_offset = ($image_width - $image_height) / 2;
        $s_size     = $image_width - ($x_offset * 2);
    }else{
        $x_offset = 0;
        $y_offset = ($image_height - $image_width) / 2;
        $s_size = $image_height - ($y_offset * 2);
    }
    $new_canvas = imagecreatetruecolor( $square_size, $square_size); //Create a new true color image

    //Copy and resize part of an image with resampling
    if(imagecopyresampled($new_canvas, $source, 0, 0, $x_offset, $y_offset, $square_size, $square_size, $s_size, $s_size)){
        save_image($new_canvas, $destination, $image_type, $quality);
    }

    return true;
}

##### Saves image resource to file #####
function save_image($source, $destination, $image_type, $quality){
    switch(strtolower($image_type)){//determine mime type
        case 'image/png':
            imagepng($source, $destination); return true; //save png file
            break;
        case 'image/gif':
            imagegif($source, $destination); return true; //save gif file
            break;
        case 'image/jpeg': case 'image/pjpeg':
        imagejpeg($source, $destination, $quality); return true; //save jpeg file
        break;
        default: return false;
    }
}

/**
* checks uploaded file to verify image
* @param FILE image
* @return bool if valid
*/
function is_image($data){
    $valid = array(IMAGETYPE_PNG, IMAGETYPE_JPEG, IMAGETYPE_GIF);
    $info = getimagesize($data);
    if(in_array($info[2], $valid)){
        return true;
    }else{
        return false;
    }
}


/**
 * basic file uploads
 * path to send image, file to upload, pad - basically to distinguish files,
 *legal types---ahan!!! See who fucking around
 * @param string $path Path to send image to
 * @param file $file
 * @param string pad
 * @param array $legalTypes
 * @return string  if successful
*/
function upload($path, $file, $pad, $legalTypes = array())
{
    $tmpName = $file['tmp_name'];
    $name = $file['name'];
    $size = $file['size'];
    $error = $file['error'];

    if(empty($legalTypes)){
        return "No restriction specified!";
    }

    if($error !== UPLOAD_ERR_OK){
        switch($error){
            case 1:
                return "Maximum file size exceeded *Set From Config*"; //Remove this please
            break;
            case 2:
                return "Ooops...Your file was too large";
            break;
            case 3:
                return "Error while uploading file";
            break;
            case 4:
                return "Empty file...!";
            break;
        }
    }

    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime = finfo_file($finfo, $tmpName);
    if(!in_array($mime, $legalTypes)){
        return "Invalid file!";
    }

    if($size > (1024*1000*5)){
        return "File too large";
    }

    $abc = move_uploaded_file($tmpName, $path.$name);
    if($abc) {
        $a = explode(".", $name);
        $ext = end($a);
            $newName = substr(md5($tmpName), 0, 10);
            $newName .= "-". $pad;
            $newName .= "." . $ext;
            rename($path . $name, $path . $newName);
            return array("main_name"=>$name, "new_name"=>$newName);
    }
    else{
        return false;
    }
}

function isPhoneNumber($data)
{
    $data = htmlspecialchars($data);
    
    /*$pattern = "/^\+?(\d{3}? ?\d{5,12})+$/"; //todo get this shit to work!
    if(!preg_match($pattern, $data)){
        return "Phone number is invalid";
    }*/
    return true;
}

function cleanUrl($url){
    return preg_replace('/[^a-z0-9]+/', '_', strtolower($url));
}

/*
 * formats a given dateTime based on the format
 */
function dateToYMD($date, $format = "Y/m/d"){
    try{
        $date = new DateTime($date);
        return $date->format($format);
    }
    catch(Exception $e){
        return false;
    }
}

/**
 * rejects a form submission based and display a message
 * the redirection is to prevent a page refresh from submitting form
 * @param string
 */
function bounce($msg){
    $_SESSION['error'] = $msg;
    header("location: {$_SERVER['REQUEST_URI']}");
}

/**returns an array of the current skill set in database
 * @param int|bool $id
 * @return array
 */
function getSkills($id = false){
    $conn = new PDO(DB_DSN, DB_USER, DB_PASS);
    if($id){
        $sql = "SELECT * FROM skills WHERE skill_id = $id";
    }
    else {
        $sql = "SELECT * FROM skills ORDER BY skill";
    }
    $st = $conn->prepare($sql);
    try{
        $st->execute();
        $cats = array();
        while($rs = $st->fetch(PDO::FETCH_ASSOC)){
            $cats[] = $rs;
        }
        return $cats;
    }
    catch(PDOException $e){
        return "Unable to retrieve skills. Please try later";
    }
}

/**
 * Gets the all occurrences of the img tag in a text and return the first instance
 * the returned text is the url of the img tag(if exists)
 * and should practically be placed in a valid html <img> tag
 * with the src attribute pointing to the returned value.
 * @param string
 * @return string
 */
function getFirstImage($text){
    preg_match('/< *img[^>]*src *= *["\']?([^"\']*)/i', $text, $img);
    return (count($img) > 0) ? $img[1] : "";
}

/**
 * Remove the img tag from a text. Mainly used for summaries
 * @param string $text to be cleaned
 * @return string a string free from image tags
 */
function stripImages($text){
    return preg_replace("/<img[^>]+\>/i", "", $text);
}

/**
 * generates a string as link for pagination
 * @param int
 * @param int
 * @param int
 * @param string
 * @param string
 * @param bool
 * @return string
 */
function generatePageLinks($limit = 10, $total, $currentPage = 1, $url, $getParameter = "page", $multipleGets = true){
    $lastPage = ceil($total/$limit);
    $pageCtrls = "";
    if($lastPage < 1){$lastPage = 1;}
    if($currentPage < 1){$currentPage = 1;}
    if($currentPage > $lastPage){$currentPage = $lastPage;}

    if($lastPage != 1) {
        if ($currentPage > 1) {
            $prev = $currentPage - 1;
            for ($i = $currentPage - 3; $i < $currentPage; $i++) {
                if ($i > 0) {
                    $pageCtrls .= "<a href='$url&amp;$getParameter=$i'>$i</a>";
                }
            }
        }
        $pageCtrls .= "<span>" . $currentPage . "&nbsp;</span>";
        for ($i = $currentPage + 1; $i <= $lastPage; $i++) {
            if ($i >= $currentPage += 4) {
                break;
            }
        }
        //allow the page parameter to be treated as the first get parameter too
        if(!$multipleGets){
            return $pageCtrls."<a href='$url?$getParameter=$i'>$i</a>";
        }
        else {
            return $pageCtrls."<a href='$url&$getParameter=$i'>$i</a>";
        }
    }
    else
        return "";
}
