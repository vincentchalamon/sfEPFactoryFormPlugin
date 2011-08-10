<?php

class sfWidgetFormTimestamp extends sfWidgetFormDateJQueryUI
{
  protected function configure($options = array(), $attributes = array()) {
    parent::configure($options, $attributes);
    $this->addOption("stepHour", 1);
    $this->addOption("stepMinute", 1);
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
    $pattern = "/^(\d{4})-(\d{1,2})-(\d{1,2}) (\d{1,2}):(\d{1,2}):(\d{1,2})$/i";
    return $this->renderTag('input', array_merge(array('type' => $this->getOption('type'), 'name' => $name, 'value' => preg_replace($pattern, "$3/$2/$1 $4H$5", $value)), $attributes)).sprintf(<<<EOF
<script type="text/javascript">
$(function() {
  %s
  $("#%s").datetimepicker({
    hour: %s,
    minute: %s,
    timeFormat : 'hhHmm',
    stepHour: %s,
    stepMinute: %s,
    hourGrid: 4,
    minuteGrid: 15,
    regional : '%s',
    changeMonth : %s,
    changeYear : %s,
    numberOfMonths : %s,
    dateFormat: 'dd/mm/yy',
    showButtonPanel : %s,
    minDate: %s
  });
});
</script>
EOF
            , $this->getOption('culture') != "en" ? "$.timepicker.regional['".$this->getOption('culture')."'];\n  $.datepicker.regional['".$this->getOption('culture')."'];" : null
            , $this->generateId($name, $value)
            , preg_match($pattern, $value) ? preg_replace($pattern, "$4", $value) : 0
            , preg_match($pattern, $value) ? preg_replace($pattern, "$5", $value) : 0
            , $this->getOption('stepHour')
            , $this->getOption('stepMinute')
            , $this->getOption('culture')
            , $this->getOption("change_month") ? "true" : "false"
            , $this->getOption("change_year") ? "true" : "false"
            , $this->getOption("number_of_months")
            , $this->getOption("show_button_panel") ? "true" : "false"
            , $this->getOption("show_previous_dates") ? "null" : "new Date()"
            );
  }

  public function getJavaScripts() {
    $javascripts = array("/sfEPFactoryFormPlugin/timepicker/timepicker.jQuery.js");
    $culture = $this->getOption('culture');
    if($culture != 'en') {
      $javascripts[] = "/sfEPFactoryFormPlugin/jqueryui/i18n/ui.timepicker-$culture.js";
    }
    return array_merge(parent::getJavaScripts(), $javascripts);
  }

  public function getStylesheets() {
    return array_merge(parent::getStylesheets(), array("/sfEPFactoryFormPlugin/timepicker/timepicker.css" => "screen"));
  }

}
