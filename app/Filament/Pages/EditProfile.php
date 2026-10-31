<?php

namespace App\Filament\Pages;

use Filament\Actions\Action;
use Filament\Auth\Pages\EditProfile as BaseEditProfile;

class EditProfile extends BaseEditProfile
{
    protected function getSaveFormAction(): Action
    {
        return parent::getSaveFormAction()
            ->label('Submit');
    }
}
