if (self.CavalryLogger) { CavalryLogger.start_js(["Qcf8j"]); }

__d('UFIScrollHighlight',['CSS','ScrollHighlight'],(function a(b,c,d,e,f,g){'use strict';var h={actOn:function i(j,k){c('ScrollHighlight').actOn(j,'#edeff4',k);c('CSS').removeClass(j,'highlightComment');}};f.exports=h;}),null);
__d('SpatialReactionClickAnimation',['cx','Promise','SphericalVideoComponentActions','SpatialReactionAnimationConfig','DOM','SpatialReactionsProductionStore','SphericalVideoComponent','SphericalViewportControlStore','Style','curry','SpatialReactionsUtils','SpatialReactionAnimationUtils','setTimeout'],(function a(b,c,d,e,f,g,h){'use strict';var i,j,k=c('SpatialReactionsUtils').cloneNode,l=c('SpatialReactionsUtils').insertOnTop,m=c('SpatialReactionAnimationUtils').addTemporaryAnimation,n=c('SpatialReactionAnimationUtils').addTransition,o=c('SpatialReactionAnimationUtils').getReactionClickPositionRelativeToViewport,p=c('SpatialReactionAnimationUtils').getReactionCenterOffset,q=c('SpatialReactionAnimationUtils').isPositionIndexOnLeftSide,r=c('SpatialReactionAnimationUtils').moveElementToPosition,s=c('SpatialReactionAnimationUtils').pollForAnimationProgress;i=babelHelpers.inherits(t,c('SphericalVideoComponent'));j=i&&i.prototype;function t(u,v,w,x){j.constructor.call(this,v);this.$SpatialReactionClickAnimation1=w;this.$SpatialReactionClickAnimation2=u;this.$SpatialReactionClickAnimation3=x;}t.prototype.getInitialState=function(u){var v=c('SphericalViewportControlStore').getState().get('sphericalViewportControlStates').get(u),w=v.yaw,x=v.pitch,y=v.fieldOfView,z=v.viewportWidth,aa=v.viewportHeight;return {viewportFieldOfView:y,viewportHeight:aa,viewportPitch:x,viewportWidth:z,viewportYaw:w};};t.prototype.calculateState=function(u){return this.getInitialState(this.id);};t.prototype.click=function(event){var u=this.id;c('SphericalVideoComponentActions').clickReaction(u,this.$SpatialReactionClickAnimation1);var v=k(this.$SpatialReactionClickAnimation2);c('Style').set(v,'transform',c('SpatialReactionAnimationConfig').DRAG.ORIGINAL_SCALE_VALUE);l(this.$SpatialReactionClickAnimation2,v);var w=function ia(){return c('DOM').remove(v);},x="_2-_z",y=c('SpatialReactionsProductionStore').getNextClickReactionPositionIndex(u),z=q(y),aa=o(y,this.state.viewportWidth,this.state.viewportHeight),ba=c('SphericalViewportControlStore').getViewportPositionVector(u),ca=ba.add(aa),da=p(c('SpatialReactionAnimationConfig').SIZES.FULL.PX),ea=function ia(){return m(v,x,'clickCoinFlipAnimation');},fa=function(){return c('SphericalVideoComponentActions').dropReaction(u,this.$SpatialReactionClickAnimation1,aa.sub(da),false,false,this.state.viewportWidth,this.state.viewportHeight,this.state.viewportYaw,this.state.viewportPitch,this.state.viewportFieldOfView,c('curry')(this.$SpatialReactionClickAnimation3,event));}.bind(this),ga=this.$SpatialReactionClickAnimation4(v,this.$SpatialReactionClickAnimation1,ca,z),ha=function ia(){var ja=v.getBoundingClientRect().width/v.offsetWidth;return ja<c('SpatialReactionAnimationConfig').SCALES.COIN_FLIP_MORPH_START;};ga().then(function(){return new (c('Promise'))(function(ia,ja){return c('setTimeout')(ia,800);});}).then(function(){ea();return s(ha);}).then(function(){fa();w();}).done();};t.prototype.$SpatialReactionClickAnimation4=function(u,v,w,x){var y=x?"_2-_w":"_2-_x";return function(){return n(u,y,'top',function(){return r(u,w);});};};f.exports=t;}),null);