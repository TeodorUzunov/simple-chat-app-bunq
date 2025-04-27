/************************************** USER RELATED SECTION **************************************/
CREATE TABLE IF NOT EXISTS "User"
(
    ID      INTEGER                             not null
        primary key autoincrement,
    name    varchar                             not null,
    created timestamp default current_timestamp not null
);
CREATE UNIQUE INDEX user_name on User (name);
/************************************ CHAT GROUP RELATED SECTION ************************************/
CREATE TABLE IF NOT EXISTS "ChatGroup"
(
    ID      INTEGER
        primary key autoincrement,
    name    varchar                             not null,
    created timestamp default current_timestamp not null
);
CREATE UNIQUE INDEX chat_group_name on ChatGroup (name);
/******************************** CHAT GROUP MEMBER RELATED SECTION ********************************/
CREATE TABLE ChatGroupMember
(
    chatGroupID INTEGER   NOT NULL,
    userID      INTEGER   NOT NULL,
    created     timestamp NOT NULL default current_timestamp

);
CREATE UNIQUE INDEX group_user ON ChatGroupMember (chatGroupID, userID);
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