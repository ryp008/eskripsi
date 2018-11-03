<?php
class MahasiswaController extends Controller{
  public function __construct()
  {
    parent::__construct();
  }

  public function islogin($level)
  {
    if(!Session::get('islogin')){
      echo "<script>window.location.assign('?p=index');</script>";
    }

      //cek level
    $sess_level = Session::get('level');
    $ceklevel = strpos($level, "$sess_level");
    return $ceklevel;
  }

  public function index()
  {
    //echo Session::get('level');
    $data['title'] = "<i class='fa fa-user-circle'></i> <b>Mahasiswa</b>";
    $data['sub_title'] = "<i class='fa fa-users'></i> <b>Data Mahasiswa</b>";
    if(!$this->islogin('01')){
      return $this->view->render('no-access',FALSE, $data);
    }

    $data['prodi'] = $this->model->getAll('programstudi', 'Kode, Prodi', null, 'Prodi ASC');
       // Cek apakah terdapat data page pada URL          
    $page = (!empty($this->get('page'))) ? $this->get('page') : 1;                    
      $limit = 20; // Jumlah data per halamannya                    
      // Untuk menentukan dari data ke berapa yang akan ditampilkan pada tabel yang ada di database
      $limit_start = ($page - 1) * $limit;

      $limit_data = $limit_start.",".$limit;

      $data['no'] = $limit_start + 1; // Untuk penomoran tabel

      //jika dilakukan pencarian
      $where ='';
      if(isset($_GET['prodi'])){
        $prodi = $this->get('prodi');
        $cari = $this->get('key');
        if($prodi == 'semua'){
          $text = $this->postTOstr($cari);
          if(!empty($text)){
            $where .= "  (mhsw.NIM LIKE '%".$text."%' or mhsw.Name LIKE '%".$text."%') ";
          }          
        }else{
          $where .= " programstudi.Kode ='".$prodi."' ";
          $text = $this->postTOstr($cari);

          if(!empty($text)){
            $where .= " and (mhsw.NIM LIKE '%".$text."%' or mhsw.Name LIKE '%".$text."%') ";
          }
        }
      }

      $join = 'inner join programstudi on programstudi.Kode = mhsw.KodeJurusan';
      
      $data['mhsw'] = $this->model->getAllJoin('mhsw', 
        'mhsw.ID, mhsw.NIM, mhsw.Name, programstudi.Prodi, mhsw.Email',
        $join, $where, 'mhsw.NIM, mhsw.Name asc', $limit_data);

      $data['page'] = $page;

      //cari semua jumlah 
      $Jdata = $this->model->getAllJoin('mhsw', "count(mhsw.NIM) as jml", $join, $where);
      //jika ada
      //if(!empty($jdata)){
      $get_jumlah = $Jdata[0]['jml'];
      $data['jumlah'] = $get_jumlah;
    //}else{
    //  $get_jumlah = 0;
    //}
      $data['jumlah_page'] = ceil($get_jumlah / $limit); 


      return $this->view->render('mahasiswa/index',FALSE,$data);
    }

  /**
  * method yg digunakan untuk menampilkan form untuk menambah data mahasiswa
  * ini hanya untuk menampilkan form kosong tanpa ada data dan parameter
  */

  public function actionTambah(){
   $data['title'] = "<i class='fa fa-user-circle'></i> <b>Mahasiswa</b>";
   $data['sub_title'] = "<i class='fa fa-user-plus'></i> <b>Tambah Mahasiswa</b>";
   if(!$this->islogin('01')){
    return $this->view->render('no-access',FALSE, $data);
  }

  $data['action'] = "?p=Mahasiswa&x=Tambah";
  $data['prodi'] = $this->model->getAll('programstudi', 'Kode, Prodi', null, 'Prodi ASC');


  if(isset($_POST['simpan'])){
    $data['input'] = array(
      'NIM'         => $this->post('NIM'),
      'Name'        => $this->post('Name'),
      'KodeJurusan' => $this->post('KodeJurusan'),
      'TglLahir'    => $this->post('TglLahir'),
      'TempatLahir' => $this->post('TempatLahir'),
      'Sex'         => $this->post('Sex'),
      'Phone'       => $this->post('Phone'),
      'Alamat1'     => $this->post('Alamat1'),
      'Email'       => $this->post('Email')
    );
    $NIM = $this->post('NIM');

    //cek username yg sama
    $cek2 = $this->model->getAll('mhsw', '*', "NIM='".$NIM."'");

    if(empty($cek2)){

      $data_insert = array(
        'Login'         => $NIM,
        'NIM'         => $NIM,
        'Name'        => $this->post('Name'),
        'KodeJurusan' => $this->post('KodeJurusan'),
        'TglLahir'    => $this->post('TglLahir'),
        'TempatLahir' => $this->post('TempatLahir'),
        'Sex'         => $this->post('Sex'),
        'Phone'       => $this->post('Phone'),
        'Alamat1'     => $this->post('Alamat1'),
        'Email'       => $this->post('Email')
      );
      $insert = $this->model->save('mhsw', $data_insert);
      if($insert){
        echo "<script>alert('Mahasiswa sudah ditambah');</script>
        <script>window.location.assign('?p=Mahasiswa');</script>";
      }else{
        echo "<script>alert('Mahasiswa sudah ditambah');</script>
        <script>window.location.assign('?p=Mahasiswa');</script>";
      }
    }else{
      $data['pesan'] ='NIM sudah ada.';  
    }
  }else{
    $data['input'] = array(
        'ID'          => '',
        'NIM'         =>'',
        'Name'        =>'',
        'KodeJurusan' =>'',
        'TglLahir'    =>'',
        'TempatLahir' =>'',
        'Sex'         =>'',
        'Phone'       =>'',
        'Alamat1'     =>'',
        'Email'       =>''
    );
  }
return $this->view->render('mahasiswa/form',FALSE,$data);

}

  /**
  * method untuk menampilkan form ubah data
  */

  public function actionUbah(){
   $data['title'] = "<i class='fa fa-user-circle'></i> <b>Mahasiswa</b>";
   $data['sub_title'] = "<i class='fa fa-users'></i> <b>Update Data Mahasiswa</b>";
   if(!$this->islogin('01')){
    return $this->view->render('no-access',FALSE, $data);
  }

  $data['action'] = "?p=Mahasiswa&x=Ubah";
  $data['prodi'] = $this->model->getAll('programstudi', 'Kode, Prodi', null, 'Prodi ASC');


  if(isset($_POST['simpan'])){
    $data['input'] = array(
      'NIM'         => $this->post('NIM'),
      'Name'        => $this->post('Name'),
      'KodeJurusan' => $this->post('KodeJurusan'),
      'TglLahir'    => $this->post('TglLahir'),
      'TempatLahir' => $this->post('TempatLahir'),
      'Sex'         => $this->post('Sex'),
      'Phone'       => $this->post('Phone'),
      'Alamat1'     => $this->post('Alamat1'),
      'Email'       => $this->post('Email')
    );
    $ID = $this->post('ID');
    $NIM = $this->post('NIM');

    //cek username yg sama
    $cek1 = $this->model->getAll('mhsw', '*', "NIM='".$NIM."' and ID ='".$ID."'");
    $cek2 = $this->model->getAll('mhsw', '*', "NIM='".$NIM."'");

    if((!empty($cek1) and !empty($cek1)) or (empty($cek1) and empty($cek2))){

      $data_update = array(
        'NIM'         => $NIM,
        'Name'        => $this->post('Name'),
        'KodeJurusan' => $this->post('KodeJurusan'),
        'TglLahir'    => $this->post('TglLahir'),
        'TempatLahir' => $this->post('TempatLahir'),
        'Sex'         => $this->post('Sex'),
        'Phone'       => $this->post('Phone'),
        'Alamat1'     => $this->post('Alamat1'),
        'Email'       => $this->post('Email')
      );
      $update = $this->model->edit('mhsw', $data_update, "ID ='".$ID."'");
      if($update){
        echo "<script>alert('Mahasiswa sudah diedit');</script>
        <script>window.location.assign('?p=Mahasiswa');</script>";
      }else{
        echo "<script>window.location.assign('?p=Mahasiswa');</script>";
      }
    }else{
      $data['pesan'] ='NIM sudah ada.';  
    }
  }else{ 

    $ID = $this->get('id');
    $mhsw = $this->model->getAll('mhsw', '*', "ID='".$ID."'");
    if(empty($mhsw)){
     echo "<script>alert('Data tidak ditemukan');</script>
     <script>window.location.assign('?p=Mahasiswa');</script>";
   }

   foreach ($mhsw as $value) {
    $data['input'] =$value;
  }
}

return $this->view->render('mahasiswa/form',FALSE,$data);
}

  /*
  * method untuk menyimpan data ke tabel pdp_mhsw
  */
  public function actionSimpan(){
    $this->model->save(
      array(
        "nim"=>$this->post("nim"),
        "nim_enkripsi"=>md5($this->post('nim')),
        "namalengkap"=>$this->post("nama"),
        "email"=>$this->post("email"),
        "alamat"=>$this->post("alamat")
      ),"Mahasiswa"
    );
  }

  /**
  * method untuk mengubah data
  *
  */

  public function actionUpdate(){
    $this->model->edit(
      array(
        "namalengkap"=>$this->post('nama'),
        "email"=>$this->post('email'),
        "alamat"=>$this->post('alamat')
      ),"nim=".$this->post('nim'),"Mahasiswa"
    );
  }


  /**
  * method untuk menghapus data
  */
  public function actionHapus(){
    $this->model->delete(
      array(
        "ID"=> $this->get('id')
      ),"Mahasiswa"
    );
  }

  /**
  * method untuk lihat detail
  */

  public function actionDetail(){
    $data['title'] = "<i class='fa fa-user-circle'></i> <b>Mahasiswa</b>";
    $data['sub_title'] = "<i class='fa fa-users'></i> <b>Data Mahasiswa</b>";
    if(!$this->islogin('01')){
      return $this->view->render('no-access',FALSE, $data);
    }else{
      $ID = $this->get('id');
      $select =  "mhsw.ID, mhsw.NIM, mhsw.Name, mhsw.Alamat1, mhsw.Phone, mhsw.Sex, mhsw.TglLahir, mhsw.TempatLahir, programstudi.Prodi, mhsw.Email";
      $join = "inner join programstudi on programstudi.Kode = mhsw.KodeJurusan";
      $where =" mhsw.ID ='".$ID."'";
      $data['row'] = $this->model->getAllJoin('mhsw', $select, $join, $where);
      if(empty($data['row']))
      {
       echo "<script>alert('Data tidak ditemukan');</script>
       <script>window.location.assign('?p=Mahasiswa');</script>";
     }
     return $this->view->render('mahasiswa/detail',FALSE,$data);
   }
 }

 public function actionmahasiswaaktif()
 {
  $data['title'] = "<i class='fa fa-users'></i> <b>Mahasiswa</b>";
  $data['sub_title'] = "<i class='fa fa-users'> </i>  <b>Mahasiswa Aktif Skripsi</b>";
  if(!$this->islogin('01234')){
    return $this->view->render('no-access',FALSE, $data);
  }else{

    $data['ta'] = $this->model->getAll('tbl_ta', '*');

    $where =' ';
    $where .= " tbl_aktivasi_mhs.Status ='1' ";
    $tahun = $this->get('tahun');
    if($tahun == 'semua' || $tahun == ''){
      $where .= ' ';
    }else{
     $where .= " and tbl_aktivasi_mhs.Tahun = '".$tahun."' ";
   }
   $prodi = $this->get('prodi');
   if($prodi == 'semua' || $prodi == ''){
    $where .= ' ';
  }else{
   $where .= " and  mhsw.KodeJurusan ='".$prodi."'";
 }

 $select = "mhsw.NIM, mhsw.Name, mhsw.KodeJurusan, tbl_aktivasi_mhs.*";
 $join = "inner join tbl_ta on tbl_ta.kode = tbl_aktivasi_mhs.Tahun
 inner join mhsw on mhsw.NIM = tbl_aktivasi_mhs.NIM";
 $order = "tbl_aktivasi_mhs.Tahun, tbl_aktivasi_mhs.TglAktif ASC";

 $data['mhs_aktif'] = $this->model->getMhswAktif($select, $join, $where, $order);

 return $this->view->render('mahasiswa/list_aktif', false, $data);
}
}

public function actionaktifkanmhsw()
{
  $data['title'] = "<i class='fa fa-users'></i> <b>Mahasiswa</b>";
  $data['sub_title'] = "<i class='fa fa-user-plus'> </i>  <b>Aktivasi Akun Mahasiswa</b>";

  if(!$this->islogin('01')){
    return $this->view->render('no-access',FALSE, $data);
  }

  $data['ta'] = $this->model->getAll('tbl_ta', '*', "aktif = 'Y'", "id_ta DESC", 1);

  if(isset($_GET['go'])){

    $where ='';
    $where .= " mhsw.NIM NOT IN (select NIM from tbl_aktivasi_mhs) ";

    $tombol = $this->get('go');
    if($tombol == 'filter'){
      if(!empty($this->get('cari'))){
        $where .= " and mhsw.KodeProgram ='".$this->get('cari')."' ";
      }
    }

    $select = " mhsw.NIM, mhsw.Name, mhsw.KodeJurusan, mhsw.KodeProgram, mhsw.TglLahir ";
    $order = " mhsw.Name ASC ";

    $data['mhsw'] = $this->model->getMhsw($select, $where, $order);
  }

  return $this->view->render('mahasiswa/form-aktif-mhsw', false, $data);

}

public function actionaktifkan()
{
  if(!$this->islogin('01')){
    return $this->view->render('no-access',FALSE, $data);
  }

  if(isset($_POST['aktifkan'])){
    $data = $_POST['pilih'];
    $jumlah = count($data);

    for ($i = 0; $i < $jumlah; $i++) {
        //cek apakah sudah aktif.
      $cekaktif = $this->model->getAll('tbl_aktivasi_mhs','tbl_aktivasi_mhs.*, count(NIM) as ada', "NIM = '".$data[$i]."'", null, 1);
      if($cekaktif[0]['ada'] < 1){
          //jika tidak ada maka insert ke tabel aktivasi mhsw.
        $rows = array('NIM' => $data[$i], 'Status' =>1, 'TglAktif' => date('Y-m-d H:s:i'), 'Tahun' => $this->post('ta'));
        $insert = $this->model->saveloop('tbl_aktivasi_mhs', $rows);
      }
    }

    echo "<script>window.location.assign('?p=Mahasiswa&x=aktifkanmhsw');</script>";

  }else{
    echo "<script>window.location.assign('?p=Mahasiswa&x=aktifkanmhsw');</script>";

  }
}

public function postTOstr($string){
  return preg_replace("/[^a-zA-Z0-9. ,]/", "", $string);
}

}
