<?php

namespace DCS\RatingBundle\Model;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use DCS\RatingBundle\DCSRatingEvents;
use DCS\RatingBundle\Event;

abstract class RatingManager implements RatingManagerInterface
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
     * Finds one rating by id
     *
     * @param string $id
     * @return ThreadInterface
     */
    public function findOneById($id)
    {
        return $this->findBy(array('id' => $id));
    }

    /**
     * Creates an empty rating instance
     *
     * @param string $id
     * @return \DCS\RatingBundle\Model\RatingInterface
     */
    public function createRating($id = null)
    {
        $class = $this->getClass();
        $rating = new $class;

        if (null !== $id) {
            $rating->setId($id);
        }

        $this->dispatcher->dispatch(DCSRatingEvents::RATING_CREATE, new Event\RatingEvent($rating));

        return $rating;
    }

    /**
     *
     * @param \DCS\RatingBundle\Model\RatingInterface $rating
     * @return \DCS\RatingBundle\Model\RatingInterface
     */
    public function saveRating(RatingInterface $rating)
    {
        $this->dispatcher->dispatch(DCSRatingEvents::RATING_PRE_PERSIST, new Event\RatingEvent($rating));

        $this->doSaveRating($rating);

        $this->dispatcher->dispatch(DCSRatingEvents::RATING_POST_PERSIST, new Event\RatingEvent($rating));
    }

    /**
     * Performs the persistence of the Rating.
     *
     * @abstract
     * @param RatingInterface $rating
     */
    abstract protected function doSaveRating(RatingInterface $rating);
}
