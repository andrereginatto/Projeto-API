<?php

class LogMsg {
    function InsereLog($msg, $nivel = 'INFO'){
        // Nome do Arquivo
        $nome_arquivo = '../logs/'.date('Y-m-d').'.txt';
        
        // Pega o tamanho do arquivo para avaliar se é necessário criar um novo arquivo
        $tamanho_arquivo = filesize($nome_arquivo);
        $tamanho_maximo = 5242880; // 5 MB
        
        if ($tamanho_arquivo >= $tamanho_maximo){
            $cont = 1;
            $novo_nome = '../logs/'.date('Y-m-d_').$cont.'.txt';
            $verifica_existencia = file_exists($novo_nome);

            while ($verifica_existencia == true){
                $cont++;
                $novo_nome = '../logs/'.date('Y-m-d_').$cont.'.txt';
                $verifica_existencia = file_exists($novo_nome);
            }
            rename($nome_arquivo, $novo_nome);
        }
        

        // Le ou cria o arquivo
        $arquivo = fopen($nome_arquivo, "a");

        // Formata mensagem
        $txt = date('Y-m-d H:i:s ') . strtoupper($nivel) . ' ' . json_encode($msg) . "\n";

        // Escreve no arquivo
        fwrite($arquivo, utf8_encode($txt));

        // Fecha o arquivo
        fclose($arquivo);
    }
}
    
?>