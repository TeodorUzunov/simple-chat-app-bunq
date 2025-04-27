<?php

declare(strict_types=1);

namespace App\Application\Actions\ChatGroup;

use Psr\Http\Message\ResponseInterface as Response;

class ViewChatGroupAction extends ChatGroupAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $chatGroupId = (int) $this->resolveArg('id');
        $chatGroup = $this->chatGroupRepository->findChatGroupById($chatGroupId);

        if ($chatGroup === null) {
            return $this->respondWithError("Chat group with ID {$chatGroupId} not found");
        }

        $this->logger->info("Chat group with ID `{$chatGroupId}` was viewed.");

        return $this->respondWithData($chatGroup);
    }
}
