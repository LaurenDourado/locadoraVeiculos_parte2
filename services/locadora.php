<?php
namespace services;

use models\{Veiculo, Carro, Moto};

// Classe para gerenciar a locação
class Locadora {
    private array $veiculos = [];

    public function __construct() {
        $this->carregarVeiculos();
    }

    private function carregarVeiculos(): void {
        if (file_exists(ARQUIVO_JSON)) {
            $dados = json_decode(file_get_contents(ARQUIVO_JSON), true);

            foreach ($dados as $dado) {
                if ($dado['tipo'] === 'carro') {
                    $veiculo = new Carro($dado['modelo'], $dado['placa']);
                } else {
                    $veiculo = new Moto($dado['modelo'], $dado['placa']);
                }

                $veiculo->setDisponivel($dado['disponivel']);
                $this->veiculos[] = $veiculo;
            }
        }
    }

    private function salvarVeiculos(): void {
        $dados = [];

        foreach ($this->veiculos as $veiculo) {
            $dados[] = [
                'tipo' => ($veiculo instanceof Carro) ? 'carro' : 'moto',
                'modelo' => $veiculo->getModelo(),
                'placa' => $veiculo->getPlaca(),
                'disponivel' => $veiculo->isDisponivel()
            ];
        }

        $dir = dirname(ARQUIVO_JSON);
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }

        file_put_contents(ARQUIVO_JSON, json_encode($dados, JSON_PRETTY_PRINT));
    }

    public function adicionarVeiculo(Veiculo $veiculo): void {
        $this->veiculos[] = $veiculo;
        $this->salvarVeiculos();
    }

    public function deletarVeiculo(string $modelo, string $placa): string {
        foreach ($this->veiculos as $key => $veiculo) {
            if ($veiculo->getModelo() === $modelo && $veiculo->getPlaca() === $placa) {
                unset($this->veiculos[$key]);
                $this->veiculos = array_values($this->veiculos);
                $this->salvarVeiculos();
                return "Veículo '{$modelo}' removido com sucesso!";
            }
        }
        return "Veículo não encontrado!";
    }

    public function alugarVeiculo(string $modelo, int $dias = 1): string {
        foreach ($this->veiculos as $veiculo) {
            if ($veiculo->getModelo() === $modelo && $veiculo->isDisponivel()) {
                $valorAluguel = $veiculo->calcularAluguel($dias);
                $mensagem = $veiculo->alugar();
                $this->salvarVeiculos();
                return $mensagem . " Valor do aluguel: R$" . number_format($valorAluguel, 2, ',', '.');
            }
        }
        return "Veículo não disponível";
    }

    public function devolverVeiculo(string $modelo): string {
        foreach ($this->veiculos as $veiculo) {
            if ($veiculo->getModelo() === $modelo && !$veiculo->isDisponivel()) {
                $mensagem = $veiculo->devolver();
                $this->salvarVeiculos();
                return $mensagem;
            }
        }
        return "Veículo já disponível ou não encontrado.";
    }

    public function listarVeiculos(): array {
        return $this->veiculos;
    }

    public function calcularPrevisaoAluguel(string $tipo, int $dias): float {
        if ($tipo === 'carro') {
            return (new Carro('', ''))->calcularAluguel($dias);
        }
        return (new Moto('', ''))->calcularAluguel($dias);
    }
}
