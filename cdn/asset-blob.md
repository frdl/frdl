---
title: Free headless assets CDN
type: hosting
---

[Other CDN options...](./)

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

##### Generate Asset Link
<div class="container">
<form action="https://cdn.frdl.io/_redirect.php" method="POST" target="_blank">
 
 <input type="hidden" name="packageType" value="webfantized-ca-permalink-experiment" /> 
 <input type="hidden" name="packageName" value="*"  /> 
 
 <legend>Type</legend>
 <select name="plugin">
 <option value="js" selected>application/javascript</option>
 <option value="css">text/css</option>
 <option value="html">text/html</option>
 <option value="json">application/json</option>
 <option value="jsonp">application/jsonp</option>
 </select>
 
 <p id="callback">
   <legend>Callback</legend>
  <input type="text" style="display:none;" name="plugin_method" value="callback"  /> 
  </p>
  
 <legend>Code/Contents</legend>
 <textarea name="code" placeholder="window.alert('Example');" style="width:95%;height:364px;"></textarea>

  <input type="submit" value="Go..." /> 
</form>
</div>

