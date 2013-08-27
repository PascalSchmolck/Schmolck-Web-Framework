<?php

/**
 * Schmolck_Tool_Piwik
 * 
 * @package Schmolck
 * @author Pascal Schmolck
 * @copyright 2013
 */
class Schmolck_Tool_Piwik {

	/**
	 * Get Piwik Analytik tracking code
	 * 
	 * @param string $strId
	 * @return string JavaScript
	 */
	static public function getTrackingCode($strId) {
		return '
			<!-- Piwik -->
			<script type="text/javascript">
				var _paq = _paq || [];
				_paq.push(["trackPageView"]);
				_paq.push(["enableLinkTracking"]);

				(function() {
					var u=(("https:" == document.location.protocol) ? "https" : "http") + "://piwik.schmolck.de/piwik/";
					_paq.push(["setTrackerUrl", u+"piwik.php"]);
					_paq.push(["setSiteId", "'.$strId.'"]);
					var d=document, g=d.createElement("script"), s=d.getElementsByTagName("script")[0]; g.type="text/javascript";
					g.defer=true; g.async=true; g.src=u+"piwik.js"; s.parentNode.insertBefore(g,s);
				})();
			</script>
			<!-- End Piwik Code -->				
		';
	}

}