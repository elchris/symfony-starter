<?php

namespace App\Controller;

use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

abstract class AppController extends AbstractController
{
    /**
     * @param Request $request
     * @return mixed
     */
    protected function getData(Request $request): array
    {
        return json_decode($request->getContent(), true);
    }

    /**
     * @param Exception $e
     */
    protected function handleException(Exception $e): void
    {
        $this->addFlash(
            'error',
            'Could not create Key: ' . $e->getMessage()
        );
    }

    protected function getBooleanValueOrNull($booleanVariable): ?bool
    {
        if ($booleanVariable !== null) {
            if ($booleanVariable === 'false') {
                $booleanVariable = false;
            } elseif ($booleanVariable === 'true') {
                $booleanVariable = true;
            } else {
                $booleanVariable = (bool)$booleanVariable;
            }
        }

        return $booleanVariable;
    }

    /**
     * @param string $message
     */
    protected function success(string $message): void
    {
        $this->addFlash(
            'success',
            $message
        );
    }

    /**
     * @return RedirectResponse
     */
    protected function sendHome(): RedirectResponse
    {
        return $this->redirectToRoute('home');
    }
}
