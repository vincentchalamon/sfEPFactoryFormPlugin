<?php

class sfWidgetFormInputMask extends sfWidgetFormInputText
{
  protected function configure($options = array(), $attributes = array()) {
    parent::configure($options, $attributes);
    $this->addRequiredOption('mask');
  }

  public function render($name, $value = null, $attributes = array(), $errors = array())
  {
    return sprintf(<<<EOF
<script type="text/javascript">
  $(document).ready(function(){
    $("#%s").mask('%s');
  });
</script>
EOF
            , $this->generateId($name, $value)
            , $this->getOption('mask')
            ).parent::render($name, $value, $attributes, $errors);
  }

  public function getJavaScripts() {
    return array('/sfEPFactoryFormPlugin/js/jquery.min.js', '/sfEPFactoryFormPlugin/js/jquery.maskedinput.min.js');
  }

}
