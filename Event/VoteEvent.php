<?php

namespace DCS\RatingBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use DCS\RatingBundle\Model\VoteInterface;

class VoteEvent extends Event
{
    /**
     * @var \DCS\RatingBundle\Model\VoteInterface
     */
    private $vote;

    public function __construct(VoteInterface $vote)
    {
        $this->vote = $vote;
    }

    /**
     * Get vote
     *
     * @return \DCS\RatingBundle\Model\VoteInterface
     */
    public function getVote()
    {
        return $this->vote;
    }
}
