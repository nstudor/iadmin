<?php
    require('cloudinary/autoload.php');
    
    \Cloudinary::config(array( 
      "cloud_name" => $fields[$k]['plugin']['cloud'], 
      "api_key" => $fields[$k]['plugin']['key'], 
      "api_secret" => $fields[$k]['plugin']['secret'] 
    ));
    
    \Cloudinary\Uploader::upload($crtPath.$fields[$k]['path'].$fileName, array("folder" => $fields[$k]['plugin']['path'], "public_id" =>$fileInfo['filename']));
    unlink($crtPath.$fields[$k]['path'].$fileName);
