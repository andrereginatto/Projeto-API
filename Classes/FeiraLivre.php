<?php
require_once 'database/Conexao.php';
require_once 'LogMsg.php';

class FeiraLivre extends Conexao{
    
    private $id;
    private $long;
    private $lat;
    private $setcens;
    private $areap;
    private $coddist;
    private $distrito;
    private $codsubpref;
    private $subprefe;
    private $regiao5;
    private $regiao8;
    private $nomefeira;
    private $registro;
    private $logradouro;
    private $numero;
    private $bairro;
    private $referencia;
            
    function ExibeFeiras(){
        $sql = Conexao::$db->prepare("SELECT * FROM feira");
        
        $this->insereLog(__FUNCTION__, $sql);
        
        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }
    
    function ExibeFeirasComFiltro($campo,$busca){
        switch ($campo){
            case "REGIAO5":
                $sql = Conexao::$db->prepare("SELECT * FROM feira WHERE UPPER(REGIAO5) LIKE(UPPER(:BUSCA))");
                break;
            case "DISTRITO":
                $sql = Conexao::$db->prepare("SELECT * FROM feira WHERE UPPER(DISTRITO) LIKE(UPPER(:BUSCA))");
                break;
            case "NOMEFEIRA":
                $sql = Conexao::$db->prepare("SELECT * FROM feira WHERE UPPER(NOMEFEIRA) LIKE(UPPER(:BUSCA))");
                break;
            case "BAIRRO":
                $sql = Conexao::$db->prepare("SELECT * FROM feira WHERE UPPER(BAIRRO) LIKE (UPPER(:BUSCA))");
                break;
        }
        
        $this->insereLog(__FUNCTION__, $sql);
        
        $sql->execute(array(':BUSCA' => '%' . $busca . '%'));
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }
    
    function ExibeFeiraPorID(){
        $sql = Conexao::$db->prepare("select * from FEIRA where ID = :ID");
        
        $this->insereLog(__FUNCTION__, $sql);
        
        $sql->execute(array(':ID' => $this->id));
        return $sql->fetch(PDO::FETCH_ASSOC);
    }
    
    function InserirFeira(){
        $sql = Conexao::$db->prepare("INSERT INTO feira ("
                                                    . "`ID`,"
                                                    . "`LONG`,"
                                                    . "`LAT`,"
                                                    . "`SETCENS`,"
                                                    . "`AREAP`,"
                                                    . "`CODDIST`,"
                                                    . "`DISTRITO`,"
                                                    . "`CODSUBPREF`,"
                                                    . "`SUBPREFE`,"
                                                    . "`REGIAO5`,"
                                                    . "`REGIAO8`,"
                                                    . "`NOMEFEIRA`,"
                                                    . "`REGISTRO`,"
                                                    . "`LOGRADOURO`,"
                                                    . "`NUMERO`,"
                                                    . "`BAIRRO`,"
                                                    . "`REFERENCIA`"
                                                  . ") "
                                        . "VALUES ("
                                                    . ":ID,"
                                                    . ":LONG,"
                                                    . ":LAT,"
                                                    . ":SETCENS,"
                                                    . ":AREAP,"
                                                    . ":CODDIST,"
                                                    . ":DISTRITO,"
                                                    . ":CODSUBPREF,"
                                                    . ":SUBPREFE,"
                                                    . ":REGIAO5,"
                                                    . ":REGIAO8,"
                                                    . ":NOMEFEIRA,"
                                                    . ":REGISTRO,"
                                                    . ":LOGRADOURO,"
                                                    . ":NUMERO,"
                                                    . ":BAIRRO,"
                                                    . ":REFERENCIA"
                                                . ")");
        $this->insereLog(__FUNCTION__, $sql);
        
        return $sql->execute(array(":ID" => $this->id,
                                   ":LONG" => $this->long,
                                   ":LAT" => $this->lat,
                                   ":SETCENS" => $this->setcens,
                                   ":AREAP" => $this->areap,
                                   ":CODDIST" => $this->coddist,
                                   ":DISTRITO" => $this->distrito,
                                   ":CODSUBPREF" => $this->codsubpref,
                                   ":SUBPREFE" => $this->subprefe,
                                   ":REGIAO5" => $this->regiao5,
                                   ":REGIAO8" => $this->regiao8,
                                   ":NOMEFEIRA" => $this->nomefeira,
                                   ":REGISTRO" => $this->registro,
                                   ":LOGRADOURO" => $this->logradouro,
                                   ":NUMERO" => $this->numero,
                                   ":BAIRRO" => $this->bairro,
                                   ":REFERENCIA" => $this->referencia));
    }
    
    function AtualizarFeira(){
        $sql = Conexao::$db->prepare("UPDATE feira ".
                                        "SET `LONG` = :LONG,"
                                         . " `LAT` = :LAT,"
                                         . " `SETCENS` = :SETCENS,"
                                         . " `AREAP` = :AREAP,"
                                         . " `CODDIST` = :CODDIST,"
                                         . " `DISTRITO` = :DISTRITO,"
                                         . " `CODSUBPREF` = :CODSUBPREF,"
                                         . " `SUBPREFE` = :SUBPREFE,"
                                         . " `REGIAO5` = :REGIAO5,"
                                         . " `REGIAO8` = :REGIAO8,"
                                         . " `NOMEFEIRA` = :NOMEFEIRA,"
                                         . " `REGISTRO` = :REGISTRO,"
                                         . " `LOGRADOURO` = :LOGRADOURO,"
                                         . " `NUMERO` = :NUMERO,"
                                         . " `BAIRRO` = :BAIRRO,"
                                         . " `REFERENCIA` = :REFERENCIA"
                                       . " WHERE ID = :ID");
        
        $this->insereLog(__FUNCTION__, $sql);
        
        return $sql->execute(array(":ID" => $this->id,
                                   ":LONG" => $this->long,
                                   ":LAT" => $this->lat,
                                   ":SETCENS" => $this->setcens,
                                   ":AREAP" => $this->areap,
                                   ":CODDIST" => $this->coddist,
                                   ":DISTRITO" => $this->distrito,
                                   ":CODSUBPREF" => $this->codsubpref,
                                   ":SUBPREFE" => $this->subprefe,
                                   ":REGIAO5" => $this->regiao5,
                                   ":REGIAO8" => $this->regiao8,
                                   ":NOMEFEIRA" => $this->nomefeira,
                                   ":REGISTRO" => $this->registro,
                                   ":LOGRADOURO" => $this->logradouro,
                                   ":NUMERO" => $this->numero,
                                   ":BAIRRO" => $this->bairro,
                                   ":REFERENCIA" => $this->referencia));
    }
    
    function DeletaFeira(){
        $sql = Conexao::$db->prepare("DELETE FROM feira WHERE ID = :ID");
        
        $this->insereLog(__FUNCTION__, $sql);
        
        return $sql->execute(array(':ID'=>$this->id));
    }

    function ValidaDados($feira){
        
        $this->insereLog(__FUNCTION__, null);
        
        if(!isset($feira['long']) || empty($feira['long']) || $feira['long'] == ""){            
            return array("codigo"=>10101,"mensagem"=>"O campo LONG é obrigatório.");
        }
        if(!isset($feira['lat']) || empty($feira['lat']) || $feira['lat'] == ""){
            return array("codigo"=>10102,"mensagem"=>"O campo LAT é obrigatório.");
        }
        if(!isset($feira['setcens']) || empty($feira['setcens']) || $feira['setcens'] == ""){
            return array("codigo"=>10103,"mensagem"=>"O campo SETCENS é obrigatório.");
        }
        if(!isset($feira['areap']) || empty($feira['areap']) || $feira['areap'] == ""){
            return array("codigo"=>10104,"mensagem"=>"O campo AREAP é obrigatório.");
        }
        if(!isset($feira['coddist']) || empty($feira['coddist']) || $feira['coddist'] == ""){
            return array("codigo"=>10105,"mensagem"=>"O campo CODDIST é obrigatório.");
        }
        if(!isset($feira['distrito']) || empty($feira['distrito']) || $feira['distrito'] == ""){
            return array("codigo"=>10106,"mensagem"=>"O campo DISTRITO é obrigatório.");
        }
        if(!isset($feira['codsubpref']) || empty($feira['codsubpref']) || $feira['codsubpref'] == ""){
            return array("codigo"=>10107,"mensagem"=>"O campo CODSUBPREF é obrigatório.");
        }
        if(!isset($feira['subprefe']) || empty($feira['subprefe']) || $feira['subprefe'] == ""){
            return array("codigo"=>10108,"mensagem"=>"O campo SUBPREFE é obrigatório.");
        }
        if(!isset($feira['regiao5']) || empty($feira['regiao5']) || $feira['regiao5'] == ""){
            return array("codigo"=>10109,"mensagem"=>"O campo REGIAO5 é obrigatório.");
        }
        if(!isset($feira['regiao8']) || empty($feira['regiao8']) || $feira['regiao8'] == ""){
            return array("codigo"=>10110,"mensagem"=>"O campo REGIAO8 é obrigatório.");
        }
        if(!isset($feira['nomefeira']) || empty($feira['nomefeira']) || $feira['nomefeira'] == ""){
            return array("codigo"=>10111,"mensagem"=>"O campo NOMEFEIRA é obrigatório.");
        }
        if(!isset($feira['registro']) || empty($feira['registro']) || $feira['registro'] == ""){
            return array("codigo"=>10112,"mensagem"=>"O campo REGISTRO é obrigatório.");
        }
        if(!isset($feira['logradouro']) || empty($feira['logradouro']) || $feira['logradouro'] == ""){
            return array("codigo"=>10113,"mensagem"=>"O campo LOGRADOURO é obrigatório.");
        }
        if(!isset($feira['numero']) || empty($feira['numero']) || $feira['numero'] == ""){
            return array("codigo"=>10114,"mensagem"=>"O campo NUMERO é obrigatório.");
        }
        if(!isset($feira['bairro']) || empty($feira['bairro']) || $feira['bairro'] == ""){
            return array("codigo"=>10115,"mensagem"=>"O campo BAIRRO é obrigatório.");
        }
        return true;
    }

    function getId() {
        return $this->id;
    }

    function getLong() {
        return $this->long;
    }

    function getLat() {
        return $this->lat;
    }

    function getSetcens() {
        return $this->setcens;
    }

    function getAreap() {
        return $this->areap;
    }

    function getCoddist() {
        return $this->coddist;
    }

    function getDistrito() {
        return $this->distrito;
    }

    function getCodsubpref() {
        return $this->codsubpref;
    }

    function getSubprefe() {
        return $this->subprefe;
    }

    function getRegiao5() {
        return $this->regiao5;
    }

    function getRegiao8() {
        return $this->regiao8;
    }

    function getNomefeira() {
        return $this->nomefeira;
    }

    function getRegistro() {
        return $this->registro;
    }

    function getLogradouro() {
        return $this->logradouro;
    }

    function getNumero() {
        return $this->numero;
    }

    function getBairro() {
        return $this->bairro;
    }

    function getReferencia() {
        return $this->referencia;
    }

    function setId($id): void {
        $this->id = $id;
    }

    function setLong($long): void {
        $this->long = $long;
    }

    function setLat($lat): void {
        $this->lat = $lat;
    }

    function setSetcens($setcens): void {
        $this->setcens = $setcens;
    }

    function setAreap($areap): void {
        $this->areap = $areap;
    }

    function setCoddist($coddist): void {
        $this->coddist = $coddist;
    }

    function setDistrito($distrito): void {
        $this->distrito = $distrito;
    }

    function setCodsubpref($codsubpref): void {
        $this->codsubpref = $codsubpref;
    }

    function setSubprefe($subprefe): void {
        $this->subprefe = $subprefe;
    }

    function setRegiao5($regiao5): void {
        $this->regiao5 = $regiao5;
    }

    function setRegiao8($regiao8): void {
        $this->regiao8 = $regiao8;
    }

    function setNomefeira($nomefeira): void {
        $this->nomefeira = $nomefeira;
    }

    function setRegistro($registro): void {
        $this->registro = $registro;
    }

    function setLogradouro($logradouro): void {
        $this->logradouro = $logradouro;
    }

    function setNumero($numero): void {
        $this->numero = $numero;
    }

    function setBairro($bairro): void {
        $this->bairro = $bairro;
    }

    function setReferencia($referencia): void {
        $this->referencia = $referencia;
    }
    
    function insereLog($nome_function, $sql_query){
        $log = new LogMsg();
        $log->InsereLog(array("Nome Function" => $nome_function, "sql" => $sql_query));
    }

}
