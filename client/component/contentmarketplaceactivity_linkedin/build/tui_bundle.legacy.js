/*! For license information please see tui_bundle.legacy.js.LICENSE.txt */
!function(){var e={Z19h:function(e,t,n){var i={"./side-panel/LinkedInActivityContentsTree":"x2Hp","./side-panel/LinkedInActivityContentsTree.vue":"x2Hp"};function r(e){var t=a(e);return n(t)}function a(e){if(!n.o(i,e)){var t=new Error("Cannot find module '"+e+"'");throw t.code="MODULE_NOT_FOUND",t}return i[e]}r.keys=function(){return Object.keys(i)},r.resolve=a,e.exports=r,r.id="Z19h"},cQXS:function(e,t,n){var i={"./ActivityView":"iGIR","./ActivityView.vue":"iGIR"};function r(e){var t=a(e);return n(t)}function a(e){if(!n.o(i,e)){var t=new Error("Cannot find module '"+e+"'");throw t.code="MODULE_NOT_FOUND",t}return i[e]}r.keys=function(){return Object.keys(i)},r.resolve=a,e.exports=r,r.id="cQXS"},x2Hp:function(e,t,n){"use strict";n.r(t),n.d(t,{default:function(){return o}});var i=tui.require("tui/components/tree/Tree"),r={components:{Tree:n.n(i)()},props:{treeData:{type:Array,required:!0},value:{type:Array,required:!0}},data:function(){return{open:this.value}}},a=(0,n("wWJ2").Z)(r,(function(){var e=this,t=e.$createElement,n=e._self._c||t;return n("Tree",{staticClass:"tui-linkedinActivityContentTree",attrs:{"tree-data":e.treeData},on:{input:function(t){return e.$emit("input",t)}},scopedSlots:e._u([{key:"custom-label",fn:function(t){var n=t.label;return[e._v("\n    "+e._s(n)+"\n  ")]}},{key:"content",fn:function(t){var i=t.content;return[n("div",{staticClass:"tui-linkedinActivityContentTree__contents"},[e._l(i.items,(function(t,i){return[n("div",{key:i,staticClass:"tui-linkedinActivityContentTree__contents-item"},[e._v("\n          "+e._s(t)+"\n        ")])]}))],2)]}}]),model:{value:e.open,callback:function(t){e.open=t},expression:"open"}})}),[],!1,null,null,null);a.options.__hasBlocks={script:!0,template:!0};var o=a.exports},iGIR:function(e,t,n){"use strict";function i(e,t,n,i,r,a,o){try{var s=e[a](o),c=s.value}catch(e){return void n(e)}s.done?t(c):Promise.resolve(c).then(i,r)}function r(e){return function(){var t=this,n=arguments;return new Promise((function(r,a){var o=e.apply(t,n);function s(e){i(o,r,a,s,c,"next",e)}function c(e){i(o,r,a,s,c,"throw",e)}s(void 0)}))}}n.r(t),n.d(t,{default:function(){return A}});var a=n("KCiO"),o=n.n(a),s=tui.require("tui/components/card/ActionCard"),c=n.n(s),l=tui.require("tui/components/settings_navigation/SettingsNavigation"),u=n.n(l),d=tui.require("tui/components/buttons/Button"),m=n.n(d),v=tui.require("mod_contentmarketplace/components/layouts/LayoutBannerTwoColumn"),_=n.n(v),p=tui.require("tui/components/lozenge/Lozenge"),f=n.n(p),k=tui.require("tui/components/notifications/NotificationBanner"),y=n.n(k),h=tui.require("tui/components/layouts/PageBackLink"),g=n.n(h),b=tui.require("tui/components/progress/Progress"),N=n.n(b),w=tui.require("tui/components/toggle/ToggleSwitch"),x=n.n(w),S=tui.require("tui/notifications"),C=tui.require("mod_contentmarketplace/constants"),T={kind:"Document",definitions:[{kind:"OperationDefinition",operation:"mutation",name:{kind:"Name",value:"mod_contentmarketplace_set_self_completion"},variableDefinitions:[{kind:"VariableDefinition",variable:{kind:"Variable",name:{kind:"Name",value:"cm_id"}},type:{kind:"NonNullType",type:{kind:"NamedType",name:{kind:"Name",value:"core_id"}}},directives:[]},{kind:"VariableDefinition",variable:{kind:"Variable",name:{kind:"Name",value:"status"}},type:{kind:"NonNullType",type:{kind:"NamedType",name:{kind:"Name",value:"param_boolean"}}},directives:[]}],directives:[],selectionSet:{kind:"SelectionSet",selections:[{kind:"Field",alias:{kind:"Name",value:"result"},name:{kind:"Name",value:"mod_contentmarketplace_set_self_completion"},arguments:[{kind:"Argument",name:{kind:"Name",value:"cm_id"},value:{kind:"Variable",name:{kind:"Name",value:"cm_id"}}},{kind:"Argument",name:{kind:"Name",value:"status"},value:{kind:"Variable",name:{kind:"Name",value:"status"}}}],directives:[]}]}}]},E={kind:"Document",definitions:[{kind:"OperationDefinition",operation:"mutation",name:{kind:"Name",value:"mod_contentmarketplace_request_non_interactive_enrol"},variableDefinitions:[{kind:"VariableDefinition",variable:{kind:"Variable",name:{kind:"Name",value:"cm_id"}},type:{kind:"NonNullType",type:{kind:"NamedType",name:{kind:"Name",value:"core_id"}}},directives:[]}],directives:[],selectionSet:{kind:"SelectionSet",selections:[{kind:"Field",alias:{kind:"Name",value:"result"},name:{kind:"Name",value:"mod_contentmarketplace_request_non_interactive_enrol"},arguments:[{kind:"Argument",name:{kind:"Name",value:"cm_id"},value:{kind:"Variable",name:{kind:"Name",value:"cm_id"}}}],directives:[]}]}}]},O={components:{ActionCard:c(),AdminMenu:u(),Button:m(),Layout:_(),Lozenge:f(),NotificationBanner:y(),PageBackLink:g(),Progress:N(),ToggleSwitch:x()},props:{cmId:{type:Number,required:!0},hasNotification:{type:Boolean,required:!0}},data:function(){return{setCompletion:!1,interactor:{can_enrol:!1,can_launch:!1,has_view_capability:!1,is_enrolled:!1,is_site_guest:!1,non_interactive_enrol_instance_enabled:!1,supports_non_interactive_enrol:!1},module:{completionstatus:C.COMPLETION_STATUS_UNKNOWN,rpl:!1}}},computed:{isProgressBarEnabled:function(){return this.completionMarketplace&&!this.selfCompletionEnabled},canEnrol:function(){return this.interactor.can_enrol&&!this.interactor.is_site_guest&&this.interactor.non_interactive_enrol_instance_enabled},canLaunch:function(){return!this.interactor.can_enrol&&(this.interactor.can_launch||this.interactor.is_site_guest)},enrolBannerText:function(){return this.interactor.has_view_capability?this.interactor.non_interactive_enrol_instance_enabled?this.$str("viewing_as_enrollable_admin","mod_contentmarketplace"):this.$str("viewing_as_enrollable_admin_self_enrol_disabled","mod_contentmarketplace"):this.canEnrol?this.$str("viewing_as_enrollable_guest","mod_contentmarketplace"):this.$str("viewing_as_guest","mod_contentmarketplace")},isActivityCompleted:function(){return this.module.completionstatus!==C.COMPLETION_STATUS_UNKNOWN&&this.module.completionstatus!==C.COMPLETION_STATUS_INCOMPLETE},completionEnabled:function(){return this.module.completion!==C.COMPLETION_TRACKING_NONE},selfCompletionEnabled:function(){return this.module.completion===C.COMPLETION_TRACKING_MANUAL},completionMarketplace:function(){return this.activity.completion_condition===C.COMPLETION_CONDITION_CONTENT_MARKETPLACE},getProgress:function(){return 100!==this.module.progress&&this.isActivityCompleted?100:this.module.progress}},mounted:function(){this.hasNotification&&(0,S.notify)({message:this.$str("enrol_success_message","mod_contentmarketplace"),type:"success"})},apollo:{activity:{query:{kind:"Document",definitions:[{kind:"OperationDefinition",operation:"query",name:{kind:"Name",value:"contentmarketplaceactivity_linkedin_linkedin_activity"},variableDefinitions:[{kind:"VariableDefinition",variable:{kind:"Variable",name:{kind:"Name",value:"cm_id"}},type:{kind:"NonNullType",type:{kind:"NamedType",name:{kind:"Name",value:"core_id"}}},directives:[]}],directives:[],selectionSet:{kind:"SelectionSet",selections:[{kind:"Field",alias:{kind:"Name",value:"instance"},name:{kind:"Name",value:"contentmarketplaceactivity_linkedin_linkedin_activity"},arguments:[{kind:"Argument",name:{kind:"Name",value:"cm_id"},value:{kind:"Variable",name:{kind:"Name",value:"cm_id"}}}],directives:[],selectionSet:{kind:"SelectionSet",selections:[{kind:"Field",name:{kind:"Name",value:"module"},arguments:[],directives:[],selectionSet:{kind:"SelectionSet",selections:[{kind:"Field",name:{kind:"Name",value:"id"},arguments:[],directives:[]},{kind:"Field",name:{kind:"Name",value:"course_module"},arguments:[],directives:[],selectionSet:{kind:"SelectionSet",selections:[{kind:"Field",name:{kind:"Name",value:"id"},arguments:[],directives:[]},{kind:"Field",name:{kind:"Name",value:"completion"},arguments:[],directives:[]},{kind:"Field",name:{kind:"Name",value:"completionenabled"},arguments:[],directives:[]},{kind:"Field",name:{kind:"Name",value:"completionstatus"},arguments:[],directives:[]},{kind:"Field",name:{kind:"Name",value:"rpl"},arguments:[],directives:[]},{kind:"Field",name:{kind:"Name",value:"progress"},arguments:[],directives:[]}]}},{kind:"Field",name:{kind:"Name",value:"course"},arguments:[],directives:[],selectionSet:{kind:"SelectionSet",selections:[{kind:"Field",name:{kind:"Name",value:"id"},arguments:[],directives:[]},{kind:"Field",name:{kind:"Name",value:"fullname"},arguments:[],directives:[]},{kind:"Field",name:{kind:"Name",value:"image"},arguments:[],directives:[]},{kind:"Field",name:{kind:"Name",value:"url"},arguments:[],directives:[]},{kind:"Field",name:{kind:"Name",value:"course_format"},arguments:[],directives:[],selectionSet:{kind:"SelectionSet",selections:[{kind:"Field",name:{kind:"Name",value:"has_course_view_page"},arguments:[],directives:[]}]}}]}},{kind:"Field",name:{kind:"Name",value:"name"},arguments:[],directives:[]},{kind:"Field",name:{kind:"Name",value:"intro"},arguments:[{kind:"Argument",name:{kind:"Name",value:"format"},value:{kind:"EnumValue",value:"HTML"}}],directives:[]},{kind:"Field",name:{kind:"Name",value:"completion_condition"},arguments:[],directives:[]},{kind:"Field",name:{kind:"Name",value:"interactor"},arguments:[],directives:[],selectionSet:{kind:"SelectionSet",selections:[{kind:"Field",name:{kind:"Name",value:"has_view_capability"},arguments:[],directives:[]},{kind:"Field",name:{kind:"Name",value:"can_enrol"},arguments:[],directives:[]},{kind:"Field",name:{kind:"Name",value:"can_launch"},arguments:[],directives:[]},{kind:"Field",name:{kind:"Name",value:"is_site_guest"},arguments:[],directives:[]},{kind:"Field",name:{kind:"Name",value:"is_enrolled"},arguments:[],directives:[]},{kind:"Field",name:{kind:"Name",value:"non_interactive_enrol_instance_enabled"},arguments:[],directives:[]},{kind:"Field",name:{kind:"Name",value:"supports_non_interactive_enrol"},arguments:[],directives:[]}]}}]}},{kind:"Field",name:{kind:"Name",value:"learning_object"},arguments:[],directives:[],selectionSet:{kind:"SelectionSet",selections:[{kind:"Field",name:{kind:"Name",value:"id"},arguments:[],directives:[]},{kind:"Field",name:{kind:"Name",value:"asset_type"},arguments:[],directives:[]},{kind:"Field",name:{kind:"Name",value:"display_level"},arguments:[],directives:[]},{kind:"Field",name:{kind:"Name",value:"time_to_complete"},arguments:[],directives:[]},{kind:"Field",name:{kind:"Name",value:"last_updated_at"},arguments:[],directives:[]},{kind:"Field",name:{kind:"Name",value:"web_launch_url"},arguments:[],directives:[]},{kind:"Field",name:{kind:"Name",value:"sso_launch_url"},arguments:[],directives:[]}]}}]}}]}}]},variables:function(){return{cm_id:this.cmId}},update:function(e){var t=e.instance,n=t.module;return this.course=n.course,this.interactor=n.interactor,this.learningObject=t.learning_object,this.module=n.course_module,this.setCompletion=this.isActivityCompleted,n}}},methods:{launch:function(){var e=this;return r(o().mark((function t(){var n;return o().wrap((function(t){for(;;)switch(t.prev=t.next){case 0:n=e.learningObject.sso_launch_url?e.learningObject.sso_launch_url:e.learningObject.web_launch_url,window.open(n,"linkedIn_course_window");case 2:case"end":return t.stop()}}),t)})))()},setCompletionHandler:function(){var e=this;return r(o().mark((function t(){return o().wrap((function(t){for(;;)switch(t.prev=t.next){case 0:return t.next=2,e.$apollo.mutate({mutation:T,refetchAll:!1,variables:{cm_id:e.cmId,status:e.setCompletion}});case 2:e.$apollo.queries.activity.refetch();case 3:case"end":return t.stop()}}),t)})))()},enrol:function(){var e=this;return r(o().mark((function t(){return o().wrap((function(t){for(;;)switch(t.prev=t.next){case 0:if(!e.interactor.supports_non_interactive_enrol){t.next=5;break}return t.next=3,e.nonInteractiveEnrol();case 3:t.next=6;break;case 5:window.location.href=e.$url("/enrol/index.php",{id:e.course.id});case 6:case"end":return t.stop()}}),t)})))()},nonInteractiveEnrol:function(){var e=this;return r(o().mark((function t(){return o().wrap((function(t){for(;;)switch(t.prev=t.next){case 0:return t.next=2,e.$apollo.mutate({mutation:E,variables:{cm_id:e.cmId},refetchAll:!0});case 2:t.sent.data.result&&(0,S.notify)({message:e.$str("enrol_success_message","mod_contentmarketplace"),type:"success"});case 5:case"end":return t.stop()}}),t)})))()}}},L=function(e){e.options.__langStrings={mod_contentmarketplace:["a11y_activity_difficulty","a11y_activity_time_to_complete","activity_contents","activity_set_self_completion","activity_status_completed","activity_status_not_completed","course_details","enrol_to_course","enrol_success_message","internal_error","launch","toggle_off_error","toggle_on_error","updated_at","viewing_as_enrollable_admin","viewing_as_enrollable_admin_self_enrol_disabled","viewing_as_enrollable_guest","viewing_as_guest"],core_enrol:["enrol"]}},F=(0,n("wWJ2").Z)(O,(function(){var e=this,t=e.$createElement,n=e._self._c||t;return e.activity?n("Layout",{staticClass:"tui-linkedinActivity",attrs:{"banner-image-url":e.course.image,"loading-full-page":e.$apollo.loading,title:e.activity.name},scopedSlots:e._u([e.course.course_format.has_course_view_page?{key:"content-nav",fn:function(){return[n("PageBackLink",{attrs:{link:e.course.url,text:e.course.fullname}})]},proxy:!0}:null,{key:"banner-content",fn:function(e){var t=e.stacked;return[n("div",{staticClass:"tui-linkedinActivity__admin"},[n("AdminMenu",{attrs:{"stacked-layout":t}})],1)]}},e.interactor.is_enrolled?null:{key:"feedback-banner",fn:function(){return[n("NotificationBanner",{attrs:{type:"info"},scopedSlots:e._u([{key:"body",fn:function(){return[n("ActionCard",{attrs:{"no-border":!0},scopedSlots:e._u([{key:"card-body",fn:function(){return[e._v("\n            "+e._s(e.enrolBannerText)+"\n          ")]},proxy:!0},e.canEnrol?{key:"card-action",fn:function(){return[n("Button",{attrs:{styleclass:{primary:"true"},title:e.$str("enrol_to_course","mod_contentmarketplace",e.course.fullname),text:e.$str("enrol","core_enrol")},on:{click:e.enrol}})]},proxy:!0}:null],null,!0)})]},proxy:!0}],null,!1,4199808284)})]},proxy:!0},{key:"main-content",fn:function(){return[n("div",{staticClass:"tui-linkedinActivity__body"},[n("Button",{attrs:{disabled:!e.canLaunch,styleclass:{primary:"true"},text:e.$str("launch","mod_contentmarketplace")},on:{click:e.launch}}),e._v(" "),n("hr",{staticClass:"tui-linkedinActivity__divider"}),e._v(" "),e.completionEnabled&&e.interactor.is_enrolled?n("div",{staticClass:"tui-linkedinActivity__status",class:{"tui-linkedinActivity__progressContainer":e.isProgressBarEnabled}},[n("div",{staticClass:"tui-linkedinActivity__status-completion"},[n("Lozenge",{attrs:{text:e.isActivityCompleted?e.$str("activity_status_completed","mod_contentmarketplace"):e.$str("activity_status_not_completed","mod_contentmarketplace")}})],1),e._v(" "),e.isProgressBarEnabled?n("Progress",{staticClass:"tui-linkedinActivity__status-progress",attrs:{value:e.getProgress}}):e._e(),e._v(" "),e.selfCompletionEnabled&&!e.module.rpl?n("ToggleSwitch",{staticClass:"tui-linkedinActivity__status-toggle",attrs:{text:e.$str("activity_set_self_completion","mod_contentmarketplace"),"toggle-first":!0},on:{input:e.setCompletionHandler},model:{value:e.setCompletion,callback:function(t){e.setCompletion=t},expression:"setCompletion"}}):e._e()],1):e._e()],1),e._v(" "),n("div",{staticClass:"tui-linkedinActivity__details"},[n("h3",{staticClass:"tui-linkedinActivity__details-header"},[e._v("\n        "+e._s(e.$str("course_details","mod_contentmarketplace"))+"\n      ")]),e._v(" "),n("div",{staticClass:"tui-linkedinActivity__details-content"},[n("div",{staticClass:"tui-linkedinActivity__details-bar"},[n("div",[n("span",{staticClass:"sr-only"},[e._v("\n              "+e._s(e.$str("a11y_activity_time_to_complete","mod_contentmarketplace"))+"\n            ")]),e._v("\n            "+e._s(e.learningObject.time_to_complete)+"\n          ")]),e._v(" "),n("div",[n("span",{staticClass:"sr-only"},[e._v("\n              "+e._s(e.$str("a11y_activity_difficulty","mod_contentmarketplace"))+"\n            ")]),e._v("\n            "+e._s(e.learningObject.display_level)+"\n          ")]),e._v(" "),n("div",[e._v("\n            "+e._s(e.$str("updated_at","mod_contentmarketplace",e.learningObject.last_updated_at))+"\n          ")])]),e._v(" "),n("div",{staticClass:"tui-linkedinActivity__details-desc",domProps:{innerHTML:e._s(e.activity.intro)}})])])]},proxy:!0}],null,!0)}):e._e()}),[],!1,null,null,null);L(F),F.options.__hasBlocks={script:!0,template:!0};var A=F.exports},wWJ2:function(e,t,n){"use strict";function i(e,t,n,i,r,a,o,s){var c,l="function"==typeof e?e.options:e;if(t&&(l.render=t,l.staticRenderFns=n,l._compiled=!0),i&&(l.functional=!0),a&&(l._scopeId="data-v-"+a),o?(c=function(e){(e=e||this.$vnode&&this.$vnode.ssrContext||this.parent&&this.parent.$vnode&&this.parent.$vnode.ssrContext)||"undefined"==typeof __VUE_SSR_CONTEXT__||(e=__VUE_SSR_CONTEXT__),r&&r.call(this,e),e&&e._registeredComponents&&e._registeredComponents.add(o)},l._ssrRegister=c):r&&(c=s?function(){r.call(this,(l.functional?this.parent:this).$root.$options.shadowRoot)}:r),c)if(l.functional){l._injectStyles=c;var u=l.render;l.render=function(e,t){return c.call(t),u(e,t)}}else{var d=l.beforeCreate;l.beforeCreate=d?[].concat(d,c):[c]}return{exports:e,options:l}}n.d(t,{Z:function(){return i}})},gnxZ:function(e,t,n){var i=n("uy/F").default;function r(){"use strict";e.exports=r=function(){return t},e.exports.__esModule=!0,e.exports.default=e.exports;var t={},n=Object.prototype,a=n.hasOwnProperty,o="function"==typeof Symbol?Symbol:{},s=o.iterator||"@@iterator",c=o.asyncIterator||"@@asyncIterator",l=o.toStringTag||"@@toStringTag";function u(e,t,n){return Object.defineProperty(e,t,{value:n,enumerable:!0,configurable:!0,writable:!0}),e[t]}try{u({},"")}catch(e){u=function(e,t,n){return e[t]=n}}function d(e,t,n,i){var r=t&&t.prototype instanceof _?t:_,a=Object.create(r.prototype),o=new C(i||[]);return a._invoke=function(e,t,n){var i="suspendedStart";return function(r,a){if("executing"===i)throw new Error("Generator is already running");if("completed"===i){if("throw"===r)throw a;return{value:void 0,done:!0}}for(n.method=r,n.arg=a;;){var o=n.delegate;if(o){var s=w(o,n);if(s){if(s===v)continue;return s}}if("next"===n.method)n.sent=n._sent=n.arg;else if("throw"===n.method){if("suspendedStart"===i)throw i="completed",n.arg;n.dispatchException(n.arg)}else"return"===n.method&&n.abrupt("return",n.arg);i="executing";var c=m(e,t,n);if("normal"===c.type){if(i=n.done?"completed":"suspendedYield",c.arg===v)continue;return{value:c.arg,done:n.done}}"throw"===c.type&&(i="completed",n.method="throw",n.arg=c.arg)}}}(e,n,o),a}function m(e,t,n){try{return{type:"normal",arg:e.call(t,n)}}catch(e){return{type:"throw",arg:e}}}t.wrap=d;var v={};function _(){}function p(){}function f(){}var k={};u(k,s,(function(){return this}));var y=Object.getPrototypeOf,h=y&&y(y(T([])));h&&h!==n&&a.call(h,s)&&(k=h);var g=f.prototype=_.prototype=Object.create(k);function b(e){["next","throw","return"].forEach((function(t){u(e,t,(function(e){return this._invoke(t,e)}))}))}function N(e,t){function n(r,o,s,c){var l=m(e[r],e,o);if("throw"!==l.type){var u=l.arg,d=u.value;return d&&"object"==i(d)&&a.call(d,"__await")?t.resolve(d.__await).then((function(e){n("next",e,s,c)}),(function(e){n("throw",e,s,c)})):t.resolve(d).then((function(e){u.value=e,s(u)}),(function(e){return n("throw",e,s,c)}))}c(l.arg)}var r;this._invoke=function(e,i){function a(){return new t((function(t,r){n(e,i,t,r)}))}return r=r?r.then(a,a):a()}}function w(e,t){var n=e.iterator[t.method];if(void 0===n){if(t.delegate=null,"throw"===t.method){if(e.iterator.return&&(t.method="return",t.arg=void 0,w(e,t),"throw"===t.method))return v;t.method="throw",t.arg=new TypeError("The iterator does not provide a 'throw' method")}return v}var i=m(n,e.iterator,t.arg);if("throw"===i.type)return t.method="throw",t.arg=i.arg,t.delegate=null,v;var r=i.arg;return r?r.done?(t[e.resultName]=r.value,t.next=e.nextLoc,"return"!==t.method&&(t.method="next",t.arg=void 0),t.delegate=null,v):r:(t.method="throw",t.arg=new TypeError("iterator result is not an object"),t.delegate=null,v)}function x(e){var t={tryLoc:e[0]};1 in e&&(t.catchLoc=e[1]),2 in e&&(t.finallyLoc=e[2],t.afterLoc=e[3]),this.tryEntries.push(t)}function S(e){var t=e.completion||{};t.type="normal",delete t.arg,e.completion=t}function C(e){this.tryEntries=[{tryLoc:"root"}],e.forEach(x,this),this.reset(!0)}function T(e){if(e){var t=e[s];if(t)return t.call(e);if("function"==typeof e.next)return e;if(!isNaN(e.length)){var n=-1,i=function t(){for(;++n<e.length;)if(a.call(e,n))return t.value=e[n],t.done=!1,t;return t.value=void 0,t.done=!0,t};return i.next=i}}return{next:E}}function E(){return{value:void 0,done:!0}}return p.prototype=f,u(g,"constructor",f),u(f,"constructor",p),p.displayName=u(f,l,"GeneratorFunction"),t.isGeneratorFunction=function(e){var t="function"==typeof e&&e.constructor;return!!t&&(t===p||"GeneratorFunction"===(t.displayName||t.name))},t.mark=function(e){return Object.setPrototypeOf?Object.setPrototypeOf(e,f):(e.__proto__=f,u(e,l,"GeneratorFunction")),e.prototype=Object.create(g),e},t.awrap=function(e){return{__await:e}},b(N.prototype),u(N.prototype,c,(function(){return this})),t.AsyncIterator=N,t.async=function(e,n,i,r,a){void 0===a&&(a=Promise);var o=new N(d(e,n,i,r),a);return t.isGeneratorFunction(n)?o:o.next().then((function(e){return e.done?e.value:o.next()}))},b(g),u(g,l,"Generator"),u(g,s,(function(){return this})),u(g,"toString",(function(){return"[object Generator]"})),t.keys=function(e){var t=[];for(var n in e)t.push(n);return t.reverse(),function n(){for(;t.length;){var i=t.pop();if(i in e)return n.value=i,n.done=!1,n}return n.done=!0,n}},t.values=T,C.prototype={constructor:C,reset:function(e){if(this.prev=0,this.next=0,this.sent=this._sent=void 0,this.done=!1,this.delegate=null,this.method="next",this.arg=void 0,this.tryEntries.forEach(S),!e)for(var t in this)"t"===t.charAt(0)&&a.call(this,t)&&!isNaN(+t.slice(1))&&(this[t]=void 0)},stop:function(){this.done=!0;var e=this.tryEntries[0].completion;if("throw"===e.type)throw e.arg;return this.rval},dispatchException:function(e){if(this.done)throw e;var t=this;function n(n,i){return o.type="throw",o.arg=e,t.next=n,i&&(t.method="next",t.arg=void 0),!!i}for(var i=this.tryEntries.length-1;i>=0;--i){var r=this.tryEntries[i],o=r.completion;if("root"===r.tryLoc)return n("end");if(r.tryLoc<=this.prev){var s=a.call(r,"catchLoc"),c=a.call(r,"finallyLoc");if(s&&c){if(this.prev<r.catchLoc)return n(r.catchLoc,!0);if(this.prev<r.finallyLoc)return n(r.finallyLoc)}else if(s){if(this.prev<r.catchLoc)return n(r.catchLoc,!0)}else{if(!c)throw new Error("try statement without catch or finally");if(this.prev<r.finallyLoc)return n(r.finallyLoc)}}}},abrupt:function(e,t){for(var n=this.tryEntries.length-1;n>=0;--n){var i=this.tryEntries[n];if(i.tryLoc<=this.prev&&a.call(i,"finallyLoc")&&this.prev<i.finallyLoc){var r=i;break}}r&&("break"===e||"continue"===e)&&r.tryLoc<=t&&t<=r.finallyLoc&&(r=null);var o=r?r.completion:{};return o.type=e,o.arg=t,r?(this.method="next",this.next=r.finallyLoc,v):this.complete(o)},complete:function(e,t){if("throw"===e.type)throw e.arg;return"break"===e.type||"continue"===e.type?this.next=e.arg:"return"===e.type?(this.rval=this.arg=e.arg,this.method="return",this.next="end"):"normal"===e.type&&t&&(this.next=t),v},finish:function(e){for(var t=this.tryEntries.length-1;t>=0;--t){var n=this.tryEntries[t];if(n.finallyLoc===e)return this.complete(n.completion,n.afterLoc),S(n),v}},catch:function(e){for(var t=this.tryEntries.length-1;t>=0;--t){var n=this.tryEntries[t];if(n.tryLoc===e){var i=n.completion;if("throw"===i.type){var r=i.arg;S(n)}return r}}throw new Error("illegal catch attempt")},delegateYield:function(e,t,n){return this.delegate={iterator:T(e),resultName:t,nextLoc:n},"next"===this.method&&(this.arg=void 0),v}},t}e.exports=r,e.exports.__esModule=!0,e.exports.default=e.exports},"uy/F":function(e){function t(n){return e.exports=t="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(e){return typeof e}:function(e){return e&&"function"==typeof Symbol&&e.constructor===Symbol&&e!==Symbol.prototype?"symbol":typeof e},e.exports.__esModule=!0,e.exports.default=e.exports,t(n)}e.exports=t,e.exports.__esModule=!0,e.exports.default=e.exports},KCiO:function(e,t,n){var i=n("gnxZ")();e.exports=i;try{regeneratorRuntime=i}catch(e){"object"==typeof globalThis?globalThis.regeneratorRuntime=i:Function("r","regeneratorRuntime = r")(i)}}},t={};function n(i){var r=t[i];if(void 0!==r)return r.exports;var a=t[i]={exports:{}};return e[i](a,a.exports,n),a.exports}n.n=function(e){var t=e&&e.__esModule?function(){return e.default}:function(){return e};return n.d(t,{a:t}),t},n.d=function(e,t){for(var i in t)n.o(t,i)&&!n.o(e,i)&&Object.defineProperty(e,i,{enumerable:!0,get:t[i]})},n.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},n.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},function(){"use strict";"undefined"!=typeof tui&&tui._bundle.isLoaded("contentmarketplaceactivity_linkedin")?console.warn('[tui bundle] The bundle "contentmarketplaceactivity_linkedin" is already loaded, skipping initialisation.'):(tui._bundle.register("contentmarketplaceactivity_linkedin"),tui._bundle.addModulesFromContext("contentmarketplaceactivity_linkedin/components",n("Z19h")),tui._bundle.addModulesFromContext("contentmarketplaceactivity_linkedin/pages",n("cQXS")))}()}();