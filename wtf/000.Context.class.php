<?php

namespace IO4;

 class Context 
 {
	protected static $db = null; 
	protected static $config = null; 
	
	function __construct($config){
	   self::$config = $config;
	   self::$db = new \Medoo\Medoo(self::config()->get('db'));
	}
	public static function config(){
	     return self::$config;	
	}

	 public static function db(){
	     return self::$db;
	}	 
	
	 public static function init(){
	     wp_cache_init();	
	}
 }