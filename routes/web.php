<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InstituicaoController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('/', function () {
  //  return view('welcome');
//});

Route::get('/painel', [InstituicaoController::class, 'index'])->name('painel');
Route::get('/painel/dados', [InstituicaoController::class, 'dadosPainel'])->name('dados_painel');

Route::get('/cursos', [InstituicaoController::class, 'cursos'])->name('cursos');
Route::get('/cursos/listagem', [InstituicaoController::class, 'listaCursos'])->name('lista_cursos');
Route::post('/cursos/instituicao_cursos', [InstituicaoController::class, 'cursosInstituicao'])->name('instituicao_cursos');

Route::get('/matriculas', [InstituicaoController::class, 'matriculas'])->name('matriculas');
Route::get('/matriculas/listagem_alunos', [InstituicaoController::class, 'listaAlunos'])->name('lista_alunos');