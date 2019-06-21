<?php namespace Visiosoft\DropboxFieldType\Handler;

use Visiosoft\DropboxFieldType\DropboxFieldType;
use Anomaly\UsersModule\User\Contract\UserRepositoryInterface;

/**
 * Class Users
 *
 * @link          http://openclassify.com/
 * @author        OpenClassify, Inc. <support@openclassify.com>
 * @author        Visiosoft Inc <support@openclassify.com>
 */
class Users
{

    /**
     * Handle the options.
     *
     * @param  DropboxFieldType $fieldType
     * @return array
     */
    public function handle(DropboxFieldType $fieldType, UserRepositoryInterface $users)
    {
        $users = $users->all();

        $fieldType->setOptions(
            $users->pluck(
                'email',
                'id'
            )->all()
        );
    }
}
