<?php
class AuthView
{
  function showLogin($error = null, $user = null)
  {
    require_once './templates/admin/login.phtml';
  }

  function showError($error, $user = null)
  {
    echo "<h1>$error</h1>";
  }
}
