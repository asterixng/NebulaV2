<?php

class WebUI_Component {
	
	protected $_html_component ="";
	
	protected $_component_name = null;
	
	protected $_css_class = null;
	protected $_style = null;
	
	protected $_open_tag = null;
	protected $_close_tag = null;
	
	public function __construct(){
		
	}
	
	
	/**
	 * Disegna il componente
	 * 
	 * params è un array formato come segue
	 * 
	 * array (
	 * 	
	 * 	'component' => 'Table', // Viene pèassato solo al metodo della view
	 * 	'name'		=> 'nome_componente',
	 * 	'params'	=> array(
	 * 		'css_class' => 'classe css',
	 * 		'style'		=>	'css style',
	 * 		'visible_row' => 12,
	 * 		)
	 * 	'widget'		=> 'funzione da chiamare su widget'
	 * 	'param_widget'	=> 'parametro da passare a widget',
	 * )
	 * 
	 * @param unknown $params
	 */
	public function placeComponent($function_content,$params){
		
		$this->addOpenTag();
		//print_r($params);
		$this->addContent($function_content,$params);
		$this->addCloseTag();
		
		print($this->_html_component);
	}
	
	protected function addHtmlText($html){
		$this->_html_component .= $html;
	}
	
	protected function addOpenTag(){
		$this->addHtmlText($this->_open_tag);
	}
	
	protected function addContent($function_content,$params){
		$class = new ReflectionClass(get_class($this));
		if($class->hasMethod($function_content)){
			
			$method = new ReflectionMethod($class->getName(), $function_content);
			$method->invokeArgs($this, $params);
			
		} else {
			throw new Exception('Function '. $function_content .' not implemented');
		}
	}
	
	protected function addCloseTag(){
		$this->addHtmlText($this->_close_tag);
	} 
	
}