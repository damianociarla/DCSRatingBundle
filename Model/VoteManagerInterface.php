<?php

namespace DCS\RatingBundle\Model;

use Symfony\Component\Security\Core\User\UserInterface;

interface VoteManagerInterface
{
    /**
     * Finds one vote by Rating and User
     *
     * @param \DCS\RatingBundle\Model\RatingInterface $rating
     * @param \Symfony\Component\Security\Core\User\UserInterface $voter
     * @return VoteInterface
     */
    public function findOneByRatingAndVoter(RatingInterface $rating, UserInterface $voter);

    /**
     * Finds votes by the given criteria
     *
     * @param array $criteria
     * @return array
     */
    public function findBy(array $criteria);

    /**
     * Finds one vote by the given criteria
     *
     * @param array $criteria
     * @return VoteInterface
     */
    public function findOneBy(array $criteria);

    /**
     * Creates an empty vote instance
     *
     * @param RatingInterface $rating
     * @param UserInterface $voter
     * @return VoteInterface
     */
    public function createVote(RatingInterface $rating, UserInterface $voter);

    /**
     * Save or update vote
     *
     * @param \DCS\RatingBundle\Model\VoteInterface $vote
     * @return RatingInterface
     */
    public function saveVote(VoteInterface $vote);

    /**
     * Returns the vote fully qualified class name
     *
     * @return string
     */
    public function getClass();
}
