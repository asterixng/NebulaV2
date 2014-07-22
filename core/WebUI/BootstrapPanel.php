<?php

class WebUI_BootstrapPanel {
	
	public static function getPrimaryPanel($title,$content){
		
		return '<div class="panel panel-primary">
				  <div class="panel-heading">
				    <h3 class="panel-title">'.$title.'</h3>
				  </div>
				  <div class="panel-body">
				    '.$content.'
				  </div>
				</div>';
		
	}
	
	public static function getSuccessPanel($title,$content){
	
		return '<div class="panel panel-success">
				  <div class="panel-heading">
				    <h3 class="panel-title">'.$title.'</h3>
				  </div>
				  <div class="panel-body">
				    '.$content.'
				  </div>
				</div>';
	
	}
	
	public static function getWarningPanel($title,$content){
	
		return '<div class="panel panel-warning">
				  <div class="panel-heading">
				    <h3 class="panel-title">'.$title.'</h3>
				  </div>
				  <div class="panel-body">
				    '.$content.'
				  </div>
				</div>';
	
	}
	
	public static function getDangerPanel($title,$content){
	
		return '<div class="panel panel-danger">
				  <div class="panel-heading">
				    <h3 class="panel-title">'.$title.'</h3>
				  </div>
				  <div class="panel-body">
				    '.$content.'
				  </div>
				</div>';
	
	}
	
	public static function getInfoPanel($title,$content){
	
		return '<div class="panel panel-info">
				  <div class="panel-heading">
				    <h3 class="panel-title">'.$title.'</h3>
				  </div>
				  <div class="panel-body">
				    '.$content.'
				  </div>
				</div>';
	
	}
	
}