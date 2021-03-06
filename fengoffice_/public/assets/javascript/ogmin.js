/*!
 * jQuery JavaScript Library v1.6.2
 * http://jquery.com/
 *
 * Copyright 2011, John Resig
 * Dual licensed under the MIT or GPL Version 2 licenses.
 * http://jquery.org/license
 *
 * Includes Sizzle.js
 * http://sizzlejs.com/
 * Copyright 2011, The Dojo Foundation
 * Released under the MIT, BSD, and GPL Licenses.
 *
 * Date: Thu Jun 30 14:16:56 2011 -0400
 */
(function(a,b){function cv(a){return f.isWindow(a)?a:a.nodeType===9?a.defaultView||a.parentWindow:!1}function cs(a){if(!cg[a]){var b=c.body,d=f("<"+a+">").appendTo(b),e=d.css("display");d.remove();if(e==="none"||e===""){ch||(ch=c.createElement("iframe"),ch.frameBorder=ch.width=ch.height=0),b.appendChild(ch);if(!ci||!ch.createElement)ci=(ch.contentWindow||ch.contentDocument).document,ci.write((c.compatMode==="CSS1Compat"?"<!doctype html>":"")+"<html><body>"),ci.close();d=ci.createElement(a),ci.body.appendChild(d),e=f.css(d,"display"),b.removeChild(ch)}cg[a]=e}return cg[a]}function cr(a,b){var c={};f.each(cm.concat.apply([],cm.slice(0,b)),function(){c[this]=a});return c}function cq(){cn=b}function cp(){setTimeout(cq,0);return cn=f.now()}function cf(){try{return new a.ActiveXObject("Microsoft.XMLHTTP")}catch(b){}}function ce(){try{return new a.XMLHttpRequest}catch(b){}}function b$(a,c){a.dataFilter&&(c=a.dataFilter(c,a.dataType));var d=a.dataTypes,e={},g,h,i=d.length,j,k=d[0],l,m,n,o,p;for(g=1;g<i;g++){if(g===1)for(h in a.converters)typeof h=="string"&&(e[h.toLowerCase()]=a.converters[h]);l=k,k=d[g];if(k==="*")k=l;else if(l!=="*"&&l!==k){m=l+" "+k,n=e[m]||e["* "+k];if(!n){p=b;for(o in e){j=o.split(" ");if(j[0]===l||j[0]==="*"){p=e[j[1]+" "+k];if(p){o=e[o],o===!0?n=p:p===!0&&(n=o);break}}}}!n&&!p&&f.error("No conversion from "+m.replace(" "," to ")),n!==!0&&(c=n?n(c):p(o(c)))}}return c}function bZ(a,c,d){var e=a.contents,f=a.dataTypes,g=a.responseFields,h,i,j,k;for(i in g)i in d&&(c[g[i]]=d[i]);while(f[0]==="*")f.shift(),h===b&&(h=a.mimeType||c.getResponseHeader("content-type"));if(h)for(i in e)if(e[i]&&e[i].test(h)){f.unshift(i);break}if(f[0]in d)j=f[0];else{for(i in d){if(!f[0]||a.converters[i+" "+f[0]]){j=i;break}k||(k=i)}j=j||k}if(j){j!==f[0]&&f.unshift(j);return d[j]}}function bY(a,b,c,d){if(f.isArray(b))f.each(b,function(b,e){c||bC.test(a)?d(a,e):bY(a+"["+(typeof e=="object"||f.isArray(e)?b:"")+"]",e,c,d)});else if(!c&&b!=null&&typeof b=="object")for(var e in b)bY(a+"["+e+"]",b[e],c,d);else d(a,b)}function bX(a,c,d,e,f,g){f=f||c.dataTypes[0],g=g||{},g[f]=!0;var h=a[f],i=0,j=h?h.length:0,k=a===bR,l;for(;i<j&&(k||!l);i++)l=h[i](c,d,e),typeof l=="string"&&(!k||g[l]?l=b:(c.dataTypes.unshift(l),l=bX(a,c,d,e,l,g)));(k||!l)&&!g["*"]&&(l=bX(a,c,d,e,"*",g));return l}function bW(a){return function(b,c){typeof b!="string"&&(c=b,b="*");if(f.isFunction(c)){var d=b.toLowerCase().split(bN),e=0,g=d.length,h,i,j;for(;e<g;e++)h=d[e],j=/^\+/.test(h),j&&(h=h.substr(1)||"*"),i=a[h]=a[h]||[],i[j?"unshift":"push"](c)}}}function bA(a,b,c){var d=b==="width"?a.offsetWidth:a.offsetHeight,e=b==="width"?bv:bw;if(d>0){c!=="border"&&f.each(e,function(){c||(d-=parseFloat(f.css(a,"padding"+this))||0),c==="margin"?d+=parseFloat(f.css(a,c+this))||0:d-=parseFloat(f.css(a,"border"+this+"Width"))||0});return d+"px"}d=bx(a,b,b);if(d<0||d==null)d=a.style[b]||0;d=parseFloat(d)||0,c&&f.each(e,function(){d+=parseFloat(f.css(a,"padding"+this))||0,c!=="padding"&&(d+=parseFloat(f.css(a,"border"+this+"Width"))||0),c==="margin"&&(d+=parseFloat(f.css(a,c+this))||0)});return d+"px"}function bm(a,b){b.src?f.ajax({url:b.src,async:!1,dataType:"script"}):f.globalEval((b.text||b.textContent||b.innerHTML||"").replace(be,"/*$0*/")),b.parentNode&&b.parentNode.removeChild(b)}function bl(a){f.nodeName(a,"input")?bk(a):"getElementsByTagName"in a&&f.grep(a.getElementsByTagName("input"),bk)}function bk(a){if(a.type==="checkbox"||a.type==="radio")a.defaultChecked=a.checked}function bj(a){return"getElementsByTagName"in a?a.getElementsByTagName("*"):"querySelectorAll"in a?a.querySelectorAll("*"):[]}function bi(a,b){var c;if(b.nodeType===1){b.clearAttributes&&b.clearAttributes(),b.mergeAttributes&&b.mergeAttributes(a),c=b.nodeName.toLowerCase();if(c==="object")b.outerHTML=a.outerHTML;else if(c!=="input"||a.type!=="checkbox"&&a.type!=="radio"){if(c==="option")b.selected=a.defaultSelected;else if(c==="input"||c==="textarea")b.defaultValue=a.defaultValue}else a.checked&&(b.defaultChecked=b.checked=a.checked),b.value!==a.value&&(b.value=a.value);b.removeAttribute(f.expando)}}function bh(a,b){if(b.nodeType===1&&!!f.hasData(a)){var c=f.expando,d=f.data(a),e=f.data(b,d);if(d=d[c]){var g=d.events;e=e[c]=f.extend({},d);if(g){delete e.handle,e.events={};for(var h in g)for(var i=0,j=g[h].length;i<j;i++)f.event.add(b,h+(g[h][i].namespace?".":"")+g[h][i].namespace,g[h][i],g[h][i].data)}}}}function bg(a,b){return f.nodeName(a,"table")?a.getElementsByTagName("tbody")[0]||a.appendChild(a.ownerDocument.createElement("tbody")):a}function W(a,b,c){b=b||0;if(f.isFunction(b))return f.grep(a,function(a,d){var e=!!b.call(a,d,a);return e===c});if(b.nodeType)return f.grep(a,function(a,d){return a===b===c});if(typeof b=="string"){var d=f.grep(a,function(a){return a.nodeType===1});if(R.test(b))return f.filter(b,d,!c);b=f.filter(b,d)}return f.grep(a,function(a,d){return f.inArray(a,b)>=0===c})}function V(a){return!a||!a.parentNode||a.parentNode.nodeType===11}function N(a,b){return(a&&a!=="*"?a+".":"")+b.replace(z,"`").replace(A,"&")}function M(a){var b,c,d,e,g,h,i,j,k,l,m,n,o,p=[],q=[],r=f._data(this,"events");if(!(a.liveFired===this||!r||!r.live||a.target.disabled||a.button&&a.type==="click")){a.namespace&&(n=new RegExp("(^|\\.)"+a.namespace.split(".").join("\\.(?:.*\\.)?")+"(\\.|$)")),a.liveFired=this;var s=r.live.slice(0);for(i=0;i<s.length;i++)g=s[i],g.origType.replace(x,"")===a.type?q.push(g.selector):s.splice(i--,1);e=f(a.target).closest(q,a.currentTarget);for(j=0,k=e.length;j<k;j++){m=e[j];for(i=0;i<s.length;i++){g=s[i];if(m.selector===g.selector&&(!n||n.test(g.namespace))&&!m.elem.disabled){h=m.elem,d=null;if(g.preType==="mouseenter"||g.preType==="mouseleave")a.type=g.preType,d=f(a.relatedTarget).closest(g.selector)[0],d&&f.contains(h,d)&&(d=h);(!d||d!==h)&&p.push({elem:h,handleObj:g,level:m.level})}}}for(j=0,k=p.length;j<k;j++){e=p[j];if(c&&e.level>c)break;a.currentTarget=e.elem,a.data=e.handleObj.data,a.handleObj=e.handleObj,o=e.handleObj.origHandler.apply(e.elem,arguments);if(o===!1||a.isPropagationStopped()){c=e.level,o===!1&&(b=!1);if(a.isImmediatePropagationStopped())break}}return b}}function K(a,c,d){var e=f.extend({},d[0]);e.type=a,e.originalEvent={},e.liveFired=b,f.event.handle.call(c,e),e.isDefaultPrevented()&&d[0].preventDefault()}function E(){return!0}function D(){return!1}function m(a,c,d){var e=c+"defer",g=c+"queue",h=c+"mark",i=f.data(a,e,b,!0);i&&(d==="queue"||!f.data(a,g,b,!0))&&(d==="mark"||!f.data(a,h,b,!0))&&setTimeout(function(){!f.data(a,g,b,!0)&&!f.data(a,h,b,!0)&&(f.removeData(a,e,!0),i.resolve())},0)}function l(a){for(var b in a)if(b!=="toJSON")return!1;return!0}function k(a,c,d){if(d===b&&a.nodeType===1){var e="data-"+c.replace(j,"$1-$2").toLowerCase();d=a.getAttribute(e);if(typeof d=="string"){try{d=d==="true"?!0:d==="false"?!1:d==="null"?null:f.isNaN(d)?i.test(d)?f.parseJSON(d):d:parseFloat(d)}catch(g){}f.data(a,c,d)}else d=b}return d}var c=a.document,d=a.navigator,e=a.location,f=function(){function J(){if(!e.isReady){try{c.documentElement.doScroll("left")}catch(a){setTimeout(J,1);return}e.ready()}}var e=function(a,b){return new e.fn.init(a,b,h)},f=a.jQuery,g=a.$,h,i=/^(?:[^<]*(<[\w\W]+>)[^>]*$|#([\w\-]*)$)/,j=/\S/,k=/^\s+/,l=/\s+$/,m=/\d/,n=/^<(\w+)\s*\/?>(?:<\/\1>)?$/,o=/^[\],:{}\s]*$/,p=/\\(?:["\\\/bfnrt]|u[0-9a-fA-F]{4})/g,q=/"[^"\\\n\r]*"|true|false|null|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?/g,r=/(?:^|:|,)(?:\s*\[)+/g,s=/(webkit)[ \/]([\w.]+)/,t=/(opera)(?:.*version)?[ \/]([\w.]+)/,u=/(msie) ([\w.]+)/,v=/(mozilla)(?:.*? rv:([\w.]+))?/,w=/-([a-z])/ig,x=function(a,b){return b.toUpperCase()},y=d.userAgent,z,A,B,C=Object.prototype.toString,D=Object.prototype.hasOwnProperty,E=Array.prototype.push,F=Array.prototype.slice,G=String.prototype.trim,H=Array.prototype.indexOf,I={};e.fn=e.prototype={constructor:e,init:function(a,d,f){var g,h,j,k;if(!a)return this;if(a.nodeType){this.context=this[0]=a,this.length=1;return this}if(a==="body"&&!d&&c.body){this.context=c,this[0]=c.body,this.selector=a,this.length=1;return this}if(typeof a=="string"){a.charAt(0)!=="<"||a.charAt(a.length-1)!==">"||a.length<3?g=i.exec(a):g=[null,a,null];if(g&&(g[1]||!d)){if(g[1]){d=d instanceof e?d[0]:d,k=d?d.ownerDocument||d:c,j=n.exec(a),j?e.isPlainObject(d)?(a=[c.createElement(j[1])],e.fn.attr.call(a,d,!0)):a=[k.createElement(j[1])]:(j=e.buildFragment([g[1]],[k]),a=(j.cacheable?e.clone(j.fragment):j.fragment).childNodes);return e.merge(this,a)}h=c.getElementById(g[2]);if(h&&h.parentNode){if(h.id!==g[2])return f.find(a);this.length=1,this[0]=h}this.context=c,this.selector=a;return this}return!d||d.jquery?(d||f).find(a):this.constructor(d).find(a)}if(e.isFunction(a))return f.ready(a);a.selector!==b&&(this.selector=a.selector,this.context=a.context);return e.makeArray(a,this)},selector:"",jquery:"1.6.2",length:0,size:function(){return this.length},toArray:function(){return F.call(this,0)},get:function(a){return a==null?this.toArray():a<0?this[this.length+a]:this[a]},pushStack:function(a,b,c){var d=this.constructor();e.isArray(a)?E.apply(d,a):e.merge(d,a),d.prevObject=this,d.context=this.context,b==="find"?d.selector=this.selector+(this.selector?" ":"")+c:b&&(d.selector=this.selector+"."+b+"("+c+")");return d},each:function(a,b){return e.each(this,a,b)},ready:function(a){e.bindReady(),A.done(a);return this},eq:function(a){return a===-1?this.slice(a):this.slice(a,+a+1)},first:function(){return this.eq(0)},last:function(){return this.eq(-1)},slice:function(){return this.pushStack(F.apply(this,arguments),"slice",F.call(arguments).join(","))},map:function(a){return this.pushStack(e.map(this,function(b,c){return a.call(b,c,b)}))},end:function(){return this.prevObject||this.constructor(null)},push:E,sort:[].sort,splice:[].splice},e.fn.init.prototype=e.fn,e.extend=e.fn.extend=function(){var a,c,d,f,g,h,i=arguments[0]||{},j=1,k=arguments.length,l=!1;typeof i=="boolean"&&(l=i,i=arguments[1]||{},j=2),typeof i!="object"&&!e.isFunction(i)&&(i={}),k===j&&(i=this,--j);for(;j<k;j++)if((a=arguments[j])!=null)for(c in a){d=i[c],f=a[c];if(i===f)continue;l&&f&&(e.isPlainObject(f)||(g=e.isArray(f)))?(g?(g=!1,h=d&&e.isArray(d)?d:[]):h=d&&e.isPlainObject(d)?d:{},i[c]=e.extend(l,h,f)):f!==b&&(i[c]=f)}return i},e.extend({noConflict:function(b){a.$===e&&(a.$=g),b&&a.jQuery===e&&(a.jQuery=f);return e},isReady:!1,readyWait:1,holdReady:function(a){a?e.readyWait++:e.ready(!0)},ready:function(a){if(a===!0&&!--e.readyWait||a!==!0&&!e.isReady){if(!c.body)return setTimeout(e.ready,1);e.isReady=!0;if(a!==!0&&--e.readyWait>0)return;A.resolveWith(c,[e]),e.fn.trigger&&e(c).trigger("ready").unbind("ready")}},bindReady:function(){if(!A){A=e._Deferred();if(c.readyState==="complete")return setTimeout(e.ready,1);if(c.addEventListener)c.addEventListener("DOMContentLoaded",B,!1),a.addEventListener("load",e.ready,!1);else if(c.attachEvent){c.attachEvent("onreadystatechange",B),a.attachEvent("onload",e.ready);var b=!1;try{b=a.frameElement==null}catch(d){}c.documentElement.doScroll&&b&&J()}}},isFunction:function(a){return e.type(a)==="function"},isArray:Array.isArray||function(a){return e.type(a)==="array"},isWindow:function(a){return a&&typeof a=="object"&&"setInterval"in a},isNaN:function(a){return a==null||!m.test(a)||isNaN(a)},type:function(a){return a==null?String(a):I[C.call(a)]||"object"},isPlainObject:function(a){if(!a||e.type(a)!=="object"||a.nodeType||e.isWindow(a))return!1;if(a.constructor&&!D.call(a,"constructor")&&!D.call(a.constructor.prototype,"isPrototypeOf"))return!1;var c;for(c in a);return c===b||D.call(a,c)},isEmptyObject:function(a){for(var b in a)return!1;return!0},error:function(a){throw a},parseJSON:function(b){if(typeof b!="string"||!b)return null;b=e.trim(b);if(a.JSON&&a.JSON.parse)return a.JSON.parse(b);if(o.test(b.replace(p,"@").replace(q,"]").replace(r,"")))return(new Function("return "+b))();e.error("Invalid JSON: "+b)},parseXML:function(b,c,d){a.DOMParser?(d=new DOMParser,c=d.parseFromString(b,"text/xml")):(c=new ActiveXObject("Microsoft.XMLDOM"),c.async="false",c.loadXML(b)),d=c.documentElement,(!d||!d.nodeName||d.nodeName==="parsererror")&&e.error("Invalid XML: "+b);return c},noop:function(){},globalEval:function(b){b&&j.test(b)&&(a.execScript||function(b){a.eval.call(a,b)})(b)},camelCase:function(a){return a.replace(w,x)},nodeName:function(a,b){return a.nodeName&&a.nodeName.toUpperCase()===b.toUpperCase()},each:function(a,c,d){var f,g=0,h=a.length,i=h===b||e.isFunction(a);if(d){if(i){for(f in a)if(c.apply(a[f],d)===!1)break}else for(;g<h;)if(c.apply(a[g++],d)===!1)break}else if(i){for(f in a)if(c.call(a[f],f,a[f])===!1)break}else for(;g<h;)if(c.call(a[g],g,a[g++])===!1)break;return a},trim:G?function(a){return a==null?"":G.call(a)}:function(a){return a==null?"":(a+"").replace(k,"").replace(l,"")},makeArray:function(a,b){var c=b||[];if(a!=null){var d=e.type(a);a.length==null||d==="string"||d==="function"||d==="regexp"||e.isWindow(a)?E.call(c,a):e.merge(c,a)}return c},inArray:function(a,b){if(H)return H.call(b,a);for(var c=0,d=b.length;c<d;c++)if(b[c]===a)return c;return-1},merge:function(a,c){var d=a.length,e=0;if(typeof c.length=="number")for(var f=c.length;e<f;e++)a[d++]=c[e];else while(c[e]!==b)a[d++]=c[e++];a.length=d;return a},grep:function(a,b,c){var d=[],e;c=!!c;for(var f=0,g=a.length;f<g;f++)e=!!b(a[f],f),c!==e&&d.push(a[f]);return d},map:function(a,c,d){var f,g,h=[],i=0,j=a.length,k=a instanceof e||j!==b&&typeof j=="number"&&(j>0&&a[0]&&a[j-1]||j===0||e.isArray(a));if(k)for(;i<j;i++)f=c(a[i],i,d),f!=null&&(h[h.length]=f);else for(g in a)f=c(a[g],g,d),f!=null&&(h[h.length]=f);return h.concat.apply([],h)},guid:1,proxy:function(a,c){if(typeof c=="string"){var d=a[c];c=a,a=d}if(!e.isFunction(a))return b;var f=F.call(arguments,2),g=function(){return a.apply(c,f.concat(F.call(arguments)))};g.guid=a.guid=a.guid||g.guid||e.guid++;return g},access:function(a,c,d,f,g,h){var i=a.length;if(typeof c=="object"){for(var j in c)e.access(a,j,c[j],f,g,d);return a}if(d!==b){f=!h&&f&&e.isFunction(d);for(var k=0;k<i;k++)g(a[k],c,f?d.call(a[k],k,g(a[k],c)):d,h);return a}return i?g(a[0],c):b},now:function(){return(new Date).getTime()},uaMatch:function(a){a=a.toLowerCase();var b=s.exec(a)||t.exec(a)||u.exec(a)||a.indexOf("compatible")<0&&v.exec(a)||[];return{browser:b[1]||"",version:b[2]||"0"}},sub:function(){function a(b,c){return new a.fn.init(b,c)}e.extend(!0,a,this),a.superclass=this,a.fn=a.prototype=this(),a.fn.constructor=a,a.sub=this.sub,a.fn.init=function(d,f){f&&f instanceof e&&!(f instanceof a)&&(f=a(f));return e.fn.init.call(this,d,f,b)},a.fn.init.prototype=a.fn;var b=a(c);return a},browser:{}}),e.each("Boolean Number String Function Array Date RegExp Object".split(" "),function(a,b){I["[object "+b+"]"]=b.toLowerCase()}),z=e.uaMatch(y),z.browser&&(e.browser[z.browser]=!0,e.browser.version=z.version),e.browser.webkit&&(e.browser.safari=!0),j.test(" ")&&(k=/^[\s\xA0]+/,l=/[\s\xA0]+$/),h=e(c),c.addEventListener?B=function(){c.removeEventListener("DOMContentLoaded",B,!1),e.ready()}:c.attachEvent&&(B=function(){c.readyState==="complete"&&(c.detachEvent("onreadystatechange",B),e.ready())});return e}(),g="done fail isResolved isRejected promise then always pipe".split(" "),h=[].slice;f.extend({_Deferred:function(){var a=[],b,c,d,e={done:function(){if(!d){var c=arguments,g,h,i,j,k;b&&(k=b,b=0);for(g=0,h=c.length;g<h;g++)i=c[g],j=f.type(i),j==="array"?e.done.apply(e,i):j==="function"&&a.push(i);k&&e.resolveWith(k[0],k[1])}return this},resolveWith:function(e,f){if(!d&&!b&&!c){f=f||[],c=1;try{while(a[0])a.shift().apply(e,f)}finally{b=[e,f],c=0}}return this},resolve:function(){e.resolveWith(this,arguments);return this},isResolved:function(){return!!c||!!b},cancel:function(){d=1,a=[];return this}};return e},Deferred:function(a){var b=f._Deferred(),c=f._Deferred(),d;f.extend(b,{then:function(a,c){b.done(a).fail(c);return this},always:function(){return b.done.apply(b,arguments).fail.apply(this,arguments)},fail:c.done,rejectWith:c.resolveWith,reject:c.resolve,isRejected:c.isResolved,pipe:function(a,c){return f.Deferred(function(d){f.each({done:[a,"resolve"],fail:[c,"reject"]},function(a,c){var e=c[0],g=c[1],h;f.isFunction(e)?b[a](function(){h=e.apply(this,arguments),h&&f.isFunction(h.promise)?h.promise().then(d.resolve,d.reject):d[g](h)}):b[a](d[g])})}).promise()},promise:function(a){if(a==null){if(d)return d;d=a={}}var c=g.length;while(c--)a[g[c]]=b[g[c]];return a}}),b.done(c.cancel).fail(b.cancel),delete b.cancel,a&&a.call(b,b);return b},when:function(a){function i(a){return function(c){b[a]=arguments.length>1?h.call(arguments,0):c,--e||g.resolveWith(g,h.call(b,0))}}var b=arguments,c=0,d=b.length,e=d,g=d<=1&&a&&f.isFunction(a.promise)?a:f.Deferred();if(d>1){for(;c<d;c++)b[c]&&f.isFunction(b[c].promise)?b[c].promise().then(i(c),g.reject):--e;e||g.resolveWith(g,b)}else g!==a&&g.resolveWith(g,d?[a]:[]);return g.promise()}}),f.support=function(){var a=c.createElement("div"),b=c.documentElement,d,e,g,h,i,j,k,l,m,n,o,p,q,r,s,t,u;a.setAttribute("className","t"),a.innerHTML="   <link/><table></table><a href='/a' style='top:1px;float:left;opacity:.55;'>a</a><input type='checkbox'/>",d=a.getElementsByTagName("*"),e=a.getElementsByTagName("a")[0];if(!d||!d.length||!e)return{};g=c.createElement("select"),h=g.appendChild(c.createElement("option")),i=a.getElementsByTagName("input")[0],k={leadingWhitespace:a.firstChild.nodeType===3,tbody:!a.getElementsByTagName("tbody").length,htmlSerialize:!!a.getElementsByTagName("link").length,style:/top/.test(e.getAttribute("style")),hrefNormalized:e.getAttribute("href")==="/a",opacity:/^0.55$/.test(e.style.opacity),cssFloat:!!e.style.cssFloat,checkOn:i.value==="on",optSelected:h.selected,getSetAttribute:a.className!=="t",submitBubbles:!0,changeBubbles:!0,focusinBubbles:!1,deleteExpando:!0,noCloneEvent:!0,inlineBlockNeedsLayout:!1,shrinkWrapBlocks:!1,reliableMarginRight:!0},i.checked=!0,k.noCloneChecked=i.cloneNode(!0).checked,g.disabled=!0,k.optDisabled=!h.disabled;try{delete a.test}catch(v){k.deleteExpando=!1}!a.addEventListener&&a.attachEvent&&a.fireEvent&&(a.attachEvent("onclick",function(){k.noCloneEvent=!1}),a.cloneNode(!0).fireEvent("onclick")),i=c.createElement("input"),i.value="t",i.setAttribute("type","radio"),k.radioValue=i.value==="t",i.setAttribute("checked","checked"),a.appendChild(i),l=c.createDocumentFragment(),l.appendChild(a.firstChild),k.checkClone=l.cloneNode(!0).cloneNode(!0).lastChild.checked,a.innerHTML="",a.style.width=a.style.paddingLeft="1px",m=c.getElementsByTagName("body")[0],o=c.createElement(m?"div":"body"),p={visibility:"hidden",width:0,height:0,border:0,margin:0},m&&f.extend(p,{position:"absolute",left:-1e3,top:-1e3});for(t in p)o.style[t]=p[t];o.appendChild(a),n=m||b,n.insertBefore(o,n.firstChild),k.appendChecked=i.checked,k.boxModel=a.offsetWidth===2,"zoom"in a.style&&(a.style.display="inline",a.style.zoom=1,k.inlineBlockNeedsLayout=a.offsetWidth===2,a.style.display="",a.innerHTML="<div style='width:4px;'></div>",k.shrinkWrapBlocks=a.offsetWidth!==2),a.innerHTML="<table><tr><td style='padding:0;border:0;display:none'></td><td>t</td></tr></table>",q=a.getElementsByTagName("td"),u=q[0].offsetHeight===0,q[0].style.display="",q[1].style.display="none",k.reliableHiddenOffsets=u&&q[0].offsetHeight===0,a.innerHTML="",c.defaultView&&c.defaultView.getComputedStyle&&(j=c.createElement("div"),j.style.width="0",j.style.marginRight="0",a.appendChild(j),k.reliableMarginRight=(parseInt((c.defaultView.getComputedStyle(j,null)||{marginRight:0}).marginRight,10)||0)===0),o.innerHTML="",n.removeChild(o);if(a.attachEvent)for(t in{submit:1,change:1,focusin:1})s="on"+t,u=s in a,u||(a.setAttribute(s,"return;"),u=typeof a[s]=="function"),k[t+"Bubbles"]=u;o=l=g=h=m=j=a=i=null;return k}(),f.boxModel=f.support.boxModel;var i=/^(?:\{.*\}|\[.*\])$/,j=/([a-z])([A-Z])/g;f.extend({cache:{},uuid:0,expando:"jQuery"+(f.fn.jquery+Math.random()).replace(/\D/g,""),noData:{embed:!0,object:"clsid:D27CDB6E-AE6D-11cf-96B8-444553540000",applet:!0},hasData:function(a){a=a.nodeType?f.cache[a[f.expando]]:a[f.expando];return!!a&&!l(a)},data:function(a,c,d,e){if(!!f.acceptData(a)){var g=f.expando,h=typeof c=="string",i,j=a.nodeType,k=j?f.cache:a,l=j?a[f.expando]:a[f.expando]&&f.expando;if((!l||e&&l&&!k[l][g])&&h&&d===b)return;l||(j?a[f.expando]=l=++f.uuid:l=f.expando),k[l]||(k[l]={},j||(k[l].toJSON=f.noop));if(typeof c=="object"||typeof c=="function")e?k[l][g]=f.extend(k[l][g],c):k[l]=f.extend(k[l],c);i=k[l],e&&(i[g]||(i[g]={}),i=i[g]),d!==b&&(i[f.camelCase(c)]=d);if(c==="events"&&!i[c])return i[g]&&i[g].events;return h?i[f.camelCase(c)]||i[c]:i}},removeData:function(b,c,d){if(!!f.acceptData(b)){var e=f.expando,g=b.nodeType,h=g?f.cache:b,i=g?b[f.expando]:f.expando;if(!h[i])return;if(c){var j=d?h[i][e]:h[i];if(j){delete j[c];if(!l(j))return}}if(d){delete h[i][e];if(!l(h[i]))return}var k=h[i][e];f.support.deleteExpando||h!=a?delete h[i]:h[i]=null,k?(h[i]={},g||(h[i].toJSON=f.noop),h[i][e]=k):g&&(f.support.deleteExpando?delete b[f.expando]:b.removeAttribute?b.removeAttribute(f.expando):b[f.expando]=null)}},_data:function(a,b,c){return f.data(a,b,c,!0)},acceptData:function(a){if(a.nodeName){var b=f.noData[a.nodeName.toLowerCase()];if(b)return b!==!0&&a.getAttribute("classid")===b}return!0}}),f.fn.extend({data:function(a,c){var d=null;if(typeof a=="undefined"){if(this.length){d=f.data(this[0]);if(this[0].nodeType===1){var e=this[0].attributes,g;for(var h=0,i=e.length;h<i;h++)g=e[h].name,g.indexOf("data-")===0&&(g=f.camelCase(g.substring(5)),k(this[0],g,d[g]))}}return d}if(typeof a=="object")return this.each(function(){f.data(this,a)});var j=a.split(".");j[1]=j[1]?"."+j[1]:"";if(c===b){d=this.triggerHandler("getData"+j[1]+"!",[j[0]]),d===b&&this.length&&(d=f.data(this[0],a),d=k(this[0],a,d));return d===b&&j[1]?this.data(j[0]):d}return this.each(function(){var b=f(this),d=[j[0],c];b.triggerHandler("setData"+j[1]+"!",d),f.data(this,a,c),b.triggerHandler("changeData"+j[1]+"!",d)})},removeData:function(a){return this.each(function(){f.removeData(this,a)})}}),f.extend({_mark:function(a,c){a&&(c=(c||"fx")+"mark",f.data(a,c,(f.data(a,c,b,!0)||0)+1,!0))},_unmark:function(a,c,d){a!==!0&&(d=c,c=a,a=!1);if(c){d=d||"fx";var e=d+"mark",g=a?0:(f.data(c,e,b,!0)||1)-1;g?f.data(c,e,g,!0):(f.removeData(c,e,!0),m(c,d,"mark"))}},queue:function(a,c,d){if(a){c=(c||"fx")+"queue";var e=f.data(a,c,b,!0);d&&(!e||f.isArray(d)?e=f.data(a,c,f.makeArray(d),!0):e.push(d));return e||[]}},dequeue:function(a,b){b=b||"fx";var c=f.queue(a,b),d=c.shift(),e;d==="inprogress"&&(d=c.shift()),d&&(b==="fx"&&c.unshift("inprogress"),d.call(a,function(){f.dequeue(a,b)})),c.length||(f.removeData(a,b+"queue",!0),m(a,b,"queue"))}}),f.fn.extend({queue:function(a,c){typeof a!="string"&&(c=a,a="fx");if(c===b)return f.queue(this[0],a);return this.each(function(){var b=f.queue(this,a,c);a==="fx"&&b[0]!=="inprogress"&&f.dequeue(this,a)})},dequeue:function(a){return this.each(function(){f.dequeue(this,a)})},delay:function(a,b){a=f.fx?f.fx.speeds[a]||a:a,b=b||"fx";return this.queue(b,function(){var c=this;setTimeout(function(){f.dequeue(c,b)},a)})},clearQueue:function(a){return this.queue(a||"fx",[])},promise:function(a,c){function m(){--h||d.resolveWith(e,[e])}typeof a!="string"&&(c=a,a=b),a=a||"fx";var d=f.Deferred(),e=this,g=e.length,h=1,i=a+"defer",j=a+"queue",k=a+"mark",l;while(g--)if(l=f.data(e[g],i,b,!0)||(f.data(e[g],j,b,!0)||f.data(e[g],k,b,!0))&&f.data(e[g],i,f._Deferred(),!0))h++,l.done(m);m();return d.promise()}});var n=/[\n\t\r]/g,o=/\s+/,p=/\r/g,q=/^(?:button|input)$/i,r=/^(?:button|input|object|select|textarea)$/i,s=/^a(?:rea)?$/i,t=/^(?:autofocus|autoplay|async|checked|controls|defer|disabled|hidden|loop|multiple|open|readonly|required|scoped|selected)$/i,u=/\:|^on/,v,w;f.fn.extend({attr:function(a,b){return f.access(this,a,b,!0,f.attr)},removeAttr:function(a){return this.each(function(){f.removeAttr(this,a)})},prop:function(a,b){return f.access(this,a,b,!0,f.prop)},removeProp:function(a){a=f.propFix[a]||a;return this.each(function(){try{this[a]=b,delete this[a]}catch(c){}})},addClass:function(a){var b,c,d,e,g,h,i;if(f.isFunction(a))return this.each(function(b){f(this).addClass(a.call(this,b,this.className))});if(a&&typeof a=="string"){b=a.split(o);for(c=0,d=this.length;c<d;c++){e=this[c];if(e.nodeType===1)if(!e.className&&b.length===1)e.className=a;else{g=" "+e.className+" ";for(h=0,i=b.length;h<i;h++)~g.indexOf(" "+b[h]+" ")||(g+=b[h]+" ");e.className=f.trim(g)}}}return this},removeClass:function(a){var c,d,e,g,h,i,j;if(f.isFunction(a))return this.each(function(b){f(this).removeClass(a.call(this,b,this.className))});if(a&&typeof a=="string"||a===b){c=(a||"").split(o);for(d=0,e=this.length;d<e;d++){g=this[d];if(g.nodeType===1&&g.className)if(a){h=(" "+g.className+" ").replace(n," ");for(i=0,j=c.length;i<j;i++)h=h.replace(" "+c[i]+" "," ");g.className=f.trim(h)}else g.className=""}}return this},toggleClass:function(a,b){var c=typeof a,d=typeof b=="boolean";if(f.isFunction(a))return this.each(function(c){f(this).toggleClass(a.call(this,c,this.className,b),b)});return this.each(function(){if(c==="string"){var e,g=0,h=f(this),i=b,j=a.split(o);while(e=j[g++])i=d?i:!h.hasClass(e),h[i?"addClass":"removeClass"](e)}else if(c==="undefined"||c==="boolean")this.className&&f._data(this,"__className__",this.className),this.className=this.className||a===!1?"":f._data(this,"__className__")||""})},hasClass:function(a){var b=" "+a+" ";for(var c=0,d=this.length;c<d;c++)if((" "+this[c].className+" ").replace(n," ").indexOf(b)>-1)return!0;return!1},val:function(a){var c,d,e=this[0];if(!arguments.length){if(e){c=f.valHooks[e.nodeName.toLowerCase()]||f.valHooks[e.type];if(c&&"get"in c&&(d=c.get(e,"value"))!==b)return d;d=e.value;return typeof d=="string"?d.replace(p,""):d==null?"":d}return b}var g=f.isFunction(a);return this.each(function(d){var e=f(this),h;if(this.nodeType===1){g?h=a.call(this,d,e.val()):h=a,h==null?h="":typeof h=="number"?h+="":f.isArray(h)&&(h=f.map(h,function(a){return a==null?"":a+""})),c=f.valHooks[this.nodeName.toLowerCase()]||f.valHooks[this.type];if(!c||!("set"in c)||c.set(this,h,"value")===b)this.value=h}})}}),f.extend({valHooks:{option:{get:function(a){var b=a.attributes.value;return!b||b.specified?a.value:a.text}},select:{get:function(a){var b,c=a.selectedIndex,d=[],e=a.options,g=a.type==="select-one";if(c<0)return null;for(var h=g?c:0,i=g?c+1:e.length;h<i;h++){var j=e[h];if(j.selected&&(f.support.optDisabled?!j.disabled:j.getAttribute("disabled")===null)&&(!j.parentNode.disabled||!f.nodeName(j.parentNode,"optgroup"))){b=f(j).val();if(g)return b;d.push(b)}}if(g&&!d.length&&e.length)return f(e[c]).val();return d},set:function(a,b){var c=f.makeArray(b);f(a).find("option").each(function(){this.selected=f.inArray(f(this).val(),c)>=0}),c.length||(a.selectedIndex=-1);return c}}},attrFn:{val:!0,css:!0,html:!0,text:!0,data:!0,width:!0,height:!0,offset:!0},attrFix:{tabindex:"tabIndex"},attr:function(a,c,d,e){var g=a.nodeType;if(!a||g===3||g===8||g===2)return b;if(e&&c in f.attrFn)return f(a)[c](d);if(!("getAttribute"in a))return f.prop(a,c,d);var h,i,j=g!==1||!f.isXMLDoc(a);j&&(c=f.attrFix[c]||c,i=f.attrHooks[c],i||(t.test(c)?i=w:v&&c!=="className"&&(f.nodeName(a,"form")||u.test(c))&&(i=v)));if(d!==b){if(d===null){f.removeAttr(a,c);return b}if(i&&"set"in i&&j&&(h=i.set(a,d,c))!==b)return h;a.setAttribute(c,""+d);return d}if(i&&"get"in i&&j&&(h=i.get(a,c))!==null)return h;h=a.getAttribute(c);return h===null?b:h},removeAttr:function(a,b){var c;a.nodeType===1&&(b=f.attrFix[b]||b,f.support.getSetAttribute?a.removeAttribute(b):(f.attr(a,b,""),a.removeAttributeNode(a.getAttributeNode(b))),t.test(b)&&(c=f.propFix[b]||b)in a&&(a[c]=!1))},attrHooks:{type:{set:function(a,b){if(q.test(a.nodeName)&&a.parentNode)f.error("type property can't be changed");else if(!f.support.radioValue&&b==="radio"&&f.nodeName(a,"input")){var c=a.value;a.setAttribute("type",b),c&&(a.value=c);return b}}},tabIndex:{get:function(a){var c=a.getAttributeNode("tabIndex");return c&&c.specified?parseInt(c.value,10):r.test(a.nodeName)||s.test(a.nodeName)&&a.href?0:b}},value:{get:function(a,b){if(v&&f.nodeName(a,"button"))return v.get(a,b);return b in a?a.value:null},set:function(a,b,c){if(v&&f.nodeName(a,"button"))return v.set(a,b,c);a.value=b}}},propFix:{tabindex:"tabIndex",readonly:"readOnly","for":"htmlFor","class":"className",maxlength:"maxLength",cellspacing:"cellSpacing",cellpadding:"cellPadding",rowspan:"rowSpan",colspan:"colSpan",usemap:"useMap",frameborder:"frameBorder",contenteditable:"contentEditable"},prop:function(a,c,d){var e=a.nodeType;if(!a||e===3||e===8||e===2)return b;var g,h,i=e!==1||!f.isXMLDoc(a);i&&(c=f.propFix[c]||c,h=f.propHooks[c]);return d!==b?h&&"set"in h&&(g=h.set(a,d,c))!==b?g:a[c]=d:h&&"get"in h&&(g=h.get(a,c))!==b?g:a[c]},propHooks:{}}),w={get:function(a,c){return f.prop(a,c)?c.toLowerCase():b},set:function(a,b,c){var d;b===!1?f.removeAttr(a,c):(d=f.propFix[c]||c,d in a&&(a[d]=!0),a.setAttribute(c,c.toLowerCase()));return c}},f.support.getSetAttribute||(f.attrFix=f.propFix,v=f.attrHooks.name=f.attrHooks.title=f.valHooks.button={get:function(a,c){var d;d=a.getAttributeNode(c);return d&&d.nodeValue!==""?d.nodeValue:b},set:function(a,b,c){var d=a.getAttributeNode(c);if(d){d.nodeValue=b;return b}}},f.each(["width","height"],function(a,b){f.attrHooks[b]=f.extend(f.attrHooks[b],{set:function(a,c){if(c===""){a.setAttribute(b,"auto");return c}}})})),f.support.hrefNormalized||f.each(["href","src","width","height"],function(a,c){f.attrHooks[c]=f.extend(f.attrHooks[c],{get:function(a){var d=a.getAttribute(c,2);return d===null?b:d}})}),f.support.style||(f.attrHooks.style={get:function(a){return a.style.cssText.toLowerCase()||b},set:function(a,b){return a.style.cssText=""+b}}),f.support.optSelected||(f.propHooks.selected=f.extend(f.propHooks.selected,{get:function(a){var b=a.parentNode;b&&(b.selectedIndex,b.parentNode&&b.parentNode.selectedIndex)}})),f.support.checkOn||f.each(["radio","checkbox"],function(){f.valHooks[this]={get:function(a){return a.getAttribute("value")===null?"on":a.value}}}),f.each(["radio","checkbox"],function(){f.valHooks[this]=f.extend(f.valHooks[this],{set:function(a,b){if(f.isArray(b))return a.checked=f.inArray(f(a).val(),b)>=0}})});var x=/\.(.*)$/,y=/^(?:textarea|input|select)$/i,z=/\./g,A=/ /g,B=/[^\w\s.|`]/g,C=function(a){return a.replace(B,"\\$&")};f.event={add:function(a,c,d,e){if(a.nodeType!==3&&a.nodeType!==8){if(d===!1)d=D;else if(!d)return;var g,h;d.handler&&(g=d,d=g.handler),d.guid||(d.guid=f.guid++);var i=f._data(a);if(!i)return;var j=i.events,k=i.handle;j||(i.events=j={}),k||(i.handle=k=function(a){return typeof f!="undefined"&&(!a||f.event.triggered!==a.type)?f.event.handle.apply(k.elem,arguments):b}),k.elem=a,c=c.split(" ");var l,m=0,n;while(l=c[m++]){h=g?f.extend({},g):{handler:d,data:e},l.indexOf(".")>-1?(n=l.split("."),l=n.shift(),h.namespace=n.slice(0).sort().join(".")):(n=[],h.namespace=""),h.type=l,h.guid||(h.guid=d.guid);var o=j[l],p=f.event.special[l]||{};if(!o){o=j[l]=[];if(!p.setup||p.setup.call(a,e,n,k)===!1)a.addEventListener?a.addEventListener(l,k,!1):a.attachEvent&&a.attachEvent("on"+l,k)}p.add&&(p.add.call(a,h),h.handler.guid||(h.handler.guid=d.guid)),o.push(h),f.event.global[l]=!0}a=null}},global:{},remove:function(a,c,d,e){if(a.nodeType!==3&&a.nodeType!==8){d===!1&&(d=D);var g,h,i,j,k=0,l,m,n,o,p,q,r,s=f.hasData(a)&&f._data(a),t=s&&s.events;if(!s||!t)return;c&&c.type&&(d=c.handler,c=c.type);if(!c||typeof c=="string"&&c.charAt(0)==="."){c=c||"";for(h in t)f.event.remove(a,h+c);return}c=c.split(" ");while(h=c[k++]){r=h,q=null,l=h.indexOf(".")<0,m=[],l||(m=h.split("."),h=m.shift(),n=new RegExp("(^|\\.)"+f.map(m.slice(0).sort(),C).join("\\.(?:.*\\.)?")+"(\\.|$)")),p=t[h];if(!p)continue;if(!d){for(j=0;j<p.length;j++){q=p[j];if(l||n.test(q.namespace))f.event.remove(a,r,q.handler,j),p.splice(j--,1)}continue}o=f.event.special[h]||{};for(j=e||0;j<p.length;j++){q=p[j];if(d.guid===q.guid){if(l||n.test(q.namespace))e==null&&p.splice(j--,1),o.remove&&o.remove.call(a,q);if(e!=null)break}}if(p.length===0||e!=null&&p.length===1)(!o.teardown||o.teardown.call(a,m)===!1)&&f.removeEvent(a,h,s.handle),g=null,delete t[h]}if(f.isEmptyObject(t)){var u=s.handle;u&&(u.elem=null),delete s.events,delete s.handle,f.isEmptyObject(s)&&f.removeData(a,b,!0)}}},customEvent:{getData:!0,setData:!0,changeData:!0},trigger:function(c,d,e,g){var h=c.type||c,i=[],j;h.indexOf("!")>=0&&(h=h.slice(0,-1),j=!0),h.indexOf(".")>=0&&(i=h.split("."),h=i.
shift(),i.sort());if(!!e&&!f.event.customEvent[h]||!!f.event.global[h]){c=typeof c=="object"?c[f.expando]?c:new f.Event(h,c):new f.Event(h),c.type=h,c.exclusive=j,c.namespace=i.join("."),c.namespace_re=new RegExp("(^|\\.)"+i.join("\\.(?:.*\\.)?")+"(\\.|$)");if(g||!e)c.preventDefault(),c.stopPropagation();if(!e){f.each(f.cache,function(){var a=f.expando,b=this[a];b&&b.events&&b.events[h]&&f.event.trigger(c,d,b.handle.elem)});return}if(e.nodeType===3||e.nodeType===8)return;c.result=b,c.target=e,d=d!=null?f.makeArray(d):[],d.unshift(c);var k=e,l=h.indexOf(":")<0?"on"+h:"";do{var m=f._data(k,"handle");c.currentTarget=k,m&&m.apply(k,d),l&&f.acceptData(k)&&k[l]&&k[l].apply(k,d)===!1&&(c.result=!1,c.preventDefault()),k=k.parentNode||k.ownerDocument||k===c.target.ownerDocument&&a}while(k&&!c.isPropagationStopped());if(!c.isDefaultPrevented()){var n,o=f.event.special[h]||{};if((!o._default||o._default.call(e.ownerDocument,c)===!1)&&(h!=="click"||!f.nodeName(e,"a"))&&f.acceptData(e)){try{l&&e[h]&&(n=e[l],n&&(e[l]=null),f.event.triggered=h,e[h]())}catch(p){}n&&(e[l]=n),f.event.triggered=b}}return c.result}},handle:function(c){c=f.event.fix(c||a.event);var d=((f._data(this,"events")||{})[c.type]||[]).slice(0),e=!c.exclusive&&!c.namespace,g=Array.prototype.slice.call(arguments,0);g[0]=c,c.currentTarget=this;for(var h=0,i=d.length;h<i;h++){var j=d[h];if(e||c.namespace_re.test(j.namespace)){c.handler=j.handler,c.data=j.data,c.handleObj=j;var k=j.handler.apply(this,g);k!==b&&(c.result=k,k===!1&&(c.preventDefault(),c.stopPropagation()));if(c.isImmediatePropagationStopped())break}}return c.result},props:"altKey attrChange attrName bubbles button cancelable charCode clientX clientY ctrlKey currentTarget data detail eventPhase fromElement handler keyCode layerX layerY metaKey newValue offsetX offsetY pageX pageY prevValue relatedNode relatedTarget screenX screenY shiftKey srcElement target toElement view wheelDelta which".split(" "),fix:function(a){if(a[f.expando])return a;var d=a;a=f.Event(d);for(var e=this.props.length,g;e;)g=this.props[--e],a[g]=d[g];a.target||(a.target=a.srcElement||c),a.target.nodeType===3&&(a.target=a.target.parentNode),!a.relatedTarget&&a.fromElement&&(a.relatedTarget=a.fromElement===a.target?a.toElement:a.fromElement);if(a.pageX==null&&a.clientX!=null){var h=a.target.ownerDocument||c,i=h.documentElement,j=h.body;a.pageX=a.clientX+(i&&i.scrollLeft||j&&j.scrollLeft||0)-(i&&i.clientLeft||j&&j.clientLeft||0),a.pageY=a.clientY+(i&&i.scrollTop||j&&j.scrollTop||0)-(i&&i.clientTop||j&&j.clientTop||0)}a.which==null&&(a.charCode!=null||a.keyCode!=null)&&(a.which=a.charCode!=null?a.charCode:a.keyCode),!a.metaKey&&a.ctrlKey&&(a.metaKey=a.ctrlKey),!a.which&&a.button!==b&&(a.which=a.button&1?1:a.button&2?3:a.button&4?2:0);return a},guid:1e8,proxy:f.proxy,special:{ready:{setup:f.bindReady,teardown:f.noop},live:{add:function(a){f.event.add(this,N(a.origType,a.selector),f.extend({},a,{handler:M,guid:a.handler.guid}))},remove:function(a){f.event.remove(this,N(a.origType,a.selector),a)}},beforeunload:{setup:function(a,b,c){f.isWindow(this)&&(this.onbeforeunload=c)},teardown:function(a,b){this.onbeforeunload===b&&(this.onbeforeunload=null)}}}},f.removeEvent=c.removeEventListener?function(a,b,c){a.removeEventListener&&a.removeEventListener(b,c,!1)}:function(a,b,c){a.detachEvent&&a.detachEvent("on"+b,c)},f.Event=function(a,b){if(!this.preventDefault)return new f.Event(a,b);a&&a.type?(this.originalEvent=a,this.type=a.type,this.isDefaultPrevented=a.defaultPrevented||a.returnValue===!1||a.getPreventDefault&&a.getPreventDefault()?E:D):this.type=a,b&&f.extend(this,b),this.timeStamp=f.now(),this[f.expando]=!0},f.Event.prototype={preventDefault:function(){this.isDefaultPrevented=E;var a=this.originalEvent;!a||(a.preventDefault?a.preventDefault():a.returnValue=!1)},stopPropagation:function(){this.isPropagationStopped=E;var a=this.originalEvent;!a||(a.stopPropagation&&a.stopPropagation(),a.cancelBubble=!0)},stopImmediatePropagation:function(){this.isImmediatePropagationStopped=E,this.stopPropagation()},isDefaultPrevented:D,isPropagationStopped:D,isImmediatePropagationStopped:D};var F=function(a){var b=a.relatedTarget,c=!1,d=a.type;a.type=a.data,b!==this&&(b&&(c=f.contains(this,b)),c||(f.event.handle.apply(this,arguments),a.type=d))},G=function(a){a.type=a.data,f.event.handle.apply(this,arguments)};f.each({mouseenter:"mouseover",mouseleave:"mouseout"},function(a,b){f.event.special[a]={setup:function(c){f.event.add(this,b,c&&c.selector?G:F,a)},teardown:function(a){f.event.remove(this,b,a&&a.selector?G:F)}}}),f.support.submitBubbles||(f.event.special.submit={setup:function(a,b){if(!f.nodeName(this,"form"))f.event.add(this,"click.specialSubmit",function(a){var b=a.target,c=b.type;(c==="submit"||c==="image")&&f(b).closest("form").length&&K("submit",this,arguments)}),f.event.add(this,"keypress.specialSubmit",function(a){var b=a.target,c=b.type;(c==="text"||c==="password")&&f(b).closest("form").length&&a.keyCode===13&&K("submit",this,arguments)});else return!1},teardown:function(a){f.event.remove(this,".specialSubmit")}});if(!f.support.changeBubbles){var H,I=function(a){var b=a.type,c=a.value;b==="radio"||b==="checkbox"?c=a.checked:b==="select-multiple"?c=a.selectedIndex>-1?f.map(a.options,function(a){return a.selected}).join("-"):"":f.nodeName(a,"select")&&(c=a.selectedIndex);return c},J=function(c){var d=c.target,e,g;if(!!y.test(d.nodeName)&&!d.readOnly){e=f._data(d,"_change_data"),g=I(d),(c.type!=="focusout"||d.type!=="radio")&&f._data(d,"_change_data",g);if(e===b||g===e)return;if(e!=null||g)c.type="change",c.liveFired=b,f.event.trigger(c,arguments[1],d)}};f.event.special.change={filters:{focusout:J,beforedeactivate:J,click:function(a){var b=a.target,c=f.nodeName(b,"input")?b.type:"";(c==="radio"||c==="checkbox"||f.nodeName(b,"select"))&&J.call(this,a)},keydown:function(a){var b=a.target,c=f.nodeName(b,"input")?b.type:"";(a.keyCode===13&&!f.nodeName(b,"textarea")||a.keyCode===32&&(c==="checkbox"||c==="radio")||c==="select-multiple")&&J.call(this,a)},beforeactivate:function(a){var b=a.target;f._data(b,"_change_data",I(b))}},setup:function(a,b){if(this.type==="file")return!1;for(var c in H)f.event.add(this,c+".specialChange",H[c]);return y.test(this.nodeName)},teardown:function(a){f.event.remove(this,".specialChange");return y.test(this.nodeName)}},H=f.event.special.change.filters,H.focus=H.beforeactivate}f.support.focusinBubbles||f.each({focus:"focusin",blur:"focusout"},function(a,b){function e(a){var c=f.event.fix(a);c.type=b,c.originalEvent={},f.event.trigger(c,null,c.target),c.isDefaultPrevented()&&a.preventDefault()}var d=0;f.event.special[b]={setup:function(){d++===0&&c.addEventListener(a,e,!0)},teardown:function(){--d===0&&c.removeEventListener(a,e,!0)}}}),f.each(["bind","one"],function(a,c){f.fn[c]=function(a,d,e){var g;if(typeof a=="object"){for(var h in a)this[c](h,d,a[h],e);return this}if(arguments.length===2||d===!1)e=d,d=b;c==="one"?(g=function(a){f(this).unbind(a,g);return e.apply(this,arguments)},g.guid=e.guid||f.guid++):g=e;if(a==="unload"&&c!=="one")this.one(a,d,e);else for(var i=0,j=this.length;i<j;i++)f.event.add(this[i],a,g,d);return this}}),f.fn.extend({unbind:function(a,b){if(typeof a=="object"&&!a.preventDefault)for(var c in a)this.unbind(c,a[c]);else for(var d=0,e=this.length;d<e;d++)f.event.remove(this[d],a,b);return this},delegate:function(a,b,c,d){return this.live(b,c,d,a)},undelegate:function(a,b,c){return arguments.length===0?this.unbind("live"):this.die(b,null,c,a)},trigger:function(a,b){return this.each(function(){f.event.trigger(a,b,this)})},triggerHandler:function(a,b){if(this[0])return f.event.trigger(a,b,this[0],!0)},toggle:function(a){var b=arguments,c=a.guid||f.guid++,d=0,e=function(c){var e=(f.data(this,"lastToggle"+a.guid)||0)%d;f.data(this,"lastToggle"+a.guid,e+1),c.preventDefault();return b[e].apply(this,arguments)||!1};e.guid=c;while(d<b.length)b[d++].guid=c;return this.click(e)},hover:function(a,b){return this.mouseenter(a).mouseleave(b||a)}});var L={focus:"focusin",blur:"focusout",mouseenter:"mouseover",mouseleave:"mouseout"};f.each(["live","die"],function(a,c){f.fn[c]=function(a,d,e,g){var h,i=0,j,k,l,m=g||this.selector,n=g?this:f(this.context);if(typeof a=="object"&&!a.preventDefault){for(var o in a)n[c](o,d,a[o],m);return this}if(c==="die"&&!a&&g&&g.charAt(0)==="."){n.unbind(g);return this}if(d===!1||f.isFunction(d))e=d||D,d=b;a=(a||"").split(" ");while((h=a[i++])!=null){j=x.exec(h),k="",j&&(k=j[0],h=h.replace(x,""));if(h==="hover"){a.push("mouseenter"+k,"mouseleave"+k);continue}l=h,L[h]?(a.push(L[h]+k),h=h+k):h=(L[h]||h)+k;if(c==="live")for(var p=0,q=n.length;p<q;p++)f.event.add(n[p],"live."+N(h,m),{data:d,selector:m,handler:e,origType:h,origHandler:e,preType:l});else n.unbind("live."+N(h,m),e)}return this}}),f.each("blur focus focusin focusout load resize scroll unload click dblclick mousedown mouseup mousemove mouseover mouseout mouseenter mouseleave change select submit keydown keypress keyup error".split(" "),function(a,b){f.fn[b]=function(a,c){c==null&&(c=a,a=null);return arguments.length>0?this.bind(b,a,c):this.trigger(b)},f.attrFn&&(f.attrFn[b]=!0)}),function(){function u(a,b,c,d,e,f){for(var g=0,h=d.length;g<h;g++){var i=d[g];if(i){var j=!1;i=i[a];while(i){if(i.sizcache===c){j=d[i.sizset];break}if(i.nodeType===1){f||(i.sizcache=c,i.sizset=g);if(typeof b!="string"){if(i===b){j=!0;break}}else if(k.filter(b,[i]).length>0){j=i;break}}i=i[a]}d[g]=j}}}function t(a,b,c,d,e,f){for(var g=0,h=d.length;g<h;g++){var i=d[g];if(i){var j=!1;i=i[a];while(i){if(i.sizcache===c){j=d[i.sizset];break}i.nodeType===1&&!f&&(i.sizcache=c,i.sizset=g);if(i.nodeName.toLowerCase()===b){j=i;break}i=i[a]}d[g]=j}}}var a=/((?:\((?:\([^()]+\)|[^()]+)+\)|\[(?:\[[^\[\]]*\]|['"][^'"]*['"]|[^\[\]'"]+)+\]|\\.|[^ >+~,(\[\\]+)+|[>+~])(\s*,\s*)?((?:.|\r|\n)*)/g,d=0,e=Object.prototype.toString,g=!1,h=!0,i=/\\/g,j=/\W/;[0,0].sort(function(){h=!1;return 0});var k=function(b,d,f,g){f=f||[],d=d||c;var h=d;if(d.nodeType!==1&&d.nodeType!==9)return[];if(!b||typeof b!="string")return f;var i,j,n,o,q,r,s,t,u=!0,w=k.isXML(d),x=[],y=b;do{a.exec(""),i=a.exec(y);if(i){y=i[3],x.push(i[1]);if(i[2]){o=i[3];break}}}while(i);if(x.length>1&&m.exec(b))if(x.length===2&&l.relative[x[0]])j=v(x[0]+x[1],d);else{j=l.relative[x[0]]?[d]:k(x.shift(),d);while(x.length)b=x.shift(),l.relative[b]&&(b+=x.shift()),j=v(b,j)}else{!g&&x.length>1&&d.nodeType===9&&!w&&l.match.ID.test(x[0])&&!l.match.ID.test(x[x.length-1])&&(q=k.find(x.shift(),d,w),d=q.expr?k.filter(q.expr,q.set)[0]:q.set[0]);if(d){q=g?{expr:x.pop(),set:p(g)}:k.find(x.pop(),x.length===1&&(x[0]==="~"||x[0]==="+")&&d.parentNode?d.parentNode:d,w),j=q.expr?k.filter(q.expr,q.set):q.set,x.length>0?n=p(j):u=!1;while(x.length)r=x.pop(),s=r,l.relative[r]?s=x.pop():r="",s==null&&(s=d),l.relative[r](n,s,w)}else n=x=[]}n||(n=j),n||k.error(r||b);if(e.call(n)==="[object Array]")if(!u)f.push.apply(f,n);else if(d&&d.nodeType===1)for(t=0;n[t]!=null;t++)n[t]&&(n[t]===!0||n[t].nodeType===1&&k.contains(d,n[t]))&&f.push(j[t]);else for(t=0;n[t]!=null;t++)n[t]&&n[t].nodeType===1&&f.push(j[t]);else p(n,f);o&&(k(o,h,f,g),k.uniqueSort(f));return f};k.uniqueSort=function(a){if(r){g=h,a.sort(r);if(g)for(var b=1;b<a.length;b++)a[b]===a[b-1]&&a.splice(b--,1)}return a},k.matches=function(a,b){return k(a,null,null,b)},k.matchesSelector=function(a,b){return k(b,null,null,[a]).length>0},k.find=function(a,b,c){var d;if(!a)return[];for(var e=0,f=l.order.length;e<f;e++){var g,h=l.order[e];if(g=l.leftMatch[h].exec(a)){var j=g[1];g.splice(1,1);if(j.substr(j.length-1)!=="\\"){g[1]=(g[1]||"").replace(i,""),d=l.find[h](g,b,c);if(d!=null){a=a.replace(l.match[h],"");break}}}}d||(d=typeof b.getElementsByTagName!="undefined"?b.getElementsByTagName("*"):[]);return{set:d,expr:a}},k.filter=function(a,c,d,e){var f,g,h=a,i=[],j=c,m=c&&c[0]&&k.isXML(c[0]);while(a&&c.length){for(var n in l.filter)if((f=l.leftMatch[n].exec(a))!=null&&f[2]){var o,p,q=l.filter[n],r=f[1];g=!1,f.splice(1,1);if(r.substr(r.length-1)==="\\")continue;j===i&&(i=[]);if(l.preFilter[n]){f=l.preFilter[n](f,j,d,i,e,m);if(!f)g=o=!0;else if(f===!0)continue}if(f)for(var s=0;(p=j[s])!=null;s++)if(p){o=q(p,f,s,j);var t=e^!!o;d&&o!=null?t?g=!0:j[s]=!1:t&&(i.push(p),g=!0)}if(o!==b){d||(j=i),a=a.replace(l.match[n],"");if(!g)return[];break}}if(a===h)if(g==null)k.error(a);else break;h=a}return j},k.error=function(a){throw"Syntax error, unrecognized expression: "+a};var l=k.selectors={order:["ID","NAME","TAG"],match:{ID:/#((?:[\w\u00c0-\uFFFF\-]|\\.)+)/,CLASS:/\.((?:[\w\u00c0-\uFFFF\-]|\\.)+)/,NAME:/\[name=['"]*((?:[\w\u00c0-\uFFFF\-]|\\.)+)['"]*\]/,ATTR:/\[\s*((?:[\w\u00c0-\uFFFF\-]|\\.)+)\s*(?:(\S?=)\s*(?:(['"])(.*?)\3|(#?(?:[\w\u00c0-\uFFFF\-]|\\.)*)|)|)\s*\]/,TAG:/^((?:[\w\u00c0-\uFFFF\*\-]|\\.)+)/,CHILD:/:(only|nth|last|first)-child(?:\(\s*(even|odd|(?:[+\-]?\d+|(?:[+\-]?\d*)?n\s*(?:[+\-]\s*\d+)?))\s*\))?/,POS:/:(nth|eq|gt|lt|first|last|even|odd)(?:\((\d*)\))?(?=[^\-]|$)/,PSEUDO:/:((?:[\w\u00c0-\uFFFF\-]|\\.)+)(?:\((['"]?)((?:\([^\)]+\)|[^\(\)]*)+)\2\))?/},leftMatch:{},attrMap:{"class":"className","for":"htmlFor"},attrHandle:{href:function(a){return a.getAttribute("href")},type:function(a){return a.getAttribute("type")}},relative:{"+":function(a,b){var c=typeof b=="string",d=c&&!j.test(b),e=c&&!d;d&&(b=b.toLowerCase());for(var f=0,g=a.length,h;f<g;f++)if(h=a[f]){while((h=h.previousSibling)&&h.nodeType!==1);a[f]=e||h&&h.nodeName.toLowerCase()===b?h||!1:h===b}e&&k.filter(b,a,!0)},">":function(a,b){var c,d=typeof b=="string",e=0,f=a.length;if(d&&!j.test(b)){b=b.toLowerCase();for(;e<f;e++){c=a[e];if(c){var g=c.parentNode;a[e]=g.nodeName.toLowerCase()===b?g:!1}}}else{for(;e<f;e++)c=a[e],c&&(a[e]=d?c.parentNode:c.parentNode===b);d&&k.filter(b,a,!0)}},"":function(a,b,c){var e,f=d++,g=u;typeof b=="string"&&!j.test(b)&&(b=b.toLowerCase(),e=b,g=t),g("parentNode",b,f,a,e,c)},"~":function(a,b,c){var e,f=d++,g=u;typeof b=="string"&&!j.test(b)&&(b=b.toLowerCase(),e=b,g=t),g("previousSibling",b,f,a,e,c)}},find:{ID:function(a,b,c){if(typeof b.getElementById!="undefined"&&!c){var d=b.getElementById(a[1]);return d&&d.parentNode?[d]:[]}},NAME:function(a,b){if(typeof b.getElementsByName!="undefined"){var c=[],d=b.getElementsByName(a[1]);for(var e=0,f=d.length;e<f;e++)d[e].getAttribute("name")===a[1]&&c.push(d[e]);return c.length===0?null:c}},TAG:function(a,b){if(typeof b.getElementsByTagName!="undefined")return b.getElementsByTagName(a[1])}},preFilter:{CLASS:function(a,b,c,d,e,f){a=" "+a[1].replace(i,"")+" ";if(f)return a;for(var g=0,h;(h=b[g])!=null;g++)h&&(e^(h.className&&(" "+h.className+" ").replace(/[\t\n\r]/g," ").indexOf(a)>=0)?c||d.push(h):c&&(b[g]=!1));return!1},ID:function(a){return a[1].replace(i,"")},TAG:function(a,b){return a[1].replace(i,"").toLowerCase()},CHILD:function(a){if(a[1]==="nth"){a[2]||k.error(a[0]),a[2]=a[2].replace(/^\+|\s*/g,"");var b=/(-?)(\d*)(?:n([+\-]?\d*))?/.exec(a[2]==="even"&&"2n"||a[2]==="odd"&&"2n+1"||!/\D/.test(a[2])&&"0n+"+a[2]||a[2]);a[2]=b[1]+(b[2]||1)-0,a[3]=b[3]-0}else a[2]&&k.error(a[0]);a[0]=d++;return a},ATTR:function(a,b,c,d,e,f){var g=a[1]=a[1].replace(i,"");!f&&l.attrMap[g]&&(a[1]=l.attrMap[g]),a[4]=(a[4]||a[5]||"").replace(i,""),a[2]==="~="&&(a[4]=" "+a[4]+" ");return a},PSEUDO:function(b,c,d,e,f){if(b[1]==="not")if((a.exec(b[3])||"").length>1||/^\w/.test(b[3]))b[3]=k(b[3],null,null,c);else{var g=k.filter(b[3],c,d,!0^f);d||e.push.apply(e,g);return!1}else if(l.match.POS.test(b[0])||l.match.CHILD.test(b[0]))return!0;return b},POS:function(a){a.unshift(!0);return a}},filters:{enabled:function(a){return a.disabled===!1&&a.type!=="hidden"},disabled:function(a){return a.disabled===!0},checked:function(a){return a.checked===!0},selected:function(a){a.parentNode&&a.parentNode.selectedIndex;return a.selected===!0},parent:function(a){return!!a.firstChild},empty:function(a){return!a.firstChild},has:function(a,b,c){return!!k(c[3],a).length},header:function(a){return/h\d/i.test(a.nodeName)},text:function(a){var b=a.getAttribute("type"),c=a.type;return a.nodeName.toLowerCase()==="input"&&"text"===c&&(b===c||b===null)},radio:function(a){return a.nodeName.toLowerCase()==="input"&&"radio"===a.type},checkbox:function(a){return a.nodeName.toLowerCase()==="input"&&"checkbox"===a.type},file:function(a){return a.nodeName.toLowerCase()==="input"&&"file"===a.type},password:function(a){return a.nodeName.toLowerCase()==="input"&&"password"===a.type},submit:function(a){var b=a.nodeName.toLowerCase();return(b==="input"||b==="button")&&"submit"===a.type},image:function(a){return a.nodeName.toLowerCase()==="input"&&"image"===a.type},reset:function(a){var b=a.nodeName.toLowerCase();return(b==="input"||b==="button")&&"reset"===a.type},button:function(a){var b=a.nodeName.toLowerCase();return b==="input"&&"button"===a.type||b==="button"},input:function(a){return/input|select|textarea|button/i.test(a.nodeName)},focus:function(a){return a===a.ownerDocument.activeElement}},setFilters:{first:function(a,b){return b===0},last:function(a,b,c,d){return b===d.length-1},even:function(a,b){return b%2===0},odd:function(a,b){return b%2===1},lt:function(a,b,c){return b<c[3]-0},gt:function(a,b,c){return b>c[3]-0},nth:function(a,b,c){return c[3]-0===b},eq:function(a,b,c){return c[3]-0===b}},filter:{PSEUDO:function(a,b,c,d){var e=b[1],f=l.filters[e];if(f)return f(a,c,b,d);if(e==="contains")return(a.textContent||a.innerText||k.getText([a])||"").indexOf(b[3])>=0;if(e==="not"){var g=b[3];for(var h=0,i=g.length;h<i;h++)if(g[h]===a)return!1;return!0}k.error(e)},CHILD:function(a,b){var c=b[1],d=a;switch(c){case"only":case"first":while(d=d.previousSibling)if(d.nodeType===1)return!1;if(c==="first")return!0;d=a;case"last":while(d=d.nextSibling)if(d.nodeType===1)return!1;return!0;case"nth":var e=b[2],f=b[3];if(e===1&&f===0)return!0;var g=b[0],h=a.parentNode;if(h&&(h.sizcache!==g||!a.nodeIndex)){var i=0;for(d=h.firstChild;d;d=d.nextSibling)d.nodeType===1&&(d.nodeIndex=++i);h.sizcache=g}var j=a.nodeIndex-f;return e===0?j===0:j%e===0&&j/e>=0}},ID:function(a,b){return a.nodeType===1&&a.getAttribute("id")===b},TAG:function(a,b){return b==="*"&&a.nodeType===1||a.nodeName.toLowerCase()===b},CLASS:function(a,b){return(" "+(a.className||a.getAttribute("class"))+" ").indexOf(b)>-1},ATTR:function(a,b){var c=b[1],d=l.attrHandle[c]?l.attrHandle[c](a):a[c]!=null?a[c]:a.getAttribute(c),e=d+"",f=b[2],g=b[4];return d==null?f==="!=":f==="="?e===g:f==="*="?e.indexOf(g)>=0:f==="~="?(" "+e+" ").indexOf(g)>=0:g?f==="!="?e!==g:f==="^="?e.indexOf(g)===0:f==="$="?e.substr(e.length-g.length)===g:f==="|="?e===g||e.substr(0,g.length+1)===g+"-":!1:e&&d!==!1},POS:function(a,b,c,d){var e=b[2],f=l.setFilters[e];if(f)return f(a,c,b,d)}}},m=l.match.POS,n=function(a,b){return"\\"+(b-0+1)};for(var o in l.match)l.match[o]=new RegExp(l.match[o].source+/(?![^\[]*\])(?![^\(]*\))/.source),l.leftMatch[o]=new RegExp(/(^(?:.|\r|\n)*?)/.source+l.match[o].source.replace(/\\(\d+)/g,n));var p=function(a,b){a=Array.prototype.slice.call(a,0);if(b){b.push.apply(b,a);return b}return a};try{Array.prototype.slice.call(c.documentElement.childNodes,0)[0].nodeType}catch(q){p=function(a,b){var c=0,d=b||[];if(e.call(a)==="[object Array]")Array.prototype.push.apply(d,a);else if(typeof a.length=="number")for(var f=a.length;c<f;c++)d.push(a[c]);else for(;a[c];c++)d.push(a[c]);return d}}var r,s;c.documentElement.compareDocumentPosition?r=function(a,b){if(a===b){g=!0;return 0}if(!a.compareDocumentPosition||!b.compareDocumentPosition)return a.compareDocumentPosition?-1:1;return a.compareDocumentPosition(b)&4?-1:1}:(r=function(a,b){if(a===b){g=!0;return 0}if(a.sourceIndex&&b.sourceIndex)return a.sourceIndex-b.sourceIndex;var c,d,e=[],f=[],h=a.parentNode,i=b.parentNode,j=h;if(h===i)return s(a,b);if(!h)return-1;if(!i)return 1;while(j)e.unshift(j),j=j.parentNode;j=i;while(j)f.unshift(j),j=j.parentNode;c=e.length,d=f.length;for(var k=0;k<c&&k<d;k++)if(e[k]!==f[k])return s(e[k],f[k]);return k===c?s(a,f[k],-1):s(e[k],b,1)},s=function(a,b,c){if(a===b)return c;var d=a.nextSibling;while(d){if(d===b)return-1;d=d.nextSibling}return 1}),k.getText=function(a){var b="",c;for(var d=0;a[d];d++)c=a[d],c.nodeType===3||c.nodeType===4?b+=c.nodeValue:c.nodeType!==8&&(b+=k.getText(c.childNodes));return b},function(){var a=c.createElement("div"),d="script"+(new Date).getTime(),e=c.documentElement;a.innerHTML="<a name='"+d+"'/>",e.insertBefore(a,e.firstChild),c.getElementById(d)&&(l.find.ID=function(a,c,d){if(typeof c.getElementById!="undefined"&&!d){var e=c.getElementById(a[1]);return e?e.id===a[1]||typeof e.getAttributeNode!="undefined"&&e.getAttributeNode("id").nodeValue===a[1]?[e]:b:[]}},l.filter.ID=function(a,b){var c=typeof a.getAttributeNode!="undefined"&&a.getAttributeNode("id");return a.nodeType===1&&c&&c.nodeValue===b}),e.removeChild(a),e=a=null}(),function(){var a=c.createElement("div");a.appendChild(c.createComment("")),a.getElementsByTagName("*").length>0&&(l.find.TAG=function(a,b){var c=b.getElementsByTagName(a[1]);if(a[1]==="*"){var d=[];for(var e=0;c[e];e++)c[e].nodeType===1&&d.push(c[e]);c=d}return c}),a.innerHTML="<a href='#'></a>",a.firstChild&&typeof a.firstChild.getAttribute!="undefined"&&a.firstChild.getAttribute("href")!=="#"&&(l.attrHandle.href=function(a){return a.getAttribute("href",2)}),a=null}(),c.querySelectorAll&&function(){var a=k,b=c.createElement("div"),d="__sizzle__";b.innerHTML="<p class='TEST'></p>";if(!b.querySelectorAll||b.querySelectorAll(".TEST").length!==0){k=function(b,e,f,g){e=e||c;if(!g&&!k.isXML(e)){var h=/^(\w+$)|^\.([\w\-]+$)|^#([\w\-]+$)/.exec(b);if(h&&(e.nodeType===1||e.nodeType===9)){if(h[1])return p(e.getElementsByTagName(b),f);if(h[2]&&l.find.CLASS&&e.getElementsByClassName)return p(e.getElementsByClassName(h[2]),f)}if(e.nodeType===9){if(b==="body"&&e.body)return p([e.body],f);if(h&&h[3]){var i=e.getElementById(h[3]);if(!i||!i.parentNode)return p([],f);if(i.id===h[3])return p([i],f)}try{return p(e.querySelectorAll(b),f)}catch(j){}}else if(e.nodeType===1&&e.nodeName.toLowerCase()!=="object"){var m=e,n=e.getAttribute("id"),o=n||d,q=e.parentNode,r=/^\s*[+~]/.test(b);n?o=o.replace(/'/g,"\\$&"):e.setAttribute("id",o),r&&q&&(e=e.parentNode);try{if(!r||q)return p(e.querySelectorAll("[id='"+o+"'] "+b),f)}catch(s){}finally{n||m.removeAttribute("id")}}}return a(b,e,f,g)};for(var e in a)k[e]=a[e];b=null}}(),function(){var a=c.documentElement,b=a.matchesSelector||a.mozMatchesSelector||a.webkitMatchesSelector||a.msMatchesSelector;if(b){var d=!b.call(c.createElement("div"),"div"),e=!1;try{b.call(c.documentElement,"[test!='']:sizzle")}catch(f){e=!0}k.matchesSelector=function(a,c){c=c.replace(/\=\s*([^'"\]]*)\s*\]/g,"='$1']");if(!k.isXML(a))try{if(e||!l.match.PSEUDO.test(c)&&!/!=/.test(c)){var f=b.call(a,c);if(f||!d||a.document&&a.document.nodeType!==11)return f}}catch(g){}return k(c,null,null,[a]).length>0}}}(),function(){var a=c.createElement("div");a.innerHTML="<div class='test e'></div><div class='test'></div>";if(!!a.getElementsByClassName&&a.getElementsByClassName("e").length!==0){a.lastChild.className="e";if(a.getElementsByClassName("e").length===1)return;l.order.splice(1,0,"CLASS"),l.find.CLASS=function(a,b,c){if(typeof b.getElementsByClassName!="undefined"&&!c)return b.getElementsByClassName(a[1])},a=null}}(),c.documentElement.contains?k.contains=function(a,b){return a!==b&&(a.contains?a.contains(b):!0)}:c.documentElement.compareDocumentPosition?k.contains=function(a,b){return!!(a.compareDocumentPosition(b)&16)}:k.contains=function(){return!1},k.isXML=function(a){var b=(a?a.ownerDocument||a:0).documentElement;return b?b.nodeName!=="HTML":!1};var v=function(a,b){var c,d=[],e="",f=b.nodeType?[b]:b;while(c=l.match.PSEUDO.exec(a))e+=c[0],a=a.replace(l.match.PSEUDO,"");a=l.relative[a]?a+"*":a;for(var g=0,h=f.length;g<h;g++)k(a,f[g],d);return k.filter(e,d)};f.find=k,f.expr=k.selectors,f.expr[":"]=f.expr.filters,f.unique=k.uniqueSort,f.text=k.getText,f.isXMLDoc=k.isXML,f.contains=k.contains}();var O=/Until$/,P=/^(?:parents|prevUntil|prevAll)/,Q=/,/,R=/^.[^:#\[\.,]*$/,S=Array.prototype.slice,T=f.expr.match.POS,U={children:!0,contents:!0,next:!0,prev:!0};f.fn.extend({find:function(a){var b=this,c,d;if(typeof a!="string")return f(a).filter(function(){for(c=0,d=b.length;c<d;c++)if(f.contains(b[c],this))return!0});var e=this.pushStack("","find",a),g,h,i;for(c=0,d=this.length;c<d;c++){g=e.length,f.find(a,this[c],e);if(c>0)for(h=g;h<e.length;h++)for(i=0;i<g;i++)if(e[i]===e[h]){e.splice(h--,1);break}}return e},has:function(a){var b=f(a);return this.filter(function(){for(var a=0,c=b.length;a<c;a++)if(f.contains(this,b[a]))return!0})},not:function(a){return this.pushStack(W(this,a,!1),"not",a)},filter:function(a){return this.pushStack(W(this,a,!0),"filter",a)},is:function(a){return!!a&&(typeof a=="string"?f.filter(a,this).length>0:this.filter(a).length>0)},closest:function(a,b){var c=[],d,e,g=this[0];if(f.isArray(a)){var h,i,j={},k=1;if(g&&a.length){for(d=0,e=a.length;d<e;d++)i=a[d],j[i]||(j[i]=T.test(i)?f(i,b||this.context):i);while(g&&g.ownerDocument&&g!==b){for(i in j)h=j[i],(h.jquery?h.index(g)>-1:f(g).is(h))&&c.push({selector:i,elem:g,level:k});g=g.parentNode,k++}}return c}var l=T.test(a)||typeof a!="string"?f(a,b||this.context):0;for(d=0,e=this.length;d<e;d++){g=this[d];while(g){if(l?l.index(g)>-1:f.find.matchesSelector(g,a)){c.push(g);break}g=g.parentNode;if(!g||!g.ownerDocument||g===b||g.nodeType===11)break}}c=c.length>1?f.unique(c):c;return this.pushStack(c,"closest",a)},index:function(a){if(!a||typeof a=="string")return f.inArray(this[0],a?f(a):this.parent().children());return f.inArray(a.jquery?a[0]:a,this)},add:function(a,b){var c=typeof a=="string"?f(a,b):f.makeArray(a&&a.nodeType?[a]:a),d=f.merge(this.get(),c);return this.pushStack(V(c[0])||V(d[0])?d:f.unique(d))},andSelf:function(){return this.add(this.prevObject)}}),f.each({parent:function(a){var b=a.parentNode;return b&&b.nodeType!==11?b:null},parents:function(a){return f.dir(a,"parentNode")},parentsUntil:function(a,b,c){return f.dir(a,"parentNode",c)},next:function(a){return f.nth(a,2,"nextSibling")},prev:function(a){return f.nth(a,2,"previousSibling")},nextAll:function(a){return f.dir(a,"nextSibling")},prevAll:function(a){return f.dir(a,"previousSibling")},nextUntil:function(a,b,c){return f.dir(a,"nextSibling",c)},prevUntil:function(a,b,c){return f.dir(a,"previousSibling",c)},siblings:function(a){return f.sibling(a.parentNode.firstChild,a)},children:function(a){return f.sibling(a.firstChild)},contents:function(a){return f.nodeName(a,"iframe")?a.contentDocument||a.contentWindow.document:f.makeArray(a.childNodes)}},function(a,b){f.fn[a]=function(c,d){var e=f.map(this,b,c),g=S.call(arguments);O.test(a)||(d=c),d&&typeof d=="string"&&(e=f.filter(d,e)),e=this.length>1&&!U[a]?f.unique(e):e,(this.length>1||Q.test(d))&&P.test(a)&&(e=e.reverse());return this.pushStack(e,a,g.join(","))}}),f.extend({filter:function(a,b,c){c&&(a=":not("+a+")");return b.length===1?f.find.matchesSelector(b[0],a)?[b[0]]:[]:f.find.matches(a,b)},dir:function(a,c,d){var e=[],g=a[c];while(g&&g.nodeType!==9&&(d===b||g.nodeType!==1||!f(g).is(d)))g.nodeType===1&&e.push(g),g=g[c];return e},nth:function(a,b,c,d){b=b||1;var e=0;for(;a;a=a[c])if(a.nodeType===1&&++e===b)break;return a},sibling:function(a,b){var c=[];for(;a;a=a.nextSibling)a.nodeType===1&&a!==b&&c.push(a);return c}});var X=/ jQuery\d+="(?:\d+|null)"/g,Y=/^\s+/,Z=/<(?!area|br|col|embed|hr|img|input|link|meta|param)(([\w:]+)[^>]*)\/>/ig,$=/<([\w:]+)/,_=/<tbody/i,ba=/<|&#?\w+;/,bb=/<(?:script|object|embed|option|style)/i,bc=/checked\s*(?:[^=]|=\s*.checked.)/i,bd=/\/(java|ecma)script/i,be=/^\s*<!(?:\[CDATA\[|\-\-)/,bf={option:[1,"<select multiple='multiple'>","</select>"],legend:[1,"<fieldset>","</fieldset>"],thead:[1,"<table>","</table>"],tr:[2,"<table><tbody>","</tbody></table>"],td:[3,"<table><tbody><tr>","</tr></tbody></table>"],col:[2,"<table><tbody></tbody><colgroup>","</colgroup></table>"],area:[1,"<map>","</map>"],_default:[0,"",""]};bf.optgroup=bf.option,bf.tbody=bf.tfoot=bf.colgroup=bf.caption=bf.thead,bf.th=bf.td,f.support.htmlSerialize||(bf._default=[1,"div<div>","</div>"]),f.fn.extend({text:function(a){if(f.isFunction(a))return this.each(function(b){var c=f(this);c.text(a.call(this,b,c.text()))});if(typeof a!="object"&&a!==b)return this.empty().append((this[0]&&this[0].ownerDocument||c).createTextNode(a));return f.text(this)},wrapAll:function(a){if(f.isFunction(a))return this.each(function(b){f(this).wrapAll(a.call(this,b))});if(this[0]){var b=f(a,this[0].ownerDocument).eq(0).clone(!0);this[0].parentNode&&b.insertBefore(this[0]),b.map(function(){var a=this;while(a.firstChild&&a.firstChild.nodeType===1)a=a.firstChild;return a}).append(this)}return this},wrapInner:function(a){if(f.isFunction(a))return this.each(function(b){f(this).wrapInner(a.call(this,b))});return this.each(function(){var b=f(this),c=b.contents();c.length?c.wrapAll(a):b.append(a)})},wrap:function(a){return this.each(function(){f(this).wrapAll(a)})},unwrap:function(){return this.parent().each(function(){f.nodeName(this,"body")||f(this).replaceWith(this.childNodes)}).end()},append:function(){return this.domManip(arguments,!0,function(a){this.nodeType===1&&this.appendChild(a)})},prepend:function(){return this.domManip(arguments,!0,function(a){this.nodeType===1&&this.insertBefore(a,this.firstChild)})},before:function(){if(this[0]&&this[0].parentNode)return this.domManip(arguments,!1,function(a){this.parentNode.insertBefore(a,this)});if(arguments.length){var a=f(arguments[0]);a.push.apply(a,this.toArray());return this.pushStack(a,"before",arguments)}},after:function(){if(this[0]&&this[0].parentNode)return this.domManip(arguments,!1,function(a){this.parentNode.insertBefore(a,this.nextSibling)});if(arguments.length){var a=this.pushStack(this,"after",arguments);a.push.apply(a,f(arguments[0]).toArray());return a}},remove:function(a,b){for(var c=0,d;(d=this[c])!=null;c++)if(!a||f.filter(a,[d]).length)!b&&d.nodeType===1&&(f.cleanData(d.getElementsByTagName("*")),f.cleanData([d])),d.parentNode&&d.parentNode.removeChild(d);return this},empty:function(){for(var a=0,b;(b=this[a])!=null;a++){b.nodeType===1&&f.cleanData(b.getElementsByTagName("*"));while(b.firstChild)b.removeChild(b.firstChild)}return this},clone:function(a,b){a=a==null?!1:a,b=b==null?a:b;return this.map(function(){return f.clone(this,a,b)})},html:function(a){if(a===b)return this[0]&&this[0].nodeType===1?this[0].innerHTML.replace(X,""):null;if(typeof a=="string"&&!bb.test(a)&&(f.support.leadingWhitespace||!Y.test(a))&&!bf[($.exec(a)||["",""])[1].toLowerCase()]){a=a.replace(Z,"<$1></$2>");try{for(var c=0,d=this.length;c<d;c++)this[c].nodeType===1&&(f.cleanData(this[c].getElementsByTagName("*")),this[c].innerHTML=a)}catch(e){this.empty().append(a)}}else f.isFunction(a)?this.each(function(b){var c=f(this);c.html(a.call(this,b,c.html()))}):this.empty().append(a);return this},replaceWith:function(a){if(this[0]&&this[0].parentNode){if(f.isFunction(a))return this.each(function(b){var c=f(this),d=c.html();c.replaceWith(a.call(this,b,d))});typeof a!="string"&&(a=f(a).detach());return this.each(function(){var b=this.nextSibling,c=this.parentNode;f(this).remove(),b?f(b).before(a):f(c).append(a)})}return this.length?this.pushStack(f(f.isFunction(a)?a():a),"replaceWith",a):this},detach:function(a){return this.remove(a,!0)},domManip:function(a,c,d){var e,g,h,i,j=a[0],k=[];if(!f.support.checkClone&&arguments.length===3&&typeof j=="string"&&bc.test(j))return this.each(function(){f(this).domManip(a,c,d,!0)});if(f.isFunction(j))return this.each(function(e){var g=f(this);a[0]=j.call(this,e,c?g.html():b),g.domManip(a,c,d)});if(this[0]){i=j&&j.parentNode,f.support.parentNode&&i&&i.nodeType===11&&i.childNodes.length===this.length?e={fragment:i}:e=f.buildFragment(a,this,k),h=e.fragment,h.childNodes.length===1?g=h=h.firstChild:g=h.firstChild;if(g){c=c&&f.nodeName(g,"tr");for(var l=0,m=this.length,n=m-1;l<m;l++)d.call(c?bg(this[l],g):this[l],e.cacheable||m>1&&l<n?f.clone(h,!0,!0):h)}k.length&&f.each(k,bm)}return this}}),f.buildFragment=function(a,b,d){var e,g,h,i;b&&b[0]&&(i=b[0].ownerDocument||b[0]),i.createDocumentFragment||(i=c),a.length===1&&typeof a[0]=="string"&&a[0].length<512&&i===c&&a[0].charAt(0)==="<"&&!bb.test(a[0])&&(f.support.checkClone||!bc.test(a[0]))&&(g=!0,h=f.fragments[a[0]],h&&h!==1&&(e=h)),e||(e=i.createDocumentFragment(),f.clean(a,i,e,d)),g&&(f.fragments[a[0]]=h?e:1);return{fragment:e,cacheable:g}},f.fragments={},f.each({appendTo:"append",prependTo:"prepend",insertBefore:"before",insertAfter:"after",replaceAll:"replaceWith"},function(a,b){f.fn[a]=function(c){var d=[],e=f(c),g=this.length===1&&this[0].parentNode;if(g&&g.nodeType===11&&g.childNodes.length===1&&e.length===1){e[b](this[0]);return this}for(var h=0,i=e.length;h<i;h++){var j=(h>0?this.clone(!0):this).get();f(e[h])[b](j),d=d.concat(j
)}return this.pushStack(d,a,e.selector)}}),f.extend({clone:function(a,b,c){var d=a.cloneNode(!0),e,g,h;if((!f.support.noCloneEvent||!f.support.noCloneChecked)&&(a.nodeType===1||a.nodeType===11)&&!f.isXMLDoc(a)){bi(a,d),e=bj(a),g=bj(d);for(h=0;e[h];++h)bi(e[h],g[h])}if(b){bh(a,d);if(c){e=bj(a),g=bj(d);for(h=0;e[h];++h)bh(e[h],g[h])}}e=g=null;return d},clean:function(a,b,d,e){var g;b=b||c,typeof b.createElement=="undefined"&&(b=b.ownerDocument||b[0]&&b[0].ownerDocument||c);var h=[],i;for(var j=0,k;(k=a[j])!=null;j++){typeof k=="number"&&(k+="");if(!k)continue;if(typeof k=="string")if(!ba.test(k))k=b.createTextNode(k);else{k=k.replace(Z,"<$1></$2>");var l=($.exec(k)||["",""])[1].toLowerCase(),m=bf[l]||bf._default,n=m[0],o=b.createElement("div");o.innerHTML=m[1]+k+m[2];while(n--)o=o.lastChild;if(!f.support.tbody){var p=_.test(k),q=l==="table"&&!p?o.firstChild&&o.firstChild.childNodes:m[1]==="<table>"&&!p?o.childNodes:[];for(i=q.length-1;i>=0;--i)f.nodeName(q[i],"tbody")&&!q[i].childNodes.length&&q[i].parentNode.removeChild(q[i])}!f.support.leadingWhitespace&&Y.test(k)&&o.insertBefore(b.createTextNode(Y.exec(k)[0]),o.firstChild),k=o.childNodes}var r;if(!f.support.appendChecked)if(k[0]&&typeof (r=k.length)=="number")for(i=0;i<r;i++)bl(k[i]);else bl(k);k.nodeType?h.push(k):h=f.merge(h,k)}if(d){g=function(a){return!a.type||bd.test(a.type)};for(j=0;h[j];j++)if(e&&f.nodeName(h[j],"script")&&(!h[j].type||h[j].type.toLowerCase()==="text/javascript"))e.push(h[j].parentNode?h[j].parentNode.removeChild(h[j]):h[j]);else{if(h[j].nodeType===1){var s=f.grep(h[j].getElementsByTagName("script"),g);h.splice.apply(h,[j+1,0].concat(s))}d.appendChild(h[j])}}return h},cleanData:function(a){var b,c,d=f.cache,e=f.expando,g=f.event.special,h=f.support.deleteExpando;for(var i=0,j;(j=a[i])!=null;i++){if(j.nodeName&&f.noData[j.nodeName.toLowerCase()])continue;c=j[f.expando];if(c){b=d[c]&&d[c][e];if(b&&b.events){for(var k in b.events)g[k]?f.event.remove(j,k):f.removeEvent(j,k,b.handle);b.handle&&(b.handle.elem=null)}h?delete j[f.expando]:j.removeAttribute&&j.removeAttribute(f.expando),delete d[c]}}}});var bn=/alpha\([^)]*\)/i,bo=/opacity=([^)]*)/,bp=/([A-Z]|^ms)/g,bq=/^-?\d+(?:px)?$/i,br=/^-?\d/,bs=/^[+\-]=/,bt=/[^+\-\.\de]+/g,bu={position:"absolute",visibility:"hidden",display:"block"},bv=["Left","Right"],bw=["Top","Bottom"],bx,by,bz;f.fn.css=function(a,c){if(arguments.length===2&&c===b)return this;return f.access(this,a,c,!0,function(a,c,d){return d!==b?f.style(a,c,d):f.css(a,c)})},f.extend({cssHooks:{opacity:{get:function(a,b){if(b){var c=bx(a,"opacity","opacity");return c===""?"1":c}return a.style.opacity}}},cssNumber:{fillOpacity:!0,fontWeight:!0,lineHeight:!0,opacity:!0,orphans:!0,widows:!0,zIndex:!0,zoom:!0},cssProps:{"float":f.support.cssFloat?"cssFloat":"styleFloat"},style:function(a,c,d,e){if(!!a&&a.nodeType!==3&&a.nodeType!==8&&!!a.style){var g,h,i=f.camelCase(c),j=a.style,k=f.cssHooks[i];c=f.cssProps[i]||i;if(d===b){if(k&&"get"in k&&(g=k.get(a,!1,e))!==b)return g;return j[c]}h=typeof d;if(h==="number"&&isNaN(d)||d==null)return;h==="string"&&bs.test(d)&&(d=+d.replace(bt,"")+parseFloat(f.css(a,c)),h="number"),h==="number"&&!f.cssNumber[i]&&(d+="px");if(!k||!("set"in k)||(d=k.set(a,d))!==b)try{j[c]=d}catch(l){}}},css:function(a,c,d){var e,g;c=f.camelCase(c),g=f.cssHooks[c],c=f.cssProps[c]||c,c==="cssFloat"&&(c="float");if(g&&"get"in g&&(e=g.get(a,!0,d))!==b)return e;if(bx)return bx(a,c)},swap:function(a,b,c){var d={};for(var e in b)d[e]=a.style[e],a.style[e]=b[e];c.call(a);for(e in b)a.style[e]=d[e]}}),f.curCSS=f.css,f.each(["height","width"],function(a,b){f.cssHooks[b]={get:function(a,c,d){var e;if(c){if(a.offsetWidth!==0)return bA(a,b,d);f.swap(a,bu,function(){e=bA(a,b,d)});return e}},set:function(a,b){if(!bq.test(b))return b;b=parseFloat(b);if(b>=0)return b+"px"}}}),f.support.opacity||(f.cssHooks.opacity={get:function(a,b){return bo.test((b&&a.currentStyle?a.currentStyle.filter:a.style.filter)||"")?parseFloat(RegExp.$1)/100+"":b?"1":""},set:function(a,b){var c=a.style,d=a.currentStyle;c.zoom=1;var e=f.isNaN(b)?"":"alpha(opacity="+b*100+")",g=d&&d.filter||c.filter||"";c.filter=bn.test(g)?g.replace(bn,e):g+" "+e}}),f(function(){f.support.reliableMarginRight||(f.cssHooks.marginRight={get:function(a,b){var c;f.swap(a,{display:"inline-block"},function(){b?c=bx(a,"margin-right","marginRight"):c=a.style.marginRight});return c}})}),c.defaultView&&c.defaultView.getComputedStyle&&(by=function(a,c){var d,e,g;c=c.replace(bp,"-$1").toLowerCase();if(!(e=a.ownerDocument.defaultView))return b;if(g=e.getComputedStyle(a,null))d=g.getPropertyValue(c),d===""&&!f.contains(a.ownerDocument.documentElement,a)&&(d=f.style(a,c));return d}),c.documentElement.currentStyle&&(bz=function(a,b){var c,d=a.currentStyle&&a.currentStyle[b],e=a.runtimeStyle&&a.runtimeStyle[b],f=a.style;!bq.test(d)&&br.test(d)&&(c=f.left,e&&(a.runtimeStyle.left=a.currentStyle.left),f.left=b==="fontSize"?"1em":d||0,d=f.pixelLeft+"px",f.left=c,e&&(a.runtimeStyle.left=e));return d===""?"auto":d}),bx=by||bz,f.expr&&f.expr.filters&&(f.expr.filters.hidden=function(a){var b=a.offsetWidth,c=a.offsetHeight;return b===0&&c===0||!f.support.reliableHiddenOffsets&&(a.style.display||f.css(a,"display"))==="none"},f.expr.filters.visible=function(a){return!f.expr.filters.hidden(a)});var bB=/%20/g,bC=/\[\]$/,bD=/\r?\n/g,bE=/#.*$/,bF=/^(.*?):[ \t]*([^\r\n]*)\r?$/mg,bG=/^(?:color|date|datetime|email|hidden|month|number|password|range|search|tel|text|time|url|week)$/i,bH=/^(?:about|app|app\-storage|.+\-extension|file|widget):$/,bI=/^(?:GET|HEAD)$/,bJ=/^\/\//,bK=/\?/,bL=/<script\b[^<]*(?:(?!<\/script>)<[^<]*)*<\/script>/gi,bM=/^(?:select|textarea)/i,bN=/\s+/,bO=/([?&])_=[^&]*/,bP=/^([\w\+\.\-]+:)(?:\/\/([^\/?#:]*)(?::(\d+))?)?/,bQ=f.fn.load,bR={},bS={},bT,bU;try{bT=e.href}catch(bV){bT=c.createElement("a"),bT.href="",bT=bT.href}bU=bP.exec(bT.toLowerCase())||[],f.fn.extend({load:function(a,c,d){if(typeof a!="string"&&bQ)return bQ.apply(this,arguments);if(!this.length)return this;var e=a.indexOf(" ");if(e>=0){var g=a.slice(e,a.length);a=a.slice(0,e)}var h="GET";c&&(f.isFunction(c)?(d=c,c=b):typeof c=="object"&&(c=f.param(c,f.ajaxSettings.traditional),h="POST"));var i=this;f.ajax({url:a,type:h,dataType:"html",data:c,complete:function(a,b,c){c=a.responseText,a.isResolved()&&(a.done(function(a){c=a}),i.html(g?f("<div>").append(c.replace(bL,"")).find(g):c)),d&&i.each(d,[c,b,a])}});return this},serialize:function(){return f.param(this.serializeArray())},serializeArray:function(){return this.map(function(){return this.elements?f.makeArray(this.elements):this}).filter(function(){return this.name&&!this.disabled&&(this.checked||bM.test(this.nodeName)||bG.test(this.type))}).map(function(a,b){var c=f(this).val();return c==null?null:f.isArray(c)?f.map(c,function(a,c){return{name:b.name,value:a.replace(bD,"\r\n")}}):{name:b.name,value:c.replace(bD,"\r\n")}}).get()}}),f.each("ajaxStart ajaxStop ajaxComplete ajaxError ajaxSuccess ajaxSend".split(" "),function(a,b){f.fn[b]=function(a){return this.bind(b,a)}}),f.each(["get","post"],function(a,c){f[c]=function(a,d,e,g){f.isFunction(d)&&(g=g||e,e=d,d=b);return f.ajax({type:c,url:a,data:d,success:e,dataType:g})}}),f.extend({getScript:function(a,c){return f.get(a,b,c,"script")},getJSON:function(a,b,c){return f.get(a,b,c,"json")},ajaxSetup:function(a,b){b?f.extend(!0,a,f.ajaxSettings,b):(b=a,a=f.extend(!0,f.ajaxSettings,b));for(var c in{context:1,url:1})c in b?a[c]=b[c]:c in f.ajaxSettings&&(a[c]=f.ajaxSettings[c]);return a},ajaxSettings:{url:bT,isLocal:bH.test(bU[1]),global:!0,type:"GET",contentType:"application/x-www-form-urlencoded",processData:!0,async:!0,accepts:{xml:"application/xml, text/xml",html:"text/html",text:"text/plain",json:"application/json, text/javascript","*":"*/*"},contents:{xml:/xml/,html:/html/,json:/json/},responseFields:{xml:"responseXML",text:"responseText"},converters:{"* text":a.String,"text html":!0,"text json":f.parseJSON,"text xml":f.parseXML}},ajaxPrefilter:bW(bR),ajaxTransport:bW(bS),ajax:function(a,c){function w(a,c,l,m){if(s!==2){s=2,q&&clearTimeout(q),p=b,n=m||"",v.readyState=a?4:0;var o,r,u,w=l?bZ(d,v,l):b,x,y;if(a>=200&&a<300||a===304){if(d.ifModified){if(x=v.getResponseHeader("Last-Modified"))f.lastModified[k]=x;if(y=v.getResponseHeader("Etag"))f.etag[k]=y}if(a===304)c="notmodified",o=!0;else try{r=b$(d,w),c="success",o=!0}catch(z){c="parsererror",u=z}}else{u=c;if(!c||a)c="error",a<0&&(a=0)}v.status=a,v.statusText=c,o?h.resolveWith(e,[r,c,v]):h.rejectWith(e,[v,c,u]),v.statusCode(j),j=b,t&&g.trigger("ajax"+(o?"Success":"Error"),[v,d,o?r:u]),i.resolveWith(e,[v,c]),t&&(g.trigger("ajaxComplete",[v,d]),--f.active||f.event.trigger("ajaxStop"))}}typeof a=="object"&&(c=a,a=b),c=c||{};var d=f.ajaxSetup({},c),e=d.context||d,g=e!==d&&(e.nodeType||e instanceof f)?f(e):f.event,h=f.Deferred(),i=f._Deferred(),j=d.statusCode||{},k,l={},m={},n,o,p,q,r,s=0,t,u,v={readyState:0,setRequestHeader:function(a,b){if(!s){var c=a.toLowerCase();a=m[c]=m[c]||a,l[a]=b}return this},getAllResponseHeaders:function(){return s===2?n:null},getResponseHeader:function(a){var c;if(s===2){if(!o){o={};while(c=bF.exec(n))o[c[1].toLowerCase()]=c[2]}c=o[a.toLowerCase()]}return c===b?null:c},overrideMimeType:function(a){s||(d.mimeType=a);return this},abort:function(a){a=a||"abort",p&&p.abort(a),w(0,a);return this}};h.promise(v),v.success=v.done,v.error=v.fail,v.complete=i.done,v.statusCode=function(a){if(a){var b;if(s<2)for(b in a)j[b]=[j[b],a[b]];else b=a[v.status],v.then(b,b)}return this},d.url=((a||d.url)+"").replace(bE,"").replace(bJ,bU[1]+"//"),d.dataTypes=f.trim(d.dataType||"*").toLowerCase().split(bN),d.crossDomain==null&&(r=bP.exec(d.url.toLowerCase()),d.crossDomain=!(!r||r[1]==bU[1]&&r[2]==bU[2]&&(r[3]||(r[1]==="http:"?80:443))==(bU[3]||(bU[1]==="http:"?80:443)))),d.data&&d.processData&&typeof d.data!="string"&&(d.data=f.param(d.data,d.traditional)),bX(bR,d,c,v);if(s===2)return!1;t=d.global,d.type=d.type.toUpperCase(),d.hasContent=!bI.test(d.type),t&&f.active++===0&&f.event.trigger("ajaxStart");if(!d.hasContent){d.data&&(d.url+=(bK.test(d.url)?"&":"?")+d.data),k=d.url;if(d.cache===!1){var x=f.now(),y=d.url.replace(bO,"$1_="+x);d.url=y+(y===d.url?(bK.test(d.url)?"&":"?")+"_="+x:"")}}(d.data&&d.hasContent&&d.contentType!==!1||c.contentType)&&v.setRequestHeader("Content-Type",d.contentType),d.ifModified&&(k=k||d.url,f.lastModified[k]&&v.setRequestHeader("If-Modified-Since",f.lastModified[k]),f.etag[k]&&v.setRequestHeader("If-None-Match",f.etag[k])),v.setRequestHeader("Accept",d.dataTypes[0]&&d.accepts[d.dataTypes[0]]?d.accepts[d.dataTypes[0]]+(d.dataTypes[0]!=="*"?", */*; q=0.01":""):d.accepts["*"]);for(u in d.headers)v.setRequestHeader(u,d.headers[u]);if(d.beforeSend&&(d.beforeSend.call(e,v,d)===!1||s===2)){v.abort();return!1}for(u in{success:1,error:1,complete:1})v[u](d[u]);p=bX(bS,d,c,v);if(!p)w(-1,"No Transport");else{v.readyState=1,t&&g.trigger("ajaxSend",[v,d]),d.async&&d.timeout>0&&(q=setTimeout(function(){v.abort("timeout")},d.timeout));try{s=1,p.send(l,w)}catch(z){status<2?w(-1,z):f.error(z)}}return v},param:function(a,c){var d=[],e=function(a,b){b=f.isFunction(b)?b():b,d[d.length]=encodeURIComponent(a)+"="+encodeURIComponent(b)};c===b&&(c=f.ajaxSettings.traditional);if(f.isArray(a)||a.jquery&&!f.isPlainObject(a))f.each(a,function(){e(this.name,this.value)});else for(var g in a)bY(g,a[g],c,e);return d.join("&").replace(bB,"+")}}),f.extend({active:0,lastModified:{},etag:{}});var b_=f.now(),ca=/(\=)\?(&|$)|\?\?/i;f.ajaxSetup({jsonp:"callback",jsonpCallback:function(){return f.expando+"_"+b_++}}),f.ajaxPrefilter("json jsonp",function(b,c,d){var e=b.contentType==="application/x-www-form-urlencoded"&&typeof b.data=="string";if(b.dataTypes[0]==="jsonp"||b.jsonp!==!1&&(ca.test(b.url)||e&&ca.test(b.data))){var g,h=b.jsonpCallback=f.isFunction(b.jsonpCallback)?b.jsonpCallback():b.jsonpCallback,i=a[h],j=b.url,k=b.data,l="$1"+h+"$2";b.jsonp!==!1&&(j=j.replace(ca,l),b.url===j&&(e&&(k=k.replace(ca,l)),b.data===k&&(j+=(/\?/.test(j)?"&":"?")+b.jsonp+"="+h))),b.url=j,b.data=k,a[h]=function(a){g=[a]},d.always(function(){a[h]=i,g&&f.isFunction(i)&&a[h](g[0])}),b.converters["script json"]=function(){g||f.error(h+" was not called");return g[0]},b.dataTypes[0]="json";return"script"}}),f.ajaxSetup({accepts:{script:"text/javascript, application/javascript, application/ecmascript, application/x-ecmascript"},contents:{script:/javascript|ecmascript/},converters:{"text script":function(a){f.globalEval(a);return a}}}),f.ajaxPrefilter("script",function(a){a.cache===b&&(a.cache=!1),a.crossDomain&&(a.type="GET",a.global=!1)}),f.ajaxTransport("script",function(a){if(a.crossDomain){var d,e=c.head||c.getElementsByTagName("head")[0]||c.documentElement;return{send:function(f,g){d=c.createElement("script"),d.async="async",a.scriptCharset&&(d.charset=a.scriptCharset),d.src=a.url,d.onload=d.onreadystatechange=function(a,c){if(c||!d.readyState||/loaded|complete/.test(d.readyState))d.onload=d.onreadystatechange=null,e&&d.parentNode&&e.removeChild(d),d=b,c||g(200,"success")},e.insertBefore(d,e.firstChild)},abort:function(){d&&d.onload(0,1)}}}});var cb=a.ActiveXObject?function(){for(var a in cd)cd[a](0,1)}:!1,cc=0,cd;f.ajaxSettings.xhr=a.ActiveXObject?function(){return!this.isLocal&&ce()||cf()}:ce,function(a){f.extend(f.support,{ajax:!!a,cors:!!a&&"withCredentials"in a})}(f.ajaxSettings.xhr()),f.support.ajax&&f.ajaxTransport(function(c){if(!c.crossDomain||f.support.cors){var d;return{send:function(e,g){var h=c.xhr(),i,j;c.username?h.open(c.type,c.url,c.async,c.username,c.password):h.open(c.type,c.url,c.async);if(c.xhrFields)for(j in c.xhrFields)h[j]=c.xhrFields[j];c.mimeType&&h.overrideMimeType&&h.overrideMimeType(c.mimeType),!c.crossDomain&&!e["X-Requested-With"]&&(e["X-Requested-With"]="XMLHttpRequest");try{for(j in e)h.setRequestHeader(j,e[j])}catch(k){}h.send(c.hasContent&&c.data||null),d=function(a,e){var j,k,l,m,n;try{if(d&&(e||h.readyState===4)){d=b,i&&(h.onreadystatechange=f.noop,cb&&delete cd[i]);if(e)h.readyState!==4&&h.abort();else{j=h.status,l=h.getAllResponseHeaders(),m={},n=h.responseXML,n&&n.documentElement&&(m.xml=n),m.text=h.responseText;try{k=h.statusText}catch(o){k=""}!j&&c.isLocal&&!c.crossDomain?j=m.text?200:404:j===1223&&(j=204)}}}catch(p){e||g(-1,p)}m&&g(j,k,m,l)},!c.async||h.readyState===4?d():(i=++cc,cb&&(cd||(cd={},f(a).unload(cb)),cd[i]=d),h.onreadystatechange=d)},abort:function(){d&&d(0,1)}}}});var cg={},ch,ci,cj=/^(?:toggle|show|hide)$/,ck=/^([+\-]=)?([\d+.\-]+)([a-z%]*)$/i,cl,cm=[["height","marginTop","marginBottom","paddingTop","paddingBottom"],["width","marginLeft","marginRight","paddingLeft","paddingRight"],["opacity"]],cn,co=a.webkitRequestAnimationFrame||a.mozRequestAnimationFrame||a.oRequestAnimationFrame;f.fn.extend({show:function(a,b,c){var d,e;if(a||a===0)return this.animate(cr("show",3),a,b,c);for(var g=0,h=this.length;g<h;g++)d=this[g],d.style&&(e=d.style.display,!f._data(d,"olddisplay")&&e==="none"&&(e=d.style.display=""),e===""&&f.css(d,"display")==="none"&&f._data(d,"olddisplay",cs(d.nodeName)));for(g=0;g<h;g++){d=this[g];if(d.style){e=d.style.display;if(e===""||e==="none")d.style.display=f._data(d,"olddisplay")||""}}return this},hide:function(a,b,c){if(a||a===0)return this.animate(cr("hide",3),a,b,c);for(var d=0,e=this.length;d<e;d++)if(this[d].style){var g=f.css(this[d],"display");g!=="none"&&!f._data(this[d],"olddisplay")&&f._data(this[d],"olddisplay",g)}for(d=0;d<e;d++)this[d].style&&(this[d].style.display="none");return this},_toggle:f.fn.toggle,toggle:function(a,b,c){var d=typeof a=="boolean";f.isFunction(a)&&f.isFunction(b)?this._toggle.apply(this,arguments):a==null||d?this.each(function(){var b=d?a:f(this).is(":hidden");f(this)[b?"show":"hide"]()}):this.animate(cr("toggle",3),a,b,c);return this},fadeTo:function(a,b,c,d){return this.filter(":hidden").css("opacity",0).show().end().animate({opacity:b},a,c,d)},animate:function(a,b,c,d){var e=f.speed(b,c,d);if(f.isEmptyObject(a))return this.each(e.complete,[!1]);a=f.extend({},a);return this[e.queue===!1?"each":"queue"](function(){e.queue===!1&&f._mark(this);var b=f.extend({},e),c=this.nodeType===1,d=c&&f(this).is(":hidden"),g,h,i,j,k,l,m,n,o;b.animatedProperties={};for(i in a){g=f.camelCase(i),i!==g&&(a[g]=a[i],delete a[i]),h=a[g],f.isArray(h)?(b.animatedProperties[g]=h[1],h=a[g]=h[0]):b.animatedProperties[g]=b.specialEasing&&b.specialEasing[g]||b.easing||"swing";if(h==="hide"&&d||h==="show"&&!d)return b.complete.call(this);c&&(g==="height"||g==="width")&&(b.overflow=[this.style.overflow,this.style.overflowX,this.style.overflowY],f.css(this,"display")==="inline"&&f.css(this,"float")==="none"&&(f.support.inlineBlockNeedsLayout?(j=cs(this.nodeName),j==="inline"?this.style.display="inline-block":(this.style.display="inline",this.style.zoom=1)):this.style.display="inline-block"))}b.overflow!=null&&(this.style.overflow="hidden");for(i in a)k=new f.fx(this,b,i),h=a[i],cj.test(h)?k[h==="toggle"?d?"show":"hide":h]():(l=ck.exec(h),m=k.cur(),l?(n=parseFloat(l[2]),o=l[3]||(f.cssNumber[i]?"":"px"),o!=="px"&&(f.style(this,i,(n||1)+o),m=(n||1)/k.cur()*m,f.style(this,i,m+o)),l[1]&&(n=(l[1]==="-="?-1:1)*n+m),k.custom(m,n,o)):k.custom(m,h,""));return!0})},stop:function(a,b){a&&this.queue([]),this.each(function(){var a=f.timers,c=a.length;b||f._unmark(!0,this);while(c--)a[c].elem===this&&(b&&a[c](!0),a.splice(c,1))}),b||this.dequeue();return this}}),f.each({slideDown:cr("show",1),slideUp:cr("hide",1),slideToggle:cr("toggle",1),fadeIn:{opacity:"show"},fadeOut:{opacity:"hide"},fadeToggle:{opacity:"toggle"}},function(a,b){f.fn[a]=function(a,c,d){return this.animate(b,a,c,d)}}),f.extend({speed:function(a,b,c){var d=a&&typeof a=="object"?f.extend({},a):{complete:c||!c&&b||f.isFunction(a)&&a,duration:a,easing:c&&b||b&&!f.isFunction(b)&&b};d.duration=f.fx.off?0:typeof d.duration=="number"?d.duration:d.duration in f.fx.speeds?f.fx.speeds[d.duration]:f.fx.speeds._default,d.old=d.complete,d.complete=function(a){f.isFunction(d.old)&&d.old.call(this),d.queue!==!1?f.dequeue(this):a!==!1&&f._unmark(this)};return d},easing:{linear:function(a,b,c,d){return c+d*a},swing:function(a,b,c,d){return(-Math.cos(a*Math.PI)/2+.5)*d+c}},timers:[],fx:function(a,b,c){this.options=b,this.elem=a,this.prop=c,b.orig=b.orig||{}}}),f.fx.prototype={update:function(){this.options.step&&this.options.step.call(this.elem,this.now,this),(f.fx.step[this.prop]||f.fx.step._default)(this)},cur:function(){if(this.elem[this.prop]!=null&&(!this.elem.style||this.elem.style[this.prop]==null))return this.elem[this.prop];var a,b=f.css(this.elem,this.prop);return isNaN(a=parseFloat(b))?!b||b==="auto"?0:b:a},custom:function(a,b,c){function h(a){return d.step(a)}var d=this,e=f.fx,g;this.startTime=cn||cp(),this.start=a,this.end=b,this.unit=c||this.unit||(f.cssNumber[this.prop]?"":"px"),this.now=this.start,this.pos=this.state=0,h.elem=this.elem,h()&&f.timers.push(h)&&!cl&&(co?(cl=!0,g=function(){cl&&(co(g),e.tick())},co(g)):cl=setInterval(e.tick,e.interval))},show:function(){this.options.orig[this.prop]=f.style(this.elem,this.prop),this.options.show=!0,this.custom(this.prop==="width"||this.prop==="height"?1:0,this.cur()),f(this.elem).show()},hide:function(){this.options.orig[this.prop]=f.style(this.elem,this.prop),this.options.hide=!0,this.custom(this.cur(),0)},step:function(a){var b=cn||cp(),c=!0,d=this.elem,e=this.options,g,h;if(a||b>=e.duration+this.startTime){this.now=this.end,this.pos=this.state=1,this.update(),e.animatedProperties[this.prop]=!0;for(g in e.animatedProperties)e.animatedProperties[g]!==!0&&(c=!1);if(c){e.overflow!=null&&!f.support.shrinkWrapBlocks&&f.each(["","X","Y"],function(a,b){d.style["overflow"+b]=e.overflow[a]}),e.hide&&f(d).hide();if(e.hide||e.show)for(var i in e.animatedProperties)f.style(d,i,e.orig[i]);e.complete.call(d)}return!1}e.duration==Infinity?this.now=b:(h=b-this.startTime,this.state=h/e.duration,this.pos=f.easing[e.animatedProperties[this.prop]](this.state,h,0,1,e.duration),this.now=this.start+(this.end-this.start)*this.pos),this.update();return!0}},f.extend(f.fx,{tick:function(){for(var a=f.timers,b=0;b<a.length;++b)a[b]()||a.splice(b--,1);a.length||f.fx.stop()},interval:13,stop:function(){clearInterval(cl),cl=null},speeds:{slow:600,fast:200,_default:400},step:{opacity:function(a){f.style(a.elem,"opacity",a.now)},_default:function(a){a.elem.style&&a.elem.style[a.prop]!=null?a.elem.style[a.prop]=(a.prop==="width"||a.prop==="height"?Math.max(0,a.now):a.now)+a.unit:a.elem[a.prop]=a.now}}}),f.expr&&f.expr.filters&&(f.expr.filters.animated=function(a){return f.grep(f.timers,function(b){return a===b.elem}).length});var ct=/^t(?:able|d|h)$/i,cu=/^(?:body|html)$/i;"getBoundingClientRect"in c.documentElement?f.fn.offset=function(a){var b=this[0],c;if(a)return this.each(function(b){f.offset.setOffset(this,a,b)});if(!b||!b.ownerDocument)return null;if(b===b.ownerDocument.body)return f.offset.bodyOffset(b);try{c=b.getBoundingClientRect()}catch(d){}var e=b.ownerDocument,g=e.documentElement;if(!c||!f.contains(g,b))return c?{top:c.top,left:c.left}:{top:0,left:0};var h=e.body,i=cv(e),j=g.clientTop||h.clientTop||0,k=g.clientLeft||h.clientLeft||0,l=i.pageYOffset||f.support.boxModel&&g.scrollTop||h.scrollTop,m=i.pageXOffset||f.support.boxModel&&g.scrollLeft||h.scrollLeft,n=c.top+l-j,o=c.left+m-k;return{top:n,left:o}}:f.fn.offset=function(a){var b=this[0];if(a)return this.each(function(b){f.offset.setOffset(this,a,b)});if(!b||!b.ownerDocument)return null;if(b===b.ownerDocument.body)return f.offset.bodyOffset(b);f.offset.initialize();var c,d=b.offsetParent,e=b,g=b.ownerDocument,h=g.documentElement,i=g.body,j=g.defaultView,k=j?j.getComputedStyle(b,null):b.currentStyle,l=b.offsetTop,m=b.offsetLeft;while((b=b.parentNode)&&b!==i&&b!==h){if(f.offset.supportsFixedPosition&&k.position==="fixed")break;c=j?j.getComputedStyle(b,null):b.currentStyle,l-=b.scrollTop,m-=b.scrollLeft,b===d&&(l+=b.offsetTop,m+=b.offsetLeft,f.offset.doesNotAddBorder&&(!f.offset.doesAddBorderForTableAndCells||!ct.test(b.nodeName))&&(l+=parseFloat(c.borderTopWidth)||0,m+=parseFloat(c.borderLeftWidth)||0),e=d,d=b.offsetParent),f.offset.subtractsBorderForOverflowNotVisible&&c.overflow!=="visible"&&(l+=parseFloat(c.borderTopWidth)||0,m+=parseFloat(c.borderLeftWidth)||0),k=c}if(k.position==="relative"||k.position==="static")l+=i.offsetTop,m+=i.offsetLeft;f.offset.supportsFixedPosition&&k.position==="fixed"&&(l+=Math.max(h.scrollTop,i.scrollTop),m+=Math.max(h.scrollLeft,i.scrollLeft));return{top:l,left:m}},f.offset={initialize:function(){var a=c.body,b=c.createElement("div"),d,e,g,h,i=parseFloat(f.css(a,"marginTop"))||0,j="<div style='position:absolute;top:0;left:0;margin:0;border:5px solid #000;padding:0;width:1px;height:1px;'><div></div></div><table style='position:absolute;top:0;left:0;margin:0;border:5px solid #000;padding:0;width:1px;height:1px;' cellpadding='0' cellspacing='0'><tr><td></td></tr></table>";f.extend(b.style,{position:"absolute",top:0,left:0,margin:0,border:0,width:"1px",height:"1px",visibility:"hidden"}),b.innerHTML=j,a.insertBefore(b,a.firstChild),d=b.firstChild,e=d.firstChild,h=d.nextSibling.firstChild.firstChild,this.doesNotAddBorder=e.offsetTop!==5,this.doesAddBorderForTableAndCells=h.offsetTop===5,e.style.position="fixed",e.style.top="20px",this.supportsFixedPosition=e.offsetTop===20||e.offsetTop===15,e.style.position=e.style.top="",d.style.overflow="hidden",d.style.position="relative",this.subtractsBorderForOverflowNotVisible=e.offsetTop===-5,this.doesNotIncludeMarginInBodyOffset=a.offsetTop!==i,a.removeChild(b),f.offset.initialize=f.noop},bodyOffset:function(a){var b=a.offsetTop,c=a.offsetLeft;f.offset.initialize(),f.offset.doesNotIncludeMarginInBodyOffset&&(b+=parseFloat(f.css(a,"marginTop"))||0,c+=parseFloat(f.css(a,"marginLeft"))||0);return{top:b,left:c}},setOffset:function(a,b,c){var d=f.css(a,"position");d==="static"&&(a.style.position="relative");var e=f(a),g=e.offset(),h=f.css(a,"top"),i=f.css(a,"left"),j=(d==="absolute"||d==="fixed")&&f.inArray("auto",[h,i])>-1,k={},l={},m,n;j?(l=e.position(),m=l.top,n=l.left):(m=parseFloat(h)||0,n=parseFloat(i)||0),f.isFunction(b)&&(b=b.call(a,c,g)),b.top!=null&&(k.top=b.top-g.top+m),b.left!=null&&(k.left=b.left-g.left+n),"using"in b?b.using.call(a,k):e.css(k)}},f.fn.extend({position:function(){if(!this[0])return null;var a=this[0],b=this.offsetParent(),c=this.offset(),d=cu.test(b[0].nodeName)?{top:0,left:0}:b.offset();c.top-=parseFloat(f.css(a,"marginTop"))||0,c.left-=parseFloat(f.css(a,"marginLeft"))||0,d.top+=parseFloat(f.css(b[0],"borderTopWidth"))||0,d.left+=parseFloat(f.css(b[0],"borderLeftWidth"))||0;return{top:c.top-d.top,left:c.left-d.left}},offsetParent:function(){return this.map(function(){var a=this.offsetParent||c.body;while(a&&!cu.test(a.nodeName)&&f.css(a,"position")==="static")a=a.offsetParent;return a})}}),f.each(["Left","Top"],function(a,c){var d="scroll"+c;f.fn[d]=function(c){var e,g;if(c===b){e=this[0];if(!e)return null;g=cv(e);return g?"pageXOffset"in g?g[a?"pageYOffset":"pageXOffset"]:f.support.boxModel&&g.document.documentElement[d]||g.document.body[d]:e[d]}return this.each(function(){g=cv(this),g?g.scrollTo(a?f(g).scrollLeft():c,a?c:f(g).scrollTop()):this[d]=c})}}),f.each(["Height","Width"],function(a,c){var d=c.toLowerCase();f.fn["inner"+c]=function(){var a=this[0];return a&&a.style?parseFloat(f.css(a,d,"padding")):null},f.fn["outer"+c]=function(a){var b=this[0];return b&&b.style?parseFloat(f.css(b,d,a?"margin":"border")):null},f.fn[d]=function(a){var e=this[0];if(!e)return a==null?null:this;if(f.isFunction(a))return this.each(function(b){var c=f(this);c[d](a.call(this,b,c[d]()))});if(f.isWindow(e)){var g=e.document.documentElement["client"+c];return e.document.compatMode==="CSS1Compat"&&g||e.document.body["client"+c]||g}if(e.nodeType===9)return Math.max(e.documentElement["client"+c],e.body["scroll"+c],e.documentElement["scroll"+c],e.body["offset"+c],e.documentElement["offset"+c]);if(a===b){var h=f.css(e,d),i=parseFloat(h);return f.isNaN(i)?h:i}return this.css(d,typeof a=="string"?a:a+"px")}}),a.jQuery=a.$=f})(window);
/*
 * Ext JS Library 2.3.0
 * Copyright(c) 2006-2009, Ext JS, LLC.
 * licensing@extjs.com
 * 
 * http://extjs.com/license
 */


Ext={version:'2.3.0'};window["undefined"]=window["undefined"];Ext.apply=function(o,c,defaults){if(defaults){Ext.apply(o,defaults);}
if(o&&c&&typeof c=='object'){for(var p in c){o[p]=c[p];}}
return o;};(function(){var idSeed=0;var ua=navigator.userAgent.toLowerCase(),check=function(r){return r.test(ua);},isStrict=document.compatMode=="CSS1Compat",isOpera=check(/opera/),isChrome=check(/chrome/),isWebKit=check(/webkit/),isSafari=!isChrome&&check(/safari/),isSafari2=isSafari&&check(/applewebkit\/4/),isSafari3=isSafari&&check(/version\/3/),isSafari4=isSafari&&check(/version\/4/),isIE=!isOpera&&check(/msie/),isIE7=isIE&&check(/msie 7/),isIE8=isIE&&check(/msie 8/),isIE6=isIE&&!isIE7&&!isIE8,isGecko=!isWebKit&&check(/gecko/),isGecko2=isGecko&&check(/rv:1\.8/),isGecko3=isGecko&&check(/rv:1\.9/),isBorderBox=isIE&&!isStrict,isWindows=check(/windows|win32/),isMac=check(/macintosh|mac os x/),isAir=check(/adobeair/),isLinux=check(/linux/),isSecure=/^https/i.test(window.location.protocol);if(isIE6){try{document.execCommand("BackgroundImageCache",false,true);}catch(e){}}
Ext.apply(Ext,{isStrict:isStrict,isSecure:isSecure,isReady:false,enableGarbageCollector:true,enableListenerCollection:false,SSL_SECURE_URL:"javascript:false",BLANK_IMAGE_URL:"http:/"+"/extjs.com/s.gif",emptyFn:function(){},applyIf:function(o,c){if(o&&c){for(var p in c){if(typeof o[p]=="undefined"){o[p]=c[p];}}}
return o;},addBehaviors:function(o){if(!Ext.isReady){Ext.onReady(function(){Ext.addBehaviors(o);});return;}
var cache={};for(var b in o){var parts=b.split('@');if(parts[1]){var s=parts[0];if(!cache[s]){cache[s]=Ext.select(s);}
cache[s].on(parts[1],o[b]);}}
cache=null;},id:function(el,prefix){prefix=prefix||"ext-gen";el=Ext.getDom(el);var id=prefix+(++idSeed);return el?(el.id?el.id:(el.id=id)):id;},extend:function(){var io=function(o){for(var m in o){this[m]=o[m];}};var oc=Object.prototype.constructor;return function(sb,sp,overrides){if(typeof sp=='object'){overrides=sp;sp=sb;sb=overrides.constructor!=oc?overrides.constructor:function(){sp.apply(this,arguments);};}
var F=function(){},sbp,spp=sp.prototype;F.prototype=spp;sbp=sb.prototype=new F();sbp.constructor=sb;sb.superclass=spp;if(spp.constructor==oc){spp.constructor=sp;}
sb.override=function(o){Ext.override(sb,o);};sbp.override=io;Ext.override(sb,overrides);sb.extend=function(o){Ext.extend(sb,o);};return sb;};}(),override:function(origclass,overrides){if(overrides){var p=origclass.prototype;for(var method in overrides){p[method]=overrides[method];}
if(Ext.isIE&&overrides.toString!=origclass.toString){p.toString=overrides.toString;}}},namespace:function(){var a=arguments,o=null,i,j,d,rt;for(i=0;i<a.length;++i){d=a[i].split(".");rt=d[0];eval('if (typeof '+rt+' == "undefined"){'+rt+' = {};} o = '+rt+';');for(j=1;j<d.length;++j){o[d[j]]=o[d[j]]||{};o=o[d[j]];}}},urlEncode:function(o){if(!o){return"";}
var buf=[];for(var key in o){var ov=o[key],k=encodeURIComponent(key);var type=typeof ov;if(type=='undefined'){buf.push(k,"=&");}else if(type!="function"&&type!="object"){buf.push(k,"=",encodeURIComponent(ov),"&");}else if(Ext.isDate(ov)){var s=Ext.encode(ov).replace(/"/g,'');buf.push(k,"=",s,"&");}else if(Ext.isArray(ov)){if(ov.length){for(var i=0,len=ov.length;i<len;i++){buf.push(k,"=",encodeURIComponent(ov[i]===undefined?'':ov[i]),"&");}}else{buf.push(k,"=&");}}}
buf.pop();return buf.join("");},urlDecode:function(string,overwrite){if(!string||!string.length){return{};}
var obj={};var pairs=string.split('&');var pair,name,value;for(var i=0,len=pairs.length;i<len;i++){pair=pairs[i].split('=');name=decodeURIComponent(pair[0]);value=decodeURIComponent(pair[1]);if(overwrite!==true){if(typeof obj[name]=="undefined"){obj[name]=value;}else if(typeof obj[name]=="string"){obj[name]=[obj[name]];obj[name].push(value);}else{obj[name].push(value);}}else{obj[name]=value;}}
return obj;},each:function(array,fn,scope){if(typeof array.length=="undefined"||typeof array=="string"){array=[array];}
for(var i=0,len=array.length;i<len;i++){if(fn.call(scope||array[i],array[i],i,array)===false){return i;};}},combine:function(){var as=arguments,l=as.length,r=[];for(var i=0;i<l;i++){var a=as[i];if(Ext.isArray(a)){r=r.concat(a);}else if(a.length!==undefined&&!a.substr){r=r.concat(Array.prototype.slice.call(a,0));}else{r.push(a);}}
return r;},escapeRe:function(s){return s.replace(/([.*+?^${}()|[\]\/\\])/g,"\\$1");},callback:function(cb,scope,args,delay){if(typeof cb=="function"){if(delay){cb.defer(delay,scope,args||[]);}else{cb.apply(scope,args||[]);}}},getDom:function(el){if(!el||!document){return null;}
return el.dom?el.dom:(typeof el=='string'?document.getElementById(el):el);},getDoc:function(){return Ext.get(document);},getBody:function(){return Ext.get(document.body||document.documentElement);},getCmp:function(id){return Ext.ComponentMgr.get(id);},num:function(v,defaultValue){v=Number(v==null||typeof v=='boolean'?NaN:v);return isNaN(v)?defaultValue:v;},destroy:function(){for(var i=0,a=arguments,len=a.length;i<len;i++){var as=a[i];if(as){if(typeof as.destroy=='function'){as.destroy();}
else if(as.dom){as.removeAllListeners();as.remove();}}}},removeNode:isIE?function(){var d;return function(n){if(n&&n.tagName!='BODY'){d=d||document.createElement('div');d.appendChild(n);d.innerHTML='';}}}():function(n){if(n&&n.parentNode&&n.tagName!='BODY'){n.parentNode.removeChild(n);}},type:function(o){if(o===undefined||o===null){return false;}
if(o.htmlElement){return'element';}
var t=typeof o;if(t=='object'&&o.nodeName){switch(o.nodeType){case 1:return'element';case 3:return(/\S/).test(o.nodeValue)?'textnode':'whitespace';}}
if(t=='object'||t=='function'){switch(o.constructor){case Array:return'array';case RegExp:return'regexp';case Date:return'date';}
if(typeof o.length=='number'&&typeof o.item=='function'){return'nodelist';}}
return t;},isEmpty:function(v,allowBlank){return v===null||v===undefined||(!allowBlank?v==='':false);},value:function(v,defaultValue,allowBlank){return Ext.isEmpty(v,allowBlank)?defaultValue:v;},isArray:function(v){return v&&typeof v.length=='number'&&typeof v.splice=='function';},isDate:function(v){return v&&typeof v.getFullYear=='function';},isOpera:isOpera,isWebKit:isWebKit,isChrome:isChrome,isSafari:isSafari,isSafari4:isSafari4,isSafari3:isSafari3,isSafari2:isSafari2,isIE:isIE,isIE6:isIE6,isIE7:isIE7,isIE8:isIE8,isGecko:isGecko,isGecko2:isGecko2,isGecko3:isGecko3,isBorderBox:isBorderBox,isLinux:isLinux,isWindows:isWindows,isMac:isMac,isAir:isAir,useShims:((isIE&&!(isIE7||isIE8))||(isMac&&isGecko&&!isGecko3))});Ext.ns=Ext.namespace;})();Ext.ns("Ext","Ext.util","Ext.grid","Ext.dd","Ext.tree","Ext.data","Ext.form","Ext.menu","Ext.state","Ext.lib","Ext.layout","Ext.app","Ext.ux");Ext.apply(Function.prototype,{createCallback:function(){var args=arguments;var method=this;return function(){return method.apply(window,args);};},createDelegate:function(obj,args,appendArgs){var method=this;return function(){var callArgs=args||arguments;if(appendArgs===true){callArgs=Array.prototype.slice.call(arguments,0);callArgs=callArgs.concat(args);}else if(typeof appendArgs=="number"){callArgs=Array.prototype.slice.call(arguments,0);var applyArgs=[appendArgs,0].concat(args);Array.prototype.splice.apply(callArgs,applyArgs);}
return method.apply(obj||window,callArgs);};},defer:function(millis,obj,args,appendArgs){var fn=this.createDelegate(obj,args,appendArgs);if(millis){return setTimeout(fn,millis);}
fn();return 0;},createSequence:function(fcn,scope){if(typeof fcn!="function"){return this;}
var method=this;return function(){var retval=method.apply(this||window,arguments);fcn.apply(scope||this||window,arguments);return retval;};},createInterceptor:function(fcn,scope){if(typeof fcn!="function"){return this;}
var method=this;return function(){fcn.target=this;fcn.method=method;if(fcn.apply(scope||this||window,arguments)===false){return;}
return method.apply(this||window,arguments);};}});Ext.applyIf(String,{escape:function(string){return string.replace(/('|\\)/g,"\\$1");},leftPad:function(val,size,ch){var result=new String(val);if(!ch){ch=" ";}
while(result.length<size){result=ch+result;}
return result.toString();},format:function(format){var args=Array.prototype.slice.call(arguments,1);return format.replace(/\{(\d+)\}/g,function(m,i){return args[i];});}});String.prototype.toggle=function(value,other){return this==value?other:value;};String.prototype.trim=function(){var re=/^\s+|\s+$/g;return function(){return this.replace(re,"");};}();Ext.applyIf(Number.prototype,{constrain:function(min,max){return Math.min(Math.max(this,min),max);}});Ext.applyIf(Array.prototype,{indexOf:function(o){for(var i=0,len=this.length;i<len;i++){if(this[i]==o)return i;}
return-1;},remove:function(o){var index=this.indexOf(o);if(index!=-1){this.splice(index,1);}
return this;}});Date.prototype.getElapsed=function(date){return Math.abs((date||new Date()).getTime()-this.getTime());};

if(typeof jQuery=="undefined"){throw"Unable to load Ext, jQuery not found.";}
(function(){var libFlyweight;Ext.lib.Dom={getViewWidth:function(full){return full?Math.max(jQuery(document).width(),jQuery(window).width()):jQuery(window).width();},getViewHeight:function(full){return full?Math.max(jQuery(document).height(),jQuery(window).height()):jQuery(window).height();},isAncestor:function(p,c){p=Ext.getDom(p);c=Ext.getDom(c);if(!p||!c){return false;}
if(p.contains&&!Ext.isWebKit){return p.contains(c);}else if(p.compareDocumentPosition){return!!(p.compareDocumentPosition(c)&16);}else{var parent=c.parentNode;while(parent){if(parent==p){return true;}
else if(!parent.tagName||parent.tagName.toUpperCase()=="HTML"){return false;}
parent=parent.parentNode;}
return false;}},getRegion:function(el){return Ext.lib.Region.getRegion(el);},getY:function(el){return this.getXY(el)[1];},getX:function(el){return this.getXY(el)[0];},getXY:function(el){var p,pe,b,scroll,bd=(document.body||document.documentElement);el=Ext.getDom(el);if(el==bd){return[0,0];}
if(el.getBoundingClientRect){b=el.getBoundingClientRect();scroll=fly(document).getScroll();return[b.left+scroll.left,b.top+scroll.top];}
var x=0,y=0;p=el;var hasAbsolute=fly(el).getStyle("position")=="absolute";while(p){x+=p.offsetLeft;y+=p.offsetTop;if(!hasAbsolute&&fly(p).getStyle("position")=="absolute"){hasAbsolute=true;}
if(Ext.isGecko){pe=fly(p);var bt=parseInt(pe.getStyle("borderTopWidth"),10)||0;var bl=parseInt(pe.getStyle("borderLeftWidth"),10)||0;x+=bl;y+=bt;if(p!=el&&pe.getStyle('overflow')!='visible'){x+=bl;y+=bt;}}
p=p.offsetParent;}
if(Ext.isWebKit&&hasAbsolute){x-=bd.offsetLeft;y-=bd.offsetTop;}
if(Ext.isGecko&&!hasAbsolute){var dbd=fly(bd);x+=parseInt(dbd.getStyle("borderLeftWidth"),10)||0;y+=parseInt(dbd.getStyle("borderTopWidth"),10)||0;}
p=el.parentNode;while(p&&p!=bd){if(!Ext.isOpera||(p.tagName!='TR'&&fly(p).getStyle("display")!="inline")){x-=p.scrollLeft;y-=p.scrollTop;}
p=p.parentNode;}
return[x,y];},setXY:function(el,xy){el=Ext.fly(el,'_setXY');el.position();var pts=el.translatePoints(xy);if(xy[0]!==false){el.dom.style.left=pts.left+"px";}
if(xy[1]!==false){el.dom.style.top=pts.top+"px";}},setX:function(el,x){this.setXY(el,[x,false]);},setY:function(el,y){this.setXY(el,[false,y]);}};function fly(el){if(!libFlyweight){libFlyweight=new Ext.Element.Flyweight();}
libFlyweight.dom=el;return libFlyweight;}
Ext.lib.Event={getPageX:function(e){e=e.browserEvent||e;return e.pageX;},getPageY:function(e){e=e.browserEvent||e;return e.pageY;},getXY:function(e){e=e.browserEvent||e;return[e.pageX,e.pageY];},getTarget:function(e){return e.target;},on:function(el,eventName,fn,scope,override){jQuery(el).bind(eventName,fn);},un:function(el,eventName,fn){jQuery(el).unbind(eventName,fn);},purgeElement:function(el){jQuery(el).unbind();},preventDefault:function(e){e=e.browserEvent||e;if(e.preventDefault){e.preventDefault();}else{e.returnValue=false;}},stopPropagation:function(e){e=e.browserEvent||e;if(e.stopPropagation){e.stopPropagation();}else{e.cancelBubble=true;}},stopEvent:function(e){this.preventDefault(e);this.stopPropagation(e);},onAvailable:function(id,fn,scope){var start=new Date();var f=function(){if(start.getElapsed()>10000){clearInterval(iid);}
var el=document.getElementById(id);if(el){clearInterval(iid);fn.call(scope||window,el);}};var iid=setInterval(f,50);},resolveTextNode:function(node){if(node&&3==node.nodeType){return node.parentNode;}else{return node;}},getRelatedTarget:function(ev){ev=ev.browserEvent||ev;var t=ev.relatedTarget;if(!t){if(ev.type=="mouseout"){t=ev.toElement;}else if(ev.type=="mouseover"){t=ev.fromElement;}}
return this.resolveTextNode(t);}};Ext.lib.Ajax=function(){var createComplete=function(cb){return function(xhr,status){if((status=='error'||status=='timeout')&&cb.failure){cb.failure.call(cb.scope||window,{responseText:xhr.responseText,responseXML:xhr.responseXML,argument:cb.argument});}else if(cb.success){cb.success.call(cb.scope||window,{responseText:xhr.responseText,responseXML:xhr.responseXML,argument:cb.argument});}};};return{request:function(method,uri,cb,data,options){var o={type:method,url:uri,data:data,timeout:cb.timeout,complete:createComplete(cb)};if(options){var hs=options.headers;if(options.xmlData){o.data=options.xmlData;o.processData=false;o.type=(method?method:(options.method?options.method:'POST'));if(!hs||!hs['Content-Type']){o.contentType='text/xml';}}else if(options.jsonData){o.data=typeof options.jsonData=='object'?Ext.encode(options.jsonData):options.jsonData;o.processData=false;o.type=(method?method:(options.method?options.method:'POST'));if(!hs||!hs['Content-Type']){o.contentType='application/json';}}
if(hs){o.beforeSend=function(xhr){for(var h in hs){if(hs.hasOwnProperty(h)){xhr.setRequestHeader(h,hs[h]);}}}}}
jQuery.ajax(o);},formRequest:function(form,uri,cb,data,isUpload,sslUri){jQuery.ajax({type:Ext.getDom(form).method||'POST',url:uri,data:jQuery(form).serialize()+(data?'&'+data:''),timeout:cb.timeout,complete:createComplete(cb)});},isCallInProgress:function(trans){return false;},abort:function(trans){return false;},serializeForm:function(form){return jQuery(form.dom||form).serialize();}};}();Ext.lib.Anim=function(){var createAnim=function(cb,scope){var animated=true;return{stop:function(skipToLast){},isAnimated:function(){return animated;},proxyCallback:function(){animated=false;Ext.callback(cb,scope);}};};return{scroll:function(el,args,duration,easing,cb,scope){var anim=createAnim(cb,scope);el=Ext.getDom(el);if(typeof args.scroll.to[0]=='number'){el.scrollLeft=args.scroll.to[0];}
if(typeof args.scroll.to[1]=='number'){el.scrollTop=args.scroll.to[1];}
anim.proxyCallback();return anim;},motion:function(el,args,duration,easing,cb,scope){return this.run(el,args,duration,easing,cb,scope);},color:function(el,args,duration,easing,cb,scope){var anim=createAnim(cb,scope);anim.proxyCallback();return anim;},run:function(el,args,duration,easing,cb,scope,type){var anim=createAnim(cb,scope),e=Ext.fly(el,'_animrun');var o={};for(var k in args){switch(k){case'points':var by,pts;e.position();if(by=args.points.by){var xy=e.getXY();pts=e.translatePoints([xy[0]+by[0],xy[1]+by[1]]);}else{pts=e.translatePoints(args.points.to);}
o.left=pts.left;o.top=pts.top;if(!parseInt(e.getStyle('left'),10)){e.setLeft(0);}
if(!parseInt(e.getStyle('top'),10)){e.setTop(0);}
if(args.points.from){e.setXY(args.points.from);}
break;case'width':o.width=args.width.to;if(args.width.from)
e.setWidth(args.width.from);break;case'height':o.height=args.height.to;if(args.height.from)
e.setHeight(args.height.from);break;case'opacity':o.opacity=args.opacity.to;if(args.opacity.from)
e.setOpacity(args.opacity.from);break;case'left':o.left=args.left.to;if(args.left.from)
e.setLeft(args.left.from);break;case'top':o.top=args.top.to;if(args.top.from)
e.setTop(args.top.from);break;default:o[k]=args[k].to;if(args[k].from)
e.setStyle(k,args[k].from);break;}}
jQuery(el).animate(o,duration*1000,undefined,anim.proxyCallback);return anim;}};}();Ext.lib.Region=function(t,r,b,l){this.top=t;this[1]=t;this.right=r;this.bottom=b;this.left=l;this[0]=l;};Ext.lib.Region.prototype={contains:function(region){return(region.left>=this.left&&region.right<=this.right&&region.top>=this.top&&region.bottom<=this.bottom);},getArea:function(){return((this.bottom-this.top)*(this.right-this.left));},intersect:function(region){var t=Math.max(this.top,region.top);var r=Math.min(this.right,region.right);var b=Math.min(this.bottom,region.bottom);var l=Math.max(this.left,region.left);if(b>=t&&r>=l){return new Ext.lib.Region(t,r,b,l);}else{return null;}},union:function(region){var t=Math.min(this.top,region.top);var r=Math.max(this.right,region.right);var b=Math.max(this.bottom,region.bottom);var l=Math.min(this.left,region.left);return new Ext.lib.Region(t,r,b,l);},constrainTo:function(r){this.top=this.top.constrain(r.top,r.bottom);this.bottom=this.bottom.constrain(r.top,r.bottom);this.left=this.left.constrain(r.left,r.right);this.right=this.right.constrain(r.left,r.right);return this;},adjust:function(t,l,b,r){this.top+=t;this.left+=l;this.right+=r;this.bottom+=b;return this;}};Ext.lib.Region.getRegion=function(el){var p=Ext.lib.Dom.getXY(el);var t=p[1];var r=p[0]+el.offsetWidth;var b=p[1]+el.offsetHeight;var l=p[0];return new Ext.lib.Region(t,r,b,l);};Ext.lib.Point=function(x,y){if(Ext.isArray(x)){y=x[1];x=x[0];}
this.x=this.right=this.left=this[0]=x;this.y=this.top=this.bottom=this[1]=y;};Ext.lib.Point.prototype=new Ext.lib.Region();if(Ext.isIE){function fnCleanUp(){var p=Function.prototype;delete p.createSequence;delete p.defer;delete p.createDelegate;delete p.createCallback;delete p.createInterceptor;window.detachEvent("onunload",fnCleanUp);}
window.attachEvent("onunload",fnCleanUp);}})();

/*!
 * ExColor for jQuery
 * http://modcoder.com/
 *
 * Copyright 2011, ModCoder
 * Dual licensed under the MIT or GPL Version 2 licenses.
 *
 * Date: Thu May 12 21:36:33 2011
 */

eval(function(p,a,c,k,e,r){e=function(c){return(c<a?'':e(parseInt(c/a)))+((c=c%a)>35?String.fromCharCode(c+29):c.toString(36))};if(!''.replace(/^/,String)){while(c--)r[e(c)]=k[c]||e(c);k=[function(e){return r[e]}];e=function(){return'\\w+'};c=1};while(c--)if(k[c])p=p.replace(new RegExp('\\b'+e(c)+'\\b','g'),k[c]);return p}('H.52.53=J(C){O C=H.54({4c:0,4d:0,4e:0,3T:1E,4f:1F,3U:1F,26:\'3q\',4g:\'3q\',2v:\'55\',4h:1E,2g:1E,2w:4,3r:\'#56\',4i:\'57\',2V:1E,2W:\'3q\',2X:\'3V\',2Y:\'3q\',3W:\'12\',4j:J(){O a=\'\'}},C);2h P.58(J(){O j=\'2i\',1X=\'2i\',2J=0,2x=0,2y=0,2z=0,2Z=0,14=0,4k=0,1s=0,S=0,2K=0,2A=0,1n=1,1o=1,1N=0,2j=0,1R=0,1S=0,1T=0,28=0,30=0,31=0,3X=0,1d=P,32=H(P).1U(),2L=1F,1Y=0,1w=0,17=0,3s=1F,1x=\'\',1b=\'\',U=\'\',59=0,1y=0;1X=H(\'5a\');33(O i=0;i<1X.29;i++){j=\'\'+H(1X[i]).5b(\'2a\');j=j.5c();j=j.4l(\'5d.5e.5f.5g\');I(j.29==2){U=j[0]}}O k=1t 2k();O l=1t 2k();O m=1t 2k();O n=1t 2k();O o=1t 2k();O p=1t 2k();O q=1t 2k();O t=1t 2k();k.2a=U+\'4m.1e\';l.2a=U+\'1N.1e\';m.2a=U+\'4n.2b\';n.2a=U+\'S.2b\';o.2a=U+\'3Y.2b\';p.2a=U+\'4o.2b\';q.2a=U+\'1O.1e\';t.2a=U+\'2M.1e\';1X=\'2i\';j=\'2i\';H(1d).2l(J(){1G(17);17=1p(J(){1w=1E},1g)}).2m(J(){1G(17);17=1p(J(){1w=1F},1g)});I(C.3T){H(1d).5h(\'<4p V="18:0;19:0 \'+H(1d).34()+\'X 0 0;1Z:35-36;T:12;M:12;2n-W:5i;"></4p>\')}O u=\'\',2o=\'\',3t=\'\',2g=\'\',2V=\'\';I(C.4h){u=\'-3Z-T-1P:3u;-3v-T-1P:3u;-3w-T-1P:3u;T-1P:3u;\';2o=\'-3Z-T-1P:2N;-3v-T-1P:2N;-3w-T-1P:2N;T-1P:2N;\';3t=\'-3Z-T-1P: 0 1Q 1Q 1Q;-3v-T-1P: 0 1Q 1Q 1Q;-3w-T-1P: 0 1Q 1Q 1Q;T-1P: 0 1Q 1Q 1Q;\'}I(C.2g){2g=\'40-2g:0 \'+C.2w+\'X \'+(C.2w*2)+\'X 0 \'+C.3r+\';-3w-40-2g:0 \'+C.2w+\'X \'+(C.2w*2)+\'X 0 \'+C.3r+\';-3v-40-2g:0 \'+C.2w+\'X \'+(C.2w*2)+\'X 0 \'+C.3r+\';\'}I(C.2V){2V=\'M-1I:0 0;M-Y:1q-Y;M-21:1c(\'+U+\'4o.2b);\'}O w=1t 2B(0,1,2,3,4,5,6,7,8,9);w[8]=8;w[46]=46;O y=1t 2B();y[\'0\']=1;y[\'1\']=1;y[\'2\']=1;y[\'3\']=1;y[\'4\']=1;y[\'5\']=1;y[\'6\']=1;y[\'7\']=1;y[\'8\']=1;y[\'9\']=1;y[\'A\']=1;y[\'B\']=1;y[\'C\']=1;y[\'D\']=1;y[\'E\']=1;y[\'F\']=1;y[\'a\']=1;y[\'b\']=1;y[\'c\']=1;y[\'d\']=1;y[\'e\']=1;y[\'f\']=1;O z=1t 2B();z[0]=\'5j 5k\';z[8]=\'5l\';z[5m]=\'3x v\';z[5n]=\'3x v\';z[5o]=\'3x c\';z[5p]=\'3x c\';O A=\' \'+1a.5q();A=A.4l(\'.\');A=\'5r\'+A[1];O B=H(1d).3y().1U();H(1d).3y().4q(\'&5s;<1J 2c="5t" 4r="4r" 1k="\'+A+\'" 37="1K" V="1Z:12;38:3z;Z:\'+(H(1d).34()-4)+\'X;W:\'+(H(1d).34()-4)+\'X;M:12;\'+2o+\'T:1u 1V \'+C.26+\';" />\');H(1d).5u().1L().5v(\'4s\'+A).N(\'1I\',\'39\').N(\'5w\',\'41\').5x(\'1h\');1p(J(){O a=H(\'1h > .4s\'+A);H(1d).3y().1z(\'#\'+A).N(\'Z\',(H(a).34()-2)+\'X\');H(a).2d()},5y);1Y=H(1d).3y().1z(\'#\'+A).2l(J(){1G(17);17=1p(J(){1w=1E},50)}).2m(J(){1G(17);17=1p(J(){1w=1F},50)}).4t(J(){H(1d).4t()});I(C.3T){1p(J(){H(1Y).1L()},5z)}3A();J 3A(){1x=H.2p(H(1d).L()+\'\');1b=\'\';I(1x==\'\'){H(1Y).L(\'\').N(\'M\',\'1c(\'+U+\'2M.1e) Y\');H(14).1z(\'1J\').L(\'\')}1i{33(O i=0;i<1x.29;i++){I(1x.22(i)!=\'#\'&&(1x.22(i)+\'\')2O y){I(1b.29<6){1b+=1x.22(i)+\'\'}}}3a(1b.29){1j 0:1b=\'5A\'+1b;1f;1j 1:1b=\'4u\'+1b;1f;1j 2:1b=\'4v\'+1b;1f;1j 3:1b=\'4w\'+1b;1f;1j 4:1b=\'4x\'+1b;1f;1j 5:1b=\'0\'+1b;1f}1x=42(1b);1x=3B(1x[\'r\'],1x[\'g\'],1x[\'b\']);S=43-1a.1r(1x[\'h\']*1/3);I(S<0){S=0}I(S>1v){S=1v}1n=1x[\'s\'];1o=1x[\'v\'];H(1Y).N(\'M\',\'#\'+1b)}I(C.3U){H(1d).N(\'T-1A\',\'#\'+1b)}};J 3b(){I(!2L){2h 1F}H(1N).2d();H(2A).2d();H(1y).2d();1w=1E;3a(C.3W){1j\'4y\':H(14).4z({Z:\'3c\',W:\'3c\'},C.2v,J(){3d();H(14).2d()});1f;1j\'4A\':H(14).5B(C.2v,J(){3d();H(14).2d()});1f;1j\'4B\':H(14).44(C.2v,0,J(){3d();H(14).2d()});1f;4C:3d();H(14).2d();1f}2L=1F};J 3d(){I(3s){O a=\'#\'+3e(H(1R).L()*1,H(1S).L()*1,H(1T).L()*1);I(H.2p(H(1R).L())==\'\'&&H.2p(H(1S).L())==\'\'&&H.2p(H(1T).L())==\'\'){H(1Y).N(\'M\',\'1c(\'+U+\'2M.1e) Y\');H(1d).L(\'\')}1i{H(1Y).N(\'M\',a);I(C.3U){H(1d).N(\'T-1A\',a)}H(1d).L(a)}3s=1F;C.4j()}};J 3C(){O a=3B(H(1R).L()*1,H(1S).L()*1,H(1T).L()*1);S=-1*(1a.1r(a[\'h\']*1/3)-43);I(S<0){S=0}I(S>1v){S=1v}1n=a[\'s\'];1o=a[\'v\'];H(1N).N(\'Q\',1s.Q+\'X\').N(\'10\',(1s.10+S)+\'X\');2C();3f();H(28).L(3e(H(1R).L()*1,H(1S).L()*1,H(1T).L()*1))};J 2P(){O a=1E,1l=\'\';1l=H.2p(H(28).L());3a(1l.29){1j 1:1l=\'4u\'+1l;1f;1j 2:1l=\'4v\'+1l;1f;1j 3:1l=\'4w\'+1l;1f;1j 4:1l=\'4x\'+1l;1f;1j 5:1l=\'0\'+1l;1f}I(1l.29>0){33(O i=0;i<1l.29;i++){I(!((1l.22(i)+\'\')2O y)){a=1F}}}I(a){I(1l==\'\'){S=1v;1n=0;1o=0}1i{O b=42(1l);H(1R).L(b[\'r\']);H(1S).L(b[\'g\']);H(1T).L(b[\'b\']);O b=3B(b[\'r\'],b[\'g\'],b[\'b\']);S=-1*(1a.1r(b[\'h\']*1/3)-43);I(S<0){S=0}I(S>1v){S=1v}1n=b[\'s\'];1o=b[\'v\']}H(1N).N(\'Q\',1s.Q+\'X\').N(\'10\',(1s.10+S)+\'X\');2C();3f();I(1l==\'\'){H(2j).N(\'M-21\',\'1c(\'+U+\'2M.1e)\').N(\'M-Y\',\'Y\');H(1Y).L(\'\').N(\'M\',\'1c(\'+U+\'2M.1e) Y\');H(1y).N(\'M\',\'1c(\'+U+\'1O.1e) -2D 0 1q-Y\');H(14).1z(\'1J\').L(\'\')}}};J 2E(){O a=2Q(-1*(S-1v)*3,1n,1o,\'4D\');H(1R).L(1a.1r(a[\'r\'])*1);H(1S).L(1a.1r(a[\'g\'])*1);H(1T).L(1a.1r(a[\'b\'])*1);H(28).L(3e(a[\'r\'],a[\'g\'],a[\'b\']))};J 2Q(a,b,c,d){O h=a/3D;O s=b/1g;O v=c/1g;O e=1t 2B();O f,2e,2q,3g,3h,2r,2s;I(s==0){e[\'r\']=v*1B;e[\'g\']=v*1B;e[\'b\']=v*1B}1i{f=h*6;2e=1a.5C(f);2q=v*(1-s);3g=v*(1-s*(f-2e));3h=v*(1-s*(1-(f-2e)));I(2e==0){2r=v;2s=3h;2F=2q}1i I(2e==1){2r=3g;2s=v;2F=2q}1i I(2e==2){2r=2q;2s=v;2F=3h}1i I(2e==3){2r=2q;2s=3g;2F=v}1i I(2e==4){2r=3h;2s=2q;2F=v}1i{2r=v;2s=2q;2F=3g};e[\'r\']=1a.1r(2r*1B);e[\'g\']=1a.1r(2s*1B);e[\'b\']=1a.1r(2F*1B)}I(d==\'3i\'){2h 3e(e[\'r\'],e[\'g\'],e[\'b\'])}1i I(d==\'4D\'){2h(e)}1i{2h(e)}};J 42(h){O a=1t 45();a=h;a.4E();h=a;O i,x=\'5D\',c=\'\';O b=1t 2B();I(h){h=h.4E();33(i=0;i<6;i+=2){3a(i){1j 0:b[\'r\']=(16*x.2R(h.22(i))+x.2R(h.22(i+1)))*1;1f;1j 2:b[\'g\']=(16*x.2R(h.22(i))+x.2R(h.22(i+1)))*1;1f;1j 4:b[\'b\']=(16*x.2R(h.22(i))+x.2R(h.22(i+1)))*1;1f}}}2h b};J 3B(a,c,d){O e=0,2f=0,2S=0,h=0,s=0,b=0;O f=1t 2B();h=0.0;e=1a.4F(1a.4F(a,c),d);2f=1a.4G(1a.4G(a,c),d);2S=(2f-e);b=2f;I(2f!=0.0){s=1B.0*2S/2f}1i{s=0.0}I(s!=0.0){I(a==2f){h=(c-d)/2S}1i{I(c==2f){h=2.0+(d-a)/2S}1i{I(d==2f){h=4.0+(a-c)/2S}}}}1i{h=-1.0}h=h*60;I(h<0.0){h=h+3D.0}f[\'h\']=1a.1r(h);f[\'s\']=1a.1r(s*1g/1B);f[\'v\']=1a.1r(b*1g/1B);I(f[\'h\']>3D){f[\'h\']=3D}I(f[\'s\']>1g){f[\'s\']=1g}I(f[\'v\']>1g){f[\'v\']=1g}2h f};J 3e(r,g,b){O a=1t 2B();a[0]=r;a[1]=g;a[2]=b;O c=[\'0\',\'1\',\'2\',\'3\',\'4\',\'5\',\'6\',\'7\',\'8\',\'9\',\'a\',\'b\',\'c\',\'d\',\'e\',\'f\'];O d=\'\';33(O i=0;i<a.29;i++){47=4H(a[i]);d+=c[4H(47/16)]+c[47%16]}2h d};J 2C(){H(1N).N(\'Q\',1s.Q+\'X\').N(\'10\',(1s.10+S)+\'X\');H(2A).N(\'Q\',(1C.Q+1a.1r(1n*1.3)-4)+\'X\').N(\'10\',(1C.10+H(2K).W()-4-1a.1r(1o*1.3))+\'X\')};J 3f(){H(2K).N(\'M-1A\',\'#\'+2Q(-1*(S-1v)*3,1g,1g,\'3i\'));H(2j).N(\'M-1A\',\'#\'+2Q(-1*(S-1v)*3,1n,1o,\'3i\')).N(\'M-21\',\'12\');H(1y).N(\'M\',\'1c(\'+U+\'1O.1e) 0 0 1q-Y\')};1p(J(){32=H(1d).1U()},5E);J 4I(){O b=-1*C.4c*20;O c=\'<K 1k="5F" V="Z:5G;W:5H;1D:Q;M:12;T:1u 1V \'+C.26+\';18:0;19:0;\'+u+\'"><K 1k="4J" V="Z:5I;W:5J;T:1u 1V 3V;1D:Q;19:0;18:0;\'+u+\'"></K></K>\';3A();H(\'1h\').4q(\'<K V="1Z:12;Z:4K;W:4L;1I:39;4M:41;19:0;18:0;\'+3t+2g+\'" 1k="3E"><K 1k="5K" V="W:3F;Z:5L;18:0;19:1M 5M 1M 1M;1D:Q;4M:41;M-1A:\'+C.4i+\';T:1u 1V \'+C.26+\';\'+2V+3t+\'"><K 1k="5N" V="Z:3F;W:3F;1D:Q;M:12;19:0;18:0;T:12;"><K 1k="4N" V="Z:4O;W:4O;T:5O 1V \'+C.4g+\';19:0;18:0;\'+u+\'"><K V="Z:3G;W:3G;1D:Q;M-21:1c(\'+U+\'4n.2b);M-1I:0 0;M-Y:1q-Y;T:1u 1V 3V;19:0;18:0;"></K></K></K><K 1k="5P" V="Z:2D;W:3G;1D:Q;19:2G 5Q 3c 1M;18:0;T:12;"><K 1k="4P" V="Z:2D;W:3G;1D:Q;M:1c(\'+U+\'S.2b) \'+b+\'X 0 1q-Y;18:0;19:0;T:12;"></K></K><K 1k="5R" V="1D:Q;1m-1H:1M;1m-3j: 3k, 3l, 3m, 3n-3o;Z:4Q;W:3F;18:0;19:0;T:12;">\'+c+\'<K 2c="3H" V="1D:Q;19:4R 0 0 0;18:0;T:12;"><b V="1Z:35-36;Z:23;1K-2t:Q;1m-1H:1M;1m-3j: 3k, 3l, 3m, 3n-3o;1m-3I:3J;1A:\'+C.2Y+\';2n-W:23;">R</b><1J V="2n-W:23;19:1u 0;18:0;1A:\'+C.2W+\';T:1u 1V \'+C.26+\';M:\'+C.2X+\';Z:3K;1m-1H:1M;1K-2t:3L;\'+2o+\'" 1k="4S" 2c="3p 2T" 37="1K" 1H="3" 3M="3" /></K><K 2c="3H" V="1D:Q;19:2N 0 0 0;18:0;T:12;"><b V="1Z:35-36;Z:23;1K-2t:Q;1m-1H:1M;1m-3j: 3k, 3l, 3m, 3n-3o;1m-3I:3J;1A:\'+C.2Y+\';2n-W:23;">G</b><1J V="2n-W:23;19:1u 0;18:0;1A:\'+C.2W+\';T:1u 1V \'+C.26+\';M:\'+C.2X+\';Z:3K;1m-1H:1M;1K-2t:3L;\'+2o+\'" 1k="4T" 2c="3p 2T" 37="1K" 1H="3" 3M="3" /></K><K 2c="3H" V="1D:Q;19:2N 0 0 0;18:0;T:12;"><b V="1Z:35-36;Z:23;1K-2t:Q;1m-1H:1M;1m-3j: 3k, 3l, 3m, 3n-3o;1m-3I:3J;1A:\'+C.2Y+\';2n-W:23;">B</b><1J V="19:1u 0;18:0;1A:\'+C.2W+\';T:1u 1V \'+C.26+\';M:\'+C.2X+\';Z:3K;1m-1H:1M;1K-2t:3L;\'+2o+\'" 1k="4U" 2c="3p 2T" 37="1K" 1H="3" 3M="3" /></K><K 2c="3H" V="1D:Q;19:4R 0;18:0;T:12;"><b V="1Z:35-36;Z:23;1K-2t:Q;1m-1H:1M;1m-3j: 3k, 3l, 3m, 3n-3o;1m-3I:3J;1A:\'+C.2Y+\';2n-W:23;">#</b><1J V="19:1u 0;18:0;1A:\'+C.2W+\';T:1u 1V \'+C.26+\';M:\'+C.2X+\';Z:3K;1m-1H:1M;1K-2t:3L;\'+2o+\'" 1k="4V" 2c="3p" 37="1K" 1H="6" 3M="6" /></K><K V="Z:4Q;W:2G;19:0;18:0;T:12;1D:Q;"><K 1k="4W" V="18:0;19:0;Z:3N;W:2G;1D:Q;38:3z;M-21:1c(\'+U+\'3Y.2b);M-1I: 0 0;M-Y:1q-Y;"></K><K 1k="4X" V="18:0;19:0;Z:2G;W:2G;1D:5S;38:3z;M-21:1c(\'+U+\'3Y.2b);M-1I: -3N 0;M-Y:1q-Y;"></K></K></K></K></K><K V="1Z:12;Z:48;W:48;1I:39;M: 1c(\'+U+\'4m.1e) \'+(-1*C.4e*11)+\'X 0 1q-Y;18:0;19:0;T:12;" 1k="2H"></K><K V="1Z:12;Z:2D;W:48;1I:39;M: 1c(\'+U+\'1N.1e) \'+(-1*C.4d*20)+\'X 0 1q-Y;18:0;19:0;T:12;38:n-5T;" 1k="2I"></K><K 1k="49" V="T:1u 1V \'+C.26+\';1Z:12;19:0;18:0;1m-1H:1u;2n-W:1u;Z:2D;W:5U;M:1c(\'+U+\'1O.1e) 0 0 1q-Y;1I:39;38:3z;\'+2o+\'"></K>\');32=H(1d).1U();14=H(\'1h > K#3E\').N(\'Q\',32.Q+\'X\').N(\'10\',(32.10+H(1d).34())+\'X\').2l(J(){1G(17);17=1p(J(){1w=1E},50)}).2m(J(){1G(17);17=1p(J(){1w=1F},50)});28=H(14).1z(\'1J#4V\');1y=H(\'1h > K#49\');1N=H(\'1h > K#2I\');2A=H(\'1h > K#2H\');3a(C.3W){1j\'4y\':H(14).N(\'Z\',\'3c\').N(\'W\',\'3c\').1L().4z({Z:\'4K\',W:\'4L\'},C.2v,J(){H(P).1L();H(\'1h > K#2I, 1h > K#2H\').1L();H(1y).1L()});1f;1j\'4A\':H(14).5V(C.2v,J(){H(P).1L();H(\'1h > K#2I, 1h > K#2H\').1L();H(1y).1L()});1f;1j\'4B\':H(\'1h > K#3E, 1h > K#2I, 1h > K#2H, 1h > K#49\').44(1,0,J(){H(P).1L().44(C.2v,1)});1f;4C:H(14).1L();H(1y).1L();H(\'1h > K#2I, 1h > K#2H\').1L();1f}2Z=H(14).1z(\'K#4P\');2K=H(14).1z(\'K#4N K\');2j=H(14).1z(\'#4J\');1R=H(14).1z(\'1J#4S\');1S=H(14).1z(\'1J#4T\');1T=H(14).1z(\'1J#4U\');31=H(14).1z(\'#4W\');3X=H(14).1z(\'#4X\');4k=H(14).1U();1C=H(2K).1U();1s=H(2Z).1U();H(1y).1W(J(){I(H.2p(H(1R).L())==\'\'&&H.2p(H(1S).L())==\'\'&&H.2p(H(1T).L())==\'\'){H(2j).N(\'M-21\',\'12\');H(P).N(\'M\',\'1c(\'+U+\'1O.1e) 0 0 1q-Y\');2E()}1i{H(2j).N(\'M-21\',\'1c(\'+U+\'2M.1e)\').N(\'M-Y\',\'Y\');H(14).1z(\'1J\').L(\'\');H(P).N(\'M\',\'1c(\'+U+\'1O.1e) -2D 0 1q-Y\')}}).N(\'Q\',(1s.Q-1)+\'X\').N(\'10\',(1s.10-15)+\'X\').2l(J(){1G(17);17=1p(J(){1w=1E},50)}).2m(J(){1G(17);17=1p(J(){1w=1F},50)});H(1N).2l(J(){1G(17);17=1p(J(){1w=1E},50)}).2m(J(){1G(17);17=1p(J(){1w=1F},50)});H(2A).2l(J(){1G(17);17=1p(J(){1w=1E},50)}).2m(J(){1G(17);17=1p(J(){1w=1F},50)}).5W(J(e){H(31).1W()});H(2A).3O(J(e){2y=H(P).1U();2J=e.2U-2y.Q;2x=e.24-2y.10;j=P;H(1y).N(\'M\',\'1c(\'+U+\'1O.1e) 0 0 1q-Y\');e.25()}).1W(J(e){});H(1N).3O(J(e){2z=H(P).1U();2J=e.2U-2z.Q;2x=e.24-2z.10;1X=P;H(1y).N(\'M\',\'1c(\'+U+\'1O.1e) 0 0 1q-Y\');e.25()});H(2Z).3O(J(e){I(e.24>=(1s.10+5)&&e.24<=((1s.10+H(2Z).W())-6)){S=e.24-1s.10-5;I(S<0)S=0;I(S>1v)S=1v;H(1y).N(\'M\',\'1c(\'+U+\'1O.1e) 0 0 1q-Y\');2C();3f();2E();2z=H(1N).1U();2J=e.2U-2z.Q;2x=e.24-2z.10;1X=1N;e.25()}});H(2K).3O(J(e){1n=1a.1r((e.2U-1C.Q-1)/1.3);I(1n>1g){1n=1g}I(1n<1){1n=1}1o=-1*(1a.1r((e.24-1C.10-1)/1.3)-1g);I(1o>1g){1o=1g}I(1o<1){1o=1}H(1y).N(\'M\',\'1c(\'+U+\'1O.1e) 0 0 1q-Y\');2C();H(2j).N(\'M-1A\',\'#\'+2Q(-1*(S-1v)*3,1n,1o,\'3i\')).N(\'M-21\',\'12\');2E();j=2A;2y=H(j).1U();2J=e.2U-2y.Q;2x=e.24-2y.10;e.25()});H(14).1z(\'1J.3p\').5X(J(a){I(H(P).4a(\'2T\')){I(!((45.4Y(a.3P)*1)2O w)&&!(a.3P 2O z)){a.25()}}1i{I(!(45.4Y(a.3P)2O y)&&!(a.3P 2O z)){a.25()}}}).5Y(J(){I(H(P).4a(\'2T\')){I(H(P).L()==\'\'){H(P).L(\'0\')}I(4b(H(P).L()*1)){H(P).L(\'0\')}I(H(P).L()*1>1B){H(P).L(\'1B\')}I(H(P).L()*1<0){H(P).L(\'0\')}3C()}1i{2P()}}).4Z(J(){I(H(P).4a(\'2T\')){I(H(P).L()==\'\'){H(P).L(\'0\')}I(4b(H(P).L()*1)){H(P).L(\'0\')}I(H(P).L()*1>1B){H(P).L(\'1B\')}I(H(P).L()*1<0){H(P).L(\'0\')}3C()}1i{2P()}});28[0].3Q=28[0].3R=J(e){1G(30);30=1p(J(){2P()},1g)};1R[0].3Q=1R[0].3R=1S[0].3Q=1S[0].3R=1T[0].3Q=1T[0].3R=J(e){I(H(P).L()==\'\'){H(P).L(\'0\')}I(4b(H(P).L()*1)){H(P).L(\'0\')}I(H(P).L()*1>1B){H(P).L(\'1B\')}I(H(P).L()*1<0){H(P).L(\'0\')}1G(30);30=1p(J(){3C()},1g)};H(31).1W(J(){3s=1E;3b()}).2l(J(){H(P).N(\'M-1I\',\'0 -2G\')}).2m(J(){H(P).N(\'M-1I\',\'0 0\')});H(3X).1W(J(){3b()}).2l(J(){H(P).N(\'M-1I\',\'-3N -2G\')}).2m(J(){H(P).N(\'M-1I\',\'-3N 0\')});2C();H(28).L(1b);2P();2L=1E;I(1b==\'\'){H(1y).N(\'M\',\'1c(\'+U+\'1O.1e) -2D 0 1q-Y\')}1i{H(1y).N(\'M\',\'1c(\'+U+\'1O.1e) 0 0 1q-Y\')}};H(5Z).61(J(e){j=\'2i\';1X=\'2i\'}).62(J(e){I(j!=\'2i\'){e.25();O a=0,2u=0;a=e.2U-2J;I(a<(1C.Q-4)){a=1C.Q-4}I(a>(1C.Q+3S)){a=1C.Q+3S}2u=e.24-2x;I(2u<(1C.10-4)){2u=1C.10-4}I(2u>(1C.10+3S)){2u=1C.10+3S}H(j).N(\'Q\',a+\'X\').N(\'10\',2u+\'X\');1o=-1*(1a.1r((2u-1C.10+5)/1.3)-1g)+1;1n=1a.1r((a-1C.Q+5)/1.3);I(1o==1){1o=0}I(1n==1){1n=0}H(2j).N(\'M-1A\',\'#\'+2Q(-1*(S-1v)*3,1n,1o,\'3i\')).N(\'M-21\',\'12\');2E()}I(1X!=\'2i\'){e.25();S=e.24-1s.10-2x;I(S<0){S=0}I(S>1v){S=1v}H(1X).N(\'Q\',1s.Q+\'X\').N(\'10\',(1s.10+S)+\'X\');3f();2E()}}).63(J(a){I(a.51==\'27\'){a.25();3b()}I(a.51==\'13\'){a.25();H(31).1W()}}).1W(J(){I(!1w){3b()}});H(1d).1W(J(){I(!2L){H(\'1h > K#2I, 1h > K#2H, 1h > K#3E\').64().2d();1p(J(){4I()},50)}}).4Z(J(){I(2L){3A();2E();2C();H(28).L(1b);2P()}});H(1Y).1W(J(){H(1d).1W()});I(C.4f){H(1Y).1W()}})};',62,377,'|||||||||||||||||||||||||||||||||||||||||||jQuery|if|function|div|val|background|css|var|this|left||hue|border|root_path|style|height|px|repeat|width|top||none||wrapper|||click_to|margin|padding|Math|inputhex|url|aitem|gif|break|100|body|else|case|id|hexistr|font|saturation|brightness|setTimeout|no|round|pos_huebox|new|1px|119|click_flag|parsex|switcher|find|color|255|pos_sbbox|float|true|false|clearTimeout|size|position|input|text|show|10px|slider|transp0|radius|7px|inp_r|inp_g|inp_b|offset|solid|click|moved_slider|isample|display||image|charAt|13px|pageY|preventDefault|border_color||inp_hex|length|src|png|class|remove|var_i|maxrgb|shadow|return|mel|colsample|Image|mouseenter|mouseleave|line|rad3px|trim|var_1|var_r|var_g|align|tty|anim_speed|shadow_size|correct_y|pos_sel|pos_slider|sb_sel|Array|init_positions|20px|update_inputs|var_b|15px|modcoder_picker|modcoder_slider|correct_x|sbbox|opened|transp|3px|in|hex_valid_and_draw|hsb2rgb_hex|indexOf|delta|modcoder_rgb|pageX|backlight|input_text_color|input_background_color|label_color|huebox|hexto|ok_but|aitem_pos|for|outerHeight|inline|block|type|cursor|absolute|switch|action_exit|0px|action_ok|rgb2hex|init_colors|var_2|var_3|hex|family|Verdana|Arial|Helvetica|Sans|serif|modcoder_input|black|shadow_color|userok|radwrap|5px|moz|webkit|ctrl|parent|pointer|init_color|rgb2hsv|draw_rgb|360|modcoder_colorpicker|140px|130px|modcoder_dataitem|weight|bold|49px|center|maxlength|47px|mousedown|which|onpaste|oninput|125|color_box|show_color_on_border|white|effect|close_but|ok|khtml|box|hidden|hex2rgb|120|fadeTo|String||dec|11px|modcoder_switcher|hasClass|isNaN|hue_bar|hue_slider|sb_slider|demo_mode|sb_border_color|round_corners|background_color|callback_on_ok|pos_wrap|split|sel|bg|shbg|span|append|readonly|mds|focus|00000|0000|000|00|zoom|animate|slide|fade|default|rgb|toUpperCase|min|max|parseInt|run_modcoder_colorpicker|modcoder_sample|265px|162px|overflow|modcoder_grad|132px|modcoder_hue|66px|6px|modcoder_r|modcoder_g|modcoder_b|modcoder_hex|modcoder_ok|modcoder_close|fromCharCode|keyup||keyCode|fn|modcoder_excolor|extend|slow|8a8a8a|silver|each|looper|script|attr|toLowerCase|jquery|modcoder|excolor|js|wrap|auto|system|keys|backspace|118|86|99|67|random|mc|nbsp|modcoder_excolor_clrbox|clone|addClass|visibility|appendTo|300|150|000000|slideUp|floor|0123456789ABCDEF|200|modcoder_sample_wrapper|62px|30px|60px|28px|modcoder_colorpicker_wrapper|244px|9px|modcoder_grad_wrap|4px|modcoder_hue_wrap|8px|modcoder_data|right|resize|12px|slideDown|dblclick|keypress|change|document||mouseup|mousemove|keydown|stop'.split('|'),0,{}))
/* This notice must be untouched at all times.
Copyright (c) 2002-2008 Walter Zorn. All rights reserved.

wz_tooltip.js	 v. 5.31

The latest version is available at
http://www.walterzorn.com
or http://www.devira.com
or http://www.walterzorn.de

Created 1.12.2002 by Walter Zorn (Web: http://www.walterzorn.com )
Last modified: 7.11.2008

Easy-to-use cross-browser tooltips.
Just include the script at the beginning of the <body> section, and invoke
Tip('Tooltip text') to show and UnTip() to hide the tooltip, from the desired
HTML eventhandlers. Example:
<a onmouseover="Tip('Some text')" onmouseout="UnTip()" href="index.htm">My home page</a>
No container DIV required.
By default, width and height of tooltips are automatically adapted to content.
Is even capable of dynamically converting arbitrary HTML elements to tooltips
by calling TagToTip('ID_of_HTML_element_to_be_converted') instead of Tip(),
which means you can put important, search-engine-relevant stuff into tooltips.
Appearance & behaviour of tooltips can be individually configured
via commands passed to Tip() or TagToTip().

Tab Width: 4
LICENSE: LGPL

This library is free software; you can redistribute it and/or
modify it under the terms of the GNU Lesser General Public
License (LGPL) as published by the Free Software Foundation; either
version 2.1 of the License, or (at your option) any later version.

This library is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.

For more details on the GNU Lesser General Public License,
see http://www.gnu.org/copyleft/lesser.html
*/

var config = new Object();


//===================  GLOBAL TOOLTIP CONFIGURATION  =========================//
var tt_Debug	= true		// false or true - recommended: false once you release your page to the public
var tt_Enabled	= true		// Allows to (temporarily) suppress tooltips, e.g. by providing the user with a button that sets this global variable to false
var TagsToTip	= true		// false or true - if true, HTML elements to be converted to tooltips via TagToTip() are automatically hidden;
							// if false, you should hide those HTML elements yourself

// For each of the following config variables there exists a command, which is
// just the variablename in uppercase, to be passed to Tip() or TagToTip() to
// configure tooltips individually. Individual commands override global
// configuration. Order of commands is arbitrary.
// Example: onmouseover="Tip('Tooltip text', LEFT, true, BGCOLOR, '#FF9900', FADEIN, 400)"

config. Above			= false		// false or true - tooltip above mousepointer
config. BgColor			= '#E2E7FF'	// Background colour (HTML colour value, in quotes)
config. BgImg			= ''		// Path to background image, none if empty string ''
config. BorderColor		= '#003099'
config. BorderStyle		= 'solid'	// Any permitted CSS value, but I recommend 'solid', 'dotted' or 'dashed'
config. BorderWidth		= 1
config. CenterMouse		= false		// false or true - center the tip horizontally below (or above) the mousepointer
config. ClickClose		= false		// false or true - close tooltip if the user clicks somewhere
config. ClickSticky		= false		// false or true - make tooltip sticky if user left-clicks on the hovered element while the tooltip is active
config. CloseBtn		= false		// false or true - closebutton in titlebar
config. CloseBtnColors	= ['#990000', '#FFFFFF', '#DD3333', '#FFFFFF']	// [Background, text, hovered background, hovered text] - use empty strings '' to inherit title colours
config. CloseBtnText	= '&nbsp;X&nbsp;'	// Close button text (may also be an image tag)
config. CopyContent		= true		// When converting a HTML element to a tooltip, copy only the element's content, rather than converting the element by its own
config. Delay			= 400		// Time span in ms until tooltip shows up
config. Duration		= 0			// Time span in ms after which the tooltip disappears; 0 for infinite duration, < 0 for delay in ms _after_ the onmouseout until the tooltip disappears
config. Exclusive		= false		// false or true - no other tooltip can appear until the current one has actively been closed
config. FadeIn			= 100		// Fade-in duration in ms, e.g. 400; 0 for no animation
config. FadeOut			= 100
config. FadeInterval	= 30		// Duration of each fade step in ms (recommended: 30) - shorter is smoother but causes more CPU-load
config. Fix				= null		// Fixated position, two modes. Mode 1: x- an y-coordinates in brackets, e.g. [210, 480]. Mode 2: Show tooltip at a position related to an HTML element: [ID of HTML element, x-offset, y-offset from HTML element], e.g. ['SomeID', 10, 30]. Value null (default) for no fixated positioning.
config. FollowMouse		= true		// false or true - tooltip follows the mouse
config. FontColor		= '#000044'
config. FontFace		= 'Verdana,Geneva,sans-serif'
config. FontSize		= '8pt'		// E.g. '9pt' or '12px' - unit is mandatory
config. FontWeight		= 'normal'	// 'normal' or 'bold';
config. Height			= 0			// Tooltip height; 0 for automatic adaption to tooltip content, < 0 (e.g. -100) for a maximum for automatic adaption
config. JumpHorz		= false		// false or true - jump horizontally to other side of mouse if tooltip would extend past clientarea boundary
config. JumpVert		= true		// false or true - jump vertically		"
config. Left			= false		// false or true - tooltip on the left of the mouse
config. OffsetX			= 14		// Horizontal offset of left-top corner from mousepointer
config. OffsetY			= 8			// Vertical offset
config. Opacity			= 100		// Integer between 0 and 100 - opacity of tooltip in percent
config. Padding			= 3			// Spacing between border and content
config. Shadow			= false		// false or true
config. ShadowColor		= '#C0C0C0'
config. ShadowWidth		= 5
config. Sticky			= false		// false or true - fixate tip, ie. don't follow the mouse and don't hide on mouseout
config. TextAlign		= 'left'	// 'left', 'right' or 'justify'
config. Title			= ''		// Default title text applied to all tips (no default title: empty string '')
config. TitleAlign		= 'left'	// 'left' or 'right' - text alignment inside the title bar
config. TitleBgColor	= ''		// If empty string '', BorderColor will be used
config. TitleFontColor	= '#FFFFFF'	// Color of title text - if '', BgColor (of tooltip body) will be used
config. TitleFontFace	= ''		// If '' use FontFace (boldified)
config. TitleFontSize	= ''		// If '' use FontSize
config. TitlePadding	= 2
config. Width			= 0			// Tooltip width; 0 for automatic adaption to tooltip content; < -1 (e.g. -240) for a maximum width for that automatic adaption;
									// -1: tooltip width confined to the width required for the titlebar
//=======  END OF TOOLTIP CONFIG, DO NOT CHANGE ANYTHING BELOW  ==============//




//=====================  PUBLIC  =============================================//
function Tip()
{
	tt_Tip(arguments, null);
}
function TagToTip()
{
	var t2t = tt_GetElt(arguments[0]);
	if(t2t)
		tt_Tip(arguments, t2t);
}
function UnTip()
{
	tt_OpReHref();
	if(tt_aV[DURATION] < 0 && (tt_iState & 0x2))
		tt_tDurt.Timer("tt_HideInit()", -tt_aV[DURATION], true);
	else if(!(tt_aV[STICKY] && (tt_iState & 0x2)))
		tt_HideInit();
}

//==================  PUBLIC PLUGIN API	 =====================================//
// Extension eventhandlers currently supported:
// OnLoadConfig, OnCreateContentString, OnSubDivsCreated, OnShow, OnMoveBefore,
// OnMoveAfter, OnHideInit, OnHide, OnKill

var tt_aElt = new Array(10), // Container DIV, outer title & body DIVs, inner title & body TDs, closebutton SPAN, shadow DIVs, and IFRAME to cover windowed elements in IE
tt_aV = new Array(),	// Caches and enumerates config data for currently active tooltip
tt_sContent,			// Inner tooltip text or HTML
tt_t2t, tt_t2tDad,		// Tag converted to tip, and its DOM parent element
tt_musX, tt_musY,
tt_over,
tt_x, tt_y, tt_w, tt_h; // Position, width and height of currently displayed tooltip

function tt_Extension()
{
	tt_ExtCmdEnum();
	tt_aExt[tt_aExt.length] = this;
	return this;
}
function tt_SetTipPos(x, y)
{
	var css = tt_aElt[0].style;

	tt_x = x;
	tt_y = y;
	css.left = x + "px";
	css.top = y + "px";
	if(tt_ie56)
	{
		var ifrm = tt_aElt[tt_aElt.length - 1];
		if(ifrm)
		{
			ifrm.style.left = css.left;
			ifrm.style.top = css.top;
		}
	}
}
function tt_HideInit()
{
	if(tt_iState)
	{
		tt_ExtCallFncs(0, "HideInit");
		tt_iState &= ~(0x4 | 0x8);
		if(tt_flagOpa && tt_aV[FADEOUT])
		{
			tt_tFade.EndTimer();
			if(tt_opa)
			{
				var n = Math.round(tt_aV[FADEOUT] / (tt_aV[FADEINTERVAL] * (tt_aV[OPACITY] / tt_opa)));
				tt_Fade(tt_opa, tt_opa, 0, n);
				return;
			}
		}
		tt_tHide.Timer("tt_Hide();", 1, false);
	}
}
function tt_Hide()
{
	if(tt_db && tt_iState)
	{
		tt_OpReHref();
		if(tt_iState & 0x2)
		{
			tt_aElt[0].style.visibility = "hidden";
			tt_ExtCallFncs(0, "Hide");
		}
		tt_tShow.EndTimer();
		tt_tHide.EndTimer();
		tt_tDurt.EndTimer();
		tt_tFade.EndTimer();
		if(!tt_op && !tt_ie)
		{
			tt_tWaitMov.EndTimer();
			tt_bWait = false;
		}
		if(tt_aV[CLICKCLOSE] || tt_aV[CLICKSTICKY])
			tt_RemEvtFnc(document, "mouseup", tt_OnLClick);
		tt_ExtCallFncs(0, "Kill");
		// In case of a TagToTip tip, hide converted DOM node and
		// re-insert it into DOM
		if(tt_t2t && !tt_aV[COPYCONTENT])
			tt_UnEl2Tip();
		tt_iState = 0;
		tt_over = null;
		tt_ResetMainDiv();
		if(tt_aElt[tt_aElt.length - 1])
			tt_aElt[tt_aElt.length - 1].style.display = "none";
	}
}
function tt_GetElt(id)
{
	return(document.getElementById ? document.getElementById(id)
			: document.all ? document.all[id]
			: null);
}
function tt_GetDivW(el)
{
	return(el ? (el.offsetWidth || el.style.pixelWidth || 0) : 0);
}
function tt_GetDivH(el)
{
	return(el ? (el.offsetHeight || el.style.pixelHeight || 0) : 0);
}
function tt_GetScrollX()
{
	return(window.pageXOffset || (tt_db ? (tt_db.scrollLeft || 0) : 0));
}
function tt_GetScrollY()
{
	return(window.pageYOffset || (tt_db ? (tt_db.scrollTop || 0) : 0));
}
function tt_GetClientW()
{
	return tt_GetWndCliSiz("Width");
}
function tt_GetClientH()
{
	return tt_GetWndCliSiz("Height");
}
function tt_GetEvtX(e)
{
	return (e ? ((typeof(e.pageX) != tt_u) ? e.pageX : (e.clientX + tt_GetScrollX())) : 0);
}
function tt_GetEvtY(e)
{
	return (e ? ((typeof(e.pageY) != tt_u) ? e.pageY : (e.clientY + tt_GetScrollY())) : 0);
}
function tt_AddEvtFnc(el, sEvt, PFnc)
{
	if(el)
	{
		if(el.addEventListener)
			el.addEventListener(sEvt, PFnc, false);
		else
			el.attachEvent("on" + sEvt, PFnc);
	}
}
function tt_RemEvtFnc(el, sEvt, PFnc)
{
	if(el)
	{
		if(el.removeEventListener)
			el.removeEventListener(sEvt, PFnc, false);
		else
			el.detachEvent("on" + sEvt, PFnc);
	}
}
function tt_GetDad(el)
{
	return(el.parentNode || el.parentElement || el.offsetParent);
}
function tt_MovDomNode(el, dadFrom, dadTo)
{
	if(dadFrom)
		dadFrom.removeChild(el);
	if(dadTo)
		dadTo.appendChild(el);
}

//======================  PRIVATE  ===========================================//
var tt_aExt = new Array(),	// Array of extension objects

tt_db, tt_op, tt_ie, tt_ie56, tt_bBoxOld,	// Browser flags
tt_body,
tt_ovr_,				// HTML element the mouse is currently over
tt_flagOpa,				// Opacity support: 1=IE, 2=Khtml, 3=KHTML, 4=Moz, 5=W3C
tt_maxPosX, tt_maxPosY,
tt_iState = 0,			// Tooltip active |= 1, shown |= 2, move with mouse |= 4, exclusive |= 8
tt_opa,					// Currently applied opacity
tt_bJmpVert, tt_bJmpHorz,// Tip temporarily on other side of mouse
tt_elDeHref,			// The tag from which we've removed the href attribute
// Timer
tt_tShow = new Number(0), tt_tHide = new Number(0), tt_tDurt = new Number(0),
tt_tFade = new Number(0), tt_tWaitMov = new Number(0),
tt_bWait = false,
tt_u = "undefined";


function tt_Init()
{
	tt_MkCmdEnum();
	// Send old browsers instantly to hell
	if(!tt_Browser() || !tt_MkMainDiv())
		return;
	tt_IsW3cBox();
	tt_OpaSupport();
	tt_AddEvtFnc(document, "mousemove", tt_Move);
	// In Debug mode we search for TagToTip() calls in order to notify
	// the user if they've forgotten to set the TagsToTip config flag
	if(TagsToTip || tt_Debug)
		tt_SetOnloadFnc();
	// Ensure the tip be hidden when the page unloads
	tt_AddEvtFnc(window, "unload", tt_Hide);
}
// Creates command names by translating config variable names to upper case
function tt_MkCmdEnum()
{
	var n = 0;
	for(var i in config)
		eval("window." + i.toString().toUpperCase() + " = " + n++);
	tt_aV.length = n;
}
function tt_Browser()
{
	var n, nv, n6, w3c;

	n = navigator.userAgent.toLowerCase(),
	nv = navigator.appVersion;
	tt_op = (document.defaultView && typeof(eval("w" + "indow" + "." + "o" + "p" + "er" + "a")) != tt_u);
	tt_ie = n.indexOf("msie") != -1 && document.all && !tt_op;
	if(tt_ie)
	{
		var ieOld = (!document.compatMode || document.compatMode == "BackCompat");
		tt_db = !ieOld ? document.documentElement : (document.body || null);
		if(tt_db)
			tt_ie56 = parseFloat(nv.substring(nv.indexOf("MSIE") + 5)) >= 5.5
					&& typeof document.body.style.maxHeight == tt_u;
	}
	else
	{
		tt_db = document.documentElement || document.body ||
				(document.getElementsByTagName ? document.getElementsByTagName("body")[0]
				: null);
		if(!tt_op)
		{
			n6 = document.defaultView && typeof document.defaultView.getComputedStyle != tt_u;
			w3c = !n6 && document.getElementById;
		}
	}
	tt_body = (document.getElementsByTagName ? document.getElementsByTagName("body")[0]
				: (document.body || null));
	if(tt_ie || n6 || tt_op || w3c)
	{
		if(tt_body && tt_db)
		{
			if(document.attachEvent || document.addEventListener)
				return true;
		}
		else
			tt_Err("wz_tooltip.js must be included INSIDE the body section,"
					+ " immediately after the opening <body> tag.", false);
	}
	tt_db = null;
	return false;
}
function tt_MkMainDiv()
{
	// Create the tooltip DIV
	if(tt_body.insertAdjacentHTML)
		tt_body.insertAdjacentHTML("afterBegin", tt_MkMainDivHtm());
	else if(typeof tt_body.innerHTML != tt_u && document.createElement && tt_body.appendChild)
		tt_body.appendChild(tt_MkMainDivDom());
	if(window.tt_GetMainDivRefs /* FireFox Alzheimer */ && tt_GetMainDivRefs())
		return true;
	tt_db = null;
	return false;
}
function tt_MkMainDivHtm()
{
	return(
		'<div id="WzTtDiV"></div>' +
		(tt_ie56 ? ('<iframe id="WzTtIfRm" src="javascript:false" scrolling="no" frameborder="0" style="filter:Alpha(opacity=0);position:absolute;top:0px;left:0px;display:none;"></iframe>')
		: '')
	);
}
function tt_MkMainDivDom()
{
	var el = document.createElement("div");
	if(el)
		el.id = "WzTtDiV";
	return el;
}
function tt_GetMainDivRefs()
{
	tt_aElt[0] = tt_GetElt("WzTtDiV");
	if(tt_ie56 && tt_aElt[0])
	{
		tt_aElt[tt_aElt.length - 1] = tt_GetElt("WzTtIfRm");
		if(!tt_aElt[tt_aElt.length - 1])
			tt_aElt[0] = null;
	}
	if(tt_aElt[0])
	{
		var css = tt_aElt[0].style;

		css.visibility = "hidden";
		css.position = "absolute";
		css.overflow = "hidden";
		return true;
	}
	return false;
}
function tt_ResetMainDiv()
{
	tt_SetTipPos(0, 0);
	tt_aElt[0].innerHTML = "";
	tt_aElt[0].style.width = "0px";
	tt_h = 0;
}
function tt_IsW3cBox()
{
	var css = tt_aElt[0].style;

	css.padding = "10px";
	css.width = "40px";
	tt_bBoxOld = (tt_GetDivW(tt_aElt[0]) == 40);
	css.padding = "0px";
	tt_ResetMainDiv();
}
function tt_OpaSupport()
{
	var css = tt_body.style;

	tt_flagOpa = (typeof(css.KhtmlOpacity) != tt_u) ? 2
				: (typeof(css.KHTMLOpacity) != tt_u) ? 3
				: (typeof(css.MozOpacity) != tt_u) ? 4
				: (typeof(css.opacity) != tt_u) ? 5
				: (typeof(css.filter) != tt_u) ? 1
				: 0;
}
// Ported from http://dean.edwards.name/weblog/2006/06/again/
// (Dean Edwards et al.)
function tt_SetOnloadFnc()
{
	tt_AddEvtFnc(document, "DOMContentLoaded", tt_HideSrcTags);
	tt_AddEvtFnc(window, "load", tt_HideSrcTags);
	if(tt_body.attachEvent)
		tt_body.attachEvent("onreadystatechange",
			function() {
				if(tt_body.readyState == "complete")
					tt_HideSrcTags();
			} );
	if(/WebKit|KHTML/i.test(navigator.userAgent))
	{
		var t = setInterval(function() {
					if(/loaded|complete/.test(document.readyState))
					{
						clearInterval(t);
						tt_HideSrcTags();
					}
				}, 10);
	}
}
function tt_HideSrcTags()
{
	if(!window.tt_HideSrcTags || window.tt_HideSrcTags.done)
		return;
	window.tt_HideSrcTags.done = true;
	if(!tt_HideSrcTagsRecurs(tt_body))
		tt_Err("There are HTML elements to be converted to tooltips.\nIf you"
				+ " want these HTML elements to be automatically hidden, you"
				+ " must edit wz_tooltip.js, and set TagsToTip in the global"
				+ " tooltip configuration to true.", true);
}
function tt_HideSrcTagsRecurs(dad)
{
	var ovr, asT2t;
	// Walk the DOM tree for tags that have an onmouseover or onclick attribute
	// containing a TagToTip('...') call.
	// (.childNodes first since .children is bugous in Safari)
	var a = dad.childNodes || dad.children || null;

	for(var i = a ? a.length : 0; i;)
	{--i;
		if(!tt_HideSrcTagsRecurs(a[i]))
			return false;
		ovr = a[i].getAttribute ? (a[i].getAttribute("onmouseover") || a[i].getAttribute("onclick"))
				: (typeof a[i].onmouseover == "function") ? (a[i].onmouseover || a[i].onclick)
				: null;
		if(ovr)
		{
			asT2t = ovr.toString().match(/TagToTip\s*\(\s*'[^'.]+'\s*[\),]/);
			if(asT2t && asT2t.length)
			{
				if(!tt_HideSrcTag(asT2t[0]))
					return false;
			}
		}
	}
	return true;
}
function tt_HideSrcTag(sT2t)
{
	var id, el;

	// The ID passed to the found TagToTip() call identifies an HTML element
	// to be converted to a tooltip, so hide that element
	id = sT2t.replace(/.+'([^'.]+)'.+/, "$1");
	el = tt_GetElt(id);
	if(el)
	{
		if(tt_Debug && !TagsToTip)
			return false;
		else
			el.style.display = "none";
	}
	else
		tt_Err("Invalid ID\n'" + id + "'\npassed to TagToTip()."
				+ " There exists no HTML element with that ID.", true);
	return true;
}
function tt_Tip(arg, t2t)
{
	if(!tt_db || (tt_iState & 0x8))
		return;
	if(tt_iState)
		tt_Hide();
	if(!tt_Enabled)
		return;
	tt_t2t = t2t;
	if(!tt_ReadCmds(arg))
		return;
	tt_iState = 0x1 | 0x4;
	tt_AdaptConfig1();
	tt_MkTipContent(arg);
	tt_MkTipSubDivs();
	tt_FormatTip();
	tt_bJmpVert = false;
	tt_bJmpHorz = false;
	tt_maxPosX = tt_GetClientW() + tt_GetScrollX() - tt_w - 1;
	tt_maxPosY = tt_GetClientH() + tt_GetScrollY() - tt_h - 1;
	tt_AdaptConfig2();
	// Ensure the tip be shown and positioned before the first onmousemove
	tt_OverInit();
	tt_ShowInit();
	tt_Move();
}
function tt_ReadCmds(a)
{
	var i;

	// First load the global config values, to initialize also values
	// for which no command is passed
	i = 0;
	for(var j in config)
		tt_aV[i++] = config[j];
	// Then replace each cached config value for which a command is
	// passed (ensure the # of command args plus value args be even)
	if(a.length & 1)
	{
		for(i = a.length - 1; i > 0; i -= 2)
			tt_aV[a[i - 1]] = a[i];
		return true;
	}
	tt_Err("Incorrect call of Tip() or TagToTip().\n"
			+ "Each command must be followed by a value.", true);
	return false;
}
function tt_AdaptConfig1()
{
	tt_ExtCallFncs(0, "LoadConfig");
	// Inherit unspecified title formattings from body
	if(!tt_aV[TITLEBGCOLOR].length)
		tt_aV[TITLEBGCOLOR] = tt_aV[BORDERCOLOR];
	if(!tt_aV[TITLEFONTCOLOR].length)
		tt_aV[TITLEFONTCOLOR] = tt_aV[BGCOLOR];
	if(!tt_aV[TITLEFONTFACE].length)
		tt_aV[TITLEFONTFACE] = tt_aV[FONTFACE];
	if(!tt_aV[TITLEFONTSIZE].length)
		tt_aV[TITLEFONTSIZE] = tt_aV[FONTSIZE];
	if(tt_aV[CLOSEBTN])
	{
		// Use title colours for non-specified closebutton colours
		if(!tt_aV[CLOSEBTNCOLORS])
			tt_aV[CLOSEBTNCOLORS] = new Array("", "", "", "");
		for(var i = 4; i;)
		{--i;
			if(!tt_aV[CLOSEBTNCOLORS][i].length)
				tt_aV[CLOSEBTNCOLORS][i] = (i & 1) ? tt_aV[TITLEFONTCOLOR] : tt_aV[TITLEBGCOLOR];
		}
		// Enforce titlebar be shown
		if(!tt_aV[TITLE].length)
			tt_aV[TITLE] = " ";
	}
	// Circumvents broken display of images and fade-in flicker in Geckos < 1.8
	if(tt_aV[OPACITY] == 100 && typeof tt_aElt[0].style.MozOpacity != tt_u && !Array.every)
		tt_aV[OPACITY] = 99;
	// Smartly shorten the delay for fade-in tooltips
	if(tt_aV[FADEIN] && tt_flagOpa && tt_aV[DELAY] > 100)
		tt_aV[DELAY] = Math.max(tt_aV[DELAY] - tt_aV[FADEIN], 100);
}
function tt_AdaptConfig2()
{
	if(tt_aV[CENTERMOUSE])
	{
		tt_aV[OFFSETX] -= ((tt_w - (tt_aV[SHADOW] ? tt_aV[SHADOWWIDTH] : 0)) >> 1);
		tt_aV[JUMPHORZ] = false;
	}
}
// Expose content globally so extensions can modify it
function tt_MkTipContent(a)
{
	if(tt_t2t)
	{
		if(tt_aV[COPYCONTENT])
			tt_sContent = tt_t2t.innerHTML;
		else
			tt_sContent = "";
	}
	else
		tt_sContent = a[0];
	tt_ExtCallFncs(0, "CreateContentString");
}
function tt_MkTipSubDivs()
{
	var sCss = 'position:relative;margin:0px;padding:0px;border-width:0px;left:0px;top:0px;line-height:normal;width:auto;',
	sTbTrTd = ' cellspacing="0" cellpadding="0" border="0" style="' + sCss + '"><tbody style="' + sCss + '"><tr><td ';

	tt_aElt[0].style.width = tt_GetClientW() + "px";
	tt_aElt[0].innerHTML =
		(''
		+ (tt_aV[TITLE].length ?
			('<div id="WzTiTl" style="position:relative;z-index:1;">'
			+ '<table id="WzTiTlTb"' + sTbTrTd + 'id="WzTiTlI" style="' + sCss + '">'
			+ tt_aV[TITLE]
			+ '</td>'
			+ (tt_aV[CLOSEBTN] ?
				('<td align="right" style="' + sCss
				+ 'text-align:right;">'
				+ '<span id="WzClOsE" style="position:relative;left:2px;padding-left:2px;padding-right:2px;'
				+ 'cursor:' + (tt_ie ? 'hand' : 'pointer')
				+ ';" onmouseover="tt_OnCloseBtnOver(1)" onmouseout="tt_OnCloseBtnOver(0)" onclick="tt_HideInit()">'
				+ tt_aV[CLOSEBTNTEXT]
				+ '</span></td>')
				: '')
			+ '</tr></tbody></table></div>')
			: '')
		+ '<div id="WzBoDy" style="position:relative;z-index:0;">'
		+ '<table' + sTbTrTd + 'id="WzBoDyI" style="' + sCss + '">'
		+ tt_sContent
		+ '</td></tr></tbody></table></div>'
		+ (tt_aV[SHADOW]
			? ('<div id="WzTtShDwR" style="position:absolute;overflow:hidden;"></div>'
				+ '<div id="WzTtShDwB" style="position:relative;overflow:hidden;"></div>')
			: '')
		);
	tt_GetSubDivRefs();
	// Convert DOM node to tip
	if(tt_t2t && !tt_aV[COPYCONTENT])
		tt_El2Tip();
	tt_ExtCallFncs(0, "SubDivsCreated");
}
function tt_GetSubDivRefs()
{
	var aId = new Array("WzTiTl", "WzTiTlTb", "WzTiTlI", "WzClOsE", "WzBoDy", "WzBoDyI", "WzTtShDwB", "WzTtShDwR");

	for(var i = aId.length; i; --i)
		tt_aElt[i] = tt_GetElt(aId[i - 1]);
}
function tt_FormatTip()
{
	var css, w, h, pad = tt_aV[PADDING], padT, wBrd = tt_aV[BORDERWIDTH],
	iOffY, iOffSh, iAdd = (pad + wBrd) << 1;

	//--------- Title DIV ----------
	if(tt_aV[TITLE].length)
	{
		padT = tt_aV[TITLEPADDING];
		css = tt_aElt[1].style;
		css.background = tt_aV[TITLEBGCOLOR];
		css.paddingTop = css.paddingBottom = padT + "px";
		css.paddingLeft = css.paddingRight = (padT + 2) + "px";
		css = tt_aElt[3].style;
		css.color = tt_aV[TITLEFONTCOLOR];
		if(tt_aV[WIDTH] == -1)
			css.whiteSpace = "nowrap";
		css.fontFamily = tt_aV[TITLEFONTFACE];
		css.fontSize = tt_aV[TITLEFONTSIZE];
		css.fontWeight = "bold";
		css.textAlign = tt_aV[TITLEALIGN];
		// Close button DIV
		if(tt_aElt[4])
		{
			css = tt_aElt[4].style;
			css.background = tt_aV[CLOSEBTNCOLORS][0];
			css.color = tt_aV[CLOSEBTNCOLORS][1];
			css.fontFamily = tt_aV[TITLEFONTFACE];
			css.fontSize = tt_aV[TITLEFONTSIZE];
			css.fontWeight = "bold";
		}
		if(tt_aV[WIDTH] > 0)
			tt_w = tt_aV[WIDTH];
		else
		{
			tt_w = tt_GetDivW(tt_aElt[3]) + tt_GetDivW(tt_aElt[4]);
			// Some spacing between title DIV and closebutton
			if(tt_aElt[4])
				tt_w += pad;
			// Restrict auto width to max width
			if(tt_aV[WIDTH] < -1 && tt_w > -tt_aV[WIDTH])
				tt_w = -tt_aV[WIDTH];
		}
		// Ensure the top border of the body DIV be covered by the title DIV
		iOffY = -wBrd;
	}
	else
	{
		tt_w = 0;
		iOffY = 0;
	}

	//-------- Body DIV ------------
	css = tt_aElt[5].style;
	css.top = iOffY + "px";
	if(wBrd)
	{
		css.borderColor = tt_aV[BORDERCOLOR];
		css.borderStyle = tt_aV[BORDERSTYLE];
		css.borderWidth = wBrd + "px";
	}
	if(tt_aV[BGCOLOR].length)
		css.background = tt_aV[BGCOLOR];
	if(tt_aV[BGIMG].length)
		css.backgroundImage = "url(" + tt_aV[BGIMG] + ")";
	css.padding = pad + "px";
	css.textAlign = tt_aV[TEXTALIGN];
	if(tt_aV[HEIGHT])
	{
		css.overflow = "auto";
		if(tt_aV[HEIGHT] > 0)
			css.height = (tt_aV[HEIGHT] + iAdd) + "px";
		else
			tt_h = iAdd - tt_aV[HEIGHT];
	}
	// TD inside body DIV
	css = tt_aElt[6].style;
	css.color = tt_aV[FONTCOLOR];
	css.fontFamily = tt_aV[FONTFACE];
	css.fontSize = tt_aV[FONTSIZE];
	css.fontWeight = tt_aV[FONTWEIGHT];
	css.textAlign = tt_aV[TEXTALIGN];
	if(tt_aV[WIDTH] > 0)
		w = tt_aV[WIDTH];
	// Width like title (if existent)
	else if(tt_aV[WIDTH] == -1 && tt_w)
		w = tt_w;
	else
	{
		// Measure width of the body's inner TD, as some browsers would expand
		// the container and outer body DIV to 100%
		w = tt_GetDivW(tt_aElt[6]);
		// Restrict auto width to max width
		if(tt_aV[WIDTH] < -1 && w > -tt_aV[WIDTH])
			w = -tt_aV[WIDTH];
	}
	if(w > tt_w)
		tt_w = w;
	tt_w += iAdd;

	//--------- Shadow DIVs ------------
	if(tt_aV[SHADOW])
	{
		tt_w += tt_aV[SHADOWWIDTH];
		iOffSh = Math.floor((tt_aV[SHADOWWIDTH] * 4) / 3);
		// Bottom shadow
		css = tt_aElt[7].style;
		css.top = iOffY + "px";
		css.left = iOffSh + "px";
		css.width = (tt_w - iOffSh - tt_aV[SHADOWWIDTH]) + "px";
		css.height = tt_aV[SHADOWWIDTH] + "px";
		css.background = tt_aV[SHADOWCOLOR];
		// Right shadow
		css = tt_aElt[8].style;
		css.top = iOffSh + "px";
		css.left = (tt_w - tt_aV[SHADOWWIDTH]) + "px";
		css.width = tt_aV[SHADOWWIDTH] + "px";
		css.background = tt_aV[SHADOWCOLOR];
	}
	else
		iOffSh = 0;

	//-------- Container DIV -------
	tt_SetTipOpa(tt_aV[FADEIN] ? 0 : tt_aV[OPACITY]);
	tt_FixSize(iOffY, iOffSh);
}
// Fixate the size so it can't dynamically change while the tooltip is moving.
function tt_FixSize(iOffY, iOffSh)
{
	var wIn, wOut, h, add, pad = tt_aV[PADDING], wBrd = tt_aV[BORDERWIDTH], i;

	tt_aElt[0].style.width = tt_w + "px";
	tt_aElt[0].style.pixelWidth = tt_w;
	wOut = tt_w - ((tt_aV[SHADOW]) ? tt_aV[SHADOWWIDTH] : 0);
	// Body
	wIn = wOut;
	if(!tt_bBoxOld)
		wIn -= (pad + wBrd) << 1;
	tt_aElt[5].style.width = wIn + "px";
	// Title
	if(tt_aElt[1])
	{
		wIn = wOut - ((tt_aV[TITLEPADDING] + 2) << 1);
		if(!tt_bBoxOld)
			wOut = wIn;
		tt_aElt[1].style.width = wOut + "px";
		tt_aElt[2].style.width = wIn + "px";
	}
	// Max height specified
	if(tt_h)
	{
		h = tt_GetDivH(tt_aElt[5]);
		if(h > tt_h)
		{
			if(!tt_bBoxOld)
				tt_h -= (pad + wBrd) << 1;
			tt_aElt[5].style.height = tt_h + "px";
		}
	}
	tt_h = tt_GetDivH(tt_aElt[0]) + iOffY;
	// Right shadow
	if(tt_aElt[8])
		tt_aElt[8].style.height = (tt_h - iOffSh) + "px";
	i = tt_aElt.length - 1;
	if(tt_aElt[i])
	{
		tt_aElt[i].style.width = tt_w + "px";
		tt_aElt[i].style.height = tt_h + "px";
	}
}
function tt_DeAlt(el)
{
	var aKid;

	if(el)
	{
		if(el.alt)
			el.alt = "";
		if(el.title)
			el.title = "";
		aKid = el.childNodes || el.children || null;
		if(aKid)
		{
			for(var i = aKid.length; i;)
				tt_DeAlt(aKid[--i]);
		}
	}
}
// This hack removes the native tooltips over links in Opera
function tt_OpDeHref(el)
{
	if(!tt_op)
		return;
	if(tt_elDeHref)
		tt_OpReHref();
	while(el)
	{
		if(el.hasAttribute && el.hasAttribute("href"))
		{
			el.t_href = el.getAttribute("href");
			el.t_stats = window.status;
			el.removeAttribute("href");
			el.style.cursor = "hand";
			tt_AddEvtFnc(el, "mousedown", tt_OpReHref);
			window.status = el.t_href;
			tt_elDeHref = el;
			break;
		}
		el = tt_GetDad(el);
	}
}
function tt_OpReHref()
{
	if(tt_elDeHref)
	{
		tt_elDeHref.setAttribute("href", tt_elDeHref.t_href);
		tt_RemEvtFnc(tt_elDeHref, "mousedown", tt_OpReHref);
		window.status = tt_elDeHref.t_stats;
		tt_elDeHref = null;
	}
}
function tt_El2Tip()
{
	var css = tt_t2t.style;

	// Store previous positioning
	tt_t2t.t_cp = css.position;
	tt_t2t.t_cl = css.left;
	tt_t2t.t_ct = css.top;
	tt_t2t.t_cd = css.display;
	// Store the tag's parent element so we can restore that DOM branch
	// when the tooltip is being hidden
	tt_t2tDad = tt_GetDad(tt_t2t);
	tt_MovDomNode(tt_t2t, tt_t2tDad, tt_aElt[6]);
	css.display = "block";
	css.position = "static";
	css.left = css.top = css.marginLeft = css.marginTop = "0px";
}
function tt_UnEl2Tip()
{
	// Restore positioning and display
	var css = tt_t2t.style;

	css.display = tt_t2t.t_cd;
	tt_MovDomNode(tt_t2t, tt_GetDad(tt_t2t), tt_t2tDad);
	css.position = tt_t2t.t_cp;
	css.left = tt_t2t.t_cl;
	css.top = tt_t2t.t_ct;
	tt_t2tDad = null;
}
function tt_OverInit()
{
	if(window.event)
		tt_over = window.event.target || window.event.srcElement;
	else
		tt_over = tt_ovr_;
	tt_DeAlt(tt_over);
	tt_OpDeHref(tt_over);
}
function tt_ShowInit()
{
	tt_tShow.Timer("tt_Show()", tt_aV[DELAY], true);
	if(tt_aV[CLICKCLOSE] || tt_aV[CLICKSTICKY])
		tt_AddEvtFnc(document, "mouseup", tt_OnLClick);
}
function tt_Show()
{
	var css = tt_aElt[0].style;

	// Override the z-index of the topmost wz_dragdrop.js D&D item
	css.zIndex = Math.max((window.dd && dd.z) ? (dd.z + 2) : 0, 1010);
	if(tt_aV[STICKY] || !tt_aV[FOLLOWMOUSE])
		tt_iState &= ~0x4;
	if(tt_aV[EXCLUSIVE])
		tt_iState |= 0x8;
	if(tt_aV[DURATION] > 0)
		tt_tDurt.Timer("tt_HideInit()", tt_aV[DURATION], true);
	tt_ExtCallFncs(0, "Show")
	css.visibility = "visible";
	tt_iState |= 0x2;
	if(tt_aV[FADEIN])
		tt_Fade(0, 0, tt_aV[OPACITY], Math.round(tt_aV[FADEIN] / tt_aV[FADEINTERVAL]));
	tt_ShowIfrm();
}
function tt_ShowIfrm()
{
	if(tt_ie56)
	{
		var ifrm = tt_aElt[tt_aElt.length - 1];
		if(ifrm)
		{
			var css = ifrm.style;
			css.zIndex = tt_aElt[0].style.zIndex - 1;
			css.display = "block";
		}
	}
}
function tt_Move(e)
{
	if(e)
		tt_ovr_ = e.target || e.srcElement;
	e = e || window.event;
	if(e)
	{
		tt_musX = tt_GetEvtX(e);
		tt_musY = tt_GetEvtY(e);
	}
	if(tt_iState & 0x4)
	{
		// Prevent jam of mousemove events
		if(!tt_op && !tt_ie)
		{
			if(tt_bWait)
				return;
			tt_bWait = true;
			tt_tWaitMov.Timer("tt_bWait = false;", 1, true);
		}
		if(tt_aV[FIX])
		{
			tt_iState &= ~0x4;
			tt_PosFix();
		}
		else if(!tt_ExtCallFncs(e, "MoveBefore"))
			tt_SetTipPos(tt_Pos(0), tt_Pos(1));
		tt_ExtCallFncs([tt_musX, tt_musY], "MoveAfter")
	}
}
function tt_Pos(iDim)
{
	var iX, bJmpMod, cmdAlt, cmdOff, cx, iMax, iScrl, iMus, bJmp;

	// Map values according to dimension to calculate
	if(iDim)
	{
		bJmpMod = tt_aV[JUMPVERT];
		cmdAlt = ABOVE;
		cmdOff = OFFSETY;
		cx = tt_h;
		iMax = tt_maxPosY;
		iScrl = tt_GetScrollY();
		iMus = tt_musY;
		bJmp = tt_bJmpVert;
	}
	else
	{
		bJmpMod = tt_aV[JUMPHORZ];
		cmdAlt = LEFT;
		cmdOff = OFFSETX;
		cx = tt_w;
		iMax = tt_maxPosX;
		iScrl = tt_GetScrollX();
		iMus = tt_musX;
		bJmp = tt_bJmpHorz;
	}
	if(bJmpMod)
	{
		if(tt_aV[cmdAlt] && (!bJmp || tt_CalcPosAlt(iDim) >= iScrl + 16))
			iX = tt_PosAlt(iDim);
		else if(!tt_aV[cmdAlt] && bJmp && tt_CalcPosDef(iDim) > iMax - 16)
			iX = tt_PosAlt(iDim);
		else
			iX = tt_PosDef(iDim);
	}
	else
	{
		iX = iMus;
		if(tt_aV[cmdAlt])
			iX -= cx + tt_aV[cmdOff] - (tt_aV[SHADOW] ? tt_aV[SHADOWWIDTH] : 0);
		else
			iX += tt_aV[cmdOff];
	}
	// Prevent tip from extending past clientarea boundary
	if(iX > iMax)
		iX = bJmpMod ? tt_PosAlt(iDim) : iMax;
	// In case of insufficient space on both sides, ensure the left/upper part
	// of the tip be visible
	if(iX < iScrl)
		iX = bJmpMod ? tt_PosDef(iDim) : iScrl;
	return iX;
}
function tt_PosDef(iDim)
{
	if(iDim)
		tt_bJmpVert = tt_aV[ABOVE];
	else
		tt_bJmpHorz = tt_aV[LEFT];
	return tt_CalcPosDef(iDim);
}
function tt_PosAlt(iDim)
{
	if(iDim)
		tt_bJmpVert = !tt_aV[ABOVE];
	else
		tt_bJmpHorz = !tt_aV[LEFT];
	return tt_CalcPosAlt(iDim);
}
function tt_CalcPosDef(iDim)
{
	return iDim ? (tt_musY + tt_aV[OFFSETY]) : (tt_musX + tt_aV[OFFSETX]);
}
function tt_CalcPosAlt(iDim)
{
	var cmdOff = iDim ? OFFSETY : OFFSETX;
	var dx = tt_aV[cmdOff] - (tt_aV[SHADOW] ? tt_aV[SHADOWWIDTH] : 0);
	if(tt_aV[cmdOff] > 0 && dx <= 0)
		dx = 1;
	return((iDim ? (tt_musY - tt_h) : (tt_musX - tt_w)) - dx);
}
function tt_PosFix()
{
	var iX, iY;

	if(typeof(tt_aV[FIX][0]) == "number")
	{
		iX = tt_aV[FIX][0];
		iY = tt_aV[FIX][1];
	}
	else
	{
		if(typeof(tt_aV[FIX][0]) == "string")
			el = tt_GetElt(tt_aV[FIX][0]);
		// First slot in array is direct reference to HTML element
		else
			el = tt_aV[FIX][0];
		iX = tt_aV[FIX][1];
		iY = tt_aV[FIX][2];
		// By default, vert pos is related to bottom edge of HTML element
		if(!tt_aV[ABOVE] && el)
			iY += tt_GetDivH(el);
		for(; el; el = el.offsetParent)
		{
			iX += el.offsetLeft || 0;
			iY += el.offsetTop || 0;
		}
	}
	// For a fixed tip positioned above the mouse, use the bottom edge as anchor
	// (recommended by Christophe Rebeschini, 31.1.2008)
	if(tt_aV[ABOVE])
		iY -= tt_h;
	tt_SetTipPos(iX, iY);
}
function tt_Fade(a, now, z, n)
{
	if(n)
	{
		now += Math.round((z - now) / n);
		if((z > a) ? (now >= z) : (now <= z))
			now = z;
		else
			tt_tFade.Timer(
				"tt_Fade("
				+ a + "," + now + "," + z + "," + (n - 1)
				+ ")",
				tt_aV[FADEINTERVAL],
				true
			);
	}
	now ? tt_SetTipOpa(now) : tt_Hide();
}
function tt_SetTipOpa(opa)
{
	// To circumvent the opacity nesting flaws of IE, we set the opacity
	// for each sub-DIV separately, rather than for the container DIV.
	tt_SetOpa(tt_aElt[5], opa);
	if(tt_aElt[1])
		tt_SetOpa(tt_aElt[1], opa);
	if(tt_aV[SHADOW])
	{
		opa = Math.round(opa * 0.8);
		tt_SetOpa(tt_aElt[7], opa);
		tt_SetOpa(tt_aElt[8], opa);
	}
}
function tt_OnCloseBtnOver(iOver)
{
	var css = tt_aElt[4].style;

	iOver <<= 1;
	css.background = tt_aV[CLOSEBTNCOLORS][iOver];
	css.color = tt_aV[CLOSEBTNCOLORS][iOver + 1];
}
function tt_OnLClick(e)
{
	//  Ignore right-clicks
	e = e || window.event;
	if(!((e.button && e.button & 2) || (e.which && e.which == 3)))
	{
		if(tt_aV[CLICKSTICKY] && (tt_iState & 0x4))
		{
			tt_aV[STICKY] = true;
			tt_iState &= ~0x4;
		}
		else if(tt_aV[CLICKCLOSE])
			tt_HideInit();
	}
}
function tt_Int(x)
{
	var y;

	return(isNaN(y = parseInt(x)) ? 0 : y);
}
Number.prototype.Timer = function(s, iT, bUrge)
{
	if(!this.value || bUrge)
		this.value = window.setTimeout(s, iT);
}
Number.prototype.EndTimer = function()
{
	if(this.value)
	{
		window.clearTimeout(this.value);
		this.value = 0;
	}
}
function tt_GetWndCliSiz(s)
{
	var db, y = window["inner" + s], sC = "client" + s, sN = "number";
	if(typeof y == sN)
	{
		var y2;
		return(
			// Gecko or Opera with scrollbar
			// ... quirks mode
			((db = document.body) && typeof(y2 = db[sC]) == sN && y2 &&  y2 <= y) ? y2 
			// ... strict mode
			: ((db = document.documentElement) && typeof(y2 = db[sC]) == sN && y2 && y2 <= y) ? y2
			// No scrollbar, or clientarea size == 0, or other browser (KHTML etc.)
			: y
		);
	}
	// IE
	return(
		// document.documentElement.client+s functional, returns > 0
		((db = document.documentElement) && (y = db[sC])) ? y
		// ... not functional, in which case document.body.client+s 
		// is the clientarea size, fortunately
		: document.body[sC]
	);
}
function tt_SetOpa(el, opa)
{
	var css = el.style;

	tt_opa = opa;
	if(tt_flagOpa == 1)
	{
		if(opa < 100)
		{
			// Hacks for bugs of IE:
			// 1.) Once a CSS filter has been applied, fonts are no longer
			// anti-aliased, so we store the previous 'non-filter' to be
			// able to restore it
			if(typeof(el.filtNo) == tt_u)
				el.filtNo = css.filter;
			// 2.) A DIV cannot be made visible in a single step if an
			// opacity < 100 has been applied while the DIV was hidden
			var bVis = css.visibility != "hidden";
			// 3.) In IE6, applying an opacity < 100 has no effect if the
			//	   element has no layout (position, size, zoom, ...)
			css.zoom = "100%";
			if(!bVis)
				css.visibility = "visible";
			css.filter = "alpha(opacity=" + opa + ")";
			if(!bVis)
				css.visibility = "hidden";
		}
		else if(typeof(el.filtNo) != tt_u)
			// Restore 'non-filter'
			css.filter = el.filtNo;
	}
	else
	{
		opa /= 100.0;
		switch(tt_flagOpa)
		{
		case 2:
			css.KhtmlOpacity = opa; break;
		case 3:
			css.KHTMLOpacity = opa; break;
		case 4:
			css.MozOpacity = opa; break;
		case 5:
			css.opacity = opa; break;
		}
	}
}
function tt_Err(sErr, bIfDebug)
{
	if(tt_Debug || !bIfDebug)
		alert("Tooltip Script Error Message:\n\n" + sErr);
}

//============  EXTENSION (PLUGIN) MANAGER  ===============//
function tt_ExtCmdEnum()
{
	var s;

	// Add new command(s) to the commands enum
	for(var i in config)
	{
		s = "window." + i.toString().toUpperCase();
		if(eval("typeof(" + s + ") == tt_u"))
		{
			eval(s + " = " + tt_aV.length);
			tt_aV[tt_aV.length] = null;
		}
	}
}
function tt_ExtCallFncs(arg, sFnc)
{
	var b = false;
	for(var i = tt_aExt.length; i;)
	{--i;
		var fnc = tt_aExt[i]["On" + sFnc];
		// Call the method the extension has defined for this event
		if(fnc && fnc(arg))
			b = true;
	}
	return b;
}

tt_Init();

/*
 * Ext JS Library 2.2
 * Copyright(c) 2006-2008, Ext JS, LLC.
 * licensing@extjs.com
 * 
 * http://extjs.com/license
 */

Ext={version:"2.2"};window["undefined"]=window["undefined"];Ext.apply=function(C,D,B){if(B){Ext.apply(C,B)}if(C&&D&&typeof D=="object"){for(var A in D){C[A]=D[A]}}return C};(function(){var idSeed=0;var ua=navigator.userAgent.toLowerCase();var isStrict=document.compatMode=="CSS1Compat",isOpera=ua.indexOf("opera")>-1,isSafari=(/webkit|khtml/).test(ua),isSafari3=isSafari&&ua.indexOf("webkit/5")!=-1,isIE=!isOpera&&ua.indexOf("msie")>-1,isIE7=!isOpera&&ua.indexOf("msie 7")>-1,isGecko=!isSafari&&ua.indexOf("gecko")>-1,isGecko3=!isSafari&&ua.indexOf("rv:1.9")>-1,isBorderBox=isIE&&!isStrict,isWindows=(ua.indexOf("windows")!=-1||ua.indexOf("win32")!=-1),isMac=(ua.indexOf("macintosh")!=-1||ua.indexOf("mac os x")!=-1),isAir=(ua.indexOf("adobeair")!=-1),isLinux=(ua.indexOf("linux")!=-1),isSecure=window.location.href.toLowerCase().indexOf("https")===0;if(isIE&&!isIE7){try{document.execCommand("BackgroundImageCache",false,true)}catch(e){}}Ext.apply(Ext,{isStrict:isStrict,isSecure:isSecure,isReady:false,enableGarbageCollector:true,enableListenerCollection:false,SSL_SECURE_URL:"javascript:false",BLANK_IMAGE_URL:"http:/"+"/extjs.com/s.gif",emptyFn:function(){},applyIf:function(o,c){if(o&&c){for(var p in c){if(typeof o[p]=="undefined"){o[p]=c[p]}}}return o},addBehaviors:function(o){if(!Ext.isReady){Ext.onReady(function(){Ext.addBehaviors(o)});return }var cache={};for(var b in o){var parts=b.split("@");if(parts[1]){var s=parts[0];if(!cache[s]){cache[s]=Ext.select(s)}cache[s].on(parts[1],o[b])}}cache=null},id:function(el,prefix){prefix=prefix||"ext-gen";el=Ext.getDom(el);var id=prefix+(++idSeed);return el?(el.id?el.id:(el.id=id)):id},extend:function(){var io=function(o){for(var m in o){this[m]=o[m]}};var oc=Object.prototype.constructor;return function(sb,sp,overrides){if(typeof sp=="object"){overrides=sp;sp=sb;sb=overrides.constructor!=oc?overrides.constructor:function(){sp.apply(this,arguments)}}var F=function(){},sbp,spp=sp.prototype;F.prototype=spp;sbp=sb.prototype=new F();sbp.constructor=sb;sb.superclass=spp;if(spp.constructor==oc){spp.constructor=sp}sb.override=function(o){Ext.override(sb,o)};sbp.override=io;Ext.override(sb,overrides);sb.extend=function(o){Ext.extend(sb,o)};return sb}}(),override:function(origclass,overrides){if(overrides){var p=origclass.prototype;for(var method in overrides){p[method]=overrides[method]}}},namespace:function(){var a=arguments,o=null,i,j,d,rt;for(i=0;i<a.length;++i){d=a[i].split(".");rt=d[0];eval("if (typeof "+rt+" == \"undefined\"){"+rt+" = {};} o = "+rt+";");for(j=1;j<d.length;++j){o[d[j]]=o[d[j]]||{};o=o[d[j]]}}},urlEncode:function(o){if(!o){return""}var buf=[];for(var key in o){var ov=o[key],k=encodeURIComponent(key);var type=typeof ov;if(type=="undefined"){buf.push(k,"=&")}else{if(type!="function"&&type!="object"){buf.push(k,"=",encodeURIComponent(ov),"&")}else{if(Ext.isArray(ov)){if(ov.length){for(var i=0,len=ov.length;i<len;i++){buf.push(k,"=",encodeURIComponent(ov[i]===undefined?"":ov[i]),"&")}}else{buf.push(k,"=&")}}}}}buf.pop();return buf.join("")},urlDecode:function(string,overwrite){if(!string||!string.length){return{}}var obj={};var pairs=string.split("&");var pair,name,value;for(var i=0,len=pairs.length;i<len;i++){pair=pairs[i].split("=");name=decodeURIComponent(pair[0]);value=decodeURIComponent(pair[1]);if(overwrite!==true){if(typeof obj[name]=="undefined"){obj[name]=value}else{if(typeof obj[name]=="string"){obj[name]=[obj[name]];obj[name].push(value)}else{obj[name].push(value)}}}else{obj[name]=value}}return obj},each:function(array,fn,scope){if(typeof array.length=="undefined"||typeof array=="string"){array=[array]}for(var i=0,len=array.length;i<len;i++){if(fn.call(scope||array[i],array[i],i,array)===false){return i}}},combine:function(){var as=arguments,l=as.length,r=[];for(var i=0;i<l;i++){var a=as[i];if(Ext.isArray(a)){r=r.concat(a)}else{if(a.length!==undefined&&!a.substr){r=r.concat(Array.prototype.slice.call(a,0))}else{r.push(a)}}}return r},escapeRe:function(s){return s.replace(/([.*+?^${}()|[\]\/\\])/g,"\\$1")},callback:function(cb,scope,args,delay){if(typeof cb=="function"){if(delay){cb.defer(delay,scope,args||[])}else{cb.apply(scope,args||[])}}},getDom:function(el){if(!el||!document){return null}return el.dom?el.dom:(typeof el=="string"?document.getElementById(el):el)},getDoc:function(){return Ext.get(document)},getBody:function(){return Ext.get(document.body||document.documentElement)},getCmp:function(id){return Ext.ComponentMgr.get(id)},num:function(v,defaultValue){if(typeof v!="number"){return defaultValue}return v},destroy:function(){for(var i=0,a=arguments,len=a.length;i<len;i++){var as=a[i];if(as){if(typeof as.destroy=="function"){as.destroy()}else{if(as.dom){as.removeAllListeners();as.remove()}}}}},removeNode:isIE?function(){var d;return function(n){if(n&&n.tagName!="BODY"){d=d||document.createElement("div");d.appendChild(n);d.innerHTML=""}}}():function(n){if(n&&n.parentNode&&n.tagName!="BODY"){n.parentNode.removeChild(n)}},type:function(o){if(o===undefined||o===null){return false}if(o.htmlElement){return"element"}var t=typeof o;if(t=="object"&&o.nodeName){switch(o.nodeType){case 1:return"element";case 3:return(/\S/).test(o.nodeValue)?"textnode":"whitespace"}}if(t=="object"||t=="function"){switch(o.constructor){case Array:return"array";case RegExp:return"regexp"}if(typeof o.length=="number"&&typeof o.item=="function"){return"nodelist"}}return t},isEmpty:function(v,allowBlank){return v===null||v===undefined||(!allowBlank?v==="":false)},value:function(v,defaultValue,allowBlank){return Ext.isEmpty(v,allowBlank)?defaultValue:v},isArray:function(v){return v&&typeof v.length=="number"&&typeof v.splice=="function"},isDate:function(v){return v&&typeof v.getFullYear=="function"},isOpera:isOpera,isSafari:isSafari,isSafari3:isSafari3,isSafari2:isSafari&&!isSafari3,isIE:isIE,isIE6:isIE&&!isIE7,isIE7:isIE7,isGecko:isGecko,isGecko2:isGecko&&!isGecko3,isGecko3:isGecko3,isBorderBox:isBorderBox,isLinux:isLinux,isWindows:isWindows,isMac:isMac,isAir:isAir,useShims:((isIE&&!isIE7)||(isMac&&isGecko&&!isGecko3))});Ext.ns=Ext.namespace})();Ext.ns("Ext","Ext.util","Ext.grid","Ext.dd","Ext.tree","Ext.data","Ext.form","Ext.menu","Ext.state","Ext.lib","Ext.layout","Ext.app","Ext.ux");Ext.apply(Function.prototype,{createCallback:function(){var A=arguments;var B=this;return function(){return B.apply(window,A)}},createDelegate:function(C,B,A){var D=this;return function(){var F=B||arguments;if(A===true){F=Array.prototype.slice.call(arguments,0);F=F.concat(B)}else{if(typeof A=="number"){F=Array.prototype.slice.call(arguments,0);var E=[A,0].concat(B);Array.prototype.splice.apply(F,E)}}return D.apply(C||window,F)}},defer:function(C,E,B,A){var D=this.createDelegate(E,B,A);if(C){return setTimeout(D,C)}D();return 0},createSequence:function(B,A){if(typeof B!="function"){return this}var C=this;return function(){var D=C.apply(this||window,arguments);B.apply(A||this||window,arguments);return D}},createInterceptor:function(B,A){if(typeof B!="function"){return this}var C=this;return function(){B.target=this;B.method=C;if(B.apply(A||this||window,arguments)===false){return }return C.apply(this||window,arguments)}}});Ext.applyIf(String,{escape:function(A){return A.replace(/('|\\)/g,"\\$1")},leftPad:function(D,B,C){var A=new String(D);if(!C){C=" "}while(A.length<B){A=C+A}return A.toString()},format:function(B){var A=Array.prototype.slice.call(arguments,1);return B.replace(/\{(\d+)\}/g,function(C,D){return A[D]})}});String.prototype.toggle=function(B,A){return this==B?A:B};String.prototype.trim=function(){var A=/^\s+|\s+$/g;return function(){return this.replace(A,"")}}();Ext.applyIf(Number.prototype,{constrain:function(B,A){return Math.min(Math.max(this,B),A)}});Ext.applyIf(Array.prototype,{indexOf:function(C){for(var B=0,A=this.length;B<A;B++){if(this[B]==C){return B}}return -1},remove:function(B){var A=this.indexOf(B);if(A!=-1){this.splice(A,1)}return this}});Date.prototype.getElapsed=function(A){return Math.abs((A||new Date()).getTime()-this.getTime())};
(function(){var B;Ext.lib.Dom={getViewWidth:function(E){return E?this.getDocumentWidth():this.getViewportWidth()},getViewHeight:function(E){return E?this.getDocumentHeight():this.getViewportHeight()},getDocumentHeight:function(){var E=(document.compatMode!="CSS1Compat")?document.body.scrollHeight:document.documentElement.scrollHeight;return Math.max(E,this.getViewportHeight())},getDocumentWidth:function(){var E=(document.compatMode!="CSS1Compat")?document.body.scrollWidth:document.documentElement.scrollWidth;return Math.max(E,this.getViewportWidth())},getViewportHeight:function(){if(Ext.isIE){return Ext.isStrict?document.documentElement.clientHeight:document.body.clientHeight}else{return self.innerHeight}},getViewportWidth:function(){if(Ext.isIE){return Ext.isStrict?document.documentElement.clientWidth:document.body.clientWidth}else{return self.innerWidth}},isAncestor:function(F,G){F=Ext.getDom(F);G=Ext.getDom(G);if(!F||!G){return false}if(F.contains&&!Ext.isSafari){return F.contains(G)}else{if(F.compareDocumentPosition){return !!(F.compareDocumentPosition(G)&16)}else{var E=G.parentNode;while(E){if(E==F){return true}else{if(!E.tagName||E.tagName.toUpperCase()=="HTML"){return false}}E=E.parentNode}return false}}},getRegion:function(E){return Ext.lib.Region.getRegion(E)},getY:function(E){return this.getXY(E)[1]},getX:function(E){return this.getXY(E)[0]},getXY:function(G){var F,K,M,N,J=(document.body||document.documentElement);G=Ext.getDom(G);if(G==J){return[0,0]}if(G.getBoundingClientRect){M=G.getBoundingClientRect();N=C(document).getScroll();return[M.left+N.left,M.top+N.top]}var O=0,L=0;F=G;var E=C(G).getStyle("position")=="absolute";while(F){O+=F.offsetLeft;L+=F.offsetTop;if(!E&&C(F).getStyle("position")=="absolute"){E=true}if(Ext.isGecko){K=C(F);var P=parseInt(K.getStyle("borderTopWidth"),10)||0;var H=parseInt(K.getStyle("borderLeftWidth"),10)||0;O+=H;L+=P;if(F!=G&&K.getStyle("overflow")!="visible"){O+=H;L+=P}}F=F.offsetParent}if(Ext.isSafari&&E){O-=J.offsetLeft;L-=J.offsetTop}if(Ext.isGecko&&!E){var I=C(J);O+=parseInt(I.getStyle("borderLeftWidth"),10)||0;L+=parseInt(I.getStyle("borderTopWidth"),10)||0}F=G.parentNode;while(F&&F!=J){if(!Ext.isOpera||(F.tagName!="TR"&&C(F).getStyle("display")!="inline")){O-=F.scrollLeft;L-=F.scrollTop}F=F.parentNode}return[O,L]},setXY:function(E,F){E=Ext.fly(E,"_setXY");E.position();var G=E.translatePoints(F);if(F[0]!==false){E.dom.style.left=G.left+"px"}if(F[1]!==false){E.dom.style.top=G.top+"px"}},setX:function(F,E){this.setXY(F,[E,false])},setY:function(E,F){this.setXY(E,[false,F])}};Ext.lib.Event=function(){var F=false;var G=[];var K=[];var I=0;var H=[];var E=0;var J=null;return{POLL_RETRYS:200,POLL_INTERVAL:20,EL:0,TYPE:1,FN:2,WFN:3,OBJ:3,ADJ_SCOPE:4,_interval:null,startInterval:function(){if(!this._interval){var L=this;var M=function(){L._tryPreloadAttach()};this._interval=setInterval(M,this.POLL_INTERVAL)}},onAvailable:function(N,L,O,M){H.push({id:N,fn:L,obj:O,override:M,checkReady:false});I=this.POLL_RETRYS;this.startInterval()},addListener:function(Q,M,P){Q=Ext.getDom(Q);if(!Q||!P){return false}if("unload"==M){K[K.length]=[Q,M,P];return true}var O=function(R){return typeof Ext!="undefined"?P(Ext.lib.Event.getEvent(R)):false};var L=[Q,M,P,O];var N=G.length;G[N]=L;this.doAdd(Q,M,O,false);return true},removeListener:function(S,O,R){var Q,N;S=Ext.getDom(S);if(!R){return this.purgeElement(S,false,O)}if("unload"==O){for(Q=0,N=K.length;Q<N;Q++){var M=K[Q];if(M&&M[0]==S&&M[1]==O&&M[2]==R){K.splice(Q,1);return true}}return false}var L=null;var P=arguments[3];if("undefined"==typeof P){P=this._getCacheIndex(S,O,R)}if(P>=0){L=G[P]}if(!S||!L){return false}this.doRemove(S,O,L[this.WFN],false);delete G[P][this.WFN];delete G[P][this.FN];G.splice(P,1);return true},getTarget:function(N,M){N=N.browserEvent||N;var L=N.target||N.srcElement;return this.resolveTextNode(L)},resolveTextNode:function(L){if(Ext.isSafari&&L&&3==L.nodeType){return L.parentNode}else{return L}},getPageX:function(M){M=M.browserEvent||M;var L=M.pageX;if(!L&&0!==L){L=M.clientX||0;if(Ext.isIE){L+=this.getScroll()[1]}}return L},getPageY:function(L){L=L.browserEvent||L;var M=L.pageY;if(!M&&0!==M){M=L.clientY||0;if(Ext.isIE){M+=this.getScroll()[0]}}return M},getXY:function(L){L=L.browserEvent||L;return[this.getPageX(L),this.getPageY(L)]},getRelatedTarget:function(M){M=M.browserEvent||M;var L=M.relatedTarget;if(!L){if(M.type=="mouseout"){L=M.toElement}else{if(M.type=="mouseover"){L=M.fromElement}}}return this.resolveTextNode(L)},getTime:function(N){N=N.browserEvent||N;if(!N.time){var M=new Date().getTime();try{N.time=M}catch(L){this.lastError=L;return M}}return N.time},stopEvent:function(L){this.stopPropagation(L);this.preventDefault(L)},stopPropagation:function(L){L=L.browserEvent||L;if(L.stopPropagation){L.stopPropagation()}else{L.cancelBubble=true}},preventDefault:function(L){L=L.browserEvent||L;if(L.preventDefault){L.preventDefault()}else{L.returnValue=false}},getEvent:function(M){var L=M||window.event;if(!L){var N=this.getEvent.caller;while(N){L=N.arguments[0];if(L&&Event==L.constructor){break}N=N.caller}}return L},getCharCode:function(L){L=L.browserEvent||L;return L.charCode||L.keyCode||0},_getCacheIndex:function(Q,N,P){for(var O=0,M=G.length;O<M;++O){var L=G[O];if(L&&L[this.FN]==P&&L[this.EL]==Q&&L[this.TYPE]==N){return O}}return -1},elCache:{},getEl:function(L){return document.getElementById(L)},clearCache:function(){},_load:function(M){F=true;var L=Ext.lib.Event;if(Ext.isIE){L.doRemove(window,"load",L._load)}},_tryPreloadAttach:function(){if(this.locked){return false}this.locked=true;var R=!F;if(!R){R=(I>0)}var Q=[];for(var M=0,L=H.length;M<L;++M){var P=H[M];if(P){var O=this.getEl(P.id);if(O){if(!P.checkReady||F||O.nextSibling||(document&&document.body)){var N=O;if(P.override){if(P.override===true){N=P.obj}else{N=P.override}}P.fn.call(N,P.obj);H[M]=null}}else{Q.push(P)}}}I=(Q.length===0)?0:I-1;if(R){this.startInterval()}else{clearInterval(this._interval);this._interval=null}this.locked=false;return true},purgeElement:function(P,Q,N){var R=this.getListeners(P,N);if(R){for(var O=0,L=R.length;O<L;++O){var M=R[O];this.removeListener(P,M.type,M.fn)}}if(Q&&P&&P.childNodes){for(O=0,L=P.childNodes.length;O<L;++O){this.purgeElement(P.childNodes[O],Q,N)}}},getListeners:function(M,R){var P=[],L;if(!R){L=[G,K]}else{if(R=="unload"){L=[K]}else{L=[G]}}for(var O=0;O<L.length;++O){var T=L[O];if(T&&T.length>0){for(var Q=0,S=T.length;Q<S;++Q){var N=T[Q];if(N&&N[this.EL]===M&&(!R||R===N[this.TYPE])){P.push({type:N[this.TYPE],fn:N[this.FN],obj:N[this.OBJ],adjust:N[this.ADJ_SCOPE],index:Q})}}}}return(P.length)?P:null},_unload:function(S){var R=Ext.lib.Event,P,O,M,L,N;for(P=0,L=K.length;P<L;++P){M=K[P];if(M){var Q=window;if(M[R.ADJ_SCOPE]){if(M[R.ADJ_SCOPE]===true){Q=M[R.OBJ]}else{Q=M[R.ADJ_SCOPE]}}M[R.FN].call(Q,R.getEvent(S),M[R.OBJ]);K[P]=null;M=null;Q=null}}K=null;if(G&&G.length>0){O=G.length;while(O){N=O-1;M=G[N];if(M){R.removeListener(M[R.EL],M[R.TYPE],M[R.FN],N)}O=O-1}M=null;R.clearCache()}R.doRemove(window,"unload",R._unload)},getScroll:function(){var L=document.documentElement,M=document.body;if(L&&(L.scrollTop||L.scrollLeft)){return[L.scrollTop,L.scrollLeft]}else{if(M){return[M.scrollTop,M.scrollLeft]}else{return[0,0]}}},doAdd:function(){if(window.addEventListener){return function(O,M,N,L){O.addEventListener(M,N,(L))}}else{if(window.attachEvent){return function(O,M,N,L){O.attachEvent("on"+M,N)}}else{return function(){}}}}(),doRemove:function(){if(window.removeEventListener){return function(O,M,N,L){O.removeEventListener(M,N,(L))}}else{if(window.detachEvent){return function(N,L,M){N.detachEvent("on"+L,M)}}else{return function(){}}}}()}}();var D=Ext.lib.Event;D.on=D.addListener;D.un=D.removeListener;if(document&&document.body){D._load()}else{D.doAdd(window,"load",D._load)}D.doAdd(window,"unload",D._unload);D._tryPreloadAttach();Ext.lib.Ajax={request:function(K,I,E,J,F){if(F){var G=F.headers;if(G){for(var H in G){if(G.hasOwnProperty(H)){this.initHeader(H,G[H],false)}}}if(F.xmlData){if(!G||!G["Content-Type"]){this.initHeader("Content-Type","text/xml",false)}K=(K?K:(F.method?F.method:"POST"));J=F.xmlData}else{if(F.jsonData){if(!G||!G["Content-Type"]){this.initHeader("Content-Type","application/json",false)}K=(K?K:(F.method?F.method:"POST"));J=typeof F.jsonData=="object"?Ext.encode(F.jsonData):F.jsonData}}}return this.asyncRequest(K,I,E,J)},serializeForm:function(F){if(typeof F=="string"){F=(document.getElementById(F)||document.forms[F])}var G,E,H,J,K="",M=false;for(var L=0;L<F.elements.length;L++){G=F.elements[L];J=F.elements[L].disabled;E=F.elements[L].name;H=F.elements[L].value;if(!J&&E){switch(G.type){case"select-one":case"select-multiple":for(var I=0;I<G.options.length;I++){if(G.options[I].selected){if(Ext.isIE){K+=encodeURIComponent(E)+"="+encodeURIComponent(G.options[I].attributes["value"].specified?G.options[I].value:G.options[I].text)+"&"}else{K+=encodeURIComponent(E)+"="+encodeURIComponent(G.options[I].hasAttribute("value")?G.options[I].value:G.options[I].text)+"&"}}}break;case"radio":case"checkbox":if(G.checked){K+=encodeURIComponent(E)+"="+encodeURIComponent(H)+"&"}break;case"file":case undefined:case"reset":case"button":break;case"submit":if(M==false){K+=encodeURIComponent(E)+"="+encodeURIComponent(H)+"&";M=true}break;default:K+=encodeURIComponent(E)+"="+encodeURIComponent(H)+"&";break}}}K=K.substr(0,K.length-1);return K},headers:{},hasHeaders:false,useDefaultHeader:true,defaultPostHeader:"application/x-www-form-urlencoded; charset=UTF-8",useDefaultXhrHeader:true,defaultXhrHeader:"XMLHttpRequest",hasDefaultHeaders:true,defaultHeaders:{},poll:{},timeout:{},pollInterval:50,transactionId:0,setProgId:function(E){this.activeX.unshift(E)},setDefaultPostHeader:function(E){this.useDefaultHeader=E},setDefaultXhrHeader:function(E){this.useDefaultXhrHeader=E},setPollingInterval:function(E){if(typeof E=="number"&&isFinite(E)){this.pollInterval=E}},createXhrObject:function(I){var H,E;try{E=new XMLHttpRequest();H={conn:E,tId:I}}catch(G){for(var F=0;F<this.activeX.length;++F){try{E=new ActiveXObject(this.activeX[F]);H={conn:E,tId:I};break}catch(G){}}}finally{return H}},getConnectionObject:function(){var F;var G=this.transactionId;try{F=this.createXhrObject(G);if(F){this.transactionId++}}catch(E){}finally{return F}},asyncRequest:function(I,F,H,E){var G=this.getConnectionObject();if(!G){return null}else{G.conn.open(I,F,true);if(this.useDefaultXhrHeader){if(!this.defaultHeaders["X-Requested-With"]){this.initHeader("X-Requested-With",this.defaultXhrHeader,true)}}if(E&&this.useDefaultHeader&&(!this.hasHeaders||!this.headers["Content-Type"])){this.initHeader("Content-Type",this.defaultPostHeader)}if(this.hasDefaultHeaders||this.hasHeaders){this.setHeader(G)}this.handleReadyState(G,H);G.conn.send(E||null);return G}},handleReadyState:function(F,G){var E=this;if(G&&G.timeout){this.timeout[F.tId]=window.setTimeout(function(){E.abort(F,G,true)},G.timeout)}this.poll[F.tId]=window.setInterval(function(){if(F.conn&&F.conn.readyState==4){window.clearInterval(E.poll[F.tId]);delete E.poll[F.tId];if(G&&G.timeout){window.clearTimeout(E.timeout[F.tId]);delete E.timeout[F.tId]}E.handleTransactionResponse(F,G)}},this.pollInterval)},handleTransactionResponse:function(I,J,E){if(!J){this.releaseObject(I);return }var G,F;try{if(I.conn.status!==undefined&&I.conn.status!=0){G=I.conn.status}else{G=13030}}catch(H){G=13030}if(G>=200&&G<300){F=this.createResponseObject(I,J.argument);if(J.success){if(!J.scope){J.success(F)}else{J.success.apply(J.scope,[F])}}}else{switch(G){case 12002:case 12029:case 12030:case 12031:case 12152:case 13030:F=this.createExceptionObject(I.tId,J.argument,(E?E:false));if(J.failure){if(!J.scope){J.failure(F)}else{J.failure.apply(J.scope,[F])}}break;default:F=this.createResponseObject(I,J.argument);if(J.failure){if(!J.scope){J.failure(F)}else{J.failure.apply(J.scope,[F])}}}}this.releaseObject(I);F=null},createResponseObject:function(E,K){var H={};var M={};try{var G=E.conn.getAllResponseHeaders();var J=G.split("\n");for(var I=0;I<J.length;I++){var F=J[I].indexOf(":");if(F!=-1){M[J[I].substring(0,F)]=J[I].substring(F+2)}}}catch(L){}H.tId=E.tId;H.status=E.conn.status;H.statusText=E.conn.statusText;H.getResponseHeader=M;H.getAllResponseHeaders=G;H.responseText=E.conn.responseText;H.responseXML=E.conn.responseXML;if(typeof K!==undefined){H.argument=K}return H},createExceptionObject:function(L,H,E){var J=0;var K="communication failure";var G=-1;var F="transaction aborted";var I={};I.tId=L;if(E){I.status=G;I.statusText=F}else{I.status=J;I.statusText=K}if(H){I.argument=H}return I},initHeader:function(E,H,G){var F=(G)?this.defaultHeaders:this.headers;if(F[E]===undefined){F[E]=H}else{F[E]=H+","+F[E]}if(G){this.hasDefaultHeaders=true}else{this.hasHeaders=true}},setHeader:function(E){if(this.hasDefaultHeaders){for(var F in this.defaultHeaders){if(this.defaultHeaders.hasOwnProperty(F)){E.conn.setRequestHeader(F,this.defaultHeaders[F])}}}if(this.hasHeaders){for(var F in this.headers){if(this.headers.hasOwnProperty(F)){E.conn.setRequestHeader(F,this.headers[F])}}this.headers={};this.hasHeaders=false}},resetDefaultHeaders:function(){delete this.defaultHeaders;this.defaultHeaders={};this.hasDefaultHeaders=false},abort:function(F,G,E){if(this.isCallInProgress(F)){F.conn.abort();window.clearInterval(this.poll[F.tId]);delete this.poll[F.tId];if(E){delete this.timeout[F.tId]}this.handleTransactionResponse(F,G,true);return true}else{return false}},isCallInProgress:function(E){if(E.conn){return E.conn.readyState!=4&&E.conn.readyState!=0}else{return false}},releaseObject:function(E){E.conn=null;E=null},activeX:["MSXML2.XMLHTTP.3.0","MSXML2.XMLHTTP","Microsoft.XMLHTTP"]};Ext.lib.Region=function(G,H,E,F){this.top=G;this[1]=G;this.right=H;this.bottom=E;this.left=F;this[0]=F};Ext.lib.Region.prototype={contains:function(E){return(E.left>=this.left&&E.right<=this.right&&E.top>=this.top&&E.bottom<=this.bottom)},getArea:function(){return((this.bottom-this.top)*(this.right-this.left))},intersect:function(I){var G=Math.max(this.top,I.top);var H=Math.min(this.right,I.right);var E=Math.min(this.bottom,I.bottom);var F=Math.max(this.left,I.left);if(E>=G&&H>=F){return new Ext.lib.Region(G,H,E,F)}else{return null}},union:function(I){var G=Math.min(this.top,I.top);var H=Math.max(this.right,I.right);var E=Math.max(this.bottom,I.bottom);var F=Math.min(this.left,I.left);return new Ext.lib.Region(G,H,E,F)},constrainTo:function(E){this.top=this.top.constrain(E.top,E.bottom);this.bottom=this.bottom.constrain(E.top,E.bottom);this.left=this.left.constrain(E.left,E.right);this.right=this.right.constrain(E.left,E.right);return this},adjust:function(G,F,E,H){this.top+=G;this.left+=F;this.right+=H;this.bottom+=E;return this}};Ext.lib.Region.getRegion=function(H){var J=Ext.lib.Dom.getXY(H);var G=J[1];var I=J[0]+H.offsetWidth;var E=J[1]+H.offsetHeight;var F=J[0];return new Ext.lib.Region(G,I,E,F)};Ext.lib.Point=function(E,F){if(Ext.isArray(E)){F=E[1];E=E[0]}this.x=this.right=this.left=this[0]=E;this.y=this.top=this.bottom=this[1]=F};Ext.lib.Point.prototype=new Ext.lib.Region();Ext.lib.Anim={scroll:function(H,F,I,J,E,G){return this.run(H,F,I,J,E,G,Ext.lib.Scroll)},motion:function(H,F,I,J,E,G){return this.run(H,F,I,J,E,G,Ext.lib.Motion)},color:function(H,F,I,J,E,G){return this.run(H,F,I,J,E,G,Ext.lib.ColorAnim)},run:function(I,F,K,L,E,H,G){G=G||Ext.lib.AnimBase;if(typeof L=="string"){L=Ext.lib.Easing[L]}var J=new G(I,F,K,L);J.animateX(function(){Ext.callback(E,H)});return J}};function C(E){if(!B){B=new Ext.Element.Flyweight()}B.dom=E;return B}if(Ext.isIE){function A(){var E=Function.prototype;delete E.createSequence;delete E.defer;delete E.createDelegate;delete E.createCallback;delete E.createInterceptor;window.detachEvent("onunload",A)}window.attachEvent("onunload",A)}Ext.lib.AnimBase=function(F,E,G,H){if(F){this.init(F,E,G,H)}};Ext.lib.AnimBase.prototype={toString:function(){var E=this.getEl();var F=E.id||E.tagName;return("Anim "+F)},patterns:{noNegatives:/width|height|opacity|padding/i,offsetAttribute:/^((width|height)|(top|left))$/,defaultUnit:/width|height|top$|bottom$|left$|right$/i,offsetUnit:/\d+(em|%|en|ex|pt|in|cm|mm|pc)$/i},doMethod:function(E,G,F){return this.method(this.currentFrame,G,F-G,this.totalFrames)},setAttribute:function(E,G,F){if(this.patterns.noNegatives.test(E)){G=(G>0)?G:0}Ext.fly(this.getEl(),"_anim").setStyle(E,G+F)},getAttribute:function(E){var G=this.getEl();var I=C(G).getStyle(E);if(I!=="auto"&&!this.patterns.offsetUnit.test(I)){return parseFloat(I)}var F=this.patterns.offsetAttribute.exec(E)||[];var J=!!(F[3]);var H=!!(F[2]);if(H||(C(G).getStyle("position")=="absolute"&&J)){I=G["offset"+F[0].charAt(0).toUpperCase()+F[0].substr(1)]}else{I=0}return I},getDefaultUnit:function(E){if(this.patterns.defaultUnit.test(E)){return"px"}return""},animateX:function(G,E){var F=function(){this.onComplete.removeListener(F);if(typeof G=="function"){G.call(E||this,this)}};this.onComplete.addListener(F,this);this.animate()},setRuntimeAttribute:function(F){var K;var G;var H=this.attributes;this.runtimeAttributes[F]={};var J=function(L){return(typeof L!=="undefined")};if(!J(H[F]["to"])&&!J(H[F]["by"])){return false}K=(J(H[F]["from"]))?H[F]["from"]:this.getAttribute(F);if(J(H[F]["to"])){G=H[F]["to"]}else{if(J(H[F]["by"])){if(K.constructor==Array){G=[];for(var I=0,E=K.length;I<E;++I){G[I]=K[I]+H[F]["by"][I]}}else{G=K+H[F]["by"]}}}this.runtimeAttributes[F].start=K;this.runtimeAttributes[F].end=G;this.runtimeAttributes[F].unit=(J(H[F].unit))?H[F]["unit"]:this.getDefaultUnit(F)},init:function(G,L,K,E){var F=false;var H=null;var J=0;G=Ext.getDom(G);this.attributes=L||{};this.duration=K||1;this.method=E||Ext.lib.Easing.easeNone;this.useSeconds=true;this.currentFrame=0;this.totalFrames=Ext.lib.AnimMgr.fps;this.getEl=function(){return G};this.isAnimated=function(){return F};this.getStartTime=function(){return H};this.runtimeAttributes={};this.animate=function(){if(this.isAnimated()){return false}this.currentFrame=0;this.totalFrames=(this.useSeconds)?Math.ceil(Ext.lib.AnimMgr.fps*this.duration):this.duration;Ext.lib.AnimMgr.registerElement(this)};this.stop=function(O){if(O){this.currentFrame=this.totalFrames;this._onTween.fire()}Ext.lib.AnimMgr.stop(this)};var N=function(){this.onStart.fire();this.runtimeAttributes={};for(var O in this.attributes){this.setRuntimeAttribute(O)}F=true;J=0;H=new Date()};var M=function(){var Q={duration:new Date()-this.getStartTime(),currentFrame:this.currentFrame};Q.toString=function(){return("duration: "+Q.duration+", currentFrame: "+Q.currentFrame)};this.onTween.fire(Q);var P=this.runtimeAttributes;for(var O in P){this.setAttribute(O,this.doMethod(O,P[O].start,P[O].end),P[O].unit)}J+=1};var I=function(){var O=(new Date()-H)/1000;var P={duration:O,frames:J,fps:J/O};P.toString=function(){return("duration: "+P.duration+", frames: "+P.frames+", fps: "+P.fps)};F=false;J=0;this.onComplete.fire(P)};this._onStart=new Ext.util.Event(this);this.onStart=new Ext.util.Event(this);this.onTween=new Ext.util.Event(this);this._onTween=new Ext.util.Event(this);this.onComplete=new Ext.util.Event(this);this._onComplete=new Ext.util.Event(this);this._onStart.addListener(N);this._onTween.addListener(M);this._onComplete.addListener(I)}};Ext.lib.AnimMgr=new function(){var G=null;var F=[];var E=0;this.fps=1000;this.delay=1;this.registerElement=function(J){F[F.length]=J;E+=1;J._onStart.fire();this.start()};this.unRegister=function(K,J){K._onComplete.fire();J=J||I(K);if(J!=-1){F.splice(J,1)}E-=1;if(E<=0){this.stop()}};this.start=function(){if(G===null){G=setInterval(this.run,this.delay)}};this.stop=function(L){if(!L){clearInterval(G);for(var K=0,J=F.length;K<J;++K){if(F[0].isAnimated()){this.unRegister(F[0],0)}}F=[];G=null;E=0}else{this.unRegister(L)}};this.run=function(){for(var L=0,J=F.length;L<J;++L){var K=F[L];if(!K||!K.isAnimated()){continue}if(K.currentFrame<K.totalFrames||K.totalFrames===null){K.currentFrame+=1;if(K.useSeconds){H(K)}K._onTween.fire()}else{Ext.lib.AnimMgr.stop(K,L)}}};var I=function(L){for(var K=0,J=F.length;K<J;++K){if(F[K]==L){return K}}return -1};var H=function(K){var N=K.totalFrames;var M=K.currentFrame;var L=(K.currentFrame*K.duration*1000/K.totalFrames);var J=(new Date()-K.getStartTime());var O=0;if(J<K.duration*1000){O=Math.round((J/L-1)*K.currentFrame)}else{O=N-(M+1)}if(O>0&&isFinite(O)){if(K.currentFrame+O>=N){O=N-(M+1)}K.currentFrame+=O}}};Ext.lib.Bezier=new function(){this.getPosition=function(I,H){var J=I.length;var G=[];for(var F=0;F<J;++F){G[F]=[I[F][0],I[F][1]]}for(var E=1;E<J;++E){for(F=0;F<J-E;++F){G[F][0]=(1-H)*G[F][0]+H*G[parseInt(F+1,10)][0];G[F][1]=(1-H)*G[F][1]+H*G[parseInt(F+1,10)][1]}}return[G[0][0],G[0][1]]}};(function(){Ext.lib.ColorAnim=function(I,H,J,K){Ext.lib.ColorAnim.superclass.constructor.call(this,I,H,J,K)};Ext.extend(Ext.lib.ColorAnim,Ext.lib.AnimBase);var F=Ext.lib;var G=F.ColorAnim.superclass;var E=F.ColorAnim.prototype;E.toString=function(){var H=this.getEl();var I=H.id||H.tagName;return("ColorAnim "+I)};E.patterns.color=/color$/i;E.patterns.rgb=/^rgb\(([0-9]+)\s*,\s*([0-9]+)\s*,\s*([0-9]+)\)$/i;E.patterns.hex=/^#?([0-9A-F]{2})([0-9A-F]{2})([0-9A-F]{2})$/i;E.patterns.hex3=/^#?([0-9A-F]{1})([0-9A-F]{1})([0-9A-F]{1})$/i;E.patterns.transparent=/^transparent|rgba\(0, 0, 0, 0\)$/;E.parseColor=function(H){if(H.length==3){return H}var I=this.patterns.hex.exec(H);if(I&&I.length==4){return[parseInt(I[1],16),parseInt(I[2],16),parseInt(I[3],16)]}I=this.patterns.rgb.exec(H);if(I&&I.length==4){return[parseInt(I[1],10),parseInt(I[2],10),parseInt(I[3],10)]}I=this.patterns.hex3.exec(H);if(I&&I.length==4){return[parseInt(I[1]+I[1],16),parseInt(I[2]+I[2],16),parseInt(I[3]+I[3],16)]}return null};E.getAttribute=function(H){var J=this.getEl();if(this.patterns.color.test(H)){var K=C(J).getStyle(H);if(this.patterns.transparent.test(K)){var I=J.parentNode;K=C(I).getStyle(H);while(I&&this.patterns.transparent.test(K)){I=I.parentNode;K=C(I).getStyle(H);if(I.tagName.toUpperCase()=="HTML"){K="#fff"}}}}else{K=G.getAttribute.call(this,H)}return K};E.doMethod=function(I,M,J){var L;if(this.patterns.color.test(I)){L=[];for(var K=0,H=M.length;K<H;++K){L[K]=G.doMethod.call(this,I,M[K],J[K])}L="rgb("+Math.floor(L[0])+","+Math.floor(L[1])+","+Math.floor(L[2])+")"}else{L=G.doMethod.call(this,I,M,J)}return L};E.setRuntimeAttribute=function(I){G.setRuntimeAttribute.call(this,I);if(this.patterns.color.test(I)){var K=this.attributes;var M=this.parseColor(this.runtimeAttributes[I].start);var J=this.parseColor(this.runtimeAttributes[I].end);if(typeof K[I]["to"]==="undefined"&&typeof K[I]["by"]!=="undefined"){J=this.parseColor(K[I].by);for(var L=0,H=M.length;L<H;++L){J[L]=M[L]+J[L]}}this.runtimeAttributes[I].start=M;this.runtimeAttributes[I].end=J}}})();Ext.lib.Easing={easeNone:function(F,E,H,G){return H*F/G+E},easeIn:function(F,E,H,G){return H*(F/=G)*F+E},easeOut:function(F,E,H,G){return -H*(F/=G)*(F-2)+E},easeBoth:function(F,E,H,G){if((F/=G/2)<1){return H/2*F*F+E}return -H/2*((--F)*(F-2)-1)+E},easeInStrong:function(F,E,H,G){return H*(F/=G)*F*F*F+E},easeOutStrong:function(F,E,H,G){return -H*((F=F/G-1)*F*F*F-1)+E},easeBothStrong:function(F,E,H,G){if((F/=G/2)<1){return H/2*F*F*F*F+E}return -H/2*((F-=2)*F*F*F-2)+E},elasticIn:function(G,E,K,J,F,I){if(G==0){return E}if((G/=J)==1){return E+K}if(!I){I=J*0.3}if(!F||F<Math.abs(K)){F=K;var H=I/4}else{var H=I/(2*Math.PI)*Math.asin(K/F)}return -(F*Math.pow(2,10*(G-=1))*Math.sin((G*J-H)*(2*Math.PI)/I))+E},elasticOut:function(G,E,K,J,F,I){if(G==0){return E}if((G/=J)==1){return E+K}if(!I){I=J*0.3}if(!F||F<Math.abs(K)){F=K;var H=I/4}else{var H=I/(2*Math.PI)*Math.asin(K/F)}return F*Math.pow(2,-10*G)*Math.sin((G*J-H)*(2*Math.PI)/I)+K+E},elasticBoth:function(G,E,K,J,F,I){if(G==0){return E}if((G/=J/2)==2){return E+K}if(!I){I=J*(0.3*1.5)}if(!F||F<Math.abs(K)){F=K;var H=I/4}else{var H=I/(2*Math.PI)*Math.asin(K/F)}if(G<1){return -0.5*(F*Math.pow(2,10*(G-=1))*Math.sin((G*J-H)*(2*Math.PI)/I))+E}return F*Math.pow(2,-10*(G-=1))*Math.sin((G*J-H)*(2*Math.PI)/I)*0.5+K+E},backIn:function(F,E,I,H,G){if(typeof G=="undefined"){G=1.70158}return I*(F/=H)*F*((G+1)*F-G)+E},backOut:function(F,E,I,H,G){if(typeof G=="undefined"){G=1.70158}return I*((F=F/H-1)*F*((G+1)*F+G)+1)+E},backBoth:function(F,E,I,H,G){if(typeof G=="undefined"){G=1.70158}if((F/=H/2)<1){return I/2*(F*F*(((G*=(1.525))+1)*F-G))+E}return I/2*((F-=2)*F*(((G*=(1.525))+1)*F+G)+2)+E},bounceIn:function(F,E,H,G){return H-Ext.lib.Easing.bounceOut(G-F,0,H,G)+E},bounceOut:function(F,E,H,G){if((F/=G)<(1/2.75)){return H*(7.5625*F*F)+E}else{if(F<(2/2.75)){return H*(7.5625*(F-=(1.5/2.75))*F+0.75)+E}else{if(F<(2.5/2.75)){return H*(7.5625*(F-=(2.25/2.75))*F+0.9375)+E}}}return H*(7.5625*(F-=(2.625/2.75))*F+0.984375)+E},bounceBoth:function(F,E,H,G){if(F<G/2){return Ext.lib.Easing.bounceIn(F*2,0,H,G)*0.5+E}return Ext.lib.Easing.bounceOut(F*2-G,0,H,G)*0.5+H*0.5+E}};(function(){Ext.lib.Motion=function(K,J,L,M){if(K){Ext.lib.Motion.superclass.constructor.call(this,K,J,L,M)}};Ext.extend(Ext.lib.Motion,Ext.lib.ColorAnim);var H=Ext.lib;var I=H.Motion.superclass;var F=H.Motion.prototype;F.toString=function(){var J=this.getEl();var K=J.id||J.tagName;return("Motion "+K)};F.patterns.points=/^points$/i;F.setAttribute=function(J,L,K){if(this.patterns.points.test(J)){K=K||"px";I.setAttribute.call(this,"left",L[0],K);I.setAttribute.call(this,"top",L[1],K)}else{I.setAttribute.call(this,J,L,K)}};F.getAttribute=function(J){if(this.patterns.points.test(J)){var K=[I.getAttribute.call(this,"left"),I.getAttribute.call(this,"top")]}else{K=I.getAttribute.call(this,J)}return K};F.doMethod=function(J,N,K){var M=null;if(this.patterns.points.test(J)){var L=this.method(this.currentFrame,0,100,this.totalFrames)/100;M=H.Bezier.getPosition(this.runtimeAttributes[J],L)}else{M=I.doMethod.call(this,J,N,K)}return M};F.setRuntimeAttribute=function(S){if(this.patterns.points.test(S)){var K=this.getEl();var M=this.attributes;var J;var O=M["points"]["control"]||[];var L;var P,R;if(O.length>0&&!Ext.isArray(O[0])){O=[O]}else{var N=[];for(P=0,R=O.length;P<R;++P){N[P]=O[P]}O=N}Ext.fly(K,"_anim").position();if(G(M["points"]["from"])){Ext.lib.Dom.setXY(K,M["points"]["from"])}else{Ext.lib.Dom.setXY(K,Ext.lib.Dom.getXY(K))}J=this.getAttribute("points");if(G(M["points"]["to"])){L=E.call(this,M["points"]["to"],J);var Q=Ext.lib.Dom.getXY(this.getEl());for(P=0,R=O.length;P<R;++P){O[P]=E.call(this,O[P],J)}}else{if(G(M["points"]["by"])){L=[J[0]+M["points"]["by"][0],J[1]+M["points"]["by"][1]];for(P=0,R=O.length;P<R;++P){O[P]=[J[0]+O[P][0],J[1]+O[P][1]]}}}this.runtimeAttributes[S]=[J];if(O.length>0){this.runtimeAttributes[S]=this.runtimeAttributes[S].concat(O)}this.runtimeAttributes[S][this.runtimeAttributes[S].length]=L}else{I.setRuntimeAttribute.call(this,S)}};var E=function(J,L){var K=Ext.lib.Dom.getXY(this.getEl());J=[J[0]-K[0]+L[0],J[1]-K[1]+L[1]];return J};var G=function(J){return(typeof J!=="undefined")}})();(function(){Ext.lib.Scroll=function(I,H,J,K){if(I){Ext.lib.Scroll.superclass.constructor.call(this,I,H,J,K)}};Ext.extend(Ext.lib.Scroll,Ext.lib.ColorAnim);var F=Ext.lib;var G=F.Scroll.superclass;var E=F.Scroll.prototype;E.toString=function(){var H=this.getEl();var I=H.id||H.tagName;return("Scroll "+I)};E.doMethod=function(H,K,I){var J=null;if(H=="scroll"){J=[this.method(this.currentFrame,K[0],I[0]-K[0],this.totalFrames),this.method(this.currentFrame,K[1],I[1]-K[1],this.totalFrames)]}else{J=G.doMethod.call(this,H,K,I)}return J};E.getAttribute=function(H){var J=null;var I=this.getEl();if(H=="scroll"){J=[I.scrollLeft,I.scrollTop]}else{J=G.getAttribute.call(this,H)}return J};E.setAttribute=function(H,K,J){var I=this.getEl();if(H=="scroll"){I.scrollLeft=K[0];I.scrollTop=K[1]}else{G.setAttribute.call(this,H,K,J)}}})()})();

/*
 * Ext JS Library 2.2
 * Copyright(c) 2006-2008, Ext JS, LLC.
 * licensing@extjs.com
 * 
 * http://extjs.com/license
 */

Ext.DomHelper=function(){var L=null;var F=/^(?:br|frame|hr|img|input|link|meta|range|spacer|wbr|area|param|col)$/i;var B=/^table|tbody|tr|td$/i;var A=function(T){if(typeof T=="string"){return T}var O="";if(Ext.isArray(T)){for(var R=0,P=T.length;R<P;R++){O+=A(T[R])}return O}if(!T.tag){T.tag="div"}O+="<"+T.tag;for(var N in T){if(N=="tag"||N=="children"||N=="cn"||N=="html"||typeof T[N]=="function"){continue}if(N=="style"){var S=T["style"];if(typeof S=="function"){S=S.call()}if(typeof S=="string"){O+=" style=\""+S+"\""}else{if(typeof S=="object"){O+=" style=\"";for(var Q in S){if(typeof S[Q]!="function"){O+=Q+":"+S[Q]+";"}}O+="\""}}}else{if(N=="cls"){O+=" class=\""+T["cls"]+"\""}else{if(N=="htmlFor"){O+=" for=\""+T["htmlFor"]+"\""}else{O+=" "+N+"=\""+T[N]+"\""}}}}if(F.test(T.tag)){O+="/>"}else{O+=">";var U=T.children||T.cn;if(U){O+=A(U)}else{if(T.html){O+=T.html}}O+="</"+T.tag+">"}return O};var M=function(T,O){var S;if(Ext.isArray(T)){S=document.createDocumentFragment();for(var R=0,P=T.length;R<P;R++){M(T[R],S)}}else{if(typeof T=="string"){S=document.createTextNode(T)}else{S=document.createElement(T.tag||"div");var Q=!!S.setAttribute;for(var N in T){if(N=="tag"||N=="children"||N=="cn"||N=="html"||N=="style"||typeof T[N]=="function"){continue}if(N=="cls"){S.className=T["cls"]}else{if(Q){S.setAttribute(N,T[N])}else{S[N]=T[N]}}}Ext.DomHelper.applyStyles(S,T.style);var U=T.children||T.cn;if(U){M(U,S)}else{if(T.html){S.innerHTML=T.html}}}}if(O){O.appendChild(S)}return S};var I=function(S,Q,P,R){L.innerHTML=[Q,P,R].join("");var N=-1,O=L;while(++N<S){O=O.firstChild}return O};var J="<table>",E="</table>",C=J+"<tbody>",K="</tbody>"+E,H=C+"<tr>",D="</tr>"+K;var G=function(N,O,Q,P){if(!L){L=document.createElement("div")}var R;var S=null;if(N=="td"){if(O=="afterbegin"||O=="beforeend"){return }if(O=="beforebegin"){S=Q;Q=Q.parentNode}else{S=Q.nextSibling;Q=Q.parentNode}R=I(4,H,P,D)}else{if(N=="tr"){if(O=="beforebegin"){S=Q;Q=Q.parentNode;R=I(3,C,P,K)}else{if(O=="afterend"){S=Q.nextSibling;Q=Q.parentNode;R=I(3,C,P,K)}else{if(O=="afterbegin"){S=Q.firstChild}R=I(4,H,P,D)}}}else{if(N=="tbody"){if(O=="beforebegin"){S=Q;Q=Q.parentNode;R=I(2,J,P,E)}else{if(O=="afterend"){S=Q.nextSibling;Q=Q.parentNode;R=I(2,J,P,E)}else{if(O=="afterbegin"){S=Q.firstChild}R=I(3,C,P,K)}}}else{if(O=="beforebegin"||O=="afterend"){return }if(O=="afterbegin"){S=Q.firstChild}R=I(2,J,P,E)}}}Q.insertBefore(R,S);return R};return{useDom:false,markup:function(N){return A(N)},applyStyles:function(P,Q){if(Q){P=Ext.fly(P);if(typeof Q=="string"){var O=/\s?([a-z\-]*)\:\s?([^;]*);?/gi;var R;while((R=O.exec(Q))!=null){P.setStyle(R[1],R[2])}}else{if(typeof Q=="object"){for(var N in Q){P.setStyle(N,Q[N])}}else{if(typeof Q=="function"){Ext.DomHelper.applyStyles(P,Q.call())}}}}},insertHtml:function(P,R,Q){P=P.toLowerCase();if(R.insertAdjacentHTML){if(B.test(R.tagName)){var O;if(O=G(R.tagName.toLowerCase(),P,R,Q)){return O}}switch(P){case"beforebegin":R.insertAdjacentHTML("BeforeBegin",Q);return R.previousSibling;case"afterbegin":R.insertAdjacentHTML("AfterBegin",Q);return R.firstChild;case"beforeend":R.insertAdjacentHTML("BeforeEnd",Q);return R.lastChild;case"afterend":R.insertAdjacentHTML("AfterEnd",Q);return R.nextSibling}throw"Illegal insertion point -> \""+P+"\""}var N=R.ownerDocument.createRange();var S;switch(P){case"beforebegin":N.setStartBefore(R);S=N.createContextualFragment(Q);R.parentNode.insertBefore(S,R);return R.previousSibling;case"afterbegin":if(R.firstChild){N.setStartBefore(R.firstChild);S=N.createContextualFragment(Q);R.insertBefore(S,R.firstChild);return R.firstChild}else{R.innerHTML=Q;return R.firstChild}case"beforeend":if(R.lastChild){N.setStartAfter(R.lastChild);S=N.createContextualFragment(Q);R.appendChild(S);return R.lastChild}else{R.innerHTML=Q;return R.lastChild}case"afterend":N.setStartAfter(R);S=N.createContextualFragment(Q);R.parentNode.insertBefore(S,R.nextSibling);return R.nextSibling}throw"Illegal insertion point -> \""+P+"\""},insertBefore:function(N,P,O){return this.doInsert(N,P,O,"beforeBegin")},insertAfter:function(N,P,O){return this.doInsert(N,P,O,"afterEnd","nextSibling")},insertFirst:function(N,P,O){return this.doInsert(N,P,O,"afterBegin","firstChild")},doInsert:function(Q,S,R,T,P){Q=Ext.getDom(Q);var O;if(this.useDom){O=M(S,null);(P==="firstChild"?Q:Q.parentNode).insertBefore(O,P?Q[P]:Q)}else{var N=A(S);O=this.insertHtml(T,Q,N)}return R?Ext.get(O,true):O},append:function(P,R,Q){P=Ext.getDom(P);var O;if(this.useDom){O=M(R,null);P.appendChild(O)}else{var N=A(R);O=this.insertHtml("beforeEnd",P,N)}return Q?Ext.get(O,true):O},overwrite:function(N,P,O){N=Ext.getDom(N);N.innerHTML=A(P);return O?Ext.get(N.firstChild,true):N.firstChild},createTemplate:function(O){var N=A(O);return new Ext.Template(N)}}}();
Ext.Template=function(E){var B=arguments;if(Ext.isArray(E)){E=E.join("")}else{if(B.length>1){var C=[];for(var D=0,A=B.length;D<A;D++){if(typeof B[D]=="object"){Ext.apply(this,B[D])}else{C[C.length]=B[D]}}E=C.join("")}}this.html=E;if(this.compiled){this.compile()}};Ext.Template.prototype={applyTemplate:function(B){if(this.compiled){return this.compiled(B)}var A=this.disableFormats!==true;var E=Ext.util.Format,C=this;var D=function(G,I,L,H){if(L&&A){if(L.substr(0,5)=="this."){return C.call(L.substr(5),B[I],B)}else{if(H){var K=/^\s*['"](.*)["']\s*$/;H=H.split(",");for(var J=0,F=H.length;J<F;J++){H[J]=H[J].replace(K,"$1")}H=[B[I]].concat(H)}else{H=[B[I]]}return E[L].apply(E,H)}}else{return B[I]!==undefined?B[I]:""}};return this.html.replace(this.re,D)},set:function(A,B){this.html=A;this.compiled=null;if(B){this.compile()}return this},disableFormats:false,re:/\{([\w-]+)(?:\:([\w\.]*)(?:\((.*?)?\))?)?\}/g,compile:function(){var fm=Ext.util.Format;var useF=this.disableFormats!==true;var sep=Ext.isGecko?"+":",";var fn=function(m,name,format,args){if(format&&useF){args=args?","+args:"";if(format.substr(0,5)!="this."){format="fm."+format+"("}else{format="this.call(\""+format.substr(5)+"\", ";args=", values"}}else{args="";format="(values['"+name+"'] == undefined ? '' : "}return"'"+sep+format+"values['"+name+"']"+args+")"+sep+"'"};var body;if(Ext.isGecko){body="this.compiled = function(values){ return '"+this.html.replace(/\\/g,"\\\\").replace(/(\r\n|\n)/g,"\\n").replace(/'/g,"\\'").replace(this.re,fn)+"';};"}else{body=["this.compiled = function(values){ return ['"];body.push(this.html.replace(/\\/g,"\\\\").replace(/(\r\n|\n)/g,"\\n").replace(/'/g,"\\'").replace(this.re,fn));body.push("'].join('');};");body=body.join("")}eval(body);return this},call:function(C,B,A){return this[C](B,A)},insertFirst:function(B,A,C){return this.doInsert("afterBegin",B,A,C)},insertBefore:function(B,A,C){return this.doInsert("beforeBegin",B,A,C)},insertAfter:function(B,A,C){return this.doInsert("afterEnd",B,A,C)},append:function(B,A,C){return this.doInsert("beforeEnd",B,A,C)},doInsert:function(C,E,B,A){E=Ext.getDom(E);var D=Ext.DomHelper.insertHtml(C,E,this.applyTemplate(B));return A?Ext.get(D,true):D},overwrite:function(B,A,C){B=Ext.getDom(B);B.innerHTML=this.applyTemplate(A);return C?Ext.get(B.firstChild,true):B.firstChild}};Ext.Template.prototype.apply=Ext.Template.prototype.applyTemplate;Ext.DomHelper.Template=Ext.Template;Ext.Template.from=function(B,A){B=Ext.getDom(B);return new Ext.Template(B.value||B.innerHTML,A||"")};
Ext.DomQuery=function(){var cache={},simpleCache={},valueCache={};var nonSpace=/\S/;var trimRe=/^\s+|\s+$/g;var tplRe=/\{(\d+)\}/g;var modeRe=/^(\s?[\/>+~]\s?|\s|$)/;var tagTokenRe=/^(#)?([\w-\*]+)/;var nthRe=/(\d*)n\+?(\d*)/,nthRe2=/\D/;function child(p,index){var i=0;var n=p.firstChild;while(n){if(n.nodeType==1){if(++i==index){return n}}n=n.nextSibling}return null}function next(n){while((n=n.nextSibling)&&n.nodeType!=1){}return n}function prev(n){while((n=n.previousSibling)&&n.nodeType!=1){}return n}function children(d){var n=d.firstChild,ni=-1;while(n){var nx=n.nextSibling;if(n.nodeType==3&&!nonSpace.test(n.nodeValue)){d.removeChild(n)}else{n.nodeIndex=++ni}n=nx}return this}function byClassName(c,a,v){if(!v){return c}var r=[],ri=-1,cn;for(var i=0,ci;ci=c[i];i++){if((" "+ci.className+" ").indexOf(v)!=-1){r[++ri]=ci}}return r}function attrValue(n,attr){if(!n.tagName&&typeof n.length!="undefined"){n=n[0]}if(!n){return null}if(attr=="for"){return n.htmlFor}if(attr=="class"||attr=="className"){return n.className}return n.getAttribute(attr)||n[attr]}function getNodes(ns,mode,tagName){var result=[],ri=-1,cs;if(!ns){return result}tagName=tagName||"*";if(typeof ns.getElementsByTagName!="undefined"){ns=[ns]}if(!mode){for(var i=0,ni;ni=ns[i];i++){cs=ni.getElementsByTagName(tagName);for(var j=0,ci;ci=cs[j];j++){result[++ri]=ci}}}else{if(mode=="/"||mode==">"){var utag=tagName.toUpperCase();for(var i=0,ni,cn;ni=ns[i];i++){cn=ni.children||ni.childNodes;for(var j=0,cj;cj=cn[j];j++){if(cj.nodeName==utag||cj.nodeName==tagName||tagName=="*"){result[++ri]=cj}}}}else{if(mode=="+"){var utag=tagName.toUpperCase();for(var i=0,n;n=ns[i];i++){while((n=n.nextSibling)&&n.nodeType!=1){}if(n&&(n.nodeName==utag||n.nodeName==tagName||tagName=="*")){result[++ri]=n}}}else{if(mode=="~"){for(var i=0,n;n=ns[i];i++){while((n=n.nextSibling)&&(n.nodeType!=1||(tagName=="*"||n.tagName.toLowerCase()!=tagName))){}if(n){result[++ri]=n}}}}}}return result}function concat(a,b){if(b.slice){return a.concat(b)}for(var i=0,l=b.length;i<l;i++){a[a.length]=b[i]}return a}function byTag(cs,tagName){if(cs.tagName||cs==document){cs=[cs]}if(!tagName){return cs}var r=[],ri=-1;tagName=tagName.toLowerCase();for(var i=0,ci;ci=cs[i];i++){if(ci.nodeType==1&&ci.tagName.toLowerCase()==tagName){r[++ri]=ci}}return r}function byId(cs,attr,id){if(cs.tagName||cs==document){cs=[cs]}if(!id){return cs}var r=[],ri=-1;for(var i=0,ci;ci=cs[i];i++){if(ci&&ci.id==id){r[++ri]=ci;return r}}return r}function byAttribute(cs,attr,value,op,custom){var r=[],ri=-1,st=custom=="{";var f=Ext.DomQuery.operators[op];for(var i=0,ci;ci=cs[i];i++){var a;if(st){a=Ext.DomQuery.getStyle(ci,attr)}else{if(attr=="class"||attr=="className"){a=ci.className}else{if(attr=="for"){a=ci.htmlFor}else{if(attr=="href"){a=ci.getAttribute("href",2)}else{a=ci.getAttribute(attr)}}}}if((f&&f(a,value))||(!f&&a)){r[++ri]=ci}}return r}function byPseudo(cs,name,value){return Ext.DomQuery.pseudos[name](cs,value)}var isIE=window.ActiveXObject?true:false;eval("var batch = 30803;");var key=30803;function nodupIEXml(cs){var d=++key;cs[0].setAttribute("_nodup",d);var r=[cs[0]];for(var i=1,len=cs.length;i<len;i++){var c=cs[i];if(!c.getAttribute("_nodup")!=d){c.setAttribute("_nodup",d);r[r.length]=c}}for(var i=0,len=cs.length;i<len;i++){cs[i].removeAttribute("_nodup")}return r}function nodup(cs){if(!cs){return[]}var len=cs.length,c,i,r=cs,cj,ri=-1;if(!len||typeof cs.nodeType!="undefined"||len==1){return cs}if(isIE&&typeof cs[0].selectSingleNode!="undefined"){return nodupIEXml(cs)}var d=++key;cs[0]._nodup=d;for(i=1;c=cs[i];i++){if(c._nodup!=d){c._nodup=d}else{r=[];for(var j=0;j<i;j++){r[++ri]=cs[j]}for(j=i+1;cj=cs[j];j++){if(cj._nodup!=d){cj._nodup=d;r[++ri]=cj}}return r}}return r}function quickDiffIEXml(c1,c2){var d=++key;for(var i=0,len=c1.length;i<len;i++){c1[i].setAttribute("_qdiff",d)}var r=[];for(var i=0,len=c2.length;i<len;i++){if(c2[i].getAttribute("_qdiff")!=d){r[r.length]=c2[i]}}for(var i=0,len=c1.length;i<len;i++){c1[i].removeAttribute("_qdiff")}return r}function quickDiff(c1,c2){var len1=c1.length;if(!len1){return c2}if(isIE&&c1[0].selectSingleNode){return quickDiffIEXml(c1,c2)}var d=++key;for(var i=0;i<len1;i++){c1[i]._qdiff=d}var r=[];for(var i=0,len=c2.length;i<len;i++){if(c2[i]._qdiff!=d){r[r.length]=c2[i]}}return r}function quickId(ns,mode,root,id){if(ns==root){var d=root.ownerDocument||root;return d.getElementById(id)}ns=getNodes(ns,mode,"*");return byId(ns,null,id)}return{getStyle:function(el,name){return Ext.fly(el).getStyle(name)},compile:function(path,type){type=type||"select";var fn=["var f = function(root){\n var mode; ++batch; var n = root || document;\n"];var q=path,mode,lq;var tk=Ext.DomQuery.matchers;var tklen=tk.length;var mm;var lmode=q.match(modeRe);if(lmode&&lmode[1]){fn[fn.length]="mode=\""+lmode[1].replace(trimRe,"")+"\";";q=q.replace(lmode[1],"")}while(path.substr(0,1)=="/"){path=path.substr(1)}while(q&&lq!=q){lq=q;var tm=q.match(tagTokenRe);if(type=="select"){if(tm){if(tm[1]=="#"){fn[fn.length]="n = quickId(n, mode, root, \""+tm[2]+"\");"}else{fn[fn.length]="n = getNodes(n, mode, \""+tm[2]+"\");"}q=q.replace(tm[0],"")}else{if(q.substr(0,1)!="@"){fn[fn.length]="n = getNodes(n, mode, \"*\");"}}}else{if(tm){if(tm[1]=="#"){fn[fn.length]="n = byId(n, null, \""+tm[2]+"\");"}else{fn[fn.length]="n = byTag(n, \""+tm[2]+"\");"}q=q.replace(tm[0],"")}}while(!(mm=q.match(modeRe))){var matched=false;for(var j=0;j<tklen;j++){var t=tk[j];var m=q.match(t.re);if(m){fn[fn.length]=t.select.replace(tplRe,function(x,i){return m[i]});q=q.replace(m[0],"");matched=true;break}}if(!matched){throw"Error parsing selector, parsing failed at \""+q+"\""}}if(mm[1]){fn[fn.length]="mode=\""+mm[1].replace(trimRe,"")+"\";";q=q.replace(mm[1],"")}}fn[fn.length]="return nodup(n);\n}";eval(fn.join(""));return f},select:function(path,root,type){if(!root||root==document){root=document}if(typeof root=="string"){root=document.getElementById(root)}var paths=path.split(",");var results=[];for(var i=0,len=paths.length;i<len;i++){var p=paths[i].replace(trimRe,"");if(!cache[p]){cache[p]=Ext.DomQuery.compile(p);if(!cache[p]){throw p+" is not a valid selector"}}var result=cache[p](root);if(result&&result!=document){results=results.concat(result)}}if(paths.length>1){return nodup(results)}return results},selectNode:function(path,root){return Ext.DomQuery.select(path,root)[0]},selectValue:function(path,root,defaultValue){path=path.replace(trimRe,"");if(!valueCache[path]){valueCache[path]=Ext.DomQuery.compile(path,"select")}var n=valueCache[path](root);n=n[0]?n[0]:n;var v=(n&&n.firstChild?n.firstChild.nodeValue:null);return((v===null||v===undefined||v==="")?defaultValue:v)},selectNumber:function(path,root,defaultValue){var v=Ext.DomQuery.selectValue(path,root,defaultValue||0);return parseFloat(v)},is:function(el,ss){if(typeof el=="string"){el=document.getElementById(el)}var isArray=Ext.isArray(el);var result=Ext.DomQuery.filter(isArray?el:[el],ss);return isArray?(result.length==el.length):(result.length>0)},filter:function(els,ss,nonMatches){ss=ss.replace(trimRe,"");if(!simpleCache[ss]){simpleCache[ss]=Ext.DomQuery.compile(ss,"simple")}var result=simpleCache[ss](els);return nonMatches?quickDiff(result,els):result},matchers:[{re:/^\.([\w-]+)/,select:"n = byClassName(n, null, \" {1} \");"},{re:/^\:([\w-]+)(?:\(((?:[^\s>\/]*|.*?))\))?/,select:"n = byPseudo(n, \"{1}\", \"{2}\");"},{re:/^(?:([\[\{])(?:@)?([\w-]+)\s?(?:(=|.=)\s?['"]?(.*?)["']?)?[\]\}])/,select:"n = byAttribute(n, \"{2}\", \"{4}\", \"{3}\", \"{1}\");"},{re:/^#([\w-]+)/,select:"n = byId(n, null, \"{1}\");"},{re:/^@([\w-]+)/,select:"return {firstChild:{nodeValue:attrValue(n, \"{1}\")}};"}],operators:{"=":function(a,v){return a==v},"!=":function(a,v){return a!=v},"^=":function(a,v){return a&&a.substr(0,v.length)==v},"$=":function(a,v){return a&&a.substr(a.length-v.length)==v},"*=":function(a,v){return a&&a.indexOf(v)!==-1},"%=":function(a,v){return(a%v)==0},"|=":function(a,v){return a&&(a==v||a.substr(0,v.length+1)==v+"-")},"~=":function(a,v){return a&&(" "+a+" ").indexOf(" "+v+" ")!=-1}},pseudos:{"first-child":function(c){var r=[],ri=-1,n;for(var i=0,ci;ci=n=c[i];i++){while((n=n.previousSibling)&&n.nodeType!=1){}if(!n){r[++ri]=ci}}return r},"last-child":function(c){var r=[],ri=-1,n;for(var i=0,ci;ci=n=c[i];i++){while((n=n.nextSibling)&&n.nodeType!=1){}if(!n){r[++ri]=ci}}return r},"nth-child":function(c,a){var r=[],ri=-1;var m=nthRe.exec(a=="even"&&"2n"||a=="odd"&&"2n+1"||!nthRe2.test(a)&&"n+"+a||a);var f=(m[1]||1)-0,l=m[2]-0;for(var i=0,n;n=c[i];i++){var pn=n.parentNode;if(batch!=pn._batch){var j=0;for(var cn=pn.firstChild;cn;cn=cn.nextSibling){if(cn.nodeType==1){cn.nodeIndex=++j}}pn._batch=batch}if(f==1){if(l==0||n.nodeIndex==l){r[++ri]=n}}else{if((n.nodeIndex+l)%f==0){r[++ri]=n}}}return r},"only-child":function(c){var r=[],ri=-1;for(var i=0,ci;ci=c[i];i++){if(!prev(ci)&&!next(ci)){r[++ri]=ci}}return r},"empty":function(c){var r=[],ri=-1;for(var i=0,ci;ci=c[i];i++){var cns=ci.childNodes,j=0,cn,empty=true;while(cn=cns[j]){++j;if(cn.nodeType==1||cn.nodeType==3){empty=false;break}}if(empty){r[++ri]=ci}}return r},"contains":function(c,v){var r=[],ri=-1;for(var i=0,ci;ci=c[i];i++){if((ci.textContent||ci.innerText||"").indexOf(v)!=-1){r[++ri]=ci}}return r},"nodeValue":function(c,v){var r=[],ri=-1;for(var i=0,ci;ci=c[i];i++){if(ci.firstChild&&ci.firstChild.nodeValue==v){r[++ri]=ci}}return r},"checked":function(c){var r=[],ri=-1;for(var i=0,ci;ci=c[i];i++){if(ci.checked==true){r[++ri]=ci}}return r},"not":function(c,ss){return Ext.DomQuery.filter(c,ss,true)},"any":function(c,selectors){var ss=selectors.split("|");var r=[],ri=-1,s;for(var i=0,ci;ci=c[i];i++){for(var j=0;s=ss[j];j++){if(Ext.DomQuery.is(ci,s)){r[++ri]=ci;break}}}return r},"odd":function(c){return this["nth-child"](c,"odd")},"even":function(c){return this["nth-child"](c,"even")},"nth":function(c,a){return c[a-1]||[]},"first":function(c){return c[0]||[]},"last":function(c){return c[c.length-1]||[]},"has":function(c,ss){var s=Ext.DomQuery.select;var r=[],ri=-1;for(var i=0,ci;ci=c[i];i++){if(s(ss,ci).length>0){r[++ri]=ci}}return r},"next":function(c,ss){var is=Ext.DomQuery.is;var r=[],ri=-1;for(var i=0,ci;ci=c[i];i++){var n=next(ci);if(n&&is(n,ss)){r[++ri]=ci}}return r},"prev":function(c,ss){var is=Ext.DomQuery.is;var r=[],ri=-1;for(var i=0,ci;ci=c[i];i++){var n=prev(ci);if(n&&is(n,ss)){r[++ri]=ci}}return r}}}}();Ext.query=Ext.DomQuery.select;
Ext.util.Observable=function(){if(this.listeners){this.on(this.listeners);delete this.listeners}};Ext.util.Observable.prototype={fireEvent:function(){if(this.eventsSuspended!==true){var A=this.events[arguments[0].toLowerCase()];if(typeof A=="object"){return A.fire.apply(A,Array.prototype.slice.call(arguments,1))}}return true},filterOptRe:/^(?:scope|delay|buffer|single)$/,addListener:function(A,C,B,F){if(typeof A=="object"){F=A;for(var E in F){if(this.filterOptRe.test(E)){continue}if(typeof F[E]=="function"){this.addListener(E,F[E],F.scope,F)}else{this.addListener(E,F[E].fn,F[E].scope,F[E])}}return }F=(!F||typeof F=="boolean")?{}:F;A=A.toLowerCase();var D=this.events[A]||true;if(typeof D=="boolean"){D=new Ext.util.Event(this,A);this.events[A]=D}D.addListener(C,B,F)},removeListener:function(A,C,B){var D=this.events[A.toLowerCase()];if(typeof D=="object"){D.removeListener(C,B)}},purgeListeners:function(){for(var A in this.events){if(typeof this.events[A]=="object"){this.events[A].clearListeners()}}},relayEvents:function(F,D){var E=function(G){return function(){return this.fireEvent.apply(this,Ext.combine(G,Array.prototype.slice.call(arguments,0)))}};for(var C=0,A=D.length;C<A;C++){var B=D[C];if(!this.events[B]){this.events[B]=true}F.on(B,E(B),this)}},addEvents:function(D){if(!this.events){this.events={}}if(typeof D=="string"){for(var C=0,A=arguments,B;B=A[C];C++){if(!this.events[A[C]]){this.events[A[C]]=true}}}else{Ext.applyIf(this.events,D)}},hasListener:function(A){var B=this.events[A];return typeof B=="object"&&B.listeners.length>0},suspendEvents:function(){this.eventsSuspended=true},resumeEvents:function(){this.eventsSuspended=false},getMethodEvent:function(G){if(!this.methodEvents){this.methodEvents={}}var F=this.methodEvents[G];if(!F){F={};this.methodEvents[G]=F;F.originalFn=this[G];F.methodName=G;F.before=[];F.after=[];var C,B,D;var E=this;var A=function(J,I,H){if((B=J.apply(I||E,H))!==undefined){if(typeof B==="object"){if(B.returnValue!==undefined){C=B.returnValue}else{C=B}if(B.cancel===true){D=true}}else{if(B===false){D=true}else{C=B}}}};this[G]=function(){C=B=undefined;D=false;var I=Array.prototype.slice.call(arguments,0);for(var J=0,H=F.before.length;J<H;J++){A(F.before[J].fn,F.before[J].scope,I);if(D){return C}}if((B=F.originalFn.apply(E,I))!==undefined){C=B}for(var J=0,H=F.after.length;J<H;J++){A(F.after[J].fn,F.after[J].scope,I);if(D){return C}}return C}}return F},beforeMethod:function(D,B,A){var C=this.getMethodEvent(D);C.before.push({fn:B,scope:A})},afterMethod:function(D,B,A){var C=this.getMethodEvent(D);C.after.push({fn:B,scope:A})},removeMethodListener:function(F,D,C){var E=this.getMethodEvent(F);for(var B=0,A=E.before.length;B<A;B++){if(E.before[B].fn==D&&E.before[B].scope==C){E.before.splice(B,1);return }}for(var B=0,A=E.after.length;B<A;B++){if(E.after[B].fn==D&&E.after[B].scope==C){E.after.splice(B,1);return }}}};Ext.util.Observable.prototype.on=Ext.util.Observable.prototype.addListener;Ext.util.Observable.prototype.un=Ext.util.Observable.prototype.removeListener;Ext.util.Observable.capture=function(C,B,A){C.fireEvent=C.fireEvent.createInterceptor(B,A)};Ext.util.Observable.releaseCapture=function(A){A.fireEvent=Ext.util.Observable.prototype.fireEvent};(function(){var B=function(F,G,E){var D=new Ext.util.DelayedTask();return function(){D.delay(G.buffer,F,E,Array.prototype.slice.call(arguments,0))}};var C=function(F,G,E,D){return function(){G.removeListener(E,D);return F.apply(D,arguments)}};var A=function(E,F,D){return function(){var G=Array.prototype.slice.call(arguments,0);setTimeout(function(){E.apply(D,G)},F.delay||10)}};Ext.util.Event=function(E,D){this.name=D;this.obj=E;this.listeners=[]};Ext.util.Event.prototype={addListener:function(G,F,E){F=F||this.obj;if(!this.isListening(G,F)){var D=this.createListener(G,F,E);if(!this.firing){this.listeners.push(D)}else{this.listeners=this.listeners.slice(0);this.listeners.push(D)}}},createListener:function(G,F,H){H=H||{};F=F||this.obj;var D={fn:G,scope:F,options:H};var E=G;if(H.delay){E=A(E,H,F)}if(H.single){E=C(E,this,G,F)}if(H.buffer){E=B(E,H,F)}D.fireFn=E;return D},findListener:function(I,H){H=H||this.obj;var F=this.listeners;for(var G=0,D=F.length;G<D;G++){var E=F[G];if(E.fn==I&&E.scope==H){return G}}return -1},isListening:function(E,D){return this.findListener(E,D)!=-1},removeListener:function(F,E){var D;if((D=this.findListener(F,E))!=-1){if(!this.firing){this.listeners.splice(D,1)}else{this.listeners=this.listeners.slice(0);this.listeners.splice(D,1)}return true}return false},clearListeners:function(){this.listeners=[]},fire:function(){var F=this.listeners,I,D=F.length;if(D>0){this.firing=true;var G=Array.prototype.slice.call(arguments,0);for(var H=0;H<D;H++){var E=F[H];if(E.fireFn.apply(E.scope||this.obj||window,arguments)===false){this.firing=false;return false}}this.firing=false}return true}}})();
Ext.EventManager=function(){var X,Q,M=false;var N,W,H,S;var P=Ext.lib.Event;var R=Ext.lib.Dom;var A="Ex"+"t";var J={};var O=function(b,E,a,Z,Y){var d=Ext.id(b);if(!J[d]){J[d]={}}var c=J[d];if(!c[E]){c[E]=[]}var D=c[E];D.push({id:d,ename:E,fn:a,wrap:Z,scope:Y});P.on(b,E,Z);if(E=="mousewheel"&&b.addEventListener){b.addEventListener("DOMMouseScroll",Z,false);P.on(window,"unload",function(){b.removeEventListener("DOMMouseScroll",Z,false)})}if(E=="mousedown"&&b==document){Ext.EventManager.stoppedMouseDownEvent.addListener(Z)}};var I=function(Y,a,e,g){Y=Ext.getDom(Y);var D=Ext.id(Y),f=J[D],E;if(f){var c=f[a],Z;if(c){for(var b=0,d=c.length;b<d;b++){Z=c[b];if(Z.fn==e&&(!g||Z.scope==g)){E=Z.wrap;P.un(Y,a,E);c.splice(b,1);break}}}}if(a=="mousewheel"&&Y.addEventListener&&E){Y.removeEventListener("DOMMouseScroll",E,false)}if(a=="mousedown"&&Y==document&&E){Ext.EventManager.stoppedMouseDownEvent.removeListener(E)}};var F=function(a){a=Ext.getDom(a);var c=Ext.id(a),b=J[c],E;if(b){for(var Z in b){if(b.hasOwnProperty(Z)){E=b[Z];for(var Y=0,D=E.length;Y<D;Y++){P.un(a,Z,E[Y].wrap);E[Y]=null}}b[Z]=null}delete J[c]}};var C=function(){if(!M){M=Ext.isReady=true;if(Ext.isGecko||Ext.isOpera){document.removeEventListener("DOMContentLoaded",C,false)}}if(Q){clearInterval(Q);Q=null}if(X){X.fire();X.clearListeners()}};var B=function(){X=new Ext.util.Event();if(Ext.isReady){return }P.on(window,"load",C);if(Ext.isGecko||Ext.isOpera){document.addEventListener("DOMContentLoaded",C,false)}else{if(Ext.isIE){Q=setInterval(function(){try{Ext.isReady||(document.documentElement.doScroll("left"))}catch(D){return }C()},5);document.onreadystatechange=function(){if(document.readyState=="complete"){document.onreadystatechange=null;C()}}}else{if(Ext.isSafari){Q=setInterval(function(){var D=document.readyState;if(D=="complete"){C()}},10)}}}};var V=function(E,Y){var D=new Ext.util.DelayedTask(E);return function(Z){Z=new Ext.EventObjectImpl(Z);D.delay(Y.buffer,E,null,[Z])}};var T=function(a,Z,D,Y,E){return function(b){Ext.EventManager.removeListener(Z,D,Y,E);a(b)}};var G=function(D,E){return function(Y){Y=new Ext.EventObjectImpl(Y);setTimeout(function(){D(Y)},E.delay||10)}};var L=function(Y,E,D,c,b){var d=(!D||typeof D=="boolean")?{}:D;c=c||d.fn;b=b||d.scope;var a=Ext.getDom(Y);if(!a){throw"Error listening for \""+E+"\". Element \""+Y+"\" doesn't exist."}var Z=function(g){if(!window[A]){return }g=Ext.EventObject.setEvent(g);var f;if(d.delegate){f=g.getTarget(d.delegate,a);if(!f){return }}else{f=g.target}if(d.stopEvent===true){g.stopEvent()}if(d.preventDefault===true){g.preventDefault()}if(d.stopPropagation===true){g.stopPropagation()}if(d.normalized===false){g=g.browserEvent}c.call(b||a,g,f,d)};if(d.delay){Z=G(Z,d)}if(d.single){Z=T(Z,a,E,c,b)}if(d.buffer){Z=V(Z,d)}O(a,E,c,Z,b);return Z};var K=/^(?:scope|delay|buffer|single|stopEvent|preventDefault|stopPropagation|normalized|args|delegate)$/;var U={addListener:function(Y,D,a,Z,E){if(typeof D=="object"){var c=D;for(var b in c){if(K.test(b)){continue}if(typeof c[b]=="function"){L(Y,b,c,c[b],c.scope)}else{L(Y,b,c[b])}}return }return L(Y,D,E,a,Z)},removeListener:function(E,D,Z,Y){return I(E,D,Z,Y)},removeAll:function(D){return F(D)},onDocumentReady:function(Y,E,D){if(!X){B()}if(M||Ext.isReady){D||(D={});Y.defer(D.delay||0,E)}else{X.addListener(Y,E,D)}},onWindowResize:function(Y,E,D){if(!N){N=new Ext.util.Event();W=new Ext.util.DelayedTask(function(){N.fire(R.getViewWidth(),R.getViewHeight())});P.on(window,"resize",this.fireWindowResize,this)}N.addListener(Y,E,D)},fireWindowResize:function(){if(N){if((Ext.isIE||Ext.isAir)&&W){W.delay(50)}else{N.fire(R.getViewWidth(),R.getViewHeight())}}},onTextResize:function(Z,Y,D){if(!H){H=new Ext.util.Event();var E=new Ext.Element(document.createElement("div"));E.dom.className="x-text-resize";E.dom.innerHTML="X";E.appendTo(document.body);S=E.dom.offsetHeight;setInterval(function(){if(E.dom.offsetHeight!=S){H.fire(S,S=E.dom.offsetHeight)}},this.textResizeInterval)}H.addListener(Z,Y,D)},removeResizeListener:function(E,D){if(N){N.removeListener(E,D)}},fireResize:function(){if(N){N.fire(R.getViewWidth(),R.getViewHeight())}},ieDeferSrc:false,textResizeInterval:50};U.on=U.addListener;U.un=U.removeListener;U.stoppedMouseDownEvent=new Ext.util.Event();return U}();Ext.onReady=Ext.EventManager.onDocumentReady;(function(){var A=function(){var C=document.body||document.getElementsByTagName("body")[0];if(!C){return false}var B=[" ",Ext.isIE?"ext-ie "+(Ext.isIE6?"ext-ie6":"ext-ie7"):Ext.isGecko?"ext-gecko "+(Ext.isGecko2?"ext-gecko2":"ext-gecko3"):Ext.isOpera?"ext-opera":Ext.isSafari?"ext-safari":""];if(Ext.isMac){B.push("ext-mac")}if(Ext.isLinux){B.push("ext-linux")}if(Ext.isBorderBox){B.push("ext-border-box")}if(Ext.isStrict){var D=C.parentNode;if(D){D.className+=" ext-strict"}}C.className+=B.join(" ");return true};if(!A()){Ext.onReady(A)}})();Ext.EventObject=function(){var B=Ext.lib.Event;var A={3:13,63234:37,63235:39,63232:38,63233:40,63276:33,63277:34,63272:46,63273:36,63275:35};var C=Ext.isIE?{1:0,4:1,2:2}:(Ext.isSafari?{1:0,2:1,3:2}:{0:0,1:1,2:2});Ext.EventObjectImpl=function(D){if(D){this.setEvent(D.browserEvent||D)}};Ext.EventObjectImpl.prototype={browserEvent:null,button:-1,shiftKey:false,ctrlKey:false,altKey:false,BACKSPACE:8,TAB:9,NUM_CENTER:12,ENTER:13,RETURN:13,SHIFT:16,CTRL:17,CONTROL:17,ALT:18,PAUSE:19,CAPS_LOCK:20,ESC:27,SPACE:32,PAGE_UP:33,PAGEUP:33,PAGE_DOWN:34,PAGEDOWN:34,END:35,HOME:36,LEFT:37,UP:38,RIGHT:39,DOWN:40,PRINT_SCREEN:44,INSERT:45,DELETE:46,ZERO:48,ONE:49,TWO:50,THREE:51,FOUR:52,FIVE:53,SIX:54,SEVEN:55,EIGHT:56,NINE:57,A:65,B:66,C:67,D:68,E:69,F:70,G:71,H:72,I:73,J:74,K:75,L:76,M:77,N:78,O:79,P:80,Q:81,R:82,S:83,T:84,U:85,V:86,W:87,X:88,Y:89,Z:90,CONTEXT_MENU:93,NUM_ZERO:96,NUM_ONE:97,NUM_TWO:98,NUM_THREE:99,NUM_FOUR:100,NUM_FIVE:101,NUM_SIX:102,NUM_SEVEN:103,NUM_EIGHT:104,NUM_NINE:105,NUM_MULTIPLY:106,NUM_PLUS:107,NUM_MINUS:109,NUM_PERIOD:110,NUM_DIVISION:111,F1:112,F2:113,F3:114,F4:115,F5:116,F6:117,F7:118,F8:119,F9:120,F10:121,F11:122,F12:123,setEvent:function(D){if(D==this||(D&&D.browserEvent)){return D}this.browserEvent=D;if(D){this.button=D.button?C[D.button]:(D.which?D.which-1:-1);if(D.type=="click"&&this.button==-1){this.button=0}this.type=D.type;this.shiftKey=D.shiftKey;this.ctrlKey=D.ctrlKey||D.metaKey;this.altKey=D.altKey;this.keyCode=D.keyCode;this.charCode=D.charCode;this.target=B.getTarget(D);this.xy=B.getXY(D)}else{this.button=-1;this.shiftKey=false;this.ctrlKey=false;this.altKey=false;this.keyCode=0;this.charCode=0;this.target=null;this.xy=[0,0]}return this},stopEvent:function(){if(this.browserEvent){if(this.browserEvent.type=="mousedown"){Ext.EventManager.stoppedMouseDownEvent.fire(this)}B.stopEvent(this.browserEvent)}},preventDefault:function(){if(this.browserEvent){B.preventDefault(this.browserEvent)}},isNavKeyPress:function(){var D=this.keyCode;D=Ext.isSafari?(A[D]||D):D;return(D>=33&&D<=40)||D==this.RETURN||D==this.TAB||D==this.ESC},isSpecialKey:function(){var D=this.keyCode;return(this.type=="keypress"&&this.ctrlKey)||D==9||D==13||D==40||D==27||(D==16)||(D==17)||(D>=18&&D<=20)||(D>=33&&D<=35)||(D>=36&&D<=39)||(D>=44&&D<=45)},stopPropagation:function(){if(this.browserEvent){if(this.browserEvent.type=="mousedown"){Ext.EventManager.stoppedMouseDownEvent.fire(this)}B.stopPropagation(this.browserEvent)}},getCharCode:function(){return this.charCode||this.keyCode},getKey:function(){var D=this.keyCode||this.charCode;return Ext.isSafari?(A[D]||D):D},getPageX:function(){return this.xy[0]},getPageY:function(){return this.xy[1]},getTime:function(){if(this.browserEvent){return B.getTime(this.browserEvent)}return null},getXY:function(){return this.xy},getTarget:function(E,F,D){return E?Ext.fly(this.target).findParent(E,F,D):(D?Ext.get(this.target):this.target)},getRelatedTarget:function(){if(this.browserEvent){return B.getRelatedTarget(this.browserEvent)}return null},getWheelDelta:function(){var D=this.browserEvent;var E=0;if(D.wheelDelta){E=D.wheelDelta/120}else{if(D.detail){E=-D.detail/3}}return E},hasModifier:function(){return((this.ctrlKey||this.altKey)||this.shiftKey)?true:false},within:function(E,F){var D=this[F?"getRelatedTarget":"getTarget"]();return D&&Ext.fly(E).contains(D)},getPoint:function(){return new Ext.lib.Point(this.xy[0],this.xy[1])}};return new Ext.EventObjectImpl()}();
(function(){var D=Ext.lib.Dom;var E=Ext.lib.Event;var A=Ext.lib.Anim;var propCache={};var camelRe=/(-[a-z])/gi;var camelFn=function(m,a){return a.charAt(1).toUpperCase()};var view=document.defaultView;Ext.Element=function(element,forceNew){var dom=typeof element=="string"?document.getElementById(element):element;if(!dom){return null}var id=dom.id;if(forceNew!==true&&id&&Ext.Element.cache[id]){return Ext.Element.cache[id]}this.dom=dom;this.id=id||Ext.id(dom)};var El=Ext.Element;El.prototype={originalDisplay:"",visibilityMode:1,defaultUnit:"px",setVisibilityMode:function(visMode){this.visibilityMode=visMode;return this},enableDisplayMode:function(display){this.setVisibilityMode(El.DISPLAY);if(typeof display!="undefined"){this.originalDisplay=display}return this},findParent:function(simpleSelector,maxDepth,returnEl){var p=this.dom,b=document.body,depth=0,dq=Ext.DomQuery,stopEl;maxDepth=maxDepth||50;if(typeof maxDepth!="number"){stopEl=Ext.getDom(maxDepth);maxDepth=10}while(p&&p.nodeType==1&&depth<maxDepth&&p!=b&&p!=stopEl){if(dq.is(p,simpleSelector)){return returnEl?Ext.get(p):p}depth++;p=p.parentNode}return null},findParentNode:function(simpleSelector,maxDepth,returnEl){var p=Ext.fly(this.dom.parentNode,"_internal");return p?p.findParent(simpleSelector,maxDepth,returnEl):null},up:function(simpleSelector,maxDepth){return this.findParentNode(simpleSelector,maxDepth,true)},is:function(simpleSelector){return Ext.DomQuery.is(this.dom,simpleSelector)},animate:function(args,duration,onComplete,easing,animType){this.anim(args,{duration:duration,callback:onComplete,easing:easing},animType);return this},anim:function(args,opt,animType,defaultDur,defaultEase,cb){animType=animType||"run";opt=opt||{};var anim=Ext.lib.Anim[animType](this.dom,args,(opt.duration||defaultDur)||0.35,(opt.easing||defaultEase)||"easeOut",function(){Ext.callback(cb,this);Ext.callback(opt.callback,opt.scope||this,[this,opt])},this);opt.anim=anim;return anim},preanim:function(a,i){return !a[i]?false:(typeof a[i]=="object"?a[i]:{duration:a[i+1],callback:a[i+2],easing:a[i+3]})},clean:function(forceReclean){if(this.isCleaned&&forceReclean!==true){return this}var ns=/\S/;var d=this.dom,n=d.firstChild,ni=-1;while(n){var nx=n.nextSibling;if(n.nodeType==3&&!ns.test(n.nodeValue)){d.removeChild(n)}else{n.nodeIndex=++ni}n=nx}this.isCleaned=true;return this},scrollIntoView:function(container,hscroll){var c=Ext.getDom(container)||Ext.getBody().dom;var el=this.dom;var o=this.getOffsetsTo(c),l=o[0]+c.scrollLeft,t=o[1]+c.scrollTop,b=t+el.offsetHeight,r=l+el.offsetWidth;var ch=c.clientHeight;var ct=parseInt(c.scrollTop,10);var cl=parseInt(c.scrollLeft,10);var cb=ct+ch;var cr=cl+c.clientWidth;if(el.offsetHeight>ch||t<ct){c.scrollTop=t}else{if(b>cb){c.scrollTop=b-ch}}c.scrollTop=c.scrollTop;if(hscroll!==false){if(el.offsetWidth>c.clientWidth||l<cl){c.scrollLeft=l}else{if(r>cr){c.scrollLeft=r-c.clientWidth}}c.scrollLeft=c.scrollLeft}return this},scrollChildIntoView:function(child,hscroll){Ext.fly(child,"_scrollChildIntoView").scrollIntoView(this,hscroll)},autoHeight:function(animate,duration,onComplete,easing){var oldHeight=this.getHeight();this.clip();this.setHeight(1);setTimeout(function(){var height=parseInt(this.dom.scrollHeight,10);if(!animate){this.setHeight(height);this.unclip();if(typeof onComplete=="function"){onComplete()}}else{this.setHeight(oldHeight);this.setHeight(height,animate,duration,function(){this.unclip();if(typeof onComplete=="function"){onComplete()}}.createDelegate(this),easing)}}.createDelegate(this),0);return this},contains:function(el){if(!el){return false}return D.isAncestor(this.dom,el.dom?el.dom:el)},isVisible:function(deep){var vis=!(this.getStyle("visibility")=="hidden"||this.getStyle("display")=="none");if(deep!==true||!vis){return vis}var p=this.dom.parentNode;while(p&&p.tagName.toLowerCase()!="body"){if(!Ext.fly(p,"_isVisible").isVisible()){return false}p=p.parentNode}return true},select:function(selector,unique){return El.select(selector,unique,this.dom)},query:function(selector){return Ext.DomQuery.select(selector,this.dom)},child:function(selector,returnDom){var n=Ext.DomQuery.selectNode(selector,this.dom);return returnDom?n:Ext.get(n)},down:function(selector,returnDom){var n=Ext.DomQuery.selectNode(" > "+selector,this.dom);return returnDom?n:Ext.get(n)},initDD:function(group,config,overrides){var dd=new Ext.dd.DD(Ext.id(this.dom),group,config);return Ext.apply(dd,overrides)},initDDProxy:function(group,config,overrides){var dd=new Ext.dd.DDProxy(Ext.id(this.dom),group,config);return Ext.apply(dd,overrides)},initDDTarget:function(group,config,overrides){var dd=new Ext.dd.DDTarget(Ext.id(this.dom),group,config);return Ext.apply(dd,overrides)},setVisible:function(visible,animate){if(!animate||!A){if(this.visibilityMode==El.DISPLAY){this.setDisplayed(visible)}else{this.fixDisplay();this.dom.style.visibility=visible?"visible":"hidden"}}else{var dom=this.dom;var visMode=this.visibilityMode;if(visible){this.setOpacity(0.01);this.setVisible(true)}this.anim({opacity:{to:(visible?1:0)}},this.preanim(arguments,1),null,0.35,"easeIn",function(){if(!visible){if(visMode==El.DISPLAY){dom.style.display="none"}else{dom.style.visibility="hidden"}Ext.get(dom).setOpacity(1)}})}return this},isDisplayed:function(){return this.getStyle("display")!="none"},toggle:function(animate){this.setVisible(!this.isVisible(),this.preanim(arguments,0));return this},setDisplayed:function(value){if(typeof value=="boolean"){value=value?this.originalDisplay:"none"}this.setStyle("display",value);return this},focus:function(){try{this.dom.focus()}catch(e){}return this},blur:function(){try{this.dom.blur()}catch(e){}return this},addClass:function(className){if(Ext.isArray(className)){for(var i=0,len=className.length;i<len;i++){this.addClass(className[i])}}else{if(className&&!this.hasClass(className)){this.dom.className=this.dom.className+" "+className}}return this},radioClass:function(className){var siblings=this.dom.parentNode.childNodes;for(var i=0;i<siblings.length;i++){var s=siblings[i];if(s.nodeType==1){Ext.get(s).removeClass(className)}}this.addClass(className);return this},removeClass:function(className){if(!className||!this.dom.className){return this}if(Ext.isArray(className)){for(var i=0,len=className.length;i<len;i++){this.removeClass(className[i])}}else{if(this.hasClass(className)){var re=this.classReCache[className];if(!re){re=new RegExp("(?:^|\\s+)"+className+"(?:\\s+|$)","g");this.classReCache[className]=re}this.dom.className=this.dom.className.replace(re," ")}}return this},classReCache:{},toggleClass:function(className){if(this.hasClass(className)){this.removeClass(className)}else{this.addClass(className)}return this},hasClass:function(className){return className&&(" "+this.dom.className+" ").indexOf(" "+className+" ")!=-1},replaceClass:function(oldClassName,newClassName){this.removeClass(oldClassName);this.addClass(newClassName);return this},getStyles:function(){var a=arguments,len=a.length,r={};for(var i=0;i<len;i++){r[a[i]]=this.getStyle(a[i])}return r},getStyle:function(){return view&&view.getComputedStyle?function(prop){var el=this.dom,v,cs,camel;if(prop=="float"){prop="cssFloat"}if(v=el.style[prop]){return v}if(cs=view.getComputedStyle(el,"")){if(!(camel=propCache[prop])){camel=propCache[prop]=prop.replace(camelRe,camelFn)}return cs[camel]}return null}:function(prop){var el=this.dom,v,cs,camel;if(prop=="opacity"){if(typeof el.style.filter=="string"){var m=el.style.filter.match(/alpha\(opacity=(.*)\)/i);if(m){var fv=parseFloat(m[1]);if(!isNaN(fv)){return fv?fv/100:0}}}return 1}else{if(prop=="float"){prop="styleFloat"}}if(!(camel=propCache[prop])){camel=propCache[prop]=prop.replace(camelRe,camelFn)}if(v=el.style[camel]){return v}if(cs=el.currentStyle){return cs[camel]}return null}}(),setStyle:function(prop,value){if(typeof prop=="string"){var camel;if(!(camel=propCache[prop])){camel=propCache[prop]=prop.replace(camelRe,camelFn)}if(camel=="opacity"){this.setOpacity(value)}else{this.dom.style[camel]=value}}else{for(var style in prop){if(typeof prop[style]!="function"){this.setStyle(style,prop[style])}}}return this},applyStyles:function(style){Ext.DomHelper.applyStyles(this.dom,style);return this},getX:function(){return D.getX(this.dom)},getY:function(){return D.getY(this.dom)},getXY:function(){return D.getXY(this.dom)},getOffsetsTo:function(el){var o=this.getXY();var e=Ext.fly(el,"_internal").getXY();return[o[0]-e[0],o[1]-e[1]]},setX:function(x,animate){if(!animate||!A){D.setX(this.dom,x)}else{this.setXY([x,this.getY()],this.preanim(arguments,1))}return this},setY:function(y,animate){if(!animate||!A){D.setY(this.dom,y)}else{this.setXY([this.getX(),y],this.preanim(arguments,1))}return this},setLeft:function(left){this.setStyle("left",this.addUnits(left));return this},setTop:function(top){this.setStyle("top",this.addUnits(top));return this},setRight:function(right){this.setStyle("right",this.addUnits(right));return this},setBottom:function(bottom){this.setStyle("bottom",this.addUnits(bottom));return this},setXY:function(pos,animate){if(!animate||!A){D.setXY(this.dom,pos)}else{this.anim({points:{to:pos}},this.preanim(arguments,1),"motion")}return this},setLocation:function(x,y,animate){this.setXY([x,y],this.preanim(arguments,2));return this},moveTo:function(x,y,animate){this.setXY([x,y],this.preanim(arguments,2));return this},getRegion:function(){return D.getRegion(this.dom)},getHeight:function(contentHeight){var h=this.dom.offsetHeight||0;h=contentHeight!==true?h:h-this.getBorderWidth("tb")-this.getPadding("tb");return h<0?0:h},getWidth:function(contentWidth){var w=this.dom.offsetWidth||0;w=contentWidth!==true?w:w-this.getBorderWidth("lr")-this.getPadding("lr");return w<0?0:w},getComputedHeight:function(){var h=Math.max(this.dom.offsetHeight,this.dom.clientHeight);if(!h){h=parseInt(this.getStyle("height"),10)||0;if(!this.isBorderBox()){h+=this.getFrameWidth("tb")}}return h},getComputedWidth:function(){var w=Math.max(this.dom.offsetWidth,this.dom.clientWidth);if(!w){w=parseInt(this.getStyle("width"),10)||0;if(!this.isBorderBox()){w+=this.getFrameWidth("lr")}}return w},getSize:function(contentSize){return{width:this.getWidth(contentSize),height:this.getHeight(contentSize)}},getStyleSize:function(){var w,h,d=this.dom,s=d.style;if(s.width&&s.width!="auto"){w=parseInt(s.width,10);if(Ext.isBorderBox){w-=this.getFrameWidth("lr")}}if(s.height&&s.height!="auto"){h=parseInt(s.height,10);if(Ext.isBorderBox){h-=this.getFrameWidth("tb")}}return{width:w||this.getWidth(true),height:h||this.getHeight(true)}},getViewSize:function(){var d=this.dom,doc=document,aw=0,ah=0;if(d==doc||d==doc.body){return{width:D.getViewWidth(),height:D.getViewHeight()}}else{return{width:d.clientWidth,height:d.clientHeight}}},getValue:function(asNumber){return asNumber?parseInt(this.dom.value,10):this.dom.value},adjustWidth:function(width){if(typeof width=="number"){if(this.autoBoxAdjust&&!this.isBorderBox()){width-=(this.getBorderWidth("lr")+this.getPadding("lr"))}if(width<0){width=0}}return width},adjustHeight:function(height){if(typeof height=="number"){if(this.autoBoxAdjust&&!this.isBorderBox()){height-=(this.getBorderWidth("tb")+this.getPadding("tb"))}if(height<0){height=0}}return height},setWidth:function(width,animate){width=this.adjustWidth(width);if(!animate||!A){this.dom.style.width=this.addUnits(width)}else{this.anim({width:{to:width}},this.preanim(arguments,1))}return this},setHeight:function(height,animate){height=this.adjustHeight(height);if(!animate||!A){this.dom.style.height=this.addUnits(height)}else{this.anim({height:{to:height}},this.preanim(arguments,1))}return this},setSize:function(width,height,animate){if(typeof width=="object"){height=width.height;width=width.width}width=this.adjustWidth(width);height=this.adjustHeight(height);if(!animate||!A){this.dom.style.width=this.addUnits(width);this.dom.style.height=this.addUnits(height)}else{this.anim({width:{to:width},height:{to:height}},this.preanim(arguments,2))}return this},setBounds:function(x,y,width,height,animate){if(!animate||!A){this.setSize(width,height);this.setLocation(x,y)}else{width=this.adjustWidth(width);height=this.adjustHeight(height);this.anim({points:{to:[x,y]},width:{to:width},height:{to:height}},this.preanim(arguments,4),"motion")}return this},setRegion:function(region,animate){this.setBounds(region.left,region.top,region.right-region.left,region.bottom-region.top,this.preanim(arguments,1));return this},addListener:function(eventName,fn,scope,options){Ext.EventManager.on(this.dom,eventName,fn,scope||this,options)},removeListener:function(eventName,fn,scope){Ext.EventManager.removeListener(this.dom,eventName,fn,scope||this);return this},removeAllListeners:function(){Ext.EventManager.removeAll(this.dom);return this},relayEvent:function(eventName,observable){this.on(eventName,function(e){observable.fireEvent(eventName,e)})},setOpacity:function(opacity,animate){if(!animate||!A){var s=this.dom.style;if(Ext.isIE){s.zoom=1;s.filter=(s.filter||"").replace(/alpha\([^\)]*\)/gi,"")+(opacity==1?"":" alpha(opacity="+opacity*100+")")}else{s.opacity=opacity}}else{this.anim({opacity:{to:opacity}},this.preanim(arguments,1),null,0.35,"easeIn")}return this},getLeft:function(local){if(!local){return this.getX()}else{return parseInt(this.getStyle("left"),10)||0}},getRight:function(local){if(!local){return this.getX()+this.getWidth()}else{return(this.getLeft(true)+this.getWidth())||0}},getTop:function(local){if(!local){return this.getY()}else{return parseInt(this.getStyle("top"),10)||0}},getBottom:function(local){if(!local){return this.getY()+this.getHeight()}else{return(this.getTop(true)+this.getHeight())||0}},position:function(pos,zIndex,x,y){if(!pos){if(this.getStyle("position")=="static"){this.setStyle("position","relative")}}else{this.setStyle("position",pos)}if(zIndex){this.setStyle("z-index",zIndex)}if(x!==undefined&&y!==undefined){this.setXY([x,y])}else{if(x!==undefined){this.setX(x)}else{if(y!==undefined){this.setY(y)}}}},clearPositioning:function(value){value=value||"";this.setStyle({"left":value,"right":value,"top":value,"bottom":value,"z-index":"","position":"static"});return this},getPositioning:function(){var l=this.getStyle("left");var t=this.getStyle("top");return{"position":this.getStyle("position"),"left":l,"right":l?"":this.getStyle("right"),"top":t,"bottom":t?"":this.getStyle("bottom"),"z-index":this.getStyle("z-index")}},getBorderWidth:function(side){return this.addStyles(side,El.borders)},getPadding:function(side){return this.addStyles(side,El.paddings)},setPositioning:function(pc){this.applyStyles(pc);if(pc.right=="auto"){this.dom.style.right=""}if(pc.bottom=="auto"){this.dom.style.bottom=""}return this},fixDisplay:function(){if(this.getStyle("display")=="none"){this.setStyle("visibility","hidden");this.setStyle("display",this.originalDisplay);if(this.getStyle("display")=="none"){this.setStyle("display","block")}}},setOverflow:function(v){if(v=="auto"&&Ext.isMac&&Ext.isGecko2){this.dom.style.overflow="hidden";(function(){this.dom.style.overflow="auto"}).defer(1,this)}else{this.dom.style.overflow=v}},setLeftTop:function(left,top){this.dom.style.left=this.addUnits(left);this.dom.style.top=this.addUnits(top);return this},move:function(direction,distance,animate){var xy=this.getXY();direction=direction.toLowerCase();switch(direction){case"l":case"left":this.moveTo(xy[0]-distance,xy[1],this.preanim(arguments,2));break;case"r":case"right":this.moveTo(xy[0]+distance,xy[1],this.preanim(arguments,2));break;case"t":case"top":case"up":this.moveTo(xy[0],xy[1]-distance,this.preanim(arguments,2));break;case"b":case"bottom":case"down":this.moveTo(xy[0],xy[1]+distance,this.preanim(arguments,2));break}return this},clip:function(){if(!this.isClipped){this.isClipped=true;this.originalClip={"o":this.getStyle("overflow"),"x":this.getStyle("overflow-x"),"y":this.getStyle("overflow-y")};this.setStyle("overflow","hidden");this.setStyle("overflow-x","hidden");this.setStyle("overflow-y","hidden")}return this},unclip:function(){if(this.isClipped){this.isClipped=false;var o=this.originalClip;if(o.o){this.setStyle("overflow",o.o)}if(o.x){this.setStyle("overflow-x",o.x)}if(o.y){this.setStyle("overflow-y",o.y)}}return this},getAnchorXY:function(anchor,local,s){var w,h,vp=false;if(!s){var d=this.dom;if(d==document.body||d==document){vp=true;w=D.getViewWidth();h=D.getViewHeight()}else{w=this.getWidth();h=this.getHeight()}}else{w=s.width;h=s.height}var x=0,y=0,r=Math.round;switch((anchor||"tl").toLowerCase()){case"c":x=r(w*0.5);y=r(h*0.5);break;case"t":x=r(w*0.5);y=0;break;case"l":x=0;y=r(h*0.5);break;case"r":x=w;y=r(h*0.5);break;case"b":x=r(w*0.5);y=h;break;case"tl":x=0;y=0;break;case"bl":x=0;y=h;break;case"br":x=w;y=h;break;case"tr":x=w;y=0;break}if(local===true){return[x,y]}if(vp){var sc=this.getScroll();return[x+sc.left,y+sc.top]}var o=this.getXY();return[x+o[0],y+o[1]]},getAlignToXY:function(el,p,o){el=Ext.get(el);if(!el||!el.dom){throw"Element.alignToXY with an element that doesn't exist"}var d=this.dom;var c=false;var p1="",p2="";o=o||[0,0];if(!p){p="tl-bl"}else{if(p=="?"){p="tl-bl?"}else{if(p.indexOf("-")==-1){p="tl-"+p}}}p=p.toLowerCase();var m=p.match(/^([a-z]+)-([a-z]+)(\?)?$/);if(!m){throw"Element.alignTo with an invalid alignment "+p}p1=m[1];p2=m[2];c=!!m[3];var a1=this.getAnchorXY(p1,true);var a2=el.getAnchorXY(p2,false);var x=a2[0]-a1[0]+o[0];var y=a2[1]-a1[1]+o[1];if(c){var w=this.getWidth(),h=this.getHeight(),r=el.getRegion();var dw=D.getViewWidth()-5,dh=D.getViewHeight()-5;var p1y=p1.charAt(0),p1x=p1.charAt(p1.length-1);var p2y=p2.charAt(0),p2x=p2.charAt(p2.length-1);var swapY=((p1y=="t"&&p2y=="b")||(p1y=="b"&&p2y=="t"));var swapX=((p1x=="r"&&p2x=="l")||(p1x=="l"&&p2x=="r"));var doc=document;var scrollX=(doc.documentElement.scrollLeft||doc.body.scrollLeft||0)+5;var scrollY=(doc.documentElement.scrollTop||doc.body.scrollTop||0)+5;if((x+w)>dw+scrollX){x=swapX?r.left-w:dw+scrollX-w}if(x<scrollX){x=swapX?r.right:scrollX}if((y+h)>dh+scrollY){y=swapY?r.top-h:dh+scrollY-h}if(y<scrollY){y=swapY?r.bottom:scrollY}}return[x,y]},getConstrainToXY:function(){var os={top:0,left:0,bottom:0,right:0};return function(el,local,offsets,proposedXY){el=Ext.get(el);offsets=offsets?Ext.applyIf(offsets,os):os;var vw,vh,vx=0,vy=0;if(el.dom==document.body||el.dom==document){vw=Ext.lib.Dom.getViewWidth();vh=Ext.lib.Dom.getViewHeight()}else{vw=el.dom.clientWidth;vh=el.dom.clientHeight;if(!local){var vxy=el.getXY();vx=vxy[0];vy=vxy[1]}}var s=el.getScroll();vx+=offsets.left+s.left;vy+=offsets.top+s.top;vw-=offsets.right;vh-=offsets.bottom;var vr=vx+vw;var vb=vy+vh;var xy=proposedXY||(!local?this.getXY():[this.getLeft(true),this.getTop(true)]);var x=xy[0],y=xy[1];var w=this.dom.offsetWidth,h=this.dom.offsetHeight;var moved=false;if((x+w)>vr){x=vr-w;moved=true}if((y+h)>vb){y=vb-h;moved=true}if(x<vx){x=vx;moved=true}if(y<vy){y=vy;moved=true}return moved?[x,y]:false}}(),adjustForConstraints:function(xy,parent,offsets){return this.getConstrainToXY(parent||document,false,offsets,xy)||xy},alignTo:function(element,position,offsets,animate){var xy=this.getAlignToXY(element,position,offsets);this.setXY(xy,this.preanim(arguments,3));return this},anchorTo:function(el,alignment,offsets,animate,monitorScroll,callback){var action=function(){this.alignTo(el,alignment,offsets,animate);Ext.callback(callback,this)};Ext.EventManager.onWindowResize(action,this);var tm=typeof monitorScroll;if(tm!="undefined"){Ext.EventManager.on(window,"scroll",action,this,{buffer:tm=="number"?monitorScroll:50})}action.call(this);return this},clearOpacity:function(){if(window.ActiveXObject){if(typeof this.dom.style.filter=="string"&&(/alpha/i).test(this.dom.style.filter)){this.dom.style.filter=""}}else{this.dom.style.opacity="";this.dom.style["-moz-opacity"]="";this.dom.style["-khtml-opacity"]=""}return this},hide:function(animate){this.setVisible(false,this.preanim(arguments,0));return this},show:function(animate){this.setVisible(true,this.preanim(arguments,0));return this},addUnits:function(size){return Ext.Element.addUnits(size,this.defaultUnit)},update:function(html,loadScripts,callback){if(typeof html=="undefined"){html=""}if(loadScripts!==true){this.dom.innerHTML=html;if(typeof callback=="function"){callback()}return this}var id=Ext.id();var dom=this.dom;html+="<span id=\""+id+"\"></span>";E.onAvailable(id,function(){var hd=document.getElementsByTagName("head")[0];var re=/(?:<script([^>]*)?>)((\n|\r|.)*?)(?:<\/script>)/ig;var srcRe=/\ssrc=([\'\"])(.*?)\1/i;var typeRe=/\stype=([\'\"])(.*?)\1/i;var match;while(match=re.exec(html)){var attrs=match[1];var srcMatch=attrs?attrs.match(srcRe):false;if(srcMatch&&srcMatch[2]){var s=document.createElement("script");s.src=srcMatch[2];var typeMatch=attrs.match(typeRe);if(typeMatch&&typeMatch[2]){s.type=typeMatch[2]}hd.appendChild(s)}else{if(match[2]&&match[2].length>0){if(window.execScript){window.execScript(match[2])}else{window.eval(match[2])}}}}var el=document.getElementById(id);if(el){Ext.removeNode(el)}if(typeof callback=="function"){callback()}});dom.innerHTML=html.replace(/(?:<script.*?>)((\n|\r|.)*?)(?:<\/script>)/ig,"");return this},load:function(){var um=this.getUpdater();um.update.apply(um,arguments);return this},getUpdater:function(){if(!this.updateManager){this.updateManager=new Ext.Updater(this)}return this.updateManager},unselectable:function(){this.dom.unselectable="on";this.swallowEvent("selectstart",true);this.applyStyles("-moz-user-select:none;-khtml-user-select:none;");this.addClass("x-unselectable");return this},getCenterXY:function(){return this.getAlignToXY(document,"c-c")},center:function(centerIn){this.alignTo(centerIn||document,"c-c");return this},isBorderBox:function(){return noBoxAdjust[this.dom.tagName.toLowerCase()]||Ext.isBorderBox},getBox:function(contentBox,local){var xy;if(!local){xy=this.getXY()}else{var left=parseInt(this.getStyle("left"),10)||0;var top=parseInt(this.getStyle("top"),10)||0;xy=[left,top]}var el=this.dom,w=el.offsetWidth,h=el.offsetHeight,bx;if(!contentBox){bx={x:xy[0],y:xy[1],0:xy[0],1:xy[1],width:w,height:h}}else{var l=this.getBorderWidth("l")+this.getPadding("l");var r=this.getBorderWidth("r")+this.getPadding("r");var t=this.getBorderWidth("t")+this.getPadding("t");var b=this.getBorderWidth("b")+this.getPadding("b");bx={x:xy[0]+l,y:xy[1]+t,0:xy[0]+l,1:xy[1]+t,width:w-(l+r),height:h-(t+b)}}bx.right=bx.x+bx.width;bx.bottom=bx.y+bx.height;return bx},getFrameWidth:function(sides,onlyContentBox){return onlyContentBox&&Ext.isBorderBox?0:(this.getPadding(sides)+this.getBorderWidth(sides))},setBox:function(box,adjust,animate){var w=box.width,h=box.height;if((adjust&&!this.autoBoxAdjust)&&!this.isBorderBox()){w-=(this.getBorderWidth("lr")+this.getPadding("lr"));h-=(this.getBorderWidth("tb")+this.getPadding("tb"))}this.setBounds(box.x,box.y,w,h,this.preanim(arguments,2));return this},repaint:function(){var dom=this.dom;this.addClass("x-repaint");setTimeout(function(){Ext.get(dom).removeClass("x-repaint")},1);return this},getMargins:function(side){if(!side){return{top:parseInt(this.getStyle("margin-top"),10)||0,left:parseInt(this.getStyle("margin-left"),10)||0,bottom:parseInt(this.getStyle("margin-bottom"),10)||0,right:parseInt(this.getStyle("margin-right"),10)||0}}else{return this.addStyles(side,El.margins)}},addStyles:function(sides,styles){var val=0,v,w;for(var i=0,len=sides.length;i<len;i++){v=this.getStyle(styles[sides.charAt(i)]);if(v){w=parseInt(v,10);if(w){val+=(w>=0?w:-1*w)}}}return val},createProxy:function(config,renderTo,matchBox){config=typeof config=="object"?config:{tag:"div",cls:config};var proxy;if(renderTo){proxy=Ext.DomHelper.append(renderTo,config,true)}else{proxy=Ext.DomHelper.insertBefore(this.dom,config,true)}if(matchBox){proxy.setBox(this.getBox())}return proxy},mask:function(msg,msgCls){if(this.getStyle("position")=="static"){this.setStyle("position","relative")}if(this._maskMsg){this._maskMsg.remove()}if(this._mask){this._mask.remove()}this._mask=Ext.DomHelper.append(this.dom,{cls:"ext-el-mask"},true);this.addClass("x-masked");this._mask.setDisplayed(true);if(typeof msg=="string"){this._maskMsg=Ext.DomHelper.append(this.dom,{cls:"ext-el-mask-msg",cn:{tag:"div"}},true);var mm=this._maskMsg;mm.dom.className=msgCls?"ext-el-mask-msg "+msgCls:"ext-el-mask-msg";mm.dom.firstChild.innerHTML=msg;mm.setDisplayed(true);mm.center(this)}if(Ext.isIE&&!(Ext.isIE7&&Ext.isStrict)&&this.getStyle("height")=="auto"){this._mask.setSize(this.dom.clientWidth,this.getHeight())}return this._mask},unmask:function(){if(this._mask){if(this._maskMsg){this._maskMsg.remove();delete this._maskMsg}this._mask.remove();delete this._mask}this.removeClass("x-masked")},isMasked:function(){return this._mask&&this._mask.isVisible()},createShim:function(){var el=document.createElement("iframe");el.frameBorder="0";el.className="ext-shim";if(Ext.isIE&&Ext.isSecure){el.src=Ext.SSL_SECURE_URL}var shim=Ext.get(this.dom.parentNode.insertBefore(el,this.dom));shim.autoBoxAdjust=false;return shim},remove:function(){Ext.removeNode(this.dom);delete El.cache[this.dom.id]},hover:function(overFn,outFn,scope){var preOverFn=function(e){if(!e.within(this,true)){overFn.apply(scope||this,arguments)}};var preOutFn=function(e){if(!e.within(this,true)){outFn.apply(scope||this,arguments)}};this.on("mouseover",preOverFn,this.dom);this.on("mouseout",preOutFn,this.dom);return this},addClassOnOver:function(className){this.hover(function(){Ext.fly(this,"_internal").addClass(className)},function(){Ext.fly(this,"_internal").removeClass(className)});return this},addClassOnFocus:function(className){this.on("focus",function(){Ext.fly(this,"_internal").addClass(className)},this.dom);this.on("blur",function(){Ext.fly(this,"_internal").removeClass(className)},this.dom);return this},addClassOnClick:function(className){var dom=this.dom;this.on("mousedown",function(){Ext.fly(dom,"_internal").addClass(className);var d=Ext.getDoc();var fn=function(){Ext.fly(dom,"_internal").removeClass(className);d.removeListener("mouseup",fn)};d.on("mouseup",fn)});return this},swallowEvent:function(eventName,preventDefault){var fn=function(e){e.stopPropagation();if(preventDefault){e.preventDefault()}};if(Ext.isArray(eventName)){for(var i=0,len=eventName.length;i<len;i++){this.on(eventName[i],fn)}return this}this.on(eventName,fn);return this},parent:function(selector,returnDom){return this.matchNode("parentNode","parentNode",selector,returnDom)},next:function(selector,returnDom){return this.matchNode("nextSibling","nextSibling",selector,returnDom)},prev:function(selector,returnDom){return this.matchNode("previousSibling","previousSibling",selector,returnDom)},first:function(selector,returnDom){return this.matchNode("nextSibling","firstChild",selector,returnDom)},last:function(selector,returnDom){return this.matchNode("previousSibling","lastChild",selector,returnDom)},matchNode:function(dir,start,selector,returnDom){var n=this.dom[start];while(n){if(n.nodeType==1&&(!selector||Ext.DomQuery.is(n,selector))){return !returnDom?Ext.get(n):n}n=n[dir]}return null},appendChild:function(el){el=Ext.get(el);el.appendTo(this);return this},createChild:function(config,insertBefore,returnDom){config=config||{tag:"div"};if(insertBefore){return Ext.DomHelper.insertBefore(insertBefore,config,returnDom!==true)}return Ext.DomHelper[!this.dom.firstChild?"overwrite":"append"](this.dom,config,returnDom!==true)},appendTo:function(el){el=Ext.getDom(el);el.appendChild(this.dom);return this},insertBefore:function(el){el=Ext.getDom(el);el.parentNode.insertBefore(this.dom,el);return this},insertAfter:function(el){el=Ext.getDom(el);el.parentNode.insertBefore(this.dom,el.nextSibling);return this},insertFirst:function(el,returnDom){el=el||{};if(typeof el=="object"&&!el.nodeType&&!el.dom){return this.createChild(el,this.dom.firstChild,returnDom)}else{el=Ext.getDom(el);this.dom.insertBefore(el,this.dom.firstChild);return !returnDom?Ext.get(el):el}},insertSibling:function(el,where,returnDom){var rt;if(Ext.isArray(el)){for(var i=0,len=el.length;i<len;i++){rt=this.insertSibling(el[i],where,returnDom)}return rt}where=where?where.toLowerCase():"before";el=el||{};var refNode=where=="before"?this.dom:this.dom.nextSibling;if(typeof el=="object"&&!el.nodeType&&!el.dom){if(where=="after"&&!this.dom.nextSibling){rt=Ext.DomHelper.append(this.dom.parentNode,el,!returnDom)}else{rt=Ext.DomHelper[where=="after"?"insertAfter":"insertBefore"](this.dom,el,!returnDom)}}else{rt=this.dom.parentNode.insertBefore(Ext.getDom(el),refNode);if(!returnDom){rt=Ext.get(rt)}}return rt},wrap:function(config,returnDom){if(!config){config={tag:"div"}}var newEl=Ext.DomHelper.insertBefore(this.dom,config,!returnDom);newEl.dom?newEl.dom.appendChild(this.dom):newEl.appendChild(this.dom);return newEl},replace:function(el){el=Ext.get(el);this.insertBefore(el);el.remove();return this},replaceWith:function(el){if(typeof el=="object"&&!el.nodeType&&!el.dom){el=this.insertSibling(el,"before")}else{el=Ext.getDom(el);this.dom.parentNode.insertBefore(el,this.dom)}El.uncache(this.id);this.dom.parentNode.removeChild(this.dom);this.dom=el;this.id=Ext.id(el);El.cache[this.id]=this;return this},insertHtml:function(where,html,returnEl){var el=Ext.DomHelper.insertHtml(where,this.dom,html);return returnEl?Ext.get(el):el},set:function(o,useSet){var el=this.dom;useSet=typeof useSet=="undefined"?(el.setAttribute?true:false):useSet;for(var attr in o){if(attr=="style"||typeof o[attr]=="function"){continue}if(attr=="cls"){el.className=o["cls"]}else{if(o.hasOwnProperty(attr)){if(useSet){el.setAttribute(attr,o[attr])}else{el[attr]=o[attr]}}}}if(o.style){Ext.DomHelper.applyStyles(el,o.style)}return this},addKeyListener:function(key,fn,scope){var config;if(typeof key!="object"||Ext.isArray(key)){config={key:key,fn:fn,scope:scope}}else{config={key:key.key,shift:key.shift,ctrl:key.ctrl,alt:key.alt,fn:fn,scope:scope}}return new Ext.KeyMap(this,config)},addKeyMap:function(config){return new Ext.KeyMap(this,config)},isScrollable:function(){var dom=this.dom;return dom.scrollHeight>dom.clientHeight||dom.scrollWidth>dom.clientWidth},scrollTo:function(side,value,animate){var prop=side.toLowerCase()=="left"?"scrollLeft":"scrollTop";if(!animate||!A){this.dom[prop]=value}else{var to=prop=="scrollLeft"?[value,this.dom.scrollTop]:[this.dom.scrollLeft,value];this.anim({scroll:{"to":to}},this.preanim(arguments,2),"scroll")}return this},scroll:function(direction,distance,animate){if(!this.isScrollable()){return }var el=this.dom;var l=el.scrollLeft,t=el.scrollTop;var w=el.scrollWidth,h=el.scrollHeight;var cw=el.clientWidth,ch=el.clientHeight;direction=direction.toLowerCase();var scrolled=false;var a=this.preanim(arguments,2);switch(direction){case"l":case"left":if(w-l>cw){var v=Math.min(l+distance,w-cw);this.scrollTo("left",v,a);scrolled=true}break;case"r":case"right":if(l>0){var v=Math.max(l-distance,0);this.scrollTo("left",v,a);scrolled=true}break;case"t":case"top":case"up":if(t>0){var v=Math.max(t-distance,0);this.scrollTo("top",v,a);scrolled=true}break;case"b":case"bottom":case"down":if(h-t>ch){var v=Math.min(t+distance,h-ch);this.scrollTo("top",v,a);scrolled=true}break}return scrolled},translatePoints:function(x,y){if(typeof x=="object"||Ext.isArray(x)){y=x[1];x=x[0]}var p=this.getStyle("position");var o=this.getXY();var l=parseInt(this.getStyle("left"),10);var t=parseInt(this.getStyle("top"),10);if(isNaN(l)){l=(p=="relative")?0:this.dom.offsetLeft}if(isNaN(t)){t=(p=="relative")?0:this.dom.offsetTop}return{left:(x-o[0]+l),top:(y-o[1]+t)}},getScroll:function(){var d=this.dom,doc=document;if(d==doc||d==doc.body){var l,t;if(Ext.isIE&&Ext.isStrict){l=doc.documentElement.scrollLeft||(doc.body.scrollLeft||0);t=doc.documentElement.scrollTop||(doc.body.scrollTop||0)}else{l=window.pageXOffset||(doc.body.scrollLeft||0);t=window.pageYOffset||(doc.body.scrollTop||0)}return{left:l,top:t}}else{return{left:d.scrollLeft,top:d.scrollTop}}},getColor:function(attr,defaultValue,prefix){var v=this.getStyle(attr);if(!v||v=="transparent"||v=="inherit"){return defaultValue}var color=typeof prefix=="undefined"?"#":prefix;if(v.substr(0,4)=="rgb("){var rvs=v.slice(4,v.length-1).split(",");for(var i=0;i<3;i++){var h=parseInt(rvs[i]);var s=h.toString(16);if(h<16){s="0"+s}color+=s}}else{if(v.substr(0,1)=="#"){if(v.length==4){for(var i=1;i<4;i++){var c=v.charAt(i);color+=c+c}}else{if(v.length==7){color+=v.substr(1)}}}}return(color.length>5?color.toLowerCase():defaultValue)},boxWrap:function(cls){cls=cls||"x-box";var el=Ext.get(this.insertHtml("beforeBegin",String.format("<div class=\"{0}\">"+El.boxMarkup+"</div>",cls)));el.child("."+cls+"-mc").dom.appendChild(this.dom);return el},getAttributeNS:Ext.isIE?function(ns,name){var d=this.dom;var type=typeof d[ns+":"+name];if(type!="undefined"&&type!="unknown"){return d[ns+":"+name]}return d[name]}:function(ns,name){var d=this.dom;return d.getAttributeNS(ns,name)||d.getAttribute(ns+":"+name)||d.getAttribute(name)||d[name]},getTextWidth:function(text,min,max){return(Ext.util.TextMetrics.measure(this.dom,Ext.value(text,this.dom.innerHTML,true)).width).constrain(min||0,max||1000000)}};var ep=El.prototype;ep.on=ep.addListener;ep.mon=ep.addListener;ep.getUpdateManager=ep.getUpdater;ep.un=ep.removeListener;ep.autoBoxAdjust=true;El.unitPattern=/\d+(px|em|%|en|ex|pt|in|cm|mm|pc)$/i;El.addUnits=function(v,defaultUnit){if(v===""||v=="auto"){return v}if(v===undefined){return""}if(typeof v=="number"||!El.unitPattern.test(v)){return v+(defaultUnit||"px")}return v};El.boxMarkup="<div class=\"{0}-tl\"><div class=\"{0}-tr\"><div class=\"{0}-tc\"></div></div></div><div class=\"{0}-ml\"><div class=\"{0}-mr\"><div class=\"{0}-mc\"></div></div></div><div class=\"{0}-bl\"><div class=\"{0}-br\"><div class=\"{0}-bc\"></div></div></div>";El.VISIBILITY=1;El.DISPLAY=2;El.borders={l:"border-left-width",r:"border-right-width",t:"border-top-width",b:"border-bottom-width"};El.paddings={l:"padding-left",r:"padding-right",t:"padding-top",b:"padding-bottom"};El.margins={l:"margin-left",r:"margin-right",t:"margin-top",b:"margin-bottom"};El.cache={};var docEl;El.get=function(el){var ex,elm,id;if(!el){return null}if(typeof el=="string"){if(!(elm=document.getElementById(el))){return null}if(ex=El.cache[el]){ex.dom=elm}else{ex=El.cache[el]=new El(elm)}return ex}else{if(el.tagName){if(!(id=el.id)){id=Ext.id(el)}if(ex=El.cache[id]){ex.dom=el}else{ex=El.cache[id]=new El(el)}return ex}else{if(el instanceof El){if(el!=docEl){el.dom=document.getElementById(el.id)||el.dom;El.cache[el.id]=el}return el}else{if(el.isComposite){return el}else{if(Ext.isArray(el)){return El.select(el)}else{if(el==document){if(!docEl){var f=function(){};f.prototype=El.prototype;docEl=new f();docEl.dom=document}return docEl}}}}}}return null};El.uncache=function(el){for(var i=0,a=arguments,len=a.length;i<len;i++){if(a[i]){delete El.cache[a[i].id||a[i]]}}};El.garbageCollect=function(){if(!Ext.enableGarbageCollector){clearInterval(El.collectorThread);return }for(var eid in El.cache){var el=El.cache[eid],d=el.dom;if(!d||!d.parentNode||(!d.offsetParent&&!document.getElementById(eid))){delete El.cache[eid];if(d&&Ext.enableListenerCollection){Ext.EventManager.removeAll(d)}}}};El.collectorThreadId=setInterval(El.garbageCollect,30000);var flyFn=function(){};flyFn.prototype=El.prototype;var _cls=new flyFn();El.Flyweight=function(dom){this.dom=dom};El.Flyweight.prototype=_cls;El.Flyweight.prototype.isFlyweight=true;El._flyweights={};El.fly=function(el,named){named=named||"_global";el=Ext.getDom(el);if(!el){return null}if(!El._flyweights[named]){El._flyweights[named]=new El.Flyweight()}El._flyweights[named].dom=el;return El._flyweights[named]};Ext.get=El.get;Ext.fly=El.fly;var noBoxAdjust=Ext.isStrict?{select:1}:{input:1,select:1,textarea:1};if(Ext.isIE||Ext.isGecko){noBoxAdjust["button"]=1}Ext.EventManager.on(window,"unload",function(){delete El.cache;delete El._flyweights})})();
Ext.enableFx=true;Ext.Fx={slideIn:function(A,C){var B=this.getFxEl();C=C||{};B.queueFx(C,function(){A=A||"t";this.fixDisplay();var D=this.getFxRestore();var I=this.getBox();this.setSize(I);var F=this.fxWrap(D.pos,C,"hidden");var K=this.dom.style;K.visibility="visible";K.position="absolute";var E=function(){B.fxUnwrap(F,D.pos,C);K.width=D.width;K.height=D.height;B.afterFx(C)};var J,L={to:[I.x,I.y]},H={to:I.width},G={to:I.height};switch(A.toLowerCase()){case"t":F.setSize(I.width,0);K.left=K.bottom="0";J={height:G};break;case"l":F.setSize(0,I.height);K.right=K.top="0";J={width:H};break;case"r":F.setSize(0,I.height);F.setX(I.right);K.left=K.top="0";J={width:H,points:L};break;case"b":F.setSize(I.width,0);F.setY(I.bottom);K.left=K.top="0";J={height:G,points:L};break;case"tl":F.setSize(0,0);K.right=K.bottom="0";J={width:H,height:G};break;case"bl":F.setSize(0,0);F.setY(I.y+I.height);K.right=K.top="0";J={width:H,height:G,points:L};break;case"br":F.setSize(0,0);F.setXY([I.right,I.bottom]);K.left=K.top="0";J={width:H,height:G,points:L};break;case"tr":F.setSize(0,0);F.setX(I.x+I.width);K.left=K.bottom="0";J={width:H,height:G,points:L};break}this.dom.style.visibility="visible";F.show();arguments.callee.anim=F.fxanim(J,C,"motion",0.5,"easeOut",E)});return this},slideOut:function(A,C){var B=this.getFxEl();C=C||{};B.queueFx(C,function(){A=A||"t";var I=this.getFxRestore();var D=this.getBox();this.setSize(D);var G=this.fxWrap(I.pos,C,"visible");var F=this.dom.style;F.visibility="visible";F.position="absolute";G.setSize(D);var J=function(){if(C.useDisplay){B.setDisplayed(false)}else{B.hide()}B.fxUnwrap(G,I.pos,C);F.width=I.width;F.height=I.height;B.afterFx(C)};var E,H={to:0};switch(A.toLowerCase()){case"t":F.left=F.bottom="0";E={height:H};break;case"l":F.right=F.top="0";E={width:H};break;case"r":F.left=F.top="0";E={width:H,points:{to:[D.right,D.y]}};break;case"b":F.left=F.top="0";E={height:H,points:{to:[D.x,D.bottom]}};break;case"tl":F.right=F.bottom="0";E={width:H,height:H};break;case"bl":F.right=F.top="0";E={width:H,height:H,points:{to:[D.x,D.bottom]}};break;case"br":F.left=F.top="0";E={width:H,height:H,points:{to:[D.x+D.width,D.bottom]}};break;case"tr":F.left=F.bottom="0";E={width:H,height:H,points:{to:[D.right,D.y]}};break}arguments.callee.anim=G.fxanim(E,C,"motion",0.5,"easeOut",J)});return this},puff:function(B){var A=this.getFxEl();B=B||{};A.queueFx(B,function(){this.clearOpacity();this.show();var F=this.getFxRestore();var D=this.dom.style;var G=function(){if(B.useDisplay){A.setDisplayed(false)}else{A.hide()}A.clearOpacity();A.setPositioning(F.pos);D.width=F.width;D.height=F.height;D.fontSize="";A.afterFx(B)};var E=this.getWidth();var C=this.getHeight();arguments.callee.anim=this.fxanim({width:{to:this.adjustWidth(E*2)},height:{to:this.adjustHeight(C*2)},points:{by:[-(E*0.5),-(C*0.5)]},opacity:{to:0},fontSize:{to:200,unit:"%"}},B,"motion",0.5,"easeOut",G)});return this},switchOff:function(B){var A=this.getFxEl();B=B||{};A.queueFx(B,function(){this.clearOpacity();this.clip();var D=this.getFxRestore();var C=this.dom.style;var E=function(){if(B.useDisplay){A.setDisplayed(false)}else{A.hide()}A.clearOpacity();A.setPositioning(D.pos);C.width=D.width;C.height=D.height;A.afterFx(B)};this.fxanim({opacity:{to:0.3}},null,null,0.1,null,function(){this.clearOpacity();(function(){this.fxanim({height:{to:1},points:{by:[0,this.getHeight()*0.5]}},B,"motion",0.3,"easeIn",E)}).defer(100,this)})});return this},highlight:function(A,C){var B=this.getFxEl();C=C||{};B.queueFx(C,function(){A=A||"ffff9c";var D=C.attr||"backgroundColor";this.clearOpacity();this.show();var G=this.getColor(D);var H=this.dom.style[D];var F=(C.endColor||G)||"ffffff";var I=function(){B.dom.style[D]=H;B.afterFx(C)};var E={};E[D]={from:A,to:F};arguments.callee.anim=this.fxanim(E,C,"color",1,"easeIn",I)});return this},frame:function(A,C,D){var B=this.getFxEl();D=D||{};B.queueFx(D,function(){A=A||"#C3DAF9";if(A.length==6){A="#"+A}C=C||1;var G=D.duration||1;this.show();var E=this.getBox();var F=function(){var H=Ext.getBody().createChild({style:{visibility:"hidden",position:"absolute","z-index":"35000",border:"0px solid "+A}});var I=Ext.isBorderBox?2:1;H.animate({top:{from:E.y,to:E.y-20},left:{from:E.x,to:E.x-20},borderWidth:{from:0,to:10},opacity:{from:1,to:0},height:{from:E.height,to:(E.height+(20*I))},width:{from:E.width,to:(E.width+(20*I))}},G,function(){H.remove();if(--C>0){F()}else{B.afterFx(D)}})};F.call(this)});return this},pause:function(C){var A=this.getFxEl();var B={};A.queueFx(B,function(){setTimeout(function(){A.afterFx(B)},C*1000)});return this},fadeIn:function(B){var A=this.getFxEl();B=B||{};A.queueFx(B,function(){this.setOpacity(0);this.fixDisplay();this.dom.style.visibility="visible";var C=B.endOpacity||1;arguments.callee.anim=this.fxanim({opacity:{to:C}},B,null,0.5,"easeOut",function(){if(C==1){this.clearOpacity()}A.afterFx(B)})});return this},fadeOut:function(B){var A=this.getFxEl();B=B||{};A.queueFx(B,function(){arguments.callee.anim=this.fxanim({opacity:{to:B.endOpacity||0}},B,null,0.5,"easeOut",function(){if(this.visibilityMode==Ext.Element.DISPLAY||B.useDisplay){this.dom.style.display="none"}else{this.dom.style.visibility="hidden"}this.clearOpacity();A.afterFx(B)})});return this},scale:function(A,B,C){this.shift(Ext.apply({},C,{width:A,height:B}));return this},shift:function(B){var A=this.getFxEl();B=B||{};A.queueFx(B,function(){var E={},D=B.width,F=B.height,C=B.x,H=B.y,G=B.opacity;if(D!==undefined){E.width={to:this.adjustWidth(D)}}if(F!==undefined){E.height={to:this.adjustHeight(F)}}if(B.left!==undefined){E.left={to:B.left}}if(B.top!==undefined){E.top={to:B.top}}if(B.right!==undefined){E.right={to:B.right}}if(B.bottom!==undefined){E.bottom={to:B.bottom}}if(C!==undefined||H!==undefined){E.points={to:[C!==undefined?C:this.getX(),H!==undefined?H:this.getY()]}}if(G!==undefined){E.opacity={to:G}}if(B.xy!==undefined){E.points={to:B.xy}}arguments.callee.anim=this.fxanim(E,B,"motion",0.35,"easeOut",function(){A.afterFx(B)})});return this},ghost:function(A,C){var B=this.getFxEl();C=C||{};B.queueFx(C,function(){A=A||"b";var H=this.getFxRestore();var E=this.getWidth(),G=this.getHeight();var F=this.dom.style;var J=function(){if(C.useDisplay){B.setDisplayed(false)}else{B.hide()}B.clearOpacity();B.setPositioning(H.pos);F.width=H.width;F.height=H.height;B.afterFx(C)};var D={opacity:{to:0},points:{}},I=D.points;switch(A.toLowerCase()){case"t":I.by=[0,-G];break;case"l":I.by=[-E,0];break;case"r":I.by=[E,0];break;case"b":I.by=[0,G];break;case"tl":I.by=[-E,-G];break;case"bl":I.by=[-E,G];break;case"br":I.by=[E,G];break;case"tr":I.by=[E,-G];break}arguments.callee.anim=this.fxanim(D,C,"motion",0.5,"easeOut",J)});return this},syncFx:function(){this.fxDefaults=Ext.apply(this.fxDefaults||{},{block:false,concurrent:true,stopFx:false});return this},sequenceFx:function(){this.fxDefaults=Ext.apply(this.fxDefaults||{},{block:false,concurrent:false,stopFx:false});return this},nextFx:function(){var A=this.fxQueue[0];if(A){A.call(this)}},hasActiveFx:function(){return this.fxQueue&&this.fxQueue[0]},stopFx:function(){if(this.hasActiveFx()){var A=this.fxQueue[0];if(A&&A.anim&&A.anim.isAnimated()){this.fxQueue=[A];A.anim.stop(true)}}return this},beforeFx:function(A){if(this.hasActiveFx()&&!A.concurrent){if(A.stopFx){this.stopFx();return true}return false}return true},hasFxBlock:function(){var A=this.fxQueue;return A&&A[0]&&A[0].block},queueFx:function(C,A){if(!this.fxQueue){this.fxQueue=[]}if(!this.hasFxBlock()){Ext.applyIf(C,this.fxDefaults);if(!C.concurrent){var B=this.beforeFx(C);A.block=C.block;this.fxQueue.push(A);if(B){this.nextFx()}}else{A.call(this)}}return this},fxWrap:function(F,D,C){var B;if(!D.wrap||!(B=Ext.get(D.wrap))){var A;if(D.fixPosition){A=this.getXY()}var E=document.createElement("div");E.style.visibility=C;B=Ext.get(this.dom.parentNode.insertBefore(E,this.dom));B.setPositioning(F);if(B.getStyle("position")=="static"){B.position("relative")}this.clearPositioning("auto");B.clip();B.dom.appendChild(this.dom);if(A){B.setXY(A)}}return B},fxUnwrap:function(A,C,B){this.clearPositioning();this.setPositioning(C);if(!B.wrap){A.dom.parentNode.insertBefore(this.dom,A.dom);A.remove()}},getFxRestore:function(){var A=this.dom.style;return{pos:this.getPositioning(),width:A.width,height:A.height}},afterFx:function(A){if(A.afterStyle){this.applyStyles(A.afterStyle)}if(A.afterCls){this.addClass(A.afterCls)}if(A.remove===true){this.remove()}Ext.callback(A.callback,A.scope,[this]);if(!A.concurrent){this.fxQueue.shift();this.nextFx()}},getFxEl:function(){return Ext.get(this.dom)},fxanim:function(D,E,B,F,C,A){B=B||"run";E=E||{};var G=Ext.lib.Anim[B](this.dom,D,(E.duration||F)||0.35,(E.easing||C)||"easeOut",function(){Ext.callback(A,this)},this);E.anim=G;return G}};Ext.Fx.resize=Ext.Fx.scale;Ext.apply(Ext.Element.prototype,Ext.Fx);
Ext.CompositeElement=function(A){this.elements=[];this.addElements(A)};Ext.CompositeElement.prototype={isComposite:true,addElements:function(E){if(!E){return this}if(typeof E=="string"){E=Ext.Element.selectorFunction(E)}var D=this.elements;var B=D.length-1;for(var C=0,A=E.length;C<A;C++){D[++B]=Ext.get(E[C])}return this},fill:function(A){this.elements=[];this.add(A);return this},filter:function(A){var B=[];this.each(function(C){if(C.is(A)){B[B.length]=C.dom}});this.fill(B);return this},invoke:function(E,B){var D=this.elements;for(var C=0,A=D.length;C<A;C++){Ext.Element.prototype[E].apply(D[C],B)}return this},add:function(A){if(typeof A=="string"){this.addElements(Ext.Element.selectorFunction(A))}else{if(A.length!==undefined){this.addElements(A)}else{this.addElements([A])}}return this},each:function(E,D){var C=this.elements;for(var B=0,A=C.length;B<A;B++){if(E.call(D||C[B],C[B],this,B)===false){break}}return this},item:function(A){return this.elements[A]||null},first:function(){return this.item(0)},last:function(){return this.item(this.elements.length-1)},getCount:function(){return this.elements.length},contains:function(A){return this.indexOf(A)!==-1},indexOf:function(A){return this.elements.indexOf(Ext.get(A))},removeElement:function(D,F){if(Ext.isArray(D)){for(var C=0,A=D.length;C<A;C++){this.removeElement(D[C])}return this}var B=typeof D=="number"?D:this.indexOf(D);if(B!==-1&&this.elements[B]){if(F){var E=this.elements[B];if(E.dom){E.remove()}else{Ext.removeNode(E)}}this.elements.splice(B,1)}return this},replaceElement:function(D,C,A){var B=typeof D=="number"?D:this.indexOf(D);if(B!==-1){if(A){this.elements[B].replaceWith(C)}else{this.elements.splice(B,1,Ext.get(C))}}return this},clear:function(){this.elements=[]}};(function(){Ext.CompositeElement.createCall=function(B,C){if(!B[C]){B[C]=function(){return this.invoke(C,arguments)}}};for(var A in Ext.Element.prototype){if(typeof Ext.Element.prototype[A]=="function"){Ext.CompositeElement.createCall(Ext.CompositeElement.prototype,A)}}})();Ext.CompositeElementLite=function(A){Ext.CompositeElementLite.superclass.constructor.call(this,A);this.el=new Ext.Element.Flyweight()};Ext.extend(Ext.CompositeElementLite,Ext.CompositeElement,{addElements:function(E){if(E){if(Ext.isArray(E)){this.elements=this.elements.concat(E)}else{var D=this.elements;var B=D.length-1;for(var C=0,A=E.length;C<A;C++){D[++B]=E[C]}}}return this},invoke:function(F,B){var D=this.elements;var E=this.el;for(var C=0,A=D.length;C<A;C++){E.dom=D[C];Ext.Element.prototype[F].apply(E,B)}return this},item:function(A){if(!this.elements[A]){return null}this.el.dom=this.elements[A];return this.el},addListener:function(B,G,F,E){var D=this.elements;for(var C=0,A=D.length;C<A;C++){Ext.EventManager.on(D[C],B,G,F||D[C],E)}return this},each:function(F,E){var C=this.elements;var D=this.el;for(var B=0,A=C.length;B<A;B++){D.dom=C[B];if(F.call(E||D,D,this,B)===false){break}}return this},indexOf:function(A){return this.elements.indexOf(Ext.getDom(A))},replaceElement:function(D,C,A){var B=typeof D=="number"?D:this.indexOf(D);if(B!==-1){C=Ext.getDom(C);if(A){var E=this.elements[B];E.parentNode.insertBefore(C,E);Ext.removeNode(E)}this.elements.splice(B,1,C)}return this}});Ext.CompositeElementLite.prototype.on=Ext.CompositeElementLite.prototype.addListener;if(Ext.DomQuery){Ext.Element.selectorFunction=Ext.DomQuery.select}Ext.Element.select=function(A,D,B){var C;if(typeof A=="string"){C=Ext.Element.selectorFunction(A,B)}else{if(A.length!==undefined){C=A}else{throw"Invalid selector"}}if(D===true){return new Ext.CompositeElement(C)}else{return new Ext.CompositeElementLite(C)}};Ext.select=Ext.Element.select;
Ext.data.Connection=function(A){Ext.apply(this,A);this.addEvents("beforerequest","requestcomplete","requestexception");Ext.data.Connection.superclass.constructor.call(this)};Ext.extend(Ext.data.Connection,Ext.util.Observable,{timeout:30000,autoAbort:false,disableCaching:true,disableCachingParam:"_dc",request:function(E){if(this.fireEvent("beforerequest",this,E)!==false){var C=E.params;if(typeof C=="function"){C=C.call(E.scope||window,E)}if(typeof C=="object"){C=Ext.urlEncode(C)}if(this.extraParams){var G=Ext.urlEncode(this.extraParams);C=C?(C+"&"+G):G}var B=E.url||this.url;if(typeof B=="function"){B=B.call(E.scope||window,E)}if(E.form){var D=Ext.getDom(E.form);B=B||D.action;var J=D.getAttribute("enctype");if(E.isUpload||(J&&J.toLowerCase()=="multipart/form-data")){return this.doFormUpload(E,C,B)}var I=Ext.lib.Ajax.serializeForm(D);C=C?(C+"&"+I):I}var K=E.headers;if(this.defaultHeaders){K=Ext.apply(K||{},this.defaultHeaders);if(!E.headers){E.headers=K}}var F={success:this.handleResponse,failure:this.handleFailure,scope:this,argument:{options:E},timeout:E.timeout||this.timeout};var A=E.method||this.method||((C||E.xmlData||E.jsonData)?"POST":"GET");if(A=="GET"&&(this.disableCaching&&E.disableCaching!==false)||E.disableCaching===true){var H=E.disableCachingParam||this.disableCachingParam;B+=(B.indexOf("?")!=-1?"&":"?")+H+"="+(new Date().getTime())}if(typeof E.autoAbort=="boolean"){if(E.autoAbort){this.abort()}}else{if(this.autoAbort!==false){this.abort()}}if((A=="GET"||E.xmlData||E.jsonData)&&C){B+=(B.indexOf("?")!=-1?"&":"?")+C;C=""}this.transId=Ext.lib.Ajax.request(A,B,F,C,E);return this.transId}else{Ext.callback(E.callback,E.scope,[E,null,null]);return null}},isLoading:function(A){if(A){return Ext.lib.Ajax.isCallInProgress(A)}else{return this.transId?true:false}},abort:function(A){if(A||this.isLoading()){Ext.lib.Ajax.abort(A||this.transId)}},handleResponse:function(A){this.transId=false;var B=A.argument.options;A.argument=B?B.argument:null;this.fireEvent("requestcomplete",this,A,B);Ext.callback(B.success,B.scope,[A,B]);Ext.callback(B.callback,B.scope,[B,true,A])},handleFailure:function(A,C){this.transId=false;var B=A.argument.options;A.argument=B?B.argument:null;this.fireEvent("requestexception",this,A,B,C);Ext.callback(B.failure,B.scope,[A,B]);Ext.callback(B.callback,B.scope,[B,false,A])},doFormUpload:function(E,A,B){var C=Ext.id();var F=document.createElement("iframe");F.id=C;F.name=C;F.className="x-hidden";if(Ext.isIE){F.src=Ext.SSL_SECURE_URL}document.body.appendChild(F);if(Ext.isIE){document.frames[C].name=C}var D=Ext.getDom(E.form);D.target=C;D.method="POST";D.enctype=D.encoding="multipart/form-data";if(B){D.action=B}var L,J;if(A){L=[];A=Ext.urlDecode(A,false);for(var H in A){if(A.hasOwnProperty(H)){J=document.createElement("input");J.type="hidden";J.name=H;J.value=A[H];D.appendChild(J);L.push(J)}}}function G(){var M={responseText:"",responseXML:null};M.argument=E?E.argument:null;try{var O;if(Ext.isIE){O=F.contentWindow.document}else{O=(F.contentDocument||window.frames[C].document)}if(O&&O.body){M.responseText=O.body.innerHTML}if(O&&O.XMLDocument){M.responseXML=O.XMLDocument}else{M.responseXML=O}}catch(N){}Ext.EventManager.removeListener(F,"load",G,this);this.fireEvent("requestcomplete",this,M,E);Ext.callback(E.success,E.scope,[M,E]);Ext.callback(E.callback,E.scope,[E,true,M]);setTimeout(function(){Ext.removeNode(F)},100)}Ext.EventManager.on(F,"load",G,this);D.submit();if(L){for(var I=0,K=L.length;I<K;I++){Ext.removeNode(L[I])}}}});Ext.Ajax=new Ext.data.Connection({autoAbort:false,serializeForm:function(A){return Ext.lib.Ajax.serializeForm(A)}});
Ext.Updater=Ext.extend(Ext.util.Observable,{constructor:function(B,A){B=Ext.get(B);if(!A&&B.updateManager){return B.updateManager}this.el=B;this.defaultUrl=null;this.addEvents("beforeupdate","update","failure");var C=Ext.Updater.defaults;this.sslBlankUrl=C.sslBlankUrl;this.disableCaching=C.disableCaching;this.indicatorText=C.indicatorText;this.showLoadIndicator=C.showLoadIndicator;this.timeout=C.timeout;this.loadScripts=C.loadScripts;this.transaction=null;this.refreshDelegate=this.refresh.createDelegate(this);this.updateDelegate=this.update.createDelegate(this);this.formUpdateDelegate=this.formUpdate.createDelegate(this);if(!this.renderer){this.renderer=this.getDefaultRenderer()}Ext.Updater.superclass.constructor.call(this)},getDefaultRenderer:function(){return new Ext.Updater.BasicRenderer()},getEl:function(){return this.el},update:function(B,F,G,D){if(this.fireEvent("beforeupdate",this.el,B,F)!==false){var A,C;if(typeof B=="object"){A=B;B=A.url;F=F||A.params;G=G||A.callback;D=D||A.discardUrl;C=A.scope;if(typeof A.nocache!="undefined"){this.disableCaching=A.nocache}if(typeof A.text!="undefined"){this.indicatorText="<div class=\"loading-indicator\">"+A.text+"</div>"}if(typeof A.scripts!="undefined"){this.loadScripts=A.scripts}if(typeof A.timeout!="undefined"){this.timeout=A.timeout}}this.showLoading();if(!D){this.defaultUrl=B}if(typeof B=="function"){B=B.call(this)}var E=Ext.apply({},{url:B,params:(typeof F=="function"&&C)?F.createDelegate(C):F,success:this.processSuccess,failure:this.processFailure,scope:this,callback:undefined,timeout:(this.timeout*1000),disableCaching:this.disableCaching,argument:{"options":A,"url":B,"form":null,"callback":G,"scope":C||window,"params":F}},A);this.transaction=Ext.Ajax.request(E)}},formUpdate:function(C,A,B,D){if(this.fireEvent("beforeupdate",this.el,C,A)!==false){if(typeof A=="function"){A=A.call(this)}C=Ext.getDom(C);this.transaction=Ext.Ajax.request({form:C,url:A,success:this.processSuccess,failure:this.processFailure,scope:this,timeout:(this.timeout*1000),argument:{"url":A,"form":C,"callback":D,"reset":B}});this.showLoading.defer(1,this)}},refresh:function(A){if(this.defaultUrl==null){return }this.update(this.defaultUrl,null,A,true)},startAutoRefresh:function(B,C,D,E,A){if(A){this.update(C||this.defaultUrl,D,E,true)}if(this.autoRefreshProcId){clearInterval(this.autoRefreshProcId)}this.autoRefreshProcId=setInterval(this.update.createDelegate(this,[C||this.defaultUrl,D,E,true]),B*1000)},stopAutoRefresh:function(){if(this.autoRefreshProcId){clearInterval(this.autoRefreshProcId);delete this.autoRefreshProcId}},isAutoRefreshing:function(){return this.autoRefreshProcId?true:false},showLoading:function(){if(this.showLoadIndicator){this.el.update(this.indicatorText)}},processSuccess:function(A){this.transaction=null;if(A.argument.form&&A.argument.reset){try{A.argument.form.reset()}catch(B){}}if(this.loadScripts){this.renderer.render(this.el,A,this,this.updateComplete.createDelegate(this,[A]))}else{this.renderer.render(this.el,A,this);this.updateComplete(A)}},updateComplete:function(A){this.fireEvent("update",this.el,A);if(typeof A.argument.callback=="function"){A.argument.callback.call(A.argument.scope,this.el,true,A,A.argument.options)}},processFailure:function(A){this.transaction=null;this.fireEvent("failure",this.el,A);if(typeof A.argument.callback=="function"){A.argument.callback.call(A.argument.scope,this.el,false,A,A.argument.options)}},setRenderer:function(A){this.renderer=A},getRenderer:function(){return this.renderer},setDefaultUrl:function(A){this.defaultUrl=A},abort:function(){if(this.transaction){Ext.Ajax.abort(this.transaction)}},isUpdating:function(){if(this.transaction){return Ext.Ajax.isLoading(this.transaction)}return false}});Ext.Updater.defaults={timeout:30,loadScripts:false,sslBlankUrl:(Ext.SSL_SECURE_URL||"javascript:false"),disableCaching:false,showLoadIndicator:true,indicatorText:"<div class=\"loading-indicator\">Loading...</div>"};Ext.Updater.updateElement=function(D,C,E,B){var A=Ext.get(D).getUpdater();Ext.apply(A,B);A.update(C,E,B?B.callback:null)};Ext.Updater.BasicRenderer=function(){};Ext.Updater.BasicRenderer.prototype={render:function(C,A,B,D){C.update(A.responseText,B.loadScripts,D)}};Ext.UpdateManager=Ext.Updater;
(function(){Date.formatCodeToRegex=function(character,currentGroup){var p=Date.parseCodes[character];if(p){p=Ext.type(p)=="function"?p():p;Date.parseCodes[character]=p}return p?Ext.applyIf({c:p.c?String.format(p.c,currentGroup||"{0}"):p.c},p):{g:0,c:null,s:Ext.escapeRe(character)}};var $f=Date.formatCodeToRegex;Ext.apply(Date,{parseFunctions:{count:0},parseRegexes:[],formatFunctions:{count:0},daysInMonth:[31,28,31,30,31,30,31,31,30,31,30,31],y2kYear:50,MILLI:"ms",SECOND:"s",MINUTE:"mi",HOUR:"h",DAY:"d",MONTH:"mo",YEAR:"y",dayNames:["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"],monthNames:["January","February","March","April","May","June","July","August","September","October","November","December"],monthNumbers:{Jan:0,Feb:1,Mar:2,Apr:3,May:4,Jun:5,Jul:6,Aug:7,Sep:8,Oct:9,Nov:10,Dec:11},getShortMonthName:function(month){return Date.monthNames[month].substring(0,3)},getShortDayName:function(day){return Date.dayNames[day].substring(0,3)},getMonthNumber:function(name){return Date.monthNumbers[name.substring(0,1).toUpperCase()+name.substring(1,3).toLowerCase()]},formatCodes:{d:"String.leftPad(this.getDate(), 2, '0')",D:"Date.getShortDayName(this.getDay())",j:"this.getDate()",l:"Date.dayNames[this.getDay()]",N:"(this.getDay() ? this.getDay() : 7)",S:"this.getSuffix()",w:"this.getDay()",z:"this.getDayOfYear()",W:"String.leftPad(this.getWeekOfYear(), 2, '0')",F:"Date.monthNames[this.getMonth()]",m:"String.leftPad(this.getMonth() + 1, 2, '0')",M:"Date.getShortMonthName(this.getMonth())",n:"(this.getMonth() + 1)",t:"this.getDaysInMonth()",L:"(this.isLeapYear() ? 1 : 0)",o:"(this.getFullYear() + (this.getWeekOfYear() == 1 && this.getMonth() > 0 ? +1 : (this.getWeekOfYear() >= 52 && this.getMonth() < 11 ? -1 : 0)))",Y:"this.getFullYear()",y:"('' + this.getFullYear()).substring(2, 4)",a:"(this.getHours() < 12 ? 'am' : 'pm')",A:"(this.getHours() < 12 ? 'AM' : 'PM')",g:"((this.getHours() % 12) ? this.getHours() % 12 : 12)",G:"this.getHours()",h:"String.leftPad((this.getHours() % 12) ? this.getHours() % 12 : 12, 2, '0')",H:"String.leftPad(this.getHours(), 2, '0')",i:"String.leftPad(this.getMinutes(), 2, '0')",s:"String.leftPad(this.getSeconds(), 2, '0')",u:"String.leftPad(this.getMilliseconds(), 3, '0')",O:"this.getGMTOffset()",P:"this.getGMTOffset(true)",T:"this.getTimezone()",Z:"(this.getTimezoneOffset() * -60)",c:function(){for(var c="Y-m-dTH:i:sP",code=[],i=0,l=c.length;i<l;++i){var e=c.charAt(i);code.push(e=="T"?"'T'":Date.getFormatCode(e))}return code.join(" + ")},U:"Math.round(this.getTime() / 1000)"},parseDate:function(input,format){var p=Date.parseFunctions;if(p[format]==null){Date.createParser(format)}var func=p[format];return Date[func](input)},getFormatCode:function(character){var f=Date.formatCodes[character];if(f){f=Ext.type(f)=="function"?f():f;Date.formatCodes[character]=f}return f||("'"+String.escape(character)+"'")},createNewFormat:function(format){var funcName="format"+Date.formatFunctions.count++;Date.formatFunctions[format]=funcName;var code="Date.prototype."+funcName+" = function(){return ";var special=false;var ch="";for(var i=0;i<format.length;++i){ch=format.charAt(i);if(!special&&ch=="\\"){special=true}else{if(special){special=false;code+="'"+String.escape(ch)+"' + "}else{code+=Date.getFormatCode(ch)+" + "}}}eval(code.substring(0,code.length-3)+";}")},createParser:function(format){var funcName="parse"+Date.parseFunctions.count++;var regexNum=Date.parseRegexes.length;var currentGroup=1;Date.parseFunctions[format]=funcName;var code="Date."+funcName+" = function(input){\n"+"var y, m, d, h = 0, i = 0, s = 0, ms = 0, o, z, u, v;\n"+"input = String(input);\n"+"d = new Date();\n"+"y = d.getFullYear();\n"+"m = d.getMonth();\n"+"d = d.getDate();\n"+"var results = input.match(Date.parseRegexes["+regexNum+"]);\n"+"if (results && results.length > 0) {";var regex="";var special=false;var ch="";for(var i=0;i<format.length;++i){ch=format.charAt(i);if(!special&&ch=="\\"){special=true}else{if(special){special=false;regex+=String.escape(ch)}else{var obj=Date.formatCodeToRegex(ch,currentGroup);currentGroup+=obj.g;regex+=obj.s;if(obj.g&&obj.c){code+=obj.c}}}}code+="if (u){\n"+"v = new Date(u * 1000);\n"+"}else if (y >= 0 && m >= 0 && d > 0 && h >= 0 && i >= 0 && s >= 0 && ms >= 0){\n"+"v = new Date(y, m, d, h, i, s, ms);\n"+"}else if (y >= 0 && m >= 0 && d > 0 && h >= 0 && i >= 0 && s >= 0){\n"+"v = new Date(y, m, d, h, i, s);\n"+"}else if (y >= 0 && m >= 0 && d > 0 && h >= 0 && i >= 0){\n"+"v = new Date(y, m, d, h, i);\n"+"}else if (y >= 0 && m >= 0 && d > 0 && h >= 0){\n"+"v = new Date(y, m, d, h);\n"+"}else if (y >= 0 && m >= 0 && d > 0){\n"+"v = new Date(y, m, d);\n"+"}else if (y >= 0 && m >= 0){\n"+"v = new Date(y, m);\n"+"}else if (y >= 0){\n"+"v = new Date(y);\n"+"}\n}\nreturn (v && (z || o))?"+" (Ext.type(z) == 'number' ? v.add(Date.SECOND, -v.getTimezoneOffset() * 60 - z) :"+" v.add(Date.MINUTE, -v.getTimezoneOffset() + (sn == '+'? -1 : 1) * (hr * 60 + mn))) : v;\n"+"}";Date.parseRegexes[regexNum]=new RegExp("^"+regex+"$","i");eval(code)},parseCodes:{d:{g:1,c:"d = parseInt(results[{0}], 10);\n",s:"(\\d{2})"},j:{g:1,c:"d = parseInt(results[{0}], 10);\n",s:"(\\d{1,2})"},D:function(){for(var a=[],i=0;i<7;a.push(Date.getShortDayName(i)),++i){}return{g:0,c:null,s:"(?:"+a.join("|")+")"}},l:function(){return{g:0,c:null,s:"(?:"+Date.dayNames.join("|")+")"}},N:{g:0,c:null,s:"[1-7]"},S:{g:0,c:null,s:"(?:st|nd|rd|th)"},w:{g:0,c:null,s:"[0-6]"},z:{g:0,c:null,s:"(?:\\d{1,3}"},W:{g:0,c:null,s:"(?:\\d{2})"},F:function(){return{g:1,c:"m = parseInt(Date.getMonthNumber(results[{0}]), 10);\n",s:"("+Date.monthNames.join("|")+")"}},M:function(){for(var a=[],i=0;i<12;a.push(Date.getShortMonthName(i)),++i){}return Ext.applyIf({s:"("+a.join("|")+")"},$f("F"))},m:{g:1,c:"m = parseInt(results[{0}], 10) - 1;\n",s:"(\\d{2})"},n:{g:1,c:"m = parseInt(results[{0}], 10) - 1;\n",s:"(\\d{1,2})"},t:{g:0,c:null,s:"(?:\\d{2})"},L:{g:0,c:null,s:"(?:1|0)"},o:function(){return $f("Y")},Y:{g:1,c:"y = parseInt(results[{0}], 10);\n",s:"(\\d{4})"},y:{g:1,c:"var ty = parseInt(results[{0}], 10);\n"+"y = ty > Date.y2kYear ? 1900 + ty : 2000 + ty;\n",s:"(\\d{1,2})"},a:{g:1,c:"if (results[{0}] == 'am') {\n"+"if (h == 12) { h = 0; }\n"+"} else { if (h < 12) { h += 12; }}",s:"(am|pm)"},A:{g:1,c:"if (results[{0}] == 'AM') {\n"+"if (h == 12) { h = 0; }\n"+"} else { if (h < 12) { h += 12; }}",s:"(AM|PM)"},g:function(){return $f("G")},G:{g:1,c:"h = parseInt(results[{0}], 10);\n",s:"(\\d{1,2})"},h:function(){return $f("H")},H:{g:1,c:"h = parseInt(results[{0}], 10);\n",s:"(\\d{2})"},i:{g:1,c:"i = parseInt(results[{0}], 10);\n",s:"(\\d{2})"},s:{g:1,c:"s = parseInt(results[{0}], 10);\n",s:"(\\d{2})"},u:{g:1,c:"ms = results[{0}]; ms = parseInt(ms, 10)/Math.pow(10, ms.length - 3);\n",s:"(\\d+)"},O:{g:1,c:["o = results[{0}];","var sn = o.substring(0,1);","var hr = o.substring(1,3)*1 + Math.floor(o.substring(3,5) / 60);","var mn = o.substring(3,5) % 60;","o = ((-12 <= (hr*60 + mn)/60) && ((hr*60 + mn)/60 <= 14))? (sn + String.leftPad(hr, 2, '0') + String.leftPad(mn, 2, '0')) : null;\n"].join("\n"),s:"([+-]\\d{4})"},P:{g:1,c:["o = results[{0}];","var sn = o.substring(0,1);","var hr = o.substring(1,3)*1 + Math.floor(o.substring(4,6) / 60);","var mn = o.substring(4,6) % 60;","o = ((-12 <= (hr*60 + mn)/60) && ((hr*60 + mn)/60 <= 14))? (sn + String.leftPad(hr, 2, '0') + String.leftPad(mn, 2, '0')) : null;\n"].join("\n"),s:"([+-]\\d{2}:\\d{2})"},T:{g:0,c:null,s:"[A-Z]{1,4}"},Z:{g:1,c:"z = results[{0}] * 1;\n"+"z = (-43200 <= z && z <= 50400)? z : null;\n",s:"([+-]?\\d{1,5})"},c:function(){var calc=[];var arr=[$f("Y",1),$f("m",2),$f("d",3),$f("h",4),$f("i",5),$f("s",6),{c:"ms = (results[7] || '.0').substring(1); ms = parseInt(ms, 10)/Math.pow(10, ms.length - 3);\n"},{c:"if(results[9] == 'Z'){\no = 0;\n}else{\n"+$f("P",9).c+"\n}"}];for(var i=0,l=arr.length;i<l;++i){calc.push(arr[i].c)}return{g:1,c:calc.join(""),s:arr[0].s+"-"+arr[1].s+"-"+arr[2].s+"T"+arr[3].s+":"+arr[4].s+":"+arr[5].s+"((.|,)\\d+)?"+"("+$f("P",null).s+"|Z)"}},U:{g:1,c:"u = parseInt(results[{0}], 10);\n",s:"(-?\\d+)"}}})}());Ext.override(Date,{dateFormat:function(B){if(Date.formatFunctions[B]==null){Date.createNewFormat(B)}var A=Date.formatFunctions[B];return this[A]()},getTimezone:function(){return this.toString().replace(/^.* (?:\((.*)\)|([A-Z]{1,4})(?:[\-+][0-9]{4})?(?: -?\d+)?)$/,"$1$2").replace(/[^A-Z]/g,"")},getGMTOffset:function(A){return(this.getTimezoneOffset()>0?"-":"+")+String.leftPad(Math.abs(Math.floor(this.getTimezoneOffset()/60)),2,"0")+(A?":":"")+String.leftPad(Math.abs(this.getTimezoneOffset()%60),2,"0")},getDayOfYear:function(){var A=0;Date.daysInMonth[1]=this.isLeapYear()?29:28;for(var B=0;B<this.getMonth();++B){A+=Date.daysInMonth[B]}return A+this.getDate()-1},getWeekOfYear:function(){var B=86400000;var C=7*B;var D=Date.UTC(this.getFullYear(),this.getMonth(),this.getDate()+3)/B;var A=Math.floor(D/7);var E=new Date(A*C).getUTCFullYear();return A-Math.floor(Date.UTC(E,0,7)/C)+1},isLeapYear:function(){var A=this.getFullYear();return !!((A&3)==0&&(A%100||(A%400==0&&A)))},getFirstDayOfMonth:function(){var A=(this.getDay()-(this.getDate()-1))%7;return(A<0)?(A+7):A},getLastDayOfMonth:function(){var A=(this.getDay()+(Date.daysInMonth[this.getMonth()]-this.getDate()))%7;return(A<0)?(A+7):A},getFirstDateOfMonth:function(){return new Date(this.getFullYear(),this.getMonth(),1)},getLastDateOfMonth:function(){return new Date(this.getFullYear(),this.getMonth(),this.getDaysInMonth())},getDaysInMonth:function(){Date.daysInMonth[1]=this.isLeapYear()?29:28;return Date.daysInMonth[this.getMonth()]},getSuffix:function(){switch(this.getDate()){case 1:case 21:case 31:return"st";case 2:case 22:return"nd";case 3:case 23:return"rd";default:return"th"}},clone:function(){return new Date(this.getTime())},clearTime:function(A){if(A){return this.clone().clearTime()}this.setHours(0);this.setMinutes(0);this.setSeconds(0);this.setMilliseconds(0);return this},add:function(B,C){var D=this.clone();if(!B||C===0){return D}switch(B.toLowerCase()){case Date.MILLI:D.setMilliseconds(this.getMilliseconds()+C);break;case Date.SECOND:D.setSeconds(this.getSeconds()+C);break;case Date.MINUTE:D.setMinutes(this.getMinutes()+C);break;case Date.HOUR:D.setHours(this.getHours()+C);break;case Date.DAY:D.setDate(this.getDate()+C);break;case Date.MONTH:var A=this.getDate();if(A>28){A=Math.min(A,this.getFirstDateOfMonth().add("mo",C).getLastDateOfMonth().getDate())}D.setDate(A);D.setMonth(this.getMonth()+C);break;case Date.YEAR:D.setFullYear(this.getFullYear()+C);break}return D},between:function(C,A){var B=this.getTime();return C.getTime()<=B&&B<=A.getTime()}});Date.prototype.format=Date.prototype.dateFormat;if(Ext.isSafari){Date.brokenSetMonth=Date.prototype.setMonth;Date.prototype.setMonth=function(A){if(A<=-1){var D=Math.ceil(-A);var C=Math.ceil(D/12);var B=(D%12)?12-D%12:0;this.setFullYear(this.getFullYear()-C);return Date.brokenSetMonth.call(this,B)}else{return Date.brokenSetMonth.apply(this,arguments)}}};
Ext.util.DelayedTask=function(E,D,A){var G=null,F,B;var C=function(){var H=new Date().getTime();if(H-B>=F){clearInterval(G);G=null;E.apply(D,A||[])}};this.delay=function(I,K,J,H){if(G&&I!=F){this.cancel()}F=I;B=new Date().getTime();E=K||E;D=J||D;A=H||A;if(!G){G=setInterval(C,F)}};this.cancel=function(){if(G){clearInterval(G);G=null}}};
Ext.util.TaskRunner=function(E){E=E||10;var F=[],A=[];var B=0;var G=false;var D=function(){G=false;clearInterval(B);B=0};var H=function(){if(!G){G=true;B=setInterval(I,E)}};var C=function(J){A.push(J);if(J.onStop){J.onStop.apply(J.scope||J)}};var I=function(){if(A.length>0){for(var O=0,K=A.length;O<K;O++){F.remove(A[O])}A=[];if(F.length<1){D();return }}var M=new Date().getTime();for(var O=0,K=F.length;O<K;++O){var N=F[O];var J=M-N.taskRunTime;if(N.interval<=J){var L=N.run.apply(N.scope||N,N.args||[++N.taskRunCount]);N.taskRunTime=M;if(L===false||N.taskRunCount===N.repeat){C(N);return }}if(N.duration&&N.duration<=(M-N.taskStartTime)){C(N)}}};this.start=function(J){F.push(J);J.taskStartTime=new Date().getTime();J.taskRunTime=0;J.taskRunCount=0;H();return J};this.stop=function(J){C(J);return J};this.stopAll=function(){D();for(var K=0,J=F.length;K<J;K++){if(F[K].onStop){F[K].onStop()}}F=[];A=[]}};Ext.TaskMgr=new Ext.util.TaskRunner();
Ext.util.MixedCollection=function(B,A){this.items=[];this.map={};this.keys=[];this.length=0;this.addEvents("clear","add","replace","remove","sort");this.allowFunctions=B===true;if(A){this.getKey=A}Ext.util.MixedCollection.superclass.constructor.call(this)};Ext.extend(Ext.util.MixedCollection,Ext.util.Observable,{allowFunctions:false,add:function(B,C){if(arguments.length==1){C=arguments[0];B=this.getKey(C)}if(typeof B=="undefined"||B===null){this.length++;this.items.push(C);this.keys.push(null)}else{var A=this.map[B];if(A){return this.replace(B,C)}this.length++;this.items.push(C);this.map[B]=C;this.keys.push(B)}this.fireEvent("add",this.length-1,C,B);return C},getKey:function(A){return A.id},replace:function(C,D){if(arguments.length==1){D=arguments[0];C=this.getKey(D)}var A=this.item(C);if(typeof C=="undefined"||C===null||typeof A=="undefined"){return this.add(C,D)}var B=this.indexOfKey(C);this.items[B]=D;this.map[C]=D;this.fireEvent("replace",C,A,D);return D},addAll:function(E){if(arguments.length>1||Ext.isArray(E)){var B=arguments.length>1?arguments:E;for(var D=0,A=B.length;D<A;D++){this.add(B[D])}}else{for(var C in E){if(this.allowFunctions||typeof E[C]!="function"){this.add(C,E[C])}}}},each:function(E,D){var B=[].concat(this.items);for(var C=0,A=B.length;C<A;C++){if(E.call(D||B[C],B[C],C,A)===false){break}}},eachKey:function(D,C){for(var B=0,A=this.keys.length;B<A;B++){D.call(C||window,this.keys[B],this.items[B],B,A)}},find:function(D,C){for(var B=0,A=this.items.length;B<A;B++){if(D.call(C||window,this.items[B],this.keys[B])){return this.items[B]}}return null},insert:function(A,B,C){if(arguments.length==2){C=arguments[1];B=this.getKey(C)}if(A>=this.length){return this.add(B,C)}this.length++;this.items.splice(A,0,C);if(typeof B!="undefined"&&B!=null){this.map[B]=C}this.keys.splice(A,0,B);this.fireEvent("add",A,C,B);return C},remove:function(A){return this.removeAt(this.indexOf(A))},removeAt:function(A){if(A<this.length&&A>=0){this.length--;var C=this.items[A];this.items.splice(A,1);var B=this.keys[A];if(typeof B!="undefined"){delete this.map[B]}this.keys.splice(A,1);this.fireEvent("remove",C,B);return C}return false},removeKey:function(A){return this.removeAt(this.indexOfKey(A))},getCount:function(){return this.length},indexOf:function(A){return this.items.indexOf(A)},indexOfKey:function(A){return this.keys.indexOf(A)},item:function(A){var B=typeof this.map[A]!="undefined"?this.map[A]:this.items[A];return typeof B!="function"||this.allowFunctions?B:null},itemAt:function(A){return this.items[A]},key:function(A){return this.map[A]},contains:function(A){return this.indexOf(A)!=-1},containsKey:function(A){return typeof this.map[A]!="undefined"},clear:function(){this.length=0;this.items=[];this.keys=[];this.map={};this.fireEvent("clear")},first:function(){return this.items[0]},last:function(){return this.items[this.length-1]},_sort:function(I,A,H){var C=String(A).toUpperCase()=="DESC"?-1:1;H=H||function(K,J){return K-J};var G=[],B=this.keys,F=this.items;for(var D=0,E=F.length;D<E;D++){G[G.length]={key:B[D],value:F[D],index:D}}G.sort(function(K,J){var L=H(K[I],J[I])*C;if(L==0){L=(K.index<J.index?-1:1)}return L});for(var D=0,E=G.length;D<E;D++){F[D]=G[D].value;B[D]=G[D].key}this.fireEvent("sort",this)},sort:function(A,B){this._sort("value",A,B)},keySort:function(A,B){this._sort("key",A,B||function(D,C){return String(D).toUpperCase()-String(C).toUpperCase()})},getRange:function(E,A){var B=this.items;if(B.length<1){return[]}E=E||0;A=Math.min(typeof A=="undefined"?this.length-1:A,this.length-1);var D=[];if(E<=A){for(var C=E;C<=A;C++){D[D.length]=B[C]}}else{for(var C=E;C>=A;C--){D[D.length]=B[C]}}return D},filter:function(C,B,D,A){if(Ext.isEmpty(B,false)){return this.clone()}B=this.createValueMatcher(B,D,A);return this.filterBy(function(E){return E&&B.test(E[C])})},filterBy:function(F,E){var G=new Ext.util.MixedCollection();G.getKey=this.getKey;var B=this.keys,D=this.items;for(var C=0,A=D.length;C<A;C++){if(F.call(E||this,D[C],B[C])){G.add(B[C],D[C])}}return G},findIndex:function(C,B,E,D,A){if(Ext.isEmpty(B,false)){return -1}B=this.createValueMatcher(B,D,A);return this.findIndexBy(function(F){return F&&B.test(F[C])},null,E)},findIndexBy:function(F,E,G){var B=this.keys,D=this.items;for(var C=(G||0),A=D.length;C<A;C++){if(F.call(E||this,D[C],B[C])){return C}}if(typeof G=="number"&&G>0){for(var C=0;C<G;C++){if(F.call(E||this,D[C],B[C])){return C}}}return -1},createValueMatcher:function(B,C,A){if(!B.exec){B=String(B);B=new RegExp((C===true?"":"^")+Ext.escapeRe(B),A?"":"i")}return B},clone:function(){var E=new Ext.util.MixedCollection();var B=this.keys,D=this.items;for(var C=0,A=D.length;C<A;C++){E.add(B[C],D[C])}E.getKey=this.getKey;return E}});Ext.util.MixedCollection.prototype.get=Ext.util.MixedCollection.prototype.item;
Ext.util.JSON=new (function(){var useHasOwn=!!{}.hasOwnProperty;var pad=function(n){return n<10?"0"+n:n};var m={"\b":"\\b","\t":"\\t","\n":"\\n","\f":"\\f","\r":"\\r","\"":"\\\"","\\":"\\\\"};var encodeString=function(s){if(/["\\\x00-\x1f]/.test(s)){return"\""+s.replace(/([\x00-\x1f\\"])/g,function(a,b){var c=m[b];if(c){return c}c=b.charCodeAt();return"\\u00"+Math.floor(c/16).toString(16)+(c%16).toString(16)})+"\""}return"\""+s+"\""};var encodeArray=function(o){var a=["["],b,i,l=o.length,v;for(i=0;i<l;i+=1){v=o[i];switch(typeof v){case"undefined":case"function":case"unknown":break;default:if(b){a.push(",")}a.push(v===null?"null":Ext.util.JSON.encode(v));b=true}}a.push("]");return a.join("")};this.encodeDate=function(o){return"\""+o.getFullYear()+"-"+pad(o.getMonth()+1)+"-"+pad(o.getDate())+"T"+pad(o.getHours())+":"+pad(o.getMinutes())+":"+pad(o.getSeconds())+"\""};this.encode=function(o){if(typeof o=="undefined"||o===null){return"null"}else{if(Ext.isArray(o)){return encodeArray(o)}else{if(Ext.isDate(o)){return Ext.util.JSON.encodeDate(o)}else{if(typeof o=="string"){return encodeString(o)}else{if(typeof o=="number"){return isFinite(o)?String(o):"null"}else{if(typeof o=="boolean"){return String(o)}else{var a=["{"],b,i,v;for(i in o){if(!useHasOwn||o.hasOwnProperty(i)){v=o[i];switch(typeof v){case"undefined":case"function":case"unknown":break;default:if(b){a.push(",")}a.push(this.encode(i),":",v===null?"null":this.encode(v));b=true}}}a.push("}");return a.join("")}}}}}}};this.decode=function(json){return eval("("+json+")")}})();Ext.encode=Ext.util.JSON.encode;Ext.decode=Ext.util.JSON.decode;
Ext.util.Format=function(){var trimRe=/^\s+|\s+$/g;return{ellipsis:function(value,len){if(value&&value.length>len){return value.substr(0,len-3)+"..."}return value},undef:function(value){return value!==undefined?value:""},defaultValue:function(value,defaultValue){return value!==undefined&&value!==""?value:defaultValue},htmlEncode:function(value){return !value?value:String(value).replace(/&/g,"&amp;").replace(/>/g,"&gt;").replace(/</g,"&lt;").replace(/"/g,"&quot;")},htmlDecode:function(value){return !value?value:String(value).replace(/&gt;/g,">").replace(/&lt;/g,"<").replace(/&quot;/g,"\"").replace(/&amp;/g,"&")},trim:function(value){return String(value).replace(trimRe,"")},substr:function(value,start,length){return String(value).substr(start,length)},lowercase:function(value){return String(value).toLowerCase()},uppercase:function(value){return String(value).toUpperCase()},capitalize:function(value){return !value?value:value.charAt(0).toUpperCase()+value.substr(1).toLowerCase()},call:function(value,fn){if(arguments.length>2){var args=Array.prototype.slice.call(arguments,2);args.unshift(value);return eval(fn).apply(window,args)}else{return eval(fn).call(window,value)}},usMoney:function(v){v=(Math.round((v-0)*100))/100;v=(v==Math.floor(v))?v+".00":((v*10==Math.floor(v*10))?v+"0":v);v=String(v);var ps=v.split(".");var whole=ps[0];var sub=ps[1]?"."+ps[1]:".00";var r=/(\d+)(\d{3})/;while(r.test(whole)){whole=whole.replace(r,"$1"+","+"$2")}v=whole+sub;if(v.charAt(0)=="-"){return"-$"+v.substr(1)}return"$"+v},date:function(v,format){if(!v){return""}if(!Ext.isDate(v)){v=new Date(Date.parse(v))}return v.dateFormat(format||"m/d/Y")},dateRenderer:function(format){return function(v){return Ext.util.Format.date(v,format)}},stripTagsRE:/<\/?[^>]+>/gi,stripTags:function(v){return !v?v:String(v).replace(this.stripTagsRE,"")},stripScriptsRe:/(?:<script.*?>)((\n|\r|.)*?)(?:<\/script>)/ig,stripScripts:function(v){return !v?v:String(v).replace(this.stripScriptsRe,"")},fileSize:function(size){if(size<1024){return size+" bytes"}else{if(size<1048576){return(Math.round(((size*10)/1024))/10)+" KB"}else{return(Math.round(((size*10)/1048576))/10)+" MB"}}},math:function(){var fns={};return function(v,a){if(!fns[a]){fns[a]=new Function("v","return v "+a+";")}return fns[a](v)}}(),nl2br:function(v){return v===undefined||v===null?"":v.replace(/\n/g,"<br/>")}}}();
Ext.XTemplate=function(){Ext.XTemplate.superclass.constructor.apply(this,arguments);var P=this.html;P=["<tpl>",P,"</tpl>"].join("");var O=/<tpl\b[^>]*>((?:(?=([^<]+))\2|<(?!tpl\b[^>]*>))*?)<\/tpl>/;var N=/^<tpl\b[^>]*?for="(.*?)"/;var L=/^<tpl\b[^>]*?if="(.*?)"/;var J=/^<tpl\b[^>]*?exec="(.*?)"/;var C,B=0;var G=[];while(C=P.match(O)){var M=C[0].match(N);var K=C[0].match(L);var I=C[0].match(J);var E=null,H=null,D=null;var A=M&&M[1]?M[1]:"";if(K){E=K&&K[1]?K[1]:null;if(E){H=new Function("values","parent","xindex","xcount","with(values){ return "+(Ext.util.Format.htmlDecode(E))+"; }")}}if(I){E=I&&I[1]?I[1]:null;if(E){D=new Function("values","parent","xindex","xcount","with(values){ "+(Ext.util.Format.htmlDecode(E))+"; }")}}if(A){switch(A){case".":A=new Function("values","parent","with(values){ return values; }");break;case"..":A=new Function("values","parent","with(values){ return parent; }");break;default:A=new Function("values","parent","with(values){ return "+A+"; }")}}G.push({id:B,target:A,exec:D,test:H,body:C[1]||""});P=P.replace(C[0],"{xtpl"+B+"}");++B}for(var F=G.length-1;F>=0;--F){this.compileTpl(G[F])}this.master=G[G.length-1];this.tpls=G};Ext.extend(Ext.XTemplate,Ext.Template,{re:/\{([\w-\.\#]+)(?:\:([\w\.]*)(?:\((.*?)?\))?)?(\s?[\+\-\*\\]\s?[\d\.\+\-\*\\\(\)]+)?\}/g,codeRe:/\{\[((?:\\\]|.|\n)*?)\]\}/g,applySubTemplate:function(A,H,G,D,C){var J=this.tpls[A];if(J.test&&!J.test.call(this,H,G,D,C)){return""}if(J.exec&&J.exec.call(this,H,G,D,C)){return""}var I=J.target?J.target.call(this,H,G):H;G=J.target?H:G;if(J.target&&Ext.isArray(I)){var B=[];for(var E=0,F=I.length;E<F;E++){B[B.length]=J.compiled.call(this,I[E],G,E+1,F)}return B.join("")}return J.compiled.call(this,I,G,D,C)},compileTpl:function(tpl){var fm=Ext.util.Format;var useF=this.disableFormats!==true;var sep=Ext.isGecko?"+":",";var fn=function(m,name,format,args,math){if(name.substr(0,4)=="xtpl"){return"'"+sep+"this.applySubTemplate("+name.substr(4)+", values, parent, xindex, xcount)"+sep+"'"}var v;if(name==="."){v="values"}else{if(name==="#"){v="xindex"}else{if(name.indexOf(".")!=-1){v=name}else{v="values['"+name+"']"}}}if(math){v="("+v+math+")"}if(format&&useF){args=args?","+args:"";if(format.substr(0,5)!="this."){format="fm."+format+"("}else{format="this.call(\""+format.substr(5)+"\", ";args=", values"}}else{args="";format="("+v+" === undefined ? '' : "}return"'"+sep+format+v+args+")"+sep+"'"};var codeFn=function(m,code){return"'"+sep+"("+code+")"+sep+"'"};var body;if(Ext.isGecko){body="tpl.compiled = function(values, parent, xindex, xcount){ return '"+tpl.body.replace(/(\r\n|\n)/g,"\\n").replace(/'/g,"\\'").replace(this.re,fn).replace(this.codeRe,codeFn)+"';};"}else{body=["tpl.compiled = function(values, parent, xindex, xcount){ return ['"];body.push(tpl.body.replace(/(\r\n|\n)/g,"\\n").replace(/'/g,"\\'").replace(this.re,fn).replace(this.codeRe,codeFn));body.push("'].join('');};");body=body.join("")}eval(body);return this},applyTemplate:function(A){return this.master.compiled.call(this,A,{},1,1)},compile:function(){return this}});Ext.XTemplate.prototype.apply=Ext.XTemplate.prototype.applyTemplate;Ext.XTemplate.from=function(A){A=Ext.getDom(A);return new Ext.XTemplate(A.value||A.innerHTML)};
Ext.util.CSS=function(){var D=null;var C=document;var B=/(-[a-z])/gi;var A=function(E,F){return F.charAt(1).toUpperCase()};return{createStyleSheet:function(G,J){var F;var E=C.getElementsByTagName("head")[0];var I=C.createElement("style");I.setAttribute("type","text/css");if(J){I.setAttribute("id",J)}if(Ext.isIE){E.appendChild(I);F=I.styleSheet;F.cssText=G}else{try{I.appendChild(C.createTextNode(G))}catch(H){I.cssText=G}E.appendChild(I);F=I.styleSheet?I.styleSheet:(I.sheet||C.styleSheets[C.styleSheets.length-1])}this.cacheStyleSheet(F);return F},removeStyleSheet:function(F){var E=C.getElementById(F);if(E){E.parentNode.removeChild(E)}},swapStyleSheet:function(G,E){this.removeStyleSheet(G);var F=C.createElement("link");F.setAttribute("rel","stylesheet");F.setAttribute("type","text/css");F.setAttribute("id",G);F.setAttribute("href",E);C.getElementsByTagName("head")[0].appendChild(F)},refreshCache:function(){return this.getRules(true)},cacheStyleSheet:function(F){if(!D){D={}}try{var H=F.cssRules||F.rules;for(var E=H.length-1;E>=0;--E){D[H[E].selectorText]=H[E]}}catch(G){}},getRules:function(F){if(D==null||F){D={};var H=C.styleSheets;for(var G=0,E=H.length;G<E;G++){try{this.cacheStyleSheet(H[G])}catch(I){}}}return D},getRule:function(E,G){var F=this.getRules(G);if(!Ext.isArray(E)){return F[E]}for(var H=0;H<E.length;H++){if(F[E[H]]){return F[E[H]]}}return null},updateRule:function(E,H,G){if(!Ext.isArray(E)){var I=this.getRule(E);if(I){I.style[H.replace(B,A)]=G;return true}}else{for(var F=0;F<E.length;F++){if(this.updateRule(E[F],H,G)){return true}}}return false}}}();
Ext.util.ClickRepeater=function(B,A){this.el=Ext.get(B);this.el.unselectable();Ext.apply(this,A);this.addEvents("mousedown","click","mouseup");this.el.on("mousedown",this.handleMouseDown,this);if(this.preventDefault||this.stopDefault){this.el.on("click",function(C){if(this.preventDefault){C.preventDefault()}if(this.stopDefault){C.stopEvent()}},this)}if(this.handler){this.on("click",this.handler,this.scope||this)}Ext.util.ClickRepeater.superclass.constructor.call(this)};Ext.extend(Ext.util.ClickRepeater,Ext.util.Observable,{interval:20,delay:250,preventDefault:true,stopDefault:false,timer:0,handleMouseDown:function(){clearTimeout(this.timer);this.el.blur();if(this.pressClass){this.el.addClass(this.pressClass)}this.mousedownTime=new Date();Ext.getDoc().on("mouseup",this.handleMouseUp,this);this.el.on("mouseout",this.handleMouseOut,this);this.fireEvent("mousedown",this);this.fireEvent("click",this);if(this.accelerate){this.delay=400}this.timer=this.click.defer(this.delay||this.interval,this)},click:function(){this.fireEvent("click",this);this.timer=this.click.defer(this.accelerate?this.easeOutExpo(this.mousedownTime.getElapsed(),400,-390,12000):this.interval,this)},easeOutExpo:function(B,A,D,C){return(B==C)?A+D:D*(-Math.pow(2,-10*B/C)+1)+A},handleMouseOut:function(){clearTimeout(this.timer);if(this.pressClass){this.el.removeClass(this.pressClass)}this.el.on("mouseover",this.handleMouseReturn,this)},handleMouseReturn:function(){this.el.un("mouseover",this.handleMouseReturn,this);if(this.pressClass){this.el.addClass(this.pressClass)}this.click()},handleMouseUp:function(){clearTimeout(this.timer);this.el.un("mouseover",this.handleMouseReturn,this);this.el.un("mouseout",this.handleMouseOut,this);Ext.getDoc().un("mouseup",this.handleMouseUp,this);this.el.removeClass(this.pressClass);this.fireEvent("mouseup",this)}});
Ext.KeyNav=function(B,A){this.el=Ext.get(B);Ext.apply(this,A);if(!this.disabled){this.disabled=true;this.enable()}};Ext.KeyNav.prototype={disabled:false,defaultEventAction:"stopEvent",forceKeyDown:false,prepareEvent:function(C){var A=C.getKey();var B=this.keyToHandler[A];if(Ext.isSafari2&&B&&A>=37&&A<=40){C.stopEvent()}},relay:function(C){var A=C.getKey();var B=this.keyToHandler[A];if(B&&this[B]){if(this.doRelay(C,this[B],B)!==true){C[this.defaultEventAction]()}}},doRelay:function(C,B,A){return B.call(this.scope||this,C)},enter:false,left:false,right:false,up:false,down:false,tab:false,esc:false,pageUp:false,pageDown:false,del:false,home:false,end:false,keyToHandler:{37:"left",39:"right",38:"up",40:"down",33:"pageUp",34:"pageDown",46:"del",36:"home",35:"end",13:"enter",27:"esc",9:"tab"},enable:function(){if(this.disabled){if(this.forceKeyDown||Ext.isIE||Ext.isSafari3||Ext.isAir){this.el.on("keydown",this.relay,this)}else{this.el.on("keydown",this.prepareEvent,this);this.el.on("keypress",this.relay,this)}this.disabled=false}},disable:function(){if(!this.disabled){if(this.forceKeyDown||Ext.isIE||Ext.isSafari3||Ext.isAir){this.el.un("keydown",this.relay)}else{this.el.un("keydown",this.prepareEvent);this.el.un("keypress",this.relay)}this.disabled=true}}};
Ext.KeyMap=function(C,B,A){this.el=Ext.get(C);this.eventName=A||"keydown";this.bindings=[];if(B){this.addBinding(B)}this.enable()};Ext.KeyMap.prototype={stopEvent:false,addBinding:function(D){if(Ext.isArray(D)){for(var F=0,H=D.length;F<H;F++){this.addBinding(D[F])}return }var N=D.key,C=D.shift,A=D.ctrl,G=D.alt,J=D.fn||D.handler,M=D.scope;if(D.stopEvent){this.stopEvent=D.stopEvent}if(typeof N=="string"){var K=[];var I=N.toUpperCase();for(var E=0,H=I.length;E<H;E++){K.push(I.charCodeAt(E))}N=K}var B=Ext.isArray(N);var L=function(R){if((!C||R.shiftKey)&&(!A||R.ctrlKey)&&(!G||R.altKey)){var P=R.getKey();if(B){for(var Q=0,O=N.length;Q<O;Q++){if(N[Q]==P){if(this.stopEvent){R.stopEvent()}J.call(M||window,P,R);return }}}else{if(P==N){if(this.stopEvent){R.stopEvent()}J.call(M||window,P,R)}}}};this.bindings.push(L)},on:function(B,D,C){var G,A,E,F;if(typeof B=="object"&&!Ext.isArray(B)){G=B.key;A=B.shift;E=B.ctrl;F=B.alt}else{G=B}this.addBinding({key:G,shift:A,ctrl:E,alt:F,fn:D,scope:C})},handleKeyDown:function(D){if(this.enabled){var B=this.bindings;for(var C=0,A=B.length;C<A;C++){B[C].call(this,D)}}},isEnabled:function(){return this.enabled},enable:function(){if(!this.enabled){this.el.on(this.eventName,this.handleKeyDown,this);this.enabled=true}},disable:function(){if(this.enabled){this.el.removeListener(this.eventName,this.handleKeyDown,this);this.enabled=false}}};
Ext.util.TextMetrics=function(){var A;return{measure:function(B,C,D){if(!A){A=Ext.util.TextMetrics.Instance(B,D)}A.bind(B);A.setFixedWidth(D||"auto");return A.getSize(C)},createInstance:function(B,C){return Ext.util.TextMetrics.Instance(B,C)}}}();Ext.util.TextMetrics.Instance=function(B,D){var C=new Ext.Element(document.createElement("div"));document.body.appendChild(C.dom);C.position("absolute");C.setLeftTop(-1000,-1000);C.hide();if(D){C.setWidth(D)}var A={getSize:function(F){C.update(F);var E=C.getSize();C.update("");return E},bind:function(E){C.setStyle(Ext.fly(E).getStyles("font-size","font-style","font-weight","font-family","line-height","text-transform","letter-spacing"))},setFixedWidth:function(E){C.setWidth(E)},getWidth:function(E){C.dom.style.width="auto";return this.getSize(E).width},getHeight:function(E){return this.getSize(E).height}};A.bind(B);return A};Ext.Element.measureText=Ext.util.TextMetrics.measure;
(function(){var A=Ext.EventManager;var B=Ext.lib.Dom;Ext.dd.DragDrop=function(E,C,D){if(E){this.init(E,C,D)}};Ext.dd.DragDrop.prototype={id:null,config:null,dragElId:null,handleElId:null,invalidHandleTypes:null,invalidHandleIds:null,invalidHandleClasses:null,startPageX:0,startPageY:0,groups:null,locked:false,lock:function(){this.locked=true},unlock:function(){this.locked=false},isTarget:true,padding:null,_domRef:null,__ygDragDrop:true,constrainX:false,constrainY:false,minX:0,maxX:0,minY:0,maxY:0,maintainOffset:false,xTicks:null,yTicks:null,primaryButtonOnly:true,available:false,hasOuterHandles:false,b4StartDrag:function(C,D){},startDrag:function(C,D){},b4Drag:function(C){},onDrag:function(C){},onDragEnter:function(C,D){},b4DragOver:function(C){},onDragOver:function(C,D){},b4DragOut:function(C){},onDragOut:function(C,D){},b4DragDrop:function(C){},onDragDrop:function(C,D){},onInvalidDrop:function(C){},b4EndDrag:function(C){},endDrag:function(C){},b4MouseDown:function(C){},onMouseDown:function(C){},onMouseUp:function(C){},onAvailable:function(){},defaultPadding:{left:0,right:0,top:0,bottom:0},constrainTo:function(H,F,M){if(typeof F=="number"){F={left:F,right:F,top:F,bottom:F}}F=F||this.defaultPadding;var J=Ext.get(this.getEl()).getBox();var C=Ext.get(H);var L=C.getScroll();var I,D=C.dom;if(D==document.body){I={x:L.left,y:L.top,width:Ext.lib.Dom.getViewWidth(),height:Ext.lib.Dom.getViewHeight()}}else{var K=C.getXY();I={x:K[0]+L.left,y:K[1]+L.top,width:D.clientWidth,height:D.clientHeight}}var G=J.y-I.y;var E=J.x-I.x;this.resetConstraints();this.setXConstraint(E-(F.left||0),I.width-E-J.width-(F.right||0),this.xTickSize);this.setYConstraint(G-(F.top||0),I.height-G-J.height-(F.bottom||0),this.yTickSize)},getEl:function(){if(!this._domRef){this._domRef=Ext.getDom(this.id)}return this._domRef},getDragEl:function(){return Ext.getDom(this.dragElId)},init:function(E,C,D){this.initTarget(E,C,D);A.on(this.id,"mousedown",this.handleMouseDown,this)},initTarget:function(E,C,D){this.config=D||{};this.DDM=Ext.dd.DDM;this.groups={};if(typeof E!=="string"){E=Ext.id(E)}this.id=E;this.addToGroup((C)?C:"default");this.handleElId=E;this.setDragElId(E);this.invalidHandleTypes={A:"A"};this.invalidHandleIds={};this.invalidHandleClasses=[];this.applyConfig();this.handleOnAvailable()},applyConfig:function(){this.padding=this.config.padding||[0,0,0,0];this.isTarget=(this.config.isTarget!==false);this.maintainOffset=(this.config.maintainOffset);this.primaryButtonOnly=(this.config.primaryButtonOnly!==false)},handleOnAvailable:function(){this.available=true;this.resetConstraints();this.onAvailable()},setPadding:function(E,C,F,D){if(!C&&0!==C){this.padding=[E,E,E,E]}else{if(!F&&0!==F){this.padding=[E,C,E,C]}else{this.padding=[E,C,F,D]}}},setInitPosition:function(F,E){var G=this.getEl();if(!this.DDM.verifyEl(G)){return }var D=F||0;var C=E||0;var H=B.getXY(G);this.initPageX=H[0]-D;this.initPageY=H[1]-C;this.lastPageX=H[0];this.lastPageY=H[1];this.setStartPosition(H)},setStartPosition:function(D){var C=D||B.getXY(this.getEl());this.deltaSetXY=null;this.startPageX=C[0];this.startPageY=C[1]},addToGroup:function(C){this.groups[C]=true;this.DDM.regDragDrop(this,C)},removeFromGroup:function(C){if(this.groups[C]){delete this.groups[C]}this.DDM.removeDDFromGroup(this,C)},setDragElId:function(C){this.dragElId=C},setHandleElId:function(C){if(typeof C!=="string"){C=Ext.id(C)}this.handleElId=C;this.DDM.regHandle(this.id,C)},setOuterHandleElId:function(C){if(typeof C!=="string"){C=Ext.id(C)}A.on(C,"mousedown",this.handleMouseDown,this);this.setHandleElId(C);this.hasOuterHandles=true},unreg:function(){A.un(this.id,"mousedown",this.handleMouseDown);this._domRef=null;this.DDM._remove(this)},destroy:function(){this.unreg()},isLocked:function(){return(this.DDM.isLocked()||this.locked)},handleMouseDown:function(E,D){if(this.primaryButtonOnly&&E.button!=0){return }if(this.isLocked()){return }this.DDM.refreshCache(this.groups);var C=new Ext.lib.Point(Ext.lib.Event.getPageX(E),Ext.lib.Event.getPageY(E));if(!this.hasOuterHandles&&!this.DDM.isOverTarget(C,this)){}else{if(this.clickValidator(E)){this.setStartPosition();this.b4MouseDown(E);this.onMouseDown(E);this.DDM.handleMouseDown(E,this);this.DDM.stopEvent(E)}else{}}},clickValidator:function(D){var C=D.getTarget();return(this.isValidHandleChild(C)&&(this.id==this.handleElId||this.DDM.handleWasClicked(C,this.id)))},addInvalidHandleType:function(C){var D=C.toUpperCase();this.invalidHandleTypes[D]=D},addInvalidHandleId:function(C){if(typeof C!=="string"){C=Ext.id(C)}this.invalidHandleIds[C]=C},addInvalidHandleClass:function(C){this.invalidHandleClasses.push(C)},removeInvalidHandleType:function(C){var D=C.toUpperCase();delete this.invalidHandleTypes[D]},removeInvalidHandleId:function(C){if(typeof C!=="string"){C=Ext.id(C)}delete this.invalidHandleIds[C]},removeInvalidHandleClass:function(D){for(var E=0,C=this.invalidHandleClasses.length;E<C;++E){if(this.invalidHandleClasses[E]==D){delete this.invalidHandleClasses[E]}}},isValidHandleChild:function(F){var E=true;var H;try{H=F.nodeName.toUpperCase()}catch(G){H=F.nodeName}E=E&&!this.invalidHandleTypes[H];E=E&&!this.invalidHandleIds[F.id];for(var D=0,C=this.invalidHandleClasses.length;E&&D<C;++D){E=!Ext.fly(F).hasClass(this.invalidHandleClasses[D])}return E},setXTicks:function(F,C){this.xTicks=[];this.xTickSize=C;var E={};for(var D=this.initPageX;D>=this.minX;D=D-C){if(!E[D]){this.xTicks[this.xTicks.length]=D;E[D]=true}}for(D=this.initPageX;D<=this.maxX;D=D+C){if(!E[D]){this.xTicks[this.xTicks.length]=D;E[D]=true}}this.xTicks.sort(this.DDM.numericSort)},setYTicks:function(F,C){this.yTicks=[];this.yTickSize=C;var E={};for(var D=this.initPageY;D>=this.minY;D=D-C){if(!E[D]){this.yTicks[this.yTicks.length]=D;E[D]=true}}for(D=this.initPageY;D<=this.maxY;D=D+C){if(!E[D]){this.yTicks[this.yTicks.length]=D;E[D]=true}}this.yTicks.sort(this.DDM.numericSort)},setXConstraint:function(E,D,C){this.leftConstraint=E;this.rightConstraint=D;this.minX=this.initPageX-E;this.maxX=this.initPageX+D;if(C){this.setXTicks(this.initPageX,C)}this.constrainX=true},clearConstraints:function(){this.constrainX=false;this.constrainY=false;this.clearTicks()},clearTicks:function(){this.xTicks=null;this.yTicks=null;this.xTickSize=0;this.yTickSize=0},setYConstraint:function(C,E,D){this.topConstraint=C;this.bottomConstraint=E;this.minY=this.initPageY-C;this.maxY=this.initPageY+E;if(D){this.setYTicks(this.initPageY,D)}this.constrainY=true},resetConstraints:function(){if(this.initPageX||this.initPageX===0){var D=(this.maintainOffset)?this.lastPageX-this.initPageX:0;var C=(this.maintainOffset)?this.lastPageY-this.initPageY:0;this.setInitPosition(D,C)}else{this.setInitPosition()}if(this.constrainX){this.setXConstraint(this.leftConstraint,this.rightConstraint,this.xTickSize)}if(this.constrainY){this.setYConstraint(this.topConstraint,this.bottomConstraint,this.yTickSize)}},getTick:function(I,F){if(!F){return I}else{if(F[0]>=I){return F[0]}else{for(var D=0,C=F.length;D<C;++D){var E=D+1;if(F[E]&&F[E]>=I){var H=I-F[D];var G=F[E]-I;return(G>H)?F[D]:F[E]}}return F[F.length-1]}}},toString:function(){return("DragDrop "+this.id)}}})();if(!Ext.dd.DragDropMgr){Ext.dd.DragDropMgr=function(){var A=Ext.EventManager;return{ids:{},handleIds:{},dragCurrent:null,dragOvers:{},deltaX:0,deltaY:0,preventDefault:true,stopPropagation:true,initialized:false,locked:false,init:function(){this.initialized=true},POINT:0,INTERSECT:1,mode:0,_execOnAll:function(D,C){for(var E in this.ids){for(var B in this.ids[E]){var F=this.ids[E][B];if(!this.isTypeOfDD(F)){continue}F[D].apply(F,C)}}},_onLoad:function(){this.init();A.on(document,"mouseup",this.handleMouseUp,this,true);A.on(document,"mousemove",this.handleMouseMove,this,true);A.on(window,"unload",this._onUnload,this,true);A.on(window,"resize",this._onResize,this,true)},_onResize:function(B){this._execOnAll("resetConstraints",[])},lock:function(){this.locked=true},unlock:function(){this.locked=false},isLocked:function(){return this.locked},locationCache:{},useCache:true,clickPixelThresh:3,clickTimeThresh:350,dragThreshMet:false,clickTimeout:null,startX:0,startY:0,regDragDrop:function(C,B){if(!this.initialized){this.init()}if(!this.ids[B]){this.ids[B]={}}this.ids[B][C.id]=C},removeDDFromGroup:function(D,B){if(!this.ids[B]){this.ids[B]={}}var C=this.ids[B];if(C&&C[D.id]){delete C[D.id]}},_remove:function(C){for(var B in C.groups){if(B&&this.ids[B][C.id]){delete this.ids[B][C.id]}}delete this.handleIds[C.id]},regHandle:function(C,B){if(!this.handleIds[C]){this.handleIds[C]={}}this.handleIds[C][B]=B},isDragDrop:function(B){return(this.getDDById(B))?true:false},getRelated:function(F,C){var E=[];for(var D in F.groups){for(j in this.ids[D]){var B=this.ids[D][j];if(!this.isTypeOfDD(B)){continue}if(!C||B.isTarget){E[E.length]=B}}}return E},isLegalTarget:function(F,E){var C=this.getRelated(F,true);for(var D=0,B=C.length;D<B;++D){if(C[D].id==E.id){return true}}return false},isTypeOfDD:function(B){return(B&&B.__ygDragDrop)},isHandle:function(C,B){return(this.handleIds[C]&&this.handleIds[C][B])},getDDById:function(C){for(var B in this.ids){if(this.ids[B][C]){return this.ids[B][C]}}return null},handleMouseDown:function(D,C){if(Ext.QuickTips){Ext.QuickTips.disable()}this.currentTarget=D.getTarget();this.dragCurrent=C;var B=C.getEl();this.startX=D.getPageX();this.startY=D.getPageY();this.deltaX=this.startX-B.offsetLeft;this.deltaY=this.startY-B.offsetTop;this.dragThreshMet=false;this.clickTimeout=setTimeout(function(){var E=Ext.dd.DDM;E.startDrag(E.startX,E.startY)},this.clickTimeThresh)},startDrag:function(B,C){clearTimeout(this.clickTimeout);if(this.dragCurrent){this.dragCurrent.b4StartDrag(B,C);this.dragCurrent.startDrag(B,C)}this.dragThreshMet=true},handleMouseUp:function(B){if(Ext.QuickTips){Ext.QuickTips.enable()}if(!this.dragCurrent){return }clearTimeout(this.clickTimeout);if(this.dragThreshMet){this.fireEvents(B,true)}else{}this.stopDrag(B);this.stopEvent(B)},stopEvent:function(B){if(this.stopPropagation){B.stopPropagation()}if(this.preventDefault){B.preventDefault()}},stopDrag:function(B){if(this.dragCurrent){if(this.dragThreshMet){this.dragCurrent.b4EndDrag(B);this.dragCurrent.endDrag(B)}this.dragCurrent.onMouseUp(B)}this.dragCurrent=null;this.dragOvers={}},handleMouseMove:function(D){if(!this.dragCurrent){return true}if(Ext.isIE&&(D.button!==0&&D.button!==1&&D.button!==2)){this.stopEvent(D);return this.handleMouseUp(D)}if(!this.dragThreshMet){var C=Math.abs(this.startX-D.getPageX());var B=Math.abs(this.startY-D.getPageY());if(C>this.clickPixelThresh||B>this.clickPixelThresh){this.startDrag(this.startX,this.startY)}}if(this.dragThreshMet){this.dragCurrent.b4Drag(D);this.dragCurrent.onDrag(D);if(!this.dragCurrent.moveOnly){this.fireEvents(D,false)}}this.stopEvent(D);return true},fireEvents:function(K,L){var N=this.dragCurrent;if(!N||N.isLocked()){return }var O=K.getPoint();var B=[];var E=[];var I=[];var G=[];var D=[];for(var F in this.dragOvers){var C=this.dragOvers[F];if(!this.isTypeOfDD(C)){continue}if(!this.isOverTarget(O,C,this.mode)){E.push(C)}B[F]=true;delete this.dragOvers[F]}for(var M in N.groups){if("string"!=typeof M){continue}for(F in this.ids[M]){var H=this.ids[M][F];if(!this.isTypeOfDD(H)){continue}if(H.isTarget&&!H.isLocked()&&H!=N){if(this.isOverTarget(O,H,this.mode)){if(L){G.push(H)}else{if(!B[H.id]){D.push(H)}else{I.push(H)}this.dragOvers[H.id]=H}}}}}if(this.mode){if(E.length){N.b4DragOut(K,E);N.onDragOut(K,E)}if(D.length){N.onDragEnter(K,D)}if(I.length){N.b4DragOver(K,I);N.onDragOver(K,I)}if(G.length){N.b4DragDrop(K,G);N.onDragDrop(K,G)}}else{var J=0;for(F=0,J=E.length;F<J;++F){N.b4DragOut(K,E[F].id);N.onDragOut(K,E[F].id)}for(F=0,J=D.length;F<J;++F){N.onDragEnter(K,D[F].id)}for(F=0,J=I.length;F<J;++F){N.b4DragOver(K,I[F].id);N.onDragOver(K,I[F].id)}for(F=0,J=G.length;F<J;++F){N.b4DragDrop(K,G[F].id);N.onDragDrop(K,G[F].id)}}if(L&&!G.length){N.onInvalidDrop(K)}},getBestMatch:function(D){var F=null;var C=D.length;if(C==1){F=D[0]}else{for(var E=0;E<C;++E){var B=D[E];if(B.cursorIsOver){F=B;break}else{if(!F||F.overlap.getArea()<B.overlap.getArea()){F=B}}}}return F},refreshCache:function(C){for(var B in C){if("string"!=typeof B){continue}for(var D in this.ids[B]){var E=this.ids[B][D];if(this.isTypeOfDD(E)){var F=this.getLocation(E);if(F){this.locationCache[E.id]=F}else{delete this.locationCache[E.id]}}}}},verifyEl:function(C){if(C){var B;if(Ext.isIE){try{B=C.offsetParent}catch(D){}}else{B=C.offsetParent}if(B){return true}}return false},getLocation:function(G){if(!this.isTypeOfDD(G)){return null}var E=G.getEl(),J,D,C,L,K,M,B,I,F;try{J=Ext.lib.Dom.getXY(E)}catch(H){}if(!J){return null}D=J[0];C=D+E.offsetWidth;L=J[1];K=L+E.offsetHeight;M=L-G.padding[0];B=C+G.padding[1];I=K+G.padding[2];F=D-G.padding[3];return new Ext.lib.Region(M,B,I,F)},isOverTarget:function(J,B,D){var F=this.locationCache[B.id];if(!F||!this.useCache){F=this.getLocation(B);this.locationCache[B.id]=F}if(!F){return false}B.cursorIsOver=F.contains(J);var I=this.dragCurrent;if(!I||!I.getTargetCoord||(!D&&!I.constrainX&&!I.constrainY)){return B.cursorIsOver}B.overlap=null;var G=I.getTargetCoord(J.x,J.y);var C=I.getDragEl();var E=new Ext.lib.Region(G.y,G.x+C.offsetWidth,G.y+C.offsetHeight,G.x);var H=E.intersect(F);if(H){B.overlap=H;return(D)?true:B.cursorIsOver}else{return false}},_onUnload:function(C,B){Ext.dd.DragDropMgr.unregAll()},unregAll:function(){if(this.dragCurrent){this.stopDrag();this.dragCurrent=null}this._execOnAll("unreg",[]);for(var B in this.elementCache){delete this.elementCache[B]}this.elementCache={};this.ids={}},elementCache:{},getElWrapper:function(C){var B=this.elementCache[C];if(!B||!B.el){B=this.elementCache[C]=new this.ElementWrapper(Ext.getDom(C))}return B},getElement:function(B){return Ext.getDom(B)},getCss:function(C){var B=Ext.getDom(C);return(B)?B.style:null},ElementWrapper:function(B){this.el=B||null;this.id=this.el&&B.id;this.css=this.el&&B.style},getPosX:function(B){return Ext.lib.Dom.getX(B)},getPosY:function(B){return Ext.lib.Dom.getY(B)},swapNode:function(D,B){if(D.swapNode){D.swapNode(B)}else{var E=B.parentNode;var C=B.nextSibling;if(C==D){E.insertBefore(D,B)}else{if(B==D.nextSibling){E.insertBefore(B,D)}else{D.parentNode.replaceChild(B,D);E.insertBefore(D,C)}}}},getScroll:function(){var D,B,E=document.documentElement,C=document.body;if(E&&(E.scrollTop||E.scrollLeft)){D=E.scrollTop;B=E.scrollLeft}else{if(C){D=C.scrollTop;B=C.scrollLeft}else{}}return{top:D,left:B}},getStyle:function(C,B){return Ext.fly(C).getStyle(B)},getScrollTop:function(){return this.getScroll().top},getScrollLeft:function(){return this.getScroll().left},moveToEl:function(B,D){var C=Ext.lib.Dom.getXY(D);Ext.lib.Dom.setXY(B,C)},numericSort:function(C,B){return(C-B)},_timeoutCount:0,_addListeners:function(){var B=Ext.dd.DDM;if(Ext.lib.Event&&document){B._onLoad()}else{if(B._timeoutCount>2000){}else{setTimeout(B._addListeners,10);if(document&&document.body){B._timeoutCount+=1}}}},handleWasClicked:function(B,D){if(this.isHandle(D,B.id)){return true}else{var C=B.parentNode;while(C){if(this.isHandle(D,C.id)){return true}else{C=C.parentNode}}}return false}}}();Ext.dd.DDM=Ext.dd.DragDropMgr;Ext.dd.DDM._addListeners()}Ext.dd.DD=function(C,A,B){if(C){this.init(C,A,B)}};Ext.extend(Ext.dd.DD,Ext.dd.DragDrop,{scroll:true,autoOffset:function(C,B){var A=C-this.startPageX;var D=B-this.startPageY;this.setDelta(A,D)},setDelta:function(B,A){this.deltaX=B;this.deltaY=A},setDragElPos:function(C,B){var A=this.getDragEl();this.alignElWithMouse(A,C,B)},alignElWithMouse:function(C,G,F){var E=this.getTargetCoord(G,F);var B=C.dom?C:Ext.fly(C,"_dd");if(!this.deltaSetXY){var H=[E.x,E.y];B.setXY(H);var D=B.getLeft(true);var A=B.getTop(true);this.deltaSetXY=[D-E.x,A-E.y]}else{B.setLeftTop(E.x+this.deltaSetXY[0],E.y+this.deltaSetXY[1])}this.cachePosition(E.x,E.y);this.autoScroll(E.x,E.y,C.offsetHeight,C.offsetWidth);return E},cachePosition:function(B,A){if(B){this.lastPageX=B;this.lastPageY=A}else{var C=Ext.lib.Dom.getXY(this.getEl());this.lastPageX=C[0];this.lastPageY=C[1]}},autoScroll:function(J,I,E,K){if(this.scroll){var L=Ext.lib.Dom.getViewHeight();var B=Ext.lib.Dom.getViewWidth();var N=this.DDM.getScrollTop();var D=this.DDM.getScrollLeft();var H=E+I;var M=K+J;var G=(L+N-I-this.deltaY);var F=(B+D-J-this.deltaX);var C=40;var A=(document.all)?80:30;if(H>L&&G<C){window.scrollTo(D,N+A)}if(I<N&&N>0&&I-N<C){window.scrollTo(D,N-A)}if(M>B&&F<C){window.scrollTo(D+A,N)}if(J<D&&D>0&&J-D<C){window.scrollTo(D-A,N)}}},getTargetCoord:function(C,B){var A=C-this.deltaX;var D=B-this.deltaY;if(this.constrainX){if(A<this.minX){A=this.minX}if(A>this.maxX){A=this.maxX}}if(this.constrainY){if(D<this.minY){D=this.minY}if(D>this.maxY){D=this.maxY}}A=this.getTick(A,this.xTicks);D=this.getTick(D,this.yTicks);return{x:A,y:D}},applyConfig:function(){Ext.dd.DD.superclass.applyConfig.call(this);this.scroll=(this.config.scroll!==false)},b4MouseDown:function(A){this.autoOffset(A.getPageX(),A.getPageY())},b4Drag:function(A){this.setDragElPos(A.getPageX(),A.getPageY())},toString:function(){return("DD "+this.id)}});Ext.dd.DDProxy=function(C,A,B){if(C){this.init(C,A,B);this.initFrame()}};Ext.dd.DDProxy.dragElId="ygddfdiv";Ext.extend(Ext.dd.DDProxy,Ext.dd.DD,{resizeFrame:true,centerFrame:false,createFrame:function(){var B=this;var A=document.body;if(!A||!A.firstChild){setTimeout(function(){B.createFrame()},50);return }var D=this.getDragEl();if(!D){D=document.createElement("div");D.id=this.dragElId;var C=D.style;C.position="absolute";C.visibility="hidden";C.cursor="move";C.border="2px solid #aaa";C.zIndex=999;A.insertBefore(D,A.firstChild)}},initFrame:function(){this.createFrame()},applyConfig:function(){Ext.dd.DDProxy.superclass.applyConfig.call(this);this.resizeFrame=(this.config.resizeFrame!==false);this.centerFrame=(this.config.centerFrame);this.setDragElId(this.config.dragElId||Ext.dd.DDProxy.dragElId)},showFrame:function(E,D){var C=this.getEl();var A=this.getDragEl();var B=A.style;this._resizeProxy();if(this.centerFrame){this.setDelta(Math.round(parseInt(B.width,10)/2),Math.round(parseInt(B.height,10)/2))}this.setDragElPos(E,D);Ext.fly(A).show()},_resizeProxy:function(){if(this.resizeFrame){var A=this.getEl();Ext.fly(this.getDragEl()).setSize(A.offsetWidth,A.offsetHeight)}},b4MouseDown:function(B){var A=B.getPageX();var C=B.getPageY();this.autoOffset(A,C);this.setDragElPos(A,C)},b4StartDrag:function(A,B){this.showFrame(A,B)},b4EndDrag:function(A){Ext.fly(this.getDragEl()).hide()},endDrag:function(C){var B=this.getEl();var A=this.getDragEl();A.style.visibility="";this.beforeMove();B.style.visibility="hidden";Ext.dd.DDM.moveToEl(B,A);A.style.visibility="hidden";B.style.visibility="";this.afterDrag()},beforeMove:function(){},afterDrag:function(){},toString:function(){return("DDProxy "+this.id)}});Ext.dd.DDTarget=function(C,A,B){if(C){this.initTarget(C,A,B)}};Ext.extend(Ext.dd.DDTarget,Ext.dd.DragDrop,{toString:function(){return("DDTarget "+this.id)}});
Ext.dd.DragTracker=function(A){Ext.apply(this,A);this.addEvents("mousedown","mouseup","mousemove","dragstart","dragend","drag");this.dragRegion=new Ext.lib.Region(0,0,0,0);if(this.el){this.initEl(this.el)}};Ext.extend(Ext.dd.DragTracker,Ext.util.Observable,{active:false,tolerance:5,autoStart:false,initEl:function(A){this.el=Ext.get(A);A.on("mousedown",this.onMouseDown,this,this.delegate?{delegate:this.delegate}:undefined)},destroy:function(){this.el.un("mousedown",this.onMouseDown,this)},onMouseDown:function(C,B){if(this.fireEvent("mousedown",this,C)!==false&&this.onBeforeStart(C)!==false){this.startXY=this.lastXY=C.getXY();this.dragTarget=this.delegate?B:this.el.dom;C.preventDefault();var A=Ext.getDoc();A.on("mouseup",this.onMouseUp,this);A.on("mousemove",this.onMouseMove,this);A.on("selectstart",this.stopSelect,this);if(this.autoStart){this.timer=this.triggerStart.defer(this.autoStart===true?1000:this.autoStart,this)}}},onMouseMove:function(D,C){D.preventDefault();var B=D.getXY(),A=this.startXY;this.lastXY=B;if(!this.active){if(Math.abs(A[0]-B[0])>this.tolerance||Math.abs(A[1]-B[1])>this.tolerance){this.triggerStart()}else{return }}this.fireEvent("mousemove",this,D);this.onDrag(D);this.fireEvent("drag",this,D)},onMouseUp:function(B){var A=Ext.getDoc();A.un("mousemove",this.onMouseMove,this);A.un("mouseup",this.onMouseUp,this);A.un("selectstart",this.stopSelect,this);B.preventDefault();this.clearStart();this.active=false;delete this.elRegion;this.fireEvent("mouseup",this,B);this.onEnd(B);this.fireEvent("dragend",this,B)},triggerStart:function(A){this.clearStart();this.active=true;this.onStart(this.startXY);this.fireEvent("dragstart",this,this.startXY)},clearStart:function(){if(this.timer){clearTimeout(this.timer);delete this.timer}},stopSelect:function(A){A.stopEvent();return false},onBeforeStart:function(A){},onStart:function(A){},onDrag:function(A){},onEnd:function(A){},getDragTarget:function(){return this.dragTarget},getDragCt:function(){return this.el},getXY:function(A){return A?this.constrainModes[A].call(this,this.lastXY):this.lastXY},getOffset:function(C){var B=this.getXY(C);var A=this.startXY;return[A[0]-B[0],A[1]-B[1]]},constrainModes:{"point":function(B){if(!this.elRegion){this.elRegion=this.getDragCt().getRegion()}var A=this.dragRegion;A.left=B[0];A.top=B[1];A.right=B[0];A.bottom=B[1];A.constrainTo(this.elRegion);return[A.left,A.top]}}});
Ext.dd.ScrollManager=function(){var C=Ext.dd.DragDropMgr;var E={};var B=null;var H={};var G=function(K){B=null;A()};var I=function(){if(C.dragCurrent){C.refreshCache(C.dragCurrent.groups)}};var D=function(){if(C.dragCurrent){var K=Ext.dd.ScrollManager;var L=H.el.ddScrollConfig?H.el.ddScrollConfig.increment:K.increment;if(!K.animate){if(H.el.scroll(H.dir,L)){I()}}else{H.el.scroll(H.dir,L,true,K.animDuration,I)}}};var A=function(){if(H.id){clearInterval(H.id)}H.id=0;H.el=null;H.dir=""};var F=function(L,K){A();H.el=L;H.dir=K;var M=(L.ddScrollConfig&&L.ddScrollConfig.frequency)?L.ddScrollConfig.frequency:Ext.dd.ScrollManager.frequency;H.id=setInterval(D,M)};var J=function(N,P){if(P||!C.dragCurrent){return }var Q=Ext.dd.ScrollManager;if(!B||B!=C.dragCurrent){B=C.dragCurrent;Q.refreshCache()}var R=Ext.lib.Event.getXY(N);var S=new Ext.lib.Point(R[0],R[1]);for(var L in E){var M=E[L],K=M._region;var O=M.ddScrollConfig?M.ddScrollConfig:Q;if(K&&K.contains(S)&&M.isScrollable()){if(K.bottom-S.y<=O.vthresh){if(H.el!=M){F(M,"down")}return }else{if(K.right-S.x<=O.hthresh){if(H.el!=M){F(M,"left")}return }else{if(S.y-K.top<=O.vthresh){if(H.el!=M){F(M,"up")}return }else{if(S.x-K.left<=O.hthresh){if(H.el!=M){F(M,"right")}return }}}}}}A()};C.fireEvents=C.fireEvents.createSequence(J,C);C.stopDrag=C.stopDrag.createSequence(G,C);return{register:function(M){if(Ext.isArray(M)){for(var L=0,K=M.length;L<K;L++){this.register(M[L])}}else{M=Ext.get(M);E[M.id]=M}},unregister:function(M){if(Ext.isArray(M)){for(var L=0,K=M.length;L<K;L++){this.unregister(M[L])}}else{M=Ext.get(M);delete E[M.id]}},vthresh:25,hthresh:25,increment:100,frequency:500,animate:true,animDuration:0.4,refreshCache:function(){for(var K in E){if(typeof E[K]=="object"){E[K]._region=E[K].getRegion()}}}}}();
Ext.dd.Registry=function(){var D={};var B={};var A=0;var C=function(F,E){if(typeof F=="string"){return F}var G=F.id;if(!G&&E!==false){G="extdd-"+(++A);F.id=G}return G};return{register:function(H,I){I=I||{};if(typeof H=="string"){H=document.getElementById(H)}I.ddel=H;D[C(H)]=I;if(I.isHandle!==false){B[I.ddel.id]=I}if(I.handles){var G=I.handles;for(var F=0,E=G.length;F<E;F++){B[C(G[F])]=I}}},unregister:function(H){var J=C(H,false);var I=D[J];if(I){delete D[J];if(I.handles){var G=I.handles;for(var F=0,E=G.length;F<E;F++){delete B[C(G[F],false)]}}}},getHandle:function(E){if(typeof E!="string"){E=E.id}return B[E]},getHandleFromEvent:function(F){var E=Ext.lib.Event.getTarget(F);return E?B[E.id]:null},getTarget:function(E){if(typeof E!="string"){E=E.id}return D[E]},getTargetFromEvent:function(F){var E=Ext.lib.Event.getTarget(F);return E?D[E.id]||B[E.id]:null}}}();
Ext.dd.StatusProxy=function(A){Ext.apply(this,A);this.id=this.id||Ext.id();this.el=new Ext.Layer({dh:{id:this.id,tag:"div",cls:"x-dd-drag-proxy "+this.dropNotAllowed,children:[{tag:"div",cls:"x-dd-drop-icon"},{tag:"div",cls:"x-dd-drag-ghost"}]},shadow:!A||A.shadow!==false});this.ghost=Ext.get(this.el.dom.childNodes[1]);this.dropStatus=this.dropNotAllowed};Ext.dd.StatusProxy.prototype={dropAllowed:"x-dd-drop-ok",dropNotAllowed:"x-dd-drop-nodrop",setStatus:function(A){A=A||this.dropNotAllowed;if(this.dropStatus!=A){this.el.replaceClass(this.dropStatus,A);this.dropStatus=A}},reset:function(A){this.el.dom.className="x-dd-drag-proxy "+this.dropNotAllowed;this.dropStatus=this.dropNotAllowed;if(A){this.ghost.update("")}},update:function(A){if(typeof A=="string"){this.ghost.update(A)}else{this.ghost.update("");A.style.margin="0";this.ghost.dom.appendChild(A)}var B=this.ghost.dom.firstChild;if(B){Ext.fly(B).setStyle(Ext.isIE?"styleFloat":"cssFloat","none")}},getEl:function(){return this.el},getGhost:function(){return this.ghost},hide:function(A){this.el.hide();if(A){this.reset(true)}},stop:function(){if(this.anim&&this.anim.isAnimated&&this.anim.isAnimated()){this.anim.stop()}},show:function(){this.el.show()},sync:function(){this.el.sync()},repair:function(B,C,A){this.callback=C;this.scope=A;if(B&&this.animRepair!==false){this.el.addClass("x-dd-drag-repair");this.el.hideUnders(true);this.anim=this.el.shift({duration:this.repairDuration||0.5,easing:"easeOut",xy:B,stopFx:true,callback:this.afterRepair,scope:this})}else{this.afterRepair()}},afterRepair:function(){this.hide(true);if(typeof this.callback=="function"){this.callback.call(this.scope||this)}this.callback=null;this.scope=null}};
Ext.dd.DragSource=function(B,A){this.el=Ext.get(B);if(!this.dragData){this.dragData={}}Ext.apply(this,A);if(!this.proxy){this.proxy=new Ext.dd.StatusProxy()}Ext.dd.DragSource.superclass.constructor.call(this,this.el.dom,this.ddGroup||this.group,{dragElId:this.proxy.id,resizeFrame:false,isTarget:false,scroll:this.scroll===true});this.dragging=false};Ext.extend(Ext.dd.DragSource,Ext.dd.DDProxy,{dropAllowed:"x-dd-drop-ok",dropNotAllowed:"x-dd-drop-nodrop",getDragData:function(A){return this.dragData},onDragEnter:function(C,D){var B=Ext.dd.DragDropMgr.getDDById(D);this.cachedTarget=B;if(this.beforeDragEnter(B,C,D)!==false){if(B.isNotifyTarget){var A=B.notifyEnter(this,C,this.dragData);this.proxy.setStatus(A)}else{this.proxy.setStatus(this.dropAllowed)}if(this.afterDragEnter){this.afterDragEnter(B,C,D)}}},beforeDragEnter:function(B,A,C){return true},alignElWithMouse:function(){Ext.dd.DragSource.superclass.alignElWithMouse.apply(this,arguments);this.proxy.sync()},onDragOver:function(C,D){var B=this.cachedTarget||Ext.dd.DragDropMgr.getDDById(D);if(this.beforeDragOver(B,C,D)!==false){if(B.isNotifyTarget){var A=B.notifyOver(this,C,this.dragData);this.proxy.setStatus(A)}if(this.afterDragOver){this.afterDragOver(B,C,D)}}},beforeDragOver:function(B,A,C){return true},onDragOut:function(B,C){var A=this.cachedTarget||Ext.dd.DragDropMgr.getDDById(C);if(this.beforeDragOut(A,B,C)!==false){if(A.isNotifyTarget){A.notifyOut(this,B,this.dragData)}this.proxy.reset();if(this.afterDragOut){this.afterDragOut(A,B,C)}}this.cachedTarget=null},beforeDragOut:function(B,A,C){return true},onDragDrop:function(B,C){var A=this.cachedTarget||Ext.dd.DragDropMgr.getDDById(C);if(this.beforeDragDrop(A,B,C)!==false){if(A.isNotifyTarget){if(A.notifyDrop(this,B,this.dragData)){this.onValidDrop(A,B,C)}else{this.onInvalidDrop(A,B,C)}}else{this.onValidDrop(A,B,C)}if(this.afterDragDrop){this.afterDragDrop(A,B,C)}}delete this.cachedTarget},beforeDragDrop:function(B,A,C){return true},onValidDrop:function(B,A,C){this.hideProxy();if(this.afterValidDrop){this.afterValidDrop(B,A,C)}},getRepairXY:function(B,A){return this.el.getXY()},onInvalidDrop:function(B,A,C){this.beforeInvalidDrop(B,A,C);if(this.cachedTarget){if(this.cachedTarget.isNotifyTarget){this.cachedTarget.notifyOut(this,A,this.dragData)}this.cacheTarget=null}this.proxy.repair(this.getRepairXY(A,this.dragData),this.afterRepair,this);if(this.afterInvalidDrop){this.afterInvalidDrop(A,C)}},afterRepair:function(){if(Ext.enableFx){this.el.highlight(this.hlColor||"c3daf9")}this.dragging=false},beforeInvalidDrop:function(B,A,C){return true},handleMouseDown:function(B){if(this.dragging){return }var A=this.getDragData(B);if(A&&this.onBeforeDrag(A,B)!==false){this.dragData=A;this.proxy.stop();Ext.dd.DragSource.superclass.handleMouseDown.apply(this,arguments)}},onBeforeDrag:function(A,B){return true},onStartDrag:Ext.emptyFn,startDrag:function(A,B){this.proxy.reset();this.dragging=true;this.proxy.update("");this.onInitDrag(A,B);this.proxy.show()},onInitDrag:function(A,C){var B=this.el.dom.cloneNode(true);B.id=Ext.id();this.proxy.update(B);this.onStartDrag(A,C);return true},getProxy:function(){return this.proxy},hideProxy:function(){this.proxy.hide();this.proxy.reset(true);this.dragging=false},triggerCacheRefresh:function(){Ext.dd.DDM.refreshCache(this.groups)},b4EndDrag:function(A){},endDrag:function(A){this.onEndDrag(this.dragData,A)},onEndDrag:function(A,B){},autoOffset:function(A,B){this.setDelta(-12,-20)}});
Ext.dd.DropTarget=function(B,A){this.el=Ext.get(B);Ext.apply(this,A);if(this.containerScroll){Ext.dd.ScrollManager.register(this.el)}Ext.dd.DropTarget.superclass.constructor.call(this,this.el.dom,this.ddGroup||this.group,{isTarget:true})};Ext.extend(Ext.dd.DropTarget,Ext.dd.DDTarget,{dropAllowed:"x-dd-drop-ok",dropNotAllowed:"x-dd-drop-nodrop",isTarget:true,isNotifyTarget:true,notifyEnter:function(A,C,B){if(this.overClass){this.el.addClass(this.overClass)}return this.dropAllowed},notifyOver:function(A,C,B){return this.dropAllowed},notifyOut:function(A,C,B){if(this.overClass){this.el.removeClass(this.overClass)}},notifyDrop:function(A,C,B){return false}});
Ext.dd.DragZone=function(B,A){Ext.dd.DragZone.superclass.constructor.call(this,B,A);if(this.containerScroll){Ext.dd.ScrollManager.register(this.el)}};Ext.extend(Ext.dd.DragZone,Ext.dd.DragSource,{getDragData:function(A){return Ext.dd.Registry.getHandleFromEvent(A)},onInitDrag:function(A,B){this.proxy.update(this.dragData.ddel.cloneNode(true));this.onStartDrag(A,B);return true},afterRepair:function(){if(Ext.enableFx){Ext.Element.fly(this.dragData.ddel).highlight(this.hlColor||"c3daf9")}this.dragging=false},getRepairXY:function(A){return Ext.Element.fly(this.dragData.ddel).getXY()}});
Ext.dd.DropZone=function(B,A){Ext.dd.DropZone.superclass.constructor.call(this,B,A)};Ext.extend(Ext.dd.DropZone,Ext.dd.DropTarget,{getTargetFromEvent:function(A){return Ext.dd.Registry.getTargetFromEvent(A)},onNodeEnter:function(D,A,C,B){},onNodeOver:function(D,A,C,B){return this.dropAllowed},onNodeOut:function(D,A,C,B){},onNodeDrop:function(D,A,C,B){return false},onContainerOver:function(A,C,B){return this.dropNotAllowed},onContainerDrop:function(A,C,B){return false},notifyEnter:function(A,C,B){return this.dropNotAllowed},notifyOver:function(A,C,B){var D=this.getTargetFromEvent(C);if(!D){if(this.lastOverNode){this.onNodeOut(this.lastOverNode,A,C,B);this.lastOverNode=null}return this.onContainerOver(A,C,B)}if(this.lastOverNode!=D){if(this.lastOverNode){this.onNodeOut(this.lastOverNode,A,C,B)}this.onNodeEnter(D,A,C,B);this.lastOverNode=D}return this.onNodeOver(D,A,C,B)},notifyOut:function(A,C,B){if(this.lastOverNode){this.onNodeOut(this.lastOverNode,A,C,B);this.lastOverNode=null}},notifyDrop:function(A,C,B){if(this.lastOverNode){this.onNodeOut(this.lastOverNode,A,C,B);this.lastOverNode=null}var D=this.getTargetFromEvent(C);return D?this.onNodeDrop(D,A,C,B):this.onContainerDrop(A,C,B)},triggerCacheRefresh:function(){Ext.dd.DDM.refreshCache(this.groups)}});
Ext.data.SortTypes={none:function(A){return A},stripTagsRE:/<\/?[^>]+>/gi,asText:function(A){return String(A).replace(this.stripTagsRE,"")},asUCText:function(A){return String(A).toUpperCase().replace(this.stripTagsRE,"")},asUCString:function(A){return String(A).toUpperCase()},asDate:function(A){if(!A){return 0}if(Ext.isDate(A)){return A.getTime()}return Date.parse(String(A))},asFloat:function(A){var B=parseFloat(String(A).replace(/,/g,""));if(isNaN(B)){B=0}return B},asInt:function(A){var B=parseInt(String(A).replace(/,/g,""));if(isNaN(B)){B=0}return B}};
Ext.data.Record=function(A,B){this.id=(B||B===0)?B:++Ext.data.Record.AUTO_ID;this.data=A};Ext.data.Record.create=function(E){var C=Ext.extend(Ext.data.Record,{});var D=C.prototype;D.fields=new Ext.util.MixedCollection(false,function(F){return F.name});for(var B=0,A=E.length;B<A;B++){D.fields.add(new Ext.data.Field(E[B]))}C.getField=function(F){return D.fields.get(F)};return C};Ext.data.Record.AUTO_ID=1000;Ext.data.Record.EDIT="edit";Ext.data.Record.REJECT="reject";Ext.data.Record.COMMIT="commit";Ext.data.Record.prototype={dirty:false,editing:false,error:null,modified:null,join:function(A){this.store=A},set:function(A,B){if(String(this.data[A])==String(B)){return }this.dirty=true;if(!this.modified){this.modified={}}if(typeof this.modified[A]=="undefined"){this.modified[A]=this.data[A]}this.data[A]=B;if(!this.editing&&this.store){this.store.afterEdit(this)}},get:function(A){return this.data[A]},beginEdit:function(){this.editing=true;this.modified={}},cancelEdit:function(){this.editing=false;delete this.modified},endEdit:function(){this.editing=false;if(this.dirty&&this.store){this.store.afterEdit(this)}},reject:function(B){var A=this.modified;for(var C in A){if(typeof A[C]!="function"){this.data[C]=A[C]}}this.dirty=false;delete this.modified;this.editing=false;if(this.store&&B!==true){this.store.afterReject(this)}},commit:function(A){this.dirty=false;delete this.modified;this.editing=false;if(this.store&&A!==true){this.store.afterCommit(this)}},getChanges:function(){var A=this.modified,B={};for(var C in A){if(A.hasOwnProperty(C)){B[C]=this.data[C]}}return B},hasError:function(){return this.error!=null},clearError:function(){this.error=null},copy:function(A){return new this.constructor(Ext.apply({},this.data),A||this.id)},isModified:function(A){return !!(this.modified&&this.modified.hasOwnProperty(A))}};
Ext.StoreMgr=Ext.apply(new Ext.util.MixedCollection(),{register:function(){for(var A=0,B;B=arguments[A];A++){this.add(B)}},unregister:function(){for(var A=0,B;B=arguments[A];A++){this.remove(this.lookup(B))}},lookup:function(A){return typeof A=="object"?A:this.get(A)},getKey:function(A){return A.storeId||A.id}});
Ext.data.Store=function(A){this.data=new Ext.util.MixedCollection(false);this.data.getKey=function(B){return B.id};this.baseParams={};this.paramNames={"start":"start","limit":"limit","sort":"sort","dir":"dir"};if(A&&A.data){this.inlineData=A.data;delete A.data}Ext.apply(this,A);if(this.url&&!this.proxy){this.proxy=new Ext.data.HttpProxy({url:this.url})}if(this.reader){if(!this.recordType){this.recordType=this.reader.recordType}if(this.reader.onMetaChange){this.reader.onMetaChange=this.onMetaChange.createDelegate(this)}}if(this.recordType){this.fields=this.recordType.prototype.fields}this.modified=[];this.addEvents("datachanged","metachange","add","remove","update","clear","beforeload","load","loadexception");if(this.proxy){this.relayEvents(this.proxy,["loadexception"])}this.sortToggle={};if(this.sortInfo){this.setDefaultSort(this.sortInfo.field,this.sortInfo.direction)}Ext.data.Store.superclass.constructor.call(this);if(this.storeId||this.id){Ext.StoreMgr.register(this)}if(this.inlineData){this.loadData(this.inlineData);delete this.inlineData}else{if(this.autoLoad){this.load.defer(10,this,[typeof this.autoLoad=="object"?this.autoLoad:undefined])}}};Ext.extend(Ext.data.Store,Ext.util.Observable,{remoteSort:false,pruneModifiedRecords:false,lastOptions:null,destroy:function(){if(this.id){Ext.StoreMgr.unregister(this)}this.data=null;this.purgeListeners()},add:function(B){B=[].concat(B);if(B.length<1){return }for(var D=0,A=B.length;D<A;D++){B[D].join(this)}var C=this.data.length;this.data.addAll(B);if(this.snapshot){this.snapshot.addAll(B)}this.fireEvent("add",this,B,C)},addSorted:function(A){var B=this.findInsertIndex(A);this.insert(B,A)},remove:function(A){var B=this.data.indexOf(A);this.data.removeAt(B);if(this.pruneModifiedRecords){this.modified.remove(A)}if(this.snapshot){this.snapshot.remove(A)}this.fireEvent("remove",this,A,B)},removeAll:function(){this.data.clear();if(this.snapshot){this.snapshot.clear()}if(this.pruneModifiedRecords){this.modified=[]}this.fireEvent("clear",this)},insert:function(C,B){B=[].concat(B);for(var D=0,A=B.length;D<A;D++){this.data.insert(C,B[D]);B[D].join(this)}this.fireEvent("add",this,B,C)},indexOf:function(A){return this.data.indexOf(A)},indexOfId:function(A){return this.data.indexOfKey(A)},getById:function(A){return this.data.key(A)},getAt:function(A){return this.data.itemAt(A)},getRange:function(B,A){return this.data.getRange(B,A)},storeOptions:function(A){A=Ext.apply({},A);delete A.callback;delete A.scope;this.lastOptions=A},load:function(B){B=B||{};if(this.fireEvent("beforeload",this,B)!==false){this.storeOptions(B);var C=Ext.apply(B.params||{},this.baseParams);if(this.sortInfo&&this.remoteSort){var A=this.paramNames;C[A["sort"]]=this.sortInfo.field;C[A["dir"]]=this.sortInfo.direction}this.proxy.load(C,this.reader,this.loadRecords,this,B);return true}else{return false}},reload:function(A){this.load(Ext.applyIf(A||{},this.lastOptions))},loadRecords:function(G,B,F){if(!G||F===false){if(F!==false){this.fireEvent("load",this,[],B)}if(B.callback){B.callback.call(B.scope||this,[],B,false)}return }var E=G.records,D=G.totalRecords||E.length;if(!B||B.add!==true){if(this.pruneModifiedRecords){this.modified=[]}for(var C=0,A=E.length;C<A;C++){E[C].join(this)}if(this.snapshot){this.data=this.snapshot;delete this.snapshot}this.data.clear();this.data.addAll(E);this.totalLength=D;this.applySort();this.fireEvent("datachanged",this)}else{this.totalLength=Math.max(D,this.data.length+E.length);this.add(E)}this.fireEvent("load",this,E,B);if(B.callback){B.callback.call(B.scope||this,E,B,true)}},loadData:function(C,A){var B=this.reader.readRecords(C);this.loadRecords(B,{add:A},true)},getCount:function(){return this.data.length||0},getTotalCount:function(){return this.totalLength||0},getSortState:function(){return this.sortInfo},applySort:function(){if(this.sortInfo&&!this.remoteSort){var A=this.sortInfo,B=A.field;this.sortData(B,A.direction)}},sortData:function(C,D){D=D||"ASC";var A=this.fields.get(C).sortType;var B=function(F,E){var H=A(F.data[C]),G=A(E.data[C]);return H>G?1:(H<G?-1:0)};this.data.sort(D,B);if(this.snapshot&&this.snapshot!=this.data){this.snapshot.sort(D,B)}},setDefaultSort:function(B,A){A=A?A.toUpperCase():"ASC";this.sortInfo={field:B,direction:A};this.sortToggle[B]=A},sort:function(E,C){var D=this.fields.get(E);if(!D){return false}if(!C){if(this.sortInfo&&this.sortInfo.field==D.name){C=(this.sortToggle[D.name]||"ASC").toggle("ASC","DESC")}else{C=D.sortDir}}var B=(this.sortToggle)?this.sortToggle[D.name]:null;var A=(this.sortInfo)?this.sortInfo:null;this.sortToggle[D.name]=C;this.sortInfo={field:D.name,direction:C};if(!this.remoteSort){this.applySort();this.fireEvent("datachanged",this)}else{if(!this.load(this.lastOptions)){if(B){this.sortToggle[D.name]=B}if(A){this.sortInfo=A}}}},each:function(B,A){this.data.each(B,A)},getModifiedRecords:function(){return this.modified},createFilterFn:function(C,B,D,A){if(Ext.isEmpty(B,false)){return false}B=this.data.createValueMatcher(B,D,A);return function(E){return B.test(E.data[C])}},sum:function(E,F,A){var C=this.data.items,B=0;F=F||0;A=(A||A===0)?A:C.length-1;for(var D=F;D<=A;D++){B+=(C[D].data[E]||0)}return B},filter:function(D,C,E,A){var B=this.createFilterFn(D,C,E,A);return B?this.filterBy(B):this.clearFilter()},filterBy:function(B,A){this.snapshot=this.snapshot||this.data;this.data=this.queryBy(B,A||this);this.fireEvent("datachanged",this)},query:function(D,C,E,A){var B=this.createFilterFn(D,C,E,A);return B?this.queryBy(B):this.data.clone()},queryBy:function(B,A){var C=this.snapshot||this.data;return C.filterBy(B,A||this)},find:function(D,C,F,E,A){var B=this.createFilterFn(D,C,E,A);return B?this.data.findIndexBy(B,null,F):-1},findBy:function(B,A,C){return this.data.findIndexBy(B,A,C)},collect:function(G,H,B){var F=(B===true&&this.snapshot)?this.snapshot.items:this.data.items;var I,J,A=[],C={};for(var D=0,E=F.length;D<E;D++){I=F[D].data[G];J=String(I);if((H||!Ext.isEmpty(I))&&!C[J]){C[J]=true;A[A.length]=I}}return A},clearFilter:function(A){if(this.isFiltered()){this.data=this.snapshot;delete this.snapshot;if(A!==true){this.fireEvent("datachanged",this)}}},isFiltered:function(){return this.snapshot&&this.snapshot!=this.data},afterEdit:function(A){if(this.modified.indexOf(A)==-1){this.modified.push(A)}this.fireEvent("update",this,A,Ext.data.Record.EDIT)},afterReject:function(A){this.modified.remove(A);this.fireEvent("update",this,A,Ext.data.Record.REJECT)},afterCommit:function(A){this.modified.remove(A);this.fireEvent("update",this,A,Ext.data.Record.COMMIT)},commitChanges:function(){var B=this.modified.slice(0);this.modified=[];for(var C=0,A=B.length;C<A;C++){B[C].commit()}},rejectChanges:function(){var B=this.modified.slice(0);this.modified=[];for(var C=0,A=B.length;C<A;C++){B[C].reject()}},onMetaChange:function(B,A,C){this.recordType=A;this.fields=A.prototype.fields;delete this.snapshot;this.sortInfo=B.sortInfo;this.modified=[];this.fireEvent("metachange",this,this.reader.meta)},findInsertIndex:function(A){this.suspendEvents();var C=this.data.clone();this.data.add(A);this.applySort();var B=this.data.indexOf(A);this.data=C;this.resumeEvents();return B}});
Ext.data.SimpleStore=function(A){Ext.data.SimpleStore.superclass.constructor.call(this,Ext.apply(A,{reader:new Ext.data.ArrayReader({id:A.id},Ext.data.Record.create(A.fields))}))};Ext.extend(Ext.data.SimpleStore,Ext.data.Store,{loadData:function(E,B){if(this.expandData===true){var D=[];for(var C=0,A=E.length;C<A;C++){D[D.length]=[E[C]]}E=D}Ext.data.SimpleStore.superclass.loadData.call(this,E,B)}});
Ext.data.JsonStore=function(A){Ext.data.JsonStore.superclass.constructor.call(this,Ext.apply(A,{proxy:A.proxy||(!A.data?new Ext.data.HttpProxy({url:A.url}):undefined),reader:new Ext.data.JsonReader(A,A.fields)}))};Ext.extend(Ext.data.JsonStore,Ext.data.Store);
Ext.data.Field=function(D){if(typeof D=="string"){D={name:D}}Ext.apply(this,D);if(!this.type){this.type="auto"}var C=Ext.data.SortTypes;if(typeof this.sortType=="string"){this.sortType=C[this.sortType]}if(!this.sortType){switch(this.type){case"string":this.sortType=C.asUCString;break;case"date":this.sortType=C.asDate;break;default:this.sortType=C.none}}var E=/[\$,%]/g;if(!this.convert){var B,A=this.dateFormat;switch(this.type){case"":case"auto":case undefined:B=function(F){return F};break;case"string":B=function(F){return(F===undefined||F===null)?"":String(F)};break;case"int":B=function(F){return F!==undefined&&F!==null&&F!==""?parseInt(String(F).replace(E,""),10):""};break;case"float":B=function(F){return F!==undefined&&F!==null&&F!==""?parseFloat(String(F).replace(E,""),10):""};break;case"bool":case"boolean":B=function(F){return F===true||F==="true"||F==1};break;case"date":B=function(G){if(!G){return""}if(Ext.isDate(G)){return G}if(A){if(A=="timestamp"){return new Date(G*1000)}if(A=="time"){return new Date(parseInt(G,10))}return Date.parseDate(G,A)}var F=Date.parse(G);return F?new Date(F):null};break}this.convert=B}};Ext.data.Field.prototype={dateFormat:null,defaultValue:"",mapping:null,sortType:null,sortDir:"ASC"};
Ext.data.DataReader=function(A,B){this.meta=A;this.recordType=Ext.isArray(B)?Ext.data.Record.create(B):B};Ext.data.DataReader.prototype={};
Ext.data.DataProxy=function(){this.addEvents("beforeload","load");Ext.data.DataProxy.superclass.constructor.call(this)};Ext.extend(Ext.data.DataProxy,Ext.util.Observable);
Ext.data.MemoryProxy=function(A){Ext.data.MemoryProxy.superclass.constructor.call(this);this.data=A};Ext.extend(Ext.data.MemoryProxy,Ext.data.DataProxy,{load:function(F,C,G,D,B){F=F||{};var A;try{A=C.readRecords(this.data)}catch(E){this.fireEvent("loadexception",this,B,null,E);G.call(D,null,B,false);return }G.call(D,A,B,true)},update:function(B,A){}});
Ext.data.HttpProxy=function(A){Ext.data.HttpProxy.superclass.constructor.call(this);this.conn=A;this.useAjax=!A||!A.events};Ext.extend(Ext.data.HttpProxy,Ext.data.DataProxy,{getConnection:function(){return this.useAjax?Ext.Ajax:this.conn},load:function(E,B,F,C,A){if(this.fireEvent("beforeload",this,E)!==false){var D={params:E||{},request:{callback:F,scope:C,arg:A},reader:B,callback:this.loadResponse,scope:this};if(this.useAjax){Ext.applyIf(D,this.conn);if(this.activeRequest){Ext.Ajax.abort(this.activeRequest)}this.activeRequest=Ext.Ajax.request(D)}else{this.conn.request(D)}}else{F.call(C||this,null,A,false)}},loadResponse:function(E,D,B){delete this.activeRequest;if(!D){this.fireEvent("loadexception",this,E,B);E.request.callback.call(E.request.scope,null,E.request.arg,false);return }var A;try{A=E.reader.read(B)}catch(C){this.fireEvent("loadexception",this,E,B,C);E.request.callback.call(E.request.scope,null,E.request.arg,false);return }this.fireEvent("load",this,E,E.request.arg);E.request.callback.call(E.request.scope,A,E.request.arg,true)},update:function(A){},updateResponse:function(A){}});
Ext.data.ScriptTagProxy=function(A){Ext.data.ScriptTagProxy.superclass.constructor.call(this);Ext.apply(this,A);this.head=document.getElementsByTagName("head")[0]};Ext.data.ScriptTagProxy.TRANS_ID=1000;Ext.extend(Ext.data.ScriptTagProxy,Ext.data.DataProxy,{timeout:30000,callbackParam:"callback",nocache:true,load:function(E,F,H,I,J){if(this.fireEvent("beforeload",this,E)!==false){var C=Ext.urlEncode(Ext.apply(E,this.extraParams));var B=this.url;B+=(B.indexOf("?")!=-1?"&":"?")+C;if(this.nocache){B+="&_dc="+(new Date().getTime())}var A=++Ext.data.ScriptTagProxy.TRANS_ID;var K={id:A,cb:"stcCallback"+A,scriptId:"stcScript"+A,params:E,arg:J,url:B,callback:H,scope:I,reader:F};var D=this;window[K.cb]=function(L){D.handleResponse(L,K)};B+=String.format("&{0}={1}",this.callbackParam,K.cb);if(this.autoAbort!==false){this.abort()}K.timeoutId=this.handleFailure.defer(this.timeout,this,[K]);var G=document.createElement("script");G.setAttribute("src",B);G.setAttribute("type","text/javascript");G.setAttribute("id",K.scriptId);this.head.appendChild(G);this.trans=K}else{H.call(I||this,null,J,false)}},isLoading:function(){return this.trans?true:false},abort:function(){if(this.isLoading()){this.destroyTrans(this.trans)}},destroyTrans:function(B,A){this.head.removeChild(document.getElementById(B.scriptId));clearTimeout(B.timeoutId);if(A){window[B.cb]=undefined;try{delete window[B.cb]}catch(C){}}else{window[B.cb]=function(){window[B.cb]=undefined;try{delete window[B.cb]}catch(D){}}}},handleResponse:function(D,B){this.trans=false;this.destroyTrans(B,true);var A;try{A=B.reader.readRecords(D)}catch(C){this.fireEvent("loadexception",this,D,B.arg,C);B.callback.call(B.scope||window,null,B.arg,false);return }this.fireEvent("load",this,D,B.arg);B.callback.call(B.scope||window,A,B.arg,true)},handleFailure:function(A){this.trans=false;this.destroyTrans(A,false);this.fireEvent("loadexception",this,null,A.arg);A.callback.call(A.scope||window,null,A.arg,false)}});
Ext.data.JsonReader=function(A,B){A=A||{};Ext.data.JsonReader.superclass.constructor.call(this,A,B||A.fields)};Ext.extend(Ext.data.JsonReader,Ext.data.DataReader,{read:function(response){var json=response.responseText;var o=eval("("+json+")");if(!o){throw {message:"JsonReader.read: Json object not found"}}return this.readRecords(o)},onMetaChange:function(A,C,B){},simpleAccess:function(B,A){return B[A]},getJsonAccessor:function(){var A=/[\[\.]/;return function(C){try{return(A.test(C))?new Function("obj","return obj."+C):function(D){return D[C]}}catch(B){}return Ext.emptyFn}}(),readRecords:function(K){this.jsonData=K;if(K.metaData){delete this.ef;this.meta=K.metaData;this.recordType=Ext.data.Record.create(K.metaData.fields);this.onMetaChange(this.meta,this.recordType,K)}var H=this.meta,A=this.recordType,R=A.prototype.fields,F=R.items,E=R.length;if(!this.ef){if(H.totalProperty){this.getTotal=this.getJsonAccessor(H.totalProperty)}if(H.successProperty){this.getSuccess=this.getJsonAccessor(H.successProperty)}this.getRoot=H.root?this.getJsonAccessor(H.root):function(U){return U};if(H.id){var Q=this.getJsonAccessor(H.id);this.getId=function(V){var U=Q(V);return(U===undefined||U==="")?null:U}}else{this.getId=function(){return null}}this.ef=[];for(var O=0;O<E;O++){R=F[O];var T=(R.mapping!==undefined&&R.mapping!==null)?R.mapping:R.name;this.ef[O]=this.getJsonAccessor(T)}}var M=this.getRoot(K),S=M.length,I=S,D=true;if(H.totalProperty){var G=parseInt(this.getTotal(K),10);if(!isNaN(G)){I=G}}if(H.successProperty){var G=this.getSuccess(K);if(G===false||G==="false"){D=false}}var P=[];for(var O=0;O<S;O++){var L=M[O];var B={};var J=this.getId(L);for(var N=0;N<E;N++){R=F[N];var G=this.ef[N](L);B[R.name]=R.convert((G!==undefined)?G:R.defaultValue,L)}var C=new A(B,J);C.json=L;P[O]=C}return{success:D,records:P,totalRecords:I}}});
Ext.data.XmlReader=function(A,B){A=A||{};Ext.data.XmlReader.superclass.constructor.call(this,A,B||A.fields)};Ext.extend(Ext.data.XmlReader,Ext.data.DataReader,{read:function(A){var B=A.responseXML;if(!B){throw {message:"XmlReader.read: XML Document not available"}}return this.readRecords(B)},readRecords:function(T){this.xmlData=T;var N=T.documentElement||T;var I=Ext.DomQuery;var B=this.recordType,L=B.prototype.fields;var D=this.meta.id;var G=0,E=true;if(this.meta.totalRecords){G=I.selectNumber(this.meta.totalRecords,N,0)}if(this.meta.success){var K=I.selectValue(this.meta.success,N,true);E=K!==false&&K!=="false"}var Q=[];var U=I.select(this.meta.record,N);for(var P=0,R=U.length;P<R;P++){var M=U[P];var A={};var J=D?I.selectValue(D,M):undefined;for(var O=0,H=L.length;O<H;O++){var S=L.items[O];var F=I.selectValue(S.mapping||S.name,M,S.defaultValue);F=S.convert(F,M);A[S.name]=F}var C=new B(A,J);C.node=M;Q[Q.length]=C}return{success:E,records:Q,totalRecords:G||Q.length}}});
Ext.data.ArrayReader=Ext.extend(Ext.data.JsonReader,{readRecords:function(C){var B=this.meta?this.meta.id:null;var G=this.recordType,K=G.prototype.fields;var E=[];var M=C;for(var I=0;I<M.length;I++){var D=M[I];var O={};var A=((B||B===0)&&D[B]!==undefined&&D[B]!==""?D[B]:null);for(var H=0,P=K.length;H<P;H++){var L=K.items[H];var F=L.mapping!==undefined&&L.mapping!==null?L.mapping:H;var N=D[F]!==undefined?D[F]:L.defaultValue;N=L.convert(N,D);O[L.name]=N}var J=new G(O,A);J.json=D;E[E.length]=J}return{records:E,totalRecords:E.length}}});
Ext.data.Tree=function(A){this.nodeHash={};this.root=null;if(A){this.setRootNode(A)}this.addEvents("append","remove","move","insert","beforeappend","beforeremove","beforemove","beforeinsert");Ext.data.Tree.superclass.constructor.call(this)};Ext.extend(Ext.data.Tree,Ext.util.Observable,{pathSeparator:"/",proxyNodeEvent:function(){return this.fireEvent.apply(this,arguments)},getRootNode:function(){return this.root},setRootNode:function(A){this.root=A;A.ownerTree=this;A.isRoot=true;this.registerNode(A);return A},getNodeById:function(A){return this.nodeHash[A]},registerNode:function(A){this.nodeHash[A.id]=A},unregisterNode:function(A){delete this.nodeHash[A.id]},toString:function(){return"[Tree"+(this.id?" "+this.id:"")+"]"}});Ext.data.Node=function(A){this.attributes=A||{};this.leaf=this.attributes.leaf;this.id=this.attributes.id;if(!this.id){this.id=Ext.id(null,"ynode-");this.attributes.id=this.id}this.childNodes=[];if(!this.childNodes.indexOf){this.childNodes.indexOf=function(D){for(var C=0,B=this.length;C<B;C++){if(this[C]==D){return C}}return -1}}this.parentNode=null;this.firstChild=null;this.lastChild=null;this.previousSibling=null;this.nextSibling=null;this.addEvents({"append":true,"remove":true,"move":true,"insert":true,"beforeappend":true,"beforeremove":true,"beforemove":true,"beforeinsert":true});this.listeners=this.attributes.listeners;Ext.data.Node.superclass.constructor.call(this)};Ext.extend(Ext.data.Node,Ext.util.Observable,{fireEvent:function(B){if(Ext.data.Node.superclass.fireEvent.apply(this,arguments)===false){return false}var A=this.getOwnerTree();if(A){if(A.proxyNodeEvent.apply(A,arguments)===false){return false}}return true},isLeaf:function(){return this.leaf===true},setFirstChild:function(A){this.firstChild=A},setLastChild:function(A){this.lastChild=A},isLast:function(){return(!this.parentNode?true:this.parentNode.lastChild==this)},isFirst:function(){return(!this.parentNode?true:this.parentNode.firstChild==this)},hasChildNodes:function(){return !this.isLeaf()&&this.childNodes.length>0},isExpandable:function(){return this.attributes.expandable||this.hasChildNodes()},appendChild:function(E){var F=false;if(Ext.isArray(E)){F=E}else{if(arguments.length>1){F=arguments}}if(F){for(var D=0,A=F.length;D<A;D++){this.appendChild(F[D])}}else{if(this.fireEvent("beforeappend",this.ownerTree,this,E)===false){return false}var B=this.childNodes.length;var C=E.parentNode;if(C){if(E.fireEvent("beforemove",E.getOwnerTree(),E,C,this,B)===false){return false}C.removeChild(E)}B=this.childNodes.length;if(B==0){this.setFirstChild(E)}this.childNodes.push(E);E.parentNode=this;var G=this.childNodes[B-1];if(G){E.previousSibling=G;G.nextSibling=E}else{E.previousSibling=null}E.nextSibling=null;this.setLastChild(E);E.setOwnerTree(this.getOwnerTree());this.fireEvent("append",this.ownerTree,this,E,B);if(C){E.fireEvent("move",this.ownerTree,E,C,this,B)}return E}},removeChild:function(B){var A=this.childNodes.indexOf(B);if(A==-1){return false}if(this.fireEvent("beforeremove",this.ownerTree,this,B)===false){return false}this.childNodes.splice(A,1);if(B.previousSibling){B.previousSibling.nextSibling=B.nextSibling}if(B.nextSibling){B.nextSibling.previousSibling=B.previousSibling}if(this.firstChild==B){this.setFirstChild(B.nextSibling)}if(this.lastChild==B){this.setLastChild(B.previousSibling)}B.setOwnerTree(null);B.parentNode=null;B.previousSibling=null;B.nextSibling=null;this.fireEvent("remove",this.ownerTree,this,B);return B},insertBefore:function(D,A){if(!A){return this.appendChild(D)}if(D==A){return false}if(this.fireEvent("beforeinsert",this.ownerTree,this,D,A)===false){return false}var B=this.childNodes.indexOf(A);var C=D.parentNode;var E=B;if(C==this&&this.childNodes.indexOf(D)<B){E--}if(C){if(D.fireEvent("beforemove",D.getOwnerTree(),D,C,this,B,A)===false){return false}C.removeChild(D)}if(E==0){this.setFirstChild(D)}this.childNodes.splice(E,0,D);D.parentNode=this;var F=this.childNodes[E-1];if(F){D.previousSibling=F;F.nextSibling=D}else{D.previousSibling=null}D.nextSibling=A;A.previousSibling=D;D.setOwnerTree(this.getOwnerTree());this.fireEvent("insert",this.ownerTree,this,D,A);if(C){D.fireEvent("move",this.ownerTree,D,C,this,E,A)}return D},remove:function(){this.parentNode.removeChild(this);return this},item:function(A){return this.childNodes[A]},replaceChild:function(A,B){this.insertBefore(A,B);this.removeChild(B);return B},indexOf:function(A){return this.childNodes.indexOf(A)},getOwnerTree:function(){if(!this.ownerTree){var A=this;while(A){if(A.ownerTree){this.ownerTree=A.ownerTree;break}A=A.parentNode}}return this.ownerTree},getDepth:function(){var B=0;var A=this;while(A.parentNode){++B;A=A.parentNode}return B},setOwnerTree:function(B){if(B!=this.ownerTree){if(this.ownerTree){this.ownerTree.unregisterNode(this)}this.ownerTree=B;var D=this.childNodes;for(var C=0,A=D.length;C<A;C++){D[C].setOwnerTree(B)}if(B){B.registerNode(this)}}},getPath:function(B){B=B||"id";var D=this.parentNode;var A=[this.attributes[B]];while(D){A.unshift(D.attributes[B]);D=D.parentNode}var C=this.getOwnerTree().pathSeparator;return C+A.join(C)},bubble:function(C,B,A){var D=this;while(D){if(C.apply(B||D,A||[D])===false){break}D=D.parentNode}},cascade:function(F,E,B){if(F.apply(E||this,B||[this])!==false){var D=this.childNodes;for(var C=0,A=D.length;C<A;C++){D[C].cascade(F,E,B)}}},eachChild:function(F,E,B){var D=this.childNodes;for(var C=0,A=D.length;C<A;C++){if(F.apply(E||this,B||[D[C]])===false){break}}},findChild:function(D,E){var C=this.childNodes;for(var B=0,A=C.length;B<A;B++){if(C[B].attributes[D]==E){return C[B]}}return null},findChildBy:function(E,D){var C=this.childNodes;for(var B=0,A=C.length;B<A;B++){if(E.call(D||C[B],C[B])===true){return C[B]}}return null},sort:function(E,D){var C=this.childNodes;var A=C.length;if(A>0){var F=D?function(){E.apply(D,arguments)}:E;C.sort(F);for(var B=0;B<A;B++){var G=C[B];G.previousSibling=C[B-1];G.nextSibling=C[B+1];if(B==0){this.setFirstChild(G)}if(B==A-1){this.setLastChild(G)}}}},contains:function(A){return A.isAncestor(this)},isAncestor:function(A){var B=this.parentNode;while(B){if(B==A){return true}B=B.parentNode}return false},toString:function(){return"[Node"+(this.id?" "+this.id:"")+"]"}});
Ext.data.GroupingStore=Ext.extend(Ext.data.Store,{remoteGroup:false,groupOnSort:false,clearGrouping:function(){this.groupField=false;if(this.remoteGroup){if(this.baseParams){delete this.baseParams.groupBy}this.reload()}else{this.applySort();this.fireEvent("datachanged",this)}},groupBy:function(C,B){if(this.groupField==C&&!B){return }this.groupField=C;if(this.remoteGroup){if(!this.baseParams){this.baseParams={}}this.baseParams["groupBy"]=C}if(this.groupOnSort){this.sort(C);return }if(this.remoteGroup){this.reload()}else{var A=this.sortInfo||{};if(A.field!=C){this.applySort()}else{this.sortData(C)}this.fireEvent("datachanged",this)}},applySort:function(){Ext.data.GroupingStore.superclass.applySort.call(this);if(!this.groupOnSort&&!this.remoteGroup){var A=this.getGroupState();if(A&&A!=this.sortInfo.field){this.sortData(this.groupField)}}},applyGrouping:function(A){if(this.groupField!==false){this.groupBy(this.groupField,true);return true}else{if(A===true){this.fireEvent("datachanged",this)}return false}},getGroupState:function(){return this.groupOnSort&&this.groupField!==false?(this.sortInfo?this.sortInfo.field:undefined):this.groupField}});
Ext.ComponentMgr=function(){var B=new Ext.util.MixedCollection();var A={};return{register:function(C){B.add(C)},unregister:function(C){B.remove(C)},get:function(C){return B.get(C)},onAvailable:function(E,D,C){B.on("add",function(F,G){if(G.id==E){D.call(C||G,G);B.un("add",D,C)}})},all:B,registerType:function(D,C){A[D]=C;C.xtype=D},isRegistered:function(C){return A[C];},create:function(C,D){return new A[C.xtype||D](C)}}}();Ext.reg=Ext.ComponentMgr.registerType;
Ext.Component=function(B){B=B||{};if(B.initialConfig){if(B.isAction){this.baseAction=B}B=B.initialConfig}else{if(B.tagName||B.dom||typeof B=="string"){B={applyTo:B,id:B.id||B}}}this.initialConfig=B;Ext.apply(this,B);this.addEvents("disable","enable","beforeshow","show","beforehide","hide","beforerender","render","beforedestroy","destroy","beforestaterestore","staterestore","beforestatesave","statesave");this.getId();Ext.ComponentMgr.register(this);Ext.Component.superclass.constructor.call(this);if(this.baseAction){this.baseAction.addComponent(this)}this.initComponent();if(this.plugins){if(Ext.isArray(this.plugins)){for(var C=0,A=this.plugins.length;C<A;C++){this.plugins[C]=this.initPlugin(this.plugins[C])}}else{this.plugins=this.initPlugin(this.plugins)}}if(this.stateful!==false){this.initState(B)}if(this.applyTo){this.applyToMarkup(this.applyTo);delete this.applyTo}else{if(this.renderTo){this.render(this.renderTo);delete this.renderTo}}};Ext.Component.AUTO_ID=1000;Ext.extend(Ext.Component,Ext.util.Observable,{disabledClass:"x-item-disabled",allowDomMove:true,autoShow:false,hideMode:"display",hideParent:false,hidden:false,disabled:false,rendered:false,ctype:"Ext.Component",actionMode:"el",getActionEl:function(){return this[this.actionMode]},initPlugin:function(A){A.init(this);return A},initComponent:Ext.emptyFn,render:function(B,A){if(!this.rendered&&this.fireEvent("beforerender",this)!==false){if(!B&&this.el){this.el=Ext.get(this.el);B=this.el.dom.parentNode;this.allowDomMove=false}this.container=Ext.get(B);if(this.ctCls){this.container.addClass(this.ctCls)}this.rendered=true;if(A!==undefined){if(typeof A=="number"){A=this.container.dom.childNodes[A]}else{A=Ext.getDom(A)}}this.onRender(this.container,A||null);if(this.autoShow){this.el.removeClass(["x-hidden","x-hide-"+this.hideMode])}if(this.cls){this.el.addClass(this.cls);delete this.cls}if(this.style){this.el.applyStyles(this.style);delete this.style}this.fireEvent("render",this);this.afterRender(this.container);if(this.hidden){this.hide()}if(this.disabled){this.disable()}if(this.stateful!==false){this.initStateEvents()}}return this},initState:function(A){if(Ext.state.Manager){var B=Ext.state.Manager.get(this.stateId||this.id);if(B){if(this.fireEvent("beforestaterestore",this,B)!==false){this.applyState(B);this.fireEvent("staterestore",this,B)}}}},initStateEvents:function(){if(this.stateEvents){for(var A=0,B;B=this.stateEvents[A];A++){this.on(B,this.saveState,this,{delay:100})}}},applyState:function(B,A){if(B){Ext.apply(this,B)}},getState:function(){return null},saveState:function(){if(Ext.state.Manager){var A=this.getState();if(this.fireEvent("beforestatesave",this,A)!==false){Ext.state.Manager.set(this.stateId||this.id,A);this.fireEvent("statesave",this,A)}}},applyToMarkup:function(A){this.allowDomMove=false;this.el=Ext.get(A);this.render(this.el.dom.parentNode)},addClass:function(A){if(this.el){this.el.addClass(A)}else{this.cls=this.cls?this.cls+" "+A:A}},removeClass:function(A){if(this.el){this.el.removeClass(A)}else{if(this.cls){this.cls=this.cls.split(" ").remove(A).join(" ")}}},onRender:function(B,A){if(this.autoEl){if(typeof this.autoEl=="string"){this.el=document.createElement(this.autoEl)}else{var C=document.createElement("div");Ext.DomHelper.overwrite(C,this.autoEl);this.el=C.firstChild}if(!this.el.id){this.el.id=this.getId()}}if(this.el){this.el=Ext.get(this.el);if(this.allowDomMove!==false){B.dom.insertBefore(this.el.dom,A)}if(this.overCls){this.el.addClassOnOver(this.overCls)}}},getAutoCreate:function(){var A=typeof this.autoCreate=="object"?this.autoCreate:Ext.apply({},this.defaultAutoCreate);if(this.id&&!A.id){A.id=this.id}return A},afterRender:Ext.emptyFn,destroy:function(){if(this.fireEvent("beforedestroy",this)!==false){this.beforeDestroy();if(this.rendered){this.el.removeAllListeners();this.el.remove();if(this.actionMode=="container"){this.container.remove()}}this.onDestroy();Ext.ComponentMgr.unregister(this);this.fireEvent("destroy",this);this.purgeListeners()}},beforeDestroy:Ext.emptyFn,onDestroy:Ext.emptyFn,getEl:function(){return this.el},getId:function(){return this.id||(this.id="ext-comp-"+(++Ext.Component.AUTO_ID))},getItemId:function(){return this.itemId||this.getId()},focus:function(B,A){if(A){this.focus.defer(typeof A=="number"?A:10,this,[B,false]);return }if(this.rendered){this.el.focus();if(B===true){this.el.dom.select()}}return this},blur:function(){if(this.rendered){this.el.blur()}return this},disable:function(){if(this.rendered){this.onDisable()}this.disabled=true;this.fireEvent("disable",this);return this},onDisable:function(){this.getActionEl().addClass(this.disabledClass);this.el.dom.disabled=true},enable:function(){if(this.rendered){this.onEnable()}this.disabled=false;this.fireEvent("enable",this);return this},onEnable:function(){this.getActionEl().removeClass(this.disabledClass);this.el.dom.disabled=false},setDisabled:function(A){this[A?"disable":"enable"]()},show:function(){if(this.fireEvent("beforeshow",this)!==false){this.hidden=false;if(this.autoRender){this.render(typeof this.autoRender=="boolean"?Ext.getBody():this.autoRender)}if(this.rendered){this.onShow()}this.fireEvent("show",this)}return this},onShow:function(){if(this.hideParent){this.container.removeClass("x-hide-"+this.hideMode)}else{this.getActionEl().removeClass("x-hide-"+this.hideMode)}},hide:function(){if(this.fireEvent("beforehide",this)!==false){this.hidden=true;if(this.rendered){this.onHide()}this.fireEvent("hide",this)}return this},onHide:function(){if(this.hideParent){this.container.addClass("x-hide-"+this.hideMode)}else{this.getActionEl().addClass("x-hide-"+this.hideMode)}},setVisible:function(A){if(A){this.show()}else{this.hide()}return this},isVisible:function(){return this.rendered&&this.getActionEl().isVisible()},cloneConfig:function(B){B=B||{};var C=B.id||Ext.id();var A=Ext.applyIf(B,this.initialConfig);A.id=C;return new this.constructor(A)},getXType:function(){return this.constructor.xtype},isXType:function(B,A){return !A?("/"+this.getXTypes()+"/").indexOf("/"+B+"/")!=-1:this.constructor.xtype==B},getXTypes:function(){var A=this.constructor;if(!A.xtypes){var C=[],B=this;while(B&&B.constructor.xtype){C.unshift(B.constructor.xtype);B=B.constructor.superclass}A.xtypeChain=C;A.xtypes=C.join("/")}return A.xtypes},findParentBy:function(A){for(var B=this.ownerCt;(B!=null)&&!A(B,this);B=B.ownerCt){}return B||null},findParentByType:function(A){return typeof A=="function"?this.findParentBy(function(B){return B.constructor===A}):this.findParentBy(function(B){return B.constructor.xtype===A})},mon:function(E,B,D,C,A){if(!this.mons){this.mons=[];this.on("beforedestroy",function(){for(var H=0,G=this.mons.length;H<G;H++){var F=this.mons[H];F.item.un(F.ename,F.fn,F.scope)}},this)}this.mons.push({item:E,ename:B,fn:D,scope:C});E.on(B,D,C,A)}});Ext.reg("component",Ext.Component);
Ext.Action=function(A){this.initialConfig=A;this.items=[]};Ext.Action.prototype={isAction:true,setText:function(A){this.initialConfig.text=A;this.callEach("setText",[A])},getText:function(){return this.initialConfig.text},setIconClass:function(A){this.initialConfig.iconCls=A;this.callEach("setIconClass",[A])},getIconClass:function(){return this.initialConfig.iconCls},setDisabled:function(A){this.initialConfig.disabled=A;this.callEach("setDisabled",[A])},enable:function(){this.setDisabled(false)},disable:function(){this.setDisabled(true)},isDisabled:function(){return this.initialConfig.disabled},setHidden:function(A){this.initialConfig.hidden=A;this.callEach("setVisible",[!A])},show:function(){this.setHidden(false)},hide:function(){this.setHidden(true)},isHidden:function(){return this.initialConfig.hidden},setHandler:function(B,A){this.initialConfig.handler=B;this.initialConfig.scope=A;this.callEach("setHandler",[B,A])},each:function(B,A){Ext.each(this.items,B,A)},callEach:function(E,B){var D=this.items;for(var C=0,A=D.length;C<A;C++){D[C][E].apply(D[C],B)}},addComponent:function(A){this.items.push(A);A.on("destroy",this.removeComponent,this)},removeComponent:function(A){this.items.remove(A)},execute:function(){this.initialConfig.handler.apply(this.initialConfig.scope||window,arguments)}};
(function(){Ext.Layer=function(D,C){D=D||{};var E=Ext.DomHelper;var G=D.parentEl,F=G?Ext.getDom(G):document.body;if(C){this.dom=Ext.getDom(C)}if(!this.dom){var H=D.dh||{tag:"div",cls:"x-layer"};this.dom=E.append(F,H)}if(D.cls){this.addClass(D.cls)}this.constrain=D.constrain!==false;this.visibilityMode=Ext.Element.VISIBILITY;if(D.id){this.id=this.dom.id=D.id}else{this.id=Ext.id(this.dom)}this.zindex=D.zindex||this.getZIndex();this.position("absolute",this.zindex);if(D.shadow){this.shadowOffset=D.shadowOffset||4;this.shadow=new Ext.Shadow({offset:this.shadowOffset,mode:D.shadow})}else{this.shadowOffset=0}this.useShim=D.shim!==false&&Ext.useShims;this.useDisplay=D.useDisplay;this.hide()};var A=Ext.Element.prototype;var B=[];Ext.extend(Ext.Layer,Ext.Element,{getZIndex:function(){return this.zindex||parseInt(this.getStyle("z-index"),10)||11000},getShim:function(){if(!this.useShim){return null}if(this.shim){return this.shim}var D=B.shift();if(!D){D=this.createShim();D.enableDisplayMode("block");D.dom.style.display="none";D.dom.style.visibility="visible"}var C=this.dom.parentNode;if(D.dom.parentNode!=C){C.insertBefore(D.dom,this.dom)}D.setStyle("z-index",this.getZIndex()-2);this.shim=D;return D},hideShim:function(){if(this.shim){this.shim.setDisplayed(false);B.push(this.shim);delete this.shim}},disableShadow:function(){if(this.shadow){this.shadowDisabled=true;this.shadow.hide();this.lastShadowOffset=this.shadowOffset;this.shadowOffset=0}},enableShadow:function(C){if(this.shadow){this.shadowDisabled=false;this.shadowOffset=this.lastShadowOffset;delete this.lastShadowOffset;if(C){this.sync(true)}}},sync:function(C){var I=this.shadow;if(!this.updating&&this.isVisible()&&(I||this.useShim)){var F=this.getShim();var H=this.getWidth(),E=this.getHeight();var D=this.getLeft(true),J=this.getTop(true);if(I&&!this.shadowDisabled){if(C&&!I.isVisible()){I.show(this)}else{I.realign(D,J,H,E)}if(F){if(C){F.show()}var G=I.adjusts,K=F.dom.style;K.left=(Math.min(D,D+G.l))+"px";K.top=(Math.min(J,J+G.t))+"px";K.width=(H+G.w)+"px";K.height=(E+G.h)+"px"}}else{if(F){if(C){F.show()}F.setSize(H,E);F.setLeftTop(D,J)}}}},destroy:function(){this.hideShim();if(this.shadow){this.shadow.hide()}this.removeAllListeners();Ext.removeNode(this.dom);Ext.Element.uncache(this.id)},remove:function(){this.destroy()},beginUpdate:function(){this.updating=true},endUpdate:function(){this.updating=false;this.sync(true)},hideUnders:function(C){if(this.shadow){this.shadow.hide()}this.hideShim()},constrainXY:function(){if(this.constrain){var G=Ext.lib.Dom.getViewWidth(),C=Ext.lib.Dom.getViewHeight();var L=Ext.getDoc().getScroll();var K=this.getXY();var H=K[0],F=K[1];var I=this.dom.offsetWidth+this.shadowOffset,D=this.dom.offsetHeight+this.shadowOffset;var E=false;if((H+I)>G+L.left){H=G-I-this.shadowOffset;E=true}if((F+D)>C+L.top){F=C-D-this.shadowOffset;E=true}if(H<L.left){H=L.left;E=true}if(F<L.top){F=L.top;E=true}if(E){if(this.avoidY){var J=this.avoidY;if(F<=J&&(F+D)>=J){F=J-D-5}}K=[H,F];this.storeXY(K);A.setXY.call(this,K);this.sync()}}},isVisible:function(){return this.visible},showAction:function(){this.visible=true;if(this.useDisplay===true){this.setDisplayed("")}else{if(this.lastXY){A.setXY.call(this,this.lastXY)}else{if(this.lastLT){A.setLeftTop.call(this,this.lastLT[0],this.lastLT[1])}}}},hideAction:function(){this.visible=false;if(this.useDisplay===true){this.setDisplayed(false)}else{this.setLeftTop(-10000,-10000)}},setVisible:function(E,D,G,H,F){if(E){this.showAction()}if(D&&E){var C=function(){this.sync(true);if(H){H()}}.createDelegate(this);A.setVisible.call(this,true,true,G,C,F)}else{if(!E){this.hideUnders(true)}var C=H;if(D){C=function(){this.hideAction();if(H){H()}}.createDelegate(this)}A.setVisible.call(this,E,D,G,C,F);if(E){this.sync(true)}else{if(!D){this.hideAction()}}}},storeXY:function(C){delete this.lastLT;this.lastXY=C},storeLeftTop:function(D,C){delete this.lastXY;this.lastLT=[D,C]},beforeFx:function(){this.beforeAction();return Ext.Layer.superclass.beforeFx.apply(this,arguments)},afterFx:function(){Ext.Layer.superclass.afterFx.apply(this,arguments);this.sync(this.isVisible())},beforeAction:function(){if(!this.updating&&this.shadow){this.shadow.hide()}},setLeft:function(C){this.storeLeftTop(C,this.getTop(true));A.setLeft.apply(this,arguments);this.sync()},setTop:function(C){this.storeLeftTop(this.getLeft(true),C);A.setTop.apply(this,arguments);this.sync()},setLeftTop:function(D,C){this.storeLeftTop(D,C);A.setLeftTop.apply(this,arguments);this.sync()},setXY:function(F,D,G,H,E){this.fixDisplay();this.beforeAction();this.storeXY(F);var C=this.createCB(H);A.setXY.call(this,F,D,G,C,E);if(!D){C()}},createCB:function(D){var C=this;return function(){C.constrainXY();C.sync(true);if(D){D()}}},setX:function(C,D,F,G,E){this.setXY([C,this.getY()],D,F,G,E)},setY:function(G,C,E,F,D){this.setXY([this.getX(),G],C,E,F,D)},setSize:function(E,F,D,H,I,G){this.beforeAction();var C=this.createCB(I);A.setSize.call(this,E,F,D,H,C,G);if(!D){C()}},setWidth:function(E,D,G,H,F){this.beforeAction();var C=this.createCB(H);A.setWidth.call(this,E,D,G,C,F);if(!D){C()}},setHeight:function(E,D,G,H,F){this.beforeAction();var C=this.createCB(H);A.setHeight.call(this,E,D,G,C,F);if(!D){C()}},setBounds:function(J,H,K,D,I,F,G,E){this.beforeAction();var C=this.createCB(G);if(!I){this.storeXY([J,H]);A.setXY.call(this,[J,H]);A.setSize.call(this,K,D,I,F,C,E);C()}else{A.setBounds.call(this,J,H,K,D,I,F,C,E)}return this},setZIndex:function(C){this.zindex=C;this.setStyle("z-index",C+2);if(this.shadow){this.shadow.setZIndex(C+1)}if(this.shim){this.shim.setStyle("z-index",C)}}})})();
Ext.Shadow=function(C){Ext.apply(this,C);if(typeof this.mode!="string"){this.mode=this.defaultMode}var D=this.offset,B={h:0};var A=Math.floor(this.offset/2);switch(this.mode.toLowerCase()){case"drop":B.w=0;B.l=B.t=D;B.t-=1;if(Ext.isIE){B.l-=this.offset+A;B.t-=this.offset+A;B.w-=A;B.h-=A;B.t+=1}break;case"sides":B.w=(D*2);B.l=-D;B.t=D-1;if(Ext.isIE){B.l-=(this.offset-A);B.t-=this.offset+A;B.l+=1;B.w-=(this.offset-A)*2;B.w-=A+1;B.h-=1}break;case"frame":B.w=B.h=(D*2);B.l=B.t=-D;B.t+=1;B.h-=2;if(Ext.isIE){B.l-=(this.offset-A);B.t-=(this.offset-A);B.l+=1;B.w-=(this.offset+A+1);B.h-=(this.offset+A);B.h+=1}break}this.adjusts=B};Ext.Shadow.prototype={offset:4,defaultMode:"drop",show:function(A){A=Ext.get(A);if(!this.el){this.el=Ext.Shadow.Pool.pull();if(this.el.dom.nextSibling!=A.dom){this.el.insertBefore(A)}}this.el.setStyle("z-index",this.zIndex||parseInt(A.getStyle("z-index"),10)-1);if(Ext.isIE){this.el.dom.style.filter="progid:DXImageTransform.Microsoft.alpha(opacity=50) progid:DXImageTransform.Microsoft.Blur(pixelradius="+(this.offset)+")"}this.realign(A.getLeft(true),A.getTop(true),A.getWidth(),A.getHeight());this.el.dom.style.display="block"},isVisible:function(){return this.el?true:false},realign:function(A,M,L,D){if(!this.el){return }var I=this.adjusts,G=this.el.dom,N=G.style;var E=0;N.left=(A+I.l)+"px";N.top=(M+I.t)+"px";var K=(L+I.w),C=(D+I.h),F=K+"px",J=C+"px";if(N.width!=F||N.height!=J){N.width=F;N.height=J;if(!Ext.isIE){var H=G.childNodes;var B=Math.max(0,(K-12))+"px";H[0].childNodes[1].style.width=B;H[1].childNodes[1].style.width=B;H[2].childNodes[1].style.width=B;H[1].style.height=Math.max(0,(C-12))+"px"}}},hide:function(){if(this.el){this.el.dom.style.display="none";Ext.Shadow.Pool.push(this.el);delete this.el}},setZIndex:function(A){this.zIndex=A;if(this.el){this.el.setStyle("z-index",A)}}};Ext.Shadow.Pool=function(){var B=[];var A=Ext.isIE?"<div class=\"x-ie-shadow\"></div>":"<div class=\"x-shadow\"><div class=\"xst\"><div class=\"xstl\"></div><div class=\"xstc\"></div><div class=\"xstr\"></div></div><div class=\"xsc\"><div class=\"xsml\"></div><div class=\"xsmc\"></div><div class=\"xsmr\"></div></div><div class=\"xsb\"><div class=\"xsbl\"></div><div class=\"xsbc\"></div><div class=\"xsbr\"></div></div></div>";return{pull:function(){var C=B.shift();if(!C){C=Ext.get(Ext.DomHelper.insertHtml("beforeBegin",document.body.firstChild,A));C.autoBoxAdjust=false}return C},push:function(C){B.push(C)}}}();
Ext.BoxComponent=Ext.extend(Ext.Component,{initComponent:function(){Ext.BoxComponent.superclass.initComponent.call(this);this.addEvents("resize","move")},boxReady:false,deferHeight:false,setSize:function(B,D){if(typeof B=="object"){D=B.height;B=B.width}if(!this.boxReady){this.width=B;this.height=D;return this}if(this.lastSize&&this.lastSize.width==B&&this.lastSize.height==D){return this}this.lastSize={width:B,height:D};var C=this.adjustSize(B,D);var F=C.width,A=C.height;if(F!==undefined||A!==undefined){var E=this.getResizeEl();if(!this.deferHeight&&F!==undefined&&A!==undefined){E.setSize(F,A)}else{if(!this.deferHeight&&A!==undefined){E.setHeight(A)}else{if(F!==undefined){E.setWidth(F)}}}this.onResize(F,A,B,D);this.fireEvent("resize",this,F,A,B,D)}return this},setWidth:function(A){return this.setSize(A)},setHeight:function(A){return this.setSize(undefined,A)},getSize:function(){return this.el.getSize()},getPosition:function(A){if(A===true){return[this.el.getLeft(true),this.el.getTop(true)]}return this.xy||this.el.getXY()},getBox:function(A){var B=this.el.getSize();if(A===true){B.x=this.el.getLeft(true);B.y=this.el.getTop(true)}else{var C=this.xy||this.el.getXY();B.x=C[0];B.y=C[1]}return B},updateBox:function(A){this.setSize(A.width,A.height);this.setPagePosition(A.x,A.y);return this},getResizeEl:function(){return this.resizeEl||this.el},getPositionEl:function(){return this.positionEl||this.el},setPosition:function(A,F){if(A&&typeof A[1]=="number"){F=A[1];A=A[0]}this.x=A;this.y=F;if(!this.boxReady){return this}var B=this.adjustPosition(A,F);var E=B.x,D=B.y;var C=this.getPositionEl();if(E!==undefined||D!==undefined){if(E!==undefined&&D!==undefined){C.setLeftTop(E,D)}else{if(E!==undefined){C.setLeft(E)}else{if(D!==undefined){C.setTop(D)}}}this.onPosition(E,D);this.fireEvent("move",this,E,D)}return this},setPagePosition:function(A,C){if(A&&typeof A[1]=="number"){C=A[1];A=A[0]}this.pageX=A;this.pageY=C;if(!this.boxReady){return }if(A===undefined||C===undefined){return }var B=this.el.translatePoints(A,C);this.setPosition(B.left,B.top);return this},onRender:function(B,A){Ext.BoxComponent.superclass.onRender.call(this,B,A);if(this.resizeEl){this.resizeEl=Ext.get(this.resizeEl)}if(this.positionEl){this.positionEl=Ext.get(this.positionEl)}},afterRender:function(){Ext.BoxComponent.superclass.afterRender.call(this);this.boxReady=true;this.setSize(this.width,this.height);if(this.x||this.y){this.setPosition(this.x,this.y)}else{if(this.pageX||this.pageY){this.setPagePosition(this.pageX,this.pageY)}}},syncSize:function(){delete this.lastSize;this.setSize(this.autoWidth?undefined:this.el.getWidth(),this.autoHeight?undefined:this.el.getHeight());return this},onResize:function(D,B,A,C){},onPosition:function(A,B){},adjustSize:function(A,B){if(this.autoWidth){A="auto"}if(this.autoHeight){B="auto"}return{width:A,height:B}},adjustPosition:function(A,B){return{x:A,y:B}}});Ext.reg("box",Ext.BoxComponent);
Ext.SplitBar=function(C,E,B,D,A){this.el=Ext.get(C,true);this.el.dom.unselectable="on";this.resizingEl=Ext.get(E,true);this.orientation=B||Ext.SplitBar.HORIZONTAL;this.minSize=0;this.maxSize=2000;this.animate=false;this.useShim=false;this.shim=null;if(!A){this.proxy=Ext.SplitBar.createProxy(this.orientation)}else{this.proxy=Ext.get(A).dom}this.dd=new Ext.dd.DDProxy(this.el.dom.id,"XSplitBars",{dragElId:this.proxy.id});this.dd.b4StartDrag=this.onStartProxyDrag.createDelegate(this);this.dd.endDrag=this.onEndProxyDrag.createDelegate(this);this.dragSpecs={};this.adapter=new Ext.SplitBar.BasicLayoutAdapter();this.adapter.init(this);if(this.orientation==Ext.SplitBar.HORIZONTAL){this.placement=D||(this.el.getX()>this.resizingEl.getX()?Ext.SplitBar.LEFT:Ext.SplitBar.RIGHT);this.el.addClass("x-splitbar-h")}else{this.placement=D||(this.el.getY()>this.resizingEl.getY()?Ext.SplitBar.TOP:Ext.SplitBar.BOTTOM);this.el.addClass("x-splitbar-v")}this.addEvents("resize","moved","beforeresize","beforeapply");Ext.SplitBar.superclass.constructor.call(this)};Ext.extend(Ext.SplitBar,Ext.util.Observable,{onStartProxyDrag:function(A,E){this.fireEvent("beforeresize",this);this.overlay=Ext.DomHelper.append(document.body,{cls:"x-drag-overlay",html:"&#160;"},true);this.overlay.unselectable();this.overlay.setSize(Ext.lib.Dom.getViewWidth(true),Ext.lib.Dom.getViewHeight(true));this.overlay.show();Ext.get(this.proxy).setDisplayed("block");var C=this.adapter.getElementSize(this);this.activeMinSize=this.getMinimumSize();this.activeMaxSize=this.getMaximumSize();var D=C-this.activeMinSize;var B=Math.max(this.activeMaxSize-C,0);if(this.orientation==Ext.SplitBar.HORIZONTAL){this.dd.resetConstraints();this.dd.setXConstraint(this.placement==Ext.SplitBar.LEFT?D:B,this.placement==Ext.SplitBar.LEFT?B:D);this.dd.setYConstraint(0,0)}else{this.dd.resetConstraints();this.dd.setXConstraint(0,0);this.dd.setYConstraint(this.placement==Ext.SplitBar.TOP?D:B,this.placement==Ext.SplitBar.TOP?B:D)}this.dragSpecs.startSize=C;this.dragSpecs.startPoint=[A,E];Ext.dd.DDProxy.prototype.b4StartDrag.call(this.dd,A,E)},onEndProxyDrag:function(C){Ext.get(this.proxy).setDisplayed(false);var B=Ext.lib.Event.getXY(C);if(this.overlay){this.overlay.remove();delete this.overlay}var A;if(this.orientation==Ext.SplitBar.HORIZONTAL){A=this.dragSpecs.startSize+(this.placement==Ext.SplitBar.LEFT?B[0]-this.dragSpecs.startPoint[0]:this.dragSpecs.startPoint[0]-B[0])}else{A=this.dragSpecs.startSize+(this.placement==Ext.SplitBar.TOP?B[1]-this.dragSpecs.startPoint[1]:this.dragSpecs.startPoint[1]-B[1])}A=Math.min(Math.max(A,this.activeMinSize),this.activeMaxSize);if(A!=this.dragSpecs.startSize){if(this.fireEvent("beforeapply",this,A)!==false){this.adapter.setElementSize(this,A);this.fireEvent("moved",this,A);this.fireEvent("resize",this,A)}}},getAdapter:function(){return this.adapter},setAdapter:function(A){this.adapter=A;this.adapter.init(this)},getMinimumSize:function(){return this.minSize},setMinimumSize:function(A){this.minSize=A},getMaximumSize:function(){return this.maxSize},setMaximumSize:function(A){this.maxSize=A},setCurrentSize:function(B){var A=this.animate;this.animate=false;this.adapter.setElementSize(this,B);this.animate=A},destroy:function(A){if(this.shim){this.shim.remove()}this.dd.unreg();Ext.removeNode(this.proxy);if(A){this.el.remove()}}});Ext.SplitBar.createProxy=function(B){var C=new Ext.Element(document.createElement("div"));C.unselectable();var A="x-splitbar-proxy";C.addClass(A+" "+(B==Ext.SplitBar.HORIZONTAL?A+"-h":A+"-v"));document.body.appendChild(C.dom);return C.dom};Ext.SplitBar.BasicLayoutAdapter=function(){};Ext.SplitBar.BasicLayoutAdapter.prototype={init:function(A){},getElementSize:function(A){if(A.orientation==Ext.SplitBar.HORIZONTAL){return A.resizingEl.getWidth()}else{return A.resizingEl.getHeight()}},setElementSize:function(B,A,C){if(B.orientation==Ext.SplitBar.HORIZONTAL){if(!B.animate){B.resizingEl.setWidth(A);if(C){C(B,A)}}else{B.resizingEl.setWidth(A,true,0.1,C,"easeOut")}}else{if(!B.animate){B.resizingEl.setHeight(A);if(C){C(B,A)}}else{B.resizingEl.setHeight(A,true,0.1,C,"easeOut")}}}};Ext.SplitBar.AbsoluteLayoutAdapter=function(A){this.basic=new Ext.SplitBar.BasicLayoutAdapter();this.container=Ext.get(A)};Ext.SplitBar.AbsoluteLayoutAdapter.prototype={init:function(A){this.basic.init(A)},getElementSize:function(A){return this.basic.getElementSize(A)},setElementSize:function(B,A,C){this.basic.setElementSize(B,A,this.moveSplitter.createDelegate(this,[B]))},moveSplitter:function(A){var B=Ext.SplitBar;switch(A.placement){case B.LEFT:A.el.setX(A.resizingEl.getRight());break;case B.RIGHT:A.el.setStyle("right",(this.container.getWidth()-A.resizingEl.getLeft())+"px");break;case B.TOP:A.el.setY(A.resizingEl.getBottom());break;case B.BOTTOM:A.el.setY(A.resizingEl.getTop()-A.el.getHeight());break}}};Ext.SplitBar.VERTICAL=1;Ext.SplitBar.HORIZONTAL=2;Ext.SplitBar.LEFT=1;Ext.SplitBar.RIGHT=2;Ext.SplitBar.TOP=3;Ext.SplitBar.BOTTOM=4;
Ext.Container=Ext.extend(Ext.BoxComponent,{autoDestroy:true,defaultType:"panel",initComponent:function(){Ext.Container.superclass.initComponent.call(this);this.addEvents("afterlayout","beforeadd","beforeremove","add","remove");var A=this.items;if(A){delete this.items;if(Ext.isArray(A)){this.add.apply(this,A)}else{this.add(A)}}},initItems:function(){if(!this.items){this.items=new Ext.util.MixedCollection(false,this.getComponentId);this.getLayout()}},setLayout:function(A){if(this.layout&&this.layout!=A){this.layout.setContainer(null)}this.initItems();this.layout=A;A.setContainer(this)},render:function(){Ext.Container.superclass.render.apply(this,arguments);if(this.layout){if(typeof this.layout=="string"){this.layout=new Ext.Container.LAYOUTS[this.layout.toLowerCase()](this.layoutConfig)}this.setLayout(this.layout);if(this.activeItem!==undefined){var A=this.activeItem;delete this.activeItem;this.layout.setActiveItem(A);return }}if(!this.ownerCt){this.doLayout()}if(this.monitorResize===true){Ext.EventManager.onWindowResize(this.doLayout,this,[false])}},getLayoutTarget:function(){return this.el},getComponentId:function(A){return A.itemId||A.id},add:function(C){if(!this.items){this.initItems()}var B=arguments,A=B.length;if(A>1){for(var D=0;D<A;D++){this.add(B[D])}return }var F=this.lookupComponent(this.applyDefaults(C));var E=this.items.length;if(this.fireEvent("beforeadd",this,F,E)!==false&&this.onBeforeAdd(F)!==false){this.items.add(F);F.ownerCt=this;this.fireEvent("add",this,F,E)}return F},insert:function(D,C){if(!this.items){this.initItems()}var B=arguments,A=B.length;if(A>2){for(var E=A-1;E>=1;--E){this.insert(D,B[E])}return }var F=this.lookupComponent(this.applyDefaults(C));if(F.ownerCt==this&&this.items.indexOf(F)<D){--D}if(this.fireEvent("beforeadd",this,F,D)!==false&&this.onBeforeAdd(F)!==false){this.items.insert(D,F);F.ownerCt=this;this.fireEvent("add",this,F,D)}return F},applyDefaults:function(A){if(this.defaults){if(typeof A=="string"){A=Ext.ComponentMgr.get(A);Ext.apply(A,this.defaults)}else{if(!A.events){Ext.applyIf(A,this.defaults)}else{Ext.apply(A,this.defaults)}}}return A},onBeforeAdd:function(A){if(A.ownerCt){A.ownerCt.remove(A,false)}if(this.hideBorders===true){A.border=(A.border===true)}},remove:function(A,B){var C=this.getComponent(A);if(C&&this.fireEvent("beforeremove",this,C)!==false){this.items.remove(C);delete C.ownerCt;if(B===true||(B!==false&&this.autoDestroy)){C.destroy()}if(this.layout&&this.layout.activeItem==C){delete this.layout.activeItem}this.fireEvent("remove",this,C)}return C},getComponent:function(A){if(typeof A=="object"){return A}return this.items.get(A)},lookupComponent:function(A){if(typeof A=="string"){return Ext.ComponentMgr.get(A)}else{if(!A.events){return this.createComponent(A)}}return A},createComponent:function(A){return Ext.ComponentMgr.create(A,this.defaultType)},doLayout:function(D){if(this.rendered&&this.layout){this.layout.layout()}if(D!==false&&this.items){var C=this.items.items;for(var B=0,A=C.length;B<A;B++){var E=C[B];if(E.doLayout){E.doLayout()}}}},getLayout:function(){if(!this.layout){var A=new Ext.layout.ContainerLayout(this.layoutConfig);this.setLayout(A)}return this.layout},beforeDestroy:function(){if(this.items){Ext.destroy.apply(Ext,this.items.items)}if(this.monitorResize){Ext.EventManager.removeResizeListener(this.doLayout,this)}if(this.layout&&this.layout.destroy){this.layout.destroy()}Ext.Container.superclass.beforeDestroy.call(this)},bubble:function(C,B,A){var D=this;while(D){if(C.apply(B||D,A||[D])===false){break}D=D.ownerCt}},cascade:function(F,E,B){if(F.apply(E||this,B||[this])!==false){if(this.items){var D=this.items.items;for(var C=0,A=D.length;C<A;C++){if(D[C].cascade){D[C].cascade(F,E,B)}else{F.apply(E||D[C],B||[D[C]])}}}}},findById:function(C){var A,B=this;this.cascade(function(D){if(B!=D&&D.id===C){A=D;return false}});return A||null},findByType:function(A){return typeof A=="function"?this.findBy(function(B){return B.constructor===A}):this.findBy(function(B){return B.constructor.xtype===A})},find:function(B,A){return this.findBy(function(C){return C[B]===A})},findBy:function(D,C){var A=[],B=this;this.cascade(function(E){if(B!=E&&D.call(C||E,E,B)===true){A.push(E)}});return A}});Ext.Container.LAYOUTS={};Ext.reg("container",Ext.Container);
Ext.layout.ContainerLayout=function(A){Ext.apply(this,A)};Ext.layout.ContainerLayout.prototype={monitorResize:false,activeItem:null,layout:function(){var A=this.container.getLayoutTarget();this.onLayout(this.container,A);this.container.fireEvent("afterlayout",this.container,this)},onLayout:function(A,B){this.renderAll(A,B)},isValidParent:function(C,B){var A=C.getPositionEl?C.getPositionEl():C.getEl();return A.dom.parentNode==B.dom},renderAll:function(D,E){var B=D.items.items;for(var C=0,A=B.length;C<A;C++){var F=B[C];if(F&&(!F.rendered||!this.isValidParent(F,E))){this.renderItem(F,C,E)}}},renderItem:function(D,A,C){if(D&&!D.rendered){D.render(C,A);if(this.extraCls){var B=D.getPositionEl?D.getPositionEl():D;B.addClass(this.extraCls)}if(this.renderHidden&&D!=this.activeItem){D.hide()}}else{if(D&&!this.isValidParent(D,C)){if(this.extraCls){D.addClass(this.extraCls)}if(typeof A=="number"){A=C.dom.childNodes[A]}C.dom.insertBefore(D.getEl().dom,A||null);if(this.renderHidden&&D!=this.activeItem){D.hide()}}}},onResize:function(){if(this.container.collapsed){return }var A=this.container.bufferResize;if(A){if(!this.resizeTask){this.resizeTask=new Ext.util.DelayedTask(this.layout,this);this.resizeBuffer=typeof A=="number"?A:100}this.resizeTask.delay(this.resizeBuffer)}else{this.layout()}},setContainer:function(A){if(this.monitorResize&&A!=this.container){if(this.container){this.container.un("resize",this.onResize,this)}if(A){A.on("resize",this.onResize,this)}}this.container=A},parseMargins:function(B){var C=B.split(" ");var A=C.length;if(A==1){C[1]=C[0];C[2]=C[0];C[3]=C[0]}if(A==2){C[2]=C[0];C[3]=C[1]}return{top:parseInt(C[0],10)||0,right:parseInt(C[1],10)||0,bottom:parseInt(C[2],10)||0,left:parseInt(C[3],10)||0}},destroy:Ext.emptyFn};Ext.Container.LAYOUTS["auto"]=Ext.layout.ContainerLayout;
Ext.layout.FitLayout=Ext.extend(Ext.layout.ContainerLayout,{monitorResize:true,onLayout:function(A,B){Ext.layout.FitLayout.superclass.onLayout.call(this,A,B);if(!this.container.collapsed){this.setItemSize(this.activeItem||A.items.itemAt(0),B.getStyleSize())}},setItemSize:function(B,A){if(B&&A.height>0){B.setSize(A)}}});Ext.Container.LAYOUTS["fit"]=Ext.layout.FitLayout;
Ext.layout.CardLayout=Ext.extend(Ext.layout.FitLayout,{deferredRender:false,renderHidden:true,setActiveItem:function(A){A=this.container.getComponent(A);if(this.activeItem!=A){if(this.activeItem){this.activeItem.hide()}this.activeItem=A;A.show();this.layout()}},renderAll:function(A,B){if(this.deferredRender){this.renderItem(this.activeItem,undefined,B)}else{Ext.layout.CardLayout.superclass.renderAll.call(this,A,B)}}});Ext.Container.LAYOUTS["card"]=Ext.layout.CardLayout;
Ext.layout.AnchorLayout=Ext.extend(Ext.layout.ContainerLayout,{monitorResize:true,getAnchorViewSize:function(A,B){return B.dom==document.body?B.getViewSize():B.getStyleSize()},onLayout:function(F,I){Ext.layout.AnchorLayout.superclass.onLayout.call(this,F,I);var O=this.getAnchorViewSize(F,I);var M=O.width,E=O.height;if(M<20||E<20){return }var B,K;if(F.anchorSize){if(typeof F.anchorSize=="number"){B=F.anchorSize}else{B=F.anchorSize.width;K=F.anchorSize.height}}else{B=F.initialConfig.width;K=F.initialConfig.height}var H=F.items.items,G=H.length,D,J,L,C,A;for(D=0;D<G;D++){J=H[D];if(J.anchor){L=J.anchorSpec;if(!L){var N=J.anchor.split(" ");J.anchorSpec=L={right:this.parseAnchor(N[0],J.initialConfig.width,B),bottom:this.parseAnchor(N[1],J.initialConfig.height,K)}}C=L.right?this.adjustWidthAnchor(L.right(M),J):undefined;A=L.bottom?this.adjustHeightAnchor(L.bottom(E),J):undefined;if(C||A){J.setSize(C||undefined,A||undefined)}}}},parseAnchor:function(B,F,A){if(B&&B!="none"){var D;if(/^(r|right|b|bottom)$/i.test(B)){var E=A-F;return function(G){if(G!==D){D=G;return G-E}}}else{if(B.indexOf("%")!=-1){var C=parseFloat(B.replace("%",""))*0.01;return function(G){if(G!==D){D=G;return Math.floor(G*C)}}}else{B=parseInt(B,10);if(!isNaN(B)){return function(G){if(G!==D){D=G;return G+B}}}}}}return false},adjustWidthAnchor:function(B,A){return B},adjustHeightAnchor:function(B,A){return B}});Ext.Container.LAYOUTS["anchor"]=Ext.layout.AnchorLayout;
Ext.layout.ColumnLayout=Ext.extend(Ext.layout.ContainerLayout,{monitorResize:true,extraCls:"x-column",scrollOffset:0,isValidParent:function(B,A){return B.getEl().dom.parentNode==this.innerCt.dom},onLayout:function(C,F){var D=C.items.items,E=D.length,G,A;if(!this.innerCt){F.addClass("x-column-layout-ct");this.innerCt=F.createChild({cls:"x-column-inner"});this.innerCt.createChild({cls:"x-clear"})}this.renderAll(C,this.innerCt);var J=Ext.isIE&&F.dom!=Ext.getBody().dom?F.getStyleSize():F.getViewSize();if(J.width<1&&J.height<1){return }var H=J.width-F.getPadding("lr")-this.scrollOffset,B=J.height-F.getPadding("tb"),I=H;this.innerCt.setWidth(H);for(A=0;A<E;A++){G=D[A];if(!G.columnWidth){I-=(G.getSize().width+G.getEl().getMargins("lr"))}}I=I<0?0:I;for(A=0;A<E;A++){G=D[A];if(G.columnWidth){G.setSize(Math.floor(G.columnWidth*I)-G.getEl().getMargins("lr"))}}}});Ext.Container.LAYOUTS["column"]=Ext.layout.ColumnLayout;
Ext.layout.BorderLayout=Ext.extend(Ext.layout.ContainerLayout,{monitorResize:true,rendered:false,onLayout:function(B,X){var C;if(!this.rendered){X.position();X.addClass("x-border-layout-ct");var M=B.items.items;C=[];for(var Q=0,R=M.length;Q<R;Q++){var U=M[Q];var F=U.region;if(U.collapsed){C.push(U)}U.collapsed=false;if(!U.rendered){U.cls=U.cls?U.cls+" x-border-panel":"x-border-panel";U.render(X,Q)}this[F]=F!="center"&&U.split?new Ext.layout.BorderLayout.SplitRegion(this,U.initialConfig,F):new Ext.layout.BorderLayout.Region(this,U.initialConfig,F);this[F].render(X,U)}this.rendered=true}var L=X.getViewSize();if(L.width<20||L.height<20){if(C){this.restoreCollapsed=C}return }else{if(this.restoreCollapsed){C=this.restoreCollapsed;delete this.restoreCollapsed}}var J=L.width,S=L.height;var I=J,P=S,G=0,H=0;var N=this.north,K=this.south,E=this.west,T=this.east,U=this.center;if(!U){throw"No center region defined in BorderLayout "+B.id}if(N&&N.isVisible()){var W=N.getSize();var O=N.getMargins();W.width=J-(O.left+O.right);W.x=O.left;W.y=O.top;G=W.height+W.y+O.bottom;P-=G;N.applyLayout(W)}if(K&&K.isVisible()){var W=K.getSize();var O=K.getMargins();W.width=J-(O.left+O.right);W.x=O.left;var V=(W.height+O.top+O.bottom);W.y=S-V+O.top;P-=V;K.applyLayout(W)}if(E&&E.isVisible()){var W=E.getSize();var O=E.getMargins();W.height=P-(O.top+O.bottom);W.x=O.left;W.y=G+O.top;var A=(W.width+O.left+O.right);H+=A;I-=A;E.applyLayout(W)}if(T&&T.isVisible()){var W=T.getSize();var O=T.getMargins();W.height=P-(O.top+O.bottom);var A=(W.width+O.left+O.right);W.x=J-A+O.left;W.y=G+O.top;I-=A;T.applyLayout(W)}var O=U.getMargins();var D={x:H+O.left,y:G+O.top,width:I-(O.left+O.right),height:P-(O.top+O.bottom)};U.applyLayout(D);if(C){for(var Q=0,R=C.length;Q<R;Q++){C[Q].collapse(false)}}if(Ext.isIE&&Ext.isStrict){X.repaint()}},destroy:function(){var B=["north","south","east","west"];for(var A=0;A<B.length;A++){var C=this[B[A]];if(C&&C.split){C.split.destroy(true)}}Ext.layout.BorderLayout.superclass.destroy.call(this)}});Ext.layout.BorderLayout.Region=function(B,A,C){Ext.apply(this,A);this.layout=B;this.position=C;this.state={};if(typeof this.margins=="string"){this.margins=this.layout.parseMargins(this.margins)}this.margins=Ext.applyIf(this.margins||{},this.defaultMargins);if(this.collapsible){if(typeof this.cmargins=="string"){this.cmargins=this.layout.parseMargins(this.cmargins)}if(this.collapseMode=="mini"&&!this.cmargins){this.cmargins={left:0,top:0,right:0,bottom:0}}else{this.cmargins=Ext.applyIf(this.cmargins||{},C=="north"||C=="south"?this.defaultNSCMargins:this.defaultEWCMargins)}}};Ext.layout.BorderLayout.Region.prototype={collapsible:false,split:false,floatable:true,minWidth:50,minHeight:50,defaultMargins:{left:0,top:0,right:0,bottom:0},defaultNSCMargins:{left:5,top:5,right:5,bottom:5},defaultEWCMargins:{left:5,top:0,right:5,bottom:0},isCollapsed:false,render:function(B,C){this.panel=C;C.el.enableDisplayMode();this.targetEl=B;this.el=C.el;var A=C.getState,D=this.position;C.getState=function(){return Ext.apply(A.call(C)||{},this.state)}.createDelegate(this);if(D!="center"){C.allowQueuedExpand=false;C.on({beforecollapse:this.beforeCollapse,collapse:this.onCollapse,beforeexpand:this.beforeExpand,expand:this.onExpand,hide:this.onHide,show:this.onShow,scope:this});if(this.collapsible){C.collapseEl="el";C.slideAnchor=this.getSlideAnchor()}if(C.tools&&C.tools.toggle){C.tools.toggle.addClass("x-tool-collapse-"+D);C.tools.toggle.addClassOnOver("x-tool-collapse-"+D+"-over")}}},getCollapsedEl:function(){if(!this.collapsedEl){if(!this.toolTemplate){var B=new Ext.Template("<div class=\"x-tool x-tool-{id}\">&#160;</div>");B.disableFormats=true;B.compile();Ext.layout.BorderLayout.Region.prototype.toolTemplate=B}this.collapsedEl=this.targetEl.createChild({cls:"x-layout-collapsed x-layout-collapsed-"+this.position,id:this.panel.id+"-xcollapsed"});this.collapsedEl.enableDisplayMode("block");if(this.collapseMode=="mini"){this.collapsedEl.addClass("x-layout-cmini-"+this.position);this.miniCollapsedEl=this.collapsedEl.createChild({cls:"x-layout-mini x-layout-mini-"+this.position,html:"&#160;"});this.miniCollapsedEl.addClassOnOver("x-layout-mini-over");this.collapsedEl.addClassOnOver("x-layout-collapsed-over");this.collapsedEl.on("click",this.onExpandClick,this,{stopEvent:true})}else{var A=this.toolTemplate.append(this.collapsedEl.dom,{id:"expand-"+this.position},true);A.addClassOnOver("x-tool-expand-"+this.position+"-over");A.on("click",this.onExpandClick,this,{stopEvent:true});if(this.floatable!==false){this.collapsedEl.addClassOnOver("x-layout-collapsed-over");this.collapsedEl.on("click",this.collapseClick,this)}}}return this.collapsedEl},onExpandClick:function(A){if(this.isSlid){this.afterSlideIn();this.panel.expand(false)}else{this.panel.expand()}},onCollapseClick:function(A){this.panel.collapse()},beforeCollapse:function(B,A){this.lastAnim=A;if(this.splitEl){this.splitEl.hide()}this.getCollapsedEl().show();this.panel.el.setStyle("z-index",100);this.isCollapsed=true;this.layout.layout()},onCollapse:function(A){this.panel.el.setStyle("z-index",1);if(this.lastAnim===false||this.panel.animCollapse===false){this.getCollapsedEl().dom.style.visibility="visible"}else{this.getCollapsedEl().slideIn(this.panel.slideAnchor,{duration:0.2})}this.state.collapsed=true;this.panel.saveState()},beforeExpand:function(A){var B=this.getCollapsedEl();this.el.show();if(this.position=="east"||this.position=="west"){this.panel.setSize(undefined,B.getHeight())}else{this.panel.setSize(B.getWidth(),undefined)}B.hide();B.dom.style.visibility="hidden";this.panel.el.setStyle("z-index",100)},onExpand:function(){this.isCollapsed=false;if(this.splitEl){this.splitEl.show()}this.layout.layout();this.panel.el.setStyle("z-index",1);this.state.collapsed=false;this.panel.saveState()},collapseClick:function(A){if(this.isSlid){A.stopPropagation();this.slideIn()}else{A.stopPropagation();this.slideOut()}},onHide:function(){if(this.isCollapsed){this.getCollapsedEl().hide()}else{if(this.splitEl){this.splitEl.hide()}}},onShow:function(){if(this.isCollapsed){this.getCollapsedEl().show()}else{if(this.splitEl){this.splitEl.show()}}},isVisible:function(){return !this.panel.hidden},getMargins:function(){return this.isCollapsed&&this.cmargins?this.cmargins:this.margins},getSize:function(){return this.isCollapsed?this.getCollapsedEl().getSize():this.panel.getSize()},setPanel:function(A){this.panel=A},getMinWidth:function(){return this.minWidth},getMinHeight:function(){return this.minHeight},applyLayoutCollapsed:function(A){var B=this.getCollapsedEl();B.setLeftTop(A.x,A.y);B.setSize(A.width,A.height)},applyLayout:function(A){if(this.isCollapsed){this.applyLayoutCollapsed(A)}else{this.panel.setPosition(A.x,A.y);this.panel.setSize(A.width,A.height)}},beforeSlide:function(){this.panel.beforeEffect()},afterSlide:function(){this.panel.afterEffect()},initAutoHide:function(){if(this.autoHide!==false){if(!this.autoHideHd){var A=new Ext.util.DelayedTask(this.slideIn,this);this.autoHideHd={"mouseout":function(B){if(!B.within(this.el,true)){A.delay(500)}},"mouseover":function(B){A.cancel()},scope:this}}this.el.on(this.autoHideHd)}},clearAutoHide:function(){if(this.autoHide!==false){this.el.un("mouseout",this.autoHideHd.mouseout);this.el.un("mouseover",this.autoHideHd.mouseover)}},clearMonitor:function(){Ext.getDoc().un("click",this.slideInIf,this)},slideOut:function(){if(this.isSlid||this.el.hasActiveFx()){return }this.isSlid=true;var A=this.panel.tools;if(A&&A.toggle){A.toggle.hide()}this.el.show();if(this.position=="east"||this.position=="west"){this.panel.setSize(undefined,this.collapsedEl.getHeight())}else{this.panel.setSize(this.collapsedEl.getWidth(),undefined)}this.restoreLT=[this.el.dom.style.left,this.el.dom.style.top];this.el.alignTo(this.collapsedEl,this.getCollapseAnchor());this.el.setStyle("z-index",102);if(this.animFloat!==false){this.beforeSlide();this.el.slideIn(this.getSlideAnchor(),{callback:function(){this.afterSlide();this.initAutoHide();Ext.getDoc().on("click",this.slideInIf,this)},scope:this,block:true})}else{this.initAutoHide();Ext.getDoc().on("click",this.slideInIf,this)}},afterSlideIn:function(){this.clearAutoHide();this.isSlid=false;this.clearMonitor();this.el.setStyle("z-index","");this.el.dom.style.left=this.restoreLT[0];this.el.dom.style.top=this.restoreLT[1];var A=this.panel.tools;if(A&&A.toggle){A.toggle.show()}},slideIn:function(A){if(!this.isSlid||this.el.hasActiveFx()){Ext.callback(A);return }this.isSlid=false;if(this.animFloat!==false){this.beforeSlide();this.el.slideOut(this.getSlideAnchor(),{callback:function(){this.el.hide();this.afterSlide();this.afterSlideIn();Ext.callback(A)},scope:this,block:true})}else{this.el.hide();this.afterSlideIn()}},slideInIf:function(A){if(!A.within(this.el)){this.slideIn()}},anchors:{"west":"left","east":"right","north":"top","south":"bottom"},sanchors:{"west":"l","east":"r","north":"t","south":"b"},canchors:{"west":"tl-tr","east":"tr-tl","north":"tl-bl","south":"bl-tl"},getAnchor:function(){return this.anchors[this.position]},getCollapseAnchor:function(){return this.canchors[this.position]},getSlideAnchor:function(){return this.sanchors[this.position]},getAlignAdj:function(){var A=this.cmargins;switch(this.position){case"west":return[0,0];break;case"east":return[0,0];break;case"north":return[0,0];break;case"south":return[0,0];break}},getExpandAdj:function(){var B=this.collapsedEl,A=this.cmargins;switch(this.position){case"west":return[-(A.right+B.getWidth()+A.left),0];break;case"east":return[A.right+B.getWidth()+A.left,0];break;case"north":return[0,-(A.top+A.bottom+B.getHeight())];break;case"south":return[0,A.top+A.bottom+B.getHeight()];break}}};Ext.layout.BorderLayout.SplitRegion=function(B,A,C){Ext.layout.BorderLayout.SplitRegion.superclass.constructor.call(this,B,A,C);this.applyLayout=this.applyFns[C]};Ext.extend(Ext.layout.BorderLayout.SplitRegion,Ext.layout.BorderLayout.Region,{splitTip:"Drag to resize.",collapsibleSplitTip:"Drag to resize. Double click to hide.",useSplitTips:false,splitSettings:{north:{orientation:Ext.SplitBar.VERTICAL,placement:Ext.SplitBar.TOP,maxFn:"getVMaxSize",minProp:"minHeight",maxProp:"maxHeight"},south:{orientation:Ext.SplitBar.VERTICAL,placement:Ext.SplitBar.BOTTOM,maxFn:"getVMaxSize",minProp:"minHeight",maxProp:"maxHeight"},east:{orientation:Ext.SplitBar.HORIZONTAL,placement:Ext.SplitBar.RIGHT,maxFn:"getHMaxSize",minProp:"minWidth",maxProp:"maxWidth"},west:{orientation:Ext.SplitBar.HORIZONTAL,placement:Ext.SplitBar.LEFT,maxFn:"getHMaxSize",minProp:"minWidth",maxProp:"maxWidth"}},applyFns:{west:function(C){if(this.isCollapsed){return this.applyLayoutCollapsed(C)}var D=this.splitEl.dom,B=D.style;this.panel.setPosition(C.x,C.y);var A=D.offsetWidth;B.left=(C.x+C.width-A)+"px";B.top=(C.y)+"px";B.height=Math.max(0,C.height)+"px";this.panel.setSize(C.width-A,C.height)},east:function(C){if(this.isCollapsed){return this.applyLayoutCollapsed(C)}var D=this.splitEl.dom,B=D.style;var A=D.offsetWidth;this.panel.setPosition(C.x+A,C.y);B.left=(C.x)+"px";B.top=(C.y)+"px";B.height=Math.max(0,C.height)+"px";this.panel.setSize(C.width-A,C.height)},north:function(C){if(this.isCollapsed){return this.applyLayoutCollapsed(C)}var D=this.splitEl.dom,B=D.style;var A=D.offsetHeight;this.panel.setPosition(C.x,C.y);B.left=(C.x)+"px";B.top=(C.y+C.height-A)+"px";B.width=Math.max(0,C.width)+"px";this.panel.setSize(C.width,C.height-A)},south:function(C){if(this.isCollapsed){return this.applyLayoutCollapsed(C)}var D=this.splitEl.dom,B=D.style;var A=D.offsetHeight;this.panel.setPosition(C.x,C.y+A);B.left=(C.x)+"px";B.top=(C.y)+"px";B.width=Math.max(0,C.width)+"px";this.panel.setSize(C.width,C.height-A)}},render:function(A,C){Ext.layout.BorderLayout.SplitRegion.superclass.render.call(this,A,C);var D=this.position;this.splitEl=A.createChild({cls:"x-layout-split x-layout-split-"+D,html:"&#160;",id:this.panel.id+"-xsplit"});if(this.collapseMode=="mini"){this.miniSplitEl=this.splitEl.createChild({cls:"x-layout-mini x-layout-mini-"+D,html:"&#160;"});this.miniSplitEl.addClassOnOver("x-layout-mini-over");this.miniSplitEl.on("click",this.onCollapseClick,this,{stopEvent:true})}var B=this.splitSettings[D];this.split=new Ext.SplitBar(this.splitEl.dom,C.el,B.orientation);this.split.placement=B.placement;this.split.getMaximumSize=this[B.maxFn].createDelegate(this);this.split.minSize=this.minSize||this[B.minProp];this.split.on("beforeapply",this.onSplitMove,this);this.split.useShim=this.useShim===true;this.maxSize=this.maxSize||this[B.maxProp];if(C.hidden){this.splitEl.hide()}if(this.useSplitTips){this.splitEl.dom.title=this.collapsible?this.collapsibleSplitTip:this.splitTip}if(this.collapsible){this.splitEl.on("dblclick",this.onCollapseClick,this)}},getSize:function(){if(this.isCollapsed){return this.collapsedEl.getSize()}var A=this.panel.getSize();if(this.position=="north"||this.position=="south"){A.height+=this.splitEl.dom.offsetHeight}else{A.width+=this.splitEl.dom.offsetWidth}return A},getHMaxSize:function(){var B=this.maxSize||10000;var A=this.layout.center;return Math.min(B,(this.el.getWidth()+A.el.getWidth())-A.getMinWidth())},getVMaxSize:function(){var B=this.maxSize||10000;var A=this.layout.center;return Math.min(B,(this.el.getHeight()+A.el.getHeight())-A.getMinHeight())},onSplitMove:function(B,A){var C=this.panel.getSize();this.lastSplitSize=A;if(this.position=="north"||this.position=="south"){this.panel.setSize(C.width,A);this.state.height=A}else{this.panel.setSize(A,C.height);this.state.width=A}this.layout.layout();this.panel.saveState();return false},getSplitBar:function(){return this.split}});Ext.Container.LAYOUTS["border"]=Ext.layout.BorderLayout;
Ext.layout.FormLayout=Ext.extend(Ext.layout.AnchorLayout,{labelSeparator:":",getAnchorViewSize:function(A,B){return A.body.getStyleSize()},setContainer:function(B){Ext.layout.FormLayout.superclass.setContainer.call(this,B);if(B.labelAlign){B.addClass("x-form-label-"+B.labelAlign)}if(B.hideLabels){this.labelStyle="display:none";this.elementStyle="padding-left:0;";this.labelAdjust=0}else{this.labelSeparator=B.labelSeparator||this.labelSeparator;B.labelWidth=B.labelWidth||100;if(typeof B.labelWidth=="number"){var C=(typeof B.labelPad=="number"?B.labelPad:5);this.labelAdjust=B.labelWidth+C;this.labelStyle="width:"+B.labelWidth+"px;";this.elementStyle="padding-left:"+(B.labelWidth+C)+"px"}if(B.labelAlign=="top"){this.labelStyle="width:auto;";this.labelAdjust=0;this.elementStyle="padding-left:0;"}}if(!this.fieldTpl){var A=new Ext.Template("<div class=\"x-form-item {5}\" tabIndex=\"-1\">","<label for=\"{0}\" style=\"{2}\" class=\"x-form-item-label\">{1}{4}</label>","<div class=\"x-form-element\" id=\"x-form-el-{0}\" style=\"{3}\">","</div><div class=\"{6}\"></div>","</div>");A.disableFormats=true;A.compile();Ext.layout.FormLayout.prototype.fieldTpl=A}},renderItem:function(D,A,C){if(D&&!D.rendered&&D.isFormField&&D.inputType!="hidden"){var B=[D.id,D.fieldLabel,D.labelStyle||this.labelStyle||"",this.elementStyle||"",typeof D.labelSeparator=="undefined"?this.labelSeparator:D.labelSeparator,(D.itemCls||this.container.itemCls||"")+(D.hideLabel?" x-hide-label":""),D.clearCls||"x-form-clear-left"];if(typeof A=="number"){A=C.dom.childNodes[A]||null}if(A){this.fieldTpl.insertBefore(A,B)}else{this.fieldTpl.append(C,B)}D.render("x-form-el-"+D.id)}else{Ext.layout.FormLayout.superclass.renderItem.apply(this,arguments)}},adjustWidthAnchor:function(B,A){return B-(A.isFormField?(A.hideLabel?0:this.labelAdjust):0)},isValidParent:function(B,A){return true}});Ext.Container.LAYOUTS["form"]=Ext.layout.FormLayout;
Ext.layout.Accordion=Ext.extend(Ext.layout.FitLayout,{fill:true,autoWidth:true,titleCollapse:true,hideCollapseTool:false,collapseFirst:false,animate:false,sequence:false,activeOnTop:false,renderItem:function(A){if(this.animate===false){A.animCollapse=false}A.collapsible=true;if(this.autoWidth){A.autoWidth=true}if(this.titleCollapse){A.titleCollapse=true}if(this.hideCollapseTool){A.hideCollapseTool=true}if(this.collapseFirst!==undefined){A.collapseFirst=this.collapseFirst}if(!this.activeItem&&!A.collapsed){this.activeItem=A}else{if(this.activeItem){A.collapsed=true}}Ext.layout.Accordion.superclass.renderItem.apply(this,arguments);A.header.addClass("x-accordion-hd");A.on("beforeexpand",this.beforeExpand,this)},beforeExpand:function(C,B){var A=this.activeItem;if(A){if(this.sequence){delete this.activeItem;if(!A.collapsed){A.collapse({callback:function(){C.expand(B||true)},scope:this});return false}}else{A.collapse(this.animate)}}this.activeItem=C;if(this.activeOnTop){C.el.dom.parentNode.insertBefore(C.el.dom,C.el.dom.parentNode.firstChild)}this.layout()},setItemSize:function(F,E){if(this.fill&&F){var B=this.container.items.items;var D=0;for(var C=0,A=B.length;C<A;C++){var G=B[C];if(G!=F){D+=(G.getSize().height-G.bwrap.getHeight())}}E.height-=D;F.setSize(E)}}});Ext.Container.LAYOUTS["accordion"]=Ext.layout.Accordion;
Ext.layout.TableLayout=Ext.extend(Ext.layout.ContainerLayout,{monitorResize:false,setContainer:function(A){Ext.layout.TableLayout.superclass.setContainer.call(this,A);this.currentRow=0;this.currentColumn=0;this.cells=[]},onLayout:function(C,E){var D=C.items.items,A=D.length,F,B;if(!this.table){E.addClass("x-table-layout-ct");this.table=E.createChild({tag:"table",cls:"x-table-layout",cellspacing:0,cn:{tag:"tbody"}},null,true);this.renderAll(C,E)}},getRow:function(A){var B=this.table.tBodies[0].childNodes[A];if(!B){B=document.createElement("tr");this.table.tBodies[0].appendChild(B)}return B},getNextCell:function(H){var A=this.getNextNonSpan(this.currentColumn,this.currentRow);var E=this.currentColumn=A[0],D=this.currentRow=A[1];for(var G=D;G<D+(H.rowspan||1);G++){if(!this.cells[G]){this.cells[G]=[]}for(var C=E;C<E+(H.colspan||1);C++){this.cells[G][C]=true}}var F=document.createElement("td");if(H.cellId){F.id=H.cellId}var B="x-table-layout-cell";if(H.cellCls){B+=" "+H.cellCls}F.className=B;if(H.colspan){F.colSpan=H.colspan}if(H.rowspan){F.rowSpan=H.rowspan}this.getRow(D).appendChild(F);return F},getNextNonSpan:function(A,C){var B=this.columns;while((B&&A>=B)||(this.cells[C]&&this.cells[C][A])){if(B&&A>=B){C++;A=0}else{A++}}return[A,C]},renderItem:function(C,A,B){if(C&&!C.rendered){C.render(this.getNextCell(C))}},isValidParent:function(B,A){return true}});Ext.Container.LAYOUTS["table"]=Ext.layout.TableLayout;
Ext.layout.AbsoluteLayout=Ext.extend(Ext.layout.AnchorLayout,{extraCls:"x-abs-layout-item",isForm:false,setContainer:function(A){Ext.layout.AbsoluteLayout.superclass.setContainer.call(this,A);if(A.isXType("form")){this.isForm=true}},onLayout:function(A,B){if(this.isForm){A.body.position()}else{B.position()}Ext.layout.AbsoluteLayout.superclass.onLayout.call(this,A,B)},getAnchorViewSize:function(A,B){return this.isForm?A.body.getStyleSize():Ext.layout.AbsoluteLayout.superclass.getAnchorViewSize.call(this,A,B)},isValidParent:function(B,A){return this.isForm?true:Ext.layout.AbsoluteLayout.superclass.isValidParent.call(this,B,A)},adjustWidthAnchor:function(B,A){return B?B-A.getPosition(true)[0]:B},adjustHeightAnchor:function(B,A){return B?B-A.getPosition(true)[1]:B}});Ext.Container.LAYOUTS["absolute"]=Ext.layout.AbsoluteLayout;
Ext.Viewport=Ext.extend(Ext.Container,{initComponent:function(){Ext.Viewport.superclass.initComponent.call(this);document.getElementsByTagName("html")[0].className+=" x-viewport";this.el=Ext.getBody();this.el.setHeight=Ext.emptyFn;this.el.setWidth=Ext.emptyFn;this.el.setSize=Ext.emptyFn;this.el.dom.scroll="no";this.allowDomMove=false;this.autoWidth=true;this.autoHeight=true;Ext.EventManager.onWindowResize(this.fireResize,this);this.renderTo=this.el},fireResize:function(A,B){this.fireEvent("resize",this,A,B,A,B)}});Ext.reg("viewport",Ext.Viewport);
Ext.Panel=Ext.extend(Ext.Container,{baseCls:"x-panel",collapsedCls:"x-panel-collapsed",maskDisabled:true,animCollapse:Ext.enableFx,headerAsText:true,buttonAlign:"right",collapsed:false,collapseFirst:true,minButtonWidth:75,elements:"body",toolTarget:"header",collapseEl:"bwrap",slideAnchor:"t",disabledClass:"",deferHeight:true,expandDefaults:{duration:0.25},collapseDefaults:{duration:0.25},initComponent:function(){Ext.Panel.superclass.initComponent.call(this);this.addEvents("bodyresize","titlechange","collapse","expand","beforecollapse","beforeexpand","beforeclose","close","activate","deactivate");if(this.tbar){this.elements+=",tbar";if(typeof this.tbar=="object"){this.topToolbar=this.tbar}delete this.tbar}if(this.bbar){this.elements+=",bbar";if(typeof this.bbar=="object"){this.bottomToolbar=this.bbar}delete this.bbar}if(this.header===true){this.elements+=",header";delete this.header}else{if(this.title&&this.header!==false){this.elements+=",header"}}if(this.footer===true){this.elements+=",footer";delete this.footer}if(this.buttons){var C=this.buttons;this.buttons=[];for(var B=0,A=C.length;B<A;B++){if(C[B].render){C[B].ownerCt=this;this.buttons.push(C[B])}else{this.addButton(C[B])}}}if(this.autoLoad){this.on("render",this.doAutoLoad,this,{delay:10})}},createElement:function(A,C){if(this[A]){C.appendChild(this[A].dom);return }if(A==="bwrap"||this.elements.indexOf(A)!=-1){if(this[A+"Cfg"]){this[A]=Ext.fly(C).createChild(this[A+"Cfg"])}else{var B=document.createElement("div");B.className=this[A+"Cls"];this[A]=Ext.get(C.appendChild(B))}}},onRender:function(H,G){Ext.Panel.superclass.onRender.call(this,H,G);this.createClasses();if(this.el){this.el.addClass(this.baseCls);this.header=this.el.down("."+this.headerCls);this.bwrap=this.el.down("."+this.bwrapCls);var M=this.bwrap?this.bwrap:this.el;this.tbar=M.down("."+this.tbarCls);this.body=M.down("."+this.bodyCls);this.bbar=M.down("."+this.bbarCls);this.footer=M.down("."+this.footerCls);this.fromMarkup=true}else{this.el=H.createChild({id:this.id,cls:this.baseCls},G)}var A=this.el,K=A.dom;if(this.cls){this.el.addClass(this.cls)}if(this.buttons){this.elements+=",footer"}if(this.frame){A.insertHtml("afterBegin",String.format(Ext.Element.boxMarkup,this.baseCls));this.createElement("header",K.firstChild.firstChild.firstChild);this.createElement("bwrap",K);var O=this.bwrap.dom;var E=K.childNodes[1],B=K.childNodes[2];O.appendChild(E);O.appendChild(B);var P=O.firstChild.firstChild.firstChild;this.createElement("tbar",P);this.createElement("body",P);this.createElement("bbar",P);this.createElement("footer",O.lastChild.firstChild.firstChild);if(!this.footer){this.bwrap.dom.lastChild.className+=" x-panel-nofooter"}}else{this.createElement("header",K);this.createElement("bwrap",K);var O=this.bwrap.dom;this.createElement("tbar",O);this.createElement("body",O);this.createElement("bbar",O);this.createElement("footer",O);if(!this.header){this.body.addClass(this.bodyCls+"-noheader");if(this.tbar){this.tbar.addClass(this.tbarCls+"-noheader")}}}if(this.border===false){this.el.addClass(this.baseCls+"-noborder");this.body.addClass(this.bodyCls+"-noborder");if(this.header){this.header.addClass(this.headerCls+"-noborder")}if(this.footer){this.footer.addClass(this.footerCls+"-noborder")}if(this.tbar){this.tbar.addClass(this.tbarCls+"-noborder")}if(this.bbar){this.bbar.addClass(this.bbarCls+"-noborder")}}if(this.bodyBorder===false){this.body.addClass(this.bodyCls+"-noborder")}if(this.bodyStyle){this.body.applyStyles(this.bodyStyle)}this.bwrap.enableDisplayMode("block");if(this.header){this.header.unselectable();if(this.headerAsText){this.header.dom.innerHTML="<span class=\""+this.headerTextCls+"\">"+this.header.dom.innerHTML+"</span>";if(this.iconCls){this.setIconClass(this.iconCls)}}}if(this.floating){this.makeFloating(this.floating)}if(this.collapsible){this.tools=this.tools?this.tools.slice(0):[];if(!this.hideCollapseTool){this.tools[this.collapseFirst?"unshift":"push"]({id:"toggle",handler:this.toggleCollapse,scope:this})}if(this.titleCollapse&&this.header){this.header.on("click",this.toggleCollapse,this);this.header.setStyle("cursor","pointer")}}if(this.tools){var J=this.tools;this.tools={};this.addTool.apply(this,J)}else{this.tools={}}if(this.buttons&&this.buttons.length>0){var D=this.footer.createChild({cls:"x-panel-btns-ct",cn:{cls:"x-panel-btns x-panel-btns-"+this.buttonAlign,html:"<table cellspacing=\"0\"><tbody><tr></tr></tbody></table><div class=\"x-clear\"></div>"}},null,true);var L=D.getElementsByTagName("tr")[0];for(var F=0,I=this.buttons.length;F<I;F++){var N=this.buttons[F];var C=document.createElement("td");C.className="x-panel-btn-td";N.render(L.appendChild(C))}}if(this.tbar&&this.topToolbar){if(Ext.isArray(this.topToolbar)){this.topToolbar=new Ext.Toolbar(this.topToolbar)}this.topToolbar.render(this.tbar);this.topToolbar.ownerCt=this}if(this.bbar&&this.bottomToolbar){if(Ext.isArray(this.bottomToolbar)){this.bottomToolbar=new Ext.Toolbar(this.bottomToolbar)}this.bottomToolbar.render(this.bbar);this.bottomToolbar.ownerCt=this}},setIconClass:function(B){var A=this.iconCls;this.iconCls=B;if(this.rendered&&this.header){if(this.frame){this.header.addClass("x-panel-icon");this.header.replaceClass(A,this.iconCls)}else{var D=this.header.dom;var C=D.firstChild&&String(D.firstChild.tagName).toLowerCase()=="img"?D.firstChild:null;if(C){Ext.fly(C).replaceClass(A,this.iconCls)}else{Ext.DomHelper.insertBefore(D.firstChild,{tag:"img",src:Ext.BLANK_IMAGE_URL,cls:"x-panel-inline-icon "+this.iconCls})}}}},makeFloating:function(A){this.floating=true;this.el=new Ext.Layer(typeof A=="object"?A:{shadow:this.shadow!==undefined?this.shadow:"sides",shadowOffset:this.shadowOffset,constrain:false,shim:this.shim===false?false:undefined},this.el)},getTopToolbar:function(){return this.topToolbar},getBottomToolbar:function(){return this.bottomToolbar},addButton:function(A,D,C){var E={handler:D,scope:C,minWidth:this.minButtonWidth,hideParent:true};if(typeof A=="string"){E.text=A}else{Ext.apply(E,A)}var B=new Ext.Button(E);B.ownerCt=this;if(!this.buttons){this.buttons=[]}this.buttons.push(B);return B},addTool:function(){if(!this[this.toolTarget]){return }if(!this.toolTemplate){var F=new Ext.Template("<div class=\"x-tool x-tool-{id}\">&#160;</div>");F.disableFormats=true;F.compile();Ext.Panel.prototype.toolTemplate=F}for(var E=0,C=arguments,B=C.length;E<B;E++){var A=C[E],G="x-tool-"+A.id+"-over";var D=this.toolTemplate.insertFirst((A.align!=="left")?this[this.toolTarget]:this[this.toolTarget].child("span"),A,true);this.tools[A.id]=D;D.enableDisplayMode("block");D.on("click",this.createToolHandler(D,A,G,this));if(A.on){D.on(A.on)}if(A.hidden){D.hide()}if(A.qtip){if(typeof A.qtip=="object"){Ext.QuickTips.register(Ext.apply({target:D.id},A.qtip))}else{D.dom.qtip=A.qtip}}D.addClassOnOver(G)}},onShow:function(){if(this.floating){return this.el.show()}Ext.Panel.superclass.onShow.call(this)},onHide:function(){if(this.floating){return this.el.hide()}Ext.Panel.superclass.onHide.call(this)},createToolHandler:function(C,A,D,B){return function(E){C.removeClass(D);E.stopEvent();if(A.handler){A.handler.call(A.scope||C,E,C,B)}}},afterRender:function(){if(this.fromMarkup&&this.height===undefined&&!this.autoHeight){this.height=this.el.getHeight()}if(this.floating&&!this.hidden&&!this.initHidden){this.el.show()}if(this.title){this.setTitle(this.title)}this.setAutoScroll();if(this.html){this.body.update(typeof this.html=="object"?Ext.DomHelper.markup(this.html):this.html);delete this.html}if(this.contentEl){var A=Ext.getDom(this.contentEl);Ext.fly(A).removeClass(["x-hidden","x-hide-display"]);this.body.dom.appendChild(A)}if(this.collapsed){this.collapsed=false;this.collapse(false)}Ext.Panel.superclass.afterRender.call(this);this.initEvents()},setAutoScroll:function(){if(this.rendered&&this.autoScroll){var A=this.body||this.el;if(A){A.setOverflow("auto")}}},getKeyMap:function(){if(!this.keyMap){this.keyMap=new Ext.KeyMap(this.el,this.keys)}return this.keyMap},initEvents:function(){if(this.keys){this.getKeyMap()}if(this.draggable){this.initDraggable()}},initDraggable:function(){this.dd=new Ext.Panel.DD(this,typeof this.draggable=="boolean"?null:this.draggable)},beforeEffect:function(){if(this.floating){this.el.beforeAction()}this.el.addClass("x-panel-animated")},afterEffect:function(){this.syncShadow();this.el.removeClass("x-panel-animated")},createEffect:function(B,A,C){var D={scope:C,block:true};if(B===true){D.callback=A;return D}else{if(!B.callback){D.callback=A}else{D.callback=function(){A.call(C);Ext.callback(B.callback,B.scope)}}}return Ext.applyIf(D,B)},collapse:function(B){if(this.collapsed||this.el.hasFxBlock()||this.fireEvent("beforecollapse",this,B)===false){return }var A=B===true||(B!==false&&this.animCollapse);this.beforeEffect();this.onCollapse(A,B);return this},onCollapse:function(A,B){if(A){this[this.collapseEl].slideOut(this.slideAnchor,Ext.apply(this.createEffect(B||true,this.afterCollapse,this),this.collapseDefaults))}else{this[this.collapseEl].hide();this.afterCollapse()}},afterCollapse:function(){this.collapsed=true;this.el.addClass(this.collapsedCls);this.afterEffect();this.fireEvent("collapse",this)},expand:function(B){if(!this.collapsed||this.el.hasFxBlock()||this.fireEvent("beforeexpand",this,B)===false){return }var A=B===true||(B!==false&&this.animCollapse);this.el.removeClass(this.collapsedCls);this.beforeEffect();this.onExpand(A,B);return this},onExpand:function(A,B){if(A){this[this.collapseEl].slideIn(this.slideAnchor,Ext.apply(this.createEffect(B||true,this.afterExpand,this),this.expandDefaults))}else{this[this.collapseEl].show();this.afterExpand()}},afterExpand:function(){this.collapsed=false;this.afterEffect();this.fireEvent("expand",this)},toggleCollapse:function(A){this[this.collapsed?"expand":"collapse"](A);return this},onDisable:function(){if(this.rendered&&this.maskDisabled){this.el.mask()}Ext.Panel.superclass.onDisable.call(this)},onEnable:function(){if(this.rendered&&this.maskDisabled){this.el.unmask()}Ext.Panel.superclass.onEnable.call(this)},onResize:function(A,B){if(A!==undefined||B!==undefined){if(!this.collapsed){if(typeof A=="number"){this.body.setWidth(this.adjustBodyWidth(A-this.getFrameWidth()))}else{if(A=="auto"){this.body.setWidth(A)}}if(typeof B=="number"){this.body.setHeight(this.adjustBodyHeight(B-this.getFrameHeight()))}else{if(B=="auto"){this.body.setHeight(B)}}if(this.disabled&&this.el._mask){this.el._mask.setSize(this.el.dom.clientWidth,this.el.getHeight())}}else{this.queuedBodySize={width:A,height:B};if(!this.queuedExpand&&this.allowQueuedExpand!==false){this.queuedExpand=true;this.on("expand",function(){delete this.queuedExpand;this.onResize(this.queuedBodySize.width,this.queuedBodySize.height);this.doLayout()},this,{single:true})}}this.fireEvent("bodyresize",this,A,B)}this.syncShadow()},adjustBodyHeight:function(A){return A},adjustBodyWidth:function(A){return A},onPosition:function(){this.syncShadow()},getFrameWidth:function(){var B=this.el.getFrameWidth("lr");if(this.frame){var A=this.bwrap.dom.firstChild;B+=(Ext.fly(A).getFrameWidth("l")+Ext.fly(A.firstChild).getFrameWidth("r"));var C=this.bwrap.dom.firstChild.firstChild.firstChild;B+=Ext.fly(C).getFrameWidth("lr")}return B},getFrameHeight:function(){var A=this.el.getFrameWidth("tb");A+=(this.tbar?this.tbar.getHeight():0)+(this.bbar?this.bbar.getHeight():0);if(this.frame){var C=this.el.dom.firstChild;var D=this.bwrap.dom.lastChild;A+=(C.offsetHeight+D.offsetHeight);var B=this.bwrap.dom.firstChild.firstChild.firstChild;A+=Ext.fly(B).getFrameWidth("tb")}else{A+=(this.header?this.header.getHeight():0)+(this.footer?this.footer.getHeight():0)}return A},getInnerWidth:function(){return this.getSize().width-this.getFrameWidth()},getInnerHeight:function(){return this.getSize().height-this.getFrameHeight()},syncShadow:function(){if(this.floating){this.el.sync(true)}},getLayoutTarget:function(){return this.body},setTitle:function(B,A){this.title=B;if(this.header&&this.headerAsText){this.header.child("span").update(B)}if(A){this.setIconClass(A)}this.fireEvent("titlechange",this,B);return this},getUpdater:function(){return this.body.getUpdater()},load:function(){var A=this.body.getUpdater();A.update.apply(A,arguments);return this},beforeDestroy:function(){Ext.Element.uncache(this.header,this.tbar,this.bbar,this.footer,this.body);if(this.tools){for(var B in this.tools){Ext.destroy(this.tools[B])}}if(this.buttons){for(var A in this.buttons){Ext.destroy(this.buttons[A])}}Ext.destroy(this.topToolbar,this.bottomToolbar);Ext.Panel.superclass.beforeDestroy.call(this)},createClasses:function(){this.headerCls=this.baseCls+"-header";this.headerTextCls=this.baseCls+"-header-text";this.bwrapCls=this.baseCls+"-bwrap";this.tbarCls=this.baseCls+"-tbar";this.bodyCls=this.baseCls+"-body";this.bbarCls=this.baseCls+"-bbar";this.footerCls=this.baseCls+"-footer"},createGhost:function(A,E,B){var D=document.createElement("div");D.className="x-panel-ghost "+(A?A:"");if(this.header){D.appendChild(this.el.dom.firstChild.cloneNode(true))}Ext.fly(D.appendChild(document.createElement("ul"))).setHeight(this.bwrap.getHeight());D.style.width=this.el.dom.offsetWidth+"px";if(!B){this.container.dom.appendChild(D)}else{Ext.getDom(B).appendChild(D)}if(E!==false&&this.el.useShim!==false){var C=new Ext.Layer({shadow:false,useDisplay:true,constrain:false},D);C.show();return C}else{return new Ext.Element(D)}},doAutoLoad:function(){this.body.load(typeof this.autoLoad=="object"?this.autoLoad:{url:this.autoLoad})}});Ext.reg("panel",Ext.Panel);
Ext.Window=Ext.extend(Ext.Panel,{baseCls:"x-window",resizable:true,draggable:true,closable:true,constrain:false,constrainHeader:false,plain:false,minimizable:false,maximizable:false,minHeight:100,minWidth:200,expandOnShow:true,closeAction:"close",elements:"header,body",collapsible:false,initHidden:true,monitorResize:true,frame:true,floating:true,initComponent:function(){Ext.Window.superclass.initComponent.call(this);this.addEvents("resize","maximize","minimize","restore")},getState:function(){return Ext.apply(Ext.Window.superclass.getState.call(this)||{},this.getBox())},onRender:function(B,A){Ext.Window.superclass.onRender.call(this,B,A);if(this.plain){this.el.addClass("x-window-plain")}this.focusEl=this.el.createChild({tag:"a",href:"#",cls:"x-dlg-focus",tabIndex:"-1",html:"&#160;"});this.focusEl.swallowEvent("click",true);this.proxy=this.el.createProxy("x-window-proxy");this.proxy.enableDisplayMode("block");if(this.modal){this.mask=this.container.createChild({cls:"ext-el-mask"},this.el.dom);this.mask.enableDisplayMode("block");this.mask.hide()}},initEvents:function(){Ext.Window.superclass.initEvents.call(this);if(this.animateTarget){this.setAnimateTarget(this.animateTarget)}if(this.resizable){this.resizer=new Ext.Resizable(this.el,{minWidth:this.minWidth,minHeight:this.minHeight,handles:this.resizeHandles||"all",pinned:true,resizeElement:this.resizerAction});this.resizer.window=this;this.resizer.on("beforeresize",this.beforeResize,this)}if(this.draggable){this.header.addClass("x-window-draggable")}this.initTools();this.el.on("mousedown",this.toFront,this);this.manager=this.manager||Ext.WindowMgr;this.manager.register(this);this.hidden=true;if(this.maximized){this.maximized=false;this.maximize()}if(this.closable){var A=this.getKeyMap();A.on(27,this.onEsc,this);A.disable()}},initDraggable:function(){this.dd=new Ext.Window.DD(this)},onEsc:function(){this[this.closeAction]()},beforeDestroy:function(){Ext.destroy(this.resizer,this.dd,this.proxy,this.mask);Ext.Window.superclass.beforeDestroy.call(this)},onDestroy:function(){if(this.manager){this.manager.unregister(this)}Ext.Window.superclass.onDestroy.call(this)},initTools:function(){if(this.minimizable){this.addTool({id:"minimize",handler:this.minimize.createDelegate(this,[])})}if(this.maximizable){this.addTool({id:"maximize",handler:this.maximize.createDelegate(this,[])});this.addTool({id:"restore",handler:this.restore.createDelegate(this,[]),hidden:true});this.header.on("dblclick",this.toggleMaximize,this)}if(this.closable){this.addTool({id:"close",handler:this[this.closeAction].createDelegate(this,[])})}},resizerAction:function(){var A=this.proxy.getBox();this.proxy.hide();this.window.handleResize(A);return A},beforeResize:function(){this.resizer.minHeight=Math.max(this.minHeight,this.getFrameHeight()+40);this.resizer.minWidth=Math.max(this.minWidth,this.getFrameWidth()+40);this.resizeBox=this.el.getBox()},updateHandles:function(){if(Ext.isIE&&this.resizer){this.resizer.syncHandleHeight();this.el.repaint()}},handleResize:function(B){var A=this.resizeBox;if(A.x!=B.x||A.y!=B.y){this.updateBox(B)}else{this.setSize(B)}this.focus();this.updateHandles();this.saveState();if(this.layout){this.doLayout()}this.fireEvent("resize",this,B.width,B.height)},focus:function(){var C=this.focusEl,A=this.defaultButton,B=typeof A;if(B!="undefined"){if(B=="number"){C=this.buttons[A]}else{if(B=="string"){C=Ext.getCmp(A)}else{C=A}}}C.focus.defer(10,C)},setAnimateTarget:function(A){A=Ext.get(A);this.animateTarget=A},beforeShow:function(){delete this.el.lastXY;delete this.el.lastLT;if(this.x===undefined||this.y===undefined){var A=this.el.getAlignToXY(this.container,"c-c");var B=this.el.translatePoints(A[0],A[1]);this.x=this.x===undefined?B.left:this.x;this.y=this.y===undefined?B.top:this.y}this.el.setLeftTop(this.x,this.y);if(this.expandOnShow){this.expand(false)}if(this.modal){Ext.getBody().addClass("x-body-masked");this.mask.setSize(Ext.lib.Dom.getViewWidth(true),Ext.lib.Dom.getViewHeight(true));this.mask.show()}},show:function(C,A,B){if(!this.rendered){this.render(Ext.getBody())}if(this.hidden===false){this.toFront();return }if(this.fireEvent("beforeshow",this)===false){return }if(A){this.on("show",A,B,{single:true})}this.hidden=false;if(C!==undefined){this.setAnimateTarget(C)}this.beforeShow();if(this.animateTarget){this.animShow()}else{this.afterShow()}},afterShow:function(){this.proxy.hide();this.el.setStyle("display","block");this.el.show();if(this.maximized){this.fitContainer()}if(Ext.isMac&&Ext.isGecko){this.cascade(this.setAutoScroll)}if(this.monitorResize||this.modal||this.constrain||this.constrainHeader){Ext.EventManager.onWindowResize(this.onWindowResize,this)}this.doConstrain();if(this.layout){this.doLayout()}if(this.keyMap){this.keyMap.enable()}this.toFront();this.updateHandles();this.fireEvent("show",this)},animShow:function(){this.proxy.show();this.proxy.setBox(this.animateTarget.getBox());this.proxy.setOpacity(0);var A=this.getBox(false);A.callback=this.afterShow;A.scope=this;A.duration=0.25;A.easing="easeNone";A.opacity=0.5;A.block=true;this.el.setStyle("display","none");this.proxy.shift(A)},hide:function(C,A,B){if(this.activeGhost){this.hide.defer(100,this,[C,A,B]);return }if(this.hidden||this.fireEvent("beforehide",this)===false){return }if(A){this.on("hide",A,B,{single:true})}this.hidden=true;if(C!==undefined){this.setAnimateTarget(C)}if(this.animateTarget){this.animHide()}else{this.el.hide();this.afterHide()}},afterHide:function(){this.proxy.hide();if(this.monitorResize||this.modal||this.constrain||this.constrainHeader){Ext.EventManager.removeResizeListener(this.onWindowResize,this)}if(this.modal){this.mask.hide();Ext.getBody().removeClass("x-body-masked")}if(this.keyMap){this.keyMap.disable()}this.fireEvent("hide",this)},animHide:function(){this.proxy.setOpacity(0.5);this.proxy.show();var B=this.getBox(false);this.proxy.setBox(B);this.el.hide();var A=this.animateTarget.getBox();A.callback=this.afterHide;A.scope=this;A.duration=0.25;A.easing="easeNone";A.block=true;A.opacity=0;this.proxy.shift(A)},onWindowResize:function(){if(this.maximized){this.fitContainer()}if(this.modal){this.mask.setSize("100%","100%");var A=this.mask.dom.offsetHeight;this.mask.setSize(Ext.lib.Dom.getViewWidth(true),Ext.lib.Dom.getViewHeight(true))}this.doConstrain()},doConstrain:function(){if(this.constrain||this.constrainHeader){var B;if(this.constrain){B={right:this.el.shadowOffset,left:this.el.shadowOffset,bottom:this.el.shadowOffset}}else{var A=this.getSize();B={right:-(A.width-100),bottom:-(A.height-25)}}var C=this.el.getConstrainToXY(this.container,true,B);if(C){this.setPosition(C[0],C[1])}}},ghost:function(A){var C=this.createGhost(A);var B=this.getBox(true);C.setLeftTop(B.x,B.y);C.setWidth(B.width);this.el.hide();this.activeGhost=C;return C},unghost:function(B,A){if(B!==false){this.el.show();this.focus();if(Ext.isMac&&Ext.isGecko){this.cascade(this.setAutoScroll)}}if(A!==false){this.setPosition(this.activeGhost.getLeft(true),this.activeGhost.getTop(true))}this.activeGhost.hide();this.activeGhost.remove();delete this.activeGhost},minimize:function(){this.fireEvent("minimize",this)},close:function(){if(this.fireEvent("beforeclose",this)!==false){this.hide(null,function(){this.fireEvent("close",this);this.destroy()},this)}},maximize:function(){if(!this.maximized){this.expand(false);this.restoreSize=this.getSize();this.restorePos=this.getPosition(true);if(this.maximizable){this.tools.maximize.hide();this.tools.restore.show()}this.maximized=true;this.el.disableShadow();if(this.dd){this.dd.lock()}if(this.collapsible){this.tools.toggle.hide()}this.el.addClass("x-window-maximized");this.container.addClass("x-window-maximized-ct");this.setPosition(0,0);this.fitContainer();this.fireEvent("maximize",this)}},restore:function(){if(this.maximized){this.el.removeClass("x-window-maximized");this.tools.restore.hide();this.tools.maximize.show();this.setPosition(this.restorePos[0],this.restorePos[1]);this.setSize(this.restoreSize.width,this.restoreSize.height);delete this.restorePos;delete this.restoreSize;this.maximized=false;this.el.enableShadow(true);if(this.dd){this.dd.unlock()}if(this.collapsible){this.tools.toggle.show()}this.container.removeClass("x-window-maximized-ct");this.doConstrain();this.fireEvent("restore",this)}},toggleMaximize:function(){this[this.maximized?"restore":"maximize"]()},fitContainer:function(){var A=this.container.getViewSize();this.setSize(A.width,A.height)},setZIndex:function(A){if(this.modal){this.mask.setStyle("z-index",A)}this.el.setZIndex(++A);A+=5;if(this.resizer){this.resizer.proxy.setStyle("z-index",++A)}this.lastZIndex=A},alignTo:function(B,A,C){var D=this.el.getAlignToXY(B,A,C);this.setPagePosition(D[0],D[1]);return this},anchorTo:function(C,G,D,B,F){var E=function(){this.alignTo(C,G,D)};Ext.EventManager.onWindowResize(E,this);var A=typeof B;if(A!="undefined"){Ext.EventManager.on(window,"scroll",E,this,{buffer:A=="number"?B:50})}E.call(this);this[F]=E;return this},toFront:function(){if(this.manager.bringToFront(this)){this.focus()}return this},setActive:function(A){if(A){if(!this.maximized){this.el.enableShadow(true)}this.fireEvent("activate",this)}else{this.el.disableShadow();this.fireEvent("deactivate",this)}},toBack:function(){this.manager.sendToBack(this);return this},center:function(){var A=this.el.getAlignToXY(this.container,"c-c");this.setPagePosition(A[0],A[1]);return this}});Ext.reg("window",Ext.Window);Ext.Window.DD=function(A){this.win=A;Ext.Window.DD.superclass.constructor.call(this,A.el.id,"WindowDD-"+A.id);this.setHandleElId(A.header.id);this.scroll=false};Ext.extend(Ext.Window.DD,Ext.dd.DD,{moveOnly:true,headerOffsets:[100,25],startDrag:function(){var A=this.win;this.proxy=A.ghost();if(A.constrain!==false){var C=A.el.shadowOffset;this.constrainTo(A.container,{right:C,left:C,bottom:C})}else{if(A.constrainHeader!==false){var B=this.proxy.getSize();this.constrainTo(A.container,{right:-(B.width-this.headerOffsets[0]),bottom:-(B.height-this.headerOffsets[1])})}}},b4Drag:Ext.emptyFn,onDrag:function(A){this.alignElWithMouse(this.proxy,A.getPageX(),A.getPageY())},endDrag:function(A){this.win.unghost();this.win.saveState()}});
Ext.WindowGroup=function(){var F={};var D=[];var E=null;var C=function(I,H){return(!I._lastAccess||I._lastAccess<H._lastAccess)?-1:1};var G=function(){var J=D,H=J.length;if(H>0){J.sort(C);var I=J[0].manager.zseed;for(var K=0;K<H;K++){var L=J[K];if(L&&!L.hidden){L.setZIndex(I+(K*10))}}}A()};var B=function(H){if(H!=E){if(E){E.setActive(false)}E=H;if(H){H.setActive(true)}}};var A=function(){for(var H=D.length-1;H>=0;--H){if(!D[H].hidden){B(D[H]);return }}B(null)};return{zseed:9000,register:function(H){F[H.id]=H;D.push(H);H.on("hide",A)},unregister:function(H){delete F[H.id];H.un("hide",A);D.remove(H)},get:function(H){return typeof H=="object"?H:F[H]},bringToFront:function(H){H=this.get(H);if(H!=E){H._lastAccess=new Date().getTime();G();return true}return false},sendToBack:function(H){H=this.get(H);H._lastAccess=-(new Date().getTime());G();return H},hideAll:function(){for(var H in F){if(F[H]&&typeof F[H]!="function"&&F[H].isVisible()){F[H].hide()}}},getActive:function(){return E},getBy:function(J,I){var K=[];for(var H=D.length-1;H>=0;--H){var L=D[H];if(J.call(I||L,L)!==false){K.push(L)}}return K},each:function(I,H){for(var J in F){if(F[J]&&typeof F[J]!="function"){if(I.call(H||F[J],F[J])===false){return }}}}}};Ext.WindowMgr=new Ext.WindowGroup();
Ext.dd.PanelProxy=function(A,B){this.panel=A;this.id=this.panel.id+"-ddproxy";Ext.apply(this,B)};Ext.dd.PanelProxy.prototype={insertProxy:true,setStatus:Ext.emptyFn,reset:Ext.emptyFn,update:Ext.emptyFn,stop:Ext.emptyFn,sync:Ext.emptyFn,getEl:function(){return this.ghost},getGhost:function(){return this.ghost},getProxy:function(){return this.proxy},hide:function(){if(this.ghost){if(this.proxy){this.proxy.remove();delete this.proxy}this.panel.el.dom.style.display="";this.ghost.remove();delete this.ghost}},show:function(){if(!this.ghost){this.ghost=this.panel.createGhost(undefined,undefined,Ext.getBody());this.ghost.setXY(this.panel.el.getXY());if(this.insertProxy){this.proxy=this.panel.el.insertSibling({cls:"x-panel-dd-spacer"});this.proxy.setSize(this.panel.getSize())}this.panel.el.dom.style.display="none"}},repair:function(B,C,A){this.hide();if(typeof C=="function"){C.call(A||this)}},moveProxy:function(A,B){if(this.proxy){A.insertBefore(this.proxy.dom,B)}}};Ext.Panel.DD=function(B,A){this.panel=B;this.dragData={panel:B};this.proxy=new Ext.dd.PanelProxy(B,A);Ext.Panel.DD.superclass.constructor.call(this,B.el,A);var C=B.header;if(C){this.setHandleElId(C.id)}(C?C:this.panel.body).setStyle("cursor","move");this.scroll=false};Ext.extend(Ext.Panel.DD,Ext.dd.DragSource,{showFrame:Ext.emptyFn,startDrag:Ext.emptyFn,b4StartDrag:function(A,B){this.proxy.show()},b4MouseDown:function(B){var A=B.getPageX();var C=B.getPageY();this.autoOffset(A,C)},onInitDrag:function(A,B){this.onStartDrag(A,B);return true},createFrame:Ext.emptyFn,getDragEl:function(A){return this.proxy.ghost.dom},endDrag:function(A){this.proxy.hide();this.panel.saveState()},autoOffset:function(A,B){A-=this.startPageX;B-=this.startPageY;this.setDelta(A,B)}});
Ext.state.Provider=function(){this.addEvents("statechange");this.state={};Ext.state.Provider.superclass.constructor.call(this)};Ext.extend(Ext.state.Provider,Ext.util.Observable,{get:function(B,A){return typeof this.state[B]=="undefined"?A:this.state[B]},clear:function(A){delete this.state[A];this.fireEvent("statechange",this,A,null)},set:function(A,B){this.state[A]=B;this.fireEvent("statechange",this,A,B)},decodeValue:function(A){var J=/^(a|n|d|b|s|o)\:(.*)$/;var C=J.exec(unescape(A));if(!C||!C[1]){return }var F=C[1];var H=C[2];switch(F){case"n":return parseFloat(H);case"d":return new Date(Date.parse(H));case"b":return(H=="1");case"a":var G=[];var I=H.split("^");for(var B=0,D=I.length;B<D;B++){G.push(this.decodeValue(I[B]))}return G;case"o":var G={};var I=H.split("^");for(var B=0,D=I.length;B<D;B++){var E=I[B].split("=");G[E[0]]=this.decodeValue(E[1])}return G;default:return H}},encodeValue:function(C){var B;if(typeof C=="number"){B="n:"+C}else{if(typeof C=="boolean"){B="b:"+(C?"1":"0")}else{if(Ext.isDate(C)){B="d:"+C.toGMTString()}else{if(Ext.isArray(C)){var F="";for(var E=0,A=C.length;E<A;E++){F+=this.encodeValue(C[E]);if(E!=A-1){F+="^"}}B="a:"+F}else{if(typeof C=="object"){var F="";for(var D in C){if(typeof C[D]!="function"&&C[D]!==undefined){F+=D+"="+this.encodeValue(C[D])+"^"}}B="o:"+F.substring(0,F.length-1)}else{B="s:"+C}}}}}return escape(B)}});
Ext.state.Manager=function(){var A=new Ext.state.Provider();return{setProvider:function(B){A=B},get:function(C,B){return A.get(C,B)},set:function(B,C){A.set(B,C)},clear:function(B){A.clear(B)},getProvider:function(){return A}}}();
Ext.state.CookieProvider=function(A){Ext.state.CookieProvider.superclass.constructor.call(this);this.path="/";this.expires=new Date(new Date().getTime()+(1000*60*60*24*7));this.domain=null;this.secure=false;Ext.apply(this,A);this.state=this.readCookies()};Ext.extend(Ext.state.CookieProvider,Ext.state.Provider,{set:function(A,B){if(typeof B=="undefined"||B===null){this.clear(A);return }this.setCookie(A,B);Ext.state.CookieProvider.superclass.set.call(this,A,B)},clear:function(A){this.clearCookie(A);Ext.state.CookieProvider.superclass.clear.call(this,A)},readCookies:function(){var C={};var F=document.cookie+";";var B=/\s?(.*?)=(.*?);/g;var E;while((E=B.exec(F))!=null){var A=E[1];var D=E[2];if(A&&A.substring(0,3)=="ys-"){C[A.substr(3)]=this.decodeValue(D)}}return C},setCookie:function(A,B){document.cookie="ys-"+A+"="+this.encodeValue(B)+((this.expires==null)?"":("; expires="+this.expires.toGMTString()))+((this.path==null)?"":("; path="+this.path))+((this.domain==null)?"":("; domain="+this.domain))+((this.secure==true)?"; secure":"")},clearCookie:function(A){document.cookie="ys-"+A+"=null; expires=Thu, 01-Jan-70 00:00:01 GMT"+((this.path==null)?"":("; path="+this.path))+((this.domain==null)?"":("; domain="+this.domain))+((this.secure==true)?"; secure":"")}});
Ext.DataView=Ext.extend(Ext.BoxComponent,{selectedClass:"x-view-selected",emptyText:"",deferEmptyText:true,trackOver:false,last:false,initComponent:function(){Ext.DataView.superclass.initComponent.call(this);if(typeof this.tpl=="string"){this.tpl=new Ext.XTemplate(this.tpl)}this.addEvents("beforeclick","click","mouseenter","mouseleave","containerclick","dblclick","contextmenu","selectionchange","beforeselect");this.all=new Ext.CompositeElementLite();this.selected=new Ext.CompositeElementLite()},onRender:function(){if(!this.el){this.el=document.createElement("div");this.el.id=this.id}Ext.DataView.superclass.onRender.apply(this,arguments)},afterRender:function(){Ext.DataView.superclass.afterRender.call(this);this.el.on({"click":this.onClick,"dblclick":this.onDblClick,"contextmenu":this.onContextMenu,scope:this});if(this.overClass||this.trackOver){this.el.on({"mouseover":this.onMouseOver,"mouseout":this.onMouseOut,scope:this})}if(this.store){this.setStore(this.store,true)}},refresh:function(){this.clearSelections(false,true);this.el.update("");var A=this.store.getRange();if(A.length<1){if(!this.deferEmptyText||this.hasSkippedEmptyText){this.el.update(this.emptyText)}this.hasSkippedEmptyText=true;this.all.clear();return }this.tpl.overwrite(this.el,this.collectData(A,0));this.all.fill(Ext.query(this.itemSelector,this.el.dom));this.updateIndexes(0)},prepareData:function(A){return A},collectData:function(B,E){var D=[];for(var C=0,A=B.length;C<A;C++){D[D.length]=this.prepareData(B[C].data,E+C,B[C])}return D},bufferRender:function(A){var B=document.createElement("div");this.tpl.overwrite(B,this.collectData(A));return Ext.query(this.itemSelector,B)},onUpdate:function(F,A){var B=this.store.indexOf(A);var E=this.isSelected(B);var C=this.all.elements[B];var D=this.bufferRender([A],B)[0];this.all.replaceElement(B,D,true);if(E){this.selected.replaceElement(C,D);this.all.item(B).addClass(this.selectedClass)}this.updateIndexes(B,B)},onAdd:function(E,C,D){if(this.all.getCount()==0){this.refresh();return }var B=this.bufferRender(C,D),F,A=this.all.elements;if(D<this.all.getCount()){F=this.all.item(D).insertSibling(B,"before",true);A.splice.apply(A,[D,0].concat(B))}else{F=this.all.last().insertSibling(B,"after",true);A.push.apply(A,B)}this.updateIndexes(D)},onRemove:function(C,A,B){this.deselect(B);this.all.removeElement(B,true);this.updateIndexes(B)},refreshNode:function(A){this.onUpdate(this.store,this.store.getAt(A))},updateIndexes:function(D,C){var B=this.all.elements;D=D||0;C=C||((C===0)?0:(B.length-1));for(var A=D;A<=C;A++){B[A].viewIndex=A}},setStore:function(A,B){if(!B&&this.store){this.store.un("beforeload",this.onBeforeLoad,this);this.store.un("datachanged",this.refresh,this);this.store.un("add",this.onAdd,this);this.store.un("remove",this.onRemove,this);this.store.un("update",this.onUpdate,this);this.store.un("clear",this.refresh,this)}if(A){A=Ext.StoreMgr.lookup(A);A.on("beforeload",this.onBeforeLoad,this);A.on("datachanged",this.refresh,this);A.on("add",this.onAdd,this);A.on("remove",this.onRemove,this);A.on("update",this.onUpdate,this);A.on("clear",this.refresh,this)}this.store=A;if(A){this.refresh()}},findItemFromChild:function(A){return Ext.fly(A).findParent(this.itemSelector,this.el)},onClick:function(C){var B=C.getTarget(this.itemSelector,this.el);if(B){var A=this.indexOf(B);if(this.onItemClick(B,A,C)!==false){this.fireEvent("click",this,A,B,C)}}else{if(this.fireEvent("containerclick",this,C)!==false){this.clearSelections()}}},onContextMenu:function(B){var A=B.getTarget(this.itemSelector,this.el);if(A){this.fireEvent("contextmenu",this,this.indexOf(A),A,B)}},onDblClick:function(B){var A=B.getTarget(this.itemSelector,this.el);if(A){this.fireEvent("dblclick",this,this.indexOf(A),A,B)}},onMouseOver:function(B){var A=B.getTarget(this.itemSelector,this.el);if(A&&A!==this.lastItem){this.lastItem=A;Ext.fly(A).addClass(this.overClass);this.fireEvent("mouseenter",this,this.indexOf(A),A,B)}},onMouseOut:function(A){if(this.lastItem){if(!A.within(this.lastItem,true)){Ext.fly(this.lastItem).removeClass(this.overClass);this.fireEvent("mouseleave",this,this.indexOf(this.lastItem),this.lastItem,A);delete this.lastItem}}},onItemClick:function(B,A,C){if(this.fireEvent("beforeclick",this,A,B,C)===false){return false}if(this.multiSelect){this.doMultiSelection(B,A,C);C.preventDefault()}else{if(this.singleSelect){this.doSingleSelection(B,A,C);C.preventDefault()}}return true},doSingleSelection:function(B,A,C){if(C.ctrlKey&&this.isSelected(A)){this.deselect(A)}else{this.select(A,false)}},doMultiSelection:function(C,A,D){if(D.shiftKey&&this.last!==false){var B=this.last;this.selectRange(B,A,D.ctrlKey);this.last=B}else{if((D.ctrlKey||this.simpleSelect)&&this.isSelected(A)){this.deselect(A)}else{this.select(A,D.ctrlKey||D.shiftKey||this.simpleSelect)}}},getSelectionCount:function(){return this.selected.getCount()},getSelectedNodes:function(){return this.selected.elements},getSelectedIndexes:function(){var B=[],D=this.selected.elements;for(var C=0,A=D.length;C<A;C++){B.push(D[C].viewIndex)}return B},getSelectedRecords:function(){var D=[],C=this.selected.elements;for(var B=0,A=C.length;B<A;B++){D[D.length]=this.store.getAt(C[B].viewIndex)}return D},getRecords:function(B){var E=[],D=B;for(var C=0,A=D.length;C<A;C++){E[E.length]=this.store.getAt(D[C].viewIndex)}return E},getRecord:function(A){return this.store.getAt(A.viewIndex)},clearSelections:function(A,B){if((this.multiSelect||this.singleSelect)&&this.selected.getCount()>0){if(!B){this.selected.removeClass(this.selectedClass)}this.selected.clear();this.last=false;if(!A){this.fireEvent("selectionchange",this,this.selected.elements)}}},isSelected:function(A){return this.selected.contains(this.getNode(A))},deselect:function(A){if(this.isSelected(A)){A=this.getNode(A);this.selected.removeElement(A);if(this.last==A.viewIndex){this.last=false}Ext.fly(A).removeClass(this.selectedClass);this.fireEvent("selectionchange",this,this.selected.elements)}},select:function(D,F,B){if(Ext.isArray(D)){if(!F){this.clearSelections(true)}for(var C=0,A=D.length;C<A;C++){this.select(D[C],true,true)}if(!B){this.fireEvent("selectionchange",this,this.selected.elements)}}else{var E=this.getNode(D);if(!F){this.clearSelections(true)}if(E&&!this.isSelected(E)){if(this.fireEvent("beforeselect",this,E,this.selected.elements)!==false){Ext.fly(E).addClass(this.selectedClass);this.selected.add(E);this.last=E.viewIndex;if(!B){this.fireEvent("selectionchange",this,this.selected.elements)}}}}},selectRange:function(C,A,B){if(!B){this.clearSelections(true)}this.select(this.getNodes(C,A),true)},getNode:function(A){if(typeof A=="string"){return document.getElementById(A)}else{if(typeof A=="number"){return this.all.elements[A]}}return A},getNodes:function(E,A){var D=this.all.elements;E=E||0;A=typeof A=="undefined"?Math.max(D.length-1,0):A;var B=[],C;if(E<=A){for(C=E;C<=A&&D[C];C++){B.push(D[C])}}else{for(C=E;C>=A&&D[C];C--){B.push(D[C])}}return B},indexOf:function(A){A=this.getNode(A);if(typeof A.viewIndex=="number"){return A.viewIndex}return this.all.indexOf(A)},onBeforeLoad:function(){if(this.loadingText){this.clearSelections(false,true);this.el.update("<div class=\"loading-indicator\">"+this.loadingText+"</div>");this.all.clear()}},onDestroy:function(){Ext.DataView.superclass.onDestroy.call(this);this.setStore(null)}});Ext.reg("dataview",Ext.DataView);
Ext.ColorPalette=function(A){Ext.ColorPalette.superclass.constructor.call(this,A);this.addEvents("select");if(this.handler){this.on("select",this.handler,this.scope,true)}};Ext.extend(Ext.ColorPalette,Ext.Component,{itemCls:"x-color-palette",value:null,clickEvent:"click",ctype:"Ext.ColorPalette",allowReselect:false,colors:["000000","993300","333300","003300","003366","000080","333399","333333","800000","FF6600","808000","008000","008080","0000FF","666699","808080","FF0000","FF9900","99CC00","339966","33CCCC","3366FF","800080","969696","FF00FF","FFCC00","FFFF00","00FF00","00FFFF","00CCFF","993366","C0C0C0","FF99CC","FFCC99","FFFF99","CCFFCC","CCFFFF","99CCFF","CC99FF","FFFFFF"],onRender:function(B,A){var C=this.tpl||new Ext.XTemplate("<tpl for=\".\"><a href=\"#\" class=\"color-{.}\" hidefocus=\"on\"><em><span style=\"background:#{.}\" unselectable=\"on\">&#160;</span></em></a></tpl>");var D=document.createElement("div");D.className=this.itemCls;C.overwrite(D,this.colors);B.dom.insertBefore(D,A);this.el=Ext.get(D);this.el.on(this.clickEvent,this.handleClick,this,{delegate:"a"});if(this.clickEvent!="click"){this.el.on("click",Ext.emptyFn,this,{delegate:"a",preventDefault:true})}},afterRender:function(){Ext.ColorPalette.superclass.afterRender.call(this);if(this.value){var A=this.value;this.value=null;this.select(A)}},handleClick:function(B,A){B.preventDefault();if(!this.disabled){var C=A.className.match(/(?:^|\s)color-(.{6})(?:\s|$)/)[1];this.select(C.toUpperCase())}},select:function(A){A=A.replace("#","");if(A!=this.value||this.allowReselect){var B=this.el;if(this.value){B.child("a.color-"+this.value).removeClass("x-color-palette-sel")}B.child("a.color-"+A).addClass("x-color-palette-sel");this.value=A;this.fireEvent("select",this,A)}}});Ext.reg("colorpalette",Ext.ColorPalette);
Ext.DatePicker=Ext.extend(Ext.Component,{todayText:"Today",okText:"&#160;OK&#160;",cancelText:"Cancel",todayTip:"{0} (Spacebar)",minText:"This date is before the minimum date",maxText:"This date is after the maximum date",format:"m/d/y",disabledDaysText:"Disabled",disabledDatesText:"Disabled",constrainToViewport:true,monthNames:Date.monthNames,dayNames:Date.dayNames,nextText:"Next Month (Control+Right)",prevText:"Previous Month (Control+Left)",monthYearText:"Choose a month (Control+Up/Down to move years)",startDay:0,showToday:true,initComponent:function(){Ext.DatePicker.superclass.initComponent.call(this);this.value=this.value?this.value.clearTime():new Date().clearTime();this.addEvents("select");if(this.handler){this.on("select",this.handler,this.scope||this)}this.initDisabledDays()},initDisabledDays:function(){if(!this.disabledDatesRE&&this.disabledDates){var A=this.disabledDates;var C="(?:";for(var B=0;B<A.length;B++){C+=A[B];if(B!=A.length-1){C+="|"}}this.disabledDatesRE=new RegExp(C+")")}},setDisabledDates:function(A){if(Ext.isArray(A)){this.disabledDates=A;this.disabledDatesRE=null}else{this.disabledDatesRE=A}this.initDisabledDays();this.update(this.value,true)},setDisabledDays:function(A){this.disabledDays=A;this.update(this.value,true)},setMinDate:function(A){this.minDate=A;this.update(this.value,true)},setMaxDate:function(A){this.maxDate=A;this.update(this.value,true)},setValue:function(B){var A=this.value;this.value=B.clearTime(true);if(this.el){this.update(this.value)}},getValue:function(){return this.value},focus:function(){if(this.el){this.update(this.activeDate)}},onRender:function(A,F){var C=["<table cellspacing=\"0\">","<tr><td class=\"x-date-left\"><a href=\"#\" title=\"",this.prevText,"\">&#160;</a></td><td class=\"x-date-middle\" align=\"center\"></td><td class=\"x-date-right\"><a href=\"#\" title=\"",this.nextText,"\">&#160;</a></td></tr>","<tr><td colspan=\"3\"><table class=\"x-date-inner\" cellspacing=\"0\"><thead><tr>"];var E=this.dayNames;for(var D=0;D<7;D++){var G=parseInt(this.startDay+D);while(G>6){G=G-7}C.push("<th><span>",(E[G]&&E[G].length>0?E[G].substr(0,1):' '),"</span></th>")}C[C.length]="</tr></thead><tbody><tr>";for(var D=0;D<42;D++){if(D%7==0&&D!=0){C[C.length]="</tr><tr>"}C[C.length]="<td><a href=\"#\" hidefocus=\"on\" class=\"x-date-date\" tabIndex=\"1\"><em><span></span></em></a></td>"}C.push("</tr></tbody></table></td></tr>",this.showToday?"<tr><td colspan=\"3\" class=\"x-date-bottom\" align=\"center\"></td></tr>":"","</table><div class=\"x-date-mp\"></div>");var B=document.createElement("div");B.className="x-date-picker";B.innerHTML=C.join("");A.dom.insertBefore(B,F);this.el=Ext.get(B);this.eventEl=Ext.get(B.firstChild);new Ext.util.ClickRepeater(this.el.child("td.x-date-left a"),{handler:this.showPrevMonth,scope:this,preventDefault:true,stopDefault:true});new Ext.util.ClickRepeater(this.el.child("td.x-date-right a"),{handler:this.showNextMonth,scope:this,preventDefault:true,stopDefault:true});this.eventEl.on("mousewheel",this.handleMouseWheel,this);this.monthPicker=this.el.down("div.x-date-mp");this.monthPicker.enableDisplayMode("block");var I=new Ext.KeyNav(this.eventEl,{"left":function(J){J.ctrlKey?this.showPrevMonth():this.update(this.activeDate.add("d",-1))},"right":function(J){J.ctrlKey?this.showNextMonth():this.update(this.activeDate.add("d",1))},"up":function(J){J.ctrlKey?this.showNextYear():this.update(this.activeDate.add("d",-7))},"down":function(J){J.ctrlKey?this.showPrevYear():this.update(this.activeDate.add("d",7))},"pageUp":function(J){this.showNextMonth()},"pageDown":function(J){this.showPrevMonth()},"enter":function(J){J.stopPropagation();return true},scope:this});this.eventEl.on("click",this.handleDateClick,this,{delegate:"a.x-date-date"});this.el.unselectable();this.cells=this.el.select("table.x-date-inner tbody td");this.textNodes=this.el.query("table.x-date-inner tbody span");this.mbtn=new Ext.Button({text:"&#160;",tooltip:this.monthYearText,renderTo:this.el.child("td.x-date-middle",true)});this.mbtn.on("click",this.showMonthPicker,this);this.mbtn.el.child(this.mbtn.menuClassTarget).addClass("x-btn-with-menu");if(this.showToday){this.todayKeyListener=this.eventEl.addKeyListener(Ext.EventObject.SPACE,this.selectToday,this);var H=(new Date()).dateFormat(this.format);this.todayBtn=new Ext.Button({renderTo:this.el.child("td.x-date-bottom",true),text:String.format(this.todayText,H),tooltip:String.format(this.todayTip,H),handler:this.selectToday,scope:this})}if(Ext.isIE){this.el.repaint()}this.update(this.value)},createMonthPicker:function(){if(!this.monthPicker.dom.firstChild){var A=["<table border=\"0\" cellspacing=\"0\">"];for(var B=0;B<6;B++){A.push("<tr><td class=\"x-date-mp-month\"><a href=\"#\">",this.monthNames[B].substr(0,3),"</a></td>","<td class=\"x-date-mp-month x-date-mp-sep\"><a href=\"#\">",this.monthNames[B+6].substr(0,3),"</a></td>",B==0?"<td class=\"x-date-mp-ybtn\" align=\"center\"><a class=\"x-date-mp-prev\"></a></td><td class=\"x-date-mp-ybtn\" align=\"center\"><a class=\"x-date-mp-next\"></a></td></tr>":"<td class=\"x-date-mp-year\"><a href=\"#\"></a></td><td class=\"x-date-mp-year\"><a href=\"#\"></a></td></tr>")}A.push("<tr class=\"x-date-mp-btns\"><td colspan=\"4\"><button type=\"button\" class=\"x-date-mp-ok\">",this.okText,"</button><button type=\"button\" class=\"x-date-mp-cancel\">",this.cancelText,"</button></td></tr>","</table>");this.monthPicker.update(A.join(""));this.monthPicker.on("click",this.onMonthClick,this);this.monthPicker.on("dblclick",this.onMonthDblClick,this);this.mpMonths=this.monthPicker.select("td.x-date-mp-month");this.mpYears=this.monthPicker.select("td.x-date-mp-year");this.mpMonths.each(function(C,D,E){E+=1;if((E%2)==0){C.dom.xmonth=5+Math.round(E*0.5)}else{C.dom.xmonth=Math.round((E-1)*0.5)}})}},showMonthPicker:function(){this.createMonthPicker();var A=this.el.getSize();this.monthPicker.setSize(A);this.monthPicker.child("table").setSize(A);this.mpSelMonth=(this.activeDate||this.value).getMonth();this.updateMPMonth(this.mpSelMonth);this.mpSelYear=(this.activeDate||this.value).getFullYear();this.updateMPYear(this.mpSelYear);this.monthPicker.slideIn("t",{duration:0.2})},updateMPYear:function(E){this.mpyear=E;var C=this.mpYears.elements;for(var B=1;B<=10;B++){var D=C[B-1],A;if((B%2)==0){A=E+Math.round(B*0.5);D.firstChild.innerHTML=A;D.xyear=A}else{A=E-(5-Math.round(B*0.5));D.firstChild.innerHTML=A;D.xyear=A}this.mpYears.item(B-1)[A==this.mpSelYear?"addClass":"removeClass"]("x-date-mp-sel")}},updateMPMonth:function(A){this.mpMonths.each(function(B,C,D){B[B.dom.xmonth==A?"addClass":"removeClass"]("x-date-mp-sel")})},selectMPMonth:function(A){},onMonthClick:function(D,B){D.stopEvent();var C=new Ext.Element(B),A;if(C.is("button.x-date-mp-cancel")){this.hideMonthPicker()}else{if(C.is("button.x-date-mp-ok")){var E=new Date(this.mpSelYear,this.mpSelMonth,(this.activeDate||this.value).getDate());if(E.getMonth()!=this.mpSelMonth){E=new Date(this.mpSelYear,this.mpSelMonth,1).getLastDateOfMonth()}this.update(E);this.hideMonthPicker()}else{if(A=C.up("td.x-date-mp-month",2)){this.mpMonths.removeClass("x-date-mp-sel");A.addClass("x-date-mp-sel");this.mpSelMonth=A.dom.xmonth}else{if(A=C.up("td.x-date-mp-year",2)){this.mpYears.removeClass("x-date-mp-sel");A.addClass("x-date-mp-sel");this.mpSelYear=A.dom.xyear}else{if(C.is("a.x-date-mp-prev")){this.updateMPYear(this.mpyear-10)}else{if(C.is("a.x-date-mp-next")){this.updateMPYear(this.mpyear+10)}}}}}}},onMonthDblClick:function(D,B){D.stopEvent();var C=new Ext.Element(B),A;if(A=C.up("td.x-date-mp-month",2)){this.update(new Date(this.mpSelYear,A.dom.xmonth,(this.activeDate||this.value).getDate()));this.hideMonthPicker()}else{if(A=C.up("td.x-date-mp-year",2)){this.update(new Date(A.dom.xyear,this.mpSelMonth,(this.activeDate||this.value).getDate()));this.hideMonthPicker()}}},hideMonthPicker:function(A){if(this.monthPicker){if(A===true){this.monthPicker.hide()}else{this.monthPicker.slideOut("t",{duration:0.2})}}},showPrevMonth:function(A){this.update(this.activeDate.add("mo",-1))},showNextMonth:function(A){this.update(this.activeDate.add("mo",1))},showPrevYear:function(){this.update(this.activeDate.add("y",-1))},showNextYear:function(){this.update(this.activeDate.add("y",1))},handleMouseWheel:function(A){var B=A.getWheelDelta();if(B>0){this.showPrevMonth();A.stopEvent()}else{if(B<0){this.showNextMonth();A.stopEvent()}}},handleDateClick:function(B,A){B.stopEvent();if(A.dateValue&&!Ext.fly(A.parentNode).hasClass("x-date-disabled")){this.setValue(new Date(A.dateValue));this.fireEvent("select",this,this.value)}},selectToday:function(){if(this.todayBtn&&!this.todayBtn.disabled){this.setValue(new Date().clearTime());this.fireEvent("select",this,this.value)}},update:function(a,U){var A=this.activeDate;this.activeDate=a;if(!U&&A&&this.el){var K=a.getTime();if(A.getMonth()==a.getMonth()&&A.getFullYear()==a.getFullYear()){this.cells.removeClass("x-date-selected");this.cells.each(function(d){if(d.dom.firstChild.dateValue==K){d.addClass("x-date-selected");setTimeout(function(){try{d.dom.firstChild.focus()}catch(f){}},50);return false}});return }}var G=a.getDaysInMonth();var L=a.getFirstDateOfMonth();var D=L.getDay()-this.startDay;if(D<=this.startDay){D+=7}var V=a.add("mo",-1);var E=V.getDaysInMonth()-D;var C=this.cells.elements;var M=this.textNodes;G+=D;var R=86400000;var X=(new Date(V.getFullYear(),V.getMonth(),E)).clearTime();var W=new Date().clearTime().getTime();var P=a.clearTime().getTime();var O=this.minDate?this.minDate.clearTime():Number.NEGATIVE_INFINITY;var S=this.maxDate?this.maxDate.clearTime():Number.POSITIVE_INFINITY;var Z=this.disabledDatesRE;var N=this.disabledDatesText;var c=this.disabledDays?this.disabledDays.join(""):false;var Y=this.disabledDaysText;var T=this.format;if(this.showToday){var I=new Date().clearTime();var B=(I<O||I>S||(Z&&T&&Z.test(I.dateFormat(T)))||(c&&c.indexOf(I.getDay())!=-1));this.todayBtn.setDisabled(B);this.todayKeyListener[B?"disable":"enable"]()}var H=function(g,d){d.title="";var e=X.getTime();d.firstChild.dateValue=e;if(e==W){d.className+=" x-date-today";d.title=g.todayText}if(e==P){d.className+=" x-date-selected";setTimeout(function(){try{d.firstChild.focus()}catch(h){}},50)}if(e<O){d.className=" x-date-disabled";d.title=g.minText;return }if(e>S){d.className=" x-date-disabled";d.title=g.maxText;return }if(c){if(c.indexOf(X.getDay())!=-1){d.title=Y;d.className=" x-date-disabled"}}if(Z&&T){var f=X.dateFormat(T);if(Z.test(f)){d.title=N.replace("%0",f);d.className=" x-date-disabled"}}};var Q=0;for(;Q<D;Q++){M[Q].innerHTML=(++E);X.setDate(X.getDate()+1);C[Q].className="x-date-prevday";H(this,C[Q])}for(;Q<G;Q++){intDay=Q-D+1;M[Q].innerHTML=(intDay);X.setDate(X.getDate()+1);C[Q].className="x-date-active";H(this,C[Q])}var b=0;for(;Q<42;Q++){M[Q].innerHTML=(++b);X.setDate(X.getDate()+1);C[Q].className="x-date-nextday";H(this,C[Q])}this.mbtn.setText(this.monthNames[a.getMonth()]+" "+a.getFullYear());if(!this.internalRender){var F=this.el.dom.firstChild;var J=F.offsetWidth;this.el.setWidth(J+this.el.getBorderWidth("lr"));Ext.fly(F).setWidth(J);this.internalRender=true;if(Ext.isOpera&&!this.secondPass){F.rows[0].cells[1].style.width=(J-(F.rows[0].cells[0].offsetWidth+F.rows[0].cells[2].offsetWidth))+"px";this.secondPass=true;this.update.defer(10,this,[a])}}},beforeDestroy:function(){if(this.rendered){Ext.destroy(this.mbtn,this.todayBtn)}}});Ext.reg("datepicker",Ext.DatePicker);
Ext.TabPanel=Ext.extend(Ext.Panel,{monitorResize:true,deferredRender:true,tabWidth:120,minTabWidth:30,resizeTabs:false,enableTabScroll:false,scrollIncrement:0,scrollRepeatInterval:400,scrollDuration:0.35,animScroll:true,tabPosition:"top",baseCls:"x-tab-panel",autoTabs:false,autoTabSelector:"div.x-tab",activeTab:null,tabMargin:2,plain:false,wheelIncrement:20,idDelimiter:"__",itemCls:"x-tab-item",elements:"body",headerAsText:false,frame:false,hideBorders:true,initComponent:function(){this.frame=false;Ext.TabPanel.superclass.initComponent.call(this);this.addEvents("beforetabchange","tabchange","contextmenu");this.setLayout(new Ext.layout.CardLayout({deferredRender:this.deferredRender}));if(this.tabPosition=="top"){this.elements+=",header";this.stripTarget="header"}else{this.elements+=",footer";this.stripTarget="footer"}if(!this.stack){this.stack=Ext.TabPanel.AccessStack()}this.initItems()},render:function(){Ext.TabPanel.superclass.render.apply(this,arguments);if(this.activeTab!==undefined){var A=this.activeTab;delete this.activeTab;this.setActiveTab(A)}},onRender:function(C,A){Ext.TabPanel.superclass.onRender.call(this,C,A);if(this.plain){var F=this.tabPosition=="top"?"header":"footer";this[F].addClass("x-tab-panel-"+F+"-plain")}var B=this[this.stripTarget];this.stripWrap=B.createChild({cls:"x-tab-strip-wrap",cn:{tag:"ul",cls:"x-tab-strip x-tab-strip-"+this.tabPosition}});var E=(this.tabPosition=="bottom"?this.stripWrap:null);this.stripSpacer=B.createChild({cls:"x-tab-strip-spacer"},E);this.strip=new Ext.Element(this.stripWrap.dom.firstChild);this.edge=this.strip.createChild({tag:"li",cls:"x-tab-edge"});this.strip.createChild({cls:"x-clear"});this.body.addClass("x-tab-panel-body-"+this.tabPosition);if(!this.itemTpl){var D=new Ext.Template("<li class=\"{cls}\" id=\"{id}\"><a class=\"x-tab-strip-close\" onclick=\"return false;\"></a>","<a class=\"x-tab-right\" href=\"#\" onclick=\"return false;\"><em class=\"x-tab-left\">","<span class=\"x-tab-strip-inner\"><span class=\"x-tab-strip-text {iconCls}\">{text}</span></span>","</em></a></li>");D.disableFormats=true;D.compile();Ext.TabPanel.prototype.itemTpl=D}this.items.each(this.initTab,this)},afterRender:function(){Ext.TabPanel.superclass.afterRender.call(this);if(this.autoTabs){this.readTabs(false)}},initEvents:function(){Ext.TabPanel.superclass.initEvents.call(this);this.on("add",this.onAdd,this);this.on("remove",this.onRemove,this);this.strip.on("mousedown",this.onStripMouseDown,this);this.strip.on("contextmenu",this.onStripContextMenu,this);if(this.enableTabScroll){this.strip.on("mousewheel",this.onWheel,this)}},findTargets:function(C){var B=null;var A=C.getTarget("li",this.strip);if(A){B=this.getComponent(A.id.split(this.idDelimiter)[1]);if(B.disabled){return{close:null,item:null,el:null}}}return{close:C.getTarget(".x-tab-strip-close",this.strip),item:B,el:A}},onStripMouseDown:function(B){if(B.button!=0){return }B.preventDefault();var A=this.findTargets(B);if(A.close){this.remove(A.item);return }if(A.item&&A.item!=this.activeTab){this.setActiveTab(A.item)}},onStripContextMenu:function(B){B.preventDefault();var A=this.findTargets(B);if(A.item){this.fireEvent("contextmenu",this,A.item,B)}},readTabs:function(D){if(D===true){this.items.each(function(G){this.remove(G)},this)}var C=this.el.query(this.autoTabSelector);for(var B=0,A=C.length;B<A;B++){var E=C[B];var F=E.getAttribute("title");E.removeAttribute("title");this.add({title:F,el:E})}},initTab:function(D,B){var E=this.strip.dom.childNodes[B];var A=D.closable?"x-tab-strip-closable":"";if(D.disabled){A+=" x-item-disabled"}if(D.iconCls){A+=" x-tab-with-icon"}if(D.tabCls){A+=" "+D.tabCls}var F={id:this.id+this.idDelimiter+D.getItemId(),text:D.title,cls:A,iconCls:D.iconCls||""};var C=E?this.itemTpl.insertBefore(E,F):this.itemTpl.append(this.strip,F);Ext.fly(C).addClassOnOver("x-tab-strip-over");if(D.tabTip){Ext.fly(C).child("span.x-tab-strip-text",true).qtip=D.tabTip}D.on("disable",this.onItemDisabled,this);D.on("enable",this.onItemEnabled,this);D.on("titlechange",this.onItemTitleChanged,this);D.on("beforeshow",this.onBeforeShowItem,this)},onAdd:function(C,B,A){this.initTab(B,A);if(this.items.getCount()==1){this.syncSize()}this.delegateUpdates()},onBeforeAdd:function(B){var A=B.events?(this.items.containsKey(B.getItemId())?B:null):this.items.get(B);if(A){this.setActiveTab(B);return false}Ext.TabPanel.superclass.onBeforeAdd.apply(this,arguments);var C=B.elements;B.elements=C?C.replace(",header",""):C;B.border=(B.border===true)},onRemove:function(C,B){Ext.removeNode(this.getTabEl(B));this.stack.remove(B);B.un("disable",this.onItemDisabled,this);B.un("enable",this.onItemEnabled,this);B.un("titlechange",this.onItemTitleChanged,this);B.un("beforeshow",this.onBeforeShowItem,this);if(B==this.activeTab){var A=this.stack.next();if(A){this.setActiveTab(A)}else{this.setActiveTab(0)}}this.delegateUpdates()},onBeforeShowItem:function(A){if(A!=this.activeTab){this.setActiveTab(A);return false}},onItemDisabled:function(B){var A=this.getTabEl(B);if(A){Ext.fly(A).addClass("x-item-disabled")}this.stack.remove(B)},onItemEnabled:function(B){var A=this.getTabEl(B);if(A){Ext.fly(A).removeClass("x-item-disabled")}},onItemTitleChanged:function(B){var A=this.getTabEl(B);if(A){Ext.fly(A).child("span.x-tab-strip-text",true).innerHTML=B.title}},getTabEl:function(A){var B=(typeof A==="number")?this.items.items[A].getItemId():A.getItemId();return document.getElementById(this.id+this.idDelimiter+B)},onResize:function(){Ext.TabPanel.superclass.onResize.apply(this,arguments);this.delegateUpdates()},beginUpdate:function(){this.suspendUpdates=true},endUpdate:function(){this.suspendUpdates=false;this.delegateUpdates()},hideTabStripItem:function(B){B=this.getComponent(B);var A=this.getTabEl(B);if(A){A.style.display="none";this.delegateUpdates()}this.stack.remove(B)},unhideTabStripItem:function(B){B=this.getComponent(B);var A=this.getTabEl(B);if(A){A.style.display="";this.delegateUpdates()}},delegateUpdates:function(){if(this.suspendUpdates){return }if(this.resizeTabs&&this.rendered){this.autoSizeTabs()}if(this.enableTabScroll&&this.rendered){this.autoScrollTabs()}},autoSizeTabs:function(){var G=this.items.length;var B=this.tabPosition!="bottom"?"header":"footer";var C=this[B].dom.offsetWidth;var A=this[B].dom.clientWidth;if(!this.resizeTabs||G<1||!A){return }var I=Math.max(Math.min(Math.floor((A-4)/G)-this.tabMargin,this.tabWidth),this.minTabWidth);this.lastTabWidth=I;var K=this.stripWrap.dom.getElementsByTagName("li");for(var E=0,H=K.length-1;E<H;E++){var J=K[E];var L=J.childNodes[1].firstChild.firstChild;var F=J.offsetWidth;var D=L.offsetWidth;L.style.width=(I-(F-D))+"px"}},adjustBodyWidth:function(A){if(this.header){this.header.setWidth(A)}if(this.footer){this.footer.setWidth(A)}return A},setActiveTab:function(C){C=this.getComponent(C);if(!C||this.fireEvent("beforetabchange",this,C,this.activeTab)===false){return }if(!this.rendered){this.activeTab=C;return }if(this.activeTab!=C){if(this.activeTab){var A=this.getTabEl(this.activeTab);if(A){Ext.fly(A).removeClass("x-tab-strip-active")}this.activeTab.fireEvent("deactivate",this.activeTab)}var B=this.getTabEl(C);Ext.fly(B).addClass("x-tab-strip-active");this.activeTab=C;this.stack.add(C);this.layout.setActiveItem(C);if(this.layoutOnTabChange&&C.doLayout){C.doLayout()}if(this.scrolling){this.scrollToTab(C,this.animScroll)}C.fireEvent("activate",C);this.fireEvent("tabchange",this,C)}},getActiveTab:function(){return this.activeTab||null},getItem:function(A){return this.getComponent(A)},autoScrollTabs:function(){var G=this.items.length;var D=this.header.dom.offsetWidth;var C=this.header.dom.clientWidth;var F=this.stripWrap;var E=F.dom;var B=E.offsetWidth;var H=this.getScrollPos();var A=this.edge.getOffsetsTo(this.stripWrap)[0]+H;if(!this.enableTabScroll||G<1||B<20){return }if(A<=C){E.scrollLeft=0;F.setWidth(C);if(this.scrolling){this.scrolling=false;this.header.removeClass("x-tab-scrolling");this.scrollLeft.hide();this.scrollRight.hide();if(Ext.isAir){E.style.marginLeft="";E.style.marginRight=""}}}else{if(!this.scrolling){this.header.addClass("x-tab-scrolling");if(Ext.isAir){E.style.marginLeft="18px";E.style.marginRight="18px"}}C-=F.getMargins("lr");F.setWidth(C>20?C:20);if(!this.scrolling){if(!this.scrollLeft){this.createScrollers()}else{this.scrollLeft.show();this.scrollRight.show()}}this.scrolling=true;if(H>(A-C)){E.scrollLeft=A-C}else{this.scrollToTab(this.activeTab,false)}this.updateScrollButtons()}},createScrollers:function(){var C=this.stripWrap.dom.offsetHeight;var A=this.header.insertFirst({cls:"x-tab-scroller-left"});A.setHeight(C);A.addClassOnOver("x-tab-scroller-left-over");this.leftRepeater=new Ext.util.ClickRepeater(A,{interval:this.scrollRepeatInterval,handler:this.onScrollLeft,scope:this});this.scrollLeft=A;var B=this.header.insertFirst({cls:"x-tab-scroller-right"});B.setHeight(C);B.addClassOnOver("x-tab-scroller-right-over");this.rightRepeater=new Ext.util.ClickRepeater(B,{interval:this.scrollRepeatInterval,handler:this.onScrollRight,scope:this});this.scrollRight=B},getScrollWidth:function(){return this.edge.getOffsetsTo(this.stripWrap)[0]+this.getScrollPos()},getScrollPos:function(){return parseInt(this.stripWrap.dom.scrollLeft,10)||0},getScrollArea:function(){return parseInt(this.stripWrap.dom.clientWidth,10)||0},getScrollAnim:function(){return{duration:this.scrollDuration,callback:this.updateScrollButtons,scope:this}},getScrollIncrement:function(){return this.scrollIncrement||(this.resizeTabs?this.lastTabWidth+2:100)},scrollToTab:function(E,A){if(!E){return }var C=this.getTabEl(E);var G=this.getScrollPos(),D=this.getScrollArea();var F=Ext.fly(C).getOffsetsTo(this.stripWrap)[0]+G;var B=F+C.offsetWidth;if(F<G){this.scrollTo(F,A)}else{if(B>(G+D)){this.scrollTo(B-D,A)}}},scrollTo:function(B,A){this.stripWrap.scrollTo("left",B,A?this.getScrollAnim():false);if(!A){this.updateScrollButtons()}},onWheel:function(D){var E=D.getWheelDelta()*this.wheelIncrement*-1;D.stopEvent();var F=this.getScrollPos();var C=F+E;var A=this.getScrollWidth()-this.getScrollArea();var B=Math.max(0,Math.min(A,C));if(B!=F){this.scrollTo(B,false)}},onScrollRight:function(){var A=this.getScrollWidth()-this.getScrollArea();var C=this.getScrollPos();var B=Math.min(A,C+this.getScrollIncrement());if(B!=C){this.scrollTo(B,this.animScroll)}},onScrollLeft:function(){var B=this.getScrollPos();var A=Math.max(0,B-this.getScrollIncrement());if(A!=B){this.scrollTo(A,this.animScroll)}},updateScrollButtons:function(){var A=this.getScrollPos();this.scrollLeft[A==0?"addClass":"removeClass"]("x-tab-scroller-left-disabled");this.scrollRight[A>=(this.getScrollWidth()-this.getScrollArea())?"addClass":"removeClass"]("x-tab-scroller-right-disabled")}});Ext.reg("tabpanel",Ext.TabPanel);Ext.TabPanel.prototype.activate=Ext.TabPanel.prototype.setActiveTab;Ext.TabPanel.AccessStack=function(){var A=[];return{add:function(B){A.push(B);if(A.length>10){A.shift()}},remove:function(E){var D=[];for(var C=0,B=A.length;C<B;C++){if(A[C]!=E){D.push(A[C])}}A=D},next:function(){return A.pop()}}};
Ext.Button=Ext.extend(Ext.Component,{hidden:false,disabled:false,pressed:false,enableToggle:false,menuAlign:"tl-bl?",type:"button",menuClassTarget:"tr",clickEvent:"click",handleMouseEvents:true,tooltipType:"qtip",buttonSelector:"button:first",initComponent:function(){Ext.Button.superclass.initComponent.call(this);this.addEvents("click","toggle","mouseover","mouseout","menushow","menuhide","menutriggerover","menutriggerout");if(this.menu){this.menu=Ext.menu.MenuMgr.get(this.menu)}if(typeof this.toggleGroup==="string"){this.enableToggle=true}},onRender:function(C,A){if(!this.template){if(!Ext.Button.buttonTemplate){Ext.Button.buttonTemplate=new Ext.Template("<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"x-btn-wrap\"><tbody><tr>","<td class=\"x-btn-left\"><i>&#160;</i></td><td class=\"x-btn-center\"><em unselectable=\"on\"><button class=\"x-btn-text\" type=\"{1}\">{0}</button></em></td><td class=\"x-btn-right\"><i>&#160;</i></td>","</tr></tbody></table>")}this.template=Ext.Button.buttonTemplate}var B,E=[this.text||"&#160;",this.type];if(A){B=this.template.insertBefore(A,E,true)}else{B=this.template.append(C,E,true)}var D=B.child(this.buttonSelector);D.on("focus",this.onFocus,this);D.on("blur",this.onBlur,this);this.initButtonEl(B,D);if(this.menu){this.el.child(this.menuClassTarget).addClass("x-btn-with-menu")}Ext.ButtonToggleMgr.register(this)},initButtonEl:function(B,C){this.el=B;B.addClass("x-btn");if(this.icon){C.setStyle("background-image","url("+this.icon+")")}if(this.iconCls){C.addClass(this.iconCls);if(!this.cls){B.addClass(this.text?"x-btn-text-icon":"x-btn-icon")}}if(this.tabIndex!==undefined){C.dom.tabIndex=this.tabIndex}if(this.tooltip){if(typeof this.tooltip=="object"){Ext.QuickTips.register(Ext.apply({target:C.id},this.tooltip))}else{C.dom[this.tooltipType]=this.tooltip}}if(this.pressed){this.el.addClass("x-btn-pressed")}if(this.handleMouseEvents){B.on("mouseover",this.onMouseOver,this);B.on("mousedown",this.onMouseDown,this)}if(this.menu){this.menu.on("show",this.onMenuShow,this);this.menu.on("hide",this.onMenuHide,this)}if(this.id){this.el.dom.id=this.el.id=this.id}if(this.repeat){var A=new Ext.util.ClickRepeater(B,typeof this.repeat=="object"?this.repeat:{});A.on("click",this.onClick,this)}B.on(this.clickEvent,this.onClick,this)},afterRender:function(){Ext.Button.superclass.afterRender.call(this);if(Ext.isIE6){this.autoWidth.defer(1,this)}else{this.autoWidth()}},setIconClass:function(A){if(this.el){this.el.child(this.buttonSelector).replaceClass(this.iconCls,A)}this.iconCls=A},beforeDestroy:function(){if(this.rendered){var A=this.el.child(this.buttonSelector);if(A){A.removeAllListeners()}}if(this.menu){Ext.destroy(this.menu)}},onDestroy:function(){if(this.rendered){Ext.ButtonToggleMgr.unregister(this)}},autoWidth:function(){if(this.el){this.el.setWidth("auto");if(Ext.isIE7&&Ext.isStrict){var A=this.el.child(this.buttonSelector);if(A&&A.getWidth()>20){A.clip();A.setWidth(Ext.util.TextMetrics.measure(A,this.text).width+A.getFrameWidth("lr"))}}if(this.minWidth){if(this.el.getWidth()<this.minWidth){this.el.setWidth(this.minWidth)}}}},setHandler:function(B,A){this.handler=B;this.scope=A},setText:function(A){this.text=A;if(this.el){this.el.child("td.x-btn-center "+this.buttonSelector).update(A)}this.autoWidth()},getText:function(){return this.text},toggle:function(A){A=A===undefined?!this.pressed:A;if(A!=this.pressed){if(A){this.el.addClass("x-btn-pressed");this.pressed=true;this.fireEvent("toggle",this,true)}else{this.el.removeClass("x-btn-pressed");this.pressed=false;this.fireEvent("toggle",this,false)}if(this.toggleHandler){this.toggleHandler.call(this.scope||this,this,A)}}},focus:function(){this.el.child(this.buttonSelector).focus()},onDisable:function(){if(this.el){if(!Ext.isIE6||!this.text){this.el.addClass(this.disabledClass)}this.el.dom.disabled=true}this.disabled=true},onEnable:function(){if(this.el){if(!Ext.isIE6||!this.text){this.el.removeClass(this.disabledClass)}this.el.dom.disabled=false}this.disabled=false},showMenu:function(){if(this.menu){this.menu.show(this.el,this.menuAlign)}return this},hideMenu:function(){if(this.menu){this.menu.hide()}return this},hasVisibleMenu:function(){return this.menu&&this.menu.isVisible()},onClick:function(A){if(A){A.preventDefault()}if(A.button!=0){return }if(!this.disabled){if(this.enableToggle&&(this.allowDepress!==false||!this.pressed)){this.toggle()}if(this.menu&&!this.menu.isVisible()&&!this.ignoreNextClick){this.showMenu()}this.fireEvent("click",this,A);if(this.handler){this.handler.call(this.scope||this,this,A)}}},isMenuTriggerOver:function(B,A){return this.menu&&!A},isMenuTriggerOut:function(B,A){return this.menu&&!A},onMouseOver:function(B){if(!this.disabled){var A=B.within(this.el,true);if(!A){this.el.addClass("x-btn-over");if(!this.monitoringMouseOver){Ext.getDoc().on("mouseover",this.monitorMouseOver,this);this.monitoringMouseOver=true}this.fireEvent("mouseover",this,B)}if(this.isMenuTriggerOver(B,A)){this.fireEvent("menutriggerover",this,this.menu,B)}}},monitorMouseOver:function(A){if(A.target!=this.el.dom&&!A.within(this.el)){if(this.monitoringMouseOver){Ext.getDoc().un("mouseover",this.monitorMouseOver,this);this.monitoringMouseOver=false}this.onMouseOut(A)}},onMouseOut:function(B){var A=B.within(this.el)&&B.target!=this.el.dom;this.el.removeClass("x-btn-over");this.fireEvent("mouseout",this,B);if(this.isMenuTriggerOut(B,A)){this.fireEvent("menutriggerout",this,this.menu,B)}},onFocus:function(A){if(!this.disabled){this.el.addClass("x-btn-focus")}},onBlur:function(A){this.el.removeClass("x-btn-focus")},getClickEl:function(B,A){return this.el},onMouseDown:function(A){if(!this.disabled&&A.button==0){this.getClickEl(A).addClass("x-btn-click");Ext.getDoc().on("mouseup",this.onMouseUp,this)}},onMouseUp:function(A){if(A.button==0){this.getClickEl(A,true).removeClass("x-btn-click");Ext.getDoc().un("mouseup",this.onMouseUp,this)}},onMenuShow:function(A){this.ignoreNextClick=0;this.el.addClass("x-btn-menu-active");this.fireEvent("menushow",this,this.menu)},onMenuHide:function(A){this.el.removeClass("x-btn-menu-active");this.ignoreNextClick=this.restoreClick.defer(250,this);this.fireEvent("menuhide",this,this.menu)},restoreClick:function(){this.ignoreNextClick=0}});Ext.reg("button",Ext.Button);Ext.ButtonToggleMgr=function(){var A={};function B(E,G){if(G){var F=A[E.toggleGroup];for(var D=0,C=F.length;D<C;D++){if(F[D]!=E){F[D].toggle(false)}}}}return{register:function(C){if(!C.toggleGroup){return }var D=A[C.toggleGroup];if(!D){D=A[C.toggleGroup]=[]}D.push(C);C.on("toggle",B)},unregister:function(C){if(!C.toggleGroup){return }var D=A[C.toggleGroup];if(D){D.remove(C);C.un("toggle",B)}}}}();
Ext.SplitButton=Ext.extend(Ext.Button,{arrowSelector:"button:last",initComponent:function(){Ext.SplitButton.superclass.initComponent.call(this);this.addEvents("arrowclick")},onRender:function(D,A){var B=new Ext.Template("<table cellspacing=\"0\" class=\"x-btn-menu-wrap x-btn\"><tr><td>","<table cellspacing=\"0\" class=\"x-btn-wrap x-btn-menu-text-wrap\"><tbody>","<tr><td class=\"x-btn-left\"><i>&#160;</i></td><td class=\"x-btn-center\"><button class=\"x-btn-text\" type=\"{1}\">{0}</button></td></tr>","</tbody></table></td><td>","<table cellspacing=\"0\" class=\"x-btn-wrap x-btn-menu-arrow-wrap\"><tbody>","<tr><td class=\"x-btn-center\"><button class=\"x-btn-menu-arrow-el\" type=\"button\">&#160;</button></td><td class=\"x-btn-right\"><i>&#160;</i></td></tr>","</tbody></table></td></tr></table>");var C,F=[this.text||"&#160;",this.type];if(A){C=B.insertBefore(A,F,true)}else{C=B.append(D,F,true)}var E=C.child(this.buttonSelector);this.initButtonEl(C,E);this.arrowBtnTable=C.child("table:last");if(this.arrowTooltip){C.child(this.arrowSelector).dom[this.tooltipType]=this.arrowTooltip}},autoWidth:function(){if(this.el){var C=this.el.child("table:first");var B=this.el.child("table:last");this.el.setWidth("auto");C.setWidth("auto");if(Ext.isIE7&&Ext.isStrict){var A=this.el.child(this.buttonSelector);if(A&&A.getWidth()>20){A.clip();A.setWidth(Ext.util.TextMetrics.measure(A,this.text).width+A.getFrameWidth("lr"))}}if(this.minWidth){if((C.getWidth()+B.getWidth())<this.minWidth){C.setWidth(this.minWidth-B.getWidth())}}this.el.setWidth(C.getWidth()+B.getWidth())}},setArrowHandler:function(B,A){this.arrowHandler=B;this.scope=A},onClick:function(A){A.preventDefault();if(!this.disabled){if(A.getTarget(".x-btn-menu-arrow-wrap")){if(this.menu&&!this.menu.isVisible()&&!this.ignoreNextClick){this.showMenu()}this.fireEvent("arrowclick",this,A);if(this.arrowHandler){this.arrowHandler.call(this.scope||this,this,A)}}else{if(this.enableToggle){this.toggle()}this.fireEvent("click",this,A);if(this.handler){this.handler.call(this.scope||this,this,A)}}}},getClickEl:function(B,A){if(!A){return(this.lastClickEl=B.getTarget("table",10,true))}return this.lastClickEl},onDisable:function(){if(this.el){if(!Ext.isIE6){this.el.addClass("x-item-disabled")}this.el.child(this.buttonSelector).dom.disabled=true;this.el.child(this.arrowSelector).dom.disabled=true}this.disabled=true},onEnable:function(){if(this.el){if(!Ext.isIE6){this.el.removeClass("x-item-disabled")}this.el.child(this.buttonSelector).dom.disabled=false;this.el.child(this.arrowSelector).dom.disabled=false}this.disabled=false},isMenuTriggerOver:function(A){return this.menu&&A.within(this.arrowBtnTable)&&!A.within(this.arrowBtnTable,true)},isMenuTriggerOut:function(B,A){return this.menu&&!B.within(this.arrowBtnTable)},onDestroy:function(){Ext.destroy(this.arrowBtnTable);Ext.SplitButton.superclass.onDestroy.call(this)}});Ext.MenuButton=Ext.SplitButton;Ext.reg("splitbutton",Ext.SplitButton);
Ext.CycleButton=Ext.extend(Ext.SplitButton,{getItemText:function(A){if(A&&this.showText===true){var B="";if(this.prependText){B+=this.prependText}B+=A.text;return B}return undefined},setActiveItem:function(C,A){if(typeof C!="object"){C=this.menu.items.get(C)}if(C){if(!this.rendered){this.text=this.getItemText(C);this.iconCls=C.iconCls}else{var B=this.getItemText(C);if(B){this.setText(B)}this.setIconClass(C.iconCls)}this.activeItem=C;if(!C.checked){C.setChecked(true,true)}if(this.forceIcon){this.setIconClass(this.forceIcon)}if(!A){this.fireEvent("change",this,C)}}},getActiveItem:function(){return this.activeItem},initComponent:function(){this.addEvents("change");if(this.changeHandler){this.on("change",this.changeHandler,this.scope||this);delete this.changeHandler}this.itemCount=this.items.length;this.menu={cls:"x-cycle-menu",items:[]};var D;for(var B=0,A=this.itemCount;B<A;B++){var C=this.items[B];C.group=C.group||this.id;C.itemIndex=B;C.checkHandler=this.checkHandler;C.scope=this;C.checked=C.checked||false;this.menu.items.push(C);if(C.checked){D=C}}this.setActiveItem(D,true);Ext.CycleButton.superclass.initComponent.call(this);this.on("click",this.toggleSelected,this)},checkHandler:function(A,B){if(B){this.setActiveItem(A)}},toggleSelected:function(){this.menu.render();var C,A;for(var B=1;B<this.itemCount;B++){C=(this.activeItem.itemIndex+B)%this.itemCount;A=this.menu.items.itemAt(C);if(!A.disabled){A.setChecked(true);break}}}});Ext.reg("cycle",Ext.CycleButton);
Ext.Toolbar=function(A){if(Ext.isArray(A)){A={buttons:A}}Ext.Toolbar.superclass.constructor.call(this,A)};(function(){var A=Ext.Toolbar;Ext.extend(A,Ext.BoxComponent,{trackMenus:true,initComponent:function(){A.superclass.initComponent.call(this);if(this.items){this.buttons=this.items}this.items=new Ext.util.MixedCollection(false,function(B){return B.itemId||B.id||Ext.id()})},autoCreate:{cls:"x-toolbar x-small-editor",html:"<table cellspacing=\"0\"><tr></tr></table>"},onRender:function(C,B){this.el=C.createChild(Ext.apply({id:this.id},this.autoCreate),B);this.tr=this.el.child("tr",true)},afterRender:function(){A.superclass.afterRender.call(this);if(this.buttons){this.add.apply(this,this.buttons);delete this.buttons}},add:function(){var C=arguments,B=C.length;for(var D=0;D<B;D++){var E=C[D];if(E.isFormField){this.addField(E)}else{if(E.render){this.addItem(E)}else{if(typeof E=="string"){if(E=="separator"||E=="-"){this.addSeparator()}else{if(E==" "){this.addSpacer()}else{if(E=="->"){this.addFill()}else{this.addText(E)}}}}else{if(E.tagName){this.addElement(E)}else{if(typeof E=="object"){if(E.xtype){this.addField(Ext.ComponentMgr.create(E,"button"))}else{this.addButton(E)}}}}}}}},addSeparator:function(){return this.addItem(new A.Separator())},addSpacer:function(){return this.addItem(new A.Spacer())},addFill:function(){return this.addItem(new A.Fill())},addElement:function(B){return this.addItem(new A.Item(B))},addItem:function(B){var C=this.nextBlock();this.initMenuTracking(B);B.render(C);this.items.add(B);return B},addButton:function(D){if(Ext.isArray(D)){var F=[];for(var E=0,C=D.length;E<C;E++){F.push(this.addButton(D[E]))}return F}var B=D;if(!(D instanceof A.Button)){B=D.split?new A.SplitButton(D):new A.Button(D)}var G=this.nextBlock();this.initMenuTracking(B);B.render(G);this.items.add(B);return B},initMenuTracking:function(B){if(this.trackMenus&&B.menu){B.on({"menutriggerover":this.onButtonTriggerOver,"menushow":this.onButtonMenuShow,"menuhide":this.onButtonMenuHide,scope:this})}},addText:function(B){return this.addItem(new A.TextItem(B))},insertButton:function(C,F){if(Ext.isArray(F)){var E=[];for(var D=0,B=F.length;D<B;D++){E.push(this.insertButton(C+D,F[D]))}return E}if(!(F instanceof A.Button)){F=new A.Button(F)}var G=document.createElement("td");this.tr.insertBefore(G,this.tr.childNodes[C]);this.initMenuTracking(F);F.render(G);this.items.insert(C,F);return F},addDom:function(C,B){var E=this.nextBlock();Ext.DomHelper.overwrite(E,C);var D=new A.Item(E.firstChild);D.render(E);this.items.add(D);return D},addField:function(C){var D=this.nextBlock();C.render(D);var B=new A.Item(D.firstChild);B.render(D);this.items.add(C);return B},nextBlock:function(){var B=document.createElement("td");this.tr.appendChild(B);return B},onDestroy:function(){Ext.Toolbar.superclass.onDestroy.call(this);if(this.rendered){if(this.items){Ext.destroy.apply(Ext,this.items.items)}Ext.Element.uncache(this.tr)}},onDisable:function(){this.items.each(function(B){if(B.disable){B.disable()}})},onEnable:function(){this.items.each(function(B){if(B.enable){B.enable()}})},onButtonTriggerOver:function(B){if(this.activeMenuBtn&&this.activeMenuBtn!=B){this.activeMenuBtn.hideMenu();B.showMenu();this.activeMenuBtn=B}},onButtonMenuShow:function(B){this.activeMenuBtn=B},onButtonMenuHide:function(B){delete this.activeMenuBtn}});Ext.reg("toolbar",Ext.Toolbar);A.Item=function(B){this.el=Ext.getDom(B);this.id=Ext.id(this.el);this.hidden=false};A.Item.prototype={getEl:function(){return this.el},render:function(B){this.td=B;B.appendChild(this.el)},destroy:function(){if(this.td&&this.td.parentNode){this.td.parentNode.removeChild(this.td)}},show:function(){this.hidden=false;this.td.style.display=""},hide:function(){this.hidden=true;this.td.style.display="none"},setVisible:function(B){if(B){this.show()}else{this.hide()}},focus:function(){Ext.fly(this.el).focus()},disable:function(){Ext.fly(this.td).addClass("x-item-disabled");this.disabled=true;this.el.disabled=true},enable:function(){Ext.fly(this.td).removeClass("x-item-disabled");this.disabled=false;this.el.disabled=false}};Ext.reg("tbitem",A.Item);A.Separator=function(){var B=document.createElement("span");B.className="ytb-sep";A.Separator.superclass.constructor.call(this,B)};Ext.extend(A.Separator,A.Item,{enable:Ext.emptyFn,disable:Ext.emptyFn,focus:Ext.emptyFn});Ext.reg("tbseparator",A.Separator);A.Spacer=function(){var B=document.createElement("div");B.className="ytb-spacer";A.Spacer.superclass.constructor.call(this,B)};Ext.extend(A.Spacer,A.Item,{enable:Ext.emptyFn,disable:Ext.emptyFn,focus:Ext.emptyFn});Ext.reg("tbspacer",A.Spacer);A.Fill=Ext.extend(A.Spacer,{render:function(B){B.style.width="100%";A.Fill.superclass.render.call(this,B)}});Ext.reg("tbfill",A.Fill);A.TextItem=function(B){var C=document.createElement("span");C.className="ytb-text";C.innerHTML=B.text?B.text:B;A.TextItem.superclass.constructor.call(this,C)};Ext.extend(A.TextItem,A.Item,{enable:Ext.emptyFn,disable:Ext.emptyFn,focus:Ext.emptyFn});Ext.reg("tbtext",A.TextItem);A.Button=Ext.extend(Ext.Button,{hideParent:true,onDestroy:function(){A.Button.superclass.onDestroy.call(this);if(this.container){this.container.remove()}}});Ext.reg("tbbutton",A.Button);A.SplitButton=Ext.extend(Ext.SplitButton,{hideParent:true,onDestroy:function(){A.SplitButton.superclass.onDestroy.call(this);if(this.container){this.container.remove()}}});Ext.reg("tbsplit",A.SplitButton);A.MenuButton=A.SplitButton})();
Ext.PagingToolbar=Ext.extend(Ext.Toolbar,{pageSize:20,displayMsg:"Displaying {0} - {1} of {2}",emptyMsg:"No data to display",beforePageText:"Page",afterPageText:"of {0}",firstText:"First Page",prevText:"Previous Page",nextText:"Next Page",lastText:"Last Page",refreshText:"Refresh",paramNames:{start:"start",limit:"limit"},initComponent:function(){this.addEvents("change","beforechange");Ext.PagingToolbar.superclass.initComponent.call(this);this.cursor=0;this.bind(this.store)},onRender:function(B,A){Ext.PagingToolbar.superclass.onRender.call(this,B,A);this.first=this.addButton({tooltip:this.firstText,iconCls:"x-tbar-page-first",disabled:true,handler:this.onClick.createDelegate(this,["first"])});this.prev=this.addButton({tooltip:this.prevText,iconCls:"x-tbar-page-prev",disabled:true,handler:this.onClick.createDelegate(this,["prev"])});this.addSeparator();this.add(this.beforePageText);this.field=Ext.get(this.addDom({tag:"input",type:"text",size:"3",value:"1",cls:"x-tbar-page-number"}).el);this.field.on("keydown",this.onPagingKeydown,this);this.field.on("focus",function(){this.dom.select()});this.afterTextEl=this.addText(String.format(this.afterPageText,1));this.field.setHeight(18);this.addSeparator();this.next=this.addButton({tooltip:this.nextText,iconCls:"x-tbar-page-next",disabled:true,handler:this.onClick.createDelegate(this,["next"])});this.last=this.addButton({tooltip:this.lastText,iconCls:"x-tbar-page-last",disabled:true,handler:this.onClick.createDelegate(this,["last"])});this.addSeparator();this.loading=this.addButton({tooltip:this.refreshText,iconCls:"x-tbar-loading",handler:this.onClick.createDelegate(this,["refresh"])});if(this.displayInfo){this.displayEl=Ext.fly(this.el.dom).createChild({cls:"x-paging-info"})}if(this.dsLoaded){this.onLoad.apply(this,this.dsLoaded)}},updateInfo:function(){if(this.displayEl){var A=this.store.getCount();var B=A==0?this.emptyMsg:String.format(this.displayMsg,this.cursor+1,this.cursor+A,this.store.getTotalCount());this.displayEl.update(B)}},onLoad:function(A,C,F){if(!this.rendered){this.dsLoaded=[A,C,F];return }this.cursor=F.params?F.params[this.paramNames.start]:0;var E=this.getPageData(),B=E.activePage,D=E.pages;this.afterTextEl.el.innerHTML=String.format(this.afterPageText,E.pages);this.field.dom.value=B;this.first.setDisabled(B==1);this.prev.setDisabled(B==1);this.next.setDisabled(B==D);this.last.setDisabled(B==D);this.loading.enable();this.updateInfo();this.fireEvent("change",this,E)},getPageData:function(){var A=this.store.getTotalCount();return{total:A,activePage:Math.ceil((this.cursor+this.pageSize)/this.pageSize),pages:A<this.pageSize?1:Math.ceil(A/this.pageSize)}},onLoadError:function(){if(!this.rendered){return }this.loading.enable()},readPage:function(C){var A=this.field.dom.value,B;if(!A||isNaN(B=parseInt(A,10))){this.field.dom.value=C.activePage;return false}return B},onPagingKeydown:function(D){var B=D.getKey(),E=this.getPageData(),C;if(B==D.RETURN){D.stopEvent();C=this.readPage(E);if(C!==false){C=Math.min(Math.max(1,C),E.pages)-1;this.doLoad(C*this.pageSize)}}else{if(B==D.HOME||B==D.END){D.stopEvent();C=B==D.HOME?1:E.pages;this.field.dom.value=C}else{if(B==D.UP||B==D.PAGEUP||B==D.DOWN||B==D.PAGEDOWN){D.stopEvent();if(C=this.readPage(E)){var A=D.shiftKey?10:1;if(B==D.DOWN||B==D.PAGEDOWN){A*=-1}C+=A;if(C>=1&C<=E.pages){this.field.dom.value=C}}}}}},beforeLoad:function(){if(this.rendered&&this.loading){this.loading.disable()}},doLoad:function(C){var B={},A=this.paramNames;B[A.start]=C;B[A.limit]=this.pageSize;if(this.fireEvent("beforechange",this,B)!==false){this.store.load({params:B})}},changePage:function(A){this.doLoad(((A-1)*this.pageSize).constrain(0,this.store.getTotalCount()))},onClick:function(E){var B=this.store;switch(E){case"first":this.doLoad(0);break;case"prev":this.doLoad(Math.max(0,this.cursor-this.pageSize));break;case"next":this.doLoad(this.cursor+this.pageSize);break;case"last":var D=B.getTotalCount();var A=D%this.pageSize;var C=A?(D-A):D-this.pageSize;this.doLoad(C);break;case"refresh":this.doLoad(this.cursor);break}},unbind:function(A){A=Ext.StoreMgr.lookup(A);A.un("beforeload",this.beforeLoad,this);A.un("load",this.onLoad,this);A.un("loadexception",this.onLoadError,this);this.store=undefined},bind:function(A){A=Ext.StoreMgr.lookup(A);A.on("beforeload",this.beforeLoad,this);A.on("load",this.onLoad,this);A.on("loadexception",this.onLoadError,this);this.store=A}});Ext.reg("paging",Ext.PagingToolbar);
Ext.Resizable=function(D,E){this.el=Ext.get(D);if(E&&E.wrap){E.resizeChild=this.el;this.el=this.el.wrap(typeof E.wrap=="object"?E.wrap:{cls:"xresizable-wrap"});this.el.id=this.el.dom.id=E.resizeChild.id+"-rzwrap";this.el.setStyle("overflow","hidden");this.el.setPositioning(E.resizeChild.getPositioning());E.resizeChild.clearPositioning();if(!E.width||!E.height){var F=E.resizeChild.getSize();this.el.setSize(F.width,F.height)}if(E.pinned&&!E.adjustments){E.adjustments="auto"}}this.proxy=this.el.createProxy({tag:"div",cls:"x-resizable-proxy",id:this.el.id+"-rzproxy"},Ext.getBody());this.proxy.unselectable();this.proxy.enableDisplayMode("block");Ext.apply(this,E);if(this.pinned){this.disableTrackOver=true;this.el.addClass("x-resizable-pinned")}var I=this.el.getStyle("position");if(I!="absolute"&&I!="fixed"){this.el.setStyle("position","relative")}if(!this.handles){this.handles="s,e,se";if(this.multiDirectional){this.handles+=",n,w"}}if(this.handles=="all"){this.handles="n s e w ne nw se sw"}var M=this.handles.split(/\s*?[,;]\s*?| /);var C=Ext.Resizable.positions;for(var H=0,J=M.length;H<J;H++){if(M[H]&&C[M[H]]){var L=C[M[H]];this[L]=new Ext.Resizable.Handle(this,L,this.disableTrackOver,this.transparent)}}this.corner=this.southeast;if(this.handles.indexOf("n")!=-1||this.handles.indexOf("w")!=-1){this.updateBox=true}this.activeHandle=null;if(this.resizeChild){if(typeof this.resizeChild=="boolean"){this.resizeChild=Ext.get(this.el.dom.firstChild,true)}else{this.resizeChild=Ext.get(this.resizeChild,true)}}if(this.adjustments=="auto"){var B=this.resizeChild;var K=this.west,G=this.east,A=this.north,M=this.south;if(B&&(K||A)){B.position("relative");B.setLeft(K?K.el.getWidth():0);B.setTop(A?A.el.getHeight():0)}this.adjustments=[(G?-G.el.getWidth():0)+(K?-K.el.getWidth():0),(A?-A.el.getHeight():0)+(M?-M.el.getHeight():0)-1]}if(this.draggable){this.dd=this.dynamic?this.el.initDD(null):this.el.initDDProxy(null,{dragElId:this.proxy.id});this.dd.setHandleElId(this.resizeChild?this.resizeChild.id:this.el.id)}this.addEvents("beforeresize","resize");if(this.width!==null&&this.height!==null){this.resizeTo(this.width,this.height)}else{this.updateChildSize()}if(Ext.isIE){this.el.dom.style.zoom=1}Ext.Resizable.superclass.constructor.call(this)};Ext.extend(Ext.Resizable,Ext.util.Observable,{resizeChild:false,adjustments:[0,0],minWidth:5,minHeight:5,maxWidth:10000,maxHeight:10000,enabled:true,animate:false,duration:0.35,dynamic:false,handles:false,multiDirectional:false,disableTrackOver:false,easing:"easeOutStrong",widthIncrement:0,heightIncrement:0,pinned:false,width:null,height:null,preserveRatio:false,transparent:false,minX:0,minY:0,draggable:false,resizeTo:function(B,A){this.el.setSize(B,A);this.updateChildSize();this.fireEvent("resize",this,B,A,null)},startSizing:function(C,B){this.fireEvent("beforeresize",this,C);if(this.enabled){if(!this.overlay){this.overlay=this.el.createProxy({tag:"div",cls:"x-resizable-overlay",html:"&#160;"},Ext.getBody());this.overlay.unselectable();this.overlay.enableDisplayMode("block");this.overlay.on("mousemove",this.onMouseMove,this);this.overlay.on("mouseup",this.onMouseUp,this)}this.overlay.setStyle("cursor",B.el.getStyle("cursor"));this.resizing=true;this.startBox=this.el.getBox();this.startPoint=C.getXY();this.offsets=[(this.startBox.x+this.startBox.width)-this.startPoint[0],(this.startBox.y+this.startBox.height)-this.startPoint[1]];this.overlay.setSize(Ext.lib.Dom.getViewWidth(true),Ext.lib.Dom.getViewHeight(true));this.overlay.show();if(this.constrainTo){var A=Ext.get(this.constrainTo);this.resizeRegion=A.getRegion().adjust(A.getFrameWidth("t"),A.getFrameWidth("l"),-A.getFrameWidth("b"),-A.getFrameWidth("r"))}this.proxy.setStyle("visibility","hidden");this.proxy.show();this.proxy.setBox(this.startBox);if(!this.dynamic){this.proxy.setStyle("visibility","visible")}}},onMouseDown:function(A,B){if(this.enabled){B.stopEvent();this.activeHandle=A;this.startSizing(B,A)}},onMouseUp:function(B){var A=this.resizeElement();this.resizing=false;this.handleOut();this.overlay.hide();this.proxy.hide();this.fireEvent("resize",this,A.width,A.height,B)},updateChildSize:function(){if(this.resizeChild){var C=this.el;var D=this.resizeChild;var B=this.adjustments;if(C.dom.offsetWidth){var A=C.getSize(true);D.setSize(A.width+B[0],A.height+B[1])}if(Ext.isIE){setTimeout(function(){if(C.dom.offsetWidth){var E=C.getSize(true);D.setSize(E.width+B[0],E.height+B[1])}},10)}}},snap:function(C,E,B){if(!E||!C){return C}var D=C;var A=C%E;if(A>0){if(A>(E/2)){D=C+(E-A)}else{D=C-A}}return Math.max(B,D)},resizeElement:function(){var A=this.proxy.getBox();if(this.updateBox){this.el.setBox(A,false,this.animate,this.duration,null,this.easing)}else{this.el.setSize(A.width,A.height,this.animate,this.duration,null,this.easing)}this.updateChildSize();if(!this.dynamic){this.proxy.hide()}return A},constrain:function(B,C,A,D){if(B-C<A){C=B-A}else{if(B-C>D){C=D-B}}return C},onMouseMove:function(S){if(this.enabled){try{if(this.resizeRegion&&!this.resizeRegion.contains(S.getPoint())){return }var Q=this.curSize||this.startBox;var I=this.startBox.x,H=this.startBox.y;var C=I,B=H;var J=Q.width,R=Q.height;var D=J,L=R;var K=this.minWidth,T=this.minHeight;var P=this.maxWidth,W=this.maxHeight;var F=this.widthIncrement;var A=this.heightIncrement;var U=S.getXY();var O=-(this.startPoint[0]-Math.max(this.minX,U[0]));var M=-(this.startPoint[1]-Math.max(this.minY,U[1]));var G=this.activeHandle.position;switch(G){case"east":J+=O;J=Math.min(Math.max(K,J),P);break;case"south":R+=M;R=Math.min(Math.max(T,R),W);break;case"southeast":J+=O;R+=M;J=Math.min(Math.max(K,J),P);R=Math.min(Math.max(T,R),W);break;case"north":M=this.constrain(R,M,T,W);H+=M;R-=M;break;case"west":O=this.constrain(J,O,K,P);I+=O;J-=O;break;case"northeast":J+=O;J=Math.min(Math.max(K,J),P);M=this.constrain(R,M,T,W);H+=M;R-=M;break;case"northwest":O=this.constrain(J,O,K,P);M=this.constrain(R,M,T,W);H+=M;R-=M;I+=O;J-=O;break;case"southwest":O=this.constrain(J,O,K,P);R+=M;R=Math.min(Math.max(T,R),W);I+=O;J-=O;break}var N=this.snap(J,F,K);var V=this.snap(R,A,T);if(N!=J||V!=R){switch(G){case"northeast":H-=V-R;break;case"north":H-=V-R;break;case"southwest":I-=N-J;break;case"west":I-=N-J;break;case"northwest":I-=N-J;H-=V-R;break}J=N;R=V}if(this.preserveRatio){switch(G){case"southeast":case"east":R=L*(J/D);R=Math.min(Math.max(T,R),W);J=D*(R/L);break;case"south":J=D*(R/L);J=Math.min(Math.max(K,J),P);R=L*(J/D);break;case"northeast":J=D*(R/L);J=Math.min(Math.max(K,J),P);R=L*(J/D);break;case"north":var X=J;J=D*(R/L);J=Math.min(Math.max(K,J),P);R=L*(J/D);I+=(X-J)/2;break;case"southwest":R=L*(J/D);R=Math.min(Math.max(T,R),W);var X=J;J=D*(R/L);I+=X-J;break;case"west":var E=R;R=L*(J/D);R=Math.min(Math.max(T,R),W);H+=(E-R)/2;var X=J;J=D*(R/L);I+=X-J;break;case"northwest":var X=J;var E=R;R=L*(J/D);R=Math.min(Math.max(T,R),W);J=D*(R/L);H+=E-R;I+=X-J;break}}this.proxy.setBounds(I,H,J,R);if(this.dynamic){this.resizeElement()}}catch(S){}}},handleOver:function(){if(this.enabled){this.el.addClass("x-resizable-over")}},handleOut:function(){if(!this.resizing){this.el.removeClass("x-resizable-over")}},getEl:function(){return this.el},getResizeChild:function(){return this.resizeChild},destroy:function(C){this.proxy.remove();if(this.overlay){this.overlay.removeAllListeners();this.overlay.remove()}var D=Ext.Resizable.positions;for(var A in D){if(typeof D[A]!="function"&&this[D[A]]){var B=this[D[A]];B.el.removeAllListeners();B.el.remove()}}if(C){this.el.update("");this.el.remove()}},syncHandleHeight:function(){var A=this.el.getHeight(true);if(this.west){this.west.el.setHeight(A)}if(this.east){this.east.el.setHeight(A)}}});Ext.Resizable.positions={n:"north",s:"south",e:"east",w:"west",se:"southeast",sw:"southwest",nw:"northwest",ne:"northeast"};Ext.Resizable.Handle=function(C,E,B,D){if(!this.tpl){var A=Ext.DomHelper.createTemplate({tag:"div",cls:"x-resizable-handle x-resizable-handle-{0}"});A.compile();Ext.Resizable.Handle.prototype.tpl=A}this.position=E;this.rz=C;this.el=this.tpl.append(C.el.dom,[this.position],true);this.el.unselectable();if(D){this.el.setOpacity(0)}this.el.on("mousedown",this.onMouseDown,this);if(!B){this.el.on("mouseover",this.onMouseOver,this);this.el.on("mouseout",this.onMouseOut,this)}};Ext.Resizable.Handle.prototype={afterResize:function(A){},onMouseDown:function(A){this.rz.onMouseDown(this,A)},onMouseOver:function(A){this.rz.handleOver(this,A)},onMouseOut:function(A){this.rz.handleOut(this,A)}};
Ext.Editor=function(B,A){this.field=B;Ext.Editor.superclass.constructor.call(this,A)};Ext.extend(Ext.Editor,Ext.Component,{value:"",alignment:"c-c?",shadow:"frame",constrain:false,swallowKeys:true,completeOnEnter:false,cancelOnEsc:false,updateEl:false,initComponent:function(){Ext.Editor.superclass.initComponent.call(this);this.addEvents("beforestartedit","startedit","beforecomplete","complete","canceledit","specialkey")},onRender:function(B,A){this.el=new Ext.Layer({shadow:this.shadow,cls:"x-editor",parentEl:B,shim:this.shim,shadowOffset:4,id:this.id,constrain:this.constrain});this.el.setStyle("overflow",Ext.isGecko?"auto":"hidden");if(this.field.msgTarget!="title"){this.field.msgTarget="qtip"}this.field.inEditor=true;this.field.render(this.el);if(Ext.isGecko){this.field.el.dom.setAttribute("autocomplete","off")}this.field.on("specialkey",this.onSpecialKey,this);if(this.swallowKeys){this.field.el.swallowEvent(["keydown","keypress"])}this.field.show();this.field.on("blur",this.onBlur,this);if(this.field.grow){this.field.on("autosize",this.el.sync,this.el,{delay:1})}},onSpecialKey:function(C,B){var A=B.getKey();if(this.completeOnEnter&&A==B.ENTER){B.stopEvent();this.completeEdit()}else{if(this.cancelOnEsc&&A==B.ESC){this.cancelEdit()}else{this.fireEvent("specialkey",C,B)}}if(this.field.triggerBlur&&(A==B.ENTER||A==B.ESC||A==B.TAB)){this.field.triggerBlur()}},startEdit:function(B,C){if(this.editing){this.completeEdit()}this.boundEl=Ext.get(B);var A=C!==undefined?C:this.boundEl.dom.innerHTML;if(!this.rendered){this.render(this.parentEl||document.body)}if(this.fireEvent("beforestartedit",this,this.boundEl,A)===false){return }this.startValue=A;this.field.setValue(A);this.doAutoSize();this.el.alignTo(this.boundEl,this.alignment);this.editing=true;this.show()},doAutoSize:function(){if(this.autoSize){var A=this.boundEl.getSize();switch(this.autoSize){case"width":this.setSize(A.width,"");break;case"height":this.setSize("",A.height);break;default:this.setSize(A.width,A.height)}}},setSize:function(A,B){delete this.field.lastSize;this.field.setSize(A,B);if(this.el){if(Ext.isGecko2||Ext.isOpera){this.el.setSize(A,B)}this.el.sync()}},realign:function(){this.el.alignTo(this.boundEl,this.alignment)},completeEdit:function(A){if(!this.editing){return }var B=this.getValue();if(this.revertInvalid!==false&&!this.field.isValid()){B=this.startValue;this.cancelEdit(true)}if(String(B)===String(this.startValue)&&this.ignoreNoChange){this.editing=false;this.hide();return }if(this.fireEvent("beforecomplete",this,B,this.startValue)!==false){this.editing=false;if(this.updateEl&&this.boundEl){this.boundEl.update(B)}if(A!==true){this.hide()}this.fireEvent("complete",this,B,this.startValue)}},onShow:function(){this.el.show();if(this.hideEl!==false){this.boundEl.hide()}this.field.show();if(Ext.isIE&&!this.fixIEFocus){this.fixIEFocus=true;this.deferredFocus.defer(50,this)}else{this.field.focus()}this.fireEvent("startedit",this.boundEl,this.startValue)},deferredFocus:function(){if(this.editing){this.field.focus()}},cancelEdit:function(A){if(this.editing){var B=this.getValue();this.setValue(this.startValue);if(A!==true){this.hide()}this.fireEvent("canceledit",this,B,this.startValue)}},onBlur:function(){if(this.allowBlur!==true&&this.editing){this.completeEdit()}},onHide:function(){if(this.editing){this.completeEdit();return }this.field.blur();if(this.field.collapse){this.field.collapse()}this.el.hide();if(this.hideEl!==false){this.boundEl.show()}},setValue:function(A){this.field.setValue(A)},getValue:function(){return this.field.getValue()},beforeDestroy:function(){this.field.destroy();this.field=null}});Ext.reg("editor",Ext.Editor);
Ext.MessageBox=function(){var R,B,N,Q;var G,J,P,A,K,M,H,F;var O,S,L,C="";var D=function(U){if(R.isVisible()){R.hide();Ext.callback(B.fn,B.scope||window,[U,S.dom.value],1)}};var T=function(){if(B&&B.cls){R.el.removeClass(B.cls)}K.reset()};var E=function(W,U,V){if(B&&B.closable!==false){R.hide()}if(V){V.stopEvent()}};var I=function(U){var W=0;if(!U){O["ok"].hide();O["cancel"].hide();O["yes"].hide();O["no"].hide();return W}R.footer.dom.style.display="";for(var V in O){if(typeof O[V]!="function"){if(U[V]){O[V].show();O[V].setText(typeof U[V]=="string"?U[V]:Ext.MessageBox.buttonText[V]);W+=O[V].el.getWidth()+15}else{O[V].hide()}}}return W};return{getDialog:function(U){if(!R){R=new Ext.Window({autoCreate:true,title:U,resizable:false,constrain:true,constrainHeader:true,minimizable:false,maximizable:false,stateful:false,modal:true,shim:true,buttonAlign:"center",width:400,height:100,minHeight:80,plain:true,footer:true,closable:true,close:function(){if(B&&B.buttons&&B.buttons.no&&!B.buttons.cancel){D("no")}else{D("cancel")}}});O={};var V=this.buttonText;O["ok"]=R.addButton(V["ok"],D.createCallback("ok"));O["yes"]=R.addButton(V["yes"],D.createCallback("yes"));O["no"]=R.addButton(V["no"],D.createCallback("no"));O["cancel"]=R.addButton(V["cancel"],D.createCallback("cancel"));O["ok"].hideMode=O["yes"].hideMode=O["no"].hideMode=O["cancel"].hideMode="offsets";R.render(document.body);R.getEl().addClass("x-window-dlg");N=R.mask;G=R.body.createChild({html:"<div class=\"ext-mb-icon\"></div><div class=\"ext-mb-content\"><span class=\"ext-mb-text\"></span><br /><div class=\"ext-mb-fix-cursor\"><input type=\"text\" class=\"ext-mb-input\" /><textarea class=\"ext-mb-textarea\"></textarea></div></div>"});H=Ext.get(G.dom.firstChild);var W=G.dom.childNodes[1];J=Ext.get(W.firstChild);P=Ext.get(W.childNodes[2].firstChild);P.enableDisplayMode();P.addKeyListener([10,13],function(){if(R.isVisible()&&B&&B.buttons){if(B.buttons.ok){D("ok")}else{if(B.buttons.yes){D("yes")}}}});A=Ext.get(W.childNodes[2].childNodes[1]);A.enableDisplayMode();K=new Ext.ProgressBar({renderTo:G});G.createChild({cls:"x-clear"})}return R},updateText:function(X){if(!R.isVisible()&&!B.width){R.setSize(this.maxWidth,100)}J.update(X||"&#160;");var V=C!=""?(H.getWidth()+H.getMargins("lr")):0;var Z=J.getWidth()+J.getMargins("lr");var W=R.getFrameWidth("lr");var Y=R.body.getFrameWidth("lr");if(Ext.isIE&&V>0){V+=3}var U=Math.max(Math.min(B.width||V+Z+W+Y,this.maxWidth),Math.max(B.minWidth||this.minWidth,L||0));if(B.prompt===true){S.setWidth(U-V-W-Y)}if(B.progress===true||B.wait===true){K.setSize(U-V-W-Y)}R.setSize(U,"auto").center();return this},updateProgress:function(V,U,W){K.updateProgress(V,U);if(W){this.updateText(W)}return this},isVisible:function(){return R&&R.isVisible()},hide:function(){if(this.isVisible()){R.hide();T()}return this},show:function(X){if(this.isVisible()){this.hide()}B=X;var Y=this.getDialog(B.title||"&#160;");Y.setTitle(B.title||"&#160;");var U=(B.closable!==false&&B.progress!==true&&B.wait!==true);Y.tools.close.setDisplayed(U);S=P;B.prompt=B.prompt||(B.multiline?true:false);if(B.prompt){if(B.multiline){P.hide();A.show();A.setHeight(typeof B.multiline=="number"?B.multiline:this.defaultTextHeight);S=A}else{P.show();A.hide()}}else{P.hide();A.hide()}S.dom.value=B.value||"";if(B.prompt){Y.focusEl=S}else{var W=B.buttons;var V=null;if(W&&W.ok){V=O["ok"]}else{if(W&&W.yes){V=O["yes"]}}if(V){Y.focusEl=V}}if(B.iconCls){Y.setIconClass(B.iconCls)}this.setIcon(B.icon);L=I(B.buttons);K.setVisible(B.progress===true||B.wait===true);this.updateProgress(0,B.progressText);this.updateText(B.msg);if(B.cls){Y.el.addClass(B.cls)}Y.proxyDrag=B.proxyDrag===true;Y.modal=B.modal!==false;Y.mask=B.modal!==false?N:false;if(!Y.isVisible()){document.body.appendChild(R.el.dom);Y.setAnimateTarget(B.animEl);Y.show(B.animEl)}Y.on("show",function(){if(U===true){Y.keyMap.enable()}else{Y.keyMap.disable()}},this,{single:true});if(B.wait===true){K.wait(B.waitConfig)}return this},setIcon:function(U){if(U&&U!=""){H.removeClass("x-hidden");H.replaceClass(C,U);C=U}else{H.replaceClass(C,"x-hidden");C=""}return this},progress:function(W,V,U){this.show({title:W,msg:V,buttons:false,progress:true,closable:false,minWidth:this.minProgressWidth,progressText:U});return this},wait:function(W,V,U){this.show({title:V,msg:W,buttons:false,closable:false,wait:true,modal:true,minWidth:this.minProgressWidth,waitConfig:U});return this},alert:function(X,W,V,U){this.show({title:X,msg:W,buttons:this.OK,fn:V,scope:U});return this},confirm:function(X,W,V,U){this.show({title:X,msg:W,buttons:this.YESNO,fn:V,scope:U,icon:this.QUESTION});return this},prompt:function(Z,Y,W,V,U,X){this.show({title:Z,msg:Y,buttons:this.OKCANCEL,fn:W,minWidth:250,scope:V,prompt:true,multiline:U,value:X});return this},OK:{ok:true},CANCEL:{cancel:true},OKCANCEL:{ok:true,cancel:true},YESNO:{yes:true,no:true},YESNOCANCEL:{yes:true,no:true,cancel:true},INFO:"ext-mb-info",WARNING:"ext-mb-warning",QUESTION:"ext-mb-question",ERROR:"ext-mb-error",defaultTextHeight:75,maxWidth:600,minWidth:100,minProgressWidth:250,buttonText:{ok:"OK",cancel:"Cancel",yes:"Yes",no:"No"}}}();Ext.Msg=Ext.MessageBox;
Ext.Tip=Ext.extend(Ext.Panel,{minWidth:40,maxWidth:300,shadow:"sides",defaultAlign:"tl-bl?",autoRender:true,quickShowInterval:250,frame:true,hidden:true,baseCls:"x-tip",floating:{shadow:true,shim:true,useDisplay:true,constrain:false},autoHeight:true,initComponent:function(){Ext.Tip.superclass.initComponent.call(this);if(this.closable&&!this.title){this.elements+=",header"}},afterRender:function(){Ext.Tip.superclass.afterRender.call(this);if(this.closable){this.addTool({id:"close",handler:this.hide,scope:this})}},showAt:function(A){Ext.Tip.superclass.show.call(this);if(this.measureWidth!==false&&(!this.initialConfig||typeof this.initialConfig.width!="number")){this.doAutoWidth()}if(this.constrainPosition){A=this.el.adjustForConstraints(A)}this.setPagePosition(A[0],A[1])},doAutoWidth:function(){var A=this.body.getTextWidth();if(this.title){A=Math.max(A,this.header.child("span").getTextWidth(this.title))}A+=this.getFrameWidth()+(this.closable?20:0)+this.body.getPadding("lr");this.setWidth(A.constrain(this.minWidth,this.maxWidth));if(Ext.isIE7&&!this.repainted){this.el.repaint();this.repainted=true}},showBy:function(A,B){if(!this.rendered){this.render(Ext.getBody())}this.showAt(this.el.getAlignToXY(A,B||this.defaultAlign))},initDraggable:function(){this.dd=new Ext.Tip.DD(this,typeof this.draggable=="boolean"?null:this.draggable);this.header.addClass("x-tip-draggable")}});Ext.Tip.DD=function(B,A){Ext.apply(this,A);this.tip=B;Ext.Tip.DD.superclass.constructor.call(this,B.el.id,"WindowDD-"+B.id);this.setHandleElId(B.header.id);this.scroll=false};Ext.extend(Ext.Tip.DD,Ext.dd.DD,{moveOnly:true,scroll:false,headerOffsets:[100,25],startDrag:function(){this.tip.el.disableShadow()},endDrag:function(A){this.tip.el.enableShadow(true)}});
Ext.ToolTip=Ext.extend(Ext.Tip,{showDelay:500,hideDelay:200,dismissDelay:5000,mouseOffset:[15,18],trackMouse:false,constrainPosition:true,initComponent:function(){Ext.ToolTip.superclass.initComponent.call(this);this.lastActive=new Date();this.initTarget()},initTarget:function(){if(this.target){this.target=Ext.get(this.target);this.target.on("mouseover",this.onTargetOver,this);this.target.on("mouseout",this.onTargetOut,this);this.target.on("mousemove",this.onMouseMove,this)}},onMouseMove:function(A){this.targetXY=A.getXY();if(!this.hidden&&this.trackMouse){this.setPagePosition(this.getTargetXY())}},getTargetXY:function(){return[this.targetXY[0]+this.mouseOffset[0],this.targetXY[1]+this.mouseOffset[1]]},onTargetOver:function(A){if(this.disabled||A.within(this.target.dom,true)){return }this.clearTimer("hide");this.targetXY=A.getXY();this.delayShow()},delayShow:function(){if(this.hidden&&!this.showTimer){if(this.lastActive.getElapsed()<this.quickShowInterval){this.show()}else{this.showTimer=this.show.defer(this.showDelay,this)}}else{if(!this.hidden&&this.autoHide!==false){this.show()}}},onTargetOut:function(A){if(this.disabled||A.within(this.target.dom,true)){return }this.clearTimer("show");if(this.autoHide!==false){this.delayHide()}},delayHide:function(){if(!this.hidden&&!this.hideTimer){this.hideTimer=this.hide.defer(this.hideDelay,this)}},hide:function(){this.clearTimer("dismiss");this.lastActive=new Date();Ext.ToolTip.superclass.hide.call(this)},show:function(){this.showAt(this.getTargetXY())},showAt:function(A){this.lastActive=new Date();this.clearTimers();Ext.ToolTip.superclass.showAt.call(this,A);if(this.dismissDelay&&this.autoHide!==false){this.dismissTimer=this.hide.defer(this.dismissDelay,this)}},clearTimer:function(A){A=A+"Timer";clearTimeout(this[A]);delete this[A]},clearTimers:function(){this.clearTimer("show");this.clearTimer("dismiss");this.clearTimer("hide")},onShow:function(){Ext.ToolTip.superclass.onShow.call(this);Ext.getDoc().on("mousedown",this.onDocMouseDown,this)},onHide:function(){Ext.ToolTip.superclass.onHide.call(this);Ext.getDoc().un("mousedown",this.onDocMouseDown,this)},onDocMouseDown:function(A){if(this.autoHide!==false&&!A.within(this.el.dom)){this.disable();this.enable.defer(100,this)}},onDisable:function(){this.clearTimers();this.hide()},adjustPosition:function(A,D){var C=this.targetXY[1],B=this.getSize().height;if(this.constrainPosition&&D<=C&&(D+B)>=C){D=C-B-5}return{x:A,y:D}},onDestroy:function(){Ext.ToolTip.superclass.onDestroy.call(this);if(this.target){this.target.un("mouseover",this.onTargetOver,this);this.target.un("mouseout",this.onTargetOut,this);this.target.un("mousemove",this.onMouseMove,this)}}});
Ext.QuickTip=Ext.extend(Ext.ToolTip,{interceptTitles:false,tagConfig:{namespace:"ext",attribute:"qtip",width:"qwidth",target:"target",title:"qtitle",hide:"hide",cls:"qclass",align:"qalign"},initComponent:function(){this.target=this.target||Ext.getDoc();this.targets=this.targets||{};Ext.QuickTip.superclass.initComponent.call(this)},register:function(D){var F=Ext.isArray(D)?D:arguments;for(var E=0,A=F.length;E<A;E++){var H=F[E];var G=H.target;if(G){if(Ext.isArray(G)){for(var C=0,B=G.length;C<B;C++){this.targets[Ext.id(G[C])]=H}}else{this.targets[Ext.id(G)]=H}}}},unregister:function(A){delete this.targets[Ext.id(A)]},onTargetOver:function(G){if(this.disabled){return }this.targetXY=G.getXY();var C=G.getTarget();if(!C||C.nodeType!==1||C==document||C==document.body){return }if(this.activeTarget&&C==this.activeTarget.el){this.clearTimer("hide");this.show();return }if(C&&this.targets[C.id]){this.activeTarget=this.targets[C.id];this.activeTarget.el=C;this.delayShow();return }var E,F=Ext.fly(C),B=this.tagConfig;var D=B.namespace;if(this.interceptTitles&&C.title){E=C.title;C.qtip=E;C.removeAttribute("title");G.preventDefault()}else{E=C.qtip||F.getAttributeNS(D,B.attribute)}if(E){var A=F.getAttributeNS(D,B.hide);this.activeTarget={el:C,text:E,width:F.getAttributeNS(D,B.width),autoHide:A!="user"&&A!=="false",title:F.getAttributeNS(D,B.title),cls:F.getAttributeNS(D,B.cls),align:F.getAttributeNS(D,B.align)};this.delayShow()}},onTargetOut:function(A){this.clearTimer("show");if(this.autoHide!==false){this.delayHide()}},showAt:function(B){var A=this.activeTarget;if(A){if(!this.rendered){this.render(Ext.getBody());this.activeTarget=A}if(A.width){this.setWidth(A.width);this.body.setWidth(this.adjustBodyWidth(A.width-this.getFrameWidth()));this.measureWidth=false}else{this.measureWidth=true}this.setTitle(A.title||"");this.body.update(A.text);this.autoHide=A.autoHide;this.dismissDelay=A.dismissDelay||this.dismissDelay;if(this.lastCls){this.el.removeClass(this.lastCls);delete this.lastCls}if(A.cls){this.el.addClass(A.cls);this.lastCls=A.cls}if(A.align){B=this.el.getAlignToXY(A.el,A.align);this.constrainPosition=false}else{this.constrainPosition=true}}Ext.QuickTip.superclass.showAt.call(this,B)},hide:function(){delete this.activeTarget;Ext.QuickTip.superclass.hide.call(this)}});
Ext.QuickTips=function(){var B,A=[];return{init:function(C){if(!B){if(!Ext.isReady){Ext.onReady(function(){Ext.QuickTips.init(C)});return }B=new Ext.QuickTip({elements:"header,body"});if(C!==false){B.render(Ext.getBody())}}},enable:function(){if(B){A.pop();if(A.length<1){B.enable()}}},disable:function(){if(B){B.disable()}A.push(1)},isEnabled:function(){return B!==undefined&&!B.disabled},getQuickTip:function(){return B},register:function(){B.register.apply(B,arguments)},unregister:function(){B.unregister.apply(B,arguments)},tips:function(){B.register.apply(B,arguments)}}}();
Ext.tree.TreePanel=Ext.extend(Ext.Panel,{rootVisible:true,animate:Ext.enableFx,lines:true,enableDD:false,hlDrop:Ext.enableFx,pathSeparator:"/",initComponent:function(){Ext.tree.TreePanel.superclass.initComponent.call(this);if(!this.eventModel){this.eventModel=new Ext.tree.TreeEventModel(this)}var A=this.loader;if(!A){A=new Ext.tree.TreeLoader({dataUrl:this.dataUrl})}else{if(typeof A=="object"&&!A.load){A=new Ext.tree.TreeLoader(A)}}this.loader=A;this.nodeHash={};if(this.root){this.setRootNode(this.root)}this.addEvents("append","remove","movenode","insert","beforeappend","beforeremove","beforemovenode","beforeinsert","beforeload","load","textchange","beforeexpandnode","beforecollapsenode","expandnode","disabledchange","collapsenode","beforeclick","click","checkchange","dblclick","contextmenu","beforechildrenrendered","startdrag","enddrag","dragdrop","beforenodedrop","nodedrop","nodedragover");if(this.singleExpand){this.on("beforeexpandnode",this.restrictExpand,this)}},proxyNodeEvent:function(C,B,A,G,F,E,D){if(C=="collapse"||C=="expand"||C=="beforecollapse"||C=="beforeexpand"||C=="move"||C=="beforemove"){C=C+"node"}return this.fireEvent(C,B,A,G,F,E,D)},getRootNode:function(){return this.root},setRootNode:function(B){if(!B.render){B=this.loader.createNode(B)}this.root=B;B.ownerTree=this;B.isRoot=true;this.registerNode(B);if(!this.rootVisible){var A=B.attributes.uiProvider;B.ui=A?new A(B):new Ext.tree.RootTreeNodeUI(B)}return B},getNodeById:function(A){return this.nodeHash[A]},registerNode:function(A){this.nodeHash[A.id]=A},unregisterNode:function(A){delete this.nodeHash[A.id]},toString:function(){return"[Tree"+(this.id?" "+this.id:"")+"]"},restrictExpand:function(A){var B=A.parentNode;if(B){if(B.expandedChild&&B.expandedChild.parentNode==B){B.expandedChild.collapse()}B.expandedChild=A}},getChecked:function(A,B){B=B||this.root;var C=[];var D=function(){if(this.attributes.checked){C.push(!A?this:(A=="id"?this.id:this.attributes[A]))}};B.cascade(D);return C},getEl:function(){return this.el},getLoader:function(){return this.loader},expandAll:function(){this.root.expand(true)},collapseAll:function(){this.root.collapse(true)},getSelectionModel:function(){if(!this.selModel){this.selModel=new Ext.tree.DefaultSelectionModel()}return this.selModel},expandPath:function(F,A,G){A=A||"id";var D=F.split(this.pathSeparator);var C=this.root;if(C.attributes[A]!=D[1]){if(G){G(false,null)}return }var B=1;var E=function(){if(++B==D.length){if(G){G(true,C)}return }var H=C.findChild(A,D[B]);if(!H){if(G){G(false,C)}return }C=H;H.expand(false,false,E)};C.expand(false,false,E)},selectPath:function(E,A,F){A=A||"id";var C=E.split(this.pathSeparator);var B=C.pop();if(C.length>0){var D=function(H,G){if(H&&G){var I=G.findChild(A,B);if(I){I.select();if(F){F(true,I)}}else{if(F){F(false,I)}}}else{if(F){F(false,I)}}};this.expandPath(C.join(this.pathSeparator),A,D)}else{this.root.select();if(F){F(true,this.root)}}},getTreeEl:function(){return this.body},onRender:function(B,A){Ext.tree.TreePanel.superclass.onRender.call(this,B,A);this.el.addClass("x-tree");this.innerCt=this.body.createChild({tag:"ul",cls:"x-tree-root-ct "+(this.useArrows?"x-tree-arrows":this.lines?"x-tree-lines":"x-tree-no-lines")})},initEvents:function(){Ext.tree.TreePanel.superclass.initEvents.call(this);if(this.containerScroll){Ext.dd.ScrollManager.register(this.body)}if((this.enableDD||this.enableDrop)&&!this.dropZone){this.dropZone=new Ext.tree.TreeDropZone(this,this.dropConfig||{ddGroup:this.ddGroup||"TreeDD",appendOnly:this.ddAppendOnly===true})}if((this.enableDD||this.enableDrag)&&!this.dragZone){this.dragZone=new Ext.tree.TreeDragZone(this,this.dragConfig||{ddGroup:this.ddGroup||"TreeDD",scroll:this.ddScroll})}this.getSelectionModel().init(this)},afterRender:function(){Ext.tree.TreePanel.superclass.afterRender.call(this);this.root.render();if(!this.rootVisible){this.root.renderChildren()}},onDestroy:function(){if(this.rendered){this.body.removeAllListeners();Ext.dd.ScrollManager.unregister(this.body);if(this.dropZone){this.dropZone.unreg()}if(this.dragZone){this.dragZone.unreg()}}this.root.destroy();this.nodeHash=null;Ext.tree.TreePanel.superclass.onDestroy.call(this)}});Ext.tree.TreePanel.nodeTypes={};Ext.reg("treepanel",Ext.tree.TreePanel);
Ext.tree.TreeEventModel=function(A){this.tree=A;this.tree.on("render",this.initEvents,this)};Ext.tree.TreeEventModel.prototype={initEvents:function(){var A=this.tree.getTreeEl();A.on("click",this.delegateClick,this);if(this.tree.trackMouseOver!==false){A.on("mouseover",this.delegateOver,this);A.on("mouseout",this.delegateOut,this)}A.on("dblclick",this.delegateDblClick,this);A.on("contextmenu",this.delegateContextMenu,this)},getNode:function(B){var A;if(A=B.getTarget(".x-tree-node-el",10)){var C=Ext.fly(A,"_treeEvents").getAttributeNS("ext","tree-node-id");if(C){return this.tree.getNodeById(C)}}return null},getNodeTarget:function(B){var A=B.getTarget(".x-tree-node-icon",1);if(!A){A=B.getTarget(".x-tree-node-el",6)}return A},delegateOut:function(B,A){if(!this.beforeEvent(B)){return }if(B.getTarget(".x-tree-ec-icon",1)){var C=this.getNode(B);this.onIconOut(B,C);if(C==this.lastEcOver){delete this.lastEcOver}}if((A=this.getNodeTarget(B))&&!B.within(A,true)){this.onNodeOut(B,this.getNode(B))}},delegateOver:function(B,A){if(!this.beforeEvent(B)){return }if(this.lastEcOver){this.onIconOut(B,this.lastEcOver);delete this.lastEcOver}if(B.getTarget(".x-tree-ec-icon",1)){this.lastEcOver=this.getNode(B);this.onIconOver(B,this.lastEcOver)}if(A=this.getNodeTarget(B)){this.onNodeOver(B,this.getNode(B))}},delegateClick:function(B,A){if(!this.beforeEvent(B)){return }if(B.getTarget("input[type=checkbox]",1)){this.onCheckboxClick(B,this.getNode(B))}else{if(B.getTarget(".x-tree-ec-icon",1)){this.onIconClick(B,this.getNode(B))}else{if(this.getNodeTarget(B)){this.onNodeClick(B,this.getNode(B))}}}},delegateDblClick:function(B,A){if(this.beforeEvent(B)&&this.getNodeTarget(B)){this.onNodeDblClick(B,this.getNode(B))}},delegateContextMenu:function(B,A){if(this.beforeEvent(B)&&this.getNodeTarget(B)){this.onNodeContextMenu(B,this.getNode(B))}},onNodeClick:function(B,A){A.ui.onClick(B)},onNodeOver:function(B,A){A.ui.onOver(B)},onNodeOut:function(B,A){A.ui.onOut(B)},onIconOver:function(B,A){A.ui.addClass("x-tree-ec-over")},onIconOut:function(B,A){A.ui.removeClass("x-tree-ec-over")},onIconClick:function(B,A){A.ui.ecClick(B)},onCheckboxClick:function(B,A){A.ui.onCheckChange(B)},onNodeDblClick:function(B,A){A.ui.onDblClick(B)},onNodeContextMenu:function(B,A){A.ui.onContextMenu(B)},beforeEvent:function(A){if(this.disabled){A.stopEvent();return false}return true},disable:function(){this.disabled=true},enable:function(){this.disabled=false}};
Ext.tree.DefaultSelectionModel=function(A){this.selNode=null;this.addEvents("selectionchange","beforeselect");Ext.apply(this,A);Ext.tree.DefaultSelectionModel.superclass.constructor.call(this)};Ext.extend(Ext.tree.DefaultSelectionModel,Ext.util.Observable,{init:function(A){this.tree=A;A.getTreeEl().on("keydown",this.onKeyDown,this);A.on("click",this.onNodeClick,this)},onNodeClick:function(A,B){this.select(A)},select:function(B){var A=this.selNode;if(A!=B&&this.fireEvent("beforeselect",this,B,A)!==false){if(A){A.ui.onSelectedChange(false)}this.selNode=B;B.ui.onSelectedChange(true);this.fireEvent("selectionchange",this,B,A)}return B},unselect:function(A){if(this.selNode==A){this.clearSelections()}},clearSelections:function(){var A=this.selNode;if(A){A.ui.onSelectedChange(false);this.selNode=null;this.fireEvent("selectionchange",this,null)}return A},getSelectedNode:function(){return this.selNode},isSelected:function(A){return this.selNode==A},selectPrevious:function(){var A=this.selNode||this.lastSelNode;if(!A){return null}var C=A.previousSibling;if(C){if(!C.isExpanded()||C.childNodes.length<1){return this.select(C)}else{var B=C.lastChild;while(B&&B.isExpanded()&&B.childNodes.length>0){B=B.lastChild}return this.select(B)}}else{if(A.parentNode&&(this.tree.rootVisible||!A.parentNode.isRoot)){return this.select(A.parentNode)}}return null},selectNext:function(){var B=this.selNode||this.lastSelNode;if(!B){return null}if(B.firstChild&&B.isExpanded()){return this.select(B.firstChild)}else{if(B.nextSibling){return this.select(B.nextSibling)}else{if(B.parentNode){var A=null;B.parentNode.bubble(function(){if(this.nextSibling){A=this.getOwnerTree().selModel.select(this.nextSibling);return false}});return A}}}return null},onKeyDown:function(C){var B=this.selNode||this.lastSelNode;var D=this;if(!B){return }var A=C.getKey();switch(A){case C.DOWN:C.stopEvent();this.selectNext();break;case C.UP:C.stopEvent();this.selectPrevious();break;case C.RIGHT:C.preventDefault();if(B.hasChildNodes()){if(!B.isExpanded()){B.expand()}else{if(B.firstChild){this.select(B.firstChild,C)}}}break;case C.LEFT:C.preventDefault();if(B.hasChildNodes()&&B.isExpanded()){B.collapse()}else{if(B.parentNode&&(this.tree.rootVisible||B.parentNode!=this.tree.getRootNode())){this.select(B.parentNode,C)}}break}}});Ext.tree.MultiSelectionModel=function(A){this.selNodes=[];this.selMap={};this.addEvents("selectionchange");Ext.apply(this,A);Ext.tree.MultiSelectionModel.superclass.constructor.call(this)};Ext.extend(Ext.tree.MultiSelectionModel,Ext.util.Observable,{init:function(A){this.tree=A;A.getTreeEl().on("keydown",this.onKeyDown,this);A.on("click",this.onNodeClick,this)},onNodeClick:function(A,B){this.select(A,B,B.ctrlKey)},select:function(A,C,B){if(B!==true){this.clearSelections(true)}if(this.isSelected(A)){this.lastSelNode=A;return A}this.selNodes.push(A);this.selMap[A.id]=A;this.lastSelNode=A;A.ui.onSelectedChange(true);this.fireEvent("selectionchange",this,this.selNodes);return A},unselect:function(B){if(this.selMap[B.id]){B.ui.onSelectedChange(false);var C=this.selNodes;var A=C.indexOf(B);if(A!=-1){this.selNodes.splice(A,1)}delete this.selMap[B.id];this.fireEvent("selectionchange",this,this.selNodes)}},clearSelections:function(B){var D=this.selNodes;if(D.length>0){for(var C=0,A=D.length;C<A;C++){D[C].ui.onSelectedChange(false)}this.selNodes=[];this.selMap={};if(B!==true){this.fireEvent("selectionchange",this,this.selNodes)}}},isSelected:function(A){return this.selMap[A.id]?true:false},getSelectedNodes:function(){return this.selNodes},onKeyDown:Ext.tree.DefaultSelectionModel.prototype.onKeyDown,selectNext:Ext.tree.DefaultSelectionModel.prototype.selectNext,selectPrevious:Ext.tree.DefaultSelectionModel.prototype.selectPrevious});
Ext.tree.TreeNode=function(A){A=A||{};if(typeof A=="string"){A={text:A}}this.childrenRendered=false;this.rendered=false;Ext.tree.TreeNode.superclass.constructor.call(this,A);this.expanded=A.expanded===true;this.isTarget=A.isTarget!==false;this.draggable=A.draggable!==false&&A.allowDrag!==false;this.allowChildren=A.allowChildren!==false&&A.allowDrop!==false;this.text=A.text;this.disabled=A.disabled===true;this.addEvents("textchange","beforeexpand","beforecollapse","expand","disabledchange","collapse","beforeclick","click","checkchange","dblclick","contextmenu","beforechildrenrendered");var B=this.attributes.uiProvider||this.defaultUI||Ext.tree.TreeNodeUI;this.ui=new B(this)};Ext.extend(Ext.tree.TreeNode,Ext.data.Node,{preventHScroll:true,isExpanded:function(){return this.expanded},getUI:function(){return this.ui},getLoader:function(){var A;return this.loader||((A=this.getOwnerTree())&&A.loader?A.loader:new Ext.tree.TreeLoader())},setFirstChild:function(A){var B=this.firstChild;Ext.tree.TreeNode.superclass.setFirstChild.call(this,A);if(this.childrenRendered&&B&&A!=B){B.renderIndent(true,true)}if(this.rendered){this.renderIndent(true,true)}},setLastChild:function(B){var A=this.lastChild;Ext.tree.TreeNode.superclass.setLastChild.call(this,B);if(this.childrenRendered&&A&&B!=A){A.renderIndent(true,true)}if(this.rendered){this.renderIndent(true,true)}},appendChild:function(B){if(!B.render&&!Ext.isArray(B)){B=this.getLoader().createNode(B)}var A=Ext.tree.TreeNode.superclass.appendChild.call(this,B);if(A&&this.childrenRendered){A.render()}this.ui.updateExpandIcon();return A},removeChild:function(A){this.ownerTree.getSelectionModel().unselect(A);Ext.tree.TreeNode.superclass.removeChild.apply(this,arguments);if(this.childrenRendered){A.ui.remove()}if(this.childNodes.length<1){this.collapse(false,false)}else{this.ui.updateExpandIcon()}if(!this.firstChild&&!this.isHiddenRoot()){this.childrenRendered=false}return A},insertBefore:function(C,A){if(!C.render){C=this.getLoader().createNode(C)}var B=Ext.tree.TreeNode.superclass.insertBefore.apply(this,arguments);if(B&&A&&this.childrenRendered){C.render()}this.ui.updateExpandIcon();return B},setText:function(B){var A=this.text;this.text=B;this.attributes.text=B;if(this.rendered){this.ui.onTextChange(this,B,A)}this.fireEvent("textchange",this,B,A)},select:function(){if(this.getOwnerTree())this.getOwnerTree().getSelectionModel().select(this)},unselect:function(){this.getOwnerTree().getSelectionModel().unselect(this)},isSelected:function(){return this.getOwnerTree().getSelectionModel().isSelected(this)},expand:function(A,B,C){if(!this.expanded){if(this.fireEvent("beforeexpand",this,A,B)===false){return }if(!this.childrenRendered){this.renderChildren()}this.expanded=true;if(!this.isHiddenRoot()&&(this.getOwnerTree().animate&&B!==false)||B){this.ui.animExpand(function(){this.fireEvent("expand",this);if(typeof C=="function"){C(this)}if(A===true){this.expandChildNodes(true)}}.createDelegate(this));return }else{this.ui.expand();this.fireEvent("expand",this);if(typeof C=="function"){C(this)}}}else{if(typeof C=="function"){C(this)}}if(A===true){this.expandChildNodes(true)}},isHiddenRoot:function(){return this.isRoot&&!this.getOwnerTree().rootVisible},collapse:function(B,E){if(this.expanded&&!this.isHiddenRoot()){if(this.fireEvent("beforecollapse",this,B,E)===false){return }this.expanded=false;if((this.getOwnerTree().animate&&E!==false)||E){this.ui.animCollapse(function(){this.fireEvent("collapse",this);if(B===true){this.collapseChildNodes(true)}}.createDelegate(this));return }else{this.ui.collapse();this.fireEvent("collapse",this)}}if(B===true){var D=this.childNodes;for(var C=0,A=D.length;C<A;C++){D[C].collapse(true,false)}}},delayedExpand:function(A){if(!this.expandProcId){this.expandProcId=this.expand.defer(A,this)}},cancelExpand:function(){if(this.expandProcId){clearTimeout(this.expandProcId)}this.expandProcId=false},toggle:function(){if(this.expanded){this.collapse()}else{this.expand()}},ensureVisible:function(B){var A=this.getOwnerTree();A.expandPath(this.parentNode.getPath(),false,function(){var C=A.getNodeById(this.id);A.getTreeEl().scrollChildIntoView(C.ui.anchor);Ext.callback(B)}.createDelegate(this))},expandChildNodes:function(B){var D=this.childNodes;for(var C=0,A=D.length;C<A;C++){D[C].expand(B)}},collapseChildNodes:function(B){var D=this.childNodes;for(var C=0,A=D.length;C<A;C++){D[C].collapse(B)}},disable:function(){this.disabled=true;this.unselect();if(this.rendered&&this.ui.onDisableChange){this.ui.onDisableChange(this,true)}this.fireEvent("disabledchange",this,true)},enable:function(){this.disabled=false;if(this.rendered&&this.ui.onDisableChange){this.ui.onDisableChange(this,false)}this.fireEvent("disabledchange",this,false)},renderChildren:function(B){if(B!==false){this.fireEvent("beforechildrenrendered",this)}var D=this.childNodes;for(var C=0,A=D.length;C<A;C++){D[C].render(true)}this.childrenRendered=true},sort:function(E,D){Ext.tree.TreeNode.superclass.sort.apply(this,arguments);if(this.childrenRendered){var C=this.childNodes;for(var B=0,A=C.length;B<A;B++){C[B].render(true)}}},render:function(A){this.ui.render(A);if(!this.rendered){this.getOwnerTree().registerNode(this);this.rendered=true;if(this.expanded){this.expanded=false;this.expand(false,false)}}},renderIndent:function(B,E){if(E){this.ui.childIndent=null}this.ui.renderIndent();if(B===true&&this.childrenRendered){var D=this.childNodes;for(var C=0,A=D.length;C<A;C++){D[C].renderIndent(true,E)}}},beginUpdate:function(){this.childrenRendered=false},endUpdate:function(){if(this.expanded&&this.rendered){this.renderChildren()}},destroy:function(){if(this.childNodes){for(var B=0,A=this.childNodes.length;B<A;B++){this.childNodes[B].destroy()}this.childNodes=null}if(this.ui.destroy){this.ui.destroy()}}});Ext.tree.TreePanel.nodeTypes.node=Ext.tree.TreeNode;
Ext.tree.AsyncTreeNode=function(A){this.loaded=A&&A.loaded===true;this.loading=false;Ext.tree.AsyncTreeNode.superclass.constructor.apply(this,arguments);this.addEvents("beforeload","load")};Ext.extend(Ext.tree.AsyncTreeNode,Ext.tree.TreeNode,{expand:function(B,D,F){if(this.loading){var E;var C=function(){if(!this.loading){clearInterval(E);this.expand(B,D,F)}}.createDelegate(this);E=setInterval(C,200);return }if(!this.loaded){if(this.fireEvent("beforeload",this)===false){return }this.loading=true;this.ui.beforeLoad(this);var A=this.loader||this.attributes.loader||this.getOwnerTree().getLoader();if(A){A.load(this,this.loadComplete.createDelegate(this,[B,D,F]));return }}Ext.tree.AsyncTreeNode.superclass.expand.call(this,B,D,F)},isLoading:function(){return this.loading},loadComplete:function(A,B,C){this.loading=false;this.loaded=true;this.ui.afterLoad(this);this.fireEvent("load",this);this.expand(A,B,C)},isLoaded:function(){return this.loaded},hasChildNodes:function(){if(!this.isLeaf()&&!this.loaded){return true}else{return Ext.tree.AsyncTreeNode.superclass.hasChildNodes.call(this)}},reload:function(A){this.collapse(false,false);while(this.firstChild){this.removeChild(this.firstChild)}this.childrenRendered=false;this.loaded=false;if(this.isHiddenRoot()){this.expanded=false}this.expand(false,false,A)}});Ext.tree.TreePanel.nodeTypes.async=Ext.tree.AsyncTreeNode;
Ext.tree.TreeNodeUI=function(A){this.node=A;this.rendered=false;this.animating=false;this.wasLeaf=true;this.ecc="x-tree-ec-icon x-tree-elbow";this.emptyIcon=Ext.BLANK_IMAGE_URL};Ext.tree.TreeNodeUI.prototype={removeChild:function(A){if(this.rendered){this.ctNode.removeChild(A.ui.getEl())}},beforeLoad:function(){this.addClass("x-tree-node-loading")},afterLoad:function(){this.removeClass("x-tree-node-loading")},onTextChange:function(B,C,A){if(this.rendered){this.textNode.innerHTML=C}},onDisableChange:function(A,B){this.disabled=B;if(this.checkbox){this.checkbox.disabled=B}if(B){this.addClass("x-tree-node-disabled")}else{this.removeClass("x-tree-node-disabled")}},onSelectedChange:function(A){if(A){this.focus();this.addClass("x-tree-selected")}else{this.removeClass("x-tree-selected")}},onMove:function(A,G,E,F,D,B){this.childIndent=null;if(this.rendered){var H=F.ui.getContainer();if(!H){this.holder=document.createElement("div");this.holder.appendChild(this.wrap);return }var C=B?B.ui.getEl():null;if(C){H.insertBefore(this.wrap,C)}else{H.appendChild(this.wrap)}this.node.renderIndent(true)}},addClass:function(A){if(this.elNode){Ext.fly(this.elNode).addClass(A)}},removeClass:function(A){if(this.elNode){Ext.fly(this.elNode).removeClass(A)}},remove:function(){if(this.rendered){this.holder=document.createElement("div");this.holder.appendChild(this.wrap)}},fireEvent:function(){return this.node.fireEvent.apply(this.node,arguments)},initEvents:function(){this.node.on("move",this.onMove,this);if(this.node.disabled){this.addClass("x-tree-node-disabled");if(this.checkbox){this.checkbox.disabled=true}}if(this.node.hidden){this.hide()}var B=this.node.getOwnerTree();var A=B.enableDD||B.enableDrag||B.enableDrop;if(A&&(!this.node.isRoot||B.rootVisible)){Ext.dd.Registry.register(this.elNode,{node:this.node,handles:this.getDDHandles(),isHandle:false})}},getDDHandles:function(){return[this.iconNode,this.textNode,this.elNode]},hide:function(){this.node.hidden=true;if(this.wrap){this.wrap.style.display="none"}},show:function(){this.node.hidden=false;if(this.wrap){this.wrap.style.display=""}},onContextMenu:function(A){if(this.node.hasListener("contextmenu")||this.node.getOwnerTree().hasListener("contextmenu")){A.preventDefault();this.focus();this.fireEvent("contextmenu",this.node,A)}},onClick:function(B){if(this.dropping){B.stopEvent();return }if(this.fireEvent("beforeclick",this.node,B)!==false){var A=B.getTarget("a");if(!this.disabled&&this.node.attributes.href&&A){this.fireEvent("click",this.node,B);return }else{if(A&&B.ctrlKey){B.stopEvent()}}B.preventDefault();if(this.disabled){return }if(this.node.attributes.singleClickExpand&&!this.animating&&this.node.isExpandable()){this.node.toggle()}this.fireEvent("click",this.node,B)}else{B.stopEvent()}},onDblClick:function(A){A.preventDefault();if(this.disabled){return }if(this.checkbox){this.toggleCheck()}if(!this.animating&&this.node.isExpandable()){this.node.toggle()}this.fireEvent("dblclick",this.node,A)},onOver:function(A){this.addClass("x-tree-node-over")},onOut:function(A){this.removeClass("x-tree-node-over")},onCheckChange:function(){var A=this.checkbox.checked;this.checkbox.defaultChecked=A;this.node.attributes.checked=A;this.fireEvent("checkchange",this.node,A)},ecClick:function(A){if(!this.animating&&this.node.isExpandable()){this.node.toggle()}},startDrop:function(){this.dropping=true},endDrop:function(){setTimeout(function(){this.dropping=false}.createDelegate(this),50)},expand:function(){this.updateExpandIcon();this.ctNode.style.display=""},focus:function(){if(!this.node.preventHScroll){try{this.anchor.focus()}catch(C){}}else{if(!Ext.isIE){try{var B=this.node.getOwnerTree().getTreeEl().dom;var A=B.scrollLeft;this.anchor.focus();B.scrollLeft=A}catch(C){}}}},toggleCheck:function(B){var A=this.checkbox;if(A){A.checked=(B===undefined?!A.checked:B);this.onCheckChange()}},blur:function(){try{this.anchor.blur()}catch(A){}},animExpand:function(B){var A=Ext.get(this.ctNode);A.stopFx();if(!this.node.isExpandable()){this.updateExpandIcon();this.ctNode.style.display="";Ext.callback(B);return }this.animating=true;this.updateExpandIcon();A.slideIn("t",{callback:function(){this.animating=false;Ext.callback(B)},scope:this,duration:this.node.ownerTree.duration||0.25})},highlight:function(){var A=this.node.getOwnerTree();Ext.fly(this.wrap).highlight(A.hlColor||"C3DAF9",{endColor:A.hlBaseColor})},collapse:function(){this.updateExpandIcon();this.ctNode.style.display="none"},animCollapse:function(B){var A=Ext.get(this.ctNode);A.enableDisplayMode("block");A.stopFx();this.animating=true;this.updateExpandIcon();A.slideOut("t",{callback:function(){this.animating=false;Ext.callback(B)},scope:this,duration:this.node.ownerTree.duration||0.25})},getContainer:function(){return this.ctNode},getEl:function(){return this.wrap},appendDDGhost:function(A){A.appendChild(this.elNode.cloneNode(true))},getDDRepairXY:function(){return Ext.lib.Dom.getXY(this.iconNode)},onRender:function(){this.render()},render:function(B){var D=this.node,A=D.attributes;var C=D.parentNode?D.parentNode.ui.getContainer():D.ownerTree.innerCt.dom;if(!this.rendered){this.rendered=true;this.renderElements(D,A,C,B);if(A.qtip){if(this.textNode.setAttributeNS){this.textNode.setAttributeNS("ext","qtip",A.qtip);if(A.qtipTitle){this.textNode.setAttributeNS("ext","qtitle",A.qtipTitle)}}else{this.textNode.setAttribute("ext:qtip",A.qtip);if(A.qtipTitle){this.textNode.setAttribute("ext:qtitle",A.qtipTitle)}}}else{if(A.qtipCfg){A.qtipCfg.target=Ext.id(this.textNode);Ext.QuickTips.register(A.qtipCfg)}}this.initEvents();if(!this.node.expanded){this.updateExpandIcon(true)}}else{if(B===true){C.appendChild(this.wrap)}}},renderElements:function(D,I,H,J){this.indentMarkup=D.parentNode?D.parentNode.ui.getChildIndent():"";var E=typeof I.checked=="boolean";var B=I.href?I.href:Ext.isGecko?"":"#";var C=["<li class=\"x-tree-node\"><div ext:tree-node-id=\"",D.id,"\" class=\"x-tree-node-el x-tree-node-leaf x-unselectable ",I.cls,"\" unselectable=\"on\">","<span class=\"x-tree-node-indent\">",this.indentMarkup,"</span>","<img src=\"",this.emptyIcon,"\" class=\"x-tree-ec-icon x-tree-elbow\" />","<img src=\"",I.icon||this.emptyIcon,"\" class=\"x-tree-node-icon",(I.icon?" x-tree-node-inline-icon":""),(I.iconCls?" "+I.iconCls:""),"\" unselectable=\"on\" />",E?("<input class=\"x-tree-node-cb\" type=\"checkbox\" "+(I.checked?"checked=\"checked\" />":"/>")):"","<a hidefocus=\"on\" class=\"x-tree-node-anchor\" href=\"",B,"\" tabIndex=\"1\" ",I.hrefTarget?" target=\""+I.hrefTarget+"\"":"","><span unselectable=\"on\">",D.text,"</span></a></div>","<ul class=\"x-tree-node-ct\" style=\"display:none;\"></ul>","</li>"].join("");var A;if(J!==true&&D.nextSibling&&(A=D.nextSibling.ui.getEl())){this.wrap=Ext.DomHelper.insertHtml("beforeBegin",A,C)}else{this.wrap=Ext.DomHelper.insertHtml("beforeEnd",H,C)}this.elNode=this.wrap.childNodes[0];this.ctNode=this.wrap.childNodes[1];var G=this.elNode.childNodes;this.indentNode=G[0];this.ecNode=G[1];this.iconNode=G[2];var F=3;if(E){this.checkbox=G[3];this.checkbox.defaultChecked=this.checkbox.checked;F++}this.anchor=G[F];this.textNode=G[F].firstChild},getAnchor:function(){return this.anchor},getTextEl:function(){return this.textNode},getIconEl:function(){return this.iconNode},isChecked:function(){return this.checkbox?this.checkbox.checked:false},updateExpandIcon:function(){if(this.rendered){var E=this.node,D,C;var A=E.isLast()?"x-tree-elbow-end":"x-tree-elbow";if(E.isExpandable()){if(E.expanded){A+="-minus";D="x-tree-node-collapsed";C="x-tree-node-expanded"}else{A+="-plus";D="x-tree-node-expanded";C="x-tree-node-collapsed"}if(this.wasLeaf){this.removeClass("x-tree-node-leaf");this.wasLeaf=false}if(this.c1!=D||this.c2!=C){Ext.fly(this.elNode).replaceClass(D,C);this.c1=D;this.c2=C}}else{if(!this.wasLeaf){Ext.fly(this.elNode).replaceClass("x-tree-node-expanded","x-tree-node-leaf");delete this.c1;delete this.c2;this.wasLeaf=true}}var B="x-tree-ec-icon "+A;if(this.ecc!=B){this.ecNode.className=B;this.ecc=B}}},getChildIndent:function(){if(!this.childIndent){var A=[];var B=this.node;while(B){if(!B.isRoot||(B.isRoot&&B.ownerTree.rootVisible)){if(!B.isLast()){A.unshift("<img src=\""+this.emptyIcon+"\" class=\"x-tree-elbow-line\" />")}else{A.unshift("<img src=\""+this.emptyIcon+"\" class=\"x-tree-icon\" />")}}B=B.parentNode}this.childIndent=A.join("")}return this.childIndent},renderIndent:function(){if(this.rendered){var A="";var B=this.node.parentNode;if(B){A=B.ui.getChildIndent()}if(this.indentMarkup!=A){this.indentNode.innerHTML=A;this.indentMarkup=A}this.updateExpandIcon()}},destroy:function(){if(this.elNode){Ext.dd.Registry.unregister(this.elNode.id)}delete this.elNode;delete this.ctNode;delete this.indentNode;delete this.ecNode;delete this.iconNode;delete this.checkbox;delete this.anchor;delete this.textNode;Ext.removeNode(this.ctNode)}};Ext.tree.RootTreeNodeUI=Ext.extend(Ext.tree.TreeNodeUI,{render:function(){if(!this.rendered){var A=this.node.ownerTree.innerCt.dom;this.node.expanded=true;A.innerHTML="<div class=\"x-tree-root-node\"></div>";this.wrap=this.ctNode=A.firstChild}},collapse:Ext.emptyFn,expand:Ext.emptyFn});
Ext.tree.TreeLoader=function(A){this.baseParams={};Ext.apply(this,A);this.addEvents("beforeload","load","loadexception");Ext.tree.TreeLoader.superclass.constructor.call(this)};Ext.extend(Ext.tree.TreeLoader,Ext.util.Observable,{uiProviders:{},clearOnLoad:true,load:function(A,B){if(this.clearOnLoad){while(A.firstChild){A.removeChild(A.firstChild)}}if(this.doPreload(A)){if(typeof B=="function"){B()}}else{if(this.dataUrl||this.url){this.requestData(A,B)}}},doPreload:function(D){if(D.attributes.children){if(D.childNodes.length<1){var C=D.attributes.children;D.beginUpdate();for(var B=0,A=C.length;B<A;B++){var E=D.appendChild(this.createNode(C[B]));if(this.preloadChildren){this.doPreload(E)}}D.endUpdate()}return true}else{return false}},getParams:function(D){var A=[],C=this.baseParams;for(var B in C){if(typeof C[B]!="function"){A.push(encodeURIComponent(B),"=",encodeURIComponent(C[B]),"&")}}A.push("node=",encodeURIComponent(D.id));return A.join("")},requestData:function(A,B){if(this.fireEvent("beforeload",this,A,B)!==false){this.transId=Ext.Ajax.request({method:this.requestMethod,url:this.dataUrl||this.url,success:this.handleResponse,failure:this.handleFailure,scope:this,argument:{callback:B,node:A},params:this.getParams(A)})}else{if(typeof B=="function"){B()}}},isLoading:function(){return !!this.transId},abort:function(){if(this.isLoading()){Ext.Ajax.abort(this.transId)}},createNode:function(attr){if(this.baseAttrs){Ext.applyIf(attr,this.baseAttrs)}if(this.applyLoader!==false){attr.loader=this}if(typeof attr.uiProvider=="string"){attr.uiProvider=this.uiProviders[attr.uiProvider]||eval(attr.uiProvider)}if(attr.nodeType){return new Ext.tree.TreePanel.nodeTypes[attr.nodeType](attr)}else{return attr.leaf?new Ext.tree.TreeNode(attr):new Ext.tree.AsyncTreeNode(attr)}},processResponse:function(response,node,callback){var json=response.responseText;try{var o=eval("("+json+")");node.beginUpdate();for(var i=0,len=o.length;i<len;i++){var n=this.createNode(o[i]);if(n){node.appendChild(n)}}node.endUpdate();if(typeof callback=="function"){callback(this,node)}}catch(e){this.handleFailure(response)}},handleResponse:function(B){this.transId=false;var A=B.argument;this.processResponse(B,A.node,A.callback);this.fireEvent("load",this,A.node,B)},handleFailure:function(B){this.transId=false;var A=B.argument;this.fireEvent("loadexception",this,A.node,B);if(typeof A.callback=="function"){A.callback(this,A.node)}}});
Ext.tree.TreeFilter=function(A,B){this.tree=A;this.filtered={};Ext.apply(this,B)};Ext.tree.TreeFilter.prototype={clearBlank:false,reverse:false,autoClear:false,remove:false,filter:function(D,A,B){A=A||"text";var C;if(typeof D=="string"){var E=D.length;if(E==0&&this.clearBlank){this.clear();return }D=D.toLowerCase();C=function(F){return F.attributes[A].substr(0,E).toLowerCase()==D}}else{if(D.exec){C=function(F){return D.test(F.attributes[A])}}else{throw"Illegal filter type, must be string or regex"}}this.filterBy(C,null,B)},filterBy:function(D,C,B){B=B||this.tree.root;if(this.autoClear){this.clear()}var A=this.filtered,H=this.reverse;var E=function(J){if(J==B){return true}if(A[J.id]){return false}var I=D.call(C||J,J);if(!I||H){A[J.id]=J;J.ui.hide();return false}return true};B.cascade(E);if(this.remove){for(var G in A){if(typeof G!="function"){var F=A[G];if(F&&F.parentNode){F.parentNode.removeChild(F)}}}}},clear:function(){var B=this.tree;var A=this.filtered;for(var D in A){if(typeof D!="function"){var C=A[D];if(C){C.ui.show()}}}this.filtered={}}};
Ext.tree.TreeSorter=function(B,C){Ext.apply(this,C);B.on("beforechildrenrendered",this.doSort,this);B.on("append",this.updateSort,this);B.on("insert",this.updateSort,this);B.on("textchange",this.updateSortParent,this);var E=this.dir&&this.dir.toLowerCase()=="desc";var F=this.property||"text";var G=this.sortType;var A=this.folderSort;var D=this.caseSensitive===true;var H=this.leafAttr||"leaf";this.sortFn=function(J,I){if(A){if(J.attributes[H]&&!I.attributes[H]){return 1}if(!J.attributes[H]&&I.attributes[H]){return -1}}var L=G?G(J):(D?J.attributes[F]:J.attributes[F].toUpperCase());var K=G?G(I):(D?I.attributes[F]:I.attributes[F].toUpperCase());if(L<K){return E?+1:-1}else{if(L>K){return E?-1:+1}else{return 0}}}};Ext.tree.TreeSorter.prototype={doSort:function(A){A.sort(this.sortFn)},compareNodes:function(B,A){return(B.text.toUpperCase()>A.text.toUpperCase()?1:-1)},updateSort:function(A,B){if(B.childrenRendered){this.doSort.defer(1,this,[B])}},updateSortParent:function(A){var B=A.parentNode;if(B&&B.childrenRendered){this.doSort.defer(1,this,[B])}}};
if(Ext.dd.DropZone){Ext.tree.TreeDropZone=function(A,B){this.allowParentInsert=false;this.allowContainerDrop=false;this.appendOnly=false;Ext.tree.TreeDropZone.superclass.constructor.call(this,A.innerCt,B);this.tree=A;this.dragOverData={};this.lastInsertClass="x-tree-no-status"};Ext.extend(Ext.tree.TreeDropZone,Ext.dd.DropZone,{ddGroup:"TreeDD",expandDelay:1000,expandNode:function(A){if(A.hasChildNodes()&&!A.isExpanded()){A.expand(false,null,this.triggerCacheRefresh.createDelegate(this))}},queueExpand:function(A){this.expandProcId=this.expandNode.defer(this.expandDelay,this,[A])},cancelExpand:function(){if(this.expandProcId){clearTimeout(this.expandProcId);this.expandProcId=false}},isValidDropPoint:function(A,I,G,D,C){if(!A||!C){return false}var E=A.node;var F=C.node;if(!(E&&E.isTarget&&I)){return false}if(I=="append"&&E.allowChildren===false){return false}if((I=="above"||I=="below")&&(E.parentNode&&E.parentNode.allowChildren===false)){return false}if(F&&(E==F||F.contains(E))){return false}var B=this.dragOverData;B.tree=this.tree;B.target=E;B.data=C;B.point=I;B.source=G;B.rawEvent=D;B.dropNode=F;B.cancel=false;var H=this.tree.fireEvent("nodedragover",B);return B.cancel===false&&H!==false},getDropPoint:function(E,D,I){var J=D.node;if(J.isRoot){return J.allowChildren!==false?"append":false}var B=D.ddel;var K=Ext.lib.Dom.getY(B),G=K+B.offsetHeight;var F=Ext.lib.Event.getPageY(E);var H=J.allowChildren===false||J.isLeaf();if(this.appendOnly||J.parentNode.allowChildren===false){return H?false:"append"}var C=false;if(!this.allowParentInsert){C=J.hasChildNodes()&&J.isExpanded()}var A=(G-K)/(H?2:3);if(F>=K&&F<(K+A)){return"above"}else{if(!C&&(H||F>=G-A&&F<=G)){return"below"}else{return"append"}}},onNodeEnter:function(D,A,C,B){this.cancelExpand()},onNodeOver:function(B,G,F,E){var I=this.getDropPoint(F,B,G);var C=B.node;if(!this.expandProcId&&I=="append"&&C.hasChildNodes()&&!B.node.isExpanded()){this.queueExpand(C)}else{if(I!="append"){this.cancelExpand()}}var D=this.dropNotAllowed;if(this.isValidDropPoint(B,I,G,F,E)){if(I){var A=B.ddel;var H;if(I=="above"){D=B.node.isFirst()?"x-tree-drop-ok-above":"x-tree-drop-ok-between";H="x-tree-drag-insert-above"}else{if(I=="below"){D=B.node.isLast()?"x-tree-drop-ok-below":"x-tree-drop-ok-between";H="x-tree-drag-insert-below"}else{D="x-tree-drop-ok-append";H="x-tree-drag-append"}}if(this.lastInsertClass!=H){Ext.fly(A).replaceClass(this.lastInsertClass,H);this.lastInsertClass=H}}}return D},onNodeOut:function(D,A,C,B){this.cancelExpand();this.removeDropIndicators(D)},onNodeDrop:function(C,I,E,D){var H=this.getDropPoint(E,C,I);var F=C.node;F.ui.startDrop();if(!this.isValidDropPoint(C,H,I,E,D)){F.ui.endDrop();return false}var G=D.node||(I.getTreeNode?I.getTreeNode(D,F,H,E):null);var B={tree:this.tree,target:F,data:D,point:H,source:I,rawEvent:E,dropNode:G,cancel:!G,dropStatus:false};var A=this.tree.fireEvent("beforenodedrop",B);if(A===false||B.cancel===true||!B.dropNode){F.ui.endDrop();return B.dropStatus}F=B.target;if(H=="append"&&!F.isExpanded()){F.expand(false,null,function(){this.completeDrop(B)}.createDelegate(this))}else{this.completeDrop(B)}return true},completeDrop:function(G){var D=G.dropNode,E=G.point,C=G.target;if(!Ext.isArray(D)){D=[D]}var F;for(var B=0,A=D.length;B<A;B++){F=D[B];if(E=="above"){C.parentNode.insertBefore(F,C)}else{if(E=="below"){C.parentNode.insertBefore(F,C.nextSibling)}else{C.appendChild(F)}}}F.ui.focus();if(Ext.enableFx&&this.tree.hlDrop){F.ui.highlight()}C.ui.endDrop();this.tree.fireEvent("nodedrop",G)},afterNodeMoved:function(A,C,E,D,B){if(Ext.enableFx&&this.tree.hlDrop){B.ui.focus();B.ui.highlight()}this.tree.fireEvent("nodedrop",this.tree,D,C,A,E)},getTree:function(){return this.tree},removeDropIndicators:function(B){if(B&&B.ddel){var A=B.ddel;Ext.fly(A).removeClass(["x-tree-drag-insert-above","x-tree-drag-insert-below","x-tree-drag-append"]);this.lastInsertClass="_noclass"}},beforeDragDrop:function(B,A,C){this.cancelExpand();return true},afterRepair:function(A){if(A&&Ext.enableFx){A.node.ui.highlight()}this.hideProxy()}})};
if(Ext.dd.DragZone){Ext.tree.TreeDragZone=function(A,B){Ext.tree.TreeDragZone.superclass.constructor.call(this,A.getTreeEl(),B);this.tree=A};Ext.extend(Ext.tree.TreeDragZone,Ext.dd.DragZone,{ddGroup:"TreeDD",onBeforeDrag:function(A,B){var C=A.node;return C&&C.draggable&&!C.disabled},onInitDrag:function(B){var A=this.dragData;this.tree.getSelectionModel().select(A.node);this.tree.eventModel.disable();this.proxy.update("");A.node.ui.appendDDGhost(this.proxy.ghost.dom);this.tree.fireEvent("startdrag",this.tree,A.node,B)},getRepairXY:function(B,A){return A.node.ui.getDDRepairXY()},onEndDrag:function(A,B){this.tree.eventModel.enable.defer(100,this.tree.eventModel);this.tree.fireEvent("enddrag",this.tree,A.node,B)},onValidDrop:function(A,B,C){this.tree.fireEvent("dragdrop",this.tree,this.dragData.node,A,B);this.hideProxy()},beforeInvalidDrop:function(A,C){var B=this.tree.getSelectionModel();B.clearSelections();B.select(this.dragData.node)},afterRepair:function(){if(Ext.enableFx&&this.tree.hlDrop){Ext.Element.fly(this.dragData.ddel).highlight(this.hlColor||"c3daf9")}this.dragging=false}})};
Ext.tree.TreeEditor=function(A,C,B){C=C||{};var D=C.events?C:new Ext.form.TextField(C);Ext.tree.TreeEditor.superclass.constructor.call(this,D,B);this.tree=A;if(!A.rendered){A.on("render",this.initEditor,this)}else{this.initEditor(A)}};Ext.extend(Ext.tree.TreeEditor,Ext.Editor,{alignment:"l-l",autoSize:false,hideEl:false,cls:"x-small-editor x-tree-editor",shim:false,shadow:"frame",maxWidth:250,editDelay:350,initEditor:function(A){A.on("beforeclick",this.beforeNodeClick,this);A.on("dblclick",this.onNodeDblClick,this);this.on("complete",this.updateNode,this);this.on("beforestartedit",this.fitToTree,this);this.on("startedit",this.bindScroll,this,{delay:10});this.on("specialkey",this.onSpecialKey,this)},fitToTree:function(B,C){var E=this.tree.getTreeEl().dom,D=C.dom;if(E.scrollLeft>D.offsetLeft){E.scrollLeft=D.offsetLeft}var A=Math.min(this.maxWidth,(E.clientWidth>20?E.clientWidth:E.offsetWidth)-Math.max(0,D.offsetLeft-E.scrollLeft)-5);this.setSize(A,"")},triggerEdit:function(A,B){this.completeEdit();if(A.attributes.editable!==false){this.editNode=A;if(this.tree.autoScroll){A.ui.getEl().scrollIntoView(this.tree.body)}this.autoEditTimer=this.startEdit.defer(this.editDelay,this,[A.ui.textNode,A.text]);return false}},bindScroll:function(){this.tree.getTreeEl().on("scroll",this.cancelEdit,this)},beforeNodeClick:function(A,B){clearTimeout(this.autoEditTimer);if(this.tree.getSelectionModel().isSelected(A)){B.stopEvent();return this.triggerEdit(A)}},onNodeDblClick:function(A,B){clearTimeout(this.autoEditTimer)},updateNode:function(A,B){this.tree.getTreeEl().un("scroll",this.cancelEdit,this);this.editNode.setText(B)},onHide:function(){Ext.tree.TreeEditor.superclass.onHide.call(this);if(this.editNode){this.editNode.ui.focus.defer(50,this.editNode.ui)}},onSpecialKey:function(C,B){var A=B.getKey();if(A==B.ESC){B.stopEvent();this.cancelEdit()}else{if(A==B.ENTER&&!B.hasModifier()){B.stopEvent();this.completeEdit()}}}});
Ext.menu.Menu=function(A){if(Ext.isArray(A)){A={items:A}}Ext.apply(this,A);this.id=this.id||Ext.id();this.addEvents("beforeshow","beforehide","show","hide","click","mouseover","mouseout","itemclick");Ext.menu.MenuMgr.register(this);Ext.menu.Menu.superclass.constructor.call(this);var B=this.items;this.items=new Ext.util.MixedCollection();if(B){this.add.apply(this,B)}};Ext.extend(Ext.menu.Menu,Ext.util.Observable,{minWidth:120,shadow:"sides",subMenuAlign:"tl-tr?",defaultAlign:"tl-bl?",allowOtherMenus:false,ignoreParentClicks:false,hidden:true,createEl:function(){return new Ext.Layer({cls:"x-menu",shadow:this.shadow,constrain:false,parentEl:this.parentEl||document.body,zindex:15000})},render:function(){if(this.el){return }var B=this.el=this.createEl();if(!this.keyNav){this.keyNav=new Ext.menu.MenuNav(this)}if(this.plain){B.addClass("x-menu-plain")}if(this.cls){B.addClass(this.cls)}this.focusEl=B.createChild({tag:"a",cls:"x-menu-focus",href:"#",onclick:"return false;",tabIndex:"-1"});var A=B.createChild({tag:"ul",cls:"x-menu-list"});A.on("click",this.onClick,this);A.on("mouseover",this.onMouseOver,this);A.on("mouseout",this.onMouseOut,this);this.items.each(function(D){var C=document.createElement("li");C.className="x-menu-list-item";A.dom.appendChild(C);D.render(C,this)},this);this.ul=A;this.autoWidth()},autoWidth:function(){var D=this.el,C=this.ul;if(!D){return }var A=this.width;if(A){D.setWidth(A)}else{if(Ext.isIE){D.setWidth(this.minWidth);var B=D.dom.offsetWidth;D.setWidth(C.getWidth()+D.getFrameWidth("lr"))}}},delayAutoWidth:function(){if(this.el){if(!this.awTask){this.awTask=new Ext.util.DelayedTask(this.autoWidth,this)}this.awTask.delay(20)}},findTargetItem:function(B){var A=B.getTarget(".x-menu-list-item",this.ul,true);if(A&&A.menuItemId){return this.items.get(A.menuItemId)}},onClick:function(B){var A;if(A=this.findTargetItem(B)){if(A.menu&&this.ignoreParentClicks){A.expandMenu()}else{A.onClick(B);this.fireEvent("click",this,A,B)}}},setActiveItem:function(A,B){if(A!=this.activeItem){if(this.activeItem){this.activeItem.deactivate()}this.activeItem=A;A.activate(B)}else{if(B){A.expandMenu()}}},tryActivate:function(F,E){var B=this.items;for(var C=F,A=B.length;C>=0&&C<A;C+=E){var D=B.get(C);if(!D.disabled&&D.canActivate){this.setActiveItem(D,false);return D}}return false},onMouseOver:function(B){var A;if(A=this.findTargetItem(B)){if(A.canActivate&&!A.disabled){this.setActiveItem(A,true)}}this.over=true;this.fireEvent("mouseover",this,B,A)},onMouseOut:function(B){var A;if(A=this.findTargetItem(B)){if(A==this.activeItem&&A.shouldDeactivate(B)){this.activeItem.deactivate();delete this.activeItem}}this.over=false;this.fireEvent("mouseout",this,B,A)},isVisible:function(){return this.el&&!this.hidden},show:function(B,C,A){this.parentMenu=A;if(!this.el){this.render()}this.fireEvent("beforeshow",this);this.showAt(this.el.getAlignToXY(B,C||this.defaultAlign),A,false)},showAt:function(C,B,A){this.parentMenu=B;if(!this.el){this.render()}if(A!==false){this.fireEvent("beforeshow",this);C=this.el.adjustForConstraints(C)}this.el.setXY(C);this.el.show();this.hidden=false;this.focus();this.fireEvent("show",this)},focus:function(){if(!this.hidden){this.doFocus.defer(50,this)}},doFocus:function(){if(!this.hidden){this.focusEl.focus()}},hide:function(A){if(this.el&&this.isVisible()){this.fireEvent("beforehide",this);if(this.activeItem){this.activeItem.deactivate();this.activeItem=null}this.el.hide();this.hidden=true;this.fireEvent("hide",this)}if(A===true&&this.parentMenu){this.parentMenu.hide(true)}},add:function(){var B=arguments,A=B.length,E;for(var C=0;C<A;C++){var D=B[C];if(D.render){E=this.addItem(D)}else{if(typeof D=="string"){if(D=="separator"||D=="-"){E=this.addSeparator()}else{E=this.addText(D)}}else{if(D.tagName||D.el){E=this.addElement(D)}else{if(typeof D=="object"){Ext.applyIf(D,this.defaults);E=this.addMenuItem(D)}}}}}return E},getEl:function(){if(!this.el){this.render()}return this.el},addSeparator:function(){return this.addItem(new Ext.menu.Separator())},addElement:function(A){return this.addItem(new Ext.menu.BaseItem(A))},addItem:function(B){this.items.add(B);if(this.ul){var A=document.createElement("li");A.className="x-menu-list-item";this.ul.dom.appendChild(A);B.render(A,this);this.delayAutoWidth()}return B},addMenuItem:function(A){if(!(A instanceof Ext.menu.Item)){if(typeof A.checked=="boolean"){A=new Ext.menu.CheckItem(A)}else{A=new Ext.menu.Item(A)}}return this.addItem(A)},addText:function(A){return this.addItem(new Ext.menu.TextItem(A))},insert:function(B,C){this.items.insert(B,C);if(this.ul){var A=document.createElement("li");A.className="x-menu-list-item";this.ul.dom.insertBefore(A,this.ul.dom.childNodes[B]);C.render(A,this);this.delayAutoWidth()}return C},remove:function(A){this.items.removeKey(A.id);A.destroy()},removeAll:function(){if(this.items){var A;while(A=this.items.first()){this.remove(A)}}},destroy:function(){this.beforeDestroy();Ext.menu.MenuMgr.unregister(this);if(this.keyNav){this.keyNav.disable()}this.removeAll();if(this.ul){this.ul.removeAllListeners()}if(this.el){this.el.destroy()}},beforeDestroy:Ext.emptyFn});Ext.menu.MenuNav=function(A){Ext.menu.MenuNav.superclass.constructor.call(this,A.el);this.scope=this.menu=A};Ext.extend(Ext.menu.MenuNav,Ext.KeyNav,{doRelay:function(C,B){var A=C.getKey();if(!this.menu.activeItem&&C.isNavKeyPress()&&A!=C.SPACE&&A!=C.RETURN){this.menu.tryActivate(0,1);return false}return B.call(this.scope||this,C,this.menu)},up:function(B,A){if(!A.tryActivate(A.items.indexOf(A.activeItem)-1,-1)){A.tryActivate(A.items.length-1,-1)}},down:function(B,A){if(!A.tryActivate(A.items.indexOf(A.activeItem)+1,1)){A.tryActivate(0,1)}},right:function(B,A){if(A.activeItem){A.activeItem.expandMenu(true)}},left:function(B,A){A.hide();if(A.parentMenu&&A.parentMenu.activeItem){A.parentMenu.activeItem.activate()}},enter:function(B,A){if(A.activeItem){B.stopPropagation();A.activeItem.onClick(B);A.fireEvent("click",this,A.activeItem);return true}}});
Ext.menu.MenuMgr=function(){var F,D,C={},A=false,K=new Date();function M(){F={};D=new Ext.util.MixedCollection();Ext.getDoc().addKeyListener(27,function(){if(D.length>0){H()}})}function H(){if(D&&D.length>0){var N=D.clone();N.each(function(O){O.hide()})}}function E(N){D.remove(N);if(D.length<1){Ext.getDoc().un("mousedown",L);A=false}}function J(N){var O=D.last();K=new Date();D.add(N);if(!A){Ext.getDoc().on("mousedown",L);A=true}if(N.parentMenu){N.getEl().setZIndex(parseInt(N.parentMenu.getEl().getStyle("z-index"),10)+3);N.parentMenu.activeChild=N}else{if(O&&O.isVisible()){N.getEl().setZIndex(parseInt(O.getEl().getStyle("z-index"),10)+3)}}}function B(N){if(N.activeChild){N.activeChild.hide()}if(N.autoHideTimer){clearTimeout(N.autoHideTimer);delete N.autoHideTimer}}function G(N){var O=N.parentMenu;if(!O&&!N.allowOtherMenus){H()}else{if(O&&O.activeChild){O.activeChild.hide()}}}function L(N){if(K.getElapsed()>50&&D.length>0&&!N.getTarget(".x-menu")){H()}}function I(O,R){if(R){var Q=C[O.group];for(var P=0,N=Q.length;P<N;P++){if(Q[P]!=O){Q[P].setChecked(false)}}}}return{hideAll:function(){H()},register:function(O){if(!F){M()}F[O.id]=O;O.on("beforehide",B);O.on("hide",E);O.on("beforeshow",G);O.on("show",J);var N=O.group;if(N&&O.events["checkchange"]){if(!C[N]){C[N]=[]}C[N].push(O);O.on("checkchange",onCheck)}},get:function(N){if(typeof N=="string"){if(!F){return null}return F[N]}else{if(N.events){return N}else{if(typeof N.length=="number"){return new Ext.menu.Menu({items:N})}else{return new Ext.menu.Menu(N)}}}},unregister:function(O){delete F[O.id];O.un("beforehide",B);O.un("hide",E);O.un("beforeshow",G);O.un("show",J);var N=O.group;if(N&&O.events["checkchange"]){C[N].remove(O);O.un("checkchange",onCheck)}},registerCheckable:function(N){var O=N.group;if(O){if(!C[O]){C[O]=[]}C[O].push(N);N.on("beforecheckchange",I)}},unregisterCheckable:function(N){var O=N.group;if(O){C[O].remove(N);N.un("beforecheckchange",I)}},getCheckedItem:function(P){var Q=C[P];if(Q){for(var O=0,N=Q.length;O<N;O++){if(Q[O].checked){return Q[O]}}}return null},setCheckedItem:function(P,R){var Q=C[P];if(Q){for(var O=0,N=Q.length;O<N;O++){if(Q[O].id==R){Q[O].setChecked(true)}}}return null}}}();
Ext.menu.BaseItem=function(A){Ext.menu.BaseItem.superclass.constructor.call(this,A);this.addEvents("click","activate","deactivate");if(this.handler){this.on("click",this.handler,this.scope)}};Ext.extend(Ext.menu.BaseItem,Ext.Component,{canActivate:false,activeClass:"x-menu-item-active",hideOnClick:true,hideDelay:100,ctype:"Ext.menu.BaseItem",actionMode:"container",render:function(A,B){this.parentMenu=B;Ext.menu.BaseItem.superclass.render.call(this,A);this.container.menuItemId=this.id},onRender:function(B,A){this.el=Ext.get(this.el);B.dom.appendChild(this.el.dom)},setHandler:function(B,A){if(this.handler){this.un("click",this.handler,this.scope)}this.on("click",this.handler=B,this.scope=A)},onClick:function(A){if(!this.disabled&&this.fireEvent("click",this,A)!==false&&this.parentMenu.fireEvent("itemclick",this,A)!==false){this.handleClick(A)}else{A.stopEvent()}},activate:function(){if(this.disabled){return false}var A=this.container;A.addClass(this.activeClass);this.region=A.getRegion().adjust(2,2,-2,-2);this.fireEvent("activate",this);return true},deactivate:function(){this.container.removeClass(this.activeClass);this.fireEvent("deactivate",this)},shouldDeactivate:function(A){return !this.region||!this.region.contains(A.getPoint())},handleClick:function(A){if(this.hideOnClick){this.parentMenu.hide.defer(this.hideDelay,this.parentMenu,[true])}},expandMenu:function(A){},hideMenu:function(){}});
Ext.menu.TextItem=function(A){if(typeof A=="string"){A={text:A}}Ext.menu.TextItem.superclass.constructor.call(this,A)};Ext.extend(Ext.menu.TextItem,Ext.menu.BaseItem,{hideOnClick:false,itemCls:"x-menu-text",onRender:function(){var A=document.createElement("span");A.className=this.itemCls;A.innerHTML=this.text;this.el=A;Ext.menu.TextItem.superclass.onRender.apply(this,arguments)}});
Ext.menu.Separator=function(A){Ext.menu.Separator.superclass.constructor.call(this,A)};Ext.extend(Ext.menu.Separator,Ext.menu.BaseItem,{itemCls:"x-menu-sep",hideOnClick:false,onRender:function(A){var B=document.createElement("span");B.className=this.itemCls;B.innerHTML="&#160;";this.el=B;A.addClass("x-menu-sep-li");Ext.menu.Separator.superclass.onRender.apply(this,arguments)}});
Ext.menu.Item=function(A){Ext.menu.Item.superclass.constructor.call(this,A);if(this.menu){this.menu=Ext.menu.MenuMgr.get(this.menu)}};Ext.extend(Ext.menu.Item,Ext.menu.BaseItem,{itemCls:"x-menu-item",canActivate:true,showDelay:200,hideDelay:200,ctype:"Ext.menu.Item",onRender:function(B,A){var C=document.createElement("a");C.hideFocus=true;C.unselectable="on";C.href=this.href||"#";if(this.hrefTarget){C.target=this.hrefTarget}C.className=this.itemCls+(this.menu?" x-menu-item-arrow":"")+(this.cls?" "+this.cls:"");C.innerHTML=String.format("<img src=\"{0}\" class=\"x-menu-item-icon {2}\" />{1}",this.icon||Ext.BLANK_IMAGE_URL,this.itemText||this.text,this.iconCls||"");this.el=C;Ext.menu.Item.superclass.onRender.call(this,B,A)},setText:function(A){this.text=A;if(this.rendered){this.el.update(String.format("<img src=\"{0}\" class=\"x-menu-item-icon {2}\">{1}",this.icon||Ext.BLANK_IMAGE_URL,this.text,this.iconCls||""));this.parentMenu.autoWidth()}},setIconClass:function(A){var B=this.iconCls;this.iconCls=A;if(this.rendered){this.el.child("img.x-menu-item-icon").replaceClass(B,this.iconCls)}},handleClick:function(A){if(!this.href){A.stopEvent()}Ext.menu.Item.superclass.handleClick.apply(this,arguments)},activate:function(A){if(Ext.menu.Item.superclass.activate.apply(this,arguments)){this.focus();if(A){this.expandMenu()}}return true},shouldDeactivate:function(A){if(Ext.menu.Item.superclass.shouldDeactivate.call(this,A)){if(this.menu&&this.menu.isVisible()){return !this.menu.getEl().getRegion().contains(A.getPoint())}return true}return false},deactivate:function(){Ext.menu.Item.superclass.deactivate.apply(this,arguments);this.hideMenu()},expandMenu:function(A){if(!this.disabled&&this.menu){clearTimeout(this.hideTimer);delete this.hideTimer;if(!this.menu.isVisible()&&!this.showTimer){this.showTimer=this.deferExpand.defer(this.showDelay,this,[A])}else{if(this.menu.isVisible()&&A){this.menu.tryActivate(0,1)}}}},deferExpand:function(A){delete this.showTimer;this.menu.show(this.container,this.parentMenu.subMenuAlign||"tl-tr?",this.parentMenu);if(A){this.menu.tryActivate(0,1)}},hideMenu:function(){clearTimeout(this.showTimer);delete this.showTimer;if(!this.hideTimer&&this.menu&&this.menu.isVisible()){this.hideTimer=this.deferHide.defer(this.hideDelay,this)}},deferHide:function(){delete this.hideTimer;if(this.menu.over){this.parentMenu.setActiveItem(this,false)}else{this.menu.hide()}}});
Ext.menu.CheckItem=function(A){Ext.menu.CheckItem.superclass.constructor.call(this,A);this.addEvents("beforecheckchange","checkchange");if(this.checkHandler){this.on("checkchange",this.checkHandler,this.scope)}Ext.menu.MenuMgr.registerCheckable(this)};Ext.extend(Ext.menu.CheckItem,Ext.menu.Item,{itemCls:"x-menu-item x-menu-check-item",groupClass:"x-menu-group-item",checked:false,ctype:"Ext.menu.CheckItem",onRender:function(A){Ext.menu.CheckItem.superclass.onRender.apply(this,arguments);if(this.group){this.el.addClass(this.groupClass)}if(this.checked){this.checked=false;this.setChecked(true,true)}},destroy:function(){Ext.menu.MenuMgr.unregisterCheckable(this);Ext.menu.CheckItem.superclass.destroy.apply(this,arguments)},setChecked:function(B,A){if(this.checked!=B&&this.fireEvent("beforecheckchange",this,B)!==false){if(this.container){this.container[B?"addClass":"removeClass"]("x-menu-item-checked")}this.checked=B;if(A!==true){this.fireEvent("checkchange",this,B)}}},handleClick:function(A){if(!this.disabled&&!(this.checked&&this.group)){this.setChecked(!this.checked)}Ext.menu.CheckItem.superclass.handleClick.apply(this,arguments)}});
Ext.menu.Adapter=function(B,A){Ext.menu.Adapter.superclass.constructor.call(this,A);this.component=B};Ext.extend(Ext.menu.Adapter,Ext.menu.BaseItem,{canActivate:true,onRender:function(B,A){this.component.render(B);this.el=this.component.getEl()},activate:function(){if(this.disabled){return false}this.component.focus();this.fireEvent("activate",this);return true},deactivate:function(){this.fireEvent("deactivate",this)},disable:function(){this.component.disable();Ext.menu.Adapter.superclass.disable.call(this)},enable:function(){this.component.enable();Ext.menu.Adapter.superclass.enable.call(this)}});
Ext.menu.DateItem=function(A){Ext.menu.DateItem.superclass.constructor.call(this,new Ext.DatePicker(A),A);this.picker=this.component;this.addEvents("select");this.picker.on("render",function(B){B.getEl().swallowEvent("click");B.container.addClass("x-menu-date-item")});this.picker.on("select",this.onSelect,this)};Ext.extend(Ext.menu.DateItem,Ext.menu.Adapter,{onSelect:function(B,A){this.fireEvent("select",this,A,B);Ext.menu.DateItem.superclass.handleClick.call(this)}});
Ext.menu.ColorItem=function(A){Ext.menu.ColorItem.superclass.constructor.call(this,new Ext.ColorPalette(A),A);this.palette=this.component;this.relayEvents(this.palette,["select"]);if(this.selectHandler){this.on("select",this.selectHandler,this.scope)}};Ext.extend(Ext.menu.ColorItem,Ext.menu.Adapter);
Ext.menu.DateMenu=function(A){Ext.menu.DateMenu.superclass.constructor.call(this,A);this.plain=true;var B=new Ext.menu.DateItem(A);this.add(B);this.picker=B.picker;this.relayEvents(B,["select"]);this.on("beforeshow",function(){if(this.picker){this.picker.hideMonthPicker(true)}},this)};Ext.extend(Ext.menu.DateMenu,Ext.menu.Menu,{cls:"x-date-menu",beforeDestroy:function(){this.picker.destroy()}});
Ext.menu.ColorMenu=function(A){Ext.menu.ColorMenu.superclass.constructor.call(this,A);this.plain=true;var B=new Ext.menu.ColorItem(A);this.add(B);this.palette=B.palette;this.relayEvents(B,["select"])};Ext.extend(Ext.menu.ColorMenu,Ext.menu.Menu);
Ext.form.Field=Ext.extend(Ext.BoxComponent,{invalidClass:"x-form-invalid",invalidText:"The value in this field is invalid",focusClass:"x-form-focus",validationEvent:"keyup",validateOnBlur:true,validationDelay:250,defaultAutoCreate:{tag:"input",type:"text",size:"20",autocomplete:"off"},fieldClass:"x-form-field",msgTarget:"qtip",msgFx:"normal",readOnly:false,disabled:false,isFormField:true,hasFocus:false,initComponent:function(){Ext.form.Field.superclass.initComponent.call(this);this.addEvents("focus","blur","specialkey","change","invalid","valid")},getName:function(){return this.rendered&&this.el.dom.name?this.el.dom.name:(this.hiddenName||"")},onRender:function(C,A){Ext.form.Field.superclass.onRender.call(this,C,A);if(!this.el){var B=this.getAutoCreate();if(!B.name){B.name=this.name||this.id}if(this.inputType){B.type=this.inputType}this.el=C.createChild(B,A)}var D=this.el.dom.type;if(D){if(D=="password"){D="text"}this.el.addClass("x-form-"+D)}if(this.readOnly){this.el.dom.readOnly=true}if(this.tabIndex!==undefined){this.el.dom.setAttribute("tabIndex",this.tabIndex)}this.el.addClass([this.fieldClass,this.cls])},initValue:function(){if(this.value!==undefined){this.setValue(this.value)}else{if(this.el.dom.value.length>0&&this.el.dom.value!=this.emptyText){this.setValue(this.el.dom.value)}}this.originalValue=this.getValue()},isDirty:function(){if(this.disabled){return false}return String(this.getValue())!==String(this.originalValue)},afterRender:function(){Ext.form.Field.superclass.afterRender.call(this);this.initEvents();this.initValue()},fireKey:function(A){if(A.isSpecialKey()){this.fireEvent("specialkey",this,A)}},reset:function(){this.setValue(this.originalValue);this.clearInvalid()},initEvents:function(){this.el.on(Ext.isIE||Ext.isSafari3?"keydown":"keypress",this.fireKey,this);this.el.on("focus",this.onFocus,this);var A=this.inEditor&&Ext.isWindows&&Ext.isGecko?{buffer:10}:null;this.el.on("blur",this.onBlur,this,A);this.originalValue=this.getValue()},onFocus:function(){if(!Ext.isOpera&&this.focusClass){this.el.addClass(this.focusClass)}if(!this.hasFocus){this.hasFocus=true;this.startValue=this.getValue();this.fireEvent("focus",this)}},beforeBlur:Ext.emptyFn,onBlur:function(){this.beforeBlur();if(!Ext.isOpera&&this.focusClass){this.el.removeClass(this.focusClass)}this.hasFocus=false;if(this.validationEvent!==false&&this.validateOnBlur&&this.validationEvent!="blur"){this.validate()}var A=this.getValue();if(String(A)!==String(this.startValue)){this.fireEvent("change",this,A,this.startValue)}this.fireEvent("blur",this)},isValid:function(A){if(this.disabled){return true}var C=this.preventMark;this.preventMark=A===true;var B=this.validateValue(this.processValue(this.getRawValue()));this.preventMark=C;return B},validate:function(){if(this.disabled||this.validateValue(this.processValue(this.getRawValue()))){this.clearInvalid();return true}return false},processValue:function(A){return A},validateValue:function(A){return true},markInvalid:function(C){if(!this.rendered||this.preventMark){return }this.el.addClass(this.invalidClass);C=C||this.invalidText;switch(this.msgTarget){case"qtip":this.el.dom.qtip=C;this.el.dom.qclass="x-form-invalid-tip";if(Ext.QuickTips){Ext.QuickTips.enable()}break;case"title":this.el.dom.title=C;break;case"under":if(!this.errorEl){var B=this.getErrorCt();if(!B){this.el.dom.title=C;break}this.errorEl=B.createChild({cls:"x-form-invalid-msg"});this.errorEl.setWidth(B.getWidth(true)-20)}this.errorEl.update(C);Ext.form.Field.msgFx[this.msgFx].show(this.errorEl,this);break;case"side":if(!this.errorIcon){var B=this.getErrorCt();if(!B){this.el.dom.title=C;break}this.errorIcon=B.createChild({cls:"x-form-invalid-icon"})}this.alignErrorIcon();this.errorIcon.dom.qtip=C;this.errorIcon.dom.qclass="x-form-invalid-tip";this.errorIcon.show();this.on("resize",this.alignErrorIcon,this);break;default:var A=Ext.getDom(this.msgTarget);A.innerHTML=C;A.style.display=this.msgDisplay;break}this.fireEvent("invalid",this,C)},getErrorCt:function(){return this.el.findParent(".x-form-element",5,true)||this.el.findParent(".x-form-field-wrap",5,true)},alignErrorIcon:function(){this.errorIcon.alignTo(this.el,"tl-tr",[2,0])},clearInvalid:function(){if(!this.rendered||this.preventMark){return }this.el.removeClass(this.invalidClass);switch(this.msgTarget){case"qtip":this.el.dom.qtip="";break;case"title":this.el.dom.title="";break;case"under":if(this.errorEl){Ext.form.Field.msgFx[this.msgFx].hide(this.errorEl,this)}break;case"side":if(this.errorIcon){this.errorIcon.dom.qtip="";this.errorIcon.hide();this.un("resize",this.alignErrorIcon,this)}break;default:var A=Ext.getDom(this.msgTarget);A.innerHTML="";A.style.display="none";break}this.fireEvent("valid",this)},getRawValue:function(){var A=this.rendered?this.el.getValue():Ext.value(this.value,"");if(A===this.emptyText){A=""}return A},getValue:function(){if(!this.rendered){return this.value}var A=this.el.getValue();if(A===this.emptyText||A===undefined){A=""}return A},setRawValue:function(A){return this.el.dom.value=(A===null||A===undefined?"":A)},setValue:function(A){this.value=A;if(this.rendered){this.el.dom.value=(A===null||A===undefined?"":A);this.validate()}},adjustSize:function(A,C){var B=Ext.form.Field.superclass.adjustSize.call(this,A,C);B.width=this.adjustWidth(this.el.dom.tagName,B.width);return B},adjustWidth:function(A,B){A=A.toLowerCase();if(typeof B=="number"&&!Ext.isSafari){if(Ext.isIE&&(A=="input"||A=="textarea")){if(A=="input"&&!Ext.isStrict){return this.inEditor?B:B-3}if(A=="input"&&Ext.isStrict){return B-(Ext.isIE6?4:1)}if(A=="textarea"&&Ext.isStrict){return B-2}}else{if(Ext.isOpera&&Ext.isStrict){if(A=="input"){return B+2}if(A=="textarea"){return B-2}}}}return B}});Ext.form.MessageTargets={"qtip":{mark:function(A){this.el.dom.qtip=msg;this.el.dom.qclass="x-form-invalid-tip";if(Ext.QuickTips){Ext.QuickTips.enable()}},clear:function(A){this.el.dom.qtip=""}},"title":{mark:function(A){this.el.dom.title=msg},clear:function(A){this.el.dom.title=""}},"under":{mark:function(B){if(!this.errorEl){var A=this.getErrorCt();if(!A){this.el.dom.title=msg;return }this.errorEl=A.createChild({cls:"x-form-invalid-msg"});this.errorEl.setWidth(A.getWidth(true)-20)}this.errorEl.update(msg);Ext.form.Field.msgFx[this.msgFx].show(this.errorEl,this)},clear:function(A){if(this.errorEl){Ext.form.Field.msgFx[this.msgFx].hide(this.errorEl,this)}else{this.el.dom.title=""}}},"side":{mark:function(B){if(!this.errorIcon){var A=this.getErrorCt();if(!A){this.el.dom.title=msg;return }this.errorIcon=A.createChild({cls:"x-form-invalid-icon"})}this.alignErrorIcon();this.errorIcon.dom.qtip=msg;this.errorIcon.dom.qclass="x-form-invalid-tip";this.errorIcon.show();this.on("resize",this.alignErrorIcon,this)},clear:function(A){if(this.errorIcon){this.errorIcon.dom.qtip="";this.errorIcon.hide();this.un("resize",this.alignErrorIcon,this)}else{this.el.dom.title=""}}},"around":{mark:function(A){},clear:function(A){}}};Ext.form.Field.msgFx={normal:{show:function(A,B){A.setDisplayed("block")},hide:function(A,B){A.setDisplayed(false).update("")}},slide:{show:function(A,B){A.slideIn("t",{stopFx:true})},hide:function(A,B){A.slideOut("t",{stopFx:true,useDisplay:true})}},slideRight:{show:function(A,B){A.fixDisplay();A.alignTo(B.el,"tl-tr");A.slideIn("l",{stopFx:true})},hide:function(A,B){A.slideOut("l",{stopFx:true,useDisplay:true})}}};Ext.reg("field",Ext.form.Field);
Ext.form.TextField=Ext.extend(Ext.form.Field,{grow:false,growMin:30,growMax:800,vtype:null,maskRe:null,disableKeyFilter:false,allowBlank:true,minLength:0,maxLength:Number.MAX_VALUE,minLengthText:"The minimum length for this field is {0}",maxLengthText:"The maximum length for this field is {0}",selectOnFocus:false,blankText:"This field is required",validator:null,regex:null,regexText:"",emptyText:null,emptyClass:"x-form-empty-field",initComponent:function(){Ext.form.TextField.superclass.initComponent.call(this);this.addEvents("autosize","keydown","keyup","keypress")},initEvents:function(){Ext.form.TextField.superclass.initEvents.call(this);if(this.validationEvent=="keyup"){this.validationTask=new Ext.util.DelayedTask(this.validate,this);this.el.on("keyup",this.filterValidation,this)}else{if(this.validationEvent!==false){this.el.on(this.validationEvent,this.validate,this,{buffer:this.validationDelay})}}if(this.selectOnFocus||this.emptyText){this.on("focus",this.preFocus,this);this.el.on("mousedown",function(){if(!this.hasFocus){this.el.on("mouseup",function(A){A.preventDefault()},this,{single:true})}},this);if(this.emptyText){this.on("blur",this.postBlur,this);this.applyEmptyText()}}if(this.maskRe||(this.vtype&&this.disableKeyFilter!==true&&(this.maskRe=Ext.form.VTypes[this.vtype+"Mask"]))){this.el.on("keypress",this.filterKeys,this)}if(this.grow){this.el.on("keyup",this.onKeyUpBuffered,this,{buffer:50});this.el.on("click",this.autoSize,this)}if(this.enableKeyEvents){this.el.on("keyup",this.onKeyUp,this);this.el.on("keydown",this.onKeyDown,this);this.el.on("keypress",this.onKeyPress,this)}},processValue:function(A){if(this.stripCharsRe){var B=A.replace(this.stripCharsRe,"");if(B!==A){this.setRawValue(B);return B}}return A},filterValidation:function(A){if(!A.isNavKeyPress()){this.validationTask.delay(this.validationDelay)}},onKeyUpBuffered:function(A){if(!A.isNavKeyPress()){this.autoSize()}},onKeyUp:function(A){this.fireEvent("keyup",this,A)},onKeyDown:function(A){this.fireEvent("keydown",this,A)},onKeyPress:function(A){this.fireEvent("keypress",this,A)},reset:function(){Ext.form.TextField.superclass.reset.call(this);this.applyEmptyText()},applyEmptyText:function(){if(this.rendered&&this.emptyText&&this.getRawValue().length<1){this.setRawValue(this.emptyText);this.el.addClass(this.emptyClass)}},preFocus:function(){if(this.emptyText){if(this.el.dom.value==this.emptyText){this.setRawValue("")}this.el.removeClass(this.emptyClass)}if(this.selectOnFocus){this.el.dom.select()}},postBlur:function(){this.applyEmptyText()},filterKeys:function(B){if(B.ctrlKey){return }var A=B.getKey();if(Ext.isGecko&&(B.isNavKeyPress()||A==B.BACKSPACE||(A==B.DELETE&&B.button==-1))){return }var D=B.getCharCode(),C=String.fromCharCode(D);if(!Ext.isGecko&&B.isSpecialKey()&&!C){return }if(!this.maskRe.test(C)){B.stopEvent()}},setValue:function(A){if(this.emptyText&&this.el&&A!==undefined&&A!==null&&A!==""){this.el.removeClass(this.emptyClass)}Ext.form.TextField.superclass.setValue.apply(this,arguments);this.applyEmptyText();this.autoSize()},validateValue:function(A){if(A.length<1||A===this.emptyText){if(this.allowBlank){this.clearInvalid();return true}else{this.markInvalid(this.blankText);return false}}if(A.length<this.minLength){this.markInvalid(String.format(this.minLengthText,this.minLength));return false}if(A.length>this.maxLength){this.markInvalid(String.format(this.maxLengthText,this.maxLength));return false}if(this.vtype){var C=Ext.form.VTypes;if(!C[this.vtype](A,this)){this.markInvalid(this.vtypeText||C[this.vtype+"Text"]);return false}}if(typeof this.validator=="function"){var B=this.validator(A);if(B!==true){this.markInvalid(B);return false}}if(this.regex&&!this.regex.test(A)){this.markInvalid(this.regexText);return false}return true},selectText:function(E,A){var C=this.getRawValue();if(C.length>0){E=E===undefined?0:E;A=A===undefined?C.length:A;var D=this.el.dom;if(D.setSelectionRange){D.setSelectionRange(E,A)}else{if(D.createTextRange){var B=D.createTextRange();B.moveStart("character",E);B.moveEnd("character",A-C.length);B.select()}}}},autoSize:function(){if(!this.grow||!this.rendered){return }if(!this.metrics){this.metrics=Ext.util.TextMetrics.createInstance(this.el)}var C=this.el;var B=C.dom.value;var D=document.createElement("div");D.appendChild(document.createTextNode(B));B=D.innerHTML;D=null;B+="&#160;";var A=Math.min(this.growMax,Math.max(this.metrics.getWidth(B)+10,this.growMin));this.el.setWidth(A);this.fireEvent("autosize",this,A)}});Ext.reg("textfield",Ext.form.TextField);
Ext.form.TriggerField=Ext.extend(Ext.form.TextField,{defaultAutoCreate:{tag:"input",type:"text",size:"16",autocomplete:"off"},hideTrigger:false,autoSize:Ext.emptyFn,monitorTab:true,deferHeight:true,mimicing:false,onResize:function(A,B){Ext.form.TriggerField.superclass.onResize.call(this,A,B);if(typeof A=="number"){this.el.setWidth(this.adjustWidth("input",A-this.trigger.getWidth()))}this.wrap.setWidth(this.el.getWidth()+this.trigger.getWidth())},adjustSize:Ext.BoxComponent.prototype.adjustSize,getResizeEl:function(){return this.wrap},getPositionEl:function(){return this.wrap},alignErrorIcon:function(){if(this.wrap){this.errorIcon.alignTo(this.wrap,"tl-tr",[2,0])}},onRender:function(B,A){Ext.form.TriggerField.superclass.onRender.call(this,B,A);this.wrap=this.el.wrap({cls:"x-form-field-wrap"});this.trigger=this.wrap.createChild(this.triggerConfig||{tag:"img",src:Ext.BLANK_IMAGE_URL,cls:"x-form-trigger "+this.triggerClass});if(this.hideTrigger){this.trigger.setDisplayed(false)}this.initTrigger();if(!this.width){this.wrap.setWidth(this.el.getWidth()+this.trigger.getWidth())}},afterRender:function(){Ext.form.TriggerField.superclass.afterRender.call(this);var A;if(Ext.isIE&&this.el.getY()!=(A=this.trigger.getY())){this.el.position();this.el.setY(A)}},initTrigger:function(){this.trigger.on("click",this.onTriggerClick,this,{preventDefault:true});this.trigger.addClassOnOver("x-form-trigger-over");this.trigger.addClassOnClick("x-form-trigger-click")},onDestroy:function(){if(this.trigger){this.trigger.removeAllListeners();this.trigger.remove()}if(this.wrap){this.wrap.remove()}Ext.form.TriggerField.superclass.onDestroy.call(this)},onFocus:function(){Ext.form.TriggerField.superclass.onFocus.call(this);if(!this.mimicing){this.wrap.addClass("x-trigger-wrap-focus");this.mimicing=true;Ext.get(Ext.isIE?document.body:document).on("mousedown",this.mimicBlur,this,{delay:10});if(this.monitorTab){this.el.on("keydown",this.checkTab,this)}}},checkTab:function(A){if(A.getKey()==A.TAB){this.triggerBlur()}},onBlur:function(){},mimicBlur:function(A){if(!this.wrap.contains(A.target)&&this.validateBlur(A)){this.triggerBlur()}},triggerBlur:function(){this.mimicing=false;Ext.get(Ext.isIE?document.body:document).un("mousedown",this.mimicBlur,this);if(this.monitorTab){this.el.un("keydown",this.checkTab,this)}this.beforeBlur();this.wrap.removeClass("x-trigger-wrap-focus");Ext.form.TriggerField.superclass.onBlur.call(this)},beforeBlur:Ext.emptyFn,validateBlur:function(A){return true},onDisable:function(){Ext.form.TriggerField.superclass.onDisable.call(this);if(this.wrap){this.wrap.addClass(this.disabledClass);this.el.removeClass(this.disabledClass)}},onEnable:function(){Ext.form.TriggerField.superclass.onEnable.call(this);if(this.wrap){this.wrap.removeClass(this.disabledClass)}},onShow:function(){if(this.wrap){this.wrap.dom.style.display="";this.wrap.dom.style.visibility="visible"}},onHide:function(){this.wrap.dom.style.display="none"},onTriggerClick:Ext.emptyFn});Ext.form.TwinTriggerField=Ext.extend(Ext.form.TriggerField,{initComponent:function(){Ext.form.TwinTriggerField.superclass.initComponent.call(this);this.triggerConfig={tag:"span",cls:"x-form-twin-triggers",cn:[{tag:"img",src:Ext.BLANK_IMAGE_URL,cls:"x-form-trigger "+this.trigger1Class},{tag:"img",src:Ext.BLANK_IMAGE_URL,cls:"x-form-trigger "+this.trigger2Class}]}},getTrigger:function(A){return this.triggers[A]},initTrigger:function(){var A=this.trigger.select(".x-form-trigger",true);this.wrap.setStyle("overflow","hidden");var B=this;A.each(function(D,F,C){D.hide=function(){var G=B.wrap.getWidth();this.dom.style.display="none";B.el.setWidth(G-B.trigger.getWidth())};D.show=function(){var G=B.wrap.getWidth();this.dom.style.display="";B.el.setWidth(G-B.trigger.getWidth())};var E="Trigger"+(C+1);if(this["hide"+E]){D.dom.style.display="none"}D.on("click",this["on"+E+"Click"],this,{preventDefault:true});D.addClassOnOver("x-form-trigger-over");D.addClassOnClick("x-form-trigger-click")},this);this.triggers=A.elements},onTrigger1Click:Ext.emptyFn,onTrigger2Click:Ext.emptyFn});Ext.reg("trigger",Ext.form.TriggerField);
Ext.form.TextArea=Ext.extend(Ext.form.TextField,{growMin:60,growMax:1000,growAppend:"&#160;\n&#160;",growPad:0,enterIsSpecial:false,preventScrollbars:false,onRender:function(B,A){if(!this.el){this.defaultAutoCreate={tag:"textarea",style:"width:100px;height:60px;",autocomplete:"off"}}Ext.form.TextArea.superclass.onRender.call(this,B,A);if(this.grow){this.textSizeEl=Ext.DomHelper.append(document.body,{tag:"pre",cls:"x-form-grow-sizer"});if(this.preventScrollbars){this.el.setStyle("overflow","hidden")}this.el.setHeight(this.growMin)}},onDestroy:function(){if(this.textSizeEl){Ext.removeNode(this.textSizeEl)}Ext.form.TextArea.superclass.onDestroy.call(this)},fireKey:function(A){if(A.isSpecialKey()&&(this.enterIsSpecial||(A.getKey()!=A.ENTER||A.hasModifier()))){this.fireEvent("specialkey",this,A)}},onKeyUp:function(A){if(!A.isNavKeyPress()||A.getKey()==A.ENTER){this.autoSize()}Ext.form.TextArea.superclass.onKeyUp.call(this,A)},autoSize:function(){if(!this.grow||!this.textSizeEl){return }var C=this.el;var A=C.dom.value;var D=this.textSizeEl;D.innerHTML="";D.appendChild(document.createTextNode(A));A=D.innerHTML;Ext.fly(D).setWidth(this.el.getWidth());if(A.length<1){A="&#160;&#160;"}else{if(Ext.isIE){A=A.replace(/\n/g,"<p>&#160;</p>")}A+=this.growAppend}D.innerHTML=A;var B=Math.min(this.growMax,Math.max(D.offsetHeight,this.growMin)+this.growPad);if(B!=this.lastHeight){this.lastHeight=B;this.el.setHeight(B);this.fireEvent("autosize",this,B)}}});Ext.reg("textarea",Ext.form.TextArea);
Ext.form.NumberField=Ext.extend(Ext.form.TextField,{fieldClass:"x-form-field x-form-num-field",allowDecimals:true,decimalSeparator:".",decimalPrecision:2,allowNegative:true,minValue:Number.NEGATIVE_INFINITY,maxValue:Number.MAX_VALUE,minText:"The minimum value for this field is {0}",maxText:"The maximum value for this field is {0}",nanText:"{0} is not a valid number",baseChars:"0123456789",initEvents:function(){Ext.form.NumberField.superclass.initEvents.call(this);var B=this.baseChars+"";if(this.allowDecimals){B+=this.decimalSeparator}if(this.allowNegative){B+="-"}this.stripCharsRe=new RegExp("[^"+B+"]","gi");var A=function(D){var C=D.getKey();if(!Ext.isIE&&(D.isSpecialKey()||C==D.BACKSPACE||C==D.DELETE)){return }var E=D.getCharCode();if(B.indexOf(String.fromCharCode(E))===-1){D.stopEvent()}};this.el.on("keypress",A,this)},validateValue:function(B){if(!Ext.form.NumberField.superclass.validateValue.call(this,B)){return false}if(B.length<1){return true}B=String(B).replace(this.decimalSeparator,".");if(isNaN(B)){this.markInvalid(String.format(this.nanText,B));return false}var A=this.parseValue(B);if(A<this.minValue){this.markInvalid(String.format(this.minText,this.minValue));return false}if(A>this.maxValue){this.markInvalid(String.format(this.maxText,this.maxValue));return false}return true},getValue:function(){return this.fixPrecision(this.parseValue(Ext.form.NumberField.superclass.getValue.call(this)))},setValue:function(A){A=typeof A=="number"?A:parseFloat(String(A).replace(this.decimalSeparator,"."));A=isNaN(A)?"":String(A).replace(".",this.decimalSeparator);Ext.form.NumberField.superclass.setValue.call(this,A)},parseValue:function(A){A=parseFloat(String(A).replace(this.decimalSeparator,"."));return isNaN(A)?"":A},fixPrecision:function(B){var A=isNaN(B);if(!this.allowDecimals||this.decimalPrecision==-1||A||!B){return A?"":B}return parseFloat(parseFloat(B).toFixed(this.decimalPrecision))},beforeBlur:function(){var A=this.parseValue(this.getRawValue());if(A){this.setValue(this.fixPrecision(A))}}});Ext.reg("numberfield",Ext.form.NumberField);
Ext.form.DateField=Ext.extend(Ext.form.TriggerField,{format:"m/d/Y",altFormats:"m/d/Y|n/j/Y|n/j/y|m/j/y|n/d/y|m/j/Y|n/d/Y|m-d-y|m-d-Y|m/d|m-d|md|mdy|mdY|d|Y-m-d",disabledDaysText:"Disabled",disabledDatesText:"Disabled",minText:"The date in this field must be equal to or after {0}",maxText:"The date in this field must be equal to or before {0}",invalidText:"{0} is not a valid date - it must be in the format {1}",triggerClass:"x-form-date-trigger",showToday:true,defaultAutoCreate:{tag:"input",type:"text",size:"10",autocomplete:"off"},initComponent:function(){Ext.form.DateField.superclass.initComponent.call(this);if(typeof this.minValue=="string"){this.minValue=this.parseDate(this.minValue)}if(typeof this.maxValue=="string"){this.maxValue=this.parseDate(this.maxValue)}this.ddMatch=null;this.initDisabledDays()},initDisabledDays:function(){if(this.disabledDates){var A=this.disabledDates;var C="(?:";for(var B=0;B<A.length;B++){C+=A[B];if(B!=A.length-1){C+="|"}}this.disabledDatesRE=new RegExp(C+")")}},setDisabledDates:function(A){this.disabledDates=A;this.initDisabledDays();if(this.menu){this.menu.picker.setDisabledDates(this.disabledDatesRE)}},setDisabledDays:function(A){this.disabledDays=A;if(this.menu){this.menu.picker.setDisabledDays(A)}},setMinValue:function(A){this.minValue=(typeof A=="string"?this.parseDate(A):A);if(this.menu){this.menu.picker.setMinDate(this.minValue)}},setMaxValue:function(A){this.maxValue=(typeof A=="string"?this.parseDate(A):A);if(this.menu){this.menu.picker.setMaxDate(this.maxValue)}},validateValue:function(E){E=this.formatDate(E);if(!Ext.form.DateField.superclass.validateValue.call(this,E)){return false}if(E.length<1){return true}var C=E;E=this.parseDate(E);if(!E){this.markInvalid(String.format(this.invalidText,C,this.format));return false}var F=E.getTime();if(this.minValue&&F<this.minValue.getTime()){this.markInvalid(String.format(this.minText,this.formatDate(this.minValue)));return false}if(this.maxValue&&F>this.maxValue.getTime()){this.markInvalid(String.format(this.maxText,this.formatDate(this.maxValue)));return false}if(this.disabledDays){var A=E.getDay();for(var B=0;B<this.disabledDays.length;B++){if(A===this.disabledDays[B]){this.markInvalid(this.disabledDaysText);return false}}}var D=this.formatDate(E);if(this.ddMatch&&this.ddMatch.test(D)){this.markInvalid(String.format(this.disabledDatesText,D));return false}return true},validateBlur:function(){return !this.menu||!this.menu.isVisible()},getValue:function(){return this.parseDate(Ext.form.DateField.superclass.getValue.call(this))||""},setValue:function(A){Ext.form.DateField.superclass.setValue.call(this,this.formatDate(this.parseDate(A)))},parseDate:function(D){if(!D||Ext.isDate(D)){return D}var B=Date.parseDate(D,this.format);if(!B&&this.altFormats){if(!this.altFormatsArray){this.altFormatsArray=this.altFormats.split("|")}for(var C=0,A=this.altFormatsArray.length;C<A&&!B;C++){B=Date.parseDate(D,this.altFormatsArray[C])}}return B},onDestroy:function(){if(this.menu){this.menu.destroy()}if(this.wrap){this.wrap.remove()}Ext.form.DateField.superclass.onDestroy.call(this)},formatDate:function(A){return Ext.isDate(A)?A.dateFormat(this.format):A},menuListeners:{select:function(A,B){this.setValue(B)},show:function(){this.onFocus()},hide:function(){this.focus.defer(10,this);var A=this.menuListeners;this.menu.un("select",A.select,this);this.menu.un("show",A.show,this);this.menu.un("hide",A.hide,this)}},onTriggerClick:function(){if(this.disabled){return }if(this.menu==null){this.menu=new Ext.menu.DateMenu()}Ext.apply(this.menu.picker,{minDate:this.minValue,maxDate:this.maxValue,disabledDatesRE:this.ddMatch,disabledDatesText:this.disabledDatesText,disabledDays:this.disabledDays,disabledDaysText:this.disabledDaysText,format:this.format,showToday:this.showToday,minText:String.format(this.minText,this.formatDate(this.minValue)),maxText:String.format(this.maxText,this.formatDate(this.maxValue))});this.menu.on(Ext.apply({},this.menuListeners,{scope:this}));this.menu.picker.setValue(this.getValue()||new Date());this.menu.show(this.el,"tl-bl?")},beforeBlur:function(){var A=this.parseDate(this.getRawValue());if(A){this.setValue(A)}}});Ext.reg("datefield",Ext.form.DateField);
Ext.form.ComboBox=Ext.extend(Ext.form.TriggerField,{defaultAutoCreate:{tag:"input",type:"text",size:"24",autocomplete:"off"},listClass:"",selectedClass:"x-combo-selected",triggerClass:"x-form-arrow-trigger",shadow:"sides",listAlign:"tl-bl?",maxHeight:300,minHeight:90,triggerAction:"query",minChars:4,typeAhead:false,queryDelay:500,pageSize:0,selectOnFocus:false,queryParam:"query",loadingText:"Loading...",resizable:false,handleHeight:8,editable:true,allQuery:"",mode:"remote",minListWidth:70,forceSelection:false,typeAheadDelay:250,lazyInit:true,initComponent:function(){Ext.form.ComboBox.superclass.initComponent.call(this);this.addEvents("expand","collapse","beforeselect","select","beforequery");if(this.transform){this.allowDomMove=false;var C=Ext.getDom(this.transform);if(!this.hiddenName){this.hiddenName=C.name}if(!this.store){this.mode="local";var G=[],D=C.options;for(var B=0,A=D.length;B<A;B++){var F=D[B];var E=(Ext.isIE?F.getAttributeNode("value").specified:F.hasAttribute("value"))?F.value:F.text;if(F.selected){this.value=E}G.push([E,F.text])}this.store=new Ext.data.SimpleStore({"id":0,fields:["value","text"],data:G});this.valueField="value";this.displayField="text"}C.name=Ext.id();if(!this.lazyRender){this.target=true;this.el=Ext.DomHelper.insertBefore(C,this.autoCreate||this.defaultAutoCreate);Ext.removeNode(C);this.render(this.el.parentNode)}else{Ext.removeNode(C)}}else{if(Ext.isArray(this.store)){if(Ext.isArray(this.store[0])){this.store=new Ext.data.SimpleStore({fields:["value","text"],data:this.store});this.valueField="value"}else{this.store=new Ext.data.SimpleStore({fields:["text"],data:this.store,expandData:true});this.valueField="text"}this.displayField="text";this.mode="local"}}this.selectedIndex=-1;if(this.mode=="local"){if(this.initialConfig.queryDelay===undefined){this.queryDelay=10}if(this.initialConfig.minChars===undefined){this.minChars=0}}},onRender:function(B,A){Ext.form.ComboBox.superclass.onRender.call(this,B,A);if(this.hiddenName){this.hiddenField=this.el.insertSibling({tag:"input",type:"hidden",name:this.hiddenName,id:(this.hiddenId||this.hiddenName)},"before",true);this.el.dom.removeAttribute("name")}if(Ext.isGecko){this.el.dom.setAttribute("autocomplete","off")}if(!this.lazyInit){this.initList()}else{this.on("focus",this.initList,this,{single:true})}if(!this.editable){this.editable=true;this.setEditable(false)}},initValue:function(){Ext.form.ComboBox.superclass.initValue.call(this);if(this.hiddenField){this.hiddenField.value=this.hiddenValue!==undefined?this.hiddenValue:this.value!==undefined?this.value:""}},initList:function(){if(!this.list){var A="x-combo-list";this.list=new Ext.Layer({shadow:this.shadow,cls:[A,this.listClass].join(" "),constrain:false});var B=this.listWidth||Math.max(this.wrap.getWidth(),this.minListWidth);this.list.setWidth(B);this.list.swallowEvent("mousewheel");this.assetHeight=0;if(this.title){this.header=this.list.createChild({cls:A+"-hd",html:this.title});this.assetHeight+=this.header.getHeight()}this.innerList=this.list.createChild({cls:A+"-inner"});this.innerList.on("mouseover",this.onViewOver,this);this.innerList.on("mousemove",this.onViewMove,this);this.innerList.setWidth(B-this.list.getFrameWidth("lr"));if(this.pageSize){this.footer=this.list.createChild({cls:A+"-ft"});this.pageTb=new Ext.PagingToolbar({store:this.store,pageSize:this.pageSize,renderTo:this.footer});this.assetHeight+=this.footer.getHeight()}if(!this.tpl){this.tpl="<tpl for=\".\"><div class=\""+A+"-item\">{"+this.displayField+"}</div></tpl>"}this.view=new Ext.DataView({applyTo:this.innerList,tpl:this.tpl,singleSelect:true,selectedClass:this.selectedClass,itemSelector:this.itemSelector||"."+A+"-item"});this.view.on("click",this.onViewClick,this);this.bindStore(this.store,true);if(this.resizable){this.resizer=new Ext.Resizable(this.list,{pinned:true,handles:"se"});this.resizer.on("resize",function(E,C,D){this.maxHeight=D-this.handleHeight-this.list.getFrameWidth("tb")-this.assetHeight;this.listWidth=C;this.innerList.setWidth(C-this.list.getFrameWidth("lr"));this.restrictHeight()},this);this[this.pageSize?"footer":"innerList"].setStyle("margin-bottom",this.handleHeight+"px")}}},bindStore:function(A,B){if(this.store&&!B){this.store.un("beforeload",this.onBeforeLoad,this);this.store.un("load",this.onLoad,this);this.store.un("loadexception",this.collapse,this);if(!A){this.store=null;if(this.view){this.view.setStore(null)}}}if(A){this.store=Ext.StoreMgr.lookup(A);this.store.on("beforeload",this.onBeforeLoad,this);this.store.on("load",this.onLoad,this);this.store.on("loadexception",this.collapse,this);if(this.view){this.view.setStore(A)}}},initEvents:function(){Ext.form.ComboBox.superclass.initEvents.call(this);this.keyNav=new Ext.KeyNav(this.el,{"up":function(A){this.inKeyMode=true;this.selectPrev()},"down":function(A){if(!this.isExpanded()){this.onTriggerClick()}else{this.inKeyMode=true;this.selectNext()}},"enter":function(A){this.onViewClick();this.delayedCheck=true;this.unsetDelayCheck.defer(10,this)},"esc":function(A){this.collapse()},"tab":function(A){this.onViewClick(false);return true},scope:this,doRelay:function(C,B,A){if(A=="down"||this.scope.isExpanded()){return Ext.KeyNav.prototype.doRelay.apply(this,arguments)}return true},forceKeyDown:true});this.queryDelay=Math.max(this.queryDelay||10,this.mode=="local"?10:250);this.dqTask=new Ext.util.DelayedTask(this.initQuery,this);if(this.typeAhead){this.taTask=new Ext.util.DelayedTask(this.onTypeAhead,this)}if(this.editable!==false){this.el.on("keyup",this.onKeyUp,this)}if(this.forceSelection){this.on("blur",this.doForce,this)}},onDestroy:function(){if(this.view){this.view.el.removeAllListeners();this.view.el.remove();this.view.purgeListeners()}if(this.list){this.list.destroy()}this.bindStore(null);Ext.form.ComboBox.superclass.onDestroy.call(this)},unsetDelayCheck:function(){delete this.delayedCheck},fireKey:function(A){if(A.isNavKeyPress()&&!this.isExpanded()&&!this.delayedCheck){this.fireEvent("specialkey",this,A)}},onResize:function(A,B){Ext.form.ComboBox.superclass.onResize.apply(this,arguments);if(this.list&&this.listWidth===undefined){var C=Math.max(A,this.minListWidth);this.list.setWidth(C);this.innerList.setWidth(C-this.list.getFrameWidth("lr"))}},onEnable:function(){Ext.form.ComboBox.superclass.onEnable.apply(this,arguments);if(this.hiddenField){this.hiddenField.disabled=false}},onDisable:function(){Ext.form.ComboBox.superclass.onDisable.apply(this,arguments);if(this.hiddenField){this.hiddenField.disabled=true}},setEditable:function(A){if(A==this.editable){return }this.editable=A;if(!A){this.el.dom.setAttribute("readOnly",true);this.el.on("mousedown",this.onTriggerClick,this);this.el.addClass("x-combo-noedit")}else{this.el.dom.setAttribute("readOnly",false);this.el.un("mousedown",this.onTriggerClick,this);this.el.removeClass("x-combo-noedit")}},onBeforeLoad:function(){if(!this.hasFocus){return }this.innerList.update(this.loadingText?"<div class=\"loading-indicator\">"+this.loadingText+"</div>":"");this.restrictHeight();this.selectedIndex=-1},onLoad:function(){if(!this.hasFocus){return }if(this.store.getCount()>0){this.expand();this.restrictHeight();if(this.lastQuery==this.allQuery){if(this.editable){this.el.dom.select()}if(!this.selectByValue(this.value,true)){this.select(0,true)}}else{this.selectNext();if(this.typeAhead&&this.lastKey!=Ext.EventObject.BACKSPACE&&this.lastKey!=Ext.EventObject.DELETE){this.taTask.delay(this.typeAheadDelay)}}}else{this.onEmptyResults()}},onTypeAhead:function(){if(this.store.getCount()>0){var B=this.store.getAt(0);var C=B.data[this.displayField];var A=C.length;var D=this.getRawValue().length;if(D!=A){this.setRawValue(C);this.selectText(D,C.length)}}},onSelect:function(A,B){if(this.fireEvent("beforeselect",this,A,B)!==false){this.setValue(A.data[this.valueField||this.displayField]);this.collapse();this.fireEvent("select",this,A,B)}},getValue:function(){if(this.valueField){return typeof this.value!="undefined"?this.value:""}else{return Ext.form.ComboBox.superclass.getValue.call(this)}},clearValue:function(){if(this.hiddenField){this.hiddenField.value=""}this.setRawValue("");this.lastSelectionText="";this.applyEmptyText();this.value=""},setValue:function(A){var C=A;if(this.valueField){var B=this.findRecord(this.valueField,A);if(B){C=B.data[this.displayField]}else{if(this.valueNotFoundText!==undefined){C=this.valueNotFoundText}}}this.lastSelectionText=C;if(this.hiddenField){this.hiddenField.value=A}Ext.form.ComboBox.superclass.setValue.call(this,C);this.value=A},findRecord:function(C,B){var A;if(this.store.getCount()>0){this.store.each(function(D){if(D.data[C]==B){A=D;return false}})}return A},onViewMove:function(B,A){this.inKeyMode=false},onViewOver:function(D,B){if(this.inKeyMode){return }var C=this.view.findItemFromChild(B);if(C){var A=this.view.indexOf(C);this.select(A,false)}},onViewClick:function(B){var A=this.view.getSelectedIndexes()[0];var C=this.store.getAt(A);if(C){this.onSelect(C,A)}if(B!==false){this.el.focus()}},restrictHeight:function(){this.innerList.dom.style.height="";var B=this.innerList.dom;var E=this.list.getFrameWidth("tb")+(this.resizable?this.handleHeight:0)+this.assetHeight;var C=Math.max(B.clientHeight,B.offsetHeight,B.scrollHeight);var A=this.getPosition()[1]-Ext.getBody().getScroll().top;var F=Ext.lib.Dom.getViewHeight()-A-this.getSize().height;var D=Math.max(A,F,this.minHeight||0)-this.list.shadowOffset-E-5;C=Math.min(C,D,this.maxHeight);this.innerList.setHeight(C);this.list.beginUpdate();this.list.setHeight(C+E);this.list.alignTo(this.wrap,this.listAlign);this.list.endUpdate()},onEmptyResults:function(){this.collapse()},isExpanded:function(){return this.list&&this.list.isVisible()},selectByValue:function(A,C){if(A!==undefined&&A!==null){var B=this.findRecord(this.valueField||this.displayField,A);if(B){this.select(this.store.indexOf(B),C);return true}}return false},select:function(A,C){this.selectedIndex=A;this.view.select(A);if(C!==false){var B=this.view.getNode(A);if(B){this.innerList.scrollChildIntoView(B,false)}}},selectNext:function(){var A=this.store.getCount();if(A>0){if(this.selectedIndex==-1){this.select(0)}else{if(this.selectedIndex<A-1){this.select(this.selectedIndex+1)}}}},selectPrev:function(){var A=this.store.getCount();if(A>0){if(this.selectedIndex==-1){this.select(0)}else{if(this.selectedIndex!=0){this.select(this.selectedIndex-1)}}}},onKeyUp:function(A){if(this.editable!==false&&!A.isSpecialKey()){this.lastKey=A.getKey();this.dqTask.delay(this.queryDelay)}},validateBlur:function(){return !this.list||!this.list.isVisible()},initQuery:function(){this.doQuery(this.getRawValue())},doForce:function(){if(this.el.dom.value.length>0){this.el.dom.value=this.lastSelectionText===undefined?"":this.lastSelectionText;this.applyEmptyText()}},doQuery:function(C,B){if(C===undefined||C===null){C=""}var A={query:C,forceAll:B,combo:this,cancel:false};if(this.fireEvent("beforequery",A)===false||A.cancel){return false}C=A.query;B=A.forceAll;if(B===true||(C.length>=this.minChars)){if(this.lastQuery!==C){this.lastQuery=C;if(this.mode=="local"){this.selectedIndex=-1;if(B){this.store.clearFilter()}else{this.store.filter(this.displayField,C)}this.onLoad()}else{this.store.baseParams[this.queryParam]=C;this.store.load({params:this.getParams(C)});this.expand()}}else{this.selectedIndex=-1;this.onLoad()}}},getParams:function(A){var B={};if(this.pageSize){B.start=0;B.limit=this.pageSize}return B},collapse:function(){if(!this.isExpanded()){return }this.list.hide();Ext.getDoc().un("mousewheel",this.collapseIf,this);Ext.getDoc().un("mousedown",this.collapseIf,this);this.fireEvent("collapse",this)},collapseIf:function(A){if(!A.within(this.wrap)&&!A.within(this.list)){this.collapse()}},expand:function(){if(this.isExpanded()||!this.hasFocus){return }this.list.alignTo(this.wrap,this.listAlign);this.list.show();this.innerList.setOverflow("auto");Ext.getDoc().on("mousewheel",this.collapseIf,this);Ext.getDoc().on("mousedown",this.collapseIf,this);this.fireEvent("expand",this)},onTriggerClick:function(){if(this.disabled){return }if(this.isExpanded()){this.collapse();this.el.focus()}else{this.onFocus({});if(this.triggerAction=="all"){this.doQuery(this.allQuery,true)}else{this.doQuery(this.getRawValue())}this.el.focus()}}});Ext.reg("combo",Ext.form.ComboBox);
Ext.form.Checkbox=Ext.extend(Ext.form.Field,{checkedCls:"x-form-check-checked",focusCls:"x-form-check-focus",overCls:"x-form-check-over",mouseDownCls:"x-form-check-down",tabIndex:0,checked:false,defaultAutoCreate:{tag:"input",type:"checkbox",autocomplete:"off"},baseCls:"x-form-check",initComponent:function(){Ext.form.Checkbox.superclass.initComponent.call(this);this.addEvents("check")},initEvents:function(){Ext.form.Checkbox.superclass.initEvents.call(this);this.initCheckEvents()},initCheckEvents:function(){this.innerWrap.removeAllListeners();this.innerWrap.addClassOnOver(this.overCls);this.innerWrap.addClassOnClick(this.mouseDownCls);this.innerWrap.on("click",this.onClick,this);this.innerWrap.on("keyup",this.onKeyUp,this)},onRender:function(B,A){Ext.form.Checkbox.superclass.onRender.call(this,B,A);if(this.inputValue!==undefined){this.el.dom.value=this.inputValue}this.el.addClass("x-hidden");this.innerWrap=this.el.wrap({tabIndex:this.tabIndex,cls:this.baseCls+"-wrap-inner"});this.wrap=this.innerWrap.wrap({cls:this.baseCls+"-wrap"});if(this.boxLabel){this.labelEl=this.innerWrap.createChild({tag:"label",htmlFor:this.el.id,cls:"x-form-cb-label",html:this.boxLabel})}this.imageEl=this.innerWrap.createChild({tag:"img",src:Ext.BLANK_IMAGE_URL,cls:this.baseCls},this.el);if(this.checked){this.setValue(true)}else{this.checked=this.el.dom.checked}this.originalValue=this.checked},onDestroy:function(){if(this.rendered){Ext.destroy(this.imageEl,this.labelEl,this.innerWrap,this.wrap)}Ext.form.Checkbox.superclass.onDestroy.call(this)},onFocus:function(A){Ext.form.Checkbox.superclass.onFocus.call(this,A);this.el.addClass(this.focusCls)},onBlur:function(A){Ext.form.Checkbox.superclass.onBlur.call(this,A);this.el.removeClass(this.focusCls)},onResize:function(){Ext.form.Checkbox.superclass.onResize.apply(this,arguments);if(!this.boxLabel&&!this.fieldLabel){this.el.alignTo(this.wrap,"c-c")}},onKeyUp:function(A){if(A.getKey()==Ext.EventObject.SPACE){this.onClick(A)}},onClick:function(A){if(!this.disabled&&!this.readOnly){this.toggleValue()}A.stopEvent()},onEnable:function(){Ext.form.Checkbox.superclass.onEnable.call(this);this.initCheckEvents()},onDisable:function(){Ext.form.Checkbox.superclass.onDisable.call(this);this.innerWrap.removeAllListeners()},toggleValue:function(){this.setValue(!this.checked)},getResizeEl:function(){if(!this.resizeEl){this.resizeEl=Ext.isSafari?this.wrap:(this.wrap.up(".x-form-element",5)||this.wrap)}return this.resizeEl},getPositionEl:function(){return this.wrap},getActionEl:function(){return this.wrap},markInvalid:Ext.emptyFn,clearInvalid:Ext.emptyFn,initValue:Ext.emptyFn,getValue:function(){if(this.rendered){return this.el.dom.checked}return false},setValue:function(A){var B=this.checked;this.checked=(A===true||A==="true"||A=="1"||String(A).toLowerCase()=="on");if(this.el&&this.el.dom){this.el.dom.checked=this.checked;this.el.dom.defaultChecked=this.checked}this.wrap[this.checked?"addClass":"removeClass"](this.checkedCls);if(B!=this.checked){this.fireEvent("check",this,this.checked);if(this.handler){this.handler.call(this.scope||this,this,this.checked)}}}});Ext.reg("checkbox",Ext.form.Checkbox);
Ext.form.CheckboxGroup=Ext.extend(Ext.form.Field,{columns:"auto",vertical:false,allowBlank:true,blankText:"You must select at least one item in this group",defaultType:"checkbox",groupCls:"x-form-check-group",onRender:function(H,F){if(!this.el){var M={cls:this.groupCls,layout:"column",border:false,renderTo:H};var A={defaultType:this.defaultType,layout:"form",border:false,defaults:{hideLabel:true,anchor:"100%"}};if(this.items[0].items){Ext.apply(M,{layoutConfig:{columns:this.items.length},defaults:this.defaults,items:this.items});for(var E=0,J=this.items.length;E<J;E++){Ext.applyIf(this.items[E],A)}}else{var D,K=[];if(typeof this.columns=="string"){this.columns=this.items.length}if(!Ext.isArray(this.columns)){var I=[];for(var E=0;E<this.columns;E++){I.push((100/this.columns)*0.01)}this.columns=I}D=this.columns.length;for(var E=0;E<D;E++){var B=Ext.apply({items:[]},A);B[this.columns[E]<=1?"columnWidth":"width"]=this.columns[E];if(this.defaults){B.defaults=Ext.apply(B.defaults||{},this.defaults)}K.push(B)}if(this.vertical){var O=Math.ceil(this.items.length/D),L=0;for(var E=0,J=this.items.length;E<J;E++){if(E>0&&E%O==0){L++}if(this.items[E].fieldLabel){this.items[E].hideLabel=false}K[L].items.push(this.items[E])}}else{for(var E=0,J=this.items.length;E<J;E++){var N=E%D;if(this.items[E].fieldLabel){this.items[E].hideLabel=false}K[N].items.push(this.items[E])}}Ext.apply(M,{layoutConfig:{columns:D},items:K})}this.panel=new Ext.Panel(M);this.el=this.panel.getEl();if(this.forId&&this.itemCls){var C=this.el.up(this.itemCls).child("label",true);if(C){C.setAttribute("htmlFor",this.forId)}}var G=this.panel.findBy(function(P){return P.isFormField},this);this.items=new Ext.util.MixedCollection();this.items.addAll(G)}Ext.form.CheckboxGroup.superclass.onRender.call(this,H,F)},validateValue:function(A){if(!this.allowBlank){var B=true;this.items.each(function(C){if(C.checked){return B=false}},this);if(B){this.markInvalid(this.blankText);return false}}return true},onDisable:function(){this.items.each(function(A){A.disable()})},onEnable:function(){this.items.each(function(A){A.enable()})},onResize:function(A,B){this.panel.setSize(A,B);this.panel.doLayout()},reset:function(){Ext.form.CheckboxGroup.superclass.reset.call(this);this.items.each(function(A){if(A.reset){A.reset()}},this)},initValue:Ext.emptyFn,getValue:Ext.emptyFn,getRawValue:Ext.emptyFn,setValue:Ext.emptyFn,setRawValue:Ext.emptyFn});Ext.reg("checkboxgroup",Ext.form.CheckboxGroup);
Ext.form.Radio=Ext.extend(Ext.form.Checkbox,{inputType:"radio",baseCls:"x-form-radio",getGroupValue:function(){var A=this.getParent().child("input[name="+this.el.dom.name+"]:checked",true);return A?A.value:null},getParent:function(){return this.el.up("form")||Ext.getBody()},toggleValue:function(){if(!this.checked){var A=this.getParent().select("input[name="+this.el.dom.name+"]");A.each(function(B){if(B.dom.id==this.id){this.setValue(true)}else{Ext.getCmp(B.dom.id).setValue(false)}},this)}},setValue:function(A){if(typeof A=="boolean"){Ext.form.Radio.superclass.setValue.call(this,A)}else{var B=this.getParent().child("input[name="+this.el.dom.name+"][value="+A+"]",true);if(B&&!B.checked){Ext.getCmp(B.id).toggleValue()}}},markInvalid:Ext.emptyFn,clearInvalid:Ext.emptyFn});Ext.reg("radio",Ext.form.Radio);
Ext.form.RadioGroup=Ext.extend(Ext.form.CheckboxGroup,{allowBlank:true,blankText:"You must select one item in this group",defaultType:"radio",groupCls:"x-form-radio-group"});Ext.reg("radiogroup",Ext.form.RadioGroup);
Ext.form.Hidden=Ext.extend(Ext.form.Field,{inputType:"hidden",onRender:function(){Ext.form.Hidden.superclass.onRender.apply(this,arguments)},initEvents:function(){this.originalValue=this.getValue()},setSize:Ext.emptyFn,setWidth:Ext.emptyFn,setHeight:Ext.emptyFn,setPosition:Ext.emptyFn,setPagePosition:Ext.emptyFn,markInvalid:Ext.emptyFn,clearInvalid:Ext.emptyFn});Ext.reg("hidden",Ext.form.Hidden);
Ext.form.BasicForm=function(B,A){Ext.apply(this,A);this.items=new Ext.util.MixedCollection(false,function(C){return C.id||(C.id=Ext.id())});this.addEvents("beforeaction","actionfailed","actioncomplete");if(B){this.initEl(B)}Ext.form.BasicForm.superclass.constructor.call(this)};Ext.extend(Ext.form.BasicForm,Ext.util.Observable,{timeout:30,activeAction:null,trackResetOnLoad:false,initEl:function(A){this.el=Ext.get(A);this.id=this.el.id||Ext.id();if(!this.standardSubmit){this.el.on("submit",this.onSubmit,this)}this.el.addClass("x-form")},getEl:function(){return this.el},onSubmit:function(A){A.stopEvent()},destroy:function(){this.items.each(function(A){Ext.destroy(A)});if(this.el){this.el.removeAllListeners();this.el.remove()}this.purgeListeners()},isValid:function(){var A=true;this.items.each(function(B){if(!B.validate()){A=false}});return A},isDirty:function(){var A=false;this.items.each(function(B){if(B.isDirty()){A=true;return false}});return A},doAction:function(B,A){if(typeof B=="string"){B=new Ext.form.Action.ACTION_TYPES[B](this,A)}if(this.fireEvent("beforeaction",this,B)!==false){this.beforeAction(B);B.run.defer(100,B)}return this},submit:function(B){if(this.standardSubmit){var A=this.isValid();if(A){this.el.dom.submit()}return A}this.doAction("submit",B);return this},load:function(A){this.doAction("load",A);return this},updateRecord:function(B){B.beginEdit();var A=B.fields;A.each(function(C){var D=this.findField(C.name);if(D){B.set(C.name,D.getValue())}},this);B.endEdit();return this},loadRecord:function(A){this.setValues(A.data);return this},beforeAction:function(A){var B=A.options;if(B.waitMsg){if(this.waitMsgTarget===true){this.el.mask(B.waitMsg,"x-mask-loading")}else{if(this.waitMsgTarget){this.waitMsgTarget=Ext.get(this.waitMsgTarget);this.waitMsgTarget.mask(B.waitMsg,"x-mask-loading")}else{Ext.MessageBox.wait(B.waitMsg,B.waitTitle||this.waitTitle||"Please Wait...")}}}},afterAction:function(A,C){this.activeAction=null;var B=A.options;if(B.waitMsg){if(this.waitMsgTarget===true){this.el.unmask()}else{if(this.waitMsgTarget){this.waitMsgTarget.unmask()}else{Ext.MessageBox.updateProgress(1);Ext.MessageBox.hide()}}}if(C){if(B.reset){this.reset()}Ext.callback(B.success,B.scope,[this,A]);this.fireEvent("actioncomplete",this,A)}else{Ext.callback(B.failure,B.scope,[this,A]);this.fireEvent("actionfailed",this,A)}},findField:function(B){var A=this.items.get(B);if(!A){this.items.each(function(C){if(C.isFormField&&(C.dataIndex==B||C.id==B||C.getName()==B)){A=C;return false}})}return A||null},markInvalid:function(G){if(Ext.isArray(G)){for(var C=0,A=G.length;C<A;C++){var B=G[C];var D=this.findField(B.id);if(D){D.markInvalid(B.msg)}}}else{var E,F;for(F in G){if(typeof G[F]!="function"&&(E=this.findField(F))){E.markInvalid(G[F])}}}return this},setValues:function(C){if(Ext.isArray(C)){for(var D=0,A=C.length;D<A;D++){var B=C[D];var E=this.findField(B.id);if(E){E.setValue(B.value);if(this.trackResetOnLoad){E.originalValue=E.getValue()}}}}else{var F,G;for(G in C){if(typeof C[G]!="function"&&(F=this.findField(G))){F.setValue(C[G]);if(this.trackResetOnLoad){F.originalValue=F.getValue()}}}}return this},getValues:function(B){var A=Ext.lib.Ajax.serializeForm(this.el.dom);if(B===true){return A}return Ext.urlDecode(A)},clearInvalid:function(){this.items.each(function(A){A.clearInvalid()});return this},reset:function(){this.items.each(function(A){A.reset()});return this},add:function(){this.items.addAll(Array.prototype.slice.call(arguments,0));return this},remove:function(A){this.items.remove(A);return this},render:function(){this.items.each(function(A){if(A.isFormField&&!A.rendered&&document.getElementById(A.id)){A.applyToMarkup(A.id)}});return this},applyToFields:function(A){this.items.each(function(B){Ext.apply(B,A)});return this},applyIfToFields:function(A){this.items.each(function(B){Ext.applyIf(B,A)});return this}});Ext.BasicForm=Ext.form.BasicForm;
Ext.FormPanel=Ext.extend(Ext.Panel,{buttonAlign:"center",minButtonWidth:75,labelAlign:"left",monitorValid:false,monitorPoll:200,layout:"form",initComponent:function(){this.form=this.createForm();this.bodyCfg={tag:"form",cls:this.baseCls+"-body",method:this.method||"POST",id:this.formId||Ext.id()};if(this.fileUpload){this.bodyCfg.enctype="multipart/form-data"}Ext.FormPanel.superclass.initComponent.call(this);this.addEvents("clientvalidation");this.relayEvents(this.form,["beforeaction","actionfailed","actioncomplete"])},createForm:function(){delete this.initialConfig.listeners;return new Ext.form.BasicForm(null,this.initialConfig)},initFields:function(){var C=this.form;var A=this;var B=function(D){if(D.isFormField){C.add(D)}else{if(D.doLayout&&D!=A){Ext.applyIf(D,{labelAlign:D.ownerCt.labelAlign,labelWidth:D.ownerCt.labelWidth,itemCls:D.ownerCt.itemCls});if(D.items){D.items.each(B)}}}};this.items.each(B)},getLayoutTarget:function(){return this.form.el},getForm:function(){return this.form},onRender:function(B,A){this.initFields();Ext.FormPanel.superclass.onRender.call(this,B,A);this.form.initEl(this.body)},beforeDestroy:function(){Ext.FormPanel.superclass.beforeDestroy.call(this);this.stopMonitoring();Ext.destroy(this.form)},initEvents:function(){Ext.FormPanel.superclass.initEvents.call(this);this.items.on("remove",this.onRemove,this);this.items.on("add",this.onAdd,this);if(this.monitorValid){this.startMonitoring()}},onAdd:function(A,B){if(B.isFormField){this.form.add(B)}},onRemove:function(A){if(A.isFormField){Ext.destroy(A.container.up(".x-form-item"));this.form.remove(A)}},startMonitoring:function(){if(!this.bound){this.bound=true;Ext.TaskMgr.start({run:this.bindHandler,interval:this.monitorPoll||200,scope:this})}},stopMonitoring:function(){this.bound=false},load:function(){this.form.load.apply(this.form,arguments)},onDisable:function(){Ext.FormPanel.superclass.onDisable.call(this);if(this.form){this.form.items.each(function(){this.disable()})}},onEnable:function(){Ext.FormPanel.superclass.onEnable.call(this);if(this.form){this.form.items.each(function(){this.enable()})}},bindHandler:function(){if(!this.bound){return false}var D=true;this.form.items.each(function(E){if(!E.isValid(true)){D=false;return false}});if(this.buttons){for(var C=0,A=this.buttons.length;C<A;C++){var B=this.buttons[C];if(B.formBind===true&&B.disabled===D){B.setDisabled(!D)}}}this.fireEvent("clientvalidation",this,D)}});Ext.reg("form",Ext.FormPanel);Ext.form.FormPanel=Ext.FormPanel;
Ext.form.FieldSet=Ext.extend(Ext.Panel,{baseCls:"x-fieldset",layout:"form",onRender:function(B,A){if(!this.el){this.el=document.createElement("fieldset");this.el.id=this.id;if(this.title||this.header||this.checkboxToggle){this.el.appendChild(document.createElement("legend")).className="x-fieldset-header"}}Ext.form.FieldSet.superclass.onRender.call(this,B,A);if(this.checkboxToggle){var C=typeof this.checkboxToggle=="object"?this.checkboxToggle:{tag:"input",type:"checkbox",name:this.checkboxName||this.id+"-checkbox"};this.checkbox=this.header.insertFirst(C);this.checkbox.dom.checked=!this.collapsed;this.checkbox.on("click",this.onCheckClick,this)}},onCollapse:function(A,B){if(this.checkbox){this.checkbox.dom.checked=false}this.afterCollapse()},onExpand:function(A,B){if(this.checkbox){this.checkbox.dom.checked=true}this.afterExpand()},onCheckClick:function(){this[this.checkbox.dom.checked?"expand":"collapse"]()}});Ext.reg("fieldset",Ext.form.FieldSet);
Ext.form.HtmlEditor=Ext.extend(Ext.form.Field,{enableFormat:true,enableFontSize:true,enableColors:true,enableAlignments:true,enableLists:true,enableSourceEdit:true,enableLinks:true,enableFont:true,createLinkText:"Please enter the URL for the link:",defaultLinkValue:"http:/"+"/",fontFamilies:["Arial","Courier New","Tahoma","Times New Roman","Verdana"],defaultFont:"tahoma",validationEvent:false,deferHeight:true,initialized:false,activated:false,sourceEditMode:false,onFocus:Ext.emptyFn,iframePad:3,hideMode:"offsets",defaultAutoCreate:{tag:"textarea",style:"width:500px;height:300px;",autocomplete:"off"},initComponent:function(){this.addEvents("initialize","activate","beforesync","beforepush","sync","push","editmodechange")},createFontOptions:function(){var D=[],B=this.fontFamilies,C,F;for(var E=0,A=B.length;E<A;E++){C=B[E];F=C.toLowerCase();D.push("<option value=\"",F,"\" style=\"font-family:",C,";\"",(this.defaultFont==F?" selected=\"true\">":">"),C,"</option>")}return D.join("")},createToolbar:function(D){var A=Ext.QuickTips&&Ext.QuickTips.isEnabled();function C(G,E,F){return{itemId:G,cls:"x-btn-icon x-edit-"+G,enableToggle:E!==false,scope:D,handler:F||D.relayBtnCmd,clickEvent:"mousedown",tooltip:A?D.buttonTips[G]||undefined:undefined,tabIndex:-1}}var B=new Ext.Toolbar({renderTo:this.wrap.dom.firstChild});B.el.on("click",function(E){E.preventDefault()});if(this.enableFont&&!Ext.isSafari2){this.fontSelect=B.el.createChild({tag:"select",cls:"x-font-select",html:this.createFontOptions()});this.fontSelect.on("change",function(){var E=this.fontSelect.dom.value;this.relayCmd("fontname",E);this.deferFocus()},this);B.add(this.fontSelect.dom,"-")}if(this.enableFormat){B.add(C("bold"),C("italic"),C("underline"))}if(this.enableFontSize){B.add("-",C("increasefontsize",false,this.adjustFont),C("decreasefontsize",false,this.adjustFont))}if(this.enableColors){B.add("-",{itemId:"forecolor",cls:"x-btn-icon x-edit-forecolor",clickEvent:"mousedown",tooltip:A?D.buttonTips["forecolor"]||undefined:undefined,tabIndex:-1,menu:new Ext.menu.ColorMenu({allowReselect:true,focus:Ext.emptyFn,value:"000000",plain:true,selectHandler:function(F,E){this.execCmd("forecolor",Ext.isSafari||Ext.isIE?"#"+E:E);this.deferFocus()},scope:this,clickEvent:"mousedown"})},{itemId:"backcolor",cls:"x-btn-icon x-edit-backcolor",clickEvent:"mousedown",tooltip:A?D.buttonTips["backcolor"]||undefined:undefined,tabIndex:-1,menu:new Ext.menu.ColorMenu({focus:Ext.emptyFn,value:"FFFFFF",plain:true,allowReselect:true,selectHandler:function(F,E){if(Ext.isGecko){this.execCmd("useCSS",false);this.execCmd("hilitecolor",E);this.execCmd("useCSS",true);this.deferFocus()}else{this.execCmd(Ext.isOpera?"hilitecolor":"backcolor",Ext.isSafari||Ext.isIE?"#"+E:E);this.deferFocus()}},scope:this,clickEvent:"mousedown"})})}if(this.enableAlignments){B.add("-",C("justifyleft"),C("justifycenter"),C("justifyright"))}if(!Ext.isSafari2){if(this.enableLinks){B.add("-",C("createlink",false,this.createLink))}if(this.enableLists){B.add("-",C("insertorderedlist"),C("insertunorderedlist"))}if(this.enableSourceEdit){B.add("-",C("sourceedit",true,function(E){this.toggleSourceEdit(E.pressed)}))}}this.tb=B},getDocMarkup:function(){return"<html><head><style type=\"text/css\">body{border:0;margin:0;padding:3px;height:98%;cursor:text;}</style></head><body></body></html>"},getEditorBody:function(){return this.doc.body||this.doc.documentElement},getDoc:function(){return Ext.isIE?this.getWin().document:(this.iframe.contentDocument||this.getWin().document)},getWin:function(){return Ext.isIE?this.iframe.contentWindow:window.frames[this.iframe.name]},onRender:function(B,A){Ext.form.HtmlEditor.superclass.onRender.call(this,B,A);this.el.dom.style.border="0 none";this.el.dom.setAttribute("tabIndex",-1);this.el.addClass("x-hidden");if(Ext.isIE){this.el.applyStyles("margin-top:-1px;margin-bottom:-1px;")}this.wrap=this.el.wrap({cls:"x-html-editor-wrap",cn:{cls:"x-html-editor-tb"}});this.createToolbar(this);this.tb.items.each(function(E){if(E.itemId!="sourceedit"){E.disable()}});var C=document.createElement("iframe");C.name=Ext.id();C.frameBorder="0";C.src=Ext.isIE?Ext.SSL_SECURE_URL:"javascript:;";this.wrap.dom.appendChild(C);this.iframe=C;this.initFrame();if(this.autoMonitorDesignMode!==false){this.monitorTask=Ext.TaskMgr.start({run:this.checkDesignMode,scope:this,interval:100})}if(!this.width){var D=this.el.getSize();this.setSize(D.width,this.height||D.height)}},initFrame:function(){this.doc=this.getDoc();this.win=this.getWin();this.doc.open();this.doc.write(this.getDocMarkup());this.doc.close();var A={run:function(){if(this.doc.body||this.doc.readyState=="complete"){Ext.TaskMgr.stop(A);this.doc.designMode="on";this.initEditor.defer(10,this)}},interval:10,duration:10000,scope:this};Ext.TaskMgr.start(A)},checkDesignMode:function(){if(this.wrap&&this.wrap.dom.offsetWidth){var A=this.getDoc();if(!A){return }if(!A.editorInitialized||String(A.designMode).toLowerCase()!="on"){this.initFrame()}}},onResize:function(B,C){Ext.form.HtmlEditor.superclass.onResize.apply(this,arguments);if(this.el&&this.iframe){if(typeof B=="number"){var D=B-this.wrap.getFrameWidth("lr");this.el.setWidth(this.adjustWidth("textarea",D));this.iframe.style.width=D+"px"}if(typeof C=="number"){var A=C-this.wrap.getFrameWidth("tb")-this.tb.el.getHeight();this.el.setHeight(this.adjustWidth("textarea",A));this.iframe.style.height=A+"px";if(this.doc){this.getEditorBody().style.height=(A-(this.iframePad*2))+"px"}}}},toggleSourceEdit:function(A){if(A===undefined){A=!this.sourceEditMode}this.sourceEditMode=A===true;var C=this.tb.items.get("sourceedit");if(C.pressed!==this.sourceEditMode){C.toggle(this.sourceEditMode);return }if(this.sourceEditMode){this.tb.items.each(function(D){if(D.itemId!="sourceedit"){D.disable()}});this.syncValue();this.iframe.className="x-hidden";this.el.removeClass("x-hidden");this.el.dom.removeAttribute("tabIndex");this.el.focus()}else{if(this.initialized){this.tb.items.each(function(D){D.enable()})}this.pushValue();this.iframe.className="";this.el.addClass("x-hidden");this.el.dom.setAttribute("tabIndex",-1);this.deferFocus()}var B=this.lastSize;if(B){delete this.lastSize;this.setSize(B)}this.fireEvent("editmodechange",this,this.sourceEditMode)},createLink:function(){var A=prompt(this.createLinkText,this.defaultLinkValue);if(A&&A!="http:/"+"/"){this.relayCmd("createlink",A)}},adjustSize:Ext.BoxComponent.prototype.adjustSize,getResizeEl:function(){return this.wrap},getPositionEl:function(){return this.wrap},initEvents:function(){this.originalValue=this.getValue()},markInvalid:Ext.emptyFn,clearInvalid:Ext.emptyFn,setValue:function(A){Ext.form.HtmlEditor.superclass.setValue.call(this,A);this.pushValue()},cleanHtml:function(A){A=String(A);if(A.length>5){if(Ext.isSafari){A=A.replace(/\sclass="(?:Apple-style-span|khtml-block-placeholder)"/gi,"")}}if(A=="&nbsp;"){A=""}return A},syncValue:function(){if(this.initialized){var D=this.getEditorBody();var C=D.innerHTML;if(Ext.isSafari){var B=D.getAttribute("style");var A=B.match(/text-align:(.*?);/i);if(A&&A[1]){C="<div style=\""+A[0]+"\">"+C+"</div>"}}C=this.cleanHtml(C);if(this.fireEvent("beforesync",this,C)!==false){this.el.dom.value=C;this.fireEvent("sync",this,C)}}},pushValue:function(){if(this.initialized){var A=this.el.dom.value;if(!this.activated&&A.length<1){A="&nbsp;"}if(this.fireEvent("beforepush",this,A)!==false){this.getEditorBody().innerHTML=A;this.fireEvent("push",this,A)}}},deferFocus:function(){this.focus.defer(10,this)},focus:function(){if(this.win&&!this.sourceEditMode){this.win.focus()}else{this.el.focus()}},initEditor:function(){var B=this.getEditorBody();var A=this.el.getStyles("font-size","font-family","background-image","background-repeat");A["background-attachment"]="fixed";B.bgProperties="fixed";Ext.DomHelper.applyStyles(B,A);if(this.doc){try{Ext.EventManager.removeAll(this.doc)}catch(C){}}this.doc=this.getDoc();Ext.EventManager.on(this.doc,{"mousedown":this.onEditorEvent,"dblclick":this.onEditorEvent,"click":this.onEditorEvent,"keyup":this.onEditorEvent,buffer:100,scope:this});if(Ext.isGecko){Ext.EventManager.on(this.doc,"keypress",this.applyCommand,this)}if(Ext.isIE||Ext.isSafari||Ext.isOpera){Ext.EventManager.on(this.doc,"keydown",this.fixKeys,this)}this.initialized=true;this.fireEvent("initialize",this);this.doc.editorInitialized=true;this.pushValue()},onDestroy:function(){if(this.monitorTask){Ext.TaskMgr.stop(this.monitorTask)}if(this.rendered){this.tb.items.each(function(A){if(A.menu){A.menu.removeAll();if(A.menu.el){A.menu.el.destroy()}}A.destroy()});this.wrap.dom.innerHTML="";this.wrap.remove()}},onFirstFocus:function(){this.activated=true;this.tb.items.each(function(D){D.enable()});if(Ext.isGecko){this.win.focus();var A=this.win.getSelection();if(!A.focusNode||A.focusNode.nodeType!=3){var B=A.getRangeAt(0);B.selectNodeContents(this.getEditorBody());B.collapse(true);this.deferFocus()}try{this.execCmd("useCSS",true);this.execCmd("styleWithCSS",false)}catch(C){}}this.fireEvent("activate",this)},adjustFont:function(B){var C=B.itemId=="increasefontsize"?1:-1;var A=parseInt(this.doc.queryCommandValue("FontSize")||2,10);if(Ext.isSafari3||Ext.isAir){if(A<=10){A=1+C}else{if(A<=13){A=2+C}else{if(A<=16){A=3+C}else{if(A<=18){A=4+C}else{if(A<=24){A=5+C}else{A=6+C}}}}}A=A.constrain(1,6)}else{if(Ext.isSafari){C*=2}A=Math.max(1,A+C)+(Ext.isSafari?"px":0)}this.execCmd("FontSize",A)},onEditorEvent:function(A){this.updateToolbar()},updateToolbar:function(){if(!this.activated){this.onFirstFocus();return }var B=this.tb.items.map,C=this.doc;if(this.enableFont&&!Ext.isSafari2){var A=(this.doc.queryCommandValue("FontName")||this.defaultFont).toLowerCase();if(A!=this.fontSelect.dom.value){this.fontSelect.dom.value=A}}if(this.enableFormat){B.bold.toggle(C.queryCommandState("bold"));B.italic.toggle(C.queryCommandState("italic"));B.underline.toggle(C.queryCommandState("underline"))}if(this.enableAlignments){B.justifyleft.toggle(C.queryCommandState("justifyleft"));B.justifycenter.toggle(C.queryCommandState("justifycenter"));B.justifyright.toggle(C.queryCommandState("justifyright"))}if(!Ext.isSafari2&&this.enableLists){B.insertorderedlist.toggle(C.queryCommandState("insertorderedlist"));B.insertunorderedlist.toggle(C.queryCommandState("insertunorderedlist"))}Ext.menu.MenuMgr.hideAll();this.syncValue()},relayBtnCmd:function(A){this.relayCmd(A.itemId)},relayCmd:function(B,A){(function(){this.focus();this.execCmd(B,A);this.updateToolbar()}).defer(10,this)},execCmd:function(B,A){this.doc.execCommand(B,false,A===undefined?null:A);this.syncValue()},applyCommand:function(B){if(B.ctrlKey){var C=B.getCharCode(),A;if(C>0){C=String.fromCharCode(C);switch(C){case"b":A="bold";break;case"i":A="italic";break;case"u":A="underline";break}if(A){this.win.focus();this.execCmd(A);this.deferFocus();B.preventDefault()}}}},insertAtCursor:function(B){if(!this.activated){return }if(Ext.isIE){this.win.focus();var A=this.doc.selection.createRange();if(A){A.collapse(true);A.pasteHTML(B);this.syncValue();this.deferFocus()}}else{if(Ext.isGecko||Ext.isOpera){this.win.focus();this.execCmd("InsertHTML",B);this.deferFocus()}else{if(Ext.isSafari){this.execCmd("InsertText",B);this.deferFocus()}}}},fixKeys:function(){if(Ext.isIE){return function(D){var A=D.getKey(),B;if(A==D.TAB){D.stopEvent();B=this.doc.selection.createRange();if(B){B.collapse(true);B.pasteHTML("&nbsp;&nbsp;&nbsp;&nbsp;");this.deferFocus()}}else{if(A==D.ENTER){B=this.doc.selection.createRange();if(B){var C=B.parentElement();if(!C||C.tagName.toLowerCase()!="li"){D.stopEvent();B.pasteHTML("<br />");B.collapse(false);B.select()}}}}}}else{if(Ext.isOpera){return function(B){var A=B.getKey();if(A==B.TAB){B.stopEvent();this.win.focus();this.execCmd("InsertHTML","&nbsp;&nbsp;&nbsp;&nbsp;");this.deferFocus()}}}else{if(Ext.isSafari){return function(B){var A=B.getKey();if(A==B.TAB){B.stopEvent();this.execCmd("InsertText","\t");this.deferFocus()}}}}}}(),getToolbar:function(){return this.tb},buttonTips:{bold:{title:"Bold (Ctrl+B)",text:"Make the selected text bold.",cls:"x-html-editor-tip"},italic:{title:"Italic (Ctrl+I)",text:"Make the selected text italic.",cls:"x-html-editor-tip"},underline:{title:"Underline (Ctrl+U)",text:"Underline the selected text.",cls:"x-html-editor-tip"},increasefontsize:{title:"Grow Text",text:"Increase the font size.",cls:"x-html-editor-tip"},decreasefontsize:{title:"Shrink Text",text:"Decrease the font size.",cls:"x-html-editor-tip"},backcolor:{title:"Text Highlight Color",text:"Change the background color of the selected text.",cls:"x-html-editor-tip"},forecolor:{title:"Font Color",text:"Change the color of the selected text.",cls:"x-html-editor-tip"},justifyleft:{title:"Align Text Left",text:"Align text to the left.",cls:"x-html-editor-tip"},justifycenter:{title:"Center Text",text:"Center text in the editor.",cls:"x-html-editor-tip"},justifyright:{title:"Align Text Right",text:"Align text to the right.",cls:"x-html-editor-tip"},insertunorderedlist:{title:"Bullet List",text:"Start a bulleted list.",cls:"x-html-editor-tip"},insertorderedlist:{title:"Numbered List",text:"Start a numbered list.",cls:"x-html-editor-tip"},createlink:{title:"Hyperlink",text:"Make the selected text a hyperlink.",cls:"x-html-editor-tip"},sourceedit:{title:"Source Edit",text:"Switch to source editing mode.",cls:"x-html-editor-tip"}}});Ext.reg("htmleditor",Ext.form.HtmlEditor);
Ext.form.TimeField=Ext.extend(Ext.form.ComboBox,{minValue:null,maxValue:null,minText:"The time in this field must be equal to or after {0}",maxText:"The time in this field must be equal to or before {0}",invalidText:"{0} is not a valid time",format:"g:i A",altFormats:"g:ia|g:iA|g:i a|g:i A|h:i|g:i|H:i|ga|ha|gA|h a|g a|g A|gi|hi|gia|hia|g|H",increment:15,mode:"local",triggerAction:"all",typeAhead:false,initDate:"1/1/2008",initComponent:function(){Ext.form.TimeField.superclass.initComponent.call(this);if(typeof this.minValue=="string"){this.minValue=this.parseDate(this.minValue)}if(typeof this.maxValue=="string"){this.maxValue=this.parseDate(this.maxValue)}if(!this.store){var B=this.parseDate(this.minValue);if(!B){B=new Date(this.initDate).clearTime()}var A=this.parseDate(this.maxValue);if(!A){A=new Date(this.initDate).clearTime().add("mi",(24*60)-1)}var C=[];while(B<=A){C.push([B.dateFormat(this.format)]);B=B.add("mi",this.increment)}this.store=new Ext.data.SimpleStore({fields:["text"],data:C});this.displayField="text"}},getValue:function(){var A=Ext.form.TimeField.superclass.getValue.call(this);return this.formatDate(this.parseDate(A))||""},setValue:function(A){Ext.form.TimeField.superclass.setValue.call(this,this.formatDate(this.parseDate(A)))},validateValue:Ext.form.DateField.prototype.validateValue,parseDate:Ext.form.DateField.prototype.parseDate,formatDate:Ext.form.DateField.prototype.formatDate,beforeBlur:function(){var A=this.parseDate(this.getRawValue());if(A){this.setValue(A.dateFormat(this.format))}}});Ext.reg("timefield",Ext.form.TimeField);
Ext.form.Label=Ext.extend(Ext.BoxComponent,{onRender:function(B,A){if(!this.el){this.el=document.createElement("label");this.el.id=this.getId();this.el.innerHTML=this.text?Ext.util.Format.htmlEncode(this.text):(this.html||"");if(this.forId){this.el.setAttribute("htmlFor",this.forId)}}Ext.form.Label.superclass.onRender.call(this,B,A)},setText:function(A,B){this.text=A;if(this.rendered){this.el.dom.innerHTML=B!==false?Ext.util.Format.htmlEncode(A):A}return this}});Ext.reg("label",Ext.form.Label);
Ext.form.Action=function(B,A){this.form=B;this.options=A||{}};Ext.form.Action.CLIENT_INVALID="client";Ext.form.Action.SERVER_INVALID="server";Ext.form.Action.CONNECT_FAILURE="connect";Ext.form.Action.LOAD_FAILURE="load";Ext.form.Action.prototype={type:"default",run:function(A){},success:function(A){},handleResponse:function(A){},failure:function(A){this.response=A;this.failureType=Ext.form.Action.CONNECT_FAILURE;this.form.afterAction(this,false)},processResponse:function(A){this.response=A;if(!A.responseText){return true}this.result=this.handleResponse(A);return this.result},getUrl:function(C){var A=this.options.url||this.form.url||this.form.el.dom.action;if(C){var B=this.getParams();if(B){A+=(A.indexOf("?")!=-1?"&":"?")+B}}return A},getMethod:function(){return(this.options.method||this.form.method||this.form.el.dom.method||"POST").toUpperCase()},getParams:function(){var A=this.form.baseParams;var B=this.options.params;if(B){if(typeof B=="object"){B=Ext.urlEncode(Ext.applyIf(B,A))}else{if(typeof B=="string"&&A){B+="&"+Ext.urlEncode(A)}}}else{if(A){B=Ext.urlEncode(A)}}return B},createCallback:function(A){var A=A||{};return{success:this.success,failure:this.failure,scope:this,timeout:(A.timeout*1000)||(this.form.timeout*1000),upload:this.form.fileUpload?this.success:undefined}}};Ext.form.Action.Submit=function(B,A){Ext.form.Action.Submit.superclass.constructor.call(this,B,A)};Ext.extend(Ext.form.Action.Submit,Ext.form.Action,{type:"submit",run:function(){var B=this.options;var C=this.getMethod();var A=C=="GET";if(B.clientValidation===false||this.form.isValid()){Ext.Ajax.request(Ext.apply(this.createCallback(B),{form:this.form.el.dom,url:this.getUrl(A),method:C,headers:B.headers,params:!A?this.getParams():null,isUpload:this.form.fileUpload}))}else{if(B.clientValidation!==false){this.failureType=Ext.form.Action.CLIENT_INVALID;this.form.afterAction(this,false)}}},success:function(B){var A=this.processResponse(B);if(A===true||A.success){this.form.afterAction(this,true);return }if(A.errors){this.form.markInvalid(A.errors);this.failureType=Ext.form.Action.SERVER_INVALID}this.form.afterAction(this,false)},handleResponse:function(C){if(this.form.errorReader){var B=this.form.errorReader.read(C);var F=[];if(B.records){for(var D=0,A=B.records.length;D<A;D++){var E=B.records[D];F[D]=E.data}}if(F.length<1){F=null}return{success:B.success,errors:F}}return Ext.decode(C.responseText)}});Ext.form.Action.Load=function(B,A){Ext.form.Action.Load.superclass.constructor.call(this,B,A);this.reader=this.form.reader};Ext.extend(Ext.form.Action.Load,Ext.form.Action,{type:"load",run:function(){Ext.Ajax.request(Ext.apply(this.createCallback(this.options),{method:this.getMethod(),url:this.getUrl(false),headers:this.options.headers,params:this.getParams()}))},success:function(B){var A=this.processResponse(B);if(A===true||!A.success||!A.data){this.failureType=Ext.form.Action.LOAD_FAILURE;this.form.afterAction(this,false);return }this.form.clearInvalid();this.form.setValues(A.data);this.form.afterAction(this,true)},handleResponse:function(B){if(this.form.reader){var A=this.form.reader.read(B);var C=A.records&&A.records[0]?A.records[0].data:null;return{success:A.success,data:C}}return Ext.decode(B.responseText)}});Ext.form.Action.ACTION_TYPES={"load":Ext.form.Action.Load,"submit":Ext.form.Action.Submit};
Ext.form.VTypes=function(){var C=/^[a-zA-Z_]+$/;var D=/^[a-zA-Z0-9_]+$/;var B=/^([\w]+)(.[\w]+)*@([\w-]+\.){1,5}([A-Za-z]){2,4}$/;var A=/(((https?)|(ftp)):\/\/([\-\w]+\.)+\w{2,3}(\/[%\-\w]+(\.\w{2,})?)*(([\w\-\.\?\\\/+@&#;`~=%!]*)(\.\w{2,})?)*\/?)/i;return{"email":function(E){return B.test(E)},"emailText":"This field should be an e-mail address in the format \"user@domain.com\"","emailMask":/[a-z0-9_\.\-@]/i,"url":function(E){return A.test(E)},"urlText":"This field should be a URL in the format \"http:/"+"/www.domain.com\"","alpha":function(E){return C.test(E)},"alphaText":"This field should only contain letters and _","alphaMask":/[a-z_]/i,"alphanum":function(E){return D.test(E)},"alphanumText":"This field should only contain letters, numbers and _","alphanumMask":/[a-z0-9_]/i}}();
Ext.grid.GridPanel=Ext.extend(Ext.Panel,{ddText:"{0} selected row{1}",minColumnWidth:25,trackMouseOver:true,enableDragDrop:false,enableColumnMove:true,enableColumnHide:true,enableHdMenu:true,stripeRows:false,autoExpandColumn:false,autoExpandMin:50,autoExpandMax:1000,view:null,loadMask:false,deferRowRender:true,rendered:false,viewReady:false,stateEvents:["columnmove","columnresize","sortchange"],initComponent:function(){Ext.grid.GridPanel.superclass.initComponent.call(this);this.autoScroll=false;this.autoWidth=false;if(Ext.isArray(this.columns)){this.colModel=new Ext.grid.ColumnModel(this.columns);delete this.columns}if(this.ds){this.store=this.ds;delete this.ds}if(this.cm){this.colModel=this.cm;delete this.cm}if(this.sm){this.selModel=this.sm;delete this.sm}this.store=Ext.StoreMgr.lookup(this.store);this.addEvents("click","dblclick","contextmenu","mousedown","mouseup","mouseover","mouseout","keypress","keydown","cellmousedown","rowmousedown","headermousedown","cellclick","celldblclick","rowclick","rowdblclick","headerclick","headerdblclick","rowcontextmenu","cellcontextmenu","headercontextmenu","bodyscroll","columnresize","columnmove","sortchange")},onRender:function(C,A){Ext.grid.GridPanel.superclass.onRender.apply(this,arguments);var D=this.body;this.el.addClass("x-grid-panel");var B=this.getView();B.init(this);D.on("mousedown",this.onMouseDown,this);D.on("click",this.onClick,this);D.on("dblclick",this.onDblClick,this);D.on("contextmenu",this.onContextMenu,this);D.on("keydown",this.onKeyDown,this);this.relayEvents(D,["mousedown","mouseup","mouseover","mouseout","keypress"]);this.getSelectionModel().init(this);this.view.render()},initEvents:function(){Ext.grid.GridPanel.superclass.initEvents.call(this);if(this.loadMask){this.loadMask=new Ext.LoadMask(this.bwrap,Ext.apply({store:this.store},this.loadMask))}},initStateEvents:function(){Ext.grid.GridPanel.superclass.initStateEvents.call(this);this.colModel.on("hiddenchange",this.saveState,this,{delay:100})},applyState:function(F){var B=this.colModel;var E=F.columns;if(E){for(var C=0,A=E.length;C<A;C++){var D=E[C];var H=B.getColumnById(D.id);if(H){H.hidden=D.hidden;H.width=D.width;var G=B.getIndexById(D.id);if(G!=C){B.moveColumn(G,C)}}}}if(F.sort){this.store[this.store.remoteSort?"setDefaultSort":"sort"](F.sort.field,F.sort.direction)}},getState:function(){var C={columns:[]};for(var B=0,D;D=this.colModel.config[B];B++){C.columns[B]={id:D.id,width:D.width};if(D.hidden){C.columns[B].hidden=true}}var A=this.store.getSortState();if(A){C.sort=A}return C},afterRender:function(){Ext.grid.GridPanel.superclass.afterRender.call(this);this.view.layout();if(this.deferRowRender){this.view.afterRender.defer(10,this.view)}else{this.view.afterRender()}this.viewReady=true},reconfigure:function(A,B){if(this.loadMask){this.loadMask.destroy();this.loadMask=new Ext.LoadMask(this.bwrap,Ext.apply({store:A},this.initialConfig.loadMask))}this.view.bind(A,B);this.store=A;this.colModel=B;if(this.rendered){this.view.refresh(true)}},onKeyDown:function(A){this.fireEvent("keydown",A)},onDestroy:function(){if(this.rendered){if(this.loadMask){this.loadMask.destroy()}var A=this.body;A.removeAllListeners();this.view.destroy();A.update("")}this.colModel.purgeListeners();Ext.grid.GridPanel.superclass.onDestroy.call(this)},processEvent:function(C,E){this.fireEvent(C,E);var D=E.getTarget();var B=this.view;var G=B.findHeaderIndex(D);if(G!==false){this.fireEvent("header"+C,this,G,E)}else{var F=B.findRowIndex(D);var A=B.findCellIndex(D);if(F!==false){this.fireEvent("row"+C,this,F,E);if(A!==false){this.fireEvent("cell"+C,this,F,A,E)}}}},onClick:function(A){this.processEvent("click",A)},onMouseDown:function(A){this.processEvent("mousedown",A)},onContextMenu:function(B,A){this.processEvent("contextmenu",B)},onDblClick:function(A){this.processEvent("dblclick",A)},walkCells:function(J,C,B,E,I){var H=this.colModel,F=H.getColumnCount();var A=this.store,G=A.getCount(),D=true;if(B<0){if(C<0){J--;D=false}while(J>=0){if(!D){C=F-1}D=false;while(C>=0){if(E.call(I||this,J,C,H)===true){return[J,C]}C--}J--}}else{if(C>=F){J++;D=false}while(J<G){if(!D){C=0}D=false;while(C<F){if(E.call(I||this,J,C,H)===true){return[J,C]}C++}J++}}return null},getSelections:function(){return this.selModel.getSelections()},onResize:function(){Ext.grid.GridPanel.superclass.onResize.apply(this,arguments);if(this.viewReady){this.view.layout()}},getGridEl:function(){return this.body},stopEditing:function(){},getSelectionModel:function(){if(!this.selModel){this.selModel=new Ext.grid.RowSelectionModel(this.disableSelection?{selectRow:Ext.emptyFn}:null)}return this.selModel},getStore:function(){return this.store},getColumnModel:function(){return this.colModel},getView:function(){if(!this.view){this.view=new Ext.grid.GridView(this.viewConfig)}return this.view},getDragDropText:function(){var A=this.selModel.getCount();return String.format(this.ddText,A,A==1?"":"s")}});Ext.reg("grid",Ext.grid.GridPanel);
Ext.grid.GridView=function(A){Ext.apply(this,A);this.addEvents("beforerowremoved","beforerowsinserted","beforerefresh","rowremoved","rowsinserted","rowupdated","refresh");Ext.grid.GridView.superclass.constructor.call(this)};Ext.extend(Ext.grid.GridView,Ext.util.Observable,{deferEmptyText:true,scrollOffset:19,autoFill:false,forceFit:false,sortClasses:["sort-asc","sort-desc"],sortAscText:"Sort Ascending",sortDescText:"Sort Descending",columnsText:"Columns",borderWidth:2,tdClass:"x-grid3-cell",hdCls:"x-grid3-hd",cellSelectorDepth:4,rowSelectorDepth:10,cellSelector:"td.x-grid3-cell",rowSelector:"div.x-grid3-row",initTemplates:function(){var C=this.templates||{};if(!C.master){C.master=new Ext.Template("<div class=\"x-grid3\" hidefocus=\"true\">","<div class=\"x-grid3-viewport\">","<div class=\"x-grid3-header\"><div class=\"x-grid3-header-inner\"><div class=\"x-grid3-header-offset\">{header}</div></div><div class=\"x-clear\"></div></div>","<div class=\"x-grid3-scroller\"><div class=\"x-grid3-body\">{body}</div><a href=\"#\" class=\"x-grid3-focus\" tabIndex=\"-1\"></a></div>","</div>","<div class=\"x-grid3-resize-marker\">&#160;</div>","<div class=\"x-grid3-resize-proxy\">&#160;</div>","</div>")}if(!C.header){C.header=new Ext.Template("<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" style=\"{tstyle}\">","<thead><tr class=\"x-grid3-hd-row\">{cells}</tr></thead>","</table>")}if(!C.hcell){C.hcell=new Ext.Template("<td class=\"x-grid3-hd x-grid3-cell x-grid3-td-{id}\" style=\"{style}\"><div {tooltip} {attr} class=\"x-grid3-hd-inner x-grid3-hd-{id}\" unselectable=\"on\" style=\"{istyle}\">",this.grid.enableHdMenu?"<a class=\"x-grid3-hd-btn\" href=\"#\"></a>":"","{value}<img class=\"x-grid3-sort-icon\" src=\"",Ext.BLANK_IMAGE_URL,"\" />","</div></td>")}if(!C.body){C.body=new Ext.Template("{rows}")}if(!C.row){C.row=new Ext.Template("<div class=\"x-grid3-row {alt}\" style=\"{tstyle}\"><table class=\"x-grid3-row-table\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" style=\"{tstyle}\">","<tbody><tr>{cells}</tr>",(this.enableRowBody?"<tr class=\"x-grid3-row-body-tr\" style=\"{bodyStyle}\"><td colspan=\"{cols}\" class=\"x-grid3-body-cell\" tabIndex=\"0\" hidefocus=\"on\"><div class=\"x-grid3-row-body\">{body}</div></td></tr>":""),"</tbody></table></div>")}if(!C.cell){C.cell=new Ext.Template("<td class=\"x-grid3-col x-grid3-cell x-grid3-td-{id} {css}\" style=\"{style}\" tabIndex=\"0\" {cellAttr}>","<div class=\"x-grid3-cell-inner x-grid3-col-{id}\" unselectable=\"on\" {attr}>{value}</div>","</td>")}for(var A in C){var B=C[A];if(B&&typeof B.compile=="function"&&!B.compiled){B.disableFormats=true;B.compile()}}this.templates=C;this.colRe=new RegExp("x-grid3-td-([^\\s]+)","")},fly:function(A){if(!this._flyweight){this._flyweight=new Ext.Element.Flyweight(document.body)}this._flyweight.dom=A;return this._flyweight},getEditorParent:function(A){return this.scroller.dom},initElements:function(){var C=Ext.Element;var B=this.grid.getGridEl().dom.firstChild;var A=B.childNodes;this.el=new C(B);this.mainWrap=new C(A[0]);this.mainHd=new C(this.mainWrap.dom.firstChild);if(this.grid.hideHeaders){this.mainHd.setDisplayed(false)}this.innerHd=this.mainHd.dom.firstChild;this.scroller=new C(this.mainWrap.dom.childNodes[1]);if(this.forceFit){this.scroller.setStyle("overflow-x","hidden")}this.mainBody=new C(this.scroller.dom.firstChild);this.focusEl=new C(this.scroller.dom.childNodes[1]);this.focusEl.swallowEvent("click",true);this.resizeMarker=new C(A[1]);this.resizeProxy=new C(A[2])},getRows:function(){return this.hasRows()?this.mainBody.dom.childNodes:[]},findCell:function(A){if(!A){return false}return this.fly(A).findParent(this.cellSelector,this.cellSelectorDepth)},findCellIndex:function(C,B){var A=this.findCell(C);if(A&&(!B||this.fly(A).hasClass(B))){return this.getCellIndex(A)}return false},getCellIndex:function(B){if(B){var A=B.className.match(this.colRe);if(A&&A[1]){return this.cm.getIndexById(A[1])}}return false},findHeaderCell:function(B){var A=this.findCell(B);return A&&this.fly(A).hasClass(this.hdCls)?A:null},findHeaderIndex:function(A){return this.findCellIndex(A,this.hdCls)},findRow:function(A){if(!A){return false}return this.fly(A).findParent(this.rowSelector,this.rowSelectorDepth)},findRowIndex:function(A){var B=this.findRow(A);return B?B.rowIndex:false},getRow:function(A){return this.getRows()[A]},getCell:function(B,A){return this.getRow(B).getElementsByTagName("td")[A]},getHeaderCell:function(A){return this.mainHd.dom.getElementsByTagName("td")[A]},addRowClass:function(C,A){var B=this.getRow(C);if(B){this.fly(B).addClass(A)}},removeRowClass:function(C,A){var B=this.getRow(C);if(B){this.fly(B).removeClass(A)}},removeRow:function(A){Ext.removeNode(this.getRow(A));this.focusRow(A)},removeRows:function(C,A){var B=this.mainBody.dom;for(var D=C;D<=A;D++){Ext.removeNode(B.childNodes[C])}this.focusRow(C)},getScrollState:function(){var A=this.scroller.dom;return{left:A.scrollLeft,top:A.scrollTop}},restoreScroll:function(A){var B=this.scroller.dom;B.scrollLeft=A.left;B.scrollTop=A.top},scrollToTop:function(){this.scroller.dom.scrollTop=0;this.scroller.dom.scrollLeft=0},syncScroll:function(){this.syncHeaderScroll();var A=this.scroller.dom;this.grid.fireEvent("bodyscroll",A.scrollLeft,A.scrollTop)},syncHeaderScroll:function(){var A=this.scroller.dom;this.innerHd.scrollLeft=A.scrollLeft;this.innerHd.scrollLeft=A.scrollLeft},updateSortIcon:function(B,A){var D=this.sortClasses;var C=this.mainHd.select("td").removeClass(D);C.item(B).addClass(D[A=="DESC"?1:0])},updateAllColumnWidths:function(){var D=this.getTotalWidth();var H=this.cm.getColumnCount();var F=[];for(var B=0;B<H;B++){F[B]=this.getColumnWidth(B)}this.innerHd.firstChild.firstChild.style.width=D;for(var B=0;B<H;B++){var C=this.getHeaderCell(B);C.style.width=F[B]}var G=this.getRows();for(var B=0,E=G.length;B<E;B++){G[B].style.width=D;G[B].firstChild.style.width=D;var I=G[B].firstChild.rows[0];for(var A=0;A<H;A++){I.childNodes[A].style.width=F[A]}}this.onAllColumnWidthsUpdated(F,D)},updateColumnWidth:function(D,G){var B=this.getColumnWidth(D);var C=this.getTotalWidth();this.innerHd.firstChild.firstChild.style.width=C;var H=this.getHeaderCell(D);H.style.width=B;var F=this.getRows();for(var E=0,A=F.length;E<A;E++){F[E].style.width=C;F[E].firstChild.style.width=C;F[E].firstChild.rows[0].childNodes[D].style.width=B}this.onColumnWidthUpdated(D,B,C)},updateColumnHidden:function(C,F){var B=this.getTotalWidth();this.innerHd.firstChild.firstChild.style.width=B;var H=F?"none":"";var G=this.getHeaderCell(C);G.style.display=H;var E=this.getRows();for(var D=0,A=E.length;D<A;D++){E[D].style.width=B;E[D].firstChild.style.width=B;E[D].firstChild.rows[0].childNodes[C].style.display=H}this.onColumnHiddenUpdated(C,F,B);delete this.lastViewWidth;this.layout()},doRender:function(E,G,M,A,L,Q){var B=this.templates,D=B.cell,F=B.row,H=L-1;var C="width:"+this.getTotalWidth()+";";var T=[],N,U,O={},I={tstyle:C},K;for(var P=0,S=G.length;P<S;P++){K=G[P];N=[];var J=(P+A);for(var R=0;R<L;R++){U=E[R];O.id=U.id;O.css=R==0?"x-grid3-cell-first ":(R==H?"x-grid3-cell-last ":"");O.attr=O.cellAttr="";O.value=U.renderer(K.data[U.name],O,K,J,R,M);O.style=U.style;if(O.value==undefined||O.value===""){O.value="&#160;"}if(K.dirty&&typeof K.modified[U.name]!=="undefined"){O.css+=" x-grid3-dirty-cell"}N[N.length]=D.apply(O)}var V=[];if(Q&&((J+1)%2==0)){V[0]="x-grid3-row-alt"}if(K.dirty){V[1]=" x-grid3-dirty-row"}I.cols=L;if(this.getRowClass){V[2]=this.getRowClass(K,J,I,M)}I.alt=V.join(" ");I.cells=N.join("");T[T.length]=F.apply(I)}return T.join("")},processRows:function(E,D){if(this.ds.getCount()<1){return }D=D||!this.grid.stripeRows;E=E||0;var I=this.getRows();var F=" x-grid3-row-alt ";for(var B=E,C=I.length;B<C;B++){var H=I[B];H.rowIndex=B;if(!D){var A=((B+1)%2==0);var G=(" "+H.className+" ").indexOf(F)!=-1;if(A==G){continue}if(A){H.className+=" x-grid3-row-alt"}else{H.className=H.className.replace("x-grid3-row-alt","")}}}},afterRender:function(){this.mainBody.dom.innerHTML=this.renderRows();this.processRows(0,true);if(this.deferEmptyText!==true){this.applyEmptyText()}},renderUI:function(){var D=this.renderHeaders();var A=this.templates.body.apply({rows:""});var B=this.templates.master.apply({body:A,header:D});var C=this.grid;C.getGridEl().dom.innerHTML=B;this.initElements();Ext.fly(this.innerHd).on("click",this.handleHdDown,this);this.mainHd.on("mouseover",this.handleHdOver,this);this.mainHd.on("mouseout",this.handleHdOut,this);this.mainHd.on("mousemove",this.handleHdMove,this);this.scroller.on("scroll",this.syncScroll,this);if(C.enableColumnResize!==false){this.splitone=new Ext.grid.GridView.SplitDragZone(C,this.mainHd.dom)}if(C.enableColumnMove){this.columnDrag=new Ext.grid.GridView.ColumnDragZone(C,this.innerHd);this.columnDrop=new Ext.grid.HeaderDropZone(C,this.mainHd.dom)}if(C.enableHdMenu!==false){if(C.enableColumnHide!==false){this.colMenu=new Ext.menu.Menu({id:C.id+"-hcols-menu"});this.colMenu.on("beforeshow",this.beforeColMenuShow,this);this.colMenu.on("itemclick",this.handleHdMenuClick,this)}this.hmenu=new Ext.menu.Menu({id:C.id+"-hctx"});this.hmenu.add({id:"asc",text:this.sortAscText,cls:"xg-hmenu-sort-asc"},{id:"desc",text:this.sortDescText,cls:"xg-hmenu-sort-desc"});if(C.enableColumnHide!==false){this.hmenu.add("-",{id:"columns",text:this.columnsText,menu:this.colMenu,iconCls:"x-cols-icon"})}this.hmenu.on("itemclick",this.handleHdMenuClick,this)}if(C.enableDragDrop||C.enableDrag){this.dragZone=new Ext.grid.GridDragZone(C,{ddGroup:C.ddGroup||"GridDD"})}this.updateHeaderSortState()},layout:function(){if(!this.mainBody){return }var C=this.grid;var F=C.getGridEl();var A=F.getSize(true);var B=A.width;if(B<20||A.height<20){return }if(C.autoHeight){this.scroller.dom.style.overflow="visible"}else{this.el.setSize(A.width,A.height);var E=this.mainHd.getHeight();var D=A.height-(E);this.scroller.setSize(B,D);if(this.innerHd){this.innerHd.style.width=(B)+"px"}}if(this.forceFit){if(this.lastViewWidth!=B){this.fitColumns(false,false);this.lastViewWidth=B}}else{this.autoExpand();this.syncHeaderScroll()}this.onLayout(B,D)},onLayout:function(A,B){},onColumnWidthUpdated:function(C,A,B){},onAllColumnWidthsUpdated:function(A,B){},onColumnHiddenUpdated:function(B,C,A){},updateColumnText:function(A,B){},afterMove:function(A){},init:function(A){this.grid=A;this.initTemplates();this.initData(A.store,A.colModel);this.initUI(A)},getColumnId:function(A){return this.cm.getColumnId(A)},renderHeaders:function(){var C=this.cm,F=this.templates;var E=F.hcell;var B=[],H=[],G={};for(var D=0,A=C.getColumnCount();D<A;D++){G.id=C.getColumnId(D);G.value=C.getColumnHeader(D)||"";G.style=this.getColumnStyle(D,true);G.tooltip=this.getColumnTooltip(D);if(C.config[D].align=="right"){G.istyle="padding-right:16px"}else{delete G.istyle}B[B.length]=E.apply(G)}return F.header.apply({cells:B.join(""),tstyle:"width:"+this.getTotalWidth()+";"})},getColumnTooltip:function(A){var B=this.cm.getColumnTooltip(A);if(B){if(Ext.QuickTips.isEnabled()){return"ext:qtip=\""+B+"\""}else{return"title=\""+B+"\""}}return""},beforeUpdate:function(){this.grid.stopEditing(true)},updateHeaders:function(){this.innerHd.firstChild.innerHTML=this.renderHeaders()},focusRow:function(A){this.focusCell(A,0,false)},focusCell:function(D,A,C){D=Math.min(D,Math.max(0,this.getRows().length-1));var B=this.ensureVisible(D,A,C);this.focusEl.setXY(B||this.scroller.getXY());if(Ext.isGecko){this.focusEl.focus()}else{this.focusEl.focus.defer(1,this.focusEl)}},ensureVisible:function(P,E,D){if(typeof P!="number"){P=P.rowIndex}if(!this.ds){return }if(P<0||P>=this.ds.getCount()){return }E=(E!==undefined?E:0);var I=this.getRow(P),F;if(!(D===false&&E===0)){while(this.cm.isHidden(E)){E++}F=this.getCell(P,E)}if(!I){return }var L=this.scroller.dom;var O=0;var C=I,M=this.el.dom;while(C&&C!=M){O+=C.offsetTop;C=C.offsetParent}O-=this.mainHd.dom.offsetHeight;var N=O+I.offsetHeight;var A=L.clientHeight;var M=parseInt(L.scrollTop,10);var K=M+A;if(O<M){L.scrollTop=O}else{if(N>K){L.scrollTop=N-A}}if(D!==false){var J=parseInt(F.offsetLeft,10);var H=J+F.offsetWidth;var G=parseInt(L.scrollLeft,10);var B=G+L.clientWidth;if(J<G){L.scrollLeft=J}else{if(H>B){L.scrollLeft=H-L.clientWidth}}}return F?Ext.fly(F).getXY():[L.scrollLeft+this.el.getX(),Ext.fly(I).getY()]},insertRows:function(A,F,C,E){if(!E&&F===0&&C>=A.getCount()-1){this.refresh()}else{if(!E){this.fireEvent("beforerowsinserted",this,F,C)}var B=this.renderRows(F,C);var D=this.getRow(F);if(D){Ext.DomHelper.insertHtml("beforeBegin",D,B)}else{Ext.DomHelper.insertHtml("beforeEnd",this.mainBody.dom,B)}if(!E){this.fireEvent("rowsinserted",this,F,C);this.processRows(F)}}this.focusRow(F)},deleteRows:function(A,C,B){if(A.getRowCount()<1){this.refresh()}else{this.fireEvent("beforerowsdeleted",this,C,B);this.removeRows(C,B);this.processRows(C);this.fireEvent("rowsdeleted",this,C,B)}},getColumnStyle:function(A,C){var B=!C?(this.cm.config[A].css||""):"";B+="width:"+this.getColumnWidth(A)+";";if(this.cm.isHidden(A)){B+="display:none;"}var D=this.cm.config[A].align;if(D){B+="text-align:"+D+";"}return B},getColumnWidth:function(B){var A=this.cm.getColumnWidth(B);if(typeof A=="number"){return(Ext.isBorderBox?A:(A-this.borderWidth>0?A-this.borderWidth:0))+"px"}return A},getTotalWidth:function(){return this.cm.getTotalWidth()+"px"},fitColumns:function(D,G,E){var F=this.cm,S,L,O;var R=F.getTotalWidth(false);var J=this.grid.getGridEl().getWidth(true)-this.scrollOffset;if(J<20){return }var B=J-R;if(B===0){return false}var A=F.getColumnCount(true);var P=A-(typeof E=="number"?1:0);if(P===0){P=1;E=undefined}var K=F.getColumnCount();var I=[];var N=0;var M=0;var H;for(O=0;O<K;O++){if(!F.isHidden(O)&&!F.isFixed(O)&&O!==E){H=F.getColumnWidth(O);I.push(O);N=O;I.push(H);M+=H}}var C=(J-F.getTotalWidth())/M;while(I.length){H=I.pop();O=I.pop();F.setColumnWidth(O,Math.max(this.grid.minColumnWidth,Math.floor(H+H*C)),true)}if((R=F.getTotalWidth(false))>J){var Q=P!=A?E:N;F.setColumnWidth(Q,Math.max(1,F.getColumnWidth(Q)-(R-J)),true)}if(D!==true){this.updateAllColumnWidths()}return true},autoExpand:function(B){var G=this.grid,A=this.cm;if(!this.userResized&&G.autoExpandColumn){var D=A.getTotalWidth(false);var H=this.grid.getGridEl().getWidth(true)-this.scrollOffset;if(D!=H){var F=A.getIndexById(G.autoExpandColumn);var E=A.getColumnWidth(F);var C=Math.min(Math.max(((H-D)+E),G.autoExpandMin),G.autoExpandMax);if(C!=E){A.setColumnWidth(F,C,true);if(B!==true){this.updateColumnWidth(F,C)}}}}},getColumnData:function(){var D=[],A=this.cm,E=A.getColumnCount();for(var C=0;C<E;C++){var B=A.getDataIndex(C);D[C]={name:(typeof B=="undefined"?this.ds.fields.get(C).name:B),renderer:A.getRenderer(C),id:A.getColumnId(C),style:this.getColumnStyle(C)}}return D},renderRows:function(H,C){var D=this.grid,F=D.colModel,A=D.store,I=D.stripeRows;var G=F.getColumnCount();if(A.getCount()<1){return""}var E=this.getColumnData();H=H||0;C=typeof C=="undefined"?A.getCount()-1:C;var B=A.getRange(H,C);return this.doRender(E,B,A,H,G,I)},renderBody:function(){var A=this.renderRows();return this.templates.body.apply({rows:A})},refreshRow:function(B){var D=this.ds,C;if(typeof B=="number"){C=B;B=D.getAt(C)}else{C=D.indexOf(B)}var A=[];this.insertRows(D,C,C,true);this.getRow(C).rowIndex=C;this.onRemove(D,B,C+1,true);this.fireEvent("rowupdated",this,C,B)},refresh:function(B){this.fireEvent("beforerefresh",this);this.grid.stopEditing(true);var A=this.renderBody();this.mainBody.update(A);if(B===true){this.updateHeaders();this.updateHeaderSortState()}this.processRows(0,true);this.layout();this.applyEmptyText();this.fireEvent("refresh",this)},applyEmptyText:function(){if(this.emptyText&&!this.hasRows()){this.mainBody.update("<div class=\"x-grid-empty\">"+this.emptyText+"</div>")}},updateHeaderSortState:function(){var B=this.ds.getSortState();if(!B){return }if(!this.sortState||(this.sortState.field!=B.field||this.sortState.direction!=B.direction)){this.grid.fireEvent("sortchange",this.grid,B)}this.sortState=B;var C=this.cm.findColumnIndex(B.field);if(C!=-1){var A=B.direction;this.updateSortIcon(C,A)}},destroy:function(){if(this.colMenu){this.colMenu.removeAll();Ext.menu.MenuMgr.unregister(this.colMenu);this.colMenu.getEl().remove();delete this.colMenu}if(this.hmenu){this.hmenu.removeAll();Ext.menu.MenuMgr.unregister(this.hmenu);this.hmenu.getEl().remove();delete this.hmenu}if(this.grid.enableColumnMove){var C=Ext.dd.DDM.ids["gridHeader"+this.grid.getGridEl().id];if(C){for(var A in C){if(!C[A].config.isTarget&&C[A].dragElId){var B=C[A].dragElId;C[A].unreg();Ext.get(B).remove()}else{if(C[A].config.isTarget){C[A].proxyTop.remove();C[A].proxyBottom.remove();C[A].unreg()}}if(Ext.dd.DDM.locationCache[A]){delete Ext.dd.DDM.locationCache[A]}}delete Ext.dd.DDM.ids["gridHeader"+this.grid.getGridEl().id]}}Ext.destroy(this.resizeMarker,this.resizeProxy);if(this.dragZone){this.dragZone.unreg()}this.initData(null,null);Ext.EventManager.removeResizeListener(this.onWindowResize,this)},onDenyColumnHide:function(){},render:function(){if(this.autoFill){this.fitColumns(true,true)}else{if(this.forceFit){this.fitColumns(true,false)}else{if(this.grid.autoExpandColumn){this.autoExpand(true)}}}this.renderUI()},initData:function(B,A){if(this.ds){this.ds.un("load",this.onLoad,this);this.ds.un("datachanged",this.onDataChange,this);this.ds.un("add",this.onAdd,this);this.ds.un("remove",this.onRemove,this);this.ds.un("update",this.onUpdate,this);this.ds.un("clear",this.onClear,this)}if(B){B.on("load",this.onLoad,this);B.on("datachanged",this.onDataChange,this);B.on("add",this.onAdd,this);B.on("remove",this.onRemove,this);B.on("update",this.onUpdate,this);B.on("clear",this.onClear,this)}this.ds=B;if(this.cm){this.cm.un("configchange",this.onColConfigChange,this);this.cm.un("widthchange",this.onColWidthChange,this);this.cm.un("headerchange",this.onHeaderChange,this);this.cm.un("hiddenchange",this.onHiddenChange,this);this.cm.un("columnmoved",this.onColumnMove,this);this.cm.un("columnlockchange",this.onColumnLock,this)}if(A){delete this.lastViewWidth;A.on("configchange",this.onColConfigChange,this);A.on("widthchange",this.onColWidthChange,this);A.on("headerchange",this.onHeaderChange,this);A.on("hiddenchange",this.onHiddenChange,this);A.on("columnmoved",this.onColumnMove,this);A.on("columnlockchange",this.onColumnLock,this)}this.cm=A},onDataChange:function(){this.refresh();this.updateHeaderSortState()},onClear:function(){this.refresh()},onUpdate:function(B,A){this.refreshRow(A)},onAdd:function(C,A,B){this.insertRows(C,B,B+(A.length-1))},onRemove:function(D,A,B,C){if(C!==true){this.fireEvent("beforerowremoved",this,B,A)}this.removeRow(B);if(C!==true){this.processRows(B);this.applyEmptyText();this.fireEvent("rowremoved",this,B,A)}},onLoad:function(){this.scrollToTop()},onColWidthChange:function(A,B,C){this.updateColumnWidth(B,C)},onHeaderChange:function(A,B,C){this.updateHeaders()},onHiddenChange:function(A,B,C){this.updateColumnHidden(B,C)},onColumnMove:function(A,D,B){this.indexMap=null;var C=this.getScrollState();this.refresh(true);this.restoreScroll(C);this.afterMove(B)},onColConfigChange:function(){delete this.lastViewWidth;this.indexMap=null;this.refresh(true)},initUI:function(A){A.on("headerclick",this.onHeaderClick,this);if(A.trackMouseOver){A.on("mouseover",this.onRowOver,this);A.on("mouseout",this.onRowOut,this)}},initEvents:function(){},onHeaderClick:function(B,A){if(this.headersDisabled||!this.cm.isSortable(A)){return }B.stopEditing(true);B.store.sort(this.cm.getDataIndex(A))},onRowOver:function(B,A){var C;if((C=this.findRowIndex(A))!==false){this.addRowClass(C,"x-grid3-row-over")}},onRowOut:function(B,A){var C;if((C=this.findRowIndex(A))!==false&&C!==this.findRowIndex(B.getRelatedTarget())){this.removeRowClass(C,"x-grid3-row-over")}},handleWheel:function(A){A.stopPropagation()},onRowSelect:function(A){this.addRowClass(A,"x-grid3-row-selected")},onRowDeselect:function(A){this.removeRowClass(A,"x-grid3-row-selected")},onCellSelect:function(C,B){var A=this.getCell(C,B);if(A){this.fly(A).addClass("x-grid3-cell-selected")}},onCellDeselect:function(C,B){var A=this.getCell(C,B);if(A){this.fly(A).removeClass("x-grid3-cell-selected")}},onColumnSplitterMoved:function(C,B){this.userResized=true;var A=this.grid.colModel;A.setColumnWidth(C,B,true);if(this.forceFit){this.fitColumns(true,false,C);this.updateAllColumnWidths()}else{this.updateColumnWidth(C,B)}this.grid.fireEvent("columnresize",C,B)},handleHdMenuClick:function(C){var B=this.hdCtxIndex;var A=this.cm,D=this.ds;switch(C.id){case"asc":D.sort(A.getDataIndex(B),"ASC");break;case"desc":D.sort(A.getDataIndex(B),"DESC");break;default:B=A.getIndexById(C.id.substr(4));if(B!=-1){if(C.checked&&A.getColumnsBy(this.isHideableColumn,this).length<=1){this.onDenyColumnHide();return false}A.setHidden(B,C.checked)}}return true},isHideableColumn:function(A){return !A.hidden&&!A.fixed},beforeColMenuShow:function(){var A=this.cm,C=A.getColumnCount();this.colMenu.removeAll();for(var B=0;B<C;B++){if(A.config[B].fixed!==true&&A.config[B].hideable!==false){this.colMenu.add(new Ext.menu.CheckItem({id:"col-"+A.getColumnId(B),text:A.getColumnHeader(B),checked:!A.isHidden(B),hideOnClick:false,disabled:A.config[B].hideable===false}))}}},handleHdDown:function(F,D){if(Ext.fly(D).hasClass("x-grid3-hd-btn")){F.stopEvent();var E=this.findHeaderCell(D);Ext.fly(E).addClass("x-grid3-hd-menu-open");var C=this.getCellIndex(E);this.hdCtxIndex=C;var B=this.hmenu.items,A=this.cm;B.get("asc").setDisabled(!A.isSortable(C));B.get("desc").setDisabled(!A.isSortable(C));this.hmenu.on("hide",function(){Ext.fly(E).removeClass("x-grid3-hd-menu-open")},this,{single:true});this.hmenu.show(D,"tl-bl?")}},handleHdOver:function(D,A){var C=this.findHeaderCell(A);if(C&&!this.headersDisabled){this.activeHd=C;this.activeHdIndex=this.getCellIndex(C);var B=this.fly(C);this.activeHdRegion=B.getRegion();if(!this.cm.isMenuDisabled(this.activeHdIndex)){B.addClass("x-grid3-hd-over");this.activeHdBtn=B.child(".x-grid3-hd-btn");if(this.activeHdBtn){this.activeHdBtn.dom.style.height=(C.firstChild.offsetHeight-1)+"px"}}}},handleHdMove:function(F,D){if(this.activeHd&&!this.headersDisabled){var B=this.splitHandleWidth||5;var E=this.activeHdRegion;var A=F.getPageX();var C=this.activeHd.style;if(A-E.left<=B&&this.cm.isResizable(this.activeHdIndex-1)){C.cursor=Ext.isAir?"move":Ext.isSafari?"e-resize":"col-resize"}else{if(E.right-A<=(!this.activeHdBtn?B:2)&&this.cm.isResizable(this.activeHdIndex)){C.cursor=Ext.isAir?"move":Ext.isSafari?"w-resize":"col-resize"}else{C.cursor=""}}}},handleHdOut:function(C,A){var B=this.findHeaderCell(A);if(B&&(!Ext.isIE||!C.within(B,true))){this.activeHd=null;this.fly(B).removeClass("x-grid3-hd-over");B.style.cursor=""}},hasRows:function(){var A=this.mainBody.dom.firstChild;return A&&A.className!="x-grid-empty"},bind:function(A,B){this.initData(A,B)}});Ext.grid.GridView.SplitDragZone=function(A,B){this.grid=A;this.view=A.getView();this.marker=this.view.resizeMarker;this.proxy=this.view.resizeProxy;Ext.grid.GridView.SplitDragZone.superclass.constructor.call(this,B,"gridSplitters"+this.grid.getGridEl().id,{dragElId:Ext.id(this.proxy.dom),resizeFrame:false});this.scroll=false;this.hw=this.view.splitHandleWidth||5};Ext.extend(Ext.grid.GridView.SplitDragZone,Ext.dd.DDProxy,{b4StartDrag:function(A,E){this.view.headersDisabled=true;var D=this.view.mainWrap.getHeight();this.marker.setHeight(D);this.marker.show();this.marker.alignTo(this.view.getHeaderCell(this.cellIndex),"tl-tl",[-2,0]);this.proxy.setHeight(D);var B=this.cm.getColumnWidth(this.cellIndex);var C=Math.max(B-this.grid.minColumnWidth,0);this.resetConstraints();this.setXConstraint(C,1000);this.setYConstraint(0,0);this.minX=A-C;this.maxX=A+1000;this.startPos=A;Ext.dd.DDProxy.prototype.b4StartDrag.call(this,A,E)},handleMouseDown:function(A){var H=this.view.findHeaderCell(A.getTarget());if(H){var K=this.view.fly(H).getXY(),E=K[0],D=K[1];var I=A.getXY(),C=I[0],B=I[1];var G=H.offsetWidth,F=false;if((C-E)<=this.hw){F=-1}else{if((E+G)-C<=this.hw){F=0}}if(F!==false){this.cm=this.grid.colModel;var J=this.view.getCellIndex(H);if(F==-1){if(J+F<0){return }while(this.cm.isHidden(J+F)){--F;if(J+F<0){return }}}this.cellIndex=J+F;this.split=H.dom;if(this.cm.isResizable(this.cellIndex)&&!this.cm.isFixed(this.cellIndex)){Ext.grid.GridView.SplitDragZone.superclass.handleMouseDown.apply(this,arguments)}}else{if(this.view.columnDrag){this.view.columnDrag.callHandleMouseDown(A)}}}},endDrag:function(D){this.marker.hide();var A=this.view;var B=Math.max(this.minX,D.getPageX());var C=B-this.startPos;A.onColumnSplitterMoved(this.cellIndex,this.cm.getColumnWidth(this.cellIndex)+C);setTimeout(function(){A.headersDisabled=false},50)},autoOffset:function(){this.setDelta(0,0)}});
Ext.grid.GroupingView=Ext.extend(Ext.grid.GridView,{hideGroupedColumn:false,showGroupName:true,startCollapsed:false,enableGrouping:true,enableGroupingMenu:true,enableNoGroups:true,emptyGroupText:"(None)",ignoreAdd:false,groupTextTpl:"{text}",gidSeed:1000,initTemplates:function(){Ext.grid.GroupingView.superclass.initTemplates.call(this);this.state={};var A=this.grid.getSelectionModel();A.on(A.selectRow?"beforerowselect":"beforecellselect",this.onBeforeRowSelect,this);if(!this.startGroup){this.startGroup=new Ext.XTemplate("<div id=\"{groupId}\" class=\"x-grid-group {cls}\">","<div id=\"{groupId}-hd\" class=\"x-grid-group-hd\" style=\"{style}\"><div>",this.groupTextTpl,"</div></div>","<div id=\"{groupId}-bd\" class=\"x-grid-group-body\">")}this.startGroup.compile();this.endGroup="</div></div>"},findGroup:function(A){return Ext.fly(A).up(".x-grid-group",this.mainBody.dom)},getGroups:function(){return this.hasRows()?this.mainBody.dom.childNodes:[]},onAdd:function(){if(this.enableGrouping&&!this.ignoreAdd){var A=this.getScrollState();this.refresh();this.restoreScroll(A)}else{if(!this.enableGrouping){Ext.grid.GroupingView.superclass.onAdd.apply(this,arguments)}}},onRemove:function(E,A,B,D){Ext.grid.GroupingView.superclass.onRemove.apply(this,arguments);var C=document.getElementById(A._groupId);if(C&&C.childNodes[1].childNodes.length<1){Ext.removeNode(C)}this.applyEmptyText()},refreshRow:function(A){if(this.ds.getCount()==1){this.refresh()}else{this.isUpdating=true;Ext.grid.GroupingView.superclass.refreshRow.apply(this,arguments);this.isUpdating=false}},beforeMenuShow:function(){var C=this.getGroupField();var B=this.hmenu.items.get("groupBy");if(B){B.setDisabled(this.cm.config[this.hdCtxIndex].groupable===false)}var A=this.hmenu.items.get("showGroups");if(A){A.setDisabled(!C&&this.cm.config[this.hdCtxIndex].groupable===false);A.setChecked(!!C,true)}},renderUI:function(){Ext.grid.GroupingView.superclass.renderUI.call(this);this.mainBody.on("mousedown",this.interceptMouse,this);if(this.enableGroupingMenu&&this.hmenu){this.hmenu.add("-",{id:"groupBy",text:this.groupByText,handler:this.onGroupByClick,scope:this,iconCls:"x-group-by-icon"});if(this.enableNoGroups){this.hmenu.add({id:"showGroups",text:this.showGroupsText,checked:true,checkHandler:this.onShowGroupsClick,scope:this})}this.hmenu.on("beforeshow",this.beforeMenuShow,this)}},onGroupByClick:function(){this.grid.store.groupBy(this.cm.getDataIndex(this.hdCtxIndex));this.beforeMenuShow()},onShowGroupsClick:function(A,B){if(B){this.onGroupByClick()}else{this.grid.store.clearGrouping()}},toggleGroup:function(C,B){this.grid.stopEditing(true);C=Ext.getDom(C);var A=Ext.fly(C);B=B!==undefined?B:A.hasClass("x-grid-group-collapsed");this.state[A.dom.id]=B;A[B?"removeClass":"addClass"]("x-grid-group-collapsed")},toggleAllGroups:function(C){var B=this.getGroups();for(var D=0,A=B.length;D<A;D++){this.toggleGroup(B[D],C)}},expandAllGroups:function(){this.toggleAllGroups(true)},collapseAllGroups:function(){this.toggleAllGroups(false)},interceptMouse:function(B){var A=B.getTarget(".x-grid-group-hd",this.mainBody);if(A){B.stopEvent();this.toggleGroup(A.parentNode)}},getGroup:function(A,D,F,G,B,E){var C=F?F(A,{},D,G,B,E):String(A);if(C===""){C=this.cm.config[B].emptyGroupText||this.emptyGroupText}return C},getGroupField:function(){return this.grid.store.getGroupState()},renderRows:function(){var A=this.getGroupField();var D=!!A;if(this.hideGroupedColumn){var B=this.cm.findColumnIndex(A);if(!D&&this.lastGroupField!==undefined){this.mainBody.update("");this.cm.setHidden(this.cm.findColumnIndex(this.lastGroupField),false);delete this.lastGroupField}else{if(D&&this.lastGroupField===undefined){this.lastGroupField=A;this.cm.setHidden(B,true)}else{if(D&&this.lastGroupField!==undefined&&A!==this.lastGroupField){this.mainBody.update("");var C=this.cm.findColumnIndex(this.lastGroupField);this.cm.setHidden(C,false);this.lastGroupField=A;this.cm.setHidden(B,true)}}}}return Ext.grid.GroupingView.superclass.renderRows.apply(this,arguments)},doRender:function(D,G,P,A,O,R){if(G.length<1){return""}var Y=this.getGroupField();var N=this.cm.findColumnIndex(Y);this.enableGrouping=!!Y;if(!this.enableGrouping||this.isUpdating){return Ext.grid.GroupingView.superclass.doRender.apply(this,arguments)}var H="width:"+this.getTotalWidth()+";";var Q=this.grid.getGridEl().id;var F=this.cm.config[N];var B=F.groupRenderer||F.renderer;var S=this.showGroupName?(F.groupName||F.header)+": ":"";var X=[],K,T,U,M;for(T=0,U=G.length;T<U;T++){var J=A+T;var L=G[T],E=L.data[Y],V=this.getGroup(E,L,B,J,N,P);if(!K||K.group!=V){M=Q+"-gp-"+Y+"-"+Ext.util.Format.htmlEncode(V);var C=typeof this.state[M]!=="undefined"?!this.state[M]:this.startCollapsed;var I=C?"x-grid-group-collapsed":"";K={group:V,gvalue:E,text:S+V,groupId:M,startRow:J,rs:[L],cls:I,style:H};X.push(K)}else{K.rs.push(L)}L._groupId=M}var W=[];for(T=0,U=X.length;T<U;T++){var V=X[T];this.doGroupStart(W,V,D,P,O);W[W.length]=Ext.grid.GroupingView.superclass.doRender.call(this,D,V.rs,P,V.startRow,O,R);this.doGroupEnd(W,V,D,P,O)}return W.join("")},getGroupId:function(F){var D=this.grid.getGridEl().id;var C=this.getGroupField();var E=this.cm.findColumnIndex(C);var B=this.cm.config[E];var G=B.groupRenderer||B.renderer;var A=this.getGroup(F,{data:{}},G,0,E,this.ds);return D+"-gp-"+C+"-"+Ext.util.Format.htmlEncode(F)},doGroupStart:function(A,D,B,E,C){A[A.length]=this.startGroup.apply(D)},doGroupEnd:function(A,D,B,E,C){A[A.length]=this.endGroup},getRows:function(){if(!this.enableGrouping){return Ext.grid.GroupingView.superclass.getRows.call(this)}var G=[];var F,C=this.getGroups();for(var E=0,A=C.length;E<A;E++){F=C[E].childNodes[1].childNodes;for(var D=0,B=F.length;D<B;D++){G[G.length]=F[D]}}return G},updateGroupWidths:function(){if(!this.enableGrouping||!this.hasRows()){return }var C=Math.max(this.cm.getTotalWidth(),this.el.dom.offsetWidth-this.scrollOffset)+"px";var B=this.getGroups();for(var D=0,A=B.length;D<A;D++){B[D].firstChild.style.width=C}},onColumnWidthUpdated:function(C,A,B){this.updateGroupWidths()},onAllColumnWidthsUpdated:function(A,B){this.updateGroupWidths()},onColumnHiddenUpdated:function(B,C,A){this.updateGroupWidths()},onLayout:function(){this.updateGroupWidths()},onBeforeRowSelect:function(D,C){if(!this.enableGrouping){return }var B=this.getRow(C);if(B&&!B.offsetParent){var A=this.findGroup(B);this.toggleGroup(A,true)}},groupByText:"Group By This Field",showGroupsText:"Show in Groups"});Ext.grid.GroupingView.GROUP_ID=1000;
Ext.grid.HeaderDragZone=function(A,C,B){this.grid=A;this.view=A.getView();this.ddGroup="gridHeader"+this.grid.getGridEl().id;Ext.grid.HeaderDragZone.superclass.constructor.call(this,C);if(B){this.setHandleElId(Ext.id(C));this.setOuterHandleElId(Ext.id(B))}this.scroll=false};Ext.extend(Ext.grid.HeaderDragZone,Ext.dd.DragZone,{maxDragWidth:120,getDragData:function(C){var A=Ext.lib.Event.getTarget(C);var B=this.view.findHeaderCell(A);if(B){return{ddel:B.firstChild,header:B}}return false},onInitDrag:function(A){this.view.headersDisabled=true;var B=this.dragData.ddel.cloneNode(true);B.id=Ext.id();B.style.width=Math.min(this.dragData.header.offsetWidth,this.maxDragWidth)+"px";this.proxy.update(B);return true},afterValidDrop:function(){var A=this.view;setTimeout(function(){A.headersDisabled=false},50)},afterInvalidDrop:function(){var A=this.view;setTimeout(function(){A.headersDisabled=false},50)}});Ext.grid.HeaderDropZone=function(A,C,B){this.grid=A;this.view=A.getView();this.proxyTop=Ext.DomHelper.append(document.body,{cls:"col-move-top",html:"&#160;"},true);this.proxyBottom=Ext.DomHelper.append(document.body,{cls:"col-move-bottom",html:"&#160;"},true);this.proxyTop.hide=this.proxyBottom.hide=function(){this.setLeftTop(-100,-100);this.setStyle("visibility","hidden")};this.ddGroup="gridHeader"+this.grid.getGridEl().id;Ext.grid.HeaderDropZone.superclass.constructor.call(this,A.getGridEl().dom)};Ext.extend(Ext.grid.HeaderDropZone,Ext.dd.DropZone,{proxyOffsets:[-4,-9],fly:Ext.Element.fly,getTargetFromEvent:function(C){var A=Ext.lib.Event.getTarget(C);var B=this.view.findCellIndex(A);if(B!==false){return this.view.getHeaderCell(B)}},nextVisible:function(C){var B=this.view,A=this.grid.colModel;C=C.nextSibling;while(C){if(!A.isHidden(B.getCellIndex(C))){return C}C=C.nextSibling}return null},prevVisible:function(C){var B=this.view,A=this.grid.colModel;C=C.prevSibling;while(C){if(!A.isHidden(B.getCellIndex(C))){return C}C=C.prevSibling}return null},positionIndicator:function(D,B,E){var H=Ext.lib.Event.getPageX(E);var A=Ext.lib.Dom.getRegion(B.firstChild);var I,K,G=A.top+this.proxyOffsets[1];if((A.right-H)<=(A.right-A.left)/2){I=A.right+this.view.borderWidth;K="after"}else{I=A.left;K="before"}var F=this.view.getCellIndex(D);var J=this.view.getCellIndex(B);if(this.grid.colModel.isFixed(J)){return false}var C=this.grid.colModel.isLocked(J);if(K=="after"){J++}if(F<J){J--}if(F==J&&(C==this.grid.colModel.isLocked(F))){return false}I+=this.proxyOffsets[0];this.proxyTop.setLeftTop(I,G);this.proxyTop.show();if(!this.bottomOffset){this.bottomOffset=this.view.mainHd.getHeight()}this.proxyBottom.setLeftTop(I,G+this.proxyTop.dom.offsetHeight+this.bottomOffset);this.proxyBottom.show();return K},onNodeEnter:function(D,A,C,B){if(B.header!=D){this.positionIndicator(B.header,D,C)}},onNodeOver:function(E,B,D,C){var A=false;if(C.header!=E){A=this.positionIndicator(C.header,E,D)}if(!A){this.proxyTop.hide();this.proxyBottom.hide()}return A?this.dropAllowed:this.dropNotAllowed},onNodeOut:function(D,A,C,B){this.proxyTop.hide();this.proxyBottom.hide()},onNodeDrop:function(B,K,F,D){var E=D.header;if(E!=B){var I=this.grid.colModel;var H=Ext.lib.Event.getPageX(F);var A=Ext.lib.Dom.getRegion(B.firstChild);var L=(A.right-H)<=((A.right-A.left)/2)?"after":"before";var G=this.view.getCellIndex(E);var J=this.view.getCellIndex(B);var C=I.isLocked(J);if(L=="after"){J++}if(G<J){J--}if(G==J&&(C==I.isLocked(G))){return false}I.setLocked(G,C,true);I.moveColumn(G,J);this.grid.fireEvent("columnmove",G,J);return true}return false}});Ext.grid.GridView.ColumnDragZone=function(A,B){Ext.grid.GridView.ColumnDragZone.superclass.constructor.call(this,A,B,null);this.proxy.el.addClass("x-grid3-col-dd")};Ext.extend(Ext.grid.GridView.ColumnDragZone,Ext.grid.HeaderDragZone,{handleMouseDown:function(A){},callHandleMouseDown:function(A){Ext.grid.GridView.ColumnDragZone.superclass.handleMouseDown.call(this,A)}});
Ext.grid.SplitDragZone=function(A,C,B){this.grid=A;this.view=A.getView();this.proxy=this.view.resizeProxy;Ext.grid.SplitDragZone.superclass.constructor.call(this,C,"gridSplitters"+this.grid.getGridEl().id,{dragElId:Ext.id(this.proxy.dom),resizeFrame:false});this.setHandleElId(Ext.id(C));this.setOuterHandleElId(Ext.id(B));this.scroll=false};Ext.extend(Ext.grid.SplitDragZone,Ext.dd.DDProxy,{fly:Ext.Element.fly,b4StartDrag:function(A,D){this.view.headersDisabled=true;this.proxy.setHeight(this.view.mainWrap.getHeight());var B=this.cm.getColumnWidth(this.cellIndex);var C=Math.max(B-this.grid.minColumnWidth,0);this.resetConstraints();this.setXConstraint(C,1000);this.setYConstraint(0,0);this.minX=A-C;this.maxX=A+1000;this.startPos=A;Ext.dd.DDProxy.prototype.b4StartDrag.call(this,A,D)},handleMouseDown:function(B){ev=Ext.EventObject.setEvent(B);var A=this.fly(ev.getTarget());if(A.hasClass("x-grid-split")){this.cellIndex=this.view.getCellIndex(A.dom);this.split=A.dom;this.cm=this.grid.colModel;if(this.cm.isResizable(this.cellIndex)&&!this.cm.isFixed(this.cellIndex)){Ext.grid.SplitDragZone.superclass.handleMouseDown.apply(this,arguments)}}},endDrag:function(C){this.view.headersDisabled=false;var A=Math.max(this.minX,Ext.lib.Event.getPageX(C));var B=A-this.startPos;this.view.onColumnSplitterMoved(this.cellIndex,this.cm.getColumnWidth(this.cellIndex)+B)},autoOffset:function(){this.setDelta(0,0)}});
Ext.grid.GridDragZone=function(B,A){this.view=B.getView();Ext.grid.GridDragZone.superclass.constructor.call(this,this.view.mainBody.dom,A);if(this.view.lockedBody){this.setHandleElId(Ext.id(this.view.mainBody.dom));this.setOuterHandleElId(Ext.id(this.view.lockedBody.dom))}this.scroll=false;this.grid=B;this.ddel=document.createElement("div");this.ddel.className="x-grid-dd-wrap"};Ext.extend(Ext.grid.GridDragZone,Ext.dd.DragZone,{ddGroup:"GridDD",getDragData:function(B){var A=Ext.lib.Event.getTarget(B);var D=this.view.findRowIndex(A);if(D!==false){var C=this.grid.selModel;if(!C.isSelected(D)||B.hasModifier()){C.handleMouseDown(this.grid,D,B)}return{grid:this.grid,ddel:this.ddel,rowIndex:D,selections:C.getSelections()}}return false},onInitDrag:function(B){var A=this.dragData;this.ddel.innerHTML=this.grid.getDragDropText();this.proxy.update(this.ddel)},afterRepair:function(){this.dragging=false},getRepairXY:function(B,A){return false},onEndDrag:function(A,B){},onValidDrop:function(A,B,C){this.hideProxy()},beforeInvalidDrop:function(A,B){}});
Ext.grid.ColumnModel=function(A){this.defaultWidth=100;this.defaultSortable=false;if(A.columns){Ext.apply(this,A);this.setConfig(A.columns,true)}else{this.setConfig(A,true)}this.addEvents("widthchange","headerchange","hiddenchange","columnmoved","columnlockchange","configchange");Ext.grid.ColumnModel.superclass.constructor.call(this)};Ext.extend(Ext.grid.ColumnModel,Ext.util.Observable,{getColumnId:function(A){return this.config[A].id},setConfig:function(C,B){if(!B){delete this.totalWidth;for(var D=0,A=this.config.length;D<A;D++){var E=this.config[D];if(E.editor){E.editor.destroy()}}}this.config=C;this.lookup={};for(var D=0,A=C.length;D<A;D++){var E=C[D];if(typeof E.renderer=="string"){E.renderer=Ext.util.Format[E.renderer]}if(typeof E.id=="undefined"){E.id=D}if(E.editor&&E.editor.isFormField){E.editor=new Ext.grid.GridEditor(E.editor)}this.lookup[E.id]=E}if(!B){this.fireEvent("configchange",this)}},getColumnById:function(A){return this.lookup[A]},getIndexById:function(C){for(var B=0,A=this.config.length;B<A;B++){if(this.config[B].id==C){return B}}return -1},moveColumn:function(C,A){var B=this.config[C];this.config.splice(C,1);this.config.splice(A,0,B);this.dataMap=null;this.fireEvent("columnmoved",this,C,A)},isLocked:function(A){return this.config[A].locked===true},setLocked:function(B,C,A){if(this.isLocked(B)==C){return }this.config[B].locked=C;if(!A){this.fireEvent("columnlockchange",this,B,C)}},getTotalLockedWidth:function(){var A=0;for(var B=0;B<this.config.length;B++){if(this.isLocked(B)&&!this.isHidden(B)){this.totalWidth+=this.getColumnWidth(B)}}return A},getLockedCount:function(){for(var B=0,A=this.config.length;B<A;B++){if(!this.isLocked(B)){return B}}},getColumnCount:function(C){if(C===true){var D=0;for(var B=0,A=this.config.length;B<A;B++){if(!this.isHidden(B)){D++}}return D}return this.config.length},getColumnsBy:function(D,C){var E=[];for(var B=0,A=this.config.length;B<A;B++){var F=this.config[B];if(D.call(C||this,F,B)===true){E[E.length]=F}}return E},isSortable:function(A){if(typeof this.config[A].sortable=="undefined"){return this.defaultSortable}return this.config[A].sortable},isMenuDisabled:function(A){return !!this.config[A].menuDisabled},getRenderer:function(A){if(!this.config[A].renderer){return Ext.grid.ColumnModel.defaultRenderer}return this.config[A].renderer},setRenderer:function(A,B){this.config[A].renderer=B},getColumnWidth:function(A){return this.config[A].width||this.defaultWidth},setColumnWidth:function(B,C,A){this.config[B].width=C;this.totalWidth=null;if(!A){this.fireEvent("widthchange",this,B,C)}},getTotalWidth:function(B){if(!this.totalWidth){this.totalWidth=0;for(var C=0,A=this.config.length;C<A;C++){if(B||!this.isHidden(C)){this.totalWidth+=this.getColumnWidth(C)}}}return this.totalWidth},getColumnHeader:function(A){return this.config[A].header},setColumnHeader:function(A,B){this.config[A].header=B;this.fireEvent("headerchange",this,A,B)},getColumnTooltip:function(A){return this.config[A].tooltip},setColumnTooltip:function(A,B){this.config[A].tooltip=B},getDataIndex:function(A){return this.config[A].dataIndex},setDataIndex:function(A,B){this.config[A].dataIndex=B},findColumnIndex:function(C){var D=this.config;for(var B=0,A=D.length;B<A;B++){if(D[B].dataIndex==C){return B}}return -1},isCellEditable:function(A,B){return(this.config[A].editable||(typeof this.config[A].editable=="undefined"&&this.config[A].editor))?true:false},getCellEditor:function(A,B){return this.config[A].editor},setEditable:function(A,B){this.config[A].editable=B},isHidden:function(A){return this.config[A].hidden},isFixed:function(A){return this.config[A].fixed},isResizable:function(A){return A>=0&&this.config[A].resizable!==false&&this.config[A].fixed!==true},setHidden:function(A,B){var C=this.config[A];if(C.hidden!==B){C.hidden=B;this.totalWidth=null;this.fireEvent("hiddenchange",this,A,B)}},setEditor:function(A,B){this.config[A].editor=B}});Ext.grid.ColumnModel.defaultRenderer=function(A){if(typeof A=="string"&&A.length<1){return"&#160;"}return A};Ext.grid.DefaultColumnModel=Ext.grid.ColumnModel;
Ext.grid.AbstractSelectionModel=function(){this.locked=false;Ext.grid.AbstractSelectionModel.superclass.constructor.call(this)};Ext.extend(Ext.grid.AbstractSelectionModel,Ext.util.Observable,{init:function(A){this.grid=A;this.initEvents()},lock:function(){this.locked=true},unlock:function(){this.locked=false},isLocked:function(){return this.locked}});
Ext.grid.RowSelectionModel=function(A){Ext.apply(this,A);this.selections=new Ext.util.MixedCollection(false,function(B){return B.id});this.last=false;this.lastActive=false;this.addEvents("selectionchange","beforerowselect","rowselect","rowdeselect");Ext.grid.RowSelectionModel.superclass.constructor.call(this)};Ext.extend(Ext.grid.RowSelectionModel,Ext.grid.AbstractSelectionModel,{singleSelect:false,initEvents:function(){if(!this.grid.enableDragDrop&&!this.grid.enableDrag){this.grid.on("rowmousedown",this.handleMouseDown,this)}else{this.grid.on("rowclick",function(B,D,C){if(C.button===0&&!C.shiftKey&&!C.ctrlKey){this.selectRow(D,false);B.view.focusRow(D)}},this)}this.rowNav=new Ext.KeyNav(this.grid.getGridEl(),{"up":function(C){if(!C.shiftKey){this.selectPrevious(C.shiftKey)}else{if(this.last!==false&&this.lastActive!==false){var B=this.last;this.selectRange(this.last,this.lastActive-1);this.grid.getView().focusRow(this.lastActive);if(B!==false){this.last=B}}else{this.selectFirstRow()}}},"down":function(C){if(!C.shiftKey){this.selectNext(C.shiftKey)}else{if(this.last!==false&&this.lastActive!==false){var B=this.last;this.selectRange(this.last,this.lastActive+1);this.grid.getView().focusRow(this.lastActive);if(B!==false){this.last=B}}else{this.selectFirstRow()}}},scope:this});var A=this.grid.view;A.on("refresh",this.onRefresh,this);A.on("rowupdated",this.onRowUpdated,this);A.on("rowremoved",this.onRemove,this)},onRefresh:function(){var F=this.grid.store,B;var D=this.getSelections();this.clearSelections(true);for(var C=0,A=D.length;C<A;C++){var E=D[C];if((B=F.indexOfId(E.id))!=-1){this.selectRow(B,true)}}if(D.length!=this.selections.getCount()){this.fireEvent("selectionchange",this)}},onRemove:function(A,B,C){if(this.selections.remove(C)!==false){this.fireEvent("selectionchange",this)}},onRowUpdated:function(A,B,C){if(this.isSelected(C)){A.onRowSelect(B)}},selectRecords:function(B,E){if(!E){this.clearSelections()}var D=this.grid.store;for(var C=0,A=B.length;C<A;C++){this.selectRow(D.indexOf(B[C]),true)}},getCount:function(){return this.selections.length},selectFirstRow:function(){this.selectRow(0)},selectLastRow:function(A){this.selectRow(this.grid.store.getCount()-1,A)},selectNext:function(A){if(this.hasNext()){this.selectRow(this.last+1,A);this.grid.getView().focusRow(this.last);return true}return false},selectPrevious:function(A){if(this.hasPrevious()){this.selectRow(this.last-1,A);this.grid.getView().focusRow(this.last);return true}return false},hasNext:function(){return this.last!==false&&(this.last+1)<this.grid.store.getCount()},hasPrevious:function(){return !!this.last},getSelections:function(){return[].concat(this.selections.items)},getSelected:function(){return this.selections.itemAt(0)},each:function(E,D){var C=this.getSelections();for(var B=0,A=C.length;B<A;B++){if(E.call(D||this,C[B],B)===false){return false}}return true},clearSelections:function(A){if(this.locked){return }if(A!==true){var C=this.grid.store;var B=this.selections;B.each(function(D){this.deselectRow(C.indexOfId(D.id))},this);B.clear()}else{this.selections.clear()}this.last=false},selectAll:function(){if(this.locked){return }this.selections.clear();for(var B=0,A=this.grid.store.getCount();B<A;B++){this.selectRow(B,true)}},hasSelection:function(){return this.selections.length>0},isSelected:function(A){var B=typeof A=="number"?this.grid.store.getAt(A):A;return(B&&this.selections.key(B.id)?true:false)},isIdSelected:function(A){return(this.selections.key(A)?true:false)},handleMouseDown:function(D,F,E){if(E.button!==0||this.isLocked()){return }var A=this.grid.getView();if(E.shiftKey&&this.last!==false){var C=this.last;this.selectRange(C,F,E.ctrlKey);this.last=C;A.focusRow(F)}else{var B=this.isSelected(F);if(E.ctrlKey&&B){this.deselectRow(F)}else{if(!B||this.getCount()>1){this.selectRow(F,E.ctrlKey||E.shiftKey);A.focusRow(F)}}}},selectRows:function(C,D){if(!D){this.clearSelections()}for(var B=0,A=C.length;B<A;B++){this.selectRow(C[B],true)}},selectRange:function(B,A,D){if(this.locked){return }if(!D){this.clearSelections()}if(B<=A){for(var C=B;C<=A;C++){this.selectRow(C,true)}}else{for(var C=B;C>=A;C--){this.selectRow(C,true)}}},deselectRange:function(C,B,A){if(this.locked){return }for(var D=C;D<=B;D++){this.deselectRow(D,A)}},selectRow:function(B,D,A){if(this.locked||(B<0||B>=this.grid.store.getCount())||this.isSelected(B)){return }var C=this.grid.store.getAt(B);if(C&&this.fireEvent("beforerowselect",this,B,D,C)!==false){if(!D||this.singleSelect){this.clearSelections()}this.selections.add(C);this.last=this.lastActive=B;if(!A){this.grid.getView().onRowSelect(B)}this.fireEvent("rowselect",this,B,C);this.fireEvent("selectionchange",this)}},deselectRow:function(B,A){if(this.locked){return }if(this.last==B){this.last=false}if(this.lastActive==B){this.lastActive=false}var C=this.grid.store.getAt(B);if(C){this.selections.remove(C);if(!A){this.grid.getView().onRowDeselect(B)}this.fireEvent("rowdeselect",this,B,C);this.fireEvent("selectionchange",this)}},restoreLast:function(){if(this._last){this.last=this._last}},acceptsNav:function(C,B,A){return !A.isHidden(B)&&A.isCellEditable(B,C)},onEditorKey:function(F,E){var C=E.getKey(),G,D=this.grid,B=D.activeEditor;var A=E.shiftKey;if(C==E.TAB){E.stopEvent();B.completeEdit();if(A){G=D.walkCells(B.row,B.col-1,-1,this.acceptsNav,this)}else{G=D.walkCells(B.row,B.col+1,1,this.acceptsNav,this)}}else{if(C==E.ENTER){E.stopEvent();B.completeEdit();if(this.moveEditorOnEnter!==false){if(A){G=D.walkCells(B.row-1,B.col,-1,this.acceptsNav,this)}else{G=D.walkCells(B.row+1,B.col,1,this.acceptsNav,this)}}}else{if(C==E.ESC){B.cancelEdit()}}}if(G){D.startEditing(G[0],G[1])}}});
Ext.grid.CellSelectionModel=function(A){Ext.apply(this,A);this.selection=null;this.addEvents("beforecellselect","cellselect","selectionchange");Ext.grid.CellSelectionModel.superclass.constructor.call(this)};Ext.extend(Ext.grid.CellSelectionModel,Ext.grid.AbstractSelectionModel,{initEvents:function(){this.grid.on("cellmousedown",this.handleMouseDown,this);this.grid.getGridEl().on(Ext.isIE||Ext.isSafari3?"keydown":"keypress",this.handleKeyDown,this);var A=this.grid.view;A.on("refresh",this.onViewChange,this);A.on("rowupdated",this.onRowUpdated,this);A.on("beforerowremoved",this.clearSelections,this);A.on("beforerowsinserted",this.clearSelections,this);if(this.grid.isEditor){this.grid.on("beforeedit",this.beforeEdit,this)}},beforeEdit:function(A){this.select(A.row,A.column,false,true,A.record)},onRowUpdated:function(A,B,C){if(this.selection&&this.selection.record==C){A.onCellSelect(B,this.selection.cell[1])}},onViewChange:function(){this.clearSelections(true)},getSelectedCell:function(){return this.selection?this.selection.cell:null},clearSelections:function(B){var A=this.selection;if(A){if(B!==true){this.grid.view.onCellDeselect(A.cell[0],A.cell[1])}this.selection=null;this.fireEvent("selectionchange",this,null)}},hasSelection:function(){return this.selection?true:false},handleMouseDown:function(B,D,A,C){if(C.button!==0||this.isLocked()){return }this.select(D,A)},select:function(F,C,B,E,D){if(this.fireEvent("beforecellselect",this,F,C)!==false){this.clearSelections();D=D||this.grid.store.getAt(F);this.selection={record:D,cell:[F,C]};if(!B){var A=this.grid.getView();A.onCellSelect(F,C);if(E!==true){A.focusCell(F,C)}}this.fireEvent("cellselect",this,F,C);this.fireEvent("selectionchange",this,this.selection)}},isSelectable:function(C,B,A){return !A.isHidden(B)},handleKeyDown:function(F){if(!F.isNavKeyPress()){return }var E=this.grid,J=this.selection;if(!J){F.stopEvent();var I=E.walkCells(0,0,1,this.isSelectable,this);if(I){this.select(I[0],I[1])}return }var B=this;var H=function(M,K,L){return E.walkCells(M,K,L,B.isSelectable,B)};var C=F.getKey(),A=J.cell[0],G=J.cell[1];var D;switch(C){case F.TAB:if(F.shiftKey){D=H(A,G-1,-1)}else{D=H(A,G+1,1)}break;case F.DOWN:D=H(A+1,G,1);break;case F.UP:D=H(A-1,G,-1);break;case F.RIGHT:D=H(A,G+1,1);break;case F.LEFT:D=H(A,G-1,-1);break;case F.ENTER:if(E.isEditor&&!E.editing){E.startEditing(A,G);F.stopEvent();return }break}if(D){this.select(D[0],D[1]);F.stopEvent()}},acceptsNav:function(C,B,A){return !A.isHidden(B)&&A.isCellEditable(B,C)},onEditorKey:function(E,D){var B=D.getKey(),F,C=this.grid,A=C.activeEditor;if(B==D.TAB){if(D.shiftKey){F=C.walkCells(A.row,A.col-1,-1,this.acceptsNav,this)}else{F=C.walkCells(A.row,A.col+1,1,this.acceptsNav,this)}D.stopEvent()}else{if(B==D.ENTER){A.completeEdit();D.stopEvent()}else{if(B==D.ESC){D.stopEvent();A.cancelEdit()}}}if(F){C.startEditing(F[0],F[1])}}});
Ext.grid.EditorGridPanel=Ext.extend(Ext.grid.GridPanel,{clicksToEdit:2,isEditor:true,detectEdit:false,autoEncode:false,trackMouseOver:false,initComponent:function(){Ext.grid.EditorGridPanel.superclass.initComponent.call(this);if(!this.selModel){this.selModel=new Ext.grid.CellSelectionModel()}this.activeEditor=null;this.addEvents("beforeedit","afteredit","validateedit")},initEvents:function(){Ext.grid.EditorGridPanel.superclass.initEvents.call(this);this.on("bodyscroll",this.stopEditing,this,[true]);if(this.clicksToEdit==1){this.on("cellclick",this.onCellDblClick,this)}else{if(this.clicksToEdit=="auto"&&this.view.mainBody){this.view.mainBody.on("mousedown",this.onAutoEditClick,this)}this.on("celldblclick",this.onCellDblClick,this)}this.getGridEl().addClass("xedit-grid")},onCellDblClick:function(B,C,A){this.startEditing(C,A)},onAutoEditClick:function(C,B){if(C.button!==0){return }var E=this.view.findRowIndex(B);var A=this.view.findCellIndex(B);if(E!==false&&A!==false){this.stopEditing();if(this.selModel.getSelectedCell){var D=this.selModel.getSelectedCell();if(D&&D.cell[0]===E&&D.cell[1]===A){this.startEditing(E,A)}}else{if(this.selModel.isSelected(E)){this.startEditing(E,A)}}}},onEditComplete:function(B,D,A){this.editing=false;this.activeEditor=null;B.un("specialkey",this.selModel.onEditorKey,this.selModel);var C=B.record;var F=this.colModel.getDataIndex(B.col);D=this.postEditValue(D,A,C,F);if(String(D)!==String(A)){var E={grid:this,record:C,field:F,originalValue:A,value:D,row:B.row,column:B.col,cancel:false};if(this.fireEvent("validateedit",E)!==false&&!E.cancel){C.set(F,E.value);delete E.cancel;this.fireEvent("afteredit",E)}}this.view.focusCell(B.row,B.col)},startEditing:function(F,B){this.stopEditing();if(this.colModel.isCellEditable(B,F)){this.view.ensureVisible(F,B,true);var C=this.store.getAt(F);var E=this.colModel.getDataIndex(B);var D={grid:this,record:C,field:E,value:C.data[E],row:F,column:B,cancel:false};if(this.fireEvent("beforeedit",D)!==false&&!D.cancel){this.editing=true;var A=this.colModel.getCellEditor(B,F);if(!A.rendered){A.render(this.view.getEditorParent(A))}(function(){A.row=F;A.col=B;A.record=C;A.on("complete",this.onEditComplete,this,{single:true});A.on("specialkey",this.selModel.onEditorKey,this.selModel);this.activeEditor=A;var G=this.preEditValue(C,E);A.startEdit(this.view.getCell(F,B).firstChild,G)}).defer(50,this)}}},preEditValue:function(A,C){var B=A.data[C];return this.autoEncode&&typeof B=="string"?Ext.util.Format.htmlDecode(B):B},postEditValue:function(C,A,B,D){return this.autoEncode&&typeof C=="string"?Ext.util.Format.htmlEncode(C):C},stopEditing:function(A){if(this.activeEditor){this.activeEditor[A===true?"cancelEdit":"completeEdit"]()}this.activeEditor=null},onDestroy:function(){if(this.rendered){var C=this.colModel.config;for(var B=0,A=C.length;B<A;B++){var D=C[B];Ext.destroy(D.editor)}}Ext.grid.EditorGridPanel.superclass.onDestroy.call(this)}});Ext.reg("editorgrid",Ext.grid.EditorGridPanel);
Ext.grid.GridEditor=function(B,A){Ext.grid.GridEditor.superclass.constructor.call(this,B,A);B.monitorTab=false};Ext.extend(Ext.grid.GridEditor,Ext.Editor,{alignment:"tl-tl",autoSize:"width",hideEl:false,cls:"x-small-editor x-grid-editor",shim:false,shadow:false});
Ext.grid.PropertyRecord=Ext.data.Record.create([{name:"name",type:"string"},"value"]);Ext.grid.PropertyStore=function(A,B){this.grid=A;this.store=new Ext.data.Store({recordType:Ext.grid.PropertyRecord});this.store.on("update",this.onUpdate,this);if(B){this.setSource(B)}Ext.grid.PropertyStore.superclass.constructor.call(this)};Ext.extend(Ext.grid.PropertyStore,Ext.util.Observable,{setSource:function(C){this.source=C;this.store.removeAll();var B=[];for(var A in C){if(this.isEditableValue(C[A])){B.push(new Ext.grid.PropertyRecord({name:A,value:C[A]},A))}}this.store.loadRecords({records:B},{},true)},onUpdate:function(E,A,D){if(D==Ext.data.Record.EDIT){var B=A.data["value"];var C=A.modified["value"];if(this.grid.fireEvent("beforepropertychange",this.source,A.id,B,C)!==false){this.source[A.id]=B;A.commit();this.grid.fireEvent("propertychange",this.source,A.id,B,C)}else{A.reject()}}},getProperty:function(A){return this.store.getAt(A)},isEditableValue:function(A){if(Ext.isDate(A)){return true}else{if(typeof A=="object"||typeof A=="function"){return false}}return true},setValue:function(B,A){this.source[B]=A;this.store.getById(B).set("value",A)},getSource:function(){return this.source}});Ext.grid.PropertyColumnModel=function(C,B){this.grid=C;var D=Ext.grid;D.PropertyColumnModel.superclass.constructor.call(this,[{header:this.nameText,width:50,sortable:true,dataIndex:"name",id:"name",menuDisabled:true},{header:this.valueText,width:50,resizable:false,dataIndex:"value",id:"value",menuDisabled:true}]);this.store=B;this.bselect=Ext.DomHelper.append(document.body,{tag:"select",cls:"x-grid-editor x-hide-display",children:[{tag:"option",value:"true",html:"true"},{tag:"option",value:"false",html:"false"}]});var E=Ext.form;var A=new E.Field({el:this.bselect,bselect:this.bselect,autoShow:true,getValue:function(){return this.bselect.value=="true"}});this.editors={"date":new D.GridEditor(new E.DateField({selectOnFocus:true})),"string":new D.GridEditor(new E.TextField({selectOnFocus:true})),"number":new D.GridEditor(new E.NumberField({selectOnFocus:true,style:"text-align:left;"})),"boolean":new D.GridEditor(A)};this.renderCellDelegate=this.renderCell.createDelegate(this);this.renderPropDelegate=this.renderProp.createDelegate(this)};Ext.extend(Ext.grid.PropertyColumnModel,Ext.grid.ColumnModel,{nameText:"Name",valueText:"Value",dateFormat:"m/j/Y",renderDate:function(A){return A.dateFormat(this.dateFormat)},renderBool:function(A){return A?"true":"false"},isCellEditable:function(A,B){return A==1},getRenderer:function(A){return A==1?this.renderCellDelegate:this.renderPropDelegate},renderProp:function(A){return this.getPropertyName(A)},renderCell:function(A){var B=A;if(Ext.isDate(A)){B=this.renderDate(A)}else{if(typeof A=="boolean"){B=this.renderBool(A)}}return Ext.util.Format.htmlEncode(B)},getPropertyName:function(B){var A=this.grid.propertyNames;return A&&A[B]?A[B]:B},getCellEditor:function(A,E){var B=this.store.getProperty(E);var D=B.data["name"],C=B.data["value"];if(this.grid.customEditors[D]){return this.grid.customEditors[D]}if(Ext.isDate(C)){return this.editors["date"]}else{if(typeof C=="number"){return this.editors["number"]}else{if(typeof C=="boolean"){return this.editors["boolean"]}else{return this.editors["string"]}}}}});Ext.grid.PropertyGrid=Ext.extend(Ext.grid.EditorGridPanel,{enableColumnMove:false,stripeRows:false,trackMouseOver:false,clicksToEdit:1,enableHdMenu:false,viewConfig:{forceFit:true},initComponent:function(){this.customEditors=this.customEditors||{};this.lastEditRow=null;var B=new Ext.grid.PropertyStore(this);this.propStore=B;var A=new Ext.grid.PropertyColumnModel(this,B);B.store.sort("name","ASC");this.addEvents("beforepropertychange","propertychange");this.cm=A;this.ds=B.store;Ext.grid.PropertyGrid.superclass.initComponent.call(this);this.selModel.on("beforecellselect",function(E,D,C){if(C===0){this.startEditing.defer(200,this,[D,1]);return false}},this)},onRender:function(){Ext.grid.PropertyGrid.superclass.onRender.apply(this,arguments);this.getGridEl().addClass("x-props-grid")},afterRender:function(){Ext.grid.PropertyGrid.superclass.afterRender.apply(this,arguments);if(this.source){this.setSource(this.source)}},setSource:function(A){this.propStore.setSource(A)},getSource:function(){return this.propStore.getSource()}});Ext.reg("propertygrid",Ext.grid.PropertyGrid);
Ext.grid.RowNumberer=function(A){Ext.apply(this,A);if(this.rowspan){this.renderer=this.renderer.createDelegate(this)}};Ext.grid.RowNumberer.prototype={header:"",width:23,sortable:false,fixed:true,menuDisabled:true,dataIndex:"",id:"numberer",rowspan:undefined,renderer:function(B,C,A,D){if(this.rowspan){C.cellAttr="rowspan=\""+this.rowspan+"\""}return D+1}};
Ext.grid.CheckboxSelectionModel=Ext.extend(Ext.grid.RowSelectionModel,{header:"<div class=\"x-grid3-hd-checker\">&#160;</div>",width:20,sortable:false,menuDisabled:true,fixed:true,dataIndex:"",id:"checker",initEvents:function(){Ext.grid.CheckboxSelectionModel.superclass.initEvents.call(this);this.grid.on("render",function(){var A=this.grid.getView();A.mainBody.on("mousedown",this.onMouseDown,this);Ext.fly(A.innerHd).on("mousedown",this.onHdMouseDown,this)},this)},onMouseDown:function(C,B){if(C.button===0&&B.className=="x-grid3-row-checker"){C.stopEvent();var D=C.getTarget(".x-grid3-row");if(D){var A=D.rowIndex;if(this.isSelected(A)){this.deselectRow(A)}else{this.selectRow(A,true)}}}},onHdMouseDown:function(C,A){if(A.className=="x-grid3-hd-checker"){C.stopEvent();var B=Ext.fly(A.parentNode);var D=B.hasClass("x-grid3-hd-checker-on");if(D){B.removeClass("x-grid3-hd-checker-on");this.clearSelections()}else{B.addClass("x-grid3-hd-checker-on");this.selectAll()}}},renderer:function(B,C,A){return"<div class=\"x-grid3-row-checker\">&#160;</div>"}});
Ext.LoadMask=function(C,B){this.el=Ext.get(C);Ext.apply(this,B);if(this.store){this.store.on("beforeload",this.onBeforeLoad,this);this.store.on("load",this.onLoad,this);this.store.on("loadexception",this.onLoad,this);this.removeMask=Ext.value(this.removeMask,false)}else{var A=this.el.getUpdater();A.showLoadIndicator=false;A.on("beforeupdate",this.onBeforeLoad,this);A.on("update",this.onLoad,this);A.on("failure",this.onLoad,this);this.removeMask=Ext.value(this.removeMask,true)}};Ext.LoadMask.prototype={msg:"Loading...",msgCls:"x-mask-loading",disabled:false,disable:function(){this.disabled=true},enable:function(){this.disabled=false},onLoad:function(){this.el.unmask(this.removeMask)},onBeforeLoad:function(){if(!this.disabled){this.el.mask(this.msg,this.msgCls)}},show:function(){this.onBeforeLoad()},hide:function(){this.onLoad()},destroy:function(){if(this.store){this.store.un("beforeload",this.onBeforeLoad,this);this.store.un("load",this.onLoad,this);this.store.un("loadexception",this.onLoad,this)}else{var A=this.el.getUpdater();A.un("beforeupdate",this.onBeforeLoad,this);A.un("update",this.onLoad,this);A.un("failure",this.onLoad,this)}}};
Ext.ProgressBar=Ext.extend(Ext.BoxComponent,{baseCls:"x-progress",waitTimer:null,initComponent:function(){Ext.ProgressBar.superclass.initComponent.call(this);this.addEvents("update")},onRender:function(D,A){Ext.ProgressBar.superclass.onRender.call(this,D,A);var C=new Ext.Template("<div class=\"{cls}-wrap\">","<div class=\"{cls}-inner\">","<div class=\"{cls}-bar\">","<div class=\"{cls}-text\">","<div>&#160;</div>","</div>","</div>","<div class=\"{cls}-text {cls}-text-back\">","<div>&#160;</div>","</div>","</div>","</div>");if(A){this.el=C.insertBefore(A,{cls:this.baseCls},true)}else{this.el=C.append(D,{cls:this.baseCls},true)}if(this.id){this.el.dom.id=this.id}var B=this.el.dom.firstChild;this.progressBar=Ext.get(B.firstChild);if(this.textEl){this.textEl=Ext.get(this.textEl);delete this.textTopEl}else{this.textTopEl=Ext.get(this.progressBar.dom.firstChild);var E=Ext.get(B.childNodes[1]);this.textTopEl.setStyle("z-index",99).addClass("x-hidden");this.textEl=new Ext.CompositeElement([this.textTopEl.dom.firstChild,E.dom.firstChild]);this.textEl.setWidth(B.offsetWidth)}this.progressBar.setHeight(B.offsetHeight)},afterRender:function(){Ext.ProgressBar.superclass.afterRender.call(this);if(this.value){this.updateProgress(this.value,this.text)}else{this.updateText(this.text)}},updateProgress:function(B,C){this.value=B||0;if(C){this.updateText(C)}if(this.rendered){var A=Math.floor(B*this.el.dom.firstChild.offsetWidth);this.progressBar.setWidth(A);if(this.textTopEl){this.textTopEl.removeClass("x-hidden").setWidth(A)}}this.fireEvent("update",this,B,C);return this},wait:function(B){if(!this.waitTimer){var A=this;B=B||{};this.updateText(B.text);this.waitTimer=Ext.TaskMgr.start({run:function(C){var D=B.increment||10;this.updateProgress(((((C+D)%D)+1)*(100/D))*0.01)},interval:B.interval||1000,duration:B.duration,onStop:function(){if(B.fn){B.fn.apply(B.scope||this)}this.reset()},scope:A})}return this},isWaiting:function(){return this.waitTimer!=null},updateText:function(A){this.text=A||"&#160;";if(this.rendered){this.textEl.update(this.text)}return this},syncProgressBar:function(){if(this.value){this.updateProgress(this.value,this.text)}return this},setSize:function(A,C){Ext.ProgressBar.superclass.setSize.call(this,A,C);if(this.textTopEl){var B=this.el.dom.firstChild;this.textEl.setSize(B.offsetWidth,B.offsetHeight)}this.syncProgressBar();return this},reset:function(A){this.updateProgress(0);if(this.textTopEl){this.textTopEl.addClass("x-hidden")}if(this.waitTimer){this.waitTimer.onStop=null;Ext.TaskMgr.stop(this.waitTimer);this.waitTimer=null}if(A===true){this.hide()}return this}});Ext.reg("progress",Ext.ProgressBar);
Ext.Slider=Ext.extend(Ext.BoxComponent,{vertical:false,minValue:0,maxValue:100,keyIncrement:1,increment:0,clickRange:[5,15],clickToChange:true,animate:true,dragging:false,initComponent:function(){if(this.value===undefined){this.value=this.minValue}Ext.Slider.superclass.initComponent.call(this);this.keyIncrement=Math.max(this.increment,this.keyIncrement);this.addEvents("beforechange","change","changecomplete","dragstart","drag","dragend");if(this.vertical){Ext.apply(this,Ext.Slider.Vertical)}},onRender:function(){this.autoEl={cls:"x-slider "+(this.vertical?"x-slider-vert":"x-slider-horz"),cn:{cls:"x-slider-end",cn:{cls:"x-slider-inner",cn:[{cls:"x-slider-thumb"},{tag:"a",cls:"x-slider-focus",href:"#",tabIndex:"-1",hidefocus:"on"}]}}};Ext.Slider.superclass.onRender.apply(this,arguments);this.endEl=this.el.first();this.innerEl=this.endEl.first();this.thumb=this.innerEl.first();this.halfThumb=(this.vertical?this.thumb.getHeight():this.thumb.getWidth())/2;this.focusEl=this.thumb.next();this.initEvents()},initEvents:function(){this.thumb.addClassOnOver("x-slider-thumb-over");this.mon(this.el,"mousedown",this.onMouseDown,this);this.mon(this.el,"keydown",this.onKeyDown,this);this.focusEl.swallowEvent("click",true);this.tracker=new Ext.dd.DragTracker({onBeforeStart:this.onBeforeDragStart.createDelegate(this),onStart:this.onDragStart.createDelegate(this),onDrag:this.onDrag.createDelegate(this),onEnd:this.onDragEnd.createDelegate(this),tolerance:3,autoStart:300});this.tracker.initEl(this.thumb);this.on("beforedestroy",this.tracker.destroy,this.tracker)},onMouseDown:function(B){if(this.disabled){return }if(this.clickToChange&&B.target!=this.thumb.dom){var A=this.innerEl.translatePoints(B.getXY());this.onClickChange(A)}this.focus()},onClickChange:function(A){if(A.top>this.clickRange[0]&&A.top<this.clickRange[1]){this.setValue(Math.round(this.reverseValue(A.left)),undefined,true)}},onKeyDown:function(B){if(this.disabled){B.preventDefault();return }var A=B.getKey();switch(A){case B.UP:case B.RIGHT:B.stopEvent();if(B.ctrlKey){this.setValue(this.maxValue,undefined,true)}else{this.setValue(this.value+this.keyIncrement,undefined,true)}break;case B.DOWN:case B.LEFT:B.stopEvent();if(B.ctrlKey){this.setValue(this.minValue,undefined,true)}else{this.setValue(this.value-this.keyIncrement,undefined,true)}break;default:B.preventDefault()}},doSnap:function(B){if(!this.increment||this.increment==1||!B){return B}var D=B,C=this.increment;var A=B%C;if(A>0){if(A>(C/2)){D=B+(C-A)}else{D=B-A}}return D.constrain(this.minValue,this.maxValue)},afterRender:function(){Ext.Slider.superclass.afterRender.apply(this,arguments);if(this.value!==undefined){var A=this.normalizeValue(this.value);if(A!==this.value){delete this.value;this.setValue(A,false)}else{this.moveThumb(this.translateValue(A),false)}}},getRatio:function(){var A=this.innerEl.getWidth();var B=this.maxValue-this.minValue;return B==0?A:(A/B)},normalizeValue:function(A){if(typeof A!="number"){A=parseInt(A)}A=Math.round(A);A=this.doSnap(A);A=A.constrain(this.minValue,this.maxValue);return A},setValue:function(B,A,C){B=this.normalizeValue(B);if(B!==this.value&&this.fireEvent("beforechange",this,B,this.value)!==false){this.value=B;this.moveThumb(this.translateValue(B),A!==false);this.fireEvent("change",this,B);if(C){this.fireEvent("changecomplete",this,B)}}},translateValue:function(A){var B=this.getRatio();return(A*B)-(this.minValue*B)-this.halfThumb},reverseValue:function(B){var A=this.getRatio();return(B+this.halfThumb+(this.minValue*A))/A},moveThumb:function(B,A){if(!A||this.animate===false){this.thumb.setLeft(B)}else{this.thumb.shift({left:B,stopFx:true,duration:0.35})}},focus:function(){this.focusEl.focus(10)},onBeforeDragStart:function(A){return !this.disabled},onDragStart:function(A){this.thumb.addClass("x-slider-thumb-drag");this.dragging=true;this.dragStartValue=this.value;this.fireEvent("dragstart",this,A)},onDrag:function(A){var B=this.innerEl.translatePoints(this.tracker.getXY());this.setValue(Math.round(this.reverseValue(B.left)),false);this.fireEvent("drag",this,A)},onDragEnd:function(A){this.thumb.removeClass("x-slider-thumb-drag");this.dragging=false;this.fireEvent("dragend",this,A);if(this.dragStartValue!=this.value){this.fireEvent("changecomplete",this,this.value)}},onResize:function(A,B){this.innerEl.setWidth(A-(this.el.getPadding("l")+this.endEl.getPadding("r")));this.syncThumb()},syncThumb:function(){if(this.rendered){this.moveThumb(this.translateValue(this.value))}},getValue:function(){return this.value}});Ext.reg("slider",Ext.Slider);Ext.Slider.Vertical={onResize:function(A,B){this.innerEl.setHeight(B-(this.el.getPadding("t")+this.endEl.getPadding("b")));this.syncThumb()},getRatio:function(){var B=this.innerEl.getHeight();var A=this.maxValue-this.minValue;return B/A},moveThumb:function(B,A){if(!A||this.animate===false){this.thumb.setBottom(B)}else{this.thumb.shift({bottom:B,stopFx:true,duration:0.35})}},onDrag:function(B){var C=this.innerEl.translatePoints(this.tracker.getXY());var A=this.innerEl.getHeight()-C.top;this.setValue(Math.round(A/this.getRatio()),false);this.fireEvent("drag",this,B)},onClickChange:function(B){if(B.left>this.clickRange[0]&&B.left<this.clickRange[1]){var A=this.innerEl.getHeight()-B.top;this.setValue(Math.round(A/this.getRatio()),undefined,true)}}};
Ext.StatusBar=Ext.extend(Ext.Toolbar,{cls:"x-statusbar",busyIconCls:"x-status-busy",busyText:"Loading...",autoClear:5000,activeThreadId:0,initComponent:function(){if(this.statusAlign=="right"){this.cls+=" x-status-right"}Ext.StatusBar.superclass.initComponent.call(this)},afterRender:function(){Ext.StatusBar.superclass.afterRender.call(this);var A=this.statusAlign=="right",B=Ext.get(this.nextBlock());if(A){this.tr.appendChild(B.dom)}else{B.insertBefore(this.tr.firstChild)}this.statusEl=B.createChild({cls:"x-status-text "+(this.iconCls||this.defaultIconCls||""),html:this.text||this.defaultText||""});this.statusEl.unselectable();this.spacerEl=B.insertSibling({tag:"td",style:"width:100%",cn:[{cls:"ytb-spacer"}]},A?"before":"after")},setStatus:function(C){C=C||{};if(typeof C=="string"){C={text:C}}if(C.text!==undefined){this.setText(C.text)}if(C.iconCls!==undefined){this.setIcon(C.iconCls)}if(C.clear){var D=C.clear,B=this.autoClear,A={useDefaults:true,anim:true};if(typeof D=="object"){D=Ext.applyIf(D,A);if(D.wait){B=D.wait}}else{if(typeof D=="number"){B=D;D=A}else{if(typeof D=="boolean"){D=A}}}D.threadId=this.activeThreadId;this.clearStatus.defer(B,this,[D])}return this},clearStatus:function(C){C=C||{};if(C.threadId&&C.threadId!==this.activeThreadId){return this}var B=C.useDefaults?this.defaultText:"",A=C.useDefaults?(this.defaultIconCls?this.defaultIconCls:""):"";if(C.anim){this.statusEl.fadeOut({remove:false,useDisplay:true,scope:this,callback:function(){this.setStatus({text:B,iconCls:A});this.statusEl.show()}})}else{this.statusEl.hide();this.setStatus({text:B,iconCls:A});this.statusEl.show()}return this},setText:function(A){this.activeThreadId++;this.text=A||"";if(this.rendered){this.statusEl.update(this.text)}return this},getText:function(){return this.text},setIcon:function(A){this.activeThreadId++;A=A||"";if(this.rendered){if(this.currIconCls){this.statusEl.removeClass(this.currIconCls);this.currIconCls=null}if(A.length>0){this.statusEl.addClass(A);this.currIconCls=A}}else{this.currIconCls=A}return this},showBusy:function(A){if(typeof A=="string"){A={text:A}}A=Ext.applyIf(A||{},{text:this.busyText,iconCls:this.busyIconCls});return this.setStatus(A)}});Ext.reg("statusbar",Ext.StatusBar);
Ext.History=(function(){var E,C;var J=false;var D;function F(){var K=top.location.href,L=K.indexOf("#");return L>=0?K.substr(L+1):null}function A(){C.value=D}function G(K){D=K;Ext.History.fireEvent("change",K)}function H(L){var K=["<html><body><div id=\"state\">",L,"</div></body></html>"].join("");try{var N=E.contentWindow.document;N.open();N.write(K);N.close();return true}catch(M){return false}}function B(){if(!E.contentWindow||!E.contentWindow.document){setTimeout(B,10);return }var N=E.contentWindow.document;var L=N.getElementById("state");var K=L?L.innerText:null;var M=F();setInterval(function(){N=E.contentWindow.document;L=N.getElementById("state");var P=L?L.innerText:null;var O=F();if(P!==K){K=P;G(K);top.location.hash=K;M=K;A()}else{if(O!==M){M=O;H(O)}}},50);J=true;Ext.History.fireEvent("ready",Ext.History)}function I(){D=C.value;if(Ext.isIE){B()}else{var K=F();setInterval(function(){var L=F();if(L!==K){K=L;G(K);A()}},50);J=true;Ext.History.fireEvent("ready",Ext.History)}}return{fieldId:"x-history-field",iframeId:"x-history-frame",events:{},init:function(L,K){if(J){Ext.callback(L,K,[this]);return }if(!Ext.isReady){Ext.onReady(function(){Ext.History.init(L,K)});return }C=Ext.getDom(Ext.History.fieldId);if(Ext.isIE){E=Ext.getDom(Ext.History.iframeId)}this.addEvents("ready","change");if(L){this.on("ready",L,K,{single:true})}I()},add:function(K,L){if(L!==false){if(this.getToken()==K){return true}}if(Ext.isIE){return H(K)}else{top.location.hash=K;return true}},back:function(){history.go(-1)},forward:function(){history.go(1)},getToken:function(){return J?D:F()}}})();Ext.apply(Ext.History,new Ext.util.Observable());

Ext.BLANK_IMAGE_URL = "s.gif";
// fix node background problem
Ext.override(Ext.tree.TreeEventModel, {
	initEvents : function(){
		var el = this.tree.getTreeEl();
		el.on('click', this.delegateClick, this);
		if(this.tree.trackMouseOver !== false){
			var innerCt = Ext.fly(el.dom.firstChild);
			innerCt.on('mouseover', this.delegateOver, this);
			innerCt.on('mouseout', this.delegateOut, this);
		}
		el.on('dblclick', this.delegateDblClick, this);
		el.on('contextmenu', this.delegateContextMenu, this);
	}
});
// disable keyboard navigation on tree panels
Ext.tree.DefaultSelectionModel.override({
   onKeyDown: Ext.emptyFn
});
/**/
// Uncomment this to support drag and drop in grids
// Also uncomment enableDrag on grids, enableDrop on workspacepanel and ddGroup on both
Ext.grid.CheckboxSelectionModel.override({
    handleMouseDown: Ext.emptyFn   
});
Ext.grid.GridView.override({
	focusCell : function(row, col, hscroll){
		this.syncFocusEl(this.ensureVisible(row, col, hscroll));
		this.focusEl.focus.defer(1, this.focusEl);
	},

    syncFocusEl : function(row, col, hscroll){
        var xy = row;
        if(!Ext.isArray(xy)){
            row = Math.min(row, Math.max(0, this.getRows().length-1));
            //xy = this.getResolvedXY(this.resolveCell(row, col, hscroll));
        }
        this.focusEl.setXY(xy||this.scroller.getXY());
    }
});
Ext.grid.RowSelectionModel.override({
    initEvents : function() {
        if (!this.grid.enableDragDrop && !this.grid.enableDrag) {
            this.grid.on("rowmousedown", this.handleMouseDown, this);
        } else { // allow click to work like normal
            this.grid.on("rowclick", function(grid, rowIndex, e) {
                var target = e.getTarget();                
                if (target.className !== 'x-grid3-row-checker' && e.button === 0 && !e.shiftKey && !e.ctrlKey) {
                    this.selectRow(rowIndex, false);
                    grid.view.focusRow(rowIndex);
                }
            }, this);
        }

        this.rowNav = new Ext.KeyNav(this.grid.getGridEl(), {
            "up" : function(e){
                if(!e.shiftKey){
                    this.selectPrevious(e.shiftKey);
                }else if(this.last !== false && this.lastActive !== false){
                    var last = this.last;
                    this.selectRange(this.last,  this.lastActive-1);
                    this.grid.getView().focusRow(this.lastActive);
                    if(last !== false){
                        this.last = last;
                    }
                }else{
                    this.selectFirstRow();
                }
            },
            "down" : function(e){
                if(!e.shiftKey){
                    this.selectNext(e.shiftKey);
                }else if(this.last !== false && this.lastActive !== false){
                    var last = this.last;
                    this.selectRange(this.last,  this.lastActive+1);
                    this.grid.getView().focusRow(this.lastActive);
                    if(last !== false){
                        this.last = last;
                    }
                }else{
                    this.selectFirstRow();
                }
            },
            scope: this
        });

        var view = this.grid.view;
        view.on("refresh", this.onRefresh, this);
        view.on("rowupdated", this.onRowUpdated, this);
        view.on("rowremoved", this.onRemove, this);        
    }
}); 
/**/

function StringBuffer() { 
  this.buffer = []; 
} 

StringBuffer.prototype.append = function append(string) { 
  this.buffer.push(string); 
  return this; 
}; 

StringBuffer.prototype.toString = function toString() { 
  return this.buffer.join(""); 
}; 


var og = {};
var ogTasks = {};
var ogTaskEvents = {};
ogTasksTask = {};
ogTasksMilestone = {};
ogTasksCompany = {};
ogTasksUser = {};
var vtindex = 0;
var vtlist = [];

og.eventTimeouts = [];
og.otherData = [];

// default config (to be overridden by server)
og.hostName = '';
og.maxFileSize = 1024 * 1024;

og.showMailsTab = 0;

// functions
og.msg =  function(title, text, timeout, classname, sound) {
	if (typeof timeout == 'undefined') timeout = 4;
	if (!classname) classname = "msg";

	var click_to_remove_msg = ''; // only show this message if message doesn't vanish by itself
	if (timeout == 0)
		click_to_remove_msg = '<div class="x-clear"></div><div class="click-to-remove">'+ lang('close') + ' X</div><div class="x-clear"></div>';
	

	var box = ['<div class="' + classname + '" title="' + lang('click to remove') + '">',
			'<div class="og-box-tl"><div class="og-box-tr"><div class="og-box-tc"></div></div></div>',
			'<div class="og-box-ml"><div class="og-box-mr"><div class="og-box-mc"><h3>{0}:</h3><p>{1}</p>',
			click_to_remove_msg, 
			'</div></div></div>',
			'<input type="hidden" value="' + new Date().getTime() + '" />',
			'<div class="og-box-bl"><div class="og-box-br"><div class="og-box-bc"></div></div></div>',
			'</div>'].join('');
	
	if( !this.msgCt){
	    this.msgCt = Ext.DomHelper.insertFirst(document.body, {id:'msg-div'}, true);
	}
	//	this.msgCt.alignTo(document, 't-t');
	var m = Ext.DomHelper.append(this.msgCt, {html:String.format(box, title, text.replace(/([^>])\n/g, '$1<br/>\n'))}, true);
	Ext.get(m).on('click', function() {
		if (timeout > 0) {
			this.setStyle('display', 'none');
		} else {
			this.remove();
		}
	});
	m.timeout = 'aaaaa';
	if (timeout > 0) {
		m.slideIn('t').pause(timeout).ghost("t", {remove:true});
	} else {
		m.slideIn('t');
	}
	if (sound) {
		og.systemSound.loadSound('public/assets/sounds/' + sound + '.mp3', true);
		og.systemSound.start(0);
	}
};

og.updateClock = function(clockId){
	var clock = og.eventTimeouts[clockId + "clock"];
	if(clock) {
		clearTimeout(clock);
	}

	var startTime = og.otherData[clockId + "starttime"];
	var startSeconds = og.otherData[clockId + "startseconds"];
	var nowTime = new Date();
	var elapsed = ((nowTime.getElapsed(startTime) / 1000) + startSeconds).toFixed(0);
	var seconds = (elapsed % 60) / 1;
	var totalMinutes = (elapsed - seconds) / 60;
	var minutes = totalMinutes % 60;
	var totalHours = (totalMinutes - minutes) / 60;  
	minutes = ( minutes < 10 ? "0" : "" ) + minutes;
  	seconds = ( seconds < 10 ? "0" : "" ) + seconds.toFixed(0);
	

	var ts = document.getElementById(clockId + "timespan");
	if (ts){
		ts.innerHTML = totalHours + ":" + minutes + ":" + seconds;

		og.eventTimeouts[clockId + "clock"] = setTimeout("og.updateClock('" + clockId + "')", 1002);
	} else {
		og.eventTimeouts[clockId + "clock"] = 0;
	}
};

og.startClock = function(clockId, startSeconds){
	og.otherData[clockId + "starttime"] = new Date();
	og.otherData[clockId + "startseconds"] = startSeconds;
	og.updateClock(clockId);
};

og.err = function(text) {
	var errors = Ext.query("div.err");
	var maxErrors = 2;
	for (var i=0; i < errors.length - maxErrors + 1; i++) {
		Ext.fly(errors[i]).remove();
	}
	og.msg(lang("information"), text, 0, "err");
};

og.clearErrors = function(timeout) {
	var errors = Ext.query("div.err");
	for (var i=0; i < errors.length; i++) {
		if (timeout) {
			var inputs = Ext.fly(errors[i]).query('input');
			var ts = inputs[0].value;
			if (new Date().getTime() - ts > timeout*1000) {
				// clear error only if timeout seconds have ellapsed
				Ext.fly(errors[i]).remove();
			}
		} else {
			Ext.fly(errors[i]).remove();
		}
	}
};

og.hideAndShow = function(itemToHide, itemToDisplay){
	Ext.get(itemToHide).setDisplayed('none');
	Ext.get(itemToDisplay).setDisplayed('block');
};

og.hideAndShowByClass = function(itemToHide, classToDisplay, containerItemName, count){
	Ext.get(itemToHide).setDisplayed('none');
	
	var list;
	var container;
	if (containerItemName != ''){
		container = document.getElementById(containerItemName);
	} else container = document;
	
	list = container.getElementsByTagName("*");
	
	for(var i = 0; i < list.length; i++){
		var obj = list[i];
		if (obj.className != '' && obj.className.indexOf(classToDisplay) >= 0) {
			obj.style.display = '';
			if (count) {
				count--;
				if (count == 0) break;
			}
		}
	}
};


og.selectReportingMenuItem = function(link, divName, tab){
	var table = document.getElementById('reportingMenu');
	
	var list = table.getElementsByTagName('td');
	for(var i = 0; i < list.length; i++)
		if (list[i].className == 'report_selected_menu')
			list[i].className = 'report_unselected_menu';
		
	link.parentNode.className = 'report_selected_menu';
	link.blur();
	
	list = table.getElementsByTagName('div');
	for(var i = 0; i < list.length; i++)
		if (list[i].className == 'inner_report_menu_div')
			list[i].style.display = 'none';
			
	document.getElementById(divName).style.display='block';
	
	var url = og.getUrl('account', 'update_user_preference', {name: 'custom_report_tab', value: tab});
	og.openLink(url,{hideLoading:true});
}

og.dateselectchange = function(select) {
	var list = select.offsetParent.offsetParent.getElementsByTagName('tr');
	for(var i = 0; i < list.length; i++)
		if (list[i].className == 'dateTr')
			list[i].style.display = select.value == '6'? 'table-row':'none';
}

og.timeslotTypeSelectChange = function(select, genid) {
	document.getElementById(genid + 'gbspan').style.display = select.value > 0? 'none':'inline';
	document.getElementById(genid + 'altgbspan').style.display = select.value > 0? 'inline':'none';
}

og.switchToOverview = function(){
	/*var opanel = Ext.getCmp('overview-panel');
	opanel.defaultContent = {type: 'url', data: og.getUrl('dashboard', 'init_overview')};
	opanel.load(opanel.defaultContent);*/
};

og.switchToDashboard = function(){
	/*var opanel = Ext.getCmp('overview-panel');
	opanel.defaultContent = {type: "url", data: og.getUrl('dashboard','index')};
	opanel.load(opanel.defaultContent);*/
};

og.customDashboard = function (controller,action,params, reload) {
	if (!params) params = {};
	if (!controller) return false; 
	if (!action) action = 'init'  ;
	var opanel = Ext.getCmp('overview-panel');
	var new_data = og.getUrl(controller,action, params) ;
	var content = {type: "url", data: new_data};
	opanel.defaultContent = content ;
	if (reload) {
		opanel.load(content);
	}
}

og.loading = function() {
	if (!this.loadingCt) {
		this.loadingCt = document.createElement('div');
		this.loadingCt.innerHTML = lang('loading');
		this.loadingCt.className = 'loading-indicator og-loading';
		this.loadingCt.onclick = function() {
			this.style.visibility = 'hidden';
			this.instances = 0;
		};
		this.loadingCt.instances = 0;
		document.body.appendChild(this.loadingCt);
	}
	this.loadingCt.instances++;
	this.loadingCt.style.visibility = 'visible';
};

og.hideLoading = function() {
	this.loadingCt.instances--;
	if (this.loadingCt.instances <= 0) {
		this.loadingCt.style.visibility = 'hidden';
	}
};

og.otherMsgCt = null;
og.showOtherMessage = function(msg, left_percent) {
	if (!og.otherMsgCt) {
		og.otherMsgCt = document.createElement('div');
		og.otherMsgCt.innerHTML = msg;
		og.otherMsgCt.className = 'loading-indicator';
		og.otherMsgCt.style.position = 'absolute';
		og.otherMsgCt.style.left = (left_percent != null ? left_percent : '15%');
		og.otherMsgCt.style.zIndex = 1000000;
		og.otherMsgCt.style.cursor = 'pointer';
		og.otherMsgCt.onclick = function() {
			this.style.visibility = 'hidden';
			this.instances = 0;
		};
		og.otherMsgCt.instances = 0;
		document.body.appendChild(og.otherMsgCt);
	}
	og.otherMsgCt.instances++;
	og.otherMsgCt.style.visibility = 'visible';
};

og.hideOtherMessage = function() {
	og.otherMsgCt.instances--;
	if (og.otherMsgCt.instances <= 0) {
		og.otherMsgCt.style.visibility = 'hidden';
	}
};

og.toggle = function(id, btn) {
	var obj = Ext.fly(id);
	if (obj.isDisplayed()) {
		obj.slideOut("t", {duration: 0.5, useDisplay: true});
		if (btn) Ext.fly(btn).replaceClass('toggle_expanded', 'toggle_collapsed');
	} else {
		obj.slideIn("t", {duration: 0.5, useDisplay: true});
		if (btn) Ext.fly(btn).replaceClass('toggle_collapsed', 'toggle_expanded');
	}
};

og.toggleAndBolden = function(id, btn) {
	var obj = Ext.get(id);
	if (obj.isDisplayed()) {
		obj.dom.style.display = 'none';
		//obj.slideOut("t", {duration: 0.5, useDisplay: true});
		if (btn) 
			btn.style.fontWeight = 'normal';
	} else {
		obj.dom.style.display = 'block';
		//obj.slideIn("t", {duration: 0.5, useDisplay: true});
		if (btn) 
			btn.style.fontWeight = 'bold';
	}
};

og.toggleSimpleTab = function(id, contentContainer, tabContainer, tab) {
	var tc = Ext.getDom(tabContainer);
	var child = tc.firstChild;
	while (child) {
		if (child.style) {
			child.style.fontWeight = 'normal';
		}
		child = child.nextSibling;
	}
	if (tab) {
		tab.style.fontWeight = 'bold';
		tab.blur();
	}

	var cc = Ext.getDom(contentContainer);
	var child = cc.firstChild;
	while (child) {
		if (child.style) {
			child.style.display = 'none';
		}
		child = child.nextSibling;
	}
	var obj = Ext.get(id);
	obj.dom.style.display = 'block';
};

og.showAndHide = function(idToShow, idsToHide, displayType){
	if (!displayType)
		displayType = 'block';
	var show = document.getElementById(idToShow);
	if(show){
		show.style.display = displayType;
		for(var i = 0; i < idsToHide.length; i++){
			var hide = document.getElementById(idsToHide[i]);
			if (hide) hide.style.display = 'none';
		}
	}
};

og.toggleAndHide = function(id, btn) {
	var obj = Ext.getDom(id);
	if (obj.style.display == 'block') {
		obj.style.display = 'none';
		if (btn) 
			btn.style.display = 'none';
	} else {
		obj.style.display = 'block';
		if (btn) 
			btn.style.display = 'none';
	}
};


og.getUrl = function(controller, action, args) {

	var url = og.getHostName() + "/index.php";
	url += "?c=" + controller;
	url += "&a=" + action;
	for (var key in args) {
		url += "&" + encodeURIComponent(key) + "=" + encodeURIComponent(args[key]);
	}
	return url;
};

og.getSandboxUrl = function(controller, action, args) {
	var url = og.getSandboxName() + "/index.php";
	url += "?c=" + controller;
	url += "&a=" + action;
	for (var key in args) {
		url += "&" + encodeURIComponent(key) + "=" + encodeURIComponent(args[key]);
	}
	return url;
};

og.filesizeFormat = function(fs) {
	if (fs > 1024 * 1024) {
		var total = Math.round(fs / 1024 / 1024 * 10);
		return total / 10 + "." + total % 10 + " MB";
	} else {
		var total = Math.round(fs / 1024 * 10);
		return total / 10 + "." + total % 10 + " KB";
	}
};


og.makeAjaxUrl = function(url, params) {
	//og.msg("","Make ajax url"+url , 15);
	//alert(params.toSource()) ;
	var q = url.indexOf('?');
	var n = url.indexOf('#');
	var ap = "";
	if ( url.indexOf("context") < 0 && (params && !params.context) ) {
		var ap = "context=" + og.contextManager.plainContext();
	}
	if (url.indexOf("ajax=true") < 0) {
		var aj = "&ajax=true";
	} else {
		var aj = "";
	}
	var p = "";
	if (params) {
		if (typeof params == 'string') {
			if (params != ''){
				p = "&" + params;
			}
		} else {
			for (var k in params) {
				p += "&" + encodeURIComponent(k) + "=" + encodeURIComponent(params[k]);
			}
		}
	}
	
	if (q < 0) {
		if (n < 0) {
			return url + "?" + ap + aj +  p;
		} else {
			return url.substring(0, n) + "?" + ap + aj + (url.substring(n) != ''? "&":"") + url.substring(n) + p;
		}
	} else {
		return url.substring(0, q + 1) + ap + aj + (url.substring(q + 1) != ''? "&":"") + url.substring(q + 1) + p;
	}
};

og.createHTMLElement = function(config) {
	var tag = config.tag || 'p';
	var attrs = config.attrs || {};
	var content = config.content || {};
	var elem = document.createElement(tag);
	for (var k in attrs) {
		elem[k] = attrs[k];
	}
	if (typeof content == 'string') {
		elem.innerHTML = content;
	} else {
		for (var i=0; i < content.length; i++) {
			elem.appendChild(og.createHTMLElement(content[i]));
		}
	}
	return elem;
};

og.debug = function(obj, level) {
	if (!level) level = 0;
	if (level > 5) return "";
	var pad = "";
	var str = "";
	for (var i=0; i < level; i++) {
		pad += "  ";
	}
	if (!obj) {
		str = "NULL";
	} else if (typeof obj == 'object') {
		str = "";
		for (var k in obj) {
			str += ",\n" + pad + "  ";
			str += k + ": ";
			str += og.debug(obj[k], level + 1);
		}
		str = "{" + str.substring(1) + "\n" + pad + "}";
	} else if (typeof obj == 'string') {
		str = '"' + obj + '"';
	} else {
		str = obj;
	}
	return str;
};

og.captureLinks = function(id, caller) {
	var element = document.getElementById(id);
	if (!element) element = document;
	var links = element.getElementsByTagName("a");
	for (var i=0; i < links.length; i++) {
		var link = links[i];
		if (!link.href || Ext.isGecko && link.href == link.baseURI || link.href.indexOf('mailto:') == 0 || link.href.indexOf('javascript:') == 0 || link.href.indexOf('#') >= 0) continue;
		if (link.target && link.target[0] == '_') continue;
		if (caller && !link.target) {
			link.target = caller.id;
		}
		link.onvalidate = link.onclick;
		link.onclick = function(e) {
			if (typeof this.onvalidate != 'function') {
				var p = true;
			} else {
				try {
					var p = this.onvalidate(e);
				} catch (e) {
				}
			}
			if (p || typeof p == 'undefined' ) {
				og.openLink(this.href, {caller: this.target}) ;
			}
			return false;
		}
	};
	forms = element.getElementsByTagName("form");
	for (var i=0; i < forms.length; i++) {
		
		var form = forms[i];
		if (form.target && form.target[0] == '_') continue;
		if (caller && !form.target) {
			form.target = caller.id;
		}
		var onsubmit = form.onsubmit;
		form.onsubmit = function() {
			if (onsubmit && !onsubmit()) {
				return false;
			} else {
				og.ajaxSubmit(this, {caller: this.target});
			}
			return false;
		}
	};
};

og.log = function(msg) {
	if (!og._log) og._log = "";
	og._log += msg + "\n";
};

og.openLink = function(url, options) {
	if (url.indexOf("c=access&a=index") != -1) return ;
	if (url.indexOf("c=dashborad&a=activity_feed") != -1) return ;
	if (!options) options = {};
	if (typeof options.caller == "object") {
		options.caller = options.caller.id;
	}
	if (!options.caller) {
		var tabs = Ext.getCmp('tabs-panel');
		if (tabs) {
			var active = tabs.getActiveTab();
			if (active) options.caller = active.id;
		}
	}
    
	if (!options.hideLoading && !options.silent) {
		og.loading();
	}
	if (!options.hideLoading && !options.hideErrors && !options.silent) {
		og.clearErrors(5);
	}
	var params = options.get || {};
	if (typeof params == 'string' && params.indexOf('current=') < 0) {
		params += "&current=" + options.caller;
	} else {
		if (options.caller && ! params.current)
			params.current = options.caller;
	}
	if (url.substring(url.length - 5) != '.html') {
		// don't add params to HTML pages (this prevents 405 errors from apache 1.3)
		url = og.makeAjaxUrl(url, params);
	}
	if (typeof options.timeout != "undefined") {
		var oldTimeout = Ext.Ajax.timeout;
		Ext.Ajax.timeout = options.timeout;
	}
	var startTime = new Date().getTime();
	Ext.Ajax.request({
		url: url,
		params: options.post,
		callback: function(options, success, response) {
			if (!options.options.hideLoading && !options.silent) {
				og.hideLoading();
			}
            
           og.eventManager.fireEvent('openLink callback', response);
            
			if (success) {
				UnTip(); //fixes ws tooltip is displayed some times when changing page
				if (og)
					clearTimeout(og.triggerFPTTO);
				try {
					try {
						var data = Ext.util.JSON.decode(response.responseText);
					} catch (e) {
						// response isn't valid JSON, display it on the caller panel or new tab
						if (!options.preventPanelLoad && !options.options.silent) {
							var p = Ext.getCmp(options.caller);
							if (p) {
								var tp = p.ownerCt;
								p.load(response.responseText);
								if (tp && tp.setActiveTab && options.options.show) {
									tp.setActiveTab(p);
								}
							} else {
								og.newTab(response.responseText);
							}
						}
					}
					og.processResponse(data, options);
				} catch (e) {
					og.err(e.message);
				}
				var ok = typeof data == 'object' && data.errorCode == 0;
				if (typeof options.postProcess == 'function') options.postProcess.call(options.scope || this, ok, data || response.responseText, options.options);
				if (ok) {
					if (typeof options.onSuccess == 'function') options.onSuccess.call(options.scope || this, data || response.responseText, options.options);
				} else {
					if (typeof options.onError == 'function') options.onError.call(options.scope || this, data || response.responseText, options.options);
				}
			} else {
				if (!options.options.hideErrors && !options.options.silent && response.status > 0) {
					og.err(lang("http error", response.status, response.statusText));
					og.httpErrLog = og.clean(response.responseText);
				}
				if (typeof options.postProcess == 'function') options.postProcess.call(options.scope || this, false, data || response.responseText, options.options);
				if (typeof options.onError == 'function') options.onError.call(options.scope || this, data || response.responseText, options.options);
			}
			var endTime = new Date().getTime();
			//og.log(url + ": " + (endTime - startTime) + " ms");
		},
		caller: options.caller,
		postProcess: options.callback || options.postProcess,
		onSuccess: options.onSuccess,
		onError: options.onError,
		scope: options.scope,
		preventPanelLoad: options.preventPanelLoad,
		options: options
	});
	if (typeof oldTimeout != "undefined") {
		Ext.Ajax.timeout = oldTimeout;
	}
};

/**
 *  This function allows to submit a form containing a file upload without
 *  refreshing the whole page by using an iframe. The request will behave
 *  as an ajax request (openLink function). You can specify in
 *  the options parameter a forcedCallback property of type function that
 *  will be invoked after the upload.
 */
og.submit = function(form, options) {
	if (!options) options = {};
	// create an iframe
	var id = Ext.id();
	var frame = document.createElement('iframe');
	frame.id = id;
	frame.name = id;
	frame.className = 'x-hidden';
	document.body.appendChild(frame);
	frame.src = Ext.SSL_SECURE_URL;

	if(Ext.isIE){
	   document.frames[id].name = id;
	}
	options.panel = options.panel || Ext.getCmp('tabs-panel').getActiveTab().id;
	
	var origUrl = form.getAttribute('action');
	var origTarget = form.getAttribute('target');
	
	Ext.EventManager.on(frame, 'load', function() {
			if (frame.submitted) {
				form.setAttribute('action', origUrl);
				form.setAttribute('target', origTarget);
				
				if (typeof options.forcedCallback == 'function') {
					options.forcedCallback();
				}
				
				og.hideLoading();
				setTimeout(function(){Ext.removeNode(frame);}, 100);
			}
		}, frame
	);
	
	og.submit[id] = options;
	form.setAttribute('target', frame.name);
	var url = og.makeAjaxUrl(origUrl) + "&upload=true&current=" + options.panel + "&request_id=" + id;
	form.setAttribute('action', url);
	og.loading();
	frame.submitted = 1;
	form.submit();
	return false;
};

/**
 * Submits a form through an open link by serializing it.
 * Doesn't work with file uploads. Use og.submit for that purpose.
 */
og.ajaxSubmit = function(form, options) {
	if (!options) options = {};
	var params = Ext.Ajax.serializeForm(form);
	options[form.getAttribute('method').toLowerCase()] = params;
	og.openLink(form.getAttribute('action'), options);
	return false;
};

og.processResponse = function(data, options, url) {
	if (!data) return;
	
	// first load scripts
	og.loadScripts(data.scripts || [], {
		callback: function() {
			if (options) var caller = options.caller;
			
			if (data.errorCode == 2009 || data.u != og.loggedUser.id) {
				if (options) {
					og.LoginDialog.show(options.url, options.options);
				} else {
					og.LoginDialog.show();
				}
				return;
			}
			
			//Fire events
			if (data.events) {
				for (var i=0; i < data.events.length; i++) {
					og.eventManager.fireEvent(data.events[i].name, data.events[i].data);
				}
			}
			
			//Load data
			if (!options || !options.preventPanelLoad && (!options.options || !options.options.silent)){
				//Load data into more than one panel
				if (data.contents) {
					for (var k in data.contents) {
						var p = Ext.getCmp(k);
						if (p) {
							p.load(data.contents[k]);
						}
					}
				}
				
				//Loads data into a single panel
				if (data.current) {
					data.current.inlineScripts = data.inlineScripts;
					if (data.current.panel || caller) { //Loads data into a specific panel
						var panelName = data.current.panel ? data.current.panel : caller; //sets data into current.panel, otherwise into caller
						var p = Ext.getCmp(panelName);
						if (p) {
							var tp = p.ownerCt;
							p.load(data.current);
							if (tp && tp.setActiveTab && Ext.getCmp(panelName) && (options.options.show || data.current.panel)) {
								tp.setActiveTab(p);
							}
							
						} else {
							og.newTab(data.current, panelName, data); //Creates the panel if it doesn't exist
						}
					} else { //Loads the data into a new tab
						og.newTab(data.current);
					}
				}
				
				//Show help in content panel if help is available
				if (data.help_content){
					Ext.getCmp('help-panel').load(data.help_content);
				}
			}
			//Show messages if any
			if (data.errorCode != 0 && (!options.options || !options.options.hideErrors && !options.options.silent)) {
				og.err(data.errorMessage);
			} else if (data.errorMessage) {
				og.msg(lang("success"), data.errorMessage);
			}
		}
	});
};

og.newTab = function(content, id, data) {
	if (!data) data = {};
	if (!data.title) {
		data.title = id?lang(id):lang('new tab');
	}
	data.tabTip = data.tabTip || data.title;
	if (data.title.length >= 15) data.title = data.title.substring(0,12) + '...';
	data.iconCls = data.iconCls || data.icon || (id ? 'ico-' + id : 'ico-tab');
	var tp = Ext.getCmp('tabs-panel');
	var t = new og.ContentPanel(Ext.apply(data, {
		closable: true,
		id: id || Ext.id(),
		defaultContent: content
	}));
	tp.add(t);
	tp.setActiveTab(t);
};

/**
 *  adds an event handler to an element, keeping the previous handlers for that event.
 *  	elem: element to which to add the event handler (e.g. document)
 *  	ev: event to handle (e.g. mousedown)
 *  	fun: function that will handle the event. Arguments: (event, handler_id)
 *  	scope: (optional) on which object to run the function
 *      returns: id of the event handler
 */
og.addDomEventHandler = function(elem, ev, fun, scope) {
	if (scope) fun = fun.createCallback(scope);
	if (!elem[ev + "Handlers"]) {
		elem[ev + "Handlers"] = {};
		if (typeof elem["on" + ev] == 'function') {
			elem[ev + "Handlers"]['original'] = elem["on" + ev];
		}
		elem["on" + ev] = function(event) {
			for (var id in this[ev + "Handlers"]) {
				this[ev + "Handlers"][id](event, id);
			}
		};
	}
	var id = Ext.id();
	elem[ev + "Handlers"][id] = fun;
};

/**
 *  Removes an event handler for the event that was added
 *  with og.addDomEventHandler.
 *  	elem: dom element
 *  	ev: event
 *  	id: id of the handler that was returned by og.addDomEventHandler.
 * 
 */
og.removeDomEventHandler = function(elem, ev, id) {
	if (!elem || !id || !ev || !elem[ev + "Handlers"]) return;
	delete elem[ev + "Handlers"][id];
};

og.eventManager = {
	events: new Array(),
	eventsById: new Array(),
	addListener: function(event, callback, scope, options) {
		if (!options) options = {};
		if (!this.events[event] || options.replace) {
			this.events[event] = new Array();
		}
		var id = Ext.id();
		var evobj = {
			id: id,
			callback: callback,
			scope: scope,
			options: options
		};
		this.events[event].push(evobj);
		this.eventsById[id] = evobj;
		return id;
	},
	removeListener: function(id) {
		var ev = this.eventsById[id];
		if (!ev) return;
		this.eventsById[id] = null;
	},
	fireEvent: function(event, arguments) {
		var list = this.events[event];
		if (!list) {
			return;
		}
		for (var i=list.length-1; i >= 0; i--) {
			if (!this.eventsById[list[i].id]) {
				list.splice(i, 1);
			}
			var ret = "";
			try {
				ret = list[i].callback.call(list[i].scope, arguments, list[i].id);
			} catch (e) {
				og.err(e.message);
			}
			if (list[i].options.single || ret == 'remove') {
				list.splice(i, 1);;
			}
		}
	}
};

og.showHelp = function() {
	Ext.getCmp('help-panel').toggleCollapse();
};

og.extractScripts = function(html) {
	var id = Ext.id();
	html += '<span id="' + id + '"></span>';
	Ext.lib.Event.onAvailable(id, function() {
		try {
			var startTime = new Date().getTime();
			var re = /(?:<script([^>]*)?>)((\n|\r|.)*?)(?:<\/script>)/ig;
			var match;
			while (match = re.exec(html)) {
				if (match[2] && match[2].length > 0) {
					try {
						if (window.execScript) {
							window.execScript(match[2]);
						} else {
							window.eval(match[2]);
						}
					} catch (e) {
						og.err(e.message);
					}
				}
			}
			var endTime = new Date().getTime();
			//og.log("scripts: " + (endTime - startTime) + " ms");
			var el = document.getElementById(id);
			if (el) { Ext.removeNode(el); }
		} catch (e) { alert(e);}
	});
	
	return html.replace(/(?:<script.*?>)((\n|\r|.)*?)(?:<\/script>)/ig, "");
};

og.clone = function(o) {
	if('object' !== typeof o) {
		return o;
	}
	var c = 'function' === typeof o.pop ? [] : {};
	var p, v;
	for(p in o) {
		v = o[p];
		if('object' === typeof v) {
			c[p] = og.clone(v);
		}
		else {
			c[p] = v;
		}
	}
	return c;
};

og.closeView = function(obj){
	var currentPanel = Ext.getCmp('tabs-panel').getActiveTab();
	currentPanel.back();
};

og.slideshow = function(id) {
	var url = og.getUrl('files', 'slideshow', {fileId: id});
	var top = screen.height * 0.1;
	var left = screen.width * 0.1;
	var width = screen.width * 0.8;
	var height = screen.height * 0.8;
	window.open(url, 'slideshow', 'top=' + top + ',left=' + left + ',width=' + width + ',height=' + height + ',status=no,menubar=no,location=no,toolbar=no,scrollbars=no,directories=no,resizable=yes')
};


og.getParentContentPanel = function(dom) {
	return Ext.fly(dom).findParentNode('.og-content-panel', 100);
};

og.getParentContentPanelBody = function(dom) {
	return Ext.fly(dom).findParentNode('.x-panel-body', 100);
};




og.removeLinkedObjectRow = function (r, tblId, confirm_msg){
	if (confirm(confirm_msg)){
		var i=r.parentNode.parentNode.rowIndex;		
		var tbl = document.getElementById(tblId);
		tbl.deleteRow(i);
		tbl.deleteRow(i-1);
	}
};

og.addLinkedObjectRow = function (tblId,obj_type,obj_id,obj_name, obj_manager, confirm_msg, unlink_msg){
	var tbl = document.getElementById(tblId);
	var cantRows = tbl.rows.length / 2;
	var row1=tbl.insertRow(tbl.rows.length);
	row1.className = 'linkedObject';
	row1.className += (cantRows% 2 == 0) ? 'even' : 'odd';
	
	var td1 = row1.insertCell(0);
	td1.rowSpan = 2;
	td1.style.paddingLeft = 1;
	td1.style.verticalAlign = 'middle';
	td1.style.width = '25px'
	td1.innerHTML = "<input type='hidden' value='"+obj_id+"' name='rel_objects[id_"+ cantRows +"]' />";
	td1.innerHTML += "<input type='hidden' value='"+obj_manager+"' name='rel_objects[type_"+ cantRows +"]' />";
	td1.innerHTML += "<div class='db-ico unknown ico-"+obj_type+ "' title='"+obj_type+"'></div>";
	
	var td2 = row1.insertCell(1);
	
	td2.innerHTML = "<b><span>"+obj_name+"</span></b>";
	
	var row2=tbl.insertRow(tbl.rows.length);
	row2.className = row1.className;
	var td2 = row2.insertCell(0);
	td2.innerHTML = '<a class="internalLink" href="#" onclick="og.removeLinkedObjectRow(this,\''+tblId+'\',\''+confirm_msg+'\')" title="' +unlink_msg+ ' object">' +unlink_msg+ '</a>';
};



/***********************************************************************/
/*********** Extending Ext.PagingToolbar  ******************************/
/***********************************************************************/

og.PagingToolbar	=	function (config) {
	og.PagingToolbar.superclass.constructor.call (this, config);
};

Ext.extend (og.PagingToolbar, Ext.PagingToolbar, {
	// override the private function 'getPageData' so that Ext.PagingToolbar 
	// will read the 'start' parameter returned from server, 
	// and set the specified page number, while presume the default behavior 
	// when the server doesn't return the 'start' parameter.
	// (JSON example).
	getPageData : function(){
 		var total = this.store.getTotalCount();
		var	ap	=	Math.ceil((this.cursor+this.pageSize)/this.pageSize);
		if (this.store.reader.jsonData) {
			var start = parseInt(this.store.reader.jsonData.start);
			// go to the specified page
			ap	=	Math.ceil((start + this.pageSize)/this.pageSize);
			// also set the cursor so that 'prev' and 'next' buttons behave correctly
			this.cursor	= start;
		}

		return {
			total : total,
			activePage : ap,
			pages :  total < this.pageSize ? 1 : Math.ceil(total/this.pageSize)
		};
	}
});

og.getGooPlayerPanel = function(callback) {
	var gppanel = Ext.getCmp('gooplayer-panel');
	if (gppanel) {
		callback();
	} else {
		og.loadScripts([
				og.getScriptUrl('og/ObjectPicker.js'),
				og.getScriptUrl('og/GooPlayer.js')
			], {
			callback: function() {
				og.newTab({
						type: "panel",
						data: "gooplayer",
						config: {
							id: 'gooplayer',
							sound: og.musicSound
						}
					},
					'gooplayer-panel', {
						title: 'GooPlayer',
						icon: 'ico-gooplayer'
					}
				);
				gppanel = Ext.getCmp('gooplayer-panel');
				callback();
			}
		});
	}
	return gppanel;
};

og.playMP3 = function(track) {
	if (og.isFlashSupported()) {
		var gppanel = og.getGooPlayerPanel(function() {
			Ext.getCmp('tabs-panel').setActiveTab(gppanel);
			var gooplayer = Ext.getCmp('gooplayer');
			gooplayer.loadPlaylist([track]);
			gooplayer.start();
		});
	} else if (track[6]) {
		window.open(track[6]);
	}
};

og.queueMP3 = function(track) {
	if (og.isFlashSupported()) {
		var gppanel = og.getGooPlayerPanel(function() {
			var gooplayer = Ext.getCmp('gooplayer');
			gooplayer.queueTrack(track);
		});
	} else if (track[6]) {
		window.open(track[6]);
	}
};

og.playXSPF = function(id) {
	if (og.isFlashSupported()) {
		var gppanel = og.getGooPlayerPanel(function() {
			Ext.getCmp('tabs-panel').setActiveTab(gppanel);
			var gooplayer = Ext.getCmp('gooplayer');
			gooplayer.loadPlaylistFromFile(id, true);
		});
	} else {
		window.open(og.getUrl('files', 'download_file', {id: id}));
	}
};

 
og.xmlFetchTag = function(xml, tag) {
	var i1 = xml.indexOf("<" + tag + ">");
	var i2 = xml.indexOf("</" + tag + ">");
	if (i1 >= 0 && i2 > i1) {
		return {
			found: true,
			value: xml.substring(i1 + tag.length + 2, i2),
			rest: xml.substring(i2 + tag.length + 3)
		};
	} else {
		return {
			found: false,
			value: "",
			rest: xml
		};
	}
};

og.clean = function(text) {
	return Ext.util.Format.htmlEncode(text);
};

og.removeTags = function(text) {
	return Ext.util.Format.stripTags(text);
};

og.displayFileContents = function(genid, isFull){
	var text = document.getElementById(genid + 'file_contents').innerHTML;
	if (text.length > 1000 && !isFull){
		text = text.substring(0,900);
		text += '&hellip;&nbsp;&nbsp;<a href="#" onclick="og.displayFileContents(\'' + genid + '\',true)">[' + lang('show more') + '&hellip;]</a>';
	}
	document.getElementById(genid + 'file_display').innerHTML = text;
};

og.dashExpand = function(genid){
	var widget = Ext.get(genid + '_widget_body');
	if (widget){
		var setExpanded = widget.dom.style.display == 'none';
		
		if (setExpanded) widget.slideIn('t', {useDisplay:true, duration:.3});
		else widget.slideOut('t', {useDisplay:true, duration:.3});
		
		var expander = document.getElementById(genid + 'expander');
		expander.className = (setExpanded) ? "dash-expander ico-dash-expanded":"dash-expander ico-dash-collapsed";
	}
};

og.closeContextHelp = function(genid,option_name){
	var help = document.getElementById(genid + 'help');
	if (help){
		help.style.display = 'none';
		if(option_name != ''){
			var url = og.getUrl('account', 'update_user_preference', {name: 'show_' + option_name + '_context_help', value:0});
			og.openLink(url,{hideLoading:true});
		}
	}
};

og.billingEditValue = function(id){
	document.getElementById(id + 'bv').style.display = 'none';
	document.getElementById(id + 'bvedit').style.display = 'inline';
	document.getElementById(id + 'edclick').value = 1;
	document.getElementById(id + 'text').focus();
};

og.checkDownload = function(url, checkedOutById, checkedOutBy) {
	var checkOut = function() {
		og.ExtendedDialog.dialog.destroy();
		location.href = url + "&checkout=1";
	};
	var readOnly = function() {
		og.ExtendedDialog.dialog.destroy();
		location.href = url + "&checkout=0";
	}
	var checkedOutByName = checkedOutBy;
	if (checkedOutByName == 'self') {
		checkedOutByName = lang('you');
	}
	if (checkedOutById > 0) {
		var config = {
			title :lang('checkout notification'),
			y :50,
			id :'checkDownloadDialog',
			modal :true,
			height :150,
			width :300,
			resizable :false,
			closeAction :'hide',
			iconCls :'op-ico',
			border :false,
			buttons : [ {
				text :lang('download'),
				handler :readOnly,
				id :'download_button',
				scope :this
			} ],
			dialogItems : [ {
				xtype :'label',
				name :'checked_label',
				id :'checkedout',
				hideLabel :true,
				style: 'font-size:100%;',
				text :lang('document checked out by', checkedOutByName)
			} ]
		};
	} else {
		var config = {
			title :lang('checkout confirmation'),
			y :50,
			id :'checkDownloadDialog',
			modal :true,
			height :150,
			width :300,
			resizable :false,
			closeAction :'hide',
			iconCls :'op-ico',
			border :false,
			buttons : [ {
				text :lang('checkout and download'),
				handler :checkOut,
				id :'checkOut_button',
				scope :this
			}, {
				text :lang('download only'),
				handler :readOnly,
				id :'readOnly_button',
				scope :this
			} ],
			dialogItems : [{
				xtype :'label',
				name :'checked_label',
				id :'checkedout',
				hideLabel :true,
				style: 'font-size:100%;',
				text :lang('checkout recommendation')
			}]
		};
	}
	og.ExtendedDialog.show(config);
};

og.getScriptUrl = function(script) {
	return og.getHostName() + "/public/assets/javascript/" + script;
};

og.loadScripts = function(urls, config) {
	if (!config) config = {};
	if (typeof urls == "string") urls = [urls];
	
	// first load scripts
	var scriptsLeft = urls.length;
	var scripts = [];
	for (var i=0; i < urls.length; i++) {
		if (og.loadedScripts[urls[i]]) {
			scriptsLeft--;
		} else {
			og.loadedScripts[urls[i]] = true;
			if (!config.hideLoading) og.loading();
			Ext.Ajax.request({
				url: urls[i],
				callback: function(options, success, response) {
					scriptsLeft--;
					if (!config.hideLoading) og.hideLoading();
					if (success) {
						scripts[options.index] = response.responseText;
					}
				},
				index: i
			});
		}
	}
	var success = {};
	var count = 0;
	var postScript = function() {
		// wait for scripts to load
		if (scriptsLeft > 0) {
			setTimeout(postScript, 100);
			return;
		}
		
		// run scripts
		for (var i=0; i < scripts.length; i++) {
			if (scripts[i]) {
				try {
					if (window.execScript) {
						window.execScript(scripts[i]);
					} else {
						window.eval(scripts[i]);
					}
					success[urls[i]] = true;
					count++;
				} catch (e) {
					og.err(e.message);
				}
			}
		}
		if (typeof config.callback == 'function') {
			config.callback.call(config.scope, count, success);
		}
	};
	postScript();
};

og.loadedScripts = {};

og.ToggleTrap = function(trapid, fsid) {
	if (Ext.isIE) {
		if (!Ext.get(fsid).isDisplayed()) {
			Ext.get(fsid).setDisplayed('block');
		} else {
			Ext.get(fsid).setDisplayed('none');
		}
	}
};

og.FileIsZip = function(mimetype, name) {
	var ix = name.lastIndexOf('.');
	var extension = ix >= 0 ? name.substring(ix + 1) : "";
	return (mimetype == 'application/zip' || mimetype == 'application/x-zip-compressed' || 
			(mimetype == 'application/x-compressed' && extension == 'zip') || extension == 'zip');
};

og.disableEventPropagation = function(event) { 
	if (Ext.isIE) { 
		window.event.cancelBubble = true; 
	} else {
		event.stopPropagation();
	} 
};

og.showMoreActions = function(genid) {
	var obj = document.getElementById('otherActions' + genid);
	obj.style.display = 'block';
	var moreOp = document.getElementById('moreOption' + genid);
	moreOp.style.display = 'none';
};

og.loadEmailAccounts = function(type) {
	og.openLink(og.getUrl('mail', 'list_accounts', {type: type}),{
		callback: function(success, data) {
			if (success) {
				if (type == 'view') og.email_accounts_toview = data.accounts;
				else if (type == 'edit') og.email_accounts_toedit = data.accounts;
			}
		}
	});
};
//	SUBSCRIBERS LIST FUNCTIONS

og.rollOver = function(div)
{
	div.className += " rolling-over";
};
og.rollOut = function(div,isCompany)
{
	
	
	if (isCompany){
		isChecked=Ext.fly(div).hasClass("checked");
		div.className = "container-div company-name";
		if (isChecked){
			div.className += " checked";
		}
	}else{
		isChecked=Ext.fly(div).hasClass("checked-user");
		if (isChecked){
			div.className = "container-div checked-user";
		}else{
			div.className = "container-div user-name";
		}
	}
};
og.checkUser = function (div){
	var hiddy = document.getElementById(div.id.substring(3));
	if (hiddy) {
		if (hiddy.checked) {
			hiddy.checked = false;
			div.className = "container-div user-name";
		} else {
			hiddy.checked = true;
			div.className = "container-div checked-user";
		}
	}
};
og.subscribeCompany = function (div){
		var isChecked = Ext.fly(div).hasClass("checked");
		var hids = div.parentNode.getElementsByTagName("input");
		for (var i=0; i < hids.length; i++) {
			var hiddenTag = hids[i];
			if (!isChecked && !hiddenTag.checked || isChecked && hiddenTag.checked) {
				og.checkUser(hiddenTag.parentNode);
			}
		}
		
		if (!isChecked) {
			Ext.fly(div).addClass('checked');
		} else {
			Ext.fly(div).removeClass('checked');
		}
};

og.confirmRemoveTags = function(manager) {
	var man = Ext.getCmp(manager);
	
	var removeAction = function() {
		og.ExtendedDialog.dialog.destroy();
		man.removeTags();
	};
	
	var cancelAction = function() {
		og.ExtendedDialog.dialog.destroy();
	};
	
	var config = {
		title: lang('remove tags'),
		y :50,
		id :'removeTags',
		modal :true,
		height :125,
		width :300,
		resizable :false,
		closeAction :'hide',
		iconCls :'op-ico',
		border :false,
		buttons : [ {
			text :lang('yes'),
			handler :removeAction,
			id :'yes_button',
			scope :this
		}, {
			text :lang('no'),
			handler :cancelAction,
			id :'no_button',
			scope :this
		} ],
		dialogItems : [ {
			xtype :'label',
			name :'moveadd_label',
			id :'moveadd',
			hideLabel :true,
			style: 'font-size:100%;',
			text: lang('confirm remove tags')
		} ]
	};
	og.ExtendedDialog.show(config);
}

og.confirmMoveToAllWs = function(manager, text) {
	var man = Ext.getCmp(manager);
	
	var moveAction = function() {
		og.ExtendedDialog.dialog.destroy();
		man.moveObjectsToAllWs();
	};
	
	var cancelAction = function() {
		og.ExtendedDialog.dialog.destroy();
	};
	
	var config = {
		title: '',
		y :50,
		id :'moveToAllWs',
		modal :true,
		height :125,
		width :300,
		resizable :false,
		closeAction :'hide',
		iconCls :'op-ico',
		border :false,
		buttons : [ {
			text :lang('yes'),
			handler :moveAction,
			id :'yes_button',
			scope :this
		}, {
			text :lang('no'),
			handler :cancelAction,
			id :'no_button',
			scope :this
		} ],
		dialogItems : [ {
			xtype :'label',
			name :'moveadd_label',
			id :'moveadd',
			hideLabel :true,
			style: 'font-size:100%;',
			text: text
		} ]
	};
	og.ExtendedDialog.show(config);
}

og.moveToWsOrMantainWs = function(manager, ws) {
	var man = Ext.getCmp(manager);
	
	var moveAction = function() {
		if (og.ExtendedDialog.dialog) og.ExtendedDialog.dialog.destroy();
		man.moveObjectsToWsOrMantainWs(0, ws);
//		man.getSelectionModel().clearSelections();
	};
	var mantainAction = function() {
		if (og.ExtendedDialog.dialog) og.ExtendedDialog.dialog.destroy();
		man.moveObjectsToWsOrMantainWs(1, ws);
//		man.getSelectionModel().clearSelections();
	};
	
	if (og.preferences['drag_drop_prompt'] == 'move') {
		moveAction();
		return;
	} else if (og.preferences['drag_drop_prompt'] == 'keep') {
		mantainAction();
		return;
	}

	var config = {
		title :lang('move to workspace or keep old ones'),
		y :50,
		id :'moveToWsOrAddWs',
		modal :true,
		height :150,
		width :300,
		resizable :false,
		closeAction :'hide',
		iconCls :'op-ico',
		border :false,
		buttons : [ {
			text :lang('move to workspace'),
			handler :moveAction,
			id :'move_button',
			scope :this
		}, {
			text :lang('keep old workspaces'),
			handler :mantainAction,
			id :'add_button',
			scope :this
		} ],
		dialogItems : [ {
			xtype :'label',
			name :'moveadd_label',
			id :'moveadd',
			hideLabel :true,
			style: 'font-size:100%;',
			text :lang('do you want to move objects to this ws or keep old ones and add this ws')
		} ]
	};
	og.ExtendedDialog.show(config);
};

og.askToClassifyUnclassifiedAttachs = function(manager, mantain, ws) {
	var man = Ext.getCmp(manager);
	
	var classifyAction = function() {
		if (og.ExtendedDialog.dialog) og.ExtendedDialog.dialog.destroy();
		man.moveObjectsClassifyingEmails(mantain, ws, 1);
	};
	var leaveAction = function() {
		if (og.ExtendedDialog.dialog) og.ExtendedDialog.dialog.destroy();
		man.moveObjectsClassifyingEmails(mantain, ws, 0);
	};
	
	if (og.preferences['mail_drag_drop_prompt'] == 'classify') {
		classifyAction();
		return;
	} else if (og.preferences['mail_drag_drop_prompt'] == 'dont') {
		leaveAction();
		return;
	}

	var config = {
		title :lang('classify mail attachments'),
		y :50,
		id :'classifyAttachs',
		modal :true,
		height :150,
		width :300,
		resizable :false,
		closeAction :'hide',
		iconCls :'op-ico',
		border :false,
		buttons : [ {
			text :lang('yes'),
			handler :classifyAction,
			id :'yes_button',
			scope :this
		}, {
			text :lang('no'),
			handler :leaveAction,
			id :'no_button',
			scope :this
		} ],
		dialogItems : [ {
			xtype :'label',
			name :'classify_label',
			id :'classify_leave',
			hideLabel :true,
			style: 'font-size:100%;',
			text :lang('do you want to classify the unclassified emails attachments')
		} ]
	};
	og.ExtendedDialog.show(config);
};


og.replaceAllOccurrences = function(str, search, replace) {
	while (str.indexOf(search) != -1) {
		str = str.replace(search, replace);
	}
	return str;
};

og.isFlashSupported = function() {
	return navigator.mimeTypes["application/x-shockwave-flash"] ? true : false;
};

og.showHide = function(itemId, mode) {
	if (!mode || (mode != 'block' && mode != 'inline')) mode = 'block';
	var el = document.getElementById(itemId);
	if (el) {
		if (el.style.display == 'none') el.style.display = mode;
		else el.style.display = 'none';
	}
};

og.calculate_time_zone = function(server) {
	var client = new Date();
	var diff = client.getTime() - server.getTime();
	diff = Math.round(diff*2/3600000);
	return diff / 2;
};

og.redrawLinkedObjects = function(id) {
	var div = Ext.get("linked_objects_in_prop_panel");
	if (div) {
		div.load({url: og.getUrl('object', 'redraw_linked_object_list', {id:id}), scripts: true});
	}
}

og.redrawSubscribers = function(id, genid) {
	var div = Ext.get(genid + "subscribers_in_prop_panel");
	if (div) {
		div.load({url: og.getUrl('object', 'redraw_subscribers_list', {id:id}), scripts: true});
	}
}

og.show_hide_subscribers_list = function(id, genid) {
	og.openLink(og.getUrl('object', 'add_subscribers_list', {obj_id: id, genid: genid}), {
		preventPanelLoad:true,
		onSuccess: function(data) {

			og.ExtendedDialog.show({
        		html: data.current.data,
        		height: 450,
        		width: 685,
        		ok_fn: function() {
        			formy = document.getElementById(genid + "add-User-Form");
        			var params = Ext.Ajax.serializeForm(formy);
        			var options = {callback: function(data, success){
            			og.redrawSubscribers(id, genid);
        			}}
    				options[formy.method.toLowerCase()] = params;
    				og.openLink(formy.getAttribute('action'), options);
    				og.ExtendedDialog.hide();        			
    			}        			
        	});
        	return;
		}
	});
};

/*
 * Adds the listener to manage concurrency while editing objects.
 * it shows a yes or no dialog, if the answer is yes re-send the form data
 * and set "merge-changes" attribute to true so that the object list view is shown.
 *  If no is choosen it sent the form and overwrite the submited data. 
 */
og.eventManager.addListener('handle edit concurrence', 
	function (data) {
		var genid = data['genid'];
		var elem = document.getElementById( genid + 'merge-changes-hidden');
		elem.value = '';
		var hidden = document.getElementById(genid + "updated-on-hidden");
 		if (hidden) {
 			hidden.value = data['updatedon'];
 		}
		var dialog = '<div style="padding:10px;">';
		dialog += '<h1>' + lang('allready updated object') + '</h1><br />';
		dialog += '<div>' + lang('allready updated object desc') + '</div></div>';
		og.ExtendedDialog.show({
    		html: dialog,
    		height: 250,
    		width: 350,
    		YESNO: true,
    		ok_fn: function() {
    			og.ExtendedDialog.hide();
    			elem.value = 'true';
    			var form = document.getElementById(genid + "submit-edit-form");
    			form.onsubmit();
    			elem.value = '';
			}
    	});
	}
);

og.getCkEditorInstance = function(name) {
	var editor = null;
	for (instName in CKEDITOR.instances) {
		if (instName == name) {
			editor = CKEDITOR.instances[instName];
			break;
		}
	}
	return editor;
};

og.adjustCkEditorArea = function(genid) {
	document.getElementById('cke_' + genid + 'ckeditor').style.padding = '0px';
	document.getElementById('cke_contents_' + genid + 'ckeditor').style.padding = '0px';
	document.getElementById('cke_contents_' + genid + 'ckeditor').style.border = '0px none';
	document.getElementById('cke_bottom_' + genid + 'ckeditor').style.display = 'none';
};

og.hideFlashObjects = function() {
	var flash = document.getElementsByTagName('embed');
	for (var i=0; i < flash.length; i++) {
		flash[i].style.visibility = 'hidden';
		flash[i].hiddenFlashObject = true;
	}
};

og.restoreFlashObjects = function() {
	var flash = document.getElementsByTagName('embed');
	for (var i=0; i < flash.length; i++) {
		if (flash[i].hiddenFlashObject) flash[i].style.visibility = 'visible';
		flash[i].hiddenFlashObject = false;
	}
};

og.promptDeleteAccount = function(account_id, reload) {
	var check_id = Ext.id();
	var config = {
		genid: Ext.id(),
		title: lang('confirm delete mail account'),
		height: 150,
		width: 250,
		labelWidth: 150,
		ok_fn: function() {
			var checked = Ext.getCmp(check_id).getValue();
			og.openLink(og.getUrl('mail', 'delete_account', {
				id: account_id,
				deleteMails: checked ? 1 : 0,
				reload: reload ? 1 : 0
			}));
			og.ExtendedDialog.hide();
		},
		dialogItems: {
			xtype: 'checkbox',
			fieldLabel: lang('delete account emails'),
			id: check_id,
			value: false
		}
	};
	og.ExtendedDialog.show(config);
};

og.htmlToText = function(html) {
	// remove line breaks
	html = html.replace(/[\n\r]\s*/g, "");
	// change several white spaces for one
	html = html.replace(/[ \t][ \t]+|&nbsp;/g, " ");
	// insert line breaks were they belong
	html = html.replace(/(<\/table>|<\/tr>|<\/div>|<br *\/?>|<\/p>)/g, "$1\n");
	// insert tabs on tables
	html = html.replace(/(<\/td>)/g, "$1\t");
	// strip tags
	html = html.replace(/<[^>]*>/g, "");

	return html;
};

og.updateUnreadEmail = function(unread) {
	if (og.preferences['show_unread_on_title']) {
		var title = document.title;
		if (title.charAt(0) == '(' && title.indexOf(')') > 0) {
			title = title.substring(title.indexOf(')') + 2);
		}
		if (unread > 0) {
			document.title = "(" + unread  + ") " + title;
		} else {
			document.title = title;
		}
	}
	var panel = Ext.getCmp('mails-panel');
	if (panel) {
		if (unread > 0) {
			panel.setTitle(lang('email tab') + " (" + unread  + ")");
		} else {
			panel.setTitle(lang('email tab'));
		}
	} else {
		var tab = Ext.select("#tabs-panel__mails-panel span.x-tab-strip-text");
		tab.each(function() {
			if (unread > 0) {
				this.innerHTML = lang('email tab') + " (" + unread + ")";
			} else {
				this.innerHTML = lang('email tab');
			}
		});
	}
};

og.onChangeObjectCoType = function(genid, manager, id, new_cotype) {
	og.openLink(og.getUrl('object', 're_render_custom_properties', {id:id, manager:manager, req:1, co_type:new_cotype}), 
		{callback: function(success, data) {
			if (success) {
				var div = Ext.get(genid + 'required_custom_properties');
				if (div) div.remove();
				var container = Ext.get(genid + 'required_custom_properties_container');
				if (container) {
					container.insertHtml('beforeEnd', '<div id="'+genid+'required_custom_properties">'+data.html+'</div>');
					eval(data.scripts);
				}
			}
		}}
	);
	og.openLink(og.getUrl('object', 're_render_custom_properties', {id:id, manager:manager, req:0, co_type:new_cotype}), 
		{callback: function(success, data) {
			if (success) {
				var div = Ext.get(genid + 'not_required_custom_properties');
				if (div) div.remove();
				var container = Ext.get(genid + 'not_required_custom_properties_container');
				if (container) {
					container.insertHtml('beforeEnd', '<div id="'+genid+'not_required_custom_properties">'+data.html+'</div>');
					eval(data.scripts);
				}
			}
		}}
	);
};

og.expandDocumentView = function() {
	if (this.oldParent) {
		//this.parentNode.parentNode.removeChild(this.parentNode);
		//this.oldParent.appendChild(this.parentNode);
		var parentBody = og.getParentContentPanelBody(this);
		parentBody.style.overflow = 'auto';
		this.parentNode.style.position = 'relative';
		this.parentNode.style.height = this.parentNode.oldHeight + 'px';
		this.parentNode.style.zIndex = '0';
		this.title = lang('expand');
		this.className = 'ico-expand';
		this.oldParent = false;
	} else {
		this.oldParent = this.parentNode.parentNode;
		//this.oldParent.removeChild(this.parentNode);
		//document.body.appendChild(this.parentNode);
		var parentBody = og.getParentContentPanelBody(this);
		parentBody.style.overflow = 'hidden';
		this.parentNode.style.position = 'absolute';
		this.parentNode.oldHeight = this.parentNode.offsetHeight;
		this.parentNode.style.height = '100%';
		this.parentNode.style.zIndex = '1000';
		this.title = lang('collapse');
		this.className = 'ico-collapse';
	}
};

og.getHostName = function() {
	og.hostName = og.hostName.replace(/\/+$/, "");
	return og.hostName;
};

og.handleMemberChooserSubmit = function(genid, objectType, preHfId) {
	if (!preHfId) preHfId = "";
	var panels = Ext.getCmp(genid + "-member-chooser-panel-" + objectType);
	if (panels) {
		var memberChoosers = panels.items ;
		var members = [] ;
		if ( memberChoosers ) {
			memberChoosers.each(function(item, index, length) {
				var checked = item.getChecked("id") ;
				for (var j = 0 ; j < checked.length ; j++ ) {
					members.push(checked[j]) ;
				}
			}) ;
		}
		document.getElementById(genid + preHfId + "members").value = Ext.util.JSON.encode(members) ;
	}
	return true;
}

og.getSandboxName = function() {
	og.sandboxName = og.sandboxName ? og.sandboxName.replace(/\/+$/, "") : og.getHostName();
	return og.sandboxName;
};

og.formatPopupMemberChooserSelectedValues = function(genid, selected) {
	var html = '';
	var title = '';
	var memberChoosers = Ext.getCmp("menu-panel").items;
	for (i=0; i<selected.length; i++) {
		if ( memberChoosers ) {
			memberChoosers.each(function(item, index, length) {
				var node = item.getNodeById(selected[i]);
				if (node) {
					title += node.text;
					if (i < selected.length - 1) title += ',';
					title += ' ';
				}
			});
		}
	}
	html = title.length > 40 ? title.substring(0, 37) + "..." : title;
	var ico = Ext.get(genid + 'popup_ms_icon');
	if (ico) {
		ico.dom.className = 'ico-edit';
		ico.dom.innerHTML = lang('edit');
	}
	
	return {html:html, title:title};
}

og.popupMemberChooserHtml = function(genid, obj_type, hf_members_id, selected, no_label) {
	var ico_cls = 'db-ico ico-add';
	var action = lang('add');
	var to_show = {html:'<span class="desc">' + lang('none selected') + '</span>', title:''};
	if (selected) {
		to_show = og.formatPopupMemberChooserSelectedValues(genid, selected);
		ico_cls = 'db-ico ico-edit';
		action = lang('edit');
	}
	var onclick_ev = 'og.showPopupMemberChooser(\''+genid+'\', \''+obj_type+'\', \''+hf_members_id+'\', \''+selected+'\');';
	var html = '';
	if (!no_label)
		html += '<div style="padding-top:5px;"><label style="font-size:100%;display:inline;margin-right:30px;">'+lang('context')+':&nbsp;</label>';
	html += '<span id="'+genid+'popup_member_selector" onclick="'+ onclick_ev +'" style="cursor:pointer;" title="' + to_show.title + '">' + to_show.html + '</span>';
	html += '<span id="'+genid+'popup_ms_icon" class="'+ico_cls+'" onclick="'+ onclick_ev +'" style="cursor:pointer; padding:5px 0 0 20px; margin-left:5px;">' + action + '</span>'
	html += '</div>';
	return html;
};

og.showPopupMemberChooser = function(genid, obj_type, hf_members_id, selected) {
	og.openLink(og.getUrl('object', 'popup_member_chooser', {obj_type: obj_type, genid: genid, selected: selected}), {
		preventPanelLoad:true,
		onSuccess: function(data) {
			var dialog = og.ExtendedDialog.show({
				html: data.current.data,
				title: lang('select context members'),
				iconCls: 'ico-workspace',
				resizable: true,
				minHeight: 273,
				minWidth: 480,
				height: 273,
				width: 480,
				ok_fn: function() {
					og.handleMemberChooserSubmit(genid, obj_type);	
					var sel_members = Ext.get(genid + "members").getValue();
					var hf = Ext.get(genid + hf_members_id);
					hf.dom.value = sel_members;
					
					og.ExtendedDialog.hide();
					if (sel_members != '') {
						var to_show = og.formatPopupMemberChooserSelectedValues(genid, Ext.util.JSON.decode(sel_members));
						var sel = Ext.get(genid + 'popup_member_selector');
						sel.dom.innerHTML = to_show.html;
						sel.dom.title = to_show.title;
					}
				}        			
			});

			return;
		}
	});
}

og.drawComboBox = function(config) {
	if (!config) config = {};
	if (!config.render_to) config.render_to = '';
	if (!config.id) config.id = Ext.id();
	if (!config.name) config.name = Ext.id();
	if (!config.selected) config.selected = 0;
	if (!config.store) config.store = [];
	if (!config.empty_text) config.empty_text = '';
	if (!config.tab_index) config.tab_index = '500';
	if (!config.width) config.width = 200;
	
	var combo = new Ext.form.ComboBox({
		renderTo: config.render_to,
		name: config.name,
		id: config.id,
		value: config.selected,
		store: new Ext.data.SimpleStore({
	        fields: ['value', 'text'],
	        data : config.store
	    }),
	    emptyText: config.empty_text,
	    width: config.width,
        listWidth: config.width,
        tabIndex: config.tab_index,
        displayField: 'text',
        typeAhead: true,
        mode: 'local',
        triggerAction: 'all',
        selectOnFocus: true,
        valueField: 'value',
        valueNotFoundText: '',
        disabled: config.disabled == true,
        hidden: config.hidden == true
	});
	
	combo.setWidth(config.width);
	return combo;
}


og.drawDateMenuPicker = function(config) {
	var datemenu = new Ext.menu.DateMenu({
	    id: config.id ? config.id : Ext.id(),
	    format: og.preferences['date_format'],
	    startDay: og.preferences['start_monday'],
		altFormats: lang('date format alternatives'),
		listeners: config.listeners,
		items: config.items
	});
	
	Ext.apply(datemenu.picker, { 
		okText: lang('ok'),
		cancelText: lang('cancel'),
		monthNames: [lang('month 1'), lang('month 2'), lang('month 3'), lang('month 4'), lang('month 5'), lang('month 6'), lang('month 7'), lang('month 8'), lang('month 9'), lang('month 10'), lang('month 11'), lang('month 12')],
		dayNames:[lang('sunday'), lang('monday'), lang('tuesday'), lang('wednesday'), lang('thursday'), lang('friday'), lang('saturday')],
		monthYearText: '',
		nextText: lang('next month'),
		prevText: lang('prev month'),
		todayText: lang('today'),
		todayTip: lang('today')
	});
	
	return datemenu;
}

og.quickForm = function (config) {
	if (!config) return false ;
	switch (config.type) {
		case "member":
			var d = config.dimensionId ;
			var tree = Ext.getCmp("dimension-panel-"+d);
			if (tree) {
				var selected = tree.getSelectionModel().getSelectedNode();
				if ( selected.getDepth() == 0  ) {
					var parent = 0 ; 
				}else{
					var parent = selected.id ;
				}
				
				var e = $("#"+config.elId) ;
				if (d) {
					$("#quick-form .form-container").html('').load(og.getUrl('member', 'quick_add_form',{dimension_id: config.dimensionId, parent_member_id: parent}),function(){
						$(this).parent().css(e.offset()).slideDown();
						$("#member-name").focus();
						return true ;
					});
					return false;
				}
			}
			break;
		default: 
			break
	}
	return false ;
}
og.InfinitePagingToolbar = Ext.extend(Ext.Toolbar, {

	pageSize: 20,
    
    emptyMsg : 'No data to display',

    beforePageText : "Page",

    firstText : "First Page",

    prevText : "Previous Page",

    nextText : "Next Page",

    refreshText : "Refresh",
    
    maxPages : 1000000,

    paramNames : {start: 'start', limit: 'limit'},

    initComponent : function(){
        this.addEvents('change', 'beforechange');
        og.InfinitePagingToolbar.superclass.initComponent.call(this);
        this.cursor = 0;
        this.bind(this.store);
    },

    // private
    onRender : function(ct, position){
    	og.InfinitePagingToolbar.superclass.onRender.call(this, ct, position);
        this.first = this.addButton({
            tooltip: this.firstText,
            iconCls: "x-tbar-page-first",
            disabled: true,
            handler: this.onClick.createDelegate(this, ["first"])
        });
        this.prev = this.addButton({
            tooltip: this.prevText,
            iconCls: "x-tbar-page-prev",
            disabled: true,
            handler: this.onClick.createDelegate(this, ["prev"])
        });
        this.addSeparator();
        this.add(this.beforePageText);
        this.field = Ext.get(this.addDom({
           tag: "input",
           type: "text",
           size: "3",
           value: "1",
           cls: "x-tbar-page-number"
        }).el);
        this.field.on("keydown", this.onPagingKeydown, this);
        this.field.on("focus", function(){this.dom.select();});
        this.field.setHeight(18);
        this.addSeparator();
        this.next = this.addButton({
            tooltip: this.nextText,
            iconCls: "x-tbar-page-next",
            disabled: true,
            handler: this.onClick.createDelegate(this, ["next"])
        });
        this.addSeparator();
        this.loading = this.addButton({
            tooltip: this.refreshText,
            iconCls: "x-tbar-loading",
            handler: this.onClick.createDelegate(this, ["refresh"])
        });

        if(this.displayInfo){
            this.displayEl = Ext.fly(this.el.dom).createChild({cls:'x-paging-info'});
        }
        if(this.dsLoaded){
            this.onLoad.apply(this, this.dsLoaded);
        }
    },

    // private
    updateInfo : function(){
        if(this.displayEl){
            var count = this.store.getCount();
            var msg = count == 0 ?
                this.emptyMsg : "";
            this.displayEl.update(msg);
        }
    },

    // private
    onLoad : function(store, r, o){
        if(!this.rendered){
            this.dsLoaded = [store, r, o];
            return;
        }
       this.cursor = o.params ? o.params[this.paramNames.start] : 0;
       var d = this.getPageData(), ap = d.activePage, ps = d.pages;
        this.field.dom.value = ap;
        this.first.setDisabled(ap == 1);
        this.prev.setDisabled(ap == 1);
        this.next.setDisabled(ap == ps);
        this.loading.enable();
        this.updateInfo();
        this.fireEvent('change', this, d);
    },

    // private
    getPageData : function(){
        var total = this.maxPages;
        var	ap	=	Math.ceil((this.cursor+this.pageSize)/this.pageSize);
		if (this.store.reader.jsonData) {
			var start = parseInt(this.store.reader.jsonData.start);
			// go to the specified page
			ap	=	Math.ceil((start + this.pageSize)/this.pageSize);
			// also set the cursor so that 'prev' and 'next' buttons behave correctly
			this.cursor	= start;
		}
        return {
            total : total,
            activePage : ap,
            pages :  total < this.pageSize ? 1 : Math.ceil(total/this.pageSize)
        };
    },

    // private
    onLoadError : function(){
        if(!this.rendered){
            return;
        }
        this.loading.enable();
    },

    readPage : function(d){
        var v = this.field.dom.value, pageNum;
        if (!v || isNaN(pageNum = parseInt(v, 10))) {
            this.field.dom.value = d.activePage;
            return false;
        }
        return pageNum;
    },

    // private
    onPagingKeydown : function(e){
        var k = e.getKey(), d = this.getPageData(), pageNum;
        if (k == e.RETURN) {
            e.stopEvent();
            pageNum = this.readPage(d);
            if(pageNum !== false){
                pageNum = Math.min(Math.max(1, pageNum), d.pages) - 1;
                this.doLoad(pageNum * this.pageSize);
            }
        }else if (k == e.HOME || k == e.END){
            e.stopEvent();
            pageNum = k == e.HOME ? 1 : d.pages;
            this.field.dom.value = pageNum;
        }else if (k == e.UP || k == e.PAGEUP || k == e.DOWN || k == e.PAGEDOWN){
            e.stopEvent();
            if(pageNum = this.readPage(d)){
                var increment = e.shiftKey ? 10 : 1;
                if(k == e.DOWN || k == e.PAGEDOWN){
                    increment *= -1;
                }
                pageNum += increment;
                if(pageNum >= 1 & pageNum <= d.pages){
                    this.field.dom.value = pageNum;
                }
            }
        }
    },

    // private
    beforeLoad : function(){
        if(this.rendered && this.loading){
            this.loading.disable();
        }
    },

    doLoad : function(start){
        var o = {}, pn = this.paramNames;
        o[pn.start] = start;
        o[pn.limit] = this.pageSize;
        if(this.fireEvent('beforechange', this, o) !== false){
            this.store.load({params:o});
        }
    },

    /**
     * Change the active page
     * @param {Integer} page The page to display 
     */
    changePage: function(page){
        this.doLoad(((page-1) * this.pageSize).constrain(0, this.maxPages));  
    },

    // private
    onClick : function(which){
        var store = this.store;
        switch(which){
            case "first":
                this.doLoad(0);
            break;
            case "prev":
                this.doLoad(Math.max(0, this.cursor-this.pageSize));
            break;
            case "next":
                this.doLoad(this.cursor+this.pageSize);
            break;
            case "refresh":
                this.doLoad(this.cursor);
            break;
        }
    },

    /**
     * Unbinds the paging toolbar from the specified {@link Ext.data.Store}
     * @param {Ext.data.Store} store The data store to unbind
     */
    unbind : function(store){
        store = Ext.StoreMgr.lookup(store);
        store.un("beforeload", this.beforeLoad, this);
        store.un("load", this.onLoad, this);
        store.un("loadexception", this.onLoadError, this);
        this.store = undefined;
    },

    /**
     * Binds the paging toolbar to the specified {@link Ext.data.Store}
     * @param {Ext.data.Store} store The data store to bind
     */
    bind : function(store){
        store = Ext.StoreMgr.lookup(store);
        store.on("beforeload", this.beforeLoad, this);
        store.on("load", this.onLoad, this);
        store.on("loadexception", this.onLoadError, this);
        this.store = store;
    }
});

/**
 * Ext.ux.HttpProvider extension
 *
 * @author    Ing. Jozef Sakalos
 * @copyright (c) 2008, Ing. Jozef Sakalos
 *
 * @license Ext.ux.HttpProvider is licensed under the terms of
 * the Open Source LGPL 3.0 license.  Commercial use is permitted to the extent
 * that the code/component(s) do NOT become part of another Open Source or Commercially
 * licensed development library or toolkit without explicit permission.
 * 
 * License details: http://www.gnu.org/licenses/lgpl.html
 */

/**
 * @class og.HttpProvider
 * @extends Ext.state.Provider
 * @constructor
 * @param {Object} config Configuration object
 */
// {{{
og.HttpProvider = function(config) {

    this.addEvents(
        /**
         * @event readsuccess
         * Fires after state has been successfully received from server and restored
         * @param {HttpProvider} this
         */
         'readsuccess'
        /**
         * @event readfailure
         * Fires in the case of an error when attempting to read state from server
         * @param {HttpProvider} this
         */
        ,'readfailure'
        /**
         * @event savesuccess
         * Fires after the state has been successfully saved to server
         * @param {HttpProvider} this
         */
        ,'savesuccess'
        /**
         * @event savefailure
         * Fires in the case of an error when attempting to save state to the server
         * @param {HttpProvider} this
         */
        ,'savefailure'
    );

    // call parent 
    og.HttpProvider.superclass.constructor.call(this);

    Ext.apply(this, config, {
        // defaults
         delay:750 // buffer changes for 750 ms
        ,dirty:false
        ,started:false
        ,autoStart:true
        ,autoRead:true
        ,user:'user'
        ,id:1
        ,session:'session'
        ,logFailure:false
        ,logSuccess:false
        ,queue:[]
        ,url:'.'
        ,readUrl:undefined
        ,saveUrl:undefined
        ,method:'post'
        ,saveBaseParams:{}
        ,readBaseParams:{}
        ,paramNames:{
             id:'id'
            ,name:'name'
            ,value:'value'
            ,user:'user'
            ,session:'session'
            ,data:'data'
        }
    }); // eo apply

    if(this.autoRead) {
        this.readState();
    }

    this.dt = new Ext.util.DelayedTask(this.submitState, this);
    if(this.autoStart) {
        this.start();
    }
}; // eo constructor
// }}}

Ext.extend(og.HttpProvider, Ext.state.Provider, {

    // localizable texts
     saveSuccessText:'Save Success'
    ,saveFailureText:'Save Failure'
    ,readSuccessText:'Read Success'
    ,readFailureText:'Read Failure'
    ,dataErrorText:'Data Error'

    // {{{
    /**
     * Initializes state from the passed state object or array.
     * This method can be called early during page load having the state Array/Object
     * retrieved from database by server.
     * @param {Array/Object} state State to initialize state manager with
     */
    ,initState:function(state) {
        if(state instanceof Array) {
            Ext.each(state, function(item) {
                this.state[item.name] = this.decodeValue(item.value);
            }, this);
        }
        else {
            this.state = state ? state : {};
        }
    } // eo function initState
    // }}}
    // {{{
    /**
     * Sets the passed state variable name to the passed value and queues the change
     * @param {String} name Name of the state variable
     * @param {Mixed} value Value of the state variable
     */
    ,set:function(name, value) {
        if(!name) {
            return;
        }

        this.queueChange(name, value);

    } // eo function set
    // }}}
    // {{{
    /**
     * Starts submitting state changes to server
     */
    ,start:function() {
        this.dt.delay(this.delay);
        this.started = true;
    } // eo function start
    // }}}
    // {{{
    /**
     * Stops submitting state changes
     */
    ,stop:function() {
        this.dt.cancel();
        this.started = false;
    } // eo function stop
    // }}}
    // {{{
    /**
     * private, queues the state change if state has changed
     */
    ,queueChange:function(name, value) {
        var changed = undefined === this.state[name] || this.state[name] !== value;
        var o = {};
        var i;
        var found = false;
        if(changed) {
            o[this.paramNames.name] = name;
            o[this.paramNames.value] = this.encodeValue(value);
            for(i = 0; i < this.queue.length; i++) {
                if(this.queue[i].name === o.name) {
                    this.queue[i] = o;
                    found = true;
                }
            }
            if(false === found) {
                this.queue.push(o);
            }
            this.dirty = true;
        }
        return changed;
    } // eo function bufferChange
    // }}}
    // {{{
    /**
     * private, submits state to server by asynchronous Ajax request
     */
    ,submitState:function() {
        if(!this.dirty) {
            this.dt.delay(this.delay);
            return;
        }
        this.dt.cancel();

        var o = {
             url:this.saveUrl || this.url
            ,method:this.method
            ,scope:this
            ,success:this.onSaveSuccess
            ,failure:this.onSaveFailure
            ,queue:og.clone(this.queue)
            ,params:{}
        };

        var params = Ext.apply({}, this.saveBaseParams);
        params[this.paramNames.id] = this.id;
        params[this.paramNames.user] = this.user;
        params[this.paramNames.session] = this.session;
        params[this.paramNames.data] = Ext.encode(o.queue);

        Ext.apply(o.params, params);

        // be optimistic
        this.dirty = false;

        Ext.Ajax.request(o);
    } // eo function submitState
    // }}}
    // {{{
    /**
     * Clears the state variable
     * @param {String} name Name of the variable to clear
     */
    ,clear:function(name) {
        this.set(name, undefined);
    } // eo function clear
    // }}}
    // {{{
    /**
     * private, save success callback
     */
    ,onSaveSuccess:function(response, options) {
        if(this.started) {
            this.start();
        }
        var o = {};
        try {o = Ext.decode(response.responseText);}
        catch(e) {
            if(true === this.logFailure) {
                this.log(this.saveFailureText, e, response);
            }
            this.dirty = true;
            return;
        }
        if(true !== o.success) {
            if(true === this.logFailure) {
                this.log(this.saveFailureText, o, response);
            }
            this.dirty = true;
        }
        else {
            Ext.each(options.queue, function(item) {
                var name = item[this.paramNames.name];
                var value = this.decodeValue(item[this.paramNames.value]);

                if(undefined === value || null === value) {
                    og.HttpProvider.superclass.clear.call(this, name);
                }
                else {
                    // parent sets value and fires event
                    og.HttpProvider.superclass.set.call(this, name, value);
                }
            }, this);
            if(false === this.dirty) {
                this.queue = [];
            }
            else {
                var i, j, found;
                for(i = 0; i < options.queue.length; i++) {
                    found = false;
                    for(j = 0; j < this.queue.length; j++) {
                        if(options.queue[i].name === this.queue[j].name) {
                            found = true;
                            break;
                        }
                    }
                    if(true === found && this.encodeValue(options.queue[i].value) === this.encodeValue(this.queue[j].value)) {
                        delete(this.queue[j]);
                    }
                }
            }
            if(true === this.logSuccess) {
                this.log(this.saveSuccessText, o, response);
            }
            this.fireEvent('savesuccess', this);
        }
    } // eo function onSaveSuccess
    // }}}
    // {{{
    /**
     * private, save failure callback
     */
    ,onSaveFailure:function(response, options) {
        if(true === this.logFailure) {
            this.log(this.saveFailureText, response);
        }
        if(this.started) {
            this.start();
        }
        this.dirty = true;
        this.fireEvent('savefailure', this);
    } // eo function onSaveFailure
    // }}}
    // {{{
    /**
     * private, read state callback
     */
    ,onReadFailure:function(response, options) {
        if(true === this.logFailure) {
            this.log(this.readFailureText, response);
        }
        this.fireEvent('readfailure', this);

    } // eo function onReadFailure
    // }}}
    // {{{
    /**
     * private, read success callback
     */
    ,onReadSuccess:function(response, options) {
        var o = {}, data;
        try {o = Ext.decode(response.responseText);}
        catch(e) {
            if(true === this.logFailure) {
                this.log(this.readFailureText, e, response);
            }
            return;
        }
        if(true !== o.success) {
            if(true === this.logFailure) {
                this.log(this.readFailureText, o, response);
            }
        }
        else {
            try {data = Ext.decode(o[this.paramNames.data]);}
            catch(ex) {
                if(true === this.logFailure) {
                    this.log(this.dataErrorText, o, response);
                }
                return;
            }
            if(!(data instanceof Array) && true === this.logFailure) {
                this.log(this.dataErrorText, data, response);
                return;
            }
            Ext.each(data, function(item) {
                this.state[item[this.paramNames.name]] = this.decodeValue(item[this.paramNames.value]);
            }, this);
            this.queue = [];
            this.dirty = false;
            if(true === this.logSuccess) {
                this.log(this.readSuccessText, data, response);
            }
            this.fireEvent('readsuccess', this);
        }
    } // eo function onReadSuccess
    // }}}
    // {{{
    /**
     * Reads saved state from server by sending asynchronous Ajax request and processing the response
     */
    ,readState:function() {
        var o = {
             url:this.readUrl || this.url
            ,method:this.method
            ,scope:this
            ,success:this.onReadSuccess
            ,failure:this.onReadFailure
            ,params:{}
        };

        var params = Ext.apply({}, this.readBaseParams);
        params[this.paramNames.id] = this.id;
        params[this.paramNames.user] = this.user;
        params[this.paramNames.session] = this.session;

        Ext.apply(o.params, params);
        Ext.Ajax.request(o);
    } // eo function readState
    // }}}
    // {{{
    /**
     * private, logs errors or successes
     */
    ,log:function() {
        if(console) {
            console.log.apply(console, arguments);
        }
    } // eo log
    // }}}

});
og.GooProxy = function(config) {
    og.GooProxy.superclass.constructor.call(this);

    Ext.apply(this, config);
};

Ext.extend(og.GooProxy, Ext.data.DataProxy, {
    load : function(params, reader, callback, scope, arg) {
        if (this.fireEvent("beforeload", this, params) !== false) {
        	og.openLink(this.url, {
        		get: params,
        		callback: this.loadResponse,
        		scope: this,
        		request: {
        			callback: callback,
        			scope: scope,
        			arg: arg
        		},
        		reader: reader,
        		timeout: this.timeout
        	});
        } else {
            callback.call(scope||this, null, arg, false);
        }
    },

    // private
    loadResponse : function(success, data, options) {
        if(!success){
            this.fireEvent("loadexception", this, options, data);
            options.request.callback.call(options.request.scope, null, options.request.arg, false);
            return;
        }
        var result;
        try {
            result = options.reader.readRecords(data);
        }catch(e){
            this.fireEvent("loadexception", this, options, data, e);
            options.request.callback.call(options.request.scope, null, options.request.arg, false);
            return;
        }
        this.fireEvent("load", this, result, options.request.arg);
        options.request.callback.call(options.request.scope, result, options.request.arg, true);
    },
    
    // private
    update : function(dataSet){
        
    },
    
    // private
    updateResponse : function(dataSet){
        
    }
});
/**
 *  QuickAdd
 *
 */
og.QuickAdd = function(config) {
	
	og.QuickAdd.superclass.constructor.call(this, Ext.applyIf(config || {}, {
		text: lang('new'),
        tooltip: lang('create an object'),
        iconCls: 'ico-quick-add',
		menu: {
			items: [
				{id: 'quick-contact', text: lang('person'), iconCls: 'ico-contact', handler: function() {
					var url = og.getUrl('contact', 'add');
					og.openLink(url/*, {caller: 'contacts-panel'}*/);
				}, hidden: !og.config['enable_contacts_module']},
				{id: 'quick-company', text: lang('company'), iconCls: 'ico-company', handler: function() {
					var url = og.getUrl('contact', 'add_company');
					og.openLink(url/*, {caller: 'contacts-panel'}*/);
				}, hidden: !og.config['enable_contacts_module']},
				{id: 'quick-event', text: lang('event'), iconCls: 'ico-event', handler: function() {
					var url = og.getUrl('event', 'add');
					og.openLink(url/*, {caller: 'calendar-panel'}*/);
				}, hidden: !og.config['enable_calendar_module']},
				{id: 'quick-task', text: lang('task'), iconCls: 'ico-task', handler: function() {
					var url = og.getUrl('task', 'add_task');
					og.openLink(url/*, {caller: 'tasks-panel'}*/);
				}, hidden: !og.config['enable_tasks_module']},
				{id: 'quick-milestone', text: lang('milestone'), iconCls: 'ico-milestone', handler: function() {
					var url = og.getUrl('milestone', 'add');
					og.openLink(url/*, {caller: 'tasks-panel'}*/);
				}, hidden: !og.config['enable_tasks_module']},
				{id: 'quick-weblink', text: lang('webpage'), iconCls: 'ico-webpage', handler: function() {
					var url = og.getUrl('webpage', 'add');
					og.openLink(url/*, {caller: 'webpages-panel'}*/);
				}, hidden: !og.config['enable_weblinks_module']},
				{id: 'quick-note', text: lang('message'), iconCls: 'ico-message', handler: function() {
					var url = og.getUrl('message', 'add');
					og.openLink(url/*, {caller: 'messages-panel'}*/);
				}, hidden: !og.config['enable_notes_module']},
//				{id: 'quick-document', text: lang('document'), iconCls: 'ico-doc', handler: function() {
//					var url = og.getUrl('files', 'add_document');
//					og.openLink(url/*, {caller: 'documents-panel'}*/);
//				}, hidden: !og.config['enable_documents_module']},
	//			{id: 'quick-spreadsheet', text: lang('spreadsheet'), iconCls: 'ico-sprd', handler: function() {
	//				var url = og.getUrl('files', 'add_spreadsheet');
	//				og.openLink(url/*, {caller: 'documents-panel'}*/);
	//			}, hidden: !og.config['enable_documents_module']},
//				{id: 'quick-presentation', text: lang('presentation'), iconCls: 'ico-prsn', handler: function() {
//					var url = og.getUrl('files', 'add_presentation');
//					og.openLink(url/*, {caller: 'documents-panel'}*/);
//				}, hidden: !og.config['enable_documents_module']},
				{id: 'quick-file', text: lang('upload file'), iconCls: 'ico-upload', handler: function() {
					var url = og.getUrl('files', 'add_file');
					og.openLink(url/*, {caller: 'documents-panel'}*/);
				}, hidden: !og.config['enable_documents_module']}/*,
				{id: 'quick-email', text: lang('email'), iconCls: 'ico-email', handler: function() {
					var url = og.getUrl('mail', 'add_mail');
					og.openLink(url);
				}, hidden: !og.config['enable_email_module']}*/
			]
		}
	}));
	



};

Ext.extend(og.QuickAdd, Ext.Button, {});
Ext.override(Ext.tree.TreePanel,{
	
	totalNodes: 0,
	
	expandedNodes: 0,
	
	expandAll: function(callback) {
        if( typeof callback == "function"){
        	this.expandedNodes = 0 ;
    		this.root.expand(true, this.animate, function (node) {
    			var tree  = node.getOwnerTree() ;
    			tree.expandedNodes++ ;    			
    			if (tree.expandedNodes >= tree.totalNodes ) {
    				//tree.expandedNodes  = tree.totalNodes ;  
    				callback(this, node);
    				//alert(tree.title + "Expanded: "+tree.expandedNodes + " de "+ tree.totalNodes) ;
    			}
    		});
        }else{
    		this.root.expand(true);
        }
	}

});
Ext.override(Ext.tree.TreeNode,{
	   /**
     * Expand this node.
     * @param {Boolean} deep (optional) True to expand all children as well
     * @param {Boolean} anim (optional) false to cancel the default animation
     * @param {Function} callback (optional) A callback to be called when
     * expanding this node completes (does not wait for deep expand to complete).
     * Called with 1 parameter, this node.
     */
    expand : function(deep, anim, callback){
    	
        if(!this.expanded){
            if(this.fireEvent("beforeexpand", this, deep, anim) === false){
                return;
            }
            if(!this.childrenRendered){
                this.renderChildren();
            }
            this.expanded = true;
            if(!this.isHiddenRoot() && (this.getOwnerTree().animate && anim !== false) || anim){
                this.ui.animExpand(function(){
                    this.fireEvent("expand", this);
                    if(typeof callback == "function"){
                        callback(this);
                    }
                    if(deep === true){
                        this.expandChildNodes(true, callback);
                    }
                }.createDelegate(this));
                return;
            }else{
                this.ui.expand();
                this.fireEvent("expand", this);
                if(typeof callback == "function"){
                    callback(this);
                }
            }
        }else{
           if(typeof callback == "function"){
               callback(this);
           }
        }
        if(deep === true){
            this.expandChildNodes(true, callback);
        }
    },

    expandedNodes : function () {
    	var expanded = [] ;
    	if (this.isExpanded()) {
    		if (this.getDepth()){
    			expanded.push(this.id) ;
    		}else{
    			// Root node
    			expanded.push(0) ;
    		}
    	}
    	if ( !this.leaf ) { 
	    	this.eachChild(function(n){
	    		expanded = expanded.concat(n.expandedNodes());
	    	});
    	}
    	return expanded ;
    	
    },

    /**
     * Expand all child nodes
     * @param {Boolean} deep (optional) true if the child nodes should also expand their child nodes
     */
    expandChildNodes : function(deep, callback){
        var cs = this.childNodes;
        for(var i = 0, len = cs.length; i < len; i++) {
        	//alert(cs[i].text) ;
        	cs[i].expand(deep, false, callback);
        }
    }
    

});


// ***** tree loader ***** //
og.MemberChooserTreeLoader = function(config) {
	og.MemberChooserTreeLoader.superclass.constructor.call(this, config);
	if (this.ownerTree) {		
		this.ownerTree.totalNodes = 0 ;
	}
};

Ext.extend(og.MemberChooserTreeLoader , Ext.tree.TreeLoader, {
		
	ownerTree: null ,
	
	createNode: function (attr) {
		
		if (  Ext.type(this.ownerTree ) ){	
			if (this.ownerTree.totalNodes) {
				this.ownerTree.totalNodes++ ;
			}else{
				this.ownerTree.totalNodes = 1;
			}
		}else{
			alert("MemberChooserTreeLoader.js - TREE NOT DEFINED  ! ! ! "+ attr.text) ;
		}
		
        // apply baseAttrs, nice idea Corey!
        if(this.baseAttrs){
            Ext.applyIf(attr, this.baseAttrs);
        }
        if(this.applyLoader !== false){
            attr.loader = this;
        }
        if(typeof attr.uiProvider == 'string'){
           attr.uiProvider = this.uiProviders[attr.uiProvider] || eval(attr.uiProvider);
        }
        if(attr.nodeType){

            var node =  Ext.tree.TreePanel.nodeTypes[attr.nodeType](attr);
        }else{
        	
            var node = attr.leaf ?
	            new Ext.tree.TreeNode(attr) :
	            new Ext.tree.AsyncTreeNode(attr);
                       
        }
		node.object_id = attr.object_id ;
		node.options = attr.options ;
		node.object_controller = attr.object_controller ;
		node.allow_childs = attr.allow_childs ;
        
        
        return node ;            
        
	},
	
	processResponse:function(response, node, callback) {
		if (  Ext.type(this.ownerTree ) ){
			this.ownerTree.totalNodes = 1 ;
		}
		var json = response.responseText;
		try {
			var o = eval("("+json+")");
			o = o.dimension_members;

			for(var i = 0, len = o.length; i < len; i++){
				var n = this.createNode(o[i]);
				n.object_id = o[i].object_id ;
				n.options = o[i].options ;
				n.object_controller = o[i].object_controller ;
				n.allow_childs = o[i].allow_childs ;

				if(n){
					node.appendChild(n);
				}
			}
			node.endUpdate();
			if(typeof callback == "function"){
				callback(this, node);
			}
		}catch(e){
			this.handleFailure(response);
		}
	}
	
	
}); 

Ext.ns('Ext.ux.layout');

/**
 * @class Ext.ux.layout.MultiAccordion
 * @extends Ext.layout.FitLayout
 * @author Ignacio Vazquez < elpepe.uy@gmail.com >
 * <p>Like Accordion Layout with confugurable max active items:</p>
 **/
Ext.ux.layout.MultiAccordion = Ext.extend(Ext.layout.ContainerLayout, {
	

	
    monitorResize:true,

	/**
	 *  @cfg {Integer} maxActive
	 *  Max number of active panels 
	 *  Default = 1
	 */
	maxActiveItems: 1 ,
	
	/**
	 * 
	 */
	activeItemsCount: 0,
	
	/**
	 * 
	 */
	activeItems: [],	
    /**
     * @cfg {Boolean} fill
     * True to adjust the active item's height to fill the available space in the container, false to use the
     * item's current height, or auto height if not explicitly set (defaults to true).
     */
    fill : true,
    /**
     * @cfg {Boolean} autoWidth
     * True to set each contained item's width to 'auto', false to use the item's current width (defaults to true).
     */
    autoWidth : true,
    /**
     * @cfg {Boolean} titleCollapse
     * True to allow expand/collapse of each contained panel by clicking anywhere on the title bar, false to allow
     * expand/collapse only when the toggle tool button is clicked (defaults to true).  When set to false,
     * {@link #hideCollapseTool} should be false also.
     */
    titleCollapse : true,
    /**
     * @cfg {Boolean} hideCollapseTool
     * True to hide the contained panels' collapse/expand toggle buttons, false to display them (defaults to false).
     * When set to true, {@link #titleCollapse} should be true also.
     */
    hideCollapseTool : false,
    /**
     * @cfg {Boolean} collapseFirst
     * True to make sure the collapse/expand toggle button always renders first (to the left of) any other tools
     * in the contained panels' title bars, false to render it last (defaults to false).
     */
    collapseFirst : false,
    /**
     * @cfg {Boolean} animate
     * True to slide the contained panels open and closed during expand/collapse using animation, false to open and
     * close directly with no animation (defaults to false).  Note: to defer to the specific config setting of each
     * contained panel for this property, set this to undefined at the layout level.
     */
    animate : false,
    /**
     * @cfg {Boolean} sequence
     * <b>Experimental</b>. If animate is set to true, this will result in each animation running in sequence.
     */
    sequence : false,
    /**
     * @cfg {Boolean} activeOnTop
     * True to swap the position of each panel as it is expanded so that it becomes the first item in the container,
     * false to keep the panels in the rendered order. <b>This is NOT compatible with "animate:true"</b> (defaults to false).
     */
    activeOnTop : false,

    /**
     * 
     */
    addActiveItem : function (item){
	    	this.activeItems.push(item) ;
	    	this.activeItemsCount++ ;
    },
    

    
    renderItem : function(c){
    	
	        if(this.animate === false){
	            c.animCollapse = false;
	        }
	        c.collapsible = true;
	        if(this.autoWidth){
	            c.autoWidth = true;
	        }
	        if(this.titleCollapse){
	            c.titleCollapse = true;
	        }
	        if(this.hideCollapseTool){
	            c.hideCollapseTool = true;
	        }
	        if(this.collapseFirst !== undefined){
	            c.collapseFirst = this.collapseFirst;
	        }
	        if( this.activeItems.length < this.maxActiveItems && !c.collapsed && !c.hidden ){
        		this.addActiveItem(c) ;
	        }else {
	            c.collapsed = true;
	        }
	        Ext.ux.layout.MultiAccordion.superclass.renderItem.apply(this, arguments);
	        c.header.addClass('x-accordion-hd');
	        c.on('beforeexpand', this.beforeExpand, this);
	        c.on('beforecollapse', this.beforeCollapse, this);
	        c.on('beforehide', this.beforeHide, this);
    },

    beforeHide : function (p) {
    	p.hidden = true ;
    	this.layout();
    },
    
    beforeCollapse : function (p, anim) {
    	// find this item on active items collection and delete it  //TODO performance make a map
    	var ais = this.activeItems ;
    	this.activeItemsCount-- ;
    	var deleted = false ;
    	for (var i = 0  ; i < ais.length ; i++ ) {
    		if ( ais[i] && ais[i].id ==  p.id ) {
    			var deleted = true ;
    			delete this.activeItems[i];
    			break;
    		}
    	}

        p.willExpand = false ;
        p.willCollapse = true ;   
        this.layout();
        
    },
    
    
    // private
    beforeExpand : function(p, anim){
        var ais = this.activeItems;
        var max = this.maxActiveItems;
		if(this.activeItemsCount >= max) {
			for (var i = 0  ; i<this.activeItems.length ; i++) {
				if ( this.activeItems[i] ) {
					this.activeItems[i];
					this.activeItems[i].collapse(false);
					break;
				}
			}
		}
        this.addActiveItem(p);
        if(this.activeOnTop){
            p.el.dom.parentNode.insertBefore(p.el.dom, p.el.dom.parentNode.firstChild);
        }
        p.willExpand = true ;
        p.willCollapse = false ;        
        this.layout();
        

    },

    
    // private
    onLayout : function(ct, target){
        Ext.ux.layout.MultiAccordion.superclass.onLayout.call(this, ct, target);
        if(!this.container.collapsed){
            this.setActiveItemsSize(target.getStyleSize());
        }
    },
    
    /*
     * size: Size of the container (widh,height)
     */
    setActiveItemsSize : function(size){
    	var margins = 7 ;
    	var delta = 30 ;// Change this value when you change item heigt/margins via css
        if(this.fill){

            var items = this.container.items.items; // Each Tree
            var hh = 0 ; // Collapsed items height
            
            for(var i = 0, len = items.length; i < len; i++){
                var p = items[i];
                if ( p.willCollapse && !p.hidden || ( p.collapsed && !p.hidden && !p.willExpand )  ) {
                	var delta = (p.getSize().height - p.bwrap.getHeight()) ;
                	delta += margins ;
                    hh += delta ;

               		//var margins = $("#"+p.id).outerHeight(true) - $("#"+p.id).outerHeight(false) ;
                   // hh += 25 ;
                    //this.debug("hh delta="+ (p.getSize().height - p.bwrap.getHeight()));
                	/*var htmlEl = document.getElementById(p.id);
               		var margins = $("#"+p.id).outerHeight(true) - $("#"+p.id).outerHeight(false) ;
                	hh += (p.getSize().height - p.bwrap.getHeight()) + margins ;*/
                }	
            }
            
            //this.debug("("+size.height + " - " + hh/delta +"*23 ) /  "+ this.activeItemsCount + " = "+ (  size.height - hh ) / this.activeItemsCount  ) ;
            // Set each active item the new calc size
            size.height = ( size.height - hh ) / this.activeItemsCount - margins ;
            
           // this.debug("height="+  size.height + "hh="+hh + "delta = "+ delta  + "tree size = " +  size.height);
            var dbg = '' ;
            for (var i = 0 ; i < this.activeItems.length ; i++) {
            	if ( this.activeItems[i] ) {
            		
            		//dbg += "\n * " + this.activeItems[i].title + "\n" ; 
            		this.activeItems[i].setSize(size);
            		this.activeItems[i].doLayout();
            	}
            }
            
            //og.msg("",dbg,5);
        }
    },
    
    
    debug : function (title) {
    	var out = '' ;
    	out += title+'\n';
    	out += '-------------------\n'; 
    	out += '* ACTIVE ITEMS COUNT: ' + this.activeItemsCount + '\n';
    	out += '* ACTIVE ITEMS : \n';
    	for (var i = 0 ; i < this.activeItems.length ; i++) {
    		if (item = this.activeItems[i]){
    			out += '      *'+item.title + '\n' ; 
    		}
    	}
    	og.msg("",out, 15);
    }
    
});
Ext.Container.LAYOUTS['multi-accordion'] = Ext.ux.layout.MultiAccordion;
Ext.ns('Ext.ux.layout');

Ext.ux.layout.HorizontalLayout = Ext.extend(Ext.layout.ContainerLayout, {
	
	
	
    // private
    monitorResize:true,
    
	/**
	 *  @cfg {Integer} maxActive
	 *  Max number of active panels 
	 *  Default = 1
	 */
	//maxActiveItems: 1 ,
	
	/**
	 * 
	 */
	//activeItemsCount: 0,
    
    // private
    extraCls: 'x-column',

    scrollOffset : 0,

    // private
    isValidParent : function(c, target){
        return c.getEl().dom.parentNode == this.innerCt.dom;
    },
    
    
    // private
    renderItem : function(c, position, target){
        if(c && !c.rendered){
            c.render(target, position);
            if(this.extraCls){
            	var t = c.getPositionEl ? c.getPositionEl() : c;
            	t.addClass(this.extraCls);
            }
            if (this.renderHidden && c != this.activeItem) {
                c.hide();
            }
        }else if(c && !this.isValidParent(c, target)){
            if(this.extraCls){
                c.addClass(this.extraCls);
            }
            if(typeof position == 'number'){
                position = target.dom.childNodes[position];
            }
            target.dom.insertBefore(c.getEl().dom, position || null);
            if (this.renderHidden && c != this.activeItem) {
                c.hide();
            }
        }
        c.header.addClass('horizontal-hd');
        c.on('beforeexpand', this.beforeExpand, this);
        c.on('beforecollapse', this.beforeCollapse, this);
    },
    
    // private
    renderRange : function(ct, target, start, limit){
        var items = ct.items.items;
        for(var i = start, len = Math.min( items.length, limit + start) ; i < len; i++) {
            var c = items[i];
            if(c && (!c.rendered || !this.isValidParent(c, target))){
                this.renderItem(c, i, target);
            }
        }
    },
    
    
    beforeCollapse :  function(p, anim){
    	p.addClass("horizontal-collapsed") ;
    	p.afterCollapse(); //doy vuelta el boton
    },
    
    
    beforeExpand : function(p, anim){
    	p.removeClass("horizontal-collapsed") ;
    },

    // private
    onLayout : function(ct, target){
        var cs = ct.items.items, len = cs.length, c, i;

        if(!this.innerCt){
            target.addClass('x-column-layout-ct');

            // the innerCt prevents wrapping and shuffling while
            // the container is resizing
            this.innerCt = target.createChild({cls:'x-column-inner'});
            this.innerCt.createChild({cls:'x-clear'});
        }
        
        this.renderAll(ct, this.innerCt);
        //this.renderRange(ct, this.innerCt, 0 , this.maxActiveItems );
        
        
        var size = Ext.isIE && target.dom != Ext.getBody().dom ? target.getStyleSize() : target.getViewSize();

        if(size.width < 1 && size.height < 1){ // display none?
            return;
        }

        var w = size.width - target.getPadding('lr') - this.scrollOffset,
            h = size.height - target.getPadding('tb'),
            pw = w;

        this.innerCt.setWidth(w);
        
        // some columns can be percentages while others are fixed
        // so we need to make 2 passes

        for(i = 0; i < len; i++){
            c = cs[i];
            if(!c.columnWidth){
                pw -= (c.getSize().width + c.getEl().getMargins('lr'));
            }
        }

        pw = pw < 0 ? 0 : pw;

        for(i = 0; i < len; i++){
            c = cs[i];
            if(c.columnWidth){
                c.setSize(Math.floor(c.columnWidth*pw) - c.getEl().getMargins('lr'));
            }
        }
    }
    

});

Ext.Container.LAYOUTS['horizontal'] = Ext.ux.layout.HorizontalLayout;
og.ExtendedDialog = function(config) {
	if (config.html) {
		var panel = new og.HtmlPanel({
			html: config.html
		});
	} else {
		var panel = new Ext.FormPanel({
			frame: false,
			url: '',
			labelWidth: config.labelWidth,
			bodyStyle: 'padding:20px 20px 0',
			border: false,
			bodyBorder: false,
			items: config.dialogItems
		});
	}	
	config.stateful = false;
	if (!config.genid) config.genid = Ext.id();
	og.ExtendedDialog.superclass.constructor.call(this, Ext.applyIf(config, {
		y: 50,
		id: config.genid + 'dialog',
		layout: 'fit',
		modal: true,
		height: 300,
		width: 450,
		resizable: false,
		closeAction: 'hide',
		iconCls: 'op-ico',
		border: false,
		buttons: [{
			text: (config.YESNO ? lang('yes') : lang('ok')),
			handler: this.accept,
			id: config.genid + 'ok_button',
			scope: this
		},{
			text: (config.YESNO ? lang('no') : lang('cancel')),
			handler: this.cancel,
			hidden: config.noCancel,
			id: config.genid + 'cancel_button',
			scope: this
		}],
		items: [
			panel
		]
	}));
}

Ext.extend(og.ExtendedDialog, Ext.Window, {
	accept: function() { this.hide(); },
	cancel: function() { this.hide(); }
});


og.ExtendedDialog.show = function(config) {
	if (!config)
		config = {};
	if (!config.genid)
		config.genid = 'Extended';
	if (this.dialog)
		this.dialog.destroy();
	this.dialog = new og.ExtendedDialog(config);
	
	if (config.ok_fn) {
		Ext.getCmp(config.genid + 'ok_button').setHandler(config.ok_fn);
	}
	if (config.cancel_fn) {
		Ext.getCmp(config.genid + 'cancel_button').setHandler(config.cancel_fn);
	}
	
	this.dialog.purgeListeners();
	this.dialog.on('hide', og.restoreFlashObjects);
	this.dialog.on('close', og.restoreFlashObjects);
	og.hideFlashObjects();
	this.dialog.show();
	var pos = this.dialog.getPosition();
	if (pos[0] < 0) pos[0] = 0;
	if (pos[1] < 0) pos[1] = 0;
	this.dialog.setPosition(pos[0], pos[1]);
	
	return this.dialog;
}

og.ExtendedDialog.hide = function() {
	if (this.dialog) this.dialog.hide();
}
/*
Copyright (c) 2006, Gustavo Ribeiro Amigo
All rights reserved.

Redistribution and use in source and binary forms, with or without modification, are permitted provided that the following conditions are met:

    * Redistributions of source code must retain the above copyright notice, this list of conditions and the following disclaimer.
    * Redistributions in binary form must reproduce the above copyright notice, this list of conditions and the following disclaimer in the documentation and/or other materials provided with the distribution.
    * Neither the name of the author nor the names of its contributors may be used to endorse or promote products derived from this software without specific prior written permission.

THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.

*/


var Sound = function(swf) {
	if (!swf) {
		swf = "public/assets/flash/SoundBridge.swf";
	}
	if (!Sound.count) {
		Sound.count = 1;
	} else {
		Sound.count++;
	}
	this.id = 'sound' + Sound.count;
	if (!Sound.instances) {
		Sound.instances = {};
	}
	Sound.instances[this.id] = this;
		
	// create swf movie
	var movie = '<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" width="0" height="0"'; 
	movie += ' id="' + this.id + '"'; 
	movie += ' align="middle">';
	movie += '<param name="movie" value="' + swf + '" />';
	movie += '<param name="quality" value="high" />';
	movie += '<param name="bgcolor" value="#ffffff" />';
	movie += '<param name="FlashVars" value="id=' + this.id + '"/>';
	movie += '<param name="allowScriptAccess" value="always"/>';
	movie += '<embed src="' + swf + '" FlashVars="id=' + this.id + '"'; 
	movie += ' allowScriptAccess="always" quality="high" bgcolor="#ffffff" width="0" height="0"'; 
	movie += ' name="' + this.id + '" align="middle" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />';
	movie += '</object>';

	var sounds = document.getElementById('__flash_sounds__');
	if (!sounds) {
		sounds = document.createElement("div");
		sounds.id = "__flash_sounds__";
		document.body.appendChild(sounds);
	}
	sounds.innerHTML += movie; 
};

Sound.prototype.loadSound = function(url, streaming) {
	return this.call('loadSound', url, streaming);
};

Sound.prototype.start = function() {
	return this.call('start');
};

Sound.prototype.stop = function() {
	return this.call('stop');
};

Sound.prototype.getId3 = function() {
	return this.call('id3');
};

Sound.prototype.getPan = function() {
	return this.call('getPan');
};

Sound.prototype.getTransform = function() {
	return this.call('getTransform');
};

Sound.prototype.getVolume = function() {
	return this.call('getVolume');
};

Sound.prototype.setPan = function(value) {
	return this.call('setPan', value);
};

Sound.prototype.setTransform = function(transformObject) {
	return this.call('setTransform', transformObject);
};

Sound.prototype.setVolume = function(value) {
	return this.call('setVolume', value);
};

Sound.prototype.start = function(secondOffset, loops) {
	return this.call('start', secondOffset, loops);
};

Sound.prototype.getDuration = function() {
	return this.call('getDuration');
};

Sound.prototype.setDuration = function(value) {
	return this.call('setDuration', value);
};

Sound.prototype.getPosition = function() {
	return this.call('getPosition');
};

Sound.prototype.setPosition = function(value) {
	return this.call('setPosition', value);
};

Sound.prototype.getBytesLoaded = function() {
	return this.call('getBytesLoaded');
};

Sound.prototype.getBytesTotal = function() {
	return this.call('getBytesTotal');
};

Sound.prototype.onLoad = function(success) {
	this.debug('Sound: onLoad(' + success + ') event triggered');
};

Sound.prototype.onSoundComplete = function() {
	this.debug('Sound: onSoundComplete() event triggered');
};

Sound.prototype.onID3 = function() {
	this.debug('Sound: onID3() event triggered');
};

Sound.prototype.call = function(method) {
	this.debug('Sound: ' + method + ' method invoked by ' + this.id);
	var args = new Array();
	for (var i=1; i < arguments.length; i++) {
		args.push(arguments[i]);
	}
	return Sound.getMovie(this.id).proxyMethods(method, args);
};

Sound.prototype.debug = function(value) {
	var debug = document.getElementById('sound_tracer');
	if (debug) {
		debug.value += value + '\n';
	}
};

Sound.getMovie = function(movieName) {
	if (navigator.appName.indexOf("Microsoft") != -1) {
		return window[movieName];
	} else {
		return document[movieName];
	}
};

og.LoginDialog = function(config) {
	if (!config) config = {};
		
	og.LoginDialog.superclass.constructor.call(this, Ext.apply(config, {
		id: 'og-login-dialog',
		modal: true,
		layout: 'form',
		closeAction: 'hide',
		iconCls: 'op-ico',
		title: lang('login'),
		labelWidth: 75,
        bodyStyle: 'padding:5px 5px 0',
        width: 250,
        defaults: {width: 130},
        defaultType: 'textfield',
        items: [{
        		xtype: 'label',
        		style: 'color: red',
        		width: 240,
        		hideLabel: true,
        		text: lang('login dialog desc')
        	},{
        		id: 'username',
                fieldLabel: lang('username'),
                name: 'username',
                //allowBlank: false,
                listeners: {
                	specialkey: {
                		fn: function(field, e) {
                			if (e.getKey() == 13) {
                				this.submit();
                			}
                		},
                		scope: this
                	}
                }
            },{
            	id: 'password',
            	inputType: 'password',
                fieldLabel: lang('password'),
                name: 'password',
                //allowBlank: false,
                listeners: {
                	specialkey: {
                		fn: function(field, e) {
                			if (e.getKey() == 13) {
                				this.submit();
                			}
                		},
                		scope: this
                	}
                }
            },{
            	id: 'remember',
            	xtype: 'checkbox',
                fieldLabel: '',
                labelSeparator: '',
                boxLabel: lang('remember me'),
                name: 'remember'
            }
        ],
        buttons: [{
            text: lang('login'),
            handler: this.submit,
            scope: this
        },{
            text: lang('cancel'),
            handler: function() {
            	this.hide()
            },
            scope: this
        }]
	}));
}

Ext.extend(og.LoginDialog, Ext.Window, {
	submit: function() {
		if (this.findById('username').getValue() == og.loggedUser.username) {
			og.openLink(og.getUrl('access', 'relogin'), {
				post: {
					"login[username]": this.findById('username').getValue(),
					"login[password]": this.findById('password').getValue(),
					"login[remember]": this.findById('remember').getValue()
				},
				callback: function(success, data) {
					if (success && data.errorCode == 0) {
						this.hide();
						if (this.params.url) {
							og.openLink(this.params.url, this.params.options);
						}
					}
				},
				scope: this
			});
		} else {
			var form = document.createElement('form');
			form.action = og.getUrl('access', 'login');
			form.method = 'POST';
			var un = document.createElement('input');
			un.name = 'login[username]';
			un.type = 'hidden';
			un.value = this.findById('username').getValue();
			var pw = document.createElement('input');
			pw.name = 'login[password]';
			pw.type = 'hidden';
			pw.value = this.findById('password').getValue();
			var rm = document.createElement('input');
			rm.name = 'login[remember]';
			rm.type = 'hidden';
			rm.value = this.findById('username').getValue() ? 'checked' : '';
			form.appendChild(un);
			form.appendChild(pw);
			form.appendChild(rm);
			document.body.appendChild(form);
			form.submit();
		}
	}
});

og.LoginDialog.show = function(url, options) {
	if (!this.dialog) {
		this.dialog = new og.LoginDialog();
		this.dialog.on('show', function() {
			this.findById('username').focus();
		}, this.dialog);
	}
	this.dialog.findById('username').setValue(og.loggedUser.username);
	this.dialog.findById('password').setValue('');
	this.dialog.params = {url: url, options: options};
	this.dialog.on('hide', og.restoreFlashObjects);
	this.dialog.on('close', og.restoreFlashObjects);
	og.hideFlashObjects();
	this.dialog.show();
}
og.HtmlPanel = function(config) {
	var html = config.html;
	config.html = null;
	var url = config.url;
	config.url = null;
	og.HtmlPanel.superclass.constructor.call(this, Ext.apply(config, {
		cls: 'html-panel'
	}));
	if (html) {
		this.load(html);
	} else if (url) {
		this.get(url);
	}
};

Ext.extend(og.HtmlPanel, Ext.Panel, {

	get: function(url) {
		this.urli = url;
		if (this.rendered) {
			Ext.Ajax.request({
				url: og.makeAjaxUrl(url),
				callback: function(options, success, response) {
					this.load(response.responseText);
				},
				scope: this
			});
		}
	},

	load: function(html) {
		this.htmli = html;
		if (this.rendered) {
			this.update();
		}
	},
	
	onRender : function(ct, position){
		og.HtmlPanel.superclass.onRender.call(this, ct, position);
		this.rendered = true;
		if (this.urli) {
			this.get(this.urli);
		} else {
			this.update();
		}
	},
	
	update: function() {
		this.body.update(this.htmli, true);
		og.captureLinks(this.id, this.ownerCt);
	}
});

Ext.reg("htmlpanel", og.HtmlPanel);

// ***** tree  ***** //
og.MemberTree = function(config) {

	var tbar = [{
		xtype: 'textfield',
		id: config.id + '-textfilter',
		cls: "dimension-panel-textfilter" ,
		emptyText:lang('filter members'),
		listeners:{
			render: {
				fn: function(f){
					f.el.on('keyup', function(e) {
						this.filterTree(e.target.value);
					},
					this, {buffer: 350});
				},
				scope: this
			}
		}
	}];
	
	if (config.isManageable) {
		tbar.push ({
	    	xtype: 'box',
	    	ctCls: 'member-quick-form-link', 
			autoEl: {
				id: 'quick-form-'+config.dimensionId,
				tag: 'a', 
				href: '#', 
				html: lang('add')+'+',
				onclick: "og.quickForm({ dimensionId: "+config.dimensionId+",type: 'member', treeId: '"+config.id+"', elId: 'quick-form-"+config.dimensionId+"'});"
			}
		});
	}
	
	
	Ext.applyIf(config, {
		region: 'center',
		id: config.id,
		loader: new og.MemberChooserTreeLoader({
    		dataUrl: 'index.php?c=dimension&a=initial_list_dimension_members_tree&ajax=true&dimension_id='+config.dimensionId+'&avoid_session=1',
    		ownerTree: this  
    	}),
		autoScroll: true,
		rootVisible: true,
		root: {
        	text: lang('All'),
        	id:0,
        	iconCls : 'root'
    	},
		collapseFirst: false,
		collapsible: true,
    	selModel: (config.multipleSelection)? new Ext.tree.MultiSelectionModel() : new Ext.tree.DefaultSelectionModel(),
    	dimensionId: config.dimensionId,
    	dimensionCode: config.dimensionCode, 
    	reloadHidden: true, //To force tree reload when is hidden 
    	height: 210,
    	animate: false,
    	tools: [
	       {
	    	   id: 'toggle',
	    	   handler : function(e,t,p){
	    		   p.toggleCollapse();
	    	   }
	       }, 
    	   {
    		   id: 'close',
    		   handler: function(e,t,p){
    			   p.removeFromContext();
    		   }
    	    }

    	],  	
    	hideCollapseTool: true ,
    	expandMode: 'root', //all root,
    	tbar: tbar 
	});

	og.MemberTree.superclass.constructor.call(this, config);
	
	var self = this ; // To change scope inside callbacks	

	// ********** TREE EVENTS *********** //
	this.on({
		click: function(node, e){
			og.eventManager.fireEvent("member tree node click", node);
			var treeConf = node.attributes.loader.ownerTree.initialConfig ;
			if  (node.getDepth() == 0 ){
				
				// Fire 'all' selection for other trees 
				var trees = this.ownerCt.items;
				if ( trees){
					trees.each( function (item, index, length){
						if ( self.id != item.id  && (!item.hidden ||item.reloadHidden) ) {
							item.getRootNode().select(node) ;
							og.contextManager.cleanActiveMembers(item.dimensionId);
							$('#'+item.id + " .member-quick-form-link").show();
						}
					});
				}
				
				// Manage dashborad
				if ( treeConf.dimensionOptions.defaultAjax ){
					var controller =  treeConf.dimensionOptions.defaultAjax.controller ;
					var action =  treeConf.dimensionOptions.defaultAjax.action ;
					if ( controller && action ) {
						og.customDashboard(controller, action, {}, true);
					}
				}
			}else{
				// Member selection (not root)
				if (node.object_id && node.options && node.options.defaultAjax && node.options.defaultAjax.controller && node.options.defaultAjax.action) {
					// Set custom dashborad but fire 'reload' only if selection didnt change.
					// (If selection changes its fired automatically)
					var reload = ( this.getSelectionModel() && this.getSelectionModel().getSelectedNode() && this.getSelectionModel().getSelectedNode().id  ==  node.id );
					og.customDashboard( node.options.defaultAjax.controller, node.options.defaultAjax.action, {id: node.object_id}, reload);
				}
			
			}
		}
	});
	
	this.getSelectionModel().on({
		
		selectionchange : function(sm, selection) {
			if (selection && !this.pauseEvents) {
				og.contextManager.cleanActiveMembers(this.dimensionId) ;
				if ( ! this.isMultiple() ){
					//Single Selection
					var node = selection ; 
					if (node.getDepth()) {
						var member = node.attributes.id ;
						if(node.attributes.allow_childs) {
							$('#'+this.id + " .member-quick-form-link").show();
						}else{
							$('#'+this.id + " .member-quick-form-link").hide();
						}
					}else{
						$('#'+this.id + " .member-quick-form-link").show();
						var member = 0 ; 
					}
					if (!this.hidden) {
						og.contextManager.addActiveMember(member, this.dimensionId );
					}
					if ( this.filterOnChange ) {
						var trees = this.ownerCt.items;
						if (trees){
							this.suspendEvents();
							this.totalFilterTrees = 0 ;
							this.filteredTrees = 0 ;
							trees.each(function (item, index, length){
								if ( self.id != item.id  && (!item.hidden ||item.reloadHidden) && self.reloadDimensions.indexOf(item.dimensionId) != -1  ) {
									// Filter other Member Trees
									self.totalFilterTrees++;
									item.filterByMember(member ,function(){
										self.filteredTrees ++ ;
										if (self.filteredTrees == self.totalFilterTrees) {
											self.resumeEvents() ;
											og.eventManager.fireEvent('member trees updated',node);
										}
									}) ;
									
								}
							});
							if (this.totalFilterTrees == 0 ) {
								this.resumeEvents();
								og.eventManager.fireEvent('member trees updated',node);
								
							}
						}
					}
					
					var type =  node.attributes.object_type_id;
					og.contextManager.lastSelectedNode = node ;
					og.contextManager.lastSelectedDimension = this.dimensionId ;
					og.contextManager.lastSelectedMemberType = type; 
					
					og.eventManager.fireEvent('member changed', node);
					og.eventManager.fireEvent('workspace changed', node); //Backguard compatibility
					
				}else { 
					// Multiple Selection: (UNDER DEVELOPENT) 
					// Add to context
					for (var i = 0 ; i < selection.length ; i++) {
						var node = selection[i] ;
						if (node.getDepth()) {
							var member = node.attributes.id ;
						} else {
							var member = 0;
						}
						og.contextManager.addActiveMember(member, this.dimensionId );
					}
				}
			}
		},
		scope:this // Con esto this referencia al TreeNode. Sino al SelModel
	});
	
	this.init(function(){
		  self.selectRoot([0]) ; 
	}) ;
	
	// **************** TREE INIT **************** //
};

Ext.extend(og.MemberTree, Ext.tree.TreePanel, {

	// ******* ATTRIBUTES ******** //
	
	filterOnChange: true,
	
	filterTree: function(text) {

		if (text == this.getTopToolbar().items.get(this.id + '-textfilter').emptyText) {
			text = "";
		}
		if (text.trim() == '') {
			this.clearFilter();
		} else {
			var re = new RegExp(Ext.escapeRe(text.toLowerCase()), 'i');
			this.filterNode(this.getRootNode(), re);
			this.expandAll();
		}
	},
	
	filterNode: function(n, re) {
		
		var f = false;
		var c = n.firstChild;
		while (c) {
			f = this.filterNode(c, re) || f;
			c = c.nextSibling;
		}
		f = re.test(n.text.toLowerCase()) || f;
		if (!n.previousState) {
			// save the state before filtering
			n.previousState = n.expanded ? "e" :"c";
		}
		if (f) {
			n.getUI().show();
		} else {
			n.getUI().hide();
		}
		return f;
	},
	
	clearFilter: function(n) {
		if (!n) n = this.getRootNode();
		if (!n.previousState) return;
		var c = n.firstChild;
		while (c) {
			this.clearFilter(c);
			c = c.nextSibling;
		}
		n.getUI().show();
		if (n.previousState == "e") {
			n.expand(false, false);
		} else if (n.previousState == "c") {
			n.collapse(false, false);
		}
		n.previousState = null;
	},
	
	
	
	expandedNodes: function () {
		nodes = [];
		nodes = nodes.concat( this.root.expandedNodes() );
		return nodes ;
	},
	
	init: function ( callback  ) {
		switch (this.expandMode) {
			case "all":
				this.expandAll(callback);
				break;
			case "root":
				this.root.expand(0,0,callback) ;
				break;
			case "none": default : // Not expand ?
				break;
		}
	} ,

	// ******* METHODS ******** //
	
	isMultiple: function() {
		return ( this.getSelectionModel().constructor.toString().indexOf("Array") != -1 );
	},
	
	selectRoot: function() {
		selModel = this.getSelectionModel() ;
		selModel.suspendEvents();
		var node = this.getRootNode() ;
		selModel.select(node) ;
		if (!this.hidden) og.contextManager.addActiveMember(0, this.dimensionId );
		selModel.resumeEvents();

	},
	
	hide: function() {
		og.MemberTree.superclass.hide.call(this);
		og.contextManager.cleanActiveMembers(this.dimensionId);
	},
	show: function() {
		og.MemberTree.superclass.show.call(this);
		og.contextManager.cleanActiveMembers(this.dimensionId);
		this.selectRoot();
	}, 

	selectNodes: function(nids) {
		for (var i = 0 ; i < nids.length ; i++ ) {
			if ( nids[i] != "undefined" ) {
				if ( nids[i] != 0 ) {
					var node = this.getNodeById(nids[i]) ;
				}else{
					var node = this.getRootNode();
				}
				if (node) {
					selModel = this.getSelectionModel() ;
					selModel.suspendEvents();
					selModel.select(node) ;
					selModel.resumeEvents();
				}
			} 
		}
	
	},
	
	expandNodes: function (nids, callback) {
		
		for (var i = 0 ; i < nids.length ; i++ ) {
			if ( nids[i] != "undefined" ) {
				if ( nids[i] != 0 ) {
					var node = this.getNodeById(nids[i]) ;
					
				}else{
					var node = this.getRootNode();
				}
				if (node) {
					node.expand();
				}
			} 
		}
		
		
	},
	
	filterByMember: function(memberId, callback) {
		var tree = this ; //scope
		var expandedNodes = tree.expandedNodes() ;
		var selectedMembers = og.contextManager.getDimensionMembers(this.dimensionId) ;

		//tree.expandMode = "none";
		
		this.collapseAll() ;
		
		this.loader =  new og.MemberChooserTreeLoader({
			dataUrl: 'index.php?c=dimension&a=list_dimension_members_tree&ajax=true&dimension_id='+this.dimensionId+'&member_id='+memberId +'&avoid_session=1',	
			ownerTree: this
		});
		this.loader.load(this.getRootNode(), function() {
			
			tree.init(
				function() {
					if (tree.expandMode != "all"){
						// If not all nodes are exapnded, expand only needed
						tree.expandNodes(expandedNodes);
					}
					tree.selectNodes(selectedMembers); 
			        if( typeof callback == "function"){
			        	callback();
			        }
				} 
			);
		});
			
	},
	
	removeFromContext: function() {
		this.hide();
		this.collapse();
		this.getSelectionModel().select(this.getRootNode());
		var did = this.dimensionId;
		Ext.getCmp("dimension-selector-"+did).suspendEvents();
		Ext.getCmp("dimension-selector-"+did).setChecked(false);
		Ext.getCmp("dimension-selector-"+did).resumeEvents();
	}

});


// ***** EXTJS REGISTER COMPONENT ******* //
Ext.reg('member-tree', og.MemberTree);

og.MemberChooserPanel = function(config) {
	
	
	Ext.applyIf(config, {
		
		iconCls: 'ico-workspaces',
		
		//layout: 'column',
		
		autoScroll: true,

		renderTo: 'member-chooser-panel'


	});
	
	og.MemberChooserPanel.superclass.constructor.call(this, config);
	
	
	
};

Ext.extend(og.MemberChooserPanel, Ext.Panel,{
	
	checkNodes: function (nodes) {
		
		this.items.each(function(item, index, length){
			item.checkNodes(nodes);
		});

	}
	
});
og.MemberChooserTree = function(config) {
	
	if (!config.allowedMemberTypes) 
		config.allowedMemberTypes = '';
	
	Ext.applyIf(config, {
		
		isMultiple: false,
		
		collapsible: true,
		
		collapsed: !config.required,
		
		titleCollapse: true,  
		
		allowedMemberTypes: '', //Array of dimension member types to be rendered as checkbox
		
		reloadDimensions: [],
		
		loader: new og.MemberChooserTreeLoader({
			dataUrl: 'index.php?c=dimension&a=initial_list_dimension_members_tree&ajax=true&'+
				'dimension_id='+config.dimensionId+
				'&object_type_id='+config.objectTypeId+
				'&checkboxes=true'+
				(config.all_members ? '&all_members=true' : '')+
				'&allowedMemberTypes='+Ext.encode(config.allowedMemberTypes)+
				'&avoid_session=1',
			ownerTree: this 
		}),

		checkBoxes: true,
		
		autoScroll: true,
		
		animCollapse: false,
		
		animExpand: false,
		
		animate: false,
		
		rootVisible: true,
		
		lines: false,
		
		root: {
        	text: lang('All'),
        	expanded: false
    	},
    	
		collapseFirst: false,
		
		cls: 'member-chooser'
		
		
	});
	
	
	
	og.MemberChooserTree.superclass.constructor.call(this, config);

	if ( Ext.isIE7 ) {
		
		this.width= 230;
		
		this.height= 280 ;
			
	}
		
	this.filterOnChange = true ;
	
	this.totalFilterTrees = 0 ;
	
	this.filteredTrees = 0 ;
	
	var self = this ; // To change scope inside callbacks	

	
	// ********** TREE EVENTS *********** //
	
	this.on ({
		'checkchange' : function (node, checked) {
			// Avoid multiple check
			if (!this.isMultiple) {
				if (checked) {
					var oldChecked = this.getChecked() ;
					for (var i = 0 ; i < oldChecked.length ; i++) {
						if ( oldChecked[i] && oldChecked[i].id != node.id ) {
							this.suspendEvents();
							oldChecked[i].checked = false ; 
							oldChecked[i].getUI().toggleCheck(false) ;						
							this.resumeEvents();
						}
					}
				}
			}
			
			// Filter other trees 
			if ( this.filterOnChange ) {
				var trees = this.ownerCt.items;
				if (trees){
					this.suspendEvents();
					this.totalFilterTrees = 0 ;
					this.filteredTrees = 0 ;
					trees.each(function (item, index, length){

						if ( self.id != item.id && self.reloadDimensions.indexOf(item.dimensionId) != -1  ) {
							self.totalFilterTrees++;
							
							var nid = (checked) ? node.id : 0 ;
							if (checked) {
								var nid = node.id ; 
							}else{
								if (!this.isMultiple){
									var nid = 0 ;
								}else {
									var nid = self.getLastChecked() ;
								}
							}
							
							item.filterByMember(nid ,function(){
								self.filteredTrees ++ ;
								if (self.filteredTrees == self.totalFilterTrees) {
									self.resumeEvents() ;
									self.fireEvent('all trees updated');
								}
							}) ;
							
						}
					});
					if (this.totalFilterTrees == 0 ) {
						this.resumeEvents();
						self.fireEvent('all trees updated');
					}
				}
			}
			
			
		},
		'scope':this
	});
};


Ext.extend(og.MemberChooserTree, Ext.tree.TreePanel, {
	
	suspendEvents: function() {
		og.MemberChooserTree.superclass.suspendEvents.call(this);
		var htmlInputs = Ext.query("#"+this.getId() + " input" ) ;
		for (var i in htmlInputs ) {
			if ( i != "remove" ) {
				htmlInputs[i].disabled = "disabled";	
			}
		}
	},

	resumeEvents: function() {
		og.MemberChooserTree.superclass.resumeEvents.call(this);
		var htmlInputs = Ext.query("#"+this.getId() + " input" ) ;
		for (var i = 0 ; i <htmlInputs.length; i++ ) {
			if ( htmlInputs[i] ) {
				htmlInputs[i].disabled = "";

			}
		}
		
	},

	
	filterByMember: function(memberId,callback) {
		var checked = this.getChecked("id");
		//this.collapseAll() ;
		this.loader =  new og.MemberChooserTreeLoader({	
			dataUrl:	
				'index.php?c=dimension&a=list_dimension_members_tree&ajax=true&checkboxes=true'
				+'&dimension_id='+this.dimensionId
				+'&member_id='+memberId
				+'&object_type_id='+this.objectTypeId 
				+'&avoid_session=1',
			ownerTree: this 			 
		}) ;
		var self = this;// Scope for callback
		this.loader.load(this.getRootNode(), function() {
			self.expandAll(function(){
				self.checkNodes(checked);
		        if( typeof callback == "function"){
		        	callback();
		        }
			});			
		});
	},
	
	checkNodes: function (nids) {
		if (!nids) return ;
		for (var i = 0 ; i < nids.length ; i++ ) {
			if ( nids[i] != "undefined" ) {
				if ( nids[i] != 0 ) {
					var node = this.getNodeById(nids[i]) ;
				}else{
					var node = this.getRootNode();
				}
				if (node) {
					this.suspendEvents();
					node.checked= true;
					node.getUI().toggleCheck(true);
					this.resumeEvents();
				}
			} 
		}
	},
	
	/**
	 * Select nodes given as array of int
	 */
	selectNodes: function (nids) {
		if (nids.length){
			for (var i = 0 ; i < nids.length ; i++ ){
				this.getSelectionModel().select(this.getNodeById(nids[i]));
				if (!this.multipleSelect) {
					return true;
				}
			}
		}
		return true;
	},
	
    afterRender : function(){
		var tree = this ;
    	var collapsed = this.collapsed ;
    	this.collapsed = false ;
        og.MemberChooserTree.superclass.afterRender.call(this);
        if(collapsed){
        	if(this.checkBoxes){
        		tree.expandAll(function(){tree.collapse(false);tree.checkNodes(tree.ownerCt.selectedMembers); tree.fireEvent('tree rendered', tree);} );
        	}else{
        		tree.expandAll(function(){tree.collapse(false);tree.selectNodes(tree.ownerCt.selectedMembers); tree.fireEvent('tree rendered', tree);} );
        	}
    	}else{
    		if (this.checkBoxes){
    			tree.expandAll(function(){tree.checkNodes(tree.ownerCt.selectedMembers); tree.fireEvent('tree rendered', tree);} );
    		}else{
    			tree.expandAll(function(){tree.selectNodes(tree.ownerCt.selectedMembers); tree.fireEvent('tree rendered', tree);} );
    		}
    	}   
        
        
    },	 
	
	getLastChecked : function() {
		var checkedNodes = this.getChecked("id");
		if (checkedNodes.length  && checkedNodes[0] ) {
			return checkedNodes[0];
		}else{
			return 0 ; // Return 'All' (root node)
		}
		
	}
    
});

Ext.reg('member-chooser-tree', og.MemberChooserTree);
og.MemberChooserNode = function (config) {
	self.construct = function(config){}
	self.construct(config);
	return self;
}


/**
 * Member Chooser 
 * @author Pepe
 */
og.MemberChooser = function(config) {
	/*
	var self = this ;
	
	var dimensionId = null ;
	
	var members = [] ;

	var isMultiple = false;
	
	var reloadDimensions = [];
	
	var checkBoxes = true ;
	
	var status = 0 ;
	
	var baseUrl = '' ;
	
	var ajaxUrl = '' ;
	
	var ct = null ;
*/

	var self = this ;
	self.construct = function(config){
		//this.members = [] ;
		this.isMultiple = false ;
		this.baseUrl = config.baseUrl ;
		this.dimensionId = config.dimensionId || "" ;
		this.objectTypeId = config.objectTypeId || "" ;
		this.ajaxUrl = this.baseUrl  
			+'&dimension_id='+this.dimensionId
			+'&object_type_id='+this.objectTypeId+
			+'&checkboxes=true'+
			+'&avoid_session=1';
	};
	
	self.renderMembers = function() {
		var ul = document.createElement('ul');
		var hdr = document.createElement ('div');
		hdr.className = "mc-header" ;
		var txtBox = document.createElement ('input');
		txtBox.type= "text" ;
		hdr.appendChild(txtBox);
		
		for (i in this.members) {
			if ( this.members[i] ){
				var member = this.members[i] ;
				var li = document.createElement('li');
				var ch = document.createElement('input');
				ch.type = 'checkbox';
				ch.name = 'dimension_members';
				ch.value = member.id ;
				li.appendChild(ch);
				li.innerHTML += "<span>"+member.name+"</span>" ;
				ul.appendChild(li);	
				
			}
		}
		
		this.ct.innerHTML = '' ;
		this.ct.appendChild(hdr);
		this.ct.appendChild(ul);
		$(this.ct).slideDown();
		this.filter("ad");
	};
	
	self.filter = function (text) {
		$(this.ct).find("li:not(:contains("+text+"))").addClass("hidden");
	};
	
	self.render = function(position) {
		if ( !this.status ) {
			var ct = document.createElement("div");
			ct.className = "mc-container";
			ct.style.diplay = "none" ;
			$(ct).offset(position);
			this.ct = ct ;
			setTimeout (function(){
				$('html').click(function() {
					$(".mc-container").slideUp();
				});
				$(ct).click(function(event){
					event.stopPropagation();
				});
			},1000);
		}else{
			$(this.ct).slideDown();
		}
		
		this.status = 1 ;
		document.body.appendChild (ct);
		 Ext.Ajax.request({
             url:self.ajaxUrl,
             success: function(data){
				var response = eval("("+ data.responseText+")");
				self.members = response.dimension_members ;
				self.renderMembers();
			},
             failure: function(data){
				alert("error in response");
			 },
         });
		
		
		return ct ;
	};
	
	self.toggle = function (e) {
		position = e.offset();
		position.top = position.top + e.height() + 2; 
		this.render(position) ;
		
	};
	
	self.construct(config);
	return self;
}
/**
 *  Just like the Ext.layout.FitLayout, except that instead of having the first
 *  element fill the container panel, the first visible element is picked.
 */
og.ContentPanelLayout = Ext.extend(Ext.layout.ContainerLayout, {
    // private
    monitorResize:true,

    // private
    onLayout : function(ct, target){
        og.ContentPanelLayout.superclass.onLayout.call(this, ct, target);
        if(!this.container.collapsed){
        	// get first visible panel
        	for (var i=0; ct.items.itemAt(i); i++) {
        		if (!ct.items.itemAt(i).hidden) {
            		this.setItemSize(this.activeItem || ct.items.itemAt(i), target.getStyleSize());
            	}
            }
            this.setItemSize(this.activeItem || ct.items.itemAt(0), target.getStyleSize());
        }
    },

    // private
    setItemSize : function(item, size){
        if(item && size.height > 0){ // display none?
            item.setSize(size);
        }
    }
});
Ext.Container.LAYOUTS['contentpanel'] = og.ContentPanelLayout;
/**
 *  Config options:
 *  	- id
 *  	- title
 *  	- iconCls
 *  	- defaultContent
 *  	- plus all Ext.Panel options
 */
og.ContentPanel = function(config) {
	if (!config) config = {};
	if (!config.listeners) config.listeners = {};
	this.onClose = config.onClose;
	this.contentAutoScroll = typeof config.autoscroll == "undefined" || config.autoscroll;
	Ext.apply(config, {
		autoscroll: false,
		layout: 'contentpanel',
		loaded: false,
		cls: 'og-content-panel', // identifies ContentPanels (see: og.getParentContentPanel)
		items: [{
			xtype: 'panel',
			html: ""
		}],
		listeners: Ext.apply(config.listeners, {
			activate: {
				fn: this.activate,
				scope: this
			},
			deactivate: {
				fn: this.deactivate,
				scope: this
			}
		})
	});
	
	og.ContentPanel.superclass.constructor.call(this, config);
	
	this.history = [];
	this.help = '';
	this.contentLoaded = false;
	
	this.onClose = config.onClose;
	
	if (config.refreshOnWorkspaceChange) {
		og.eventManager.addListener('workspace changed', this.reset, this);
	}

	
	// dirty stuff to allow refreshing a content panel when clicking on its tab
	
	
	this.on('render', function() {
		var tab = Ext.get("tabs-panel__" + this.id);
		if (tab) {
			og._activeTab = this.id;
			tab.on('click', function() { 
				og._activeTab = this.id;
			}, this);
			tab.on('dblclick', function() { 
				if (this.id == og._activeTab) {
					this.reset();
				}
			}, this);
			//og.eventManager.fireEvent("tab selected", tab);
		}
		if (this.ownerCt) {
			this.ownerCt.on('remove', function(ct, item) {
				if (item == this) {
					if (typeof this.onClose == 'function') {
						this.onClose();
					}
				}
			}, this);
		}
	}, this);
};

Ext.extend(og.ContentPanel, Ext.Panel, {

	activate: function() {
		this.active = true;
		if (this.getComponent(0).activate) {
			this.getComponent(0).activate();
		}
		if (!this.loaded) {
			if (this.initialContent) {
				this.history.push(this.defaultContent);
				this.load(this.initialContent);
				this.initialContent = false;
			} else {
				this.load(this.defaultContent);
			}
		}
		if(this.help.data){
			Ext.getCmp('help-panel').load(this.help);
		}
	},
	
	deactivate: function() {
		this.active = false;
		/*if (this.z(0).deactivate) {
			this.getComponent(0).deactivate();
		}*/ 
	},
	
	setHelp: function(help){
		this.help = help; 
	},
	
	hasHelp: function(){
		if(this.help != ''){
			return true;
		}
		return false;
	},
	
	setPreventClose: function(prevent) {
		if (!this.preventClose && prevent) {
			// if this panel was closable but now we want to prevent it:
			og.ContentPanel.preventCloseCount++;
			if (og.ContentPanel.preventCloseCount) {
				window.onbeforeunload = function() {return lang("confirm unload page");};
			}
		} else if (this.preventClose && !prevent) {
			// if this panel prevented closing and now becomes closable
			og.ContentPanel.preventCloseCount--;
			if (!og.ContentPanel.preventCloseCount) {
				window.onbeforeunload = null;
			}
		}
		this.preventClose = prevent;
	},
	
	confirmClose: function() {
		if (this.preventClose) {
			if (!confirm(lang("confirm leave panel"))) {
				return false;
			}
			this.setPreventClose(false);
		}
		return !this.preventClose;
	},

	
	
	
	load: function(content, isBack, isReload, isReset) {
		/*if ( content.data.indexOf("c=customer&a=view") != -1 ) {
			alert("ENTRA a load - content: "+ content.toSource());
		}*/
		if (!this.confirmClose()) {
			if (isBack) {
				// put content back to the history stack
				this.history.push(content);
			}
			return false;
		}
		if (this.content && this.content.onleave) {
			eval(this.content.onleave);
		}
		if (content.type == 'start') {
			if (this.closable) {
				this.ownerCt.remove(this);
			} else {
				this.reset();
			}
			return false;
		} else if (content.type == 'back') {
			if (typeof content.data == 'number') {
				for (var i=0; i < content.data; i++) {
					this.back();
				}
			} else {
				this.back();
			}
			return false;
		} else if (content.type == 'reload') {
			this.reload();
			return false;
		}
		
		
		if (this.content && !isBack && this.content.type != 'url' && !content.replace) {
			var skip = false;
			if (this.content.type == 'html' && (content.type == 'url' || content.type == 'html')) {
				// avoid open twice the same content (open it twice but don't add it to the history stack)
				var url1 = this.content.url;
				var url2 = content.url || content.data;
				if (url1 && url2) {
					url1 = url1.replace(/_dc=[^&]*/g, "");
					url2 = url2.replace(/_dc=[^&]*/g, "");
					if (url1 == url2) {
						skip = true;
					}
				}
			}
			if (!skip) {
				this.history.push(this.content);
			}
		}
		if (typeof content == 'string') {
			content = {
				type: 'html',
				data: content
			}
		}

		this.content = content;
		if (content.makeDefault) {
			this.defaultContent = content;
		}
		if (this.content.type != 'url') {
			var i=0;
			while (this.getComponent(i)) {
				if (this.getComponent(i).doNotRemove) {
					this.getComponent(i).hide();
					i++;
				} else {
					this.remove(this.getComponent(i));
				}
			}
			this.doLayout();
		}
		this.setPreventClose(content.preventClose);		
		if (content.type == 'html') {
			if (this.history.length > 0 && !content.noback) {
				var tbar = [{
					text: lang('back'),
					handler: function() {
						this.back();
					},
					scope: this,
					iconCls: 'ico-back'
				},'-'];
			} else if (this.closable) {
				var tbar = [{
					text: lang('cancel'),
					handler: function() {
						this.ownerCt.remove(this);
					},
					scope: this,
					iconCls: 'ico-back'
				},'-'];
			} else if (content.actions) {
				var tbar = [];
			}
			if (content.actions) {
				for (var i=0; i < content.actions.length; i++) {
					if (content.actions[i].title == '-') {
						tbar.push('-');
					} else {
						tbar.push({
							text: content.actions[i].title,
							handler: function() {
								if (this.url.indexOf('javascript:') == 0) {
									var js = this.url.substring(11);
									eval(js);
								} else {
									if (this.target == '_blank') {
										window.open(this.url);
									} else if (this.target) {
										og.openLink(this.url, {caller: this.target});
									} else {
										og.openLink(this.url);
									}
								}
							},
							scope: content.actions[i],
							iconCls: content.actions[i].name
						});
					}
				}
			}
			if (content.notbar){
				tbar = null;
			}
			var html = content.data
			if (content.inlineScripts && content.inlineScripts.length) {
				var id = Ext.id();
				html += '<span id="' + id + '"></span>';
				Ext.lib.Event.onAvailable(id, function() {
					var start = new Date().getTime();
					for (var inlineScriptContentIterator=0; inlineScriptContentIterator < content.inlineScripts.length; inlineScriptContentIterator++) {
						try {
							if (window.execScript) {
								window.execScript(content.inlineScripts[inlineScriptContentIterator]);
							} else {
								window.eval(content.inlineScripts[inlineScriptContentIterator]);
							}
						} catch (e) {
							og.err(e.message);
						}
					}
					var end = new Date().getTime();
					//og.log("scripits: " + (end - start) + " ms");
					var el = document.getElementById(id);
					if (el) Ext.removeNode(el);
				});
			}
			var p = new og.HtmlPanel({
				html: og.extractScripts(html),
				autoScroll: this.contentAutoScroll,//this.initialConfig.autoScroll,
				tbar: tbar
			});
			this.add(p);
			this.doLayout();
		} else if (content.type == 'url') {
			if (this.active) {
				context_str = "";
				if (og.contextManager && og.contextManager.dimensionMembers.length > 0)
					context_str = "&context=" + escape(og.contextManager.plainContext());
				og.openLink(content.data + context_str, {caller: this, preventSwitch: true});
			} else {
				this.loaded = false;
			}
		} else if (content.type == 'panel') {
			if (!content.panel) {
				for (var i=0; this.getComponent(i) && !content.panel; i++) {
					//alert(i);
					if (this.getComponent(i).getXType() == content.data) {
						// a panel of this type has already been loaded => use it
						
						content.panel = this.getComponent(i);
					}
				}
				if (!content.panel) {
					// create a new panel of the type
					var config = content.config || {};
					config.xtype = content.data || config.xtype;
					if (Ext.ComponentMgr.isRegistered(config.xtype))
						content.panel = Ext.ComponentMgr.create(config);
					else return false;
				} else if (content.config && typeof content.panel.newConfig == 'function') {
					content.panel.newConfig(content.config);
				}
				//content.panel.load();
			}
			if (isReset) {
				if (content.panel) content.panel.reset();
			} else {//if (!isBack) {//if (isReload) {
				if (!isBack || content.data != 'mails-containerpanel') {
					
					//if (content.panel) content.panel.load(); //FIXME Pepe
					if (content.panel.data != "overview") content.panel.load(); //FIXME Pepe
				}
			}

			this.add(content.panel);
			if (content.panel) content.panel.show();
			this.doLayout();
			og.captureLinks(this.id, this);
		} else {
			var html = "<h1>Error: invalid content</h1>";
			html += "<pre>";
			html += og.debug(content);
			html += "</pre>";
			var p = new Ext.Panel({
				html: html,
				autoScroll: true
			});
			this.add(p);
			this.doLayout();
		}
		if (content.type != 'url') {
			this.loaded = true;
		}
		
		og.eventManager.fireEvent("tab loaded", this.id);
		return true;
	},
	
	
	
	
	back: function() {
		var prev = this.history.pop();
		if (!prev) {
			this.load({type: 'start'});
		} else if (prev.type == 'html' && prev.url) {
			this.load({type: 'url', data: prev.url}, true);
		} else { 
			this.load(prev, true, true);
		}
	},
	
	
	
	reload: function() {
    	//og.msg("","reload "+ this.content.toSource(), 15);
		if (this.content.type == 'html' && this.content.url) {
			this.load({type:'url',data:this.content.url}, true);
		} else {
			this.load(this.content, true, true);
		}
	},
	
	
	
	
	reset: function() {

		if (!this.confirmClose()) return;
		this.loaded = false;
		if (this.active) {
			this.load(this.defaultContent, true, true, true);
		}
		this.history = [];
	}
});

og.ContentPanel.preventCloseCount = 0;
/**
 * @author Pepe  elpepe.uy@gmail.com 
 */
og.contextManager  = new function() {
	
	// Public Attributes


	/**
	 * Member Chooser selected members gruped by dimension.
	 * Used to Store the Selected Context - ( Right sidebar trees )
	 * @author Pepe
	 */
	this.lastCheckedMembers = {} ;
	
	/**
	 * Left Panel selected members gruped by dimension.
	 * Used to Store the Global Context - ( Left sidebar trees )
	 * @author Pepe
	 */
    this.dimensionMembers = {} ;
    
    /**
     * Contains info about each dimension abailable for the user. (hidden or not).
     * Array map of {dimension ID : diememsion INFO}
	 * @author Pepe
     */
    this.contextDimensions = {} ;
    
    /**
     * Member choosers
     * Dimension trees (ids) rendered by content type form.
     * (When editing/creating any content object)  
	 * @author Pepe
     */
    this.formDimensionTrees = [];
    
    /**
     * Initialize structure
     * @author Pepe
     */
    this.construct = function () {
    	for (var i = 0 ; i < og.dimensionPanels.length ; i++ ) {
    		if (d = og.dimensionPanels[i] ) {
	    		this.contextDimensions[d.id] = {
	    				id: d.id,
	    				dimensionId: d.dimensionId,
	    				title: d.title,
	    				checked: (d.isRoot) ? true : false 
	    				
	    		} ;    		
    		}
    		
    	}
    }
    
    /**
     * Returns a list of items to be rendered in the dimension Menu (at the top of the dimension panel) 
     */
    this.getDimensionMenu = function () {
    	var menu = [] ;
    	for ( var i in this.contextDimensions ) {
    		if ( i != "remove" ) {
    			var did = this.contextDimensions[i].dimensionId;
    			menu.push({
    				id: "dimension-selector-"+did,
    				text: this.contextDimensions[i].title,
    				checked: this.contextDimensions[i].checked, 
    				dimensionId: this.contextDimensions[i].id,
    				hideOnClick: false,
    				
    				checkHandler: function (item, status){
    					var panel = Ext.getCmp(this.dimensionId) ;
    					if (!status) {
    						panel.removeFromContext();
    					}else{
    						panel.show();
    						panel.expand();
    					}
    					
    					//panel.ownerCt.doLayout();
    					
    				}
    				
    			});
    		}
    	}
    	return menu ;    	
    }
    
    // Public Methods 
    
    /**
     * Add a new member chooser tree id for certain dimension
     */
    this.addFormDimensionTree = function (id, objectType, dimensionId) {
    	if (!this.formDimensionTrees[objectType]) {
    		this.formDimensionTrees[objectType] = [];
    	}  
    	if ( this.formDimensionTrees.indexOf(id)  == -1 ) {
    		this.formDimensionTrees[objectType][dimensionId] = id;
    	}    	
    }
    
    /**
     * Returns a List of MemberChooser tree for 1 dimension
     */
    this.getFormDimensionTrees = function (objectType) {
    	if ( this.formDimensionTrees[objectType] ) {
    		return this.formDimensionTrees[objectType] ;
    	}
    	return null
    }
    
    /**
     * Clean the collection of trees ids 
     */
    this.cleanFormDimensionTrees = function (objectType, dimensionId) {
    	if (this.formDimensionTrees[objectType]) {
    		delete this.formDimensionTrees[objectType][dimensionId] ;
    	} 
    }
    
    
    // ACTIVE MEMBERS
    
    /**
     * Removes all the dimension members from the context structure for certain dimension Id
     */
    this.cleanActiveMembers = function (dimensionId) {
    	if ( dimensionId != undefined ) {
    		delete this.dimensionMembers[dimensionId] ;
    	}      
    }
    
    /**
     * Adds a new member to the context 
     * @param member - integer: memeber id to add
     * @param dimension - integer: dimension id 
     *  
     */
    this.addActiveMember = function ( member , dimension ) {   	
    	
    	if (dimension) {
    		if (!this.dimensionMembers[dimension]) 
    			this.dimensionMembers[dimension] = [] ;
    		if ( this.dimensionMembers[dimension].indexOf(member) == -1)
    			this.dimensionMembers[dimension].push(member) ;
    	}

    }
    
    this.removeActiveMember = function ( member , dimensionId ) {
    	
		if ( this.dimensionMembers[dimensionId] ) {
    	  	var index = this.dimensionMembers[i].indexOf(member) ;
        	if ( index != -1) 
        		delete this.dimensionMembers[i][index]; //TODO break
    	}
    }
    
    this.getDimensionName = function (dimId){
    	return this.contextDimensions["dimension-panel-"+dimId].title;
    }
    
    
    this.getTreeNode = function (dimId, memberId){ 
    	var tree =  Ext.getCmp("dimension-panel-"+dimId);
    	return  tree.getNodeById(memberId);
    	
    }
    

    this.getMemberName = function (dimId, memberId){
    	var node = this.getTreeNode(dimId, memberId) ;
    	if (node) {
    		return node.text ;
    	}else{
    		return "" ;
    	}
    }
    
    this.getMemberPath = function (dimId, memberId) {
    	var path = "" ;
    	var node = this.getTreeNode(dimId, memberId) ;
    	if (node) {
	    	var depth = node.getDepth();
	    	if (depth >= 2 ) {
	    		while ( depth > 1 ){
	    			node  = node.parentNode ;
	    			if (node) {
	    				if (!path) {
	    					path = node.text  ;
	    				}else{
	    					path = node.text + " - " + path;
	    				}
		    			depth-- ;
	    			}
	    		}
	    	}
	    	if (path) {
	    		path = " - " + path ;
	    	}
    	}
    	return path ;
    	
    }
    
    
    /**
     * Returns an array of member ids for certain diemension that are in the context 
     */
    this.getDimensionMembers = function (dimension) {
    	if ( dimension && this.dimensionMembers[dimension] ) return this.dimensionMembers[dimension] ;
    	else if (dimension) return [] ;
    	else return null ;
    }
    
    this.plainActiveMembers = function () {
    	return "["+this.activeMembers.join(",")+"]";
    }

    /**
     * Returns the context on a plain format to be send to the servers. 
     * Format example: {"3":[6,7], "4":[7,8]}
     * Values: 
     * - 0: if 'All' is selected
     * - integer > 0: member id selected
     */
    this.plainContext = function () {
    	return Ext.util.JSON.encode( this.dimensionMembers) ;
    }
    
    /**
     * Returns this list of checked members Grouped by dimension, in JSON FORMAT
     * For certain objectTypeId
     * @params objecteTypeId
     * 
     */
    this.plainCheckedMembers = function (objectTypeId) {
    	return Ext.util.JSON.encode( this.lastCheckedMembers[objectTypeId]) ;
    }
    
    /**
     * Returns this list of checked members Grouped by dimension 
     * For certain objectTypeId
     * @params objecteTypeId
     * 
     */
    this.getCheckedMembers = function (objectTypeId) {
    	return this.lastCheckedMembers[objectTypeId];
    }
    
    this.hasCheckedMembers = function (objectTypeId) {
    	var checked = this.getCheckedMembers(objectTypeId);   	
    	for ( var i  in checked ){
    		if (checked[i].length) return true ;
    	}  
    	return false  ;
    }
    
    /**
     * Reset the list of checked members for one content type
     */
    this.cleanCheckedMembers = function (objectTypeId){
    	this.lastCheckedMembers[objectTypeId] = {};
    }
    
    /**
     * 
     */
    this.addCheckedMember = function (objectTypeId, member, dimension) {
    	if (!this.lastCheckedMembers[objectTypeId]) {
    		this.lastCheckedMembers[objectTypeId] = {} ;
    	}
    	if (!this.lastCheckedMembers[objectTypeId][dimension]) {
    		this.lastCheckedMembers[objectTypeId][dimension] = [];
    	}  
    	if ( this.lastCheckedMembers[objectTypeId][dimension].indexOf(member)  == -1 ) {
    		this.lastCheckedMembers[objectTypeId][dimension].push(member)   ;
    	}    
    }
    
    
    
}




Ext.onReady(function(){

	Ext.get("loading").hide();
		
	// fix cursor not showing on message boxs
	Ext.MessageBox.getDialog().on("show", function(d) {
		var div = Ext.get(d.el);
		div.setStyle("overflow", "auto");
		var text = div.select(".ext-mb-textarea", true);
		if (!text.item(0))
			text = div.select(".ext-mb-text", true);
		if (text.item(0))
			text.item(0).dom.select();
	});

	if (og.preferences['rememberGUIState']) {
		Ext.state.Manager.setProvider(new og.HttpProvider({
			saveUrl: og.getUrl('gui', 'save_state'),
			readUrl: og.getUrl('gui', 'read_state'),
			autoRead: false
		}));
		Ext.state.Manager.getProvider().initState(og.initialGUIState);
	}
	
	Ext.QuickTips.init();
	
	//LOAD PANELS AND ADD TO VIEWPORT
	
	og.openLink(og.getUrl('panel', 'list_all'), {
		
		onSuccess: function(data) {
			var panelData = data['panels'] ;
			og.panels = {} ; // Array Map PANEL_NAME => PANEL
			//alert("antes de viewport") ;
			var panels = [] ; // Array of PANELS ( backguard compatibiliy )
			for (var i = 0 ; i < panelData.length ; i++ ) {		
				var p = new og.ContentPanel(panelData[i]) ;		
				og.panels[p.title] = p ;
				panels.push(p);
				
				
				// Add Plugins to QuickAdd
				var singleId = (p.title.substr(-1) == "s" ) ? p.title.slice(0, -1) : p.title ;
					
				if ( p.type == "plugin" ) {
					quickAdd.menu.add({
						text: p.quickAddTitle,
						iconCls: p.iconCls,
						defaultController: p.defaultController,
						handler: function() {
							var url = og.getUrl(this.defaultController, 'add');
							og.openLink(url);
						}
					});
					
				}
			};
			
			//alert(panels.toSource());
			
			var tab_panel = new Ext.TabPanel({
				id: 'tabs-panel',
				region: 'center',
				activeTab: 0,
				enableTabScroll: true,
			
				items: (panels && panels.length)?panels:null 

			});
			
			var center_panel = new Ext.Panel({
				layout: 'border', 
				id: 'center-panel',
				region:'center',
				enableTabScroll: true,
				items: [
				   	new Ext.Panel({
				   	   id: 'breadcrumbs-panel',	
					   region: 'north', 
					   cls : 'breadcrumbs-container',
					   html: '<div id="breadcrumbs"><h1>'+lang('all customers')+'</h1><ul></ul></div>',
					   expanded: true,
					   collapsed: false ,
					   height: 40,
					   header: false,
					   hideBorders: true ,
					   hideCollapseTool: true,
					   headerAsText: true
				   }),
				   tab_panel
				]
			});
			
		
			// ENABLE / DISABLE MODULES
			og.eventManager.addListener('config option changed', function(option) {
				if (option.name.substring(0, 7) == 'enable_' && option.name.substring(option.name.length - 7) == '_module') {
					var module = option.name.substring(7, option.name.length - 7);
					var tab = tab_panel.id + "__" + og.panels[module].id ;
					Ext.get(tab).setDisplayed(option.value);					
				}
			});
			
			var viewport = new Ext.Viewport({
				layout: 'border',
				stateful: og.preferences['rememberGUIState'],
				items: [
				        new Ext.BoxComponent({
				        	region: 'north',
				        	el: 'header'
				        })
				        ,new Ext.BoxComponent({
				        	region: 'south',
				        	el: 'footer'
				        })
				        ,{
				        	region: 'west',
				        	id: 'menu-panel',
				        	split: true,
				        	width: 242,
				        	//bodyBorder: false,
				        	hideCollapseTool:true,
				        	collapseMode:'mini',
				        	collapsible:true ,
				        	//autoWidth: true,
				        	layout: 'multi-accordion',
				        	layoutConfig: {
				        		// layout-specific configs go here
				        		fill: true,
				        		titleCollapse: true,
				        		animate: true,
				        		maxActiveItems: 3 ,
				        		autoWidth: true
				        	},
				        	stateful: og.preferences['rememberGUIState'],
				        	items:  og.dimensionPanels  ,
				        	bbar : [
				        	    {	
				        			iconCls: 'ico-workspace-edit',
				        			tooltip: '<b>'+lang('filters')+'</b>',
				        			menu: {
				        				items: og.contextManager.getDimensionMenu(),
				        				cls: "context-menu"
				        			}
				        	    },
				        	    '->',
				        	    {	
				        			iconCls: 'ico-trash',
				        			tooltip: lang('trash'),
				        			handler: function() {
					        	    	var cp = Ext.getCmp('trash-panel');
										var tp = Ext.getCmp('tabs-panel');
										if (!cp){
											cp = new og.ContentPanel({
												closable: true,
												title: lang('trash'),
												id: 'trash-panel',
												iconCls: 'ico-trash',
												refreshOnWorkspaceChange: true,
												refreshOnTagChange: true,
												defaultContent: {
													type: "url",
													data: og.getUrl('object', 'init_trash')
												}
											});
											tp.add(cp);
										}
										tp.setActiveTab(cp);
				        			}
				        	    },
				        	    {	
				        			iconCls: 'ico-archive-obj',
				        			tooltip: lang('archived objects'),
				        			handler: function() {
					        	    	var cp = Ext.getCmp('archivedobjs-panel');
										var tp = Ext.getCmp('tabs-panel');
										if (!cp){
											cp = new og.ContentPanel({
												closable: true,
												title: lang('archived objects'),
												id: 'archivedobjs-panel',
												iconCls: 'ico-archive-obj',
												refreshOnWorkspaceChange: true,
												refreshOnTagChange: true,
												defaultContent: {
													type: "url",
													data: og.getUrl('object', 'init_archivedobjs')
												}
											});
											tp.add(cp);
										}
										tp.setActiveTab(cp);
				        			}
				        	    }
				        	]

				        }
				        ,
				        	center_panel
				        ]

			});

			og.captureLinks();

			if (og.preferences['email_polling'] > 0) {
				function updateUnreadCount() {
					og.openLink(og.getUrl('mail', 'get_unread_count'), {
						onSuccess: function(d) {
							if (typeof d.unreadCount != 'undefined') {
								og.updateUnreadEmail(d.unreadCount);
							}
						},
						hideLoading: true,
						hideErrors: true,
						preventPanelLoad: true
					});
				}
				updateUnreadCount();
				setInterval(updateUnreadCount, Math.max(og.preferences['email_polling'], 5000));
			}

			if (og.hasNewVersions) {
				og.msg(lang('new version notification title'), og.hasNewVersions, 0);
			}					

		},
		onError: function(data) {
		}
	});


});
og.sendComment=function(id,ele){
	var comms = $("."+ele).parent().find('textarea').val();
	if(comms!=''){
		var args=[];
		args['object_id']=id;
		jQuery.ajax({
			    url: og.getUrl('comment','add',args),
		    	type: "POST",
                data: {'comment':{'text': comms}},
                success: function(){
                    var path = og.getUrl('dashboard', 'activity_feed', {ajax: true});
                    $.getJSON(path, function(obj)
                        {
                            $('div.activity_feed_loader').html(obj.current.data);
                        }
                    ) 
				}
			});
	}
}
og.sendCommentFromTextBox=function(id,ele,e){
	 var code = (e.keyCode ? e.keyCode : e.which);
	 if(code == 13 && !e.shiftKey) {
		 $(ele).attr("disabled", "disabled"); 
		 var msgid=$(ele).attr("class");
		 var comms =$(ele).val();
		 	comms=comms.replace(/\n/g, "<br />");
			if(comms!=''){
				var args=[];
				args['object_id']=id;
				jQuery.ajax(
                    {
					    url: og.getUrl('comment','add',args),
				    	type: "POST",
		                data: {'comment':{'text': comms}},
		                success: function(data)
                        {
                            var path = og.getUrl('dashboard', 'activity_feed', {ajax: true});
                            $.getJSON(path, function(obj)
                                {
                                    $('div.activity_feed_loader').html(obj.current.data);
                                    $("div.x-panel-body").scrollTo($("."+msgid).siblings('div').children(':last'),800);                                    
                                }
                            )                        
						}
					}
                );
			}
	 }
}
og.commentBoxKeyDown=function(ele,e,id){
	og.sendCommentFromTextBox(id,ele,e);
	if (e.keyCode == 13 && e.shiftKey) {
		 ele.value=(ele.value + "\n");// use the right id here
		 newHeight=parseInt($(ele).css('height'))+15;
		 $(ele).css('height',newHeight+"px");
         return true;

	}else if(e.keyCode==8){
		if($(ele)[0].value.charAt($(ele)[0].value.length-1)=="\n"){
			 newHeight=parseInt($(ele).css('height'))-15;
			 $(ele).css('height',newHeight+"px");
			 ele.rows-=1;
		}
	}
}

ofc_chart = {
	image_binary: function(src) {
		swf_cont = document.getElementById(src);
		swf = null;
		for (i=0; i<swf_cont.childNodes.length; i++) {
			child = swf_cont.childNodes.item(i);
			if (child.id == 'chart' || child.id == 'ie_chart') { swf = child; break; }
		}
		return swf.get_img_binary();
	},
	
	image_tag: function(src) {
		return "<img src='data:image/png;base64," + ofc_chart.image_binary(src) + "' />";
	},
	
  	post_image_from_swf: function(genid, filename) {

  		var form = document.createElement('form');
  		form.method = 'post';
  		form.enctype = 'multipart/form-data';
  		form.encoding = 'multipart/form-data';
  		form.action = og.getUrl('report', 'upload_image');
  		form.style.display = 'none';

  		i_name = document.createElement("input");
  		i_name.type = 'hidden';
  		i_name.name = 'filename';
  		i_name.value = genid + filename;
  		form.appendChild(i_name);
  		
  		i_data = document.createElement("input");
  		i_data.type = 'hidden';
  		i_data.name = 'imgdata';
  		i_data.value = ofc_chart.image_binary(genid);
  		form.appendChild(i_data);
  		
  		document.body.appendChild(form);

  		og.submit(form, {
  	  		hideLoading: true,
  			callback: function() {
  				form.removeChild(input);
  				document.body.removeChild(form);
  			}
  		});
  	}
};
og.Breadcrumbs = {
	
	cmp: null,
		
	status: 0 ,	
	
	items: 0, 
	
	mainDimension: null ,	
	
	collapse: function () {
		this.cmp.collapse(false);
	},
	
	expand: function () {
		this.cmp.expand(false);
	},
	
	resize: function() {
		var cmp = Ext.getCmp("breadcrumbs-panel") ;
		if (this.items == 0) {
			cmp.setHeight(0);
		
		}else if(this.items == 0) {
			cmp.setHeight(30);
		}else{
			cmp.setHeight(45);
		}
		cmp.doLayout();
		
	},
	

	refresh: function (node) {
		// Clean Previews state
		$("#breadcrumbs ul").html("");
		this.items = 0 ;
		
		// Update
		for (i in og.contextManager.dimensionMembers) {
			var member = og.contextManager.dimensionMembers[i];
			var dimId = i ;
			if (member.length ) {
				member = member[0];
				if ( dimId == this.mainDimension ) {
					var mainTitle = lang("All") ;
					var mainPath = "" ;
					if (member > 0) {
						this.items ++ ;
						mainTitle = og.contextManager.getMemberName(dimId, member);
						mainPath = og.contextManager.getMemberPath(dimId, member);
						this.expand();
					}
					if(mainTitle) {
						$("#breadcrumbs h1").html("<em>"+mainTitle+"</em>"+mainPath);
					}
				}else{
					if (member > 0 ) {
						//alert(member);
						memberTitle = og.contextManager.getMemberName(dimId, member);
						dimensionTitle = og.contextManager.getDimensionName(dimId);
						
						if (memberTitle) {
							this.items++;
							var itemClass = "" ;
							if ($('#breadcrumbs ul').children().size() == 0 ){
								itemClass = "first";
							}
							$("#breadcrumbs ul").append("<li class='"+itemClass+"'><strong>"+dimensionTitle+"</strong>: "+memberTitle+"</li>");
							this.expand();
						}
					}
				}
			}
		}
		if (this.items == 0) {
			this.collapse();
		}
		
		// Show div if was hidden 
		/*
		if ($("#breadcrumbs").is(":hidden")) $("#breadcrumbs").slideDown('slow', function(){
			
			// Resize Ext Components - Ext do no fire automatically this ! ! 
			//var bcHeight =$("#breadcrumbs").height() + 53   ; // 10 px padding ?
			var bcHeight = 100 ;
			var tp = Ext.getCmp("tabs-panel") ;
			var tpSize = tp.getSize();
			tpSize.height = tpSize.height - bcHeight ;
			tp.setSize(tpSize);
		});
		*/
		
		
		//
	},
		
}
/*
 * HTML5 Forms Chapter JavaScript Library
 * http://thecssninja.com/javascript/H5F
 *
 * Copyright (c) 2010-2011 Ryan Seddon - http://thecssninja.com/
 * Dual-licensed under the BSD and MIT licenses.
 * http://thecssninja.com/H5F/license.txt
 */
var H5F=H5F||{};(function(d){var field=d.createElement("input"),emailPatt=/^[a-z0-9_.%+\-]+@[0-9a-z.\-]+\.[a-z.]{2,6}$/i,urlPatt=/[a-z][\-\.+a-z]*:\/\//i,nodes=/^(input|select|textarea)$/i,isSubmit,usrPatt,curEvt,args,custMsg="",setup,validation,validity,checkField,checkValidity,setCustomValidity,support,pattern,placeholder,range,required,valueMissing,listen,unlisten,preventActions,getTarget,addClass,removeClass,isHostMethod;setup=function(form,settings){var isCollection=!form.nodeType||false;var opts={validClass:"valid",invalidClass:"error",requiredClass:"required",placeholderClass:"placeholder"};if(typeof settings=="object"){for(var i in opts){if(typeof settings[i]=="undefined"){settings[i]=opts[i];}}}
args=settings||opts;if(isCollection){for(var k=0,len=form.length;k<len;k++){validation(form[k]);}}else{validation(form);}};validation=function(form){var f=form.elements,flen=f.length,isRequired,noValidate=!!(form.attributes["novalidate"]);listen(form,"invalid",checkField,true);listen(form,"blur",checkField,true);listen(form,"input",checkField,true);listen(form,"keyup",checkField,true);listen(form,"focus",checkField,true);listen(form,"submit",function(e){isSubmit=true;if(!noValidate&&!form.checkValidity()){preventActions(e);}},false);if(!support()){form.checkValidity=function(){return checkValidity(form);};while(flen--){isRequired=!!(f[flen].attributes["required"]);if(f[flen].nodeName!=="FIELDSET"){validity(f[flen]);}}}};validity=function(el){var elem=el,missing=valueMissing(elem),attrs={type:elem.getAttribute("type"),pattern:elem.getAttribute("pattern"),placeholder:elem.getAttribute("placeholder")},isType=/^(email|url)$/i,evt=/^(input|keyup)$/i,fType=((isType.test(attrs.type))?attrs.type:((attrs.pattern)?attrs.pattern:false)),patt=pattern(elem,fType),step=range(elem,"step"),min=range(elem,"min"),max=range(elem,"max"),customError=(custMsg!=="");elem.checkValidity=function(){return checkValidity.call(this,elem);};elem.setCustomValidity=function(msg){setCustomValidity.call(elem,msg);};elem.validationMessage=custMsg;elem.validity={valueMissing:missing,patternMismatch:patt,rangeUnderflow:min,rangeOverflow:max,stepMismatch:step,customError:customError,valid:(!missing&&!patt&&!step&&!min&&!max&&!customError)};if(attrs.placeholder&&!evt.test(curEvt)){placeholder(elem);}};checkField=function(e){var el=getTarget(e)||e,events=/^(input|keyup|focusin|focus)$/i,ignoredTypes=/^(submit|image|button|reset)$/i,checkForm=true;if(nodes.test(el.nodeName)&&!(ignoredTypes.test(el.type)||ignoredTypes.test(el.nodeName))){curEvt=e.type;if(!support()){validity(el);}
if(el.validity.valid){removeClass(el,[args.invalidClass,args.requiredClass]);addClass(el,args.validClass);}else if(!events.test(curEvt)){if(el.validity.valueMissing){removeClass(el,[args.invalidClass,args.validClass]);addClass(el,args.requiredClass);}else{removeClass(el,[args.validClass,args.requiredClass]);addClass(el,args.invalidClass);}}else if(el.validity.valueMissing){removeClass(el,[args.requiredClass,args.invalidClass,args.validClass]);}
if(curEvt==="input"&&checkForm){unlisten(el.form,"keyup",checkField,true);checkForm=false;}}};checkValidity=function(el){var f,ff,isRequired,hasPattern,invalid=false;if(el.nodeName==="FORM"){f=el.elements;for(var i=0,len=f.length;i<len;i++){ff=f[i];isRequired=!!(ff.attributes["required"]);hasPattern=!!(ff.attributes["pattern"]);if(ff.nodeName!=="FIELDSET"&&(isRequired||hasPattern&&isRequired)){checkField(ff);if(!ff.validity.valid&&!invalid){if(isSubmit){ff.focus();}
invalid=true;}}}
return!invalid;}else{checkField(el);return el.validity.valid;}};setCustomValidity=function(msg){var el=this;custMsg=msg;el.validationMessage=custMsg;};support=function(){return(isHostMethod(field,"validity")&&isHostMethod(field,"checkValidity"));};pattern=function(el,type){if(type==="email"){return!emailPatt.test(el.value);}else if(type==="url"){return!urlPatt.test(el.value);}else if(!type){return false;}else{var placeholder=el.getAttribute("placeholder"),val=el.value;usrPatt=new RegExp('^(?:'+type+')$');if(val===placeholder){return true;}else if(val===""){return false;}else{return!usrPatt.test(el.value);}}};placeholder=function(el){var attrs={placeholder:el.getAttribute("placeholder")},focus=/^(focus|focusin|submit)$/i,node=/^(input|textarea)$/i,ignoredType=/^password$/i,isNative=!!("placeholder"in field);if(!isNative&&node.test(el.nodeName)&&!ignoredType.test(el.type)){if(el.value===""&&!focus.test(curEvt)){el.value=attrs.placeholder;listen(el.form,'submit',function(){curEvt='submit';placeholder(el);},true);addClass(el,args.placeholderClass);}else if(el.value===attrs.placeholder&&focus.test(curEvt)){el.value="";removeClass(el,args.placeholderClass);}}};range=function(el,type){var min=parseInt(el.getAttribute("min"),10)||0,max=parseInt(el.getAttribute("max"),10)||false,step=parseInt(el.getAttribute("step"),10)||1,val=parseInt(el.value,10),mismatch=(val-min)%step;if(!valueMissing(el)&&!isNaN(val)){if(type==="step"){return(el.getAttribute("step"))?(mismatch!==0):false;}else if(type==="min"){return(el.getAttribute("min"))?(val<min):false;}else if(type==="max"){return(el.getAttribute("max"))?(val>max):false;}}else if(el.getAttribute("type")==="number"){return true;}else{return false;}};required=function(el){var required=!!(el.attributes["required"]);return(required)?valueMissing(el):false;};valueMissing=function(el){var placeholder=el.getAttribute("placeholder"),isRequired=!!(el.attributes["required"]);return!!(isRequired&&(el.value===""||el.value===placeholder));};listen=function(node,type,fn,capture){if(isHostMethod(window,"addEventListener")){node.addEventListener(type,fn,capture);}else if(isHostMethod(window,"attachEvent")&&typeof window.event!=="undefined"){if(type==="blur"){type="focusout";}else if(type==="focus"){type="focusin";}
node.attachEvent("on"+type,fn);}};unlisten=function(node,type,fn,capture){if(isHostMethod(window,"removeEventListener")){node.removeEventListener(type,fn,capture);}else if(isHostMethod(window,"detachEvent")&&typeof window.event!=="undefined"){node.detachEvent("on"+type,fn);}};preventActions=function(evt){evt=evt||window.event;if(evt.stopPropagation&&evt.preventDefault){evt.stopPropagation();evt.preventDefault();}else{evt.cancelBubble=true;evt.returnValue=false;}};getTarget=function(evt){evt=evt||window.event;return evt.target||evt.srcElement;};addClass=function(e,c){var re;if(!e.className){e.className=c;}
else{re=new RegExp('(^|\\s)'+c+'(\\s|$)');if(!re.test(e.className)){e.className+=' '+c;}}};removeClass=function(e,c){var re,m,arr=(typeof c==="object")?c.length:1,len=arr;if(e.className){if(e.className==c){e.className='';}
else{while(arr--){re=new RegExp('(^|\\s)'+((len>1)?c[arr]:c)+'(\\s|$)');m=e.className.match(re);if(m&&m.length==3){e.className=e.className.replace(re,(m[1]&&m[2])?' ':'');}}}}};isHostMethod=function(o,m){var t=typeof o[m],reFeaturedMethod=new RegExp('^function|object$','i');return!!((reFeaturedMethod.test(t)&&o[m])||t=='unknown');};window["H5F"]={setup:setup};})(document);
$(function(){
	
	/**
	 * Close quick add boxes
	 */
	$('#quick-form .close').click(function(){
		$(this).parent().slideUp();
	});
	
	/**
	 * Hide floating boxes clicking ouside them
	 */
	$('body').click( function (e) {
		var toClose = ['#quick-form', '.user-box-actions' ] ; // Array of selectors (CSS like)
		var ignoreClick = ["#userboxWrapper"]; // Array of containers to ignore Click
		var clicked =  $(e.target) ;
		if (!clicked[0]) return;
		
		for (var  i in ignoreClick ) {
			if (  i == "remove" || !ignoreClick[i] ) continue ;
			var toIgnore = $(ignoreClick[i]);
			if (!toIgnore[0] || jQuery.contains(toIgnore[0],clicked[0])) return ;
		}
		
		for ( var i in toClose ) {
			if (  i == "remove" || !toClose[i] ) continue ;
			var box = $( toClose[i]) ; 
			if ( box[0] && !jQuery.contains(box[0],clicked[0]) ){
				box.slideUp();
			}
		}
	});
	
	
	
});
