<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;

/**
 * Comment Entity
 *
 * @property int $id
 * @property int $postId
 * @property int $userId
 * @property string $message
 * @property int|null $parent_id
 * @property \Cake\I18n\FrozenTime $created
 *
 * @property \App\Model\Entity\ParentComment $parent_comment
 * @property \App\Model\Entity\ChildComment[] $child_comments
 */
class Comment extends Entity
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
        'postId' => true,
        'userId' => true,
        'message' => true,
        'parent_id' => true,
        'created' => true,
        'parent_comment' => true,
        'child_comments' => true
    ];

    protected $_virtual = ['children_comments'];

    protected function _getChildrenComments() {
        $options['contain'] = array('Users');
        $options['conditions'] = array('parent_id' => $this->_properties['id']);
        $query = TableRegistry::get('Comments')->find('all',$options);
        return $query->toArray();
    }
}
