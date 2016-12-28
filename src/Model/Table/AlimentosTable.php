<?php

namespace Enutri\Model\Table;

use Cake\Validation\Validator;
use Cake\Event\Event;
use Enutri\Model\Formatting\Number;
use ArrayObject;

class AlimentosTable extends EnutriTable
{
    public function initialize(array $config)
    {
        parent::initialize($config);
        $this->belongsTo('ConsumoMedida', [
            'foreignKey' => 'consumo_medida_id',
            'className'  => 'Medidas',
        ]);
        $this->belongsTo('CompraMedida', [
            'foreignKey' => 'compra_medida_id',
            'className'  => 'Medidas',
        ]);
    }
    
    /**
     * Regras de validação default
     * 
     * @param Cake\Validation\Validator $validator
     * @return Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        parent::validationDefault($validator);
        
        $validator->requirePresence('nome', 'create', 'Informe o nome do alimento');
        $validator->requirePresence('consumo_medida_id', 'create', 'Informe a unidade de medida');
        $validator->requirePresence('compra_medida_id', 'create', 'Informe a unidade de medida');
        
        $validator->notEmpty('nome', 'Preencha o nome do alimento');
        $validator->notEmpty('consumo_medida_id', 'Informe a unidade de medida');
        
        $validator->numeric('fator', 'Valor inválido');
        $validator->numeric('kcal',  'Valor inválido');
        $validator->numeric('cho',   'Valor inválido');
        $validator->numeric('ptn',   'Valor inválido');
        $validator->numeric('lip',   'Valor inválido');
        $validator->numeric('ca',    'Valor inválido');
        $validator->numeric('fe',    'Valor inválido');
        $validator->numeric('mg',    'Valor inválido');
        $validator->numeric('zn',    'Valor inválido');
        $validator->numeric('vita',  'Valor inválido');
        $validator->numeric('vitc',  'Valor inválido');
        
        return $validator;
    }
    
    public function beforeMarshal(Event $event, ArrayObject $data, ArrayObject $options)
    {
        Number::brToFloat($data, [
            'kcal',
            'cho',
            'ptn',
            'lip',
            'ca',
            'fe',
            'mg',
            'zn',
            'vita',
            'vitc',
        ]);
    }
    
    /**
     * Retorna a listagem de alimentos cadastrados ordenados pelo nome
     * 
     * @return Cake\ORM\Query
     */
    public function listar()
    {
        return $this->find('all', [
            'order' => 'Alimentos.nome ASC',
        ]);
    }
    
    /**
     * Retorna o alimento com o id especificado
     * 
     * @param int $alimentoId
     * @return type
     */
    public function localizar($alimentoId)
    {
        return $this->get($alimentoId, [
            'contain' => [
                'ConsumoMedida',
                'CompraMedida',
            ]
        ]);
    }
}