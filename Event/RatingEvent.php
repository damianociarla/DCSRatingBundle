<?php

namespace DCS\RatingBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use DCS\RatingBundle\Model\RatingInterface;

class RatingEvent extends Event
{
    /**
     * @var \DCS\RatingBundle\Model\RatingInterface
     */
    private $rating;

    public function __construct(RatingInterface $rating)
    {
        $this->rating = $rating;
    }

    /**
     * Get rating
     * 
     * @return \DCS\RatingBundle\Model\RatingInterface
     */
    public function getRating()
    {
        return $this->rating;
    }
}
