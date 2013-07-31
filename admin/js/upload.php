<?php

include('../inc/inc_start.php');

// faz o upload de cada arquivo e guarda na tabela 'upload'
// para ser relacionado a um item no site quando for dado o POST do formulário
foreach ($_FILES as $fieldName => $file) 
{
	$temp_name = $file['tmp_name'];
	$nome_original = strip_tags(utf8_decode(basename($file['name'])));
	$nome_arquivo = 'arquivo_' . date('YmdHis') . '.' . Utils::extensao($nome_original); 

	if( move_uploaded_file($temp_name, DIR_ROOT . Upload::DESTINO_ARQUIVO . $nome_arquivo) )
	{
		$upload = new Upload();
		$upload->nome_original = $nome_original;
		$upload->nome_arquivo = $nome_arquivo;
		$upload->quando = date('Y-m-d H:i:s');
		
		$id_upload = $upload->store();
		
		echo $id_upload;
	}
	else
	{
		echo 0;
	}
}




?>