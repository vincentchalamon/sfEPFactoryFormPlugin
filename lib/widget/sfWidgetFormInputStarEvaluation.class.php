<?php
/**
 * sfWidgetFormInputStarEvaluation represents an evaluation with stars
 *
 * @package    symfony
 * @subpackage widget
 * @author     Vincent CHALAMON <vincentchalamon@gmail.com>
 * @version    SVN: $Id: sfWidgetFormInputStarEValuation.class.php 68 2009-06-19 04:33:41Z hlwebs $
 */
class sfWidgetFormInputStarEvaluation extends sfWidgetFormInputHidden
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
    $this->addRequiredOption('max');
    $this->addOption('size', 16);
  }

  public function isHidden() {
    return false;
  }
  
  public function render($name, $value = null, $attributes = array(), $errors = array())
  {
    return sprintf(<<<EOF
<script>
  $(document).ready(function(){
    var o = null;
    SV.init({
      num : %s,
      size : %s,
      hoverCss : "hover",
      unhoverCss : "unhover",
      onclick : function(e){
        $('#%s').val(o.point());
      }
    });
    o = $("#%s_star").attach(%s);
  });
</script>
<div id="%s_star"></div>
EOF
            , $this->getOption('max')
            , $this->getOption('size')
            , $this->generateId($name, $value)
            , $this->generateId($name, $value)
            , (int)$value
            , $this->generateId($name, $value)
            ).parent::render($name, $value, $attributes, $errors);
  }

  public function getJavaScripts() {
    return array('/sfEPFactoryFormPlugin/js/jquery.min.js', '/sfEPFactoryFormPlugin/starEvaluation/starEvaluation.jQuery.js');
  }
}