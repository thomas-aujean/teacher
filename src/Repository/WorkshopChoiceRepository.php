<?php

namespace App\Repository;

use App\Entity\WorkshopChoice;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<WorkshopChoice>
 *
 * @method WorkshopChoice|null find($id, $lockMode = null, $lockVersion = null)
 * @method WorkshopChoice|null findOneBy(array $criteria, array $orderBy = null)
 * @method WorkshopChoice[]    findAll()
 * @method WorkshopChoice[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WorkshopChoiceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, WorkshopChoice::class);
    }

    public function add(WorkshopChoice $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(WorkshopChoice $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }


    public function findOrdered(): array
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT wc, w
            FROM App\Entity\WorkshopChoice wc
            INNER JOIN wc.workshops w
            ORDER BY 
            -- w.type DESC, 
            w.start ASC'
        );
        return $query->getResult();
    }

    public function findWorkshopsByFilter(
        $type
//        , $weeks
    )
    {
        $entityManager = $this->getEntityManager();
        $today = new DateTime();

        $query = $entityManager->createQuery(
            'SELECT wc, w
        FROM App\Entity\WorkshopChoice wc
        LEFT JOIN wc.workshops w
        WHERE w.type = :type
            AND w.start > :today
        -- HAVING COUNT(w) = :weeks 
        ORDER BY 
        -- w.type DESC, 
        w.start ASC'
        )
            ->setParameter('type', $type)
            ->setParameter('today', $today);

        $results = $query->getArrayResult();


        foreach ($results as $key => $result) {
//            if (count($result['workshops']) != $weeks) {
//                unset($results[$key]);
//            }


            foreach ($result['workshops'] as $k => $workshop) {
                if ($workshop['enroled'] == $workshop['maximum']) {
                    unset($results[$key]);
                    break;
                }

//                if ($weeks == 1) {
                        if (isset($results[$key]['workshops'][$k])) {

                            $remain = $results[$key]['workshops'][$k]['maximum'] - $results[$key]['workshops'][$k]['enroled'];

                            $results[$key]['workshops'][$k]['label'] = "Du {$workshop['start']->format('d/m/Y')} au {$workshop['end']->format('d/m/Y')} - ($remain places restantes)";
                        }
//                } else {
//                    if (count($result['workshops']) != 2) {
//                        unset($results[$key]);
//                        break;
//                    }
//                    if (isset($results[$key]['workshops'][$k])){
//                        $month = ($workshop['start']->format('m') == '7') ? 'Juillet' : 'Aoùt';
//
//                        if ($k == 0){
//                            $remainFirst = $results[$key]['workshops'][$k]['maximum'] - $results[$key]['workshops'][$k]['enroled'];
//                            $results[$key]['workshops'][$k]['label'] = "Mois de $month, du {$workshop['start']->format('d/m/Y')}";
//                        } else{
//                            $remainSecond = $results[$key]['workshops'][$k]['maximum'] - $results[$key]['workshops'][$k]['enroled'];
//                            $min = min([$remainFirst, $remainSecond]);
//                            $results[$key]['workshops'][0]['label'] .= " au {$workshop['end']->format('d/m/Y')} - ($min places restantes)";
//                        }
//                    }
//                }
            }
        }

        
// dd($results);

        return $results;
    }

    //    /**
    //     * @return WorkshopChoice[] Returns an array of WorkshopChoice objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('w')
    //            ->andWhere('w.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('w.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?WorkshopChoice
    //    {
    //        return $this->createQueryBuilder('w')
    //            ->andWhere('w.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}