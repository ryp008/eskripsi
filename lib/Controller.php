<?php
class Controller{
  public function __construct() {
    $this->view=new View();
  }
  public function loadModel($nama){
    $path="../models/".$nama.".php";
    if(file_exists($path)){
      require_once '../models/'.$nama.'.php';
      $namamodel=$nama;
      $this->model=new $namamodel;
    }
  }
  public function post($text){
    return filter_input(INPUT_POST, $text);
  }
  public function get($text){
    return filter_input(INPUT_GET, $text);
  }

  // Format tangal ke yyyy-mm-dd
  public function date_to_en($tanggal) {
    $tgl = date('Y-m-d', strtotime($tanggal));
    if ($tgl == '1970-01-01') {
        return '';
    } else {
        return $tgl;
    }
  }

// Format tangal ke dd-mm-yyyy
  public function date_to_id($tanggal) {
    $tgl = date('d-m-Y', strtotime($tanggal));
    if ($tgl == '01-01-1970') {
        return '';
    } else {
        return $tgl;
    }
  }
}
