<?php 

include('inc/inc_start.php'); 


if(isset($_COOKIE["ultimo_email_login"]))
{
	$login_email = $_COOKIE["ultimo_email_login"];
	$frase_load="onload=\"$('#login_senha').focus();\"";
}
else
{
	$frase_load="onload=\"$('#login_email').focus();\"";
}	

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" http://www.w3.org/TR/xhtml1/DTD/html1-transitional.dtd>
<html>
<head>
	<?php include(DIR_CMS_ROOT . 'inc/inc_header.php'); ?>
</head>
<body <?=$frase_load?>>
<div id="box_login">
	<div id="login_logo">
    </div>
    <div id="login_conteiner">
        <form id="form_login" name="form_login" method="post" action="<?=$PHP_SELF?>" onsubmit="return submete_login()">
        
			<label for="login_email"><span>E-mail</span></label>
			<input id="login_email" name="login_email" value="<?=$login_email?>" class="obr" type="text" maxlength="200" />
        
			<label for="login_senha"><span>Senha</span></label>
			<input id="login_senha" name="login_senha" value="<?=$login_senha?>" class="obr" type="password" maxlength="20" />
        
			<a href="#" id="bt_submete_login" onclick="$('#form_login').submit()" class="bt_padrao ui-state-default ui-corner-all" rel="Enviar"><span class="ui-icon ui-icon-key"></span><strong>Entrar</strong></a>
			
			<input type="hidden" id="enviar" name="enviar" value="1" />
			<input type="submit" class="submit" />
        </form>
	</div>
	<?php
	/*
	<center><a href="#" id="bt_toggle_login" onclick="toggle_login(); return false" rel="efetuar login">esqueci minha senha</a></center>
	*/
	?>
</div>


<div id="dialog_alerta" title="Atenção" style="display:none">
	<p></p>
</div>

<div id="loading" style="display:none;"><img src="<?php echo DIR_CMS_HTM_ROOT; ?>imagens/loading_peq.gif" /></div>

</body>
</html>
