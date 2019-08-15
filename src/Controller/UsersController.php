<?php
namespace App\Controller;
use App\Controller\AppController;

class UsersController extends AppController {

    public function initialize() {
        parent::initialize();
        $this->Auth->allow(['logout','register']);
    }

    public function login() {
        if ($this->request->is('post')) {
            $user = $this->Auth->identify();
            if ($user) {
                $this->Auth->setUser($user);
                return $this->redirect($this->Auth->redirectUrl());
            }
            $this->Flash->error('Your username or password is incorrect.');
        }
    }

    public function register() {
        $this->autoRender = false;
        $this->layout = false;
        
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            $this->log($user);
            if ($this->Users->save($user)) {
                return $this->redirect(['action' => 'login']);
            }
            else {
                $this->log($user->getErrors());
            }
        }
    }

    public function logout() {
        return $this->redirect($this->Auth->logout());
    }
}
