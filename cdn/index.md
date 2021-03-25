---
title: CDN of Frdlweb
---

# Frdlweb CDN

## NPM Package (Javascript)
<form action="https://cdn.frdl.io/_redirect.php" method="POST">
 
 <input type="hidden" name="packageType" value="npm" /> 
 
 <legend>Package Name</legend>
 <input type="text" name="packageName" placeholder="@frdl/frdl"  value="@frdl/frdl"  /> 
 
 
 <legend>Package Version</legend>
 <input type="text" name="packageVersion" placeholder="latest"  value="latest" /> 
 
 <legend>View</legend>
 <select>
 <option value="raw" selected>Raw Source Code</option>
 <option value="bundle" disabled>Bundled Package</option>
 <option value="browse">Pretty Browse Files</option>
 </select>
</form>

## Composer Package (PHP)
<form action="https://cdn.frdl.io/_redirect.php" method="POST">
  <input type="hidden" name="packageType" value="php" /> 
 
 <legend>Package Name</legend>
 <input type="text" name="packageName" placeholder="frdl/remote-psr4"  value="frdl/remote-psr4" /> 
 
 
 <legend>Package Version</legend>
 <input type="text" name="packageVersion" placeholder="latest"  value="latest" /> 
 
 <legend>View</legend>
 <select>
 <option value="raw" selected>Raw Source Code</option>
 <option value="bundle" disabled>Bundled Package</option>
 <option value="browse" disabled>Pretty Browse Files</option>
 </select>
</form>
