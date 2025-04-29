<?php
namespace models;
use interfaces\locavel;

// classe que representa as motos
class moto extends veiculo implements locavel{

    public function calcularAluguel(int $dias): float
    {
        return $dias * DIARIA_MOTO;
    }

    public function alugar(): string
    {
        if($this->disponivel){
            $this ->disponivel = false;
            return "Moto '{$this->modelo}' alugada com sucesso!";
        }
        return "moto '{$this->modelo}' não está dispinível.";
    }
    public function devolver(): string
    {
        if($this->disponivel){
            $this ->disponivel = true;
            return "Moto '{$this->modelo}' devolvida com sucesso!";
        }
        return "moto '{$this->modelo}' já está dispinível.";
    }
}