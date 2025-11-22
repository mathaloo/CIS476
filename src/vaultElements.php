<?php
require_once 'observers.php';

interface VaultInfo {
    public function display();
}

class ProxyLogin implements VaultInfo {
    private $itemID;
    private $loginInfo;
    public function display() {
        // FIXME!!!
        return "blank";
    }
    public function __construct($id, $o) {
        $this->itemID = $id;
        $loginInfo = new RealLogin;
    }
}

class RealLogin implements VaultInfo, InfoSubject {
    private $observer = array();
    private $password;
    private $username;
    public $site;
    public $url;

    public function __construct($id, $o) {
        // ACCESS DATABASE FOR INSTANTIATION??
        $this->password = $id;
        //$loginInfo = new RealLogin;
    }
    public function display() {
        // FIXME!!!
        return "blank";
    }
    public function regObs(InfoObserver $o): void {
        $observer[] = $o;
    }
    public function removeObs(InfoObserver $o): void;
    public function notify(): void;
}