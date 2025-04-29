<?php
// define espaço para organização do código
namespace services;

class auth{
    private array $usuarios = [];

    // método construtor
    public function __construct()
    {
        $this ->carregarUsuarios();
    }

    // método para carregar usuários do arquivo json
    private function carregarUsuarios(): void{
        // verificar se existe o arquivo 
        if(file_exists(ARQUIVO_USUARIOS)){
            $conteudo = json_decode(file_get_contents(ARQUIVO_USUARIOS), true);

            // verificar se é um array
            $this->usuarios = is_array($conteudo) ? $conteudo:[];
        } else{
            $this -> usuarios = [
                ['username' => 'admin',
                'password' => password_hash('admin123', PASSWORD_DEFAULT),
                'perfil' => 'admin'
                ],
                ['username' => 'usuario',
                'password' => password_hash('usuario123', PASSWORD_DEFAULT),
                'perfil' => 'usuario'
                ]
            ];
            $this -> salvarUsuarios();
        }
    }

    // função para salvar usuários no arquivo json
    private function salvarUsuarios():void{
        $dir = dirname(ARQUIVO_USUARIOS);

        if(!is_dir($dir)){
            mkdir($dir, 0777, true);
        }

        file_put_contents(ARQUIVO_USUARIOS, json_encode($this->usuarios, JSON_PRETTY_PRINT));
    }

    // método para realizar login
    public function login(string $username, string $password): bool{

        foreach ($this ->usuarios as $usuario){
            if ($usuario['username'] === $username && password_verify ($password, $usuario['password'])){
                $_SESSION['auth'] = [
                    'logado' => true,
                    'username' => $username,
                    'perfil' => $usuario['perfil']
                ];
                return true;    //login realizado
            }
        }
        return false; //não realizou login
    }
    public function logout() :void{
        session_destroy();
    }

    // verificar se o usuário está logado
    public static function verificarLogin():bool{
        return isset($_SESSION['auth']) && $_SESSION['auth']['perfil'] === true;
    }

    public static function isPerfil(string $perfil): bool{
        return isset($_SESSION['auth']) && $_SESSION['auth']['perfil'] === $perfil;
    }
    public static function isAdmin(): bool{
        return self::isPerfil('admin');
    }
    public static function getUsuario(): ?array {
        // retorna os dados da sessão ou nulo se não existir
        return $_SESSION['auth'] ?? null;
    }
}