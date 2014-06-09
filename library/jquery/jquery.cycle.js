/*
 * jQuery Cycle Plugin (core engine)
 * Examples and documentation at: http://jquery.malsup.com/cycle/
 * Copyright (c) 2007-2010 M. Alsup
 * Version: 2.88 (08-JUN-2010)
 * Dual licensed under the MIT and GPL licenses.
 * http://jquery.malsup.com/license.html
 * Requires: jQuery v1.2.6 or later
 */
(function($){var ver="2.88";if($.support==undefined){$.support={opacity:!($.browser.msie)};}$.fn.cycle=function(options,arg2){var o={s:this.selector,c:this.context};if(this.length===0&&options!="stop"){if(!$.isReady&&o.s){$(function(){$(o.s,o.c).cycle(options,arg2);});return this;}return this;}return this.each(function(){var opts=handleArguments(this,options,arg2);if(opts===false){return;}opts.updateActivePagerLink=opts.updateActivePagerLink||$.fn.cycle.updateActivePagerLink;if(this.cycleTimeout){clearTimeout(this.cycleTimeout);}this.cycleTimeout=this.cyclePause=0;var $cont=$(this);var $slides=opts.slideExpr?$(opts.slideExpr,this):$cont.children();var els=$slides.get();if(els.length<2){return;}var opts2=buildOptions($cont,$slides,els,opts,o);if(opts2===false){return;}var startTime=opts2.continuous?10:getTimeout(els[opts2.currSlide],els[opts2.nextSlide],opts2,!opts2.rev);if(startTime){startTime+=(opts2.delay||0);if(startTime<10){startTime=10;}this.cycleTimeout=setTimeout(function(){go(els,opts2,0,(!opts2.rev&&!opts.backwards));},startTime);}});};function handleArguments(cont,options,arg2){if(cont.cycleStop==undefined){cont.cycleStop=0;}if(options===undefined||options===null){options={};}if(options.constructor==String){switch(options){case"destroy":case"stop":var opts=$(cont).data("cycle.opts");if(!opts){return false;}cont.cycleStop++;if(cont.cycleTimeout){clearTimeout(cont.cycleTimeout);}cont.cycleTimeout=0;$(cont).removeData("cycle.opts");if(options=="destroy"){destroy(opts);}return false;case"toggle":cont.cyclePause=(cont.cyclePause===1)?0:1;checkInstantResume(cont.cyclePause,arg2,cont);return false;case"pause":cont.cyclePause=1;return false;case"resume":cont.cyclePause=0;checkInstantResume(false,arg2,cont);return false;case"prev":case"next":var opts=$(cont).data("cycle.opts");if(!opts){return false;}$.fn.cycle[options](opts);return false;default:options={fx:options};}return options;}else{if(options.constructor==Number){var num=options;options=$(cont).data("cycle.opts");if(!options){return false;}if(num<0||num>=options.elements.length){return false;}options.nextSlide=num;if(cont.cycleTimeout){clearTimeout(cont.cycleTimeout);cont.cycleTimeout=0;}if(typeof arg2=="string"){options.oneTimeFx=arg2;}go(options.elements,options,1,num>=options.currSlide);return false;}}return options;function checkInstantResume(isPaused,arg2,cont){if(!isPaused&&arg2===true){var options=$(cont).data("cycle.opts");if(!options){return false;}if(cont.cycleTimeout){clearTimeout(cont.cycleTimeout);cont.cycleTimeout=0;}go(options.elements,options,1,(!opts.rev&&!opts.backwards));}}}function removeFilter(el,opts){if(!$.support.opacity&&opts.cleartype&&el.style.filter){try{el.style.removeAttribute("filter");}catch(smother){}}}function destroy(opts){if(opts.next){$(opts.next).unbind(opts.prevNextEvent);}if(opts.prev){$(opts.prev).unbind(opts.prevNextEvent);}if(opts.pager||opts.pagerAnchorBuilder){$.each(opts.pagerAnchors||[],function(){this.unbind().remove();});}opts.pagerAnchors=null;if(opts.destroy){opts.destroy(opts);}}function buildOptions($cont,$slides,els,options,o){var opts=$.extend({},$.fn.cycle.defaults,options||{},$.metadata?$cont.metadata():$.meta?$cont.data():{});if(opts.autostop){opts.countdown=opts.autostopCount||els.length;}var cont=$cont[0];$cont.data("cycle.opts",opts);opts.$cont=$cont;opts.stopCount=cont.cycleStop;opts.elements=els;opts.before=opts.before?[opts.before]:[];opts.after=opts.after?[opts.after]:[];opts.after.unshift(function(){opts.busy=0;});if(!$.support.opacity&&opts.cleartype){opts.after.push(function(){removeFilter(this,opts);});}if(opts.continuous){opts.after.push(function(){go(els,opts,0,(!opts.rev&&!opts.backwards));});}saveOriginalOpts(opts);if(!$.support.opacity&&opts.cleartype&&!opts.cleartypeNoBg){clearTypeFix($slides);}if($cont.css("position")=="static"){$cont.css("position","relative");}if(opts.width){$cont.width(opts.width);}if(opts.height&&opts.height!="auto"){$cont.height(opts.height);}if(opts.startingSlide){opts.startingSlide=parseInt(opts.startingSlide);}else{if(opts.backwards){opts.startingSlide=els.length-1;}}if(opts.random){opts.randomMap=[];for(var i=0;i<els.length;i++){opts.randomMap.push(i);}opts.randomMap.sort(function(a,b){return Math.random()-0.5;});opts.randomIndex=1;opts.startingSlide=opts.randomMap[1];}else{if(opts.startingSlide>=els.length){opts.startingSlide=0;}}opts.currSlide=opts.startingSlide||0;var first=opts.startingSlide;$slides.css({position:"absolute",top:0,left:0}).hide().each(function(i){var z;if(opts.backwards){z=first?i<=first?els.length+(i-first):first-i:els.length-i;}else{z=first?i>=first?els.length-(i-first):first-i:els.length-i;}$(this).css("z-index",z);});$(els[first]).css("opacity",1).show();removeFilter(els[first],opts);if(opts.fit&&opts.width){$slides.width(opts.width);}if(opts.fit&&opts.height&&opts.height!="auto"){$slides.height(opts.height);}var reshape=opts.containerResize&&!$cont.innerHeight();if(reshape){var maxw=0,maxh=0;for(var j=0;j<els.length;j++){var $e=$(els[j]),e=$e[0],w=$e.outerWidth(),h=$e.outerHeight();if(!w){w=e.offsetWidth||e.width||$e.attr("width");}if(!h){h=e.offsetHeight||e.height||$e.attr("height");}maxw=w>maxw?w:maxw;maxh=h>maxh?h:maxh;}if(maxw>0&&maxh>0){$cont.css({width:maxw+"px",height:maxh+"px"});}}if(opts.pause){$cont.hover(function(){this.cyclePause++;},function(){this.cyclePause--;});}if(supportMultiTransitions(opts)===false){return false;}var requeue=false;options.requeueAttempts=options.requeueAttempts||0;$slides.each(function(){var $el=$(this);this.cycleH=(opts.fit&&opts.height)?opts.height:($el.height()||this.offsetHeight||this.height||$el.attr("height")||0);this.cycleW=(opts.fit&&opts.width)?opts.width:($el.width()||this.offsetWidth||this.width||$el.attr("width")||0);if($el.is("img")){var loadingIE=($.browser.msie&&this.cycleW==28&&this.cycleH==30&&!this.complete);var loadingFF=($.browser.mozilla&&this.cycleW==34&&this.cycleH==19&&!this.complete);var loadingOp=($.browser.opera&&((this.cycleW==42&&this.cycleH==19)||(this.cycleW==37&&this.cycleH==17))&&!this.complete);var loadingOther=(this.cycleH==0&&this.cycleW==0&&!this.complete);if(loadingIE||loadingFF||loadingOp||loadingOther){if(o.s&&opts.requeueOnImageNotLoaded&&++options.requeueAttempts<100){setTimeout(function(){$(o.s,o.c).cycle(options);},opts.requeueTimeout);requeue=true;return false;}}}return true;});if(requeue){return false;}opts.cssBefore=opts.cssBefore||{};opts.animIn=opts.animIn||{};opts.animOut=opts.animOut||{};$slides.not(":eq("+first+")").css(opts.cssBefore);if(opts.cssFirst){$($slides[first]).css(opts.cssFirst);}if(opts.timeout){opts.timeout=parseInt(opts.timeout);if(opts.speed.constructor==String){opts.speed=$.fx.speeds[opts.speed]||parseInt(opts.speed);}if(!opts.sync){opts.speed=opts.speed/2;}var buffer=opts.fx=="shuffle"?500:250;while((opts.timeout-opts.speed)<buffer){opts.timeout+=opts.speed;}}if(opts.easing){opts.easeIn=opts.easeOut=opts.easing;}if(!opts.speedIn){opts.speedIn=opts.speed;}if(!opts.speedOut){opts.speedOut=opts.speed;}opts.slideCount=els.length;opts.currSlide=opts.lastSlide=first;if(opts.random){if(++opts.randomIndex==els.length){opts.randomIndex=0;}opts.nextSlide=opts.randomMap[opts.randomIndex];}else{if(opts.backwards){opts.nextSlide=opts.startingSlide==0?(els.length-1):opts.startingSlide-1;}else{opts.nextSlide=opts.startingSlide>=(els.length-1)?0:opts.startingSlide+1;}}if(!opts.multiFx){var init=$.fn.cycle.transitions[opts.fx];if($.isFunction(init)){init($cont,$slides,opts);}else{if(opts.fx!="custom"&&!opts.multiFx){return false;}}}var e0=$slides[first];if(opts.before.length){opts.before[0].apply(e0,[e0,e0,opts,true]);}if(opts.after.length>1){opts.after[1].apply(e0,[e0,e0,opts,true]);}if(opts.next){$(opts.next).bind(opts.prevNextEvent,function(){return advance(opts,opts.rev?-1:1);});}if(opts.prev){$(opts.prev).bind(opts.prevNextEvent,function(){return advance(opts,opts.rev?1:-1);});}if(opts.pager||opts.pagerAnchorBuilder){buildPager(els,opts);}exposeAddSlide(opts,els);return opts;}function saveOriginalOpts(opts){opts.original={before:[],after:[]};opts.original.cssBefore=$.extend({},opts.cssBefore);opts.original.cssAfter=$.extend({},opts.cssAfter);opts.original.animIn=$.extend({},opts.animIn);opts.original.animOut=$.extend({},opts.animOut);$.each(opts.before,function(){opts.original.before.push(this);});$.each(opts.after,function(){opts.original.after.push(this);});}function supportMultiTransitions(opts){var i,tx,txs=$.fn.cycle.transitions;if(opts.fx.indexOf(",")>0){opts.multiFx=true;opts.fxs=opts.fx.replace(/\s*/g,"").split(",");for(i=0;i<opts.fxs.length;i++){var fx=opts.fxs[i];tx=txs[fx];if(!tx||!txs.hasOwnProperty(fx)||!$.isFunction(tx)){opts.fxs.splice(i,1);i--;}}if(!opts.fxs.length){return false;}}else{if(opts.fx=="all"){opts.multiFx=true;opts.fxs=[];for(p in txs){tx=txs[p];if(txs.hasOwnProperty(p)&&$.isFunction(tx)){opts.fxs.push(p);}}}}if(opts.multiFx&&opts.randomizeEffects){var r1=Math.floor(Math.random()*20)+30;for(i=0;i<r1;i++){var r2=Math.floor(Math.random()*opts.fxs.length);opts.fxs.push(opts.fxs.splice(r2,1)[0]);}}return true;}function exposeAddSlide(opts,els){opts.addSlide=function(newSlide,prepend){var $s=$(newSlide),s=$s[0];if(!opts.autostopCount){opts.countdown++;}els[prepend?"unshift":"push"](s);if(opts.els){opts.els[prepend?"unshift":"push"](s);}opts.slideCount=els.length;$s.css("position","absolute");$s[prepend?"prependTo":"appendTo"](opts.$cont);if(prepend){opts.currSlide++;opts.nextSlide++;}if(!$.support.opacity&&opts.cleartype&&!opts.cleartypeNoBg){clearTypeFix($s);}if(opts.fit&&opts.width){$s.width(opts.width);}if(opts.fit&&opts.height&&opts.height!="auto"){$slides.height(opts.height);}s.cycleH=(opts.fit&&opts.height)?opts.height:$s.height();s.cycleW=(opts.fit&&opts.width)?opts.width:$s.width();$s.css(opts.cssBefore);if(opts.pager||opts.pagerAnchorBuilder){$.fn.cycle.createPagerAnchor(els.length-1,s,$(opts.pager),els,opts);}if($.isFunction(opts.onAddSlide)){opts.onAddSlide($s);}else{$s.hide();}};}$.fn.cycle.resetState=function(opts,fx){fx=fx||opts.fx;opts.before=[];opts.after=[];opts.cssBefore=$.extend({},opts.original.cssBefore);opts.cssAfter=$.extend({},opts.original.cssAfter);opts.animIn=$.extend({},opts.original.animIn);opts.animOut=$.extend({},opts.original.animOut);opts.fxFn=null;$.each(opts.original.before,function(){opts.before.push(this);});$.each(opts.original.after,function(){opts.after.push(this);});var init=$.fn.cycle.transitions[fx];if($.isFunction(init)){init(opts.$cont,$(opts.elements),opts);}};function go(els,opts,manual,fwd){if(manual&&opts.busy&&opts.manualTrump){$(els).stop(true,true);opts.busy=false;}if(opts.busy){return;}var p=opts.$cont[0],curr=els[opts.currSlide],next=els[opts.nextSlide];if(p.cycleStop!=opts.stopCount||p.cycleTimeout===0&&!manual){return;}if(!manual&&!p.cyclePause&&!opts.bounce&&((opts.autostop&&(--opts.countdown<=0))||(opts.nowrap&&!opts.random&&opts.nextSlide<opts.currSlide))){if(opts.end){opts.end(opts);}return;}var changed=false;if((manual||!p.cyclePause)&&(opts.nextSlide!=opts.currSlide)){changed=true;var fx=opts.fx;curr.cycleH=curr.cycleH||$(curr).height();curr.cycleW=curr.cycleW||$(curr).width();next.cycleH=next.cycleH||$(next).height();next.cycleW=next.cycleW||$(next).width();if(opts.multiFx){if(opts.lastFx==undefined||++opts.lastFx>=opts.fxs.length){opts.lastFx=0;}fx=opts.fxs[opts.lastFx];opts.currFx=fx;}if(opts.oneTimeFx){fx=opts.oneTimeFx;opts.oneTimeFx=null;}$.fn.cycle.resetState(opts,fx);if(opts.before.length){$.each(opts.before,function(i,o){if(p.cycleStop!=opts.stopCount){return;}o.apply(next,[curr,next,opts,fwd]);});}var after=function(){$.each(opts.after,function(i,o){if(p.cycleStop!=opts.stopCount){return;}o.apply(next,[curr,next,opts,fwd]);});};opts.busy=1;if(opts.fxFn){opts.fxFn(curr,next,opts,after,fwd,manual&&opts.fastOnEvent);}else{if($.isFunction($.fn.cycle[opts.fx])){$.fn.cycle[opts.fx](curr,next,opts,after,fwd,manual&&opts.fastOnEvent);}else{$.fn.cycle.custom(curr,next,opts,after,fwd,manual&&opts.fastOnEvent);}}}if(changed||opts.nextSlide==opts.currSlide){opts.lastSlide=opts.currSlide;if(opts.random){opts.currSlide=opts.nextSlide;if(++opts.randomIndex==els.length){opts.randomIndex=0;}opts.nextSlide=opts.randomMap[opts.randomIndex];if(opts.nextSlide==opts.currSlide){opts.nextSlide=(opts.currSlide==opts.slideCount-1)?0:opts.currSlide+1;}}else{if(opts.backwards){var roll=(opts.nextSlide-1)<0;if(roll&&opts.bounce){opts.backwards=!opts.backwards;opts.nextSlide=1;opts.currSlide=0;}else{opts.nextSlide=roll?(els.length-1):opts.nextSlide-1;opts.currSlide=roll?0:opts.nextSlide+1;}}else{var roll=(opts.nextSlide+1)==els.length;if(roll&&opts.bounce){opts.backwards=!opts.backwards;opts.nextSlide=els.length-2;opts.currSlide=els.length-1;}else{opts.nextSlide=roll?0:opts.nextSlide+1;opts.currSlide=roll?els.length-1:opts.nextSlide-1;}}}}if(changed&&opts.pager){opts.updateActivePagerLink(opts.pager,opts.currSlide,opts.activePagerClass);}var ms=0;if(opts.timeout&&!opts.continuous){ms=getTimeout(els[opts.currSlide],els[opts.nextSlide],opts,fwd);}else{if(opts.continuous&&p.cyclePause){ms=10;}}if(ms>0){p.cycleTimeout=setTimeout(function(){go(els,opts,0,(!opts.rev&&!opts.backwards));},ms);}}$.fn.cycle.updateActivePagerLink=function(pager,currSlide,clsName){$(pager).each(function(){$(this).children().removeClass(clsName).eq(currSlide).addClass(clsName);});};function getTimeout(curr,next,opts,fwd){if(opts.timeoutFn){var t=opts.timeoutFn.call(curr,curr,next,opts,fwd);while((t-opts.speed)<250){t+=opts.speed;}if(t!==false){return t;}}return opts.timeout;}$.fn.cycle.next=function(opts){advance(opts,opts.rev?-1:1);};$.fn.cycle.prev=function(opts){advance(opts,opts.rev?1:-1);};function advance(opts,val){var els=opts.elements;var p=opts.$cont[0],timeout=p.cycleTimeout;if(timeout){clearTimeout(timeout);p.cycleTimeout=0;}if(opts.random&&val<0){opts.randomIndex--;if(--opts.randomIndex==-2){opts.randomIndex=els.length-2;}else{if(opts.randomIndex==-1){opts.randomIndex=els.length-1;}}opts.nextSlide=opts.randomMap[opts.randomIndex];}else{if(opts.random){opts.nextSlide=opts.randomMap[opts.randomIndex];}else{opts.nextSlide=opts.currSlide+val;if(opts.nextSlide<0){if(opts.nowrap){return false;}opts.nextSlide=els.length-1;}else{if(opts.nextSlide>=els.length){if(opts.nowrap){return false;}opts.nextSlide=0;}}}}var cb=opts.onPrevNextEvent||opts.prevNextClick;if($.isFunction(cb)){cb(val>0,opts.nextSlide,els[opts.nextSlide]);}go(els,opts,1,val>=0);return false;}function buildPager(els,opts){var $p=$(opts.pager);$.each(els,function(i,o){$.fn.cycle.createPagerAnchor(i,o,$p,els,opts);});opts.updateActivePagerLink(opts.pager,opts.startingSlide,opts.activePagerClass);}$.fn.cycle.createPagerAnchor=function(i,el,$p,els,opts){var a;if($.isFunction(opts.pagerAnchorBuilder)){a=opts.pagerAnchorBuilder(i,el);}else{a='<a href="#">'+(i+1)+"</a>";}if(!a){return;}var $a=$(a);if($a.parents("body").length===0){var arr=[];if($p.length>1){$p.each(function(){var $clone=$a.clone(true);$(this).append($clone);arr.push($clone[0]);});$a=$(arr);}else{$a.appendTo($p);}}opts.pagerAnchors=opts.pagerAnchors||[];opts.pagerAnchors.push($a);$a.bind(opts.pagerEvent,function(e){e.preventDefault();opts.nextSlide=i;var p=opts.$cont[0],timeout=p.cycleTimeout;if(timeout){clearTimeout(timeout);p.cycleTimeout=0;}var cb=opts.onPagerEvent||opts.pagerClick;if($.isFunction(cb)){cb(opts.nextSlide,els[opts.nextSlide]);}go(els,opts,1,opts.currSlide<i);});if(!/^click/.test(opts.pagerEvent)&&!opts.allowPagerClickBubble){$a.bind("click.cycle",function(){return true;});}if(opts.pauseOnPagerHover){$a.hover(function(){opts.$cont[0].cyclePause++;},function(){opts.$cont[0].cyclePause--;});}};$.fn.cycle.hopsFromLast=function(opts,fwd){var hops,l=opts.lastSlide,c=opts.currSlide;if(fwd){hops=c>l?c-l:opts.slideCount-l;}else{hops=c<l?l-c:l+opts.slideCount-c;}return hops;};function clearTypeFix($slides){function hex(s){s=parseInt(s).toString(16);return s.length<2?"0"+s:s;}function getBg(e){for(;e&&e.nodeName.toLowerCase()!="html";e=e.parentNode){var v=$.css(e,"background-color");if(v.indexOf("rgb")>=0){var rgb=v.match(/\d+/g);return"#"+hex(rgb[0])+hex(rgb[1])+hex(rgb[2]);}if(v&&v!="transparent"){return v;}}return"#ffffff";}$slides.each(function(){$(this).css("background-color",getBg(this));});}$.fn.cycle.commonReset=function(curr,next,opts,w,h,rev){$(opts.elements).not(curr).hide();opts.cssBefore.opacity=1;opts.cssBefore.display="block";if(w!==false&&next.cycleW>0){opts.cssBefore.width=next.cycleW;}if(h!==false&&next.cycleH>0){opts.cssBefore.height=next.cycleH;}opts.cssAfter=opts.cssAfter||{};opts.cssAfter.display="none";$(curr).css("zIndex",opts.slideCount+(rev===true?1:0));$(next).css("zIndex",opts.slideCount+(rev===true?0:1));};$.fn.cycle.custom=function(curr,next,opts,cb,fwd,speedOverride){var $l=$(curr),$n=$(next);var speedIn=opts.speedIn,speedOut=opts.speedOut,easeIn=opts.easeIn,easeOut=opts.easeOut;$n.css(opts.cssBefore);if(speedOverride){if(typeof speedOverride=="number"){speedIn=speedOut=speedOverride;}else{speedIn=speedOut=1;}easeIn=easeOut=null;}var fn=function(){$n.animate(opts.animIn,speedIn,easeIn,cb);};$l.animate(opts.animOut,speedOut,easeOut,function(){if(opts.cssAfter){$l.css(opts.cssAfter);}if(!opts.sync){fn();}});if(opts.sync){fn();}};$.fn.cycle.transitions={fade:function($cont,$slides,opts){$slides.not(":eq("+opts.currSlide+")").css("opacity",0);opts.before.push(function(curr,next,opts){$.fn.cycle.commonReset(curr,next,opts);opts.cssBefore.opacity=0;});opts.animIn={opacity:1};opts.animOut={opacity:0};opts.cssBefore={top:0,left:0};}};$.fn.cycle.ver=function(){return ver;};$.fn.cycle.defaults={fx:"fade",timeout:4000,timeoutFn:null,continuous:0,speed:1000,speedIn:null,speedOut:null,next:null,prev:null,onPrevNextEvent:null,prevNextEvent:"click.cycle",pager:null,onPagerEvent:null,pagerEvent:"click.cycle",allowPagerClickBubble:false,pagerAnchorBuilder:null,before:null,after:null,end:null,easing:null,easeIn:null,easeOut:null,shuffle:null,animIn:null,animOut:null,cssBefore:null,cssAfter:null,fxFn:null,height:"auto",startingSlide:0,sync:1,random:0,fit:0,containerResize:1,pause:0,pauseOnPagerHover:0,autostop:0,autostopCount:0,delay:0,slideExpr:null,cleartype:!$.support.opacity,cleartypeNoBg:false,nowrap:0,fastOnEvent:0,randomizeEffects:1,rev:0,manualTrump:true,requeueOnImageNotLoaded:true,requeueTimeout:250,activePagerClass:"activeSlide",updateActivePagerLink:null,backwards:false};$.fn.cycle.transitions.scrollHorz=function($cont, $slides, opts){$cont.css('overflow','hidden').width();opts.before.push(function(curr, next, opts, fwd){$.fn.cycle.commonReset(curr,next,opts);opts.cssBefore.left=fwd?(next.cycleW-1):(1-next.cycleW);opts.animOut.left = fwd ? -curr.cycleW : curr.cycleW;});opts.cssFirst={left:0};opts.cssBefore={top:0};opts.animIn={left:0};opts.animOut={top:0};};})(jQuery);
/**
* hoverIntent r5 // 2007.03.27 // jQuery 1.1.2+
* <http://cherne.net/brian/resources/jquery.hoverIntent.html>
* 
* @param  f  onMouseOver function || An object with configuration options
* @param  g  onMouseOut function  || Nothing (use configuration options object)
* @author    Brian Cherne <brian@cherne.net>
*/
(function($){$.fn.hoverIntent=function(f,g){var cfg={sensitivity:7,interval:100,timeout:0};cfg=$.extend(cfg,g?{over:f,out:g}:f);var cX,cY,pX,pY;var track=function(ev){cX=ev.pageX;cY=ev.pageY;};var compare=function(ev,ob){ob.hoverIntent_t=clearTimeout(ob.hoverIntent_t);if((Math.abs(pX-cX)+Math.abs(pY-cY))<cfg.sensitivity){$(ob).unbind("mousemove",track);ob.hoverIntent_s=1;return cfg.over.apply(ob,[ev]);}else{pX=cX;pY=cY;ob.hoverIntent_t=setTimeout(function(){compare(ev,ob);},cfg.interval);}};var delay=function(ev,ob){ob.hoverIntent_t=clearTimeout(ob.hoverIntent_t);ob.hoverIntent_s=0;return cfg.out.apply(ob,[ev]);};var handleHover=function(e){var p=(e.type=="mouseover"?e.fromElement:e.toElement)||e.relatedTarget;while(p&&p!=this){try{p=p.parentNode;}catch(e){p=this;}}if(p==this){return false;}var ev=jQuery.extend({},e);var ob=this;if(ob.hoverIntent_t){ob.hoverIntent_t=clearTimeout(ob.hoverIntent_t);}if(e.type=="mouseover"){pX=ev.pageX;pY=ev.pageY;$(ob).bind("mousemove",track);if(ob.hoverIntent_s!=1){ob.hoverIntent_t=setTimeout(function(){compare(ev,ob);},cfg.interval);}}else{$(ob).unbind("mousemove",track);if(ob.hoverIntent_s==1){ob.hoverIntent_t=setTimeout(function(){delay(ev,ob);},cfg.timeout);}}};return this.mouseover(handleHover).mouseout(handleHover);};})(jQuery);
(function($){var cache=[];$.preLoadImages=function(){var args_len=arguments.length;for (var i=args_len;i--;){var cacheImage=document.createElement('img');cacheImage.src=arguments[i];cache.push(cacheImage);}}})(jQuery);
/*
 * Postcode anywhere functions
 */
 
var _postcode_fieldset = false
var _vzPlayer = false;

function vzaarPlayerReady() 
{
    _vzPlayer = document.getElementById('video');
}


function PostcodeAnywhere_Interactive_Find_v1_10End(response)
{
  	//Test for an error
	if (response.length==1 && typeof(response[0].Error) == 'undefined') {
		$('.add2,.add4',_postcode_fieldset).val('');
		$('.add1',_postcode_fieldset).val(response[0].StreetAddress);
		$('.add3',_postcode_fieldset).val(response[0].Place);
	 }
	 else {
		 alert('Sorry, no matching items found');
	 }
}
/*
 * Silkstream functions
 */
function getSelectedSize()
{
	var _size = $('#size span').text();
	var _sizes = $('#sizes a.opt span');
	var _i = 0;
	for (_i=0;_i<_sizes.length;_i++)
	{
		if($(_sizes[_i]).text() == _size) return _i;
	}
	return false;
}

function getSelectedQuantity()
{
	var _qty = $('#quantity span').text();
	var _quantities = $('#quantities a.opt span');
	var _i = 0;
	for (_i=0;_i<_quantities.length;_i++)
	{
		if($(_quantities[_i]).text() == _qty) return _i;
	}
	return false;
}

function updatePriceMatrix()
{
	var _table = $('#comparePrices .priceMatrix');
	
	$('td',_table).removeClass('high').removeClass('sel');
	
	var _x = getSelectedSize()+1;
	var _y = getSelectedQuantity()+1;
	
	$('tr',_table).each(function(_i,_tr)
	{
		if (_i < _y)
		{
			$('td:eq('+_x+')',_tr).addClass('high');
		}
		else if (_i == _y)
		{
			$('td:lt('+_x+')',_tr).addClass('high');
			$('td:eq('+_x+')',_tr).addClass('sel').find('a').first().map(function(){$('#basketTotal span.price').text($(this).text());});
		}
		else
		{
			return false;
		}
	});
}

function fasterPopup(_flag)
{
	if ($('#fasterPopup').length == 0)
	{
		$('#contentArea').append('<div id="fasterPopup" class="modalPopup" style="display: none;"><div></div><div class="closeModal"><a href="#">Close Window</a></div></div>');

		$('#fasterPopup a').click(function()
		{
			$('#fasterPopup').hide();
			return false;
		});
	}
	
	$.getJSON('/ajax.php?do='+_flag, function(_data) 
	{
		if (_data.ok == 1)
		{
			$('#fasterPopup').find('div:first').html(_data.content).end().fadeIn('fast');
		}
	});
	
	var _title = $('#product>h1').text();
	var _gevent = false;
	switch (_flag)
	{
		case 'fasterInfo':
			_gevent = 'Need it faster';
		break;
		
		case 'sizePopup':
			_gevent = 'Size not found';
		break;

		case 'qtyPopup':
			_gevent = 'Quantity not found';
		break;
	}
	
	if (_gevent)
	{
		_gaq.push(['_trackEvent', _gevent, _title, 'Click']);
	}

	return false;
}

function updatePrices()
{
	var _id = $('#option span').text();
	
	var _fd = 0;
	var _sd = 0;
	
	var _toggle = $('#toggleFolding');
	if (_toggle.length == 1 && _toggle.hasClass('on')) _fd = 1;
		
	var _toggle = $('#toggleSides');
	if (_toggle.length == 1 && _toggle.hasClass('on')) _sd = 1;
	
	$.getJSON('/ajax.php?do=prices&id='+_id+'&fd='+_fd+'&sd='+_sd, function(_data) 
	{
		if (_data.ok == 1)
		{
			$('#sizes').html(_data.sizes);
			$('#quantities').html(_data.quantities);
		
			if (getSelectedSize() === false) $('#size').html($('#sizes li a.opt:first').html());
			if (getSelectedQuantity() === false) $('#quantity').html($('#quantities li a.opt:first').html());
			$('#deliveryInfo span.london strong.highlight').text(_data.london_del);
			$('#deliveryInfo span.mainland strong.highlight').text(_data.uk_del);
			$('#comparePrices table.priceMatrix').replaceWith(_data.matrix);
			updatePriceMatrix();
			updateTooltips();
		}
		_data = '';
	});
}

function updateTooltips()
{
	$('.st').hoverIntent(function()
	{
		var _this = $(this);
		var _id = _this.attr('id');
		var _pos = _this.position();
		var _tmp = _id.split('_');
		if (_tmp.length == 2)
		{
			if ($('#tt'+_id).length == 0)
			{
				_this.append('<div id="tt'+_id+'" class="tooltip" style="display: none;"></div>');
			}
			$.getJSON('/ajax.php?do='+_tmp[0]+'&id='+_tmp[1]+'&el='+_id, function(_data) 
			{
				if (_data.ok == 1 && _data.content.length > 10)
				{
					$('#tt'+_data.el).html(_data.content).fadeIn('slow');
				}
			});
		}
	},function()
	{
		$('.tooltip:visible').fadeOut('slow');
	});
}

var _tick = false;
var _token = '';

if (swfobject) swfobject.registerObject("deliveryVan", "8.0.0", "/js/expressInstall.swf");

$(document).ready(function()
{
	$('#tbxSearch')
	.focus(function(){if($(this).select().val() == 'Search for products...') $(this).val('');})
	.blur(function(){if($(this).val() == '') $(this).val('Search for products...');})
	.autocomplete({source: '/ajax.php?do=autosearch', minLength: 1, select: function(_event, _ui) {if (_ui && _ui.item) {window.location.href =  _ui.item.link;}}});
	
	$('#featured').cycle(
	{
		fx:'fade', 
		timeout: 6000, 
		delay:  -2000,
		pagerEvent: 'mouseover',
		pauseOnPagerHover: true,
		pager:  '#tabs ul',
		pagerAnchorBuilder: function(_idx, _slide) 
		{
			return '#tabs ul li:eq(' + (_idx) + ') a';
   		},
		
		before: function(_currSlideElement, _nextSlideElement, _options, _forwardFlag)
		{
			$('div.progress',_nextSlideElement).stop(true).css('width','0px');
		},
		after: function(_currSlideElement, _nextSlideElement, _options, _forwardFlag)
		{
			if (_options && _options.$cont[0])
			{
				if (_options.$cont[0].cyclePause < 1)
				{
					$('div.progress',_nextSlideElement).animate({width:'488'},5500);
				}
				else
				{
					$('div.progress').stop(true).css('width','0px');
				}
			}
			
		}
  	});
	
	$('#workedFor div').cycle({ 
		fx:    'fade', 
		speed:  2000 
 	});
	
	$('#blogPosts').cycle({
		fx: 'scrollHorz', 
		timeout:  0,
		speed:    500, 
		next:    '#next1'
	});

	$('#tnsContainer').cycle({
		fx: 'scrollHorz', 
		timeout:  0,
		speed:    500, 
		prev:    '#tnsLeft',
		next:    '#tnsRight',
		cleartypeNoBg: true
	});
	
	$('#proVideoLink').click(function() {
		$('#proImage').hide();
		$('#proVideo').show();
		return false;
	});

	$('#proImageLink').click(function() {
		if (_vzPlayer)
		{
			_vzPlayer.pause();
		}
		$('#proVideo').hide();
		$('#proImage').show();
		$('.cloud-zoom, .cloud-zoom-gallery').CloudZoom();
		return false;
	});

	
	$('<a />', {'href': '#', 'html':'Show more…', 'class': 'readMore', 'click': function() {
       $('#contentAreaMain .more:hidden').slideDown();
	   $(this).remove();
	   return false;
	}}).insertBefore('#contentAreaMain .more');

	$('<button />', {'html':'Click to Find', 'click': function() {
															   
	   var _pc = $(this).next().val();
	   _postcode_fieldset = $(this).closest('fieldset');
	   
	   if (_pc.length > 4) {
		   
		   var _script = document.createElement('script'), _head = document.getElementsByTagName('head')[0], _url = "https://services.postcodeanywhere.co.uk/PostcodeAnywhere/Interactive/Find/v1.10/json.ws?";
		   
		   // Build the query string
		   _url += "&Key=" + encodeURIComponent('DZ75-BW99-MA26-XN95');
		   _url += "&SearchTerm=" + encodeURIComponent(_pc);
		   _url += "&CallbackFunction=PostcodeAnywhere_Interactive_Find_v1_10End";
		   
		   _script.src = _url;
		   
		   // Make the request
		   _script.onload = _script.onreadystatechange = function () {
			   if (!this.readyState || this.readyState === 'loaded' || this.readyState === 'complete') {
				   _script.onload = _script.onreadystatechange = null;
				   if (_head && _script.parentNode) {
					   _head.removeChild(_script);
				   }
			   }
		   }
			
		   _head.insertBefore(_script, _head.firstChild);
		   return false;
	   }
	}}).insertBefore('li.inputPC input');
 
	$('#mainImage img:first').wrap(function() 
	{
		return '<a id="zoom1" rel="position: \'inside\' , showTitle: false" class="cloud-zoom" href="'+$(this).attr('src').replace('s.jpg','.jpg')+'"></a>';
	});

	$('#mainImagetn img').wrap(function() 
	{
		var _src = $(this).attr('src')
		return '<a rel="useZoom: \'zoom1\' , smallImage: \''+_src.replace('t.jpg','s.jpg')+'\'" class="cloud-zoom-gallery" href="'+_src.replace('t.jpg','.jpg')+'"></a>';
	});
	
	$('#headerNav a.sub').parent().hoverIntent(function()
	{
		$(this).addClass('hover');
	},function()
	{
		$(this).removeClass('hover');
	});

	$('#thumbs .tns a').hoverIntent(function()
	{
		$(this).css('z-index','9999');
		$('span.tip',this).fadeIn('fast');
	},function()
	{
		$(this).css('z-index','9997');
		$('span.tip',this).hide();
	});

	if (window.location.toString().indexOf('artwork-options') === -1)
	{
		$('#browseProducts').hoverIntent({
		over: function() {$(this).addClass('hover');},
     	timeout: 500, 
     	out: function() {$(this).removeClass('hover');}
		});
	}

	$('#browseProductsLink').click(function(_event)
	{
		$(this).parent().toggleClass('click');
		return false;
	});
	
	$('.queueDelete').live('click',function()
	{
		var _this = $(this);
		var _id = _this.attr('id').substr(2);
		_swfu.cancelUpload(_id);
		_this.hide();
		_this.parent().css('text-decoration','line-through');
		return false;
	});

	if ($('#uploadArea').length == 1)
	{
		var _token = $('#token').val();
		_swfu = new SWFUpload({ upload_url : '/uploads/upload.php', 
								flash_url : '/swfupload.swf', 
								file_size_limit : '200 MB', 
								post_params: {'PHPSESSID' : _token},
								button_image_url: '/images/artwork_upload.png',
								file_queued_handler : function(_file) 
								{
									$('#uploadArea div.queue ul').append('<li><img id="qd'+_file.id+'" class="queueDelete" src="/images/icon_del_tiny.png" title="Remove from queue">'+_file.name+'</li>');
									$('#uploadArea div.queue ul li.none').remove();
									$('#uploadSpacer:hidden').show(); 
									$('#uploadArea a.upload:hidden').css('display','block').click(function()
									{
										var _stats = _swfu.getStats();
										if (_stats.files_queued > 0)
										{
											$('#uploadArea div.queue').before('<div id="fsUploadProgress"><div></div></div><div id="fsUploadFilename"></div><p />');
											_swfu.startUpload();
										}
										else
										{
											window.location = '/basket.html';
										}
										return false;
									});
								},
								file_dialog_complete_handler: function(_file) {},
								swfupload_load_failed_handler: function() 
								{
									$('#niceUpload').hide();
									$('#oldUpload').show();
								},
								upload_progress_handler: function(_file, _bytesLoaded, _bytesTotal) 
								{
									var _p = Math.ceil((_bytesLoaded / _bytesTotal) * 100);
									if (_p >= 0 && _p <= 100)
									{
										var _w = 5.79 * _p;
										$('#fsUploadProgress div').width(_w+'px');
									}										
								},
								upload_start_handler: function(_file) {$('#fsUploadFilename').text('Uploading '+_file.name);},
								upload_complete_handler: function(_file) 
								{
									var _stats = _swfu.getStats();
									if (_stats.files_queued > 0)
									{
										_swfu.startUpload();
									}
									else
									{
										window.location = '/basket.html';
									}
								},
								debug: false,
								button_width: '205',
								button_window_mode: 'transparent',
								button_height: '48',
								button_placeholder_id: 'spanButtonPlaceHolder'}); 
	  
	}
	
	$('#requireArtwork').click(function(_event)
	{
		$('#requireArea').slideDown('');
		return false;
	});
	
	$('#addtoBasket').click(function(_event)
	{
		var _val = '';
		var _toggle = '';

		$('#productForm form input').each(function()
		{
			switch (this.name)
			{
				case 'id':
					_val = $('#option span').text();
				break;

				case 'sz':
					_val = $('#size span').text();
				break;

				case 'qt':
					_val = $('#quantity span').text();
				break;
				
				case 'fd':
					_val = '';
					_toggle = $('#toggleFolding');
					if (_toggle.length == 1 && _toggle.hasClass('on')) _val = 1;
				break;

				case 'sd':
					_val = '';
					_toggle = $('#toggleSides');
					if (_toggle.length == 1 && _toggle.hasClass('on')) _val = 1;
				break;

				default:
					_val = $(this).val();
				break;
			}

			$(this).val(_val);
		});
		
		$('#productForm form').submit();
		return false;
	});
	
	$('.teamDepartment>a').click(function()
	{
		var _a = $(this);
		var _div = _a.next();
		$('.teamDepartment>a').removeClass('on');
		if (_div.hasClass('teamHidden'))
		{
			$('.teamDepartment>div').not('.teamHidden').slideUp('fast',function()
			{
				$(this).addClass('teamHidden').removeClass('on');
			});
			
			_div.slideDown('fast',function()
			{
				$(this).removeClass('teamHidden');
				 var _dest = _a.addClass('on').offset().top;
				 $('html:not(:animated),body:not(:animated)').animate({ scrollTop: _dest},300); 
			});
		}
		return false;
	});
	
	$('#filterOptions a').click(function()
	{
		var _this = $(this);
		if (!_this.hasClass('on'))
		{
			if (this.id == 'list')
			{
				$('#thumb').removeClass('on');
				$('#content').removeClass('thumbs').addClass('linear');
			}
			else
			{
				$('#list').removeClass('on');
				$('#content').removeClass('linear').addClass('thumbs');
			}
			_this.addClass('on');
		}
		return false;
	});
	
	$('body').click(function(_event)
	{
		$('#options,#sizes,#quantities').hide();
		$('#browseProducts').removeClass('click');
	});
	
	$('#productForm').click(function(_event)
	{
		var _target = $(_event.target);
		
		if (_target.hasClass('toggle'))
		{
			$(_target).toggleClass('on');
			updatePrices(false);
		}
		else if (_target.hasClass('opt'))
		{
			var _id = _target.attr('id');
			var _sizes = $('#sizes');
			var _quantities = $('#quantities');
			var _options = $('#options');
		
			switch (_id)
			{
				case 'option':
					_sizes.hide();
					_quantities.hide();
					if (_options.is(':hidden')) {_options.fadeIn('fast');} else {_options.hide();}
				break;
	
				case 'size':
					_options.hide();
					_quantities.hide();
					if (_sizes.is(':hidden')) {_sizes.fadeIn('fast');} else {_sizes.hide();}
				break;
	
				case 'quantity':
					_options.hide();
					_sizes.hide();
					if (_quantities.is(':hidden')) {_quantities.fadeIn('fast');} else {_quantities.hide();}
				break;
				
				default:
					_options.hide();
					_sizes.hide();
					_quantities.hide();
					var _div = _target.closest('div').attr('id');
					switch (_div)
					{
						case 'options':
							$('#option').html(_target.html());
							updatePrices(true);
						break;

						case 'sizes':
							$('#size').html(_target.html());
							updatePriceMatrix();
						break;
						
						case 'quantities':
							$('#quantity').html(_target.html());
							updatePriceMatrix();
						break;
					}
				break;
			}

			return false;
		}
	});
	
	if ($('#countDown').length)
	{
		var _spans = $('#countDown span');
		if (_spans.length == 3)
		{
			_spans[0] = $(_spans[0]);
			_spans[1] = $(_spans[1]);
			_spans[2] = $(_spans[2]);
			var _hrs = parseInt(_spans[0].text(),10);
			var _mins = parseInt(_spans[1].text(),10);
			var _secs = parseInt(_spans[2].text(),10);

			_tick = setInterval (function()
			{
				_secs -= 1;
				if (_secs < 0) {_secs=59;_mins-=1;}
				if (_mins < 0) {_secs=0;_mins=59;_hrs-=1;}
				if (_hrs < 0) 
				{
					// End of timer
					$('#deliveryInfo').fadeOut();
					clearInterval(_tick);
				}
				else
				{
					_spans[0].text(_hrs);
					
					_spans[1].text((_mins < 10) ? '0'+_mins : _mins);
					_spans[2].text((_secs < 10) ? '0'+_secs : _secs);
				}
			}, 1000 );
		}
	}

	$('#requireArea form').submit(function()
	{
		var _this = $(this);
		if (!_this.data('_flag'))
		{
			_ta = $('textarea',_this);
			if (_ta.val().length == 0)
			{
				_ta.val('Please enter your requirements').focus(function()
				{
					if ($(this).val() == 'Please enter your requirements') $(this).val('').parent().removeClass('error');
				}).parent().addClass('error');
				_this.data('_flag',1);
				return false;
			}
		}
		return true;
	});
	
	$('#comparePrices table.priceMatrix').live('click',function(_event)
	{
		var _target = $(_event.target);
		var _href = _target.attr('href');

		var _toggle = $('#toggleFolding');
		if (_toggle.length == 1 && _toggle.hasClass('on')) _href += '&f=1';

		_toggle = $('#toggleSides');
		if (_toggle.length == 1 && _toggle.hasClass('on')) _href += '&s=1';
		
		_target.attr('href',_href);
		
		return true;
	});
	
	$('#checkoutArea').find('select.qtySelect').change(function(_event)
	{
		var _this = $(this);
		var _uniqid = _this.closest('tr').attr('id');
		var _id = _this.val();
		
		$.getJSON('/ajax.php?do=basketQty&uniqid='+_uniqid+'&id='+_id, function(_data) 
		{
			if (_data.ok == 1)
			{
				var _tr = $('#'+_data.uniqid);
				if (_tr.length == 1)
				{
					_tr.find('.rowVat').html(_data.vatRate);
					_tr.find('.rowPrice').html(_data.cost);
					$('#basketVat').html(_data.vatTotal);
					$('#basketSubtotal').html(_data.subtotal);
					$('#basketTotal').html(_data.total);
					if (_data.discount.length > 0)
					{
						$('#basketDiscount').html(_data.discount).parent().show();
					}
					else
					{
						$('#basketDiscount').parent().hide();
					}
				}
			}
			_data = '';
		});
	});

	$('#checkoutArea').find('td.rowDel img').click(function(_event)
	{
		if (confirm('Are you sure you want to remove this item from your basket?\nYou will also lose any uploaded files.'))
		{
			var _this = $(this);
			var _uniqid = _this.closest('tr').attr('id');
			
			$.getJSON('/ajax.php?do=basketDelete&uniqid='+_uniqid, function(_data) 
			{
				if (_data.ok == 1)
				{
					$('#'+_data.uniqid).fadeOut('fast');
					$('#basketVat').html(_data.vatTotal);
					$('#basketSubtotal').html(_data.subtotal);
					$('#basketTotal').html(_data.total);
					if (_data.discount.length > 0)
					{
						$('#basketDiscount').html(_data.discount).parent().show();
					}
					else
					{
						$('#basketDiscount').parent().hide();
					}
					
					$('#basketItems').find('span.counter').text(_data.count);
				}
				_data = '';
			});
		}
		return false;
	});
	
	$('#deliveryInfo .london img, #londonMap').click(function()
	{
		if ($('#deliveryPopup').length == 0)
		{
			$('#contentArea').append('<div id="deliveryPopup" class="modalPopup" style="display: none;"><div></div><div class="closeModal"><a href="#">Close Window</a></div></div>');
			$('#deliveryPopup a').click(function()
			{
				$('#deliveryPopup').hide();
				return false;
			});
			$('body').click(function()
			{
				$('#deliveryPopup').hide();
				$('#videoPopup').hide();
				return true;
			});
			$.getJSON('/ajax.php?do=deliveryInfo', function(_data) 
			{
				if (_data.ok == 1)
				{
					$('#deliveryPopup').find('div:first').html(_data.content).end().fadeIn('fast');
				}
			});
		}
		else
		{
			$('#deliveryPopup').fadeIn('fast');
		}
		return false;
	});
	
	$('#mainImage').click(function()
	{
		var _vid = false;
		if ($(this).hasClass('video'))
		{
			if ($('#videoPopup').length == 0)
			{
				$('#contentArea').append('<div id="videoPopup" class="modalPopup" style="display: none;"><div></div><div class="closeModal"><a href="#">Close Window</a></div></div>');

				$('#videoPopup a').click(function()
				{
					if (_vid)
					{
						_vid.api('api_pause');
					}
					$('#videoPopup').hide();
					return false;
				});
				$('body').click(function()
				{
					if (_vid)
					{
						_vid.api('api_pause');
					}
					$('#deliveryPopup').hide();
					$('#videoPopup').hide();
					return true;
				});
				
				var _id = $('#zoom1').attr('href').replace('http://','').replace('www.solopress.com','').replace('/media/images/categories/','').replace('_5.jpg','');
				$.getJSON('/ajax.php?do=video&id='+_id, function(_data) 
				{
					if (_data.ok == 1)
					{
						$('#videoPopup').find('div:first').html(_data.content).end().fadeIn('fast');
						Froogaloop( $('#vimeo1')[0] ).addEvent('ready', function() {
           					_vid = $f( $('#vimeo1')[0] );   
            			});
					}
				});
			}
			else
			{
				$('#videoPopup').fadeIn('fast');
			}
			return false;
		}
		return true;
	});
	
	$('#column a[href=\'#chat\']').click(function() {
		openLiveHelp();
		return false;
	});
	

//	$('#feedback').click(function()
//	{
//		if ($('#feedbackPopup').length == 0)
//		{
//			$('#pageContainer').append('<div id="feedbackPopup" class="modalPopup" style="display: none;"><div></div><div class="closeModal"><a href="#">Close Window</a></div></div>');
//			$('#feedbackPopup a').click(function()
//			{
//				$('#feedbackPopup').hide();
//				return false;
//			});
//			
//			$.getJSON('/ajax.php?do=feedback', function(_data) 
//			{
//				if (_data.ok == 1)
//				{
//					$('#feedbackPopup').find('div:first').html(_data.content).end().fadeIn('fast');
//					$('#feedbackform').submit(function()
//					{
//						$.post(this.action, $(this).serialize()+'&ajax=1', function(_data)
//						{
//							$('#modalInfo').html('');
//							if (_data.ok == 1)
//							{
//								$('#modalInfo').html('<div class="success">'+_data.content+'</div>');
//								$('#feedbackform input').val('');
//								$('#feedbackform').hide();
//							}
//							else
//							{
//								$('#modalInfo').html('<div class="error">'+_data.content+'</div>');
//							}
//						},
//						'json');
//						
//						return false;
//					});
//				}
//			});
//		}
//		else
//		{
//			$('#modalInfo').html('Please send us your feedback.');
//			$('#feedbackform').show();
//			$('#feedbackPopup').fadeIn('fast');
//		}
//		return false;
//	});

	$('#deliveryInfo .mainland img,#ukMap').click(function()
	{
		if ($('#deliveryPopupUK').length == 0)
		{
			$('#contentArea').append('<div id="deliveryPopupUK" class="modalPopup" style="display: none;"><div></div><div class="closeModal"><a href="#">Close Window</a></div></div>');
			$('#deliveryPopupUK a').click(function()
			{
				$('#deliveryPopupUK').hide();
				return false;
			});
			$('body').click(function()
			{
				$('#deliveryPopupUK').hide();
				return true;
			});
			$.getJSON('/ajax.php?do=deliveryUKInfo', function(_data) 
			{
				if (_data.ok == 1)
				{
					_pop = $('#deliveryPopupUK');
					_pop.find('div:first').html(_data.content);
					_pop.find('img:first').wrap('<a id="zoom2" class="cloud-zoom" rel="position: \'inside\' , showTitle: false" href="/media/images/mainland_left.jpg"></a>');
					$('a#zoom2').CloudZoom();
					_pop.fadeIn('fast');
				}
			});
		}
		else
		{
			$('#deliveryPopupUK').fadeIn('fast');
		}
		return false;
	});

	$('#sizeLabel').html('Size: <a id="sizeLabelLink" href="#" onClick="return fasterPopup(\'sizePopup\');">can\'t find your size?</a>');
	$('#qtyLabel').html('Qty: <a id="qtyLabelLink" href="#" onClick="return fasterPopup(\'qtyPopup\');">can\'t find your qty?</a>');

	$('#fasterLink').click(function()
	{
		fasterPopup('fasterInfo');
		return false;
	});
	
	updateTooltips();
	
	// Basket Stuff
	$("#delivery_different").click(function(event)
	{
        if (event.target.checked)
		{
			$('#ul_different').slideDown('slow');
			$('#delivery_same').attr('checked', false);
        }
		else
		{
			$('#ul_different').slideUp('slow');
			$('#delivery_same').attr('checked',true);
		}
    });

	$("#checkoutArea #register").click(function(event)
	{
        if (event.target.checked)
		{
			$('#register_password_entry ul').slideDown('slow');
        }
		else
		{
			$('#register_password_entry ul').slideUp('slow');
		}
    });

	$('#firstname,#lastname').bind('keyup change',function()
	{
		var _el = $('#billing_'+this.id);
		if (_el.hasClass('default'))
		{
			_el.val($(this).val());
		}
	});
	
	if ($('#map').length == 1)
	{
		if (GBrowserIsCompatible()) 
		{
			//sll=51.557169,0.710592
			var address = 'Solopress<br />Unit 4, 11 Stock Road<br />Southend-on-Sea<br />Essex SS2 5QF';
			var map = new GMap2(document.getElementById("map"));
			var geocoder = new GClientGeocoder();
			map.addControl(new GSmallMapControl());
			map.setCenter(new GLatLng(51.556169,0.710492), 10);

			// Creates a marker at the given point with the given number label
			function createMarker(point, number) 
			{
				var marker = new GMarker(point);
				GEvent.addListener(marker, "click", function() 
				{
						marker.openInfoWindowHtml(address);
				});
				return marker;
			}
			var point = new GLatLng(51.556169,0.710492);
			map.addOverlay(createMarker(point, 1));
			$('body').bind('unload',GUnload);
		}
	}
	
	$('#moreReviewsLink').click(function() 
	{
		$('#moreReviews').hide();
		$('#product_reviews .hide').fadeIn('slow');
		return false;
	});
	
	jQuery.preLoadImages('/images/dropdown_edge.png', '/images/dropdown_bg.png', '/images/dropdown_edge.png');
	
	if($.browser.msie && parseInt($.browser.version) <= 6)
	{
		$('#betaPeel').hide();
		$('html').removeClass('js');
		$('<div id="browserWarning">You are using an unsupported browser. Please download the <strong>free</strong> update from Microsoft here <a href="http://www.microsoft.com/windows/internet-explorer/">www.microsoft.com</a></div>').css({'font-size':'1.5em','backgroundColor':'#fcfdde','width':'100%','border-top':'solid 1px #000','border-bottom':'solid 1px #000','text-align':'center','padding':'5px 0px 5px 0px'}).prependTo('body');
	}
		
	$('#proTabs li').css('cursor','pointer').click(function()
	{
		var _this = $(this);
		_this.addClass('on').siblings().removeClass('on');
		var _i = $('#proTabs li').index(this);
		$('#proTabsContent>div:visible').hide();
		$('#proTabsContent>div:eq('+_i+')').show();													  
	
		return false;
	});
	
	$('a#user_reviews').click(function()
	{
		$('#reviewTab').addClass('on').siblings().removeClass('on');
		$('#proTabsContent>div:visible').hide();
		$('#product_reviews').show();
		$('html,body').animate({ scrollTop: $('#product_reviews').offset().top });
		return false;
	});

	
});

//////////////////////////////////////////////////////////////////////////////////
// Cloud Zoom V1.0.2
// (c) 2010 by R Cecco. <http://www.professorcloud.com>
// MIT License
//
// Please retain this copyright header in all versions of the software
//////////////////////////////////////////////////////////////////////////////////
(function($){$(document).ready(function(){$('.cloud-zoom, .cloud-zoom-gallery').CloudZoom()});function format(str){for(var i=1;i<arguments.length;i++){str=str.replace('%'+(i-1),arguments[i])}return str}function CloudZoom(jWin,opts){var sImg=$('img',jWin);var img1;var img2;var zoomDiv=null;var $mouseTrap=null;var lens=null;var $tint=null;var softFocus=null;var $ie6Fix=null;var zoomImage;var controlTimer=0;var cw,ch;var destU=0;var destV=0;var currV=0;var currU=0;var filesLoaded=0;var mx,my;var ctx=this,zw;setTimeout(function(){if($mouseTrap===null){var w=jWin.width();jWin.parent().append(format('<div style="width:%0px;position:absolute;top:75%;left:%1px;text-align:center" class="cloud-zoom-loading" >Loading...</div>',w/3,(w/2)-(w/6))).find(':last').css('opacity',0.5)}},200);var ie6FixRemove=function(){if($ie6Fix!==null){$ie6Fix.remove();$ie6Fix=null}};this.removeBits=function(){if(lens){lens.remove();lens=null}if($tint){$tint.remove();$tint=null}if(softFocus){softFocus.remove();softFocus=null}ie6FixRemove();$('.cloud-zoom-loading',jWin.parent()).remove()};this.destroy=function(){jWin.data('zoom',null);if($mouseTrap){$mouseTrap.unbind();$mouseTrap.remove();$mouseTrap=null}if(zoomDiv){zoomDiv.remove();zoomDiv=null}this.removeBits()};this.fadedOut=function(){if(zoomDiv){zoomDiv.remove();zoomDiv=null}this.removeBits()};this.controlLoop=function(){if(lens){var x=(mx-sImg.offset().left-(cw*0.5))>>0;var y=(my-sImg.offset().top-(ch*0.5))>>0;if(x<0){x=0}else if(x>(sImg.outerWidth()-cw)){x=(sImg.outerWidth()-cw)}if(y<0){y=0}else if(y>(sImg.outerHeight()-ch)){y=(sImg.outerHeight()-ch)}lens.css({left:x,top:y});lens.css('background-position',(-x)+'px '+(-y)+'px');destU=(((x)/sImg.outerWidth())*zoomImage.width)>>0;destV=(((y)/sImg.outerHeight())*zoomImage.height)>>0;currU+=(destU-currU)/opts.smoothMove;currV+=(destV-currV)/opts.smoothMove;zoomDiv.css('background-position',(-(currU>>0)+'px ')+(-(currV>>0)+'px'))}controlTimer=setTimeout(function(){ctx.controlLoop()},30)};this.init2=function(img,id){filesLoaded++;if(id===1){zoomImage=img}if(filesLoaded===2){this.init()}};this.init=function(){$('.cloud-zoom-loading',jWin.parent()).remove();$mouseTrap=jWin.parent().append(format("<div class='mousetrap' style='background-image:url(\".\");z-index:999;position:absolute;width:%0px;height:%1px;left:%2px;top:%3px;\'></div>",sImg.outerWidth(),sImg.outerHeight(),0,0)).find(':last');$mouseTrap.bind('mousemove',this,function(event){mx=event.pageX;my=event.pageY});$mouseTrap.bind('mouseleave',this,function(event){clearTimeout(controlTimer);if(lens){lens.fadeOut(299)}if($tint){$tint.fadeOut(299)}if(softFocus){softFocus.fadeOut(299)}zoomDiv.fadeOut(300,function(){ctx.fadedOut()});return false});$mouseTrap.bind('mouseenter',this,function(event){mx=event.pageX;my=event.pageY;zw=event.data;if(zoomDiv){zoomDiv.stop(true,false);zoomDiv.remove()}var xPos=opts.adjustX,yPos=opts.adjustY;var siw=sImg.outerWidth();var sih=sImg.outerHeight();var w=opts.zoomWidth;var h=opts.zoomHeight;if(opts.zoomWidth=='auto'){w=siw}if(opts.zoomHeight=='auto'){h=sih}var appendTo=jWin.parent();switch(opts.position){case'top':yPos-=h;break;case'right':xPos+=siw;break;case'bottom':yPos+=sih;break;case'left':xPos-=w;break;case'inside':w=siw;h=sih;break;default:appendTo=$('#'+opts.position);if(!appendTo.length){appendTo=jWin;xPos+=siw;yPos+=sih}else{w=appendTo.innerWidth();h=appendTo.innerHeight()}}zoomDiv=appendTo.append(format('<div id="cloud-zoom-big" class="cloud-zoom-big" style="display:none;position:absolute;left:%0px;top:%1px;width:%2px;height:%3px;background-image:url(\'%4\');z-index:99;"></div>',xPos,yPos,w,h,zoomImage.src)).find(':last');if(sImg.attr('title')&&opts.showTitle){zoomDiv.append(format('<div class="cloud-zoom-title">%0</div>',sImg.attr('title'))).find(':last').css('opacity',opts.titleOpacity)}if($.browser.msie&&$.browser.version<7){$ie6Fix=$('<iframe frameborder="0" src="#"></iframe>').css({position:"absolute",left:xPos,top:yPos,zIndex:99,width:w,height:h}).insertBefore(zoomDiv)}zoomDiv.fadeIn(500);if(lens){lens.remove();lens=null}cw=(sImg.outerWidth()/zoomImage.width)*zoomDiv.width();ch=(sImg.outerHeight()/zoomImage.height)*zoomDiv.height();lens=jWin.append(format("<div class = 'cloud-zoom-lens' style='display:none;z-index:98;position:absolute;width:%0px;height:%1px;'></div>",cw,ch)).find(':last');$mouseTrap.css('cursor',lens.css('cursor'));var noTrans=false;if(opts.tint){lens.css('background','url("'+sImg.attr('src')+'")');$tint=jWin.append(format('<div style="display:none;position:absolute; left:0px; top:0px; width:%0px; height:%1px; background-color:%2;" />',sImg.outerWidth(),sImg.outerHeight(),opts.tint)).find(':last');$tint.css('opacity',opts.tintOpacity);noTrans=true;$tint.fadeIn(500)}if(opts.softFocus){lens.css('background','url("'+sImg.attr('src')+'")');softFocus=jWin.append(format('<div style="position:absolute;display:none;top:2px; left:2px; width:%0px; height:%1px;" />',sImg.outerWidth()-2,sImg.outerHeight()-2,opts.tint)).find(':last');softFocus.css('background','url("'+sImg.attr('src')+'")');softFocus.css('opacity',0.5);noTrans=true;softFocus.fadeIn(500)}if(!noTrans){lens.css('opacity',opts.lensOpacity)}if(opts.position!=='inside'){lens.fadeIn(500)}zw.controlLoop();return})};img1=new Image();$(img1).load(function(){ctx.init2(this,0)});img1.src=sImg.attr('src');img2=new Image();$(img2).load(function(){ctx.init2(this,1)});img2.src=jWin.attr('href')}$.fn.CloudZoom=function(options){try{document.execCommand("BackgroundImageCache",false,true)}catch(e){}this.each(function(){var relOpts,opts;eval('var	a = {'+$(this).attr('rel')+'}');relOpts=a;if($(this).is('.cloud-zoom')){$(this).css({'position':'relative','display':'block'});$('img',$(this)).css({'display':'block'});if($(this).parent().attr('id')!='wrap'){$(this).wrap('<div id="wrap" style="top:0px;z-index:9999;position:relative;"></div>')}opts=$.extend({},$.fn.CloudZoom.defaults,options);opts=$.extend({},opts,relOpts);$(this).data('zoom',new CloudZoom($(this),opts))}else if($(this).is('.cloud-zoom-gallery')){opts=$.extend({},relOpts,options);$(this).data('relOpts',opts);$(this).bind('click',$(this),function(event){var data=event.data.data('relOpts');$('#mainZoomTo').show();$('#mainImage').removeClass('video');$('#'+data.useZoom).data('zoom').destroy();$('#'+data.useZoom).attr('href',event.data.attr('href'));$('#'+data.useZoom+' img').attr('src',event.data.data('relOpts').smallImage);$('#'+event.data.data('relOpts').useZoom).CloudZoom();return false})}});return this};$.fn.CloudZoom.defaults={zoomWidth:'auto',zoomHeight:'auto',position:'right',tint:false,tintOpacity:0.5,lensOpacity:0.5,softFocus:false,smoothMove:3,showTitle:true,titleOpacity:0.5,adjustX:0,adjustY:0}})(jQuery);
