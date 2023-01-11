<?php
  class MediaController extends CrudController{

    public function upload(){
        $accepted_origins = array("http://usites.com");

        echo json_encode(array('location' => "yyy.png"));
        exit();

        /*********************************************
         * Change this line to set the upload folder *
         *********************************************/
        $imageFolder = "images/";
      
        if (isset($_SERVER['HTTP_ORIGIN'])) {
          // same-origin requests won't set an origin. If the origin is set, it must be valid.
          if (in_array($_SERVER['HTTP_ORIGIN'], $accepted_origins)) {
            header('Access-Control-Allow-Origin: ' . $_SERVER['HTTP_ORIGIN']);
          } else {
            header("HTTP/1.1 403 Origin Denied");
            return;
          }
        }
      
        echo json_encode(array('location' => "yyy.png"));
        exit();
    }

  }
?>