<?php

/**
 * ENUTRI: Sistema de Apoio à Gestão da Alimentação Escolar
 * Copyright (c) Renato Uchôa Brandão <contato@renatouchoa.com.br>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 * 
 * @copyright (c)   Renato Uchôa Brandão <contato@renatouchoa.com.br>
 * @since           1.0.0
 * @license         https://www.gnu.org/licenses/gpl-3.0.html GPL v.3
 */

$this->extend('_exercicios');

$this->assign('content-description', 'Remção da UEx do Exercício');

$this->Html->addCrumb('Exercícios', ['action' => 'listar']);
$this->Html->addCrumb(h($participante->exercicio->ano), ['action' => 'visualizar', h($participante->exercicio->id)]);
$this->Html->addCrumb('Remover Participante');

echo $this->Box->create(['class' => 'box-danger']);

echo $this->Box->header([
    'icon' => 'excluir',
    'text' => 'Confirmação da remoção da UEx',
    'toolbar' => [
        'groups' => [
            array(
                'buttons' => [
                    array(
                        'icon' => 'cancelar',
                        'text' => 'Cancelar',
                        'url'  => ['action' => 'visualizar', h($participante->exercicio->id)],
                    )
                ]
            )
        ]
    ]
]);

echo $this->Box->body();

?>

<?= $this->form->create() ?>

<div class="row">
    <div class="col-md-12">
        <div class="alert alert-danger">
            Você deseja remover a UEx <strong> <?= h($participante->uex->nome) ?> </strong>
            do Exercício <strong><?= h($participante->exercicio->ano) ?></strong> ?
            Essa operação apagará todos os Processos.
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <?= $this->form->salvar(['class' => 'btn-danger', 'icon' => 'excluir', 'text' => 'Excluir']) ?>
    </div>
</div>

<?= $this->form->end() ?>

<?= $this->Box->end(); ?>
