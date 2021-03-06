/**
 *  catch javascript exceptions when updating an element with "scripts: true"
 *  	so that the callback function is executed anyways
 */
Ext.Element.prototype.update = function(html, loadScripts, callback){
    if(typeof html == "undefined"){
        html = "";
    }
    if(loadScripts !== true){
        this.dom.innerHTML = html;
        if(typeof callback == "function"){
            callback();
        }
        return this;
    }
    var id = Ext.id();
    var dom = this.dom;

    html += '<span id="' + id + '"></span>';

    Ext.lib.Event.onAvailable(id, function(){
        var hd = document.getElementsByTagName("head")[0];
        var re = /(?:<script([^>]*)?>)((\n|\r|.)*?)(?:<\/script>)/ig;
        var srcRe = /\ssrc=([\'\"])(.*?)\1/i;
        var typeRe = /\stype=([\'\"])(.*?)\1/i;

        var match;
        try {
	        while(match = re.exec(html)){
	            var attrs = match[1];
	            var srcMatch = attrs ? attrs.match(srcRe) : false;
	            if(srcMatch && srcMatch[2]){
	               var s = document.createElement("script");
	               s.src = srcMatch[2];
	               var typeMatch = attrs.match(typeRe);
	               if(typeMatch && typeMatch[2]){
	                   s.type = typeMatch[2];
	               }
	               hd.appendChild(s);
	            }else if(match[2] && match[2].length > 0){
	                if(window.execScript) {
	                   window.execScript(match[2]);
	                } else {
	                   window.eval(match[2]);
	                }
	            }
	        }
	    } catch (e) {
	    	alert("" + e);
	    }
        var el = document.getElementById(id);
        if(el){Ext.removeNode(el);}
        if(typeof callback == "function"){
            callback();
        }
    });
    dom.innerHTML = html.replace(/(?:<script.*?>)((\n|\r|.)*?)(?:<\/script>)/ig, "");
    return this;
}