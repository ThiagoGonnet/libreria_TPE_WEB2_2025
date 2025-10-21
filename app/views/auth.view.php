<?php
class AuthView
{
  public function showLogin($error = null)
  {
    require_once './app/templates/admin/login.phtml';
  }

  public function showError($error)
  {
    echo "<h1>$error</h1>";
  }
}
