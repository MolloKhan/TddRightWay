<?php

namespace App\Repository;

use App\Entity\Player;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Player|null find($id, $lockMode = null, $lockVersion = null)
 * @method Player|null findOneBy(array $criteria, array $orderBy = null)
 * @method Player[]    findAll()
 * @method Player[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PlayerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Player::class);
    }

    public function getScoreboard(): array
    {
        return $this->createQueryBuilder('p')
            ->addSelect('p, COUNT(gr.victory) AS score')
            ->addGroupBy('p')
            ->join('p.gameResults', 'gr')
            ->andWhere('gr.victory = 1')
            ->andWhere('gr.createdAt >= :dateLimit')
            ->setParameter('dateLimit', new \DateTimeImmutable('-15 days'))
            ->setMaxResults(5)
            ->orderBy('score', 'DESC')
            ->getQuery()
            ->execute();
    }

    public function findTopPlayerForDay(string $days): ?Player
    {
        $dayStart = new \DateTime(sprintf('%s days', $days));
        $dayStart->setTime(0, 0, 0);
        $dayEnd = new \DateTime(sprintf('%s days', $days));
        $dayEnd->setTime(23, 59, 59);

        return $this->createQueryBuilder('p')
            ->addGroupBy('p')
            ->join('p.gameResults', 'gr')
            ->andWhere('gr.victory = 1')
            ->andWhere('gr.createdAt >= :dayStart AND gr.createdAt <= :dayEnd')
            ->setParameter('dayStart', $dayStart)
            ->setParameter('dayEnd', $dayEnd)
            ->setMaxResults(1)
            ->orderBy('COUNT(gr.victory)', 'DESC')
            ->getQuery()
            ->getOneOrNullResult();
    }
}
