<?php

namespace DCS\RatingBundle\Model;

abstract class Vote implements VoteInterface
{
    /**
     * Id
     *
     * @var integer
     */
    protected $id;

    /**
     * Value of vote
     *
     * @var integer
     */
    protected $value;

    /**
     * Data of creation
     *
     * @var \DateTime
     */
    protected $createdAt;

    /**
     * Rating
     *
     * @var RatingInterface
     */
    protected $rating;

    /**
     * Rating
     *
     * @var \Symfony\Component\Security\Core\User\UserInterface
     */
    protected $voter;

    public function __construct()
    {
        $this->createdAt = new \DateTime('now');
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set value
     *
     * @param integer $value
     * @return VoteInterface
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return integer
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Sets the date on which the vote was added
     *
     * @param \DateTime $createdAt
     * @return VoteInterface
     */
    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get the date on which the vote was added
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set rating
     *
     * @param \DCS\RatingBundle\Model\RatingInterface $rating
     * @return VoteInterface
     */
    public function setRating(RatingInterface $rating)
    {
        $this->rating = $rating;

        return $this;
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

    /**
     * Set voter
     *
     * @param \Symfony\Component\Security\Core\User\UserInterface $voter
     * @return VoteInterface
     */
    public function setVoter(\Symfony\Component\Security\Core\User\UserInterface $voter)
    {
        $this->voter = $voter;

        return $this;
    }

    /**
     * Get voter
     *
     * @return \Symfony\Component\Security\Core\User\UserInterface
     */
    public function getVoter()
    {
        return $this->voter;
    }
}
