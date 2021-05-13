---
title: DNS over HTTPS
---

# Custom DNS Over HTTPS Resolver
On this page you can generate your <sup class="language-plaintext badge badge-success">FREE</sup> own Custom DNS Over HTTPS Resolver Server-Url.


<div oc-lazy-load="['https://cdn.frdl.io/@frdl/components/angularjs/api.helper.dns-over-https.js']">					 
<div frdl-api-helper-dns-custom="https://dns.api.webfan.de/dns-query"><img src="https://cdn.frdl.io/@frdl/webfantized-friendly-assets/img/loading.gif" style="border:none;" />
	<span>Loading DNS-API-Helper Widget...</span>
	<div ng-cloak>
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
<ul>	<li>DNS Servers:
		<ul>
			<li><button onclick="location.hash='builder';" class="btn-sm btn-success">Build Your Custom DNS Server...</button></li>
			<li><a href="javascript:;" onclick="$('#list.dns.frdl.de').removeClass('d-none');">dns.frdl.de...</a>
				<ul id="list.dns.frdl.de" class="d-none">
			<li>https://dns.api.webfan.de/dns-query</li>
			<li>https://dns.frdl.de/dns-query</li>
			<li>https://blue.dns.frdl.de/dns-query</li>
			<li>https://green.dns.frdl.de/dns-query</li>			
			<li>...<i>Internal DNS-Protocol servers...</i></li>
				</ul>	
			</li>
		</ul>
	</li>
		<li><a href="https://support.mozilla.org/de/kb/firefox-dns-über-https#" target="blank">DNS über HTTPS in Firefox</a> 
	<img src="https://frdl.ws/cloudsharing/s/B7QSP6572EdQTYf/preview" style="max-width:364px;width:auto;height:auto;" /></li>
</ul>
	<a name="builder"></a>
	<h2>Customize your own <span style="color:green;">FREE</span> DNS Over HTTPS Resolver Service:</h2>
<table style="width:99%;">
  <thead ng-repeat="(hostName, records) in MyDNS">
	 <tr> 
      <td colspan="2">
		  <legend>
		  <span ng-bind="hostName" style="display:inline;">{{hostName}}</span> 
            <input style="max-width:84px;" ng-blur="changeZone(this.value, records, hostName, false )" type="text" placeholder="{{hostName}}">
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
  <tbody>	
	<tr> 
    <td colspan="2"><h3>Resolver-URL:</h3></td>    
  </tr>	  
  <tr>   
    <td colspan="2">	
		<input type="text" readonly onclick="this.select()" ng-model="resolverUrl" style="width:75%;">	   
	  </td>
  </tr>	    
    </tbody>	    
  </table>
  
  
  <table style="width:99%;">
	 <thead>	
  <tr> 
    <td colspan="2"><h3>Test your custom DNS:</h3></td>    
  </tr>
	 </thead>	
  <tr>
    <td>Query Host/Domain</td>
    <td><input type="text" id="qname" ng-model="testRequest.qname"></td>
  </tr>
  <tr>
    <td>Query type</td>
    <td><input type="text" id="qtype" ng-model="testRequest.qtype"></td>
  </tr>
	
  <tfoot>
  <tr> 
    <td colspan="2"><button ng-click="clickTestLink()">Send the Test-Request</button></td>
  </tr>

  </tfoot>
</table>	
<a name="testresult"></a><pre ng-show="testResult" ng-bind-html="testResultJSON"></pre>

</div>	
</div>	
</div>

