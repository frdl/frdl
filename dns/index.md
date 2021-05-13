---
title: DNS over HTTPS
---

# Your FREE DNS/DNS Over HTTPS server

<div oc-lazy-load="['https://cdn.frdl.io/@frdl/components/angularjs/api.helper.dns-over-https.js', 'ui-notification', 'frdl-ui-progressbar']">	
	<frdl-progressbar></frdl-progressbar>	
	 

	 
<div ng-show="progressbarValue" class="page-header-wrapper" style="height:16px;width:100%;position:fixed;left:0px;top:0px;z-index:999;">
	<span frdl-id="mainProgressBar" ng-bind="progressHint" style="left:0px;top:0px;position:fixed;"></span>
	<uib-progressbar frdl-id="mainProgressBar" animate="true" value="progressbarValue" max="100" type="success"></uib-progressbar>     
</div>	
		
<div class="d-block f-top" ui-view="topBarView">		           
	<div style="position:fixed;float:top;padding:4px;padding-top:2px;margin:12px;z-Index:999;top:1px;left:1px;" ng-cloak>	
	  <a href="https://frdl.de" class="btn btn-primary">Frdlweb</a>
	  <a href="https://apps.api.frdl.de/developer/" class="btn btn-primary">Developer</a>
	  <a href="https://apps.api.frdl.de" class="btn btn-primary">API</a>
	  <a href="https://registry.frdl.de/?goto=oidplus%3Aresources%24About%2FDatenschutzerklaerung.html" class="btn-sm btn-primary">Privacy policy&nbsp;Datenschutzerkl&auml;rung</a>
	  <a href="https://registry.frdl.de/?goto=oidplus%3Aresources%24About%2FImpressum.html" class="btn-sm btn-primary">Imprint</a>
	</div>        	
</div>					 
<div frdl-api-helper-dns-custom="https://dns.api.webfan.de/dns-query">	                 	

</div>						 
</div>
<script type="text/javascript" src="https://cdn.frdl.io/@frdl/components/frdl-plugs/frdlweb-legacy.js"></script>	
<dsgvo-adsense></dsgvo-adsense>	
