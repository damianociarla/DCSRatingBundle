<?php

namespace DCS\RatingBundle\Entity;

use Doctrine\ORM\EntityManager;
use DCS\RatingBundle\Model\VoteManager as BaseVoteManager;
use DCS\RatingBundle\Model\VoteInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use DCS\RatingBundle\Model\RatingInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class VoteManager extends BaseVoteManager
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $em;

    /**
     * @var \Doctrine\ORM\EntityRepository
     */
    protected $repository;

    /**
     * @var string
     */
    protected $class;

    public function __construct(EventDispatcherInterface $dispatcher, EntityManager $em, $class)
    {
        parent::__construct($dispatcher);

        $this->em = $em;
        $this->repository = $em->getRepository($class);

        $metadata = $em->getClassMetadata($class);
        $this->class = $metadata->name;
    }

    public function findBy(array $criteria)
    {
        return $this->repository->findBy($criteria);
    }

    public function findOneBy(array $criteria)
    {
        return $this->repository->findOneBy($criteria);
    }

    protected function doSaveVote(VoteInterface $vote)
    {
        $this->em->persist($vote);
        $this->em->flush();
    }

    public function getClass()
    {
        return $this->class;
    }
}
