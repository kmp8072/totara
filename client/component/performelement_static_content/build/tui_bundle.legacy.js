/*! For license information please see tui_bundle.legacy.js.LICENSE.txt */
!function(){var t={k8kS:function(t,e,n){var r={"./StaticContentAdminEdit":"FbEc","./StaticContentAdminEdit.vue":"FbEc","./StaticContentAdminSummary":"jkuI","./StaticContentAdminSummary.vue":"jkuI","./StaticContentAdminView":"hF5o","./StaticContentAdminView.vue":"hF5o","./StaticContentParticipantForm":"sJ2w","./StaticContentParticipantForm.vue":"sJ2w"};function i(t){var e=o(t);return n(e)}function o(t){if(!n.o(r,t)){var e=new Error("Cannot find module '"+t+"'");throw e.code="MODULE_NOT_FOUND",e}return r[t]}i.keys=function(){return Object.keys(r)},i.resolve=o,t.exports=i,i.id="k8kS"},FbEc:function(t,e,n){"use strict";function r(t,e,n,r,i,o,a){try{var u=t[o](a),c=u.value}catch(t){return void n(t)}u.done?e(c):Promise.resolve(c).then(r,i)}function i(t){return function(){var e=this,n=arguments;return new Promise((function(i,o){var a=t.apply(e,n);function u(t){r(a,i,o,u,c,"next",t)}function c(t){r(a,i,o,u,c,"throw",t)}u(void 0)}))}}n.r(e),n.d(e,{default:function(){return g}});var o=n("KCiO"),a=n.n(o),u=tui.require("mod_perform/components/element/PerformAdminCustomElementEdit"),c=n.n(u),s=tui.require("editor_weka/components/Weka"),l=n.n(s),d=tui.require("editor_weka/WekaValue"),f=n.n(d),m=tui.require("tui/components/uniform"),p={kind:"Document",definitions:[{kind:"OperationDefinition",operation:"mutation",name:{kind:"Name",value:"core_file_unused_draft_item_id"},variableDefinitions:[],directives:[],selectionSet:{kind:"SelectionSet",selections:[{kind:"Field",alias:{kind:"Name",value:"item_id"},name:{kind:"Name",value:"core_file_unused_draft_item_id"},arguments:[],directives:[]}]}}]},h={kind:"Document",definitions:[{kind:"OperationDefinition",operation:"mutation",name:{kind:"Name",value:"performelement_static_content_prepare_draft_area"},variableDefinitions:[{kind:"VariableDefinition",variable:{kind:"Variable",name:{kind:"Name",value:"section_id"}},type:{kind:"NonNullType",type:{kind:"NamedType",name:{kind:"Name",value:"core_id"}}},directives:[]},{kind:"VariableDefinition",variable:{kind:"Variable",name:{kind:"Name",value:"element_id"}},type:{kind:"NonNullType",type:{kind:"NamedType",name:{kind:"Name",value:"core_id"}}},directives:[]}],directives:[],selectionSet:{kind:"SelectionSet",selections:[{kind:"Field",alias:{kind:"Name",value:"draft_id"},name:{kind:"Name",value:"performelement_static_content_prepare_draft_area"},arguments:[{kind:"Argument",name:{kind:"Name",value:"section_id"},value:{kind:"Variable",name:{kind:"Name",value:"section_id"}}},{kind:"Argument",name:{kind:"Name",value:"element_id"},value:{kind:"Variable",name:{kind:"Name",value:"element_id"}}}],directives:[]}]}}]},v={components:{FormField:m.FormField,FormRow:m.FormRow,PerformAdminCustomElementEdit:c(),Weka:l()},inheritAttrs:!1,props:{data:Object,elementId:[Number,String],identifier:String,rawData:Object,rawTitle:String,sectionId:[Number,String],settings:Object,activityContextId:[Number,String]},data:function(){return{initialValues:{data:this.data,draftId:null,identifier:this.identifier,rawTitle:this.rawTitle,wekaDoc:f().empty()},ready:!1}},computed:{actualElementId:function(){return this.elementId&&!isNaN(this.elementId)?this.elementId:null}},mounted:function(){var t=this;return i(a().mark((function e(){return a().wrap((function(e){for(;;)switch(e.prev=e.next){case 0:if(t.rawData&&t.rawData.wekaDoc&&(t.initialValues.wekaDoc=f().fromDoc(JSON.parse(t.rawData.wekaDoc))),!t.sectionId||!t.actualElementId){e.next=6;break}return e.next=4,t.$_loadExistingDraftId();case 4:e.next=8;break;case 6:return e.next=8,t.$_loadNewDraftId();case 8:t.ready=!0;case 9:case"end":return e.stop()}}),e)})))()},methods:{$_loadNewDraftId:function(){var t=this;return i(a().mark((function e(){var n,r;return a().wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return e.next=2,t.$apollo.mutate({mutation:p});case 2:n=e.sent,r=n.data.item_id,t.initialValues.draftId=r;case 5:case"end":return e.stop()}}),e)})))()},$_loadExistingDraftId:function(){var t=this;return i(a().mark((function e(){var n,r;return a().wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return e.next=2,t.$apollo.mutate({mutation:h,variables:{section_id:parseInt(t.sectionId),element_id:parseInt(t.elementId)}});case 2:n=e.sent,r=n.data.draft_id,t.initialValues.draftId=r;case 5:case"end":return e.stop()}}),e)})))()},processData:function(t){return{data:{docFormat:"FORMAT_JSON_EDITOR",draftId:t.data.draftId,format:"HTML",wekaDoc:JSON.stringify(t.data.wekaDoc.getDoc())},title:t.title}},validateEditor:function(t){if(!t||t.isEmpty)return this.$str("required","performelement_static_content")}}},_=function(t){t.options.__langStrings={performelement_static_content:["required","static_content_placeholder","weka_enter_content"]}},y=(0,n("wWJ2").Z)(v,(function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("div",{staticClass:"tui-staticContentAdminEdit"},[t.ready?n("PerformAdminCustomElementEdit",{attrs:{"initial-values":t.initialValues,settings:t.settings},on:{cancel:function(e){return t.$emit("display")},update:function(e){t.$emit("update",t.processData(e))}}},[n("FormRow",{attrs:{label:t.$str("static_content_placeholder","performelement_static_content"),required:!0},scopedSlots:t._u([{key:"default",fn:function(e){var r=e.id;return[n("FormField",{attrs:{name:"wekaDoc",validate:t.validateEditor},scopedSlots:t._u([{key:"default",fn:function(e){var i=e.value,o=e.update;return[n("Weka",{attrs:{id:r,"context-id":t.activityContextId,value:i,"usage-identifier":{component:"performelement_static_content",area:"content",instanceId:t.actualElementId},variant:"full","file-item-id":t.initialValues.draftId,placeholder:t.$str("weka_enter_content","performelement_static_content")},on:{input:o}})]}}],null,!0)})]}}],null,!1,2190760222)})],1):t._e()],1)}),[],!1,null,null,null);_(y),y.options.__hasBlocks={script:!0,template:!0};var g=y.exports},jkuI:function(t,e,n){"use strict";n.r(e),n.d(e,{default:function(){return a}});var r=tui.require("mod_perform/components/element/PerformAdminCustomElementSummary"),i={components:{PerformAdminCustomElementSummary:n.n(r)()},inheritAttrs:!1,props:{data:Object,identifier:String,isRequired:Boolean,settings:Object,title:String}},o=(0,n("wWJ2").Z)(i,(function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("div",{staticClass:"tui-staticContentAdminSummary"},[n("PerformAdminCustomElementSummary",{attrs:{"html-content":t.data.content,identifier:t.identifier,"is-required":t.isRequired,settings:t.settings,title:t.title},on:{display:function(e){return t.$emit("display")}}})],1)}),[],!1,null,null,null);o.options.__hasBlocks={script:!0,template:!0};var a=o.exports},hF5o:function(t,e,n){"use strict";n.r(e),n.d(e,{default:function(){return u}});var r=n("7mX8"),i=n.n(r),o={inheritAttrs:!1,props:{data:Object},mounted:function(){this.$_scan()},updated:function(){this.$_scan()},methods:{$_scan:function(){var t=this;this.$nextTick().then((function(){var e=t.$refs.content;e&&i().scan(e)}))}}},a=(0,n("wWJ2").Z)(o,(function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("div",{staticClass:"tui-staticContentAdminView"},[n("div",{ref:"content",domProps:{innerHTML:t._s(t.data.content)}})])}),[],!1,null,null,null);a.options.__hasBlocks={script:!0,template:!0};var u=a.exports},sJ2w:function(t,e,n){"use strict";n.r(e),n.d(e,{default:function(){return u}});var r=n("7mX8"),i=n.n(r),o={props:{element:Object},mounted:function(){this.$_scan()},updated:function(){this.$_scan()},methods:{$_scan:function(){var t=this;this.$nextTick().then((function(){var e=t.$refs.content;e&&i().scan(e)}))}}},a=(0,n("wWJ2").Z)(o,(function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("div",{staticClass:"tui-staticContentElementParticipantForm"},[n("div",{ref:"content",domProps:{innerHTML:t._s(t.element.data.content)}})])}),[],!1,null,null,null);a.options.__hasBlocks={script:!0,template:!0};var u=a.exports},wWJ2:function(t,e,n){"use strict";function r(t,e,n,r,i,o,a,u){var c,s="function"==typeof t?t.options:t;if(e&&(s.render=e,s.staticRenderFns=n,s._compiled=!0),r&&(s.functional=!0),o&&(s._scopeId="data-v-"+o),a?(c=function(t){(t=t||this.$vnode&&this.$vnode.ssrContext||this.parent&&this.parent.$vnode&&this.parent.$vnode.ssrContext)||"undefined"==typeof __VUE_SSR_CONTEXT__||(t=__VUE_SSR_CONTEXT__),i&&i.call(this,t),t&&t._registeredComponents&&t._registeredComponents.add(a)},s._ssrRegister=c):i&&(c=u?function(){i.call(this,(s.functional?this.parent:this).$root.$options.shadowRoot)}:i),c)if(s.functional){s._injectStyles=c;var l=s.render;s.render=function(t,e){return c.call(e),l(t,e)}}else{var d=s.beforeCreate;s.beforeCreate=d?[].concat(d,c):[c]}return{exports:t,options:s}}n.d(e,{Z:function(){return r}})},"7mX8":function(t){"use strict";t.exports=tui.require("tui/tui")},gnxZ:function(t,e,n){var r=n("uy/F").default;function i(){"use strict";t.exports=i=function(){return e},t.exports.__esModule=!0,t.exports.default=t.exports;var e={},n=Object.prototype,o=n.hasOwnProperty,a="function"==typeof Symbol?Symbol:{},u=a.iterator||"@@iterator",c=a.asyncIterator||"@@asyncIterator",s=a.toStringTag||"@@toStringTag";function l(t,e,n){return Object.defineProperty(t,e,{value:n,enumerable:!0,configurable:!0,writable:!0}),t[e]}try{l({},"")}catch(t){l=function(t,e,n){return t[e]=n}}function d(t,e,n,r){var i=e&&e.prototype instanceof p?e:p,o=Object.create(i.prototype),a=new N(r||[]);return o._invoke=function(t,e,n){var r="suspendedStart";return function(i,o){if("executing"===r)throw new Error("Generator is already running");if("completed"===r){if("throw"===i)throw o;return{value:void 0,done:!0}}for(n.method=i,n.arg=o;;){var a=n.delegate;if(a){var u=b(a,n);if(u){if(u===m)continue;return u}}if("next"===n.method)n.sent=n._sent=n.arg;else if("throw"===n.method){if("suspendedStart"===r)throw r="completed",n.arg;n.dispatchException(n.arg)}else"return"===n.method&&n.abrupt("return",n.arg);r="executing";var c=f(t,e,n);if("normal"===c.type){if(r=n.done?"completed":"suspendedYield",c.arg===m)continue;return{value:c.arg,done:n.done}}"throw"===c.type&&(r="completed",n.method="throw",n.arg=c.arg)}}}(t,n,a),o}function f(t,e,n){try{return{type:"normal",arg:t.call(e,n)}}catch(t){return{type:"throw",arg:t}}}e.wrap=d;var m={};function p(){}function h(){}function v(){}var _={};l(_,u,(function(){return this}));var y=Object.getPrototypeOf,g=y&&y(y(O([])));g&&g!==n&&o.call(g,u)&&(_=g);var w=v.prototype=p.prototype=Object.create(_);function k(t){["next","throw","return"].forEach((function(e){l(t,e,(function(t){return this._invoke(e,t)}))}))}function x(t,e){function n(i,a,u,c){var s=f(t[i],t,a);if("throw"!==s.type){var l=s.arg,d=l.value;return d&&"object"==r(d)&&o.call(d,"__await")?e.resolve(d.__await).then((function(t){n("next",t,u,c)}),(function(t){n("throw",t,u,c)})):e.resolve(d).then((function(t){l.value=t,u(l)}),(function(t){return n("throw",t,u,c)}))}c(s.arg)}var i;this._invoke=function(t,r){function o(){return new e((function(e,i){n(t,r,e,i)}))}return i=i?i.then(o,o):o()}}function b(t,e){var n=t.iterator[e.method];if(void 0===n){if(e.delegate=null,"throw"===e.method){if(t.iterator.return&&(e.method="return",e.arg=void 0,b(t,e),"throw"===e.method))return m;e.method="throw",e.arg=new TypeError("The iterator does not provide a 'throw' method")}return m}var r=f(n,t.iterator,e.arg);if("throw"===r.type)return e.method="throw",e.arg=r.arg,e.delegate=null,m;var i=r.arg;return i?i.done?(e[t.resultName]=i.value,e.next=t.nextLoc,"return"!==e.method&&(e.method="next",e.arg=void 0),e.delegate=null,m):i:(e.method="throw",e.arg=new TypeError("iterator result is not an object"),e.delegate=null,m)}function S(t){var e={tryLoc:t[0]};1 in t&&(e.catchLoc=t[1]),2 in t&&(e.finallyLoc=t[2],e.afterLoc=t[3]),this.tryEntries.push(e)}function E(t){var e=t.completion||{};e.type="normal",delete e.arg,t.completion=e}function N(t){this.tryEntries=[{tryLoc:"root"}],t.forEach(S,this),this.reset(!0)}function O(t){if(t){var e=t[u];if(e)return e.call(t);if("function"==typeof t.next)return t;if(!isNaN(t.length)){var n=-1,r=function e(){for(;++n<t.length;)if(o.call(t,n))return e.value=t[n],e.done=!1,e;return e.value=void 0,e.done=!0,e};return r.next=r}}return{next:C}}function C(){return{value:void 0,done:!0}}return h.prototype=v,l(w,"constructor",v),l(v,"constructor",h),h.displayName=l(v,s,"GeneratorFunction"),e.isGeneratorFunction=function(t){var e="function"==typeof t&&t.constructor;return!!e&&(e===h||"GeneratorFunction"===(e.displayName||e.name))},e.mark=function(t){return Object.setPrototypeOf?Object.setPrototypeOf(t,v):(t.__proto__=v,l(t,s,"GeneratorFunction")),t.prototype=Object.create(w),t},e.awrap=function(t){return{__await:t}},k(x.prototype),l(x.prototype,c,(function(){return this})),e.AsyncIterator=x,e.async=function(t,n,r,i,o){void 0===o&&(o=Promise);var a=new x(d(t,n,r,i),o);return e.isGeneratorFunction(n)?a:a.next().then((function(t){return t.done?t.value:a.next()}))},k(w),l(w,s,"Generator"),l(w,u,(function(){return this})),l(w,"toString",(function(){return"[object Generator]"})),e.keys=function(t){var e=[];for(var n in t)e.push(n);return e.reverse(),function n(){for(;e.length;){var r=e.pop();if(r in t)return n.value=r,n.done=!1,n}return n.done=!0,n}},e.values=O,N.prototype={constructor:N,reset:function(t){if(this.prev=0,this.next=0,this.sent=this._sent=void 0,this.done=!1,this.delegate=null,this.method="next",this.arg=void 0,this.tryEntries.forEach(E),!t)for(var e in this)"t"===e.charAt(0)&&o.call(this,e)&&!isNaN(+e.slice(1))&&(this[e]=void 0)},stop:function(){this.done=!0;var t=this.tryEntries[0].completion;if("throw"===t.type)throw t.arg;return this.rval},dispatchException:function(t){if(this.done)throw t;var e=this;function n(n,r){return a.type="throw",a.arg=t,e.next=n,r&&(e.method="next",e.arg=void 0),!!r}for(var r=this.tryEntries.length-1;r>=0;--r){var i=this.tryEntries[r],a=i.completion;if("root"===i.tryLoc)return n("end");if(i.tryLoc<=this.prev){var u=o.call(i,"catchLoc"),c=o.call(i,"finallyLoc");if(u&&c){if(this.prev<i.catchLoc)return n(i.catchLoc,!0);if(this.prev<i.finallyLoc)return n(i.finallyLoc)}else if(u){if(this.prev<i.catchLoc)return n(i.catchLoc,!0)}else{if(!c)throw new Error("try statement without catch or finally");if(this.prev<i.finallyLoc)return n(i.finallyLoc)}}}},abrupt:function(t,e){for(var n=this.tryEntries.length-1;n>=0;--n){var r=this.tryEntries[n];if(r.tryLoc<=this.prev&&o.call(r,"finallyLoc")&&this.prev<r.finallyLoc){var i=r;break}}i&&("break"===t||"continue"===t)&&i.tryLoc<=e&&e<=i.finallyLoc&&(i=null);var a=i?i.completion:{};return a.type=t,a.arg=e,i?(this.method="next",this.next=i.finallyLoc,m):this.complete(a)},complete:function(t,e){if("throw"===t.type)throw t.arg;return"break"===t.type||"continue"===t.type?this.next=t.arg:"return"===t.type?(this.rval=this.arg=t.arg,this.method="return",this.next="end"):"normal"===t.type&&e&&(this.next=e),m},finish:function(t){for(var e=this.tryEntries.length-1;e>=0;--e){var n=this.tryEntries[e];if(n.finallyLoc===t)return this.complete(n.completion,n.afterLoc),E(n),m}},catch:function(t){for(var e=this.tryEntries.length-1;e>=0;--e){var n=this.tryEntries[e];if(n.tryLoc===t){var r=n.completion;if("throw"===r.type){var i=r.arg;E(n)}return i}}throw new Error("illegal catch attempt")},delegateYield:function(t,e,n){return this.delegate={iterator:O(t),resultName:e,nextLoc:n},"next"===this.method&&(this.arg=void 0),m}},e}t.exports=i,t.exports.__esModule=!0,t.exports.default=t.exports},"uy/F":function(t){function e(n){return t.exports=e="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(t){return typeof t}:function(t){return t&&"function"==typeof Symbol&&t.constructor===Symbol&&t!==Symbol.prototype?"symbol":typeof t},t.exports.__esModule=!0,t.exports.default=t.exports,e(n)}t.exports=e,t.exports.__esModule=!0,t.exports.default=t.exports},KCiO:function(t,e,n){var r=n("gnxZ")();t.exports=r;try{regeneratorRuntime=r}catch(t){"object"==typeof globalThis?globalThis.regeneratorRuntime=r:Function("r","regeneratorRuntime = r")(r)}}},e={};function n(r){var i=e[r];if(void 0!==i)return i.exports;var o=e[r]={exports:{}};return t[r](o,o.exports,n),o.exports}n.n=function(t){var e=t&&t.__esModule?function(){return t.default}:function(){return t};return n.d(e,{a:e}),e},n.d=function(t,e){for(var r in e)n.o(e,r)&&!n.o(t,r)&&Object.defineProperty(t,r,{enumerable:!0,get:e[r]})},n.o=function(t,e){return Object.prototype.hasOwnProperty.call(t,e)},n.r=function(t){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(t,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(t,"__esModule",{value:!0})},function(){"use strict";"undefined"!=typeof tui&&tui._bundle.isLoaded("performelement_static_content")?console.warn('[tui bundle] The bundle "performelement_static_content" is already loaded, skipping initialisation.'):(tui._bundle.register("performelement_static_content"),tui._bundle.addModulesFromContext("performelement_static_content/components",n("k8kS")))}()}();