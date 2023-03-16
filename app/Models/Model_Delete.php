<?php
namespace App\Models;
use CodeIgniter\Model;//para poder usar la librería Models
class Model_Delete extends Model{
	public function Delete_Data($table, $where){
		$builder = $this->db->table($table);
		$builder->where($where);
		$resultado = $builder->delete();
		if($resultado === true){
			return true;
		}
		else{
			return false;
		}
	}
}
?>