!function(e){var t={};function a(o){if(t[o])return t[o].exports;var n=t[o]={i:o,l:!1,exports:{}};return e[o].call(n.exports,n,n.exports,a),n.l=!0,n.exports}a.m=e,a.c=t,a.d=function(e,t,o){a.o(e,t)||Object.defineProperty(e,t,{configurable:!1,enumerable:!0,get:o})},a.r=function(e){Object.defineProperty(e,"__esModule",{value:!0})},a.n=function(e){var t=e&&e.__esModule?function(){return e.default}:function(){return e};return a.d(t,"a",t),t},a.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},a.p="",a(a.s=1)}([,function(e,t,a){"use strict";$(function(){$(".connectedSortable").sortable({placeholder:"sort-highlight",connectWith:".connectedSortable",handle:".box-header, .nav-tabs",forcePlaceholderSize:!0,zIndex:999999}).disableSelection(),$(".connectedSortable .box-header, .connectedSortable .nav-tabs-custom").css("cursor","move"),$(".sidebar-menu .opened").each(function(){$(this).children("a").children(".menu-item-toggle-icon").removeClass("fa-plus-square-o"),$(this).children("a").children(".menu-item-toggle-icon").addClass("fa-minus-square-o"),$(this).children("ul").css("display","block")}),$("#idRemoveVideoButton").click(function(e){e.preventDefault(),$("#idRemoveVideo").val("1"),$("#idVideoFileInput").val("")}),$("#idRemoveMobileVideoButton").click(function(e){e.preventDefault(),$("#idRemoveMobileVideo").val("1"),$("#idMobileVideoFileInput").val("")}),$("#idRemoveFileButton").click(function(e){e.preventDefault(),$("#idRemoveFile").val("1"),$("#idFileInput").val("")})}),$(document).ready(function(){var e,t=decodeURIComponent(window.location.href).split("&")[0].split("Search[content]=")[1];t&&(console.log(t),$(".search-cont").each(function(){new Mark(this).mark(t.replace("+"," ")),new Mark(this).mark(t.replace("+","  "))}));function a(e,t,a){Lobibox.notify(e,{sound:!1,position:"top right",delay:1500,showClass:"fadeInDown",title:t,msg:a})}$("#linked").on("shown.bs.modal",function(){$.ajax({url:"/base/tree",type:"POST",data:{key:parseInt($("#tree-modal-body").attr("data-key"))},success:function(t){!function(t){e=JSON.parse(t),$("#jstree-choose").jstree({plugins:["checkbox","types","wholerow"],checkbox:{three_state:!1},core:{data:e},types:{website:{icon:"fa fa-globe"},page:{icon:"fa fa-file-powerpoint-o"},video_section:{icon:"fa fa-file-video-o"},content_text:{icon:"fa fa-file-text"},teaser:{icon:"fa fa-file-text"},section:{icon:"fa fa-folder-open-o"},service:{icon:"fa fa-wrench"},pharmaceutical_form:{icon:"fa fa-medkit"}}})}(t)}})}),$("#move-modal").on("shown.bs.modal",function(){$.ajax({url:"/base/tree-for-move",type:"POST",data:{key:parseInt($("#tree-modal-body").attr("data-key"))},success:function(e){!function(e){JSON.parse(e),$("#jstree-move").jstree({plugins:["checkbox","rules","types","wholerow"],checkbox:{three_state:!1},core:{multiple:!1,data:JSON.parse(e)},types:{website:{icon:"fa fa-globe"},page:{icon:"fa fa-file-powerpoint-o"},video_section:{icon:"fa fa-file-video-o"},content_text:{icon:"fa fa-file-text"},teaser:{icon:"fa fa-file-text"},section:{icon:"fa fa-folder-open-o"},service:{icon:"fa fa-wrench"},pharmaceutical_form:{icon:"fa fa-medkit"}}})}(e)}})}),setTimeout(function(){$(".kv-file-remove").each(function(){$(this).click(function(){var e=$(this).data("key").toString(),t=$("[name*=deletedImages]"),a=t.val(),o=[];a.length>0&&(o=a.split(",")).includes(e)||o.push(e),t.val(o.join())})})},1e3),$("#linked-button").click(function(){var e=[];$("#jstree-choose").jstree("get_checked",null,!0).forEach(function(t){e.push(t)}),$.ajax({url:"/base/link-tree",type:"POST",data:{ids:e,tree:parseInt($("#tree-modal-body").attr("data-key"))},success:function(e){1==(e=JSON.parse(e)).code?($("#linked").modal("hide"),a("success","Link Object","Successfully Linked")):a("error","Link Object",e.message)}})}),$("#move-button").click(function(){var e=[];$("#jstree-move").jstree("get_checked",null,!0).forEach(function(t){e.push(t)}),$.ajax({url:"/base/move-tree",type:"POST",data:{prepend_to:e,moved:[parseInt($("#move-modal-body").attr("data-key"))]},success:function(e){1==(e=JSON.parse(e)).code?($("#move-modal").modal("hide"),a("success","Link Object","Successfully Linked")):a("error","Link Object",e.message)}})}),$("#show_in_menu :checkbox").change(function(){var e=$("#show_in_menu"),t=e.serialize();$.ajax({url:e.attr("action"),type:e.attr("method"),data:t,success:function(e){console.log(e),0==e?a("error","Show In Menu","Changes not Saved"):a("success","Show In Menu","Saved")},error:function(e){a("error","Show In Menu","Changes not Saved")}})}),$("#table_names_tree :checkbox").change(function(){var e=[];"all"===$(this).val()?$("#table_names_tree input:checkbox").prop("checked",this.checked):$("#table_names_tree input:checked").each(function(){e.push($(this).val())}),$.ajax({url:"/base/tree",type:"POST",data:{table_names:e},success:function(e){$("#jstree-choose").jstree(!0).settings.core.data=JSON.parse(e),$("#jstree-choose").jstree(!0).refresh()}})}),$("#table_names_for_move :checkbox").change(function(){var e=[];"all"===$(this).val()?$("#table_names_for_move input:checkbox").prop("checked",this.checked):$("#table_names_for_move input:checked").each(function(){e.push($(this).val())}),$.ajax({url:"/base/tree-for-move",type:"POST",data:{table_names:e},success:function(e){$("#jstree-move").jstree(!0).settings.core.data=JSON.parse(e),$("#jstree-move").jstree(!0).refresh()}})});$("#content_tree_child tbody").sortable({handle:".tree-children-draggable",start:function(e,t){t.item.data("start_pos",t.item.index())},stop:function(e,t){if(t.item.data("start_pos")!=t.item.index()){var o,n=0,i=0;void 0!==t.item.prev("tr").attr("data-key")&&(n=t.item.prev("tr").attr("data-key")),void 0!==t.item.next("tr").attr("data-key")&&(i=t.item.next("tr").attr("data-key")),o=t.item.attr("data-key"),$.ajax({url:"/base/swap",type:"POST",data:{prev:n,element:o,next:i},success:function(e){0==e?a("error","Child Hierarchy","Changes not Saved"):a("success","Child Hierarchy","Saved")},error:function(e){a("error","Child Hierarchy","Changes not Saved")}})}}}),$(".view-dropdown").change(function(){var e=$(this).val(),t=$(this).closest("tr").data("key");$.ajax({url:"/base/update-view",type:"POST",data:{id:t,value:e},success:function(e){0==e?a("error","View","Changes not Saved"):a("success","View","Changes Saved")},error:function(e){a("error","View","Changes not Saved")}})}),$(".hide-dropdown").change(function(){var e=$(this).val(),t=$(this).closest("tr").data("key");$.ajax({url:"/base/update-hide",type:"POST",data:{id:t,value:e},success:function(e){0==e?a("error","Hidden Option","Changes not Saved"):a("success","Hidden Option","Changes Saved")},error:function(e){a("error","Hidden Option","Changes not Saved")}})}),$('.widget-text-form select[name*="[language]"]').change(function(){var e=$(this).find('option[value="'+this.value+'"]');window.location.href=e.attr("data-url")}),$(".highlight code").each(function(e,t){hljs.highlightBlock(t)})})}]);
//# sourceMappingURL=app.js.map