<?php

namespace App\Filament\Resources\ServicesResource\Pages;

use App\Filament\Resources\ServicesResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditServices extends EditRecord
{
    protected static string $resource = ServicesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        // ambil media yang sudah dipilih, isi ke form
        $data['media'] = $this->record->media()->pluck('media.id')->toArray();

        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $this->mediaIds = $data['media'] ?? [];
        unset($data['media']);

        return $data;
    }

    protected function afterSave(): void
    {
        if (!empty($this->mediaIds)) {
            $this->record->media()->sync($this->mediaIds);
        }
    }
}
