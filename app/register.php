<?php
include_once 'templates/login_register.php'
?>
<button onclick='window.location.href = "login.php"' id="switchButton">Login</button>
<form action="userHandeling.php" method="POST" id="registerForm">
    <label id="topTextLogin">Register</label>
    <input type="text" name="username" placeholder="Username">
    <input type="password" name="password" placeholder="Password">
    <input class="submit" type="submit" value="register" name="register">
</form>
</body>
</html>
