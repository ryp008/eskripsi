<?php

class TentangController extends Controller{

  public function __construct(){
    parent::__construct();
  }

  public function index(){
    $data['title'] = 'Tentang Skirpsi';
    $this->view->render("tentang/index", false, $data);
  }
}