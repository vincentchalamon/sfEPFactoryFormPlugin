<?php

class sfValidatorDoctrineAutocomplete extends sfValidatorBase {

  protected function configure($options = array(), $messages = array()) {
    parent::configure($options, $messages);
    $this->addRequiredOption('model');
    $this->addOption('query', null);
    $this->addOption('column', null);
    $this->addOption('return_column');
    $this->addOption('multiple', false);
    $this->addOption('autosave', false);
    $this->addMessage('autosave', "Une erreur est survenue durant l'enregistrement automatique de l'objet %value% : %message%.");
  }

  protected function doClean($value) {
    if($query = $this->getOption('query')) {
      $query = clone $query;
    }
    else {
      $query = Doctrine_Core::getTable($this->getOption('model'))->createQuery();
    }
    if($this->getOption("multiple")) {
      // Retrieve objects
      $objects = $query->andWhereIn(sprintf('%s.%s', $query->getRootAlias(), $this->getColumn()), explode(", ", $value))
                       ->execute();
      $results = $objects->toKeyValueArray($this->getReturnColumn(), $this->getColumn());
      foreach(explode(", ", $value) as $valeur) {
        // Autosave : create object
        if(!in_array($valeur, array_values($results))) {
          if($this->getOption('autosave')) {
            $object = $this->createObject($valeur);
            // Add object to return array
            $results[$object[$this->getReturnColumn()]] = $object[$this->getColumn()];
          }
          else {
            throw new sfValidatorError($this, 'invalid', array('value' => $value));
          }
        }
      }
      return array_keys($results);
    }
    else {
      // Retrieve object
      $object = $query->andWhere(sprintf('%s.%s = ?', $query->getRootAlias(), $this->getColumn()), $value)->fetchOne();
      // Autosave : create object
      if(!$object) {
        if($this->getOption('autosave')) {
          $object = $this->createObject($value);
        }
        else {
          throw new sfValidatorError($this, 'invalid', array('value' => $value));
        }
      }
      return $object ? $object[$this->getReturnColumn()] : null;
    }
  }

  protected function createObject($value) {
    try {
      $class = $this->getOption('model');
      $object = new $class();
      $object[$this->getColumn()] = $value;
      $object->save();
      return $object;
    }
    catch(Exception $error) {
      throw new sfValidatorError($this, 'autosave', array('value' => $value, 'message' => $error->getMessage()));
      return false;
    }
  }

  /**
   * Returns the column to use for comparison.
   *
   * The primary key is used by default.
   *
   * @return string The column name
   */
  protected function getColumn() {
    $table = Doctrine_Core::getTable($this->getOption('model'));
    if($this->getOption('column')) {
      $columnName = $this->getOption('column');
    }
    else {
      $identifier = (array) $table->getIdentifier();
      $columnName = current($identifier);
    }
    return $table->getColumnName($columnName);
  }

  /**
   * Returns the column to use for return
   *
   * The primary key is used by default.
   *
   * @return string The column name
   */
  protected function getReturnColumn() {
    $table = Doctrine_Core::getTable($this->getOption('model'));
    if($this->getOption('return_column')) {
      $columnName = $this->getOption('return_column');
    }
    else {
      $identifier = (array) $table->getIdentifier();
      $columnName = current($identifier);
    }
    return $table->getColumnName($columnName);
  }

}