<?php

namespace Lingo\Redirect;


/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2014 Leo Feyer
 *
 * PHP version 5
 * @copyright  Lingo4you 2014
 * @author     Mario Müller <http://www.lingolia.com/>
 * @version    1.0.1
 * @package    redirect_404
 * @license    http://opensource.org/licenses/lgpl-3.0.html
 */

class PageError404 extends \Contao\PageError404
{
	public function generate($pageId, $strDomain=null, $strHost=null)
	{
		$strUrl = FALSE;
		$intStatus = 301;

		// HOOK: add custom logic
		if (isset($GLOBALS['TL_HOOKS']['redirectPageError404']) && is_array($GLOBALS['TL_HOOKS']['redirectPageError404']))
		{
			foreach ($GLOBALS['TL_HOOKS']['redirectPageError404'] as $callback)
			{
				$this->import($callback[0]);
				$arrModules = $this->$callback[0]->$callback[1]($pageId, $strDomain, $strHost, $strUrl, $intStatus);
			}
		}

		$language = ($GLOBALS['TL_LANGUAGE'] != '' ? $GLOBALS['TL_LANGUAGE'] : FALSE);

		$strRequest = \Environment::get('request');

		if ($language && (substr($strRequest, 0, 3) == $language.'/'))
		{
			$strRequest = substr($strRequest, 3);
		}

		if (!$strUrl && preg_match('#^([^\?]+)#i', $strRequest, $match))
		{
			$strUrl = $this->findInHistory(\Environment::get('host'), $match[1], $language);
		}


		if ($strUrl !== FALSE)
		{
			// see https://github.com/contao/core/issues/6785
			// \Search::removeEntry(\Environment::get('request'));

			\System::log(sprintf('Redirect %s → %s (%d) Referer: %s', \Environment::get('request'), $strUrl, $intStatus, $this->getReferer()), __METHOD__, TL_GENERAL);

			$this->redirect($strUrl, $intStatus);
		}
		else
		{
			parent::generate($pageId, $strDomain, $strHost);
		}
	}


	/**
	 * look for the page in the history table
	 */
	protected function findInHistory($strDomain, $strAlias, $language = FALSE)
	{
		$objDatabase = \Database::getInstance();

		if ($language !== FALSE)
		{
			$objResult = $objDatabase->prepare("SELECT `pid` FROM `tl_page_history` WHERE `alias`=? AND `language`=? AND `dns`=?")
									 ->execute($strAlias, $language, $strDomain);
		}
		else
		{
			$objResult = $objDatabase->prepare("SELECT `pid` FROM `tl_page_history` WHERE `alias`=? AND `dns`=?")
									 ->execute($strAlias, $strDomain);
		}

		if ($objResult->next())
		{
			$objPage = \PageModel::findWithDetails($objResult->pid);

			if ($objPage != NULL && $objPage->published != '')
			{
				\System::log(sprintf('Found «%s» in history', $strAlias), __METHOD__, TL_GENERAL);

				return \Environment::get('base') . $this->generateFrontendUrl($objPage->row(), NULL, $language);
			}
		}

		return FALSE;
	}
}
