<?php

/**
 * Description of Dosen
 *
 * @author rolly
 */
class Dosen extends Model {
    //put your code here
    public function __construct() {
        parent::__construct();
    }
     public function tabel(){
      return "dosen";
    }
     public function findOne($rows, $where = null, $order = null, $limit = null){
      
      $this->crud->select(
        $this->tabel(), $rows, $where, $order, $limit
      );
      $data=$this->crud->getResult();
      return json_decode($data, true);
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

    public function save($tabel= null, $rows = null) {
    return $this->crud->insert($tabel, $rows);        
  }

    // public function save($rows = null, $page = null){
    //   $this->crud->create(
    //     $this->tabel(),$rows,$page
    //   );
    // }
    
public function edit($field = null, $where = null, $page = null) {
        return $this->crud->update($this->tabel(), $field, $where, $page);
    }

    public function delete($where = null, $page = null){
      $this->crud->delete($this->tabel(),$where,$page);
    }
     public function find(){
      $this->crud->select($this->tabel(),"*",NULL,"Name ASC");
      $data= $this->crud->getResult();
      return json_decode($data,true);
    }
   
}
