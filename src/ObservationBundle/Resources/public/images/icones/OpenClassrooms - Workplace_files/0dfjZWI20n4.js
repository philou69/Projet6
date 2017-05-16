if (self.CavalryLogger) { CavalryLogger.start_js(["rOj1L"]); }

__d('LeftNavItemClassicDraggableContainer.react',['React','ReactDOM'],(function a(b,c,d,e,f,g){'use strict';var h,i,j=c('React').PropTypes;h=babelHelpers.inherits(k,c('React').Component);i=h&&h.prototype;k.prototype.render=function(){return c('React').createElement('div',{'data-itemid':this.props.itemID},this.props.children);};k.prototype.componentDidMount=function(){var l=this.props,m=l.section,n=l.itemID,o=l.draggableBound,p=l.ItemDraggableBehavior;if(p&&!this.draggable)this.draggable=new p(c('ReactDOM').findDOMNode(this),m,n,o);};k.prototype.componentWillUnmount=function(){this.draggable.destroy();this.draggable=null;};function k(){h.apply(this,arguments);}k.propTypes={itemID:j.oneOfType([j.string,j.number]).isRequired,section:j.object.isRequired,draggableBound:j.object,ItemDraggableBehavior:j.func};f.exports=k;}),null);
__d('LeftNavItem.react',['cx','fbt','Arbiter','BootloadedComponent.react','DOMContainer.react','Image.react','formatNumber','LeftNavItemClassicDraggableContainer.react','Link.react','JSResource','React','UnicodeBidi','XUISpinner.react','ifRequired'],(function a(b,c,d,e,f,g,h,i){'use strict';var j,k,l=c('React').createElement('span',{className:"_2-ky"}),m=c('React').createElement(c('XUISpinner.react'),{className:'uiSideNavSpinner'});j=babelHelpers.inherits(n,c('React').Component);k=j&&j.prototype;function n(o){k.constructor.call(this,o);this.state=babelHelpers['extends']({},this.$LeftNavItem1(o),{hasUsedPopoverMenu:false,showPopoverOnMount:false});}n.prototype.componentWillReceiveProps=function(o){var p=this.$LeftNavItem1(o);if(o.inEditMode)p.showPopoverOnMount=false;this.setState(p);};n.prototype.$LeftNavItem1=function(o){var p=o.model,q=o.section.props.id,r=p.count>0,s=q==='pinnedNav'&&p.sortable,t=q==='bookmarksSeeAllEntSection',u=p.keys.some(function(x){return x===o.selectedKey;}),v=p.keys.some(function(x){return x===o.loadingKey;}),w=s&&o.inEditMode;return {hasCount:r,hasSortableItems:s,inSeeAllSection:t,isSelected:u,isLoading:v,isSorting:w};};n.prototype.render=function(){var o=this.props.model,p=this.state;return c('React').createElement('li',{className:"clearfix"+(' '+"sideNavItem")+(' '+"stat_elem")+(p.isSelected?' '+"selectedItem":'')+(p.isLoading?' '+"_5afd":''),'data-sortable':p.isSorting?o.sortable:null,id:'navItem_'+o.id},this.$LeftNavItem2(this.$LeftNavItem3()));};n.prototype.$LeftNavItem3=function(){var o=this.props.model,p=this.props.section,q=this.state,r=c('UnicodeBidi').isDirectionRTL(o.name)?'rtl':'ltr',s=c('React').createElement('a',{key:'link','data-testid':'left_nav_item_'+o.link.title,className:"_5afe"+(q.hasSortableItems?' '+"sortableItem":''),'data-gt':o.datagt,title:o.link.title,rel:o.link.rel,href:o.link.href,target:o.link.target,ajaxify:o.link.ajaxify,draggable:'false',onClick:function(){return this.$LeftNavItem4(o);}.bind(this)},this.$LeftNavItem5(o),this.$LeftNavItem6(o.image),c('React').createElement('div',{dir:r,className:"linkWrap"+(q.hasCount?' '+"hasCount":'')+(!q.hasCount?' '+"noCount":'')},c('React').createElement('span',null,o.name),q.inSeeAllSection?this.$LeftNavItem7(o.count):null));return [o.auxcontent?c('React').createElement(c('DOMContainer.react'),{key:'auxpopover'},o.auxcontent):null,this.$LeftNavItem8(o,p,this.props.loadDragDropModules,this.state.hasUsedPopoverMenu),s];};n.prototype.$LeftNavItem8=function(o,p,q,r){if(!o.editmenu)return null;var s=function(){this.setState({hasUsedPopoverMenu:true,showPopoverOnMount:true});q&&q();}.bind(this),t=i._("Edit {Link name} link",[i.param('Link name',o.name)]),u=c('React').createElement(c('Link.react'),{href:'#',title:t,'aria-label':t,onClick:r?null:s,className:"_1wc5 _26tg _1iiv"});if(r)u=c('React').createElement(c('BootloadedComponent.react'),{bootloadPlaceholder:u,bootloadLoader:c('JSResource')('BookmarkPopoverMenu.react').__setRef('LeftNavItem.react'),module:'BookmarkPopoverMenu.react',navSection:p,model:o,showOnMount:this.state.showPopoverOnMount},u);return c('React').createElement('div',{className:'buttonWrap',key:'popover'},c('React').createElement('div',{className:'uiSideNavEditButton'},u));};n.prototype.$LeftNavItem6=function(o){return c('React').createElement('span',{className:'imgWrap','data-testid':'bookmark_icon_'+(this.state.inSeeAllSection?'see_all':'left_nav')},c('React').createElement(c('Image.react'),{src:o,draggable:'false',alt:''}));};n.prototype.$LeftNavItem7=function(o){if(!this.state.hasCount)return null;return c('React').createElement('span',{className:"countValue"+(' '+"_2jgb")},c('formatNumber').withMaxLimit(o,20));};n.prototype.$LeftNavItem5=function(o){var p=this.state;if(p.inSeeAllSection)return null;var q=p.hasCount&&!p.isSorting;if(p.isLoading||q||p.isSorting)return c('React').createElement('div',{className:'rfloat'},p.isLoading?m:null,q?this.$LeftNavItem7(o.count):null,p.isSorting?l:null);return null;};n.prototype.$LeftNavItem2=function(o){if(!this.state.isSorting)return o;return c('React').createElement(c('LeftNavItemClassicDraggableContainer.react'),{itemID:this.props.model.id,section:this.props.section,draggableBound:this.props.draggableBound,ItemDraggableBehavior:this.props.ItemDraggableBehavior},o);};n.prototype.$LeftNavItem4=function(o){c('Arbiter').inform('LeftNavController/setItemCount',{item:o,count:0});if(o&&o.type==='type_explore_feed')c('Arbiter').inform('LeftNavController/topicFeedClick',o.id);};f.exports=n;}),null);
__d('LeftNavItemPlaceholder.react',['cx','React'],(function a(b,c,d,e,f,g,h){'use strict';var i,j;i=babelHelpers.inherits(k,c('React').Component);j=i&&i.prototype;k.prototype.render=function(){return c('React').createElement('li',{className:'sideNavItem stat_elem'},c('React').createElement('a',{className:"_5afe clearfix sortableItem"}));};function k(){i.apply(this,arguments);}f.exports=k;}),null);
__d('LeftNavSection.react',['cx','fbt','Arbiter','Bootloader','InlineBlock.react','LeftNavItem.react','LeftNavItemPlaceholder.react','LeftRight.react','Link.react','React','ReactDOM'],(function a(b,c,d,e,f,g,h,i){'use strict';var j,k,l='more';j=babelHelpers.inherits(m,c('React').Component);k=j&&j.prototype;function m(){var n,o;for(var p=arguments.length,q=Array(p),r=0;r<p;r++)q[r]=arguments[r];return o=(n=k.constructor).call.apply(n,[this].concat(q)),this.state={inEditMode:false,draggableBound:null,placeholderIdx:-1},o;}m.prototype.render=function(){var n=this,o=this.props,p=o.ItemDraggableBehavior,q=o.loadingKey,r=o.loadDragDropModules,s=o.model,t=o.selectedKey,u=s.items,v=this.state,w=v.inEditMode,x=v.draggableBound;if(u.length===0)return null;var y=this.$LeftNavSection1(l,this.props),z=s.welcomebox?s.welcomebox:'left_nav_section_'+(s.title||'FAVORITES'),aa=u.map(function(da){da.datagt=this.$LeftNavSection1('item',this.props,da.datagt);return c('React').createElement(c('LeftNavItem.react'),{key:da.id,model:da,section:n,selectedKey:t,loadingKey:q,inEditMode:w,draggableBound:x,loadDragDropModules:r,ItemDraggableBehavior:p});},this);if(this.state.placeholderIdx>=0)aa.splice(this.state.placeholderIdx,0,c('React').createElement(c('LeftNavItemPlaceholder.react'),{key:'itemplaceholder',ref:'placeholder'}));var ba="_bui"+(this.$LeftNavSection2()?' '+"droppableNav":'')+(!this.$LeftNavSection2()?' '+"nonDroppableNav":'')+(!w?' '+"_3-96":''),ca=this.$LeftNavSection2()?c('React').createElement('div',{className:"_3hge _3hgf"},c('React').createElement(c('Link.react'),{className:'navEditDone',ref:'Donelink',onClick:function da(){c('Bootloader').loadModules(["LeftNavDragController"],function(){c('Arbiter').inform('LeftNavDragController/toggleEditMode',{section:n});},'LeftNavSection.react');}},i._("Done"))):null;return c('React').createElement('div',{id:this.props.id,className:"homeSideNav",'data-ft':s.dataft,'data-testid':z},this.$LeftNavSection3(y),c('React').createElement('ul',{className:ba,'data-ft':s.dataft},aa),ca);};m.prototype.componentDidUpdate=function(n,o){if(this.state.inEditMode)c('ReactDOM').findDOMNode(this.refs.Donelink).focus();};m.prototype.$LeftNavSection3=function(n){var o=this.props.model,p=void 0;if(o.title){var q=o.seeallhref&&!o.seeallbelow?c('React').createElement(c('Link.react'),{href:o.seeallhref,'data-gt':n},c('React').createElement(c('LeftRight.react'),null,c('React').createElement('span',{className:'sectionDragHandle'},o.title),o.remainingcount?c('React').createElement(c('InlineBlock.react'),{className:"_3-91"},c('React').createElement('div',{'data-testid':"left_nav_section_MORE",className:"_1cwg _5ol3"},o.seealltext)):null)):c('React').createElement('span',{className:'sectionDragHandle'},o.title);p=c('React').createElement('h4',{className:'navHeader'},q);}else p=null;return p;};m.prototype.$LeftNavSection2=function(){return this.props.id==='pinnedNav';};m.prototype.$LeftNavSection1=function(n,o,p){var q=o.id,r=o.model,s=o.total;p=p?JSON.parse(p):{};if(q!=='bookmarksSeeAllEntSection'){p.masher=n.toString();p.total=s.toString();}if(n===l){p.nav_section=r.id;p.nav_items_count=r.items?r.items.length:0;p.remaining_count=r.remainingcount;}p=JSON.stringify(p);return p;};f.exports=m;}),null);
__d('LeftNavSectionPlaceholder.react',['cx','React'],(function a(b,c,d,e,f,g,h){'use strict';var i,j;i=babelHelpers.inherits(k,c('React').Component);j=i&&i.prototype;k.prototype.render=function(){var l={height:this.props.height+'px',width:this.props.width+'px'};return c('React').createElement('div',{className:'homeSideNav',style:l},c('React').createElement('ul',{className:"_bui"}));};function k(){i.apply(this,arguments);}f.exports=k;}),null);
__d('LeftNavContainer.react',['invariant','Bootloader','LeftNavSection.react','LeftNavSectionPlaceholder.react','React','emptyFunction'],(function a(b,c,d,e,f,g,h){'use strict';function i(k){k.setState({loadDragDropModules:c('emptyFunction')});c('Bootloader').loadModules(["LeftNavDragController","LeftNavItemDraggableBehavior"],function(l,m){l.subscribe();k.setState({DragController:l,ItemDraggableBehavior:m});},'LeftNavContainer.react');}var j=c('React').createClass({displayName:'LeftNavContainer',getInitialState:function k(){return {placeholderIdx:-1,placeholderWidth:0,placeholderHeight:0,loadDragDropModules:function(){return i(this);}.bind(this),DragController:null,ItemDraggableBehavior:null};},componentDidMount:function k(){var l=this.state.DragController;if(l)l.subscribe();},componentWillUnmount:function k(){var l=this.state.DragController;if(l)l.unsubscribe();},render:function k(){var l=this.props.model,m=c('React').createElement(c('LeftNavSection.react'),{selectedKey:l.selectedKey,loadingKey:l.loadingKey,model:l.userSection,key:'userNav',id:'userNav',ref:'userNav',total:l.total}),n=c('React').createElement(c('LeftNavSection.react'),{selectedKey:l.selectedKey,loadingKey:l.loadingKey,model:l.pinnedSection,key:'pinnedNav',id:'pinnedNav',ref:'pinnedNav',loadDragDropModules:this.state.loadDragDropModules,ItemDraggableBehavior:this.state.ItemDraggableBehavior,total:l.total}),o=l.sections.map(function(p){return c('React').createElement(c('LeftNavSection.react'),{selectedKey:l.selectedKey,loadingKey:l.loadingKey,model:p,key:p.id,id:p.id,loadDragDropModules:this.state.loadDragDropModules,ItemDraggableBehavior:this.state.ItemDraggableBehavior,total:l.total});}.bind(this));if(this.state.placeholderIdx>-1)o.splice(this.state.placeholderIdx,0,c('React').createElement(c('LeftNavSectionPlaceholder.react'),{key:'placeholder',width:this.state.placeholderWidth,height:this.state.placeholderHeight}));return c('React').createElement('div',null,m,n,o);},getPinnedSection:function k(){var l=this.refs.pinnedNav;l||h(0);return l;}});f.exports=j;}),null);
__d('LeftNavModel',['URI'],(function a(b,c,d,e,f,g){'use strict';var h=void 0,i=null,j={init:function k(l){h=l;},initAdditionalItems:function k(l){i=l.items;},setSelectedKey:function k(l){h.loadingKey=null;h.selectedKey=l||h.defaultKey;},setLoadingKey:function k(l){h.loadingKey=l;},setItemCount:function k(l,m){l.count=m||0;},updateItemCounts:function k(l,m){var n=false;m.forEach(function(o){var p=void 0,q=j.findItemByKey(o.key);if(q){p=q.count;if(o.count!==undefined){q.count=o.count;}else if(o.increment!==undefined)q.count+=o.increment;n=n||p!=o.count;}});return n;},findItemByKey:function k(l){return j.findItem(function(m){return m.keys.some(function(n){return n===l;});});},findItem:function k(l){var m=void 0;if(h.pinnedSection){m=h.pinnedSection.items.find(l);if(m)return m;}if(h.pinnedSection.default_count>0){m=j._findItemInFlyout(l);if(m)return m;}for(var n=0;n<h.sections.length;n++){m=h.sections[n].items.find(l);if(m)return m;}if(i){m=i.find(l);if(m)return m;}return null;},findItemByURI:function k(l){var m=l.getQueryData().sk;if(m){return j.findItemByKey(m);}else if(j._isHomePath(l)){return j.findItemByKey(h.defaultKey);}else return j.findItem(function(n){if(n.link&&new (c('URI'))(n.link.href).qualify().getSubdomain()!==l.getSubdomain())return false;return n.path&&n.path.some(function(o){if(typeof o==='object'&&o.regex)return l.getPath().match(o.regex);return o===l.getPath();});});},_isHomePath:function k(l){var m=c('URI').getRequestURI();return l.getDomain()===m.getDomain()&&(l.getPath()==='/'||l.getPath()==='/home.php');},_findItemInFlyout:function k(l){var m=void 0;h.pinnedSection.items.some(function(n){if(n&&n.flyout_items){m=n.flyout_items.find(l);if(m)return true;}return false;});return m;}};f.exports=j;}),null);
__d("XFeedTopicRefreshLoadTimeController",["XController"],(function a(b,c,d,e,f,g){f.exports=c("XController").create("\/feed\/topic\/refresh\/loadtime\/",{});}),null);
__d('LeftNavController',['cx','Arbiter','AsyncRequest','Bootloader','ChannelConstants','LeftNavContainer.react','LeftNavModel','NavigationMessage','PageTransitionPriorities','React','ReactDOM','Run','SubscriptionsHandler','XFeedTopicRefreshLoadTimeController','CSS'],(function a(b,c,d,e,f,g,h){'use strict';var i=[],j=void 0,k=void 0,l=void 0,m=void 0,n={init:function u(v,w){k=v;c('LeftNavModel').init(w);var x=function z(aa){c('Bootloader').loadModules(["LeftNavActions"],function(ba){ba.initModel(w);aa(ba);o();},'LeftNavController');};l=new (c('SubscriptionsHandler'))();l.addSubscriptions(c('Arbiter').subscribe('LeftNavController/toggleFavorite',function(z,aa){return x(function(ba){return ba.toggleFavorite(z,aa,i);});}),c('Arbiter').subscribe('LeftNavController/updatePinnedSection',function(z,aa){var ba=aa.idOrder;return x(function(ca){return ca.updatePinnedSection(z,ba);});}),c('Arbiter').subscribe('LeftNavController/setItemCount',function(z,aa){var ba=aa.item,ca=aa.count;c('LeftNavModel').setItemCount(ba,ca);o();}),c('Arbiter').subscribe('LeftNavController/topicFeedClick',function(z,aa){new (c('AsyncRequest'))(c('XFeedTopicRefreshLoadTimeController').getURIBuilder().getURI()).setData({topic_id:aa}).setMethod('POST').send();}),c('Arbiter').subscribe(c('ChannelConstants').getArbiterType('nav_update_counts'),function(z,aa){var ba=aa.obj.items,ca=c('LeftNavModel').updateItemCounts(z,ba);if(ca)o();}),c('Arbiter').subscribeOnce('AsyncLayout/initialized',function(){return m=true;}),c('Arbiter').subscribe(c('NavigationMessage').NAVIGATION_ITEM_REMOVED,function(z,aa){return x(function(ba){return ba.removeItemByKey(z,aa);});}),c('Arbiter').subscribe(c('NavigationMessage').NAVIGATION_COMPLETED,function(){c('LeftNavModel').setSelectedKey(w.loadingKey);o();}),c('Arbiter').subscribe(c('NavigationMessage').NAVIGATION_FAILED,function(){c('LeftNavModel').setLoadingKey(null);o();}),c('Arbiter').subscribe(c('NavigationMessage').NAVIGATION_COUNT_UPDATE,function(z,aa){var ba=c('LeftNavModel').findItemByKey(aa&&aa.key);if(ba){var ca=ba.count,da=aa.count||0;c('LeftNavModel').setItemCount(ba,aa.hide?0:da);if(da!==ca||aa.hide&&ca>0)o();}}),c('Arbiter').subscribe(c('NavigationMessage').NAVIGATION_SELECT,function(z,aa){var ba=aa.sk;if(aa.asLoading){c('LeftNavModel').setLoadingKey(ba);}else c('LeftNavModel').setSelectedKey(ba);}),c('Arbiter').subscribe('LeftNavDragController/toggleEditMode',function(){return c('CSS').toggleClass(k,"_2ryg");}),c('Arbiter').subscribe('LeftNavController/updateFoldPinnedSection',function(z,aa){var ba=aa.idOrder;return x(function(ca){return ca.updateFoldPinnedSection(z,ba);});}),c('Arbiter').subscribe('UnfollowUser',function(z,aa){var ba=aa.profile_id;return x(function(ca){return ca.removeItemByKey(z,'profile_'+ba);});}));var y=c('LeftNavModel').findItemByKey(w.selectedKey);if(y)y.count=0;j=c('ReactDOM').render(c('React').createElement(c('LeftNavContainer.react'),{model:w}),k);c('Run').onLeave(this.uninstall.bind(this));},uninstall:function u(){m=false;l.release();if(j.componentWillUnmount)j.componentWillUnmount();},initAdditionalItems:function u(v){c('LeftNavModel').initAdditionalItems(v);},initPageTransitions:function u(v){v.registerHandler(function(w){return m&&p(w);},c('PageTransitionPriorities').LEFT_NAV);},mountSeeAllPayload:function u(v){i.push(v);}};function o(){j.forceUpdate();}function p(u){var v=c('LeftNavModel').findItemByURI(u);return v&&v.endpoint&&q(v,u);}function q(u,v){c('LeftNavModel').setLoadingKey(u.keys[0]);c('LeftNavModel').setItemCount(u,0);o();s(u.endpoint,babelHelpers['extends']({},r(u,v),v.getQueryData()));return true;}function r(u,v){var w={};w.sidecol=true;w.path=v.getPath();var x=t(u.keys);x=x.text?x.text:x.numeric;w.sk=x;w.key=x;return w;}function s(u,v){v.endpoint=u;c('Arbiter').inform(c('NavigationMessage').NAVIGATION_BEGIN,{useAjaxPipe:true,params:v});}function t(u){var v=/^(app|group|fl)_/,w={};for(var x=0;x<u.length;x++){var y=v.test(u[x]);if(y&&!w.numeric){w.numeric=u[x];}else if(!y&&!w.text)w.text=u[x];if(w.numeric&&w.text)break;}return w;}f.exports=n;}),null);
__d('BookmarkSeeAllEntsSectionController',['LeftNavController','LeftNavSection.react','React','ReactDOM','Arbiter','Run','SubscriptionsHandler','NavigationMessage'],(function a(b,c,d,e,f,g){'use strict';var h=[],i=false,j=void 0,k={init:function p(q,r){if(!i){j=new (c('SubscriptionsHandler'))();j.addSubscriptions(c('Arbiter').subscribe('LeftNavController/toggleFavorite',m),c('Arbiter').subscribe(c('NavigationMessage').NAVIGATION_ITEM_REMOVED,n));c('Run').onLeave(this.uninstall.bind(this));}i=true;h.push([q,r]);c('LeftNavController').mountSeeAllPayload(r);l(q,r);},uninstall:function p(){j.release();}};function l(p,q){var r={items:q,remainingcount:0},s=c('React').createElement(c('LeftNavSection.react'),{model:r,id:'bookmarksSeeAllEntSection'});c('ReactDOM').render(c('React').createElement('div',null,s),p);}function m(p,q){h.some(function(r){var s=r[0],t=r[1],u=t.find(function(v){return v.id===q;});if(u){u.pinned=!u.pinned;l(s,t);return true;}return false;});}function n(p,q){function r(s,t){return s.keys.some(function(u){return u===t;});}h.some(function(s){var t=s[0],u=s[1];if(o(u,function(v){return r(v,q);})){l(t,u);return true;}return false;});}function o(p,q){for(var r=0;r<p.length;r++)if(q(p[r])){var s=p[r];p.splice(r,1);return s;}return undefined;}f.exports=k;}),null);