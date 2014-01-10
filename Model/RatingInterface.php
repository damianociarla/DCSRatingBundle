<?php

namespace DCS\RatingBundle\Model;

interface RatingInterface
{
    /**
     * Set unique string id
     *
     * @param integer $id
     * @return RatingInterface
     */
    public function setId($id);

    /**
     * Get unique string id
     *
     * @return integer
     */
    public function getId();

    /**
     * Set num votes
     *
     * @param integer $numVotes
     * @return RatingInterface
     */
    public function setNumVotes($numVotes);

    /**
     * Return num votes
     *
     * @return integer
     */
    public function getNumVotes();

    /**
     * Set the rate of the votes
     *
     * @param integer $rate
     * @return RatingInterface
     */
    public function setRate($rate);

    /**
     * Get the rate of the votes
     *
     * @return integer
     */
    public function getRate();

    /**
     * Set the permalink of the page
     *
     * @param string $permalink
     * @return RatingInterface
     */
    public function setPermalink($permalink);

    /**
     * Get the permalink of the page
     *
     * @return string
     */
    public function getPermalink();

    /**
     * Set the securityRole
     *
     * @param string $securityRole
     * @return RatingInterface
     */
    public function setSecurityRole($securityRole);

    /**
     * Get the securityRole
     *
     * @return string
     */
    public function getSecurityRole();

    /**
     * Sets the date on which the thread was added
     *
     * @param \DateTime $createdAt
     * @return RatingInterface
     */
    public function setCreatedAt(\DateTime $createdAt);

    /**
     * Get the date on which the thread was added
     *
     * @return \DateTime
     */
    public function getCreatedAt();

    public function addVote(VoteInterface $vote);

    public function removeVote(VoteInterface $vote);

    public function getVotes();
}
