<?php

    $chatGroup = 1;
    //@todo - add the UI for this project
?>
<!-- templates/index.html -->
<!DOCTYPE html>
<html lang="en-US">
<head>
    <title>Chat Form</title>
</head>
<body>
<h1>Send a Message</h1>
<form action="/api/messages/<?= $chatGroup //@todo - add the chat group to the URL ?>" method="POST">
    <input type="hidden" name="userId">
    <label>
        <textarea name="content" placeholder="Your message..." required></textarea>
    </label>
    <br>
    <button type="submit">Send</button>
</form>
</body>
</html>
