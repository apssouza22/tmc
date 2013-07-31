<?php
class Utils
{
	
	const REGEX_URL_LIMPA = '/[^A-Za-z0-9_|\\-]/'; // para retornar uma URL limpa


	public static function encurtar_url($url){
		$url = trim($url);
		$url = urlencode($url);
		$cURL = curl_init('http://migre.me/api.txt?url='.$url);
		curl_setopt($cURL, CURLOPT_RETURNTRANSFER, true);
		$resultado = curl_exec($cURL);
		curl_close($cURL);
		return $resultado;
	}
	
	function getDiasemana($data) {
		$ano =  substr("$data", 0, 4);
		$mes =  substr("$data", 5, -3);
		$dia =  substr("$data", 8, 9);

		$diasemana = date("w", mktime(0,0,0,$mes,$dia,$ano) );

		switch($diasemana) {
			case"0": $diasemana = "Domingo";       break;
			case"1": $diasemana = "Segunda-Feira"; break;
			case"2": $diasemana = "Terça-Feira";   break;
			case"3": $diasemana = "Quarta-Feira";  break;
			case"4": $diasemana = "Quinta-Feira";  break;
			case"5": $diasemana = "Sexta-Feira";   break;
			case"6": $diasemana = "Sábado";        break;
		}

		return $diasemana;
	}
	
	function pegarImagem($strCaminhoFull, $strPathSalvar, $strNomeImagemSalvar)
	{
		if (!file_exists($strPathSalvar.$strNomeImagemSalvar))
		{
			$ctx = stream_context_create(array('http' => array('timeout' => 60))); 
			$strImagem = file_get_contents($strCaminhoFull, 0, $ctx); 
			$hndSalvar = fopen($strPathSalvar.$strNomeImagemSalvar,"w");
			fwrite($hndSalvar,$strImagem);
			fclose($hndSalvar);
			return $strPathSalvar.$strNomeImagemSalvar;
		}else{
			return $strPathSalvar.$strNomeImagemSalvar;
		}
	}
	
	public static function parse_br_to_list($texto)
	{
		$texto=nl2br($texto);
		$retorno = '<ul>';
		
		$vetor_texto = explode('<br />',$texto);
		foreach($vetor_texto as $item)
		{
			$retorno.= '<li><span>' . $item . '</span></li>';
		}
		
		$retorno.= '</ul>';
		return $retorno;
	}
	
	
	/**
	 * Retorna apenas o primeiro nome
	 * @param string $nome Nome completo
	 */
	public static function primeiro_nome($nome)
	{
	$vetor_nome=explode(" ", $nome);
	return $vetor_nome[0];
	}
	
	
	public static function formata_num_kb($numero, $casas=0)
	{
		$numero_fmt = $numero>=1024 ? self::formata_num($numero/1024, $casas) . 'MB' : self::formata_num($numero, $casas) . 'KB';
		return $numero_fmt;
	}
	
	public static function formata_num($num, $casas=2) 
	{
		$num_fmt = number_format(round($num, $casas), $casas, ",", ".");
		return $num_fmt;
	}	
	
	
	public static function decimal_br_en($numero)
	{
		return (float) str_replace(",", ".", $numero); 
	}
	
	
	/**
	 * Retorna o nome da página atual, inclusive com as variáveis
	 * Enter description here ...
	 */
	public static function pagina_atual() 
	{
		$pageURL = 'http';
		if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
		$pageURL .= "://";
		if ($_SERVER["SERVER_PORT"] != "80") 
		{
			$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
		} 
		else 
		{
			$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
		}
		return $pageURL;
	}

	public static function enviaEmail($emailRem,$emailDest,$assunto,$msg){
		/* Verifica qual é o sistema operacional do servidor para ajustar o cabeçalho de forma correta. Não alterar */
		if(PATH_SEPARATOR == ";") 
			$quebra_linha = "\r\n"; //Se for Windows
		else 
			$quebra_linha = "\n"; //Se "não for Windows"
			
			
		//HEADER		
		$headers = "MIME-Version: 1.1" .$quebra_linha;
		$headers .= "Content-type: text/html; charset=iso-8859-1" .$quebra_linha;
		$headers .= "From: " . $emailRem . $quebra_linha;
		
		if(!mail($emailDest, $assunto, $msg, $headers ,"-r".$emailDest)) // Se for Postfix
		{
	    	$headers .= "Return-Path: " . $emailRem . $quebra_linha; // Se "não for Postfix"
	    	if(mail($emailDest, $assunto, $msg, $headers ))
	    	{
	    		return true;
	    	}else
	    	{
	    		return false;
	    	}
		}
		else
		{
			return true;
		}
		
	}
	

	/**
	 * Retorna a extensão de um arquivo 
	 * @param string $nome_arquivo
	 */
	public static function extensao($nome_arquivo)
	{
		$vetor = explode('.', $nome_arquivo);
		return strtolower($vetor[sizeof($vetor)-1]);
	}

	
	/**
	 * volta a mostrar os elementos HTML que foram 'escapados' para gravar no banco 
	 * @param string $texto_html
	 */
	public static function suja_post_var($texto_html)  
	{
		$trans_tbl = get_html_translation_table (HTML_ENTITIES);
		$trans_tbl = array_flip ($trans_tbl);
		$ret = strtr ($texto_html, $trans_tbl);
		return preg_replace('/&#(\d+);/me', "chr('\\1')",$ret);
	} 
	

	/**
	 * Formata um timestamp no formato americano (somente data)
	 * @param string $quando
	 */
	public static function get_quando_en_fmt($quando)
	{
		return date("Y-m-d", strtotime($quando));
	}
	
	/**
	 * Formata um timestamp no formato brasileiro (somente data)
	 * @param string $quando
	 */
	public static function get_quando_br_fmt($quando)
	{
		return date("d/m/Y", strtotime($quando));
	}

	/**
	 * Retorna a hora e minuto
	 * @param string $quando
	 */
	public static function get_hora($quando)
	{
		return date("H:i", strtotime($quando));
	}
	
	
	/**
	 * Retorna a data preparada para ser enviada ao MySQL no formato DATE ou DATETIME (se fornecida a hora) 
	 * @param string $quando data no formato mm/dd/yyyy
	 */
	public static function str_quando_to_mysql($quando)
	{
		$vetor = explode('/', $quando);
		$dia = floor($vetor[0]);
		$mes = floor($vetor[1]);
		$ano = floor(substr($vetor[2], 0, 4));
		
		if(strlen($vetor[2])>4)
		{
			$hora = floor(substr($vetor[2], 5, 2));
			$minuto = floor(substr($vetor[2], 8, 2));
			$segundo = floor(substr($vetor[2], 11, 2));
		}
		else
		{
			$hora = 0;
			$minuto = 0;
			$segundo = 0;
		}
		
		if(!checkdate($mes, $dia, $ano))
		{
			return false;
		}
		else
		{
			return date("Y-m-d H:i:s", mktime($hora, $minuto, $segundo, $mes, $dia, $ano));
		}
	}
	
	
	
	
	
	/**
	 * corta uma string se ela tem mais caracteres que $tamanho 
	 * @param string $string string a ser cortada
	 * @param int $tamanho limite de caracteres da string
	 * @param string $string_add é a string que pode ser adicionada a STRING, caso ela seja maior que TAMANHO (ex.: 3 pontinhos)
	 * @param bool $cortar_palavra define se a palavra será cortada no meio (default: false)
	 */
	public static function corta_string($string, $tamanho, $string_add="", $cortar_palavra=false) 
	{
		if(strlen($string)>$tamanho) 
		{
			$pos_ultimo_espaco = $cortar_palavra ? $tamanho : self::strposReverse($string, " ", $tamanho);
			$string= $pos_ultimo_espaco===false ? substr($string, 0, $tamanho) . $string_add : substr($string, 0, $pos_ultimo_espaco) . $string_add;
		}
		$string=trim($string);
		return $string;
	}

	
	
	/**
	 * Acha a posição da última ocorrência do caractere procurado
	 * Enter description here ...
	 * @param string $str texto original
	 * @param string $search texto procurado
	 * @param $pos última posição (tamanho da string)
	 */
	public static function strposReverse( $str, $search, $pos )
	{
		$str = strrev($str);
		$search = strrev($search);
		$pos = (strlen($str) - 1) - $pos;
	   
		$posRev = strpos( $str, $search, $pos );
		return (strlen($str) - 1) - $posRev - (strlen($search) - 1);
	} 	
	
	
	/**
	 * Remove os acentos de uma string
	 * @param string $string 
	 */
	public static function remove_acentos($string) 
	{ 
		return strtr($string, "ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝßàáâãäåæçèéêëìíîïðñòóôõöøùúûüýÿ", "AAAAAAACEEEEIIIIDNOOOOOOUUUUYsaaaaaaaceeeeiiiionoooooouuuuyy"); 
	}
	
	
	/**
	 * Cria uma string que possa ser usada como URL
	 * @param string $string
	 */
	public static function cria_url_amigavel($string)
	{
		return preg_replace(self::REGEX_URL_LIMPA,'',self::remove_acentos(strtolower(str_replace(' ', '_', trim($string)))));
	} 
	
	
	/**
	 * Lista os estados brasileiros e retorna o HTML do drop down
	 * @param string $id_estado_sel sigla do estado, caso queira que ele esteja selecionado
	 * @param string $id_campo atributo "id" da tag do campo <select> retornado
	 * @param string $metodo_onchange código Javascript para o atributo 'onchange' do campo <select> retornado 
	 */
	public static function lista_estados($id_estado_sel=null, $metodo_onchange=null, $id_campo='id_estado', $firstLabel = '')
	{
		ob_start();
		$string_onchange = $metodo_onchange ? ' onchange="' . $metodo_onchange . '" ' : ''; 
		?>
		<select name="<?=$id_campo?>" id="<?=$id_campo?>" <?=$string_onchange?>>
        	<option value=""><?=$firstLabel?></option>
			<?
            $repEstados = new TRepository('BrasilEstado');
            $criterioEstados = new TCriteria();
            $criterioEstados->setProperty('order','id');
            $estados = $repEstados->load($criterioEstados);
            foreach($estados as $estado_loop)
            {
                $seleciona = $id_estado_sel && $estado_loop->id==$id_estado_sel ? ' selected' : '';
                ?>
                <option value="<?=$estado_loop->id?>"<?=$seleciona?>><?=$estado_loop->id?></option>
                <?
            }
            ?>
        </select>
		<?
		$result = ob_get_contents();
		ob_clean();
		
		return $result;
	}
	
	
	/**
	 * Lista as cidades do estado solicitado e retorna o HTML do drop down
	 * @param string $id_estado sigla do estado
	 * @param int $id_cidade_sel ID da cidade no banco, caso queira que volte selecionada, em vez da capital do estado
	 * @param string $id_campo atributo "id" da tag do campo <select> retornado
	 */
	public static function lista_cidades($id_estado, $id_cidade_sel=null, $id_campo='id_cidade')
	{
		$repCidades = new TRepository('BrasilCidade');
		$criterio = new TCriteria();
		$criterio->add(new TFilter('id_estado', '=', "'" . $id_estado . "'"));
		$criterio->setProperty('order', 'nome');
		$cidades = $repCidades->load($criterio);
		
		ob_start();
		?>
		<select id="<?=$id_campo?>" name="<?=$id_campo?>">
			<? 
			foreach ($cidades as $cidade)
			{
				if($id_cidade_sel)
				{
					$seleciona = $id_cidade_sel==$cidade->id ? ' selected' : '';
				}
				else
				{
					$seleciona = $cidade->bool_capital==1 ? ' selected' : '';
				}
				?>
		        <option value="<?=$cidade->id?>"<?=$seleciona?>><?=$cidade->nome?></option>
		        <?
			} 
		    ?>
	    </select>
		<?
		$result = ob_get_contents();
		ob_clean();
		
		return $result;
	}

	
	/**
	 * Retorna um vetor de strings com os resultados da busca
	 */
	/**
	 * Retorna um vetor de strings com os resultados da busca
	 * @param array $vetor_classes
	 * @param string $palavra string a ser procurada
	 * @param int $pg paginação (página atual)
	 * @param bool $visiveis listar somente os registros com $bool_visivel=1
	 * @param bool $apenas_contar sinaliza que a consulta é apenas para contar o número de registros 
	 */
	public static function busca($vetor_classes, $palavra, $pg=1, $reg_por_pg=null, $visiveis=true, $apenas_contar=false)
	{
		$palavra = str_replace("'", "", $palavra);
		if(trim($palavra=='') || !$vetor_classes)
		{
			return null;
		}
		else
		{
			$retorno['qtd'] = 0;
			foreach($vetor_classes as $classe)
			{
				$objeto = new $classe(); // objeto deve ser filho de TRepository
				$vetor_campos = $objeto->get_busca_vetor_campos(); 							// vetor com os nomes dos campos em que será feita a pesquisa
				$rotulo_classe = constant("$classe::ROTULO"); 								// nome amigável da classe 
				$busca_campo_foto = constant("$classe::BUSCA_CAMPO_FOTO"); 					// nome do campo que retornará a imagem
				$busca_prefixo_foto = constant("$classe::BUSCA_PREFIXO_FOTO"); 				// prefixo para o thumb da imagem
				$busca_titulo = constant("$classe::BUSCA_TITULO"); 							// nome do campo que retornará o título (chamada)
				$busca_quando = constant("$classe::BUSCA_QUANDO"); 							// nome do campo que contém a data (definir NULL para item sem data)
				$busca_texto = constant("$classe::BUSCA_TEXTO"); 							// nome do campo que retornará o texto (chamada)
				$busca_destino = constant("$classe::BUSCA_DESTINO"); 						// caminho para o item, a partir da raíz do site
				$busca_destino_cms = constant("$classe::BUSCA_DESTINO_CMS");				// caminho para o item, a partir da raíz do CMS
				$busca_propriedade_id = constant("$classe::BUSCA_PROPRIEDADE_ID"); 			// nome da propriedade que identifica o destino (concatenar ao $_destino)
				$busca_propriedade_id_cms = constant("$classe::BUSCA_PROPRIEDADE_ID_CMS"); 	// nome da propriedade que identifica o destino (concatenar ao $_destino)
				$busca_max_itens = constant("$classe::BUSCA_MAX_ITENS");					// quantidade máxima de itens deste tipo que devem ser retornados (definir NULL para ilimitados)
				$busca_ordem = constant("$classe::BUSCA_ORDEM");							// ordem SQL em que os resultados devem ser exibidos
				
				
				// preparando a consulta
				$where_exibir = $visiveis ? ' WHERE bool_exibir=1 ' : ' WHERE 1 ';

				$localiza = ' AND (';
				foreach($vetor_campos as $campo)
				{
					$localiza.= 'LOWER(' . $campo . ') REGEXP \'[[:<:]]' . strtolower($palavra) . '[[:>:]]\'=1 OR '; // --> procura por palavras inteiras
					$localiza.= 'LOWER(' . $campo . ') REGEXP \'[[:<:]]' . self::remove_acentos(strtolower($palavra)) . '[[:>:]]\'=1 OR '; // --> procura por palavras inteiras
					$localiza.= 'LOWER(' . $campo . ') REGEXP \'[[:<:]]' . htmlentities(htmlentities($palavra)) . '[[:>:]]\'=1 OR '; // --> procura por palavras inteiras
				}
				$localiza = substr($localiza, 0, -3) . ') ';
					
		
				
				
				if($apenas_contar)
				{
					$sql = 'SELECT COUNT(*) AS quantidade FROM ' . constant($classe . '::TABLENAME') . $where_exibir . $localiza;
				}
				else
				{
					$sql = 'SELECT * FROM ' . constant($classe . '::TABLENAME') . $where_exibir . $localiza;
				}
				
				$sql.=' ORDER BY ' . $busca_ordem;
				
				if($busca_max_itens!=null)
				{
					$sql.=' LIMIT ' . $busca_max_itens;
				}
				//echo $sql;
				
				
				// executa o SQL
				$conn = TConnection::open();
				//$resultado = $conn->query($sql);

				try {
					$resultado = $conn->query($sql);
				} catch (PDOException $e) {
					trigger_error(str_replace('#', '', $e->getTraceAsString()) . ' SQL: '.$sql, E_USER_ERROR);
				}

				$conn = null;
				
				if($apenas_contar)
				{
					$row = $resultado->fetch();
					$retorno['qtd'] += $row[0];
					//echo '+' . $row[0] . '<br>';
				}
				else
				{
					if($resultado)
					{
						while ($item = $resultado->fetchObject($classe))
						{
							//var_dump($item);
							if($item->bool_exibir==1 || (!$visiveis && $item->bool_exibir==0))
							{
								$vetor_item['classe'] = $classe;
								$vetor_item['rotulo_classe'] = $rotulo_classe;
								$vetor_item['id'] = $item->id;
								$vetor_item['titulo'] = $item->$busca_titulo;
								$vetor_item['quando'] = $busca_quando==null ? '' : Utils::get_quando_br_fmt($item->$busca_quando);
								$vetor_item['quando_en'] = $busca_quando==null ? '' : Utils::get_quando_en_fmt($item->$busca_quando);
								$vetor_item['texto'] = Utils::formata_texto_busca($item->$busca_texto);
								$vetor_item['destino'] = $busca_destino . $item->$busca_propriedade_id;
								$vetor_item['destino_cms'] = $busca_destino_cms . $item->$busca_propriedade_id_cms;
								$vetor_item['foto'] = $busca_campo_foto && $item->$busca_campo_foto!='' ? $busca_prefixo_foto . $item->$busca_campo_foto : '';
							}
							$retorno['itens'][] = $vetor_item;
						}
					}
					$retorno['qtd'] = sizeof($retorno['itens']);
				}
			}
		
			
			
			
		// fatia o vetor para retornar apenas os itens da página atual
		if($reg_por_pg!=null)
		{
			$pg = max(1,floor($pg));
			//		$pg = 2; $reg_por_pg = 3;
			$offset = ($pg-1)*$reg_por_pg;
			if(sizeof($retorno['itens'])>0)
			{
				$retorno['itens'] = array_slice($retorno['itens'], $offset, $reg_por_pg);
			}
		}
		
		return $retorno;
		}
	}


	/**
	 * Devolve o texto sem HTML e do tamanho correto para ser exibido
	 * @param string $string
	 * @param int $tamanho
	 */
	public static function formata_texto_busca($string, $tamanho=300)
	{
		return self::corta_string(strip_tags(Utils::suja_post_var($string)), $tamanho, '...');
	} 
	
	
	
	
	/**
	 * 
	 * Destaca as ocorrências de uma lista de palavras no texto
	 * @param string $texto string com o texto
	 * @param array $vetor_palavras vetor com as palavras a serem procuradas 
	 * @param string $str_ini tag HTML ou string a ser colocada antes de cada ocorrência da palavra 
	 * @param string $str_fim tag HTML ou string a ser colocada depois de cada ocorrência palavra
	 */
	public static function destaca_ocorrencia($texto, $vetor_palavras, $str_ini='<em>', $str_fim='</em>')
	{
		foreach($vetor_palavras as $cada_palavra)
		{
			$texto = preg_replace("/\b" . $cada_palavra . "\b/i", $str_ini . $cada_palavra .  $str_fim, $texto);
		}
	
		return $texto;
	}
	
	
	public static function unhtmlentities ($string)
	{
	$trans_tbl = get_html_translation_table (HTML_ENTITIES);
	$trans_tbl = array_flip ($trans_tbl);
	$ret = strtr ($string, $trans_tbl);
	return preg_replace('/&#(\d+);/me', "chr('\\1')",$ret);
	} 
	

	/**
	 * Obtém uma fatia de um vetor, para ajudar na paginação
	 * @param array $vetor Vetor que precisa ser fatiado
	 * @param int $reg_por_pag Registros por fatia (página)
	 * @param int $pagina Fatia (página) desejada
	 */
	public static function get_fatia_vetor($vetor, $reg_por_pag, $pagina=null)
	{
		$qtd_registros = sizeof($vetor);
		$qtd_paginas = ceil($qtd_registros/$reg_por_pag);
		$pagina = $pagina==null ? 1 : min(max(floor($pagina),1),$qtd_paginas);
		$offset = max(0,($pagina-1)*$reg_por_pag);
		
		return array_slice($vetor, $offset, $reg_por_pag);
	}
	
	
	
	/**
	 * 
	 * pega src embed de uma url  do youtube, pega tudo a partir do 'v'
	 * @param $url
	 */
	public function get_src_embed($url)
	{

		if(strpos($url, 'v=') >0){
			$pos_str_ini = strpos($url, 'v=');
			$str_src = substr($url, ($pos_str_ini+2));
		}elseif(strpos($url, 'v/') >0){
			$pos_str_ini = strpos($url, 'v/');
			$str_src = substr($url, ($pos_str_ini+2));
		}else{
			$arrUrl = explode('/',$url);
			$str_src = end($arrUrl);
		}
		
		return $str_src;
	}
	
	public static function getOnlyIdYoutube($url){
		preg_match("#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+|(?<=v=)[^&\n]+|(?<=youtu.be/)[^&\n]+#", $url, $matches);
		return $matches[0];
	}


	/**
	 * 
	 * pega a a identificacao do video do vimeo
	 * @param $url
	 */
	public function get_src_embed_vimeo($url)
	{
		// separando apenas o src
		$str_ini = '.com/';
		$pos_str_ini = strpos($url, $str_ini);
		$str_src = substr($url, ($pos_str_ini+5));
		
		return $str_src;
	}
	
	/*
	 * remove as quebra de linhas do texto
	 * @param String $text
	 */
	public static function remove_quebra($text)
	{
		$text = str_replace("\r\n", "<br>", $text);
		$text = str_replace("\n", "<br>", $text);
		return str_replace("\r", "<br>", $text);
	}
	
	public static function formata_texto_busca_json($text)
	{
		$text = self::formata_texto_busca($text);
		$text = str_replace("\"","\\\"",$text);
		$text = str_replace("'","\'",$text);
		$text = self::remove_quebra($text);
		return $text;
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
	


	/**
	 * Exclui a pasta indicada e todos os seus arquivos
	 * @param string $pasta caminho físico da pasta
	 */
	public static function apaga_pasta($pasta)
	{
	if(is_dir($pasta))
		{
		if($handle=opendir($pasta)) 
			{
			while(false!==($file=readdir($handle))) $vetor_itens[]=$file;
			closedir($handle);
			}

		foreach($vetor_itens as $item) 
			{
			if($item!='.' && $item!='..') 
				{
				self::apaga_pasta($pasta . '/' . $item);
				}
			}

		return rmdir($pasta);
		}
	else 
		{
		return unlink($pasta);
		}
	}
	

	
	public static function limpa_posts()
	{
		foreach($_POST as $chave_variavel_atual=>$valor_variavel_atual)
		{
			global $$chave_variavel_atual;
			
			if(!is_array($_POST[$chave_variavel_atual]))
			{
			$$chave_variavel_atual=htmlspecialchars($_POST[$chave_variavel_atual], ENT_QUOTES);
			}
		}
	 
		foreach($_GET as $chave_variavel_atual=>$valor_variavel_atual)
		{
			global $$chave_variavel_atual;
			
			if(!is_array($_POST[$chave_variavel_atual]))
			{
				$$chave_variavel_atual=htmlspecialchars($_GET[$chave_variavel_atual], ENT_QUOTES);
			}
		}
		
		foreach($_REQUEST as $chave_variavel_atual=>$valor_variavel_atual)
		{
			global $$chave_variavel_atual;
			
			if(!is_array($_REQUEST[$chave_variavel_atual]))
			{
				$$chave_variavel_atual=htmlspecialchars($_REQUEST[$chave_variavel_atual], ENT_QUOTES);
			}
		}
	}
	

	
	/**
	 * Escreve o box de erro ou sucesso na tela
	 */
	public static function escreve_alerta()
	{
		global $erro;
		//global $sucesso;
		
		if($erro)
		{
			//$mensagem = $erro ? $erro : $sucesso;
			echo '<div class="ui-widget" style="margin-top: 20px;"><div class="ui-state-error ui-corner-all" style="padding: 0 .7em;"><p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>';
			echo $erro;
			echo '</p></div></div>';
		}
	}	

	
	
	/**
	 * Devolve o resultado de uma requisição SQL
	 * @param string $sql comando SQL
	 */
	public static function resultado($sql)
	{
		$conn = TConnection::open();
		$resultado = $conn->query($sql);
		$conn = null;
		
		return $resultado;
	}
	
	
	
	/**
	 * Retorna o resultado de uma consulta simples de SQL (um campo ou COUNT)
	 * @param string $sql Comando SQL
	 * @param bool $debug [false] Define se o comando será escrito ou não 
	 */
	public static function get_campo_sql($sql, $debug=false)
	{
		if($debug)
		{
			echo $sql . '<br />';
		}
		
		$conn = TConnection::open();
		$result = $conn->query($sql);
		$row = $result->fetch();
		$conn = null;
		return $row[0];
	}
	

	
	/**
	 * 
	 * recebe o argumento do número do mês e retorna a string do seu nome
	 * @param int $numero Inteiro que representa o mês
	 */
	public static function nome_mes($numero) 
	{
		switch($numero)
		{
			case 1: $mes="janeiro"; break;
			case 2: $mes="fevereiro"; break;
			case 3: $mes="março"; break;
			case 4: $mes="abril"; break;
			case 5: $mes="maio"; break;
			case 6: $mes="junho"; break;
			case 7: $mes="julho"; break;
			case 8: $mes="agosto"; break;
			case 9: $mes="setembro"; break;
			case 10: $mes="outubro"; break;
			case 11: $mes="novembro"; break;
			case 12: $mes="dezembro"; break;
		}
		return $mes;
	}
	

	/**
	 * Retorna o nome do dia da semana, de acordo com o inteiro passado como argumento
	 * @param int $dia inteiro que representa do dia da semana (0: domingo)
	 */
	public static function nome_dia_semana($dia)
	{
		$vetor_semana = array(
		'domingo', 
		'segunda-feira', 
		'terça-feira', 
		'quarta-feira', 
		'quinta-feira', 
		'sexta-feira', 
		'sábado',
		'domingo');
		
		return $vetor_semana[$dia];
	}

	
	
	/**
	 * Retorna a lista de dias da semana
	 */
	public static function get_semana()
	{
		$vetor_semana = array(
		'domingo', 
		'segunda-feira', 
		'terça-feira', 
		'quarta-feira', 
		'quinta-feira', 
		'sexta-feira', 
		'sábado');
		
		return $vetor_semana;
	}

	
	
	

    public static function in_multiarray($elem, $array)
    {
        $top = sizeof($array) - 1;
        $bottom = 0;
        while($bottom <= $top)
        {
            if($array[$bottom] == $elem)
                return true;
            else
                if(is_array($array[$bottom]))
                    if(self::in_multiarray($elem, ($array[$bottom])))
                        return true;
                   
            $bottom++;
        }       
        return false;
    }




	/**
	 * Completa a string com zeros à esquerda 
	 * @param string $num número
	 * @param int $algarismos número de algarismos desejado para a string final
	 */
	public static function completa_zeros($num, $algarismos)
	{
		$string_formatada=$num;
		for($teto=10; $num>$teto, strlen($string_formatada)<$algarismos; $teto=$teto*10)
		{
			$string_formatada="0" . $string_formatada;
		}
		return $string_formatada;
	}
    


	/**
	 * Gera um código alfa-numérico com o algoritmo md5 
	 * @param int $num Número de caracteres do código (máximo: 32)
	 */
	public static function gera_codigo($num)
	{
		return substr(md5(rand()), 0, min($num, 32));
	}

        /**
	 * Gera um combo html select
	 * @param array $array um array tridimensional posicao/chave/valor
	 * @param string $cmpValue string com o nome da chave que vai no value
	 * @param string $txtExibir string com o nome da chave que vai ser ficar visível
	 * @param string $valorSelecionado string com o valor selecionado
	 * @param string $nome string com o name do select
	 * @param string $opcionais string com o valores que queira adicionar ao combo ex classe
	 */
        public static function criar_select($array,$cmpValue,$txtExibir,$valorSelecionado,$nome,$opcionais=''){
            
            $select = "<select name='$nome' $opcionais >";

            foreach ($array as $value) {
                $selecionado = $value[$cmpValue] == $valorSelecionado ? "selected='selected'" : "";
                $select .= "<option value='$value[$cmpValue]' $selecionado >$value[$txtExibir]</option>";
            }

            $select .="</select>";

            
            return $select;
        }



	public static function teste()
	{
		$arquivo = DIR_ROOT . 'email_templates/teste.htm';
		$conteudo = file_get_contents($arquivo);
		//$regex = '/#(a-zA-Z_0-9)+#/';
		$regex = '/(#([[:alnum:]]|_)+#)/';
		$conteudo = preg_replace($regex, '---', $conteudo);
		echo $conteudo;
	}


	public static function formata_cpf($cpf)
	{
		$cpf_numeros = Utils::completa_zeros(substr($cpf, 0, -2), 9);
		$cpf_numeros=substr($cpf_numeros, 0,3) . "." . substr($cpf_numeros, 3,3) . "." . substr($cpf_numeros, 6,3);
		$cpf_digitos=substr($cpf, -2);
		 
		return $cpf_numeros . "-" . $cpf_digitos;
	}

	public static function formata_cnpj($cnpj)
	{
		$cnpj_bloco1=substr($cnpj, 0, 2);
		$cnpj_bloco2=substr($cnpj, 2, 3);
		$cnpj_bloco3=substr($cnpj, 5, 3);
		$cnpj_bloco4=substr($cnpj, 8, 4);
		$cnpj_bloco5=substr($cnpj, 12, 2);
		
		return $cnpj_bloco1 . "." . $cnpj_bloco2 . "." . $cnpj_bloco3 . "/" . $cnpj_bloco4 . "-" . $cnpj_bloco5;
	}


	
	
	
	/**
	 * Envia uma string que represente a requisição SQL no formato do CSV para salvar o arquivo
	 * @param string $query Requisição SQL
	 * @param boolean $bool_campos Define se inclui os nomes dos campos no retorno
	 */
	public static function imprime_sql_csv($query, $bool_campos=true)
	{
		Utils::conecta();
		$res=mysql_query($query);
		if(mysql_errno==1146) 
		{
			$str = 'Tabela inexistente';
		}
		elseif(mysql_num_rows($res)==0)
		{
			echo '<pre>';
			var_dump($res);
			echo '</pre>';
			die();
			$str = 'Tabela vazia: ' . $query;
		}
		else
		{
			// imprime os campos
			if($bool_campos)
			{
				$tam = mysql_num_fields($res);
				for($i=0; $i<$tam; $i++) 
				{
					$str.= mysql_field_name($res, $i);
					if( ($i+1) < $tam )
					{
						$str.= ';';
					}
				}	
				$str.= "\r\n";
			}
			
			// imprime os registros
			while($row_dados=mysql_fetch_array($res))
			{
				for($i=0; $i<mysql_num_fields($res); $i++)
				{
					$str.= $row_dados[$i];
					if( ($i+1) < (mysql_num_fields($res)) )
					{
						$str.= ';';
					}
				}
				$str.= "\r\n";
			}
		}
		return $str;
	}
	

	
	/**
	 * Função estática conecta
	 * Abre uma conexão ao banco de dados no modo tradicional
	 * Se não passar nenhum nome de arquivo no parâmetro $arquivo_db, conecta ao banco padrão da aplicação
	 * @param $arquivo_db
	 */
	public static function conecta($arquivo_db='')
	{
		// verifica se existe o arquivo "config.ini" para buscar as configurações do banco
		// TODO: classe config que centraliza a busca dessas informações
		$dir_config = CONFIG;
		
		
		if($arquivo_db=='')
		{
			// Se não passou nenhum nome de arquivo, conecta ao banco padrão da aplicação
			$arquivo_config = 'config.ini';
			
			if(!file_exists($dir_config . $arquivo_config))
			{
				throw new Exception("Arquivo {$dir_config}{$arquivo_config} não encontrado.");
			}
			else
			{ 
				$config = parse_ini_file($dir_config . $arquivo_config);
				//var_dump($config);
				$arquivo_db = $config['db'];
			} 
		}
		//echo 'arquivo_db: ' . $arquivo_db . '<br /><br />';
		//echo ($dir_config . $arquivo_db);
		
		if(!file_exists($dir_config . $arquivo_db)) 
		{
			throw new Exception("Arquivo {$arquivo_db} não encontrado.");
		}
		else
		{
			$config_db = parse_ini_file($dir_config . $arquivo_db); 
			//var_dump($config_db);
		}
		
		// recupera as variáveis
		$db_tipo 	= $config_db['tipo']; 
		$db_host 	= $config_db['host'];
		$db_nome 	= $config_db['nome'];
		$db_usuario = $config_db['usuario'];
		$db_senha 	= $config_db['senha'];
		$db_porta 	= $config_db['porta'];
		

		$conectar = mysql_connect($db_host, $db_usuario, $db_senha)
		  	or die ("Não foi possível conectar ao servidor.");
		
		$banco = mysql_select_db($db_nome, $conectar)
			or die ("Não foi possível conectar ao banco de dados.");
	}

	public static function get_vetor_meses()
	{
		return array("Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro");
	}

	
	/**
	 * Imprime na tela o var_dump da variável solicitada
	 * @param mixed $objeto Objeto ou variável
	 */
	public static function dumpa($objeto)
	{
		echo '<pre>'; 
		var_dump($objeto);
		echo '</pre>';
	}


	/**
	 * Calcula a distância entre dois pontos na Terra
	 * @param float $lat1 Latitude do ponto 1
	 * @param float $lng1 Longitude do ponto 1
	 * @param float $lat2 Latitude do ponto 2
	 * @param float $lng2 Longitude do ponto 2
	 * @param bool $miles Unidade padrão: km (Set true para distância em milhas)
	 */
    public static function get_distancia($lat1, $lng1, $lat2, $lng2, $miles = false)
    {
	    $pi80 = M_PI / 180;
	    $lat1 *= $pi80;
	    $lng1 *= $pi80;
	    $lat2 *= $pi80;
	    $lng2 *= $pi80;
	     
	    $r = 6372.797; // mean radius of Earth in km
	    $dlat = $lat2 - $lat1;
	    $dlng = $lng2 - $lng1;
	    $a = sin($dlat / 2) * sin($dlat / 2) + cos($lat1) * cos($lat2) * sin($dlng / 2) * sin($dlng / 2);
	    $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
	    $km = $r * $c;
	     
	    return ($miles ? ($km * 0.621371192) : $km);
    }

}

