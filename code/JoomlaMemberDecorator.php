<?php

class JoomlaMemberDecorator extends DataObjectDecorator{
	
	function extraStatics(){
		return array(
			'db' => array(
				'JoomlaID' => 'Int',
				'Username' => 'Varchar',
				'JoomlaBlock' => 'Boolean',
				'JoomlaSendEmail' => 'Boolean',
				'JoomlaGid' => 'Int',
				'JoomlaActivation' => 'Varchar(255)' //this might be a MD5 instead
			)
		);
	}
	
}

?>
