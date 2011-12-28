<?php

class sfWidgetFormInputSwitch extends sfWidgetFormSelectRadio {

  public function render($name, $value = null, $attributes = array(), $errors = array()) {
    if(isset($attributes['class'])) {
      $attributes['class'].= " noTransform";
    }
    else {
      $attributes['class'] = "noTransform";
    }
    return $this->renderContentTag("span", parent::render($name, $value, $attributes, $errors), array('class' => "switch"));
  }

  public function getStylesheets() {
    return array('/sfEPFactoryFormPlugin/switcher/js-switcher.css' => 'all');
  }

  public function getJavaScripts() {
    return array('/sfEPFactoryFormPlugin/js/jquery.min.js', '/sfEPFactoryFormPlugin/switcher/switcher.js');
  }

  protected function formatChoices($name, $value, $choices, $attributes) {
    $inputs = array();
    $i = 0;
    foreach($choices as $key => $option) {
      $baseAttributes = array(
          'name' => substr($name, 0, -2),
          'type' => 'radio',
          'value' => self::escapeOnce($key),
          'id' => $id = $this->generateId($name, self::escapeOnce($key)),
      );
      $labelClass = $i % 2 == 0 ? "cb-enable" : "cb-disable";
      if(strval($key) == strval($value === false ? 0 : $value)) {
        $labelClass.= " selected";
        $baseAttributes['checked'] = 'checked';
      }
      $inputs[$id] = array(
          'input' => $this->renderTag('input', array_merge($baseAttributes, $attributes)),
          'label' => $this->renderContentTag('label', $this->renderContentTag("span", self::escapeOnce($option)), array('for' => $id, 'class' => $labelClass)),
      );
      $i++;
    }
    return call_user_func($this->getOption('formatter'), $this, $inputs);
  }

  public function formatter($widget, $inputs) {
    $rows = "";
    foreach($inputs as $input) {
      $rows.= $input['input'];
    }
    foreach($inputs as $input) {
      $rows.= $input['label'];
    }
    return $rows;
  }

}
