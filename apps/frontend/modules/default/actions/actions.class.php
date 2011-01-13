<?php

/**
 * default actions.
 *
 * @package    scratch001
 * @subpackage default
 * @author     xcezx
 * @version    SVN: $Id$
 */
require_once(sfConfig::get('sf_plugins_dir') . '/dinoTwitterOAuthPlugin/modules/dinoTwitterOAuth/lib/BaseDinoTwitterOAuthActions.class.php');

class defaultActions extends BaseDinoTwitterOAuthActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    $form = new sfForm();
    $form->setWidgets(array(
        'status' => new sfWidgetFormTextarea(array('label' => '今何してる?')),
      ));
    $this->form = $form;
  }

  public function executeAuth()
  {
    $this->forward404Unless($this->getRequest()->getMethod() === sfRequest::POST);
    $this->getUser()->setAttribute('status', $this->getRequestParameter('status'), 'twitter');

    return parent::executeAuth();
  }

  public function executeTwit(sfWebRequest $request)
  {
    $status = $this->getUser()->getAttribute('status', null, 'twitter');

    $twit = new dinoTwitterOAuth();
    $twit->setAccessToken($this->getUser()->getAttribute('access_token', null, 'twitter'));
    $twit->setAccessTokenSecret($this->getUser()->getAttribute('access_token_secret', null, 'twitter'));

    $this->res = $twit->tweet($status);
  }
}
