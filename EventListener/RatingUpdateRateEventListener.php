<?php

namespace DCS\RatingBundle\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use DCS\RatingBundle\DCSRatingEvents;
use DCS\RatingBundle\Event\VoteEvent;
use DCS\RatingBundle\Model\RatingManagerInterface;
use DCS\RatingBundle\Model\VoteManagerInterface;

class RatingUpdateRateEventListener implements EventSubscriberInterface
{
    private $ratingManager;
    private $voteManager;

    public function __construct(RatingManagerInterface $ratingManager, VoteManagerInterface $voteManager)
    {
        $this->ratingManager = $ratingManager;
        $this->voteManager = $voteManager;
    }

    public static function getSubscribedEvents()
    {
        return array(
            DCSRatingEvents::VOTE_POST_PERSIST => 'onCreateVote'
        );
    }

    public function onCreateVote(VoteEvent $event)
    {
        $rating = $event->getVote()->getRating();
        $this->ratingManager->updateRatingStats($rating);
    }
}
