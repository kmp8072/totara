(()=>{var t={uPXB:(t,e,n)=>{var r={"./layouts/LayoutBannerSidepanelTwoColumn":"yEW0","./layouts/LayoutBannerSidepanelTwoColumn.vue":"yEW0","./layouts/LayoutBannerTwoColumn":"emuI","./layouts/LayoutBannerTwoColumn.vue":"emuI","./outer_layouts/OuterLayoutBanner":"jdK7","./outer_layouts/OuterLayoutBanner.vue":"jdK7","./outer_layouts/OuterLayoutBannerSidepanel":"TOU3","./outer_layouts/OuterLayoutBannerSidepanel.vue":"TOU3"};function a(t){var e=i(t);return n(e)}function i(t){if(!n.o(r,t)){var e=new Error("Cannot find module '"+t+"'");throw e.code="MODULE_NOT_FOUND",e}return r[t]}a.keys=function(){return Object.keys(r)},a.resolve=i,t.exports=a,a.id="uPXB"},sxRu:(t,e,n)=>{var r={"./constants":"QSEf","./constants.js":"QSEf"};function a(t){var e=i(t);return n(e)}function i(t){if(!n.o(r,t)){var e=new Error("Cannot find module '"+t+"'");throw e.code="MODULE_NOT_FOUND",e}return r[t]}a.keys=function(){return Object.keys(r)},a.resolve=i,t.exports=a,a.id="sxRu"},l8Tl:(t,e,n)=>{var r={"./ContentMarketplaceModules":"tXTW","./ContentMarketplaceModules.vue":"tXTW"};function a(t){var e=i(t);return n(e)}function i(t){if(!n.o(r,t)){var e=new Error("Cannot find module '"+t+"'");throw e.code="MODULE_NOT_FOUND",e}return r[t]}a.keys=function(){return Object.keys(r)},a.resolve=i,t.exports=a,a.id="l8Tl"},yEW0:(t,e,n)=>{"use strict";n.r(e),n.d(e,{default:()=>f});const r=tui.require("mod_contentmarketplace/components/outer_layouts/OuterLayoutBannerSidepanel");var a=n.n(r),i=n("z1IF"),o=n.n(i),s=n("5Nvt"),u=n.n(s),l=n("YQTe"),d=n.n(l),c=n("dyC4"),m=n.n(c),p=n("H4QJ"),_=n.n(p);const g={components:{BannerLayout:a(),Grid:o(),GridItem:u(),Loader:d(),PageHeading:m(),Responsive:_()},props:{bannerImageUrl:[Boolean,String],loadingFullPage:Boolean,loadingMainContent:Boolean,title:{required:!0,type:String}},data:()=>({boundaryDefaults:{small:{gridDirection:"vertical",gridUnitsLeft:24,gridUnitsRight:24},medium:{gridDirection:"horizontal",gridUnitsLeft:16,gridUnitsRight:8},large:{gridDirection:"horizontal",gridUnitsLeft:17,gridUnitsRight:7},xLarge:{gridDirection:"horizontal",gridUnitsLeft:18,gridUnitsRight:6}},currentBoundary:"xLarge"}),computed:{gridDirection(){if(this.currentBoundary)return this.boundaryDefaults[this.currentBoundary].gridDirection},gridUnitsLeft(){if(this.currentBoundary)return this.boundaryDefaults[this.currentBoundary].gridUnitsLeft},gridUnitsRight(){if(this.currentBoundary)return this.boundaryDefaults[this.currentBoundary].gridUnitsRight},stacked(){return"vertical"===this.gridDirection}},methods:{resize(t){this.currentBoundary=t}}};var y=(0,n("wWJ2").Z)(g,(function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("BannerLayout",{staticClass:"tui-marketplaceLayoutBannerSidepanelTwoColumn",attrs:{"banner-image-url":t.bannerImageUrl,loading:t.loadingFullPage},scopedSlots:t._u([{key:"modals",fn:function(){return[t._t("modals")]},proxy:!0},{key:"side-panel",fn:function(e){var r=e.outerStacked;return[n("aside",{staticClass:"tui-marketplaceLayoutBannerSidepanelTwoColumn__sidePanel"},[t._t("side-panel",null,{stacked:r})],2)]}},t.$scopedSlots["banner-content"]?{key:"banner-content",fn:function(e){var n=e.outerStacked;return[t._t("banner-content",null,{stacked:n})]}}:null,{key:"main-content",fn:function(){return[n("Loader",{staticClass:"tui-marketplaceLayoutBannerSidepanelTwoColumn__inner",attrs:{loading:t.loadingMainContent}},[n("Responsive",{attrs:{breakpoints:[{name:"small",boundaries:[0,852]},{name:"medium",boundaries:[850,972]},{name:"large",boundaries:[970,1122]},{name:"xLarge",boundaries:[1120,1681]}]},on:{"responsive-resize":t.resize}},[n("Grid",{staticClass:"tui-marketplaceLayoutBannerSidepanelTwoColumn__grid",class:{"tui-marketplaceLayoutBannerSidepanelTwoColumn__grid--stacked":t.stacked},attrs:{direction:t.gridDirection,"max-units":24}},[n("GridItem",{staticClass:"tui-marketplaceLayoutBannerSidepanelTwoColumn__main",attrs:{units:t.gridUnitsLeft}},[t._t("feedback-banner"),t._v(" "),t._t("user-overview"),t._v(" "),n("div",{staticClass:"tui-marketplaceLayoutBannerSidepanelTwoColumn__heading"},[t._t("content-nav"),t._v(" "),n("PageHeading",{attrs:{title:t.title},scopedSlots:t._u([{key:"buttons",fn:function(){return[t._t("header-buttons")]},proxy:!0}],null,!0)})],2),t._v(" "),t._t("main-content")],2),t._v(" "),n("GridItem",{staticClass:"tui-marketplaceLayoutBannerSidepanelTwoColumn__side",attrs:{units:t.gridUnitsRight}},[t._t("side-content")],2)],1)],1)],1)]},proxy:!0}],null,!0)})}),[],!1,null,null,null);y.options.__hasBlocks={script:!0,template:!0};const f=y.exports},emuI:(t,e,n)=>{"use strict";n.r(e),n.d(e,{default:()=>f});const r=tui.require("mod_contentmarketplace/components/outer_layouts/OuterLayoutBanner");var a=n.n(r),i=n("z1IF"),o=n.n(i),s=n("5Nvt"),u=n.n(s),l=n("YQTe"),d=n.n(l),c=n("dyC4"),m=n.n(c),p=n("H4QJ"),_=n.n(p);const g={components:{BannerLayout:a(),Grid:o(),GridItem:u(),Loader:d(),PageHeading:m(),Responsive:_()},props:{bannerImageUrl:[Boolean,String],loadingFullPage:Boolean,loadingMainContent:Boolean,title:{required:!0,type:String}},data:()=>({boundaryDefaults:{small:{gridDirection:"vertical",gridUnitsLeft:24,gridUnitsRight:24},medium:{gridDirection:"horizontal",gridUnitsLeft:16,gridUnitsRight:8},large:{gridDirection:"horizontal",gridUnitsLeft:17,gridUnitsRight:7},xLarge:{gridDirection:"horizontal",gridUnitsLeft:18,gridUnitsRight:6}},currentBoundary:"xLarge"}),computed:{gridDirection(){if(this.currentBoundary)return this.boundaryDefaults[this.currentBoundary].gridDirection},gridUnitsLeft(){if(this.currentBoundary)return this.boundaryDefaults[this.currentBoundary].gridUnitsLeft},gridUnitsRight(){if(this.currentBoundary)return this.boundaryDefaults[this.currentBoundary].gridUnitsRight},stacked(){return"vertical"===this.gridDirection}},methods:{resize(t){this.currentBoundary=t}}};var y=(0,n("wWJ2").Z)(g,(function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("BannerLayout",{attrs:{"banner-image-url":t.bannerImageUrl,loading:t.loadingFullPage},scopedSlots:t._u([{key:"modals",fn:function(){return[t._t("modals")]},proxy:!0},t.$scopedSlots["banner-content"]?{key:"banner-content",fn:function(){return[t._t("banner-content",null,{stacked:t.stacked})]},proxy:!0}:null,{key:"main-content",fn:function(){return[n("Loader",{staticClass:"tui-marketplaceLayoutBannerTwoColumn__inner",attrs:{loading:t.loadingMainContent}},[n("Responsive",{attrs:{breakpoints:[{name:"small",boundaries:[0,852]},{name:"medium",boundaries:[850,972]},{name:"large",boundaries:[970,1122]},{name:"xLarge",boundaries:[1120,1681]}]},on:{"responsive-resize":t.resize}},[n("Grid",{staticClass:"tui-marketplaceLayoutBannerTwoColumn__grid",class:{"tui-marketplaceLayoutBannerTwoColumn__grid--stacked":t.stacked},attrs:{direction:t.gridDirection,"max-units":24}},[n("GridItem",{staticClass:"tui-marketplaceLayoutBannerTwoColumn__main",attrs:{units:t.gridUnitsLeft}},[t._t("feedback-banner"),t._v(" "),t._t("user-overview"),t._v(" "),n("div",{staticClass:"tui-marketplaceLayoutBannerTwoColumn__heading"},[t._t("content-nav"),t._v(" "),n("PageHeading",{attrs:{title:t.title},scopedSlots:t._u([{key:"buttons",fn:function(){return[t._t("header-buttons")]},proxy:!0}],null,!0)})],2),t._v(" "),t._t("main-content")],2),t._v(" "),n("GridItem",{staticClass:"tui-marketplaceLayoutBannerTwoColumn__side",attrs:{units:t.gridUnitsRight}},[t._t("side-content")],2)],1)],1)],1)]},proxy:!0}],null,!0)})}),[],!1,null,null,null);y.options.__hasBlocks={script:!0,template:!0};const f=y.exports},jdK7:(t,e,n)=>{"use strict";n.r(e),n.d(e,{default:()=>c});var r=n("z1IF"),a=n.n(r),i=n("5Nvt"),o=n.n(i),s=n("YQTe"),u=n.n(s);const l={components:{Grid:a(),GridItem:o(),Loader:u()},props:{bannerImageUrl:[Boolean,String],loading:Boolean},computed:{bannerImage(){let t=this.bannerImageUrl;return t&&null!==t?'url("'+encodeURI(t)+'")':""}}};var d=(0,n("wWJ2").Z)(l,(function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("div",{staticClass:"tui-marketplaceOuterLayoutBanner"},[n("Loader",{attrs:{loading:t.loading}},[n("Grid",{attrs:{"max-units":24,"use-vertical-gap":!1}},[n("GridItem",{attrs:{units:24}},[n("div",{staticClass:"tui-marketplaceOuterLayoutBanner__banner"},[n("div",{staticClass:"tui-marketplaceOuterLayoutBanner__banner-image",style:{"background-image":t.bannerImage}}),t._v(" "),t.$scopedSlots["banner-content"]?n("div",{staticClass:"tui-marketplaceOuterLayoutBanner__banner-content"},[n("div",{staticClass:"tui-marketplaceOuterLayoutBanner__banner-contentArea"},[t._t("banner-content",null,{outerStacked:!1})],2)]):t._e()]),t._v(" "),n("div",{staticClass:"tui-marketplaceOuterLayoutBanner__body"},[t._t("main-content",null,{outerStacked:!1})],2)])],1)],1),t._v(" "),t._t("modals")],2)}),[],!1,null,null,null);d.options.__hasBlocks={script:!0,template:!0};const c=d.exports},TOU3:(t,e,n)=>{"use strict";n.r(e),n.d(e,{default:()=>p});var r=n("z1IF"),a=n.n(r),i=n("5Nvt"),o=n.n(i),s=n("YQTe"),u=n.n(s),l=n("H4QJ"),d=n.n(l);const c={components:{Grid:a(),GridItem:o(),Loader:u(),Responsive:d()},props:{bannerImageUrl:[Boolean,String],loading:Boolean},data:()=>({boundaryDefaults:{small:{gridDirection:"vertical",gridUnitsLeft:12,gridUnitsRight:12},medium:{gridDirection:"horizontal",gridUnitsLeft:6,gridUnitsRight:18},large:{gridDirection:"horizontal",gridUnitsLeft:5,gridUnitsRight:19}},breakpoints:[{name:"small",boundaries:[0,1167]},{name:"medium",boundaries:[1165,1422]},{name:"large",boundaries:[1420,1681]}],currentBoundary:"large"}),computed:{bannerImage(){let t=this.bannerImageUrl;return t&&null!==t?'url("'+encodeURI(t)+'")':""},gridDirection(){if(this.currentBoundary)return this.boundaryDefaults[this.currentBoundary].gridDirection},gridUnitsLeft(){if(this.currentBoundary)return this.boundaryDefaults[this.currentBoundary].gridUnitsLeft},gridUnitsRight(){if(this.currentBoundary)return this.boundaryDefaults[this.currentBoundary].gridUnitsRight},stacked(){return"vertical"===this.gridDirection}},methods:{resize(t){this.currentBoundary=t}}};var m=(0,n("wWJ2").Z)(c,(function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("div",{staticClass:"tui-marketplaceOuterLayoutBannerSidepanel"},[n("Loader",{attrs:{loading:t.loading}},[n("Responsive",{attrs:{breakpoints:t.breakpoints},on:{"responsive-resize":t.resize}},[n("Grid",{attrs:{direction:t.gridDirection,"max-units":24,"use-vertical-gap":!1}},[n("GridItem",{attrs:{units:t.gridUnitsLeft}},[t._t("side-panel",null,{outerStacked:t.stacked})],2),t._v(" "),n("GridItem",{staticClass:"tui-marketplaceOuterLayoutBannerSidepanel__right",attrs:{units:t.gridUnitsRight}},[n("div",{staticClass:"tui-marketplaceOuterLayoutBannerSidepanel__banner"},[n("div",{staticClass:"tui-marketplaceOuterLayoutBannerSidepanel__banner-image",style:{"background-image":t.bannerImage}}),t._v(" "),t.$scopedSlots["banner-content"]?n("div",{staticClass:"tui-marketplaceOuterLayoutBannerSidepanel__banner-content"},[n("div",{staticClass:"tui-marketplaceOuterLayoutBannerSidepanel__banner-contentArea"},[t._t("banner-content",null,{outerStacked:t.stacked})],2)]):t._e()]),t._v(" "),n("div",{staticClass:"tui-marketplaceOuterLayoutBannerSidepanel__body"},[t._t("main-content",null,{outerStacked:t.stacked})],2)])],1)],1)],1),t._v(" "),t._t("modals")],2)}),[],!1,null,null,null);m.options.__hasBlocks={script:!0,template:!0};const p=m.exports},tXTW:(t,e,n)=>{"use strict";n.r(e),n.d(e,{default:()=>_});const r=tui.require("tui/components/layouts/LayoutOneColumn");var a=n.n(r);const i=tui.require("tui/components/datatable/Table");var o=n.n(i);const s=tui.require("tui/components/datatable/HeaderCell");var u=n.n(s);const l=tui.require("tui/components/datatable/Cell");var d=n.n(l);const c={components:{LayoutOneColumn:a(),Table:o(),HeaderCell:u(),Cell:d()},props:{marketplaceRecords:{type:Array,required:!0,validator:t=>t.every((t=>"name"in t&&"component_name"in t&&"cm_id"in t))},heading:{type:String,required:!0}}},m=function(t){t.options.__langStrings={core:["name"],mod_contentmarketplace:["marketplace_component"]}};var p=(0,n("wWJ2").Z)(c,(function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("LayoutOneColumn",{attrs:{title:t.heading},scopedSlots:t._u([{key:"content",fn:function(){return[n("Table",{attrs:{data:t.marketplaceRecords},scopedSlots:t._u([{key:"header-row",fn:function(){return[n("HeaderCell",[t._v("\n          "+t._s(t.$str("name","core"))+"\n        ")]),t._v(" "),n("HeaderCell",[t._v("\n          "+t._s(t.$str("marketplace_component","mod_contentmarketplace"))+"\n        ")])]},proxy:!0},{key:"row",fn:function(e){var r=e.row;return[n("Cell",{attrs:{"column-header":t.$str("name","core")}},[n("a",{attrs:{href:t.$url("/mod/contentmarketplace/view.php",{id:r.cm_id})}},[t._v("\n            "+t._s(r.name)+"\n          ")])]),t._v(" "),n("Cell",{attrs:{"column-header":t.$str("marketplace_component","mod_contentmarketplace")}},[t._v("\n          "+t._s(r.component_name)+"\n        ")])]}}])})]},proxy:!0}])})}),[],!1,null,null,null);m(p),p.options.__hasBlocks={script:!0,template:!0};const _=p.exports},QSEf:(t,e,n)=>{"use strict";n.r(e),n.d(e,{COMPLETION_CONDITION_CONTENT_MARKETPLACE:()=>s,COMPLETION_STATUS_INCOMPLETE:()=>o,COMPLETION_STATUS_UNKNOWN:()=>i,COMPLETION_TRACKING_MANUAL:()=>a,COMPLETION_TRACKING_NONE:()=>r});const r="tracking_none",a="tracking_manual",i="unknown",o="incomplete",s="CONTENT_MARKETPLACE"},wWJ2:(t,e,n)=>{"use strict";function r(t,e,n,r,a,i,o,s){var u,l="function"==typeof t?t.options:t;if(e&&(l.render=e,l.staticRenderFns=n,l._compiled=!0),r&&(l.functional=!0),i&&(l._scopeId="data-v-"+i),o?(u=function(t){(t=t||this.$vnode&&this.$vnode.ssrContext||this.parent&&this.parent.$vnode&&this.parent.$vnode.ssrContext)||"undefined"==typeof __VUE_SSR_CONTEXT__||(t=__VUE_SSR_CONTEXT__),a&&a.call(this,t),t&&t._registeredComponents&&t._registeredComponents.add(o)},l._ssrRegister=u):a&&(u=s?function(){a.call(this,(l.functional?this.parent:this).$root.$options.shadowRoot)}:a),u)if(l.functional){l._injectStyles=u;var d=l.render;l.render=function(t,e){return u.call(e),d(t,e)}}else{var c=l.beforeCreate;l.beforeCreate=c?[].concat(c,u):[u]}return{exports:t,options:l}}n.d(e,{Z:()=>r})},"5Nvt":t=>{"use strict";t.exports=tui.require("tui/components/grid/GridItem")},z1IF:t=>{"use strict";t.exports=tui.require("tui/components/grid/Grid")},dyC4:t=>{"use strict";t.exports=tui.require("tui/components/layouts/PageHeading")},YQTe:t=>{"use strict";t.exports=tui.require("tui/components/loading/Loader")},H4QJ:t=>{"use strict";t.exports=tui.require("tui/components/responsive/Responsive")}},e={};function n(r){var a=e[r];if(void 0!==a)return a.exports;var i=e[r]={exports:{}};return t[r](i,i.exports,n),i.exports}n.n=t=>{var e=t&&t.__esModule?()=>t.default:()=>t;return n.d(e,{a:e}),e},n.d=(t,e)=>{for(var r in e)n.o(e,r)&&!n.o(t,r)&&Object.defineProperty(t,r,{enumerable:!0,get:e[r]})},n.o=(t,e)=>Object.prototype.hasOwnProperty.call(t,e),n.r=t=>{"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(t,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(t,"__esModule",{value:!0})},function(){"use strict";"undefined"!=typeof tui&&tui._bundle.isLoaded("mod_contentmarketplace")?console.warn('[tui bundle] The bundle "mod_contentmarketplace" is already loaded, skipping initialisation.'):(tui._bundle.register("mod_contentmarketplace"),tui._bundle.addModulesFromContext("mod_contentmarketplace",n("sxRu")),tui._bundle.addModulesFromContext("mod_contentmarketplace/components",n("uPXB")),tui._bundle.addModulesFromContext("mod_contentmarketplace/pages",n("l8Tl")))}()})();