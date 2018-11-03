<?php
class Session{
  public function __construct() {
  }

  public static function start(){
    session_start();
  }
  public static function  end(){
   echo "<script>window.location.assign('?page=bappeda');</script>";
 }

  // public static function set($name=null, $value=null){
  //   if(isset($name) && isset($value)){
  //     $_SESSION['$name']=$value;
  //   }
  // }

 public static function set($data, $value = NULL)
 {
  if (is_array($data))
  {
    foreach ($data as $key => &$value)
    {
      $_SESSION[$key] = $value;
    }

    return;
  }

  return $_SESSION[$data] = $value;
}

public static function get($key =null){
  //return @$_SESSION[$key];
  return isset($_SESSION[$key]) ? $_SESSION[$key] : NULL;
  //return $_SESSION[$key];
}

// public static function hapus($name=null,$user=null){
//   unset($_SESSION['$name']);
//   unset($_SESSION['$user']);
//   self::start();
//   session_destroy();

// }

// public static function destroy()
// {
//   session_destroy();
// }

}
