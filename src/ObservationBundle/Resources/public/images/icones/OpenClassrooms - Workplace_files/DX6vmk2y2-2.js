if (self.CavalryLogger) { CavalryLogger.start_js(["kyzTD"]); }

__d("XReactComposerMagicTagSurveyController",["XController"],(function a(b,c,d,e,f,g){f.exports=c("XController").create("\/ajax\/react_composer\/magic_tag_survey\/",{session_id:{type:"String",required:true},composer_id:{type:"String",required:true},photo_id:{type:"String",required:true},facebox_id:{type:"String",required:true}});}),null);
__d('ReactComposerMagicTagSurvey',['AsyncRequest','ReactComposerPhotoStore','ComposerXSessionIDs','XReactComposerMagicTagSurveyController'],(function a(b,c,d,e,f,g){var h={loadSurvey:function i(j){var k=this._shouldShowSurvey(j);if(!k.shouldShowSurvey)return;var l=c('ComposerXSessionIDs').getSessionID(j),m=c('XReactComposerMagicTagSurveyController').getURIBuilder().setString('composer_id',j).setString('session_id',l).setString('photo_id',k.photoID).setString('facebox_id',k.faceboxID);new (c('AsyncRequest'))().setURI(m.getURI()).send();},_shouldShowSurvey:function i(j){var k=false,l=null,m=null,n=c('ReactComposerPhotoStore').getPhotos(j);if(n.count()===1)n.forEach(function(o){if(o.faceboxes.count()!==1)return;o.faceboxes.forEach(function(p){if(p.recognizedSubjectID&&p.taggedSubjectID===null){k=true;l=o.id;m=p.id;return;}});});return {shouldShowSurvey:k,photoID:l,faceboxID:m};}};f.exports=h;}),null);