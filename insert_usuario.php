<?php
//incluir o arquivo de conexão

include 'conexao.php';


//recebendo dados de usuario


$nm_usuario =$_POST['nome'];
$dt_nascimento =$_POST['data'];
$login = $_POST['login'];
$senha = $_POST['senha'];
$setor = $_POST['setor'];

print [$_POST];
//funcao para inserir os dados do usuario


$insert  = "INSERT INTO tb_usuario Values(NULL, '$nm_usuario','$dt_nascimento','$login', '$senha','$setor')";

$query = $conexao->query($insert);

if($query == true){
echo "<script>alert('Usuario Cadastrado com sucesso'); history.back()</script>";


}else{

    echo "<script> alert('Erro ao Cadastrar'); history.Back</script>";
}




?>