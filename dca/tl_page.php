<?php if (!defined('TL_ROOT')) die('You cannot access this file directly!');


$GLOBALS['TL_DCA']['tl_page']['config']['onsubmit_callback'][] = array('tl_page_history', 'savePageHistory');


class tl_page_history extends Backend
{
	public function savePageHistory(DataContainer $dc)
	{
		$objPage = PageModel::findWithDetails($dc->activeRecord->id);

		$objDatabase = \Database::getInstance();

		$objResult = $objDatabase->prepare('SELECT `id` FROM `tl_page_history` WHERE `alias`=? AND `language`=? AND `dns`=?')
								 ->execute($objPage->alias, $objPage->language, $objPage->domain);

		if ($objResult->numRows == 0)
		{
			$objResult = $objDatabase->prepare('INSERT INTO `tl_page_history` (`pid`, `alias`, `language`, `dns`) VALUES (?, ?, ?, ?)')
									 ->execute($objPage->id, $objPage->alias, $objPage->language, $objPage->domain);
		}
	}
}

