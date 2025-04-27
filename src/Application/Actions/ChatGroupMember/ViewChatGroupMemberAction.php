<?php

declare(strict_types=1);

namespace App\Application\Actions\ChatGroupMember;

use Psr\Http\Message\ResponseInterface as Response;

class ViewChatGroupMemberAction extends ChatGroupMemberAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $userId = (int) $this->resolveArg('id');
        $memberships = $this->chatGroupMemberRepository->findChatGroupsForUserId($userId);

        // Check if the user exists by verifying memberships
        if (empty($memberships)) {
            return $this->respondWithError("User with ID {$userId} does not exist or has no memberships.");
        }

        $this->logger->info("Chat group memberships for User with id `{$userId}` was viewed.");

        return $this->respondWithData($memberships);
    }
}
