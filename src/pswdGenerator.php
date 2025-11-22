<?PHP
interface buildPassword{
    public function produceCharacters(): void;
    public function produceNumbers(): void;
    public function produceSymbols(): void;
    public function getPassword();
}

class weakPassword implements buildPassword{
    private $result;

    public function __construct(){
       $this->reset();
    }
    public function reset(): void{
        $this->result = "";
    }
    public function produceCharacters(): void{
        $this->result = $this->result."char";
    }
    public function produceNumbers(): void{
        $this->result = $this->result."num";
    }
    public function produceSymbols(): void{
        $this->result = $this->result."symweak";
    }
    public function getPassword(): string {
        $result = $this->result;
        $this->reset();
        return $result;
    }
}

class medPassword implements buildPassword{
    private $result;

    public function __construct(){
       $this->reset();
    }
    public function reset(): void{
        $this->result = "";
    }
    public function produceCharacters(): void{
        $this->result = $this->result."char";
    }
    public function produceNumbers(): void{
        $this->result = $this->result."num";
    }
    public function produceSymbols(): void{
        $this->result = $this->result."symmed";
    }
    public function getPassword(): string {
        $result = $this->result;
        $this->reset();
        return $result;
    }
}

class strongPassword implements buildPassword{
    private $result;

    public function __construct(){
       $this->reset();
    }
    public function reset(): void{
        $this->result = "";
    }
    public function produceCharacters(): void{
        $this->result = $this->result."char";
    }
    public function produceNumbers(): void{
        $this->result = $this->result."num";
    }
    public function produceSymbols(): void{
        $this->result = $this->result."symhard";
    }
    public function getPassword(): string {
        $result = $this->result;
        $this->reset();
        return $result;
    }
}

class director{
    public function buildPassword($builder): string{
        $builder->produceCharacters();
        $builder->produceNumbers();
        $builder->produceSymbols();
        return $builder->getPassword();
    }
}