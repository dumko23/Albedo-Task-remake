<?php

use App\core\Application;

$title = "Members List";

include('source/views/layouts/header.php')
?>
<a href="/">Back to Register Form</a>
<div class="memberList">
    <!--    --><?php
    //    Application::get('pageController')
    //        ->showMembers(Application::get('database')
    //            ->getFromDB(
    //                'photo, firstName, lastName, email, subject',
    //                Application::get('config')['database']['dbAndTable']
    //            )
    //        );
    //    ?>

    <?php
    foreach ($data as $member) {
        if ($member['photo'] === '') {
            $member['photo'] = 'source/uploads/default-image.png';
        }
        echo "<table class='member-table'>
        <tr>
            <td class='descr'>Photo</td>
            <td><img src='{$member['photo']}' alt='user photo'></td>
        </tr>
        <tr>
            <td class='descr'>Full Name</td>
            <td>{$member['firstName']} {$member['lastName']}</td>
        </tr>
        <tr>
            <td class='descr'>Report Subject</td>
            <td>{$member['subject']}</td>
        </tr>
        <tr>
            <td class='descr'>Email</td>
            <td><a href='mailto:{$member['email']}'>{$member['email']}</a></td>
        </tr>
    </table>
    ";
    }
    ?>
</div>

<a style="position: fixed; bottom: 0; left: 0;" href="#">To the top</a>
</body>
</html>
