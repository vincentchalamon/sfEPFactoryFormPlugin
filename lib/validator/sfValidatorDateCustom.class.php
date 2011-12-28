<?php

class sfValidatorDateCustom extends sfValidatorDate
{
  const DEFAULT_BIRTHDATE_VALID_PATTERN = '~(?P<day>\d{2})/(?P<month>\d{1,2})/(?P<year>\d{4})~';
  
  protected function configure($options = array(), $messages = array())
  {
    parent::configure($options, $messages);
    $this->setOption('date_format', self::DEFAULT_BIRTHDATE_VALID_PATTERN);
  }
}
