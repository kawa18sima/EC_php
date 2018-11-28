<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Purchases Controller
 *
 * @property \App\Model\Table\PurchasesTable $Purchases
 *
 * @method \App\Model\Entity\Purchase[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PurchasesController extends AppController
{
    public function index()
    {
        $this->paginate = [
            'contain' => [
                'Users',
                'Carts' =>[
                    'Products'
                ]],
            'order' => [
                'id' => 'desc'
            ]
        ];
        $purchases = $this->paginate($this->Purchases->find()->where(['user_id' => $this->Auth->user()['id'], 'Purchases.level' => 1]));

        $this->set(compact('purchases'));
    }

    public function edit($id = null, $type = null)
    {
        $this->loadModel('Products');
        $this->autoRender = false;
        $purchase = $this->Purchases->get($id, [
            'contain' => [
                'Carts' =>[
                    'Products'
                ]]
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            if($type == 1){
                foreach ($purchase->carts as $cart) {
                    if($cart->product->stock - $cart->count < 0){
                        $this->Flash->error($cart->product->title . 'の在庫がありません。');
                        return $this->redirect(['controller' => 'carts', 'action' => 'index']);
                    }
                }
                $purchase->level = 1;
                $purchase->purchaseDate = date('Y-m-d H:i:s');
                if ($this->Purchases->save($purchase)) {
                    $this->Flash->success(__('購入が完了しました'));
                    foreach ($purchase->carts as $cart) {
                        $cart->product->stock -= $cart->count;
                        $this->Products->save($cart->product);
                    }
                    $purchase = $this->Purchases->newEntity();
                    $purchase->user_id = $this->Auth->user()['id'];
                    $this->Purchases->save($purchase);
                }
                return $this->redirect(['controller' => 'Products', 'action' => 'index']);
            }
            $this->Flash->error(__('The purchase could not be saved. Please, try again.'));
        }
        $users = $this->Purchases->Users->find('list', ['limit' => 200]);
        $this->set(compact('purchase', 'users'));
    }
}
