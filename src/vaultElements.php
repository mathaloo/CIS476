<?php
require_once 'observers.php';

// SECURE NOTES CLASS (doesn't belong to Observer or Proxy Patterns)
class SecureNote {
    private $name;
    private $note;

    public function __construct($name, $note) {
        $this->name = $name;
        $this->note = $note;
    }
    public function display() {
        echo 
        "<td>
            {$this->name}
        </td>
        <td>
            {$this->note}
        </td>";
    }
}

// Abstract Proxy
interface VaultInfo {
    public function display();
}

class ProxyLogin implements VaultInfo {
    private $loginInfo;
    private $reveal;

    public function display() {
        if (!$this->reveal) {
            echo 
            "<td>
                {$this->loginInfo->site}
            </td>
            <td>
                <i>hidden</i>
            </td>
            <td>
                <i>hidden</i>
            </td>
            <td>
                {$this->loginInfo->url}
            </td>";
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
    public $site;
    public $url;

    public function __construct($pw, $un, $site, $url) {
        $this->password = $pw;
        $this->username = $un;
        $this->site = $site;
        $this->url = $url;
    }
    public function display() {
        echo 
        "<td>
            {$this->site}
        </td>
        <td>
            {$this->username}
        </td>
        <td>
            {$this->password}
        </td>
        <td>
            {$this->url}
        </td>";
    }
    public function getPswd() {
        return $this->password;
    }
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
            echo 
            "<td>
                {$this->itemID}
            </td>
            <td>
                {$this->ccInfo->nameOnCard}
            </td>
            <td>
                <i>hidden</i>
            </td>
            <td>
                <i>hidden</i>
            </td>
            <td>
                {$this->ccInfo->expiration}
            </td>
            <td>
                {$this->ccInfo->zip}
            </td>";
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
    public $nameOnCard;
    public $expiration;
    public $zip;
    public $itemID;

    public function __construct($cn, $cvv, $name, $exp, $zip, $id) {
        $this->cardNum = $cn;
        $this->cvv = $cvv;
        $this->nameOnCard = $name;
        $this->expiration = $exp;
        $this->zip = $zip;
        $this->itemID = $id;
    }
    public function display() {
        echo 
        "<td>
            {$this->itemID}
        </td>
        <td>
            {$this->nameOnCard}
        </td>
        <td>
            {$this->cardNum}
        </td>
        <td>
            {$this->cvv}
        </td>
        <td>
            {$this->expiration}
        </td>
        <td>
            {$this->zip}
        </td>";
    }
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
            echo 
            "<td>
                {$this->itemID}
            </td>
            <td>
                <i>hidden</i>
            </td>
            <td>
                {$this->idInfo->type}
            </td>
            <td>
                {$this->idInfo->expiration}
            </td>";
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
    public $expiration;
    public $type;
    public $itemID;

    public function __construct($id, $exp, $t, $num) {
        $this->idNum = $id;
        $this->expiration = $exp;
        $this->type = $t;
        $this->itemID = $num;
    }
    public function display() {
        echo 
        "<td>
            {$this->itemID}
        </td>
        <td>
            {$this->idNum}
        </td>
        <td>
            {$this->type}
        </td>
        <td>
            {$this->expiration}
        </td>";
    }
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