<?php 

namespace App\Models;

use CodeIgniter\Model;

class EventoModel extends Model 
{
    protected $table            =   'eventos';
    protected $primaryKey       =   'id';
    
    protected $allowedFields    =  ['title', 'description', 'start', 'end', 'allDay', 'textColor', 'backgroundColor'];

    protected $useTimestamps    = false;

    protected $validationRules  = [
        'title'              => 'required|alpha_numeric_space|min_length[3]|max_length[65]',
        'description'        => 'permit_empty|alpha_numeric_space|min_length[3]|max_length[120]',
        'start'              => 'required',
        'end'                => 'required',
        'allDay'             => 'required|integer',
        'textColor'          => 'permit_empty|alpha_numeric_punct|min_length[3]|max_length[45]',
        'backgroundColor'    => 'permit_empty|alpha_numeric_punct|min_length[3]|max_length[45]',
    ];

    protected $skipValidation = false;
}