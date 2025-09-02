<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;

class Marca extends Model
{
    //
    use HasFactory;
    protected $fillable = ['nome', 'imagem'];

    public function rules(){
        return [
       'nome' => [
            'required',
            'min:3',
            Rule::unique('marcas', 'nome')->ignore($this->id) // ignora o id no update
        ],
        'imagem' => 'required|file|mimes:png,jpeg'
        ];
    }

    public function feedback(){
        return [
            'required' => 'o Campo :attribute é obrigatório',
            'nome.unique' => 'o Campo :attribute já existe',
            'imagem.mimes' => 'O arquivo deve ser dos tipos: png ou jpeg'
        ];
    }
}
