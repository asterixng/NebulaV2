<?php
use Zend\Mvc\Application;

class Controller_Process extends Web_Controller{
	public function __construct(){
		$this->set_auth('ActionIndex');
		$this->set_auth('ActionGetprocess');
		$this->set_auth('ActionTasks');
		$this->set_auth('ActionTest');
		$this->set_auth('ActionCalls');
		$this->set_auth('ActionLogs');
		$this->set_auth('ActionProcexec');
	}

	public function ActionIndex(){
		
		$view = $this->getViewer();
		
		$model = Web_Connector::Query("SELECT * FROM process");
		
		$header = '<table class="table  table-bordered"><thead>
					<tr>
						<th>Processo</th>
						<th>Input Message</th>
						<th>&nbsp;</th>
					</tr>
				</thead><tbody>'; 
		
		$table_row = "";
		
		foreach($model as $row){
			
			$btn_action = '<div class="btn-group">
							  <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
							    <i class="icon-tasks"></i>
							    <span class="caret"></span>
							  </a>
							  <ul class="dropdown-menu">
							    <li>'.Web_Application::ComposeLink(array('css'=>'action_ajax','label'=>'Visualizza','controller'=>'process','action'=>'getprocess?id='.$row['idprocess'])).'</li>
							  </ul>
							</div>';
			
			$table_row .= '<tr><td>'.$row['name'].'</td><td>'.$row['messageStart'].'</td><td>'.$btn_action.'</td></tr>';
			
		}
		
		$table_process = $header . $table_row . '</tbody></table>';
		
		$view->setContent($table_process);
		
		
	}

	public function ActionGetprocess(){
		
		$id = $_GET['id'];
		
		$model = Web_Connector::Query("SELECT * FROM process WHERE idprocess = $id");
		
		$model_task = Web_Connector::Query("SELECT * FROM process_activity WHERE idprocess = $id ORDER BY callorder DESC");
		
		$this->getViewer()->disableOutput();
		
		$html = '<h4>Task legati al processo '.$model[0]['name'] .'</h4>';
		$html .= '<h5>Massaggio Avvio ['.$model[0]['messageStart'].'] &nbsp;&nbsp;&nbsp;&nbsp;<a id="action_ajax_msg" class="btn btn-info" href="javascript:sendMessageSoa(\''.$model[0]['messageStart'].'\',{\'test\':\'handrun\'},\'#ajax_response\')" ><i class=" icon-eye-open" ></i>Esegui</a> </h5> ';
		
		$header = '<table class="table  table-bordered"><thead>
					<tr>
						<th>Classe</th>
						<th>Metodo</th>
						<th>Odr Chiamata</th>
					</tr>
				</thead><tbody>'; 
		
		$table_row = "";
		
		foreach($model_task as $task){
			
			$table_row .= '<tr><td>'.$task['class'].'</td><td>'.$task['method'].'</td><td>'.$task['callorder'].'</td></tr>';
			
		}

		$html .= $header . $table_row . '</tbody></table>';
		
		echo $html;
		//print_r($model_task);
	}
	
	public function ActionTasks(){
		
		
		
	}
	
	public function ActionTest(){
		
		if(isset($_POST['test'])){
			$this->getViewer()->disableOutput();
			
						
			
		} else {
			
			$model = Web_Connector::Query("SELECT * FROM process WHERE enabled = 1");
			
			$button_start = '<a id="button" class="btn btn-info">Avvia Processo</a>';
			
			$select = '<label class="control-label" for="processo">Nome Processo</label><div class="controls"><select id="processo" name="process"><option value="0">--------</option>';
			
			foreach($model as $proc){
				$select .= '<option value="'.$proc['messageStart'].'">'.$proc['name']. ' <= '. $proc['messageStart'].'</option>';
			}
			
			$select .='</select>'.$button_start.'</div>'  ;
			
			
			
			$this->getViewer()->setContent('<form class="form-horizontal" action="" method="post"><fieldset><legend>Parametri Processo</legend><br/>'.$select.'</fieldset></form>' );
		}
		
	}
	
	public function ActionCalls(){
		
		if(isset($_GET['ajax_resolver'])){
			
			$this->getViewer()->disableOutput();
			
			
			
			print_r($_POST);
			
		}
		
	}
	
	public function ActionLogs(){
		
	}

	public function ActionProcexec(){
		
	}


}
	