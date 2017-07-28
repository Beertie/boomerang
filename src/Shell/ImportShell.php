<?php

namespace App\Shell;

use App\Model\Entity\Image;
use App\Model\Entity\Tag;
use Cake\Console\Shell;

/**
 * Import shell command.
 *
 * @property \App\Model\Table\TagsTable   $Tags
 * @property \App\Model\Table\ImagesTable $Images
 */
class ImportShell extends Shell
{

    public $apiUrl;

    public $perPage = 10;

    public function initialize()
    {
        $this->loadModel('Tags');
        $this->loadModel('Images');
    }


    public function run()
    {

        //TODO set key to var
        $this->apiUrl = "https://pixabay.com/api/?key=6025170-3537519008d7fe43504b076cc&per_page=" . $this->perPage;

        $tags = $this->getTags();

        foreach ($tags as $tag) {

            $this->getImagesByTag($tag);
        }
    }


    public function getTags()
    {
        return $this->Tags->find()->toArray();
    }

    /**
     * @param Tag $tag
     */
    public function getImagesByTag($tag)
    {

        $more = true;
        $round = 1;
        while ($more) {
            $listOfImages = json_decode(file_get_contents($this->apiUrl . "&category=" . $tag->name));

            foreach ($listOfImages->hits as $hit) {
                $this->saveImage($hit, $tag);
            }

            //TODO remove for testing
            $more = false;

            // to get all img
            if (($round * $this->perPage) < $listOfImages->total) {
                $more = false;
            }

            $round++;
        }

    }

    /**
     * @param $data
     * @param Tag $tag
     */
    public function saveImage($data, $tag)
    {
        $image = $this->Images->newEntity();
        $image->tags = isset($data->tags) ? $data->tags : null;
        $image->webformatHeight = isset($data->webformatHeight) ? $data->webformatHeight : null;
        $image->webformatWidth = isset($data->webformatWidth) ? $data->webformatWidth : null;
        $image->previewHeight = isset($data->previewHeight) ? $data->previewHeight : null;
        $image->previewWidth = isset($data->previewWidth) ? $data->previewWidth : null;
        $image->views = isset($data->views) ? $data->views : null;
        $image->comments = isset($data->comments) ? $data->comments : null;
        $image->downloads = isset($data->downloads) ? $data->downloads : null;
        $image->previewURL = isset($data->previewURL) ? $data->previewURL : null;
        $image->pageURL = isset($data->pageURL) ? $data->pageURL : null;
        $image->webformatURL = isset($data->webformatURL) ? $data->webformatURL : null;
        $image->imageWidth = isset($data->imageWidth) ? $data->imageWidth : null;
        $image->type = isset($data->type) ? $data->type : null;
        $image->tag_id = $tag->id;
        $this->Images->save($image);
        $this->getImageAndSave($image);
    }

    /**
     * @param Image $image
     */
    public function getImageAndSave($image)
    {
        $imageData = file_get_contents("https://pixabay.com/get/eb30b3062ff5053ed95c4518b74a4694e676e5d504b0144194f2c670a6ecbc_640.jpg");
        $image->image = $imageData;
        $this->Images->save($image);
        echo ".";
    }
}
