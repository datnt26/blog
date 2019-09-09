<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Likes Model
 *
 * @method \App\Model\Entity\Like get($primaryKey, $options = [])
 * @method \App\Model\Entity\Like newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Like[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Like|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Like saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Like patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Like[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Like findOrCreate($search, callable $callback = null, $options = [])
 */
class LikesTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('likes');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->integer('postId')
            ->requirePresence('postId', 'create')
            ->notEmptyString('postId');

        $validator
            ->integer('userId')
            ->requirePresence('userId', 'create')
            ->notEmptyString('userId');

        return $validator;
    }
}
