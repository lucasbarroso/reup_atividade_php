<?php
include __DIR__.'\persistencia\conexao.php';
include __DIR__.'\persistencia\PessoaDao.php';

if ($_SERVER['REQUEST_METHOD'] != 'GET') {
    http_response_code(405);
    die();
}
$text = @$_GET['nome'];
$nome = "%{$text}%";



//$sql = $mysqli->prepare("SELECT * FROM pessoas WHERE nome LIKE ?");
//$sql->bind_param("s", $nome);
//$sql->execute();
//TODO
//arrumar o pessoa dao para funcionar aqui(com as variaveis de ambiente)
$pessoaDao = new PessoaDao($nome);

$result = $pessoaDao->queryNome($nome);
$num_rows = $pessoaDao->countNome($nome);

//$countSQL =$mysqli->prepare( "SELECT COUNT(*) as total FROM pessoas WHERE nome like ?");
//$countSQL->bind_param("s",$nome);
//$countSQL->execute();
//$countResult = $countSQL->get_result();
// echo var_dump($countResult->fetch_field('total'));
//$countRow = $countResult->fetch_assoc();
//$num_rows = $countRow['total'];

if ($num_rows > 0) {
    $pessoas= array();
    
    $row_count = 0;
    while ($row = $result->fetch_assoc()) {
        $pessoas[]= $row;
        
        $row_count++;
        if ($row_count >= 5) {
            
            break; // Stop displaying rows after reaching the limit
        }
    }

    echo json_encode($pessoas, JSON_UNESCAPED_UNICODE);
        if ($row_count >= 5) {
            
             echo "<div class='box'>Existem mais de 5 registros, refine sua pesquisa</div>";
        }
} else {
    http_response_code(404);
    // echo "Nenhum registro foi encontrado.";
}

?>