<?php
abstract class Model {
    public $crud;
    public function __construct() {
        $this->crud = new ProcessDB();
    }
    abstract public function tabel();
    abstract public function find();
    abstract public function findOne($rows, $where = null, $order = null, $limit = null);
    abstract public function save($rows = null, $page = null);
    abstract public function edit($field = null, $where = null, $page = null);
    abstract public function delete($where = null, $page = null);
}
