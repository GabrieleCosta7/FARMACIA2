<?php 
    require 'conexao.php'; 

    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $preco = $_POST['preco'];
    $quantidade = $_POST['quantidade'];
    $categoria = $_POST['categoria'];
    $validade = $_POST['validade'];
    
    $sql = $pdo->prepare("UPDATE medicamentos SET nome = :nome, preco = :preco, quantidade = :quantidade, categoria = :categoria, validade = :validade WHERE id = :id");
    $sql->bindValue(':id', $id);
    $sql->bindValue(':nome', $nome);
    $sql->bindValue(':preco', $preco);
    $sql->bindValue(':quantidade', $quantidade);
    $sql->bindValue(':categoria', $categoria);
    $sql->bindValue(':validade', $validade);

    $sql->execute();
    
    header("Location: cadastrarMed.php");
?>
