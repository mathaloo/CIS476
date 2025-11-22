<?php
interface InfoSubject {    // Interface for our Subject objects (defined in vaultElements.php)
    public function regObs(InfoObserver $o): void;
    public function removeObs(InfoObserver $o): void;
    public function notify(): void;
}

interface InfoObserver {
    public function display();
    public function update($first, $second);
}

class ExpObserver implements InfoObserver {
    private $expiration;
    private $id;
    //private $type;
    public function display() {
        return "Item {$this->id} is expired";
    }
    public function update($exp, $id) {   // get newest expiration state and id to identify subject
        $this->expiration = $exp;
        $this->id = $id;
    }
    public function expired() {   // determines if subject has expired data
        $exp = new DateTime($this->expiration);
        $today = new DateTime();

        if ($exp > $today) {
            return true;
        }
        return false;
    }
}

class PswdObserver implements InfoObserver {
    private $password;
    private $web;
    //private $type;
    public function display() {
        return "Weak password for website {$this->web}. 
                Password should be at least 10 characters and contain numbers or special characters." ;
    }
    public function update($pw, $site = "") {   // get newest expiration state and id to identify subject
        $this->password = $pw;
        $this->web = $site;
    }
    public function weakPassword() {   // determines if subject has expired data
        if (strlen($this->password) > 10) {
            $hasLetter = preg_match('/[a-zA-Z]/', $this->password);
            $hasNum = preg_match('/\d/', $this->password);
            $hasSpecChar = preg_match('/[^a-zA-Z0-9]/', $this->password);

            if ($hasLetter && $hasNum) {
                return false;
            }
            else if ($hasLetter && $hasSpecChar) {
                return false;
            }
            else if ($hasNum && $hasSpecChar) {
                return false;
            }
        }
        return true;
    }
}