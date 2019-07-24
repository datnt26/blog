<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Comments Controller
 *
 * @property \App\Model\Table\CommentsTable $Comments
 *
 * @method \App\Model\Entity\Comment[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CommentsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index() {
        $data = array();
        /******** find all *********/
        /*
            $query = $this->Comments->find('all');
            //By default queries and result sets will return Entities objects. You can retrieve basic arrays by disabling hydration:
            $query->enableHydration(false);
            $data = $query->toArray();
        */

        /******** find first *********/
        /*
            $query = $this->Comments->find()->first();
            $data = $query->toArray();
        */

        /******** find list *********/
        /*
            $options = array();
            $options['keyField'] = 'id';
            $options['valueField'] = function ($comment) {
                                        return $comment->get('label');
                                    };
            $options['groupField'] = 'userId';

            $query = $this->Comments->find('list',$options);
            $data = $query->toArray();
        */

        /******** find threaded *********/
        /*
            $options = array();
            $options['contain'] = array('Users');
            $query = $this->Comments->find('threaded',$options);
            $data = $query->toArray();
        */

        $this->log($data);

        $comments = $this->paginate($this->Comments);

        $this->set(compact('comments'));
    }

    public function getAllComment() {
        $this->layout = false;
        $this->autoRender = false;

        $this->response->body(json_encode('haha'));

        return $this->response;
    }

    /**
     * View method
     *
     * @param string|null $id Comment id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $comment = $this->Comments->get($id, [
            'contain' => ['ParentComments', 'ChildComments']
        ]);

        $this->set('comment', $comment);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $comment = $this->Comments->newEntity();
        if ($this->request->is('post')) {
            $comment = $this->Comments->patchEntity($comment, $this->request->getData());
            if ($this->Comments->save($comment)) {
                $this->Flash->success(__('The comment has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The comment could not be saved. Please, try again.'));
        }
        $parentComments = $this->Comments->ParentComments->find('list', ['limit' => 200]);
        $this->set(compact('comment', 'parentComments'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Comment id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $comment = $this->Comments->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $comment = $this->Comments->patchEntity($comment, $this->request->getData());
            if ($this->Comments->save($comment)) {
                $this->Flash->success(__('The comment has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The comment could not be saved. Please, try again.'));
        }
        $parentComments = $this->Comments->ParentComments->find('list', ['limit' => 200]);
        $this->set(compact('comment', 'parentComments'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Comment id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $comment = $this->Comments->get($id);
        if ($this->Comments->delete($comment)) {
            $this->Flash->success(__('The comment has been deleted.'));
        } else {
            $this->Flash->error(__('The comment could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
