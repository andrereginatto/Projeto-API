<?php
require_once '../Classes/FeiraLivre.php';
require_once '../Classes/LogMsg.php';
$feira = new FeiraLivre();
$log = new LogMsg();
$method=$_SERVER['REQUEST_METHOD'];


$log->InsereLog(array("api" => basename( __FILE__ ),"method" => $method));

if ($method !== 'POST'){
    $arr_return = array(
                        "codigo"=>999,
                        "mensagem"=>"Método não suportado"
                        );
    Response(405, $arr_return);
}else{
    if (isset($_FILES['arquivo'])) {
        $flag_erro = false;
        if (move_uploaded_file($_FILES['arquivo']['tmp_name'], '../arquivos/' . $_FILES['arquivo']['name'])) {
            $linhas = fopen("../arquivos/" . $_FILES['arquivo']['name'], "r") or die("Unable to open file!");
            $cont_linhas = 0;
            while (!feof($linhas)) {


                $linha = fgets($linhas);
                $linha = explode(',', $linha);
                // Verifica se é a ultima linha e se é vazia, caso sim, pula a linha
                if (feof($linhas) == true && $linha[0] == "") {
                    break;
                }
                if (count($linha) < 16) {
                    $flag_erro = true;
                    Response(400, array("codigo" => 400,
                        "mensagem" => "O número de colunas deve ser igual a 16 ou 17"
                    ));
                    break;
                }

                $feira->setId($linha[0]);
                $consulta_DB = $feira->ExibeFeiraPorID();

                if ($consulta_DB !== false) {
                    $flag_erro = true;
                    Response(400, array("codigo" => 400,
                        "mensagem" => "O ID " . $linha[0] . " já está sendo utilizado"
                    ));
                    break;
                }
            }
            fclose($linhas);

            if ($flag_erro == false) {
                $linhas = fopen("../arquivos/" . $_FILES['arquivo']['name'], "r");
                $flag = false;
                $cont = 0;
                while (!feof($linhas)) {

                    $linha = fgets($linhas);
                    $linha = explode(',', $linha);
                    $cont++;

                    // Verifica se é a ultima linha e se é vazia, caso sim, pula a linha
                    if (feof($linhas) == true && $linha[0] == "") {
                        break;
                    }

                    if ($cont !== 1) {
                        $feira->setId($linha[0]);
                        $feira->setLong($linha[1]);
                        $feira->setLat($linha[2]);
                        $feira->setSetcens($linha[3]);
                        $feira->setAreap($linha[4]);
                        $feira->setCoddist($linha[5]);
                        $feira->setDistrito($linha[6]);
                        $feira->setCodsubpref($linha[7]);
                        $feira->setSubprefe($linha[8]);
                        $feira->setRegiao5($linha[9]);
                        $feira->setRegiao8($linha[10]);
                        $feira->setNomefeira($linha[11]);
                        $feira->setRegistro($linha[12]);
                        $feira->setLogradouro($linha[13]);
                        $feira->setNumero($linha[14]);
                        $feira->setBairro($linha[15]);
                        if (isset($linha[16])) {
                            $feira->setReferencia(str_replace("\r\n","",$linha[16]));
                        } else {
                            $feira->setReferencia("");
                        }

                        $retorno = $feira->InserirFeira();
                        if ($retorno == false) {
                            $flag = true;
                        }
                    }
                }
                fclose($linhas);

                if ($flag == true) {
                    Response(500, array("codigo" => 500,
                        "mensagem" => "Ocorreu um erro interno"
                    ));
                } else {
                    Response(201, array("codigo" => 201,
                        "mensagem" => "Arquivo processado com sucesso"
                    ));
                }
            }
        } else {
            Response(500, array("codigo" => 500,
                        "mensagem" => "Não foi possível processar o arquivo, tente novamente"
                    ));
        }
    }else{
        $arr_return = array(
                        "codigo"=>999,
                        "mensagem"=>"Request Inválido"
                        );
        Response(400, $arr_return);
    }
}

function Response($code, $arr_response) {
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
?>