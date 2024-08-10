<?php

class RssFactory {

    // constructor
	function RssFactory() {}

    // rss generator
	function GenRssByData($aRssData, $sTitle, $sMainLink, $sImage = '') {
        $sRSSLast = '';
        if (isset($aRssData[0]))
            $sRSSLast = $aRssData[0]['DateTime'];

        $sUnitRSSFeed = '';
		foreach ($aRssData as $iUnitID => $aUnitInfo) {
			$sUnitUrl = $aUnitInfo['Link'];
			$sUnitGuid = $aUnitInfo['Guid'];
			$sUnitTitle = $aUnitInfo['Title'];
            $sUnitDate = $aUnitInfo['DateTime'];
			$sUnitDesc = $aUnitInfo['Desc'];

            $sUnitRSSFeed .= "<item><title><![CDATA[{$sUnitTitle}]]></title><link><![CDATA[{$sUnitUrl}]]></link><guid><![CDATA[{$sUnitGuid}]]></guid><description><![CDATA[{$sUnitDesc}]]></description><pubDate>{$sUnitDate}</pubDate></item>";
		}

		$sRSSTitle = "{$sTitle} RSS";
		$sRSSImage = ($sImage != '') ? "<image><url>{$sImage}</url><title>{$sRSSTitle}</title><link>{$sMainLink}</link></image>" : '';
        return "<?xml version=\"1.0\" encoding=\"UTF-8\"?><rss version=\"2.0\"><channel><title>{$sRSSTitle}</title><link>{$sMainLink}</link><description>{$sRSSTitle}</description><lastBuildDate>{$sRSSLast}</lastBuildDate>{$sRSSImage}{$sUnitRSSFeed}</channel></rss>";
	}
}

?>