---
title: CDN of Frdlweb
---

# Frdlweb CDN
Fetch source code from public content delivery networks...


## NPM Package (Javascript)
<div class="container">
<form action="https://cdn.frdl.io/_redirect.php" method="POST">
 
 <input type="hidden" name="packageType" value="npm" /> 
 
 <legend>Package Name</legend>
 <input type="text" name="packageName" placeholder="@frdl/frdl"  value="@frdl/frdl"  /> 
 
 
 <legend>Package Version</legend>
 <input type="text" name="packageVersion" placeholder="latest"  value="latest" /> 
 
 <legend>View</legend>
 <select name="plugin">
 <option value="raw" selected>Raw Source Code</option>
 <option value="bundle" disabled>Bundled Package</option>
 <option value="browse">Pretty Browse Files</option>
 </select>
 
  <input type="submit" value="Go..." /> 
</form>
</div>




## Composer Package (PHP)
<div class="container">
<form action="https://cdn.frdl.io/_redirect.php" method="POST">
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
 
  <input type="submit" value="Go..." /> 
</form>
</div>




## Class File (PHP)
<div class="container">
<form action="https://cdn.frdl.io/_redirect.php" method="POST">
  <input type="hidden" name="packageType" value="php-class" /> 
 
 <legend>Class Name</legend>
 <input type="text" name="packageName" placeholder="\webfan\hps\Compile\MimeStubIndex::class"  value="\webfan\hps\Compile\MimeStubIndex::class" /> 
 
 
 <legend>Class Version</legend>
 <input type="text" name="packageVersion" placeholder="latest"  value="latest"  readonly /> 
 
 <legend>View</legend>
 <select name="plugin">
 <option value="raw" selected>Raw Source Code</option>
 <option value="bundle" disabled>Package</option>
 <option value="browse" disabled>Pretty Highlight File</option>
 </select>
 
  <input type="submit" value="Go..." /> 
</form>
</div>
