<?php

declare(strict_types=1);

namespace App\Application\Actions\ChatGroupMember;

use App\Application\Actions\Action;
use App\Domain\ChatGroup\ChatGroupRepository;
use App\Domain\ChatGroupMember\ChatGroupMemberRepository;
use App\Domain\User\UserRepository;
use Psr\Log\LoggerInterface;

abstract class ChatGroupMemberAction extends Action
{
    protected ChatGroupMemberRepository $chatGroupMemberRepository;
    protected UserRepository $userRepository;
    protected ChatGroupRepository $chatGroupRepository;

    public function __construct(
        LoggerInterface $logger,
        ChatGroupMemberRepository $chatGroupMemberRepository,
        UserRepository $userRepository,
        ChatGroupRepository $chatGroupRepository
    ) {
        parent::__construct($logger);
        $this->chatGroupMemberRepository = $chatGroupMemberRepository;
        $this->userRepository = $userRepository;
        $this->chatGroupRepository = $chatGroupRepository;
    }
}
