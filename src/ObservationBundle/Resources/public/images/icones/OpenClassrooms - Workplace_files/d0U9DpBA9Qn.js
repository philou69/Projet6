if (self.CavalryLogger) { CavalryLogger.start_js(["7NCmx"]); }

__d("XEventReactionPermalinkAsyncController",["XController"],(function a(b,c,d,e,f,g){f.exports=c("XController").create("\/events\/{event_id}\/ajax\/permalink\/reaction\/",{acontext:{type:"String"},event_id:{type:"Int",required:true},active_tab:{type:"Enum",defaultValue:"about",enumType:1}});}),null);
__d('EventComposerSuccessMessage.react',['cx','fbt','AsyncRequest','EventsPermalinkTabBar','Link.react','React','XEventReactionPermalinkAsyncController','XUICard.react'],(function a(b,c,d,e,f,g,h,i){var j,k,l=c('React').PropTypes;j=babelHelpers.inherits(m,c('React').Component);k=j&&j.prototype;m.prototype.render=function(){'use strict';var n=c('XEventReactionPermalinkAsyncController').getURIBuilder().setInt('event_id',this.props.eventID).setEnum('active_tab','discussion').getURI();return c('React').createElement(c('XUICard.react'),{className:"_340"},c('React').createElement('p',{className:"_342"},i._("{view_post_link} in the event discussion.",[i.param('view_post_link',c('React').createElement(c('Link.react'),{href:'#',onClick:function o(){new (c('AsyncRequest'))(n).send();c('EventsPermalinkTabBar').showWait();},className:"_39o"},'View your post'))])));};function m(){'use strict';j.apply(this,arguments);}m.propTypes={eventID:l.string};f.exports=m;}),null);
__d('EventsAboutTabComposer',['Arbiter','Bootloader','EventComposerSuccessMessage.react','React','ReactDOM','Run','SubscriptionsHandler'],(function a(b,c,d,e,f,g){var h=600;function i(k,l){c('Bootloader').loadModules(["Animation","ComposerXController","ComposerXMarauderLogger","DOM"],function(m,n,o,p){var q=document.getElementById('eventComposerSuccess');if(q){c('ReactDOM').render(c('React').createElement(c('EventComposerSuccessMessage.react'),{eventID:l}),q);new m(q).from('opacity',0).to('opacity',1).duration(h).go();}o.logCompleted(k);},'EventsAboutTabComposer');}var j={initComposer:function k(l,m){var n=new (c('SubscriptionsHandler'))();n.addSubscriptions(c('Arbiter').subscribe('LitestandComposer/publish',function(o,p){if(p.composer_id===l)i(l,m);}));c('Run').onLeave(function(){n.release();});}};f.exports=j;}),null);
__d('EventPermalinkEventTips.react',['cx','fbt','Promise','regeneratorRuntime','Banzai','BoostedPostDialogButton.react','EventsActionsLogger','Image.react','Layout.react','Link.react','React','XUIButton.react','XUICard.react','XUICardHeader.react','XUICardHeaderTitle.react','XUICardSection.react','XUIText.react','joinClasses'],(function a(b,c,d,e,f,g,h,i){'use strict';var j,k,l=c('Layout.react').Column,m=c('Layout.react').FillColumn,n=c('React').PropTypes,o={SHOWING:'showing',HIDDEN:'hidden',APPEARING:'appearing',DISAPPEARING:'disappearing'},p={showing:"_5y4_",hidden:"_5y50",appearing:"_5y53",disappearing:"_5y55"};function q(t){return new (c('Promise'))(function(u){return setTimeout(u,t);});}function r(t,u,v,w,x,y){c('Banzai').post('events_education_unit_logging',{event_id:t,type:u,target:v,action_context:w,tip_type:x,tip_position:y});}j=babelHelpers.inherits(s,c('React').Component);k=j&&j.prototype;function s(){var t,u;for(var v=arguments.length,w=Array(v),x=0;x<v;x++)w[x]=arguments[x];return u=(t=k.constructor).call.apply(t,[this].concat(w)),this.state={selectedTip:0,tipState:o.SHOWING},this.handleNext=function(){var y=this.state.selectedTip;(function z(){return c('regeneratorRuntime').async(function aa(ba){while(1)switch(ba.prev=ba.next){case 0:this.setState({tipState:o.DISAPPEARING});ba.next=3;return c('regeneratorRuntime').awrap(q(150));case 3:this.setState({selectedTip:(y+1)%this.props.tipData.length,tipState:o.HIDDEN});ba.next=6;return c('regeneratorRuntime').awrap(q(100));case 6:this.setState({tipState:o.APPEARING});ba.next=9;return c('regeneratorRuntime').awrap(q(300));case 9:this.setState({tipState:o.SHOWING});case 10:case 'end':return ba.stop();}},null,this);}).bind(this)().done();r(this.props.eventID,c('EventsActionsLogger').Type.CLICK,c('EventsActionsLogger').Target.EDUCATION_UNIT_NEXT_LINK,this.props.actionContext,this.props.tipData[y].type,y);}.bind(this),this.$EventPermalinkEventTips1=function(y){if(y==null)return;y.addEventListener('click',function(z){r(this.props.eventID,c('EventsActionsLogger').Type.CLICK,c('EventsActionsLogger').Target.EDUCATION_UNIT_CTA,this.props.actionContext,this.props.tipData[this.state.selectedTip].type,this.state.selectedTip);}.bind(this),true);}.bind(this),u;}s.prototype.render=function(){var t=this.props.tipData[this.state.selectedTip],u=null;if(this.props.tipData.length>1)u=c('React').createElement(c('Link.react'),{onClick:this.handleNext},i._("Next Tip"));var v=null;if(t.ctaConfig.type==='button'){var w=t.ctaConfig.buttonConfig;v=c('React').createElement(c('XUIButton.react'),{className:"_3-8z _5y6q",use:'confirm',label:w.label,href:w.href,rel:w.rel,ajaxify:w.ajaxify,target:w.target,size:'large'});}else if(t.ctaConfig.type==='ad_button')v=c('React').createElement('div',{className:"_3-8z"},c('React').createElement(c('BoostedPostDialogButton.react'),babelHelpers['extends']({size:'large',showTooltip:false},t.ctaConfig.adButtonConfig.configData)));var x=c('React').createElement('div',{ref:this.$EventPermalinkEventTips1},v),y=c('React').createElement('div',{key:'tip',className:c('joinClasses')("_5y56",p[this.state.tipState])},c('React').createElement('div',{className:"_3-95"},c('React').createElement(c('XUIText.react'),{weight:'bold'},t.title)),c('React').createElement(c('Layout.react'),null,c('React').createElement(l,null,c('React').createElement('div',{className:"_2pib _2pi4"},c('React').createElement(c('Image.react'),{src:t.image_ix_map,width:'56',height:'56'}))),c('React').createElement(m,{className:"_3-9a _5y6k"},c('React').createElement('div',null,t.message),x)));if(this.state.tipState===o.SHOWING)r(this.props.eventID,c('EventsActionsLogger').Type.VIEW,c('EventsActionsLogger').Target.EDUCATION_UNIT,this.props.actionContext,t.type,this.state.selectedTip);return c('React').createElement(c('XUICard.react'),{className:"_3-96 _5y6r"},c('React').createElement(c('XUICardHeader.react'),{link:u,type:'secondary'},c('React').createElement(c('XUICardHeaderTitle.react'),null,i._("Event Tips"))),c('React').createElement(c('XUICardSection.react'),{className:"_2pi9 _2pid _2pio _5y6s"},y));};s.propTypes={tipData:n.array.isRequired,eventID:n.string.isRequired,actionContext:n.object.isRequired};f.exports=s;}),null);
__d('ReactComposerEventBootloader',['Bootloader'],(function a(b,c,d,e,f,g){'use strict';var h={statusAttachment:function i(j){c('Bootloader').loadModules(["ReactComposerStatusAttachmentContainer.react","ReactComposerEventPostButtonContainer.react"],j,'ReactComposerEventBootloader');},mediaAttachment:function i(j){c('Bootloader').loadModules(["ReactComposerMediaAttachmentContainer.react","ReactComposerEventMediaPostButtonContainer.react"],j,'ReactComposerEventBootloader');},questionAttachment:function i(j){c('Bootloader').loadModules(["ReactComposerQuestionAttachmentContainer.react","ReactComposerEventPostButtonContainer.react"],j,'ReactComposerEventBootloader');}};f.exports=h;}),null);
__d('ReactEventComposer.react',['cx','fbt','ReactComposer.react','ReactComposerAttachmentType','ReactComposerBodyContainer.react','ReactComposerConfig','ReactComposerContextConfig','ReactComposerContextProviderMixin','ComposerEntryPointRef','ReactComposerEventBootloader','ReactComposerLazyHeader.react','ReactComposerMarkdownTaggerButton.react','ReactComposerMarkdownTaggerContainer.react','ReactComposerMediaAttachmentSelector.react','ReactComposerMediaLazyAttachment.react','ReactComposerQuestionAttachmentSelector.react','ReactComposerQuestionLazyAttachment.react','ReactComposerStatusAttachmentSelector.react','ReactComposerStatusLazyAttachment.react','ReactComposerTaggerType','BootloadedComponent.react','EventsAboutTabComposer','LitestandComposer','JSResource','React','XUISpinner.react'],(function a(b,c,d,e,f,g,h,i){var j=c('React').createClass({displayName:'ReactEventComposer',mixins:[c('ReactComposerContextProviderMixin')],propTypes:{contextConfig:c('ReactComposerContextConfig').isRequired,config:c('ReactComposerConfig').isRequired},componentDidMount:function k(){if(this.props.config.loggingConfig.ref===c('ComposerEntryPointRef').EVENT_ABOUT){c('EventsAboutTabComposer').initComposer(this.props.contextConfig.composerID,this.props.config.targetData.targetID);}else c('LitestandComposer').initComposer(this.props.contextConfig.composerID);},render:function k(){var l=this._getAttachmentComponents(),m=l[0],n=l[1],o=this.props.config.actorConfig?c('React').createElement(c('BootloadedComponent.react'),babelHelpers['extends']({},this.props.config.actorConfig,{bootloadPlaceholder:c('React').createElement(c('XUISpinner.react'),{className:"_3igw"}),bootloadLoader:c('JSResource')('ReactComposerActorSelectorContainer.react').__setRef('ReactEventComposer.react')})):null;return c('React').createElement(c('ReactComposer.react'),{className:"_4lmd",loggingConfig:this.props.config.loggingConfig},c('React').createElement(c('ReactComposerLazyHeader.react'),{rightChild:o},m),c('React').createElement(c('ReactComposerBodyContainer.react'),null,n));},_getAttachmentComponents:function k(){var l=[],m=[],n=this.props.config.attachmentsConfig,o=n[c('ReactComposerAttachmentType').MEDIA].enabled,p=n[c('ReactComposerAttachmentType').QUESTION].enabled;l.push(c('React').createElement(c('ReactComposerStatusAttachmentSelector.react'),{key:'status',label:i._("Write Post")}));m.push(c('React').createElement(c('ReactComposerStatusLazyAttachment.react'),{additionalTaggers:this._getAdditionalTaggersForStatusAttachment(),config:this.props.config,key:'status',placeholder:i._("Write something..."),selected:true,bootloader:c('ReactComposerEventBootloader')}));if(o){l.push(c('React').createElement(c('ReactComposerMediaAttachmentSelector.react'),{key:'media',label:i._("Add Photo\/Video")}));m.push(c('React').createElement(c('ReactComposerMediaLazyAttachment.react'),{additionalTaggers:this._getAdditionalTaggersForStatusAttachment(),config:this.props.config,key:'media',bootloader:c('ReactComposerEventBootloader')}));}if(p){l.push(c('React').createElement(c('ReactComposerQuestionAttachmentSelector.react'),{key:'question'}));m.push(c('React').createElement(c('ReactComposerQuestionLazyAttachment.react'),{config:this.props.config,key:'question',bootloader:c('ReactComposerEventBootloader')}));}return [l,m];},_getAdditionalTaggersForStatusAttachment:function k(){var l=[];if(this.props.config.taggersConfig[c('ReactComposerTaggerType').MARKDOWN].enabled)l.push({button:c('React').createElement(c('ReactComposerMarkdownTaggerButton.react'),{key:'markdown_button'}),container:c('React').createElement(c('ReactComposerMarkdownTaggerContainer.react'),{key:'markdown_container'})});return l;}});f.exports=j;}),null);