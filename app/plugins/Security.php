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
    Phalcon\Mvc\User\Plugin;



class Security extends Plugin
{

    // ...

    public function beforeExecuteRoute(Event $event, Dispatcher $dispatcher)
    {
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
		
		var_dump($role);
		var_dump($controller);
		var_dump($action);
		var_dump($allowed);
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
                return $this->response->redirect("/refund");
                // Возвращая "false" мы приказываем диспетчеру прекратить текущую операцию
                return false;
            }
        }

    }

}