<?php
use Zend\Mvc\Application;

class Controller_Ebooks extends Web_Controller{
	
	public function __construct(){
	
		$this->set_auth('ActionIndex');
	
	}
	
	public function ActionIndex(){
		
		$this->getViewer()->disableOutput();
		// solo per versione PHP=>5.4
		//if(session_status() == PHP_SESSION_ACTIVE && $_POST['sessid'] == session_id()){
		if($_POST['sessid'] == session_id()){
			
			$panel = "";
			
			foreach(CloudDB::find('ebook') as $data){

				$panel .= '<div class="row"><div class="col-md-2">';
				if(array_key_exists('0',$data['data']['CollateralDetail']['SupportingResource'])){
					$panel .= '<img class="thumbnails" width="80" src="' . $data['data']['CollateralDetail']['SupportingResource']['0']['ResourceVersion']['ResourceLink'] .'"/><br/>';
				} else {
					$panel .= '<img class="thumbnails" width="80" src="' . $data['data']['CollateralDetail']['SupportingResource']['ResourceVersion']['ResourceLink'] .'"/><br/>';
				}
				$panel .= '</div><div class="col-md-8">';
				$panel .= '<div class="list-group">
					  <a href="#" data-link="/ebook/view?id='.(string)$data['_id'].'" class="ui-ajax list-group-item">
						<h4 class="list-group-item-heading">'.$data['data']['DescriptiveDetail']['TitleDetail']['TitleElement']['TitleText'].'</h4>
					    <p class="list-group-item-text">'.$data['data']['CollateralDetail']['TextContent']['Text'].'</p>
					  </a>
					</div>';
				$panel .= '</div></div>';
				
			}
			
		
			echo WebUI_BootstrapPanel::getPrimaryPanel("Lista Ebook Importati",$panel);
			
		}
			
	}
	
	
}