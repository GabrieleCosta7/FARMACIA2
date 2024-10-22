<?php 
    require 'conexao.php';
    $id = $_POST['id'];

    $sql = $pdo->prepare("DELETE FROM medicamentos WHERE id = :id");
    $sql->bindValue(':id', $id);
   
    $sql->execute();
    
    header("Location: cadastrarMed.php");
?>
