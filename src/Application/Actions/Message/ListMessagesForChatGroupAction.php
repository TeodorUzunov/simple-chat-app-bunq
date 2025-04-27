<?php

declare(strict_types=1);

namespace App\Application\Actions\Message;

use Psr\Http\Message\ResponseInterface as Response;

class ListMessagesForChatGroupAction extends MessageAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $chatGroupId = (int)$this->resolveArg('chatGroupId');

        $userId = (int)($this->request->getQueryParams()['since'] ?? 0);
        // todo: check if the user ID has access to this chat group
        $since = (int)($this->request->getQueryParams()['since'] ?? 0);
        $messages = $this->messageRepository->getAllMessagesForGroupIdSince($chatGroupId, $since);

        $this->logger->info(
            "Messages after {$since} for chat group with ID {$chatGroupId} was viewed by user {$userId}."
        );

        return $this->respondWithData($messages);
    }
}
