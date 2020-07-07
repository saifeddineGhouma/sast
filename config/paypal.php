<?php

return array(

/** set your paypal credential **/

'client_id' =>'Acbr4b1xev_zsdGEB0iGj6MHfZGUuxBHI-_dE2_q4x5gbek6B2H5kf-vAbq1neQRFdiVjniUcukNnB3z',

'secret' => 'EN1DLiBTypPhlvyK-r2yEOpkJ6oIwktWVOMzI7OcAhglQ47zio0lkJPJaOoLCy-b3LIZD7oxo7u1zvRA',




/**

* SDK configuration 

*/

'settings' => array(

	/**

	* Available option 'sandbox' or 'live'

	*/

	'mode' => 'live',

	/**

	* Specify the max request time in seconds

	*/

	'http.ConnectionTimeOut' => 1000,

	/**

	* Whether want to log to a file

	*/

	'log.LogEnabled' => true,

	/**

	* Specify the file that want to write on

	*/

	'log.FileName' => storage_path() . '/logs/paypal.log',

	/**

	* Available option 'FINE', 'INFO', 'WARN' or 'ERROR'

	*

	* Logging is most verbose in the 'FINE' level and decreases as you

	* proceed towards ERROR

	*/

	'log.LogLevel' => 'FINE'

	),

);

?>