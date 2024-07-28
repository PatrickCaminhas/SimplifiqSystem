<?php

declare(strict_types=1);

use App\Http\Controllers\ContasController;
use App\Http\Middleware\RedirectIfAuthenticated;
use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CadastroProdutos;
use App\Http\Controllers\FornecedorController;
use App\Http\Controllers\InformacaoProdutosController;
use App\Http\Controllers\ConfiguracoesController;
use App\Http\Controllers\EstoqueController;
use App\Http\Middleware\AuthenticateDashboard;
use App\Http\Middleware\CheckCompanyType;

/*
|--------------------------------------------------------------------------
| Tenant Routes
|--------------------------------------------------------------------------
|
| Here you can register the tenant routes for your application.
| These routes are loaded by the TenantRouteServiceProvider.
|
| Feel free to customize them however you want. Good luck!
|
*/

Route::middleware([
    'web',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function () {
    Route::get('login', [LoginController::class, 'showLoginFormTenant'])->name('login');
    Route::post('login', [LoginController::class, 'login']);
    Route::get('/', [LoginController::class, 'showLoginFormTenant'])->name('login');


    Route::middleware([AuthenticateDashboard::class, CheckCompanyType::class])->group(function () {


        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        Route::get('/cadastroproduto', [CadastroProdutos::class, 'create'])->name('cadastroproduto');
        Route::post('/cadastroproduto', [CadastroProdutos::class, 'store'])->name('cadastroproduto.store');

        Route::get('/informacaoproduto', [InformacaoProdutosController::class, 'createRead'])->name('produto.informacao');
        Route::get('/informacaoproduto/{nome}', [InformacaoProdutosController::class, 'listar'])->name('produto.listar.nome');
        Route::get('/informacaoprodutorequisicao', [InformacaoProdutosController::class, 'create'])->name('produto.listar');
        Route::get('alterarinformacoesproduto', [InformacaoProdutosController::class, 'update'])->name('produto.alterar');

        Route::get('/cadastrofornecedor', [FornecedorController::class, 'create'])->name('cadastrofornecedor');
        Route::post('/cadastrofornecedor', [FornecedorController::class, 'store'])->name('cadastrofornecedor.store');

        Route::get('/configuracoes', [ConfiguracoesController::class, 'createConfiguracoes'])->name('configuracoes');
        Route::get('/alterarSenha', [ConfiguracoesController::class, 'createAlterarSenha'])->name('configuracoes.senha');
        Route::post('/alterarSenhaConfirmar', [ConfiguracoesController::class, 'update'])->name('configuracoes.senha.alterar');

        Route::get('/cadastrarfuncionario', [ConfiguracoesController::class, 'createCadastroFuncionario'])->name('configuracoes.funcionario');
        Route::post('/cadastrarfuncionarioconfirmar', [ConfiguracoesController::class, 'storeFuncionario'])->name('configuracoes.funcionario.cadastrar');

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
        Route::get('/estoque', [EstoqueController::class, 'create'])->name('estoque.create');
        Route::post('/estoque', [EstoqueController::class, 'edit'])->name('estoque.edit');
        Route::get('/estoque/{id}', [EstoqueController::class, 'edit'])->name('estoque.edit');
        Route::post('/estoque/{id}',[EstoqueController::class,'update'])->name('estoque.update');
        Route::get('/contas',[ContasController::class,'createRead'])->name('contas.read');
        Route::get('/contas/cadastro',[ContasController::class,'create'])->name('contas.create');
        Route::post('/contas/cadastro',[ContasController::class,'createConta'])->name('contas.createConta');
        Route::get('/contas/finalizar',[ContasController::class,'update'])->name('contas.update');
        Route::post('/contas/finalizar',[ContasController::class,'finalizarConta'])->name('contas.finalizarConta');
        Route::get('logout', [LoginController::class, 'logout'])->name('logout');
    });
});

