<?php

declare(strict_types=1);

namespace App\Application\Actions\User;

use Psr\Http\Message\ResponseInterface as Response;

class ViewUserAction extends UserAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $userId = (int) $this->resolveArg('id');
        $user = $this->userRepository->findUserById($userId);

        if ($user === null) {
            return $this->respondWithError("User with ID {$userId} not found");
        }

        $this->logger->info("User of id `{$userId}` was viewed.");

        return $this->respondWithData($user);
    }
}
