YUI.add("moodle-core-formautosubmit",function(e,t){var n,r="core-formautosubmit",i,s=!1;n={AUTOSUBMIT:"autosubmit"},i=function(){i.superclass.constructor.apply(this,arguments)},e.extend(i,e.Base,{initializer:function(){var t,r;s||(s=!0,t=e.one("body"),t.delegate("key",this.process_changes,"press:13","select."+n.AUTOSUBMIT,this),t.delegate("click",this.process_changes,"select."+n.AUTOSUBMIT,this),e.UA.os==="macintosh"&&e.UA.webkit&&t.delegate("change",this.process_changes,"select."+n.AUTOSUBMIT,this),e.UA.touchEnabled&&t.delegate("change",this.process_changes,"select."+n.AUTOSUBMIT,this)),this.get("selectid")&&(r=e.one("select#"+this.get("selectid")),r&&((this.get("nothing")||this.get("nothing")==="")&&r.setData("nothing",this.get("nothing")),r.setData("startindex",r.get("selectedIndex"))))},check_changed:function(e){var t,r,i,s,o;return t=e.target.ancestor("select."+n.AUTOSUBMIT,!0),t?(r=t.getData("nothing"),i=t.getData("startindex"),s=t.get("selectedIndex"),o=parseInt(t.getData("previousindex"),10),t.setData("previousindex",s),o||(o=i),r!==!1&&t.get("value")===r||i===t.get("selectedIndex")||s===o?!1:t):!1},process_changes:function(e){var t=this.check_changed(e),n;t&&(n=t.ancestor("form",!0),n.submit())}},{NAME:r,ATTRS:{selectid:{value:""},nothing:{value:""},ignorechangeevent:{value:!1}}}),M.core=M.core||{},M.core.init_formautosubmit=M.core.init_formautosubmit||function(e){return new i(e)}},"@VERSION@",{requires:["base","event-key"]});
