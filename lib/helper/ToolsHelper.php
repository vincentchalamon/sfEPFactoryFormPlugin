<?php

/**
 * Convert a Doctrine_Query object to SQL string
 * 
 * @param Doctrine_Query $requete Query
 * @return String Converted query
 */
function convertDqlToSql(Doctrine_Query $requete) {
  $params = $requete->getParams();
  $query = $requete->getSqlQuery();
  foreach($params['where'] as $param) {
    if(is_array($param)) {
      $query = join(implode(', ', $param), explode('?', $query, 2));
    }
    else {
      $param = htmlspecialchars($param, ENT_QUOTES, sfConfig::get('sf_charset'));
      $query = join(var_export(is_scalar($param) ? $param : (string)$param, true), explode('?', $query, 2));
    }
  }
  return $query;
}

/**
 * Convert seconds to time
 *
 * @param string $time Seconds
 * @return string Time
 */
function convert_seconds_to_time($time) {
  // calcul du nombre d'heures
  $heures = floor($time / 3600);
  if($heures < 10) {
    $heures = "0".$heures;
  }
  // calcul du nombre de minutes
  $min = floor(($time - ($heures * 3600)) / 60);
  if($min < 10) {
    $min = "0".$min;
  }
  // combien de secondes
  $sec = floor($time - ($heures * 3600) - ($min * 60));
  if($sec < 10) {
    $sec = "0".$sec;
  }
  return "$heures:$min:$sec";
}