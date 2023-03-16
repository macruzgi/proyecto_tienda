<?php
namespace App\Models;
use CodeIgniter\Model;//para poder usar la librería Models
class Model_Update extends Model{
	public function Update_Data($table, $data, $where){
		$builder = $this->db->table($table);
		$builder->set($data);
		$builder->where($where);
		$resultado = $builder->update();
		if($resultado === true){
			return true;
		}
		else{
			return false;
		}
	}
}
?>