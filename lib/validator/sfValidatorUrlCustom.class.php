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
  const REGEX_URL_FORMAT = "~^(/([A-z\d\_\-/#]+)?)|(@[A-z\_\-\d]+)|([A-z\_\-\d]+/[A-z\_\-\d]+)|((%s)://(([a-z0-9-]+\.)+[a-z]{2,6}|\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3})(:[0-9]+)?(/?|/\S+))$~ix";

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
    $this->addOption('allow_symfony_routes', false);
    $this->addOption('allow_external_routes', false);
    $this->addOption('protocols', array('http', 'https', 'ftp', 'ftps'));
    $this->setOption('pattern', self::REGEX_URL_FORMAT);
  }

  public function getPattern()
  {
    return sprintf(self::REGEX_URL_FORMAT, implode('|', $this->getOption('protocols')));
  }

  protected function doClean($value)
  {
    // Force http default protocol
    if(substr($value, 0, 1) != "/" && !$this->getOption("allow_symfony_routes") && !$this->getOption("allow_external_routes")) {
      $value = "/$value";
    }
    return parent::doClean($value);
  }
}
