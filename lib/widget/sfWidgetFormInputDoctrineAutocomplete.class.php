<?php

class sfWidgetFormInputDoctrineAutocomplete extends sfWidgetFormInputAutocomplete
{
  /**
   * @param array $options     An array of options
   * @param array $attributes  An array of default HTML attributes
   *
   * @see sfWidgetFormInputAutocomplete
   */
  protected function configure($options = array(), $attributes = array())
  {
    parent::configure($options, $attributes);
    $this->addRequiredOption('model');
    $this->addOption('column');
    $this->addOption('query');
    $this->addOption('render', '__toString');
  }
  
  public function render($name, $value = null, $attributes = array(), $errors = array())
  {
    if($value) {
      if($query = $this->getOption('query')) {
        $query = clone $query;
      }
      else {
        $query = Doctrine_Core::getTable($this->getOption('model'))->createQuery();
      }
      if($this->getOption('multi')) {
        $objects = $query->andWhereIn(sprintf('%s.%s', $query->getRootAlias(), $this->getColumn()), $value)
                         ->select(sprintf('%s.%s AS value', $query->getRootAlias(), $this->getReturnColumn()))
                         ->execute();
        $results = array();
        foreach($objects as $object) {
          $results[] = $object->{$this->getOption('render')}();
        }
        $value = count($results) ? implode(", ", $results) : $value;
      }
      else {
        $object = $query->andWhere(sprintf('%s.%s = ?', $query->getRootAlias(), $this->getColumn()), $value)->fetchOne();
        $value = $object ? $object->{$this->getOption('render')}() : $value;
      }
    }
    return parent::render($name, $value, $attributes, $errors);
  }

  /**
   * Returns the column to use for comparison.
   *
   * The primary key is used by default.
   *
   * @return string The column name
   */
  protected function getColumn()
  {
    $table = Doctrine_Core::getTable($this->getOption('model'));
    if ($this->getOption('column'))
    {
      $columnName = $this->getOption('column');
    }
    else
    {
      $identifier = (array) $table->getIdentifier();
      $columnName = current($identifier);
    }

    return $table->getColumnName($columnName);
  }

}