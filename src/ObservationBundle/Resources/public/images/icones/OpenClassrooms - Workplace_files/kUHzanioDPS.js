if (self.CavalryLogger) { CavalryLogger.start_js(["CJe\/w"]); }

__d('ChatReadOnlyTabSheet.react',['cx','React'],(function a(b,c,d,e,f,g,h){'use strict';var i=function j(k){return c('React').createElement('div',{className:"_87-"},k.reason);};f.exports=i;}),null);
__d('MessengerTypeaheadView.react',['cx','immutable','MessengerContactAdapters','MessengerContactList.react','MessengerTypeaheadUtils','React','joinClasses'],(function a(b,c,d,e,f,g,h){'use strict';var i,j,k=c('React').PropTypes;i=babelHelpers.inherits(l,c('React').PureComponent);j=i&&i.prototype;function l(){var m,n;for(var o=arguments.length,p=Array(o),q=0;q<o;q++)p[q]=arguments[q];return n=(m=j.constructor).call.apply(m,[this].concat(p)),this.$MessengerTypeaheadView1=function(r,event){this.props.onSelect&&this.props.onSelect(r,event);}.bind(this),n;}l.prototype.render=function(){return c('React').createElement(c('MessengerContactList.react'),{ariaOwneeID:this.props.ariaOwneeID,className:c('joinClasses')(this.props.className,"_4p-s"),contactAdapter:c('MessengerContactAdapters').fromSearchableEntry,hasHoverState:this.props.hasHoverState,highlightedEntry:this.props.highlightedEntry,isLoading:this.props.isLoading,listSections:c('MessengerTypeaheadUtils').buildListSections(this.props.entries,this.props.queryString),onHighlight:this.props.onHighlight,onRenderHighlight:this.props.onRenderHighlight,onScrollIntoView:this.props.onScrollIntoView,onSelect:this.$MessengerTypeaheadView1,originalEntryIDs:this.props.originalEntryIDs,invitedEntryIDs:this.props.invitedEntryIDs,queryString:this.props.queryString,selectedEntryIDs:this.props.selectedEntryIDs,showPresence:false,viewer:this.props.viewer});};l.propTypes={ariaOwneeID:k.string,entries:k.array.isRequired,hasHoverState:k.bool,highlightedEntry:k.object,isLoading:k.bool,onHighlight:k.func,onRenderHighlight:k.func,onScrollIntoView:k.func,onSelect:k.func,originalEntryIDs:k.instanceOf(c('immutable').Set),invitedEntryIDs:k.instanceOf(c('immutable').Set),queryString:k.string,selectedEntryIDs:k.instanceOf(c('immutable').Set),viewer:k.string.isRequired};f.exports=l;}),null);