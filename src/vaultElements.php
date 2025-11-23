<?php
require_once 'observers.php';

// Abstract Proxy
interface VaultInfo {
    public function display();
}

class ProxyLogin implements VaultInfo {
    private $loginInfo;
    private $reveal;

    public function display() {
        if (!$this->reveal) {
            // FIXME!!!
        }
        else {
            $this->loginInfo->display();
        }
    }
    public function __construct(RealLogin $rl, $r) {
        $this->loginInfo = $rl;
        $this->reveal = $r;
    }
}

class RealLogin implements VaultInfo, InfoSubject {
    private $observer = array();
    private $password;
    private $username;
    //private $sub;
    public $site;
    public $url;

    public function __construct($pw, $un, $site, $url) {
        $this->password = $pw;
        $this->username = $un;
        //$this->sub = $sub;   // if the user does not want observer notifications for this item
        $this->site = $site;
        $this->url = $url;
    }
    public function display() {
        // FIXME!!!
        return "blank";
    }
    public function getPswd() {
        return $this->password;
    }
    /*public function getSub() {
        return $this->sub;
    }*/
    public function regObs(InfoObserver $o) {
        $this->observer[] = $o;
    }
    public function removeObs(InfoObserver $o) {
        // REMOVE?? 
    }
    public function notify() {
        foreach ($this->observer as $o) {
            $o->update($this, "login");
        }
    }
}

class ProxyCreditCard implements VaultInfo {
    private $ccInfo;
    private $itemID;
    private $reveal;

    public function display() {
        if (!$this->reveal) {
            // FIXME!!!
        }
        else {
            $this->ccInfo->display();
        }
    }
    public function __construct(RealCreditCard $rcc, $id, $r) {
        $this->ccInfo = $rcc;
        $this->itemID = $id;
        $this->reveal = $r;
    }
}

class RealCreditCard implements VaultInfo, InfoSubject {
    private $observer = array();
    private $cardNum;
    private $cvv;
    // private $sub;   // if the user does not want observer notifications for this item
    public $nameOnCard;
    public $expiration;
    public $zip;
    public $itemID;

    public function __construct($cn, $cvv, $name, $exp, $zip, $id) {
        $this->cardNum = $cn;
        $this->cvv = $cvv;
        // $this->sub = $sub;
        $this->nameOnCard = $name;
        $this->expiration = $exp;
        $this->zip = $zip;
        $this->itemID = $id;
    }
    public function display() {
        // FIXME!!!
        return "blank";
    }
    /*public function getSub() {
        return $this->sub;
    }*/
    public function regObs(InfoObserver $o) {
        $this->observer[] = $o;
    }
    public function removeObs(InfoObserver $o) {
        // REMOVE?? 
    }
    public function notify() {
        foreach ($this->observer as $o) {
            $o->update($this, "login");
        }
    }
}

class ProxyID implements VaultInfo {
    private $idInfo;
    private $itemID;
    private $reveal;
    
    public function display() {
        if (!$this->reveal) {
            // FIXME!!!
        }
        else {
            $this->idInfo->display();
        }
    }
    public function __construct(RealID $ri, $id, $r) {
        $this->idInfo = $ri;
        $this->itemID = $id;
        $this->reveal = $r;
    }
}

class RealID implements VaultInfo, InfoSubject {
    private $observer = array();
    private $idNum;
    //private $sub;   // if the user does not want observer notifications for this item
    public $expiration;
    public $type;
    public $itemID;

    public function __construct($id, $exp, $t, $num) {
        $this->idNum = $id;
        $this->expiration = $exp;
        //$this->sub = $sub;
        $this->type = $t;
        $this->itemID = $num;
    }
    public function display() {
        // FIXME!!!
        return "blank";
    }
    /*public function getSub() {
        return $this->sub;
    }*/
    public function regObs(InfoObserver $o) {
        $this->observer[] = $o;
    }
    public function removeObs(InfoObserver $o) {
        // REMOVE?? 
    }
    public function notify() {
        foreach ($this->observer as $o) {
            $o->update($this, "login");
        }
    }
}