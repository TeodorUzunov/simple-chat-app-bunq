<?php

declare(strict_types=1);

namespace App\Application\Actions\Message;

use Psr\Http\Message\ResponseInterface as Response;

class AddMessageAction extends MessageAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $chatGroupId = (int)$this->resolveArg('chatGroupId');
        $data = (array)$this->request->getParsedBody();

        $userId = (int)($data['userId'] ?? 0);
        $content = trim($data['content'] ?? '');

        //add validation and cleaning of the passed data

        $message = $this->messageRepository->addMessage($userId, $chatGroupId, $content);

        $this->logger->info(
            "A new message with ID `{$message->getId()}` added in chat group with ID `{$chatGroupId}` by User with ID 
            `{$userId}`."
        );

        return $this->respondWithData($message);
    }
}
