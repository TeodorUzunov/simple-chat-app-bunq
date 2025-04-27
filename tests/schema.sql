/************************************** USER RELATED SECTION **************************************/
CREATE TABLE IF NOT EXISTS "User"
(
    ID      INTEGER                             not null
        primary key autoincrement,
    name    varchar                             not null,
    created timestamp default current_timestamp not null
);
CREATE UNIQUE INDEX user_name on User (name);
INSERT INTO User
VALUES (1, 'test_user_1', 1745490297),
       (2, 'test user 2', 1745480297),
       (3, 'test_user_3$', 1735490297);
/************************************ CHAT GROUP RELATED SECTION ************************************/
CREATE TABLE IF NOT EXISTS "ChatGroup"
(
    ID      INTEGER
        primary key autoincrement,
    name    varchar                             not null,
    created timestamp default current_timestamp not null
);
CREATE UNIQUE INDEX chat_group_name on ChatGroup (name);
INSERT INTO ChatGroup
VALUES (1, 'test_group_1', 1745490297),
       (2, 'test group 2', 1745480297),
       (3, 'test_group_3$', 1735490297);
/******************************** CHAT GROUP MEMBER RELATED SECTION ********************************/
CREATE TABLE IF NOT EXISTS  "ChatGroupMember"
(
    chatGroupID INTEGER   NOT NULL,
    userID      INTEGER   NOT NULL,
    created     timestamp NOT NULL default current_timestamp

);
CREATE UNIQUE INDEX group_user ON ChatGroupMember (chatGroupID, userID);
INSERT INTO ChatGroupMember
VALUES (1, 1, 1745490297),
       (2, 2, 1745480297),
       (3, 2, 1735490297);
/************************************* MESSAGE RELATED SECTION *************************************/
CREATE TABLE IF NOT EXISTS "Message"
(
    ID          INTEGER
        primary key autoincrement,
    chatGroupID INTEGER                             not null,
    userID      INTEGER                             not null,
    content     TEXT                                not null,
    created     timestamp default current_timestamp not null
);
INSERT INTO Message
VALUES (1, 1, 1, 'Test message from user 1 to chat group 1', 1745490297),
       (2, 1, 2, 'Test message from user 2 to chat group 1', 1745490297),
       (3, 3, 3, 'Test message from user 3 to chat group 3', 1745490297);