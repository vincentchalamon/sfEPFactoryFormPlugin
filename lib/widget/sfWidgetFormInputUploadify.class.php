<?php

class sfWidgetFormInputUploadify extends sfWidgetFormInputText
{
  protected function configure($options = array(), $attributes = array()) {
    parent::configure($options, $attributes);
    $this->addRequiredOption('url');
    $this->addOption('path', '/uploads');
    $this->addOption('buttonText', 'Parcourir...');
    $this->addOption('checkScript');
    $this->addOption('fileExt');
    $this->addOption('fileDesc');
    $this->addOption('multi', false);
    $this->addOption('max');
    $this->addOption('scriptData');
    $this->addOption('sizeLimit');
    $this->addOption('addScript', true);
    $this->addOption('fullMessage', "Vous ne pouvez uploader que jusqu'à %%max%% fichiers.");
    $this->addOption('errorMessage', "Une erreur est survenue.");
    $this->addOption('alertFunction', "alert");
  }

  public function render($name, $value = null, $attributes = array(), $errors = array())
  {
    if($this->getOption('fileExt') && !$this->getOption('fileDesc')) {
      throw new sfException(get_class($this)." requires fileDesc option when fileExt option is set.");
    }
    if($this->getOption('scriptData') && !is_array($this->getOption('scriptData'))) {
      throw new InvalidArgumentException(get_class($this)." requires scriptData to be array.");
    }
    if(isset($attributes['class'])) {
      $attributes['class'].= " uploadify";
    }
    else {
      $attributes['class'] = "uploadify";
    }
    // Prepare rendering
    $render = parent::render($name, $value, $attributes, $errors);
    if($this->getOption('addScript')) {
      $render.= $this->getScript("#".$this->generateId($name, $value));
    }
    return $render;
  }

  /**
   * Get uploadify script
   *
   * @param string $name Selector name
   * @return string Script
   */
  public function getScript($name)
  {
    return sprintf(<<<EOF
<script type="text/javascript">
  $(document).ready(function() {
    $('%s').uploadify({
      'uploader'        : '/sfEPFactoryFormPlugin/uploadify/uploadify.swf',
      'expressInstall'  : '/sfEPFactoryFormPlugin/uploadify/expressInstall.swf',
      'script'          : '%s',
      'cancelImg'       : '/sfEPFactoryFormPlugin/uploadify/cancel.png',
      'folder'          : '%s',
      'auto'            : true,
      'buttonText'      : '%s',
      'checkScript'     : %s,
      'fileExt'         : %s,
      'fileDesc'        : %s,
      'multi'           : %s,
      'queueSizeLimit'  : %s,
      'removeCompleted' : false,
      'scriptData'      : %s,
      'sizeLimit'       : %s,
      'onComplete'      : function(event, queueID, fileObj, response, data) {
        if(response.match(/^error/i)) {
          %s(response.substr(6));
        }
        else if(%s) {
          $(event.target).val($(event.target).val() + ($(event.target).val().length ? ";" : "") + response);
        }
        else {
          $(event.target).val(response);
        }
      },
      'onQueueFull'     : function(event, queueSizeLimit) {
        %s('%s');
        return false;
      },
      'onError'         : function(event, ID, fileObj, errorObj) {
        %s('%s');
        return false;
      }
    });
  });
</script>
EOF
            , $name
            , str_ireplace("'", "\'", $this->getOption('url'))
            , str_ireplace("'", "\'", $this->getOption('path'))
            , str_ireplace("'", "\'", $this->getOption('buttonText'))
            , $this->getOption('checkScript') ? "'".str_ireplace("'", "\'", $this->getOption('checkScript'))."'" : "null"
            , $this->getOption('fileExt') ? "'".str_ireplace("'", "\'", $this->getOption('fileExt'))."'" : "null"
            , $this->getOption('fileDesc') ? "'".str_ireplace("'", "\'", $this->getOption('fileDesc'))."'" : "null"
            , $this->getOption('multi') ? 'true' : 'false'
            , $this->getOption('max') ? $this->getOption('max') : 999
            , json_encode(array_merge(array('folder' => $this->getOption('path')), $this->getOption('scriptData') ? $this->getOption('scriptData') : array()))
            , $this->getOption('sizeLimit') ? $this->getOption('sizeLimit') : "null"
            , $this->getOption('alertFunction')
            , $this->getOption('multi') ? 'true' : 'false'
            , $this->getOption('alertFunction')
            , str_ireplace("'", "\'", str_ireplace('%%max%%', $this->getOption('max'), $this->getOption('fullMessage')))
            , $this->getOption('alertFunction')
            , str_ireplace("'", "\'", $this->getOption('errorMessage'))
          );
  }

  public function getJavaScripts() {
    return array('/sfEPFactoryFormPlugin/js/jquery.min.js', '/sfEPFactoryFormPlugin/uploadify/swfobject.js', '/sfEPFactoryFormPlugin/uploadify/jquery.uploadify.v2.1.4.min.js');
  }

  public function getStylesheets() {
    return array('/sfEPFactoryFormPlugin/uploadify/uploadify.css' => 'screen');
  }

}
