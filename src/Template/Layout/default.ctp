<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

$cakeDescription = 'CakePHP: the rapid development php framework';
?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $cakeDescription ?>:
        <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon') ?>

    <?= $this->Html->css('base.css') ?>
    <?= $this->Html->css('style.css') ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
    <?= $this->Html->script('http://code.jquery.com/jquery-1.11.3.min.js'); ?>
    <?= $this->Html->css('https://use.fontawesome.com/releases/v5.0.6/css/all.css') ?>
</head>
<body>
    <nav class="top-bar expanded" data-topbar role="navigation">
        <ul class="title-area large-2 medium-4 columns">
            <li class="name">
                <h1><a href="/">ECサイト</a></h1>
            </li>
        </ul>
        <div class="top-bar-section">
            <ul class="right">
                <?php if(isset($current_user)): ?>
                    <li><?=$this->Html->link('商品一覧',['controller' => 'Products', 'action' => 'index'])?></li>
                    <li><?=$this->Html->link('商品検索',['controller' => 'Products', 'action' => 'find'])?></li>
                    <li><?=$this->Html->link('カート',['controller' => 'Carts', 'action' => 'index'])?></li>
                    <li><?=$this->Html->link('購入履歴',['controller' => 'Purchases', 'action' => 'index'])?></li>
                    <li> <?= $this->Form->postLink(__('ユーザー編集'), ['controller' => 'Users', 'action' => 'view', $current_user['id']]) ?></li>
                    <li> <?= $this->Form->postLink(__('退会'), ['controller' => 'Users', 'action' => 'delete', $current_user['id']], ['confirm' => __('退会しますか？')]) ?></li>
                    <li><?=$this->Html->link('ログアウト',['controller' => 'Users', 'action' => 'logout'])?></li>
                <?php else: ?>
                    <li><?=$this->Html->link('ログイン',['controller' => 'Users', 'action' => 'login'])?></li>
                    <li><?=$this->Html->link('新規登録',['controller' => 'Users', 'action' => 'signup'])?></li>
                <?php endif ?>
            </ul>
        </div>
    </nav>
    <?= $this->Flash->render() ?>
    <div class="container clearfix">
        <?= $this->fetch('content') ?>
    </div>
    <footer>
    </footer>
</body>
</html>
