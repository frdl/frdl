---
title: CDN of Frdlweb
---

# Frdlweb CDN

Our Content Delivery Network, the `Frdlweb CDN` ( `cdn.frdl.de` ) is powered by (a proxy random race of):
* [Frdl](https://frdl.de) | - [Implementation-Example](https://github.com/frdl/translations#onpage-multilanguage-example)
* [JSDELIVR](https://www.jsdelivr.com/)
* [UNPKG](https://unpkg.com/)

For example, the Frdlweb CDN is the host of our webfan-website.js project, wich runs most of the webfans/frdlwebs websites javascripts, even this site.

#### Examples
* Main Core:
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
* [DM-Captcha](https://dm-captcha-sas.weid.info/)
* [Domain Check (Simple Whois)](https://frdlweb.de/dns/domain-check)
````HTML
&lt;frdlweb-domain-check-whois ng-cloak=&amp;quot;&amp;quot;&gt;&lt;/frdlweb-domain-check-whois&gt;
````

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

 
*Do you see a phishing warning for cdn.frdl.de? Please read the info: [https://startforum.de/content/perma?id=814](https://startforum.de/content/perma?id=814)*
 
