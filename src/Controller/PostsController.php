<?php
namespace App\Controller;
use App\Controller\AppController;
use Cake\ORM\Query;

class PostsController extends AppController {

    public function index() { 
        /******  virtual fields  ******/
        /*
            $query = $this->Posts->find();
            foreach ($query as $value) {
                $this->log($value);
            }
        */

        /****** format result ******/
        $options = array();
        $options['contain'] = array('Users');
        $options['order'] = array('Posts.created DESC');
        $options['limit'] = 5;
        $posts = $this->Posts->find('all',$options);
        // format posts
        $posts->formatResults(function (\Cake\Collection\CollectionInterface $results) {
            return $results->map(function ($row) {
                $row['Comment'] = json_decode($this->requestAction('/comments/getAllComment/' . $row['id']));
                return $row;
            });
        });

        /****** Linking Tables Nested ******/
        /*
            $options['contain'] = array('Users','Comments' => 'Users');
            $options['contain']['Users']['fields'] = array('Users.id'); // select fields return in linking table
            $postss = $this->Posts->find('all',$options)->enableHydration(false);// By default queries and result sets will return Entities objects. You can retrieve basic arrays by disabling hydration
            $this->log($postss->toArray());
        */

        /****** Passing Conditions to Contain ******/
        /*
            $options['contain'] = array('Users','Comments.Users');
            $options['contain']['Users']['fields'] = array('Users.id'); // select fields return in linking table
            $options['contain']['Comments'] = function (Query $query) {
                return $query->where(['Comments.id > ' => 1]);
            };
            $postss = $this->Posts->find('all',$options)->enableHydration(false);
            $this->log($postss->toArray());
        */

        /***** Use TableRegistry in Model *****/
        /*
            $query = $this->Posts->find('allComment');
            $this->log($query->toArray());
        */
            
        $avatarCurrentUser = $this->Auth->user('avatar');
        $title = 'Timeline';
        $this->set(compact('title','avatarCurrentUser','posts'));
    }

    public function create() {
        $this->autoRender = false;
        $this->layout = false;

        $post = $this->Posts->newEntity();
        if ($this->request->is('Ajax')) {
            $data = $this->request->data;
            $data['user_id'] = $this->Auth->user('id');
            $post = $this->Posts->patchEntity($post,$data);
            if ($this->Posts->save($post)) {
                $options = array();
                $options['contain'] = array('Users');
                $newPost = $this->Posts->get($post->id,$options);
                $this->response->body(json_encode($newPost));

                return $this->response;
            }
        }
    }

    // get next 5 posts 
    public function loadMore() {
        $this->layout = false;
        $this->autoRender = false;  

        if ($this->request->is('Ajax')) {
            $data = $this->request->data;
            $currentPage = $data['currentPage'];
            $options = array();
            $options['contain'] = array('Users');
            $options['order'] = array('Posts.created DESC');
            $options['limit'] = 5;
            $options['offset'] = $currentPage * 5;
            $posts = $this->Posts->find('all',$options);
            // format posts
            $posts->formatResults(function (\Cake\Collection\CollectionInterface $results) {
                return $results->map(function ($row) {
                    $row['Comment'] = json_decode($this->requestAction('/comments/getAllComment/' . $row['id']));
                    return $row;
                });
            });
            $this->log($posts->toArray());
            $this->response->body(json_encode($posts));

            return $this->response;
        }
    }

    public function delete() {
        $this->layout = false;
        $this->autoRender = false;  

        $this->log($this->request->data);

        if ($this->request->is('Ajax')) {
            $data = $this->request->data;
            $post = $this->Posts->get($data['postId']);
            // delete post and all comment of post
            if ($this->Posts->delete($post)) {
                $options = array();
                $options['contain'] = array('Users','Comments' => 'Users');
                $options['order'] = array('Posts.created DESC');
                $options['limit'] = 5;
                $posts = $this->Posts->find('all',$options);
                $this->response->body(json_encode($posts));

                return $this->response;
            }
        }
    }

}
