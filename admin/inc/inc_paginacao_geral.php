<?

$passo=2; //___número de páginas que aparecem na navegação
$pg_ini=1+$passo*(ceil($pg/$passo)-1);
$pg_fim=min($pg_ini+$passo-1, $num_pg);
$pg_ant=$pg_ini-1;
$pg_seg=$pg_fim+1;

if($num_pg>1)
	{
	?>
    <div class="paginacao_geral">
	páginas: &nbsp;
	<?
	if($pg>$passo)
		{
		?>
		<a href="<?=$_SERVER['PHP_SELF']?>?pg=<?=$pg_ant?><?=$variaveis_paginacao?>">
		<img src="<?php echo DIR_CMS_HTM_ROOT; ?>imagens/setas_paginacao_esq.gif" alt="" border="0" align="absbottom" hspace="10" /></a>
		<?
		}

    for($n=$pg_ini;$n<=$pg_fim;$n++)
		{
		$n_show=$n;
		if($n_show==$pg)
			{
			echo $n_show;
			}
		else
			{
			?>
			<a href="<?=$_SERVER["PHP_SELF"]?>?pg=<?=$n_show?><?=$variaveis_paginacao?>"><?=$n_show?></a>
			<?php
			}
		
		if($pg_fim!=$n_show)
			{
			echo "&nbsp;|&nbsp;";
			}
		}	 

    if($pg_fim<$num_pg)
		{
		?>
		<a href="<?=$_SERVER['PHP_SELF']?>?pg=<?=$pg_seg?><?=$variaveis_paginacao?>">
		<img src="<?php echo DIR_CMS_HTM_ROOT; ?>imagens/setas_paginacao_dir.gif" alt="" border="0" align="absbottom" hspace="10" /></a>
		</a>
		<?
		}
	?>
    </div>
    <?
	}
?>