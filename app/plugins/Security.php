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

        // Проверяем, установлена ли в сессии переменная "auth" для определения активной роли.
        $auth = $this->session->get('agent_id');
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

        // Проверяем, имеет ли данная роль доступ к контроллеру (ресурсу)
        if($role=='Guests'){
            $allowed = $acl->isAllowed($role, $controller, $action);
            if ($allowed != \Phalcon\Acl::ALLOW) {

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

    }

}