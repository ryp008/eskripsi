<?php
class Ethesis {
    private $page;
    private $aksi;
    public static $pesan="";
    public function __construct() {
        $this->page = filter_input(INPUT_GET, "p", FILTER_SANITIZE_STRING);
        $this->aksi = filter_input(INPUT_GET, "x", FILTER_SANITIZE_STRING);
        if (empty($this->page) || $this->page == "Index" || $this->page == "index") {
            require "../controllers/HomeController.php";
            $controller = new HomeController();
                $controller->loadModel('Home');
            if (isset($this->aksi) && method_exists($controller, "action" . $this->aksi)) {
                $x = "action" . $this->aksi;
                $controller->$x();
            } else {
                $controller->index();
            }
        } else {
            $file = '../controllers/' . $this->page . "Controller.php";
            if (file_exists($file)) {

                // Jika File Ditemukan
                require '../controllers/' . $this->page . "Controller.php";
                $namacontroller = $this->page . "Controller";
                $controller = new $namacontroller();
                $controller->loadModel($this->page);
                //pemilihan method sesuai dengan aksi yang akan digunakan.
                if (isset($this->aksi) && method_exists($controller, "action" . $this->aksi)) {
                    $x = "action" . $this->aksi;
                    $controller->$x();
                } else {
                    $controller->index();
                }
            } else {
                //	Jika File Tidak Ditemukan kembalikan ke index
                require "../controllers/HomeController.php";
                $controller = new HomeController();
                $controller->loadModel('Home');
                $controller->index();
            }
        }
    }
    /**
    * Untuk menampilkan judul web, berdasarkan parameter page yang dipilih.
    * Jika yang dipanggil indek, maka judul web akan menampilkan daskboard
    */
    public static function getTitle(){
      $page="";
      if(filter_input(INPUT_GET, 'p')=="" || filter_input(INPUT_GET, 'p')=="Index" || filter_input(INPUT_GET, 'p')=="index" ):
        $page="Dashboard";
      else:
        $page=filter_input(INPUT_GET, 'p');
      endif;
      return $page;
    }
}
