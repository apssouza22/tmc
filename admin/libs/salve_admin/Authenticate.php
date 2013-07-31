<?php

/**
 * Description of Authenticate
 *
 * @author User
 */
class Authenticate
{
	public function submete_login(){
		$user = ContainerDi::getObject('UsuarioCMS');
		return $user->submete_login();
	}

/**
	 * Encripta a senha para um padrão numérico
	 * @param string $senha Senha desejada
	 * @return string $s Senha encriptada  
	 */
	public static function pwenc($senha)
	{
		if(trim($senha)=="" || !preg_match('/^([a-zA-Z0-9]+)$/', $senha))
		{
			return false;
		}
		else
		{
			for($i=0; $i<strlen($senha); $i++)
			{
				$v[]=48; $v[]=57; $v[]=65; $v[]=90; $v[]=97; $v[]=122;
				$la=ord($senha[$i]);
				$g= $la==($la%($v[1]+1)) ? 1 : 0;
				$g= $g ? $g : floor($la/($v[3]+1))+2;
				  
				$f= floor($g-1) ? $v[$g+$g%2] : $v[floor($g-1)];  
				$o=$la-$f+1;
				  
				$o= $o<10 ? "0".$o : $o;
				$s.= $o . $g;
			}
		return $s;
		}
	}

	/**
	 * Decripta a senha no padrão numérico usado em self::pwenc()
	 * @param int $numero Senha encriptada numericamente
	 * @return string $la Senha decriptada  
	 */
	public static function pwdec($numero)
	{
		for($i=0; $i<strlen($numero)/3; $i++)
		{
			$o=intval(substr($numero, $i*3, 2));
			$g=substr($numero, $i*3+2, 1);
			$v[]=48; $v[]=57; $v[]=65; $v[]=90; $v[]=97; $v[]=122;
			$f= floor($g-1) ? $v[$g+$g%2] : $v[floor($g-1)];
			$n=$f+$o-1;  
			$la.=chr($n);
		}
		return $la;
	}
	
	/**
	 * Retorna o nome da pasta do arquivo atual
	 */
	public static function this_folder_name()
	{
		$path=$_SERVER['PHP_SELF'];
		$current_directory = dirname($path);
		$current_directory = str_replace('\\','/',$current_directory);
		$current_directory = explode('/',$current_directory);
		$current_directory = end($current_directory);
		return $current_directory;
	}
	
	/**
	 * Verifica se o e-mail é válido
	 * @param string $email
	 * @return booleano
	 */
	public static function confere_email($email)
	{
		return (preg_match('/^([a-z0-9_]|\\-|\\.)+@(([a-z0-9_]|\\-)+\\.)+[a-z]{2,4}$/', $email));
	}	
}

