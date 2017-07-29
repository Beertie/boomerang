<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Image Entity
 *
 * @property int $id
 * @property string $name
 * @property int $tag_id
 * @property string $tags
 * @property int $webformatHeight
 * @property int $webformatWidth
 * @property int $previewHeight
 * @property int $previewWidth
 * @property int $views
 * @property int $comments
 * @property int $downloads
 * @property string $pageURL
 * @property string $previewURL
 * @property string $webformatURL
 * @property int $imageWidth
 * @property int $imageHeight
 * @property string $type
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Tag $tag
 * @property \App\Model\Entity\Resource[] $resources
 * @property \App\Model\Entity\User[] $users
 */
class Image extends Entity
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
        '*' => true,
        'id' => false
    ];
}
