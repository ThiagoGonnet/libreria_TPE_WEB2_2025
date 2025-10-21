<?php

class AuthView
{

  public function showLogin($error, $user)
  {
    require_once './templates/admin/login.phtml';
  }

  public function showError($error, $user)
  {
    echo "<h1>$error</h1>";
  }
  function showPanel($user)
  {
    include "templates/admin/panel.phtml";
  }
}
