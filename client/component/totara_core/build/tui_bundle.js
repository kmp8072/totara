(()=>{var e={aOQU:(e,t,n)=>{var r={"./adder/LearningAdder":"L9CH","./adder/LearningAdder.vue":"L9CH","./performelement_linked_review/learning/AdminEdit":"Y9BB","./performelement_linked_review/learning/AdminEdit.vue":"Y9BB","./performelement_linked_review/learning/AdminView":"OGOV","./performelement_linked_review/learning/AdminView.vue":"OGOV","./performelement_linked_review/learning/ParticipantContent":"8Jkj","./performelement_linked_review/learning/ParticipantContent.vue":"8Jkj","./performelement_linked_review/learning/ParticipantContentPicker":"VIhv","./performelement_linked_review/learning/ParticipantContentPicker.vue":"VIhv"};function i(e){var t=a(e);return n(t)}function a(e){if(!n.o(r,e)){var t=new Error("Cannot find module '"+e+"'");throw t.code="MODULE_NOT_FOUND",t}return r[e]}i.keys=function(){return Object.keys(r)},i.resolve=a,e.exports=i,i.id="aOQU"},L9CH:(e,t,n)=>{"use strict";n.r(t),n.d(t,{default:()=>S});const r=tui.require("tui/components/adder/Adder");var i=n.n(r);const a=tui.require("tui/components/datatable/Cell");var s=n.n(a);const o=tui.require("tui/components/filters/FilterBar");var l=n.n(o);const c=tui.require("tui/components/datatable/HeaderCell");var u=n.n(c);const d=tui.require("tui/components/filters/SearchFilter");var _=n.n(d);const m=tui.require("tui/components/filters/SelectFilter");var p=n.n(m);const g=tui.require("tui/components/datatable/SelectTable");var v=n.n(g);const h={kind:"Document",definitions:[{kind:"OperationDefinition",operation:"query",name:{kind:"Name",value:"totara_core_user_learning_items"},variableDefinitions:[{kind:"VariableDefinition",variable:{kind:"Variable",name:{kind:"Name",value:"input"}},type:{kind:"NonNullType",type:{kind:"NamedType",name:{kind:"Name",value:"totara_core_user_learning_items_input"}}},directives:[]}],directives:[],selectionSet:{kind:"SelectionSet",selections:[{kind:"Field",name:{kind:"Name",value:"totara_core_user_learning_items"},arguments:[{kind:"Argument",name:{kind:"Name",value:"input"},value:{kind:"Variable",name:{kind:"Name",value:"input"}}}],directives:[],selectionSet:{kind:"SelectionSet",selections:[{kind:"Field",name:{kind:"Name",value:"items"},arguments:[],directives:[],selectionSet:{kind:"SelectionSet",selections:[{kind:"Field",name:{kind:"Name",value:"id"},arguments:[],directives:[]},{kind:"Field",name:{kind:"Name",value:"itemtype"},arguments:[],directives:[]},{kind:"Field",name:{kind:"Name",value:"fullname"},arguments:[{kind:"Argument",name:{kind:"Name",value:"format"},value:{kind:"EnumValue",value:"PLAIN"}}],directives:[]},{kind:"Field",name:{kind:"Name",value:"description"},arguments:[{kind:"Argument",name:{kind:"Name",value:"format"},value:{kind:"EnumValue",value:"HTML"}}],directives:[]},{kind:"Field",name:{kind:"Name",value:"progress"},arguments:[],directives:[]},{kind:"Field",name:{kind:"Name",value:"image_src"},arguments:[],directives:[]},{kind:"Field",name:{kind:"Name",value:"url_view"},arguments:[],directives:[]},{kind:"Field",name:{kind:"Name",value:"unique_id"},arguments:[],directives:[]}]}},{kind:"Field",name:{kind:"Name",value:"next_cursor"},arguments:[],directives:[]},{kind:"Field",name:{kind:"Name",value:"total"},arguments:[],directives:[]}]}}]}}]},k={kind:"Document",definitions:[{kind:"OperationDefinition",operation:"query",name:{kind:"Name",value:"totara_core_user_learning_items_selected"},variableDefinitions:[{kind:"VariableDefinition",variable:{kind:"Variable",name:{kind:"Name",value:"input"}},type:{kind:"NonNullType",type:{kind:"NamedType",name:{kind:"Name",value:"totara_core_user_learning_items_input"}}},directives:[]}],directives:[],selectionSet:{kind:"SelectionSet",selections:[{kind:"Field",name:{kind:"Name",value:"totara_core_user_learning_items_selected"},arguments:[{kind:"Argument",name:{kind:"Name",value:"input"},value:{kind:"Variable",name:{kind:"Name",value:"input"}}}],directives:[],selectionSet:{kind:"SelectionSet",selections:[{kind:"Field",name:{kind:"Name",value:"items"},arguments:[],directives:[],selectionSet:{kind:"SelectionSet",selections:[{kind:"Field",name:{kind:"Name",value:"id"},arguments:[],directives:[]},{kind:"Field",name:{kind:"Name",value:"itemtype"},arguments:[],directives:[]},{kind:"Field",name:{kind:"Name",value:"fullname"},arguments:[{kind:"Argument",name:{kind:"Name",value:"format"},value:{kind:"EnumValue",value:"PLAIN"}}],directives:[]},{kind:"Field",name:{kind:"Name",value:"description"},arguments:[{kind:"Argument",name:{kind:"Name",value:"format"},value:{kind:"EnumValue",value:"HTML"}}],directives:[]},{kind:"Field",name:{kind:"Name",value:"progress"},arguments:[],directives:[]},{kind:"Field",name:{kind:"Name",value:"image_src"},arguments:[],directives:[]},{kind:"Field",name:{kind:"Name",value:"url_view"},arguments:[],directives:[]},{kind:"Field",name:{kind:"Name",value:"unique_id"},arguments:[],directives:[]}]}},{kind:"Field",name:{kind:"Name",value:"next_cursor"},arguments:[],directives:[]},{kind:"Field",name:{kind:"Name",value:"total"},arguments:[],directives:[]}]}}]}}]},f=tui.require("tui/util"),y="COURSE",b={components:{Adder:i(),Cell:s(),FilterBar:l(),HeaderCell:u(),SearchFilter:_(),SelectFilter:p(),SelectTable:v()},props:{existingItems:{type:Array,default:()=>[]},open:Boolean,customQuery:Object,customQueryKey:String,showLoadingBtn:Boolean,userId:Number},data(){return{learningItems:null,learningSelectedItems:[],searchFilter:"",nextPage:!1,skipQueries:!0,searchDebounce:"",learningTypeFilter:y,learningTypeFilterOptions:[{id:"COURSE",label:this.$str("learning_type_course","totara_core")},{id:"CERTIFICATION",label:this.$str("learning_type_certification","totara_core")},{id:"PROGRAM",label:this.$str("learning_type_program","totara_core")}],progressFilter:null,progressOptions:[{id:null,label:this.$str("all","totara_core")},{id:"COMPLETED",label:this.$str("completed","core_completion")},{id:"IN_PROGRESS",label:this.$str("inprogress","core_completion")},{id:"NOT_STARTED",label:this.$str("statusnotstarted","core_completion")},{id:"NOT_TRACKED",label:this.$str("statusnottracked","core_completion")}],typeValue:"COURSE"}},watch:{open(){this.open?(this.searchDebounce="",this.skipQueries=!1):this.skipQueries=!0},searchDebounce(e){this.updateFilterDebounced(e)}},created(){this.$apollo.addSmartQuery("learningItems",{query:this.customQuery?this.customQuery:h,skip(){return this.skipQueries},variables(){return{input:{filters:{search:this.searchFilter,type:this.learningTypeFilter,progress:this.progressFilter},user_id:this.userId}}},update({[this.customQueryKey?this.customQueryKey:"totara_core_user_learning_items"]:e}){return this.nextPage=!!e.next_cursor&&e.next_cursor,e}}),this.$apollo.addSmartQuery("selectedLearning",{query:this.customQuery?this.customQuery:k,skip(){return this.skipQueries},variables(){return{input:{filters:{ids:[]},user_id:this.userId}}},update({[this.customQueryKey?this.customQueryKey:"totara_core_user_learning_items_selected"]:e}){return this.learningSelectedItems=e.items,e}})},methods:{async loadMoreItems(){this.nextPage&&this.$apollo.queries.learningItems.fetchMore({variables:{input:{cursor:this.nextPage,filters:{search:this.searchFilter,type:this.learningTypeFilter,progress:this.progressFilter},user_id:this.userId}},updateQuery:(e,{fetchMoreResult:t})=>{const n=e.totara_core_user_learning_items,r=t.totara_core_user_learning_items,i=n.items.concat(r.items);return{[this.customQueryKey?this.customQueryKey:"totara_core_user_learning_items"]:{items:i,next_cursor:r.next_cursor}}}})},async closeWithData(e){let t;this.$emit("add-button-clicked");try{t=await this.updateSelectedItems(e)}catch(e){return void console.error(e)}this.$emit("added",{ids:e,data:t})},closeModal(){this.learningTypeFilter=y,this.progressFilter=null,this.$emit("cancel")},async updateSelectedItems(e){const t=e.length;try{await this.$apollo.queries.selectedLearning.refetch({input:{filters:{ids:e},result_size:t,user_id:this.userId}})}catch(e){console.error(e)}return this.learningSelectedItems},updateFilterDebounced:(0,f.debounce)((function(e){this.searchFilter=e}),500),typeName(e){if(!e)return this.$str("learning_type_unknown","totara_core");let t=this.$str("learning_type_"+e,"totara_core");return t||(t=this.$str("learning_type_unknown","totara_core")),t}}},w=function(e){e.options.__langStrings={core:["no","yes","xpercent"],core_completion:["completed","inprogress","statusnotstarted","statusnottracked"],totara_core:["all","filter_learning","filter_learning_search_label","header_learning_name","header_learning_type","header_learning_progress","learning_type_certification","learning_type_course","learning_type_program","learning_type_unknown","search","select_learning"]}};var C=(0,n("wWJ2").Z)(b,(function(){var e=this,t=e.$createElement,n=e._self._c||t;return n("Adder",{attrs:{open:e.open,title:e.$str("select_learning","totara_core"),"existing-items":e.existingItems,loading:e.$apollo.loading,"show-load-more":e.nextPage,"show-loading-btn":e.showLoadingBtn},on:{added:function(t){return e.closeWithData(t)},cancel:e.closeModal,"load-more":e.loadMoreItems,"selected-tab-active":function(t){return e.updateSelectedItems(t)}},scopedSlots:e._u([{key:"browse-filters",fn:function(){return[n("FilterBar",{attrs:{"has-top-bar":!1,title:e.$str("filter_learning","totara_core")},scopedSlots:e._u([{key:"filters-left",fn:function(t){var r=t.stacked;return[n("SelectFilter",{attrs:{label:e.$str("header_learning_type","totara_core"),"show-label":!0,options:e.learningTypeFilterOptions,stacked:r},model:{value:e.learningTypeFilter,callback:function(t){e.learningTypeFilter=t},expression:"learningTypeFilter"}}),e._v(" "),n("SelectFilter",{attrs:{label:e.$str("header_learning_progress","totara_core"),"show-label":!0,options:e.progressOptions,stacked:r},model:{value:e.progressFilter,callback:function(t){e.progressFilter=t},expression:"progressFilter"}})]}},{key:"filters-right",fn:function(t){var r=t.stacked;return[n("SearchFilter",{attrs:{label:e.$str("filter_learning_search_label","totara_core"),"show-label":!1,placeholder:e.$str("search","totara_core"),stacked:r},model:{value:e.searchDebounce,callback:function(t){e.searchDebounce=t},expression:"searchDebounce"}})]}}])})]},proxy:!0},{key:"browse-list",fn:function(t){var r=t.disabledItems,i=t.selectedItems,a=t.update;return[n("SelectTable",{attrs:{"large-check-box":!0,"no-label-offset":!0,value:i,data:e.learningItems&&e.learningItems.items?e.learningItems.items:[],"disabled-ids":r,"checkbox-v-align":"center","select-all-enabled":!0,"border-bottom-hidden":!0,"get-id":function(e,t){return"unique_id"in e?e.unique_id:t}},on:{input:function(e){return a(e)}},scopedSlots:e._u([{key:"header-row",fn:function(){return[n("HeaderCell",{attrs:{size:"5",valign:"center"}},[e._v("\n          "+e._s(e.$str("header_learning_name","totara_core"))+"\n        ")]),e._v(" "),n("HeaderCell",{attrs:{size:"4",valign:"center"}},[e._v("\n          "+e._s(e.$str("header_learning_type","totara_core"))+"\n        ")]),e._v(" "),n("HeaderCell",{attrs:{size:"3",align:"center",valign:"center"}},[e._v("\n          "+e._s(e.$str("header_learning_progress","totara_core"))+"\n        ")])]},proxy:!0},{key:"row",fn:function(t){var r=t.row;return[n("Cell",{attrs:{size:"5","column-header":e.$str("header_learning_name","totara_core"),valign:"center"}},[e._v("\n          "+e._s(r.fullname)+"\n        ")]),e._v(" "),n("Cell",{attrs:{size:"4","column-header":e.$str("header_learning_type","totara_core"),valign:"center"}},[e._v("\n          "+e._s(e.typeName(r.itemtype))+"\n        ")]),e._v(" "),n("Cell",{attrs:{size:"3","column-header":e.$str("header_learning_progress","totara_core"),align:"center",valign:"center"}},[r.progress||0===r.progress?[e._v("\n            "+e._s(e.$str("xpercent","core",r.progress))+"\n          ")]:[e._v("\n            "+e._s(e.$str("statusnottracked","core_completion"))+"\n          ")]],2)]}}],null,!0)})]}},{key:"basket-list",fn:function(t){var r=t.disabledItems,i=t.selectedItems,a=t.update;return[n("SelectTable",{attrs:{"large-check-box":!0,"no-label-offset":!0,value:i,data:e.learningSelectedItems,"disabled-ids":r,"checkbox-v-align":"center","border-bottom-hidden":!0,"select-all-enabled":!0,"get-id":function(e,t){return"unique_id"in e?e.unique_id:t}},on:{input:function(e){return a(e)}},scopedSlots:e._u([{key:"header-row",fn:function(){return[n("HeaderCell",{attrs:{size:"5",valign:"center"}},[e._v("\n          "+e._s(e.$str("header_learning_name","totara_core"))+"\n        ")]),e._v(" "),n("HeaderCell",{attrs:{size:"4",valign:"center"}},[e._v("\n          "+e._s(e.$str("header_learning_type","totara_core"))+"\n        ")]),e._v(" "),n("HeaderCell",{attrs:{size:"3",align:"center",valign:"center"}},[e._v("\n          "+e._s(e.$str("header_learning_progress","totara_core"))+"\n        ")])]},proxy:!0},{key:"row",fn:function(t){var r=t.row;return[n("Cell",{attrs:{size:"5","column-header":e.$str("header_learning_name","totara_core"),valign:"center"}},[e._v("\n          "+e._s(r.fullname)+"\n        ")]),e._v(" "),n("Cell",{attrs:{size:"4","column-header":e.$str("header_learning_type","totara_core"),valign:"center"}},[e._v("\n          "+e._s(e.typeName(r.itemtype))+"\n        ")]),e._v(" "),n("Cell",{attrs:{size:"3","column-header":e.$str("header_learning_progress","totara_core"),align:"center",valign:"center"}},[r.progress||0===r.progress?[e._v("\n            "+e._s(e.$str("xpercent","core",r.progress))+"\n          ")]:[e._v("\n            "+e._s(e.$str("statusnottracked","core_completion"))+"\n          ")]],2)]}}],null,!0)})]}}])})}),[],!1,null,null,null);w(C),C.options.__hasBlocks={script:!0,template:!0};const S=C.exports},Y9BB:(e,t,n)=>{"use strict";n.r(t),n.d(t,{default:()=>a});const r={components:{},inheritAttrs:!1,props:{relationships:Array}};var i=(0,n("wWJ2").Z)(r,(function(){var e=this.$createElement;return(this._self._c||e)("div")}),[],!1,null,null,null);i.options.__hasBlocks={script:!0,template:!0};const a=i.exports},OGOV:(e,t,n)=>{"use strict";n.r(t),n.d(t,{default:()=>o});const r=tui.require("totara_core/components/performelement_linked_review/learning/ParticipantContent"),i={components:{ParticipantContent:n.n(r)()},props:{data:{type:Object,required:!0}},methods:{getPreviewData(){return{fullname:this.$str("example_learning_fullname","totara_core"),description:this.$str("example_learning_description","totara_core"),image_src:this.data.content_type_settings.default_image,itemtype:"course",progress:25}}}},a=function(e){e.options.__langStrings={totara_core:["example_learning_fullname","example_learning_description"]}};var s=(0,n("wWJ2").Z)(i,(function(){var e=this,t=e.$createElement;return(e._self._c||t)("ParticipantContent",{attrs:{content:e.getPreviewData(),preview:!0}})}),[],!1,null,null,null);a(s),s.options.__hasBlocks={script:!0,template:!0};const o=s.exports},"8Jkj":(e,t,n)=>{"use strict";n.r(t),n.d(t,{default:()=>u});const r=tui.require("tui/components/card/Card");var i=n.n(r);const a=tui.require("tui_charts/components/PercentageDoughnut");var s=n.n(a);const o={components:{Card:i(),PercentageDoughnut:s()},props:{content:{type:Object},createdAt:String,fromPrint:Boolean,isExternalParticipant:Boolean,preview:Boolean,subjectUser:Object},computed:{chartProps(){return{percentage:this.content.progress,showPercentage:!0,percentageFontSize:13,cutout:80,square:!0}},typeName(){if(!this.content.itemtype)return this.$str("learning_type_unknown","totara_core");let e=this.$str("learning_type_"+this.content.itemtype,"totara_core");return e||(e=this.$str("learning_type_unknown","totara_core")),e},hasContent(){return this.content.id||this.content.itemtype}},methods:{open(){window.open(this.content.url_view)}}},l=function(e){e.options.__langStrings={core_completion:["statusnottracked"],totara_core:["learning_removed","learning_type_certification","learning_type_course","learning_type_program","learning_type_unknown"]}};var c=(0,n("wWJ2").Z)(o,(function(){var e=this,t=e.$createElement,n=e._self._c||t;return e.hasContent?n("div",{staticClass:"tui-linkedReviewViewCurrentLearning"},[e.preview?e._e():n("div",{staticClass:"tui-linkedReviewViewCurrentLearning__date"},[e._v("\n    "+e._s(e.createdAt)+"\n  ")]),e._v(" "),n("Card",{staticClass:"tui-linkedReviewViewCurrentLearning__card",attrs:{clickable:!e.preview},on:{click:e.open}},[n("div",{staticClass:"tui-linkedReviewViewCurrentLearning__image",style:"background-image: url("+e.content.image_src+");"}),e._v(" "),n("div",{staticClass:"tui-linkedReviewViewCurrentLearning__content"},[n("h3",{staticClass:"tui-linkedReviewViewCurrentLearning__content-heading"},[e.preview?[e._v(e._s(e.content.fullname))]:n("a",{attrs:{href:e.content.url_view,target:"_blank"}},[e._v(e._s(e.content.fullname))])],2),e._v(" "),n("div",{staticClass:"tui-linkedReviewViewCurrentLearning__content-description",domProps:{innerHTML:e._s(e.content.description)}}),e._v(" "),n("span",{staticClass:"tui-linkedReviewViewCurrentLearning__content-type"},[e._v("\n        "+e._s(e.typeName)+"\n      ")])]),e._v(" "),n("div",{staticClass:"tui-linkedReviewViewCurrentLearning__chart"},[null!==e.content.progress?n("PercentageDoughnut",e._b({},"PercentageDoughnut",e.chartProps,!1)):n("div",{staticClass:"tui-linkedReviewViewCurrentLearning__chart-text"},[e._v("\n        "+e._s(e.$str("statusnottracked","core_completion"))+"\n      ")])],1)])],1):n("p",{staticClass:"tui-linkedReviewViewCurrentLearning tui-linkedReviewViewCurrentLearning--deleted"},[e._v("\n  "+e._s(e.$str("learning_removed","totara_core"))+"\n")])}),[],!1,null,null,null);l(c),c.options.__hasBlocks={script:!0,template:!0};const u=c.exports},VIhv:(e,t,n)=>{"use strict";n.r(t),n.d(t,{default:()=>u});const r=tui.require("totara_core/components/adder/LearningAdder");var i=n.n(r);const a=tui.require("performelement_linked_review/components/SelectContent");var s=n.n(a);const o={components:{LearningAdder:i(),SelectContent:s()},props:{canShowAdder:{type:Boolean,required:!0},coreRelationship:{type:Array,required:!0},isDraft:Boolean,participantInstanceId:{type:[String,Number],required:!0},previewComponent:[Function,Object],required:Boolean,sectionElementId:String,subjectUser:Object,userId:Number},methods:{getAdder:()=>i(),getItemData:e=>e}},l=function(e){e.options.__langStrings={totara_core:["add_learning","awaiting_selection_text","remove_learning"]}};var c=(0,n("wWJ2").Z)(o,(function(){var e=this,t=e.$createElement,n=e._self._c||t;return n("SelectContent",{attrs:{adder:e.getAdder(),"add-btn-text":e.$str("add_learning","totara_core"),"can-show-adder":e.canShowAdder,"cant-add-text":e.$str("awaiting_selection_text","totara_core",e.coreRelationship[0].name),"is-draft":e.isDraft,"participant-instance-id":e.participantInstanceId,"remove-text":e.$str("remove_learning","totara_core"),required:e.required,"section-element-id":e.sectionElementId,"user-id":e.userId,"additional-content":["itemtype"],"get-id":function(e){return"unique_id"in e?e.unique_id:null}},on:{"unsaved-plugin-change":function(t){return e.$emit("unsaved-plugin-change",t)},update:function(t){return e.$emit("update",t)}},scopedSlots:e._u([{key:"content-preview",fn:function(t){var r=t.content;return[n(e.previewComponent,{tag:"component",attrs:{content:e.getItemData(r),"subject-user":e.subjectUser}})]}}])})}),[],!1,null,null,null);l(c),c.options.__hasBlocks={script:!0,template:!0};const u=c.exports},wWJ2:(e,t,n)=>{"use strict";function r(e,t,n,r,i,a,s,o){var l,c="function"==typeof e?e.options:e;if(t&&(c.render=t,c.staticRenderFns=n,c._compiled=!0),r&&(c.functional=!0),a&&(c._scopeId="data-v-"+a),s?(l=function(e){(e=e||this.$vnode&&this.$vnode.ssrContext||this.parent&&this.parent.$vnode&&this.parent.$vnode.ssrContext)||"undefined"==typeof __VUE_SSR_CONTEXT__||(e=__VUE_SSR_CONTEXT__),i&&i.call(this,e),e&&e._registeredComponents&&e._registeredComponents.add(s)},c._ssrRegister=l):i&&(l=o?function(){i.call(this,(c.functional?this.parent:this).$root.$options.shadowRoot)}:i),l)if(c.functional){c._injectStyles=l;var u=c.render;c.render=function(e,t){return l.call(t),u(e,t)}}else{var d=c.beforeCreate;c.beforeCreate=d?[].concat(d,l):[l]}return{exports:e,options:c}}n.d(t,{Z:()=>r})}},t={};function n(r){var i=t[r];if(void 0!==i)return i.exports;var a=t[r]={exports:{}};return e[r](a,a.exports,n),a.exports}n.n=e=>{var t=e&&e.__esModule?()=>e.default:()=>e;return n.d(t,{a:t}),t},n.d=(e,t)=>{for(var r in t)n.o(t,r)&&!n.o(e,r)&&Object.defineProperty(e,r,{enumerable:!0,get:t[r]})},n.o=(e,t)=>Object.prototype.hasOwnProperty.call(e,t),n.r=e=>{"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},function(){"use strict";"undefined"!=typeof tui&&tui._bundle.isLoaded("totara_core")?console.warn('[tui bundle] The bundle "totara_core" is already loaded, skipping initialisation.'):(tui._bundle.register("totara_core"),tui._bundle.addModulesFromContext("totara_core/components",n("aOQU")))}()})();