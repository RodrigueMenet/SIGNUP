<?php
$I_NB_CUSTOMER = 5;
$I_NB_PRODUCT = 4;
for ($iCust = 0; $iCust < $I_NB_CUSTOMER; $iCust++) {
	for ($iProd = 0; $iProd < $I_NB_PRODUCT; $iProd++) {
		echo "INSERT INTO transac (id, product_id, customer_id, sold_date) VALUES (".
		($iCust * $I_NB_PRODUCT + $iProd).", ".
		$iProd.", ".
		$iCust.", DATE_ADD(curdate(), INTERVAL -".sprintf("%02d",rand(1,10))." DAY));<br/>";
	}
}
?>