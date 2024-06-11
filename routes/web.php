<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\CadastroController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CadastroProdutos;
use App\Http\Controllers\InformacaoProdutosController;


use App\Http\Middleware\AuthenticateDashboard;


Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::get('logout', [LoginController::class, 'logout'])->name('logout');


Route::get('/cadastro', [CadastroController::class, 'create'])->name('cadastro');
Route::post('/cadastro', [CadastroController::class, 'store']);
Route::match(['get', 'post'], '/cadastroempresaconcluido', function () {
    return view('index/cadastroEmpresaConcluido');
});

Route::get('/', function () {
    return view('index/inicio');
});

Route::middleware(AuthenticateDashboard::class)->name('dashboard')->match(['get', 'post'], '/dashboard', function () {
    return view('sistema/dashboard');
});;



Route::middleware([AuthenticateDashboard::class])->group(function () {
    Route::get('/cadastroproduto', [CadastroProdutos::class, 'create'])->name('cadastroproduto');
    Route::post('/cadastroproduto', [CadastroProdutos::class, 'store'])->name('cadastroproduto.store');

    Route::get('/informacaoproduto', [InformacaoProdutosController::class, 'createRead'])->name('produto.informacao');
    Route::get('/informacaoproduto/{nome}', [InformacaoProdutosController::class, 'listar'])->name('produto.listar.nome');
    Route::get('/informacaoprodutorequisicao', [InformacaoProdutosController::class, 'create'])->name('produto.listar');

 


});

Route::middleware(AuthenticateDashboard::class)->match(['get', 'post'], '/cadastrofornecedor', function () {
    return view('cadastrosSistema/cadastroDeFornecedor');
});
Route::middleware(AuthenticateDashboard::class)->match(['get', 'post'], '/cotacaoprodutos', function () {
    return view('cotacao/cotacaoDeProdutos');
});
Route::middleware(AuthenticateDashboard::class)->match(['get', 'post'], '/cotacaoprodutosrevisao', function () {
    return view('cotacao/cotacaoDeProdutosRevisao');
});
Route::middleware(AuthenticateDashboard::class)->match(['get', 'post'], '/cotacaoprodutosfinal', function () {
    return view('cotacao/cotacaoDeProdutosFinal');
});
Route::middleware(AuthenticateDashboard::class)->match(['get', 'post'], '/cotacaoprodutoseditar', function () {
    return view('cotacao/cotacaoDeProdutosEditar');
});

Route::middleware(AuthenticateDashboard::class)->match(['get', 'post'], '/configuracaousuario', function () {
    return view('configuracoes/configuracaoUsuario');
});
Route::middleware(AuthenticateDashboard::class)->match(['get', 'post'], '/ultimasatividades', function () {
    return view('sistema/ultimasAtividades');
});
Route::middleware(AuthenticateDashboard::class)->match(['get', 'post'], '/notificacoes', function () {
    return view('sistema/notificacoes');
});

Route::middleware(AuthenticateDashboard::class)->match(['get', 'post'], '/enviarmensagem', function () {
    return view('sistema/caixaDeMensagensEnviar');
});

Route::middleware(AuthenticateDashboard::class)->match(['get', 'post'], '/dashboard2', function () {
    return view('alternative/dashboard');
});
Route::match(['get', 'post'], '/login2', function () {
    return view('alternative/login');
});
