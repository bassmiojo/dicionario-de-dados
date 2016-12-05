<?php include_once("header.php"); ?>

<div class="container">
    <h1>Dicionário de Dados</h1>
    <br>
    <form method="post" action="resultado.php">
        <div class="form-group">
            <label for="exampleInputPassword1">Banco de Dados</label>
            <select name="DataBase" class="form-control" required="required" >
                <option value="">Selecione</option>
                <option value="postregres">PostGres</option>
                <option value="mysql">MySql</option>
                <option value="oracle">Oracle</option>
                <option value="sql_server">SqlServer</option>
            </select>
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">HOST</label>
            <input name="host" class="form-control" placeholder="Localhost" required="required">
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">DB NAME</label>
            <input name="db_name" class="form-control" placeholder="Nome do banco" required="required">
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">USER</label>
            <input name="user" class="form-control" placeholder="Usuário" required="required">
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">Password</label>
            <input name="password" class="form-control" id="exampleInputPassword1" placeholder="Password" >
        </div>

        <div class="text-right">
            <button type="submit" class="btn btn-default">Submit</button>
        </div>
    </form>

</div>