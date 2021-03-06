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

$this->extend('_usuarios');

$this->assign('content-description', 'Informações do Usuário');

$this->Html->addCrumb('Usuários', ['action' => 'listar']);
$this->Html->addCrumb(h($usuario->nome));

echo $this->Box->create();

echo $this->Box->header([
    'icon' => 'info',
    'text' => 'Informações do Usuário',
    'toolbar' => [
        'groups' => [
            array(
                'buttons' => [
                    array(
                        'text' => 'Listar Usuários',
                        'icon' => 'voltar',
                        'url'  => ['action' => 'listar'],
                    )
                ]
            ),
            array(
                'buttons' => [
                    array(
                        'text' => 'Alterar Senha',
                        'icon' => 'senha',
                        'url'  => [
                            'action' => 'alterar_senha',
                            h($usuario->id),
                        ],
                    )
                ]
            ),
            array(
                'buttons' => [
                    array(
                        'text' => 'Editar',
                        'icon' => 'editar',
                        'url'  => ['action' => 'editar', h($usuario->id)],
                    ),
                    array(
                        'title' => 'Mais opções',
                        'dropdown' => [
                            'items' => [
                                array(
                                    'text' => 'Lotar Usuário',
                                    'icon' => 'inserir',
                                    'url'  => [
                                        'action' => 'lotacao_cadastrar',
                                        h($usuario->id)
                                    ],
                                ),
                                array(
                                    'type' => 'separator',
                                ),
                                array(
                                    'text' => 'Redefinir Senha',
                                    'icon' => 'senha',
                                    'url'  => [
                                        'action' => 'redefinir_senha',
                                        h($usuario->id)
                                    ],
                                ),
                                array(
                                    'text' => 'Excluir',
                                    'icon' => 'excluir',
                                    'url'  => [
                                        'action' => 'excluir',
                                        h($usuario->id)
                                    ],
                                ),
                            ]
                        ]
                    )
                ]
            )
        ]
    ]
]);

echo $this->Box->body();

?>

<div class="row">
    <div class="col-md-5">
        <?= $this->Data->display('Grupo', h($usuario->grupo->nome)) ?>
    </div>
    <div class="col-md-7">
        <?= $this->Data->display('Nome Completo', h($usuario->nome)) ?>
    </div>
</div>
<div class="row">
    <div class="col-md-9">
        <?= $this->Data->display('Email', h($usuario->email)) ?>
    </div>
    <div class="col-md-3">
        <?= $this->Data->display('CRN', h($usuario->crn)) ?>
    </div>
</div>
<div class="row">
    <div class="col-md-8">
        <?= $this->Data->display('Endereço', h($usuario->endereco)) ?>
    </div>
    <div class="col-md-4">
        <?= $this->Data->display('CRN', h($usuario->bairro)) ?>
    </div>
</div>
<div class="row">
    <div class="col-md-4">
        <?= $this->Data->display('Município', h($usuario->municipio)) ?>
    </div>
    <div class="col-md-2">
        <?= $this->Data->display('UF', h($usuario->uf->sigla)) ?>
    </div>
    <div class="col-md-3">
        <?= $this->Data->display('Telefone', h($usuario->telefone1)) ?>
    </div>
    <div class="col-md-3">
        <?= $this->Data->display('Celular', h($usuario->telefone2)) ?>
    </div>
</div>

<fieldset>
    <legend>Lotações</legend>
    
    <?php if(count($usuario->lotacoes) < 1): ?>

        <div class="alert alert-info">
            Usuário não lotado em nenhuma Unidade Executora.
        </div>

    <?php else: ?>
    
    <table class="table table-hover">
        <thead>
            <tr>
                <th>
                    Unidade Executora
                </th>
                <th class="options">
                    Opções
                </th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($usuario->lotacoes as $lotacao): ?>
                <tr>
                    <td>
                        <?= $lotacao->uex->nome_reduzido ?>
                    </td>
                    <td class="options">
                        <?=
                            $this->Options->make([
                                array(
                                    'url'   => ['action' => 'lotacao-excluir', h($lotacao->id)],
                                    'icon'  => 'excluir',
                                    'title' => 'Remover Lotação',
                                ),
                            ]);
                        ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    
    <?php endif; ?>
    
</fieldset>


<?php

echo $this->Box->end();
