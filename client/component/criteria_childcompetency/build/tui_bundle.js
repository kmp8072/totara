(()=>{var e={"/ezX":(e,i,n)=>{var t={"./achievements/AchievementDisplay":"aZHh","./achievements/AchievementDisplay.vue":"aZHh"};function a(e){var i=d(e);return n(i)}function d(e){if(!n.o(t,e)){var i=new Error("Cannot find module '"+e+"'");throw i.code="MODULE_NOT_FOUND",i}return t[e]}a.keys=function(){return Object.keys(t)},a.resolve=d,e.exports=a,a.id="/ezX"},aZHh:(e,i,n)=>{"use strict";n.r(i),n.d(i,{default:()=>d});const t=tui.require("totara_criteria/components/achievements/CompetencyAchievementDisplay");var a=function(e,i,n,t,a,d,r,s){var l,c="function"==typeof e?e.options:e;if(i&&(c.render=i,c.staticRenderFns=[],c._compiled=!0),l)if(c.functional){c._injectStyles=l;var m=c.render;c.render=function(e,i){return l.call(i),m(e,i)}}else{var o=c.beforeCreate;c.beforeCreate=o?[].concat(o,l):[l]}return{exports:e,options:c}}({components:{CompetencyAchievementDisplay:n.n(t)()},props:{assignmentId:{required:!0,type:Number},instanceId:{required:!0,type:Number},userId:{required:!0,type:Number}},data:()=>({achievements:{items:[]}}),apollo:{achievements:{query:{kind:"Document",definitions:[{kind:"OperationDefinition",operation:"query",name:{kind:"Name",value:"criteria_childcompetency_achievements"},variableDefinitions:[{kind:"VariableDefinition",variable:{kind:"Variable",name:{kind:"Name",value:"instance_id"}},type:{kind:"NonNullType",type:{kind:"NamedType",name:{kind:"Name",value:"core_id"}}},directives:[]},{kind:"VariableDefinition",variable:{kind:"Variable",name:{kind:"Name",value:"user_id"}},type:{kind:"NonNullType",type:{kind:"NamedType",name:{kind:"Name",value:"core_id"}}},directives:[]},{kind:"VariableDefinition",variable:{kind:"Variable",name:{kind:"Name",value:"assignment_id"}},type:{kind:"NonNullType",type:{kind:"NamedType",name:{kind:"Name",value:"core_id"}}},directives:[]}],directives:[],selectionSet:{kind:"SelectionSet",selections:[{kind:"Field",name:{kind:"Name",value:"criteria_childcompetency_achievements"},arguments:[{kind:"Argument",name:{kind:"Name",value:"instance_id"},value:{kind:"Variable",name:{kind:"Name",value:"instance_id"}}},{kind:"Argument",name:{kind:"Name",value:"user_id"},value:{kind:"Variable",name:{kind:"Name",value:"user_id"}}},{kind:"Argument",name:{kind:"Name",value:"assignment_id"},value:{kind:"Variable",name:{kind:"Name",value:"assignment_id"}}}],directives:[],selectionSet:{kind:"SelectionSet",selections:[{kind:"Field",name:{kind:"Name",value:"current_user"},arguments:[],directives:[]},{kind:"Field",name:{kind:"Name",value:"aggregation_method"},arguments:[],directives:[]},{kind:"Field",name:{kind:"Name",value:"required_items"},arguments:[],directives:[]},{kind:"Field",name:{kind:"Name",value:"is_valid"},arguments:[],directives:[]},{kind:"Field",name:{kind:"Name",value:"items"},arguments:[],directives:[],selectionSet:{kind:"SelectionSet",selections:[{kind:"Field",name:{kind:"Name",value:"assigned"},arguments:[],directives:[]},{kind:"Field",name:{kind:"Name",value:"self_assignable"},arguments:[],directives:[]},{kind:"Field",name:{kind:"Name",value:"competency"},arguments:[],directives:[],selectionSet:{kind:"SelectionSet",selections:[{kind:"Field",name:{kind:"Name",value:"id"},arguments:[],directives:[]},{kind:"Field",name:{kind:"Name",value:"fullname"},arguments:[],directives:[]},{kind:"Field",name:{kind:"Name",value:"description"},arguments:[],directives:[]}]}},{kind:"Field",name:{kind:"Name",value:"value"},arguments:[],directives:[],selectionSet:{kind:"SelectionSet",selections:[{kind:"Field",name:{kind:"Name",value:"id"},arguments:[],directives:[]},{kind:"Field",name:{kind:"Name",value:"name"},arguments:[],directives:[]},{kind:"Field",name:{kind:"Name",value:"proficient"},arguments:[],directives:[]}]}}]}}]}}]}}]},context:{batch:!0},variables(){return{assignment_id:this.assignmentId,instance_id:this.instanceId,user_id:this.userId}},update({criteria_childcompetency_achievements:e}){return this.$emit("loaded"),e}}}},(function(){var e=this,i=e.$createElement;return(e._self._c||i)("CompetencyAchievementDisplay",{attrs:{type:"childCompetency",achievements:e.achievements,"user-id":e.userId},on:{"self-assigned":function(i){return e.$apollo.queries.achievements.refetch()}}})}));a.options.__hasBlocks={script:!0,template:!0};const d=a.exports}},i={};function n(t){var a=i[t];if(void 0!==a)return a.exports;var d=i[t]={exports:{}};return e[t](d,d.exports,n),d.exports}n.n=e=>{var i=e&&e.__esModule?()=>e.default:()=>e;return n.d(i,{a:i}),i},n.d=(e,i)=>{for(var t in i)n.o(i,t)&&!n.o(e,t)&&Object.defineProperty(e,t,{enumerable:!0,get:i[t]})},n.o=(e,i)=>Object.prototype.hasOwnProperty.call(e,i),n.r=e=>{"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},function(){"use strict";"undefined"!=typeof tui&&tui._bundle.isLoaded("criteria_childcompetency")?console.warn('[tui bundle] The bundle "criteria_childcompetency" is already loaded, skipping initialisation.'):(tui._bundle.register("criteria_childcompetency"),tui._bundle.addModulesFromContext("criteria_childcompetency/components",n("/ezX")))}()})();