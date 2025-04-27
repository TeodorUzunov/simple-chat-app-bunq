<?php

declare(strict_types=1);

use App\Application\Actions\ChatGroup\AddChatGroupAction;
use App\Application\Actions\ChatGroup\ListChatGroupsAction;
use App\Application\Actions\ChatGroup\ViewChatGroupAction;
use App\Application\Actions\ChatGroupMember\AddUserToChatGroupAction;
use App\Application\Actions\ChatGroupMember\ViewChatGroupMemberAction;
use App\Application\Actions\Message\AddMessageAction;
use App\Application\Actions\Message\ListMessagesForChatGroupAction;
use App\Application\Actions\User\ListUsersAction;
use App\Application\Actions\User\ViewUserAction;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

return function (App $app) {
    $app->options('/{routes:.*}', function (Request $request, Response $response) {
        // CORS Pre-Flight OPTIONS Request Handler
        return $response;
    });

    $app->get('/', function ($request, $response) {
        $html = file_get_contents(__DIR__ . '/../src/Templates/index.php');
        $response->getBody()->write($html);
        return $response;
    });

    $app->group('/api', function (Group $group) {
        $group->group('/users', function (Group $userGroup) {
            $userGroup->get('', ListUsersAction::class);
            $userGroup->get('/{id}', ViewUserAction::class);
        });

        $group->group('/chat_groups', function (Group $chatGroupGroup) {
            $chatGroupGroup->get('', ListChatGroupsAction::class);
            $chatGroupGroup->get('/{id}', ViewChatGroupAction::class);
            $chatGroupGroup->post('', AddChatGroupAction::class);
        });

        $group->group('/user_group_members', function (Group $chatGroupMemberGroup) {
            $chatGroupMemberGroup->get('/{id}', ViewChatGroupMemberAction::class);
            $chatGroupMemberGroup->post('/{chatGroupId}', AddUserToChatGroupAction::class);
        });

        $group->group('/messages', function (Group $messageGroup) {
            $messageGroup->post('/{chatGroupId}', AddMessageAction::class);
            $messageGroup->get('/{chatGroupId}', ListMessagesForChatGroupAction::class);
        });
    });
};
