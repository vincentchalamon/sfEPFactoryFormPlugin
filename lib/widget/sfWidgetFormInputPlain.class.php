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
  
  public function render($name, $values = null, $attributes = array(), $errors = array())
  {
    if($this->hasOption('value') && !is_null($this->getOption('value'))) {
      $field = $this->getOption('value');
    }
    elseif(is_object($values) && $values instanceof Doctrine_Collection) {
      $render = "";
      foreach($values as $value) {
        $render.= sprintf("<li><span>%s</span>%s</li>", (string)$value, parent::render($name."[]", $value->getPrimaryKey(), $attributes, $errors));
      }
      return "<ul>$render</ul>";
    }
    else {
      $field = $values;
      // Time
      if(preg_match('/^(\d{2}):(\d{2}):(\d{2})$/', $values)) {
        $field = date('H\hi', strtotime($values));
      }
      // Date
      elseif(preg_match('/^(\d{4})-(\d{2})-(\d{2})$/', $values)) {
        $field = date('d/m/Y', strtotime($values));
      }
      // Timestamp
      elseif(preg_match('/^(\d{4})-(\d{2})-(\d{2})[ T](\d{2}):(\d{2}):(\d{2})$/', $values)) {
        $field = date('d/m/Y H\hi', strtotime($values));
      }
    }
    return "<span>$field</span>".parent::render($name, $values, $attributes, $errors);
  }
}