<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="./style.css"/>
</head>
<body>
    <div class="login-page">
    <div class="form">
    <form class="login-form" method="POST" action="connection.php" >
      <input type="text" name="username" placeholder="username@insa-cvl.fr"/>
      <input type="password" name="password" placeholder="password"/>
      <button name="login">login</button>
      <p class="message">Not registered? <a href="#">Create an account</a></p>
    </form>
  </div>
</div>
    
</body>
</html>