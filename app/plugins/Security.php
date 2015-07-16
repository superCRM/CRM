<?php
/**
 * Created by PhpStorm.
 * User: unevmerzhuzkiy
 * Date: 7/8/15
 * Time: 5:39 PM
 */

namespace Plagins;

use Phalcon\Events\Event,
    Phalcon\Mvc\Dispatcher,
    Phalcon\Mvc\User\Plugin,
	CRM\Agent;



class Security extends Plugin
{

    public function setCookie($agent)
	{
		$this->cookies->set('remember-me',$agent->setCookie(),time()+ 15 * 86400);
	}

    public function beforeExecuteRoute(Event $event, Dispatcher $dispatcher)
    {
        // Проверяем, установлена ли в куках переменная "remember-me" для определения agent`а.
		if($this->cookies->has('remember-me'))
		{
			$rememberMe = $this->cookies->get('remember-me');
			$value = $rememberMe->getValue();
			$agent = Agent::getAgentByCookie($value);
			//var_dump($agent);
			if($agent){
				$this->session->set('agentId',$agent->id);
				$this->session->set('login',$agent->login);
                if($rememberMe->getExpiration()<time()+24*3600)
				    $this->setCookie($agent);
                //$this->cookies->set('remember-me',$agent->setCookie(),time()+ 15 * 86400);
			}
			
		}
		
		// Проверяем, установлена ли в сессии переменная "agentId" для определения активной роли.
        $auth = $this->session->get('agentId');
        if (!$auth) {
            $role = 'Guests';
        } else {
            $role = 'Users';
        }

        // Получаем активные контроллер и действие от диспетчера
        $controller = $dispatcher->getControllerName();
        $action = $dispatcher->getActionName();
		
        // Получаем список ACL
        $acl = $this->acl;

        $allowed = $acl->isAllowed($role, $controller, $action);
        // Проверяем, имеет ли данная роль доступ к контроллеру (ресурсу)
		
		/*var_dump($role);
		var_dump($controller);
		var_dump($action);
		var_dump($allowed);*/
		//exit();
        if($role=='Guests'){

            if ($allowed == \Phalcon\Acl::DENY) {

                // Если доступа нет, перенаправляем его на контроллер "index".
                $this->flashSession->error("You don't have access to this module");
                $dispatcher->forward(
                    array(
                        'controller' => 'index',
                        'action' => 'index'
                    )
                );

                // Возвращая "false" мы приказываем диспетчеру прекратить текущую операцию
                return false;
            }
        }

        if($role=='Users'){
            if ($allowed == \Phalcon\Acl::DENY) {

                // Если доступа нет, перенаправляем его на контроллер "refund".

                /*$dispatcher->forward(
                    array(
                        'controller' => 'refund',
                        'action' => 'index'
                    )
                );*/

                return $this->response->redirect("/agent");
                // Возвращая "false" мы приказываем диспетчеру прекратить текущую операцию
                //return false;
            }
        }

    }

}