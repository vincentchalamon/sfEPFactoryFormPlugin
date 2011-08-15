/*
 * Multiple - jQuery Plugin
 * Generate interactions for jquery-multiple html code
 *
 * @todo Gérer le multiple récursif
 *
 * HTML needed :
 * <script type="text/javascript" src="multiple.jquery.js"></script>
 * <script type="text/javascript">
 *   $(document).ready(function(){
 *     $('.jquery-multiple').multiple();
 *   });
 * </script>
 * <link href="jquery-multiple.css" rel="stylesheet" />
 * <div class="jquery-multiple">
 *   <a href="" class="jquery-multiple-create">Créer <span class="jquery-multiple-add">+</span></a>
 *   <div class="jquery-multiple-source">
 *     <div class="jquery-multiple-elements">
 *       <div class="jquery-multiple-element jquery-multiple-element-text">
 *         <label for="my_input">Label</label>
 *         <input type="text" name="my_input_name" id="my_input" value="" />
 *       </div>
 *     </div>
 *     <div class="jquery-multiple-actions">
 *       <a href="" class="jquery-multiple-remove">-</a>
 *       <a href="" class="jquery-multiple-add">+</a>
 *     </div>
 *   </div>
 * </div>
 *
 * Copyright (c) 2011 Vincent CHALAMON <vincentchalamon@gmail.com>
 *
 * Version: 1.0 (12/08/2011)
 * Developped in: jQuery v1.5+
 */
(function($) {
  $.fn.multiple = function(settings){
    /**
     * Init settings
     */
    var self = this;
    this.settings = $.extend({
      max: null,
      maxMessage: "Vous ne pouvez pas ajouter d'éléments (%max% maximum).",
      onMax: function(message){
        alert(message);
      },
      min: null,
      minMessage: "Vous ne pouvez pas supprimer d'éléments (%min% minimum).",
      onMin: function(message){
        alert(message);
      },
      onAdd: function(event, object){},
      onRemove: function(event, object){}
    }, settings);

    /**
     * Create first element
     */
    this.create = function(event){
      $('.jquery-multiple-create', $(self)).hide();
      this.add(event);
    };

    /**
     * Add an element
     */
    this.add = function(event){
      var object = self._duplicate();
      if(object) {
        self.settings.onAdd(event, object);
      }
    };

    /**
     * Remove an element
     */
    this.remove = function(event){
      if(self.settings.min !== null && $('.jquery-multiple-row', $(self)).length == self.settings.min) {
        self.settings.onMin(self.settings.minMessage.replace(/%min%/i, self.settings.min));
        return;
      }
      var object = $(event.target).parents('.jquery-multiple-row:first').remove();
      if($('.jquery-multiple-row', $(self)).length == 0) {
        $('.jquery-multiple-create', $(self)).show();
      }
      self.settings.onRemove(event, object);
    };

    /**
     * Duplicate source to an element
     */
    this._duplicate = function(){
      if(self.settings.max !== null && $('.jquery-multiple-row', $(self)).length == self.settings.max) {
        self.settings.onMax(self.settings.maxMessage.replace(/%max%/i, self.settings.max));
        return;
      }
      var source = $('.jquery-multiple-source', $(self));
      var object = source.clone().removeClass('jquery-multiple-source').addClass('jquery-multiple-row');
      var id = 1;
      if(source.siblings('.jquery-multiple-row').length) {
        var ids = $('input[name], textarea[name], select[name]', source.siblings('.jquery-multiple-row:last')).attr('name').match(/(\d+)/ig);
        id = parseInt(ids.length ? ids[ids.length-1] : -1)+1;
      }
      $('input[name][id], textarea[name][id], select[name][id], label[for]', object).val('').removeAttr('checked').each(function(){
        var multiples = $(self).parents('.jquery-multiple').length;
        var pattern = "(.*";
        if(multiples) {
          for(var i = 0; i < multiples-1; i++) {
            pattern += "\\[\\d+\\].*";
          }
        }
        pattern += ")\\[(\\d+)\\](.*";
        if(multiples) {
          for(var j = 0; j < multiples-1-(multiples-1); j++) {
            pattern += "\\[\\d+\\].*";
          }
        }
        pattern += ")";
        var regex = new RegExp(pattern.replace(/(\[|\])/ig, '_'), "i");
        if(this.nodeName == "LABEL") {
          $(this).attr('for', !$(this).attr("for") ? null : $(this).attr("for").replace(regex, "$1_" + id + "_$3"));
        }
        else {
          $(this).attr('name', !$(this).attr("name") ? null : $(this).attr("name").replace(new RegExp(pattern, "i"), "$1[" + id + "]$3"));
          $(this).attr('id', !$(this).attr("id") ? null : $(this).attr("id").replace(regex, "$1_" + id + "_$3"));
        }
      });
      object.appendTo(source.parent());
      return object;
    };

    /**
     * Catch clicks
     */
    this.each(function(){
      $('.jquery-multiple-create', $(self)).live('click', function(event){
        event.preventDefault();
        self.create(event);
      });
      $('a.jquery-multiple-add', $(self)).live('click', function(event){
        event.preventDefault();
        self.add(event);
      });
      $('.jquery-multiple-remove', $(self)).live('click', function(event){
        event.preventDefault();
        self.remove(event);
      });
      $(self).parents('form:not(.jquery-multiple-waiting)').addClass('jquery-multiple-waiting').live('submit', function(event){
        event.preventDefault();
        $('.jquery-multiple-source', $(self)).remove();
        $('.jquery-multiple-row', $(self)).each(function(){
          var remove = true;
          $('input, textarea, select', $(this)).each(function(){
            if($(this).val().length) {
              remove = false;
            }
          });
          if(remove) {
            $(this).remove();
          }
        });
        $(this).submit();
      });
    });

    return this;
  };
})(jQuery);