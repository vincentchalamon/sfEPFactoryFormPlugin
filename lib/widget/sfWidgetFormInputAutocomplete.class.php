<?php

class sfWidgetFormInputAutocomplete extends sfWidgetFormInputText
{
  /**
   * @param array $options     An array of options
   * @param array $attributes  An array of default HTML attributes
   *
   * @see sfWidgetFormInput
   */
  protected function configure($options = array(), $attributes = array())
  {
    parent::configure($options, $attributes);
    $this->addRequiredOption('url');
    $this->setOption('is_hidden', false);
    $this->addOption('multiple', false);
    $this->addOption('caching', false);
    $this->addOption('theme', '/sfEPFactoryFormPlugin/jqueryui/smoothness/jquery-ui.css');
  }
  
  public function render($name, $value = null, $attributes = array(), $errors = array())
  {
    if($this->getOption("multiple")) {
      if(isset($attributes['class'])) {
        $attributes['class'].= " multiple";
      }
      else {
        $attributes['class'] = "multiple";
      }
    }
    return sprintf(<<<EOF
<script type="text/javascript">
  $(document).ready(function(){
    $("#%s").autocomplete({
      focus: function(event, ui){
        if($(this).hasClass('multiple')) {
          return false;
        }
      },
      select: function(event, ui){
        if($(this).hasClass('multiple')) {
          var terms = $(this).val().split(/,\s*/);
          terms.pop();
          terms.push(ui.item.value);
          terms.push("");
          $(this).val(terms.join(", ").replace(/(.*), $/, "$1")).focus();
          return false;
        }
      },
      source: function(request, response){
        var xhr = null;
        var value = request.term;
        if($(this.element).hasClass('multiple')) {
          value = value.split(/,\s*/);
          value = value.length ? value[value.length-1] : null;
        }
        %s
        xhr = $.ajax({
          url: '%s',
          type: 'post',
          dataType: 'json',
          data: {
            q: value
          },
          success: function(data){
            var datas = new Array();
            for(var i in data) {
              datas.push(data[i].name);
            }
            %s
            response(datas);
          }
        });
      }
    });
  });
</script>
EOF
            , $this->generateId($name, $value)
            , $this->getOption('caching') ? sprintf(<<<EOF
if(value in cache_%s) {
          response(cache_%s[value]);
          return;
        }
EOF
            , $this->generateId($name, $value), $this->generateId($name, $value)) : null
            , $this->getOption("url")
            , $this->getOption('caching') ? sprintf('cache_%s[value] = datas;', $this->generateId($name, $value)) : null
            ).parent::render($name, $this->getOption("multiple") ? implode(", ", $value) : $value, $attributes, $errors);
  }

  /*
   *
   * Gets the stylesheet paths associated with the widget.
   *
   * @return array An array of stylesheet paths
   */
  public function getStylesheets()
  {
    return array($this->getOption('theme') => 'screen');
  }

  /**
   * Gets the JavaScript paths associated with the widget.
   *
   * @return array An array of JavaScript paths
   */
  public function getJavaScripts()
  {
    return array('/sfEPFactoryFormPlugin/js/jquery.min.js', '/sfEPFactoryFormPlugin/jqueryui/jquery-ui.min.js');
  }

}