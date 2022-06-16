<?php

use App\core\Application;

$title = "Members List";

include('source/views/layouts/header.php')
?>
<a href="/">Back to Register Form</a>
<div class="memberList">
    <?php
    Application::get('view')->showMembers(Application::get('database')->getMembersFromDB());
    ?>
</div>

<a style="position: fixed; bottom: 0; left: 0;" href="#">To the top</a>
</body>
</html>
