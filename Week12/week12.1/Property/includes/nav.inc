<nav>
    <a href=index.php>Home</a>
    <?php if (!isset($_SESSION['username'])) { ?>
        <a href=register.php>Register</a>
        <a href=login.php>Login</a>
    <?php } ?>
    <?php if (!empty($_SESSION['username'])) { ?>
        <a href=new_property.php>New Property</a>
        <a href=logout.php>Logout</a>
    <?php } ?>
    <a href=properties.php>Properties</a>
</nav>