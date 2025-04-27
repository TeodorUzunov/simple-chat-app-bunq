<?php

declare(strict_types=1);

namespace App\Application\Actions\ChatGroup;

use App\Application\Actions\Action;
use App\Domain\ChatGroup\ChatGroupRepository;
use App\Domain\ChatGroupMember\ChatGroupMemberRepository;
use App\Domain\User\UserRepository;
use Psr\Log\LoggerInterface;

abstract class ChatGroupAction extends Action
{
    protected ChatGroupRepository $chatGroupRepository;
    protected ChatGroupMemberRepository $chatGroupMemberRepository;
    protected UserRepository $userRepository;

    public function __construct(
        LoggerInterface $logger,
        ChatGroupRepository $chatGroupRepository,
        ChatGroupMemberRepository $chatGroupMemberRepository,
        UserRepository $userRepository
    ) {
        parent::__construct($logger);
        $this->chatGroupRepository = $chatGroupRepository;
        $this->chatGroupMemberRepository = $chatGroupMemberRepository;
        $this->userRepository = $userRepository;
    }
}
