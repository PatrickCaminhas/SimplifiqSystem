<?php

namespace App\Http\Controllers;

use App\Models\Produtos; // Add this line to import the Produto class
use App\Models\Estoque;
use Illuminate\Http\Request;

class InformacaoProdutosController extends Controller
{
    //
    public function create()
    {
        $produtos = Produtos::all();
        if ($produtos) {
            return view('sistema\produto\informacaoProdutoRequisicao', ['produtos' => $produtos], ['page' => 'produto']);
        } else {
            return redirect('informacaoProdutoRequisicao')->with('error', 'Produto não encontrado.');
        }

    }
    private function sanitizeString($string)
    {
        $string = trim($string); // Remove espaços em branco do início e do fim
        $string = str_replace(
            ['ç', 'ã', 'õ', 'á', 'é', 'í', 'ó', 'ú', 'â', 'ê', 'î', 'ô', 'û', 'à', 'è', 'ì', 'ò', 'ù', 'ä', 'ë', 'ï', 'ö', 'ü', 'ñ'],
            ['c', 'a', 'o', 'a', 'e', 'i', 'o', 'u', 'a', 'e', 'i', 'o', 'u', 'a', 'e', 'i', 'o', 'u', 'a', 'e', 'i', 'o', 'u', 'n'],
            $string
        ); // Substitui caracteres especiais
        $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Remove caracteres especiais
        $string = preg_replace('/\s+/', '', $string); // Remove espaços em branco no meio

        return strtolower($string);
    }
    public function createRead()
    {
        return view('sistema\produto\informacaoProduto', ['page' => 'produto']);
    }

    public function listar($id)
    {
        $produto = Produtos::where('id', $id)->first();
        $estoque = $this->estoqueDoProdutoAoLongoDoTempo($id);
        if ($produto) {
            return view('sistema\produto\informacaoProduto', ['produto' => $produto,'page' => 'produto', 'estoque' => $estoque]);
        } else {
            return redirect('informacaoproduto')->with('error', 'Produto não encontrado.');
        }
    }

    public function buscarProduto(Request $request)
    {
        $termo = $request->input('query');
        $produtos = Produtos::where('nome', 'LIKE', "%{$termo}%")
            ->orWhere('modelo', 'LIKE', "%{$termo}%")
            ->orWhere('marca', 'LIKE', "%{$termo}%")
            ->limit(10)
            ->get();

        $resultados = $produtos->map(function ($produto) {
            return [
                'id' => $produto->id,
                'nome' => $produto->nome,
                'modelo' => $produto->modelo,
                'marca' => $produto->marca
            ];
        });

        return response()->json($resultados);
    }

    public function todosNomes()
    {
        $produtos = Produtos::all();
        if ($produtos) {
            return ['produtos' => $produtos];
        } else {
            return redirect('informacaoproduto')->with('error', 'Produto não encontrado.');
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string',
            'marca' => 'string',
            'modelo' => 'string',
            'categoria' => 'string',
            'unidade_medida' => 'string',
            'medida' => 'string',
            'descricao' => 'string',
        ]);
        $produto = Produtos::create([
            'nome' => $request->input('nome'),
            'marca' => $request->input('marca'),
            'modelo' => $request->input('modelo'),
            'categoria' => $request->input('categoria'),
            'unidade_medida' => $request->input('unidade_medida'),
            'medida' => $request->input('medida'),
            'descricao' => $request->input('descricao'),
            'ultimo_fornecedor' => "Nenhum",
            'quantidade' => 0,
            'preco_compra' => 0,
            'preco_venda' => 0,

        ]);
        if ($produto) {
            return redirect('dashboard')->with('success', 'Cadastro realizado com sucesso!');
        } else {
            return redirect('cadastroproduto')->with('error', 'Erro ao cadastrar produto.');
        }
    }
    public function update(Request $request)
    {
        $request->validate([
            'nome' => 'required|string',
            'marca' => 'string',
            'modelo' => 'string',
            'categoria' => 'string',
            'unidade_medida' => 'string',
            'medida' => 'string',
            'descricao' => 'string',
            'quantidade' => 'string',
            'preco_venda' => 'string',
        ]);
        $produto = Produtos::where('nome', $request->input('nome'))->update([
            'nome' => $request->input('nome'),
            'marca' => $request->input('marca'),
            'modelo' => $request->input('modelo'),
            'categoria' => $request->input('categoria'),
            'unidade_medida' => $request->input('unidade_medida'),
            'medida' => $request->input('medida'),
            'descricao' => $request->input('descricao'),
            'preco_venda' => $request->input('preco_venda'),
        ]);
        if ($produto) {
            return redirect('dashboard')->with('success', 'Alteração de dados produto com sucesso!');
        } else {
            return redirect('cadastroproduto')->with('error', 'Erro ao alterar produto.');
        }
    }
    public function delete(Request $request)
    {
        $produto = Produtos::where('nome', $request->input('nome'))->delete();
        if ($produto) {
            return redirect('dashboard')->with('success', 'Produto deletado com sucesso!');
        } else {
            return redirect('cadastroproduto')->with('error', 'Erro ao deletar produto.');
        }
    }

    public function estoqueDoProdutoAoLongoDoTempo($id){
        $estoque = Estoque::where('id_produto', $id)->get();
        if($estoque){
            return $estoque;
        }else{
            return "sem estoque";;
        }

    }


}

