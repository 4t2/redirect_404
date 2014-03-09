<?php

class HistoryRunonceJob extends Controller
{
	public function run()
	{
		$objPages = \Database::getInstance()->execute("SELECT `id`,`alias`,`language`,`dns` FROM `tl_page` WHERE `published`='1'");

		while ($objPages->next())
		{
			if ($objPages->language == '' || $objPages->dns == '')
			{
				$objPage = \PageModel::findWithDetails($objPages->id);

				$strLanguage = $objPage->language;
				$strDomain = $objPage->domain;
			}
			else
			{
				$strLanguage = $objPages->language;
				$strDomain = $objPages->dns;
			}

			\Database::getInstance()->prepare('INSERT INTO `tl_page_history` (`pid`, `alias`, `language`, `dns`) VALUES (?, ?, ?, ?)')->execute($objPages->id, $objPages->alias, $strLanguage, $strDomain);
		}

		$objVersions = \Database::getInstance()->execute("SELECT `pid`, `data` FROM `tl_version` WHERE `fromTable`='tl_page'");

		while ($objVersions->next())
		{
			$rowPage = unserialize($objVersions->data);

			if ($rowPage['alias'] != '')
			{
				$objPage = \PageModel::findWithDetails($rowPage['id']);

				if ($objPage != NULL)
				{
					$objResult = \Database::getInstance()->prepare('SELECT `id` FROM `tl_page_history` WHERE `alias`=? AND `language`=? AND `dns`=?')->execute($objPage->alias, $objPage->language, $objPage->domain);

					if ($objResult->numRows == 0)
					{
						\Database::getInstance()->prepare('INSERT INTO `tl_page_history` (`pid`, `alias`, `language`, `dns`) VALUES (?, ?, ?, ?)')->execute($rowPage['id'], $rowPage['alias'], $objPage->language, $objPage->domain);
					}
				}
			}
		}
	}
}

$objHistoryRunonceJob = new HistoryRunonceJob();
$objHistoryRunonceJob->run();
