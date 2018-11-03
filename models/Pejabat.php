<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Prodi
 *
 * @author rolly
 */
class Pejabat extends Model {

    public function __construct(){
      parent::__construct();
    }
    public function tabel() {
        return "tbl_pejabat";
    }


    public function delete($where = null, $page = null) {
      $this->crud->delete(
        $this->tabel(),$where,$page
      );
    }

    public function edit($field = null, $where = null, $page = null) {
      $this->crud->update(
        $this->tabel(), $field, $where, $page
      );
    }

    public function find() {
        $this->crud->select($this->tabel(), "*");
        $data = $this->crud->getResult();
        return json_decode($data, true);
    }

    public function findOne($rows, $where = null, $order = null, $limit = null) {
      $this->crud->select(
        $this->tabel(), $rows, $where
      );
      $data=$this->crud->getResult();
      return json_decode($data,true);
    }

    public function save($rows = null, $page = null) {
      $this->crud->create(
        $this->tabel(), $rows, $page
      );
    }



//put your code here
}
