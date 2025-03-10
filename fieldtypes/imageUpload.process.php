<?php
$size1 = filesize($tempName);

$crtPath = getcwd();

$im1 = imagecreatefromstring(file_get_contents($tempName));

if (!empty($fields[$k]['cropRatio'])) {
    $x = imagesx($im1);
    if ($x / $fields[$k]['cropRatio'] > imagesy($im1))
        $x = imagesy($im1) * $fields[$k]['cropRatio'];

    $y = $x / $fields[$k]['cropRatio'];

    $im2 = imagecreatetruecolor($x, $y);
    imagecopyresampled(
        $im2,
        $im1,
        0,
        0,
        (imagesx($im1) - $x) / 2,
        (imagesy($im1) - $y) / 2,
        $x,
        $y,
        $x,
        $y
    );
    imagedestroy($im1);
    $im1 = $im2;
}

if (!empty($fields[$k]['max'])) {
    if (imagesx($im1) < imagesy($im1))
        $fields[$k]['max-y'] = $fields[$k]['max'];
    else
        $fields[$k]['max-x'] = $fields[$k]['max'];
}
if (!empty($fields[$k]['min'])) {
    if (imagesx($im1) < imagesy($im1))
        $fields[$k]['max-x'] = $fields[$k]['min'];
    else
        $fields[$k]['max-y'] = $fields[$k]['min'];
}
$trim = 0;
if (!empty($fields[$k]['max-x'])) {
    $x = $fields[$k]['max-x'];
    $y = $x * imagesy($im1) / imagesx($im1);
    $trim = 1;
}
if (!empty($fields[$k]['max-y'])) {
    $y = $fields[$k]['max-y'];
    $x = $y * imagesx($im1) / imagesy($im1);
    $trim = 1;
}
if ($trim) {
    $im2 = imagecreatetruecolor($x, $y);
    imagecopyresampled($im2, $im1, 0, 0, 0, 0, imagesx($im2), imagesy($im2), imagesx($im1), imagesy($im1));
    imagedestroy($im1);
    $im1 = $im2;
}


$fileInfo = pathinfo($fileName);
$fileName = $fileInfo['filename'] . '.' . $fields[$k]['filetype'];
//    file_put_contents($fields[$k]['path'].$fileName, );
switch ($fields[$k]['filetype']) {
    case 'jpg':
        imagejpeg($im1, $crtPath . $fields[$k]['path'] . $fileName);
        break;
    case 'png':
        imagepng($im1, $crtPath . $fields[$k]['path'] . $fileName);
        break;
    case 'gif':
        imagegif($im1, $crtPath . $fields[$k]['path'] . $fileName);
        break;
    case 'webp':
        imagewebp($im1, $crtPath . $fields[$k]['path'] . $fileName);
        break;
    case 'wbmp':
        imagewbmp($im1, $crtPath . $fields[$k]['path'] . $fileName);
        break;
}
$size2 = filesize($crtPath . $fields[$k]['path'] . $fileName);
if ($size2 == 0) $MESSAGE = "Error saving file !";

if (is_array($fields[$k]['plugin'])) {
    include('imagePlugins/' . $fields[$k]['plugin']['name'] . '.php');
}
