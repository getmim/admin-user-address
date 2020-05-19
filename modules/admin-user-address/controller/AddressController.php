<?php
/**
 * AddressController
 * @package admin-user-address
 * @version 0.0.1
 */

namespace AdminUserAddress\Controller;

use LibFormatter\Library\Formatter;
use LibForm\Library\Form;
use LibForm\Library\Combiner;
use LibUserMain\Model\User;
use UserAddress\Model\UserAddress as UAddress;

class AddressController extends \AdminUser\Controller\EditorController
{
    private function getParams(string $title): array{
        return [
            '_meta' => [
                'title' => $title,
                'menus' => ['user', 'all-user']
            ],
            'subtitle' => $title,
            'pages' => null
        ];
    }

    public function editAction(){
        if(!$this->user->isLogin())
            return $this->loginFirst(1);
        if(!$this->can_i->manage_user_address)
            return $this->show404();

        $user = (object)[];

        $id = $this->req->param->id;
        $user = User::getOne(['id'=>$id]);
        if(!$user)
            return $this->show404();
        $params = $this->getParams('Edit User Address');

        $address = UAddress::getOne(['user'=>$id]);
        if(!$address){
            $aid = UAddress::create(['user'=>$id]);
            $address = UAddress::getOne(['id'=>$aid]);
        }

        $form              = new Form('admin.user.address');
        $params['form']    = $form;
        $params['saved']   = false;
        $params['user']    = $user;
        $params['address'] = $address;

        $c_opts = [
            'country'   => [null, null, 'format', 'active', 'name'],
            'state'     => [null, null, 'format', 'active', 'name'],
            'city'      => [null, null, 'format', 'active', 'name'],
            'district'  => [null, null, 'format', 'active', 'name'],
            'village'   => [null, null, 'format', 'active', 'name'],
            'zipcode'   => [null, null, 'format', 'active', 'name']
        ];
        $combiner = new Combiner($address->id, $c_opts, 'user-address');
        $address  = $combiner->prepare($address);

        $params['opts'] = $combiner->getOptions();

        if(!($valid = $form->validate($address)) || !$form->csrfTest('noob'))
            return $this->resp('user/address', $params);

        foreach($c_opts as $key => $opts)
            $valid->$key = $valid->$key ?? NULL;

        if(!UAddress::set((array)$valid, ['user'=>$id]))
            deb(User::lastError());

        // add the log
        $this->addLog([
            'user'   => $this->user->id,
            'object' => $address->id,
            'parent' => $id,
            'method' => 2,
            'type'   => 'user-address',
            'original' => $address,
            'changes'  => $valid
        ]);

        $params['saved'] = true;
        $this->resp('user/address', $params);
    }
}