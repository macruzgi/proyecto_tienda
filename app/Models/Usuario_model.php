<?php
namespace App\Models;
use CodeIgniter\Model;//para poder usar la librería Models
class Usuario_model extends Model{
	public function Traer_Usuario_Login($adm_usuario){
		$resultado = $this->db->query("select u.codigousuario , u.nombreusuario , u.nombre, u.id_tipo_usuario from usuarios u where u.estado= 1 and u.nombreusuario = ? and u.contrasena = ?", array($adm_usuario["nombreusuario"], $adm_usuario["contrasena"]));
		if($resultado->getNumRows() > 0){
			return $resultado->getRow();
		}
		else{
			return false;
		}
	}
	public function Traer_Ususuarios(){
		$resultado = $this->db->query("select u.codigousuario , u.nombreusuario , u.id_tipo_usuario , u.nombre, u.estado, tipou.tipousu_nombre  from usuarios u 
		inner join adm_tipos_usuario tipou on(tipou.id_tipo_usuario = u.id_tipo_usuario)
		order by u.codigousuario desc");
		if($resultado->getNumRows() > 0){
			return $resultado->getResult();
		}
		else{
			return false;
		}
	}
	public function Taer_Opciones_Del_Menu($id_usuario){
		$resultado = $this->db->query("select u.codigousuario , u.nombreusuario, u.nombre,
		amou.tiene_permiso, amou.agregar, amou.eliminar, amou.actualizar,
		amo.id_modulo_opcion , amo.nombre_opcion, amo.link, amo.opcion_orden ,
		am.id_modulo, am.nombre_modulo, am.fa_menu 
		from usuarios u 
		inner join adm_modulo_opcion_usuario amou on (amou.id_usuario = u.codigousuario)
		inner join adm_modulo_opcion amo on(amo.id_modulo_opcion = amou.id_modulo_opcion)
		inner join adm_modulo am on (am.id_modulo = amo.id_modulo)
		where amou.id_usuario = ? and amou.tiene_permiso = 1 and amo.opcion_estado  = 1 order by am.id_modulo , amo.opcion_orden asc", $id_usuario);
		if($resultado->getNumRows() > 0){
			return $resultado->getResult();
		}
		else{
			return false;
		}
	}
	public function Traer_Todos_Los_Permisos($id_usuario){
		$resultado = $this->db->query("select u.codigousuario , u.nombreusuario, u.nombre,
amou.tiene_permiso, amou.agregar, amou.eliminar, amou.actualizar, 
amo.id_modulo_opcion , amo.nombre_opcion, amo.link,
am.id_modulo, am.nombre_modulo 
from usuarios u 
inner join adm_modulo_opcion_usuario amou on (amou.id_usuario = u.codigousuario)
inner join adm_modulo_opcion amo on(amo.id_modulo_opcion = amou.id_modulo_opcion)
inner join adm_modulo am on (am.id_modulo = amo.id_modulo)
where amou.id_usuario = ?  order by am.id_modulo asc", $id_usuario);
		if($resultado->getNumRows() > 0){
			return $resultado->getResult();
		}
		else{
			return false;
		}
	}
	public function Actualizar_Opciones_Permitidas($usuario_opciones){
		//primer update es para actualizar todas las opciones del menu a 0 es decir el campo tiene_permiso, agregar, actualizar, eliminar establecerlo a 0
		$dato_actualizar = array(
			"tiene_permiso"=>0,
			"agregar"=>0,
			"actualizar"=>0,
			"eliminar"=>0
		);
		$update = $this->db->table("adm_modulo_opcion_usuario");
		$update->where("id_usuario", $usuario_opciones["id_usuario"]);
		$resultado = $update->update($dato_actualizar);
		
		//siguiente itero las opciones marcadas y por cada opcion itero los permisos asignados, tiene_permiso (ver), agregar, actualizar y eliminar
		
		foreach ($usuario_opciones["id_opciones"] as $id_modulo_opcion) {
			 $data = array();
			
			if(is_array($usuario_opciones["id_opciones"])) {
				foreach($usuario_opciones["id_opciones"] as $value){
					$data['tiene_permiso'] = 1;
					$update->where("id_usuario", $usuario_opciones["id_usuario"]);
					$update->where("id_modulo_opcion", $value);
					$update->update($data);
				}
			}
			if(is_array($usuario_opciones["agregar"])) {
				foreach($usuario_opciones["agregar"] as $value){
					$data['agregar'] = 1;
					$update->where("id_usuario", $usuario_opciones["id_usuario"]);
					$update->where("id_modulo_opcion", $value);
					$update->update($data);
				}
			}
			if(is_array($usuario_opciones["actualizar"])) {
				foreach($usuario_opciones["actualizar"] as $value){
					$data['actualizar'] = 1;
					$update->where("id_usuario", $usuario_opciones["id_usuario"]);
					$update->where("id_modulo_opcion", $value);
					$update->update($data);
				}
			}
			if (is_array($usuario_opciones["eliminar"])) {
				foreach($usuario_opciones["eliminar"] as $value){
					$data['eliminar'] = 1;
					$update->where("id_usuario", $usuario_opciones["id_usuario"]);
					$update->where("id_modulo_opcion", $value);
					$update->update($data);
				}
			}
		}
 
		
		if($resultado === true){
			return true;
		}
		else{
			return false;
		}
	}
	public function Agregar_Usuario($usuarios){
	
		//inicio transaccion
		$this->db->transBegin();
		$resultado =$this->db->table("usuarios");
		$resultado->insert($usuarios);
		//traigo el ultimo codigousuario insertado
		$codigousuario = $this->db->insertId();
		$this->db->query("insert into adm_modulo_opcion_usuario (id_usuario, id_modulo_opcion)
		select ?, amo.id_modulo_opcion  from adm_modulo_opcion amo", $codigousuario);
		//se comprueba el estado de la transaccion
		if ($this->db->transStatus() === false) {
			$this->db->transRollback();
			return false;
		} else {
			$this->db->transCommit();
			return true;
		}
		
	}
}
?>