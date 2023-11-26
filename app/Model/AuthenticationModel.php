<?php

namespace Model;

use Base\Controller;
use Base\Model;
use Exception;

class AuthenticationModel extends Model
{
    public string $table = 'authentication';

    public function __construct(Controller $controller)
    {
        parent::__construct();
    }

    public function authenticateUser(string $username, string $password): bool
    {

        if ($this->checkCredentials($username, $password)) {
            $userId = $this->getUserIdByUsername($username);

            // Überprüfe, ob der Nutzer bereits in der Tabelle authentication eingetragen ist
            if (!$this->isUserAuthenticated($userId)) {
                // Der Nutzer ist nicht eingetragen, erstelle einen neuen Eintrag
                $authKey = $this->generateUniqueAuthKey();
                $revokeTimestamp = time() + 24 * 60 * 60; // Timestamp für 24 Stunden

                // Füge den neuen Eintrag in die Tabelle authentication ein
                $this->insertAuthenticationEntry($userId, $authKey, $revokeTimestamp);
            }

            $_SESSION['auth'] = true;
            $_SESSION['authKey'] = $authKey;

            return true;
        }

        return false; // Anmeldung fehlgeschlagen
    }

    private function checkCredentials(string $username, string $password): bool
    {

        $query = "SELECT password FROM ". USERS ." WHERE username = :username";

        $this->setQueryString($query);
        $this->setParams(['username' => $username]);
        $this->executeStatement();
        $result = $this->getResult();



        $hashedPasswordFromDatabase = $result[0]['password']; // Hier hole das gehashte Passwort aus der Datenbank

        return password_verify($password, $hashedPasswordFromDatabase);
    }

    private function getUserIdByUsername(string $username): int
    {
        // Hier implementierst du die Logik zur Rückgabe der user_id anhand des Benutzernamens
        // Beispiel: SELECT user_id FROM users WHERE username = :username
        $query = "SELECT id FROM users WHERE username = :username";
        $params = ['username' => $username];

        $this->setQueryString($query);
        $this->setParams($params);
        $this->executeStatement();

        $result = $this->getResult();

        // Annahme: Es wird erwartet, dass nur ein Ergebnis zurückgegeben wird
        return isset($result[0]['id']) ? (int)$result[0]['id'] : 0;
    }

    private function isUserAuthenticated(int $userId): bool
    {
        // Hier implementierst du die Logik zur Überprüfung, ob der Nutzer bereits eingetragen ist
        // Beispiel: SELECT COUNT(*) FROM authentication WHERE user_id = :user_id
        $query = "SELECT COUNT(*) FROM ".AUTHENTIFICATION." WHERE user_id = :user_id";
        $params = ['user_id' => $userId];

        $this->setQueryString($query);
        $this->setParams($params);
        $this->executeStatement();

        $result = $this->getResult();
        return isset($result[0]['COUNT(*)']) && $result[0]['COUNT(*)'] > 0;
    }

    private function generateUniqueAuthKey(): string
    {
        try {
            return bin2hex(random_bytes(6));
        } catch (Exception $e) {
        }
    }

    private function insertAuthenticationEntry(int $userId, string $authKey, int $revokeTimestamp): void
    {
        // Hier implementierst du die Logik zum Einfügen eines neuen Eintrags in die Tabelle authentication
        // Beispiel: INSERT INTO authentication (user_id, auth_key, revoke_timestamp) VALUES (:user_id, :auth_key, :revoke_timestamp)
        $query = "INSERT INTO authentication (auth_key, user_id, revoke_timestamp) VALUES (:auth_key, :user_id, :revoke_timestamp)";
        $params = [
            'auth_key' => $authKey,
            'user_id' => $userId,
            'revoke_timestamp' => $revokeTimestamp
        ];

        $this->setQueryString($query);
        $this->setParams($params);
        $this->executeStatement();
    }
}