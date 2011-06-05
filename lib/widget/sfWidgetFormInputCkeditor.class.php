<?php

class sfWidgetFormInputCkeditor extends sfWidgetFormTextarea
{
  public function render($name, $value = null, $attributes = array(), $errors = array())
  {
    if(isset($attributes['class'])) {
      $attributes['class'].= " ckeditorDone";
    }
    else {
      $attributes['class'] = "ckeditorDone";
    }
    return parent::render($name, $value, $attributes, $errors).sprintf(<<<EOF
<script type="text/javascript">
	CKEDITOR.replace('%s');
</script>
EOF
            , $this->generateId($name, $value));
  }

  public function getJavaScripts()
  {
    return array_merge(parent::getJavaScripts(), array(public_path('/sfEPFactoryFormPlugin/ckeditor/ckeditor.js')));
  }
}
