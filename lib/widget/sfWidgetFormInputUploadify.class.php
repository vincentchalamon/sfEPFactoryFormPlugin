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
    $this->addOption('editable', true);
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
    if(is_array($value)) {
      $value = implode(";", $value);
    }
    // Prepare rendering
    $render = "";
    if($this->getOption('editable') && $value) {
      $render.= sprintf('<div class="uploadifyQueue uploadifyQueueCustom" id="%s_listQueue_custom">', $this->generateId($name, $value));
      $filenames = array();
      foreach(explode(';', $value) as $filename) {
        if(is_file(sfConfig::get('sf_web_dir').$filename)) {
          $filenames[]= $filename;
          $hash = "";
          for($i = 0; $i <= 5; $i++) {
            $hash.= strtoupper(chr(rand(65, 90)));
          }
          $render.= sprintf(<<<EOF
  <div class="uploadifyQueueItem completed">
    <div class="cancel">
      <a href="#" rel="%s">
        <img border="0" src="/sfEPFactoryFormPlugin/uploadify/cancel.png" />
      </a>
    </div>
    <span class="fileName">%s (%s KB)</span>
    <span class="percentage"> - Completed</span>
  </div>
EOF
                  , $filename
                  , strlen(basename($filename)) > 20 ? substr(basename($filename), 0, 20)."..." : basename($filename)
                  , filesize(sfConfig::get('sf_web_dir').$filename)/1000
                  );
        }
      }
      $value = implode(";", $filenames);
      $render.= "</div>";
    }
    if($this->getOption('addScript')) {
      $render.= $this->getScript("#".$this->generateId($name, $value));
    }
    return parent::render($name, $value, $attributes, $errors).$render;
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
      'onComplete'      : function(event, ID, fileObj, response, data) {
        if(response.match(/^error/i)) {
          %s(response.substr(6));
        }
        else {
          $(event.target).val(%s ? $(event.target).val() + ($(event.target).val().length ? ";" : "") + response : response);
          $('#' + $(event.target).attr('id') + ID).append('<span style="display: none" class="value">' + response + '</span>');
        }
      },
      'onCancel'        : function(event, ID, fileObj, data) {
        $(event.target).val($(event.target).val().replace($('#' + $(event.target).attr('id') + ID + ' .value').html(), '').replace(/[;]{1,}/i, ';').replace(/^;(.*)/i, '$1').replace(/(.*);$/i, '$1'));
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
    $('%s').siblings('.uploadifyQueueCustom').find('.cancel a').click(function(event){
      event.preventDefault();
      var input = $(this).parents('.uploadifyQueueCustom:first').siblings('input:text.uploadify');
      input.val(input.val().replace($(this).attr('rel'), '').replace(/[;]{1,}/i, ';').replace(/^;(.*)/i, '$1').replace(/(.*);$/i, '$1'));
      $(this).parents('.uploadifyQueueItem:first').fadeOut(500, function(){
        $(this).remove();
      });
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
            , $name
          );
  }

  public function getJavaScripts() {
    return array('/sfEPFactoryFormPlugin/js/jquery.min.js', '/sfEPFactoryFormPlugin/uploadify/swfobject.js', '/sfEPFactoryFormPlugin/uploadify/jquery.uploadify.v2.1.4.min.js');
  }

  public function getStylesheets() {
    return array('/sfEPFactoryFormPlugin/uploadify/uploadify.css' => 'screen');
  }

}
