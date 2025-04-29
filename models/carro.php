<?php
namespace models;
use interfaces\locavel;

// classe que representa um carro

class carro extends veiculo implements locavel {
    public function calcularAluguel(int $dias): float {
        return $dias * DIARIA_CARRO;
    }

    public function alugar(): string {
       if ($this->disponivel){
        $this->disponivel = false;
        return "Carro '{$this->modelo}' alugado com sucesso!";
       } 
       return "Carro '{$this->modelo}' não está dispinível.";
    }

    public function devolver(): string {
        if ($this->disponivel){
         $this->disponivel = true;
         return "Carro '{$this->modelo}' devolvido com sucesso!";
        } 
        return "Carro '{$this->modelo}' já está dispinível.";
    }
}