<?php
class View{
    public function __construct() {
    }
    public function render($view, $noinclude=false,$data=null,$data2=null,$act=null){
      if(file_exists("../views/".$view.".php")){
      	if($noinclude){
          if($act=="report"){
            require_once './layout/header-report.php';
        	  require_once "../views/".$view.".php";
            require_once './layout/footer-report.php';
          }elseif($act == 'popup'){
            require_once './layout/header-popup.php';
            require_once "../views/".$view.".php";
            require_once './layout/footer-popup.php';
          }else{
            require_once './layout/header2.php';
            require_once "../views/".$view.".php";
            require_once './layout/footer2.php';
          }
      	}else{
          //include header
      	  require_once './layout/header2.php';
          //include contents
          require_once './layout/contents2.php';
      	  require_once '../views/'.$view.'.php';
          //include footer
      	  require_once './layout/footer2.php';
      	}
      }else{
      	include_once './layout/header2.php';
      	//include contents
        require_once './layout/contents2.php';
      	require_once '../views/error/error.php';
      	include_once './layout/footer2.php';
      }
    }
}
