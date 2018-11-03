<?php

class Arsip extends Model {

    public function __construct() {
        parent::__construct();
    }

    public function delete($where = null, $page = null) {
        
    }

    public function edit($field = null, $where = null, $page = null) {
        
    }

    public function find() {
        $data=$this->crud->select("tbl_judul","*");
        $data=$this->crud->getResult();
        return json_decode($data, true);
    }

    public function findOne($rows, $where = null, $order = null, $limit = null) {
        
    }

    public function save($rows = null, $page = null) {
        
    }

    public function tabel() {
        
    }

}

?>
