/*
 * Ext JS Library 2.0.1
 * Copyright(c) 2006-2007, Ext JS, LLC.
 * licensing@extjs.com
 * 
 * http://extjs.com/license
 */

YAHOO.util.Connect={_msxml_progid:["MSXML2.XMLHTTP.3.0","MSXML2.XMLHTTP","Microsoft.XMLHTTP"],_http_headers:{},_has_http_headers:false,_use_default_post_header:true,_default_post_header:"application/x-www-form-urlencoded",_use_default_xhr_header:true,_default_xhr_header:"XMLHttpRequest",_has_default_headers:true,_default_headers:{},_isFormSubmit:false,_isFileUpload:false,_formNode:null,_sFormData:null,_poll:{},_timeOut:{},_polling_interval:50,_transaction_id:0,setProgId:function(A){this._msxml_progid.unshift(A)},setDefaultPostHeader:function(A){this._use_default_post_header=A},setDefaultXhrHeader:function(A){this._use_default_xhr_header=A},setPollingInterval:function(A){if(typeof A=="number"&&isFinite(A)){this._polling_interval=A}},createXhrObject:function(E){var D,A;try{A=new XMLHttpRequest();D={conn:A,tId:E}}catch(C){for(var B=0;B<this._msxml_progid.length;++B){try{A=new ActiveXObject(this._msxml_progid[B]);D={conn:A,tId:E};break}catch(C){}}}finally{return D}},getConnectionObject:function(){var B;var C=this._transaction_id;try{B=this.createXhrObject(C);if(B){this._transaction_id++}}catch(A){}finally{return B}},asyncRequest:function(E,B,D,A){var C=this.getConnectionObject();if(!C){return null}else{if(this._isFormSubmit){if(this._isFileUpload){this.uploadFile(C.tId,D,B,A);this.releaseObject(C);return }if(E.toUpperCase()=="GET"){if(this._sFormData.length!=0){B+=((B.indexOf("?")==-1)?"?":"&")+this._sFormData}else{B+="?"+this._sFormData}}else{if(E.toUpperCase()=="POST"){A=A?this._sFormData+"&"+A:this._sFormData}}}C.conn.open(E,B,true);if(this._use_default_xhr_header){if(!this._default_headers["X-Requested-With"]){this.initHeader("X-Requested-With",this._default_xhr_header,true)}}if(this._isFormSubmit||(A&&this._use_default_post_header)){this.initHeader("Content-Type",this._default_post_header);if(this._isFormSubmit){this.resetFormState()}}if(this._has_default_headers||this._has_http_headers){this.setHeader(C)}this.handleReadyState(C,D);C.conn.send(A||null);return C}},handleReadyState:function(B,C){var A=this;if(C&&C.timeout){this._timeOut[B.tId]=window.setTimeout(function(){A.abort(B,C,true)},C.timeout)}this._poll[B.tId]=window.setInterval(function(){if(B.conn&&B.conn.readyState==4){window.clearInterval(A._poll[B.tId]);delete A._poll[B.tId];if(C&&C.timeout){delete A._timeOut[B.tId]}A.handleTransactionResponse(B,C)}},this._polling_interval)},handleTransactionResponse:function(E,F,A){if(!F){this.releaseObject(E);return }var C,B;try{if(E.conn.status!==undefined&&E.conn.status!=0){C=E.conn.status}else{C=13030}}catch(D){C=13030}if(C>=200&&C<300){B=this.createResponseObject(E,F.argument);if(F.success){if(!F.scope){F.success(B)}else{F.success.apply(F.scope,[B])}}}else{switch(C){case 12002:case 12029:case 12030:case 12031:case 12152:case 13030:B=this.createExceptionObject(E.tId,F.argument,(A?A:false));if(F.failure){if(!F.scope){F.failure(B)}else{F.failure.apply(F.scope,[B])}}break;default:B=this.createResponseObject(E,F.argument);if(F.failure){if(!F.scope){F.failure(B)}else{F.failure.apply(F.scope,[B])}}}}this.releaseObject(E);B=null},createResponseObject:function(A,G){var D={};var I={};try{var C=A.conn.getAllResponseHeaders();var F=C.split("\n");for(var E=0;E<F.length;E++){var B=F[E].indexOf(":");if(B!=-1){I[F[E].substring(0,B)]=F[E].substring(B+2)}}}catch(H){}D.tId=A.tId;D.status=A.conn.status;D.statusText=A.conn.statusText;D.getResponseHeader=I;D.getAllResponseHeaders=C;D.responseText=A.conn.responseText;D.responseXML=A.conn.responseXML;if(typeof G!==undefined){D.argument=G}return D},createExceptionObject:function(H,D,A){var F=0;var G="communication failure";var C=-1;var B="transaction aborted";var E={};E.tId=H;if(A){E.status=C;E.statusText=B}else{E.status=F;E.statusText=G}if(D){E.argument=D}return E},initHeader:function(A,D,C){var B=(C)?this._default_headers:this._http_headers;if(B[A]===undefined){B[A]=D}else{B[A]=D+","+B[A]}if(C){this._has_default_headers=true}else{this._has_http_headers=true}},setHeader:function(A){if(this._has_default_headers){for(var B in this._default_headers){if(YAHOO.lang.hasOwnProperty(this._default_headers,B)){A.conn.setRequestHeader(B,this._default_headers[B])}}}if(this._has_http_headers){for(var B in this._http_headers){if(YAHOO.lang.hasOwnProperty(this._http_headers,B)){A.conn.setRequestHeader(B,this._http_headers[B])}}delete this._http_headers;this._http_headers={};this._has_http_headers=false}},resetDefaultHeaders:function(){delete this._default_headers;this._default_headers={};this._has_default_headers=false},setForm:function(J,E,B){this.resetFormState();var I;if(typeof J=="string"){I=(document.getElementById(J)||document.forms[J])}else{if(typeof J=="object"){I=J}else{return }}if(E){this.createFrame(B?B:null);this._isFormSubmit=true;this._isFileUpload=true;this._formNode=I;return }var A,H,F,K;var G=false;for(var D=0;D<I.elements.length;D++){A=I.elements[D];K=I.elements[D].disabled;H=I.elements[D].name;F=I.elements[D].value;if(!K&&H){switch(A.type){case"select-one":case"select-multiple":for(var C=0;C<A.options.length;C++){if(A.options[C].selected){if(window.ActiveXObject){this._sFormData+=encodeURIComponent(H)+"="+encodeURIComponent(A.options[C].attributes["value"].specified?A.options[C].value:A.options[C].text)+"&"}else{this._sFormData+=encodeURIComponent(H)+"="+encodeURIComponent(A.options[C].hasAttribute("value")?A.options[C].value:A.options[C].text)+"&"}}}break;case"radio":case"checkbox":if(A.checked){this._sFormData+=encodeURIComponent(H)+"="+encodeURIComponent(F)+"&"}break;case"file":case undefined:case"reset":case"button":break;case"submit":if(G==false){this._sFormData+=encodeURIComponent(H)+"="+encodeURIComponent(F)+"&";G=true}break;default:this._sFormData+=encodeURIComponent(H)+"="+encodeURIComponent(F)+"&";break}}}this._isFormSubmit=true;this._sFormData=this._sFormData.substr(0,this._sFormData.length-1);return this._sFormData},resetFormState:function(){this._isFormSubmit=false;this._isFileUpload=false;this._formNode=null;this._sFormData=""},createFrame:function(A){var B="yuiIO"+this._transaction_id;if(window.ActiveXObject){var C=document.createElement("<iframe id=\""+B+"\" name=\""+B+"\" />");if(typeof A=="boolean"){C.src="javascript:false"}else{if(typeof secureURI=="string"){C.src=A}}}else{var C=document.createElement("iframe");C.id=B;C.name=B}C.style.position="absolute";C.style.top="-1000px";C.style.left="-1000px";document.body.appendChild(C)},appendPostData:function(A){var D=[];var B=A.split("&");for(var C=0;C<B.length;C++){var E=B[C].indexOf("=");if(E!=-1){D[C]=document.createElement("input");D[C].type="hidden";D[C].name=B[C].substring(0,E);D[C].value=B[C].substring(E+1);this._formNode.appendChild(D[C])}}return D},uploadFile:function(A,I,C,B){var F="yuiIO"+A;var G="multipart/form-data";var H=document.getElementById(F);this._formNode.action=C;this._formNode.method="POST";this._formNode.target=F;if(this._formNode.encoding){this._formNode.encoding=G}else{this._formNode.enctype=G}if(B){var J=this.appendPostData(B)}this._formNode.submit();if(J&&J.length>0){for(var E=0;E<J.length;E++){this._formNode.removeChild(J[E])}}this.resetFormState();var D=function(){var L={};L.tId=A;L.argument=I.argument;try{L.responseText=H.contentWindow.document.body?H.contentWindow.document.body.innerHTML:null;L.responseXML=H.contentWindow.document.XMLDocument?H.contentWindow.document.XMLDocument:H.contentWindow.document}catch(K){}if(I&&I.upload){if(!I.scope){I.upload(L)}else{I.upload.apply(I.scope,[L])}}if(YAHOO.util.Event){YAHOO.util.Event.removeListener(H,"load",D)}else{if(window.detachEvent){H.detachEvent("onload",D)}else{H.removeEventListener("load",D,false)}}setTimeout(function(){document.body.removeChild(H)},100)};if(YAHOO.util.Event){YAHOO.util.Event.addListener(H,"load",D)}else{if(window.attachEvent){H.attachEvent("onload",D)}else{H.addEventListener("load",D,false)}}},abort:function(B,C,A){if(this.isCallInProgress(B)){B.conn.abort();window.clearInterval(this._poll[B.tId]);delete this._poll[B.tId];if(A){delete this._timeOut[B.tId]}this.handleTransactionResponse(B,C,true);return true}else{return false}},isCallInProgress:function(A){if(A.conn){return A.conn.readyState!=4&&A.conn.readyState!=0}else{return false}},releaseObject:function(A){A.conn=null;A=null}};YAHOO.register("connection",YAHOO.widget.Module,{version:"2.2.0",build:"127"});