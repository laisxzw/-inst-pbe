
<?php

// CONFIGURAÇÕES INICIAIS

$host = "localhost";
$banco = "instagram_db";
$usuario = "root";
$senha = "";

try {

    // CONEXÃO COM O BANCO DE DADOS

    $con = new PDO(
        "mysql:host=$host;dbname=$banco;charset=utf8",
        $usuario,
        $senha
    );

    // CONFIGURAÇÃO DE ERROS

    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {

    echo json_encode([
        "erro" => "Erro ao conectar com o banco de dados!"
    ]);

    exit;

}

?>
