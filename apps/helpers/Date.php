<?php

namespace helpers;

/**
 * Helper de datas
 *
 * @author Alexsandro
 */
class Date
{

	/**
	 * Retorna a data preparada para ser enviada ao MySQL no formato DATE ou DATETIME (se fornecida a hora) 
	 * @param string $quando data no formato mm/dd/yyyy
	 * @return string $quando data no formato yyyy-mm-dd
	 */
	public static function getDateToMysql($quando)
	{
		$vetor = explode('/', $quando);
		$dia = floor($vetor[0]);
		$mes = floor($vetor[1]);
		$ano = floor(substr($vetor[2], 0, 4));

		if (strlen($vetor[2]) > 4) {
			$hora = floor(substr($vetor[2], 5, 2));
			$minuto = floor(substr($vetor[2], 8, 2));
			$segundo = floor(substr($vetor[2], 11, 2));
		} else {
			$hora = 0;
			$minuto = 0;
			$segundo = 0;
		}

		if (!checkdate($mes, $dia, $ano)) {
			return false;
		} else {
			return date("Y-m-d H:i:s", mktime($hora, $minuto, $segundo, $mes, $dia, $ano));
		}
	}

	/**
	 * Retorna a representa��o textual dos dias da semana ou o dia se passado o parametro
	 * @param int $day representa��o numerica do dia da semana
	 * @param boolean $complete acrescenta a -feira junto aos dias
	 * @return string com o dia da semana 
	 */
	public static function getDayWeek($day = null, $complete = false)
	{
		$feira = $complete ? '-feira' : '';
		$days = array('Domingo', 'Segunda' . $feira, 'Ter�a' . $feira, 'Quarta' . $feira, 'Quinta' . $feira, 'Sexta' . $feira, 'S�bado');
		if ($day) {
			return $days[$day];
		}
		return $days;
	}
	
	public static function intervalDiff($date1, $date2 = 'now', $format= null){
		$date1 = new \DateTime($date1);
		$date2 = new \DateTime($date2);
		$diff = $date1->diff($date2);
		if(!$format){
			$diff->y ? $format[]= '%y anos '	: '';
			$diff->m ? $format[]= '%m meses '	: '';
			$diff->d ? $format[]= '%d dias '	: '';
			$diff->h ? $format[]= '%h horas '	: '';
			$diff->i ? $format[]= '%i Minutos ' : '';
			$diff->s ? $format[]= '%s segundos ' : '';
			$format = implode(', ', $format);
		}
		return  $diff->format($format); 
	}

}

?>
