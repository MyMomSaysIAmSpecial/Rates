<?php

	function getYahooRates($aCurrencyCodesToProcess) {

		foreach ( $aCurrencyCodesToProcess as $sCurrencyCode ) {
			$aCurrencyRequestCodes[] = ' "' . $sCurrencyCode . 'LTL"';
		}

		$sCurrencyRequestCodes	= implode(',', $aCurrencyRequestCodes);

		$sYahooApiUrl		= 'http://query.yahooapis.com/v1/public/yql' . '?q=';
		$sYahooApiYql		= 'select * from yahoo.finance.xchange where pair in (' . $sCurrencyRequestCodes . ')';
		$sYahooApiYqlParams	= '&format=json&env=store://datatables.org/alltableswithkeys&callback=';

		$sYahooRequestUrl	= $sYahooApiUrl . urlencode($sYahooApiYql) . $sYahooApiYqlParams;

		$oCh = curl_init();
		curl_setopt($oCh, CURLOPT_URL, $sYahooRequestUrl);
		curl_setopt($oCh, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($oCh, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($oCh, CURLINFO_HEADER_OUT, true);
		$sResponse = curl_exec( $oCh );
		curl_close($oCh);

		return json_decode($sResponse, TRUE);
	}