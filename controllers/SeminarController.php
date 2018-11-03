<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SeminarController
 *
 * @author rolly
 */
class SeminarController extends Controller{
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

	public function index()
	{
		if(!$this->islogin('012345')){
      return $this->view->render('no-access',FALSE);
    } 
	}

	public function actionSeminarProposal()
	{
		$data['title'] = "<i class='fa fa-tv'></i> <b>Seminar</b>";
		$data['sub_title'] = "<i class='fa fa-tv'></i> <b> Seminar Proposal</b>";
		
		if(!$this->islogin('01234')){
      return $this->view->render('no-access',FALSE, $data);
    }
		$where =" tbl_seminar.JenisSeminar = 'Proposal'";
		$prodi = Session::get('prodi');
		if($prodi != 'all'){
			$where .= " and tbl_seminar.Prodi ='".$prodi."'";
		}

		$select = "mhsw.NIM, mhsw.Name, mhsw.KodeJurusan,
		(select CONCAT_WS(', ',dosen.Name, dosen.Gelar) from dosen where dosen.ID = tbl_pembimbing.IDDosen1 ) as Dosen1, 
		(select CONCAT_WS(', ',dosen.Name, dosen.Gelar) from dosen where dosen.ID = tbl_pembimbing.IDDosen2 ) as Dosen2,
		(select CONCAT_WS(', ',dosen.Name, dosen.Gelar) from dosen where dosen.ID = tbl_seminar.IDKetua) as Ketua,
		(select CONCAT_WS(', ',dosen.Name, dosen.Gelar) from dosen where dosen.ID = tbl_seminar.IDPenguji1 ) as Penguji1,
		(select CONCAT_WS(', ',dosen.Name, dosen.Gelar) from dosen where dosen.ID = tbl_seminar.IDPenguji2 ) as Penguji2,
		tbl_seminar.Gelombang, tbl_seminar.Tahun, tbl_seminar.IDSeminar";
		$join ="inner join mhsw on mhsw.NIM = tbl_seminar.NIM
		inner join tbl_pembimbing on tbl_pembimbing.NIM = tbl_seminar.NIM";
		$data['seminar'] = $this->model->getAllJoin('tbl_seminar', $select, $join, $where);
		return $this->view->render('seminar/seminar-proposal',FALSE,$data);	
	}

	public function actionSeminarProposalMhsw()
	{
		$data['title'] = "<i class='fa fa-tv'></i> <b>Seminar</b>";
		$data['sub_title'] = "<i class='fa fa-tv'></i> <b> Seminar Proposal</b>";
		
		if(!$this->islogin('015')){
      return $this->view->render('no-access',FALSE, $data);
    }
    	$NIM = Session::get('username');

		$where =" tbl_seminar.JenisSeminar = 'Proposal' and mhsw.NIM='".$NIM."' ";
		$prodi = Session::get('prodi');
		if($prodi != 'all'){
			$where .= " and tbl_seminar.Prodi ='".$prodi."'";
		}


		$select = "mhsw.NIM, mhsw.Name, mhsw.KodeJurusan,
		(select CONCAT_WS(', ',dosen.Name, dosen.Gelar) from dosen where dosen.ID = tbl_pembimbing.IDDosen1 ) as Dosen1, 
		(select CONCAT_WS(', ',dosen.Name, dosen.Gelar) from dosen where dosen.ID = tbl_pembimbing.IDDosen2 ) as Dosen2,
		(select CONCAT_WS(', ',dosen.Name, dosen.Gelar) from dosen where dosen.ID = tbl_seminar.IDKetua) as Ketua,
		(select CONCAT_WS(', ',dosen.Name, dosen.Gelar) from dosen where dosen.ID = tbl_seminar.IDPenguji1 ) as Penguji1,
		(select CONCAT_WS(', ',dosen.Name, dosen.Gelar) from dosen where dosen.ID = tbl_seminar.IDPenguji2 ) as Penguji2,
		tbl_seminar.Gelombang, tbl_seminar.Tahun, tbl_seminar.IDSeminar";
		$join ="inner join mhsw on mhsw.NIM = tbl_seminar.NIM
		inner join tbl_pembimbing on tbl_pembimbing.NIM = tbl_seminar.NIM";
		$data['seminar'] = $this->model->getAllJoin('tbl_seminar', $select, $join, $where);
		return $this->view->render('seminar/seminar-proposal',FALSE,$data);	
	}

	public function actionSeminarHasil()
	{
		$data['title'] = "<i class='fa fa-tv'></i> <b>Seminar</b>";
		$data['sub_title'] = "<i class='fa fa-tv'></i> <b> Seminar Hasil</b>";
		
		if(!$this->islogin('012345')){
      return $this->view->render('no-access',FALSE, $data);
    }

		$where =" tbl_seminar.JenisSeminar = 'Hasil' ";
		$prodi = Session::get('prodi');
		if($prodi != 'all'){
			$where .= " and tbl_seminar.Prodi ='".$prodi."'";
		}

		$select = "mhsw.NIM, mhsw.Name, mhsw.KodeJurusan,
		(select CONCAT_WS(', ',dosen.Name, dosen.Gelar) from dosen where dosen.ID = tbl_pembimbing.IDDosen1 ) as Dosen1, 
		(select CONCAT_WS(', ',dosen.Name, dosen.Gelar) from dosen where dosen.ID = tbl_pembimbing.IDDosen2 ) as Dosen2,
		(select CONCAT_WS(', ',dosen.Name, dosen.Gelar) from dosen where dosen.ID = tbl_seminar.IDKetua) as Ketua,
		(select CONCAT_WS(', ',dosen.Name, dosen.Gelar) from dosen where dosen.ID = tbl_seminar.IDPenguji1 ) as Penguji1,
		(select CONCAT_WS(', ',dosen.Name, dosen.Gelar) from dosen where dosen.ID = tbl_seminar.IDPenguji2 ) as Penguji2,
		tbl_seminar.Gelombang, tbl_seminar.Tahun, tbl_seminar.IDSeminar";
		$join ="inner join mhsw on mhsw.NIM = tbl_seminar.NIM
		inner join tbl_pembimbing on tbl_pembimbing.NIM = tbl_seminar.NIM";
		//$where ="tbl_seminar.JenisSeminar = 'Hasil'";
		$data['seminar'] = $this->model->getAllJoin('tbl_seminar', $select, $join, $where);
		return $this->view->render('seminar/seminar-hasil',FALSE,$data);	
	}

	public function actionSeminarHasilMhsw()
	{
		$data['title'] = "<i class='fa fa-tv'></i> <b>Seminar</b>";
		$data['sub_title'] = "<i class='fa fa-tv'></i> <b> Seminar Hasil</b>";
		
		if(!$this->islogin('012345')){
      return $this->view->render('no-access',FALSE, $data);
    }

    	$NIM = Session::get('username');
		$where =" tbl_seminar.JenisSeminar = 'Hasil' and mhsw.NIM='".$NIM."' ";
		$prodi = Session::get('prodi');
		if($prodi != 'all'){
			$where .= " and tbl_seminar.Prodi ='".$prodi."'";
		}

		$select = "mhsw.NIM, mhsw.Name, mhsw.KodeJurusan,
		(select CONCAT_WS(', ',dosen.Name, dosen.Gelar) from dosen where dosen.ID = tbl_pembimbing.IDDosen1 ) as Dosen1, 
		(select CONCAT_WS(', ',dosen.Name, dosen.Gelar) from dosen where dosen.ID = tbl_pembimbing.IDDosen2 ) as Dosen2,
		(select CONCAT_WS(', ',dosen.Name, dosen.Gelar) from dosen where dosen.ID = tbl_seminar.IDKetua) as Ketua,
		(select CONCAT_WS(', ',dosen.Name, dosen.Gelar) from dosen where dosen.ID = tbl_seminar.IDPenguji1 ) as Penguji1,
		(select CONCAT_WS(', ',dosen.Name, dosen.Gelar) from dosen where dosen.ID = tbl_seminar.IDPenguji2 ) as Penguji2,
		tbl_seminar.Gelombang, tbl_seminar.Tahun, tbl_seminar.IDSeminar";
		$join ="inner join mhsw on mhsw.NIM = tbl_seminar.NIM
		inner join tbl_pembimbing on tbl_pembimbing.NIM = tbl_seminar.NIM";
		//$where ="tbl_seminar.JenisSeminar = 'Hasil'";
		$data['seminar'] = $this->model->getAllJoin('tbl_seminar', $select, $join, $where);
		return $this->view->render('seminar/seminar-hasil',FALSE,$data);	
	}

	public function actionPendaftaranSempro()
	{
		$data['title'] = "<i class='fa fa-tv'></i> <b>Seminar</b>";
		$data['sub_title'] = "<i class='fa fa-tv'></i> <b>Pendaftaran Seminar Proposal</b>";
		
		if(!$this->islogin('013')){
      return $this->view->render('no-access',FALSE, $data);
    }

		$data['dosen'] = $this->model->getAll('dosen', "ID, CONCAT_WS(', ',Name, dosen.Gelar) as NamaDosen", null, "Name ASC");

		if(isset($_GET['nim'])){
			$NIM = $this->get('nim');
			$data['tahun'] = $this->model->getAll('tbl_ta', 'kode', "aktif = 'Y'", null, 1);
			$NIM = $this->get('nim');
			$select = "mhsw.NIM, mhsw.Name, mhsw.KodeJurusan, tbl_aktivasi_mhs.Status, tbl_judul.status as sts_judul, tbl_pembimbing.IDDosen1, tbl_pembimbing.IDDOsen2, tbl_judul.judul,
			(select CONCAT_WS(', ',dosen.Name, dosen.Gelar) from dosen where dosen.ID = tbl_pembimbing.IDDosen1 ) as Dosen1, 
			(select CONCAT_WS(', ',dosen.Name, dosen.Gelar) from dosen where dosen.ID = tbl_pembimbing.IDDosen2 ) as Dosen2";

			$join = "left outer join tbl_judul on tbl_judul.nim = mhsw.NIM
			left outer join tbl_pembimbing on tbl_pembimbing.NIM = tbl_judul.nim
			left outer join tbl_aktivasi_mhs on tbl_aktivasi_mhs.NIM = mhsw.NIM
			";
			$where = "mhsw.NIM = '".$NIM."' and tbl_judul.status = 'SUDAH ACC'";


			$cekmhs = $this->model->getAllJoin('mhsw',$select, $join, $where, null, 1);
			$data['mhsw'] = $cekmhs;
		} 
		return $this->view->render('seminar/form-sempro',FALSE,$data);	
	}

	public function actionPendaftaranSemha()
	{
		
		$data['title'] = "<i class='fa fa-tv'></i> <b>Seminar</b>";
		$data['sub_title'] = "<i class='fa fa-tv'></i> <b> Pendaftaran Seminar Hasil</b>";
		
		if(!$this->islogin('013')){
      return $this->view->render('no-access',FALSE, $data);
    }

		$data['dosen'] = $this->model->getAll('dosen', "ID, CONCAT_WS(', ',Name, dosen.Gelar) as NamaDosen", null, "Name ASC");

		if(isset($_GET['nim'])){
			$NIM = $this->get('nim');
			$data['tahun'] = $this->model->getAll('tbl_ta', 'kode', "aktif = 'Y'", null, 1);
			$NIM = $this->get('nim');
			$select = "mhsw.NIM, mhsw.Name, mhsw.KodeJurusan, tbl_aktivasi_mhs.Status, tbl_judul.status as sts_judul, tbl_pembimbing.IDDosen1, tbl_pembimbing.IDDOsen2, tbl_judul.judul,
			(select CONCAT_WS(', ',dosen.Name, dosen.Gelar) from dosen where dosen.ID = tbl_pembimbing.IDDosen1 ) as Dosen1, 
			(select CONCAT_WS(', ',dosen.Name, dosen.Gelar) from dosen where dosen.ID = tbl_pembimbing.IDDosen2 ) as Dosen2";

			$join = "left outer join tbl_judul on tbl_judul.nim = mhsw.NIM
			left outer join tbl_pembimbing on tbl_pembimbing.NIM = tbl_judul.nim
			left outer join tbl_aktivasi_mhs on tbl_aktivasi_mhs.NIM = mhsw.NIM
			";
			$where = "mhsw.NIM = '".$NIM."' and tbl_judul.status = 'SUDAH ACC'";


			$cekmhs = $this->model->getAllJoin('mhsw',$select, $join, $where, null, 1);
			$data['mhsw'] = $cekmhs;
		} 
		return $this->view->render('seminar/form-semha',FALSE,$data);	
	}

	public function actionSimpanSempro()
	{
		if(!$this->islogin('013')){
      return $this->view->render('no-access',FALSE);
    } 

		if(isset($_POST['submit'])){

			$data_input = array(
				'NIM'          => $this->post('NIM'),
				'JenisSeminar' => $this->post('JenisSeminar'),
				'Prodi'        => $this->post('Prodi'),
				'IDKetua'      => $this->post('Ketua'),
				'IDPenguji1'     => $this->post('Penguji1'),
				'IDPenguji2'     => $this->post('Penguji2'),
				'Tanggal'      => $this->post('Tanggal'),
				'Jam'          => $this->post('Jam'),
				'Ruang'        => $this->post('Ruang'),
				'Tahun'        => $this->post('Tahun'),
				'Gelombang'    => $this->post('Gelombang'),
				'Seminar'      => 'Y'
			);
			$insert = $this->model->save('tbl_seminar', $data_input);
			if($insert){
				echo "<script>alert('Sudah disimpan');</script>
				<script>window.location.assign('?p=Seminar&x=PendaftaranSempro');</script>";
			}else{
				echo "<script>alert('Gagal disimpan');</script>
				<script>window.location.assign('?p=Seminar&x=PendaftaranSempro');</script>";
			}

		}else{
			echo "<script>window.location.assign('?p=Seminar&x=SeminarProposal');</script>";

		}
	}

	public function actionDetSempro()
	{
		$data['title'] = "<i class='fa fa-tv'></i> <b>Seminar</b>";
		$data['sub_title'] = "<i class='fa fa-tv'></i> <b>Detail Seminar Proposal</b>";
		
		if(!$this->islogin('012345')){
      return $this->view->render('no-access',FALSE, $data);
    }
		$ID = $this->get('id');
		$data['back'] = '?p=Seminar&x=SeminarProposalMhsw';

		$data['dosen'] = $this->model->getAll('dosen', "ID, CONCAT_WS(', ',Name, dosen.Gelar) as NamaDosen", null, "Name ASC");

		$select ="mhsw.NIM, mhsw.Name, mhsw.KodeJurusan, tbl_judul.judul, 
				(select CONCAT_WS(', ',dosen.Name, dosen.Gelar) from dosen where dosen.ID = tbl_pembimbing.IDDosen1 ) as Dosen1, 
			(select CONCAT_WS(', ',dosen.Name, dosen.Gelar) from dosen where dosen.ID = tbl_pembimbing.IDDosen2 ) as Dosen2, tbl_seminar.*";
		$join = "inner join mhsw on mhsw.NIM = tbl_seminar.NIM
				inner join tbl_judul on tbl_judul.nim = mhsw.NIM
				inner join tbl_pembimbing on tbl_pembimbing.NIM = tbl_seminar.NIM";
		$where = "tbl_judul.status ='SUDAH ACC' and tbl_seminar.IDSeminar ='".$ID."' and tbl_seminar.JenisSeminar ='Proposal'";

		$seminar = $this->model->getAllJoin('tbl_seminar', $select, $join, $where);
		if(empty($seminar)){
			echo "<script>alert('Data Tidak Ditemukan');</script>
				<script>window.location.assign('?p=Seminar&x=SeminarProposal');</script>";
		}
		$data['mhsw'] = $seminar;

		return $this->view->render('seminar/detail-sempro',FALSE,$data);	
			
	}

	public function actionDetSemha()
	{
		$data['title'] = "<i class='fa fa-tv'></i> <b>Seminar</b>";
		$data['sub_title'] = "<i class='fa fa-tv'></i> <b> Detail Seminar Hasil</b>";
		
		if(!$this->islogin('012345')){
      return $this->view->render('no-access',FALSE, $data);
    }
		$ID = $this->get('id');
		$data['back'] = '?p=Seminar&x=SeminarSemhaMhsw';

		$data['dosen'] = $this->model->getAll('dosen', "ID, CONCAT_WS(', ',Name, dosen.Gelar) as NamaDosen", null, "Name ASC");

		$select ="mhsw.NIM, mhsw.Name, mhsw.KodeJurusan, tbl_judul.judul, 
				(select CONCAT_WS(', ',dosen.Name, dosen.Gelar) from dosen where dosen.ID = tbl_pembimbing.IDDosen1 ) as Dosen1, 
			(select CONCAT_WS(', ',dosen.Name, dosen.Gelar) from dosen where dosen.ID = tbl_pembimbing.IDDosen2 ) as Dosen2, tbl_seminar.*";
		$join = "inner join mhsw on mhsw.NIM = tbl_seminar.NIM
				inner join tbl_judul on tbl_judul.nim = mhsw.NIM
				inner join tbl_pembimbing on tbl_pembimbing.NIM = tbl_seminar.NIM";
		$where = "tbl_judul.status ='SUDAH ACC' and tbl_seminar.IDSeminar ='".$ID."' and tbl_seminar.JenisSeminar ='Hasil'";

		$seminar = $this->model->getAllJoin('tbl_seminar', $select, $join, $where);
		if(empty($seminar)){
			echo "<script>alert('Data Tidak Ditemukan');</script>
				<script>window.location.assign('?p=Seminar&x=SeminarHasil');</script>";
		}
		$data['mhsw'] = $seminar;

		return $this->view->render('seminar/detail-semha',FALSE,$data);	
			
	}

	public function actionEditSempro()
	{
		$data['title'] = "<i class='fa fa-tv'></i> <b>Seminar</b>";
		$data['sub_title'] = "<i class='fa fa-edit'></i> <b>Edit Seminar Proposal</b>";
		
		if(!$this->islogin('013')){
      return $this->view->render('no-access',FALSE, $data);
    } 

		$ID = $this->get('id');

		$data['dosen'] = $this->model->getAll('dosen', "ID, CONCAT_WS(', ',Name, dosen.Gelar) as NamaDosen", null, "Name ASC");

		$select ="mhsw.NIM, mhsw.Name, mhsw.KodeJurusan, tbl_judul.judul, 
			(select CONCAT_WS(', ',dosen.Name, dosen.Gelar) from dosen where dosen.ID = tbl_pembimbing.IDDosen1 ) as Dosen1,
			(select CONCAT_WS(', ',dosen.Name, dosen.Gelar) from dosen where dosen.ID = tbl_pembimbing.IDDosen2 ) as Dosen2, tbl_seminar.*";
		$join = "inner join mhsw on mhsw.NIM = tbl_seminar.NIM
				inner join tbl_judul on tbl_judul.nim = mhsw.NIM
				inner join tbl_pembimbing on tbl_pembimbing.NIM = tbl_seminar.NIM";
		$where = "tbl_judul.status ='SUDAH ACC' and tbl_seminar.IDSeminar ='".$ID."' and tbl_seminar.JenisSeminar ='Proposal'";

		$seminar = $this->model->getAllJoin('tbl_seminar', $select, $join, $where);
		if(empty($seminar)){
			echo "<script>alert('Data Tidak Ditemukan');</script>
				<script>window.location.assign('?p=Seminar&x=SeminarProposal');</script>";
		}
		$data['mhsw'] = $seminar;

		return $this->view->render('seminar/form-edit-sempro',FALSE,$data);	
			
	}

	public function actionEditSemha()
	{
		if(!$this->islogin('013')){
      return $this->view->render('no-access',FALSE);
    } 

		$data['title'] = 'Seminar Hasil';
		$data['sub_title'] = 'Edit Seminar Hasil';
		$ID = $this->get('id');

		$data['dosen'] = $this->model->getAll('dosen', "ID, CONCAT_WS(', ',Name, dosen.Gelar) as NamaDosen", null, "Name ASC");

		$select ="mhsw.NIM, mhsw.Name, mhsw.KodeJurusan, tbl_judul.judul, tbl_pembimbing.IDDosen1, tbl_pembimbing.IDDosen2, tbl_seminar.*";
		$join = "inner join mhsw on mhsw.NIM = tbl_seminar.NIM
				inner join tbl_judul on tbl_judul.nim = mhsw.NIM
				inner join tbl_pembimbing on tbl_pembimbing.NIM = tbl_seminar.NIM";
		$where = "tbl_judul.status ='SUDAH ACC' and tbl_seminar.IDSeminar ='".$ID."' and tbl_seminar.JenisSeminar ='Hasil'";

		$seminar = $this->model->getAllJoin('tbl_seminar', $select, $join, $where);
		if(empty($seminar)){
			echo "<script>alert('Data Tidak Ditemukan');</script>
				<script>window.location.assign('?p=Seminar&x=SeminarProposal');</script>";
		}
		$data['mhsw'] = $seminar;

		return $this->view->render('seminar/form-edit-semha',FALSE,$data);	
			
	}

	public function actionHapusSempro()
	{
		if(!$this->islogin('013')){
      return $this->view->render('no-access',FALSE);
    } 
		$ID = $this->get('id');
		$NIM = $this->get('nim');

		$seminar = $this->model->getAll('tbl_seminar', "*", "IDSeminar ='".$ID."' and NIM='".$NIM."'");
		if(empty($seminar)){
			echo "<script>alert('Data Tidak Ditemukan');</script>
				<script>window.location.assign('?p=Seminar&x=SeminarProposal');</script>";
		}else{

  	$this->model->delete(array("IDSeminar"=>$ID, "NIM"=>$NIM),"Seminar&x=SeminarProposal");
		return $this->view->render('seminar/form-edit-sempro',FALSE,$data);	
	}
			
	}

	public function actionHapusSemha()
	{
		if(!$this->islogin('013')){
      return $this->view->render('no-access',FALSE);
    } 
		$ID = $this->get('id');
		$NIM = $this->get('nim');

		$seminar = $this->model->getAll('tbl_seminar', "*", "IDSeminar ='".$ID."' and NIM='".$NIM."'");
		if(empty($seminar)){
			echo "<script>alert('Data Tidak Ditemukan');</script>
				<script>window.location.assign('?p=Seminar&x=SeminarHasil');</script>";
		}else {
			$this->model->delete(array("IDSeminar"=>$ID, "NIM"=>$NIM),"Seminar&x=SeminarHasil");
		//return $this->view->render('seminar/form-edit-sempro',FALSE,$data);	
		}	
			
	}

	public function actionSimpanEditSempro()
	{
		if(!$this->islogin('013')){
      return $this->view->render('no-access',FALSE);
    } 

		if(isset($_POST['submit'])){
			$ID = $this->post('ID');
			$data_input = array(
				'IDKetua'      => $this->post('Ketua'),
				'IDPenguji1'     => $this->post('Penguji1'),
				'IDPenguji2'     => $this->post('Penguji2'),
				'Tanggal'      => $this->post('Tanggal'),
				'Jam'          => $this->post('Jam'),
				'Ruang'        => $this->post('Ruang'),
				'Gelombang'    => $this->post('Gelombang')
			);
			$insert = $this->model->edit($data_input, "IDSeminar ='".$ID."'");
			if($insert){
				echo "<script>alert('Sudah diubah');</script>
				<script>window.location.assign('?p=Seminar&x=SeminarProposal');</script>";
			}else{
				echo "<script>alert('Gagal diubah');</script>
				<script>window.location.assign('?p=Seminar&x=SeminarProposal');</script>";
			}

		}else{
			echo "<script>window.location.assign('?p=Seminar&x=SeminarProposal');</script>";

		}
	}

	public function actionSimpanEditSemha()
	{
		if(!$this->islogin('013')){
      return $this->view->render('no-access',FALSE);
    } 

		if(isset($_POST['submit'])){
			$ID = $this->post('ID');
			$data_input = array(
				'IDKetua'      => $this->post('Ketua'),
				'IDPenguji1'     => $this->post('Penguji1'),
				'IDPenguji2'     => $this->post('Penguji2'),
				'Tanggal'      => $this->post('Tanggal'),
				'Jam'          => $this->post('Jam'),
				'Ruang'        => $this->post('Ruang'),
				'Gelombang'    => $this->post('Gelombang')
			);
			$insert = $this->model->edit($data_input, "IDSeminar ='".$ID."'");
			if($insert){
				echo "<script>alert('Sudah diubah');</script>
				<script>window.location.assign('?p=Seminar&x=SeminarHasil');</script>";
			}else{
				echo "<script>alert('Gagal diubah');</script>
				<script>window.location.assign('?p=Seminar&x=SeminarHasil');</script>";
			}

		}else{
			echo "<script>window.location.assign('?p=Seminar&x=SeminarHasil');</script>";

		}
	}

	public function actionSimpanSemha()
	{
		if(!$this->islogin('013')){
      return $this->view->render('no-access',FALSE);
    } 

		if(isset($_POST['submit'])){

			$data_input = array(
				'NIM'          => $this->post('NIM'),
				'JenisSeminar' => $this->post('JenisSeminar'),
				'Prodi'        => $this->post('Prodi'),
				'IDKetua'      => $this->post('Ketua'),
				'IDPenguji1'     => $this->post('Penguji1'),
				'IDPenguji2'     => $this->post('Penguji2'),
				'Tanggal'      => $this->post('Tanggal'),
				'Jam'          => $this->post('Jam'),
				'Ruang'        => $this->post('Ruang'),
				'Tahun'        => $this->post('Tahun'),
				'Gelombang'    => $this->post('Gelombang'),
				'Seminar'      => 'Y'
			);
			$insert = $this->model->save('tbl_seminar', $data_input);
			if($insert){
				echo "<script>alert('Sudah disimpan');</script>
				<script>window.location.assign('?p=Seminar&x=PendaftaranSemha');</script>";
			}else{
				echo "<script>alert('Gagal disimpan');</script>
				<script>window.location.assign('?p=Seminar&x=PendaftaranSemha');</script>";
			}

		}else{
			echo "<script>window.location.assign('?p=Seminar&x=SeminarHasil');</script>";

		}
	}

	public function actionCetakBerkasSemha()
	{
		if(!$this->islogin('013')){
      return $this->view->render('no-access',FALSE);
    } 
		$ID = $this->get('id');

 			$select ="mhsw.NIM, mhsw.Name, mhsw.KodeJurusan, tbl_seminar.*,

			(select CONCAT_WS(', ',dosen.Name, dosen.Gelar) from dosen where dosen.ID = tbl_pembimbing.IDDosen1 ) as Dosen1,
			(select CONCAT_WS(', ',dosen.Name, dosen.Gelar) from dosen where dosen.ID = tbl_pembimbing.IDDosen2 ) as Dosen2,
			(select CONCAT_WS(', ',dosen.Name, dosen.Gelar) from dosen where dosen.ID = tbl_seminar.IDKetua ) as Ketua,
			(select CONCAT_WS(', ',dosen.Name, dosen.Gelar) from dosen where dosen.ID = tbl_seminar.IDPenguji2 ) as Penguji2,
			(select CONCAT_WS(', ',dosen.Name, dosen.Gelar) from dosen where dosen.ID = tbl_seminar.IDPenguji1 ) as Penguji1, tbl_judul.judul";

			$join = "inner join mhsw on mhsw.NIM = tbl_seminar.NIM
				inner join tbl_judul on tbl_judul.nim = mhsw.NIM
				inner join tbl_pembimbing on tbl_pembimbing.NIM = tbl_seminar.NIM";
		$where = "tbl_judul.status ='SUDAH ACC' and tbl_seminar.IDSeminar ='".$ID."' and tbl_seminar.JenisSeminar ='Hasil'";

		$seminar = $this->model->getAllJoin('tbl_seminar', $select, $join, $where);
		if(empty($seminar)){
			echo "<script>alert('Data Tidak Ditemukan');</script>
				<script>window.close();</script>";
		}
		$data['mhsw'] = $seminar;

		return $this->view->render('seminar/cetak-berkas-semha', TRUE,$data, null, 'report');	

	}

	public function actionCetakBerkasSempro()
	{
		if(!$this->islogin('013')){
      return $this->view->render('no-access',FALSE);
    } 
		$ID = $this->get('id');

 			$select ="mhsw.NIM, mhsw.Name, mhsw.KodeJurusan, tbl_seminar.*,

			(select CONCAT_WS(', ',dosen.Name, dosen.Gelar) from dosen where dosen.ID = tbl_pembimbing.IDDosen1 ) as Dosen1,
			(select CONCAT_WS(', ',dosen.Name, dosen.Gelar) from dosen where dosen.ID = tbl_pembimbing.IDDosen2 ) as Dosen2,
			(select CONCAT_WS(', ',dosen.Name, dosen.Gelar) from dosen where dosen.ID = tbl_seminar.IDKetua ) as Ketua,
			(select CONCAT_WS(', ',dosen.Name, dosen.Gelar) from dosen where dosen.ID = tbl_seminar.IDPenguji2 ) as Penguji2,
			(select CONCAT_WS(', ',dosen.Name, dosen.Gelar) from dosen where dosen.ID = tbl_seminar.IDPenguji1 ) as Penguji1, tbl_judul.judul";

			$join = "inner join mhsw on mhsw.NIM = tbl_seminar.NIM
				inner join tbl_judul on tbl_judul.nim = mhsw.NIM
				inner join tbl_pembimbing on tbl_pembimbing.NIM = tbl_seminar.NIM";
		$where = "tbl_judul.status ='SUDAH ACC' and tbl_seminar.IDSeminar ='".$ID."' and tbl_seminar.JenisSeminar ='Proposal'";

		$seminar = $this->model->getAllJoin('tbl_seminar', $select, $join, $where);
		if(empty($seminar)){
			echo "<script>alert('Data Tidak Ditemukan');</script>
				<script>window.close();</script>";
		}
		$data['mhsw'] = $seminar;

		return $this->view->render('seminar/cetak-berkas-sempro', TRUE,$data, null, 'report');	

	}
}

