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

namespace Enutri\Controller;

use Cake\Datasource\Exception\RecordNotFoundException;

/**
 * Controller da gestão de exercícios
 * 
 */
class ExerciciosController extends AppController
{
    /**
     * Action default do controller
     * 
     * @return void
     */
    public function index()
    {
        return $this->redirect(['action' => 'listar']);
    }
    
    /**
     * Listagem dos Exercícios cadastrados
     * 
     * @return void
     */
    public function listar()
    {
        $exercicios = $this->Exercicios->listar();
        $this->set(compact('exercicios'));
    }
    
    /**
     * Visualização das informações de um Exercício
     * 
     * @param int $exercicioId
     * 
     * @return void
     */
    public function visualizar($exercicioId = null)
    {
        try {
            $exercicio = $this->Exercicios->localizar($exercicioId);
            $this->set(compact('exercicio'));
        } catch (RecordNotFoundException $e) {
            $this->Flash->error('Exercício não localizado.');
            return $this->redirect(['action' => 'listar']);
        }
    }
    
    /**
     * Cadastro de novo Exercício
     * 
     * @return void
     */
    public function cadastrar()
    {
        $exercicio = $this->Exercicios->newEntity();
        if ($this->request->is(['post', 'put'])) {
            $this->Exercicios->patchEntity($exercicio, $this->request->data);
            if ($this->Exercicios->save($exercicio)) {
                $this->Flash->success('Exercício cadastrado com sucesso!');
                return $this->redirect(['action' => 'visualizar', h($exercicio->id)]);
            }
            $this->Flash->error('Não foi possível cadastrar o Exercício.');
        }
        $this->set(compact('exercicio'));
    }
    
    /**
     * Edição das informações de um Exercício
     * 
     * @param int $exercicioId
     * 
     * @return void
     */
    public function editar ($exercicioId = null)
    {
        try {
            $exercicio = $this->Exercicios->localizar($exercicioId);
            if ($this->request->is(['post', 'put'])) {
                $this->Exercicios->patchEntity($exercicio, $this->request->data);
                if ($this->Exercicios->save($exercicio)) {
                    $this->Flash->success('As informações do Exercício foram atualizadas.');
                    return $this->redirect(['action' => 'visualizar', h($exercicio->id)]);
                }
                $this->Flash->error('Não foi possível salvar as alterações.');
            }
            $this->set(compact('exercicio'));
        } catch (RecordNotFoundException $e) {
            $this->Flash->error('Exercício não localizado.');
            return $this->redirect(['action' => 'listar']);
        }
    }
    
    /**
     * Exclusão de Exercício
     * 
     * @param int $exercicioId
     * 
     * @return void
     */
    public function excluir ($exercicioId = null)
    {
        try {
            $exercicio = $this->Exercicios->localizar($exercicioId);
            if ($this->request->is(['post', 'put'])) {
                if ($this->Exercicios->delete($exercicio)) {
                    $this->Flash->success('O Exercício foi excluído do sistema.');
                    return $this->redirect(['action' => 'listar']);
                }
                $this->Flash->error('Não foi possível excluir o Exercício.');
            }
            $this->set(compact('exercicio'));
        } catch (RecordNotFoundException $e) {
            $this->Flash->error('Exercício não localizado.');
            return $this->redirect(['action' => 'listar']);
        }
    }
    
    /**
     * Inclusão de UEx participante de um Exercício
     * 
     * @param int $exercicioId
     * 
     * @return void
     */
    public function participanteInserir ($exercicioId = null)
    {
        try {
            
            $exercicio = $this->Exercicios->localizar($exercicioId);
            
            $this->loadModel('Uexs');
            $uexs = $this->Uexs->getList();
            
            // Remove da lista as UEx que já estão participando do Exercício
            foreach ($exercicio->participantes as $participante) {
                if (isset($uexs[$participante->uex_id])) {
                    unset($uexs[$participante->uex_id]);
                }
            }
            
            // Verifica se sobrou alguma UEx para ser incluída no Exercício
            if (count($uexs) < 1) {
                $this->Flash->warning('Todas as UExs já estão participando do Exercício.');
                return $this->redirect(['action' => 'visualizar', h($exercicio->id)]);
            }
            
            $this->loadModel('Participantes');
            $participante = $this->Participantes->newEntity();            

            if ($this->request->is(['post', 'put'])) {
                
                $this->Participantes->patchEntity($participante, $this->request->data);
                $participante->exercicio_id = $exercicio->id;
                
                if ($this->Participantes->save($participante)) {
                    $this->Flash->success('A UEx foi inserida no Exercício.');
                    return $this->redirect(['action' => 'visualizar', h($exercicio->id)]);
                }
                
                $this->Flash->error('Não foi possível salvar as alterações.');
            }
            
            $this->set(compact('exercicio'));
            $this->set(compact('uexs'));
            $this->set(compact('participante'));
            
        } catch (RecordNotFoundException $e) {
            $this->Flash->error('Exercício não localizado.');
            return $this->redirect(['action' => 'listar']);
        }
    }
    
    /**
     * Atualização das informações do Participante de um Exercício
     * 
     * @param int $participanteId
     * 
     * @return void
     */
    public function participanteEditar ($participanteId = null)
    {
        try {
            
            $this->loadModel('Participantes');
            $participante = $this->Participantes->localizar($participanteId);
            
            if ($this->request->is(['post', 'put'])) {
                $this->Participantes->patchEntity($participante, $this->request->data);
                if ($this->Participantes->save($participante)) {
                    $this->Flash->success('As informações do Participante foram atualizadas.');
                    return $this->redirect(['action' => 'visualizar', h($participante->exercicio->id)]);
                }
                $this->Flash->error('Não foi possível salvar as alterações.');
            }
            
            $this->set(compact('participante'));
                    
        } catch (RecordNotFoundException $e) {
            $this->Flash->error('Participante não localizado.');
            return $this->redirect(['action' => 'listar']);
        }
    }
    
    /**
     * Remoção do Participante de um Exercício
     * 
     * @param int $participanteId
     * 
     * @return void
     */
    public function participanteRemover ($participanteId = null)
    {
        try {
            
            $this->loadModel('Participantes');
            $participante = $this->Participantes->localizar($participanteId);
            
            if ($this->request->is(['post', 'put'])) {
                $exercicioId = $participante->exercicio_id;
                if ($this->Participantes->delete($participante)) {
                    $this->Flash->success('A UEx foi removida do Exercício.');
                    return $this->redirect(['action' => 'visualizar', h($exercicioId)]);
                }
                $this->Flash->error('Não foi possível remover a UEx do Exercício.');
            }
            
            $this->set(compact('participante'));
                    
        } catch (RecordNotFoundException $e) {
            $this->Flash->error('Participante não localizado.');
            return $this->redirect(['action' => 'listar']);
        }
    }
}