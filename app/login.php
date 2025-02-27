<?php
include_once 'templates/login_register.php'
?>
<button onclick='window.location.href = "register.php"' id="switchButton">Register</button>
<form action="userHandeling.php" method="POST" id="loginForm">
    <label id="topTextLogin">Login</label>
    <input type="text" name="username" placeholder="Username">
    <input type="password" name="password" placeholder="Password">
    <input class="submit" type="submit" value="login" name="login">
</form>
</body>
</html>
