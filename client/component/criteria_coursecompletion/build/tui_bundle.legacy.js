!function(){var e={O3t0:function(e,i,n){var t={"./achievements/AchievementDisplay":"iMt1","./achievements/AchievementDisplay.vue":"iMt1"};function r(e){var i=a(e);return n(i)}function a(e){if(!n.o(t,e)){var i=new Error("Cannot find module '"+e+"'");throw i.code="MODULE_NOT_FOUND",i}return t[e]}r.keys=function(){return Object.keys(t)},r.resolve=a,e.exports=r,r.id="O3t0"},iMt1:function(e,i,n){"use strict";n.r(i),n.d(i,{default:function(){return a}});var t=tui.require("totara_criteria/components/achievements/CourseAchievementDisplay"),r=function(e,i,n,t,r,a,o,d){var s,u="function"==typeof e?e.options:e;if(i&&(u.render=i,u.staticRenderFns=[],u._compiled=!0),s)if(u.functional){u._injectStyles=s;var c=u.render;u.render=function(e,i){return s.call(i),c(e,i)}}else{var l=u.beforeCreate;u.beforeCreate=l?[].concat(l,s):[s]}return{exports:e,options:u}}({components:{CourseAchievementDisplay:n.n(t)()},inheritAttrs:!1,props:{instanceId:{required:!0,type:Number},userId:{required:!0,type:Number},displayed:Boolean},data:function(){return{achievements:{items:[]}}},apollo:{achievements:{query:{kind:"Document",definitions:[{kind:"OperationDefinition",operation:"query",name:{kind:"Name",value:"criteria_coursecompletion_achievements"},variableDefinitions:[{kind:"VariableDefinition",variable:{kind:"Variable",name:{kind:"Name",value:"instance_id"}},type:{kind:"NonNullType",type:{kind:"NamedType",name:{kind:"Name",value:"core_id"}}},directives:[]},{kind:"VariableDefinition",variable:{kind:"Variable",name:{kind:"Name",value:"user_id"}},type:{kind:"NonNullType",type:{kind:"NamedType",name:{kind:"Name",value:"core_id"}}},directives:[]}],directives:[],selectionSet:{kind:"SelectionSet",selections:[{kind:"Field",name:{kind:"Name",value:"criteria_coursecompletion_achievements"},arguments:[{kind:"Argument",name:{kind:"Name",value:"instance_id"},value:{kind:"Variable",name:{kind:"Name",value:"instance_id"}}},{kind:"Argument",name:{kind:"Name",value:"user_id"},value:{kind:"Variable",name:{kind:"Name",value:"user_id"}}}],directives:[],selectionSet:{kind:"SelectionSet",selections:[{kind:"Field",name:{kind:"Name",value:"aggregation_method"},arguments:[],directives:[]},{kind:"Field",name:{kind:"Name",value:"required_items"},arguments:[],directives:[]},{kind:"Field",name:{kind:"Name",value:"is_valid"},arguments:[],directives:[]},{kind:"Field",name:{kind:"Name",value:"items"},arguments:[],directives:[],selectionSet:{kind:"SelectionSet",selections:[{kind:"Field",name:{kind:"Name",value:"course"},arguments:[],directives:[],selectionSet:{kind:"SelectionSet",selections:[{kind:"Field",name:{kind:"Name",value:"fullname"},arguments:[],directives:[]},{kind:"Field",name:{kind:"Name",value:"description"},arguments:[],directives:[]},{kind:"Field",name:{kind:"Name",value:"progress"},arguments:[],directives:[]},{kind:"Field",name:{kind:"Name",value:"url_view"},arguments:[],directives:[]}]}}]}}]}}]}}]},context:{batch:!0},variables:function(){return{instance_id:this.instanceId,user_id:this.userId}},update:function(e){var i=e.criteria_coursecompletion_achievements;return this.$emit("loaded"),i}}}},(function(){var e=this,i=e.$createElement;return(e._self._c||i)("CourseAchievementDisplay",{attrs:{achievements:e.achievements,displayed:e.displayed}})}));r.options.__hasBlocks={script:!0,template:!0};var a=r.exports}},i={};function n(t){var r=i[t];if(void 0!==r)return r.exports;var a=i[t]={exports:{}};return e[t](a,a.exports,n),a.exports}n.n=function(e){var i=e&&e.__esModule?function(){return e.default}:function(){return e};return n.d(i,{a:i}),i},n.d=function(e,i){for(var t in i)n.o(i,t)&&!n.o(e,t)&&Object.defineProperty(e,t,{enumerable:!0,get:i[t]})},n.o=function(e,i){return Object.prototype.hasOwnProperty.call(e,i)},n.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},function(){"use strict";"undefined"!=typeof tui&&tui._bundle.isLoaded("criteria_coursecompletion")?console.warn('[tui bundle] The bundle "criteria_coursecompletion" is already loaded, skipping initialisation.'):(tui._bundle.register("criteria_coursecompletion"),tui._bundle.addModulesFromContext("criteria_coursecompletion/components",n("O3t0")))}()}();