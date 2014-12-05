<?php

namespace DCS\RatingBundle\Entity;

use Doctrine\ORM\EntityManager;
use DCS\RatingBundle\Model\RatingManager as BaseRatingManager;
use DCS\RatingBundle\Model\RatingInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class RatingManager extends BaseRatingManager
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

    public function updateRatingStats(RatingInterface $rating)
    {
        $qb = $this->em->createQueryBuilder();
        $qb
            ->select('COUNT(v) AS totalVotes, SUM(v.value) AS totalValue')
            ->from($this->getClass(), 'r')
            ->join('r.votes', 'v')
            ->where('r = :r')
            ->setParameter('r', $rating)
        ;

        extract($qb->getQuery()->getSingleResult(\Doctrine\ORM\AbstractQuery::HYDRATE_ARRAY));

        $rating->setNumVotes($totalVotes);
        $rating->setRate(round(($totalValue / $totalVotes), 1));

        $this->saveRating($rating);

        return $rating;
    }

    public function findBy(array $criteria)
    {
        return $this->repository->findOneBy($criteria);
    }

    protected function doSaveRating(RatingInterface $rating)
    {
        $this->em->persist($rating);
        $this->em->flush();
    }

    public function getClass()
    {
        return $this->class;
    }
}
