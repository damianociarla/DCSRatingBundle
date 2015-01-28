<?php

namespace DCS\RatingBundle\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use DCS\RatingBundle\DCSRatingEvents;
use DCS\RatingBundle\Event\RatingEvent;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\HttpFoundation\Request;

class RatingUpdateInfoEventListener implements EventSubscriberInterface
{
    /**
     * @var Request
     */
    private $request;

    /**
     * Set request
     *
     * @param Request $request
     */
    public function setRequest(Request $request = null)
    {
        $this->request = $request;
    }

    public static function getSubscribedEvents()
    {
        return array(
            DCSRatingEvents::RATING_PRE_PERSIST => 'updatePermalink',
        );
    }

    /**
     * @param RatingEvent $event
     */
    public function updatePermalink(RatingEvent $event)
    {
        if (null === $this->request) {
            return;
        }

        $rating = $event->getRating();
        $requestPermalink = $this->request->get('permalink');
        $requestSecurityRole = $this->request->get('securityRole');

        if ($requestPermalink != $rating->getPermalink()) {
            $rating->setPermalink($requestPermalink);
        }

        if ($requestSecurityRole != $rating->getSecurityRole()) {
            $rating->setSecurityRole($requestSecurityRole);
        }
    }
}
