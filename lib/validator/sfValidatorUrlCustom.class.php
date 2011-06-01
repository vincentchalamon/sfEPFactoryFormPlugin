<?php

/*
 * This file is part of the symfony package.
 * (c) Fabien Potencier <fabien.potencier@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * sfValidatorUrl validates Urls.
 *
 * @package    symfony
 * @subpackage validator
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 * @version    SVN: $Id: sfValidatorUrl.class.php 22149 2009-09-18 14:09:53Z Kris.Wallsmith $
 */
class sfValidatorUrlCustom extends sfValidatorRegex
{
  const REGEX_URL_FORMAT = "~^/([A-z\d_\-/#]+)?$~ix";
  const SYMFONY_REGEX_URL_FORMAT = "~^(/([A-z\d\_\-/#]+)?|(@[A-z\_\-\d]+)|([A-z\_\-\d]+/[A-z\_\-\d]+))$~ix";

  /**
   * Available options:
   *
   *  * protocols: An array of acceptable URL protocols (http, https, ftp and ftps by default)
   *
   * @param array $options   An array of options
   * @param array $messages  An array of error messages
   *
   * @see sfValidatorRegex
   */
  protected function configure($options = array(), $messages = array())
  {
    parent::configure($options, $messages);
    $this->setOption('pattern', self::REGEX_URL_FORMAT);
    $this->addMessage('exist', "L'url %value% existe déjà !");
    $this->addOption('allow_symfony_routes', false);
  }

  public function getPattern()
  {
    return $this->getOption("allow_symfony_routes") ? self::SYMFONY_REGEX_URL_FORMAT : self::REGEX_URL_FORMAT;
  }

  protected function doClean($value)
  {
    // Force http default protocol
    if(substr($value, 0, 1) != "/" && !$this->getOption("allow_symfony_routes")) $value = "/$value";
    // Clean routing
    foreach(sfYaml::load(sfConfig::get('sf_app_config_dir').'/routing.yml') as $route)
    {
      if((isset($route['url']) && $value == $route['url'])
        || (isset($route['class']) && $route['class'] == "sfDoctrineRouteCollection" && preg_match(sprintf("~^%s~i", $route['options']['prefix_path']), $value)))
      {
        throw new sfValidatorError($this, 'exist', array('value' => $value));
      }
    }
    return parent::doClean($value);
  }
}
