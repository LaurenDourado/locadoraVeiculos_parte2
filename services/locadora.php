<?php
namespace services;
use models\{veiculo, carro, moto};

// classe para gerenciar a locação
class locadora{
    private array $veiculos = [];

    public function _construct(){
        $this->carregarVeiculos();
    }
    private function carregarVeiculos(): void{
        if (file_exists(ARQUIVO_JSON)){
            
            // decodifica o arquivo json
            $dados = json_decode(file_get_contents(ARQUIVO_JSON), true);

            foreach ($dados as $dado){
                if($dado['tipo'] === 'carro'){
                    $veiculo = new carro($dado['modelo'], $dado['placa']);
                } else {
                    $veiculo = new moto($dado['modelo'], $dado['placa']);
                }
                $veiculo->setDisponivel($dado['disponivel']);

                $this->veiculos[] = $veiculo;
            }
        }
    }
    // salvar veiculos
    private function salvarVeiculos(): void{
        $dados = [];

        foreach($this->veiculos as $veiculo){
            $dados[] = [
                'tipo' => ($veiculo instanceof carro) ? 'carro' :'moto',
                'modelo' => $veiculo -> getModelo(),
                'placa' => $veiculo -> getPlaca(),
                'disponivel' => $veiculo -> isDisponivel()
            ];
        }

        $dir =dirname(ARQUIVO_JSON);

        if (!is_dir($dir)){
            mkdir($dir, 0777, true);
        }
        file_put_contents(ARQUIVO_JSON, json_encode($dados, JSON_PRETTY_PRINT));
    }

    // adicinar novo veículo 
    public function adicionarVeiculo(veiculo $veiculo): void{
        $this->veiculos[]= $veiculo;
        $this->salvarVeiculos();
    }
    // remover veículo


    // alugar veiculo por x dias


    // devolver veiculo

    // retorna a lista de veiculos


    // calcular a previsão do valor
}
