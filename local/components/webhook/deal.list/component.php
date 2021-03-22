<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if($_REQUEST['stage']){
    $APPLICATION->RestartBuffer();
    $deal_list = \Webhook\Deal\Deal::getDealList($_REQUEST['stage']);
    if($deal_list != array()) {
        print json_encode($deal_list, JSON_UNESCAPED_UNICODE);
    }else{
        print 'N';
    }
    die();
}

foreach(\Webhook\Deal\Deal::getStageDealList() as $deal ){
    $arParams['stages'][] = $deal;
}

$this->IncludeComponentTemplate();