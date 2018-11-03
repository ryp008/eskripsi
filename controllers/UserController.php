<?php

class UserController extends Controller{

  public function __construct(){
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

  public function index($pesan = null){
    $data['pesan'] = $pesan;
    $data['title'] = 'Login Skripsi';
    $this->view->render("user/index", false, $data);
  }

  public function actionLogin(){

    if(isset($_POST['submit'])){
      $username = $this->post('TextUser');
      $password = $this->post('TextPass');

    //cek user admin, ka. prodi dan biro
      $admin = $this->model->cekAdmin($username, $password);
      if(!empty($admin)){
        //set session

       $set_session =array(
        'id_user'  => $admin[0]['id'],
        'username' => $admin[0]['user_name'],
        'level'    => $admin[0]['level'],
        'name'     => $admin[0]['nama'],
        'prodi'    => $admin[0]['prodi'],
        'islogin'  => true
      );
       Session::set($set_session);
       echo "<script>window.location.assign('?p=index');</script>";

     }else{
      //cek login mahasiswa
      $mhsw = $this->model->LoginDosenMhsw('mhsw', $username, $password);
      if(!empty($mhsw)){
        $NIM = $mhsw[0]['NIM'];
          //hanya mahasiswa yang sudah aktif yang dapat masuk ke skripsi
        $aktif = $this->model->cekAktif($NIM);
        if(!empty($aktif)){
          $set_session =array(
            'id_user'  => $mhsw[0]['ID'],
            'username' => $mhsw[0]['Login'],
            'level'    => 5,
            'name'     => $mhsw[0]['Name'],
            'prodi'    => $mhsw[0]['KodeJurusan'],
            'islogin'  => true
          );
          Session::set($set_session);
          echo "<script>window.location.assign('?p=index');</script>";

        }else{            
          echo "<script>alert('akun anda belum aktif. silahkan hubungi prodi');
          window.location.assign('?p=User');</script>";
        }
      }else{
        //cek login dosen
        $dosen = $this->model->LoginDosenMhsw('dosen', $username, $password);
        if(!empty($dosen)){
          $set_session =array(
            'id_user'  => $dosen[0]['ID'],
            'username' => $dosen[0]['Login'],
            'level'    => 4,
            'name'     => $dosen[0]['Name'].", ".$dosen[0]['Gelar'],
            'prodi'    => 'all',
            'islogin'  => true
          );
          Session::set($set_session);
          echo "<script>window.location.assign('?p=index');</script>";
        }else{
          $pesan = 'Username dan password salah.';
          $this->index($pesan);
        }
      }
    }
  }else{
    echo "<script>window.location.assign('?p=User');</script>";
  }

}

public function actionAdmin()
{
  $data['title'] = "<i class='fa fa-user-circle'></i> <b>User Skripsi</b>";
  $data['sub_title'] = "<strong> <i class='fa fa-user' aria-hidden></i> User Administrator</strong>";
  if(!$this->islogin('01')){
      return $this->view->render('no-access',FALSE, $data);
    }

  $data['user'] = $this->model->getAll('tbl_user', '*', "level =1");

  return $this->view->render('user/user-admin',FALSE,$data); 
}

public function actionProdi()
{
  $data['title'] = "<i class='fa fa-user-circle'></i> <b>User Skripsi</b>";
  $data['sub_title'] = "<strong> <i class='fa fa-user' aria-hidden></i> User Program Studi</strong>";
  if(!$this->islogin('01')){
      return $this->view->render('no-access',FALSE, $data);
    }

  $data['user'] = $this->model->getAll('tbl_user', '*', "level =2");

  return $this->view->render('user/user-prodi',FALSE,$data); 
}

public function actionBiro()
{
  $data['title'] = "<i class='fa fa-user-circle'></i> <b>User Skripsi</b>";
  $data['sub_title'] = "<strong> <i class='fa fa-user' aria-hidden></i> User Biro Akademik</strong>";
  if(!$this->islogin('01')){
      return $this->view->render('no-access',FALSE, $data);
    }

  $data['user'] = $this->model->getAll('tbl_user', '*', "level =3");

  return $this->view->render('user/user-biro',FALSE,$data); 

}

public function actionDosen()
{
 $data['title'] = "<i class='fa fa-user-circle'></i> <b>User Skripsi</b>";
  $data['sub_title'] = "<strong> <i class='fa fa-user' aria-hidden></i> User Dosen</strong>";
  if(!$this->islogin('01')){
      return $this->view->render('no-access',FALSE, $data);
    }

  $data['user'] = $this->model->getAll('dosen', 'ID, Name, Login, Gelar, Email, NotActive', null, "Name ASC");

  return $this->view->render('user/user-dosen',FALSE,$data); 

}

public function actionMhsw()
{
  $data['title'] = "<i class='fa fa-user-circle'></i> <b>User Skripsi</b>";
  $data['sub_title'] = "<strong> <i class='fa fa-user' aria-hidden></i> User Mahasiswa</strong>";
  if(!$this->islogin('01')){
      return $this->view->render('no-access',FALSE, $data);
    }

  $data['user'] = $this->model->getAll('mhsw', 'ID, NIM, Name, Login, Email, NotActive', null, "NIM, Name ASC");

  return $this->view->render('user/user-mhsw',FALSE,$data); 

}

public function actionTambahAdmin()
{
  $data['title'] = "<i class='fa fa-user-circle'></i> <b>User Skripsi</b>";
  $data['sub_title'] = "<strong> <i class='fa fa-user-plus' aria-hidden></i>Tambah User Administrator</strong>";
  if(!$this->islogin('01')){
      return $this->view->render('no-access',FALSE, $data);
    }

  $data['action'] = "?p=User&x=TambahAdmin";

 $data['pesan'] = '';
  if(isset($_POST['simpan'])){
    $data['input'] = array(
      'id' => '',
      'user_name' => $this->post('user_name'),
      'nama'      => $this->post('nama'),
      'password'  => $this->post('password'),
      'level'     => 1,
      'email'     => $this->post('email'),
      'aktif'     => $this->post('aktif')
    );
      //cek username yg sama
    $cek = $this->model->getAll('tbl_user', '*', "user_name='".$this->post('user_name')."'");
      //echo  count($cek);
    if(empty($cek)){
      $data_input = array(
        'user_name' => $this->post('user_name'),
        'password'  => md5($this->post('password')),
        'level'     => 1,
        'nama'      => $this->post('nama'),
        'email'     => $this->post('email'),
        'aktif'     => $this->post('aktif') == '' ? 'Y' : $this->post('aktif')
      );

      $insert  = $this->model->save('tbl_user', $data_input);
      if($insert){
       echo "<script>alert('Sudah disimpan');</script>
       <script>window.location.assign('?p=User&x=Admin');</script>";
     }else{
      echo "<script>alert('Gagal disimpan');</script>
      <script>window.location.assign('?p=User&x=Admin');</script>";
    }
  }else{
    $data['pesan'] ='Username sudah ada.';
  }

}else{
  $data['input'] = array(
    'id' => '',
    'user_name' => '',
    'nama'      => '',
    'password'  => '',
    'pwdlama'   => '',
    'level'     => '1',
    'email'     => '',
    'aktif'     => ''
  );
}
return $this->view->render('user/form-admin',FALSE,$data); 
}

public function actionTambahProdi()
{
  $data['title'] = "<i class='fa fa-user-circle'></i> <b>User Skripsi</b>";
  $data['sub_title'] = "<strong> <i class='fa fa-user-plus' aria-hidden></i>Tambah User Program Studi</strong>";
  if(!$this->islogin('01')){
      return $this->view->render('no-access',FALSE, $data);
    }

  $data['action'] = "?p=User&x=TambahProdi";

  $data['prodi'] = $this->model->getAll('programstudi', 'Kode, Prodi', null, 'Prodi asc');
  $data['pesan'] = '';
  if(isset($_POST['simpan'])){
    $data['input'] = array(
      'id' => '',
      'user_name' => $this->post('user_name'),
      'nama'      => $this->post('nama'),
      'password'  => $this->post('password'),
      'level'     => 2,
      'prodi'     => $this->post('prodi'),
      'email'     => $this->post('email'),
      'aktif'     => $this->post('aktif')
    );
      //cek username yg sama
    $cek = $this->model->getAll('tbl_user', '*', "user_name='".$this->post('user_name')."'");
      //echo  count($cek);
    if(empty($cek)){
      $data_input = array(
        'user_name' => $this->post('user_name'),
        'password'  => md5($this->post('password')),
        'level'     => 2,
        'nama'      => $this->post('nama'),
        'prodi'     => $this->post('prodi'),
        'email'     => $this->post('email'),
        'aktif'     => $this->post('aktif') == '' ? 'Y' : $this->post('aktif')
      );

      $insert  = $this->model->save('tbl_user', $data_input);
      if($insert){
       echo "<script>alert('Sudah disimpan');</script>
       <script>window.location.assign('?p=User&x=Prodi');</script>";
     }else{
      echo "<script>alert('Gagal disimpan');</script>
      <script>window.location.assign('?p=User&x=Prodi');</script>";
    }
  }else{
    $data['pesan'] ='Username sudah ada.';
  }

}else{
  $data['input'] = array(
    'id' => '',
    'user_name' => '',
    'nama'      => '',
    'password'  => '',
    'pwdlama'   => '',
    'level'     => '2',
    'prodi'     => '',
    'email'     => '',
    'aktif'     => ''
  );
}
return $this->view->render('user/form-prodi',FALSE,$data); 
}

public function actionTambahBiro()
{
  $data['title'] = "<i class='fa fa-user-circle'></i> <b>User Skripsi</b>";
  $data['sub_title'] = "<strong> <i class='fa fa-user-plus' aria-hidden></i>Tambah User Biro Akademik</strong>";
  if(!$this->islogin('01')){
      return $this->view->render('no-access',FALSE, $data);
    }

  $data['action'] = "?p=User&x=TambahBiro";
  $data['pesan'] = '';
  if(isset($_POST['simpan'])){
    $data['input'] = array(
      'id' => '',
      'user_name' => $this->post('user_name'),
      'nama'      => $this->post('nama'),
      'password'  => $this->post('password'),
      'level'     => 3,
      'email'     => $this->post('email'),
      'aktif'     => $this->post('aktif')
    );
      //cek username yg sama
    $cek = $this->model->getAll('tbl_user', '*', "user_name='".$this->post('user_name')."'");
      //echo  count($cek);
    if(empty($cek)){
      $data_input = array(
        'user_name' => $this->post('user_name'),
        'password'  => md5($this->post('password')),
        'level'     => 3,
        'nama'      => $this->post('nama'),
        'email'     => $this->post('email'),
        'aktif'     => $this->post('aktif') == '' ? 'Y' : $this->post('aktif')
      );

      $insert  = $this->model->save('tbl_user', $data_input);
      if($insert){
       echo "<script>alert('Sudah disimpan');</script>
       <script>window.location.assign('?p=User&x=Biro');</script>";
     }else{
      echo "<script>alert('Gagal disimpan');</script>
      <script>window.location.assign('?p=User&x=Biro');</script>";
    }
  }else{
    $data['pesan'] ='Username sudah ada.';
  }

}else{
  $data['input'] = array(
    'id' => '',
    'user_name' => '',
    'nama'      => '',
    'password'  => '',
    'pwdlama'   => '',
    'level'     => '3',
    'prodi'     => '',
    'email'     => '',
    'aktif'     => ''
  );
}
return $this->view->render('user/form-biro',FALSE,$data); 
}

public function actionEditProdi()
{
  $data['title'] = "<i class='fa fa-user-circle'></i> <b>User Skripsi</b>";
  $data['sub_title'] = "<strong> <i class='fa fa-edit' aria-hidden></i>Edit User Program Studi</strong>";
  if(!$this->islogin('01')){
      return $this->view->render('no-access',FALSE, $data);
    }

  $data['prodi'] = $this->model->getAll('programstudi', 'Kode, Prodi', null, 'Prodi asc');
  $data['action'] = "?p=User&x=EditProdi";
  $data['pesan'] = '';
  if(isset($_POST['simpan'])){
    $data['input'] = array(
      'id' => $this->post('id'),
      'user_name' => $this->post('user_name'),
      'nama'      => $this->post('nama'),
      'pwdlama'  => $this->post('pwdlama'),
      'password' => $this->post('password'),
      'level'     => 2,
      'prodi'     => $this->post('prodi'),
      'email'     => $this->post('email'),
      'aktif'     => $this->post('aktif')
    );
    $ID = $this->post('id');
    $username = $this->post('user_name');
      //cek username yg sama
    $cek1 = $this->model->getAll('tbl_user', '*', "user_name='".$username."' and id ='".$ID."'");
    $cek2 = $this->model->getAll('tbl_user', '*', "user_name='".$this->post('user_name')."'");
      
    if((!empty($cek1) and !empty($cek1)) or (empty($cek1) and empty($cek2))){

      $password = $this->post('password');
      $pwdlama = $this->post('pwdlama');

      if(empty($password)){
        $pwd = $pwdlama;
      }else{
        $pwd = md5($password);
      }
      $data_update = array(
        'user_name' => $this->post('user_name'),
        'nama'      => $this->post('nama'),
        'password'  => $pwd,
        'prodi'     => $this->post('prodi'),
        'email'     => $this->post('email'),
        'aktif'     => $this->post('aktif') == '' ? 'Y' : $this->post('aktif')
      );
      $update = $this->model->edit('tbl_user', $data_update, "id ='".$ID."'");
      if($update){
       echo "<script>alert('Sudah diubah');</script>
       <script>window.location.assign('?p=User&x=Prodi');</script>";
     }else{
      echo "<script>window.location.assign('?p=User&x=Prodi');</script>";
    }

    }else{
      $data['pesan'] ='username sudah ada.';
    }

  }else{
    $ID = $this->get('id');
    $user = $this->model->getAll('tbl_user', 'tbl_user.*, tbl_user.password as pwdlama', "id='".$ID."' and level=2");
    
    if(empty($user)){
      echo "<script>alert('Data tidak ditemukan');</script>
      <script>window.location.assign('?p=User&x=Prodi');</script>";
    }
    foreach ($user as $value) {
      $data['input'] =$value;
    }
  }
  return $this->view->render('user/form-prodi',FALSE,$data); 
}

public function actionProfilProdi()
{
  $data['title'] = "<i class='fa fa-user-circle'></i> <b>User Skripsi</b>";
  $data['sub_title'] = "<strong> <i class='fa fa-edit' aria-hidden></i>Edit User Program Studi</strong>";
  if(!$this->islogin('012')){
      return $this->view->render('no-access',FALSE, $data);
    }

  $data['prodi'] = $this->model->getAll('programstudi', 'Kode, Prodi', null, 'Prodi asc');
  $data['action'] = "?p=User&x=ProfilProdi";
  $data['pesan'] = '';
  if(isset($_POST['simpan'])){
    $data['input'] = array(
      'id' => $this->post('id'),
      'user_name' => $this->post('user_name'),
      'nama'      => $this->post('nama'),
      'pwdlama'  => $this->post('pwdlama'),
      'password' => $this->post('password'),
      'level'     => 2,
      'prodi'     => $this->post('prodi'),
      'email'     => $this->post('email'),
      'aktif'     => $this->post('aktif')
    );
    $ID = $this->post('id');
    $username = $this->post('user_name');
      //cek username yg sama
    $cek1 = $this->model->getAll('tbl_user', '*', "user_name='".$username."' and id ='".$ID."'");
    $cek2 = $this->model->getAll('tbl_user', '*', "user_name='".$this->post('user_name')."'");
      
    if((!empty($cek1) and !empty($cek1)) or (empty($cek1) and empty($cek2))){

      $password = $this->post('password');
      $pwdlama = $this->post('pwdlama');

      if(empty($password)){
        $pwd = $pwdlama;
      }else{
        $pwd = md5($password);
      }
      $data_update = array(
        'user_name' => $this->post('user_name'),
        'nama'      => $this->post('nama'),
        'password'  => $pwd,
        'prodi'     => $this->post('prodi'),
        'email'     => $this->post('email'),
        'aktif'     => $this->post('aktif') == '' ? 'Y' : $this->post('aktif')
      );
      $update = $this->model->edit('tbl_user', $data_update, "id ='".$ID."'");
      if($update){
       echo "<script>alert('Sudah diubah');</script>
       <script>window.location.assign('?p=User&x=ProfilProdi');</script>";
     }else{
      echo "<script>window.location.assign('?p=User&x=ProfilProdi');</script>";
    }

    }else{
      $data['pesan'] ='username sudah ada.';
    }

  }else{
    $ID = Session::get('id_user');//$this->get('id');
    $user = $this->model->getAll('tbl_user', 'tbl_user.*, tbl_user.password as pwdlama', "id='".$ID."' and level=2");
    
    if(empty($user)){
      echo "<script>alert('Data tidak ditemukan');</script>
      <script>window.location.assign('?p=Index');</script>";
    }
    foreach ($user as $value) {
      $data['input'] =$value;
    }
  }
  return $this->view->render('user/form-prodi',FALSE,$data); 
}

public function actionEditAdmin()
{
  $data['title'] = "<i class='fa fa-user-circle'></i> <b>User Skripsi</b>";
  $data['sub_title'] = "<strong> <i class='fa fa-edit' aria-hidden></i>Edit User Administrator</strong>";
  if(!$this->islogin('01')){
      return $this->view->render('no-access',FALSE, $data);
    }

 $data['action'] = "?p=User&x=EditAdmin";
  $data['pesan'] = '';
  if(isset($_POST['simpan'])){
    $data['input'] = array(
      'id' => $this->post('id'),
      'user_name' => $this->post('user_name'),
      'nama'      => $this->post('nama'),
      'pwdlama'  => $this->post('pwdlama'),
      'password' => $this->post('password'),
      'level'     => 1,
      'email'     => $this->post('email'),
      'aktif'     => $this->post('aktif')
    );
    $ID = $this->post('id');
    $username = $this->post('user_name');
      //cek username yg sama
    $cek1 = $this->model->getAll('tbl_user', '*', "user_name='".$username."' and id ='".$ID."'");
    $cek2 = $this->model->getAll('tbl_user', '*', "user_name='".$this->post('user_name')."'");
      
    if((!empty($cek1) and !empty($cek1)) or (empty($cek1) and empty($cek2))){

      $password = $this->post('password');
      $pwdlama = $this->post('pwdlama');

      if(empty($password)){
        $pwd = $pwdlama;
      }else{
        $pwd = md5($password);
      }
      $data_update = array(
        'user_name' => $this->post('user_name'),
        'nama'      => $this->post('nama'),
        'password'  => $pwd,
        'email'     => $this->post('email'),
        'aktif'     => $this->post('aktif') == '' ? 'Y' : $this->post('aktif')
      );
      $update = $this->model->edit('tbl_user', $data_update, "id ='".$ID."'");
      if($update){
       echo "<script>alert('Sudah diubah');</script>
       <script>window.location.assign('?p=User&x=Admin');</script>";
     }else{
      echo "<script>window.location.assign('?p=User&x=Admin');</script>";
    }

    }else{
      $data['pesan'] ='username sudah ada.';
    }

  }else{
    $ID = $this->get('id');
    $user = $this->model->getAll('tbl_user', 'tbl_user.*, tbl_user.password as pwdlama', "id='".$ID."' and level =1");
    
    if(empty($user)){
      echo "<script>alert('Data tidak ditemukan');</script>
      <script>window.location.assign('?p=User&x=Admin');</script>";
    }
    foreach ($user as $value) {
      $data['input'] =$value;
    }
  }
  return $this->view->render('user/form-admin',FALSE,$data); 
}


public function actionEditBiro()
{
  $data['title'] = "<i class='fa fa-user-circle'></i> <b>User Skripsi</b>";
  $data['sub_title'] = "<strong> <i class='fa fa-edit' aria-hidden></i>Edit User Biro Akademik</strong>";
  if(!$this->islogin('01')){
      return $this->view->render('no-access',FALSE, $data);
    }

  $data['action'] = "?p=User&x=EditBiro";
  $data['pesan'] = '';
  if(isset($_POST['simpan'])){
    $data['input'] = array(
      'id' => $this->post('id'),
      'user_name' => $this->post('user_name'),
      'nama'      => $this->post('nama'),
      'pwdlama'  => $this->post('pwdlama'),
      'password' => $this->post('password'),
      'level'     => 2,
      'email'     => $this->post('email'),
      'aktif'     => $this->post('aktif')
    );
    $ID = $this->post('id');
    $username = $this->post('user_name');
      //cek username yg sama
    $cek1 = $this->model->getAll('tbl_user', '*', "user_name='".$username."' and id ='".$ID."'");
    $cek2 = $this->model->getAll('tbl_user', '*', "user_name='".$this->post('user_name')."'");
      
    if((!empty($cek1) and !empty($cek1)) or (empty($cek1) and empty($cek2))){

      $password = $this->post('password');
      $pwdlama = $this->post('pwdlama');

      if(empty($password)){
        $pwd = $pwdlama;
      }else{
        $pwd = md5($password);
      }
      $data_update = array(
        'user_name' => $this->post('user_name'),
        'nama'      => $this->post('nama'),
        'password'  => $pwd,
        'email'     => $this->post('email'),
        'aktif'     => $this->post('aktif') == '' ? 'Y' : $this->post('aktif')
      );
      $update = $this->model->edit('tbl_user', $data_update, "id ='".$ID."'");
      if($update){
       echo "<script>alert('Sudah diubah');</script>
       <script>window.location.assign('?p=User&x=Biro');</script>";
     }else{
      echo "<script>window.location.assign('?p=User&x=Biro');</script>";
    }

    }else{
      $data['pesan'] ='username sudah ada.';
    }

  }else{
    $ID = $this->get('id');
    $user = $this->model->getAll('tbl_user', 'tbl_user.*, tbl_user.password as pwdlama', "id='".$ID."' and level=3");
    if(empty($user)){
      echo "<script>alert('Data tidak ditemukan');</script>
      <script>window.location.assign('?p=User&x=Biro');</script>";
    }
    foreach ($user as $value) {
      $data['input'] =$value;
    }
  }
  return $this->view->render('user/form-biro',FALSE,$data); 
}

public function actionProfilBiro()
{
  $data['title'] = "<i class='fa fa-user-circle'></i> <b>User Skripsi</b>";
  $data['sub_title'] = "<strong> <i class='fa fa-edit' aria-hidden></i>Edit User Biro Akademik</strong>";
  if(!$this->islogin('013')){
      return $this->view->render('no-access',FALSE, $data);
    }

  $data['action'] = "?p=User&x=ProfilBiro";
  $data['pesan'] = '';
  if(isset($_POST['simpan'])){
    $data['input'] = array(
      'id' => $this->post('id'),
      'user_name' => $this->post('user_name'),
      'nama'      => $this->post('nama'),
      'pwdlama'  => $this->post('pwdlama'),
      'password' => $this->post('password'),
      'level'     => 2,
      'email'     => $this->post('email'),
      'aktif'     => $this->post('aktif')
    );
    $ID = $this->post('id');
    $username = $this->post('user_name');
      //cek username yg sama
    $cek1 = $this->model->getAll('tbl_user', '*', "user_name='".$username."' and id ='".$ID."'");
    $cek2 = $this->model->getAll('tbl_user', '*', "user_name='".$this->post('user_name')."'");
      
    if((!empty($cek1) and !empty($cek1)) or (empty($cek1) and empty($cek2))){

      $password = $this->post('password');
      $pwdlama = $this->post('pwdlama');

      if(empty($password)){
        $pwd = $pwdlama;
      }else{
        $pwd = md5($password);
      }
      $data_update = array(
        'user_name' => $this->post('user_name'),
        'nama'      => $this->post('nama'),
        'password'  => $pwd,
        'email'     => $this->post('email'),
        'aktif'     => $this->post('aktif') == '' ? 'Y' : $this->post('aktif')
      );
      $update = $this->model->edit('tbl_user', $data_update, "id ='".$ID."'");
      if($update){
       echo "<script>alert('Sudah diubah');</script>
       <script>window.location.assign('?p=User&x=ProfilBiro');</script>";
     }else{
      echo "<script>window.location.assign('?p=User&x=ProfilBiro');</script>";
    }

    }else{
      $data['pesan'] ='username sudah ada.';
    }

  }else{
    $ID = Session::get('id_user');
    $user = $this->model->getAll('tbl_user', 'tbl_user.*, tbl_user.password as pwdlama', "id='".$ID."' and level=3");
    if(empty($user)){
      echo "<script>alert('Data tidak ditemukan');</script>
      <script>window.location.assign('?p=Index');</script>";
    }
    foreach ($user as $value) {
      $data['input'] =$value;
    }
  }
  return $this->view->render('user/form-biro',FALSE,$data); 
}

public function actionEditDosen()
{
  $data['title'] = "<i class='fa fa-user-circle'></i> <b>User Skripsi</b>";
  $data['sub_title'] = "<strong> <i class='fa fa-edit' aria-hidden></i>Edit User Dosen</strong>";
  if(!$this->islogin('01')){
      return $this->view->render('no-access',FALSE, $data);
    }

  $data['action'] = "?p=User&x=EditDosen";
  $data['pesan'] = '';
  if(isset($_POST['simpan'])){
    $data['input'] = array(
      'ID' => $this->post('id'),
      'Login' => $this->post('user_name'),
      'Name' => $this->post('nama'),
      'pwdlama'  => $this->post('pwdlama'),
      'Password' => $this->post('password'),
      'Email'     => $this->post('email'),
      'NotActive'     => $this->post('aktif')
    );
    $ID = $this->post('id');
    $username = $this->post('user_name');
      //cek username yg sama
    $cek1 = $this->model->getAll('dosen', '*', "Login='".$username."' and ID ='".$ID."'");
    $cek2 = $this->model->getAll('dosen', '*', "Login='".$this->post('user_name')."'");
      
    if((!empty($cek1) and !empty($cek1)) or (empty($cek1) and empty($cek2))){

      $password = $this->post('password');
      $pwdlama = $this->post('pwdlama');

      if(empty($password)){
        $pwd = "";
      }else{
        $pwd = "Password = LEFT(PASSWORD('$password'),10),";
      }
      $sts = $this->post('aktif') == '' ? 'N' : $this->post('aktif');
      $data_update = "Login ='".$this->post('user_name')."', $pwd Email='".$this->post('email')."', NotActive='".$sts."'";
      
      //echo $up;
       $update = $this->model->edit2('dosen', $data_update, "ID ='".$ID."'");
      if($update){
       echo "<script>alert('Sudah diubah');</script>
       <script>window.location.assign('?p=User&x=Dosen');</script>";
     }else{
      echo "<script>window.location.assign('?p=User&x=Dosen');</script>";
    }
    }else{
      $data['pesan'] ='username sudah ada.';
    }

  }else{
    $ID = $this->get('id');
    $user = $this->model->getAll('dosen', 'ID, Name, Login, Gelar, Email, NotActive ,Password as pwdlama, Password', "ID='".$ID."'");
    if(empty($user)){
      echo "<script>alert('Data tidak ditemukan');</script>
      <script>window.location.assign('?p=User&x=Dosen');</script>";
    }
    foreach ($user as $value) {
      $data['input'] =$value;
    }
  }
  return $this->view->render('user/form-dosen',FALSE,$data); 
}

public function actionProfilDosen()
{
  $data['title'] = "<i class='fa fa-user-circle'></i> <b>User Skripsi</b>";
  $data['sub_title'] = "<strong> <i class='fa fa-edit' aria-hidden></i>Edit User Dosen</strong>";
  if(!$this->islogin('014')){
      return $this->view->render('no-access',FALSE, $data);
    }

  $data['action'] = "?p=User&x=ProfilDosen";
  $data['pesan'] = '';
  if(isset($_POST['simpan'])){
    $data['input'] = array(
      'ID' => $this->post('id'),
      'Login' => $this->post('user_name'),
      'Name' => $this->post('nama'),
      'pwdlama'  => $this->post('pwdlama'),
      'Password' => $this->post('password'),
      'Email'     => $this->post('email'),
      'NotActive'     => $this->post('aktif')
    );
    $ID = $this->post('id');
    $username = $this->post('user_name');
      //cek username yg sama
    $cek1 = $this->model->getAll('dosen', '*', "Login='".$username."' and ID ='".$ID."'");
    $cek2 = $this->model->getAll('dosen', '*', "Login='".$this->post('user_name')."'");
      
    if((!empty($cek1) and !empty($cek1)) or (empty($cek1) and empty($cek2))){

      $password = $this->post('password');
      $pwdlama = $this->post('pwdlama');

      if(empty($password)){
        $pwd = "";
      }else{
        $pwd = "Password = LEFT(PASSWORD('$password'),10),";
      }
      $sts = $this->post('aktif') == '' ? 'N' : $this->post('aktif');
      $data_update = "Login ='".$this->post('user_name')."', $pwd Email='".$this->post('email')."', NotActive='".$sts."'";
      
      //echo $up;
       $update = $this->model->edit2('dosen', $data_update, "ID ='".$ID."'");
      if($update){
       echo "<script>alert('Sudah diubah');</script>
       <script>window.location.assign('?p=User&x=ProfilDosen');</script>";
     }else{
      echo "<script>window.location.assign('?p=User&x=ProfilDosen');</script>";
    }
    }else{
      $data['pesan'] ='username sudah ada.';
    }

  }else{
    $ID = Session::get('id_user');
    $user = $this->model->getAll('dosen', 'ID, Name, Login, Gelar, Email, NotActive ,Password as pwdlama, Password', "ID='".$ID."'");
    if(empty($user)){
      echo "<script>alert('Data tidak ditemukan');</script>
      <script>window.location.assign('?p=User&x=Dosen');</script>";
    }
    foreach ($user as $value) {
      $data['input'] =$value;
    }
  }
  return $this->view->render('user/form-dosen',FALSE,$data); 
}

public function actionEditMhsw()
{
  $data['title'] = "<i class='fa fa-user-circle'></i> <b>User Skripsi</b>";
  $data['sub_title'] = "<strong> <i class='fa fa-edit' aria-hidden></i>Edit User Mahasiswa</strong>";
  if(!$this->islogin('01')){
      return $this->view->render('no-access',FALSE, $data);
    }

  $data['action'] = "?p=User&x=EditMhsw";
  $data['pesan'] = '';
  if(isset($_POST['simpan'])){
    $data['input'] = array(
      'ID' => $this->post('id'),
      'Login' => $this->post('user_name'),
      'Name' => $this->post('nama'),
      'pwdlama'  => $this->post('pwdlama'),
      'Password' => $this->post('password'),
      'Email'     => $this->post('email'),
      'NotActive'     => $this->post('aktif')
    );
    $ID = $this->post('id');
    $username = $this->post('user_name');
      //cek username yg sama
    $cek1 = $this->model->getAll('mhsw', '*', "Login='".$username."' and ID ='".$ID."'");
    $cek2 = $this->model->getAll('mhsw', '*', "Login='".$this->post('user_name')."'");
      
    if((!empty($cek1) and !empty($cek1)) or (empty($cek1) and empty($cek2))){

      $password = $this->post('password');
      $pwdlama = $this->post('pwdlama');

      if(empty($password)){
        $pwd = "";
      }else{
        $pwd = "Password = LEFT(PASSWORD('$password'),10),";
      }
      $sts = $this->post('aktif') == '' ? 'N' : $this->post('aktif');
      $data_update = "Login ='".$this->post('user_name')."', $pwd Email='".$this->post('email')."', NotActive='".$sts."'";
      
      //echo $up;
       $update = $this->model->edit2('mhsw', $data_update, "ID ='".$ID."'");
      if($update){
       echo "<script>alert('Sudah diubah');</script>
       <script>window.location.assign('?p=User&x=Mhsw');</script>";
     }else{
      echo "<script>window.location.assign('?p=User&x=Mhsw');</script>";
    }
    }else{
      $data['pesan'] ='username sudah ada.';
    }

  }else{
    $ID = $this->get('id');
    $user = $this->model->getAll('mhsw', 'ID, NIM, Name, Login, Email, NotActive ,Password as pwdlama, Password', "ID='".$ID."'");
    if(empty($user)){
      echo "<script>alert('Data tidak ditemukan');</script>
      <script>window.location.assign('?p=User&x=Mhsw');</script>";
    }
    foreach ($user as $value) {
      $data['input'] =$value;
    }
  }
  return $this->view->render('user/form-mhsw',FALSE,$data); 
}

public function actionProfilMhsw()
{
  $data['title'] = "<i class='fa fa-user-circle'></i> <b>User</b>";
  $data['sub_title'] = "<i class='fa fa-edit'></i> <b>Edit Profil</b>";

  if(!$this->islogin('015')){
      return $this->view->render('no-access',FALSE, $data);
    }
  $data['action'] = "?p=User&x=ProfilMhsw";

    $ID = Session::get('id_user');
    $NIM = Session::get('username');

    if(isset($_POST['simpan'])){
      $data['input'] = array(
      'ID'        => $this->post('id'),
      'Login'     => $this->post('user_name'),
      'Name'      => $this->post('nama'),
      'pwdlama'   => $this->post('pwdlama'),
      'Password'  => $this->post('password'),
      'Email'     => $this->post('email'),
      'NotActive' => $this->post('aktif')
    );
    $ID = $this->post('id');
    $username = $this->post('user_name');
      //cek username yg sama
    $cek1 = $this->model->getAll('mhsw', '*', "Login='".$username."' and ID ='".$ID."'");
    $cek2 = $this->model->getAll('mhsw', '*', "Login='".$this->post('user_name')."'");
      
    if((!empty($cek1) and !empty($cek1)) or (empty($cek1) and empty($cek2))){

      $password = $this->post('password');
      $pwdlama = $this->post('pwdlama');

      if(empty($password)){
        $pwd = "";
      }else{
        $pwd = "Password = LEFT(PASSWORD('$password'),10),";
      }
      $sts = $this->post('aktif') == '' ? 'N' : $this->post('aktif');
      $data_update = "Login ='".$this->post('user_name')."', $pwd Email='".$this->post('email')."', NotActive='".$sts."'";
      
      //echo $up;
       $update = $this->model->edit2('mhsw', $data_update, "ID ='".$ID."'");
      if($update){
       echo "<script>alert('Sudah diubah');</script>
       <script>window.location.assign('?p=User&x=ProfilMhsw');</script>";
     }else{
      echo "<script>window.location.assign('?p=User&x=ProfilMhsw');</script>";
    }
    }else{
      $data['pesan'] ='username sudah ada.';
    }
    }else{
      $mhsw = $this->model->getAll('mhsw', "*", "ID='".$ID."' and NIM='".$NIM."'");
      foreach ($mhsw as $value) {
        $data['input'] = $value;
      }
    return $this->view->render('user/form-mhsw',FALSE,$data);       
    }
}

public function actionHapusUser()
{
  if(!$this->islogin('01')){
      return $this->view->render('no-access',FALSE);
    }

  $ID = $this->get('id');
  $header = $this->get('act');
  $user = $this->model->getAll('tbl_user', '*',"id ='".$ID."'");
  if(empty($user)){
    echo "<script>alert('Data tidak ditemukan');</script>
      <script>window.location.assign('?p=User&x=".$header."');</script>";
  }else{
  //hapus
    $this->model->delete('tbl_user', array("id"=>$ID),"User&x=".$header);
  }
}

public function actionHapusDosen()
{
 if(!$this->islogin('01')){
      return $this->view->render('no-access',FALSE);
    }

  $ID = $this->get('id');
  $header = $this->get('act');
  $user = $this->model->getAll('dosen', '*',"ID ='".$ID."'");
  if(empty($user)){
    echo "<script>alert('Data tidak ditemukan');</script>
      <script>window.location.assign('?p=User&x=Dosen');</script>";
  }else{
  //hapus
    $this->model->delete2('dosen', array("ID"=>$ID),"User&x=".$header);
  }
}

public function actionLogout(){
    //hapus session
  session_destroy();
    //kembalikan ke index
  echo "<script> window.location.assign('?p=index'); </script>";
}

}

?>
