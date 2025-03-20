<?php

namespace App\Forms\Components;

use Filament\Forms\Components\Field;

class CameraCapture extends Field
{
    protected string $view = 'forms.components.camera-capture';

    protected function setUp(): void
    {
        parent::setUp();

        $this->dehydrated(false); // This field doesn't need to be saved directly to the model
    }
}
