---
title: DNS over HTTPS
---

# Your FREE DNS/DNS Over HTTPS server

<div oc-lazy-load="['https://dns.api.webfan.de/dns-api.js', 'ui-notification', 'frdl-ui-progressbar']">	
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
<div class="d-rel-inline-block f-center content" ng-controller="buildResolverUrlCtrl">	                 	
        
<h1>Frdlweb DNS/DNS Over HTTPS</h1>
	<p style="color:red;">This service is in BETA-Status, do NOT use in productional environments!</p>

	
<h2>What is this?</h2>
<p>	
 This is an internal/private DNS service providing a <a onclick="location.hash='builder';">user-customizable</a> <a href="https://de.wikipedia.org/wiki/DNS_over_HTTPS" target="_blank">DNS over HTTPS</a> look-up.	
</p>
	
	
<h2>What is the use case?</h2>
Mainly:
<ul>
	<li>Internal (reverse-)proxy routing</li>	
	<li>Preview of Sites/Domains on development/testing environments/servers (e.g. Webfan Homepagesystem)</li>
	<li>Providing <strong><a href="http://wfpu.de/docs/blue-green_deployment.pdf" target="blank">&quot;Blue-green deployment&quot;</a></strong> (e.g. Frdlweb projects)</li>
</ul>

	<a name="howto"></a>
<h2>How to use?</h2>	
<ul>
	<li><a href="https://support.mozilla.org/de/kb/firefox-dns-über-https#" target="blank">DNS über HTTPS in Firefox</a> 
	<img src="https://frdl.ws/cloudsharing/s/B7QSP6572EdQTYf/preview" style="max-width:364px;width:auto;height:auto;" /></li>
	<li>DNS Servers:
		<ul>
			<li><a onclick="location.hash='builder';" style="color:red;">Build Your Custom: <span ng-bind="resolverUrl"></span></a></li>
			<li>https://dns.api.webfan.de/dns-query</li>
			<li>https://dns.frdl.de/dns-query</li>
			<li>https://blue.dns.frdl.de/dns-query</li>
			<li>https://green.dns.frdl.de/dns-query</li>			
			<li>...<i>Internal DNS-Protocol servers...</i></li>
		</ul>
	</li>
	<li>...<i>more info coming soon...</i></li>
</ul>
	<a name="builder"></a>
	<h2>Customize your own <span style="color:green;">FREE</span> DNS Over HTTPS Resolver Service:</h2>
<table style="width:99%%;">
  <thead ng-repeat="(hostName, records) in MyDNS">
	 <tr> 
      <td colspan="2">
		  <legend>
		  <span ng-bind="hostName" style="display:inline;">{{hostName}}</span> 
		    <button class="btn-sm btn-danger" ng-click="removeRecord(hostName)">X</button>
			  
		  </legend>
		 </td>
	 </tr>	
	  
  <tr ng-repeat="record in records track by $index">
    <td>
		type: <input  style="max-width:128px;" type="text"  placeholder="AAAA" ng-model="MyDNS
[hostName][$index][0]"> ttl: <input style="max-width:64px;" type="text" placeholder="900" ng-model="MyDNS
[hostName][$index][2]">
	  </td>
    <td>
		value:<input type="text" ng-model="MyDNS
[hostName][$index][1]">
	  
		<button class="btn-sm btn-danger" ng-click="removeRecord(hostName, $index)">X</button>
	  </td>	  
  </tr>	  
  </thead>	  
	<tr> 
    <td colspan="2"><h3>Resolver-URL:</h3></td>    
  </tr>	
  <tr>   
    <td colspan="2">	
		<input type="text" readonly onclick="this.select()" ng-model="resolverUrl" style="width:75%;">	   
	  </td>
  </tr>	
  <tr> 
    <td colspan="2"><h3>Test your custom DNS:</h3></td>    
  </tr>
  <tr>
    <td>Query Host/Domain</td>
    <td><input type="text" id="qname" ng-model="testRequest.qname"></td>
  </tr>
  <tr>
    <td>Query type</td>
    <td><input type="text" id="qtype" ng-model="testRequest.qtype"></td>
  </tr>
  <tr> 
    <td colspan="2"><button ng-click="clickTestLink()">Send the Test-Request</button></td>
    
  </tr>

</table>	


<a name="testresult"></a><pre>{{ testResult | json }}</pre>
	</div>						 
</div>	


<script type="text/javascript" src="https://frdl.webfan.de/app/js/frdlweb.js"></script>	
<dsgvo-adsense></dsgvo-adsense>	
