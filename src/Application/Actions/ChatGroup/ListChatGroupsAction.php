<?php

declare(strict_types=1);

namespace App\Application\Actions\ChatGroup;

use Psr\Http\Message\ResponseInterface as Response;

class ListChatGroupsAction extends ChatGroupAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $users = $this->chatGroupRepository->findAll();

        $this->logger->info("Chat group list was viewed.");

        return $this->respondWithData($users);
    }
}
