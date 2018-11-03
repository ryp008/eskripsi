<?php

/**
 * Description of DosenController
 *
 * @author rolly
 */
class DosenController extends Controller {

    //put your code here
    public function __construct() {
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

    public function index() {
        $data['title'] = "<i class='fa fa-user-circle'></i> <b>Dosen</b>";
        $data['sub_title'] = "<i class='fa fa-users'></i> <b>Data Dosen</b>";
        if(!$this->islogin('0123')){
            return $this->view->render('no-access',FALSE, $data);
        }
        $data['dosen'] = $this->model->find();

        return $this->view->render('dosen/index', FALSE, $data);
    }
    
    public function actionTambah(){
        $data['title'] = "<i class='fa fa-user-circle'></i> <b>Dosen</b>";
        $data['sub_title'] = "<i class='fa fa-user-plus'></i> <b>Tambah Dosen</b>";
                if(!$this->islogin('01')){
    return $this->view->render('no-access',FALSE, $data);
}
        $data['jenjang'] = $this->model->getAll('jenjangps', 'Kode,Nama', null, 'Kode ASC');

        return $this->view->render('dosen/_form', false, $data);
    }

    public function actionSimpan()
    {
        if(!$this->islogin('01')){
    return $this->view->render('no-access',FALSE);
}

        if(isset($_POST['simpan'])){
            $input = array(
                        'NIDN'         => $this->post('NIDN'),
                        'NIK'          => $this->post('NIK'),
                        'Name'         => $this->post('Name'),
                        'Gelar'        => $this->post('Gelar'),
                        'Email'        => $this->post('Email'),
                        'Sex'          => $this->post('Sex'),
                        'TglLahir'     => $this->post('TglLahir'),
                        'TempatLahir'  => $this->post('TempatLahir'),
                        'Alamat1'      => $this->post('Alamat'),
                        'Phone'        => $this->post('Phone'),
                        'JenjangDosen' => $this->post('Jenjang'),
                        'LulusanPT'    => $this->post('LulusanPT')
                    );
            $insert = $this->model->save('dosen', $input);
            if($insert){
            echo "<script>alert('Sudah disimpan');</script>
            <script>window.location.assign('?p=Dosen');</script>";
            }else{
            echo "<script>alert('Gagal disimpan');</script>
            <script>window.location.assign('?p=Dosen');</script>";
            }
        }else{
            echo "<script>window.location.assign('?p=Dosen');</script>";            
        }
    }

    public function actionDetail()
    {
         $data['title'] = "<i class='fa fa-user-circle'></i> <b>Dosen</b>";
        $data['sub_title'] = "<i class='fa fa-user-o'></i> <b>Detail Dosen</b>";

        if(!$this->islogin('0123')){
    return $this->view->render('no-access',FALSE, $data);
}
        $ID = $this->get('id');
        $dosen = $this->model->getAll('dosen', '*', "ID='".$ID."'");
        if(empty($dosen)){
            echo "<script>alert('Data tidak ditemukan');</script>
            <script>window.location.assign('?p=Dosen');</script>";
        }

        $data['dosen']=$dosen;
        return $this->view->render('dosen/detail', false, $data);

    }

    public function actionEdit()
    {
         $data['title'] = "<i class='fa fa-user-circle'></i> <b>Dosen</b>";
        $data['sub_title'] = "<i class='fa fa-edit'></i> <b>Update Data Dosen</b>";

        if(!$this->islogin('01')){
    return $this->view->render('no-access',FALSE, $data);
}
        $data['jenjang'] = $this->model->getAll('jenjangps', 'Kode,Nama', null, 'Kode ASC');

        $ID = $this->get('id');
        $dosen = $this->model->getAll('dosen', '*', "ID='".$ID."'");
        if(empty($dosen)){
            echo "<script>alert('Data tidak ditemukan');</script>
            <script>window.location.assign('?p=Dosen');</script>";
        }

        $data['row']=$dosen;
        return $this->view->render('dosen/_form_edit', false, $data);
    }


    public function actionSimpanEdit()
    {
        
if(!$this->islogin('01')){
    return $this->view->render('no-access',FALSE);
}
        if(isset($_POST['simpan'])){
            $ID = $this->post('ID');
            $input = array(
                        'NIDN'         => $this->post('NIDN'),
                        'NIK'          => $this->post('NIK'),
                        'Name'         => $this->post('Name'),
                        'Gelar'        => $this->post('Gelar'),
                        'Email'        => $this->post('Email'),
                        'Sex'          => $this->post('Sex'),
                        'TglLahir'     => $this->post('TglLahir'),
                        'TempatLahir'  => $this->post('TempatLahir'),
                        'Alamat1'      => $this->post('Alamat'),
                        'Phone'        => $this->post('Phone'),
                        'JenjangDosen' => $this->post('Jenjang'),
                        'LulusanPT'    => $this->post('LulusanPT')
                    );

            $update = $this->model->edit($input, "ID ='".$ID."'");
            if($update){
            echo "<script>alert('Sudah diubah');</script>
            <script>window.location.assign('?p=Dosen');</script>";
            }else{
            echo "<script>alert('Gagal diubah');</script>
            <script>window.location.assign('?p=Dosen');</script>";
            }
        }else{
            echo "<script>window.location.assign('?p=Dosen');</script>";            
        }
    }


    public function actionHapus() {
        if(!$this->islogin('01')){
    return $this->view->render('no-access',FALSE);
}
        $this->model->delete(
                array(
            "ID" => $this->get('id')
                ), "Dosen"
        );
    }

}
