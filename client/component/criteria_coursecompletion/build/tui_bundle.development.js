/*
 * ATTENTION: The "eval" devtool has been used (maybe by default in mode: "development").
 * This devtool is neither made for production nor for readable output files.
 * It uses "eval()" calls to create a separate source file in the browser devtools.
 * If you are trying to read the output file, select a different devtool (https://webpack.js.org/configuration/devtool/)
 * or disable the default devtool with "devtool: false".
 * If you are looking for production-ready output files, see mode: "production" (https://webpack.js.org/configuration/mode/).
 */
/******/ (() => { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./client/component/criteria_coursecompletion/src/components sync recursive ^(?:(?%21__[a-z]*__%7C[/\\\\]internal[/\\\\]).)*$":
/*!***********************************************************************************************************************!*\
  !*** ./client/component/criteria_coursecompletion/src/components/ sync ^(?:(?%21__[a-z]*__%7C[/\\]internal[/\\]).)*$ ***!
  \***********************************************************************************************************************/
/***/ ((module, __unused_webpack_exports, __webpack_require__) => {

eval("var map = {\n\t\"./achievements/AchievementDisplay\": \"./client/component/criteria_coursecompletion/src/components/achievements/AchievementDisplay.vue\",\n\t\"./achievements/AchievementDisplay.vue\": \"./client/component/criteria_coursecompletion/src/components/achievements/AchievementDisplay.vue\"\n};\n\n\nfunction webpackContext(req) {\n\tvar id = webpackContextResolve(req);\n\treturn __webpack_require__(id);\n}\nfunction webpackContextResolve(req) {\n\tif(!__webpack_require__.o(map, req)) {\n\t\tvar e = new Error(\"Cannot find module '\" + req + \"'\");\n\t\te.code = 'MODULE_NOT_FOUND';\n\t\tthrow e;\n\t}\n\treturn map[req];\n}\nwebpackContext.keys = function webpackContextKeys() {\n\treturn Object.keys(map);\n};\nwebpackContext.resolve = webpackContextResolve;\nmodule.exports = webpackContext;\nwebpackContext.id = \"./client/component/criteria_coursecompletion/src/components sync recursive ^(?:(?%21__[a-z]*__%7C[/\\\\\\\\]internal[/\\\\\\\\]).)*$\";\n\n//# sourceURL=webpack:///./client/component/criteria_coursecompletion/src/components/_sync_^(?");

/***/ }),

/***/ "./server/totara/criteria/plugins/coursecompletion/webapi/ajax/achievements.graphql":
/*!******************************************************************************************!*\
  !*** ./server/totara/criteria/plugins/coursecompletion/webapi/ajax/achievements.graphql ***!
  \******************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export */ __webpack_require__.d(__webpack_exports__, {\n/* harmony export */   \"default\": () => (__WEBPACK_DEFAULT_EXPORT__)\n/* harmony export */ });\n\n    var doc = {\"kind\":\"Document\",\"definitions\":[{\"kind\":\"OperationDefinition\",\"operation\":\"query\",\"name\":{\"kind\":\"Name\",\"value\":\"criteria_coursecompletion_achievements\"},\"variableDefinitions\":[{\"kind\":\"VariableDefinition\",\"variable\":{\"kind\":\"Variable\",\"name\":{\"kind\":\"Name\",\"value\":\"instance_id\"}},\"type\":{\"kind\":\"NonNullType\",\"type\":{\"kind\":\"NamedType\",\"name\":{\"kind\":\"Name\",\"value\":\"core_id\"}}},\"directives\":[]},{\"kind\":\"VariableDefinition\",\"variable\":{\"kind\":\"Variable\",\"name\":{\"kind\":\"Name\",\"value\":\"user_id\"}},\"type\":{\"kind\":\"NonNullType\",\"type\":{\"kind\":\"NamedType\",\"name\":{\"kind\":\"Name\",\"value\":\"core_id\"}}},\"directives\":[]}],\"directives\":[],\"selectionSet\":{\"kind\":\"SelectionSet\",\"selections\":[{\"kind\":\"Field\",\"name\":{\"kind\":\"Name\",\"value\":\"criteria_coursecompletion_achievements\"},\"arguments\":[{\"kind\":\"Argument\",\"name\":{\"kind\":\"Name\",\"value\":\"instance_id\"},\"value\":{\"kind\":\"Variable\",\"name\":{\"kind\":\"Name\",\"value\":\"instance_id\"}}},{\"kind\":\"Argument\",\"name\":{\"kind\":\"Name\",\"value\":\"user_id\"},\"value\":{\"kind\":\"Variable\",\"name\":{\"kind\":\"Name\",\"value\":\"user_id\"}}}],\"directives\":[],\"selectionSet\":{\"kind\":\"SelectionSet\",\"selections\":[{\"kind\":\"Field\",\"name\":{\"kind\":\"Name\",\"value\":\"aggregation_method\"},\"arguments\":[],\"directives\":[]},{\"kind\":\"Field\",\"name\":{\"kind\":\"Name\",\"value\":\"required_items\"},\"arguments\":[],\"directives\":[]},{\"kind\":\"Field\",\"name\":{\"kind\":\"Name\",\"value\":\"is_valid\"},\"arguments\":[],\"directives\":[]},{\"kind\":\"Field\",\"name\":{\"kind\":\"Name\",\"value\":\"items\"},\"arguments\":[],\"directives\":[],\"selectionSet\":{\"kind\":\"SelectionSet\",\"selections\":[{\"kind\":\"Field\",\"name\":{\"kind\":\"Name\",\"value\":\"course\"},\"arguments\":[],\"directives\":[],\"selectionSet\":{\"kind\":\"SelectionSet\",\"selections\":[{\"kind\":\"Field\",\"name\":{\"kind\":\"Name\",\"value\":\"fullname\"},\"arguments\":[],\"directives\":[]},{\"kind\":\"Field\",\"name\":{\"kind\":\"Name\",\"value\":\"description\"},\"arguments\":[],\"directives\":[]},{\"kind\":\"Field\",\"name\":{\"kind\":\"Name\",\"value\":\"progress\"},\"arguments\":[],\"directives\":[]},{\"kind\":\"Field\",\"name\":{\"kind\":\"Name\",\"value\":\"url_view\"},\"arguments\":[],\"directives\":[]}]}}]}}]}}]}}]};\n    /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (doc);\n  \n\n//# sourceURL=webpack:///./server/totara/criteria/plugins/coursecompletion/webapi/ajax/achievements.graphql?");

/***/ }),

/***/ "./client/component/criteria_coursecompletion/src/tui.json":
/*!*****************************************************************!*\
  !*** ./client/component/criteria_coursecompletion/src/tui.json ***!
  \*****************************************************************/
/***/ ((__unused_webpack_module, __unused_webpack_exports, __webpack_require__) => {

eval("!function() {\n\"use strict\";\n\nif (typeof tui !== 'undefined' && tui._bundle.isLoaded(\"criteria_coursecompletion\")) {\n  console.warn(\n    '[tui bundle] The bundle \"' + \"criteria_coursecompletion\" +\n    '\" is already loaded, skipping initialisation.'\n  );\n  return;\n};\ntui._bundle.register(\"criteria_coursecompletion\")\ntui._bundle.addModulesFromContext(\"criteria_coursecompletion/components\", __webpack_require__(\"./client/component/criteria_coursecompletion/src/components sync recursive ^(?:(?%21__[a-z]*__%7C[/\\\\\\\\]internal[/\\\\\\\\]).)*$\"));\n}();\n\n//# sourceURL=webpack:///./client/component/criteria_coursecompletion/src/tui.json?");

/***/ }),

/***/ "./client/component/criteria_coursecompletion/src/components/achievements/AchievementDisplay.vue":
/*!*******************************************************************************************************!*\
  !*** ./client/component/criteria_coursecompletion/src/components/achievements/AchievementDisplay.vue ***!
  \*******************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export */ __webpack_require__.d(__webpack_exports__, {\n/* harmony export */   \"default\": () => (__WEBPACK_DEFAULT_EXPORT__)\n/* harmony export */ });\n/* harmony import */ var _AchievementDisplay_vue_vue_type_template_id_d3a10f00___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./AchievementDisplay.vue?vue&type=template&id=d3a10f00& */ \"./client/component/criteria_coursecompletion/src/components/achievements/AchievementDisplay.vue?vue&type=template&id=d3a10f00&\");\n/* harmony import */ var _AchievementDisplay_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./AchievementDisplay.vue?vue&type=script&lang=js& */ \"./client/component/criteria_coursecompletion/src/components/achievements/AchievementDisplay.vue?vue&type=script&lang=js&\");\n/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ \"./node_modules/vue-loader/lib/runtime/componentNormalizer.js\");\n\n\n\n\n\n/* normalize component */\n;\nvar component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__[\"default\"])(\n  _AchievementDisplay_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__[\"default\"],\n  _AchievementDisplay_vue_vue_type_template_id_d3a10f00___WEBPACK_IMPORTED_MODULE_0__.render,\n  _AchievementDisplay_vue_vue_type_template_id_d3a10f00___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,\n  false,\n  null,\n  null,\n  null\n  \n)\n\ncomponent.options.__hasBlocks = {\"script\":true,\"template\":true};\n/* hot reload */\nif (false) { var api; }\ncomponent.options.__file = \"client/component/criteria_coursecompletion/src/components/achievements/AchievementDisplay.vue\"\n/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);\n\n//# sourceURL=webpack:///./client/component/criteria_coursecompletion/src/components/achievements/AchievementDisplay.vue?");

/***/ }),

/***/ "./client/tooling/webpack/tui_vue_loader.js??ruleSet[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./node_modules/source-map-loader/dist/cjs.js??ruleSet[1].rules[3].use[0]!./client/component/criteria_coursecompletion/src/components/achievements/AchievementDisplay.vue?vue&type=script&lang=js&":
/*!*******************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./client/tooling/webpack/tui_vue_loader.js??ruleSet[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./node_modules/source-map-loader/dist/cjs.js??ruleSet[1].rules[3].use[0]!./client/component/criteria_coursecompletion/src/components/achievements/AchievementDisplay.vue?vue&type=script&lang=js& ***!
  \*******************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export */ __webpack_require__.d(__webpack_exports__, {\n/* harmony export */   \"default\": () => (__WEBPACK_DEFAULT_EXPORT__)\n/* harmony export */ });\n/* harmony import */ var totara_criteria_components_achievements_CourseAchievementDisplay__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! totara_criteria/components/achievements/CourseAchievementDisplay */ \"totara_criteria/components/achievements/CourseAchievementDisplay\");\n/* harmony import */ var totara_criteria_components_achievements_CourseAchievementDisplay__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(totara_criteria_components_achievements_CourseAchievementDisplay__WEBPACK_IMPORTED_MODULE_0__);\n/* harmony import */ var criteria_coursecompletion_graphql_achievements__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! criteria_coursecompletion/graphql/achievements */ \"./server/totara/criteria/plugins/coursecompletion/webapi/ajax/achievements.graphql\");\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n\n// Components\n\n// GraphQL\n\n\n/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({\n  components: { CourseAchievementDisplay: (totara_criteria_components_achievements_CourseAchievementDisplay__WEBPACK_IMPORTED_MODULE_0___default()) },\n  inheritAttrs: false,\n  props: {\n    instanceId: {\n      required: true,\n      type: Number,\n    },\n    userId: {\n      required: true,\n      type: Number,\n    },\n    displayed: Boolean,\n  },\n\n  data: function() {\n    return {\n      achievements: {\n        items: [],\n      },\n    };\n  },\n\n  apollo: {\n    /**\n     * Fetch a criteria set for course completion\n     *\n     * @return {Object}\n     */\n    achievements: {\n      query: criteria_coursecompletion_graphql_achievements__WEBPACK_IMPORTED_MODULE_1__[\"default\"],\n      context: { batch: true },\n      variables() {\n        return {\n          instance_id: this.instanceId,\n          user_id: this.userId,\n        };\n      },\n      update({ criteria_coursecompletion_achievements: achievements }) {\n        this.$emit('loaded');\n        return achievements;\n      },\n    },\n  },\n});\n\n\n//# sourceURL=webpack:///./client/component/criteria_coursecompletion/src/components/achievements/AchievementDisplay.vue?./client/tooling/webpack/tui_vue_loader.js??ruleSet%5B0%5D.rules%5B0%5D.use%5B0%5D!./node_modules/vue-loader/lib/index.js??vue-loader-options!./node_modules/source-map-loader/dist/cjs.js??ruleSet%5B1%5D.rules%5B3%5D.use%5B0%5D");

/***/ }),

/***/ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js":
/*!********************************************************************!*\
  !*** ./node_modules/vue-loader/lib/runtime/componentNormalizer.js ***!
  \********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export */ __webpack_require__.d(__webpack_exports__, {\n/* harmony export */   \"default\": () => (/* binding */ normalizeComponent)\n/* harmony export */ });\n/* globals __VUE_SSR_CONTEXT__ */\n\n// IMPORTANT: Do NOT use ES2015 features in this file (except for modules).\n// This module is a runtime utility for cleaner component module output and will\n// be included in the final webpack user bundle.\n\nfunction normalizeComponent (\n  scriptExports,\n  render,\n  staticRenderFns,\n  functionalTemplate,\n  injectStyles,\n  scopeId,\n  moduleIdentifier, /* server only */\n  shadowMode /* vue-cli only */\n) {\n  // Vue.extend constructor export interop\n  var options = typeof scriptExports === 'function'\n    ? scriptExports.options\n    : scriptExports\n\n  // render functions\n  if (render) {\n    options.render = render\n    options.staticRenderFns = staticRenderFns\n    options._compiled = true\n  }\n\n  // functional template\n  if (functionalTemplate) {\n    options.functional = true\n  }\n\n  // scopedId\n  if (scopeId) {\n    options._scopeId = 'data-v-' + scopeId\n  }\n\n  var hook\n  if (moduleIdentifier) { // server build\n    hook = function (context) {\n      // 2.3 injection\n      context =\n        context || // cached call\n        (this.$vnode && this.$vnode.ssrContext) || // stateful\n        (this.parent && this.parent.$vnode && this.parent.$vnode.ssrContext) // functional\n      // 2.2 with runInNewContext: true\n      if (!context && typeof __VUE_SSR_CONTEXT__ !== 'undefined') {\n        context = __VUE_SSR_CONTEXT__\n      }\n      // inject component styles\n      if (injectStyles) {\n        injectStyles.call(this, context)\n      }\n      // register component module identifier for async chunk inferrence\n      if (context && context._registeredComponents) {\n        context._registeredComponents.add(moduleIdentifier)\n      }\n    }\n    // used by ssr in case component is cached and beforeCreate\n    // never gets called\n    options._ssrRegister = hook\n  } else if (injectStyles) {\n    hook = shadowMode\n      ? function () {\n        injectStyles.call(\n          this,\n          (options.functional ? this.parent : this).$root.$options.shadowRoot\n        )\n      }\n      : injectStyles\n  }\n\n  if (hook) {\n    if (options.functional) {\n      // for template-only hot-reload because in that case the render fn doesn't\n      // go through the normalizer\n      options._injectStyles = hook\n      // register for functional component in vue file\n      var originalRender = options.render\n      options.render = function renderWithStyleInjection (h, context) {\n        hook.call(context)\n        return originalRender(h, context)\n      }\n    } else {\n      // inject component registration as beforeCreate hook\n      var existing = options.beforeCreate\n      options.beforeCreate = existing\n        ? [].concat(existing, hook)\n        : [hook]\n    }\n  }\n\n  return {\n    exports: scriptExports,\n    options: options\n  }\n}\n\n\n//# sourceURL=webpack:///./node_modules/vue-loader/lib/runtime/componentNormalizer.js?");

/***/ }),

/***/ "./client/component/criteria_coursecompletion/src/components/achievements/AchievementDisplay.vue?vue&type=template&id=d3a10f00&":
/*!**************************************************************************************************************************************!*\
  !*** ./client/component/criteria_coursecompletion/src/components/achievements/AchievementDisplay.vue?vue&type=template&id=d3a10f00& ***!
  \**************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export */ __webpack_require__.d(__webpack_exports__, {\n/* harmony export */   \"render\": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_tooling_webpack_tui_vue_loader_js_ruleSet_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_AchievementDisplay_vue_vue_type_template_id_d3a10f00___WEBPACK_IMPORTED_MODULE_0__.render),\n/* harmony export */   \"staticRenderFns\": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_tooling_webpack_tui_vue_loader_js_ruleSet_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_AchievementDisplay_vue_vue_type_template_id_d3a10f00___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns)\n/* harmony export */ });\n/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_tooling_webpack_tui_vue_loader_js_ruleSet_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_AchievementDisplay_vue_vue_type_template_id_d3a10f00___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../tooling/webpack/tui_vue_loader.js??ruleSet[0].rules[0].use[0]!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./AchievementDisplay.vue?vue&type=template&id=d3a10f00& */ \"./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./client/tooling/webpack/tui_vue_loader.js??ruleSet[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./client/component/criteria_coursecompletion/src/components/achievements/AchievementDisplay.vue?vue&type=template&id=d3a10f00&\");\n\n\n//# sourceURL=webpack:///./client/component/criteria_coursecompletion/src/components/achievements/AchievementDisplay.vue?");

/***/ }),

/***/ "./client/component/criteria_coursecompletion/src/components/achievements/AchievementDisplay.vue?vue&type=script&lang=js&":
/*!********************************************************************************************************************************!*\
  !*** ./client/component/criteria_coursecompletion/src/components/achievements/AchievementDisplay.vue?vue&type=script&lang=js& ***!
  \********************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export */ __webpack_require__.d(__webpack_exports__, {\n/* harmony export */   \"default\": () => (__WEBPACK_DEFAULT_EXPORT__)\n/* harmony export */ });\n/* harmony import */ var _tooling_webpack_tui_vue_loader_js_ruleSet_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_node_modules_source_map_loader_dist_cjs_js_ruleSet_1_rules_3_use_0_AchievementDisplay_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../tooling/webpack/tui_vue_loader.js??ruleSet[0].rules[0].use[0]!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!../../../../../../node_modules/source-map-loader/dist/cjs.js??ruleSet[1].rules[3].use[0]!./AchievementDisplay.vue?vue&type=script&lang=js& */ \"./client/tooling/webpack/tui_vue_loader.js??ruleSet[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./node_modules/source-map-loader/dist/cjs.js??ruleSet[1].rules[3].use[0]!./client/component/criteria_coursecompletion/src/components/achievements/AchievementDisplay.vue?vue&type=script&lang=js&\");\n /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_tooling_webpack_tui_vue_loader_js_ruleSet_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_node_modules_source_map_loader_dist_cjs_js_ruleSet_1_rules_3_use_0_AchievementDisplay_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__[\"default\"]); \n\n//# sourceURL=webpack:///./client/component/criteria_coursecompletion/src/components/achievements/AchievementDisplay.vue?");

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./client/tooling/webpack/tui_vue_loader.js??ruleSet[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./client/component/criteria_coursecompletion/src/components/achievements/AchievementDisplay.vue?vue&type=template&id=d3a10f00&":
/*!****************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./client/tooling/webpack/tui_vue_loader.js??ruleSet[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./client/component/criteria_coursecompletion/src/components/achievements/AchievementDisplay.vue?vue&type=template&id=d3a10f00& ***!
  \****************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export */ __webpack_require__.d(__webpack_exports__, {\n/* harmony export */   \"render\": () => (/* binding */ render),\n/* harmony export */   \"staticRenderFns\": () => (/* binding */ staticRenderFns)\n/* harmony export */ });\nvar render = function () {var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;return _c('CourseAchievementDisplay',{attrs:{\"achievements\":_vm.achievements,\"displayed\":_vm.displayed}})}\nvar staticRenderFns = []\nrender._withStripped = true\n\n\n//# sourceURL=webpack:///./client/component/criteria_coursecompletion/src/components/achievements/AchievementDisplay.vue?./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./client/tooling/webpack/tui_vue_loader.js??ruleSet%5B0%5D.rules%5B0%5D.use%5B0%5D!./node_modules/vue-loader/lib/index.js??vue-loader-options");

/***/ }),

/***/ "totara_criteria/components/achievements/CourseAchievementDisplay":
/*!****************************************************************************************************!*\
  !*** external "tui.require(\"totara_criteria/components/achievements/CourseAchievementDisplay\")" ***!
  \****************************************************************************************************/
/***/ ((module) => {

"use strict";
module.exports = tui.require("totara_criteria/components/achievements/CourseAchievementDisplay");

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/compat get default export */
/******/ 	(() => {
/******/ 		// getDefaultExport function for compatibility with non-harmony modules
/******/ 		__webpack_require__.n = (module) => {
/******/ 			var getter = module && module.__esModule ?
/******/ 				() => (module['default']) :
/******/ 				() => (module);
/******/ 			__webpack_require__.d(getter, { a: getter });
/******/ 			return getter;
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/define property getters */
/******/ 	(() => {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = (exports, definition) => {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module can't be inlined because the eval devtool is used.
/******/ 	var __webpack_exports__ = __webpack_require__("./client/component/criteria_coursecompletion/src/tui.json");
/******/ 	
/******/ })()
;