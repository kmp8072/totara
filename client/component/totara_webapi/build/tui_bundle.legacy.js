!function(){var e={clPJ:function(e,n,t){var i={"./TestSession":"te7B","./TestSession.vue":"te7B"};function s(e){var n=o(e);return t(n)}function o(e){if(!t.o(i,e)){var n=new Error("Cannot find module '"+e+"'");throw n.code="MODULE_NOT_FOUND",n}return i[e]}s.keys=function(){return Object.keys(i)},s.resolve=o,e.exports=s,s.id="clPJ"},te7B:function(e,n,t){"use strict";t.r(n),t.d(n,{default:function(){return s}});var i=function(e,n,t,i,s,o,r,a){var u,d="function"==typeof e?e.options:e;if(n&&(d.render=n,d.staticRenderFns=[function(){var e=this.$createElement,n=this._self._c||e;return n("div",[n("hr")])}],d._compiled=!0),u)if(d.functional){d._injectStyles=u;var l=d.render;d.render=function(e,n){return u.call(n),l(e,n)}}else{var c=d.beforeCreate;d.beforeCreate=c?[].concat(c,u):[u]}return{exports:e,options:d}}({components:{},props:{},data:function(){return{sessionButtonText:"Send session query",nosessionButtonText:"Send nosession query",nosession:"",session:"",sessionError:"",nosessionError:""}},methods:{sendSessionQuery:function(){this.$apollo.queries.session.skip=!1,this.$apollo.queries.session.refetch()},sendNosessionQuery:function(){this.$apollo.queries.nosession.skip=!1,this.$apollo.queries.nosession.refetch()}},apollo:{nosession:{query:{kind:"Document",definitions:[{kind:"OperationDefinition",operation:"query",name:{kind:"Name",value:"totara_webapi_status_nosession"},variableDefinitions:[],directives:[],selectionSet:{kind:"SelectionSet",selections:[{kind:"Field",name:{kind:"Name",value:"totara_webapi_status"},arguments:[],directives:[],selectionSet:{kind:"SelectionSet",selections:[{kind:"Field",name:{kind:"Name",value:"status"},arguments:[],directives:[]},{kind:"Field",name:{kind:"Name",value:"timestamp"},arguments:[],directives:[]},{kind:"Field",alias:{kind:"Name",value:"date"},name:{kind:"Name",value:"timestamp"},arguments:[{kind:"Argument",name:{kind:"Name",value:"format"},value:{kind:"EnumValue",value:"DATELONG"}}],directives:[]}]}}]}}]},update:function(e){return e.totara_webapi_status},error:function(e){return this.nosessionError=e.graphQLErrors.length>0?e.graphQLErrors:e.networkError,!1},skip:!0,fetchPolicy:"no-cache"},session:{query:{kind:"Document",definitions:[{kind:"OperationDefinition",operation:"query",name:{kind:"Name",value:"totara_webapi_status"},variableDefinitions:[],directives:[],selectionSet:{kind:"SelectionSet",selections:[{kind:"Field",name:{kind:"Name",value:"totara_webapi_status"},arguments:[],directives:[],selectionSet:{kind:"SelectionSet",selections:[{kind:"Field",name:{kind:"Name",value:"status"},arguments:[],directives:[]},{kind:"Field",name:{kind:"Name",value:"timestamp"},arguments:[],directives:[]},{kind:"Field",alias:{kind:"Name",value:"date"},name:{kind:"Name",value:"timestamp"},arguments:[{kind:"Argument",name:{kind:"Name",value:"format"},value:{kind:"EnumValue",value:"DATELONG"}}],directives:[]}]}}]}}]},update:function(e){return e.totara_webapi_status},error:function(e){return this.sessionError=e.graphQLErrors.length>0?e.graphQLErrors:e.networkError,!1},skip:!0,fetchPolicy:"no-cache"}}},(function(){var e=this,n=e.$createElement,t=e._self._c||n;return t("div",[t("p",[e._v("\n    This is a test page to test queries using sessions and queries using\n    nosession.\n  ")]),e._v(" "),t("div",[t("button",{attrs:{type:"button"},on:{click:function(n){return e.sendSessionQuery()}}},[e._v("\n      "+e._s(e.sessionButtonText)+"\n    ")]),e._v(" "),e.session?t("h4",[e._v("Result:")]):e._e(),e._v(" "),e.session?t("div",[t("pre",[e._v(e._s(e.session))])]):e._e(),e._v(" "),e.sessionError?t("h4",[e._v("Error:")]):e._e(),e._v(" "),e.sessionError?t("div",[t("pre",[e._v(e._s(e.sessionError))])]):e._e()]),e._v(" "),e._m(0),e._v(" "),t("div",[t("button",{attrs:{type:"button"},on:{click:function(n){return e.sendNosessionQuery()}}},[e._v("\n      "+e._s(e.nosessionButtonText)+"\n    ")]),e._v(" "),e.nosession?t("h3",[e._v("Result:")]):e._e(),e._v(" "),e.nosession?t("div",[t("pre",[e._v(e._s(e.nosession))])]):e._e(),e._v(" "),e.nosessionError?t("h4",[e._v("Error:")]):e._e(),e._v(" "),e.nosessionError?t("div",[t("pre",[e._v(e._s(e.nosessionError))])]):e._e()])])}));i.options.__hasBlocks={script:!0,template:!0};var s=i.exports}},n={};function t(i){var s=n[i];if(void 0!==s)return s.exports;var o=n[i]={exports:{}};return e[i](o,o.exports,t),o.exports}t.d=function(e,n){for(var i in n)t.o(n,i)&&!t.o(e,i)&&Object.defineProperty(e,i,{enumerable:!0,get:n[i]})},t.o=function(e,n){return Object.prototype.hasOwnProperty.call(e,n)},t.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},function(){"use strict";"undefined"!=typeof tui&&tui._bundle.isLoaded("totara_webapi")?console.warn('[tui bundle] The bundle "totara_webapi" is already loaded, skipping initialisation.'):(tui._bundle.register("totara_webapi"),tui._bundle.addModulesFromContext("totara_webapi/pages",t("clPJ")))}()}();