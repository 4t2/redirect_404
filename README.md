Redirect 404
============

Diese Erweiterung legt eine extra Tabelle `tl_page_history` an und speichert be jeder Änderung eines Seitenaliases die ursprüngliche URL in dieser Tabelle. Ruft ein Client später die urspüngliche und nicht mehr gültige URL auf, ermittelt `redirect_404` über die History-Tabelle die gewünschte Seite und leitet auf diese um.

Callback
========

Über den Callback `redirectPageError404` lässt sich die Erweiterung auch mit eigenen Regeln ergänzen und Seitenspezifische Umleitungen einbauen.

Beispiel:

```php
<?php if (!defined('TL_ROOT')) die('You cannot access this file directly!');

class RedirectHooks extends System
{

	public function redirectPageError404Hook($pageId, $strDomain, $strHost, &$strUrl, &$intStatus)
	{
		if (!$strUrl && preg_match('#undefined$#i', \Environment::get('request'), $match))
		{
			$strUrl = \Environment::get('base');
			$intStatus = 302;
		}
}
```
