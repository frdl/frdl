---
title: Online webpack/webfanpack
---

[Other CDN options...](./)


#### Bundle Packages (webfanpack-js/webpack - runkit powered)

Experimental Online Webpack Bundlers **(not for production, DEV or BETA stage!)**

<div class="container">
<form action="https://cdn.frdl.io/_redirect.php" method="POST" target="_blank">
 
  <legend>Packager/Bundler</legend>
 <select name="packageType">
 <option value="webpack">webfantized-webpack v2.0.0</option>
 <option value="webfantized-webpack" selected>webfantized-webpack dev-master</option>
 </select>
 
 
 <legend>Dependencies Package Names</legend>
 <input type="text" name="packageName" placeholder="path,url"  value="path,url"  /> 
 
 
 <legend>Code (main.js)</legend>
 <textarea name="code" placeholder="module.exports=42;" style="width:95%;height:364px;"></textarea>
 
 <legend>View</legend>
 <select name="plugin">
 <option value="code">Bundled Javascript Entry</option>
 <option value="meta" selected>Meta Data (json)</option>
 </select>
 
 <legend>API-Endpoint (Method)</legend>
 <select name="plugin_method">
 <option value="GET">GET</option>
 <option value="POST" selected>POST</option>
 </select>
  
  <input type="submit" value="Go..." /> 
</form>
</div>



