<?php

namespace App\Service;

use App\Entity\AppUser;
use App\Repository\AppUserRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserService
{
    /**
     * @var AppUserRepository
     */
    private $userRepository;
    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    public function __construct(
        AppUserRepository $userRepository,
        UserPasswordEncoderInterface $encoder
    ) {
        $this->userRepository = $userRepository;
        $this->encoder = $encoder;
    }

    /**
     * @param array $userData
     * @return AppUser
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function newUser(array $userData): AppUser
    {
        $newUser = new AppUser();
        $newUser->setEmail($userData[AppUser::EMAIL]);
        $newUser->setMobilePhone($userData[AppUser::MOBILE_PHONE]);
        $newUser->setFirstName($userData[AppUser::FIRST_NAME]);
        $newUser->setLastName($userData[AppUser::LAST_NAME]);
        $newUser->setAbout($userData[AppUser::ABOUT]);
        $newUser->setPassword(
            $this->encoder->encodePassword(
                $newUser,
                $userData[AppUser::PASSWORD]
            )
        );
        $newUser->setRoles([
            AppUser::ROLE_API_DEV,
            AppUser::ROLE_USER
        ]);

        return $this->userRepository->saveUser(
            $newUser
        );
    }

    public function byId(int $userId): AppUser
    {
        return $this->userRepository->findOneBy(
            [
                AppUser::ID => $userId
            ]
        );
    }

    public function byEmail(string $email): AppUser
    {
        return $this->userRepository->findOneBy(
            [
                AppUser::EMAIL => $email
            ]
        );
    }
}
