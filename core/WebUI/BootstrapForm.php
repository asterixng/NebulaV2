<?php
use Zend\Mvc\Application;

class WebUI_BootstrapForm {
	
	private $_form = "";
	
	function __construct($title,$action="",$type="form-horizontal"){
		$this->_form = '
				<form action="'.$action.'" method="post" class="form-ajax '.$type.'">
  					<fieldset>
    					<legend>'.$title.'</legend>"			
				';	
	}
	
	/**
	 * 
	 * crea un form dal seguente array:
	 * 
	 * 	array(
	 * 		
	 * 		array(),
	 * 
	 * )
	 * 
	 * @param array structure $params
	 */
	public function createForm($submit_label,$params){
		
		foreach($params as $field){
				
			if($field['type']=='text'){
				
				$this->addInput($field['id'],$field['title'],$field['placeholder']);
				
			} elseif ($field['type']=='password'){
				$this->addPassword($field['id'],$field['title']);
			} elseif ($field['type']=='textarea'){
				$this->addTextarea($field['id'],$field['message']);
			} elseif ($field['type']=='select'){
				$this->addSelect($field['id'],$field['title'],$options);
			}
			
		}		
		$this->_form .= $this->addSubmitButton($submit_label);
		$this->_form .= '</fieldset></form>';
		
		return $this->_form;
		
	}
	
	private function addInput($id,$title,$placeholder){
		
		$this->_form .= '<div class="form-group">
      						<label for="'.$id.'" class="col-lg-2 control-label">'.$title.'</label>
      						<div class="col-lg-10">
        						<input class="form-control" name="'.$id.'" id="'.$id.'" placeholder="" type="text">
      						</div>
    					</div>';
		
	}
	
	private function addPassword($id,$title){
		$this->_form .= '<div class="form-group">
      						<label for="'.$id.'" class="col-lg-2 control-label">'.$title.'</label>
      						<div class="col-lg-10">
        						<input class="form-control" name="'.$id.'" id="'.$id.'" placeholder="123456" type="password">
      						</div>
    					</div>';
		
	}
	
	private function addTextarea($id,$message=""){
		
		$this->_form .= '<div class="form-group">
                    <label for="'.$id.'" class="col-lg-2 control-label">Textarea</label>
                    <div class="col-lg-10">
                      <textarea class="form-control" rows="3" name="'.$id.'" id="'.$id.'"></textarea>
                      <span class="help-block">'.$message.'</span>
                    </div>
                  </div>';
		
	}
	
	private function addSelect($id,$label,$options){
		
		$this->_form .= '<div class="form-group">
                    <label for="'.$id.'" class="col-lg-2 control-label">'.$label.'</label>
                    <div class="col-lg-10"><select class="form-control" id="'.$id.'">';

		foreach ($options as $key => $value){
			$this->_form .= '<option value="'.$value.'">'.$key.'</option>';
		}
		
        $this->_form .= '</select></div></div>';
		
	}
	
	private function addSubmitButton($label){
		
		$this->_form .= '
                    <div class="col-lg-10 col-lg-offset-2">
                      <button type="submit" class="btn btn-primary">'.$label.'</button>
                    </div>
                  ';
		
	}
	
}
