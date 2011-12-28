<?php

class sfWidgetFormInputFilemanager extends sfWidgetFormInputText
{
  protected function configure($options = array(), $attributes = array())
  {
    parent::configure($options, $attributes);
    $this->addOption('path', '/uploads');
    $this->addOption('button_label', 'Parcourir');
    $this->addOption('is_image', false);
    $this->addOption('width', 900);
    $this->addOption('height', 500);
    $this->addOption('returnFunction');
  }

  /**
   * Renders the widget.
   *
   * @param  string $name        The element name
   * @param  string $value       The value displayed in this widget
   * @param  array  $attributes  An array of HTML attributes to be merged with the default HTML attributes
   * @param  array  $errors      An array of errors for the field
   *
   * @return string An HTML tag string
   *
   * @see sfWidgetForm
   */
  public function render($name, $value = null, $attributes = array(), $errors = array())
  {
    return parent::render($name, $value, $attributes, $errors).sprintf(<<<EOF
%s
%s
<script type="text/javascript">
  $(document).ready(function(){
    $('#%s_filemanager').click(function(){
      window.open("/sfEPFactoryFormPlugin/ckeditor/filemanager/index.html?path=%s&returnId=%s%s", "Gestionnaire de fichiers", "width=%s,height=%s");
    });
  });
</script>
EOF
            , $this->getOption('is_image') ? image_tag($value)."<br />" : null
            , $this->renderTag("input", array('type' => 'button', 'value' => $this->getOption('button_label'), 'id' => $this->generateId($name, $value).'_filemanager'))
            , $this->generateId($name, $value)
            , $this->getOption('path')
            , $this->generateId($name, $value)
            , $this->getOption('returnFunction') ? "&returnFunction=".$this->getOption('returnFunction') : null
            , $this->getOption('width')
            , $this->getOption('height')
            );
  }
}
