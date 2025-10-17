<?php

namespace App\Filament\Resources\Movimentos\Pages;

use App\Filament\Resources\Movimentos\MovimentoResource;
use Filament\Resources\Pages\CreateRecord;
use App\Models\Produto;
use Filament\Notifications\Notification;


class CreateMovimento extends CreateRecord
{
    protected static string $resource = MovimentoResource::class;

    protected function beforeCreate(): void
    {
        $data = $this -> data;
        $produto = Produto :: find ($data['produto_id']);
        $quantidadeMovimento = (int) $data ['quantidade'];



        if ($data ['tipo']=== 's' && $produto -> estoque < $quantidadeMovimento) {
            Notification::make()
            ->warning()
            ->title('Aviso')
            ->body('Sem estoque')
            ->persistent()

            ->send();

        $this->halt();
        }
    }

    protected function afterCreate(): void
    {
        $movimento = $this -> getRecord();
        $produto = $movimento -> produto;

        if($movimento -> tipo === 'e'){
            $produto -> increment('estoque', $movimento -> quantidade);
        }else{
            $produto -> decrement ('estoque', $movimento -> quantidade);
        }
    }
}
