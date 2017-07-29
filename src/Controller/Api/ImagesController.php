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
        $tags = $this->Images->Tags->find()->contain(['Images'])->order(['name']);
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
                'id' => $tag->images[0]->id
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

        $data = [
            'tag' => $image->tag['name'],
            'previewHeight' => $image->imageWidth,
            'previewWidth' => $image->imageWidth,
            'imageWidth' => $image->imageWidth,
            'imageHeight' => $image->imageWidth,
            'image' => base64_encode(file_get_contents($image->webformatURL)),
            'imaageId' => $image->id
        ];

        $this->set('data', $data);
        $this->set('success', true);
        $this->set('message', null);
        $this->set('_serialize', ['data', 'success', 'message']);
    }


    public function viewSmall(){
        $image = $this->Images->get(10);
        $data = [
            'tag' => $image->tag['name'],
            'previewHeight' => $image->imageWidth,
            'previewWidth' => $image->imageWidth,
            'imageWidth' => $image->imageWidth,
            'imageHeight' => $image->imageWidth,
            'image' => base64_encode(file_get_contents($image->previewURL)),
            'imaageId' => $image->id
        ];

        $this->set('data', $data);
        $this->set('success', true);
        $this->set('message', null);
        $this->set('_serialize', ['data', 'success', 'message']);

    }
}
