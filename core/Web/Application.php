<?php
use Zend\View\View;

/**
 * Classe principale del framework web per la gestione del routing e della classe TemplateEngine
 * 
 * @package Web
 *  
 * @author asterix
 *
 */
class Web_Application {
	
	public  static $APP_PATH = 'app';
	
        public static $_theme = "bootstrap";
        
	private static $_tengine= null;
	
	public static $_page_next_login = null;
	
	/**
	 * Punto di ingresso dell'app
	 * Metodo principale che inizializza e manda in running l'application
	 */
	
	public static function Run($theme = "bootstrap"){
            Web_Application::$_theme = $theme;
            Web_Application::Router();
		
	}
	
	/**
	 * Ritorna l'istanza singleton del templating engine
	 * 
	 * @return Object TemplateEngine
	 */
	public static function getTemplateEngineInstance(){
		
		if(is_null(Web_Application::$_tengine)){
			Web_Application::$_tengine = new RainTPL();
			return Web_Application::$_tengine;
		}  else {
			return Web_Application::$_tengine;
		}
		
	} 
	
	/**
	 * Elabora la richiesta HTTP
	 * Viene chiamata dal metoddo Router() se PATH_INFO è presente
	 */
	private static function elaborate_request(){
		
		$mapper = new Web_ApplicationMapper();
		
		$controller = "";
		$action = "";
		
		$return_url_splitted = Array('controller'=>'index');
		
		$splitted_pinfo = explode("/", $_SERVER['PATH_INFO']);
		//print_r($splitted_pinfo);
		if(count($splitted_pinfo) > 1){
			if($splitted_pinfo[1]==""){
				$return_url_splitted['controller']='index';
			} else {
				$return_url_splitted['controller'] = $splitted_pinfo[1];
			}
			if(count($splitted_pinfo) > 2){
				$return_url_splitted['action'] = $splitted_pinfo[2]; 
			} else {
				$return_url_splitted['action'] = 'index';
			}
			
		} else {
			print('malformed url => ' . print_r($_SERVER['PATH_INFO']));
		}
		
		//print_r($return_url_splitted);
		
		return $return_url_splitted; 
	}

	/**
	 * Ritorna la parte html per includere la risorsa css della libreria
	 * 
	 * @param String $resource
	 * @return string
	 */
	public static function loadCssResource($resource){
		
		$resource = str_ireplace('index.php','', $_SERVER['SCRIPT_NAME']) .  Web_Application::$APP_PATH .'/library/css/' . $resource .'.css';
		
		return '<link href="'.$resource.'" type="text/css" rel="stylesheet"></link>';
		
	}
	
	/**
	 * Ritorna la parte html per includere la risorsa JS dalla libreria
	 * 
	 * @param String $resource
	 * @return string
	 */
	public static function loadJsResource($resource){
	
		$resource = str_ireplace('index.php','', $_SERVER['SCRIPT_NAME']) . Web_Application::$APP_PATH .'/library/js/' . $resource .'.js';
	
		return '<script src="'.$resource.'" type="text/javascript"></script>';
	
	}
	
	/**
	 * Crea il link per il template puo essere richiamato da:
	 * 
	 * {function="Web_Application::ComposeLink(array('controller'=>'nomecontroller','label'=>'label link', action=>"nome_azione"))"}
	 * @param unknown $link
	 * @param string $noprint
	 * @return mixed
	 */
	public static function createLink($link,$noprint=false){
		$link_path = str_ireplace('index.php', ''.$link, $_SERVER['SCRIPT_NAME']); 
		if(!$noprint){
			print($link_path);
		} else {
			return $link_path;
		}
	}
	
	public static function ComposeLink($params){
		
		$link = 'index.php/' . $params['controller'];
		$css = '';
		
		if(array_key_exists('action', $params)){
			$link .= '/'.$params['action'];
		}
		
		if(isset($params['css'])){
			$css = $params['css'];	
		}

		$a = '<a class="'.$css.'" href="'.Web_Application::createLink($link,true).'">'.$params['label'].'</a>';
		
		return $a;
	} 
	
	/**
	 * Ritorna la parte html per includere la risorsa immagine dalla libreria
	 * 
	 * FormatType è il formato dell'immagine se non specificato è JPG
	 * 
	 * @param String $resource
	 * @param string $FormatType
	 * @return string
	 */
	public static function loadImageResource($resource,$FormatType='jpg'){
		$resource = str_ireplace('index.php','', $_SERVER['SCRIPT_NAME']) .  Web_Application::$APP_PATH .'/library/image/' . $resource . '.' . $FormatType;
		
		return '<img src="'.$resource.'" />';
		
	} 

	
	/**
	 * Effettua il routing dell'applicazione
	 * 
	 * e inizializza gli oggetti Controller,View e Model se necessario
	 * 
	 * nel caso in cui sia presente il PATH_INFO chiama elaborate_request() ed inizializza i vari componenti necessari
	 * 
	 */
	private static function Router(){
		
		session_start();
		
		Web_Application::getTemplateEngineInstance()->assign("content","&nbsp;");
		
		if(empty($_SERVER['PATH_INFO'])){
			/** you are on home request **/
			
			/** Create an instance of Controller **/
				$controller = Web_Controller::getInstanceOfController("index");
				
			/** Create an instance of view **/
				$view = new Web_View();
				/** Imposto $view nel template sull'istanza di view corrente **/
				Web_Application::$_tengine->assign('view',$view);
				$controller->setViewer($view);
			/** Elaboro l'azione index **/
				$controller->invokeAction('index');
				
				/**
				 * Fa il display della vista
				 * Per disabilitare chiamare il metodo
				 * $view->disableOutput(); nella action
				*/
				
				$view->DisplayMappedActionView('index');
                                $view->setVariable("theme", Web_Application::$_theme);
		} else {
			/** you must elaborate other controller & view **/
			//print($_SERVER['PATH_INFO']);
			$request = Web_Application::elaborate_request();
			
	/** routing the request **/
			
			/** Create an instance of Controller **/
			$controller = Web_Controller::getInstanceOfController($request['controller']);
						
			/** Create an instance of view **/
			$view = new Web_View();
			$view->setVariable("theme", Web_Application::$_theme);
			/** Assegna l'istance of view al controller **/
			$controller->setViewer($view);
			
			/** Imposto $view nel template sull'istanza di view corrente **/
			Web_Application::$_tengine->assign('view',$view);
			
			/** Elaboro l'azione richiesta se  presente altrimenti chiamo index sul controller**/
			if($request['action'] == ""){
				$controller->ActionIndex();
			} else {
				$controller->invokeAction($request['action']);
			}
			
			/** 
			 * Fa il display della vista
			 * Per disabilitare chiamare il metodo 
			 * $view->disableOutput();
			 */ 
			$view->DisplayMappedActionView($request['action']);
		}
		
	}

	public static function redirect($page){
		
		if($page==""){
			header('location:'.str_ireplace('index.php','', $_SERVER['SCRIPT_NAME']).'index.php');
		} else {
			//var_dump($page);
			header('location:'.str_ireplace('index.php','', $_SERVER['SCRIPT_NAME']).'index.php/'.$page);
		}
		
		
		
	}
	
}
