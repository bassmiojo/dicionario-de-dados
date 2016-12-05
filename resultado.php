<?php
include_once ("header.php");

require_once("vendor/autoload.php");
$model = new App\Dicionario();
$resultado = $model->setDataBase($_POST["DataBase"])
    ->setHost($_POST["host"])
    ->setDbName($_POST["db_name"])
    ->setUser($_POST["user"])
    ->setPassword($_POST["password"])
    ->init();


foreach ($model->getDataDicionary() as $a => $b): ?>

    <table border="1">
        <tr align="center">
            <td colspan="5" class="titulo_tabela fundo_gray"> tabela <?php echo($b["title"]); ?></td>

        </tr>
        <tr class="campos_cabecalho">
            <td width="30" align="center" class="fundo_gray"> Nº</td>
            <td width="300" align="center"> Campo</td>
            <td width="400" align="center"> Tipo de Dado</td>
            <td width="500" align="center"> Descrição</td>
            <td width="50" align="center"> Observação</td>
        </tr>
        <?php foreach ($b["column"] as $c): ?>
            <tr class="campos_texto">
                <td align="center" class="fundo_gray"> <?php echo $c["indice"]; ?></td>
                <td> <?php echo $c["column_name"]; ?></td>
                <td> <?php echo $c["data_type"]; ?></td>
                <td> <?php ?></td>
                <td>
                    <?php echo $c["is_nullable"]; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
 
<?php endforeach;; ?>
