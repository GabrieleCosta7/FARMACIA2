
<?php

function conectarBanco() {
    $host = 'localhost';
    $db = 'farmacia'; 
    $user = 'root'; 
    $pass = 'cimatec'; 

    try {
        $conn = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    } catch (PDOException $e) {
        echo "Erro na conexão: " . $e->getMessage();
        exit;
    }
}






// CADASTRAR MEDicamentos
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['cadastrar'])) {
    $nome = $_POST['nome'];
    $preco = $_POST['preco'];
    $quantidade = $_POST['quantidade'];
    $categoria = $_POST['categoria'];
    $validade = $_POST['validade'];

    $conn = conectarBanco();
    $sql = "INSERT INTO medicamentos (nome, preco, quantidade, categoria, validade) VALUES (:nome, :preco, :quantidade, :categoria, :validade)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':preco', $preco);
    $stmt->bindParam(':quantidade', $quantidade);
    $stmt->bindParam(':categoria', $categoria);
    $stmt->bindParam(':validade', $validade);
    
    try {
        $stmt->execute();
        echo "<div class='alert alert-success'>Medicamento cadastrado com sucesso!</div>";
    } catch (PDOException $e) {
        echo "<div class='alert alert-danger'>Erro ao cadastrar medicamento: " . $e->getMessage() . "</div>";
    }
}



//TABELA MEDICAMENTO/LISTAGEM
function listarMedicamentos() {
    $conn = conectarBanco();
    $sql = "SELECT * FROM medicamentos ORDER BY nome ASC"; 
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

$medicamentos = listarMedicamentos();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Cadastro de Medicamentos</title>
</head>
<body>
<div class="container mt-5">
    <h2>Cadastro de Medicamentos</h2>
    <form method="POST" action="">
        <div class="form-group">
            <label for="nome">Nome do Medicamento:</label>
            <input type="text" class="form-control" name="nome" required>
        </div>
        <div class="form-group">
            <label for="preco">Preço Unitário:</label>
            <input type="number" class="form-control" name="preco" step="0.01" required>
        </div>
        <div class="form-group">
            <label for="quantidade">Quantidade em Estoque:</label>
            <input type="number" class="form-control" name="quantidade" required>
        </div>
        <div class="form-group">
            <label for="categoria">Categoria:</label>
            <select class="form-control" name="categoria" required>
                <option>Analgesico</option>
                <option>Antibiotico</option>
                <option>Anti-inflamatorio</option>
            
            </select>
        </div>
        <div class="form-group">
            <label for="validade">Data de Validade:</label>
            <input type="date" class="form-control" name="validade" required>
        </div>
        <button type="submit" name="cadastrar" class="btn btn-primary">Cadastrar</button>
    </form>

    <h2 class="mt-5">Lista de Medicamentos</h2>
    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>Nome</th>
                <th>Preço</th>
                <th>Quantidade</th>
                <th>Categoria</th>
                <th>Validade</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($medicamentos as $medicamento): ?>
                <tr>
                    <td><?php echo htmlspecialchars($medicamento['nome']); ?></td>
                    <td><?php echo htmlspecialchars($medicamento['preco']); ?></td>
                    <td><?php echo htmlspecialchars($medicamento['quantidade']); ?></td>
                    <td><?php echo htmlspecialchars($medicamento['categoria']); ?></td>
                    <td><?php echo htmlspecialchars($medicamento['validade']); ?></td>
                    <td>
                        <a href="editar.php?id=<?php echo $medicamento['id']; ?>" class="btn btn-warning btn-sm">Editar</a>

                        <form action="excluir.php" method="POST" style="display:inline;">
                        <input type="hidden" name="id" value="<?php echo $medicamento['id']; ?>">
                        <button type="submit" class="btn btn-danger btn-sm">Excluir</button>
                </form>
                 </td>                    
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>