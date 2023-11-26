<?php

namespace Controller;

use Base\Controller;
use Model\AuthenticationModel;

class AuthenticationController extends Controller
{

    private AuthenticationModel $authModel;

    public function __construct()
    {
        if ($this->callModel("AuthenticationModel") == null) {
            return;
        }

        $this->authModel = $this->callModel("AuthenticationModel");
    }


    public function logInUser(string $username, string $password): bool
    {
        if($username == null || $password == null) {
            return false;
        }

        return $this->authModel->authenticateUser($username, $password);
    }

}