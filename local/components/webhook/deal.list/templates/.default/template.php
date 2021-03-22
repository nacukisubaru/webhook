<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
?>
<script src="https://unpkg.com/react@17/umd/react.production.min.js" crossorigin></script>
<script src="https://unpkg.com/react-dom@17/umd/react-dom.production.min.js" crossorigin></script>
<script src="https://unpkg.com/babel-standalone@6/babel.min.js"></script>
<link href="<?= $this->GetFolder() ?>/css/bootstrap.css" rel="stylesheet">
<link href="<?= $this->GetFolder() ?>/css/style.css" rel="stylesheet">
<div class="row">

        <div class="row">
            <div class="col-md-4 col-lg-3 navbar-container bg-light">
                <!-- Вертикальное меню -->
                <div class="collapse navbar-collapse menu-box" id="navbar">
                    <? foreach ($arParams['stages'] as $stage) { ?>
                        <div class="deal_stage"  data-url="<?=$_SERVER['PHP_SELF']?>" data-stageid="<?= $stage ?>"></div>
                    <? } ?>
                </div>
            </div>
        </div>
    <div class="col-md-4 deal-box">
        <div id="deal_block"></div>
    </div>
</div>
<script type="text/babel" src="<?= $this->GetFolder() ?>/deal_list.js"></script>
<script src="<?= $this->GetFolder() ?>/js/jquery.js"></script>

