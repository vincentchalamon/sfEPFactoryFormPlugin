<?php

class BasesfEPFactoryFormActions extends sfActions
{
  /**
   * Generate autocomplete
   * 
   * @param sfWebRequest $request
   * @return string
   */
  public function executeAutocomplete(sfWebRequest $request) {
    $this->forward404Unless($request->isXmlHttpRequest() && $request->hasParameter('q') && $request->hasParameter('model'));
    $columns = $request->hasParameter('column') ? array($request->getParameter('column')) : array('name', 'title', 'description', 'subject', 'keywords', 'id');
    $table = Doctrine_Core::getTable($request->getParameter('model'));
    foreach($columns as $columnName)
    {
      if($table->hasColumn($columnName))
      {
        $identifier = $table->getIdentifier();
        $query = $table->createQuery()
                       ->select(sprintf('%s, %s', $table->getColumnName(is_array($identifier) ? current($identifier) : $identifier), $columnName))
                       ->where("$columnName LIKE ?", "%".$request->getParameter("q")."%");
        if($table->hasColumn('is_active'))
        {
          $query->andWhere('is_active = 1');
        }
        if($table->hasTemplate('SoftDelete'))
        {
          $query->andWhere('deleted_at IS NULL');
        }
        $objects = $query->limit(10)->fetchArray();
        return $this->renderText(json_encode($objects));
      }
    }
    throw new sfException("Unable to find a column to render object");
  }
  
  public function executeUploadify(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod("post"));
    sfConfig::set('sf_web_debug', false);
    try {
      // Récupère le fichier envoyé
      $file = $request->getFiles('Filedata');
      if (!$file || !is_array($file) || !count($file)) {
        $error = "No file to upload.";
      }
      elseif ($file['error']) {
        switch ($file['error']) {
          // UPLOAD_ERR_INI_SIZE
          case 1:
            $error = "Le fichier dépasse la limite autorisée par le serveur !";
            break;
          // UPLOAD_ERR_FORM_SIZE
          case 2:
            $error = "Le fichier dépasse la limite autorisée dans le formulaire HTML !";
            break;
          // UPLOAD_ERR_PARTIAL
          case 3:
            $error = "L'envoi du fichier a été interrompu pendant le transfert !";
            break;
          // UPLOAD_ERR_NO_FILE
          case 4:
            $error = "Le fichier que vous avez envoyé a une taille nulle !";
            break;
        }
      }
      if (isset($error)) {
        return $this->renderText("error:".$error);
      }
      // Génère les noms de répertoire et fichier définitif
      $targetRelativePath = DIRECTORY_SEPARATOR.trim($request->getParameter("folder"), DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR;
      $targetPath = sfConfig::get("sf_web_dir").$targetRelativePath;
      $savedFileName = strtolower(sha1($file['tmp_name']).".".pathinfo($file['name'], PATHINFO_EXTENSION));
      // Crée le répertoire cible s'il n'existe pas et force l'écriture
      if(!is_dir($targetPath)) {
        mkdir($targetPath, 0777);
      }
      // Déplace le fichier temporaire vers le répertoire cible
      if(!move_uploaded_file($file['tmp_name'], $targetPath.$savedFileName)) {
        throw new sfException("Impossible de déplacer le fichier ".$file['tmp_name']." vers $targetPath$savedFileName.");
      }
      // Génère une erreur si le fichier n'existe pas (droits sur le répertoire)
      if(!is_file($targetPath.$savedFileName)) {
        throw new sfException("Impossible d'uploader le fichier $targetPath$savedFileName.");
      }
      // Force l'écriture
      chmod($targetPath.$savedFileName, 0777);
    }
    catch(Exception $error) {
      // Retourne l'erreur
      return $this->renderText("error:".$error->getMessage());
    }
    // Retourne le nom relatif du fichier
    return $this->renderText($targetRelativePath.$savedFileName);
  }
}
