<?php
namespace App\Model\Entity;
use Cake\ORM\Entity;
use Cake\Auth\DefaultPasswordHasher;

class User extends Entity {
    // set trường có thể lấy được trong patchEntity($user, $this->request->getData())
	protected $_accessible = [
        'username' => true,
        'password' => true
    ];
    protected function _setPassword($value) {
        if (strlen($value)) {
            $hasher = new DefaultPasswordHasher();

            return $hasher->hash($value);
        }
    }
}
