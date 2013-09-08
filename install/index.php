<?php

?>

<html>
	<head>
		<script type="text/javascript" src="./js/jquery.min.js"></script>
		<script type="text/javascript" src="./js/jquery-ui.min.js"></script>
		
		<link type="text/css" rel="stylesheet" href="css/cupertino/jquery-ui-1.10.3.custom.min.css" />
		<link type="text/css" rel="stylesheet" href="css/bootstrap.min.css" />
		
		<style type="text/css">
			html,body {
				font-family: 'Segoe UI','Segoe','Segoe WP',' Tahoma','Verdana','Arial','sans-serif';
				color: rgb(51, 51, 51);
				font-weight: normal;
				
			}
		
			h2 {
				cursor:pointer;
			}
			body {
				background-color:#6cf;
			}
			#header {
				background-color:#eee;
				margin-top:20px;
				padding:20px;
			}
			
			#installproc {
				background-color:#fff;
				margin-top:20px;
				padding:20px;
			}
			
			#requirement {
				background-color:#eee;
				margin-top:20px;
				padding:20px;
			}
			
			#console_log {
				
				background:black;
				font-family:courier;
				color:#090;
				padding:10px;
			}
		</style>
		<script>

			$(function(){
					$('#console_log').hide();
					$('#require_content').hide();
					$('#console_content').hide();
					$('#clear').click(function(){
						$('#console_log').html('&nbsp;');
					});
					$('#close').click(function(){
						
						if($('#console_log').is(':visible')){
							$('#console_log').hide();	
							$(this).html('Open Console');					
							
						} else {
							$('#console_log').show();	
							$(this).html('Close Console');					
								
						}
					});
					
					$('#require').click(function(){
						if( $('#require_content').is(':visible') ){
								$('#require_content').hide();
							} else {
								$('#require_content').show();
							}
						});
					$('#console').click(function(){
						if( $('#console_content').is(':visible') ){
								$('#console_content').hide();
							} else {
								$('#console_content').show();
							}
						});

					$('.btn').click(function(){

						var id = $(this).attr('id');
						$.post('command.php',{cmd:id},function(data){
							$('#console_log').show();
							$('#console_log').append('<br/>'+data);
						});
					});

					
				});

		</script>
	</head>
	<body>
		
		<div id="header" class="container ui-corner-all">
			<div class="row">
				<div class="span4" style="text-align:center;">
					<img src="image/Blue-Mobile-Me-icon.png" />
				</div>
				<div class="span8">
					
					<h1>Framework Nebula V2</h1>
					<h3>Installation Procedure</h3>
							
				</div>
			</div>
		</div>
		
		<div id="requirement" class="container ui-corner-all">
			
			<h2 id="require">Requirements &amp; Status</h2>
			<div id="require_content" class="span11">
			<hr/>
			<div class="row">
				<div class="span2" style="text-align:right;font-weight:bold;">Memory</div>
				<div class="span1"><?php echo str_ireplace("M", "&nbsp;Mb", ini_get('post_max_size'));?></div>
				<div class="span2" style="text-align:right;font-weight:bold;">File Upload</div>
				<div class="span1" ><?php echo str_ireplace("M", "&nbsp;Mb", ini_get('max_file_uploads'));?></div>
				<div class="span2" style="text-align:right;font-weight:bold;">Max Exec Time</div>
				<div class="span1"><?php echo str_ireplace("M", "&nbsp;Mb", ini_get('max_execution_time'));?></div>
				
			</div>
			
			<div class="row">
				<div class="span2" style="text-align:right;font-weight:bold;">Memory Limit</div>
				<div class="span1"><?php echo str_ireplace("M", "&nbsp;Mb", ini_get('memory_limit'));?></div>
				<div class="span2" style="text-align:right;font-weight:bold;">Time Zone</div>
				<div class="span1" ><?php echo str_ireplace("M", "&nbsp;Mb", ini_get('date.timezone'));?>&nbsp;</div>
				<div class="span2" style="text-align:right;font-weight:bold;">Socket Timeout</div>
				<div class="span1"><?php echo str_ireplace("M", "&nbsp;Mb", ini_get('default_socket_timeout'));?></div>
				
			</div>
			
			<hr/>
			 <div class="row">
				<div class="span12">
				<div class="span3">
				
<?php

$count = 1;
foreach(get_loaded_extensions() as $extension){
	if($count > 10){
		echo '</div><div class="span3">';
	}
	echo '<div class="alert alert-info">'.$extension.'</div>';
	$count++;
}
?>
</div>
				</div>
			</div>
			</div>
		</div>
		
		<div id="installproc" class="container ui-corner-all">
			<h2 id="console">Install Console</h2>
			<div id="console_content" class="span11">
				<h3>Install Command</h3>
				<div class="row">
					<div class="span3">
						<button id="dbuser" class="btn btn-info">Create User Database</button>
					</div>
				</div>
				<hr/>
				<div class="row">
					<div class="span8">&nbsp;</div>
					<div id="clear" class="span1">Clear</div>
					<div id="close" class="span2">Open Console</div>
				</div>
				<div class="row">
					<div id="console_log" class="span11"></div>
				</div>
			</div>
		</div>
		
		
	</body>
	
</html>