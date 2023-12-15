<?php
include('Conexao.php');
// include('PessoaDao.php');
class Dao{

    // private Conexao $pdo;
    private $tabela = null;

    // Atributo estático que contém uma instância da própria classe
    private static $dao = null;
    private $conexao = null;

    private function __construct()
    {
        $this->conexao= new Conexao();
  
        
    }
    // //DÚVIDA Resposta: Design Pattern singleton para que haja robustez em garantir que somente uma conexão será feita
    public static function getInstance($tabela = NULL) {

    //     // Verifica se existe uma instância da classe
        if (!isset(self::$dao)) :
            try {
                self::$dao = new Dao($tabela);
            } catch (Exception $e) {
                echo "Erro " . $e->getMessage();
            }
        endif;
        if (!empty($tabela)) {
            self::$dao->setTableName($tabela);
        }
        return self::$dao;
    }


    //Qual tabela vai ser manipulada/consultada
    public function setTableName($tabela){
        if(!empty($tabela)){
          $this->tabela = $tabela;
        }
      }


      //Statement executaInsert
    public function executaInsert($arrayDados){
      $insert =$this->buildInsert($arrayDados);
      echo var_dump($arrayDados);
      echo var_dump($insert);
      $stmt = $this->conexao->getPdo()->prepare($insert);
      $result = $stmt->execute($arrayDados);
      var_dump($result);
    }

    public function executaUpdate($arrayDados, $arrayUpdate){
        $update = $this->buildUpdate($arrayDados, $arrayUpdate);
        $stmt = $this->conexao->getPdo()->prepare($update);
        // Parte que combina os arrays de alguma maneira que da certo?
        $arrayUpdatePrefixed = array_combine(
            array_map(function($k){ return 'update_'.$k; }, array_keys($arrayUpdate)),
            $arrayUpdate
        );
        var_dump($arrayUpdatePrefixed);
        $parametros = array_merge($arrayDados, $arrayUpdatePrefixed);
        var_dump($parametros);
        // Executa a instrução SQL
        $result = $stmt->execute($parametros);
    
        // Retorna o resultado da execução
        return $result;
    }
    // public function executaUpdate($arrayDados, $arrayUpdate){
    //     $update = $this->buildUpdate($arrayDados, $arrayUpdate);
    //     echo var_dump($arrayDados);
    //     echo var_dump($arrayUpdate);
    //     $stmt = $this->conexao->getPdo()->prepare($update);
    //     $result = $stmt->execute($arrayUpdate);
    //     var_dump($result);
    // }


    // Statement executa select
    public function executaSelect($arrayDados){
        $select = $this->buildSelect($arrayDados);
        var_dump($arrayDados);
        var_dump($select);
        $stmt = $this->conexao->getPdo()->prepare($select);
        $stmt->execute($arrayDados);
        $result = $stmt->fetch(PDO::FETCH_OBJ);
        var_dump($result);
        return $result;
        
        
    }
    public function executaDelete($arrayDados){
        $delete = $this->buildDelete($arrayDados);
        var_dump($delete);
        $stmt = $this->conexao->getPdo()->prepare($delete);
        $result = $stmt->execute($arrayDados);
        var_dump($result);
    }

    //entra um array de dados-> sai uma string ###SUGESTÃO FUTURA: Conseguir fazer o buildInsert ser genérico para todas as ações do CRUD?
    private function buildInsert($arrayDados){

        // Inicializa variáveis
        $sql = "";
        $campos = "";
        $valores = "";
 
        // Loop para montar a instrução com os campos e valores
        foreach($arrayDados as $chave => $valor){
           $campos .= $chave . ', ';
           $valores .= ":$chave, ";
        }
 
        // Retira vírgula do final da string
        $campos = (substr($campos, -2) == ', ') ? trim(substr($campos, 0, (strlen($campos) - 2))) : $campos ;
        $valores = (substr($valores, -2) == ', ') ? trim(substr($valores, 0, (strlen($valores) - 2))) : $valores ;
 
        // Concatena todas as variáveis e finaliza a instrução
        $sql .= "INSERT INTO {$this->tabela} (" . $campos . ") VALUES (" . $valores . ")";
        // echo var_dump($sql);

        // Retorna string com instrução SQL
        return trim($sql);

    }




    private function buildSelect($arrayDados){ //IMPORTANTE: Perguntar como devo lidar com os diversos casos especiais de selects #talvez fazer sobrecarga?

        // Inicializa variáveis
        $sql = "";
        $campos = "";
        $where = "";
    
        // Loop para montar a instrução com os campos
        foreach($arrayDados as $campo => $valor){
           $campos .= "\"" . $campo . "\", ";
           $where .= "\"" . $campo . "\" = :" . $campo . " AND ";
        }
    
        // Retira vírgula do final da string
        $campos = (substr($campos, -2) == ', ') ? trim(substr($campos, 0, (strlen($campos) - 2))) : $campos ; //Se for fazer uma consulta + especifica
    
        // Retira AND do final da string
        $where = (substr($where, -5) == ' AND ') ? trim(substr($where, 0, (strlen($where) - 5))) : $where ;
    
        // Concatena todas as variáveis e finaliza a instrução
        $sql .= "SELECT * FROM \"" . $this->tabela . "\" WHERE " . $where;
    
        // Retorna string com instrução SQL
        return trim($sql);
    }



    private function buildUpdate($arrayDados, $arrayUpdate){ 

        // Inicializa variáveis
        $sql = "";
        $where = "";
        $set = "";
    
        // Loop para montar a instrução com os campos para o WHERE
        foreach($arrayDados as $campo => $valor){
           $where .= "\"" . $campo . "\" = :" . $campo . " AND ";
        }
    
        // Loop para montar a instrução com os campos para o SET
        foreach($arrayUpdate as $campo => $valor){
           $set .= "\"" . $campo . "\" = :update_" . $campo . ", ";
           var_dump($set);
        }
    
        // Retira AND do final da string
        $where = (substr($where, -5) == ' AND ') ? trim(substr($where, 0, (strlen($where) - 5))) : $where ;
    
        // Retira vírgula do final da string
        $set = (substr($set, -2) == ', ') ? trim(substr($set, 0, (strlen($set) - 2))) : $set ;
    
        // Concatena todas as variáveis e finaliza a instrução
        $sql .= "UPDATE \"" . $this->tabela . "\" SET " . $set . " WHERE " . $where;
    
        // Retorna string com instrução SQL
        return trim($sql);
    }



    private function buildDelete($arrayDados){
        // Inicializa variáveis
        $sql = "";
        $where = "";
    
        // Loop para montar a instrução com os campos
        foreach($arrayDados as $campo => $valor){
           $where .= "\"" . $campo . "\" = :" . $campo . " AND ";
        }
    
        // Retira AND do final da string
        $where = (substr($where, -5) == ' AND ') ? trim(substr($where, 0, (strlen($where) - 5))) : $where ;
    
        // Concatena todas as variáveis e finaliza a instrução
        $sql .= "DELETE FROM \"" . $this->tabela . "\" WHERE " . $where;
        var_dump($sql);
    
        // Retorna string com instrução SQL
        return trim($sql);
    }





    
    
}
// $conexao = new Conexao();

// $teste = new PessoaDao();

// $teste->queryNome("%joão%");
// var_dump($teste);
$dao = Dao::getInstance('pessoa'); //os :: funcionam semelhante a -
// $dao->setTableName('pessoa');
$dados = array('nome'=> "Lucas");//'id'=>50,'nome'=> "Jão"
// $dadosAtualizados= array('id'=>1, 'nome'=>"João");
// $dados = array('id'=>22  );
// $resultado = $dao->buildInsert($dados);
// echo var_dump($resultado);
$dao->executaDelete($dados);


