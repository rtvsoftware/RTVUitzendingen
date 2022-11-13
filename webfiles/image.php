<?php
define('SYSTEM_DIR', './system');
require(SYSTEM_DIR.'/init.php');

if (!isset($_GET['id']))
exit;

$id = intval($_GET['id']);
if ($id == 0) exit;

$imageidfile = "id_".$id.".";
$imagefile = "";
foreach (scandir($images) as $f) {
    $len = strlen($imageidfile); 
    if (substr($f, 0, strlen($imageidfile)) == $imageidfile) {
        $imagefile = $images . $f;
    }
}

if (strlen($imagefile) == 0) {
    header('Content-Type: image/png');
    echo base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABAQMAAAAl21bKAAAAA1BMVEUAAACnej3aAAAAAXRSTlMAQObYZgAAAApJREFUCNdjYAAAAAIAAeIhvDMAAAAASUVORK5CYII=');
    exit();
}
$fp = fopen($imagefile, 'rb');

$image_info = getimagesize($imagefile);
switch ($image_info[2]) {
    case IMAGETYPE_JPEG:
        header("Content-Type: image/jpeg");
        break;
    case IMAGETYPE_GIF:
        header("Content-Type: image/gif");
        break;
    case IMAGETYPE_PNG:
        header("Content-Type: image/png");
        break;
    default:
        header($_SERVER["SERVER_PROTOCOL"] . " 500 Internal Server Error");
        break;
}

header('Content-Length: ' . filesize($imagefile));
fpassthru($fp);
exit;

  

