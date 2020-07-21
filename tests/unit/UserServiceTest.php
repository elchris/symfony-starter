<?php

namespace App\Tests\unit;

use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;

class UserServiceTest extends AppTestCase
{
    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function testUserService(): void
    {
        self::assertNotNull(
            $this->userService
        );

        $created = $this->newSvcUser();

        $this->em()->clear();

        $retrieved = $this->userService->byId(
            $created->getId()
        );
        self::assertNotNull($created);
        self::assertSame(
            $created->getEmail(),
            $retrieved->getEmail()
        );
        self::assertSame(
            $created->getMobilePhone(),
            $retrieved->getMobilePhone()
        );
        self::assertSame(
            $created->getLastName(),
            $retrieved->getLastName()
        );
        self::assertSame(
            $created->getFirstName(),
            $retrieved->getFirstName()
        );
        self::assertSame(
            $created->getAbout(),
            $retrieved->getAbout()
        );
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function testGetUserByEmail(): void
    {
        $user = $this->newSvcUser();
        $this->em()->clear();
        $retrieved = $this->userService->byEmail(
            $user->getUsername()
        );
        self::assertTrue($retrieved->is($user));
    }
}
