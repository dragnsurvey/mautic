<?php


namespace MauticPlugin\DragnSurveyBundle\EventListener;
use Mautic\CoreBundle\Helper\EmojiHelper;

use Mautic\EmailBundle\Model\EmailModel;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Mautic\EmailBundle\EmailEvents;
use Mautic\EmailBundle\Event\EmailSendEvent;
use Symfony\Component\Translation\TranslatorInterface;

class DragnSurveyEmailBuilderSubscriber implements EventSubscriberInterface
{
    /**
     * @var TranslatorInterface
     */
    private $translator;

    public function __construct(EmailModel $emailModel, TranslatorInterface $translator){
        $this->emailModel = $emailModel;
        $this->translator = $translator;
    }

    /**
     * @return array
     */
    static public function getSubscribedEvents()
    {
        return array(
            EmailEvents::EMAIL_ON_SEND   => array('onTranslateLinks', -1),
            EmailEvents::EMAIL_ON_DISPLAY => array('onTranslateLinks', -1)
        );
    }

    public function onTranslateLinks(EmailSendEvent $event){

        $idHash = $event->getIdHash();
        if (null == $idHash) {
            // Generate a bogus idHash to prevent errors for routes that may include it
            $idHash = uniqid();
        }
        $email  = $event->getEmail();
        $emailLanguage = "fr";
        if($email){
            $emailLanguage = $email->getLanguage();
        }

        $unsubscribeText = $this->translator->trans('mautic.email.unsubscribe.text', ['%link%' => '|URL|'], null, $emailLanguage);
        $unsubscribeText = str_replace('|URL|', $this->emailModel->buildUrl('mautic_email_unsubscribe', ['idHash' => $idHash]), $unsubscribeText);
        $event->addToken('{unsubscribe_text}', EmojiHelper::toHtml($unsubscribeText));

        $webviewText = $this->translator->trans('mautic.email.webview.text', ['%link%' => '|URL|'], null, $emailLanguage);
        $webviewText = str_replace('|URL|', $this->emailModel->buildUrl('mautic_email_webview', ['idHash' => $idHash]), $webviewText);
        $event->addToken('{webview_text}', EmojiHelper::toHtml($webviewText));
    }
}