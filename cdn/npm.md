---
title: NPM CDN Mirror Compilation
---

[Other CDN options...](./)

## NPM Package ([Javascript](https://www.npmjs.com/~webfan))

Fetch source code from public content delivery networks...

<div class="container">
<form action="/_redirect.php" method="POST" target="_blank">
 
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



