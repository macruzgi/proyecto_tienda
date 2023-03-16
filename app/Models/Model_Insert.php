<?php
namespace App\Models;
use CodeIgniter\Model;//para poder usar la librería Models
class Model_Insert extends Model{
	public function Insert_Data($table, $data){
		$builder = $this->db->table($table);
		$resultado = $builder->insert($data);

		/*$affectedRows = $this->db->affectedRows();
		
		if ($affectedRows > 0) {
			return $this->db->insertID();
		} else {
			return false;
		}
		*/
		if($resultado === true){
			return true;
		}
		else{
			return false;
		}
	}
}
?>