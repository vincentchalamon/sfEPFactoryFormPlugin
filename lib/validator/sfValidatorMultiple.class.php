<?php
class sfValidatorMultiple extends sfValidatorBase
{
  protected function configure($options = array(), $messages = array())
  {
    parent::configure($options, $messages);
    $this->addRequiredOption("validators");
  }
  
  protected function doClean($values)
  {
    $validators = $this->getOption("validators");
    if(!is_array($validators) || !count($validators)) throw new sfException("Vous devez passer un tableau de validateurs.", 500);
    if(!is_array($values)) return array();
    foreach($values as $id => $value)
    {
      foreach($validators as $name => $validator)
      {
        if(!isset($value[$name])) $value[$name] = false;
        $values[$id][$name] = $validator->clean($value[$name]);
      }
    }
    return $values;
  }
}
