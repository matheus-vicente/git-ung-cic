<meta charset="utf-8">

<?php
require_once "../Model/Projetos.php";
require_once "../Model/Tarefas.php";
require_once "../DAO/ProjetosDAO.php";
require_once "../DAO/TarefasDAO.php";
session_start();

$tar = $_GET['cod'];
$tmpTarefa = TarefasDAO::consultarTarefa($tar);

$proj = $_GET['proj'];
$tmpProjeto = ProjetosDAO::consultarProjeto($proj);
$responsavel = $tmpProjeto->getEmailUsuario();

if ($tmpTarefa->getStatus() == 0) {
    $status = "Incompleta";
    $textoBotao = "Finalizar";
} else {
    $status = "Finalizada";
    $textoBotao = "Reabrir";
}
?>
<html>
    <head>

        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    </head>
    <body>

        <div class="container" style="margin-top: 10px;">
            <div class="card">
                <div class="card-header bg-dark text-white">
                    <h4>
                    <?=$tmpProjeto->getNome();?>
                    </h4>
                </div>
                <div class="card-body">

                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h5> <?= $tmpTarefa->getNome(); ?> - <?= ProjetosDAO::corrigirData($tmpTarefa->getData()); ?> </h5>                       
                        </div>
                        <div class="card-body">

                            <?= $tmpTarefa->getDescricao(); ?><br>
                            Status: <b><?= $status; ?></b>
                            
                            <?php
                                if($_SESSION['email']  == $responsavel){
                            ?>
                            <a href="../Control/TarefasControl.php?acao=3&proj=<?=$proj?>&tar=<?=$tar?>&status=<?=$tmpTarefa->getStatus();?>" class="btn btn-danger text-white float-right">
                                <?=$textoBotao;?>
                            </a>
                            <?php 
                                }
                            ?>
                            
                        </div>                               
                    </div>
                    <div class="row">
                        <div class="col-md-5">
                            <div class="card" style="margin-top:15px;">
                                <div class="card-header bg-success text-white">
                                    Mensagem
                                </div>
                                <div class="card-body">
                                    FORM                            
                                </div>                               
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="card" style="margin-top:15px;">
                                <div class="card-header bg-warning text-white">
                                    Arquivos
                                </div>
                                <div class="card-body">
                                    <div class="row">                                    
                                    <?php
                                    $itens = TarefasDAO::listarArquivos($tar);
                                    
                                    for($i=0;$i<count($itens);$i++){
                                    ?>
                                        <div class="col-md-3 text-center">
                                            
                                            <a href="../../files/<?=$itens[$i]->getNome();?>" target="_blank">
                                                <i class="fa fa-file fa-2x"></i>
                                                <br>
                                                <?=$itens[$i]->getNome();?>
                                            </a>
                                            
                                            <a href="../Control/TarefasControl.php?acao=4&arq=<?=$itens[$i]->getCodigo();?>">
                                                <i class="fa fa-trash fa-sm text-danger"></i>
                                            </a>
                                            
                                        </div>
                                    
                                    <?php
                                    }
                                    ?>
                                    </div><hr>
                                    <form action="EnviaArquivoUI.php" method="POST" enctype="multipart/form-data">
                                        <div class="form-group">
                                            <input type="file" name="HTML_arquivo" class="form-control-sm">
                                        </div>
                                        <div class="form-group">
                                            <input type="hidden" name="proj" value="<?=$proj?>">
                                            <input type="hidden" name="cod" value="<?=$tar?>">
                                            <button type="submit" class="btn btn-dark float-right">
                                                Enviar
                                            </button>
                                        </div>
                                            
                                    </form>
                                </div>                               
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </body>

</html>
