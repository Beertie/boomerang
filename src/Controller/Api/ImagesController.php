<?php

namespace App\Controller\Api;

use App\Controller\AppController;
use App\Model\Entity\Image;
use App\Model\Entity\Tag;

/**
 * Images Controller
 *
 * @property \App\Model\Table\ImagesTable $Images
 *
 * @method \App\Model\Entity\Image[] paginate($object = null, array $settings = [])
 */
class ImagesController extends AppController
{



    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {


        $tags = $this->Images->Tags->find()->contain(['Images']);
        $data = [];
        /** @var Tag $tag */
        foreach ($tags as $tag) {
            if (!isset($tag->images[0]->id)) {
                continue;
            }
            $data[] = [
                'tag' => $tag->name,
                'previewHeight' => $tag->images[0]->imageWidth,
                'previewWidth' => $tag->images[0]->imageWidth,
                'imageWidth' => $tag->images[0]->imageWidth,
                'imageHeight' => $tag->images[0]->imageWidth,
                'image' => base64_encode(file_get_contents($tag->images[0]->previewURL)),
                'imaageId' => $tag->images[0]->id
            ];
        }
        $this->set('data', $data);
        $this->set('success', true);
        $this->set('message', null);
        $this->set('_serialize', ['data', 'success', 'message']);
    }

    /**
     * View method
     *
     * @param string|null $id Image id.
     *
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $image = $this->Images->get($id, [
            'contain' => ['Tags']
        ]);

        $this->set('image', $image);
        $this->set('_serialize', ['image']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $image = $this->Images->newEntity();
        if ($this->request->is('post')) {
            $image = $this->Images->patchEntity($image, $this->request->getData());
            if ($this->Images->save($image)) {
                $this->Flash->success(__('The image has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The image could not be saved. Please, try again.'));
        }
        $tags = $this->Images->Tags->find('list', ['limit' => 200]);
        $this->set(compact('image', 'tags'));
        $this->set('_serialize', ['image']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Image id.
     *
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $image = $this->Images->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $image = $this->Images->patchEntity($image, $this->request->getData());
            if ($this->Images->save($image)) {
                $this->Flash->success(__('The image has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The image could not be saved. Please, try again.'));
        }
        $tags = $this->Images->Tags->find('list', ['limit' => 200]);
        $this->set(compact('image', 'tags'));
        $this->set('_serialize', ['image']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Image id.
     *
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $image = $this->Images->get($id);
        if ($this->Images->delete($image)) {
            $this->Flash->success(__('The image has been deleted.'));
        } else {
            $this->Flash->error(__('The image could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
