YUI.add("moodle-editor_atto-editor",function(e,t){function s(){s.superclass.constructor.apply(this,arguments)}function c(){}function h(){}function m(){}function y(){y.superclass.constructor.apply(this,arguments),this._submitEvents={},this._queue=[],this._throttle=null}function b(){}function w(){this._domPurify=new e.DOMPurify,this._domPurify.addHook("afterSanitizeAttributes",function(e){if(e.target){e.setAttribute("target","_blank");var t=e.getAttribute("rel");t=t?t.split(" "):[],t.includes("noopener")||t.push("noopener"),t.includes("noreferrer")||t.push("noreferrer"),e.setAttribute("rel",t.join(" "))}}),this._domPurifyConfig={ALLOWED_URI_REGEXP:/^(?:(?:(?:f|ht)tps?|irc|nntp|news|rtsp|rtmp|teamspeak|mms|mailto|skype|meet|sip|xmpp):|[^a-z]|[a-z+.-]+(?:[^a-z+.\-:]|$))/i,ADD_TAGS:["nolink","tex","algebra","lang","font","rb","rbc","rtc"],ADD_ATTR:["autoplay","muted","controls","rel","rev","rbspan","frame","rules","charoff","target"]}}function E(){}function S(){}function x(){}function T(){}function N(){}function C(){}var n="moodle-editor_atto-editor",r={CONTENT:"editor_atto_content",CONTENTWRAPPER:"editor_atto_content_wrap",TOOLBAR:"editor_atto_toolbar",WRAPPER:"editor_atto",HIGHLIGHT:"highlight"},i=window.rangy;e.extend(s,e.Base,{BLOCK_TAGS:["address","article","aside","audio","blockquote","canvas","dd","div","dl","fieldset","figcaption","figure","footer","form","h1","h2","h3","h4","h5","h6","header","hgroup","hr","noscript","ol","output","p","pre","section","table","tfoot","ul","video"],PLACEHOLDER_CLASS:"atto-tmp-class",ALL_NODES_SELECTOR:"[style],font[face]",FONT_FAMILY:"fontFamily",_wrapper:null,editor:null,textarea:null,textareaLabel:null,plugins:null,_eventHandles:null,initializer:function(){var t;this.textarea=e.one(document.getElementById(this.get("elementid"))),this.textarea.setData("editor",this);if(!this.textarea)return;var n=this.textarea.getAttribute("class");this._eventHandles=[],this._wrapper=e.Node.create('<div class="'+r.WRAPPER+'" />'),t=e.Handlebars.compile('<div id="{{elementid}}editable" contenteditable="true" role="textbox" spellcheck="true" aria-live="off" class="{{CSS.CONTENT}} '+n+'" '+"/>"),this.editor=e.Node.create(t({elementid:this.get("elementid"),CSS:r})),this.textareaLabel=e.one('[for="'+this.get("elementid")+'"]'),this.textareaLabel&&(this.textareaLabel.generateID(),this.editor.setAttribute("aria-labelledby",this.textareaLabel.get("id"))),this.setupToolbar();var i=e.Node.create('<div class="'+r.CONTENTWRAPPER+'" />');i.appendChild(this.editor),this._wrapper.appendChild(i),this.textarea.getDOMNode().offsetParent?this.editor.setStyle("height",this.textarea.getDOMNode().getBoundingClientRect().height+"px"):this.editor.setStyle("height",20*this.textarea.getAttribute("rows")+8+"px");var s=this._wrapper.getDOMNode().querySelector(".editor_atto_toolbar"),o=s.getBoundingClientRect().height,u=function(){var e=s.getBoundingClientRect().height;if(o===e)return;var t=parseInt(this.editor.getStyle("height"));t=t+o-e,this.editor.setStyle("height",t+"px"),o=e}.bind(this);if(typeof ResizeObserver=="function"){var a=new ResizeObserver(u);a.observe(s)}else if(typeof MutationObserver=="function"){var f=new MutationObserver(function(e){e.forEach(function(e){e.addedNodes.forEach(function(e){e.tagName==="IMG"&&!e.complete&&e.addEventListener("load",function(){u()}),u()})})});f.observe(s,{subtree:!0,childList:!0}),window.addEventListener("resize",u),u()}this.disableCssStyling(),document.queryCommandSupported("DefaultParagraphSeparator")&&document.execCommand("DefaultParagraphSeparator",!1,"p"),this.textarea.get("parentNode").insert(this._wrapper,this.textarea).setAttribute("class","editor_atto_wrap"),this.textarea.hide(),this.updateFromTextArea(),this.publishEvents(),this.setupSelectionWatchers(),this.setupAutomaticPolling(),this.setupPlugins(),this.setupAutosave(),this.setupNotifications(),M.util.js_complete("totara_form_element_editor_atto")},focus:function(){return this.editor.focus(),this},publishEvents:function(){return this.publish("change",{broadcast:!0,preventable:!0}),this.publish("pluginsloaded",{fireOnce:!0}),this.publish("atto:selectionchanged",{prefix:"atto"}),this},setupAutomaticPolling:function(){return this._registerEventHandle(this.editor.on(["keyup","cut"],this.updateOriginal,this)),this._registerEventHandle(this.editor.on("paste",this.pasteCleanup,this)),this._registerEventHandle(this.editor.on("drop",this.updateOriginalDelayed,this)),this},updateOriginalDelayed:function(){return e.soon(e.bind(this.updateOriginal,this)),this},setupPlugins:function(){this.plugins={};var t=this.get("plugins"),n,r,i,s,o;for(n in t){r=t[n];if(!r.plugins)continue;for(i in r.plugins){s=r.plugins[i],o=e.mix({name:s.name,group:r.group,editor:this.editor,toolbar:this.toolbar,host:this},s);if(typeof e.M["atto_"+s.name]=="undefined")continue;this.plugins[s.name]=new e.M["atto_"+s.name].Button(o)}}return this.fire("pluginsloaded"),this},enablePlugins:function(e){this._setPluginState(!0,e)},disablePlugins:function(e){this._setPluginState(!1,e)},_setPluginState:function(t,n){var r="disableButtons";t&&(r="enableButtons"),n?this.plugins[n][r]():e.Object.each(this.plugins,function(e){e[r]()},this)},_registerEventHandle:function(e){this._eventHandles.push(e)}},{NS:"editor_atto",ATTRS:{elementid:{value:null,writeOnce:!0},contextid:{value:null,writeOnce:!0},plugins:{value:{},writeOnce:!0}}}),e.augment(s,e.EventTarget),e.namespace("M.editor_atto").Editor=s,e.namespace("M.editor_atto.Editor").init=function(t){return new e.M.editor_atto.Editor(t)};var o="moodle-editor_atto-editor-notify",u="info",a="warning",f="editor_atto_alert",l="."+f;c.ATTRS={iconCache:{value:{warning:{flexIcon:"warning",iconAltString:"warning",html:""},info:{flexIcon:"help",iconAltString:"info",html:""},error:{flexIcon:"times-circle-danger",iconAltString:"error",html:""},close:{flexIcon:"delete-ns",iconAltString:"closebuttontitle",html:""}}}},c.prototype={alertOverlay:null,messageOverlay:null,hideTimer:null,setupNotifications:function(
){var e=this,t=e.get("iconCache");return require(["core/templates","core/str"],function(n,r){Object.keys(t).map(function(i){var s=t[i].flexIcon;r.get_string(t[i].iconAltString).then(function(e){return n.renderIcon(s,{alt:e})}).then(function(t){e.set("iconCache."+i+".html",t)})})}),this},showAlert:function(t,n){this.alertOverlay=e.one(l);var r=this;if(this.alertOverlay===null){var i=e.one("#page-content");if(i===null)return;require(["core/templates"],function(s){var o="core/notification_"+n,u={closebutton:!0,extraclasses:f,announce:!0,message:t};s.render(o,u).then(function(t){r.alertOverlay=e.Node.create(t),i.prepend(r.alertOverlay)})})}},showMessage:function(t,n,r){var i;return this.messageOverlay===null&&(this.messageOverlay=e.Node.create('<div class="editor_atto_notification"></div>'),this.messageOverlay.hide(!0),this.textarea.get("parentNode").append(this.messageOverlay),this.messageOverlay.on("click",this.hideMessage,this)),this.hideTimer!==null&&this.hideTimer.cancel(),i=parseInt(r,10),i<=0&&(i=6e4),this.messageOverlay.empty(),this.messageOverlay.removeClass("atto_warning atto_info").addClass("atto_"+n),this.messageOverlay.append(t),this.messageOverlay.show(!0),r>0&&(this.hideTimer=e.later(i,this,function(){this.hideMessage()})),this},hideMessage:function(){return this.hideTimer!==null&&(this.hideTimer.cancel(),this.hideTimer=null,this.messageOverlay.inDoc()&&this.messageOverlay.hide(!0)),this.messageOverlay.hide(!0),this}},e.Base.mix(e.M.editor_atto.Editor,[c]),h.ATTRS={},h.prototype={_getEmptyContent:function(){return e.UA.ie&&e.UA.ie<10?"<p></p>":"<p><br></p>"},updateFromTextArea:function(){var e=this.textarea.get("value");return this.editor.setHTML(""),e=e.replace(/<(audio|video) ([^>]*)autoplay([^>]*)>/g,"<$1 $2data-autoplay$3>"),this.editor.append(this._cleanHTML(e)),this.editor.getHTML()===""&&this.editor.setHTML(this._getEmptyContent()),this},updateOriginal:function(){var e=this.textarea.get("value"),t=this.getCleanHTML();return t===""&&this.isActive()&&(t=this._getEmptyContent()),e!==t&&(this.textarea.set("value",t),this.textarea.simulate("change"),this.fire("change")),this}},e.Base.mix(e.M.editor_atto.Editor,[h]);var p=5e3,d=6e4,v="moodle-editor_atto-editor-autosave";m.ATTRS={autosaveEnabled:{value:!0,writeOnce:!0},autosaveFrequency:{value:60,writeOnce:!0},pageHash:{value:"",writeOnce:!0}},m.prototype={lastText:"",autosaveInstance:null,autosaveTimer:null,setupAutosave:function(){var t=-1,n,r=null,i=this.get("filepickeroptions"),s;if(!this.get("autosaveEnabled"))return;this.autosaveInstance=e.stamp(this);for(r in i)typeof i[r].itemid!="undefined"&&(t=i[r].itemid);s={contextid:this.get("contextid"),action:"resume",draftid:t,elementid:this.get("elementid"),pageinstance:this.autosaveInstance,pagehash:this.get("pageHash")},this.autosaveIo(s,this,{success:function(e){if(e===null)return;if(!e)return;if(e.result==="<p></p>"||e.result==="<p><br></p>"||e.result==="<br>")e.result="";if(e.result==="<p>&nbsp;</p>"||e.result==="<p><br>&nbsp;</p>")e.result="";e.error||typeof e.result=="undefined"?this.showMessage(M.util.get_string("errortextrecovery","editor_atto"),a,d):e.result!==this.textarea.get("value")&&e.result!==""&&this.recoverText(e.result),this._fireSelectionChanged()},failure:function(){this.showMessage(M.util.get_string("errortextrecovery","editor_atto"),a,d)}});var o=parseInt(this.get("autosaveFrequency"),10)*1e3;return this.autosaveTimer=e.later(o,this,this.saveDraft,!1,!0),n=this.textarea.ancestor("form"),n&&this.autosaveIoOnSubmit(n,{action:"reset",contextid:this.get("contextid"),elementid:this.get("elementid"),pageinstance:this.autosaveInstance,pagehash:this.get("pageHash")}),this},recoverText:function(e){var t,n;return e=this._cleanHTML(e),this.editor.setHTML(e),this.saveSelection(),this.updateOriginal(),this.lastText=e,this.showAlert(M.util.get_string("textrecoveredalert","editor_atto"),a),t=this.toolbar.one(".atto_undo_button_undo"),t!==null?(n="textrecoveredwithundo",t.once("click",this.hideMessage,this)):n="textrecovered",this.showMessage(M.util.get_string(n,"editor_atto"),a),this.once("change",this.hideMessage,this),require(["core/event"],function(e){e.notifyEditorContentRestored()}),this},saveDraft:function(){var t,n;if(!this.editor.getDOMNode()){this.autosaveTimer.cancel();return}this.editor.get("hidden")||this.updateOriginal();var r=this.textarea.get("value");if(r!==this.lastText){t=M.cfg.wwwroot+this.get("autosaveAjaxScript"),n={sesskey:M.cfg.sesskey,contextid:this.get("contextid"),action:"save",drafttext:r,elementid:this.get("elementid"),pagehash:this.get("pageHash"),pageinstance:this.autosaveInstance};var i=function(e){var t=parseInt(this.get("autosaveFrequency"),10)*1e3;this.showMessage(M.util.get_string("autosavefailed","editor_atto"),a,t)};this.autosaveIo(n,this,{failure:i,success:function(t){t&&t.error?e.soon(e.bind(i,this,[t])):(this.lastText=r,this.showMessage(M.util.get_string("autosavesucceeded","editor_atto"),u,p),this.fire("atto:draftsavesuccess"))}})}return this}},e.Base.mix(e.M.editor_atto.Editor,[m]);var g=null;y.NAME="EditorAutosaveIoDispatcher",y.ATTRS={autosaveAjaxScript:{value:"/lib/editor/atto/autosave-ajax.php",readOnly:!0},delay:{value:50,readOnly:!0}},e.extend(y,e.Base,{dispatch:function(t,n,r){this._throttle&&this._throttle.cancel(),this._throttle=e.later(this.get("delay"),this,this._processDispatchQueue),this._queue.push([t,n,r])},_processDispatchQueue:function(){var t=this._queue,n={};this._queue=[];if(t.length<1)return;e.Array.each(t,function(e,t){n[t]=e[0]}),e.io(M.cfg.wwwroot+this.get("autosaveAjaxScript"),{method:"POST",data:e.QueryString.stringify({actions:n,sesskey:M.cfg.sesskey}),on:{start:this._makeIoEventCallback("start",t),complete:this._makeIoEventCallback("complete",t),failure:this._makeIoEventCallback("failure",t),end:this._makeIoEventCallback("end",t),success:this._makeIoEventCallback("success",t)}})},_makeIoEventCallback:function(t,n){var r=function(){};return function(){var i=arguments[1],s={};(t=="complete"||t=="success"
)&&typeof i!="undefined"&&typeof i.responseText!="undefined"&&i.responseText!==""&&(s=JSON.parse(i.responseText)||{}),e.Array.each(n,function(e,n){var i=e[1],o=e[2]&&e[2][t]||r,u;s&&s.error?u=s:s&&(u=s[n]),o.apply(i,[u])})}},_onSubmit:function(t){var n={},r=t.currentTarget.generateID(),i=this._submitEvents[r];if(!i||i.ios.length<1)return;e.Array.each(i.ios,function(e,t){n[t]=e}),e.io(M.cfg.wwwroot+this.get("autosaveAjaxScript"),{method:"POST",data:e.QueryString.stringify({actions:n,sesskey:M.cfg.sesskey}),sync:!0})},whenSubmit:function(e,t){typeof this._submitEvents[e.generateID()]=="undefined"&&(this._submitEvents[e.generateID()]={event:e.on("submit",this._onSubmit,this),ios:[]}),this._submitEvents[e.get("id")].ios.push([t])}}),g=new y,b.prototype={autosaveIo:function(e,t,n){g.dispatch(e,t,n)},autosaveIoOnSubmit:function(e,t){g.whenSubmit(e,t)}},e.Base.mix(e.M.editor_atto.Editor,[b]),w.ATTRS={sanitize:{value:!0,writeOnce:!0}},w.prototype={getCleanHTML:function(){var t=this.editor.cloneNode(!0),n;return e.each(t.all('[id^="yui"]'),function(e){e.removeAttribute("id")}),t.all(".atto_control").remove(!0),n=t.get("innerHTML"),n==="<p></p>"||n==="<p><br></p>"?"":(n=n.replace(/<(audio|video) ([^>]*)data-autoplay([^>]*)>/g,"<$1 $2autoplay$3>"),this._cleanHTML(n))},cleanEditorHTML:function(){var e=this.editor.get("innerHTML");return this.editor.set("innerHTML",this._cleanHTML(e)),this},_cleanHTML:function(e){var t=[{regex:/<style[^>]*>[\s\S]*?<\/style>/gi,replace:""},{regex:/<!--(?![\s\S]*?-->)/gi,replace:""},{regex:/<\/?(?:title|meta|style|st\d|head|font|html|body|link)[^>]*?>/gi,replace:""}];return e=this._filterContentWithRules(e,t),this.get("sanitize")!==!1&&(e=this._domPurify.sanitize(e,this._domPurifyConfig)),e},_filterContentWithRules:function(e,t){var n=0;for(n=0;n<t.length;n++)e=e.replace(t[n].regex,t[n].replace);return e},pasteCleanup:function(e){if(e.type==="paste"){var t=e._event;if(!(t&&t.clipboardData&&t.clipboardData.getData&&t.clipboardData.types))return this.fallbackPasteCleanupDelayed(),!0;var n=t.clipboardData.types,r=!1;typeof n.contains=="function"?r=n.contains("text/html"):typeof n.indexOf=="function"&&(r=n.indexOf("text/html")>-1);var i;if(r){try{i=t.clipboardData.getData("text/html")}catch(s){return this.fallbackPasteCleanupDelayed(),!0}e.preventDefault(),i=this._cleanPasteHTML(i);var o=window.rangy.saveSelection();return this.insertContentAtFocusPoint(i),window.rangy.restoreSelection(o),window.rangy.getSelection().collapseToEnd(),this.updateOriginal(),!1}try{i=t.clipboardData.getData("text")}catch(s){return this.fallbackPasteCleanupDelayed(),!0}}return this.updateOriginalDelayed(),!0},fallbackPasteCleanup:function(){var e=window.rangy.saveSelection(),t=this.editor.get("innerHTML");return this.editor.set("innerHTML",this._cleanPasteHTML(t)),this.updateOriginal(),window.rangy.restoreSelection(e),this},fallbackPasteCleanupDelayed:function(){return e.soon(e.bind(this.fallbackPasteCleanup,this)),this},_cleanPasteHTML:function(e){if(!e||e.length===0)return"";var t=[{regex:/<\s*\/html\s*>([\s\S]+)$/gi,replace:""},{regex:/^([\s\S]+)<html[^>]*>/gi,replace:""},{regex:/<head[^>]*>[\s\S]*?<\/head>/gi,replace:""},{regex:/<!--\[if[\s\S]*?endif\]-->/gi,replace:""},{regex:/<!--(Start|End)Fragment-->/gi,replace:""},{regex:/<xml[^>]*>[\s\S]*?<\/xml>/gi,replace:""},{regex:/<\?xml[^>]*>[\s\S]*?<\\\?xml>/gi,replace:""},{regex:/<\/?\w+:[^>]*>/gi,replace:""},{regex:/<script[^>]*>[\s\S]*?<\/script>/gi,replace:""},{regex:/<script[^>]*\/>/gi,replace:""},{regex:/<iframe[^>]*>[\s\S]*?<\/iframe>/gi,replace:""}];e=this._filterContentWithRules(e,t),e=this._cleanHTML(e);if(e.length===0||!e.match(/\S/))return e;var n=document.createElement("div");return n.innerHTML=e,e=n.innerHTML,n.innerHTML="",t=[{regex:/(<[^>]*?class\s*?=\s*?")([^>"]*)(")/gi,replace:function(e,t,n,r){return n=n.replace(/(?:^|[\s])[\s]*MSO[_a-zA-Z0-9\-]*/gi,""),n=n.replace(/(?:^|[\s])[\s]*Apple-[_a-zA-Z0-9\-]*/gi,""),t+n+r}},{regex:/<a [^>]*?name\s*?=\s*?"OLE_LINK\d*?"[^>]*?>\s*?<\/a>/gi,replace:""}],e=this._cleanStyles(e),e=this._filterContentWithRules(e,t),e=this._cleanHTML(e),e=this._cleanSpans(e),e},_cleanStyles:function(e){var t=document.createElement("div");t.innerHTML=e;var n=t.querySelectorAll("[style]"),r=0;for(r=0;r<n.length;r++)n[r].removeAttribute("style");var i=t.querySelectorAll("[class]");for(r=0;r<i.length;r++)i[r].removeAttribute("class");return t.innerHTML},_cleanSpans:function(e){if(!e||e.length===0)return"";if(e.length===0||!e.match(/\S/))return e;var t=[{regex:/(<[^>]*?)(?:[\s]*(?:class|style|id)\s*?=\s*?"\s*?")+/gi,replace:"$1"}];e=this._filterContentWithRules(e,t);var n=document.createElement("div");n.innerHTML=e;var r=n.getElementsByTagName("span"),i=Array.prototype.slice.call(r,0);return i.forEach(function(e){if(!e.hasAttributes()){while(e.firstChild)e.parentNode.insertBefore(e.firstChild,e);e.parentNode.removeChild(e)}}),n.innerHTML}},e.Base.mix(e.M.editor_atto.Editor,[w]),E.ATTRS={},E.prototype={applyFormat:function(t,n,r,i){function s(t,n,r,i,s,o){e.soon(e.bind(function(e,t,n,r,i,s){var o=window.rangy.getSelection(),u=o.getRangeAt(0);u.setStart(i,s),o.setSingleRange(u),t.apply(n,[e,r]),o.collapseToEnd(),this.saveSelection(),this.updateOriginal()},this,t,n,r,i,s,o))}r=r||this;var o=window.rangy.getSelection();if(o.isCollapsed){var u=this.editor.once("input",s,this,n,r,i,o.anchorNode,o.anchorOffset);this.editor.onceAfter(["click","selectstart"],u.detach,u);return}n.apply(r,[t,i]),this.saveSelection(),this.updateOriginal()},replaceTags:function(t,n){t.setAttribute("data-iterate",!0);var r=this.editor.one('[data-iterate="true"]');while(r){var i=e.Node.create("<"+n+" />").setAttrs(r.getAttrs()).removeAttribute("data-iterate");r.getAttribute("style")&&i.setAttribute("style",r.getAttribute("style")),r.getAttribute("class")&&i.setAttribute("class",r.getAttribute("class"));var s=r.getDOMNode().childNodes,o;o=s[0];while(typeof o!="undefined")i.append(o),o=s[0];r.replace(i),r=this.editor.one('[data-iterate="true"]')}},
changeToCSS:function(e,t){var n=window.rangy.saveSelection();this.editor.all(".rangySelectionBoundary").setStyle("display",null),this.editor.all(e).addClass(t),this.replaceTags(this.editor.all("."+t),"span"),window.rangy.restoreSelection(n)},changeToTags:function(e,t){var n=window.rangy.saveSelection();this.editor.all(".rangySelectionBoundary").setStyle("display",null),this.replaceTags(this.editor.all('span[class="'+e+'"]'),t),this.editor.all(t+'[class="'+e+'"]').removeAttribute("class"),this.editor.all("."+e).each(function(n){n.wrap("<"+t+"/>"),n.removeClass(e)}),this.editor.all('[class="'+e+'"]').removeAttribute("class"),this.editor.all(t).removeClass(e),window.rangy.restoreSelection(n)}},e.Base.mix(e.M.editor_atto.Editor,[E]),S.ATTRS={},S.prototype={toolbar:null,openMenus:null,setupToolbar:function(){return this.toolbar=e.Node.create('<div class="'+r.TOOLBAR+'" role="toolbar" aria-live="off"/>'),this.openMenus=[],this._wrapper.appendChild(this.toolbar),this.textareaLabel&&this.toolbar.setAttribute("aria-labelledby",this.textareaLabel.get("id")),this.setupToolbarNavigation(),this}},e.Base.mix(e.M.editor_atto.Editor,[S]),x.ATTRS={},x.prototype={_tabFocus:null,setupToolbarNavigation:function(){return this._wrapper.delegate("key",this.toolbarKeyboardNavigation,"down:37,39","."+r.TOOLBAR,this),this._wrapper.delegate("focus",function(e){this._setTabFocus(e.currentTarget)},"."+r.TOOLBAR+" button",this),this},toolbarKeyboardNavigation:function(e){e.preventDefault();var t=this.toolbar.all("button"),n=1,r,i=e.target.ancestor("button",!0);e.keyCode===37&&(n=-1),r=this._findFirstFocusable(t,i,n),r&&(r.focus(),this._setTabFocus(r))},_findFirstFocusable:function(e,t,n){var r=0,i,s,o,u;u=e.indexOf(t),u<-1&&(u=0);while(r<e.size()){u+=n,u<0?u=e.size()-1:u>=e.size()&&(u=0),s=e.item(u),r++;if(s.hasAttribute("hidden")||s.hasAttribute("disabled"))continue;i=s.ancestor(".atto_group");if(i.hasAttribute("hidden"))continue;o=s;break}return o},checkTabFocus:function(){if(this._tabFocus)if(this._tabFocus.hasAttribute("disabled")||this._tabFocus.hasAttribute("hidden")||this._tabFocus.ancestor(".atto_group").hasAttribute("hidden")){var e=this._findFirstFocusable(this.toolbar.all("button"),this._tabFocus,-1);e&&(this._tabFocus.compareTo(document.activeElement)&&e.focus(),this._setTabFocus(e))}return this},_setTabFocus:function(e){return this._tabFocus&&this._tabFocus.setAttribute("tabindex","-1"),this._tabFocus=e,this._tabFocus.setAttribute("tabindex",0),this.toolbar.setAttribute("aria-activedescendant",this._tabFocus.generateID()),this}},e.Base.mix(e.M.editor_atto.Editor,[x]),T.ATTRS={},T.prototype={_selections:null,_lastSelection:null,_focusFromClick:!1,setupSelectionWatchers:function(){return this.on("atto:selectionchanged",this.saveSelection,this),this.editor.on("focus",this.restoreSelection,this),this.editor.on("mousedown",function(){this._focusFromClick=!0},this),this.editor.on("blur",function(){this._focusFromClick=!1,this.updateOriginal()},this),this.editor.on(["keyup","focus"],function(t){e.soon(e.bind(this._hasSelectionChanged,this,t))},this),e.one(document.body).on("gesturemoveend",function(t){e.soon(e.bind(this._hasSelectionChanged,this,t))},{standAlone:!0},this),this},isActive:function(){var e=i.createRange(),t=i.getSelection();return t.rangeCount?!document.activeElement||!this.editor.compareTo(document.activeElement)&&!this.editor.contains(document.activeElement)?!1:(e.selectNode(this.editor.getDOMNode()),e.intersectsRange(t.getRangeAt(0))):!1},getSelectionFromNode:function(e){var t=i.createRange();return t.selectNode(e.getDOMNode()),[t]},saveSelection:function(){this.isActive()&&(this._selections=this.getSelection())},restoreSelection:function(){this._focusFromClick||this._selections&&this.setSelection(this._selections),this._focusFromClick=!1},getSelection:function(){return i.getSelection().getAllRanges()},selectionContainsNode:function(e){return i.getSelection().containsNode(e.getDOMNode(),!0)},selectionFilterMatches:function(e,t,n){typeof n=="undefined"&&(n=!0),t||(t=this.getSelectedNodes());var r=t.size()>0,i=!1,s=this.editor,o=function(e){return e===s};return s.one(e)?(t.each(function(t){if(n){if(!r||!t.ancestor(e,!0,o))r=!1}else!i&&t.ancestor(e,!0,o)&&(i=!0)},this),n?r:i):!1},getSelectedNodes:function(){var t=new e.NodeList,n,r,s,o,u;r=i.getSelection(),r.rangeCount?s=r.getRangeAt(0):s=i.createRange(),s.collapsed&&s.commonAncestorContainer!==this.editor.getDOMNode()&&s.commonAncestorContainer!==e.config.doc&&(s=s.cloneRange(),s.selectNode(s.commonAncestorContainer)),n=s.getNodes();for(u=0;u<n.length;u++)o=e.one(n[u]),this.editor.contains(o)&&t.push(o);return t},_hasSelectionChanged:function(e){var t=i.getSelection(),n,r=!1;return t.rangeCount?n=t.getRangeAt(0):n=i.createRange(),this._lastSelection&&!this._lastSelection.equals(n)?(r=!0,this._fireSelectionChanged(e)):(this._lastSelection=n,r)},_fireSelectionChanged:function(e){this.fire("atto:selectionchanged",{event:e,selectedNodes:this.getSelectedNodes()})},getSelectionParentNode:function(){var e=i.getSelection();return e.rangeCount?e.getRangeAt(0).commonAncestorContainer:!1},setSelection:function(e){var t=i.getSelection();t.setRanges(e)},insertContentAtFocusPoint:function(t){var n=i.getSelection(),r,s=e.Node.create(t);return n.rangeCount&&(r=n.getRangeAt(0)),r&&(r.deleteContents(),r.insertNode(s.getDOMNode())),s}},e.Base.mix(e.M.editor_atto.Editor,[T]),N.ATTRS={},N.prototype={disableCssStyling:function(){try{document.execCommand("styleWithCSS",0,!1)}catch(e){try{document.execCommand("useCSS",0,!0)}catch(t){try{document.execCommand("styleWithCSS",!1,!1)}catch(n){}}}},enableCssStyling:function(){try{document.execCommand("styleWithCSS",0,!0)}catch(e){try{document.execCommand("useCSS",0,!1)}catch(t){try{document.execCommand("styleWithCSS",!1,!0)}catch(n){}}}},toggleInlineSelectionClass:function(e){var t=e.join(" "),n=i.createClassApplier(t,{normalize:!0});n.toggleSelection()},formatSelectionInlineStyle:function(e){var t=this.PLACEHOLDER_CLASS,n=i.createClassApplier
(t,{normalize:!0});n.applyToSelection(),this.editor.all("."+t).each(function(n){n.removeClass(t).setStyles(e)},this)},formatSelectionBlock:function(t,n){var r=this.getSelectionParentNode(),i,s,o,u,a,f;if(!r)return!1;i=this.editor,r=e.one(r),s=r.ancestor(function(e){var t=e.get("tagName");return t&&(t=t.toLowerCase()),e===i||t==="td"||t==="th"},!0),s&&(i=s),o=r.ancestor(this.BLOCK_TAGS.join(", "),!0),o&&(a=o.ancestor(function(e){return e===i},!1),a||(o=!1)),o||(u=e.Node.create("<p></p>"),i.get("childNodes").each(function(e){u.append(e.remove())}),i.append(u),o=u),t&&t!==""&&(f=e.Node.create("<"+t+"></"+t+">"),f.setAttrs(o.getAttrs()),o.get("childNodes").each(function(e){e.remove(),f.append(e)}),o.replace(f),o=f),n&&o.setAttrs(n);var l=this.getSelectionFromNode(o);return this.setSelection(l),o}},e.Base.mix(e.M.editor_atto.Editor,[N]),C.ATTRS={filepickeroptions:{value:{}}},C.prototype={canShowFilepicker:function(e){return typeof this.get("filepickeroptions")[e]!="undefined"},showFilepicker:function(t,n,r){var i=this;e.use("core_filepicker",function(e){var s=e.clone(i.get("filepickeroptions")[t],!0);s.formcallback=n,r&&(s.magicscope=r),M.core_filepicker.show(e,s)})}},e.Base.mix(e.M.editor_atto.Editor,[C])},"@VERSION@",{requires:["node","transition","io","overlay","escape","event","event-simulate","event-custom","node-event-html5","node-event-simulate","yui-throttle","moodle-core-notification-dialogue","moodle-core-notification-confirm","moodle-editor_atto-rangy","moodle-editor_atto-dompurify","handlebars","timers","querystring-stringify"]});
