<?php

namespace DCS\RatingBundle\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use DCS\RatingBundle\DCSRatingEvents;
use DCS\RatingBundle\Event\RatingEvent;
use Symfony\Component\DependencyInjection\Container;

class RatingUpdateInfoEventListener implements EventSubscriberInterface
{
    /**
     * @var \Symfony\Component\HttpFoundation\Request
     */
    private $request;

    public function __construct(Container $container)
    {
        $container->enterScope('request');
        $container->set('request', new Request(), 'request');
        $this->request = $container->get('request');
    }

    public static function getSubscribedEvents()
    {
        return array(
            DCSRatingEvents::RATING_PRE_PERSIST => 'updatePermalink',
        );
    }

    public function updatePermalink(RatingEvent $event)
    {
        $rating = $event->getRating();

        if (null === $rating->getPermalink()) {
            $rating->setPermalink($this->request->get('permalink'));
        }

        if (null === $rating->getSecurityRole()) {
            $rating->setSecurityRole($this->request->get('securityRole'));
        }
    }
}
