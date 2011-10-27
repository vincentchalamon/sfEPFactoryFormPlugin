<?php

class sfWidgetFormInputPlain extends sfWidgetFormInputHidden
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
    $this->setOption('is_hidden', false);
    $this->addOption('value');
  }
  
  public function render($name, $value = null, $attributes = array(), $errors = array())
  {
    if($this->hasOption('value') && !is_null($this->getOption('value'))) {
      $field = $this->getOption('value');
    }
    else {
      $field = $value;
      // Time
      if(preg_match('/^(\d{2}):(\d{2}):(\d{2})$/', $value)) {
        $field = date('H\hi', strtotime($value));
      }
      // Date
      elseif(preg_match('/^(\d{4})-(\d{2})-(\d{2})$/', $value)) {
        $field = date('d/m/Y', strtotime($value));
      }
      // Timestamp
      elseif(preg_match('/^(\d{4})-(\d{2})-(\d{2})[ T](\d{2}):(\d{2}):(\d{2})$/', $value)) {
        $field = date('d/m/Y H\hi', strtotime($value));
      }
    }
    return "<span>$field</span>".parent::render($name, $value, $attributes, $errors);
  }
}