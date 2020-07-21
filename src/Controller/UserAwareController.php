<?php

namespace App\Controller;

use App\Entity\AppUser;
use App\Exception\UserMustBeLoggedIn;
use App\Service\UserService;

abstract class UserAwareController extends AppController
{
    /**
     * @var UserService
     */
    protected $userService;

    public function __construct(
        UserService $userService
    ) {
        $this->userService = $userService;
    }

    protected function getAppUser(): AppUser
    {
        return $this->userService->byEmail(
            $this->getUser()->getUsername()
        );
    }

    protected function isUserLoggedIn(): bool
    {
        return $this->getUser() !== null;
    }

    /**
     * @throws UserMustBeLoggedIn
     */
    protected function verifyUserLoggedIn(): void
    {
        if (!$this->isUserLoggedIn()) {
            throw new UserMustBeLoggedIn();
        }
    }
}
