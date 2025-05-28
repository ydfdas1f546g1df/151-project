<?php
if (isset($error)) {
    echo "<p style='color: red;'>$error</p>";
}
?>
<form method="post" action="index.php?url=login" class="login-card">
    <h1>Login</h1>
    <label for="username">Username:</label>
    <input type="text" id="username" name="username" required>
    </br>
    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required>

    <button type="submit" >Login</button>
</form>