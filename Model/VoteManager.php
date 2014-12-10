<?php

namespace DCS\RatingBundle\Model;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use DCS\RatingBundle\DCSRatingEvents;
use DCS\RatingBundle\Event;
use Symfony\Component\Security\Core\User\UserInterface;

abstract class VoteManager implements VoteManagerInterface
{
    /**
     * @var \Symfony\Component\EventDispatcher\EventDispatcherInterface
     */
    protected $dispatcher;

    public function __construct(EventDispatcherInterface $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    /**
     * Creates an empty vote instance
     *
     * @param RatingInterface $rating
     * @param UserInterface $voter
     * @return \DCS\RatingBundle\Model\VoteInterface
     */
    public function createVote(RatingInterface $rating, UserInterface $voter)
    {
        $class = $this->getClass();
        $vote = new $class;
        $vote->setRating($rating);
        $vote->setVoter($voter);

        $this->dispatcher->dispatch(DCSRatingEvents::VOTE_CREATE, new Event\VoteEvent($vote));

        return $vote;
    }

    /**
     * Finds one vote by Rating and User
     *
     * @param \DCS\RatingBundle\Model\RatingInterface $rating
     * @param \Symfony\Component\Security\Core\User\UserInterface $voter
     * @return VoteInterface
     */
    public function findOneByRatingAndVoter(RatingInterface $rating, UserInterface $voter)
    {
        return $this->findOneBy(array(
            'rating' => $rating,
            'voter' => $voter,
        ));
    }

    /**
     *
     * @param \DCS\RatingBundle\Model\VoteInterface $vote
     * @return \DCS\RatingBundle\Model\VoteInterface
     */
    public function saveVote(VoteInterface $vote)
    {
        $this->dispatcher->dispatch(DCSRatingEvents::VOTE_PRE_PERSIST, new Event\VoteEvent($vote));

        $this->doSaveVote($vote);

        $this->dispatcher->dispatch(DCSRatingEvents::VOTE_POST_PERSIST, new Event\VoteEvent($vote));
    }

    /**
     * Performs the persistence of the Vote.
     *
     * @abstract
     * @param VoteInterface $vote
     */
    abstract protected function doSaveVote(VoteInterface $vote);
}
