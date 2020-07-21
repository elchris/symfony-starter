<?php

namespace App\Repository;

use App\Entity\AppUser;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use function get_class;

/**
 * @method AppUser|null find($id, $lockMode = null, $lockVersion = null)
 * @method AppUser|null findOneBy(array $criteria, array $orderBy = null)
 * @method AppUser[]    findAll()
 * @method AppUser[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AppUserRepository extends AppRepository implements PasswordUpgraderInterface
{
    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     * @param UserInterface $user
     * @param string $newEncodedPassword
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function upgradePassword(UserInterface $user, string $newEncodedPassword): void
    {
        if (!$user instanceof AppUser) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', get_class($user)));
        }

        $user->setPassword($newEncodedPassword);
        $this->_em->persist($user);
        $this->_em->flush();
    }

    /**
     * @param AppUser $user
     * @return AppUser
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function saveUser(AppUser $user): AppUser
    {
        $this->persistEntity($user);
        return $user;
    }

    // /**
    //  * @return AppUser[] Returns an array of AppUser objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?AppUser
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    protected function getEntity(): string
    {
        return AppUser::class;
    }
}
