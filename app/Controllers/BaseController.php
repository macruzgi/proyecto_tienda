<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var array
     */
    protected $helpers = ['url', 'form', 'session'];

    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */
     protected $session;

    /**
     * Constructor.
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.

        // E.g.: $this->session = \Config\Services::session();
		//para la validacion
		$this->validacion = \Config\Services::validation();
		//para los request
		$this->request    = \Config\Services::request();
		//para el uso de las sesiones
		$this->session    = \Config\Services::session();
		//cargo el helpers
		helper('respuestas');
    }
	protected function isLoggedIn()
    {
		if(!session('chequear')){
			throw new \CodeIgniter\Router\Exceptions\RedirectException('/');
		}
		else{
			return true;
		}
        //return session('chequear') ?? false;
    }
	public function Ver_Si_Usuario_Tiene_Acceso_A_la_Opcion($id_modulo_opcion, $permiso){
		/*if (in_array("$id_modulo_opcion", session('ids_modulo_opciones'))) {
				
		}else{
				throw new \CodeIgniter\Router\Exceptions\RedirectException('/Error_De_Acceso');
		}*/
		 foreach(session('ids_modulo_opciones') as $opcion) {
			if($opcion['id_modulo_opcion'] == $id_modulo_opcion) {
				if($opcion[$permiso] == 1) {
					return true;
				} else {
					throw new \CodeIgniter\Router\Exceptions\RedirectException('/Error_De_Acceso');
				}
			}
		}
		throw new \CodeIgniter\Router\Exceptions\RedirectException('/Error_De_Acceso');
	}
	protected function Validar_Campos($rules, $errors) {
		$this->validacion->setRules($rules);
		//$this->validacion->setErrors($errors);

		if (!$this->validacion->withRequest($this->request)->run()) {
			$respuesta = array(
				"respuesta" => 0,
				"mensaje" => $this->validacion->listErrors(),
				"clase_css" => "alert alert-danger alert-dismissible"
			);
			return json_encode($respuesta);
		}
	}
	protected function Errores_No_Existe_Registro(){
		
		throw new \CodeIgniter\Router\Exceptions\RedirectException('/Errores_No_Existe_Registro');
	}
}
