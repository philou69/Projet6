if (self.CavalryLogger) { CavalryLogger.start_js(["CT2qt"]); }

__d('ReactComposerHeaderType',[],(function a(b,c,d,e,f,g){'use strict';var h={NONE:'NONE',DEFAULT:'DEFAULT',SHARESHEET:'SHARESHEET'};f.exports=h;}),null);
__d('ReactComposerSproutsHeader.react',['cx','fbt','React','ReactComposerHeaderType'],(function a(b,c,d,e,f,g,h,i){'use strict';var j,k;j=babelHelpers.inherits(l,c('React').Component);k=j&&j.prototype;function l(){var m,n;for(var o=arguments.length,p=Array(o),q=0;q<o;q++)p[q]=arguments[q];return n=(m=k.constructor).call.apply(m,[this].concat(p)),this.defaultProps={type:c('ReactComposerHeaderType').DEFAULT},n;}l.prototype.render=function(){switch(this.props.type){case c('ReactComposerHeaderType').DEFAULT:return c('React').createElement('div',{className:"_3ubp _sg2"},this.props.children);case c('ReactComposerHeaderType').SHARESHEET:return c('React').createElement('div',{className:"_3ubp"},i._("Select Audience"));case c('ReactComposerHeaderType').NONE:default:return c('React').createElement('span',null);}};f.exports=l;}),null);
__d('ReactComposerHeaderContainer.react',['ReactComposerConfig','ReactComposerContextConfig','ReactComposerPropsAndStoreBasedStateMixin','ReactComposerContextProviderMixin','ReactComposerAttachmentType','ReactComposerAttachmentStore','ReactComposerHeaderType','ReactComposerSproutsHeader.react','React'],(function a(b,c,d,e,f,g){'use strict';var h=c('React').PropTypes,i=c('React').createClass({displayName:'ReactComposerHeaderContainer',mixins:[c('ReactComposerContextProviderMixin'),c('ReactComposerPropsAndStoreBasedStateMixin')(c('ReactComposerAttachmentStore'))],propTypes:{contextConfig:c('ReactComposerContextConfig').isRequired,config:c('ReactComposerConfig').isRequired,children:h.arrayOf(h.element)},statics:{calculateState:function j(k,l,m){return {selectedAttachmentID:c('ReactComposerAttachmentStore').getSelectedAttachmentID(k)};}},_getComposerHeaderType:function j(){var k=this.props.contextConfig.gks&&this.props.contextConfig.gks.albumTab,l=this.state.selectedAttachmentID===c('ReactComposerAttachmentType').AUDIENCE_SELECTOR;return k&&!l?c('ReactComposerHeaderType').DEFAULT:l?c('ReactComposerHeaderType').SHARESHEET:c('ReactComposerHeaderType').NONE;},render:function j(){return c('React').createElement(c('ReactComposerSproutsHeader.react'),{type:this._getComposerHeaderType()},this.props.children);}});f.exports=i;}),null);
__d('ReactComposerSproutsSelector.react',['cx','React','ReactComposerAttachmentType','ReactComposerAttachmentSelectorContainer.react'],(function a(b,c,d,e,f,g,h){'use strict';var i,j;i=babelHelpers.inherits(k,c('React').Component);j=i&&i.prototype;k.prototype.render=function(){return c('React').createElement('span',{className:"_sg1"},c('React').createElement(c('ReactComposerAttachmentSelectorContainer.react'),{attachmentID:this.props.attachmentID,label:this.props.label,icon:this.props.icon,loggingName:this.props.loggingName,alternativeAttachmentIDs:this.props.alternativeAttachmentIDs,onSelected:this.props.onSelected}));};function k(){i.apply(this,arguments);}f.exports=k;}),null);
__d('ReactComposerSproutsAlbumSelector.react',['ix','cx','fbt','React','ReactComposerAttachmentType','ReactComposerCollectionSelectorContainerGatedModule','ReactComposerConfig','ReactComposerContextMixin','fbglyph','joinClasses','Image.react','TooltipData','DOMContainer.react'],(function a(b,c,d,e,f,g,h,i,j){'use strict';var k,l,m=c('ReactComposerCollectionSelectorContainerGatedModule').module,n=c('ReactComposerContextMixin').contextTypes;k=babelHelpers.inherits(o,c('React').Component);l=k&&k.prototype;o.prototype.render=function(){if(this.props.useCollectionSelector){var p=h("123370"),q=j._("Album"),r=c('joinClasses')("_4-h7",'fbReactComposerAttachmentSelector_'+c('ReactComposerAttachmentType').ALBUM);return c('React').createElement('span',{className:"_sg1"},m?c('React').createElement(m,{addAnyPostToAlbum:this.context.gks&&this.context.gks.addAnyPostToAlbum,alternateTriggerComponent:c('React').createElement('span',babelHelpers['extends']({className:r,'data-tooltip-delay':'500'},c('TooltipData').propsFor(q)),c('React').createElement('span',{className:"_4-fs"},c('React').createElement(c('Image.react'),{src:p,className:"_5qto"}),c('React').createElement('span',{className:"_5qtp"},q),c('React').createElement('span',{className:"_4-h8"})))}):null);}else return c('React').createElement('span',{key:'album',className:"_sg1"},c('React').createElement(c('DOMContainer.react'),{display:'inline'},this.props.config.attachmentsConfig[c('ReactComposerAttachmentType').ALBUM].createAlbumLink));};function o(){k.apply(this,arguments);}o.contextTypes=n;f.exports=o;}),null);
__d('ReactComposerSproutsLiveVideoSelector.react',['ix','fbt','React','ReactComposerAttachmentType','ReactComposerLoggingName','ReactComposerSproutsSelector.react','fbglyph'],(function a(b,c,d,e,f,g,h,i){'use strict';var j,k;j=babelHelpers.inherits(l,c('React').Component);k=j&&j.prototype;function l(){var m,n;for(var o=arguments.length,p=Array(o),q=0;q<o;q++)p[q]=arguments[q];return n=(m=k.constructor).call.apply(m,[this].concat(p)),this.defaultProps={onSelected:function r(){}},n;}l.prototype.render=function(){return c('React').createElement('span',{'data-testid':'react-composer-live-video-selector-react'},c('React').createElement(c('ReactComposerSproutsSelector.react'),{attachmentID:c('ReactComposerAttachmentType').LIVE_VIDEO,loggingName:c('ReactComposerLoggingName').LIVE_VIDEO_TAB_SELECTOR,icon:h("123206"),label:i._("Live Video"),onSelected:this.props.onSelected}));};f.exports=l;}),null);
__d('ReactComposerSproutsLiveVideoDialogSelector.react',['Arbiter','Bootloader','ReactComposerAttachmentActions','ReactComposerAttachmentType','ReactComposerEvents','ReactComposerLoggingName','ReactComposerConfig','ReactComposerContextConfig','ReactComposerSproutsLiveVideoSelector.react','React'],(function a(b,c,d,e,f,g){'use strict';var h,i;h=babelHelpers.inherits(j,c('React').Component);i=h&&h.prototype;function j(){var k,l;for(var m=arguments.length,n=Array(m),o=0;o<m;o++)n[o]=arguments[o];return l=(k=i.constructor).call.apply(k,[this].concat(n)),this.$ReactComposerSproutsLiveVideoDialogSelector1=function(){c('ReactComposerAttachmentActions').selectAttachment(this.props.contextConfig.composerID,c('ReactComposerAttachmentType').LIVE_VIDEO,true,c('ReactComposerLoggingName').LIVE_VIDEO_TAB_SELECTOR);setTimeout(function(){return c('Arbiter').inform(c('ReactComposerEvents').ACTIVATE_ATTACHMENT+this.props.contextConfig.composerID);}.bind(this),0);c('Bootloader').loadModules(["LiveVideoBroadcastUtils"],function(p){return p.startPreviewUI(this.props.contextConfig,this.props.config,true);}.bind(this),'ReactComposerSproutsLiveVideoDialogSelector.react');}.bind(this),l;}j.prototype.render=function(){return c('React').createElement(c('ReactComposerSproutsLiveVideoSelector.react'),{onSelected:this.$ReactComposerSproutsLiveVideoDialogSelector1});};f.exports=j;}),null);
__d('ReactComposerSproutsPostToGroupsSelector.react',['ix','cx','fbt','ReactComposerGroupSelectorTabContainerGatedModule','React','fbglyph'],(function a(b,c,d,e,f,g,h,i,j){'use strict';var k,l,m=c('ReactComposerGroupSelectorTabContainerGatedModule').module;k=babelHelpers.inherits(n,c('React').Component);l=k&&k.prototype;n.prototype.render=function(){if(m){var o=j._("Post to Group"),p=h("123072");return c('React').createElement('span',{key:'group_selector',className:"_sg1"},c('React').createElement(m,{label:o,icon:p}));}return null;};function n(){k.apply(this,arguments);}f.exports=n;}),null);
__d('ReactComposerSproutsStatusAndMediaSelector.react',['ix','fbt','React','ReactComposerAttachmentType','ReactComposerLoggingName','ReactComposerSproutsSelector.react','ReactComposerMediaUploadStore','ReactComposerPropsAndStoreBasedStateMixin','fbglyph','getObjectValues'],(function a(b,c,d,e,f,g,h,i){'use strict';var j=c('React').PropTypes,k=c('React').createClass({displayName:'ReactComposerSproutsStatusAndMediaSelector',mixins:[c('ReactComposerPropsAndStoreBasedStateMixin')(c('ReactComposerMediaUploadStore'))],propTypes:{alternativeAttachmentIDs:j.arrayOf(j.oneOf(c('getObjectValues')(c('ReactComposerAttachmentType'))))},statics:{calculateState:function l(m,n){var o=c('ReactComposerAttachmentType').STATUS,p=c('ReactComposerAttachmentType').MEDIA;if(c('ReactComposerMediaUploadStore').getUploadsCount(m)>0){o=c('ReactComposerAttachmentType').MEDIA;p=c('ReactComposerAttachmentType').STATUS;}return {attachment:o,alternativeAttachments:[p].concat(n.alternativeAttachmentIDs)};}},render:function l(){return c('React').createElement(c('ReactComposerSproutsSelector.react'),{attachmentID:this.state.attachment,loggingName:c('ReactComposerLoggingName').STATUS_TAB_SELECTOR,icon:h("123350"),label:i._("Create a Post"),alternativeAttachmentIDs:this.state.alternativeAttachments});}});f.exports=k;}),null);