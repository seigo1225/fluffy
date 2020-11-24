/**
 * jQuery Editable
 *
 * ある要素をその場で編集できるようにします。
 *
 * @author Towny Pooky
 * @license MIT
 */
(function($){

    $.fn.extend({
       editable: function(event, apply, remove){
           var action, multiline, removable;

            // event
           if(typeof event === "string"){
               action = event;
               multiline = false;
           }else if(typeof event === "object"){
               action = event.action || "dblclick";
               multiline = event.multiline || false;
           }else{
               action = "dbclick";
               multiline = false;
           }

           // removable
           removable = typeof remove === "function";

           // main
           $(this).bind(action, function(target, origin){
               target = $(this);
               origin = target.html();

               // multilineが有効だとtextareaになる
               if(!multiline) {
                   target.html('<input class="editable" type="textbox" value="'+origin+'" />');
               }else{
                   target.html('<textarea class="editable">'+origin+'</textarea>');
               }

               // inputでもtextareaでも同じ
               $('.editable:last', this).focus()
                   .keydown(function(e, value){
                       value = $(this).val();
                       // Apply
                       if(e.keyCode === 13 && value.length){
                           target.html(value);
                           apply.apply(target, [value, origin]);
                           return false;
                       }
                       // Remove
                       else if(e.keyCode === 13 && removable) {
                           target.remove();
                           remove.apply(target, [origin]);
                       }
                       // Cancel
                       else if(e.keyCode === 27){
                           target.html(origin);
                       }
                   });
           });
       }
    });
})(jQuery);
