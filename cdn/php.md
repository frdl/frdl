---
title: PHP Psr4 from remote CDN
type: cdn
---

[Other CDN options...](cdn/index)

# PHP Psr4 from remote CDN

To use the *php CDN* in a project, you can use [the package `frdl/remote-psr4`](https://github.com/frdl/remote-psr4) and autoload php classes on demand from one or more remote servers. Further you can map namespaces to remote-folders, etc... .


#### Look-Up Class File ([PHP](https://frdl.webfan.de/install/?source=*))


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
