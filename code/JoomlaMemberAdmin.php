<?php

class JoomlaMemberAdmin extends ModelAdmin{
	
	static $managed_models = array(
		'Member'
	);
	
	static $model_importers = array(
		'Member' => 'JoomlaMemberImporter'
	);
	
	static $url_segment = 'members';
}

?>
