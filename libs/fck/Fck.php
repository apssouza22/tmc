<?php

/**
 * Ajuda a escrever os dados de configura��o do FckEditor
 * @author Cicero Louren�o
 *
 */
class Fck
{
	
	/**
	 * Escreve na tela, com base no ID do elemento do DOM informado
	 * @param string $id_elemento ID do elemento do DOM (textarea) que receber� o editor
	 * @param string $texto_html Texto HTML inicial  
	 */
	public static function write($id_elemento, $texto_html='', $toolbar='toolbar_vivacom')
	{
		$fck = new FCKeditor($id_elemento);
		$fck->BasePath = DIR_CMS_HTM_ROOT . 'js/FCKeditor/';								
		$fck->Value = $texto_html;
		$fck->Height = 230;
		$fck->ToolbarSet = $toolbar;
		$fck->Config['SkinPath'] = DIR_CMS_HTM_ROOT . 'js/FCKeditor/editor/skins/silver/';
		$fck->Config['UserFilesPath'] = '_adminica_vivacom/userfiles/fck/' ;
		$fck->Create();
	}

}
