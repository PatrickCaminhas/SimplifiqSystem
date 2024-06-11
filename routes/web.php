<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\CadastroController;
use App\Http\Controllers\DashboardController;


Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::get('logout', [LoginController::class, 'logout'])->name('logout');


Route::get('/cadastro', [CadastroController::class, 'create'])->name('cadastro');
Route::post('/cadastro', [CadastroController::class, 'store']);


Route::get('/', function () {
    return view('index/inicio');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});













Route::match(['get', 'post'],'/cadastroempresaconcluido', function () {
    return view('index/cadastroEmpresaConcluido');
});
Route::match(['get', 'post'],'/cadastrodeproduto', function () {
    return view('cadastrosSistema/cadastroDeProduto');
});
Route::match(['get', 'post'],'/cadastrofornecedor', function () {
    return view('cadastrosSistema/cadastroDeFornecedor');
});
Route::match(['get', 'post'],'/cotacaoprodutos', function () {
    return view('cotacao/cotacaoDeProdutos');
});
Route::match(['get', 'post'],'/cotacaoprodutosrevisao', function () {
    return view('cotacao/cotacaoDeProdutosRevisao');
});
Route::match(['get', 'post'],'/cotacaoprodutosfinal', function () {
    return view('cotacao/cotacaoDeProdutosFinal');
});
Route::match(['get', 'post'],'/cotacaoprodutoseditar', function () {
    return view('cotacao/cotacaoDeProdutosEditar');
});
Route::match(['get', 'post'],'/informacaoproduto', function () {
    return view('produto/informacaoProduto');
});
Route::match(['get', 'post'],'/informacaoprodutorequisicao', function () {
    return view('produto/informacaoProdutoRequisicao');
});
Route::match(['get', 'post'],'/configuracaousuario', function () {
    return view('configuracoes/configuracaoUsuario');
});
Route::match(['get', 'post'],'/ultimasatividades', function () {
    return view('sistema/ultimasAtividades');
});
Route::match(['get', 'post'],'/notificacoes', function () {
    return view('sistema/notificacoes');
});

Route::match(['get', 'post'],'/enviarmensagem', function () {
    return view('sistema/caixaDeMensagensEnviar');
});

Route::match(['get', 'post'],'/dashboard2', function () {
    return view('alternative/dashboard');
});
Route::match(['get', 'post'],'/login2', function () {
    return view('alternative/login');
});