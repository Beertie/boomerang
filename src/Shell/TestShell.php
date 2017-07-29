<?php
namespace App\Shell;

use Cake\Console\Shell;

/**
 * Test shell command.
 *
 * @property \App\Model\Table\TagsTable   $Tags
 * @property \App\Model\Table\UsersTable  $Users
 */
class TestShell extends Shell
{

    public function initialize()
    {
        $this->loadModel('Tags');
        $this->loadModel('Users');
    }

    public function run(){

        $user = $this->Users->get(3);
        $tags = $this->Tags->find()->toArray();

        $user->tags = $tags;
        $this->Users->save($user);
        exit;


        $tagIdArray = [];
        /** @var Tag $tag */
        foreach ($tags as $tag) {
            $tagIdArray[] = $tag->id;
        }
        $data = [
            'tags' => [
                '_ids' => $tagIdArray
            ]
        ];
        $entity = $this->Users->patchEntity($user, $data, ['associated' => ['tags']]);
        $this->Users->save($entity);

    }

    public function get(){
        $user = $this->Users->find()->where(['id' => 1])->contain(['Tags'])->firstOrFail();
        debug($user);
    }
}
