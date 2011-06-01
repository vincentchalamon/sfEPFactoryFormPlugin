<?php

class sfWidgetFormInputToken extends sfWidgetFormInputText {

  protected function configure($options = array(), $attributes = array()) {
    parent::configure($options, $attributes);
    $this->addRequiredOption("url");
  }

  public function render($name, $value = null, $attributes = array(), $errors = array()) {
    $values = "";
    if(is_string($value)) {
      $value = strlen($value) ? explode(',', $value) : array();
    }
    foreach($value as $object) {
      $values.= sprintf('{id: "%s", name: "%s"},', $object, $object);
    }
    return parent::render($name, $value, $attributes, $errors).sprintf(<<<EOF
<script type="text/javascript">
$("#%s").tokenInput("%s", {
  theme: "facebook",
  method: "POST",
  preventDuplicates: true,
  hintText: "Saisissez une recherche...",
  noResultsText: "Aucun résultat",
  searchingText: "Recherche en cours...",
  prePopulate: %s
});
</script>
EOF
            , $this->generateId($name, $value)
            , $this->getOption("url")
            , count($value) ? "[".substr($values, 0, -1)."]" : "null"
    );
  }

  public function getJavaScripts() {
    return array('/sfEPFactoryFormPlugin/jquery-tokeninput/jquery.tokeninput.js');
  }

  public function getStylesheets() {
    return array('/sfEPFactoryFormPlugin/jquery-tokeninput/token-input.css' => 'screen', '/sfEPFactoryFormPlugin/jquery-tokeninput/token-input-facebook.css' => 'screen');
  }

}