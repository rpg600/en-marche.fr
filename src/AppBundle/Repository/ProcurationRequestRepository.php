<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Adherent;
use Doctrine\ORM\EntityRepository;

class ProcurationRequestRepository extends EntityRepository
{
    public function findManagedBy(Adherent $procurationManager)
    {
        if (!$procurationManager->isProcurationManager()) {
            return [];
        }

        $qb = $this->createQueryBuilder('pr')
            ->select('pr')
            ->orderBy('pr.createdAt', 'DESC')
            ->addOrderBy('pr.lastName', 'ASC');

        $codesFilter = $qb->expr()->orX();

        foreach ($procurationManager->getProcurationManagedArea()->getCodes() as $key => $code) {
            if (is_numeric($code)) {
                // Postal code prefix
                $codesFilter->add(
                    $qb->expr()->andX(
                        'pr.voteCountry = \'FR\'',
                        $qb->expr()->like('pr.votePostalCode', ':code'.$key)
                    )
                );

                $qb->setParameter('code'.$key, $code.'%');
            } else {
                // Country
                $codesFilter->add($qb->expr()->eq('pr.voteCountry', ':code'.$key));
                $qb->setParameter('code'.$key, $code);
            }
        }

        $qb->andWhere($codesFilter);

        return $qb->getQuery()->getResult();
    }
}
