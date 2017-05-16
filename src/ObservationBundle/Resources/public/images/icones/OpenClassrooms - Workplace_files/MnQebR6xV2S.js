if (self.CavalryLogger) { CavalryLogger.start_js(["Z6ZL+"]); }

__d('ExpandingCtaModern',['CtaImpressionsTypedLogger','Animation','Style'],(function a(b,c,d,e,f,g){var h=150,i=255,j=750,k={show:function l(m,n,o,p,q,r){var s=document.documentElement.clientHeight,t=false;c('Style').set(document.body,'margin-bottom',i+'px');var u=setInterval(v,1000);if(q)setTimeout(w,3000);window.onload=function(){if(!q&&window.pageYOffset<=j)x(m,'height',i+'px');};p.addEventListener('click',function(){if(!r){c('Style').set(o,'display','none');c('Style').set(m,'height','70%');c('Style').set(n,'display','block');c('Style').set(m,'background','none');x(m,'height',i+'px');}else x(m,'height','0px');clearInterval(u);});function v(){if(!t&&window.pageYOffset>j){w();clearInterval(u);}}function w(){if(!t){c('Style').set(n,'display','none');c('Style').set(o,'display','block');x(m,'height',s+'px');x(m,'background','rgba(0,0,0,0.5)');t=true;var y=new (c('CtaImpressionsTypedLogger'))();y.setCtaType('www_pages_cta');y.setOriginalURI(window.location.href);y.logVital();}}function x(y,z,aa){new (c('Animation'))(y).to(z,aa).duration(h).ease(c('Animation').ease.both).go();}}};f.exports=k;}),null);
__d('PagesAboutSectionLogger',['Event','PagesEventObserver','Run'],(function a(b,c,d,e,f,g){'use strict';var h={registerLogEvent:function i(j,k,l){var m=c('Event').listen(j,'click',function(){return c('PagesEventObserver').notify(k,l);});c('Run').onLeave(function(){m.remove();});}};f.exports=h;}),null);
__d('PageLiveInsightsStore',['FluxReduceStore','PageLiveInsightsDispatcher'],(function a(b,c,d,e,f,g){'use strict';var h,i,j=10000;h=babelHelpers.inherits(k,c('FluxReduceStore'));i=h&&h.prototype;k.prototype.getInitialState=function(){return {fadingOut:false,hovering:false,idleTime:j,pageID:null,text:null};};k.prototype.reduce=function(l,m){var n=babelHelpers['extends']({},l);switch(m.type){case 'show_banner':return {fadingOut:false,hovering:false,idleTime:m.data.idle_time,pageID:m.data.page_id,text:m.data.text};case 'fade_out_banner':n.fadingOut=true;return n;case 'hover_banner':n.fadingOut=false;n.hovering=true;return n;case 'mouse_leave_banner':n.hovering=false;return n;}return {fadingOut:false,hovering:false,idleTime:j,pageID:null,text:null};};function k(){h.apply(this,arguments);}f.exports=new k(c('PageLiveInsightsDispatcher'));}),null);
__d('PageLiveInsightsBanner.react',['cx','Animation','DOMContainer.react','FluxContainer','PageLiveInsightsDispatcher','PageLiveInsightsStore','React','ReactDOM','Style','ViewportBounds'],(function a(b,c,d,e,f,g,h){'use strict';var i,j,k=1500;i=babelHelpers.inherits(l,c('React').Component);j=i&&i.prototype;function l(){var m,n;for(var o=arguments.length,p=Array(o),q=0;q<o;q++)p[q]=arguments[q];return n=(m=j.constructor).call.apply(m,[this].concat(p)),this.$PageLiveInsightsBanner1=null,this.$PageLiveInsightsBanner2=null,n;}l.getStores=function(){return [c('PageLiveInsightsStore')];};l.calculateState=function(m,n){return c('PageLiveInsightsStore').getState();};l.prototype.componentWillMount=function(){c('PageLiveInsightsDispatcher').explicitlyRegisterStore(c('PageLiveInsightsStore'));};l.prototype.componentWillUnmount=function(){if(this.$PageLiveInsightsBanner2){this.$PageLiveInsightsBanner2.stop();this.$PageLiveInsightsBanner2=null;}this.$PageLiveInsightsBanner3();};l.prototype.render=function(){if(!this.state.text)return null;var m=document.getElementById('pagelet_page_above_header');if(m&&m.offsetHeight>0)return null;if(!this.state.fadingOut&&!this.state.hovering)this.$PageLiveInsightsBanner4();this.$PageLiveInsightsBanner5();var n={top:(c('ViewportBounds').getTop()+20).toString()+'px'};return c('React').createElement('div',{className:"_4p0v",onMouseEnter:function(){return this.$PageLiveInsightsBanner6();}.bind(this),onMouseLeave:function(){return this.$PageLiveInsightsBanner7();}.bind(this),ref:'banner',style:n},c('React').createElement(c('DOMContainer.react'),null,this.state.text));};l.prototype.$PageLiveInsightsBanner4=function(){if(this.$PageLiveInsightsBanner1===null)this.$PageLiveInsightsBanner1=setTimeout(function(){c('PageLiveInsightsDispatcher').dispatch({type:'fade_out_banner',data:null});},this.state.idleTime);};l.prototype.$PageLiveInsightsBanner5=function(){if(this.state.fadingOut){this.$PageLiveInsightsBanner1=null;if(this.$PageLiveInsightsBanner2===null)this.$PageLiveInsightsBanner2=new (c('Animation'))(c('ReactDOM').findDOMNode(this.refs.banner)).from('opacity','1').to('opacity','0').duration(k).ondone(this.$PageLiveInsightsBanner3).go();}else if(!this.state.fadingOut&&this.$PageLiveInsightsBanner2){this.$PageLiveInsightsBanner2&&this.$PageLiveInsightsBanner2.stop();this.$PageLiveInsightsBanner2=null;c('Style').set(c('ReactDOM').findDOMNode(this.refs.banner),'opacity','1');}};l.prototype.$PageLiveInsightsBanner3=function(){c('PageLiveInsightsDispatcher').dispatch({type:'remove_banner',data:null});};l.prototype.$PageLiveInsightsBanner6=function(){if(this.$PageLiveInsightsBanner1!==null){clearTimeout(this.$PageLiveInsightsBanner1);this.$PageLiveInsightsBanner1=null;}c('PageLiveInsightsDispatcher').dispatch({type:'hover_banner',data:null});};l.prototype.$PageLiveInsightsBanner7=function(){c('PageLiveInsightsDispatcher').dispatch({type:'mouse_leave_banner',data:null});};f.exports=c('FluxContainer').create(l);}),null);
__d('PagesPostsSearch',['cx','Arbiter','CSS','DOM','LoadingIndicator.react','React','ReactDOM','Run','SubscriptionsHandler','UIPagelet'],(function a(b,c,d,e,f,g,h){var i=100,j={searchPosts:function k(l,m,n){this._pageID=l;this._postsContainer=m;this._searchResultsContainer=n;var o=new (c('SubscriptionsHandler'))();o.addSubscriptions(c('Arbiter').subscribe('PagesTimelineSearch/search',this._handleSearchBarAction.bind(this)));c('Run').onLeave(function(){return o.release();});},_handleSearchBarAction:function k(l,m){this._query=m.query;if(this._query!==''){this._handleSearch();}else this._handleClearField();setTimeout(function(){c('Arbiter').inform('PagesTimelineSearch/searchDone',{query:this._query});}.bind(this),i);},_handleSearch:function k(){c('CSS').hide(this._postsContainer);c('ReactDOM').render(c('React').createElement('div',{className:"_3x9t"},c('React').createElement(c('LoadingIndicator.react'),{color:'white',size:'large'})),this._searchResultsContainer);c('UIPagelet').loadFromEndpoint('PagePostsSearchResultsPagelet',this._searchResultsContainer,{page_id:this._pageID,search_query:this._query});},_handleClearField:function k(){c('DOM').setContent(this._searchResultsContainer,null);c('CSS').show(this._postsContainer);}};f.exports=j;}),null);
__d('ReactionLogging',['DataStore','Event','MarauderLogger'],(function a(b,c,d,e,f,g){var h='reaction_logging';function i(k,l,m){c('DataStore').set(k,h,l);if(m)c('Event').listen(k,'click',function(){j(k);});}function j(k){var l=c('DataStore').get(k,h);if(!l||!l.logging_data)return;l=l.logging_data;c('MarauderLogger').log('reaction_unit_interaction','guide_cards_null_state',l);}f.exports={startLogTracking:i};}),null);
__d('MorePagerFetchOnScroll',['AsyncRequest','DOMQuery','Event','Style','Vector','throttle'],(function a(b,c,d,e,f,g){var h={};function i(j,k,l){'use strict';this._pager=j;this._offset=k||0;this._hasEventHandlers=false;if(l)this.setup();h[j.id]=this;}i.prototype.setup=function(){'use strict';this._scrollParent=c('Style').getScrollParent(this._pager);this.setPagerInViewHandler(this._defaultPagerInViewHandler.bind(this));if(!this.check()){this._scrollListener=c('Event').listen(this._scrollParent,'scroll',c('throttle')(function(){this.check();}.bind(this),50));this._clickListener=c('Event').listen(this._scrollParent,'click',c('throttle')(function(){this.check();}.bind(this),50));this._hasEventHandlers=true;}};i.prototype.check=function(){'use strict';if(!c('DOMQuery').contains(document.body,this._pager)){this.removeEventListeners();return true;}var j=c('Vector').getElementPosition(this._pager).y,k=this._scrollParent===window?c('Vector').getViewportDimensions().y:c('Vector').getElementDimensions(this._scrollParent).y,l=this._scrollParent===window?c('Vector').getScrollPosition().y+k:c('Vector').getElementPosition(this._scrollParent).y+k;if(j-this._offset<l){this._inViewHandler();this.removeEventListeners();return true;}return false;};i.prototype.removeEventListeners=function(){'use strict';if(this._hasEventHandlers){this._scrollListener&&this._scrollListener.remove();this._clickListener&&this._clickListener.remove();this._hasEventHandlers=false;}};i.prototype.setPagerInViewHandler=function(j){'use strict';this._inViewHandler=j;return this;};i.prototype._defaultPagerInViewHandler=function(){'use strict';var j=c('DOMQuery').scry(this._pager,'a')[0];if(j)c('AsyncRequest').bootstrap(j.getAttribute('ajaxify')||j.href,j);};i.getInstance=function(j){'use strict';return h[j];};f.exports=i;}),null);
__d('EntityPageSubNavigationLogger',['cx','Arbiter','Event','Parent','SubscriptionsHandler','XUISubNavigationLoader'],(function a(b,c,d,e,f,g,h){var i="_2yaa",j=void 0,k=null,l={subscribe:function m(event,n,o){if(!j)j=new (c('Arbiter'))();return j.subscribe(event,n,o);},register:function m(n){if(!k){k=new (c('SubscriptionsHandler'))();k.addSubscriptions(c('XUISubNavigationLoader').onLeave(function(){k&&k.release();k=null;}));}k.addSubscriptions(c('Event').listen(n,'click',function(event){j&&j.inform('click',c('Parent').byClass(event.target,i).getAttribute('data-key'));}));}};f.exports=l;}),null);
__d('AsyncData',[],(function a(b,c,d,e,f,g){var h=Object.create(null),i=Object.create(null),j=Object.create(null),k={resolve:function n(o,p){var q=j[o]={result:p,status:'success'};if(h[o]){h[o].forEach(function(r){return r(q.result);});delete h[o];}delete i[o];},reject:function n(o,p){var q=j[o]={error:p,status:'error'};if(i[o]){i[o].forEach(function(r){return r(q.error);});delete i[o];}delete h[o];},preload:function n(o){var p={};p.onLoaded=l.bind(null,o,p);p.onError=m.bind(null,o,p);return p;}};function l(n,o,p){var q=j[n];if(q&&!q.error){p(q.result);}else{h[n]=h[n]||[];h[n].push(p);}return o;}function m(n,o,p){var q=j[n];if(q){if(q.status==='error')p(q.error);}else{i[n]=i[n]||[];i[n].push(p);}return o;}f.exports=k;}),null);
__d('AsyncDataPreloader',['AsyncData'],(function a(b,c,d,e,f,g){function h(i){var j=i.id;'use strict';this.$AsyncDataPreloader1=j;this.$AsyncDataPreloader2=c('AsyncData').preload.call(null,this.$AsyncDataPreloader1);}h.prototype.onLoaded=function(i){'use strict';this.$AsyncDataPreloader2.onLoaded(i);return this;};h.prototype.onError=function(i){'use strict';this.$AsyncDataPreloader2.onError(i);return this;};f.exports=h;}),null);
__d('CurrentPage',['invariant','Run'],(function a(b,c,d,e,f,g,h){'use strict';var i=null,j=null,k={init:function l(m){var n=m.pageID,o=m.pageName;this.setID(n);this.setName(o);c('Run').onLeave(this._clear);},getID:function l(){i!==null||h(0);return i;},setID:function l(m){if(!i)i=m;},getName:function l(){j!==null||h(0);return j;},setName:function l(m){if(!j)j=m;},_clear:function l(){i=null;j=null;}};f.exports=k;}),null);