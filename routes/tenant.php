<?php

declare(strict_types=1);

use App\Http\Controllers\ContasController;
use App\Http\Controllers\InformacaoEmpresaController;
use App\Http\Controllers\ServicosController;
use App\Http\Controllers\Auth\CadastroController;
use App\Http\Middleware\CheckMetas;
use App\Http\Middleware\RedirectIfAuthenticated;
use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\FornecedorController;
use App\Http\Controllers\InformacaoProdutosController;
use App\Http\Controllers\ConfiguracoesController;
use App\Http\Controllers\EstoqueController;
use App\Http\Middleware\AuthenticateDashboard;
use App\Http\Controllers\MetasController;
use App\Http\Controllers\CotacoesController;
use App\Http\Controllers\SimplesNacionalController;
use App\Http\Controllers\VendasController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\FaturamentoController;
use App\Http\Controllers\Auth\SenhaResetController;

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
    Route::post('/handle-login', [LoginController::class, 'handleSubdomainLogin'])->name('handle-login')->middleware('web');
    Route::get('/handle-login', [LoginController::class, 'handleSubdomainLogin'])->name('handle-login')->middleware('web');

    Route::post('/redirect-post', [LoginController::class, 'redirectPost'])->name('redirect-post');

    Route::get('password/reset', [SenhaResetController::class, 'requestForm'])->name('password.request');
    Route::post('password/email', [SenhaResetController::class, 'sendResetLink'])->name('password.email');
    Route::get('password/reset/{token}', [SenhaResetController::class, 'resetForm'])->name('password.reset');
    Route::post('password/reset', [SenhaResetController::class, 'resetPassword'])->name('password.update');

    Route::get('/login_second', [LoginController::class, 'formularioLoginTenant'])->name('tenant.login');
    Route::post('/login_second', [LoginController::class, 'loginTenant'])->name('tenant.login');


    Route::middleware([AuthenticateDashboard::class])->group(function () {

        Route::get('/testeHome', function () {
            return view('testeHome');
        });

        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        Route::get('/cadastros', [DashboardController::class, 'cadastros'])->name('cadastros');

        Route::get('/cadastroproduto', [ProdutoController::class, 'create'])->name('produto.create');

        Route::post('/cadastroproduto', [ProdutoController::class, 'store'])->name('cadastroproduto.store');

        Route::get('/informacaoproduto', [InformacaoProdutosController::class, 'createRead'])->name('produto.informacao');
        // Route::get('/informacaoproduto/{nome}', [InformacaoProdutosController::class, 'listar'])->name('produto.listar.nome');
        Route::get('/informacaoproduto/{id}', [InformacaoProdutosController::class, 'listar'])->name('produto.listar.id');

        Route::get('/buscar-produto', [InformacaoProdutosController::class, 'buscarProduto']);
        Route::get('/informacaoprodutorequisicao', [InformacaoProdutosController::class, 'create'])->name('produto.listar');
        Route::get('alterarinformacoesproduto', [InformacaoProdutosController::class, 'update'])->name('produto.alterar');

        Route::get('/produto/editar/{id}', [ProdutoController::class, 'createAtualizarDadosProduto'])->name('produto.edit');
        Route::post('/produto/editar', [ProdutoController::class, 'atualizarDadosProduto'])->name('produto.edit.store');
        Route::get('/produto/preco/{id}', [ProdutoController::class, 'createAtualizarPrecoProduto'])->name('produto.preco');
        Route::post('/produto/preco', [ProdutoController::class, 'atualizarPrecoProduto'])->name('produto.preco.store');

        Route::get('/produto/categoria/cadastro', [ProdutoController::class, 'createCadastroCategoria'])->name('produto.categoria');
        Route::post('/produto/categoria/cadastro', [ProdutoController::class, 'storeCategoria'])->name('produto.categoria.store');

        Route::get('/cadastroFornecedor', [FornecedorController::class, 'create'])->name('fornecedor.create');
        Route::post('/cadastroFornecedor', [FornecedorController::class, 'store'])->name('fornecedor.store');
        Route::get('/fornecedores', [FornecedorController::class, 'read'])->name('fornecedores');
        Route::post('/fornecedores/editar', [FornecedorController::class, 'edit'])->name('fornecedores.edit');
        Route::post('/fornecedores/editar/store', [FornecedorController::class, 'update'])->name('fornecedores.edit.store');

        Route::get('/configuracoes', [ConfiguracoesController::class, 'createConfiguracoes'])->name('configuracoes');
        Route::get('/alterarSenha', [ConfiguracoesController::class, 'createAlterarSenha'])->name('configuracoes.senha');
        Route::post('/alterarSenhaConfirmar', [ConfiguracoesController::class, 'alterarSenha'])->name('configuracoes.senha.alterar');
        Route::get('/alterarDadosPessoais', [ConfiguracoesController::class, 'createAlteraDadosPessoais'])->name('configuracoes.dados');
        Route::post('/alterarDadosPessoais', [ConfiguracoesController::class, 'alterarDadosPessoais'])->name('configuracoes.dados.alterar');
        Route::get('/cadastrarfuncionario', [ConfiguracoesController::class, 'createCadastroFuncionario'])->name('configuracoes.funcionario');
        Route::post('/cadastrarfuncionarioconfirmar', [CadastroController::class, 'cadastrarNovoFuncionarioEmpresaExiste'])->name('configuracoes.funcionario.cadastrar');
        Route::get('/alterarCargos', [ConfiguracoesController::class,'createAlterarCargos'])->name('configuracoes.cargos');
        Route::post('/alterarCargos', [ConfiguracoesController::class, 'alterarCargos'])->name('configuracoes.cargos.alterar');
        Route::get('/excluirFuncionario', [ConfiguracoesController::class, 'createExcluirFuncionario'])->name('configuracoes.excluir');
        Route::post('/excluirFuncionario', [ConfiguracoesController::class, 'excluirFuncionario'])->name('configuracoes.funcionario.excluir');

        // Route::get('/cotacaoprodutos',[CotacoesController::class, 'create'])->name('cotacaoProdutos');
        Route::get('/cotacaoprodutos', [CotacoesController::class, 'createLista'])->name('cotacaoProdutos');
        Route::get('/cotacao/lista', [CotacoesController::class, 'createLista'])->name('cotacao.lista');
        Route::post('/cotacao/produtos-selecionados', [CotacoesController::class, 'processarProdutosSelecionados'])->name('cotacao.produtos.selecionados');
        Route::post('/cotacao/inserir', [CotacoesController::class, 'inserirCotacao'])->name('inserir.cotacao');
        Route::get('/cotacao/resultados/{id_cotacao}', [CotacoesController::class, 'mostrarResultados'])->name('cotacao.resultados');

        Route::post('/cotacaoprodutosrevisao', [CotacoesController::class, 'createRevisao'])->name('cotacaoProdutosRevisao');
        Route::post('/cotacaoprodutosfinal', [CotacoesController::class, 'createFinal'])->name('cotacaoProdutosFinal');
        Route::post('/cotacaoprodutoseditar', [CotacoesController::class, 'createEdicao'])->name('cotacaoProdutosEditar');



        Route::get('/estoque', [EstoqueController::class, 'create'])->name('estoque.create');
        //Route::post('/estoque', [EstoqueController::class, 'edit'])->name('estoque.edit');
        //Route::get('/estoque/{id}', [EstoqueController::class, 'edit'])->name('estoque.edit');
        Route::get('/estoque/{id}', [EstoqueController::class, 'update'])->name('estoque.update');
        Route::post('/estoque', [EstoqueController::class, 'update'])->name('estoque.update');
        Route::get('/estoque/recente/{id}', [EstoqueController::class, 'getEstoqueRecente'])->name('estoque.recente');

        Route::get('/contas', [ContasController::class, 'createRead'])->name('contas.read');
        Route::get('/contas/cadastro', [ContasController::class, 'create'])->name('contas.create');
        Route::post('/contas/cadastro', [ContasController::class, 'store'])->name('contas.store');
        Route::get('/contas/finalizar', [ContasController::class, 'update'])->name('contas.update');
        Route::post('/contas/finalizar', [ContasController::class, 'finalizarConta'])->name('contas.finalizarConta');

        Route::middleware([CheckMetas::class])->group(function () {
            Route::get('/metas', [MetasController::class, 'createRead'])->name('metas.read');
        });
        Route::get('/metas/cadastro', [MetasController::class, 'createStoreMeta'])->name('metas.create');
        Route::post('/metas/cadastro', [MetasController::class, 'store'])->name('metas.store');
        Route::post('/metas', [MetasController::class, 'storeProgresso'])->name('metas.storeProgresso');
        Route::get('/metas/informacoes', [MetasController::class, 'createInformacoes'])->name('metas.informacoes');
        Route::post('/metas/informacoes', [MetasController::class, 'createInformacoes'])->name('metas.informacoes');

        Route::get('/servicos', [ServicosController::class, 'createRead'])->name('servicos.read');
        Route::get('/servicos/cadastro', [ServicosController::class, 'createStoreServico'])->name('servicos.create');
        Route::post('/servicos/cadastro', [ServicosController::class, 'store'])->name('servicos.store');
        Route::get('/servicos/cadastro/tipo', [ServicosController::class, 'createTipoRead'])->name('servicos.tipo.read');
        Route::post('/servicos/cadastro/tipo', [ServicosController::class, 'storeTipo'])->name('servicos.tipo.store');
        Route::post('/servicos/finalizar', [ServicosController::class, 'finalizarServico'])->name('servicos.finalizar');
        Route::post('/servicos/cancelar', [ServicosController::class, 'cancelarServico'])->name('servicos.cancelar');

        //Route::get('/tarefas', [ServicosController::class, 'createReadTarefas'])->name('tarefas.read');
        //Route::get('/tarefas/cadastro', [ServicosController::class, 'createStoreTarefas'])->name('tarefas.create');

        Route::get('/informacoes/empresa', [InformacaoEmpresaController::class, 'createRead'])->name('informacoes.empresa');

        Route::get('/cliente/cadastro', [ClienteController::class, 'create'])->name('cliente.store.create');
        Route::post('/cliente/cadastro/store', [ClienteController::class, 'store'])->name('cliente.store');
        Route::get('/clientes', [ClienteController::class, 'read'])->name('cliente.read.all');
        Route::post('/Clientes/editar', [ClienteController::class, 'edit'])->name('cliente.edit');
        Route::post('/Clientes/editar/store', [ClienteController::class, 'update'])->name('cliente.update.store');
        Route::post('/Clientes/quitar', [ClienteController::class, 'quitarDividaView'])->name('cliente.quitar.view');
        Route::post('/Clientes/quitar/store', [ClienteController::class, 'quitarDividaStore'])->name('cliente.quitar');

        Route::get('/vendas/create', [VendasController::class, 'create'])->name('vendas.create');
        Route::get('/produtos/search', [ProdutoController::class, 'search'])->name('produtos.search');
        Route::post('/vendas/store', [VendasController::class, 'store'])->name('vendas.store');
        Route::get('/vendas', [VendasController::class, 'info'])->name('vendas.info');


        Route::get('/faturamento', [FaturamentoController::class, 'create'])->name('faturamento.create');
        Route::post('/faturamento', [FaturamentoController::class, 'store'])->name('faturamento.store');
        Route::get('/faturamento/exibir', [FaturamentoController::class, 'read'])->name('faturamento.read');
        Route::post('/faturamento/editar', [FaturamentoController::class, 'update'])->name('faturamento.update');


        Route::get('/calcularSimples', [SimplesNacionalController::class, 'createCalculadora'])->name('simples.create.calculadora');
        Route::post('/calcularSimples', [SimplesNacionalController::class, 'calculate'])->name('simples.calculate');

        Route::get('logout', [LoginController::class, 'logout'])->name('logout');
    });
});

