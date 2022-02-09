<html>
    <head>
        <meta charset="UTF-8">
        <title>Projeto API</title>
    </head>
    <body>
    <center>
        <div style="width: 80%; text-align: left">
            <h2>Projeto API</h2>
            <h3>Documentação da API</h3>
            <p style="margin-bottom: 50px"><a href="https://documenter.getpostman.com/view/8395944/UVeKnPZM" target="_blank">Clique aqui para acessar a documentação.</a><p>
            <hr/>
            <h3 style="margin-top: 50px">Inserir dados via Arquivo</h3>
            <form method="POST" enctype="multipart/form-data" action="api/processa_arquivo.php">
                <label for="arquivo">Selecione o arquivo:</label><br>
                <input style="margin-bottom: 5px" type="file" id="arquivo" name="arquivo"  accept=".csv"><br>
                <input type="submit" value="Enviar">
            </form> 
        </div>
    </center>
</body>
</html>
