<?php
$error = "";
$msg = "";
$tmp_portrait_name="";
$fileElementName = 'user_portrait_original';
if(!empty($_FILES[$fileElementName]['error']))
{
    switch($_FILES[$fileElementName]['error'])
    {

        case '1':
            $error = '上传图片文件过大，请不要超过2M';
            break;
        case '2':
            $error = 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form';
            break;
        case '3':
            $error = 'The uploaded file was only partially uploaded';
            break;
        case '4':
            $error = '请上传图片.';
            break;
        case '6':
            $error = 'Missing a temporary folder';
            break;
        case '7':
            $error = 'Failed to write file to disk';
            break;
        case '8':
            $error = 'File upload stopped by extension';
            break;
        case '999':
            $error = 'unknow';
            break;
        default:
            $error = 'No error code avaiable';
    }
}elseif(empty($_FILES['user_portrait_original']['tmp_name']) || $_FILES['user_portrait_original']['tmp_name'] == 'none')
{
    $error = "请上传文件.";
    echo "{";
    echo				"error: '" . $error . "'\n";
//    echo				"msg: '" . $msg . "'\n";
    echo "}";
    @unlink($_FILES['user_portrait_original']);
    exit;
}elseif($_FILES['user_portrait_original']['size']>2000000){
    $error.="too large file.";
    echo "{";
    echo				"error: '" . $error . "',\n";
    echo				"msg: '" . $msg . "'\n";
    echo "}";
    @unlink($_FILES['user_portrait_original']);
    exit;
}else{
    $file_name=$_FILES['user_portrait_original']['tmp_name'];
    $file=fopen($file_name,"rb");
    flock($file,LOCK_EX);
    $twoByte=fread($file,2);
    flock($file,LOCK_UN);
    fclose($file);
    $strInfo  = @unpack("C2chars", $twoByte);
    $typeCode = intval($strInfo['chars1'].$strInfo['chars2']);
    $fileType = '';
    switch ($typeCode)
    {
        case 255216:
            $fileType = 'jpg';
            break;
        case 7173:
            $fileType = 'gif';
            break;
        case 13780:
            $fileType = 'png';
            break;
        default:
            $fileType = '上传文件不是图片，请重新上传。';
            $error.=$fileType.$typeCode;
            echo "{";
            echo				"error: '" . $error . "'\n";
//            echo				"msg: '" . $msg . "',\n";
//            echo                "tmp: '" .$tmp_portrait_name."'\n";
            echo "}";
            @unlink($_FILES['user_portrait_original']);
            exit;
    }
//    $msg .= " File Name: " . $_FILES['user_portrait_original']['name'] . ", ";
//    $msg .= " File Size: " . @filesize($_FILES['user_portrait_original']['tmp_name']);
    //for security reason, we force to remove all uploaded file;
    $file_path="../../media/images/cache/";
    $rand=rand(0,999);
    $upload_portrait_name=$file_path.$_POST["UID"]."/".$rand."tmp.".$fileType;
    $tmp_portrait_name=$file_path.$_POST["UID"]."/".$rand.".".$fileType;
    array_map("unlink",array_filter(glob("../../media/images/cache/".$_POST["UID"]."/*"), "is_file"));
    move_uploaded_file($_FILES['user_portrait_original']['tmp_name'],$upload_portrait_name);
//    $tmp_pic=fopen($upload_portrait_name,"rb");
    switch ($fileType){
        case 'jpg':
            $img_old=imagecreatefromjpeg($upload_portrait_name);
            $arr=getimagesize($upload_portrait_name);
            $old_width=$arr[0];
            $old_height=$arr[1];
            $percent=round(800/$old_width,3);
            $new_width=800;
            $new_height=$old_height*$percent;
            $new_height=round($new_height);
            $img_new=imagecreatetruecolor($new_width,$new_height);
            imagecopyresampled($img_new,$img_old,0,0,0,0,$new_width,$new_height,$old_width,$old_height);
            imagejpeg($img_new,$tmp_portrait_name,100);
            break;
        case 'gif':
//            $imagick = new Imagick($upload_portrait_name);
//            $format = $imagick->getImageFormat();
//            if ($format == 'GIF') {
//                $imagick = $imagick->coalesceImages();
//                do {
//                    $imagick->resizeImage(120, 120, Imagick::FILTER_BOX, 1);
//                } while ($imagick->nextImage());
//                $imagick = $imagick->deconstructImages();
//                $imagick->writeImages($tmp_portrait_name, true);
//            }
//            $imagick->clear();
//            $imagick->destroy();
            break;
        case 'png':
            $img_old=imagecreatefrompng($upload_portrait_name);
            $arr=getimagesize($upload_portrait_name);
            $old_width=$arr[0];
            $old_height=$arr[1];
            $percent=round(800/$old_width);
            $new_width=800;
            $new_height=$old_height*$percent;
            $new_height=round($new_height);
            $img_new=imagecreatetruecolor($new_width,$new_height);
            $color=imagecolorallocate($img_new,255,255,255);  //上色
            imagecolortransparent($img_new,$color);           //设置透明
            imagefill($img_new,0,0,$color);                   //设置透明
            imagecopyresampled($img_new,$img_old,0,0,0,0,$new_width,$new_height,$old_width,$old_height);
            imagepng($img_new,$tmp_portrait_name,8);
            break;

    }
//    $img_old=imagecreatefromjpeg($upload_portrait_name);
//    $arr=getimagesize($upload_portrait_name);
//    $old_width=$arr[0];
//    $old_height=$arr[1];
//    $percent=round(1000/$old_width,3);
//    $new_width=1000;
//    $new_height=$old_height*$percent;
//    $img_new=imagecreatetruecolor($new_width,$new_height);
//    imagecopyresampled($img_new,$img_old,0,0,0,0,$new_width,$new_height,$old_width,$old_height);
//    $tmp_portrait_name=$file_path.$_POST["UID"]."_".$rand.".".$fileType;
//    imagejpeg($img_new,$tmp_portrait_name,100);
//    move_uploaded_file($_FILES['user_portrait_original']['tmp_name'],$tmp_portrait_name);
    if(!empty($_POST["portrait_tmp"])){
        @unlink($_POST["portrait_tmp"]);
    }
    @unlink($_FILES['user_portrait_original']);
    @unlink($upload_portrait_name);
}
$tmp_portrait_name=substr($tmp_portrait_name,3);
echo "{";
echo				"error: '" . $error . "',\n";
echo				"msg: '" . $msg . "',\n";
echo                "tmp: '" .$tmp_portrait_name."',\n";
echo                "type: '".$fileType."',\n";
echo                "height: '".$new_height."'\n ";
echo "}";
?>