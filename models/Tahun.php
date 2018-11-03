<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Tahun
 *
 * @author rolly
 */
class Tahun extends Model {

	public function tabel() {
		return  'tbl_ta';

	}

	public function getAll()
	{
		$this->crud->select(
			$this->tabel(), "*", null, "kode ASC", null);
		$data=$this->crud->getResult();
		return json_decode($data, true);
	}
	public function delete($where = null, $page = null) {
		$this->crud->delete(
        $this->tabel(),$where,$page
      );
	}

	public function edit($field = null, $where = null, $page = null) {
		return $this->crud->update($this->tabel(), $field, $where, $page);
	}

	public function find() {

	}

	public function findOne($rows, $where = null, $order = null, $limit = null) {

	}

	public function getByID($ID)
	{
		$this->crud->select(
			$this->tabel(), "*", "id_ta ='".$ID."'", null, 1);
		$data=$this->crud->getResult();
		return json_decode($data, true);
	}

	public function save($tabel= null, $rows = null) {
		return $this->crud->insert($tabel, $rows);        
	}



//put your code here
}
