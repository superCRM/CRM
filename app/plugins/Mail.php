<?php
namespace Plagins;
use Phalcon\Mvc\User\Component;
use Swift_Message as Message;
use Swift_SmtpTransport as Smtp;
use Phalcon\Mvc\View;
/**
 * Sends e-mails based on pre-defined templates
 */
class Mail extends Component
{
    protected $transport;
    protected $directSmtp = true;

    /**
     * Applies a template to be used in the e-mail
     *
     * @param string $name
     * @param array $params
     */
    public function getTemplate($name, $params)
    {
        $parameters = array_merge(array(
            'publicUrl' => 'localhost:8080'//$this->config->application->publicUrl
        ), $params);
        return $this->view->getRender('emailTemplates', $name, $parameters, function ($view) {
            $view->setRenderLevel(View::LEVEL_LAYOUT);
			return $view->getContent();
        });
        
    }
    /**
     * @param array $to
     * @param string $subject
     * @param string $name
     * @param array $params
     */
    public function send($to, $subject, $name, $params)
    {
        // Settings
        $mailSettings = $this->config->mail;
        $template = $this->getTemplate($name, $params);
        // Create the message
        $message = Message::newInstance()
            ->setSubject($subject)
            ->setTo($to)
            ->setFrom(array(
                $mailSettings->fromEmail => $mailSettings->fromName
            ))
            ->setBody($template, 'text/html');
        if ($this->directSmtp) {
            if (!$this->transport) {
                $this->transport = Smtp::newInstance(
                    $mailSettings->smtp->server,
                    $mailSettings->smtp->port,
                    $mailSettings->smtp->security
                )
                ->setUsername($mailSettings->smtp->username)
                ->setPassword($mailSettings->smtp->password);
            }
            // Create the Mailer using your created Transport
            $mailer = \Swift_Mailer::newInstance($this->transport);
            return $mailer->send($message);
        } 
    }
}