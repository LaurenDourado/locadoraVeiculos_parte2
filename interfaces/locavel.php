<?php
namespace interfaces;

// interface que define os métodos necessários para um veículo ser locável

interface locavel {
    public function alugar() : string;
    public function devolver() : string;
    public function isDisponivel() : bool;
}
?>