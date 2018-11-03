<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Surat
 *
 * @author rolly
 */
class Surat extends Model{
    public function delete($where = null, $page = null) {
        
    }

    public function edit($field = null, $where = null, $page = null) {
        
    }

    public function getAll($table, $rows, $where = null, $order = null, $limit = null)
    {
      $this->crud->select($table, $rows, $where, $order, $limit);
      $data= $this->crud->getResult();
      return json_decode($data,true);
    }

    public function getAllJoin($table, $rows =null, $join =null, $where =null, $order =null, $limit = null)
    {
       $this->crud->selectjoin($table, $rows, $join, $where, $order);
        $data=$this->crud->getResult();
        return json_decode($data,true);
    }

    public function find() {
        
    }

    public function findOne($rows, $where = null, $order = null, $limit = null) {
        
    }

    public function save($rows = null, $page = null) {
        
    }

    public function tabel() {
        
    }

//put your code here
}
