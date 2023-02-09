!function(){var t={x4dL:function(t,e,n){var o={"./MultiLangBlock":"MxOa","./MultiLangBlock.vue":"MxOa","./MultiLangBlockCollection":"tpC8","./MultiLangBlockCollection.vue":"tpC8","./form/SimpleMultiLangForm":"77Wj","./form/SimpleMultiLangForm.vue":"77Wj","./modal/EditSimpleMultiLangModal":"W35/","./modal/EditSimpleMultiLangModal.vue":"W35/"};function i(t){var e=a(t);return n(e)}function a(t){if(!n.o(o,t)){var e=new Error("Cannot find module '"+t+"'");throw e.code="MODULE_NOT_FOUND",e}return o[t]}i.keys=function(){return Object.keys(o)},i.resolve=a,t.exports=i,i.id="x4dL"},Ynos:function(t,e,n){var o={"./extension":"b1ER","./extension.js":"b1ER","./plugin":"wt9c","./plugin.js":"wt9c"};function i(t){var e=a(t);return n(e)}function a(t){if(!n.o(o,t)){var e=new Error("Cannot find module '"+t+"'");throw e.code="MODULE_NOT_FOUND",e}return o[t]}i.keys=function(){return Object.keys(o)},i.resolve=a,t.exports=i,i.id="Ynos"},MxOa:function(t,e,n){"use strict";n.r(e),n.d(e,{default:function(){return k}});var o=n("TVjX"),i=n.n(o),a=n("1+j7"),r=n.n(a),l=tui.require("tui/components/icons/Edit"),s=n.n(l),u=tui.require("tui/components/icons/Delete"),c=n.n(u),_=tui.require("tui/components/modal/ModalPresenter"),d=n.n(_),p=tui.require("weka_simple_multi_lang/components/modal/EditSimpleMultiLangModal"),m=n.n(p),g={components:{ButtonIcon:r(),Edit:s(),Delete:c(),ModalPresenter:d(),EditMultiLangModal:m()},extends:i(),data:function(){return{editModal:!1}},computed:{language:function(){return this.attrs.lang},langContentJson:function(){var t=[];return this.node.content.forEach((function(e){return t.push(e.toJSON())})),t},removable:function(){return!this.editorDisabled&&this.attrs.siblings_count>2},editLanguageAriaLabel:function(){return this.$str("edit_language_x","weka_simple_multi_lang",this.language||this.$str("unspecified","weka_simple_multi_lang"))},removeLanguageAriaLabel:function(){return this.$str("remove_language_x","weka_simple_multi_lang",this.language||this.$str("unspecified","weka_simple_multi_lang"))},editorCompact:function(){return this.context.getCompact()},placeholderResolverClass:function(){return this.context.getPlaceholderResolverClassName()}},methods:{handleUpdateLangContent:function(t){var e=t.lang,n=t.content,o={attrs:{lang:e,siblings_count:this.attrs.siblings_count},content:n};this.editModal=!1,this.context.updateSelf(o,this.getRange)},handleRemoving:function(){this.context.removeSelf(this.getRange)}}},f=function(t){t.options.__langStrings={weka_simple_multi_lang:["edit_language_x","remove_language_x","unspecified","language_label"]}},v=(0,n("wWJ2").Z)(g,(function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("div",{staticClass:"tui-wekaMultiLangBlock",attrs:{contenteditable:"false"}},[n("ModalPresenter",{attrs:{open:t.editModal},on:{"request-close":function(e){t.editModal=!1}}},[n("EditMultiLangModal",{attrs:{lang:t.language,content:t.langContentJson,"editor-compact":t.editorCompact,"placeholder-resolver-class":t.placeholderResolverClass},on:{submit:t.handleUpdateLangContent}})],1),t._v(" "),n("div",{staticClass:"tui-wekaMultiLangBlock__container"},[n("div",{staticClass:"tui-wekaMultiLangBlock__wrapper"},[n("div",{staticClass:"tui-wekaMultiLangBlock__languageWrapper"},[n("div",{staticClass:"tui-wekaMultiLangBlock__language"},[t._v("\n          "+t._s(t.$str("language_label","weka_simple_multi_lang",t.language||t.$str("unspecified","weka_simple_multi_lang")))+"\n        ")]),t._v(" "),n("div",{staticClass:"tui-wekaMultiLangBlock__actions"},[t.editorDisabled?t._e():n("ButtonIcon",{attrs:{"aria-label":t.editLanguageAriaLabel,styleclass:{transparent:!0,transparentNoPadding:!0}},on:{click:function(e){t.editModal=!0}}},[n("Edit",{attrs:{size:100}})],1)],1)]),t._v(" "),n("div",{ref:"content",staticClass:"tui-wekaMultiLangBlock__texts"})]),t._v(" "),t.removable?n("ButtonIcon",{staticClass:"tui-wekaMultiLangBlock__remove",attrs:{"aria-label":t.removeLanguageAriaLabel,styleclass:{transparent:!0,transparentNoPadding:!0}},on:{click:t.handleRemoving}},[n("Delete",{attrs:{size:100}})],1):t._e()],1)],1)}),[],!1,null,null,null);f(v),v.options.__hasBlocks={script:!0,template:!0};var k=v.exports},tpC8:function(t,e,n){"use strict";n.r(e),n.d(e,{default:function(){return d}});var o=n("TVjX"),i=n.n(o),a=n("1+j7"),r=n.n(a),l=tui.require("tui/components/icons/Add"),s=n.n(l),u={components:{ButtonIcon:r(),Add:s()},extends:i(),computed:{isActionSpacingRequired:function(){return this.node.content.content.length>2}},methods:{insertNewLangBlock:function(){this.context.insertNewLangBlock(this.getRange)}}},c=function(t){t.options.__langStrings={weka_simple_multi_lang:["add_new","remove_collection_block"]}},_=(0,n("wWJ2").Z)(u,(function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("div",{staticClass:"tui-wekaMultiLangBlockCollection"},[n("div",{ref:"content",staticClass:"tui-wekaMultiLangBlockCollection__content"}),t._v(" "),n("div",{staticClass:"tui-wekaMultiLangBlockCollection__actions",class:{"tui-wekaMultiLangBlockCollection__actions--spacing":t.isActionSpacingRequired}},[t.editorDisabled?t._e():n("ButtonIcon",{attrs:{"aria-label":t.$str("add_new","weka_simple_multi_lang"),styleclass:{transparentNoPadding:!0}},on:{click:t.insertNewLangBlock}},[n("Add",{attrs:{size:300}})],1)],1)])}),[],!1,null,null,null);c(_),_.options.__hasBlocks={script:!0,template:!0};var d=_.exports},"77Wj":function(t,e,n){"use strict";n.r(e),n.d(e,{default:function(){return x}});var o=tui.require("tui/components/uniform/Uniform"),i=n.n(o),a=tui.require("editor_weka/components/Weka"),r=n.n(a),l=tui.require("editor_weka/WekaValue"),s=n.n(l),u=tui.require("tui/components/form/FormRow"),c=n.n(u),_=tui.require("tui/components/uniform/FormText"),d=n.n(_),p=tui.require("tui/components/uniform/FormField"),m=n.n(p),g=tui.require("tui/components/buttons/ButtonGroup"),f=n.n(g),v=tui.require("tui/components/buttons/Button"),k=n.n(v),h=tui.require("tui/components/buttons/Cancel"),b=n.n(h),w={components:{Uniform:i(),FormRow:c(),FormText:d(),FormField:m(),Weka:r(),ButtonGroup:f(),Cancel:b(),Button:k()},props:{lang:{type:String,validator:function(t){return t.length<=5}},content:{type:Array,validator:function(t){return t.every((function(t){return t.type&&("paragraph"===t.type||"heading"===t.type)}))},default:function(){return[]}},editorCompact:Boolean,editorExtraExtensions:{type:Array,default:function(){return[]},validator:function(t){return t.every((function(t){return"name"in t}))}}},data:function(){var t=null;return this.content.length&&(t=s().fromDoc({type:"doc",content:this.content})),{formValue:{lang:{type:String,value:this.lang},content:{type:s(),value:t}}}},methods:{submitForm:function(t){var e={lang:t.lang.value,content:[]},n=t.content.value.getDoc().content;n&&n.length&&(e.content=n),this.$emit("submit",e)},validateContentEditor:function(t){return t?t.isEmpty?this.$str("required","core"):"":this.$str("required","core")}}},y=function(t){t.options.__langStrings={weka_simple_multi_lang:["lang_code","content","content_help","lang_code_help"],totara_core:["save"],core:["required"]}},C=(0,n("wWJ2").Z)(w,(function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("Uniform",{staticClass:"tui-wekaSimpleMultiLangForm",attrs:{"initial-values":t.formValue,"input-width":"full"},on:{submit:t.submitForm}},[n("FormRow",{attrs:{label:t.$str("lang_code","weka_simple_multi_lang"),required:!0,helpmsg:t.$str("lang_code_help","weka_simple_multi_lang")}},[[n("FormText",{attrs:{name:["lang","value"],maxlength:5,"char-length":5,validations:function(t){return[t.required()]}}})]],2),t._v(" "),n("FormRow",{attrs:{label:t.$str("content","weka_simple_multi_lang"),required:!0,helpmsg:t.$str("content_help","weka_simple_multi_lang")}},[[n("FormField",{attrs:{name:["content","value"],"char-length":"full",validate:t.validateContentEditor},scopedSlots:t._u([{key:"default",fn:function(e){var o=e.value,i=e.update;return[n("Weka",{attrs:{value:o,compact:t.editorCompact,"extra-extensions":t.editorExtraExtensions,variant:"simple"},on:{input:i}})]}}])})]],2),t._v(" "),n("ButtonGroup",{staticClass:"tui-wekaSimpleMultiLangForm__buttonGroup"},[[n("Button",{attrs:{styleclass:{primary:!0},text:t.$str("save","totara_core"),"aria-label":t.$str("save","totara_core"),type:"submit"}}),t._v(" "),n("Cancel",{on:{click:function(e){return t.$emit("cancel")}}})]],2)],1)}),[],!1,null,null,null);y(C),C.options.__hasBlocks={script:!0,template:!0};var x=C.exports},"W35/":function(t,e,n){"use strict";n.r(e),n.d(e,{default:function(){return d}});var o=tui.require("weka_simple_multi_lang/components/form/SimpleMultiLangForm"),i=n.n(o),a=tui.require("tui/components/modal/Modal"),r=n.n(a),l=tui.require("tui/components/modal/ModalContent"),s=n.n(l),u={components:{MultiLangForm:i(),Modal:r(),ModalContent:s()},props:{lang:String,content:Array,editorCompact:Boolean,placeholderResolverClass:String},computed:{editorExtraExtensions:function(){return this.placeholderResolverClass?[{name:"weka_notification_placeholder_extension",options:{resolver_class_name:this.placeholderResolverClass}}]:[]}}},c=function(t){t.options.__langStrings={weka_simple_multi_lang:["edit_language"]}},_=(0,n("wWJ2").Z)(u,(function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("Modal",{staticClass:"tui-wekaEditSimpleMultiLangModal",attrs:{size:"large",dismissable:{esc:!1,backdropClick:!1}}},[n("ModalContent",{attrs:{title:t.$str("edit_language","weka_simple_multi_lang"),"close-button":!0}},[n("MultiLangForm",{attrs:{lang:t.lang,content:t.content,"editor-compact":t.editorCompact,"editor-extra-extensions":t.editorExtraExtensions},on:{submit:function(e){return t.$emit("submit",e)},cancel:function(e){return t.$emit("request-close")}}})],1)],1)}),[],!1,null,null,null);c(_),_.options.__hasBlocks={script:!0,template:!0};var d=_.exports},b1ER:function(t,e,n){"use strict";function o(t,e){if(!(t instanceof e))throw new TypeError("Cannot call a class as a function")}function i(t,e){for(var n=0;n<e.length;n++){var o=e[n];o.enumerable=o.enumerable||!1,o.configurable=!0,"value"in o&&(o.writable=!0),Object.defineProperty(t,o.key,o)}}function a(t,e){return a=Object.setPrototypeOf?Object.setPrototypeOf.bind():function(t,e){return t.__proto__=e,t},a(t,e)}function r(t){return r="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(t){return typeof t}:function(t){return t&&"function"==typeof Symbol&&t.constructor===Symbol&&t!==Symbol.prototype?"symbol":typeof t},r(t)}function l(t,e){if(e&&("object"===r(e)||"function"==typeof e))return e;if(void 0!==e)throw new TypeError("Derived constructors may only return object or undefined");return function(t){if(void 0===t)throw new ReferenceError("this hasn't been initialised - super() hasn't been called");return t}(t)}function s(t){return s=Object.setPrototypeOf?Object.getPrototypeOf.bind():function(t){return t.__proto__||Object.getPrototypeOf(t)},s(t)}n.r(e),n.d(e,{default:function(){return x}});var u=tui.require("editor_weka/extensions/Base"),c=n.n(u),_=tui.require("weka_simple_multi_lang/components/MultiLangBlock"),d=n.n(_),p=tui.require("weka_simple_multi_lang/components/MultiLangBlockCollection"),m=n.n(p),g=tui.require("editor_weka/toolbar"),f=tui.require("tui/i18n"),v=tui.require("tui/util"),k=tui.require("tui/components/icons/MultiLang"),h=n.n(k),b=n("wt9c"),w=n("Xz/0"),y=tui.require("editor_weka/extensions/util");tui.require("ext_prosemirror/view");var C=function(t){!function(t,e){if("function"!=typeof e&&null!==e)throw new TypeError("Super expression must either be null or a function");t.prototype=Object.create(e&&e.prototype,{constructor:{value:t,writable:!0,configurable:!0}}),Object.defineProperty(t,"prototype",{writable:!1}),e&&a(t,e)}(_,t);var e,n,r,u,c=(r=_,u=function(){if("undefined"==typeof Reflect||!Reflect.construct)return!1;if(Reflect.construct.sham)return!1;if("function"==typeof Proxy)return!0;try{return Boolean.prototype.valueOf.call(Reflect.construct(Boolean,[],(function(){}))),!0}catch(t){return!1}}(),function(){var t,e=s(r);if(u){var n=s(this).constructor;t=Reflect.construct(e,arguments,n)}else t=e.apply(this,arguments);return l(this,t)});function _(){return o(this,_),c.apply(this,arguments)}return e=_,(n=[{key:"nodes",value:function(){var t=this;return{weka_simple_multi_lang_lang_block:{schema:{atom:!0,selectable:!1,isolating:!0,group:"weka_simple_multi_lang_lang_blocks",draggable:!1,content:"(paragraph|heading)*",allowGapCursor:!1,attrs:{lang:{default:void 0},siblings_count:{default:1}},toDOM:function(t){return["div",{class:"tui-wekaMultiLangBlock","data-attrs":JSON.stringify({lang:t.attrs.lang,siblings_count:t.attrs.siblings_count})},0]},parseDOM:[{tag:"div.tui-wekaMultiLangBlock",getAttrs:y.getJsonAttrs}]},component:d(),componentContext:{removeSelf:this._removeLangBlock.bind(this),updateSelf:this._updateLangBlock.bind(this),getCompact:function(){return t.options.compact||!1},getPlaceholderResolverClassName:function(){return t.options.placeholder_resolver_class_name||null}}},weka_simple_multi_lang_lang_blocks:{schema:{atom:!0,draggable:!1,selectable:!0,isolating:!0,group:"block",content:"weka_simple_multi_lang_lang_block+",allowGapCursor:!1,toDOM:function(){return["div",{class:"tui-wekaMultiLangBlockCollection"},0]},parseDOM:[{tag:"div.tui-wekaMultiLangBlockCollection"}]},component:m(),componentContext:{insertNewLangBlock:this._insertNewLangBlock.bind(this)}}}}},{key:"toolbarItems",value:function(){return this.options.is_active?[new g.ToolbarItem({group:"embeds",label:(0,f.langString)("multi_lang","weka_simple_multi_lang"),iconComponent:h(),execute:this._createCollectionBlock.bind(this)})]:[]}},{key:"plugins",value:function(){return[(0,b.default)({handleKeyDown:this._handleKeyDown.bind(this)})]}},{key:"keymap",value:function(t){this.options.is_active&&t("Ctrl-m",this._createCollectionBlock.bind(this))}},{key:"loadSerializedVisitor",value:function(){return{weka_simple_multi_lang_lang_blocks:function(t){t.content.forEach((function(e){e.attrs||(e.attrs={}),e.attrs.siblings_count=t.content.length}))}}}},{key:"saveSerializedVisitor",value:function(){return{weka_simple_multi_lang_lang_blocks:function(t){t.content.forEach((function(t){delete t.attrs.siblings_count}))}}}},{key:"_createCollectionBlock",value:function(){var t=(0,v.pick)(this.editor.state.selection,["from","to"]),e=t.from,n=t.to;this.editor.execute((function(t,o){var i=t.tr;i.replaceWith(e,n,[t.schema.node("weka_simple_multi_lang_lang_blocks",{},[t.schema.node("weka_simple_multi_lang_lang_block",{siblings_count:2}),t.schema.node("weka_simple_multi_lang_lang_block",{siblings_count:2})])]),o(i)}))}},{key:"_removeLangBlock",value:function(t){var e=this,n=t().from,o=this.doc.resolve(n),i=this.doc.resolve(o.end()),a=i.node();"weka_simple_multi_lang_lang_blocks"===a.type.name?a.content.content.length<=2?console.warn("[Weka] cannot remove another single lang block due to the minimum requirement"):this.editor.execute((function(t,n){var r=t.schema,l=t.tr;(a=a.toJSON()).content=a.content.filter((function(t,e){return e!==o.index()}));var s=a.content.length;a.content=a.content.map((function(t){return(t=Object.assign({},t)).attrs=Object.assign({},t.attrs,{siblings_count:s}),t})),l.replaceWith(i.before(),i.after(),r.nodeFromJSON(a)),n(l),e.editor.view.focus()})):console.error("[Weka] cannot resolve the position of parent collection node")}},{key:"_updateLangBlock",value:function(t,e){var n=t.attrs,o=t.content,i=e(),a=i.from,r=i.to;this.editor.execute((function(t,e){var i=t.tr,l=o.map((function(e){return t.schema.nodeFromJSON(e)}));e(i.replaceWith(a,r,t.schema.node("weka_simple_multi_lang_lang_block",n,l)))})),this.editor.view.focus()}},{key:"_insertNewLangBlock",value:function(t){var e=t().to,n=this.editor.state.doc.resolve(e-1),o=n.node();if("weka_simple_multi_lang_lang_blocks"===o.type.name){var i=(o=o.toJSON()).content.length;o.content=o.content.map((function(t){return(t=Object.assign({},t)).attrs=Object.assign({},t.attrs,{siblings_count:i+1}),t})),this.editor.execute((function(t,e){var a=t.tr,r=t.schema;a.replaceWith(n.before(),n.after(),r.nodeFromJSON(o)),a.insert(n.end(),r.node("weka_simple_multi_lang_lang_block",{siblings_count:i+1})),e(a)})),this.editor.view.focus()}else console.warn("Unable to resolve node 'weka_simple_multi_lang_lang_blocks' from the position ".concat(e))}},{key:"_handleKeyDown",value:function(t,e){switch(e.key){case"Enter":return this._createNewLine(t);case"Backspace":case"Delete":return this._handleRemoveCollectionBlocKFromBackspace(t);default:var n=t.state.tr.selection.$from.node();return!(!n||"weka_simple_multi_lang_lang_blocks"!==n.type.name&&"weka_simple_multi_lang_lang_block"!==n.type.name)}}},{key:"_createNewLine",value:function(t){var e=this,n=t.state.tr.selection.$from,o=n.node(),i=function(){switch(o.type.name){case"weka_simple_multi_lang_lang_blocks":return n.after();case"weka_simple_multi_lang_lang_block":return e.doc.resolve(n.before()).after();case"paragraph":case"heading":if("weka_simple_multi_lang_lang_block"===n.node(n.depth-1).type.name){var i=t.state.doc.resolve(n.before());return t.state.doc.resolve(i.before()).after()}return null;default:return null}}();return null!==i&&(this.editor.execute((function(t,e){var n=t.tr;n.insert(i,t.schema.nodes.paragraph.createAndFill()),n.setSelection(new w.TextSelection(n.doc.resolve(i+1))),e(n)})),!0)}},{key:"_handleRemoveCollectionBlocKFromBackspace",value:function(t){var e,n,o,i=t.state.tr.selection.$from,a=i.node();return"weka_simple_multi_lang_lang_blocks"===a.type.name?(e={from:i.before(),to:i.after()},n=e.from,o=e.to,this.editor.execute((function(t,e){var i=t.tr;i.delete(n,o),e(i)})),!0):"weka_simple_multi_lang_lang_block"===a.type.name||"paragraph"===a.type.name&&"weka_simple_multi_lang_lang_block"===i.node(i.depth-1).type.name}}])&&i(e.prototype,n),Object.defineProperty(e,"prototype",{writable:!1}),_}(c()),x=function(t){return new C(t)}},wt9c:function(t,e,n){"use strict";n.r(e),n.d(e,{default:function(){return i}});var o=n("Xz/0");function i(t){var e=t.handleKeyDown,n=new o.PluginKey("weka_simple_multi_lang");return new o.Plugin({key:n,props:{handleKeyDown:e}})}},wWJ2:function(t,e,n){"use strict";function o(t,e,n,o,i,a,r,l){var s,u="function"==typeof t?t.options:t;if(e&&(u.render=e,u.staticRenderFns=n,u._compiled=!0),o&&(u.functional=!0),a&&(u._scopeId="data-v-"+a),r?(s=function(t){(t=t||this.$vnode&&this.$vnode.ssrContext||this.parent&&this.parent.$vnode&&this.parent.$vnode.ssrContext)||"undefined"==typeof __VUE_SSR_CONTEXT__||(t=__VUE_SSR_CONTEXT__),i&&i.call(this,t),t&&t._registeredComponents&&t._registeredComponents.add(r)},u._ssrRegister=s):i&&(s=l?function(){i.call(this,(u.functional?this.parent:this).$root.$options.shadowRoot)}:i),s)if(u.functional){u._injectStyles=s;var c=u.render;u.render=function(t,e){return s.call(e),c(t,e)}}else{var _=u.beforeCreate;u.beforeCreate=_?[].concat(_,s):[s]}return{exports:t,options:u}}n.d(e,{Z:function(){return o}})},TVjX:function(t){"use strict";t.exports=tui.require("editor_weka/components/nodes/BaseNode")},"Xz/0":function(t){"use strict";t.exports=tui.require("ext_prosemirror/state")},"1+j7":function(t){"use strict";t.exports=tui.require("tui/components/buttons/ButtonIcon")}},e={};function n(o){var i=e[o];if(void 0!==i)return i.exports;var a=e[o]={exports:{}};return t[o](a,a.exports,n),a.exports}n.n=function(t){var e=t&&t.__esModule?function(){return t.default}:function(){return t};return n.d(e,{a:e}),e},n.d=function(t,e){for(var o in e)n.o(e,o)&&!n.o(t,o)&&Object.defineProperty(t,o,{enumerable:!0,get:e[o]})},n.o=function(t,e){return Object.prototype.hasOwnProperty.call(t,e)},n.r=function(t){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(t,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(t,"__esModule",{value:!0})},function(){"use strict";"undefined"!=typeof tui&&tui._bundle.isLoaded("weka_simple_multi_lang")?console.warn('[tui bundle] The bundle "weka_simple_multi_lang" is already loaded, skipping initialisation.'):(tui._bundle.register("weka_simple_multi_lang"),tui._bundle.addModulesFromContext("weka_simple_multi_lang",n("Ynos")),tui._bundle.addModulesFromContext("weka_simple_multi_lang/components",n("x4dL")))}()}();