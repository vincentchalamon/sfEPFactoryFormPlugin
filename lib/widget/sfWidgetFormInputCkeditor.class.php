<?php

class sfWidgetFormInputCkeditor extends sfWidgetFormTextarea
{
  protected function configure($options = array(), $attributes = array()) {
    parent::configure($options, $attributes);
    $this->addOption('width', 635);
    $this->addOption('height', 400);
    $this->addOption('filemanager_path', "/uploads/");
    $this->addOption('toolbar', "Custom");
  }

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
  CKEDITOR.replace('%s', {
    width: %s,
    height: %s,
    filebrowserBrowseUrl: "/sfEPFactoryFormPlugin/ckeditor/filemanager/index.html?path=%s",
    toolbar: "%s"
  });
</script>
EOF
            , $this->generateId($name, $value)
            , $this->getOption('width')
            , $this->getOption('height')
            , $this->getOption('filemanager_path')
            , $this->getOption("toolbar")
            );
  }

  public function getJavaScripts()
  {
    return array_merge(parent::getJavaScripts(), array(public_path('/sfEPFactoryFormPlugin/ckeditor/ckeditor.js')));
  }
}
