if (self.CavalryLogger) { CavalryLogger.start_js(["reiRp"]); }

__d("OzConstants",[],(function a(b,c,d,e,f,g){f.exports={AUTHOR_TYPES:{BOT:"bot",TRAINER:"trainer",USER:"user"},ATTS:{COMMAND:"\u0040COMMAND",IMAGE:"image",SUGG:"\u0040SUGG",TEMPLATE:"template",SURVEY:"survey",QUICK_REPLIES:"\u0040QUICK_REPLIES",OPENTABLEQR:"opentableQuickReply"},SESSION_INFO_EVENT:"iframenonce_fb_session_info",TOKENS:{USER_FIRST_NAME:"user-first-name"},REMINDERS:{RANGE_IN_YEARS:5},M_FBIDS:{M:"881263441913087",M_DEV:"1579802578966277",P:"506060876211905"}};}),null);
__d('GroupChatMessageBlockAlert',['fbt','DialogX','GenderConst','MercuryParticipants','React','XUIDialogBody.react','XUIDialogButton.react','XUIDialogFooter.react','XUIDialogTitle.react'],(function a(b,c,d,e,f,g,h){var i={show:function j(k,l,m){var n=new (c('DialogX'))({width:445},c('React').createElement('div',null,c('React').createElement(c('XUIDialogTitle.react'),null,h._("See Conversations?")),c('React').createElement(c('XUIDialogBody.react'),null,this.dialogBodyText(k)),c('React').createElement(c('XUIDialogFooter.react'),null,c('React').createElement(c('XUIDialogButton.react'),{action:'cancel',label:this.leaveGroupButton(),onClick:function o(){return m();}}),c('React').createElement(c('XUIDialogButton.react'),{use:'confirm',action:'cancel',label:this.openChatButton(),onClick:function o(){return l();}}))));n.show();},openChatButton:function j(){return h._("See Conversation");},leaveGroupButton:function j(){return h._("Leave Group");},dialogBodyText:function j(k){if(k.length!==1){return h._("People you've blocked are in this conversation. If you see this conversation, you'll get each other's messages to the group.");}else{var l='';c('MercuryParticipants').get(k.pop(),function(m){switch(m.gender){case c('GenderConst').FEMALE_SINGULAR:l=h._("{name} is in this group conversation but you've blocked her. If you see this conversation, you'll see her messages to the group and she'll see yours.",[h.param('name',m.short_name)]);break;case c('GenderConst').MALE_SINGULAR:l=h._("{name} is in this group conversation but you've blocked him. If you see this conversation, you'll see his messages to the group and he'll see yours.",[h.param('name',m.short_name)]);break;default:l=h._("{name} is in this group conversation but you've blocked them. If you see this conversation, you'll see their messages to the group and they'll see yours.",[h.param('name',m.short_name)]);}});return l;}}};f.exports=i;}),null);
__d('ChatTabPolicy',['ChatBehavior','LogHistory','MercuryActionType','MercuryLogMessageType','MercuryAssert','mercuryBlockedParticipantsRe','MercuryConfig','MercuryIDs','MercuryParticipantTypes','MercurySourceType','MercuryThreadActions','MercuryThreadInfo','MercuryViewer','MessagingTag','OzConstants','PresencePrivacy','Set','ShortProfiles','WorkModeConfig','isInFocusMode'],(function a(b,c,d,e,f,g){'use strict';var h=c('mercuryBlockedParticipantsRe').get(),i=c('MercuryThreadActions').get(),j=c('OzConstants').M_FBIDS,k=j.M_DEV,l=j.M,m=j.P,n=new (c('Set'))([k,l,m]),o=c('LogHistory').getInstance('tab_policy');f.exports={messageIsAllowed:function p(q,r,s){var t=q.thread_id,u=r.message_id,v=c('MercuryIDs').getUserIDFromParticipantID(c('MercuryViewer').getID());c('MercuryAssert').isThreadID(t);c('MercuryAssert').isParticipantID(r.author);var w=void 0;if(c('MercuryThreadInfo').isMuted(q)){w={thread_id:t,message_id:u,mute_until:q.mute_until};o.log('message_thread_muted',JSON.stringify(w));if(!c('MercuryThreadInfo').areMentionsMuted(q)){if(!r.profile_ranges||!r.profile_ranges.some||!r.profile_ranges.some(function(y){return y.id===v;})){o.log('message_mentions_viewer',JSON.stringify(w));return;}}else return;}if(c('isInFocusMode')(t)){w={thread_id:t,message_id:u,availability_mode:'focus'};o.log('message_thread_focus_mode',JSON.stringify(w));return;}if(q.read_only){w={thread_id:t,message_id:u,mode:q.mode};o.log('message_read_only',JSON.stringify(w));return;}if(r.source==c('MercurySourceType').EMAIL||r.source==c('MercurySourceType').TITAN_EMAIL_REPLY){w={thread_id:t,message_id:u,source:r.source};o.log('message_source_not_allowed',JSON.stringify(w));return;}var x=c('MercuryIDs').getUserIDFromParticipantID(r.author);if(!x){o.log('message_bad_author',JSON.stringify({thread_id:t,message_id:u,user:x}));return;}if(r.action_type!=c('MercuryActionType').USER_GENERATED_MESSAGE&&!this._messageIsNewlyCreatedGroup(r,q)){w={thread_id:t,message_id:u,type:r.action_type};o.log('message_non_user_generated',JSON.stringify(w));return;}if(q.is_canonical_user&&!c('ChatBehavior').notifiesUserMessages()){o.log('message_jabber',JSON.stringify({thread_id:t,message_id:u}));i.markSeen(t,true);return;}if(q.is_canonical&&!q.other_user_fbid){o.log('message_canonical_contact',JSON.stringify({thread_id:t,message_id:u}));return;}if(q.folder!=c('MessagingTag').INBOX){o.log('message_folder',JSON.stringify({thread_id:t,message_id:u,folder:q.folder}));return;}if(h.isPresentInGroupThread(q)){w={thread_id:t,message_id:u};o.log('message_blocked_participants',JSON.stringify(w));return;}c('ShortProfiles').getMulti([x,v],function(y){if(!c('PresencePrivacy').allows(x)){o.log('message_privacy',JSON.stringify({thread_id:t,message_id:u,user:x}));return;}var z=y[x].employee&&y[v].employee,aa=c('WorkModeConfig').is_work_user;if(!z&&!aa&&!y[x].isCommercePage&&!n.has(x)&&y[x].type!==c('MercuryParticipantTypes').FRIEND&&y[x].type!==c('MercuryParticipantTypes').PAGE){o.log('message_non_friend',JSON.stringify({thread_id:t,message_id:u,user:x}));return;}s();});},_messageIsNewlyCreatedGroup:function p(q,r){return q.action_type===c('MercuryActionType').LOG_MESSAGE&&q.log_message_type===c('MercuryLogMessageType').THREAD_NAME&&r.message_count===1;}};}),null);