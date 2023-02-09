(()=>{var t={o64i:(t,e,r)=>{var n={"./basket/ImportBasket":"JmDg","./basket/ImportBasket.vue":"JmDg","./count/ImportCountAndFilters":"FcPZ","./count/ImportCountAndFilters.vue":"FcPZ","./filters/ImportSortFilter":"EAox","./filters/ImportSortFilter.vue":"EAox","./layouts/PageLayoutTwoColumn":"/vxj","./layouts/PageLayoutTwoColumn.vue":"/vxj","./paging/ImportReviewLoadMore":"nqFD","./paging/ImportReviewLoadMore.vue":"nqFD","./paging/ImportSelectionPaging":"miDL","./paging/ImportSelectionPaging.vue":"miDL","./tables/ImportReviewTable":"Cvfz","./tables/ImportReviewTable.vue":"Cvfz","./tables/ImportSelectionTable":"yM6j","./tables/ImportSelectionTable.vue":"yM6j","./tables/ImportTable":"IYtA","./tables/ImportTable.vue":"IYtA"};function o(t){var e=a(t);return r(e)}function a(t){if(!r.o(n,t)){var e=new Error("Cannot find module '"+t+"'");throw e.code="MODULE_NOT_FOUND",e}return n[t]}o.keys=function(){return Object.keys(n)},o.resolve=a,t.exports=o,o.id="o64i"},Rvhv:(t,e,r)=>{var n={"./CatalogImportLayout":"XxKb","./CatalogImportLayout.vue":"XxKb"};function o(t){var e=a(t);return r(e)}function a(t){if(!r.o(n,t)){var e=new Error("Cannot find module '"+t+"'");throw e.code="MODULE_NOT_FOUND",e}return n[t]}o.keys=function(){return Object.keys(n)},o.resolve=a,t.exports=o,o.id="Rvhv"},JmDg:(t,e,r)=>{"use strict";r.r(e),r.d(e,{default:()=>_});const n=tui.require("tui/components/basket/Basket");var o=r.n(n),a=r("IpiT"),i=r.n(a),s=r("QcEE"),l=r.n(s);const c={components:{Basket:o(),Button:i(),Select:l()},props:{categoryOptions:Array,selectedCategory:[String,Number],selectedItems:{type:Array,required:!0},viewingSelected:Boolean,creatingContent:Boolean,isLoading:Boolean,currentCategoryId:[String,Number]},computed:{options(){let t=this.categoryOptions.slice();return this.isLoading&&this.currentCategoryId||t.unshift({id:null,label:this.$str("assign_category","totara_contentmarketplace")}),t}}},u=function(t){t.options.__langStrings={totara_contentmarketplace:["assign_category","basket_back_to_catalogue","basket_clear_selection","basket_create_courses","basket_go_to_review","basket_select_category"]}};var p=(0,r("wWJ2").Z)(c,(function(){var t=this,e=t.$createElement,r=t._self._c||e;return r("Basket",{staticClass:"tui-contentMarketplaceImportBasket",attrs:{items:t.selectedItems,"wide-gap":!0},scopedSlots:t._u([{key:"status",fn:function(e){return[e.empty?t._e():r("Button",{attrs:{styleclass:{transparent:!0},text:t.$str("basket_clear_selection","totara_contentmarketplace")},on:{click:function(e){return t.$emit("clear-selection")}}})]}},{key:"actions",fn:function(e){var n=e.empty;return[t.viewingSelected?[r("Button",{attrs:{styleclass:{transparent:!0},text:t.$str("basket_back_to_catalogue","totara_contentmarketplace")},on:{click:function(e){return t.$emit("reviewing-selection",!1)}}}),t._v(" "),r("Button",{attrs:{disabled:n,loading:t.creatingContent,styleclass:{primary:!0},text:t.$str("basket_create_courses","totara_contentmarketplace")},on:{click:function(e){return t.$emit("create-courses")}}})]:[r("div",{staticClass:"tui-contentMarketplaceImportBasket__category"},[r("Select",{attrs:{id:t.$id("categorySelect"),"aria-label":t.$str("basket_select_category","totara_contentmarketplace"),"char-length":"15",options:t.options,required:!0,value:t.selectedCategory},on:{input:function(e){return t.$emit("category-change",e)}}})],1),t._v(" "),r("Button",{attrs:{disabled:n||!t.selectedCategory,styleclass:{primary:!0},text:t.$str("basket_go_to_review","totara_contentmarketplace")},on:{click:function(e){return t.$emit("reviewing-selection",!0)}}})]]}}])})}),[],!1,null,null,null);u(p),p.options.__hasBlocks={script:!0,template:!0};const _=p.exports},FcPZ:(t,e,r)=>{"use strict";r.r(e),r.d(e,{default:()=>i});const n={props:{count:{type:Number,required:!0},filters:Array},computed:{activeFilters(){if(!this.filters.length)return"";let t="";return this.filters.forEach(((e,r)=>{t+=0===r?this.$str("active_filter_first","totara_contentmarketplace",e):r===this.filters.length-1?this.$str("active_filter_last","totara_contentmarketplace",e):this.$str("active_filter","totara_contentmarketplace",e)})),t},formattedCount(){return this.count.toLocaleString()}}},o=function(t){t.options.__langStrings={totara_contentmarketplace:["active_filter","active_filter_first","active_filter_last","item_count","item_count_and_filters"]}};var a=(0,r("wWJ2").Z)(n,(function(){var t=this,e=t.$createElement;return(t._self._c||e)("div",{staticClass:"tui-contentMarketplaceImportCountAndFilters",attrs:{"aria-live":"polite"}},[t.activeFilters?[t._v("\n    "+t._s(t.$str("item_count_and_filters","totara_contentmarketplace",{count:t.formattedCount,filters:t.activeFilters}))+"\n  ")]:[t._v("\n    "+t._s(t.$str("item_count","totara_contentmarketplace",{count:t.formattedCount}))+"\n  ")]],2)}),[],!1,null,null,null);o(a),a.options.__hasBlocks={script:!0,template:!0};const i=a.exports},EAox:(t,e,r)=>{"use strict";r.r(e),r.d(e,{default:()=>u});const n=tui.require("tui/components/form/Label");var o=r.n(n),a=r("QcEE"),i=r.n(a);const s={components:{Label:o(),Select:i()},props:{options:{type:Array,required:!0},sortBy:{type:String,required:!0}}},l=function(t){t.options.__langStrings={totara_contentmarketplace:["filter_sort_by"]}};var c=(0,r("wWJ2").Z)(s,(function(){var t=this,e=t.$createElement,r=t._self._c||e;return r("div",{staticClass:"tui-contentMarketplaceImportSortFilter"},[r("Label",{staticClass:"tui-contentMarketplaceImportSortFilter__label",attrs:{"for-id":t.$id("sortBy"),label:t.$str("filter_sort_by","totara_contentmarketplace")}}),t._v(" "),r("Select",{attrs:{id:t.$id("sortBy"),"char-length":"10",options:t.options,value:t.sortBy},on:{input:function(e){return t.$emit("filter-change",e)}}})],1)}),[],!1,null,null,null);l(c),c.options.__hasBlocks={script:!0,template:!0};const u=c.exports},"/vxj":(t,e,r)=>{"use strict";r.r(e),r.d(e,{default:()=>d});var n=r("z1IF"),o=r.n(n),a=r("5Nvt"),i=r.n(a);const s=tui.require("tui/components/loading/Loader");var l=r.n(s);const c=tui.require("tui/components/layouts/PageHeading");var u=r.n(c);const p={components:{Grid:o(),GridItem:i(),Loader:l(),PageHeading:u()},props:{flush:Boolean,loading:Boolean,loadingRight:Boolean,stackAt:{type:Number,default:1e3},title:{required:!0,type:String},subTitle:String}};var _=(0,r("wWJ2").Z)(p,(function(){var t=this,e=t.$createElement,r=t._self._c||e;return r("div",{staticClass:"tui-contentMarketplacePageLayoutTwoColumn",class:{"tui-contentMarketplacePageLayoutTwoColumn--flush":t.flush}},[t._t("feedback-banner"),t._v(" "),t._t("user-overview"),t._v(" "),r("div",{staticClass:"tui-contentMarketplacePageLayoutTwoColumn__heading"},[t._t("content-nav"),t._v(" "),r("PageHeading",{attrs:{title:t.title},scopedSlots:t._u([{key:"buttons",fn:function(){return[t._t("header-buttons")]},proxy:!0}],null,!0)})],2),t._v(" "),t.subTitle?r("div",{staticClass:"tui-contentMarketplacePageLayoutTwoColumn__subHeading"},[t._v("\n    "+t._s(t.subTitle)+"\n  ")]):t._e(),t._v(" "),t._t("pre-body"),t._v(" "),r("Loader",{staticClass:"tui-contentMarketplacePageLayoutTwoColumn__body",attrs:{loading:t.loading}},[r("Grid",{attrs:{"stack-at":t.stackAt}},[r("GridItem",{attrs:{units:3}},[t._t("left-content")],2),t._v(" "),r("GridItem",{attrs:{units:9}},[r("Loader",{attrs:{loading:t.loadingRight}},[t._t("right-content")],2)],1)],1)],1),t._v(" "),t._t("modals")],2)}),[],!1,null,null,null);_.options.__hasBlocks={script:!0,template:!0};const d=_.exports},nqFD:(t,e,r)=>{"use strict";r.r(e),r.d(e,{default:()=>s});var n=r("IpiT");const o={components:{Button:r.n(n)()},props:{lastPage:Boolean}},a=function(t){t.options.__langStrings={totara_contentmarketplace:["load_more"]}};var i=(0,r("wWJ2").Z)(o,(function(){var t=this,e=t.$createElement,r=t._self._c||e;return r("div",{staticClass:"tui-contentMarketplaceImportReviewPaging"},[t.lastPage?t._e():r("Button",{attrs:{text:t.$str("load_more","totara_contentmarketplace")},on:{click:function(e){return t.$emit("next-page")}}})],1)}),[],!1,null,null,null);a(i),i.options.__hasBlocks={script:!0,template:!0};const s=i.exports},miDL:(t,e,r)=>{"use strict";r.r(e),r.d(e,{default:()=>i});const n=tui.require("tui/components/paging/Paging"),o={components:{Paging:r.n(n)()},props:{currentPage:{type:Number,required:!0},itemsPerPage:{type:Number,default:20},totalItems:{type:Number,required:!0}}};var a=(0,r("wWJ2").Z)(o,(function(){var t=this,e=t.$createElement,r=t._self._c||e;return t.totalItems?r("Paging",{staticClass:"tui-contentMarketplaceImportSelectionPaging",attrs:{"items-per-page":t.itemsPerPage,page:t.currentPage,"total-items":t.totalItems},on:{"count-change":function(e){return t.$emit("items-per-page-change",e)},"page-change":function(e){return t.$emit("page-change",e)}}}):t._e()}),[],!1,null,null,null);a.options.__hasBlocks={script:!0,template:!0};const i=a.exports},Cvfz:(t,e,r)=>{"use strict";r.r(e),r.d(e,{default:()=>p});var n=r("RJ4J"),o=r.n(n),a=r("Lo/q"),i=r.n(a),s=r("hkSA"),l=r.n(s);const c={components:{Cell:o(),HeaderCell:i(),SelectTable:l()},props:{items:{type:Array,required:!0},rowLabelKey:{type:String,required:!0},selectedItems:{type:Array,required:!0}}};var u=(0,r("wWJ2").Z)(c,(function(){var t=this,e=t.$createElement,r=t._self._c||e;return r("div",{staticClass:"tui-contentMarketplaceImportReviewTable"},[r("SelectTable",{attrs:{"border-bottom-hidden":!0,data:t.items,"hover-off":!0,"no-label-offset":!0,"row-label-key":t.rowLabelKey,"select-all-enabled":!0,"selected-highlight-off":!0,value:t.selectedItems},on:{input:function(e){return t.$emit("update",e)}},scopedSlots:t._u([{key:"header-row",fn:function(){return[r("HeaderCell",{attrs:{size:"12",valign:"center"}})]},proxy:!0},{key:"row",fn:function(e){var n=e.checked,o=e.row;return[r("Cell",{attrs:{size:"12"}},[t._t("row",null,{checked:n,row:o})],2)]}}],null,!0)})],1)}),[],!1,null,null,null);u.options.__hasBlocks={script:!0,template:!0};const p=u.exports},yM6j:(t,e,r)=>{"use strict";r.r(e),r.d(e,{default:()=>p});var n=r("RJ4J"),o=r.n(n),a=r("Lo/q"),i=r.n(a),s=r("hkSA"),l=r.n(s);const c={components:{Cell:o(),HeaderCell:i(),SelectTable:l()},props:{items:{type:Array,required:!0},rowLabelKey:{type:String,required:!0},selectedItems:{type:Array,required:!0}}};var u=(0,r("wWJ2").Z)(c,(function(){var t=this,e=t.$createElement,r=t._self._c||e;return r("div",{staticClass:"tui-contentMarketplaceImportSelectionTable"},[r("SelectTable",{attrs:{"border-bottom-hidden":!0,data:t.items,"hover-off":!0,"large-check-box":!0,"no-label-offset":!0,"row-label-key":t.rowLabelKey,"select-all-enabled":!0,"selected-highlight-off":!0,value:t.selectedItems},on:{input:function(e){return t.$emit("update",e)}},scopedSlots:t._u([{key:"header-row",fn:function(){return[r("HeaderCell",{attrs:{size:"12",valign:"center"}})]},proxy:!0},{key:"row",fn:function(e){var n=e.row;return[r("Cell",{attrs:{size:"12"}},[t._t("row",null,{row:n})],2)]}}],null,!0)})],1)}),[],!1,null,null,null);u.options.__hasBlocks={script:!0,template:!0};const p=u.exports},IYtA:(t,e,r)=>{"use strict";r.r(e),r.d(e,{default:()=>p});var n=r("RJ4J"),o=r.n(n),a=r("Lo/q"),i=r.n(a);const s=tui.require("tui/components/datatable/Table");var l=r.n(s);const c={components:{Cell:o(),HeaderCell:i(),Table:l()},props:{items:{type:Array,required:!0}}};var u=(0,r("wWJ2").Z)(c,(function(){var t=this,e=t.$createElement,r=t._self._c||e;return r("div",{staticClass:"tui-contentMarketplaceImportTable"},[r("Table",{attrs:{"border-bottom-hidden":!0,data:t.items},scopedSlots:t._u([{key:"header-row",fn:function(){return[t.$slots["row-header"]?r("HeaderCell",{attrs:{size:"12",valign:"center"}},[t._t("row-header")],2):t._e()]},proxy:!0},{key:"row",fn:function(e){var n=e.row;return[r("Cell",{attrs:{size:"12"}},[t._t("row",null,{row:n}),t._v(" "),r("a",{staticClass:"tui-contentMarketplaceImportTable__link",attrs:{role:"button",href:"#","aria-label":n.name},on:{click:function(e){return e.preventDefault(),t.$emit("select",n)}}})],2)]}}],null,!0)})],1)}),[],!1,null,null,null);u.options.__hasBlocks={script:!0,template:!0};const p=u.exports},XxKb:(t,e,r)=>{"use strict";r.r(e),r.d(e,{default:()=>b});const n=tui.require("tui/components/buttons/ButtonIcon");var o=r.n(n),a=r("z1IF"),i=r.n(a),s=r("5Nvt"),l=r.n(s);const c=tui.require("tui/components/collapsible/HideShow");var u=r.n(c);const p=tui.require("tui/components/layouts/LayoutOneColumn");var _=r.n(p);const d=tui.require("totara_contentmarketplace/components/layouts/PageLayoutTwoColumn");var m=r.n(d);const f=tui.require("tui/components/icons/Slider");var g=r.n(f);const v={components:{ButtonIcon:o(),Grid:i(),GridItem:l(),HideShow:u(),LayoutReview:_(),LayoutSelect:m(),SliderIcon:g()},props:{loading:Boolean,reviewTitle:String,reviewingSelection:Boolean,selectionTitle:{type:String,required:!0},selectionSubTitle:String}},y=function(t){t.options.__langStrings={totara_contentmarketplace:["a11y_filter_panel","a11y_import_page_reviewing","a11y_import_page_selecting","hide_filters","show_filters"]}};var k=(0,r("wWJ2").Z)(v,(function(){var t=this,e=t.$createElement,r=t._self._c||e;return r("div",{staticClass:"tui-contentMarketplaceImport"},[r("div",{staticClass:"sr-only",attrs:{"aria-atomic":"true","aria-live":"polite",role:"status"}},[t.reviewingSelection?[t._v("\n      "+t._s(t.$str("a11y_import_page_reviewing","totara_contentmarketplace"))+"\n    ")]:[t._v("\n      "+t._s(t.$str("a11y_import_page_selecting","totara_contentmarketplace"))+"\n    ")]],2),t._v(" "),t.reviewingSelection?r("LayoutReview",{attrs:{title:t.reviewTitle,loading:t.loading},scopedSlots:t._u([{key:"content-nav",fn:function(){return[t._t("content-nav")]},proxy:!0},{key:"pre-body",fn:function(){return[r("Grid",{attrs:{"stack-at":1150}},[r("GridItem",{attrs:{units:6}}),t._v(" "),r("GridItem",{attrs:{units:6}},[t._t("basket")],2)],1)]},proxy:!0},{key:"content",fn:function(){return[r("div",{staticClass:"tui-contentMarketplaceImport__body"},[t._t("review-table")],2)]},proxy:!0}],null,!0)}):r("LayoutSelect",{attrs:{title:t.selectionTitle,"sub-title":t.selectionSubTitle,"loading-right":t.loading,"stack-at":1150},scopedSlots:t._u([{key:"content-nav",fn:function(){return[t._t("content-nav")]},proxy:!0},t.$slots.basket?{key:"pre-body",fn:function(){return[r("Grid",{attrs:{"stack-at":1050}},[r("GridItem",{attrs:{units:6}}),t._v(" "),r("GridItem",{attrs:{units:6}},[t._t("basket")],2)],1)]},proxy:!0}:null,{key:"left-content",fn:function(){return[r("aside",{staticClass:"tui-contentMarketplaceImport__filters"},[r("HideShow",{attrs:{"aria-region-label":t.$str("a11y_filter_panel","totara_contentmarketplace"),"hide-content-text":t.$str("hide_filters","totara_contentmarketplace"),"mobile-only":!0,"show-content-text":t.$str("show_filters","totara_contentmarketplace"),sticky:!0},scopedSlots:t._u([{key:"trigger",fn:function(t){var e=t.controls,n=t.expanded,o=t.text,a=t.toggleContent;return[r("ButtonIcon",{staticClass:"tui-contentMarketplaceImport__filters-toggle",class:{"tui-contentMarketplaceImport__filters-toggleExpanded":n},attrs:{"aria-controls":e,"aria-label":!1,styleclass:{transparent:!0},text:o},on:{click:a}},[r("SliderIcon")],1)]}},{key:"content",fn:function(){return[r("div",{staticClass:"tui-contentMarketplaceImport__filters-content"},[t._t("primary-filter"),t._v(" "),t._t("filters",null,{contentId:"contentMarketplaceImportBody"})],2)]},proxy:!0}],null,!0)})],1)]},proxy:!0},{key:"right-content",fn:function(){return[r("div",{staticClass:"tui-contentMarketplaceImport__body",attrs:{id:"contentMarketplaceImportBody",tabindex:"-1"}},[r("Grid",{attrs:{"stack-at":600}},[r("GridItem",{staticClass:"tui-contentMarketplaceImport__summary-gridItem",attrs:{units:8}},[t._t("summary-count")],2),t._v(" "),r("GridItem",{staticClass:"tui-contentMarketplaceImport__summary-gridItem",attrs:{units:4}},[t._t("summary-sort")],2)],1),t._v(" "),t._t("select-table")],2)]},proxy:!0}],null,!0)})],1)}),[],!1,null,null,null);y(k),k.options.__hasBlocks={script:!0,template:!0};const b=k.exports},wWJ2:(t,e,r)=>{"use strict";function n(t,e,r,n,o,a,i,s){var l,c="function"==typeof t?t.options:t;if(e&&(c.render=e,c.staticRenderFns=r,c._compiled=!0),n&&(c.functional=!0),a&&(c._scopeId="data-v-"+a),i?(l=function(t){(t=t||this.$vnode&&this.$vnode.ssrContext||this.parent&&this.parent.$vnode&&this.parent.$vnode.ssrContext)||"undefined"==typeof __VUE_SSR_CONTEXT__||(t=__VUE_SSR_CONTEXT__),o&&o.call(this,t),t&&t._registeredComponents&&t._registeredComponents.add(i)},c._ssrRegister=l):o&&(l=s?function(){o.call(this,(c.functional?this.parent:this).$root.$options.shadowRoot)}:o),l)if(c.functional){c._injectStyles=l;var u=c.render;c.render=function(t,e){return l.call(e),u(t,e)}}else{var p=c.beforeCreate;c.beforeCreate=p?[].concat(p,l):[l]}return{exports:t,options:c}}r.d(e,{Z:()=>n})},IpiT:t=>{"use strict";t.exports=tui.require("tui/components/buttons/Button")},RJ4J:t=>{"use strict";t.exports=tui.require("tui/components/datatable/Cell")},"Lo/q":t=>{"use strict";t.exports=tui.require("tui/components/datatable/HeaderCell")},hkSA:t=>{"use strict";t.exports=tui.require("tui/components/datatable/SelectTable")},QcEE:t=>{"use strict";t.exports=tui.require("tui/components/form/Select")},"5Nvt":t=>{"use strict";t.exports=tui.require("tui/components/grid/GridItem")},z1IF:t=>{"use strict";t.exports=tui.require("tui/components/grid/Grid")}},e={};function r(n){var o=e[n];if(void 0!==o)return o.exports;var a=e[n]={exports:{}};return t[n](a,a.exports,r),a.exports}r.n=t=>{var e=t&&t.__esModule?()=>t.default:()=>t;return r.d(e,{a:e}),e},r.d=(t,e)=>{for(var n in e)r.o(e,n)&&!r.o(t,n)&&Object.defineProperty(t,n,{enumerable:!0,get:e[n]})},r.o=(t,e)=>Object.prototype.hasOwnProperty.call(t,e),r.r=t=>{"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(t,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(t,"__esModule",{value:!0})},function(){"use strict";"undefined"!=typeof tui&&tui._bundle.isLoaded("totara_contentmarketplace")?console.warn('[tui bundle] The bundle "totara_contentmarketplace" is already loaded, skipping initialisation.'):(tui._bundle.register("totara_contentmarketplace"),tui._bundle.addModulesFromContext("totara_contentmarketplace/components",r("o64i")),tui._bundle.addModulesFromContext("totara_contentmarketplace/pages",r("Rvhv")))}()})();