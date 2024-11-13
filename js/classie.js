/*!
 * classie v1.0.1
 * class helper functions
 * from bonzo https://github.com/ded/bonzo
 * MIT license
 * 
 * classie.has( elem, 'my-class' ) -> true/false
 * classie.add( elem, 'my-new-class' )
 * classie.remove( elem, 'my-unwanted-class' )
 * classie.toggle( elem, 'my-class' )
 */ !function(s){"use strict";function t(s){return RegExp("(^|\\s+)"+s+"(\\s+|$)")}function a(s,t){(e(s,t)?c:n)(s,t)}"classList"in document.documentElement?(e=function(s,t){return s.classList.contains(t)},n=function(s,t){s.classList.add(t)},c=function(s,t){s.classList.remove(t)}):(e=function(s,a){return t(a).test(s.className)},n=function(s,t){e(s,t)||(s.className=s.className+" "+t)},c=function(s,a){s.className=s.className.replace(t(a)," ")});var e,n,c,o={hasClass:e,addClass:n,removeClass:c,toggleClass:a,has:e,add:n,remove:c,toggle:a};"function"==typeof define&&define.amd?define(o):"object"==typeof exports?module.exports=o:s.classie=o}(window);