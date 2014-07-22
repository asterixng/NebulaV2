<?php


class CloudDB {
	
	public static function getCollections(){
		
		$cols = array();
		
		try{
			
			$mongo = new Mongo(MONGOLAB);
			$db = $mongo->selectDB("stealth");
			$cols = $db->getCollectionNames();
			
			$mongo->close();
		
		}catch(Exception $ex){echo '<br/>'.$ex->getMessage();}
		
		return $cols;
	}
	
	
	public static function find($collection,$where=array()){
		
		$cols = array();
		
		try{
				
			$mongo = new Mongo(MONGOLAB);
			$db = $mongo->selectDB(MONGO_DB);
			$collection = $db->selectCollection($collection);
			$cursor = $collection->find($where);
			$num_docs = $cursor->count();

		    if( $num_docs > 0 )
		    {
		        // loop over the results
		        foreach ($cursor as $obj)
		        {
		           $cols[] = $obj;
		        }
		    }
			$mongo->close();
		}catch(Exception $ex){echo '<br/>'.$ex->getMessage();}
		
		return $cols;
		
	}
	
	public static $_connection = null;
	
	public static function connect(){
		CloudDB::$_connection = new MongoClient();
	}
	
	public static function getMongoPanelStatus(){
		
		CloudDB::connect();
		
		$panel = "";
		
		$dbs = CloudDB::$_connection->listDBs();
		
		$panel .= '<table class="table rounded-table"><thead><tr><th>DB</th><th>Size</th></tr></thead><tbody>';
		
		foreach($dbs['databases'] as $db){
			
			$size_db = $db['sizeOnDisk'] / 1024 / 1024; // Mb
			
			$panel .= '<tr><td>'.$db['name'].'</td><td>'.round($size_db,3).'</td></tr>';
		}
		
		$panel .= '</tbody></table>';
		
		CloudDB::close();
		
		return $panel;
	}

	
	public static function close(){
		$connections = CloudDB::$_connection->getConnections();
		
		foreach ( $connections as $con )
		{
			// Loop over all the connections, and when the type is "SECONDARY"
			// we close the connection
			if ( $con['connection']['connection_type_desc'] == "SECONDARY" )
			{
				
				$closed = $a->close( $con['hash'] );
				echo $closed ? "ok" : "failed", "\n";
			}
		}
	} 
	
	
	
}