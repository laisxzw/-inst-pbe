<?php
//CONFIGURAÇÕES INICIAS
//cabeçalho com algumas configurações
//define a resposta da API, neste caso o JSON
header("content-type:application/json; charset=utf-8");
//permite o acesso á API de todas as origens
header("acess-control-allow-origin: ");
//permite os metodos
header("acess-control-allow-methods: GET, POST, PUT, DELETE");
require"config.php";
$rota = $_GET["rota"]??"";
$metodo = $_SERVER["REQUEST_METHOD"];
//NECESSARIO para ultilizamos o PUT
$corpo = json_decode(file_get_contents("php://input"),true) ??[];
function teste(){
echo json_encode(["mensagem"=> "Back-end do instagram_db respondendo!"]);
exit;
}
//CRUD - usuario
//CREATE
function createUsuarios($con, $dados){
$stmt = $con->prepare(
"INSERT INTO USUARIOS (NOME, USERNAME, EMAIL, SENHA) VALUES (?,?,?,?)"
);
$stmt->execute ([$dados["nome"], $dados["username"], $dados["email"], $dados["senha"]]);
http_response_code(201);
echo json_encode(["mensagem" => "usuario criado com sucesso!", "id" => $con->lastInsertId()]
);
}
//READ
function readUsuarios($con){
$stmt =$con->query("SELECT * FROM Usuarios");
echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
}
// UPDATE
function updateUsuarios($con, $id, $dados){
    $stmt = $con->prepare("UPDATE Usuarios SET nome = ?, username = ?, email = ?, senha = ? WHERE id_usuario = ?");
    $stmt->execute([
        $dados["nome"],
        $dados["username"],
        $dados["email"],
        $dados["senha"],
        $id]);

    echo json_encode([
        "mensagem" => "Usuario atualizado com sucesso!"
    ]);
}

//DELETE
function deleteUsuarios($con, $id){
$stmt = $con->prepare("DELETE FROM Usuarios WHERE id_usuario=?");
$stmt->execute([$id]);
echo json_encode(["mensagem" => "Usuario removido com sucesso!"]);
}
//CRUD -publicacoes
//CREATE
function createPublicacoes($con, $dados){
$stmt = $con->prepare(
"INSERT INTO PUBLICACOES (ID_USUARIO, LEGENDA, IMAGEM_URL, DATA_PUBLICACAO) VALUES (?,?,?,?)"
);
$stmt->execute ([$dados["id_usuario"], $dados["legenda"], $dados["imagem_url"], $dados["data_publicacao"]]);
http_response_code(201);
echo json_encode(["mensagem" => "Sua imagem foi publicada com sucesso!", "id" => $con->lastInsertId()]
);
}
//READ
function readPublicacoes($con){
$stmt =$con->query("SELECT * FROM publicacoes");
echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
}
//UPDATE
function updatePublicacoes($con, $id, $dados){
    $stmt = $con->prepare("UPDATE Publicacoes SET LEGENDA=?, IMAGEM_URL=?, DATA_PUBLICACAO=? WHERE id_publicacao=?"
    );
    $stmt->execute([
        $dados["legenda"],
        $dados["imagem_url"],
        $dados["data_publicacao"],
        $id
    ]);
    echo json_encode([
        "mensagem" => "Publicação atualizada com sucesso!"
    ]);
}
//DELETE
function deletePublicacoes($con, $id){
    $stmt = $con->prepare(
        "DELETE FROM Publicacoes WHERE id_publicacao=?"
    );
    $stmt->execute([$id]);
    echo json_encode([
        "mensagem" => "Publicação apagada com sucesso!"
    ]);
}
//CRUD - curtida
//CREATE
function createCurtida($con, $dados){
$stmt = $con->prepare(
"INSERT INTO Curtidas (ID_USUARIO, ID_PUBLICACAO) VALUES (?,?)"
);
$stmt->execute ([$dados["id_usuario"], $dados["id_publicacao"]]);
http_response_code(201);
echo json_encode(["mensagem" => "Curtida enviada com sucesso!", "id" => $con->lastInsertId()]
);
}
//READ
function readCurtida($con){
$stmt =$con->query("SELECT * FROM Curtidas");
echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
}
//UPDATE
function updateCurtida($con, $id, $dados){
    $stmt = $con->prepare("UPDATE Curtidas SET ID_USUARIO=?, ID_PUBLICACAO=? WHERE id_Curtida=?");
    $stmt->execute([$dados["id_usuario"], $dados["id_publicacao"], $id]);
    echo json_encode(["mensagem" => "Curtida atualizada com sucesso!"]);
}
//DELETE
function deleteCurtida($con, $id){
$stmt = $con->prepare("DELETE FROM Curtidas WHERE id_curtida=?");
$stmt->execute([$id]);
echo json_encode(["mensagem" => "Curtida removida com sucesso!"]);
}
//ROTAS
if($rota == "usuarios"){
switch($metodo){
case"GET":
readUsuarios($con);
break;
case"POST":
createUsuarios($con, $corpo);
break;
case"PUT":
updateUsuarios($con, $_GET["id"], $corpo);
break;
case"DELETE":
deleteUsuarios($con,$_GET["id"]);
break;
default:
teste();
}
}else if ($rota == "publicacoes"){
switch($metodo){
case"GET":
readPublicacoes($con);
break;
case"POST":
createPublicacoes($con, $corpo);
break;
case"PUT":
updatePublicacoes($con, $_GET["id"],$corpo);
break;
case"DELETE":
deletePublicacoes($con, $_GET["id"]);
break;
default:
teste();
}
}elseif ($rota == "curtida"){
switch($metodo){
case"GET":
readCurtida($con);
break;
case"POST":
createCurtida($con, $corpo);
break;
case"PUT":
updateCurtida($con, $_GET["id"],$corpo);
break;
case"DELETE":
deleteCurtida($con, $_GET["id"]);
break;
default:
teste();
}
}