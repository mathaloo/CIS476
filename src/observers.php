<?php
interface InfoSubject {    // Interface for our Subject objects (defined in vaultElements.php)
    public function regObs(InfoObserver $o);
    public function removeObs(InfoObserver $o);
    public function notify();
}

interface InfoObserver {
    public function display();
    public function update(InfoSubject $first, $second);
}

class ExpObserver implements InfoObserver {
    private $state;
    private $type;
    //private $type;
    public function display() {
        return "Item {$this->state->itemID} is expired";
    }
    public function update($subject, $t) {   // get newest expiration state and id to identify subject
        $this->state = $subject;
        $this->type = $t;
    }
    public function expired() {   // determines if subject has expired data
        $exp = new DateTime($this->state->expiration);
        $today = new DateTime();

        if ($exp < $today) {
            return true;
        }
        return false;
    }
}

class PswdObserver implements InfoObserver {
    private $state;
    private $type;

    public function display() {
        if ($this->type == "login"){
            return "<hr>
                    WARNING: Weak password for website {$this->state->site}. 
                    Password should be at least 10 characters and contain numbers or special characters.
                    <hr>";
        }
    }
    public function update($subject, $t) {   // get newest expiration state and id to identify subject
        $this->state = $subject;
        $this->type = $t;
    }
    public function weakPassword() {   // determines if subject has a weak password
        if (strlen($this->state->getPswd()) > 10) {
            $hasLetter = preg_match('/[a-zA-Z]/', $this->state->getPswd());
            $hasNum = preg_match('/\d/', $this->state->getPswd());
            $hasSpecChar = preg_match('/[^a-zA-Z0-9]/', $this->state->getPswd());

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