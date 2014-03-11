<?php if (!defined('TL_ROOT')) die('You cannot access this file directly!');

$GLOBALS['TL_DCA']['tl_page']['fields']['alias']['save_callback'][] = array('tl_page_history', 'savePageAliasToHistory');


class tl_page_history extends Backend
{
	public function savePageAliasToHistory($varValue, \DataContainer $dc)
	{
		if (($dc->activeRecord->alias != '') && ($varValue != $dc->activeRecord->alias))
		{
			$objPage = PageModel::findWithDetails($dc->activeRecord->id);

			$objDatabase = \Database::getInstance();

			$objResult = $objDatabase->prepare('SELECT `id` FROM `tl_page_history` WHERE `alias`=? AND `language`=? AND `dns`=?')
									 ->execute($dc->activeRecord->alias, $objPage->language, $objPage->domain);

			if ($objResult->numRows == 0)
			{
				$objResult = $objDatabase->prepare('INSERT INTO `tl_page_history` (`pid`, `alias`, `language`, `dns`) VALUES (?, ?, ?, ?)')
										 ->execute($objPage->id, $dc->activeRecord->alias, $objPage->language, $objPage->domain);
			}
		}

		return $varValue;
	}
}
