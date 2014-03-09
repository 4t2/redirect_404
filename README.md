Redirect 404
============

Diese Erweiterung legt eine extra Tabelle `tl_page_history` an und speichert bei jeder Änderung eines Seitenaliases die ursprüngliche URL in dieser Tabelle. Ruft ein Client später die urspüngliche und nicht mehr gültige URL auf, ermittelt `redirect_404` über die History-Tabelle die gewünschte Seite und leitet auf die neue URL um.

Hook
----

Über den Hook `redirectPageError404` lässt sich die Erweiterung auch mit eigenen Regeln und seitenspezifischen Umleitungen ergänzen.

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
}
```

Ist nach dem Aufruf des Hooks `$strUrl` gesetzt, wird von der Erweiterung nicht mehr in der History-Tabelle nach einer passenden URL gesucht.