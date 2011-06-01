<?php
/*
 * This file is part of the HLW package.
 * (c) Daniel Santiago <daniel.santiago@highlevelwebs.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
/**
 * sfWidgetFormInputPlain represents a hidden HTML input tag with a span element with the value.
 *
 * @package    symfony
 * @subpackage widget
 * @author     Daniel Santiago <daniel.santiago@highlevelwebs.com>
 * @version    SVN: $Id: sfWidgetFormInputPlain.class.php 68 2009-06-19 04:33:41Z hlwebs $
 */
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
      $field = "<span>$value</span>";
      // Time
      if(preg_match('/(\d{2}):(\d{2}):(\d{2})/', $value)) {
        $field = "<span>".preg_replace('/(\d{2}):(\d{2}):(\d{2})/', '$1h$2', $value)."</span>";
      }
      // Date
      if(preg_match('/(\d{4})-(\d{2})-(\d{2})/', $value)) {
        $field = "<span>".preg_replace('/(\d{4})-(\d{2})-(\d{2})/', '$3/$2/$1', $value)."</span>";
      }
    }
    return $field.parent::render($name, $value, $attributes, $errors);
  }
}