<?php

declare(strict_types=1);

namespace App\Application\Actions\ChatGroup;

use Psr\Http\Message\ResponseInterface as Response;

class AddChatGroupAction extends ChatGroupAction
{
    /**
     * {@inheritdoc}
     * @todo - detect wrong data types for inputs and return correct error
     */
    protected function action(): Response
    {
        $data = (array)$this->request->getParsedBody();

        $userId = (int)($data['userId'] ?? 0);
        $name = trim($data['name'] ?? '');
        $created = (int)($data['created'] ?? 0);

        // Check if the userId and name are valid
        if ($userId <= 0 || empty($name)) {
            return $this->respondWithError('Missing or invalid required parameters: userId or name');
        }

        // Check if the user exists in the User table
        if (!$this->userRepository->findUserById($userId)) {
            return $this->respondWithError("User with ID {$userId} does not exist");
        }

        // Check if a chat group already exists with the same name in the ChatGroup table
        if ($this->chatGroupRepository->findChatGroupByName($name)) {
            return $this->respondWithError("Chat group with name '{$name}' already exists.");
        }

        $result = $this->chatGroupRepository->addChatGroup($name, $created);

        $this->logger->info("A new chat group with ID `{$result->getId()}` has been added with name `{$name}`");

        //add the creator of this chat group as the first member to it
        $this->chatGroupMemberRepository->addUserToChatGroup($userId, $result->getId(), $created);

        return $this->respondWithData($result);
    }
}
