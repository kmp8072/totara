(()=>{var e={O3t0:(e,i,n)=>{var t={"./achievements/AchievementDisplay":"KIRT","./achievements/AchievementDisplay.vue":"KIRT"};function a(e){var i=r(e);return n(i)}function r(e){if(!n.o(t,e)){var i=new Error("Cannot find module '"+e+"'");throw i.code="MODULE_NOT_FOUND",i}return t[e]}a.keys=function(){return Object.keys(t)},a.resolve=r,e.exports=a,a.id="O3t0"},KIRT:(e,i,n)=>{"use strict";n.r(i),n.d(i,{default:()=>r});const t=tui.require("totara_criteria/components/achievements/CourseAchievementDisplay");var a=function(e,i,n,t,a,r,d,o){var s,l="function"==typeof e?e.options:e;if(i&&(l.render=i,l.staticRenderFns=[],l._compiled=!0),s)if(l.functional){l._injectStyles=s;var u=l.render;l.render=function(e,i){return s.call(i),u(e,i)}}else{var c=l.beforeCreate;l.beforeCreate=c?[].concat(c,s):[s]}return{exports:e,options:l}}({components:{CourseAchievementDisplay:n.n(t)()},inheritAttrs:!1,props:{instanceId:{required:!0,type:Number},userId:{required:!0,type:Number},displayed:Boolean},data:function(){return{achievements:{items:[]}}},apollo:{achievements:{query:{kind:"Document",definitions:[{kind:"OperationDefinition",operation:"query",name:{kind:"Name",value:"criteria_coursecompletion_achievements"},variableDefinitions:[{kind:"VariableDefinition",variable:{kind:"Variable",name:{kind:"Name",value:"instance_id"}},type:{kind:"NonNullType",type:{kind:"NamedType",name:{kind:"Name",value:"core_id"}}},directives:[]},{kind:"VariableDefinition",variable:{kind:"Variable",name:{kind:"Name",value:"user_id"}},type:{kind:"NonNullType",type:{kind:"NamedType",name:{kind:"Name",value:"core_id"}}},directives:[]}],directives:[],selectionSet:{kind:"SelectionSet",selections:[{kind:"Field",name:{kind:"Name",value:"criteria_coursecompletion_achievements"},arguments:[{kind:"Argument",name:{kind:"Name",value:"instance_id"},value:{kind:"Variable",name:{kind:"Name",value:"instance_id"}}},{kind:"Argument",name:{kind:"Name",value:"user_id"},value:{kind:"Variable",name:{kind:"Name",value:"user_id"}}}],directives:[],selectionSet:{kind:"SelectionSet",selections:[{kind:"Field",name:{kind:"Name",value:"aggregation_method"},arguments:[],directives:[]},{kind:"Field",name:{kind:"Name",value:"required_items"},arguments:[],directives:[]},{kind:"Field",name:{kind:"Name",value:"is_valid"},arguments:[],directives:[]},{kind:"Field",name:{kind:"Name",value:"items"},arguments:[],directives:[],selectionSet:{kind:"SelectionSet",selections:[{kind:"Field",name:{kind:"Name",value:"course"},arguments:[],directives:[],selectionSet:{kind:"SelectionSet",selections:[{kind:"Field",name:{kind:"Name",value:"fullname"},arguments:[],directives:[]},{kind:"Field",name:{kind:"Name",value:"description"},arguments:[],directives:[]},{kind:"Field",name:{kind:"Name",value:"progress"},arguments:[],directives:[]},{kind:"Field",name:{kind:"Name",value:"url_view"},arguments:[],directives:[]}]}}]}}]}}]}}]},context:{batch:!0},variables(){return{instance_id:this.instanceId,user_id:this.userId}},update({criteria_coursecompletion_achievements:e}){return this.$emit("loaded"),e}}}},(function(){var e=this,i=e.$createElement;return(e._self._c||i)("CourseAchievementDisplay",{attrs:{achievements:e.achievements,displayed:e.displayed}})}));a.options.__hasBlocks={script:!0,template:!0};const r=a.exports}},i={};function n(t){var a=i[t];if(void 0!==a)return a.exports;var r=i[t]={exports:{}};return e[t](r,r.exports,n),r.exports}n.n=e=>{var i=e&&e.__esModule?()=>e.default:()=>e;return n.d(i,{a:i}),i},n.d=(e,i)=>{for(var t in i)n.o(i,t)&&!n.o(e,t)&&Object.defineProperty(e,t,{enumerable:!0,get:i[t]})},n.o=(e,i)=>Object.prototype.hasOwnProperty.call(e,i),n.r=e=>{"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},function(){"use strict";"undefined"!=typeof tui&&tui._bundle.isLoaded("criteria_coursecompletion")?console.warn('[tui bundle] The bundle "criteria_coursecompletion" is already loaded, skipping initialisation.'):(tui._bundle.register("criteria_coursecompletion"),tui._bundle.addModulesFromContext("criteria_coursecompletion/components",n("O3t0")))}()})();