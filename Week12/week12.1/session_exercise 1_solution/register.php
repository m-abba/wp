<?php
$title = "Register";
include('includes/header.inc');
?>
<h1>Registration page</h1>
<?php
include('includes/nav.inc');
?>
<div>
    <form action="process_register.php" method="post">
        <label for="username">username</label>
        <input type="text" name="username" id="username"><br><br>
        <label for="password">password</label>
        <input type="password" name="password" id="password"><br><br>
        <input type="submit" value="Register">
    </form>
</div>
<?php
include('includes/footer.inc');
?>