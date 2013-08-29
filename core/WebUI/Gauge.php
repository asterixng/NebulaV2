<?php

class WebUI_Gauge extends WebUI_Component {
	
	private static $_value_ok = '#66CC66';
	private static $_value_warning = '';
	private static $_value_high = '#FF0000';
	
	public static function Design($value,$class,$change_value=false,$color=null,$isReadOnly=true,$data_width="200"){
		
		$read_only = 'true';
		$gauge='';
		
		if(!$isReadOnly){
			$read_only = 'false';
		}
		
		if($change_value){
			$color = '';
		}
		
		if(is_null($color)){
			$gauge = '<input type="text" value="'.$value.'" class="'.$class.'" data-readOnly='.$read_only.' data-width='.$data_width.'>';
		} else {
			$gauge = '<input type="text" value="'.$value.'" class="'.$class.'" data-fgColor="'.$color.'" data-readOnly='.$read_only.'  data-width='.$data_width.' >';
		}
		
		return $gauge;
	}
	
	
}
