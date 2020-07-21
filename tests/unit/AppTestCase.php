<?php

namespace App\Tests\unit;

use App\DataFixtures\AppFixtures;
use App\Entity\AppUser;
use App\Repository\AppUserRepository;
use App\Service\UserService;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\Tools\SchemaTool;
use Doctrine\ORM\Tools\ToolsException;
use Faker\Factory;
use Faker\Generator;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;

abstract class AppTestCase extends WebTestCase
{
    /** @var  EntityManagerInterface */
    private $em;

    /** @var ContainerInterface */
    protected $serviceContainer;

    /** @var AppUserRepository */
    protected $userRepository;

    /** @var UserService */
    protected $userService;

    /** @var Generator */
    protected $faker;

    protected function setUp(): void
    {
        parent::setUp();
        $this->faker = Factory::create();
        $kernel = self::bootKernel();
        $this->serviceContainer = $kernel->getContainer();
        $this->em =
                $this
                    ->serviceContainer
                    ->get('doctrine')
                    ->getManager();
        $this->setUpEntityManager();

        $this->userRepository = $this->em()->getRepository(
            AppUser::class
        );

        /** @var UserService $userService */
        $this->userService = $this->getService(
            UserService::class
        );
    }

    protected function em() : EntityManagerInterface
    {
        return $this->em;
    }

    /**
     * @return AppUser
     * @throws ORMException
     * @throws OptimisticLockException
     */
    protected function newSvcUser(): AppUser
    {
        return $this->userService->newUser(
            AppFixtures::newUserData()
        );
    }

    /**
     * @return AppUser
     * @throws ORMException
     * @throws OptimisticLockException
     */
    protected function newVerifiedSvcUser(): AppUser
    {
        $user = $this->newSvcUser();
        $user->setIsVerified(true);
        return $this->userRepository->saveUser($user);
    }

    protected function getService(string $serviceClass)
    {
        return $this
            ->serviceContainer
            ->get('test.' . $serviceClass);
    }

    private function setUpEntityManager(): void
    {
        $classes = $this->em()->getMetadataFactory()->getAllMetadata();
        $tool = new SchemaTool($this->em);
        $tool->dropSchema($classes);
        try {
            $tool->createSchema($classes);
        } catch (ToolsException $e) {
        }
    }
}
