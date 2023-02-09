!function(){var t={"blt/":function(t,e,o){var n={"./notification/AttendanceStatus":"dOAU","./notification/AttendanceStatus.vue":"dOAU","./notification/BookingStatus":"7s9I","./notification/BookingStatus.vue":"7s9I","./notification/IcalAttachment":"SFRD","./notification/IcalAttachment.vue":"SFRD"};function a(t){var e=r(t);return o(e)}function r(t){if(!o.o(n,t)){var e=new Error("Cannot find module '"+t+"'");throw e.code="MODULE_NOT_FOUND",e}return n[t]}a.keys=function(){return Object.keys(n)},a.resolve=r,t.exports=a,a.id="blt/"},dOAU:function(t,e,o){"use strict";o.r(e),o.d(e,{default:function(){return c}});var n=o("p202"),a=o("hAGe"),r=o.n(a),s={components:{FormRow:n.FormRow,FormCheckboxGroup:n.FormCheckboxGroup,Checkbox:r()},props:{disabled:Boolean,required:Boolean}},i=function(t){t.options.__langStrings={mod_facetoface:["attendancestatus","status_fully_attended","status_partially_attended","status_unable_to_attend","status_no_show","status_not_set"]}},u=(0,o("wWJ2").Z)(s,(function(){var t=this,e=t.$createElement,o=t._self._c||e;return o("FormRow",{attrs:{label:t.$str("attendancestatus","mod_facetoface"),"is-stacked":!1,required:t.required}},[o("FormCheckboxGroup",{attrs:{name:"attendanceStatus",validations:function(t){return[t.required()]},disabled:t.disabled,required:t.required}},[o("Checkbox",{attrs:{value:"status_fully_attended"}},[t._v("\n      "+t._s(t.$str("status_fully_attended","mod_facetoface"))+"\n    ")]),t._v(" "),o("Checkbox",{attrs:{value:"status_partially_attended"}},[t._v("\n      "+t._s(t.$str("status_partially_attended","mod_facetoface"))+"\n    ")]),t._v(" "),o("Checkbox",{attrs:{value:"status_unable_to_attend"}},[t._v("\n      "+t._s(t.$str("status_unable_to_attend","mod_facetoface"))+"\n    ")]),t._v(" "),o("Checkbox",{attrs:{value:"status_no_show"}},[t._v("\n      "+t._s(t.$str("status_no_show","mod_facetoface"))+"\n    ")]),t._v(" "),o("Checkbox",{attrs:{value:"status_not_set"}},[t._v("\n      "+t._s(t.$str("status_not_set","mod_facetoface"))+"\n    ")])],1),t._v(" "),t._t("override-toggle")],2)}),[],!1,null,null,null);i(u),u.options.__hasBlocks={script:!0,template:!0};var c=u.exports},"7s9I":function(t,e,o){"use strict";o.r(e),o.d(e,{default:function(){return u}});var n=o("p202"),a=o("hAGe"),r={components:{Checkbox:o.n(a)(),FormCheckboxGroup:n.FormCheckboxGroup,FormRow:n.FormRow},props:{disabled:Boolean}},s=function(t){t.options.__langStrings={mod_facetoface:["notification_subject_status","status_booked","status_pending_requests","status_user_cancelled","status_waitlisted"]}},i=(0,o("wWJ2").Z)(r,(function(){var t=this,e=t.$createElement,o=t._self._c||e;return o("FormRow",{attrs:{label:t.$str("notification_subject_status","mod_facetoface"),"is-stacked":!1,required:t.required}},[o("FormCheckboxGroup",{attrs:{name:"recipients",validations:function(t){return[t.required()]},disabled:t.disabled,required:t.required}},[o("Checkbox",{attrs:{value:"status_waitlisted"}},[t._v("\n      "+t._s(t.$str("status_waitlisted","mod_facetoface"))+"\n    ")]),t._v(" "),o("Checkbox",{attrs:{value:"status_user_cancelled"}},[t._v("\n      "+t._s(t.$str("status_user_cancelled","mod_facetoface"))+"\n    ")]),t._v(" "),o("Checkbox",{attrs:{value:"status_pending_requests"}},[t._v("\n      "+t._s(t.$str("status_pending_requests","mod_facetoface"))+"\n    ")]),t._v(" "),o("Checkbox",{attrs:{value:"status_booked"}},[t._v("\n      "+t._s(t.$str("status_booked","mod_facetoface"))+"\n    ")])],1),t._v(" "),t._t("override-toggle")],2)}),[],!1,null,null,null);s(i),i.options.__hasBlocks={script:!0,template:!0};var u=i.exports},SFRD:function(t,e,o){"use strict";o.r(e),o.d(e,{default:function(){return c}});var n=o("p202"),a=o("hAGe"),r=o.n(a),s={components:{FormRow:n.FormRow,FormCheckboxGroup:n.FormCheckboxGroup,FormCheckbox:r()},props:{disabled:Boolean}},i=function(t){t.options.__langStrings={totara_notification:["notification_include_ical_attachment_label"],totara_core:["enabled"]}},u=(0,o("wWJ2").Z)(s,(function(){var t=this,e=t.$createElement,o=t._self._c||e;return o("FormRow",{attrs:{label:t.$str("notification_include_ical_attachment_label","totara_notification"),"is-stacked":!1}},[o("FormCheckboxGroup",{attrs:{name:"ical",disabled:t.disabled}},[o("FormCheckbox",{attrs:{value:"include_ical_attachment"}},[t._v("\n      "+t._s(t.$str("enabled","totara_core"))+"\n    ")])],1),t._v(" "),t._t("override-toggle")],2)}),[],!1,null,null,null);i(u),u.options.__hasBlocks={script:!0,template:!0};var c=u.exports},wWJ2:function(t,e,o){"use strict";function n(t,e,o,n,a,r,s,i){var u,c="function"==typeof t?t.options:t;if(e&&(c.render=e,c.staticRenderFns=o,c._compiled=!0),n&&(c.functional=!0),r&&(c._scopeId="data-v-"+r),s?(u=function(t){(t=t||this.$vnode&&this.$vnode.ssrContext||this.parent&&this.parent.$vnode&&this.parent.$vnode.ssrContext)||"undefined"==typeof __VUE_SSR_CONTEXT__||(t=__VUE_SSR_CONTEXT__),a&&a.call(this,t),t&&t._registeredComponents&&t._registeredComponents.add(s)},c._ssrRegister=u):a&&(u=i?function(){a.call(this,(c.functional?this.parent:this).$root.$options.shadowRoot)}:a),u)if(c.functional){c._injectStyles=u;var _=c.render;c.render=function(t,e){return u.call(e),_(t,e)}}else{var d=c.beforeCreate;c.beforeCreate=d?[].concat(d,u):[u]}return{exports:t,options:c}}o.d(e,{Z:function(){return n}})},hAGe:function(t){"use strict";t.exports=tui.require("tui/components/form/Checkbox")},p202:function(t){"use strict";t.exports=tui.require("tui/components/uniform")}},e={};function o(n){var a=e[n];if(void 0!==a)return a.exports;var r=e[n]={exports:{}};return t[n](r,r.exports,o),r.exports}o.n=function(t){var e=t&&t.__esModule?function(){return t.default}:function(){return t};return o.d(e,{a:e}),e},o.d=function(t,e){for(var n in e)o.o(e,n)&&!o.o(t,n)&&Object.defineProperty(t,n,{enumerable:!0,get:e[n]})},o.o=function(t,e){return Object.prototype.hasOwnProperty.call(t,e)},o.r=function(t){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(t,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(t,"__esModule",{value:!0})},function(){"use strict";"undefined"!=typeof tui&&tui._bundle.isLoaded("mod_facetoface")?console.warn('[tui bundle] The bundle "mod_facetoface" is already loaded, skipping initialisation.'):(tui._bundle.register("mod_facetoface"),tui._bundle.addModulesFromContext("mod_facetoface/components",o("blt/")))}()}();