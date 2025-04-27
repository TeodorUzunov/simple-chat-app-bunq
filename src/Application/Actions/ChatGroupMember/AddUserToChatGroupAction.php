<?php

declare(strict_types=1);

namespace App\Application\Actions\ChatGroupMember;

use Psr\Http\Message\ResponseInterface as Response;

class AddUserToChatGroupAction extends ChatGroupMemberAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        // Retrieve and sanitize chat group ID from the URL
        $chatGroupId = (int) $this->resolveArg('chatGroupId');

        // Retrieve and sanitize the data from the request body
        $data = (array)$this->request->getParsedBody();
        $userId = (int)($data['userId'] ?? 0);
        $created = (int)($data['created'] ?? 0);

        // Check if the userId and chatGroupId are valid
        if ($userId <= 0 || $chatGroupId <= 0) {
            return $this->respondWithError('Missing required parameters: userId or chatGroupId');
        }

        // Check if the user exists in the User table
        if (!$this->userRepository->findUserById($userId)) {
            return $this->respondWithError("User with ID {$userId} does not exist");
        }
        //@todo - check if the user ID is already a member of this chat group

        // Check if the chat group exists in the ChatGroup table
        if (!$this->chatGroupRepository->findChatGroupById($chatGroupId)) {
            return $this->respondWithError("Chat group with ID {$chatGroupId} does not exist.");
        }

        $created = $created ?: time();

        // Add user to chat group
        $result = $this->chatGroupMemberRepository->addUserToChatGroup($userId, $chatGroupId, $created);

        $this->logger->info("A new user with ID `{$userId}` has been added to chat group with ID `{$chatGroupId}`");

        return $this->respondWithData($result);
    }
}
