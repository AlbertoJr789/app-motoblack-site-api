<?php

namespace App\Livewire\Forms;

use App\Models\Endereco;
use Exception;
use Livewire\Attributes\Validate;
use Livewire\Form;

class AddressForm extends Form
{
    public $endereco,
    $cep,
    $logradouro,
    $numero,
    $bairro,
    $complemento,
    $pais,
    $cidade,
    $estado;

}
