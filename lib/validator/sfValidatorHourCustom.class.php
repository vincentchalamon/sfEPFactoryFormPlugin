<?php
/**
* 
*/
class sfValidatorHourCustom extends sfValidatorTime
{
  protected function doClean($value) {
    if(!preg_match('/(\d{2})h(\d{2})/i', $value)) {
      throw new sfValidatorError($this, 'invalid', array('value' => $value));
    }
    return parent::doClean(array('hour' => preg_replace('/(\d{2})h(\d{2})/i', '$1', $value), 'minute' => preg_replace('/(\d{2})h(\d{2})/i', '$2', $value)));
  }
}
