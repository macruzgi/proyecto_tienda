<?php
namespace App\Models;
use CodeIgniter\Model;//para poder usar la librería Models
class Model_Select extends Model{
	public function Select_Data($table_name, $columns, $where = array(), $order_by = '', $limit = '', $or_where = array(), $group_by = '', $where_in = array(), $having = '')
	{
		//$db = \Config\Database::connect();

		$builder = $this->db->table($table_name);

		$builder->select($columns);

		if (!empty($where)) {
			$builder->where($where);
		}
		
		if (!empty($or_where)) {
			$builder->orWhere($or_where);
		}
		
		if (!empty($where_in)) {
			$builder->whereIn(key($where_in), $where_in[key($where_in)]);
		}
		if ($order_by) {
			$builder->orderBy($order_by);
		}

		if ($limit) {
			$builder->limit($limit);
		}
		if($group_by) {
			$builder->groupBy($group_by);
		}
		if ($having) {
			$builder->having($having);
		}

		$query = $builder->get();

		return $query->getResult();
	}
}
?>