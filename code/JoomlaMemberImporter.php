<?php

/**
 * Imports members from CSV export of joomla member table
 * 
 */
class JoomlaMemberImporter extends CsvBulkLoader{
	
	static $default_group = null;
	
	public $columnMap = array(
		'id' => 'JoomlaID',
		'name' => '->importName',
		'username' => 'Username',
		'email' => 'Email',
		'password' => '->importPassword',
		'usertype' => '->importUserType',
		'block' => 'JoomlaBlock',
		'sendEmail' => 'JoomlaSendEmail',
		'gid' => 'JoomlaGid', //TODO: groupid could be mapped to a SS group
		'registerDate' => 'Created', //check if these load
		'lastvisitDate' => 'LastVisited',  //check if these load
		'activation' => 'JoomlaActivation',
		'params' => '->importParams'
	);
	
	public $duplicateChecks = array(
      'id' => 'JoomlaID',
      'email' => 'Email'
	);
	
	function set_default_group($groupcode){
		self::$default_group = $groupcode;
	}
	
	function importPassword(&$obj, $val, $record){
		//store salt seperate from password
		$parts = explode(":",$val);
		if(count($parts == 2)){
			
			//SS converts passwords to base 64. see Security->encrypt_password
			$password = substr(base_convert($parts[0], 16, 36), 0, 64); 
			$salt = $parts[1];
			
			//SS doesn't have the abilty to set a pre-encrypted password so we need to query the DB directly
			if(!$obj->ID) $obj->write(); //Need an ID for db query
			
			DB::query("UPDATE Member SET Password='$password', SALT='$salt', PasswordEncryption='md5' WHERE ID=".$obj->ID);
		}
		
	}
	
	function importName(&$obj, $val, $record){
		$val = trim($val);
		$nameparts = explode(" ",$val);
		
		if(isset($nameparts[0]))
			$obj->FirstName = $nameparts[0];
		
		if(count($nameparts) > 1){
			unset($nameparts[0]);
			$obj->Surname = implode(" ",$nameparts);
		}
	}
	
	function importUserType(&$obj, $val, $record){		
		if(self::$default_group){
			Group::addToGroupByName($obj,self::$default_group);			
		}
	}	
	
	function importParams(&$obj, $val, $record){
		$params =  explode("\n",$val);
		
		//TODO: finish me
	}
}