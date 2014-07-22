<?php
/**
 * Fornisce le funzioni per lavorare sul template engine
 * 
 * i TAG che si possono usare all'interno del template sono:
 * {$variable_name}
 * {#constant#}
 * {if="condition"}
 * {loop="array"}
 * {include="template"}
 * {function="myFunc"}
 * {noparse}
 * {* comment *}
 * 
 * Per accedere alle variabili globali usare il tag
 *  {$GLOBALS}
 *  
 * @author Bentenuto Bruno
 *
 */

class Web_View {
	
	private $_disable_output = false;
	
	public static $_ContextView = null;
	
	public static function LinkInContext($controller,$action='view'){
		
		$isInContext = '';
				
		$context_link = $controller .':' . $action;
		
		if(!strcmp($context_link, Web_View::$_ContextView)){
			$isInContext = ' active ';
		}
		
		return $isInContext;
	} 
	
	public function __construct(){
		$this->elaborateContext();	
		$this->setContent("");
		$this->setContentPart("", "context_bottom");
		$this->setContentPart("", "context_up");
	}
	
	/**
	 * Setta un avariabile nel tempalte engine
	 * 
	 * usare il tag {$nomevar} nel template per singola variabile
	 * usare il tag {$nome.variabile} per array
	 *  
	 * @param unknown $variable
	 * @param unknown $value
	 */
	public function setVariable($variable,$value){
		Web_Application::getTemplateEngineInstance()->assign($variable,$value);
	}
	
	
	/**
	 * Aggiunge contenuto al tag content
	 * da usare all'interno dei metodi action del controller
	 * 
	 */
	public function setContent($html_content){
		$this->setVariable('content', $html_content);
	}
	
	/**
	 * Setta il contenuto html all'interno di una part descritta da un tag del template
	 * 
	 * @param String $html_content
	 * @param String $part
	 */
	public function setContentPart($html_content,$part){
		
		$this->setVariable($part,$html_content);
		
	}
	
	/**
	 * Setta le variabili di un array associativo direttamente sul template
	 * 
	 * @param unknown $array
	 */
	public function setExplodedArray($array){
		
		foreach($array as $key => $val){
			$this->setVariable($key, $val);
		}
		
	}

	public function __call($method,$arguments){
		throw new Exception("Called a non exist method on View " .get_class($this) );
	}
	
	/**
	 * Effettua la visualizzazione della vista mappata con l'action in esecuzione
	 * 
	 * @param unknown $action
	 */
	public function DisplayMappedActionView($action){
		if(!$this->_disable_output){
			if($action=""){
				$action="index";
			}
			
			$mapper = new Web_ApplicationMapper();
			$template_mapped = $mapper->getMappedView($action);
			try{
			$tengine = Web_Application::getTemplateEngineInstance();
			$tengine->draw($template_mapped);
			}catch(RainTpl_NotFoundException $tplex){
				print($tplex->getMessage() . ' ['.$template_mapped.'] ');
			}catch(Exception $ex){
				
			}
		} 		
	}
	
	/**
	 * Elabora il contesto della richiesta in running
	 */
	public function elaborateContext(){
		
		$context = new Web_Context();
		
		$context->createContext();
		
		Web_View::$_ContextView = $context->getContext();
		
		$this->setVariable("context", $context->getContext());
		$this->setVariable("user", $context->userInContext());
		
	}
	
	/**
	 * Impedisce che il template associato alla action venga elaborato
	 * questo permette di lavorare conb richieste ajax senza effettuare di nuovo l'elaborazione del template principale
	 *  
	 */
	public function disableOutput(){
		$this->_disable_output = true;
	}
	
	/**
	 * Elabora un frammento di pagina e la ritorna come stringa
	 * 
	 * NB: Il fragmento deve trovarsi all'interno della cartella fragment dentro la cartella dei template
	 * 
	 * @param string $fragment
	 * @return String $html;
	 */
	public function getPageFragmentContent($fragment){
		
		return Web_Application::getTemplateEngineInstance()->draw(''.$fragment,true);
		
	}
	
	/**
	 * Ritorna il nome della View corrente
	 * 
	 * @return string
	 */
	public function getViewName(){
		return get_class($this);
	}
	
	
	public function displayLoginForm(){
		$this->DisplayMappedActionView('login');
		exit;
	}
	
	
	/**
	 * Disegna il componente
	 *
	 * widget_params è un array formato come segue
	 *
	 * widget_params = array (
	 *
	 * 	'widget' => 'Table', // Viene passato solo al metodo della view
	 * 	'name'		=> 'nome_componente',
	 * 	'params_widget'	=> array(
	 * 		'css_class' => 'classe css',
	 * 		'style'		=>	'css style',
	 * 		'visible_row' => 12,
	 * 		)
	 * 	'design_by'		=> 'funzione da chiamare su widget'
	 * 	'params_design'	=> 'parametro da passare a widget',
	 * 
	 * )
	 * */
	public function GetWidget($widget_params){
		
		$widget =  "WebUI_" . ucfirst($widget_params['widget']);
		$design_method = $widget_params['design_by'];
		$name_widget = $widget_params['name'];
		if(isset($widget_params['params_widget'])){
			$param_widget = $widget_params['params_widget'];
		}else{
			$param_widget = array();
		}
		$arguments_design = $widget_params['params_design'];
		
		$reflection_widget = new ReflectionClass($widget);
		$object_widget = $reflection_widget->newInstanceArgs(array($name_widget,$param_widget));
		
		$object_widget->placeComponent($design_method,$arguments_design);
		
	}
}