<?php
/*
$postdata = file_get_contents('php://input');
$fp = fopen('./upload/' . $_GET['filename'], 'wb');
fwrite($fp, $postdata);
fclose($fp);
echo 'upload success.'
*/
?> 

<?php
/*
 * Author: Rohit Kumar
 * Date: 12-08-2014
 * Website: iamrohit.in
 * App Name: Ajax file uploader
 * Description: PHP + Ajax file uploader with progress bar
 */
error_reporting(0);
if (($_POST['del'] == 1) && (isset($_POST['del']))) {
    if (file_exists($_POST['filePath'])) {
        unlink($_POST['filePath']);
        $data = json_encode(array(
            'type' => 'success',
            'msg' => 'File deleted successfully.'
        ));
    } else {
        $data = json_encode(array(
            'type' => 'error',
            'msg' => 'Can not delete, File not exist.'
        ));
    }
    echo $data;
    exit;
} else {
    $allowFile = array(
        'image/png',
        'image/jpeg',
        'image/gif',
        'image/jpg'
    );
    $fileName = $_FILES["file"]["name"]; // iconv("gbk", "UTF-8", $_FILES["file"]["name"]);
    // echo $fileName;
    if (empty($fileName)) {
        echo $data = json_encode(array(
            'type' => 'error',
            'msg' => "Please choose file to upload."
        ));
        exit;
    }
    if (in_array($_FILES["file"]["type"], $allowFile)) {
        if ($_FILES["file"]["error"] > 0) {
            $data = json_encode(array(
                'type' => 'error',
                'msg' => "Return Code: " . $_FILES["file"]["error"]
            ));
        } else {
            $fileName = iconv("UTF-8", "gbk", $fileName);
            // echo iconv("UTF-8", "big5", $fileName);
            if (file_exists("upload/" . $fileName)) {
                $data = json_encode(array(
                    'type' => 'error',
                    'msg' => $fileName . " already exists. "
                ));
            } else {
                move_uploaded_file($_FILES["file"]["tmp_name"], "upload/" . $fileName);
                $data = json_encode(array(
                    'fileName' => $fileName,
                    'msg' => $fileName . " uploaded successfully.",
                    'type' => 'success'
                ));
            }
        }
    } else {
        $data = json_encode(array(
            'type' => 'error',
            'msg' => "Oh! Oh! Oh! Bad file type."
        ));
    }
    echo $data;
}

?> 