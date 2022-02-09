<?php
// ADICIONA A CLASSE DO OBJETO FeiraLivre
require_once '../Classes/FeiraLivre.php';
require_once '../Classes/LogMsg.php';
$feira = new FeiraLivre();
$log = new LogMsg();

//PEGA O METODO DA REQUISICAO PARA TRATAR
$method=$_SERVER['REQUEST_METHOD'];
$request = file_get_contents('php://input');
$arr_request = json_decode($request,true);

$log->InsereLog(array("api" => basename( __FILE__ ),"method" => $method,array("request" => $arr_request)));

switch ($method){
    case "GET" :        
        if(isset($_GET['campo']) && isset($_GET['busca'])){
            $_GET['campo'] = strtoupper($_GET['campo']);
            
            $log->InsereLog(array($method, array("campo" => $_GET['campo'], "busca" => $_GET['busca'])));
            
            if ($_GET['campo'] == "DISTRITO" ||
                $_GET['campo'] == "REGIAO5" || 
                $_GET['campo'] == "NOMEFEIRA" ||
                $_GET['campo'] == "BAIRRO"){
                                
                $retorno = $feira->ExibeFeirasComFiltro($_GET['campo'], $_GET['busca']);
                if ($retorno==false){
                    Response(200, array(
                                        "codigo"=>200,
                                        "mensagem"=>"Nenhuma feira encontrada"
                                        )); 
                }else{
                    Response(200, $retorno); 
                }
                
            }else{
                $arr_return = array(
                                    "codigo"=>999,
                                    "mensagem"=>"Campo inválido para busca de feiras"
                                    ); 
                Response(400, $arr_return);
            }
        }else{
            $retorno = $feira->ExibeFeiras();
            if ($retorno==false){
                Response(200, array(
                                    "codigo"=>200,
                                    "mensagem"=>"Nenhuma feira cadastrada"
                                    )); 
            }else{
                Response(200, $retorno); 
            }
            
        }
        break;
    case "DELETE" :
        if (!isset($_GET['id'])){            
            $arr_return = array(
                               "codigo"=>999,
                               "mensagem"=>"É necessário informar um ID no endpoint para atualizar uma feira"
                               ); 
            Response(400, $arr_return);
        }else{
            $feira->setId($_GET['id']);
            $consulta_DB = $feira->ExibeFeiraPorID();

            if($consulta_DB !== false){
                $retorno = $feira->DeletaFeira();
                if ($retorno == false){
                    Response(500, array(
                                        "codigo"=>500,
                                        "mensagem"=>"Ocorreu um erro interno"
                                        ));
                }else{
                    Response(200, array(
                                       "codigo"=>200,
                                       "mensagem"=>"Feira excluída com sucesso"
                                        ));
                }
            }else{
                $arr_return = array(
                                    "codigo"=>999,
                                    "mensagem"=>"Feira não encontrada"
                                    );
                Response(404, $arr_return);
            }
        }
        break;
    case "POST" :
        // Retorna ERRO na API
        if ($arr_request == NULL){
            $arr_return = array(
                                "codigo"=>999,
                                "mensagem"=>"Request Inválido"
                                );
            Response(400, $arr_return);
        }else{
            foreach ($arr_request as $obj){
                $validacao = $feira->ValidaDados($obj);

                if($validacao !== true){
                    break;
                }
            }
                        
            if($validacao !== true){
                Response(400, $validacao);
                exit;
            }else{
                $flag = false;
                foreach ($arr_request as $obj){
                    $feira->setId(0);
                    $feira->setLong($obj['long']);
                    $feira->setLat($obj['lat']);
                    $feira->setSetcens($obj['setcens']);
                    $feira->setAreap($obj['areap']);
                    $feira->setCoddist($obj['coddist']);
                    $feira->setDistrito($obj['distrito']);
                    $feira->setCodsubpref($obj['codsubpref']);
                    $feira->setSubprefe($obj['subprefe']);
                    $feira->setRegiao5($obj['regiao5']);
                    $feira->setRegiao8($obj['regiao8']);
                    $feira->setNomefeira($obj['nomefeira']);
                    $feira->setRegistro($obj['registro']);
                    $feira->setLogradouro($obj['logradouro']);
                    $feira->setNumero($obj['numero']);
                    $feira->setBairro($obj['bairro']);
                    if(isset($obj['referencia'])){
                        $feira->setReferencia($obj['referencia']);
                    }else{
                        $feira->setReferencia("");
                    }
                                        
                    $retorno = $feira->InserirFeira();
                    if ($retorno == false){
                        $flag = true;
                    }
                }
                
                if ($flag == true){
                    Response(500, array("codigo"=>500,
                            "mensagem"=>"Ocorreu um erro interno"
                            ));
                }else{
                    Response(201, array("codigo"=>201,
                            "mensagem"=>"Feira cadastrada com sucesso"
                            ));
                }
                
            }
            
        }
        break;
    case "PUT" :
        // Retorna ERRO na API     
        if ($arr_request == NULL || !isset($_GET['id'])){            
            if ($arr_request == NULL){
                $arr_return = array(
                                "codigo"=>999,
                                "mensagem"=>"Request Inválido"
                                );
            }else{
                $arr_return = array(
                                "codigo"=>999,
                                "mensagem"=>"É necessário informar um ID no endpoint para atualizar uma feira"
                                );
            }
            
            Response(400, $arr_return);
        }else{
            $validacao = $feira->ValidaDados($arr_request);
                        
            if($validacao !== true){
                Response(400, $validacao);
            }else{
                $feira->setId($_GET['id']);
                $consulta_DB = $feira->ExibeFeiraPorID();

                if($consulta_DB !== false){
                    $feira->setLong($arr_request['long']);
                    $feira->setLat($arr_request['lat']);
                    $feira->setSetcens($arr_request['setcens']);
                    $feira->setAreap($arr_request['areap']);
                    $feira->setCoddist($arr_request['coddist']);
                    $feira->setDistrito($arr_request['distrito']);
                    $feira->setCodsubpref($arr_request['codsubpref']);
                    $feira->setSubprefe($arr_request['subprefe']);
                    $feira->setRegiao5($arr_request['regiao5']);
                    $feira->setRegiao8($arr_request['regiao8']);
                    $feira->setNomefeira($arr_request['nomefeira']);
                    $feira->setRegistro($arr_request['registro']);
                    $feira->setLogradouro($arr_request['logradouro']);
                    $feira->setNumero($arr_request['numero']);
                    $feira->setBairro($arr_request['bairro']);
                    if(isset($arr_request['referencia'])){
                        $feira->setReferencia($arr_request['referencia']);
                    }else{
                        $feira->setReferencia("");
                    }

                    $retorno = $feira->AtualizarFeira();
                    if ($retorno == false){
                        Response(500, array(
                            "codigo"=>500,
                            "mensagem"=>"Ocorreu um erro interno"
                            ));
                    }else{
                        Response(200, array(
                            "codigo"=>200,
                            "mensagem"=>"Feira atualizada com sucesso"
                            ));
                    }
                }else{
                    $arr_return = array(
                                "codigo"=>999,
                                "mensagem"=>"Feira não encontrada"
                                );
                    Response(404, $arr_return);
                }
            }
        }
        break;
    default :
        $arr_return = array(
                            "codigo"=>999,
                            "mensagem"=>"Método não suportado"
                            );
        Response(405, $arr_return);
}

function Response($code,$arr_response){
    header('Content-Type: application/json; charset=utf-8');
    http_response_code($code);
    echo json_encode($arr_response);
    
    // Gera Log
    $log = new LogMsg();
    if($code == 200 || $code == 201){
        $log->InsereLog(array($arr_response));
    }else{
        $log->InsereLog(array($arr_response),"ERROR");
    }
    
}