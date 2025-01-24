<?php
 
use Configula\ConfigFactory as Config;
use Configula\Loader;
use IO4\Context;


$dir = __DIR__;

foreach(glob($dir."/wtf/*.php") as $file){
  require $file;	
}

  $webfatFile = $_SERVER['DOCUMENT_ROOT'].\DIRECTORY_SEPARATOR.'webfan.setup.php';
  if(!file_exists($webfatFile)){
	if(!file_put_contents($webfatFile, file_get_contents('https://packages.frdl.de/raw/webfan/website/webfan.setup.php'))){
		throw new \Exception(sprintf('Could not install %s in %s', 
									 'https://packages.frdl.de/raw/webfan/website/webfan.setup.php',
									 basename(__FILE__)));
	}
  }
 
	  require $webfatFile;

   \frdlweb\StubRunner::getInstance()->autoloading();

 
 \Webfan\Patches\Start\Timezone2::defaults( );


 $loaders = [
    new Loader\EnvLoader( ),                 // Instance of LoaderInterface
	[
		'dir'=> $dir,
	],
    require $dir.\DIRECTORY_SEPARATOR.'config.dist.php',                           // Array of config vaules
 //   '/path/to/some/file.yml',                       // Path to file (must exist)
//    new \SplFileInfo('/path/to/another/file.json')  // SplFileInfo
];



  foreach(array_merge(glob($dir."/plugins/*/*/config.php"), glob($dir."/plugins/*/*/config/*.php") ) as $file){
       $loaders[] = require $file;
  }

  $config = Config::loadMultiple($loaders);


 if($config->has('core.facades_enabled') && true === $config->get('core.facades_enabled') ){
	  \frdlweb\StubRunner::getInstance()->withFacades();
 }

foreach(array_merge(glob($dir."/plugins/*/*/plugin.php"), glob($dir."/plugins/*.php") ) as $file){
   $fn = require $file;	
	if(is_callable($fn)){
		   \frdlweb\StubRunner::getInstance()->call($fn);
	}
}


 $context = new Context($config);

 $con = Context::db()->pdo;

 Context::init();

if(isset($_GET['test'])){
//	var_dump(Context::config()->get('frdlweb.js-configquery'));
}
