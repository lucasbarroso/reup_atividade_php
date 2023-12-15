<?php
class PessoaDAO {}

class DAO {

  public function select() { // pegar do banco e devolver objeto
    $result
      while ($row)
        foreach ($row as $chave => valor)
          $p = new Pessoa()
          $p->[$chave] = $valor;
  }

  // receber objeto e salvar no banco
  public function insert(Entidade $entidade) {
    echo var_dump($entidade->tabela());
    echo var_dump($entidade->atributos());

    // $sql = "INSERT INTO " . $entidade->tabela() . (iterar os atributos) ex: (nome, idade) VALUES ('L:ucas', '');
    
  }
}

// class Conta implements Entidade {
//   $atributos = array();
  
//   public function tabela() {
//     return "contas_pagar";
//   }

//   public function atributos() {
//     return $this->atributos;
//   }
// }

interface Entidade {
  function tabela();
  function atributos();
}


class Pessoa implements Entidade { // classe/aberta
  private $atributos = array();

  public function tabela() {
    return "pessoas";
  }

  public function atributos() {
    return $this->atributos;
  }

  public function __set($chave, $valor) {
    $this->atributos[$chave] = $valor;
  }

  public function __get($chave) {
    return $this->atributos[$chave];
  }
}

// iterar $result, para cada propriedade e valor
//  $p->propriedade = valor;
// $row -> SELECT
$p = new Pessoa();
$p->nome = "Lucas";
$p->idade = 27;
$p->nacionalidade = "Brasileira";
$p->cidade = "Rio Grande";

echo "INSERT INTO {$p->tabela()} () VALUES ()";
echo "\n";
foreach($p->atributos() as $chave => $valor) {
  echo $chave . ': ' . $valor;
  echo "\n";
}

$dao = new DAO();
$dao->insert($p);
// DAO genérico, um DAO para qualquer objeto
// o dao vai ler os atributos e fazer
// um insert
// echo var_dump($p);
// echo $p->nome;
// echo "Hello, world!\n";