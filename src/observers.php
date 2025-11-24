<?php
interface InfoSubject {    // Interface for our Subject objects (defined in vaultElements.php)
    public function regObs(InfoObserver $o);
    // Not using remove observers since each page does not persist (added based on db notify value)
    // Each request to the server resets the values
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
        return "<hr>WARNING: Item {$this->state->itemID} is expired<hr>";
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
        else if ($this->type == "user") {
            return "
                    WARNING: Weak master password for user. 
                    Password should be at least 10 characters and contain numbers or special characters.
                    <hr>";
        }
    }
    public function update($subject, $t) {   // get newest expiration state and id to identify subject
        $this->state = $subject;
        $this->type = $t;
    }
    public function weakPassword() {   // determines if subject has a weak password
        if (strlen($this->state->getPassword()) > 10) {
            $hasLetter = preg_match('/[a-zA-Z]/', $this->state->getPassword());
            $hasNum = preg_match('/\d/', $this->state->getPassword());
            $hasSpecChar = preg_match('/[^a-zA-Z0-9]/', $this->state->getPassword());

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