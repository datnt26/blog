<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;

/**
 * Post Entity
 *
 * @property int $id
 * @property int $user_id
 * @property string|null $content
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 *
 * @property \App\Model\Entity\User $user
 */
class Post extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'user_id' => true,
        'content' => true,
        'created' => true,
        'modified' => true,
        'user' => true
    ];
     /* virtual fields */
    // protected $_virtual = ['avatar_of_curent_user'];
    
    // protected function _getAvatar() {
    //     return $this->Auth->user('avatar');
    // }

    protected $_virtual = ['current_user_is_like_post'];
    
    protected function _getCurrentUserIsLikePost() {
        $like = TableRegistry::get('Likes');
        $exists = $like->exists(['userId' => 1, 'postId' => $this->_properties['id']]);
        return ($exists) ? true : false;
    }

}
