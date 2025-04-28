# Funcionamento do sistema de locadora de veículos com php e bootstrap

Esse documento descreve o funcionamento do sistema de locadora de veículos desenvolvido em php, utilizando o bootstrap para intervace, com autenticação de usuários, gerenciamento de veículos (carros e motos) e persistência de dados em arquivos json. O foco principal é explicar o funcionamento geral do sistema, com ênfase nos perfis de acesso (admin e usuário).

## 1. Visão geral do sistema

O sistema de locadora de veículos é uma aplicação web que permite:
- Autenticação de usuário com dois perfis: **admin** (administrador) e **usuário**
- Gerenciamento de veículos: cadastro, aluguel,devolução e exclusão;
- Cálculo de previsão de aluguel: com base no tipo de veículo (carro e moto) e número de dias;
- Interface responsiva.

Os dados são armazenados em dois arquivos JSON:
- `usuarios.json`: username, senha criptografada e perfil;
- `veiculos.json`: tipo, modelo, placa e status de disponibilidade.

## 2. Estrutura do sistema

O sistema utiliza:
- **PHP**: para a lógica
- **Bootstrap**: para a estilização
- **Bootstrap Icons**: para os ícones da interface
- **Composer**: para autoloading de classes
- **JSON**: para persistência de dados

### 2.1 Componentes principais
- **Interfaces**: define a interface `Locavel`para veículos e utiliza os métodos `alugar()`, `devolver()` e  `isDisponível()`
- **Models**: classes `Veiculo`(abstrata), `Carro` e `Moto`para os veículos, com cálculo de aluguel baseado em diárias constantes (`DIARIA_CARRO` e `DIARIA_MOTO`)
- **Services**: classes `AUTH`(autenticação e gerenciamento de usuários) e `Locadora`(gerenciamento dos veículos)
- **Views**: template principal `template.php` para renderizar a interface e `login.php` para a autenticação
- **Controllers**: lógica em `index.php`para processar requisições e carregar o template.