<?php

class BasesfEPFactoryFormActions extends sfActions
{
  public function executeUploadify($request)
  {
    $this->forward404Unless($request->isMethod("post"));
    sfConfig::set('sf_web_debug', false);
    try {
      // Récupère le fichier envoyé
      $file = $request->getFiles('Filedata');
      if(!$file || !is_array($file) || !count($file)) {
        throw new sfException('No file to upload.');
      }
      // Génère les noms de répertoire et fichier définitif
      $targetRelativePath = DIRECTORY_SEPARATOR.trim($request->getParameter("folder"), DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR;
      $targetPath = sfConfig::get("sf_web_dir").$targetRelativePath;
      $savedFileName = sha1($file['tmp_name']).".".pathinfo($file['name'], PATHINFO_EXTENSION);
      // Crée le répertoire cible s'il n'existe pas et force l'écriture
      if(!is_dir($targetPath)) {
        mkdir($targetPath, 0777);
      }
      // Déplace le fichier temporaire vers le répertoire cible
      move_uploaded_file($file['tmp_name'], $targetPath.$savedFileName);
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
