<?php

namespace App\Controller\Api;

use App\Controller\AppController;
use App\Model\Entity\Image;
use App\Model\Entity\Tag;

/**
 * Tags Controller
 *
 * @property \App\Model\Table\TagsTable $Tags
 *
 * @method \App\Model\Entity\Tag[] paginate($object = null, array $settings = [])
 */
class TagsController extends AppController
{


    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $tags = $this->Tags->find('all');

        $this->set('data',  $tags->toArray());
        $this->set('success', true);
        $this->set('message', null);
        $this->set('_serialize', ['data', 'success', 'message']);
    }


    /**
     * @param string $tag
     */
    public function getImageByTagForNow($tag){

        /** @var Tag $tag */
        $tag = $this->Tags->find()->where(['name' => $tag])->first();
        /** @var Image $image */
        $image = $this->Tags->Images->find()->where(['tag_id' => $tag->id])->firstOrFail();
        $data = [
            'previewHeight' => $image->imageWidth,
            'previewWidth' => $image->imageWidth,
            'imageWidth' => $image->imageWidth,
            'imageHeight' => $image->imageWidth,
            'image' => base64_encode(file_get_contents($image->webformatURL)),
            'imaageId' => $image->id
        ];

        //TODO set image as used
        $this->set('data',  $data);
        $this->set('success', true);
        $this->set('message', null);
        $this->set('_serialize', ['data', 'success', 'message']);
    }

    /**
     * View method
     *
     * @param string|null $id Tag id.
     *
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $tag = $this->Tags->get($id, [
            'contain' => ['Images']
        ]);

        $this->set('tag', $tag);
        $this->set('_serialize', ['tag']);
    }




    public function setTags()
    {
        $tags = [
            "fashion",
            "nature",
            "backgrounds",
            "science",
            "education",
            "people",
            "feelings",
            "religion",
            "health",
            "places",
            "animals",
            "industry",
            "food",
            "computer",
            "sports",
            "transportation",
            "travel",
            "buildings",
            "business",
            "music"
        ];

        foreach ($tags as $tag) {
            $tagObj = $this->Tags->newEntity();
            $tagObj->name = $tag;
            $tagObj->active = true;
            $this->Tags->save($tagObj);
        }

    }
}
