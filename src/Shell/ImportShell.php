<?php
namespace App\Shell;

use Cake\Console\Shell;

/**
 * Import shell command.
 *
 * @property \App\Model\Table\TagsTable $Tags
 * @property \App\Model\Table\ImagesTable $Images
 */
class ImportShell extends Shell
{

    public $apiUrl;

    public function initialize()
    {
        $this->loadModel('Tags');
        $this->loadModel('Images');
    }


    public function run(){

    }

    public function setTags(){
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

        foreach ($tags as $tag){
            $tagObj = $this->Tags->newEntity();
            $tagObj->name = $tag;
            $tagObj->active = true;
            $this->Tags->save($tagObj);
        }

    }

    public function getPixabayImage(){

        //TODO set key to var
        $this->apiUrl = "https://pixabay.com/api/?key=6025170-3537519008d7fe43504b076cc";



    }
}
