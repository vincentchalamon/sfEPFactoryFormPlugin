<?php

class sfWidgetFormSelectSlider extends sfWidgetFormSelect {

  protected function configure($options = array(), $attributes = array()) {
    parent::configure($options, $attributes);
    $this->addOption('theme', '/sfEPFactoryFormPlugin/jqueryui/smoothness/jquery-ui.css');
  }

  public function render($name, $value = null, $attributes = array(), $errors = array()) {
    if(isset($attributes['class'])) {
      $attributes['class'].= " noTransform";
    }
    else {
      $attributes['class'] = "noTransform";
    }
    return parent::render($name, $value, $attributes, $errors).sprintf(<<<EOF
<script type="text/javascript">
  $(document).ready(function(){
    $("#%s").selectToUISlider({
      labels: %s
    }).hide();
  });
</script>
EOF
            , $this->generateId($name, $value)
            , count($this->getChoices())
            );
  }

  /*
   *
   * Gets the stylesheet paths associated with the widget.
   *
   * @return array An array of stylesheet paths
   */
  public function getStylesheets()
  {
    return array($this->getOption('theme') => 'screen', '/sfEPFactoryFormPlugin/selectToUISlider/ui.slider.extras.css' => 'screen');
  }

  /**
   * Gets the JavaScript paths associated with the widget.
   *
   * @return array An array of JavaScript paths
   */
  public function getJavaScripts()
  {
    return array('/sfEPFactoryFormPlugin/js/jquery.min.js', '/sfEPFactoryFormPlugin/jqueryui/jquery-ui.min.js', '/sfEPFactoryFormPlugin/selectToUISlider/selectToUISlider.jQuery.js');
  }

}
