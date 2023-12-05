<?php

class DbHandler {
		
	private static $_mHandler;
		
	private function __construct() {}
		
	private static function _getHandler() {
		if(!isset(self::$_mHandler)){				
			try{
				// Create new PDO object
				self::$_mHandler = new PDO(PDO_POLLS,
										   DB_USERNAME,
										   DB_PASSWORD,
										   array(
												PDO::ATTR_PERSISTENT=>DB_PERSISTENCY,
												PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES UTF8"
												)
										   );
											
					// Set PDO to throw exceptions
					self::$_mHandler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);					
				}
				catch(PDOException $e){
					self::close(); //Close handler and generate error
					trigger_error($e->getMessage(), E_USER_ERROR);
				}
			}
			return self::$_mHandler;
		}	

	public static function close() {
		self::$_mHandler = NULL;
	}

	public static function execute($sqlQuery, $params = NULL) {
		try{
			$database_handler = self::_getHandler();                    // Get DB handler
			$statement_handler = $database_handler->prepare($sqlQuery); // Prepare qry. to execute
			$statement_handler->execute($params);                       // Execute query
			
			return 'ok';
		}
		catch(PDOException $e){
				self::close();                                          // Close handler and generate error
				return $e->getMessage();
		}
	}
	
	public static function insert($sqlQuery, $params = NULL) {
		try{
			$database_handler = self::_getHandler();                    // Get DB handler
			$statement_handler = $database_handler->prepare($sqlQuery); // Prepare qry. to execute
			$statement_handler->execute($params);                       // Execute query
			
			return $database_handler->lastInsertId();
		}
		catch(PDOException $e){
				self::close();                                          // Close handler and generate error
				return $e->getMessage();
		}		
		
		
	}

	public static function getAll($sqlQuery, $params = NULL, $fetchStyle = PDO::FETCH_ASSOC) {
		$result = NULL;
		try{
			$database_handler = self::_getHandler();                    
			$statement_handler = $database_handler->prepare($sqlQuery); 
			$statement_handler->execute($params);                       
			$result = $statement_handler->fetchAll($fetchStyle);
		}
		catch(PDOException $e){
			self::close();                                         
			trigger_error($e->getMessage(), E_USER_ERROR);
		}
		
		return $result;			
	}
		
	public static function getRow($sqlQuery, $params = NULL, $fetchStyle = PDO::FETCH_ASSOC) {
		$result = NULL;
		try{
			$database_handler = self::_getHandler();                   
			$statement_handler = $database_handler->prepare($sqlQuery); 
			$statement_handler->execute($params);                      
			$result = $statement_handler->fetch($fetchStyle);	
		}
		catch(PDOException $e){
			self::close();                                          
			trigger_error($e->getMessage(), E_USER_ERROR);
		}
		
		return $result;		
	}
		
	public static function getOne($sqlQuery, $params = NULL) {
		$result = NULL;
		try{
			$database_handler = self::_getHandler();                    
			$statement_handler = $database_handler->prepare($sqlQuery); 
			$statement_handler->execute($params);                      
			$result = $statement_handler->fetch(PDO::FETCH_NUM); 
			$result = $result[0];
		}
		catch(PDOException $e){
			self::close();         
			trigger_error($e->getMessage(), E_USER_ERROR);
		}
		
			return $result;		
	}	

	public static function callProcedure($procName, $params = NULL) {		
		try {   
			
			$sql = 'CALL '.$procName.'()';   			
			
			$database_handler = self::_getHandler();			
			
			$q = $database_handler->query($sql);  // Procedure call
			$q->setFetchMode(PDO::FETCH_ASSOC);
			
		} catch (PDOException $e) {
			die("Proc Call error occurred:" . $e->getMessage());
		}		
	}	
}