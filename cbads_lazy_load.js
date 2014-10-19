function addListenerCB(obj,type,listener){if (obj.addEventListener){obj.addEventListener(type,listener,false);return true;}else if(obj.attachEvent){obj.attachEvent('on'+type,listener);return true;}return false;}
addListenerCB(window,'scroll',function(){showCbads();})
addListenerCB(window,'resize',function(){showCbads();})
addListenerCB(window,'load',function(){showCbads();})

function getCoordsCB(elem){
    var box=elem.getBoundingClientRect();
    var body=document.body;
    var docElem=document.documentElement;
    var scrollTop=window.pageYOffset || docElem.scrollTop || body.scrollTop;
    var scrollLeft=window.pageXOffset || docElem.scrollLeft || body.scrollLeft;
    var clientTop=docElem.clientTop || body.clientTop || 0;
    var clientLeft=docElem.clientLeft || body.clientLeft || 0;
    return {top: Math.round(box.top+scrollTop-clientTop),left: Math.round(box.left+scrollLeft-clientLeft)};
}
function isVisibleCB(elem){
	var coords=getCoordsCB(elem);
	coords.bottom=coords.top+elem.offsetHeight;
	var windowTop=(window.pageYOffset || document.documentElement.scrollTop)-100;
	var windowBottom=windowTop+document.documentElement.clientHeight+300;
	return (coords.top<windowBottom && coords.bottom>windowTop);
}
var cbads=0;
function showCbads(){if(cbads==0){cbads=setTimeout("showCbads2()",200)}}
function showCbads2(){
	var tgs=document.getElementsByTagName('iframe');cbads=0;
	for(var i=0;i<tgs.length;i++){tgt=tgs[i];var src1=tgt.getAttribute('data-src');if(src1 && isVisibleCB(tgt)){tgt.src=src1;tgt.setAttribute('data-src','');}}
}
