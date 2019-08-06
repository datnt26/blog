<?php
namespace App\Controller;

use App\Controller\AppController;

class CommentsController extends AppController {
    
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

        /******** Custom Finder Methods *********/
        /*
            $query = $this->Comments->find('ownedBy', ['commentId' => 1]);
            $data = $query->toArray();
        */
        $this->log($data);

        $comments = $this->paginate($this->Comments);

        $this->set(compact('comments'));
    }

    public function getAllComment($postId) {
        $this->layout = false;
        $this->autoRender = false;

        if (!$postId) return;
        $options = array();
        $options['conditions'] = array('Comments.postId' => $postId);
        $options['contain'] = array('Users');
        $query = $this->Comments->find('threaded',$options);
        $data = $query->toArray();
        $this->response->body(json_encode($data));

        return $this->response;
    }

    public function addComment() {
        $this->layout = false;
        $this->autoRender = false;  

        $comment = $this->Comments->newEntity();
        if ($this->request->is('Ajax')) {
            $data = $this->request->data;
            if (!$data['message']) return;
            $data['userId'] = $this->Auth->user('id');
            $comment = $this->Comments->patchEntity($comment,$data);
            $this->log($comment);
            if ($this->Comments->save($comment)) {
                $options = array();
                $options['contain'] = array('Users');
                $newComment = $this->Comments->get($comment->id,$options);
                $this->response->body(json_encode($newComment));

                return $this->response;
            }
        }
    }
}
