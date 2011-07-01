<?php

class sfValidatorTimestamp extends sfValidatorDateTime
{
  const DEFAULT_BIRTHDATE_VALID_PATTERN = '~(?P<day>\d{2})/(?P<month>\d{2})/(?P<year>\d{4}) (?P<hour>\d{2})h(?P<minute>\d{2})~';
  
  protected function configure($options = array(), $messages = array())
  {
    parent::configure($options, $messages);
    $this->setOption('date_format', self::DEFAULT_BIRTHDATE_VALID_PATTERN);
  }

  protected function doClean($value) {
    if(!is_array($value)) {
      $value = array();
    }
    return parent::doClean(isset($value['date']) && isset($value['hour']) ? $value['date'].' '.$value['hour'] : null);
  }
}
