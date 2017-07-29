<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * UsersHasImage Entity
 *
 * @property int $user_id
 * @property int $images_id
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Image $image
 */
class UsersHasImage extends Entity
{

}
