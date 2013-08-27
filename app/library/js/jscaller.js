var ws_repo = '/ws/wsrouter.php';


function sendMessageSoa(message,json_data,log){
	
	json_data.message = message;
	
	console.log(json_data);
	
	console.log('Invio Messaggio ' + message);
	
	$.post(ws_repo,json_data,function(data){
		
		$(log).html(data);
		
	}).done(function() { $(log).append("<b>Chiamata Inviata con successo</b>"); }).fail(function() { $(log).append("errore nell'invio del messaggio"); });
	
}