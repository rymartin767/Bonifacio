<?php

namespace App\Http\Livewire;

use App\Models\Ame;
use Livewire\Component;

class IndexAmes extends Component
{
    public function deleteAme($id)
    {
        $ame = Ame::find($id);
        $ame->reviews()->delete();
        $ame->delete();
    }

    public function render()
    {
        return view('livewire.index-ames', [
            'ames' => Ame::all()
        ]);
    }
}
