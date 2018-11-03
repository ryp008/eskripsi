<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SidangController
 *
 * @author rolly
 */
class SidangController extends Controller{
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
		$data['title'] = "<i class='fa fa-gavel'></i> <b>Sidang</b>";
		$data['sub_title'] = "<i class='fa fa-gavel text-success'></i> <b>Sidang Meja Hijau</b>";

		if(!$this->islogin('012345')){
			return $this->view->render('no-access',FALSE, $data);
		}

		$select = "mhsw.NIM, mhsw.Name, mhsw.KodeJurusan,
		(select CONCAT_WS(', ',dosen.Name, dosen.Gelar) from dosen where dosen.ID = tbl_pembimbing.IDDosen1 ) as Dosen1, 
		(select CONCAT_WS(', ',dosen.Name, dosen.Gelar) from dosen where dosen.ID = tbl_pembimbing.IDDosen2 ) as Dosen2,
		(select CONCAT_WS(', ',dosen.Name, dosen.Gelar) from dosen where dosen.ID = tbl_sidang.IDKetua) as Ketua,
		(select CONCAT_WS(', ',dosen.Name, dosen.Gelar) from dosen where dosen.ID = tbl_sidang.IDPenguji1 ) as Penguji1,
		(select CONCAT_WS(', ',dosen.Name, dosen.Gelar) from dosen where dosen.ID = tbl_sidang.IDPenguji2 ) as Penguji2,
		tbl_sidang.Gelombang, tbl_sidang.Tahun, tbl_sidang.IDSidang";
		$join ="inner join mhsw on mhsw.NIM = tbl_sidang.NIM
		inner join tbl_pembimbing on tbl_pembimbing.NIM = tbl_sidang.NIM";
		$data['sidang'] = $this->model->getAllJoin('tbl_sidang', $select, $join);
		return $this->view->render('sidang/index',FALSE,$data);
	}

	public function actionSidangMhsw()
	{
		$data['title'] = "<i class='fa fa-gavel'></i> <b>Sidang</b>";
		$data['sub_title'] = "<i class='fa fa-gavel text-success'></i> <b>Sidang Meja Hijau</b>";

		if(!$this->islogin('015')){
			return $this->view->render('no-access',FALSE, $data);
		}

		$NIM = Session::get('username');

		$select = "mhsw.NIM, mhsw.Name, mhsw.KodeJurusan,
		(select CONCAT_WS(', ',dosen.Name, dosen.Gelar) from dosen where dosen.ID = tbl_pembimbing.IDDosen1 ) as Dosen1, 
		(select CONCAT_WS(', ',dosen.Name, dosen.Gelar) from dosen where dosen.ID = tbl_pembimbing.IDDosen2 ) as Dosen2,
		(select CONCAT_WS(', ',dosen.Name, dosen.Gelar) from dosen where dosen.ID = tbl_sidang.IDKetua) as Ketua,
		(select CONCAT_WS(', ',dosen.Name, dosen.Gelar) from dosen where dosen.ID = tbl_sidang.IDPenguji1 ) as Penguji1,
		(select CONCAT_WS(', ',dosen.Name, dosen.Gelar) from dosen where dosen.ID = tbl_sidang.IDPenguji2 ) as Penguji2,
		tbl_sidang.Gelombang, tbl_sidang.Tahun, tbl_sidang.IDSidang";
		$join ="inner join mhsw on mhsw.NIM = tbl_sidang.NIM
		inner join tbl_pembimbing on tbl_pembimbing.NIM = tbl_sidang.NIM";
		$data['sidang'] = $this->model->getAllJoin('tbl_sidang', $select, $join, "mhsw.NIM='".$NIM."'");
		return $this->view->render('sidang/index',FALSE,$data);
	}

	public function actionPendaftaranSidang()
	{

		$data['title'] = "<i class='fa fa-gavel'></i> <b>Sidang</b>";
		$data['sub_title'] = "<i class='fa fa-gavel'></i> <b>Pendaftaran Sidang</b>";

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
		return $this->view->render('sidang/form-sidang',FALSE,$data);	
	}

	public function actionSimpanSidang()
	{
		if(!$this->islogin('013')){
			return $this->view->render('no-access',FALSE);
		}

		if(isset($_POST['submit'])){

			$data_input = array(
				'NIM'          => $this->post('NIM'),
				'Prodi'        => $this->post('Prodi'),
				'IDKetua'      => $this->post('Ketua'),
				'IDPenguji1'     => $this->post('Penguji1'),
				'IDPenguji2'     => $this->post('Penguji2'),
				'Tanggal'      => $this->post('Tanggal'),
				'Jam'          => $this->post('Jam'),
				'Ruang'        => $this->post('Ruang'),
				'Tahun'        => $this->post('Tahun'),
				'Gelombang'    => $this->post('Gelombang'),
				'Sidang'      => 'Y'
			);
			$insert = $this->model->save('tbl_sidang', $data_input);
			if($insert){
				echo "<script>alert('Sudah disimpan');</script>
				<script>window.location.assign('?p=Sidang');</script>";
			}else{
				echo "<script>alert('Gagal disimpan');</script>
				<script>window.location.assign('?p=Sidang');</script>";
			}

		}else{
			echo "<script>window.location.assign('?p=Sidang');</script>";

		}
	}

	public function actionDetSidang()
	{
		$data['title'] = "<i class='fa fa-gavel'></i> <b>Sidang</b>";
		$data['sub_title'] = "<i class='fa fa-gavel'></i> <b>Detail Sidang</b>";

		if(!$this->islogin('012345')){
			return $this->view->render('no-access',FALSE, $data);
		}

		$ID = $this->get('id');

		$data['back'] = '?p=Seminar&x=SeminarProposalMhsw';
		$data['dosen'] = $this->model->getAll('dosen', "ID, CONCAT_WS(', ',Name, dosen.Gelar) as NamaDosen", null, "Name ASC");

		$select ="mhsw.NIM, mhsw.Name, mhsw.KodeJurusan, tbl_judul.judul, 
		(select CONCAT_WS(', ',dosen.Name, dosen.Gelar) from dosen where dosen.ID = tbl_pembimbing.IDDosen1 ) as Dosen1, 
		(select CONCAT_WS(', ',dosen.Name, dosen.Gelar) from dosen where dosen.ID = tbl_pembimbing.IDDosen2 ) as Dosen2, tbl_sidang.*";
		$join = "inner join mhsw on mhsw.NIM = tbl_sidang.NIM
		inner join tbl_judul on tbl_judul.nim = mhsw.NIM
		inner join tbl_pembimbing on tbl_pembimbing.NIM = tbl_sidang.NIM";
		$where = "tbl_judul.status ='SUDAH ACC' and tbl_sidang.IDSidang ='".$ID."'";

		$sidang = $this->model->getAllJoin('tbl_sidang', $select, $join, $where);
		if(empty($sidang)){
			echo "<script>alert('Data Tidak Ditemukan');</script>
			<script>window.location.assign('?p=Sidang');</script>";
		}
		$data['mhsw'] = $sidang;

		return $this->view->render('sidang/detail-sidang',FALSE,$data);	

	}

	public function actionEditSidang()
	{
		$data['title'] = "<i class='fa fa-gavel'></i> <b>Sidang</b>";
		$data['sub_title'] = "<i class='fa fa-edit'></i> <b>Edit Sidang</b>";

		if(!$this->islogin('013')){
			return $this->view->render('no-access',FALSE, $data);
		}

		$ID = $this->get('id');

		$data['dosen'] = $this->model->getAll('dosen', "ID, CONCAT_WS(', ',Name, dosen.Gelar) as NamaDosen", null, "Name ASC");

		$select ="mhsw.NIM, mhsw.Name, mhsw.KodeJurusan, tbl_judul.judul, tbl_pembimbing.IDDosen1, tbl_pembimbing.IDDosen2,
		(select CONCAT_WS(', ',dosen.Name, dosen.Gelar) from dosen where dosen.ID = tbl_pembimbing.IDDosen1 ) as Dosen1,
		(select CONCAT_WS(', ',dosen.Name, dosen.Gelar) from dosen where dosen.ID = tbl_pembimbing.IDDosen2 ) as Dosen2, tbl_sidang.*";
		$join = "inner join mhsw on mhsw.NIM = tbl_sidang.NIM
		inner join tbl_judul on tbl_judul.nim = mhsw.NIM
		inner join tbl_pembimbing on tbl_pembimbing.NIM = tbl_sidang.NIM";
		$where = "tbl_judul.status ='SUDAH ACC' and tbl_sidang.IDSidang ='".$ID."'";

		$sidang = $this->model->getAllJoin('tbl_sidang', $select, $join, $where);
		if(empty($sidang)){
			echo "<script>alert('Data Tidak Ditemukan');</script>
			<script>window.location.assign('?p=sidang');</script>";
		}
		$data['mhsw'] = $sidang;

		return $this->view->render('sidang/form-edit-sidang',FALSE,$data);	

	}

	public function actionSimpanEditSidang()
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
			$insert = $this->model->edit($data_input, "IDSidang ='".$ID."'");
			if($insert){
				echo "<script>alert('Sudah diubah');</script>
				<script>window.location.assign('?p=Sidang');</script>";
			}else{
				echo "<script>alert('Gagal diubah');</script>
				<script>window.location.assign('?p=Sidang');</script>";
			}

		}else{
			echo "<script>window.location.assign('?p=Sidang');</script>";

		}
	}

	public function actionCetakBerkasSidang()
	{
		if(!$this->islogin('013')){
			return $this->view->render('no-access',FALSE);
		}
		
		$ID = $this->get('id');

		$select ="mhsw.NIM, mhsw.Name, mhsw.KodeJurusan, tbl_sidang.*,

		(select CONCAT_WS(', ',dosen.Name, dosen.Gelar) from dosen where dosen.ID = tbl_pembimbing.IDDosen1 ) as Dosen1,
		(select CONCAT_WS(', ',dosen.Name, dosen.Gelar) from dosen where dosen.ID = tbl_pembimbing.IDDosen2 ) as Dosen2,
		(select CONCAT_WS(', ',dosen.Name, dosen.Gelar) from dosen where dosen.ID = tbl_sidang.IDKetua ) as Ketua,
		(select CONCAT_WS(', ',dosen.Name, dosen.Gelar) from dosen where dosen.ID = tbl_sidang.IDPenguji2 ) as Penguji2,
		(select CONCAT_WS(', ',dosen.Name, dosen.Gelar) from dosen where dosen.ID = tbl_sidang.IDPenguji1 ) as Penguji1, tbl_judul.judul";

		$join = "inner join mhsw on mhsw.NIM = tbl_sidang.NIM
		inner join tbl_judul on tbl_judul.nim = mhsw.NIM
		inner join tbl_pembimbing on tbl_pembimbing.NIM = tbl_sidang.NIM";
		$where = "tbl_judul.status ='SUDAH ACC' and tbl_sidang.IDSidang ='".$ID."'";

		$seminar = $this->model->getAllJoin('tbl_sidang', $select, $join, $where);
		if(empty($seminar)){
			echo "<script>alert('Data Tidak Ditemukan');</script>
			<script>window.close();</script>";
		}
		$data['mhsw'] = $seminar;

		return $this->view->render('sidang/cetak-berkas-sidang', TRUE,$data, null, 'report');	

	}
}
