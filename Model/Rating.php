<?php

namespace DCS\RatingBundle\Model;

abstract class Rating implements RatingInterface
{
    /**
     * Id, a unique string that binds the votes together in a thread.
     * It can be a url or really anything unique.
     *
     * @var string
     */
    protected $id;

    /**
     * Total votes in a thread
     *
     * @var int
     */
    protected $numVotes;

    /**
     * Rate votes in a thread
     *
     * @var int
     */
    protected $rate;

    /**
     * Base security role
     *
     * @var string
     */
    protected $securityRole;

    /**
     * Url of the page where the thread lives
     *
     * @var string
     */
    protected $permalink;

    /**
     * Date on which the thread was added
     *
     * @var \DateTime
     */
    protected $createdAt;

    /**
     * Votes
     *
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    protected $votes;

    public function __construct()
    {
        $this->rate = 0;
        $this->numVotes = 0;
        $this->createdAt = new \DateTime('now');
        $this->votes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set unique string id
     *
     * @param integer $id
     * @return RatingInterface
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get unique string id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set num votes
     *
     * @param integer $numVotes
     * @return RatingInterface
     */
    public function setNumVotes($numVotes)
    {
        $this->numVotes = $numVotes;

        return $this;
    }

    /**
     * Return num votes
     *
     * @return integer
     */
    public function getNumVotes()
    {
        return $this->numVotes;
    }

    /**
     * Set the rate of the votes
     *
     * @param integer $rate
     * @return RatingInterface
     */
    public function setRate($rate)
    {
        $this->rate = $rate;

        return $this;
    }

    /**
     * Get the rate of the votes
     *
     * @return integer
     */
    public function getRate()
    {
        return $this->rate;
    }

    /**
     * Set the permalink of the page
     *
     * @param string $permalink
     * @return RatingInterface
     */
    public function setPermalink($permalink = null)
    {
        $this->permalink = $permalink;

        return $this;
    }

    /**
     * Get the permalink of the page
     *
     * @return string
     */
    public function getPermalink()
    {
        return $this->permalink;
    }

    /**
     * Set the securityRole
     *
     * @param string $securityRole
     * @return RatingInterface
     */
    public function setSecurityRole($securityRole)
    {
        $this->securityRole = $securityRole;

        return $this;
    }

    /**
     * Get the securityRole
     *
     * @return string
     */
    public function getSecurityRole()
    {
        return $this->securityRole;
    }

    /**
     * Sets the date on which the thread was added
     *
     * @param \DateTime $createdAt
     * @return RatingInterface
     */
    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get the date on which the thread was added
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function addVote(VoteInterface $vote)
    {
        $this->votes->add($vote);

        return $this;
    }

    public function removeVote(VoteInterface $vote)
    {
        $this->votes->remove($vote);

        return $this;
    }

    public function getVotes()
    {
        return $this->votes;
    }
}
