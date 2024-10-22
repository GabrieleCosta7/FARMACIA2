<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Excluir Medicamento</title>
</head>
<body>
    <h1>Excluindo Medicamento</h1>
    <?php 
        require 'conexao.php';
        $id = $_REQUEST["id"];
        $dados = []; // p armazenar os dados

        $sql = $pdo->prepare("SELECT * FROM medicamentos WHERE id = :id");
        $sql->bindValue(":id", $id);
        $sql->execute();

        if($sql->rowCount() > 0){
            $dados = $sql->fetch(PDO::FETCH_ASSOC);
        } else {
            header("Location: cadastrarMed.php");
            exit;
        }
    ?>
    <h2>Tem certeza que quer excluir o medicamento abaixo?</h2>

    <form action="excluindo.php" method="$_REQUEST">
        <input type="hidden" name="id" id="id" value="<?= htmlspecialchars($dados['id']); ?>">
        <label for="nome">
            Nome: <input type="text" name="nome" value="<?= htmlspecialchars($dados['nome']); ?>" disabled>
        </label>
        <label for="preco">
            Preço: <input type="text" name="preco" value="<?= htmlspecialchars($dados['preco']); ?>" disabled>
        </label>
        <label for="quantidade">
            Quantidade: <input type="text" name="quantidade" value="<?= htmlspecialchars($dados['quantidade']); ?>" disabled>
        </label>
        <label for="categoria">
            Categoria: <input type="text" name="categoria" value="<?= htmlspecialchars($dados['categoria']); ?>" disabled>
        </label>
        <label for="validade">
            Validade: <input type="text" name="validade" value="<?= htmlspecialchars($dados['validade']); ?>" disabled>
        </label>

        <button type="submit">Excluir</button>
    </form>

    <a href="cadastrarMed.php">Voltar</a>
</body>
</html>
