<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Medicamento</title>
</head>
<body>
    <h1>Editar Medicamento</h1>
    <?php 
        require 'conexao.php';
        $id = $_REQUEST["id"];
        $dados = []; // p armazenar os dados
        $sql = $pdo->prepare("SELECT * FROM medicamentos WHERE id = :id");
        $sql->bindValue(":id", $id);
        $sql->execute();

        if($sql->rowCount() > 0) {
            $dados = $sql->fetch(PDO::FETCH_ASSOC);
        } else {
            header("Location: cadastrarMed.php");
            exit;
        }     
    ?>
    <form action="editando.php" method="$_POST">
        <input type="hidden" name="id" id="id" value="<?= htmlspecialchars($dados['id']); ?>">
        <label for="nome">
            Nome: <input type="text" name="nome" value="<?= htmlspecialchars($dados['nome']); ?>">
        </label>        
        <label for="preco">
            Preço: <input type="number" step="0.01" name="preco" value="<?= htmlspecialchars($dados['preco']); ?>">
        </label>
        <label for="quantidade">
            Quantidade: <input type="number" name="quantidade" value="<?= htmlspecialchars($dados['quantidade']); ?>">
        </label>
        <label for="categoria">
            Categoria: 
            <select name="categoria">
                <option <?= $dados['categoria'] == 'Analgesico' ? 'selected' : ''; ?>>Analgesico</option>
                <option <?= $dados['categoria'] == 'Antibiotico' ? 'selected' : ''; ?>>Antibiotico</option>
                <option <?= $dados['categoria'] == 'Anti-inflamatorio' ? 'selected' : ''; ?>>Anti-inflamatorio</option>
            </select>
        </label>
        <label for="validade">
            Validade: <input type="date" name="validade" value="<?= htmlspecialchars($dados['validade']); ?>">
        </label>
        <button type="submit">Salvar</button>
    </form>
</body>
</html>
