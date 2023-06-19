<?php 

ini_set('display_errors', 1);
error_reporting(E_ALL);

//Adiciona o arquivo de Conexão a esta página
require_once("Connection.php");

//Conexão a ser utiliza no acesso ao banco de dados
$conn = Connection::getConnection();
//print_r($conn);

if(isset($_POST['submetido'])) {
    $titulo = isset($_POST['titulo']) ? $_POST['titulo'] : null;
    $genero = isset($_POST['genero']) ? $_POST['genero'] : null;
    $qtdPaginas = isset($_POST['qtdPaginas']) ? 
                        $_POST['qtdPaginas'] : null;

    $sql = 'INSERT INTO livros (titulo, genero, qtd_paginas)' .
        ' VALUES (?, ?, ?)';
    $stmt = $conn->prepare($sql);
    $stmt->execute([$titulo, $genero, $qtdPaginas]);

    header("location: livros.php");
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de livros</title>
</head>
<body>
    <h1>Cadastro de livros</h1>

    <h3>Formulário de livros</h3>
    <form action="" method="POST">
        <input type="text" name="titulo" 
            placeholder="Informe o título" />

        <br><br>

        <select name="genero">
            <option value="">---Selecione o gênero---</option>
            <option value="D">Drama</option>
            <option value="F">Ficção</option>
            <option value="R">Romance</option>
            <option value="O">Outro</option>
        </select>

        <br><br>

        <input type="number" name="qtdPaginas"
            placeholder="Informe o número de páginas" />

        <br><br>

        <button type="submit">Cadastrar</button>

        <input type="hidden" name="submetido" value="1" />
    </form>

    <h3>Listagem de livros</h3>
    <?php 
        $sql = "SELECT * FROM livros";

        //Prepara e executa o comando SQL
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        //Armazena os resultados ($result é uma matriz)
        $result = $stmt->fetchAll();
    ?>
    <table border="1">
        <tr>
            <td>ID</td>
            <td>Título</td>
            <td>Gênero</td>
            <td>Páginas</td>
            <td></td>
        </tr>
        
        <?php foreach($result as $reg): ?>
            <tr>
                <td> <?php echo $reg['id'] ?> </td>
                <td> <?php echo $reg['titulo'] ?> </td>
                <td> 
                <?php 
                    switch($reg['genero']) {
                        case 'D':
                            echo "Drama";
                            break;
                        case 'F':
                            echo "Ficção";
                            break;
                        case 'R':
                            echo "Romance";
                            break;
                        case 'O':
                            echo "Outros";
                            break;
                    }
                ?> 
                </td>
                <td> <?= $reg['qtd_paginas'] ?> </td>
                <td><a href="livros_del.php?id=<?= $reg['id']; ?>"
                        onclick="return confirm('Confirma a exclusão?');">
                        Excluir</a></td>

            </tr>
        <?php endforeach; ?>
    </table>

</body>
</html>

