<?php

/**
 * @author     Artur Rozek
 * @version    1.0.0
 */
class sfWidgetFormDateJQueryUI extends sfWidgetFormInputText
{

  /**
   * Configures the current widget.
   *
   * Available options:
   *
   * @param string   culture           Sets culture for the widget
   * @param boolean  change_month      If date chooser attached to widget has month select dropdown, defaults to false
   * @param boolean  change_year       If date chooser attached to widget has year select dropdown, defaults to false
   * @param integer  number_of_months  Number of months visible in date chooser, defaults to 1
   * @param boolean  show_button_panel If date chooser shows panel with 'today' and 'done' buttons, defaults to false
   * @param string   theme             css theme for jquery ui interface, defaults to '/sfEPFactoryFormPlugin/jqueryui/smoothness/jquery-ui.css'
   *
   * @see sfWidgetForm
   */
  protected function configure($options = array(), $attributes = array())
  {
    $this->addOption('culture', "fr");
    $this->addOption('change_month', false);
    $this->addOption('change_year', false);
    $this->addOption('number_of_months', 1);
    $this->addOption('show_button_panel', false);
    $this->addOption('show_previous_dates', true);
    $this->addOption('inline', false);
    $this->addOption('theme', '/sfEPFactoryFormPlugin/jqueryui/smoothness/jquery-ui.css');
    parent::configure($options, $attributes);
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
    if(preg_match("/(\d{4})-(\d{2})-(\d{2})/", $value)) {
      $value = substr($value, 8, 2).'/'.substr($value, 5, 2).'/'.substr($value, 0, 4);
    }
    if($this->getOption('inline')) {
      $widget = new sfWidgetFormInputHidden();
      return sprintf(<<<EOF
<div id="%s_datepicker"></div>
%s
<script type="text/javascript">
$(function() {
  %s
  $("#%s_datepicker").datepicker({
    regional : '%s',
    changeMonth : %s,
    changeYear : %s,
    numberOfMonths : %s,
    dateFormat: 'dd/mm/yy',
    showButtonPanel : %s,
    minDate: %s,
    onSelect: function(dateText, inst){
      $("#%s").val(dateText);
    }
  });
});
</script>
EOF
              , $this->generateId($name, $value)
              , $widget->render($name, $value, $attributes, $errors)
              , $this->getOption('culture') != "en" ? "$.datepicker.regional['".$this->getOption('culture')."'];" : null
              , $this->generateId($name, $value)
              , $this->getOption('culture')
              , $this->getOption("change_month") ? "true" : "false"
              , $this->getOption("change_year") ? "true" : "false"
              , $this->getOption("number_of_months")
              , $this->getOption("show_button_panel") ? "true" : "false"
              , $this->getOption("show_previous_dates") ? "null" : "new Date()"
              , $this->generateId($name, $value)
              );
    }
    return parent::render($name, $value, $attributes, $errors).sprintf(<<<EOF
<script type="text/javascript">
$(function() {
  %s
  $("#%s").datepicker({
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
            , $this->getOption('culture') != "en" ? "$.datepicker.regional['".$this->getOption('culture')."'];" : null
            , $this->generateId($name, $value)
            , $this->getOption('culture')
            , $this->getOption("change_month") ? "true" : "false"
            , $this->getOption("change_year") ? "true" : "false"
            , $this->getOption("number_of_months")
            , $this->getOption("show_button_panel") ? "true" : "false"
            , $this->getOption("show_previous_dates") ? "null" : "new Date()"
            );
  }

  /*
   *
   * Gets the stylesheet paths associated with the widget.
   *
   * @return array An array of stylesheet paths
   */
  public function getStylesheets()
  {
    return array($this->getOption('theme') => 'screen');
  }

  /**
   * Gets the JavaScript paths associated with the widget.
   *
   * @return array An array of JavaScript paths
   */
  public function getJavaScripts()
  {
    $js = array('/sfEPFactoryFormPlugin/js/jquery.min.js', '/sfEPFactoryFormPlugin/jqueryui/jquery-ui.min.js');
    $culture = $this->getOption('culture');
    if($culture != 'en') {
      $js[] = "/sfEPFactoryFormPlugin/jqueryui/i18n/ui.datepicker-$culture.js";
    }
    return $js;
  }

}
