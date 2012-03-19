<?php

class sfWidgetFormInputColorPicker extends sfWidgetFormInputText
{
  protected function configure($options = array(), $attributes = array())
  {
    parent::configure($options, $attributes);
    $this->addOption('readonly', false);
  }

  public function render($name, $value = null, $attributes = array(), $errors = array())
  {
    return sprintf(<<<EOF
<script type="text/javascript">
  $(document).ready(function(){
    $("#%s").miniColors({
      readonly: %s
    });
  });
</script>
EOF
            , $this->generateId($name, $value)
            , $this->getOption('readonly') ? "true" : "false"
            ).parent::render($name, $value, $attributes, $errors);
  }

  public function getJavaScripts()
  {
    return array('/sfEPFactoryFormPlugin/js/jquery.min.js', '/sfEPFactoryFormPlugin/colorPicker/jquery.miniColors.min.js');
  }
  
  public function getStylesheets()
  {
    return array('/sfEPFactoryFormPlugin/colorPicker/jquery.miniColors.css' => 'all');
  }

}
