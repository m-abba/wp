<?php
$title = "Login";
include('includes/header.inc');
?>
<h1>Login Page</h1>
<?php
include('includes/nav.inc');
?>
<form action="login_process.php" method="post">
    <label for="username">Username:</label>
    <input type="text" name="username" id="username" required>
    <br>
    <label for="password">Password:</label>
    <input type="password" name="password" id="password" required>
    <br>
    <input type="submit" value="Register">
</form>

<?php
include('includes/footer.inc');
?>