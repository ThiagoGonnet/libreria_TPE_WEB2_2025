<?php
class AdminView {
    function showLogin($error = null) {
        include "templates/admin/login.phtml";
    }

    function showPanel($user) {
        include "templates/admin/panel.phtml";
    }
}



