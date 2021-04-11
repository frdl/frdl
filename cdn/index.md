---
title: CDN of Frdlweb
---

# Frdlweb CDN

## Asset Link (webfantized-ca-permalink-experiment)

Generate a content addressed permalink for small or medium assets.
Host and share any contents (small or medium sized) of the type HTML, Javascript, CSS on [our cdn for free](https://cdn.frdl.io).

#### How it works

`pros`
+ Equal Contents result in the same Bucket, Hash, Url, Address
+ NO database or persistent storage is involved, the disk quota for the data is ZERO
+ NO user account binding, everything is published public as per protocol

`cons`
+ The content size is limited by the maximum request-url length
+ The uris are very long and ugly


<div class="container">
<form action="https://cdn.frdl.io/_redirect.php" method="POST" target="_blank">
 
 <input type="hidden" name="packageType" value="webfantized-ca-permalink-experiment" /> 
 <input type="hidden" name="packageName" value="*"  /> 
 
 <legend>Type</legend>
 <select name="plugin">
 <option value="js" selected>javascript</option>
 <option value="css">css</option>
 <option value="html">html</option>
 </select>
  
 
 <legend>Code/Contents</legend>
 <textarea name="code" placeholder="window.alert('Example');"></textarea>

  <input type="submit" value="Go..." /> 
</form>
</div>



## NPM Package ([Javascript](https://www.npmjs.com/~webfan))

Fetch source code from public content delivery networks...

<div class="container">
<form action="https://cdn.frdl.io/_redirect.php" method="POST" target="_blank">
 
 <input type="hidden" name="packageType" value="npm" /> 
 
 <legend>Package Name</legend>
 <input type="text" name="packageName" placeholder="@frdl/frdl"  value="frdl"  /> 
 
 
 <legend>Package Version</legend>
 <input type="text" name="packageVersion" placeholder="latest"  value="latest" /> 
 
 <legend>View</legend>
 <select name="plugin">
 <option value="raw">Raw Source Code</option>
 <option value="bundle" disabled>Bundled Package</option>
 <option value="browse" selected>Pretty Browse Files</option>
 </select>
 
  <input type="submit" value="Go..." /> 
</form>
</div>






## Bundle Packages (webfanpack-js/webpack)

Experimental Online Webpack Bundler

<div class="container">
<form action="https://cdn.frdl.io/_redirect.php" method="POST" target="_blank">
 
  <legend>Packager/Bundler</legend>
 <select name="packageType">
 <option value="webfantized-webfanpack" disabled>@frdl/webfantized-webfanpack</option>
 <option value="webpack" selected>webfantized-webpack v2.0.0</option>
 <option value="webfantized-webpack" disabled>webfantized-webpack dev-master</option>
 </select>
 
 
 <legend>Dependencies Package Names</legend>
 <input type="text" name="packageName" placeholder="path,url"  value="path,url"  /> 
 
 
 <legend>Code (main.js)</legend>
 <textarea name="code" placeholder="module.exports=42;"></textarea>
 
 <legend>View</legend>
 <select name="plugin">
 <option value="code" selected>Bundled Javascript Entry</option>
 <option value="meta">Meta Data (json)</option>
 </select>
 
 <legend>API-Endpoint (Method)</legend>
 <select name="plugin_method">
 <option value="GET" selected>GET</option>
 <option value="POST">POST</option>
 </select>
  
  <input type="submit" value="Go..." /> 
</form>
</div>





## Class File ([PHP](https://frdl.webfan.de/install/?source=*))

<div class="container">
<form action="https://cdn.frdl.io/_redirect.php" method="POST" target="_blank">
  <input type="hidden" name="packageType" value="php-class" /> 
 
 <legend>Class Name</legend>
 <input type="text" name="packageName" placeholder="\webfan\hps\Compile\MimeStubIndex::class"  value="\webfan\hps\Compile\MimeStubIndex::class" /> 
 
 
 <legend>Class Version</legend>
 <input type="text" name="packageVersion" placeholder="latest"  value="latest"  readonly /> 
 
 <legend>View</legend>
 <select name="plugin">
 <option value="raw">Raw Source Code</option>
 <option value="bundle" disabled>Package</option>
 <option value="browse" selected>Pretty Highlight File</option>
 </select>
 
  <input type="submit" value="Go..." /> 
</form>
</div>




## Composer Package ([PHP](https://packages.frdl.de))

*This look up is marked as @ToDo...*
<div class="container">
<form disabled action="https://cdn.frdl.io/_redirect.php" method="POST" target="_blank">
  <input type="hidden" name="packageType" value="php-pkg" /> 
 
 <legend>Package Name</legend>
 <input type="text" name="packageName" placeholder="frdl/remote-psr4"  value="frdl/remote-psr4" /> 
 
 
 <legend>Package Version</legend>
 <input type="text" name="packageVersion" placeholder="latest"  value="latest" /> 
 
 <legend>View</legend>
 <select name="plugin">
 <option value="raw" selected>Raw Source Code</option>
 <option value="bundle">Zipped Package</option>
 <option value="browse" disabled>Pretty Browse Repository</option>
 </select>
 
  <input type="submit" value="Go..."  disabled /> 
</form>
</div>




