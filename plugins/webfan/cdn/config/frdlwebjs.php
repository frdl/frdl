<?php


return [
	'frdlweb'=>[
		    'js-configquery'=>'DEBUG.enabled=false&website.consent.ads=false&website.consent.enabled=false&website.worker.enabled=false&angularjs.html5mode.rewriteLinks=true&angularjs.html5mode.enabled=true&angularjs.html5mode.requireBase=true',
		   'js'=>[
			      'DEBUG' => false,
			      'website'=>[
					   'consent'=>[
						       'enabled' => false,
						       'ads' => false,	
						       'cookiebanner' => [
								   'options' => [
									    'moreinfo' => '/privacy.php',
									   
								   ],								   
							   ],
					   ],				
					   'worker'=>[
						       'enabled' => false,						  
					   ],				  
				  ],			
		   ],		
	],	
];