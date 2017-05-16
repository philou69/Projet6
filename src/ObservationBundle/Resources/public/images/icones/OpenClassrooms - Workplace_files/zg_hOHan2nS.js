if (self.CavalryLogger) { CavalryLogger.start_js(["e5BVk"]); }

__d('legacy:dom',['DOM'],(function a(b,c,d,e,f,g){b.DOM=c('DOM');}),3);
__d('NotifUserSettingActionTypedLogger',['Banzai','GeneratedLoggerUtils','nullthrows'],(function a(b,c,d,e,f,g){'use strict';function h(){this.clear();}h.prototype.log=function(){c('GeneratedLoggerUtils').log('logger:NotifUserSettingActionLoggerConfig',this.$NotifUserSettingActionTypedLogger1,c('Banzai').BASIC);};h.prototype.logVital=function(){c('GeneratedLoggerUtils').log('logger:NotifUserSettingActionLoggerConfig',this.$NotifUserSettingActionTypedLogger1,c('Banzai').VITAL);};h.prototype.clear=function(){this.$NotifUserSettingActionTypedLogger1={};return this;};h.prototype.updateData=function(j){this.$NotifUserSettingActionTypedLogger1=babelHelpers['extends']({},this.$NotifUserSettingActionTypedLogger1,j);return this;};h.prototype.setAppID=function(j){this.$NotifUserSettingActionTypedLogger1.app_id=j;return this;};h.prototype.setControllerClass=function(j){this.$NotifUserSettingActionTypedLogger1.controller_class=j;return this;};h.prototype.setCurState=function(j){this.$NotifUserSettingActionTypedLogger1.cur_state=j;return this;};h.prototype.setEntityID=function(j){this.$NotifUserSettingActionTypedLogger1.entity_id=j;return this;};h.prototype.setEventType=function(j){this.$NotifUserSettingActionTypedLogger1.event_type=j;return this;};h.prototype.setMedium=function(j){this.$NotifUserSettingActionTypedLogger1.medium=j;return this;};h.prototype.setNotifType=function(j){this.$NotifUserSettingActionTypedLogger1.notif_type=j;return this;};h.prototype.setPrevState=function(j){this.$NotifUserSettingActionTypedLogger1.prev_state=j;return this;};h.prototype.setRecipID=function(j){this.$NotifUserSettingActionTypedLogger1.recip_id=j;return this;};h.prototype.setSource=function(j){this.$NotifUserSettingActionTypedLogger1.source=j;return this;};h.prototype.setWantLess=function(j){this.$NotifUserSettingActionTypedLogger1.want_less=j;return this;};var i={app_id:true,controller_class:true,cur_state:true,entity_id:true,event_type:true,medium:true,notif_type:true,prev_state:true,recip_id:true,source:true,want_less:true};f.exports=h;}),null);
__d('FutureSideNavItem',['Arbiter','CSS','DOM','Parent','$','createArrayFromMixed','getElementText'],(function a(b,c,d,e,f,g){function h(i,j){'use strict';this.id=i.id;this.up=j;this.endpoint=i.endpoint;this.type=i.type;this.node=i.node||c('$')(i.id);this.paths=i.path?c('createArrayFromMixed')(i.path):[];this.keys=i.key?c('createArrayFromMixed')(i.key):[];var k=this._findKeys(this.keys);this.numericKey=k.numeric||this.keys[0];this.textKey=k.text||this.keys[0];this._pathPattern=this._buildRegex(this.paths);this._keyPattern=this._buildRegex(this.keys);this.hideLoading();this.hideSelected();}h.prototype.equals=function(i){'use strict';return i&&i.id===this.id;};h.prototype.getLinkNode=function(){'use strict';return c('DOM').scry(this.node,'a.item')[0]||c('DOM').scry(this.node,'a.subitem')[0];};h.prototype.matchPath=function(i){'use strict';return this._matchInput(this._pathPattern,i);};h.prototype.matchKey=function(i){'use strict';return this._matchInput(this._keyPattern,i);};h.prototype._matchInput=function(i,j){'use strict';var k=i&&i.exec(j);return k&&k.slice(1);};h.prototype.getTop=function(){'use strict';return this.isTop()?this:this.up.getTop();};h.prototype.isTop=function(i){'use strict';return !this.up;};h.prototype.setCount=function(i,j){'use strict';return this._updateCount(i,true);};h.prototype.incrementCount=function(i,j){'use strict';return this._updateCount(i,false);};h.prototype._updateCount=function(i,j,k){'use strict';var l=c('DOM').scry(this.node,'span.count')[0],m=l&&c('DOM').scry(l,'span.countValue')[0];if(m){var n=j?0:parseInt(c('getElementText')(m),10),o=Math.max(0,n+i),p=this.isTop()?'hidden':'hiddenSubitem';c('DOM').setContent(m,o);k&&c('CSS').conditionClass(this.node,p,!o);c('CSS').conditionClass(l,'hidden_elem',!o);if(this.isTop()){var q=c('DOM').scry(this.node,'div.linkWrap')[0];if(q){c('CSS').conditionClass(q,'noCount',!o);c('CSS').conditionClass(q,'hasCount',o);}}}c('Arbiter').inform('NavigationMessage.COUNT_UPDATE_DONE');};h.prototype.showLoading=function(){'use strict';c('CSS').addClass(this.node,'loading');};h.prototype.hideLoading=function(){'use strict';c('CSS').removeClass(this.node,'loading');};h.prototype.showSelected=function(){'use strict';c('CSS').addClass(this.node,'selectedItem');c('CSS').hasClass(this.node,'hider')&&c('CSS').addClass(this._getExpanderParent(),'expandedMode');};h.prototype.hideSelected=function(){'use strict';c('CSS').removeClass(this.node,'selectedItem');};h.prototype.showChildren=function(){'use strict';c('CSS').addClass(this.node,'open');};h.prototype.hideChildren=function(){'use strict';c('CSS').removeClass(this.node,'open');};h.prototype._getExpanderParent=function(){'use strict';return c('Parent').byClass(this.node,'expandableSideNav');};h.prototype._buildRegex=function(i){'use strict';if(i.length){var j=i.map(function(k){if(typeof k==="string"){return k.replace(/([^a-z0-9_])/ig,'\\$1');}else if(k&&k.regex)return k.regex;});return new RegExp('^(?:'+j.join('|')+')$');}};h.prototype._findKeys=function(i){'use strict';var j=/^(app|group|fl)_/,k={};for(var l=0;l<i.length;l++){var m=j.test(i[l]);if(m&&!k.numeric){k.numeric=i[l];}else if(!m&&!k.text)k.text=i[l];if(k.numeric&&k.text)break;}return k;};f.exports=h;}),null);
__d('FutureSideNavSection',['Bootloader','DOMQuery','$'],(function a(b,c,d,e,f,g){function h(i){'use strict';this.id=i.id;this.node=this.node||c('$')(i.id);this.editEndpoint=i.editEndpoint;}h.prototype.equals=function(i){'use strict';return i&&i.id===this.id;};h.prototype.getEditorAsync=function(i){'use strict';c('Bootloader').loadModules(["SortableSideNav"],function(j){var k=new j(c('DOMQuery').find(this.node,'ul.uiSideNav'),this.editEndpoint);i(k);}.bind(this),'FutureSideNavSection');};f.exports=h;}),null);
__d('FutureSideNav',['Arbiter','ChannelConstants','CSS','DOM','DOMDimensions','$','Event','FutureSideNavItem','FutureSideNavSection','NavigationMessage','PageTransitions','Parent','Run','SelectorDeprecated','URI','Vector','Locale','createArrayFromMixed','debounce'],(function a(b,c,d,e,f,g){function h(i,j,k){'use strict';h.instance&&h.instance.uninstall();h.instance=this;if(typeof i==='undefined')return;this.init(i,j,k);}h.prototype.init=function(i,j,k){'use strict';this.root=i;this.items={};this.sections={};this.editor=null;this.editing=false;this.selected=null;this.loading=null;this.keyParam='sk';this.defaultKey=j;this.uri=c('URI').getRequestURI();this.ajaxPipe=k;this.ajaxPipeEndpoints={};this.sidecol=true;this._installed=true;this._handlePageTransitions=true;c('PageTransitions').registerHandler(function(l){return this._handlePageTransitions&&this.handlePageTransition(l);}.bind(this));this._eventHandlers=[];this._sectionEventHandlers={};this._arbiterSubscriptions=[c('Arbiter').subscribe(c('NavigationMessage').NAVIGATION_COMPLETED,this.navigationComplete.bind(this)),c('Arbiter').subscribe(c('NavigationMessage').NAVIGATION_FAILED,this.navigationFailed.bind(this)),c('Arbiter').subscribe(c('NavigationMessage').NAVIGATION_COUNT_UPDATE,this.navigationCountUpdate.bind(this)),c('Arbiter').subscribe(c('NavigationMessage').NAVIGATION_SELECT,this.navigationSelect.bind(this)),c('Arbiter').subscribe(c('ChannelConstants').getArbiterType('nav_update_counts'),this.navigationCountUpdateFromPresence.bind(this)),c('Arbiter').subscribe('sideNavPopoverMenuItemClicked',function(l,m){var n=c('Parent').byClass(m.bookmarkNode,'homeSideNav'),o=n&&n.getAttribute('id');if(!o)return;this._handleMenuClick(this.sections[o],m.bookmarkNode,m.menuItemNode,m.menuNode);}.bind(this)),c('Arbiter').subscribe('sideNavPopoverMenuCheckFavorite',function(l,m){var n=c('Parent').byClass(m.bookmarkNode,'homeSideNav'),o=n&&n.getAttribute('id');if(!o)return;var p=this.sections[o].equals(this.getSection('favorites')),q=this.items[m.bookmarkNode.id];if(p){q.showFavorite(m.menuNode);}else q.hideFavorite(m.menuNode);}.bind(this))];this._handleResize=c('debounce')(this._checkNarrow.bind(this),200);this._eventHandlers.push(c('Event').listen(window,'resize',this._handleResize));this._checkNarrow();this._selectorSubscriptions=[];window.Selector&&this._selectorSubscriptions.push(c('SelectorDeprecated').subscribe(['open','close'],function(l,m){var n=c('Parent').byClass(m.selector,'sideNavItem');n&&c('CSS').conditionClass(n,'editMenuOpened',l==='open');}));c('Run').onLeave(this.uninstall.bind(this));if(this._pendingSections)this._pendingSections.forEach(function(l){this.initSection.apply(this,l);}.bind(this));};h.prototype._checkNarrow=function(){'use strict';if(!this.root)return;var i=c('Vector').getElementPosition(this.root).x;c('CSS').conditionClass(this.root,'uiNarrowSideNav',i<20||c('Locale').isRTL()&&i+c('DOMDimensions').getElementDimensions(this.root).width<c('DOMDimensions').getElementDimensions(c('$')('globalContainer')).width);};h.prototype.uninstall=function(){'use strict';if(this._installed){this._installed=false;this._handlePageTransitions=false;this._arbiterSubscriptions.forEach(c('Arbiter').unsubscribe);this._selectorSubscriptions.forEach(function(j){c('SelectorDeprecated').unsubscribe(j);});this._eventHandlers.forEach(function(j){j.remove();});for(var i in this._sectionEventHandlers)this._sectionEventHandlers[i].remove();this._handleResize.reset();}};h.prototype.initSection=function(i,j){'use strict';if(!this._installed){this._pendingSections=this._pendingSections||[];this._pendingSections.push(arguments);return;}this._initItems(j);this._initSection(i);};h.prototype.addItem=function(i,j){'use strict';this._initItem(i,j);};h.prototype._initItems=function(i){'use strict';var j=function(k,l){var m=this._initItem(k,l);if(k.children)k.children.forEach(function(n){j(n,m);});}.bind(this);c('createArrayFromMixed')(i).forEach(function(k){j(k,null);});};h.prototype._initItem=function(i,j){'use strict';var k=this.items[i.id]=this._constructItem(i,j);if(k.equals(this.selected)||i.selected)this.setSelected(k);var l=k.getLinkNode();l&&this._eventHandlers.push(c('Event').listen(l,'click',function(event){return !this.editing;}.bind(this)));return k;};h.prototype._initSection=function(i){'use strict';this._sectionEventHandlers[i.id]&&this._sectionEventHandlers[i.id].remove();var j=this.sections[i.id]=this._constructSection(i);this._sectionEventHandlers[i.id]=c('Event').listen(j.node,'click',this.handleSectionClick.bind(this,j));return j;};h.prototype._constructItem=function(i,j){'use strict';return new (c('FutureSideNavItem'))(i,j);};h.prototype._constructSection=function(i){'use strict';return new (c('FutureSideNavSection'))(i);};h.prototype.handleSectionClick=function(i,event){'use strict';var j=this._getEventTarget(event,'a');if(j)this._handleLinkClick(i,j,event);};h.prototype._getEventTarget=function(event,i){'use strict';var j=event.getTarget();if(j.tagName!==i.toUpperCase()){return c('Parent').byTag(j,i);}else return j;};h.prototype._handleMenuClick=function(i,j,k,l){'use strict';if(c('CSS').hasClass(k,'rearrange'))this.beginEdit(i);};h.prototype._handleMenuItemClick=function(i,j,k){'use strict';if(i==='rearrange')this.beginEdit(j);};h.prototype._handleLinkClick=function(i,j,event){'use strict';if(c('CSS').hasClass(j,'navEditDone')){this.editing?this.endEdit():this.beginEdit(i);event.kill();}};h.prototype.getItem=function(i){'use strict';if(this._isCurrentPath(i)){return this._getItemForKey(this._getKey(i.getQueryData())||this.defaultKey);}else return this._getItemForPath(i.getPath());};h.prototype.getNodeForKey=function(i){'use strict';var j=this._getItemForKey(i);if(j)return j.node;};h.prototype._isCurrentPath=function(i){'use strict';return i.getDomain()===this.uri.getDomain()&&i.getPath()===this.uri.getPath();};h.prototype._getKey=function(i){'use strict';return i[this.keyParam];};h.prototype._getSectionForNode=function(i){'use strict';while(i=i.parentNode)if(i.id&&this.sections[i.id])return this.sections[i.id];};h.prototype._getItemForNode=function(i){'use strict';i=c('Parent').byClass(i,'sideNavItem');return i&&this.items[i.id];};h.prototype._getItemForKey=function(i){'use strict';return this._findItem(function(j){return j.matchKey(i);});};h.prototype._getItemForPath=function(i){'use strict';return this._findItem(function(j){return j.matchPath(i);});};h.prototype._findItem=function(i){'use strict';for(var j in this.items)if(i(this.items[j]))return this.items[j];};h.prototype.removeItem=function(i){'use strict';if(i&&this.items[i.id]){c('DOM').remove(i.node);delete this.items[i.id];}};h.prototype.removeItemByKey=function(i){'use strict';this.removeItem(this._getItemForKey(i));};h.prototype.moveItem=function(i,j,k){'use strict';var l=c('DOM').find(i.node,'ul.uiSideNav');(k?c('DOM').prependContent:c('DOM').appendContent)(l,j.node);};h.prototype.setLoading=function(i){'use strict';this.loading&&this.loading.hideLoading();this.loading=i;this.loading&&this.loading.showLoading();};h.prototype.setSelected=function(i){'use strict';this.setLoading(null);if(this.selected){this.selected.hideSelected();this.selected.getTop().hideChildren();}this.selected=i;if(this.selected){this.selected.showSelected();this.selected.getTop().showChildren();}};h.prototype.handlePageTransition=function(i){'use strict';var j=this.getItem(i),k=j&&j.endpoint&&this._doPageTransition(j,i);return k;};h.prototype._doPageTransition=function(i,j){'use strict';this.setLoading(i);this._sendPageTransition(i.endpoint,babelHelpers['extends']({},this._getTransitionData(i,j),j.getQueryData()));return true;};h.prototype._sendPageTransition=function(i,j){'use strict';j.endpoint=i;c('Arbiter').inform(c('NavigationMessage').NAVIGATION_BEGIN,{useAjaxPipe:this._useAjaxPipe(i),params:j});};h.prototype._getTransitionData=function(i,j){'use strict';var k={};k.sidecol=this.sidecol;k.path=j.getPath();k[this.keyParam]=i.textKey;k.key=i.textKey;return k;};h.prototype._useAjaxPipe=function(i){'use strict';return this.ajaxPipe||this.ajaxPipeEndpoints[i];};h.prototype.navigationComplete=function(){'use strict';this.loading&&this.setSelected(this.loading);};h.prototype.navigationFailed=function(){'use strict';this.setLoading(null);};h.prototype.navigationSelect=function(i,j){'use strict';var k=this._getItemForKey(this._getKey(j));if(j.asLoading){this.setLoading(k);}else this.setSelected(k);};h.prototype.navigationCountUpdate=function(i,j){'use strict';var k=this._getItemForKey(j&&j.key);if(k)if(typeof j.count!=="undefined"){k.setCount(j.count,j.hide);}else if(typeof j.increment!=="undefined")k.incrementCount(j.increment,j.hide);};h.prototype.navigationCountUpdateFromPresence=function(i,j){'use strict';j=j.obj;if(j)if(!j.class_name||j.class_name&&c('CSS').hasClass(this.root,j.class_name))if(j.items)for(var k=0;k<j.items.length;k++)this.navigationCountUpdate(i,j.items[k]);};h.prototype.beginEdit=function(i){'use strict';if(!this.editing){this.editing=true;c('CSS').addClass(this.root,'editMode');this._updateTrackingData();this._initEditor(i);}};h.prototype.endEdit=function(){'use strict';if(this.editing){c('CSS').removeClass(this.root,'editMode');this.editor&&this.editor.endEdit();this.editor=null;this.editing=false;this._updateTrackingData();}};h.prototype._updateTrackingData=function(i){'use strict';var j=this.root.getAttribute('data-gt')||"{}";try{j=JSON.parse(j);if(this.editing){j.editing=true;}else delete j.editing;this.root.setAttribute('data-gt',JSON.stringify(j));}catch(k){}};h.prototype._initEditor=function(i){'use strict';i.getEditorAsync(function(j){if(this.editing){this.editor=j;this.editor.beginEdit();}}.bind(this));};h.getInstance=function(){'use strict';return h.instance||new h();};h.initMenu=function(i,j){'use strict';j.subscribe('itemclick',function(k,l){var m=h.getInstance(),n=i.getTriggerElem(),o=m._getSectionForNode(n),p=m._getItemForNode(n);m._handleMenuItemClick(l.item.getValue(),o,p);});};h.initSectionGlobally=function(i,j){'use strict';h.getInstance().initSection(i,j);};h.instance=null;f.exports=h;}),null);
__d('TimelineAllActivitySideNav',['csx','$','CSS','DOMQuery','FutureSideNav','PageTransitions','Scroll','Style','UIPagelet','ge','getOrCreateDOMID','getViewportDimensions'],(function a(b,c,d,e,f,g,h){function i(k){var l=k==='review'||k==='tagreview',m=c('ge')('rightColContent'),n=m&&c('DOMQuery').scry(m,".fbTimelineLogScrubber")[0];n&&c('CSS').conditionShow(n,!l);}var j={init:function k(l,m,n,o,p){var q=c('DOMQuery').find(c('$')('contentArea'),"._6-0"),r=c('getOrCreateDOMID')(q);c('Style').set(q,'minHeight',c('getViewportDimensions')().height+'px');c('CSS').addClass(l,'fixed_elem');i(p||'all');c('PageTransitions').registerHandler(function(s){var t;if(m===s.getPath()&&s.getQueryData().sk==n){var t=function(){var u=babelHelpers['extends']({profile_id:o,renderContentsOnly:1,uripath:s.toString()},s.getQueryData()),v=c('FutureSideNav').getInstance(),w=v&&v._getItemForKey(u.log_filter||'all');w&&v.setLoading(w);c('UIPagelet').loadFromEndpoint('TimelineAllActivityColumn',r,u,{jsNonblock:true,constHeight:true,displayCallback:function x(y){y();w&&v.setSelected(w);c('Scroll').setTop(document.body,0);i(u.log_filter||'all');c('PageTransitions').transitionComplete(true);}});return {v:true};}();if(typeof t==="object")return t.v;}return false;});}};f.exports=j;}),null);
__d('DetailedSearchFilterPage',['Arbiter','DetailedSearchOptions','DOM','Input','Run','$','ge'],(function a(b,c,d,e,f,g){var h={setQuery:function i(j){if(!c('DetailedSearchOptions').isFacebar)c('Input').setValue(c('$')('q'),j);},setFilter:function i(j,k){var l=c('DOM').create('input',{type:'hidden',name:'type',value:j});c('DOM').insertAfter(c('ge')('q'),l);var m;if(j==='web'){m=c('DOM').create('input',{type:'hidden',name:'form',value:k});c('DOM').insertAfter(c('ge')('q'),m);}c('Run').onLeave(function(){c('DOM').remove(l);if(m)c('DOM').remove(m);});c('Arbiter').inform('search/typeahead/updateFilter',{filter_type:j},c('Arbiter').BEHAVIOR_STATE);},setShowWebResults:function i(j,k){this.setFilter('web',k);var l=c('$')('searchBarClickRef').action;c('$')('searchBarClickRef').action=j;var m=c('Arbiter').subscribe('page_transition',function(n,o){c('$')('searchBarClickRef').action=l;c('Arbiter').unsubscribe(m);},c('Arbiter').SUBSCRIBE_NEW);c('Arbiter').inform('search/typeahead/updateSeeMoreEndpoint',j,c('Arbiter').BEHAVIOR_STATE);}};f.exports=h;}),null);
__d("XPartnersPortalMobileSettingsController",["XController"],(function a(b,c,d,e,f,g){f.exports=c("XController").create("\/mobile\/settings\/",{carrier_id:{type:"Int"},partner_id:{type:"Int"},portal:{type:"Enum",enumType:1},ref:{type:"Enum",enumType:1},current_tab:{type:"String"}});}),null);
__d('SettingsController',['Arbiter','Banzai','Bootloader','CSS','CurrentUser','DOM','DOMQuery','Event','NotifUserSettingActionTypedLogger','PageTransitions','Parent','Style','URI','XPartnersPortalMobileSettingsController','ge'],(function a(b,c,d,e,f,g){var h=null,i=null;function j(){return new (c('URI'))(window.location.href).getQueryData().tab||'account';}function k(){return new (c('URI'))(window.location.href).getQueryData().section;}function l(){return new (c('URI'))(window.location).getQueryData().id;}function m(){return new (c('URI'))(window.location).getQueryData().partner_id;}function n(v){return new (c('URI'))(v).addQueryData({view:null});}function o(v){return c('Parent').byClass(v,'fbSettingsListItem');}function p(v){return c('Parent').byClass(v,'fbSettingsListLink');}function q(v){return c('Parent').byClass(v,'cancel');}function r(){return new (c('URI'))(window.location).getPath();}function s(){return '/pages/edit/';}function t(){return c('XPartnersPortalMobileSettingsController').getURIBuilder().getURI().toString();}var u={init:function v(w,x,y){this.extra_params=y||{};c('Event').listen(w,'click',function(ba){var ca=ba.getTarget();if(q(ca))this.closeEditor();}.bind(this));c('PageTransitions').registerHandler(function(ba){var ca=ba.getQueryData();if(ba.getPath()==r()&&ca.tab===j()&&typeof ca.view!=='undefined'){c('PageTransitions').transitionComplete();if(ca.section){this._currentSection=ca.section;c('Arbiter').inform('section_toggle',{action:'expand',section:this._currentSection});}return true;}if(ca.tab!=j()||ba.getPath()!==r()){this._sectionArbiter&&this._sectionArbiter.unsubscribe();this._sectionArbiter=null;this._masherEventHandler&&this._masherEventHandler.remove();this._masherEventHandler=null;this._selectorEventHandler&&this._selectorEventHandler.remove();this._selectorEventHandler=null;if(ba.getPath()==='/settings'){c('Banzai').post(this._banzaiRoute,{event:'settings_link',exit_point:ca.tab+'_settings'});}else{var da=ba.getPath();if(ba.getQueryData().audience_usered)da='composer_link';c('Banzai').post(this._banzaiRoute,{event:'exit_settings_page',exit_point:da});}this._banzaiRoute=null;}}.bind(this));var z=k();if(z){var aa=x+':'+z;this.scrollToActiveSection(aa);}},scrollToActiveSection:function v(w){var x=document.getElementById(w);if(x){x.scrollIntoView();}else setTimeout(function(){this.scrollToActiveSection(w);}.bind(this),250);},getQueryString:function v(w,x){if(x==null)return null;var y=x?x:window.location.href,z=new RegExp('[?&]'+w+'=([^&#]*)','i'),aa=z.exec(y);return aa?aa[1]:null;},handleLinkClick:function v(w){var x=j(),y=k(),z=this.getQueryString('section',w),aa=c('CurrentUser').getID();if(x==='notifications'){var ba=new (c('NotifUserSettingActionTypedLogger'))().setEventType('click').setSource('web_settings_page').setPrevState(y).setCurState(z).setControllerClass('SettingsController').setWantLess(false).setRecipID(parseInt(aa,10));ba.log();}if(h&&h.checkUnsaved())return false;if(i!==w)i&&c('CSS').removeClass(i,'async_saving');i=w;var ca=w.getAttribute('data-meta'),da=JSON.parse(ca);switch(da.rel){case 'async':c('Bootloader').loadModules(["AsyncRequest"],function(ea){ea.bootstrap(da.ajaxify,w);},'SettingsController');break;case 'dialog':c('Bootloader').loadModules(["AsyncDialog"],function(ea){ea.bootstrap(da.ajaxify,w,da.rel);},'SettingsController');break;default:throw new Error('SettingsController.handleLinkClick: Unexpected "rel".');}},updateErrors:function v(w,x){if(h){h.hideErrors();h.showError(w,x);}},hideErrors:function v(){h&&h.hideErrors();},getEditor:function v(){return h;},setEditor:function v(w){if(!w||!i||w.contains(i))if(this.closeEditor()!==false){i&&c('PageTransitions').go(n(i.href));i=null;(h=w)&&w.show();}},prepareAndReplaceEditor:function v(w){w.prepare(h.container);h=w;},prepareAndSetEditor:function v(w,x,y){var z=o(w);u.setEditor(x.prepare(z,y));},closeEditor:function v(){if(h&&h.hide()!==false){c('Arbiter').inform('section_toggle',{action:'collapse',section:this._currentSection});if(c('DOM').contains(document.body,h.container)){var w=null,x=r(),y={tab:j()};if(x==s()){y.id=l();}else if(x==t())y.partner_id=m();for(var z in this.extra_params)if(Object.prototype.hasOwnProperty.call(this.extra_params,z))y[z]=this.extra_params[z];w=new (c('URI'))(x).setQueryData(y);c('PageTransitions').go(n(w));}h=null;}return !h;},setPreviewForCurrent:function v(w){u.setPreview(h.container,w);},setPreview:function v(w,x){var y=c('DOM').find(o(w),'span.fbSettingsListItemContent');c('DOM').setContent(y,x);},closeAndAnimateEdited:function v(){var w=h.container;u.closeEditor();u.animateEditedListItem(w);},animateEdited:function v(w){u.animateEditedListItem(o(w));},animateEditedListItem:function v(w){c('Bootloader').loadModules(["Animation"],function(x){var y=c('DOM').find(w,'span.fbSettingsListItemEdit'),z=c('DOM').find(w,'span.fbSettingsListItemSaved');c('CSS').hide(y);c('CSS').show(z);c('Style').set(y,'opacity',0);new x(p(y)).from('background','#fff8bb').to('background','#fff').duration(1000).ease(x.ease.begin).ondone(function(){c('CSS').removeClass(w,'fbSettingsListItemEdited');c('Style').set(this.obj,'background','');new x(z).to('color','#fff').duration(500).ease(x.ease.begin).ondone(function(){c('CSS').hide(z);c('Style').set(z,'color','');c('CSS').show(y);new x(y).to('opacity',1).duration(500).ease(x.ease.begin).go();}).go();}).go();},'SettingsController');},registerSectionLogging:function v(w){this._banzaiRoute=w;this._sectionArbiter=c('Arbiter').subscribe('section_toggle',function(x,y){c('Banzai').post(w,{event:y.section+'_'+y.action});}.bind(this));},registerSelectorLogging:function v(w,x,y,z,aa){w=w.getInstance();w.subscribe('open',function(){c('Banzai').post(aa,{event:x});});w.subscribe('close',function(){c('Banzai').post(aa,{event:y});});w.subscribe('changed',function(){c('Banzai').post(aa,{event:z});});},registerNonAdamaSelectorLogging:function v(w,x,y,z,aa){this._selectorValue=aa;this._selectorEventHandler=c('Event').listen(z,'click',function(){if(c('DOMQuery').scry(z,'.openToggler').length===0){c('Banzai').post(w,{event:x});}else c('Banzai').post(w,{event:y});});},setComposerNUXText:function v(w,x){var y=c('ge')(w);y&&c('DOM').setContent(y,x);},registerNonAdamaSelectorChange:function v(w,event,x){if(x!=this._selectorValue){this._selectorValue=x;c('Banzai').post(w,{event:event});}},registerMasherLogging:function v(w,event){this._masherEventHandler=c('Event').listen(w,'click',function(){c('Banzai').post('privacy_settings',{event:event});});}};f.exports=u;}),null);
__d("XSettingsExitSurveyController",["XController"],(function a(b,c,d,e,f,g){f.exports=c("XController").create("\/settings\/exit_survey\/",{current_tab:{type:"String",required:true}});}),null);
__d('SettingsExitSurvey',['AsyncRequest','Run','XSettingsExitSurveyController'],(function a(b,c,d,e,f,g){var h={launchOnExit:function i(j){var k=c('XSettingsExitSurveyController').getURIBuilder().setString('current_tab',j).getURI();c('Run').onLeave(function(){return new (c('AsyncRequest'))().setURI(k).setAllowCrossPageTransition(true).send();});}};f.exports=h;}),null);
__d('SelectorSubmitOnChange',['Parent','submitForm'],(function a(b,c,d,e,f,g){function h(i){'use strict';this._selector=i;}h.prototype.enable=function(){'use strict';this._subscription=this._selector.subscribe('change',this._onChange.bind(this));};h.prototype.disable=function(){'use strict';this._subscription.unsubscribe();this._subscription=null;};h.prototype._onChange=function(){'use strict';var i=c('Parent').byTag(this._selector.getButton(),'form');i&&c('submitForm')(i);};Object.assign(h.prototype,{_subscription:null});f.exports=h;}),null);
__d('legacy:ui-side-nav-future-js',['FutureSideNav'],(function a(b,c,d,e,f,g){b.FutureSideNav=c('FutureSideNav');}),3);