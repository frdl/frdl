[Other CDN options...](./)


## Bundle Packages (webfanpack-js/webpack - runkit powered)

Experimental Online Webpack Bundlers **(not for production, DEV or BETA stage!)**

<div class="container">
<form action="https://cdn.frdl.io/_redirect.php" method="POST" target="_blank">
 
  <legend>Packager/Bundler</legend>
 <select name="packageType">
 <option value="webfantized-webfanpack" disabled>@frdl/webfantized-webfanpack</option>
 <option value="webpack" selected>webfantized-webpack v2.0.0</option>
 <option value="webfantized-webpack">webfantized-webpack dev-master</option>
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



