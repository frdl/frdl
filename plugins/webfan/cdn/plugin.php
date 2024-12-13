<?php
namespace Webfan\Remote\CDN\plugin;

//\IO4\Context::config()->get('frdlweb.js-configquery')
function echo_header(?array $args = []){
	$configquery = \IO4\Context::config()->get('frdlweb.js-configquery');
	
$html= '<script>
((q, w,d)=>{
var s=d.createElement(\'script\');
s.setAttribute(\'src\', \'https://cdn.startdir.de/webfan.js?cdn=https://cdn.startdir.de&?\' + q);	
s.async=\'defer\';
s.onload=async()=>{
 window.frdlweb.ready(async()=>{        
	 var FRDL = await require(\'frdlweb\');
          
	 FRDL .Webfan.watchFor(\'a[href="https://registry.frdl.de/?goto=oidplus%3Aresources%24About%2FDatenschutzerklaerung.html"]\', el=>{
		el.setAttribute(\'href\',  \'/privacy.php\');	
	 });      
      
 });
};
d.head.prepend(s);		
})(\''.$configquery.'\', window, document);
</script>';
echo $html;
}
	
 
return (function( ){
 add_action(	'frdl_echo_header_html',	__NAMESPACE__.'\echo_header',	0, null);
});