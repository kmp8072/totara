YUI.add("moodle-atto_media-button",function(e,t){var n="atto_media",r={LINK:"LINK",VIDEO:"VIDEO",AUDIO:"AUDIO"},i={SUBTITLES:"SUBTITLES",CAPTIONS:"CAPTIONS",DESCRIPTIONS:"DESCRIPTIONS",CHAPTERS:"CHAPTERS",METADATA:"METADATA"},s={SOURCE:"atto_media_source",TRACK:"atto_media_track",MEDIA_SOURCE:"atto_media_media_source",LINK_SOURCE:"atto_media_link_source",POSTER_SOURCE:"atto_media_poster_source",TRACK_SOURCE:"atto_media_track_source",DISPLAY_OPTIONS:"atto_media_display_options",NAME_INPUT:"atto_media_name_entry",URL_INPUT:"atto_media_url_entry",POSTER_SIZE:"atto_media_poster_size",LINK_SIZE:"atto_media_link_size",WIDTH_INPUT:"atto_media_width_entry",HEIGHT_INPUT:"atto_media_height_entry",TRACK_KIND_INPUT:"atto_media_track_kind_entry",TRACK_LABEL_INPUT:"atto_media_track_label_entry",TRACK_LANG_INPUT:"atto_media_track_lang_entry",TRACK_DEFAULT_SELECT:"atto_media_track_default",MEDIA_CONTROLS_TOGGLE:"atto_media_controls",MEDIA_AUTOPLAY_TOGGLE:"atto_media_autoplay",MEDIA_MUTE_TOGGLE:"atto_media_mute",MEDIA_LOOP_TOGGLE:"atto_media_loop",ADVANCED_SETTINGS:"atto_media_advancedsettings",LINK:r.LINK.toLowerCase(),VIDEO:r.VIDEO.toLowerCase(),AUDIO:r.AUDIO.toLowerCase(),TRACK_SUBTITLES:i.SUBTITLES.toLowerCase(),TRACK_CAPTIONS:i.CAPTIONS.toLowerCase(),TRACK_DESCRIPTIONS:i.DESCRIPTIONS.toLowerCase(),TRACK_CHAPTERS:i.CHAPTERS.toLowerCase(),TRACK_METADATA:i.METADATA.toLowerCase()},o={SOURCE:"."+s.SOURCE,TRACK:"."+s.TRACK,MEDIA_SOURCE:"."+s.MEDIA_SOURCE,POSTER_SOURCE:"."+s.POSTER_SOURCE,TRACK_SOURCE:"."+s.TRACK_SOURCE,DISPLAY_OPTIONS:"."+s.DISPLAY_OPTIONS,NAME_INPUT:"."+s.NAME_INPUT,URL_INPUT:"."+s.URL_INPUT,POSTER_SIZE:"."+s.POSTER_SIZE,LINK_SIZE:"."+s.LINK_SIZE,WIDTH_INPUT:"."+s.WIDTH_INPUT,HEIGHT_INPUT:"."+s.HEIGHT_INPUT,TRACK_KIND_INPUT:"."+s.TRACK_KIND_INPUT,TRACK_LABEL_INPUT:"."+s.TRACK_LABEL_INPUT,TRACK_LANG_INPUT:"."+s.TRACK_LANG_INPUT,TRACK_DEFAULT_SELECT:"."+s.TRACK_DEFAULT_SELECT,MEDIA_CONTROLS_TOGGLE:"."+s.MEDIA_CONTROLS_TOGGLE,MEDIA_AUTOPLAY_TOGGLE:"."+s.MEDIA_AUTOPLAY_TOGGLE,MEDIA_MUTE_TOGGLE:"."+s.MEDIA_MUTE_TOGGLE,MEDIA_LOOP_TOGGLE:"."+s.MEDIA_LOOP_TOGGLE,ADVANCED_SETTINGS:"."+s.ADVANCED_SETTINGS,LINK_TAB:'li[data-medium-type="'+s.LINK+'"]',LINK_PANE:'.tab-pane[data-medium-type="'+s.LINK+'"]',VIDEO_TAB:'li[data-medium-type="'+s.VIDEO+'"]',VIDEO_PANE:'.tab-pane[data-medium-type="'+s.VIDEO+'"]',AUDIO_TAB:'li[data-medium-type="'+s.AUDIO+'"]',AUDIO_PANE:'.tab-pane[data-medium-type="'+s.AUDIO+'"]',TRACK_SUBTITLES_TAB:'li[data-track-kind="'+s.TRACK_SUBTITLES+'"]',TRACK_SUBTITLES_PANE:'.tab-pane[data-track-kind="'+s.TRACK_SUBTITLES+'"]',TRACK_CAPTIONS_TAB:'li[data-track-kind="'+s.TRACK_CAPTIONS+'"]',TRACK_CAPTIONS_PANE:'.tab-pane[data-track-kind="'+s.TRACK_CAPTIONS+'"]',TRACK_DESCRIPTIONS_TAB:'li[data-track-kind="'+s.TRACK_DESCRIPTIONS+'"]',TRACK_DESCRIPTIONS_PANE:'.tab-pane[data-track-kind="'+s.TRACK_DESCRIPTIONS+'"]',TRACK_CHAPTERS_TAB:'li[data-track-kind="'+s.TRACK_CHAPTERS+'"]',TRACK_CHAPTERS_PANE:'.tab-pane[data-track-kind="'+s.TRACK_CHAPTERS+'"]',TRACK_METADATA_TAB:'li[data-track-kind="'+s.TRACK_METADATA+'"]',TRACK_METADATA_PANE:'.tab-pane[data-track-kind="'+s.TRACK_METADATA+'"]'},u={ROOT:'<form class="mform atto_form atto_media" id="{{elementid}}_atto_media_form"><ul class="root nav nav-tabs" role="tablist"><li data-medium-type="{{CSS.LINK}}" class="nav-item"><a class="nav-link active" href="#{{elementid}}_{{CSS.LINK}}" role="tab" data-toggle="tab">{{get_string "link" component}}</a></li><li data-medium-type="{{CSS.VIDEO}}" class="nav-item"><a class="nav-link" href="#{{elementid}}_{{CSS.VIDEO}}" role="tab" data-toggle="tab">{{get_string "video" component}}</a></li><li data-medium-type="{{CSS.AUDIO}}" class="nav-item"><a class="nav-link" href="#{{elementid}}_{{CSS.AUDIO}}" role="tab" data-toggle="tab">{{get_string "audio" component}}</a></li></ul><div class="root tab-content"><div data-medium-type="{{CSS.LINK}}" class="tab-pane active" id="{{elementid}}_{{CSS.LINK}}">{{> tab_panes.link}}</div><div data-medium-type="{{CSS.VIDEO}}" class="tab-pane" id="{{elementid}}_{{CSS.VIDEO}}">{{> tab_panes.video}}</div><div data-medium-type="{{CSS.AUDIO}}" class="tab-pane" id="{{elementid}}_{{CSS.AUDIO}}">{{> tab_panes.audio}}</div></div><div class="mdl-align"><br/><button class="submit" type="submit">{{get_string "createmedia" component}}</button></div></form>',TAB_PANES:{LINK:'{{renderPartial "form_components.source" context=this id=CSS.LINK_SOURCE}}<label>Enter name<input class="fullwidth {{CSS.NAME_INPUT}}" type="text" id="{{elementid}}_link_nameentry"size="32" required="true"/></label>',VIDEO:'{{renderPartial "form_components.source" context=this id=CSS.MEDIA_SOURCE entersourcelabel="videosourcelabel" addcomponentlabel="addsource" multisource="true" addsourcehelp=helpStrings.addsource}}<fieldset class="collapsible collapsed" id="{{elementid}}_video-display-options"><input name="mform_isexpanded_{{elementid}}_video-display-options" type="hidden"><legend class="ftoggler">{{get_string "displayoptions" component}}</legend><div class="fcontainer">{{> form_components.display_options}}</div></fieldset><fieldset class="collapsible collapsed" id="{{elementid}}_video-advanced-settings"><input name="mform_isexpanded_{{elementid}}_video-advanced-settings" type="hidden"><legend class="ftoggler">{{get_string "advancedsettings" component}}</legend><div class="fcontainer">{{> form_components.advanced_settings}}</div></fieldset><fieldset class="collapsible collapsed" id="{{elementid}}_video-tracks"><input name="mform_isexpanded_{{elementid}}_video-tracks" type="hidden"><legend class="ftoggler">{{get_string "tracks" component}} {{{helpStrings.tracks}}}</legend><div class="fcontainer">{{renderPartial "form_components.track_tabs" context=this id=CSS.VIDEO}}</div></fieldset>',AUDIO:'{{renderPartial "form_components.source" context=this id=CSS.MEDIA_SOURCE entersourcelabel="audiosourcelabel" addcomponentlabel="addsource" multisource="true" addsourcehelp=helpStrings.addsource}}<fieldset class="collapsible collapsed" id="{{elementid}}_audio-advanced-settings"><input name="mform_isexpanded_{{elementid}}_audio-advanced-settings" type="hidden"><legend class="ftoggler">{{get_string "advancedsettings" component}}</legend><div class="fcontainer">{{> form_components.advanced_settings}}</div></fieldset><fieldset class="collapsible collapsed" id="{{elementid}}_audio-tracks"><input name="mform_isexpanded_{{elementid}}_audio-tracks" type="hidden"><legend class="ftoggler">{{get_string "tracks" component}} {{{helpStrings.tracks}}}</legend><div class="fcontainer">{{renderPartial "form_components.track_tabs" context=this id=CSS.AUDIO}}</div></fieldset>'
},FORM_COMPONENTS:{SOURCE:'<div class="{{CSS.SOURCE}} {{id}}"><label>{{#entersourcelabel}}{{get_string ../entersourcelabel ../component}}{{/entersourcelabel}}{{^entersourcelabel}}{{get_string "entersource" ../component}}{{/entersourcelabel}}</a><br/><input class="{{CSS.URL_INPUT}}" type="url" size="32"/></label><button class="openmediabrowser" type="button">{{get_string "browserepositories" component}}</button>{{#multisource}}{{renderPartial "form_components.add_component" context=../this label=../addcomponentlabel  help=../addsourcehelp}}{{/multisource}}</div>',ADD_COMPONENT:'<div><a href="#" class="addcomponent">{{#label}}{{get_string ../label ../component}}{{/label}}{{^label}}{{get_string "add" ../component}}{{/label}}</a>{{#help}}{{{../help}}}{{/help}}</div>',REMOVE_COMPONENT:'<div><a href="#" class="removecomponent">{{#label}}{{get_string ../label ../component}}{{/label}}{{^label}}{{get_string "remove" ../component}}{{/label}}</a></div>',DISPLAY_OPTIONS:'<div class="{{CSS.DISPLAY_OPTIONS}}"><label>{{get_string "size" component}}<div class={{CSS.POSTER_SIZE}}><label><span class="accesshide">{{get_string "videowidth" component}}</span><input type="text" class="{{CSS.WIDTH_INPUT}} input-mini" size="4"/></label> x <label><span class="accesshide">{{get_string "videoheight" component}}</span><input type="text" class="{{CSS.HEIGHT_INPUT}} input-mini" size="4"/></label></div></label><div class="clearfix"></div>{{renderPartial "form_components.source" context=this id=CSS.POSTER_SOURCE entersourcelabel="poster"}}<div>',ADVANCED_SETTINGS:'<div class="{{CSS.ADVANCED_SETTINGS}}"><label><input type="checkbox" checked="true" class="{{CSS.MEDIA_CONTROLS_TOGGLE}}"/>{{get_string "controls" component}}</label><label><input type="checkbox" class="{{CSS.MEDIA_AUTOPLAY_TOGGLE}}"/>{{get_string "autoplay" component}}</label><label><input type="checkbox" class="{{CSS.MEDIA_MUTE_TOGGLE}}"/>{{get_string "mute" component}}</label><label><input type="checkbox" class="{{CSS.MEDIA_LOOP_TOGGLE}}"/>{{get_string "loop" component}}</label></div>',TRACK_TABS:'<ul class="nav nav-tabs"><li data-track-kind="{{CSS.TRACK_SUBTITLES}}" class="nav-item"><a class="nav-link active" href="#{{elementid}}_{{id}}_{{CSS.TRACK_SUBTITLES}}" role="tab" data-toggle="tab">{{get_string "subtitles" component}}</a></li><li data-track-kind="{{CSS.TRACK_CAPTIONS}}" class="nav-item"><a class="nav-link" href="#{{elementid}}_{{id}}_{{CSS.TRACK_CAPTIONS}}" role="tab" data-toggle="tab">{{get_string "captions" component}}</a></li><li data-track-kind="{{CSS.TRACK_DESCRIPTIONS}}"  class="nav-item"><a class="nav-link" href="#{{elementid}}_{{id}}_{{CSS.TRACK_DESCRIPTIONS}}" role="tab" data-toggle="tab">{{get_string "descriptions" component}}</a></li><li data-track-kind="{{CSS.TRACK_CHAPTERS}}" class="nav-item"><a class="nav-link" href="#{{elementid}}_{{id}}_{{CSS.TRACK_CHAPTERS}}" role="tab" data-toggle="tab">{{get_string "chapters" component}}</a></li><li data-track-kind="{{CSS.TRACK_METADATA}}" class="nav-item"><a class="nav-link" href="#{{elementid}}_{{id}}_{{CSS.TRACK_METADATA}}" role="tab" data-toggle="tab">{{get_string "metadata" component}}</a></li></ul><div class="tab-content"><div data-track-kind="{{CSS.TRACK_SUBTITLES}}" class="tab-pane active" id="{{elementid}}_{{id}}_{{CSS.TRACK_SUBTITLES}}"><div class="trackhelp">{{{helpStrings.subtitles}}}</div>{{renderPartial "form_components.track" context=this sourcelabel="subtitlessourcelabel" addcomponentlabel="addsubtitlestrack"}}</div><div data-track-kind="{{CSS.TRACK_CAPTIONS}}" class="tab-pane" id="{{elementid}}_{{id}}_{{CSS.TRACK_CAPTIONS}}"><div class="trackhelp">{{{helpStrings.captions}}}</div>{{renderPartial "form_components.track" context=this sourcelabel="captionssourcelabel" addcomponentlabel="addcaptionstrack"}}</div><div data-track-kind="{{CSS.TRACK_DESCRIPTIONS}}" class="tab-pane" id="{{elementid}}_{{id}}_{{CSS.TRACK_DESCRIPTIONS}}"><div class="trackhelp">{{{helpStrings.descriptions}}}</div>{{renderPartial "form_components.track" context=this sourcelabel="descriptionssourcelabel" addcomponentlabel="adddescriptionstrack"}}</div><div data-track-kind="{{CSS.TRACK_CHAPTERS}}" class="tab-pane" id="{{elementid}}_{{id}}_{{CSS.TRACK_CHAPTERS}}"><div class="trackhelp">{{{helpStrings.chapters}}}</div>{{renderPartial "form_components.track" context=this sourcelabel="chapterssourcelabel" addcomponentlabel="addchapterstrack"}}</div><div data-track-kind="{{CSS.TRACK_METADATA}}" class="tab-pane" id="{{elementid}}_{{id}}_{{CSS.TRACK_METADATA}}"><div class="trackhelp">{{{helpStrings.metadata}}}</div>{{renderPartial "form_components.track" context=this sourcelabel="metadatasourcelabel" addcomponentlabel="addmetadatatrack"}}</div></div>',TRACK:'<div class="{{CSS.TRACK}}">{{renderPartial "form_components.source" context=this id=CSS.TRACK_SOURCE entersourcelabel=sourcelabel}}<label class="langlabel"><span>{{get_string "srclang" component}}</span><select class="{{CSS.TRACK_LANG_INPUT}}"><optgroup label="{{get_string "languagesinstalled" component}}">{{#langsinstalled}}<option value="{{code}}" {{#default}}selected="selected"{{/default}}>{{lang}}</option>{{/langsinstalled}}</optgroup><optgroup label="{{get_string "languagesavailable" component}} ">{{#langsavailable}}<option value="{{code}}">{{lang}}</option>{{/langsavailable}}</optgroup></select></label><label class="labellabel"><span>{{get_string "label" component}}</span><input class="{{CSS.TRACK_LABEL_INPUT}}" type="text"/></label><label class="defaultlabel"><input type="checkbox" class="{{CSS.TRACK_DEFAULT_SELECT}}"/>{{get_string "default" component}}</label>{{renderPartial "form_components.add_component" context=this label=addcomponentlabel}}</div>'},HTML_MEDIA:{VIDEO:'&nbsp;<video {{#width}}width="{{../width}}" {{/width}}{{#height}}height="{{../height}}" {{/height}}{{#poster}}poster="{{../poster}}" {{/poster}}{{#showControls}}controls="true" {{/showControls}}{{#loop}}loop="true" {{/loop}}{{#muted}}muted="true" {{/muted}}{{#autoplay}}data-autoplay="true" {{/autoplay}}>{{#sources}}<source src="{{source}}">{{/sources}}{{#tracks}}<track src="{{track}}" kind="{{kind}}" srclang="{{srclang}}" label="{{label}}" {{#defaultTrack}}default="true"{{/defaultTrack}}>{{/tracks}}{{#description}}{{../description}}{{/description}}</video>&nbsp'
,AUDIO:'&nbsp;<audio {{#showControls}}controls="true" {{/showControls}}{{#loop}}loop="true" {{/loop}}{{#muted}}muted="true" {{/muted}}{{#autoplay}}data-autoplay="true" {{/autoplay}}>{{#sources}}<source src="{{source}}">{{/sources}}{{#tracks}}<track src="{{track}}" kind="{{kind}}" srclang="{{srclang}}" label="{{label}}" {{#defaultTrack}}default="true"{{/defaultTrack}}>{{/tracks}}{{#description}}{{../description}}{{/description}}</audio>&nbsp',LINK:'<a href="{{url}}" {{#width}}data-width="{{../width}}" {{/width}}{{#height}}data-height="{{../height}}"{{/height}}>{{#name}}{{../name}}{{/name}}{{^name}}{{../url}}{{/name}}</a>'}};e.namespace("M.atto_media").Button=e.Base.create("button",e.M.editor_atto.EditorPlugin,[],{initializer:function(){this.get("host").canShowFilepicker("media")&&(this.editor.delegate("dblclick",this._displayDialogue,"video",this),this.editor.delegate("click",this._handleClick,"video",this),this.addButton({icon:"e/insert_edit_video",callback:this._displayDialogue,tags:"video, audio",tagMatchRequiresAll:!1}))},_getContext:function(t){return e.merge({elementid:this.get("host").get("elementid"),component:n,langsinstalled:this.get("langs").installed,langsavailable:this.get("langs").available,helpStrings:this.get("help"),CSS:s},t)},_handleClick:function(e){var t=e.target,n=this.get("host").getSelectionFromNode(t);this.get("host").getSelection()!==n&&this.get("host").setSelection(n)},_displayDialogue:function(){if(this.get("host").getSelection()===!1)return;"renderPartial"in e.Handlebars.helpers||(function r(t,n){e.each(n,function(n,i){t.push(i),typeof n!="object"?e.Handlebars.registerPartial(t.join(".").toLowerCase(),n):r(t,n),t.pop()})}([],u),e.Handlebars.registerHelper("renderPartial",function(t,n){if(!t)return"";var r=e.Handlebars.partials[t],i=n.hash.context?e.clone(n.hash.context):{},s=e.merge(i,n.hash);return delete s.context,r?new e.Handlebars.SafeString(e.Handlebars.compile(r)(s)):""}));var t=this.getDialogue({headerContent:M.util.get_string("createmedia",n),focusAfterHide:!0,width:660,focusOnShowSelector:o.URL_INPUT});t.set("bodyContent",this._getDialogueContent(this.get("host").getSelection())).show(),M.form.shortforms({formid:this.get("host").get("elementid")+"_atto_media_form"})},_getDialogueContent:function(t){var n=e.Node.create(e.Handlebars.compile(u.ROOT)(this._getContext())),r=this.get("host").getSelectedNodes().filter("video,audio").shift(),i=r?this._getMediumProperties(r):!1;return this._attachEvents(this._applyMediumProperties(n,i),t)},_attachEvents:function(e,t){return e.delegate("click",function(e){e.preventDefault(),this._addMediaSourceComponent(e.currentTarget)},o.MEDIA_SOURCE+" .addcomponent",this),e.delegate("click",function(e){e.preventDefault(),this._addTrackComponent(e.currentTarget)},o.TRACK+" .addcomponent",this),e.delegate("click",function(e){var t=e.currentTarget;if(t.get("checked")){var n=function(e){return this._getTrackTypeFromTabPane(e.ancestor(".tab-pane"))}.bind(this);t.ancestor(".root.tab-content").all(o.TRACK_DEFAULT_SELECT).each(function(e){e!==t&&n(t)===n(e)&&e.set("checked",!1)})}},o.TRACK_DEFAULT_SELECT,this),e.delegate("click",function(e){var t=e.currentTarget,n=t.ancestor(o.POSTER_SOURCE)&&"image"||t.ancestor(o.TRACK_SOURCE)&&"subtitle"||"media";e.preventDefault(),this.get("host").showFilepicker(n,this._getFilepickerCallback(t,n),this)},".openmediabrowser",this),e.all(".nav-item").on("click",function(e){e.currentTarget.get("parentNode").all(".active").removeClass("active")}),e.one(".submit").on("click",function(e){e.preventDefault();var n=this._getMediaHTML(e.currentTarget.ancestor(".atto_form")),r=this.get("host");this.getDialogue({focusAfterHide:null}).hide(),n&&(r.setSelection(t),r.insertContentAtFocusPoint(n),this.markUpdated())},this),e},_applyMediumProperties:function(t,n){if(!n)return t;var r=function(e,t){e.one(o.TRACK_SOURCE+" "+o.URL_INPUT).set("value",t.src),e.one(o.TRACK_LANG_INPUT).set("value",t.srclang),e.one(o.TRACK_LABEL_INPUT).set("value",t.label),e.one(o.TRACK_DEFAULT_SELECT).set("checked",t.defaultTrack)},i=t.one(".root.tab-content > .tab-pane#"+this.get("host").get("elementid")+"_"+n.type.toLowerCase());i.one(o.MEDIA_SOURCE+" "+o.URL_INPUT).set("value",n.sources[0]),e.Array.each(n.sources.slice(1),function(e){this._addMediaSourceComponent(i.one(o.MEDIA_SOURCE+" .addcomponent"),function(t){t.one(o.URL_INPUT).set("value",e)})},this),e.Object.each(n.tracks,function(t,n){var s=t.length?t:[{src:"",srclang:"",label:"",defaultTrack:!1}],u=o["TRACK_"+n.toUpperCase()+"_PANE"];r(i.one(u+" "+o.TRACK),s[0]),e.Array.each(s.slice(1),function(e){this._addTrackComponent(i.one(u+" "+o.TRACK+" .addcomponent"),function(t){r(t,e)})},this)},this),i.one(o.POSTER_SOURCE+" "+o.URL_INPUT).setAttribute("value",n.poster),i.one(o.WIDTH_INPUT).set("value",n.width),i.one(o.HEIGHT_INPUT).set("value",n.height),i.one(o.MEDIA_CONTROLS_TOGGLE).set("checked",n.controls),i.one(o.MEDIA_AUTOPLAY_TOGGLE).set("checked",n.autoplay),i.one(o.MEDIA_MUTE_TOGGLE).set("checked",n.muted),i.one(o.MEDIA_LOOP_TOGGLE).set("checked",n.loop);var s=this._getMediumTypeFromTabPane(i);return i.siblings(".active").removeClass("active"),t.all(".root.nav-tabs .nav-item a").removeClass("active"),i.addClass("active"),t.one(o[s.toUpperCase()+"_TAB"]+" a").addClass("active"),t},_getMediumProperties:function(e){var t=function(e,t){return e.getAttribute(t)?!0:!1},n={subtitles:[],captions:[],descriptions:[],chapters:[],metadata:[]};return e.all("track").each(function(e){n[e.getAttribute("kind")].push({src:e.getAttribute("src"),srclang:e.getAttribute("srclang"),label:e.getAttribute("label"),defaultTrack:t(e,"default")})}),{type:e.test("video")?r.VIDEO:r.AUDIO,sources:e.all("source").get("src"),poster:e.getAttribute("poster"),width:e.getAttribute("width"),height:e.getAttribute("height"),autoplay:t(e,"autoplay"),loop:t(e,"loop"),muted:t(e,"muted"),controls:t(e,"controls"),tracks:n}},_addTrackComponent:function(e,t){var n=this._getTrackTypeFromTabPane(e.ancestor(".tab-pane")),r=this.
_getContext({sourcelabel:n+"sourcelabel",addcomponentlabel:"add"+n+"track"});this._addComponent(e,u.FORM_COMPONENTS.TRACK,o.TRACK,r,t)},_addMediaSourceComponent:function(e,t){var n=this._getMediumTypeFromTabPane(e.ancestor(".tab-pane")),r=this._getContext({multisource:!0,id:s.MEDIA_SOURCE,entersourcelabel:n+"sourcelabel",addcomponentlabel:"addsource",addsourcehelp:this.get("help").addsource});this._addComponent(e,u.FORM_COMPONENTS.SOURCE,o.MEDIA_SOURCE,r,t)},_addComponent:function(t,n,r,i,s){var o=t.ancestor(r),a=e.Node.create(e.Handlebars.compile(n)(i)),f=this._getContext(i);f.label="remove";var l=e.Node.create(e.Handlebars.compile(u.FORM_COMPONENTS.REMOVE_COMPONENT)(f));l.one(".removecomponent").on("click",function(e){e.preventDefault(),o.remove(!0)}),o.insert(a,"after"),t.ancestor().insert(l,"after"),t.ancestor().remove(!0),s&&s.call(this,a)},_getFilepickerCallback:function(e,t){return function(n){if(n.url!==""){var r=e.ancestor(".tab-pane");e.ancestor(o.SOURCE).one(o.URL_INPUT).set("value",n.url),r.get("id")===this.get("host").get("elementid")+"_"+s.LINK&&r.one(o.NAME_INPUT).set("value",n.file);if(t==="subtitle"){var i=n.file.split(".vtt")[0].split("-").slice(-1)[0],u=this.get("langs").available.reduce(function(e,t){return t.code===i?t:e},!1);u&&(e.ancestor(o.TRACK).one(o.TRACK_LABEL_INPUT).set("value",u.lang.substr(0,u.lang.lastIndexOf(" "))),e.ancestor(o.TRACK).one(o.TRACK_LANG_INPUT).set("value",u.code))}}}},_getMediumTypeFromTabPane:function(e){return e.getAttribute("data-medium-type")},_getTrackTypeFromTabPane:function(e){return e.getAttribute("data-track-kind")},_getMediaHTML:function(e){var t=this._getMediumTypeFromTabPane(e.one(".root.tab-content > .tab-pane.active")),n=e.one(o[t.toUpperCase()+"_PANE"]);return this["_getMediaHTML"+t[0].toUpperCase()+t.substr(1)](n)},_getMediaHTMLLink:function(t){var n={url:t.one(o.URL_INPUT).get("value"),name:t.one(o.NAME_INPUT).get("value")||!1};return n.url?e.Handlebars.compile(u.HTML_MEDIA.LINK)(n):""},_getMediaHTMLVideo:function(t){var n=this._getContextForMediaHTML(t);return n.width=t.one(o.WIDTH_INPUT).get("value")||!1,n.height=t.one(o.HEIGHT_INPUT).get("value")||!1,n.poster=t.one(o.POSTER_SOURCE+" "+o.URL_INPUT).get("value")||!1,n.sources.length?e.Handlebars.compile(u.HTML_MEDIA.VIDEO)(n):""},_getMediaHTMLAudio:function(t){var n=this._getContextForMediaHTML(t);return n.sources.length?e.Handlebars.compile(u.HTML_MEDIA.AUDIO)(n):""},_getContextForMediaHTML:function(e){var t=[];return e.all(o.TRACK).each(function(e){t.push({track:e.one(o.TRACK_SOURCE+" "+o.URL_INPUT).get("value"),kind:this._getTrackTypeFromTabPane(e.ancestor(".tab-pane")),label:e.one(o.TRACK_LABEL_INPUT).get("value")||e.one(o.TRACK_LANG_INPUT).get("value"),srclang:e.one(o.TRACK_LANG_INPUT).get("value"),defaultTrack:e.one(o.TRACK_DEFAULT_SELECT).get("checked")?"true":null})},this),{sources:e.all(o.MEDIA_SOURCE+" "+o.URL_INPUT).get("value").filter(function(e){return!!e}).map(function(e){return{source:e}}),description:e.one(o.MEDIA_SOURCE+" "+o.URL_INPUT).get("value")||!1,tracks:t.filter(function(e){return!!e.track}),showControls:e.one(o.MEDIA_CONTROLS_TOGGLE).get("checked"),autoplay:e.one(o.MEDIA_AUTOPLAY_TOGGLE).get("checked"),muted:e.one(o.MEDIA_MUTE_TOGGLE).get("checked"),loop:e.one(o.MEDIA_LOOP_TOGGLE).get("checked")}}},{ATTRS:{langs:{},help:{}}})},"@VERSION@",{requires:["moodle-editor_atto-plugin","moodle-form-shortforms"]});
