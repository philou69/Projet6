if (self.CavalryLogger) { CavalryLogger.start_js(["EeqBH"]); }

__d('AdsEmailTokenizer.react',['cx','BUIAdoptionBUIText.react','BUITextInput.react','CIWebmailValidator','React','ReactDOM','XUIError.react','XUITokenizerToken.react','emptyFunction','joinClasses','setImmediate'],(function a(b,c,d,e,f,g,h){'use strict';var i,j,k=c('React').PropTypes,l=c('CIWebmailValidator').isValidEmail;i=babelHelpers.inherits(m,c('React').PureComponent);j=i&&i.prototype;function m(){var n,o;for(var p=arguments.length,q=Array(p),r=0;r<p;r++)q[r]=arguments[r];return o=(n=j.constructor).call.apply(n,[this].concat(q)),this.state={textInProgress:''},this.$AdsEmailTokenizer2=function(event){var s=event.target.value;if(s.length===0&&this.props.recipients.length>0){var t=this.props.recipients[this.props.recipients.length-1];this.$AdsEmailTokenizer3(t);}}.bind(this),this.$AdsEmailTokenizer4=function(s,event){event.preventDefault();var t=event.target.value,u=t.split(/[,;\s]/);if(s||u.length>1){var v=u.filter(function(w){return this.$AdsEmailTokenizer5(w);}.bind(this));if(v.length){this.$AdsEmailTokenizer6(v);t='';}}if(event.type==='blur')this.props.onBlur(event);this.setState({textInProgress:t});}.bind(this),this.$AdsEmailTokenizer6=function(s){var t=this.props.recipients.concat(s);this.props.onChange(t);}.bind(this),this.$AdsEmailTokenizer3=function(s){var t=this.props.recipients.filter(function(u){return u!==s;});this.props.onChange(t);}.bind(this),this.$AdsEmailTokenizer5=function(s){return s.length>0&&(l(s)||this.props.allowInvalid);}.bind(this),this.$AdsEmailTokenizer7=function(s,t){return c('React').createElement(c('XUITokenizerToken.react'),{className:"_2zky"+(!l(s)?' '+"invalid":''),isDragDropEnabled:false,key:t,label:s,removable:true,onRemove:function(){return this.$AdsEmailTokenizer3(s);}.bind(this)});}.bind(this),this.$AdsEmailTokenizer1=function(){c('setImmediate')(function(){if(this.refs&&this.refs.textSizeProxy){var s=c('ReactDOM').findDOMNode(this.refs.textSizeProxy).offsetWidth;c('ReactDOM').findDOMNode(this.refs.input).style.width=s+'px';}}.bind(this));}.bind(this),o;}m.prototype.componentDidMount=function(){this.$AdsEmailTokenizer1();};m.prototype.componentDidUpdate=function(n){this.$AdsEmailTokenizer1();};m.prototype.render=function(){var n=c('joinClasses')("_2zl1 clearfix",this.props.className),o=this.props.recipients.map(this.$AdsEmailTokenizer7);return c('React').createElement(c('XUIError.react'),{xuiError:this.props.xuiError},c('React').createElement('div',{className:n,role:'presentation',onClick:function(){return c('ReactDOM').findDOMNode(this.refs.input).focus();}.bind(this)},o,c('React').createElement(c('BUITextInput.react'),{className:"_2zl2",placeholder:this.props.placeholder,ref:'input',value:this.state.textInProgress,onBackspace:this.$AdsEmailTokenizer2,onBlur:this.$AdsEmailTokenizer4.bind(this,true),onChange:this.$AdsEmailTokenizer4.bind(this,false),onEnter:this.$AdsEmailTokenizer4.bind(this,true)}),c('React').createElement(c('BUIAdoptionBUIText.react'),{className:"_2zl3",ref:'textSizeProxy',size:'small'},this.state.textInProgress||this.props.placeholder)));};m.propTypes={allowInvalid:k.bool.isRequired,className:k.string,recipients:k.arrayOf(k.string).isRequired,onBlur:k.func.isRequired,onChange:k.func.isRequired,placeholder:k.string,xuiError:k.string};m.defaultProps={allowInvalid:false,onBlur:c('emptyFunction'),onChange:c('emptyFunction')};f.exports=m;}),null);
__d('isKeyActivation',['Keys'],(function a(b,c,d,e,f,g){'use strict';function h(event){var i=0,j=event.charCode,k=event.keyCode;if(j!=null&&j!==0){i=j;}else if(k!=null&&k!==0)i=k;return [c('Keys').RETURN,c('Keys').SPACE].includes(i);}f.exports=h;}),null);
__d('KeyActivationToClickHOC.react',['React','isKeyActivation'],(function a(b,c,d,e,f,g){'use strict';var h=function(i){var j,k;return k=j=function(){var l,m;l=babelHelpers.inherits(n,c('React').Component);m=l&&l.prototype;function n(){var o;'use strict';for(var p=arguments.length,q=Array(p),r=0;r<p;r++)q[r]=arguments[r];(o=m.constructor).call.apply(o,[this].concat(q));this.$_class2=function(event){if(c('isKeyActivation')(event)){event.preventDefault();event.stopPropagation();if(this.$_class1)this.$_class1.click();}}.bind(this);this.$_class3=function(s){this.$_class1=s;}.bind(this);this.$_class1=null;}n.prototype.render=function(){'use strict';return c('React').createElement(i,babelHelpers['extends']({},this.props,{keyActivationToClickEvent:this.$_class2,keyActivationToClickRef:this.$_class3}));};return n;}(),j.displayName='KeyActivationToClickHOC',k;}.bind(this);f.exports=h;}),null);
__d('FBToggle.react',['cx','invariant','KeyActivationToClickHOC.react','React','joinClasses'],(function a(b,c,d,e,f,g,h,i){var j,k,l=c('React').PropTypes;j=babelHelpers.inherits(m,c('React').Component);k=j&&j.prototype;function m(){var n,o;'use strict';for(var p=arguments.length,q=Array(p),r=0;r<p;r++)q[r]=arguments[r];return o=(n=k.constructor).call.apply(n,[this].concat(q)),this.state={isOpen:this.props.startOpen||!!this.props.open},this.$FBToggle2=function(){if(this.props.disabled)return;if(this.props.onChange)this.props.onChange(!this.state.isOpen,this.props.disabled);this.setState({isOpen:!this.state.isOpen});}.bind(this),o;}m.prototype.componentWillReceiveProps=function(n){'use strict';this.setState({isOpen:n.open!=null?n.open:this.state.isOpen});};m.prototype.render=function(){'use strict';var n=this.props.children,o=n.length==2||n.length==3;o||i(0);if(n.length==2)n=[n[0]].concat(n);var p=this.state.isOpen?n[1]:n[0],q=n[2],r=(this.state.isOpen?"_4ncx":'')+(!this.state.isOpen?' '+"_4ncy":'')+(this.props.disabled?' '+"_4ncz":''),s="_4nc-",t="_4nc_"+(!this.state.isOpen?' '+"hidden_elem":'');return c('React').createElement('div',babelHelpers['extends']({},this.props,{className:c('joinClasses')(this.props.className,r)}),c('React').createElement('span',{'aria-level':this.props.headingLevel,className:s,role:this.props.headingLevel?'heading':null},c('React').createElement('span',{'aria-pressed':this.state.isOpen,onClick:this.$FBToggle2,onKeyPress:this.props.keyActivationToClickEvent,ref:this.props.keyActivationToClickRef,role:'button',tabIndex:'0'},' ',p,' ')),c('React').createElement('span',{className:t},' ',q,' '));};m.propTypes={startOpen:l.bool,open:l.bool,disabled:l.bool,headingLevel:l.oneOf([2,3,4,5,6]),onChange:l.func};m.defaultProps={disabled:false,headingLevel:null,open:null,startOpen:false};f.exports=c('KeyActivationToClickHOC.react')(m);}),null);
__d('OuiSpinner.react',['cx','React','joinClasses','OuiColorScheme'],(function a(b,c,d,e,f,g,h){'use strict';var i,j,k=c('React').PropTypes,l=[c('OuiColorScheme').LIGHT,c('OuiColorScheme').GRAY,c('OuiColorScheme').DARK],m='medium',n=['medium','large'];i=babelHelpers.inherits(o,c('React').Component);j=i&&i.prototype;o.prototype.render=function(){var p=this.props,q=p.alt,r=p.className,s=p.hidden,t=p.muted,u=p.size,v=babelHelpers.objectWithoutProperties(p,['alt','className','hidden','muted','size']),w=this.props.colorScheme||this.context.ouiColorScheme||c('OuiColorScheme').LIGHT,x=q||'';return c('React').createElement('i',babelHelpers['extends']({},v,{className:c('joinClasses')(r,"_3wip"+(u==='medium'?' '+"_3wiq":'')+(u==='large'?' '+"_3wir":'')+(w===c('OuiColorScheme').LIGHT?' '+"_3wiu":'')+(w===c('OuiColorScheme').GRAY?' '+"_4_fe":'')+(w===c('OuiColorScheme').DARK?' '+"_3wis":'')+(t?' '+"_3wiv":'')+(s?' '+"_3wiw":''))}),x);};function o(){i.apply(this,arguments);}o.contextTypes={ouiColorScheme:k.oneOf(l)};o.defaultProps={hidden:false,muted:false,size:m};o.propTypes={alt:k.string,colorScheme:k.oneOf(l),hidden:k.bool,muted:k.bool,size:k.oneOf(n)};f.exports=o;}),null);