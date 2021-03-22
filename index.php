<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
global $APPLICATION;
$APPLICATION->IncludeComponent('webhook:deal.list','.default',array());
