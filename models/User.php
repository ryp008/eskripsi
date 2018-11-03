<?php


class User extends Model{
	public function __construct(){
		parent::__construct();
	}

	public function table()
	{
		return "tbl_user";
	}

	public function cekAdmin($user, $password)
	{
		$this->crud->select($this->table(), "*", "user_name = '".$user."' and password ='".md5($password)."'");
        $data=$this->crud->getResult();
        // return $data;
         return json_decode($data,true);
	}

	public function getAllJoin($table, $rows =null, $join =null, $where =null, $order =null, $limit = null)
    {
       $this->crud->selectjoin($table, $rows, $join, $where, $order);
        $data=$this->crud->getResult();
        return json_decode($data,true);
    }

    public function getAll($table, $rows, $where = null, $order = null, $limit = null)
    {
      $this->crud->select($table, $rows, $where, $order, $limit);
      $data= $this->crud->getResult();
      return json_decode($data,true);
    }

	public function LoginDosenMhsw($table, $user, $password)
	{
		$this->crud->select($table, "*", "Login ='".$user."' and Password=LEFT(PASSWORD('$password'),10)");
        $data=$this->crud->getResult();
        // return $data;
         return json_decode($data,true);
	}

	public function cekAktif($NIM)
	{
		$this->crud->select('tbl_aktivasi_mhs', "*", "NIM ='".$NIM."'");
        $data=$this->crud->getResult();
        // return $data;
         return json_decode($data,true);
	}

	public function edit($table = null, $field = null, $where = null, $page = null) {
		return $this->crud->update($table, $field, $where, $page);
	}

	public function edit2($table = null, $field = null, $where = null, $page = null) {
		return $this->crud->update2($table, $field, $where, $page);
	}

	public function find()
	{}

	public function findOne($rows, $where = null, $order = null, $limit = null)
	{
		$this->crud->select($this->tabel(), "*", $where);
        $data=$this->crud->getResult();
        //return json_decode($data,true);
	}
	public function save($tabel= null, $rows = null) {
    return $this->crud->insert($tabel, $rows);        
  }

	public function tabel()
	{
		return "tbl_user";
	}

	public function delete($where = null, $page = null) {
        $this->crud->delete(
        $this->tabel(),$where,$page
      );
    }

    public function delete2($table, $where = null, $page = null) {
        $this->crud->delete(
        $table,$where,$page
      );
    }

}


?>
