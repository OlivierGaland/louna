<?php
	ini_set('display_startup_errors', 1);
	ini_set('display_errors', 1);
	error_reporting(-1);

	class Ctx { 
		public static function Get_PYTHON_dir() { return $_SERVER['CONTEXT_DOCUMENT_ROOT'].'/python/'; }
		public static function Get_PHP_dir() { return $_SERVER['CONTEXT_DOCUMENT_ROOT'].'/php/'; }
		
		private static $_instance = null;
		private function __construct() {
			$this->settings = null;			
			$this->settings = simplexml_load_file(Ctx::Get_PYTHON_dir().'settings.xml');
			$this->profiles = [];
			foreach(scandir(Ctx::Get_PYTHON_dir().'profiles/') as $file) if(is_file(Ctx::Get_PYTHON_dir().'profiles/'.$file)) $this->profiles[str_replace(".xml","",$file)] = simplexml_load_file(Ctx::Get_PYTHON_dir().'profiles/'.$file);
		}
		public static function Get() { if(is_null(self::$_instance)) { self::$_instance = new Ctx(); } return self::$_instance;	}
		
	}
	
?>