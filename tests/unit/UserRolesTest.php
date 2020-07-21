<?php

namespace App\Tests\unit;

use App\Entity\AppUser;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;

class UserRolesTest extends AppTestCase
{
    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function testUserRoles(): void
    {
        $user = $this->newSvcUser();
        self::assertTrue(
            $user->hasRole(AppUser::ROLE_API_DEV)
        );
        self::assertTrue(
            $user->hasRole(AppUser::ROLE_USER)
        );
        self::assertFalse(
            $user->hasRole('BOGUS_ROLE')
        );
        self::assertTrue(
            $user->isApiDev()
        );
    }
}
