<!DOCTYPE html>
<html>
<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <title>My Form Project</title>
   <style>
      span.error {
         color: red;
      }
      form 
      {
         margin:0 auto;
      }
   </style>
</head>
<body>

<?php
require 'myformdatabasee.php'; // All logic & validation is here
?>
<h1>registration form </h1>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <input type='hidden' name="action" value="register-form"/>
    <table>
        <tr>
            <td><label for="name">Name</label></td>
            <td>
                <input type="text" name="name" value="<?php echo htmlspecialchars($_POST['name'] ?? ''); ?>">
                <span class="error">* <?php echo $errors['name'] ?? ''; ?></span>
            </td>
        </tr>
        <tr>
            <td><label for="email">Email</label></td>
            <td>
                <input type="email" name="email" value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>">
                <span class="error">* <?php echo $errors['email'] ?? ''; ?></span>
            </td>
        </tr>
        <tr>
            <td><label for="password">Password</label></td>
            <td>
                <input type="password" name="password">
                <span class="error">* <?php echo $errors['password'] ?? ''; ?></span>
            </td>
        </tr>
        <tr>
            <td><label for="cfpassword">Confirm Password</label></td>
            <td>
                <input type="password" name="cfpassword">
                <span class="error">* <?php echo $errors['cfpassword'] ?? ''; ?></span>
            </td>
        </tr>
        <tr>
            <td colspan="2"><input type="submit" value="Register"></td>
        </tr>
    </table>
</form>

</body>
</html>