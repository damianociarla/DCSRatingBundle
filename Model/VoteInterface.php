<?php

namespace DCS\RatingBundle\Model;

interface VoteInterface
{
    /**
     * Get id
     *
     * @return integer
     */
    public function getId();

    /**
     * Set value
     *
     * @param integer $value
     * @return VoteInterface
     */
    public function setValue($value);

    /**
     * Get value
     *
     * @return integer
     */
    public function getValue();

    /**
     * Sets the date on which the vote was added
     *
     * @param \DateTime $createdAt
     * @return VoteInterface
     */
    public function setCreatedAt(\DateTime $createdAt);

    /**
     * Get the date on which the vote was added
     *
     * @return \DateTime
     */
    public function getCreatedAt();

    /**
     * Set rating
     *
     * @param \DCS\RatingBundle\Model\RatingInterface $rating
     * @return VoteInterface
     */
    public function setRating(RatingInterface $rating);

    /**
     * Get rating
     *
     * @return \DCS\RatingBundle\Model\RatingInterface
     */
    public function getRating();

    /**
     * Sets the owner of the vote
     *
     * @param UserInterface $user
     * @return SignedVoteInterface
     */
    public function setVoter(\Symfony\Component\Security\Core\User\UserInterface $voter);

    /**
     * Gets the owner of the vote
     *
     * @return UserInterface
     */
    public function getVoter();
}
