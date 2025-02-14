---
title: CDN of Frdlweb
---

# Frdlweb CDN

Our Content Delivery Network, the `Frdlweb CDN` ( `cdn.frdl.de` ) is powered by (a proxy random race of):
* [Frdl](https://frdl.de) | - [Implementation-Examples](https://frdlweb.de/cdn/index#examples)
* [JSDELIVR](https://www.jsdelivr.com/) proxy/redirection
* [UNPKG](https://unpkg.com/) proxy/redirection
* [Cloudflare](https://cdnjs.cloudflare.com) proxy

For example, the Frdlweb CDN is the host of our webfan-website.js project, wich runs most of the webfans/frdlwebs websites javascripts, even this site.

#### Examples
* Main Core ([see how to config](https://frdl.de/blog/view/1208/webfanjs-webfan-websitejs-configuration-parameters)):
````HTML
<script>
((q, w,d)=>{
var s=d.createElement('script');
s.setAttribute('src', 'https://cdn.startdir.de/webfan.js?' + q);	
s.async='false';
s.onload=async ()=>{
 frdlweb.ready(()=>{
     //page and library loaded and bootstrapped...
     //...
     //  await window.frdlweb () === await window.require('frdlweb') 
  });
};
d.head.prepend(s);		
})('DEBUG.enabled=true&website.consent.ads=false&angularjs.html5mode.rewriteLinks=false&angularjs.html5mode.enabled=false',
   window, document);	
</script>
````
* [Multi-Language](https://github.com/frdl/translations#onpage-multilanguage-example)
* [DM-Captcha](https://dm-captcha-sas.weid.info/test-post.php)
* [Domain Check (Simple Whois) Demo](https://frdlweb.de/dns/domain-check) Code: ````<frdlweb-domain-check-whois></frdlweb-domain-check-whois>````
* [RSS Viewer Component](https://frdl.de/blog/view/1169/rss-viewer-frdlwebjs-component) - [Demo](/service/news)
* [Random (background) image](https://startforum.de/comment/perma?id=320)
* [Dark Mode](https://frdl.de/blog/view/1213/darkmode-added-to-the-framework)
* [Markdown, BBCode](https://frdl.de/blog/view/1225/webfanjs-frdlwebjs-markdown-components)



# ℹ️ More info...

If you want to run your own content on our CDN, you can start with [Webfan Hub](https://webfan.io/), so far.

If you want to use it locally/on your own domain, you can use [this module](https://github.com/frdlweb/frdlweb-cdn-module).

<div>
 To read some information about the software we use, you can 
 visit the <a href="https://webfan.de/install/">Webfan Software Page</a>
 or <button class="btn-sm btn-info"
 onclick="this.setAttribute('disabled', true);this.parentNode.innerHTML+=atob('PGZyZGx3ZWItc29mdHdhcmUtbGljZW5zZXM+PC9mcmRsd2ViLXNvZnR3YXJlLWxpY2Vuc2VzPg==');"
  >click this button</button>.
 <br />
  <br />
</div>

 

