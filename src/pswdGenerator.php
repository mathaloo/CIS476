<?PHP
interface BuildPassword{
    public function produceCharacters(): void;
    public function produceNumbers(): void;
    public function produceSymbols(): void;
    public function getPassword();
}

class weakPassword implements BuildPassword{
    private $result;

    public function __construct(){
       $this->reset();
    }
    public function reset(): void{
        $this->result = "";
    }
    public function produceCharacters(): void{
        for($i = 0; $i < 10; $i++){
        if(rand(0,1) == 0){
            $this->result .= chr(rand(65,90));
        }else{
            $this->result .= chr(rand(97,122));
        }
        }
    }
    public function produceNumbers(): void{
        for($i = 0; $i < 10; $i++){
        $this->result .= chr(rand(48, 57));
        }
    }
    public function produceSymbols(): void{
        $this->result = $this->result."";
    }
    public function getPassword(): string {
        $result = $this->result;
        $this->reset();
        return $result;
    }
}

class medPassword implements BuildPassword{
    private $result;

    public function __construct(){
       $this->reset();
    }
    public function reset(): void{
        $this->result = "";
    }
    public function produceCharacters(): void{
        for($i = 0; $i < 10; $i++){
        if(rand(0,1) == 0){
            $this->result .= chr(rand(65,90));
        }else{
            $this->result .= chr(rand(97,122));
        }
        }
    }
    public function produceNumbers(): void{
        for($i = 0; $i < 10; $i++){
        $this->result .= chr(rand(48, 57));
        }
    }
    public function produceSymbols(): void{
        for($i = 0; $i < 10; $i++){
        $this->result .= chr(rand(33, 47));
        }
    }    
    public function getPassword(): string {
        $result = $this->result;
        $this->reset();
        return $result;
    }
}

class strongPassword implements BuildPassword{
    private $result;

    public function __construct(){
       $this->reset();
    }
    public function reset(): void{
        $this->result = "";
    }
    public function produceCharacters(): void{
        for($i = 0; $i < 15; $i++){
        if(rand(0,1) == 0){
            $this->result .= chr(rand(65,90));
        }else{
            $this->result .= chr(rand(97,122));
        }
        }
    }
    public function produceNumbers(): void{
        for($i = 0; $i < 15; $i++){
        $this->result .= chr(rand(48, 57));
        }
    }
    public function produceSymbols(): void{
        for($i = 0; $i < 15; $i++){
        $this->result .= chr(rand(33, 47));
        }
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