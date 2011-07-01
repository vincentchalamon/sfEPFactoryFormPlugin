<?php

class sfWidgetFormTimestamp extends sfWidgetFormDateJQueryUI
{
  /**
   * Prepare widget
   * 
   * @param array $options
   * @param array $attributes
   */
  protected function configure($options = array(), $attributes = array()) {
    parent::configure($options, $attributes);
    $this->addOption('widget');
  }

  /**
   * @param  string $name        The element name
   * @param  string $value       The date displayed in this widget
   * @param  array  $attributes  An array of HTML attributes to be merged with the default HTML attributes
   * @param  array  $errors      An array of errors for the field
   *
   * @return string An HTML tag string
   *
   * @see sfWidgetForm
   */
  public function render($name, $value = null, $attributes = array(), $errors = array())
  {
    $widget = $this->getOption('widget') ? $this->getOption('widget') : new sfWidgetFormInputText();
    return "<div class='sf_widget_timestamp'>".parent::render($name."[date]", $value ? date('Y-m-d', strtotime($value)) : null, $attributes, $errors).$widget->render($name."[hour]", $value ? date('H\hi', strtotime($value)) : null, $widget->getAttributes(), $errors)."</div><div style='clear: both;'></div>";
  }

  public function getJavaScripts() {
    $widget = $this->getOption('widget') ? $this->getOption('widget') : new sfWidgetFormInputText($this->getOption('options'), $this->getOption('attributes'));
    return array_merge(parent::getJavaScripts(), $widget->getJavaScripts());
  }

  public function getStylesheets() {
    $widget = $this->getOption('widget') ? $this->getOption('widget') : new sfWidgetFormInputText($this->getOption('options'), $this->getOption('attributes'));
    return array_merge(parent::getStylesheets(), $widget->getStylesheets());
  }

}
