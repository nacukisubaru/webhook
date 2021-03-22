<?php

namespace Webhook\Deal;
use \Webhook\QueryRest\QueryRest;

/**
 * Class Deal
 * Класс для получения сделок
 * @package Webhook\Deal
 */
class Deal
{
    public function __construct()
    {
    }

    /**
     * Получает весь список сделок и товаров сделок по стадии
     * товары сделок получает при помощи метода rest api batch
     * @param string $stage стадия сделки
     * @return array
     */
    public static function getDealList(string $stage):array
    {
        $array_prod = array();
        $array_deals = array();
        $array_batch = array();
        $deal_list = array();
        $array_clients = array();
        $array_batch_client = array();
        $query_rest = new QueryRest('crm.deal.list');
        $deals = $query_rest->executeQuery(array('filter' => array('STAGE_ID' => $stage), 'order' => array('SORT' => 'ASC')));
        foreach ($deals as $key => $deal) {
            $array_batch['cmd'][] = 'crm.productrow.list?' . http_build_query(array('filter' => array('OWNER_TYPE' => 'D', 'OWNER_ID' => $deal['ID'])));
            $array_deals[$deal['ID']] = $deals;
            $array_clients[] = $deal['CONTACT_ID'];
        }
        $query_get_prod = new QueryRest('batch');
        $prod_deals = $query_get_prod->executeQuery($array_batch);
        $inc = 0;
        foreach ($prod_deals['result'] as $key => $prod_deal) {
            foreach ($prod_deal as $key => $value) {
                if ($array_deals[$value['OWNER_ID']]) {
                    $array_prod[$value['OWNER_ID']][] = array('name'=>$value['PRODUCT_NAME'],'price'=>round($value['PRICE']),
                        'quan'=>round($value['QUANTITY']),'lng'=>$value['MEASURE_NAME']);
                }
            }
            $inc++;
        }
        foreach (array_unique($array_clients) as $key=>$client){
            $array_batch_client['cmd'][] = 'crm.contact.get?id='.$client;
        }
        $query_get_contact = new QueryRest('batch');
        $contacts = $query_get_contact->executeQuery($array_batch_client)['result'];
        $array_contacts_res= array();
        foreach ($contacts as $key=>$contact){
            $array_contacts_res[$contact['ID']] = $contact;
        }
        $deal_inc = 0;
        foreach ($array_deals as $key => $deal) {
            if ($array_prod[$deal[$deal_inc]['ID']]) {
                $deal_list[] = array(
                    'id' => $deal[$deal_inc]['ID'],
                    'name' => $deal[$deal_inc]['TITLE'],
                    'currency'=>$deal[$deal_inc]['CURRENCY_ID'],
                    'sum' => round($deal[$deal_inc]['OPPORTUNITY']),
                    'client' => array('name' => $array_contacts_res[$deal[$deal_inc]['CONTACT_ID']]['NAME'], 'phone' => $array_contacts_res[$deal[$deal_inc]['CONTACT_ID']]['PHONE'][0]['VALUE']),
                    'create' => date('d.m.Y H:i:s', strtotime($deal[$deal_inc]['DATE_CREATE'])),
                    'comment' => $deal[$deal_inc]['COMMENTS'],
                    'products' => $array_prod[$deal[$deal_inc]['ID']]
                );
            }
            $deal_inc++;
        }
        return $deal_list;
    }

    /**
     * Получает список стадий для сделок
     * @return array
     */
    public static function getStageDealList():array {
      $array_stages = array();
      $query_rest = new QueryRest('crm.status.list');
      $stages = $query_rest->executeQuery(array('filter'=>array('ENTITY_ID'=>'DEAL_STAGE'),
          'order'=>array('SORT'=>'ASC')));
        foreach ($stages as $key=>$stage) {
           $array_stages[] = $stage['STATUS_ID'];
        }
        return $array_stages;
    }
}