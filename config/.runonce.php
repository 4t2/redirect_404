<?php

class HistoryRunonceJob extends Controller
{
	public function run()
	{
		$objDatabase = \Database::getInstance();

		if ($objDatabase->tableExists('tl_page_history')) 
		{
			$objVersions = $objDatabase->execute("SELECT `pid`, `data` FROM `tl_version` WHERE `fromTable`='tl_page'");

			while ($objVersions->next())
			{
				$rowPage = unserialize($objVersions->data);

				if ($rowPage['alias'] != '')
				{
					$objPage = \PageModel::findWithDetails($rowPage['id']);

					if ($objPage != NULL)
					{
						$objResult = $objDatabase->prepare('SELECT `id` FROM `tl_page_history` WHERE `alias`=? AND `language`=? AND `dns`=?')->execute($objPage->alias, $objPage->language, $objPage->domain);

						if ($objResult->numRows == 0)
						{
							$objDatabase->prepare('INSERT INTO `tl_page_history` (`pid`, `alias`, `language`, `dns`) VALUES (?, ?, ?, ?)')->execute($rowPage['id'], $rowPage['alias'], $objPage->language, $objPage->domain);
						}
					}
				}
			}
		}

	}
}

$objHistoryRunonceJob = new HistoryRunonceJob();
$objHistoryRunonceJob->run();
