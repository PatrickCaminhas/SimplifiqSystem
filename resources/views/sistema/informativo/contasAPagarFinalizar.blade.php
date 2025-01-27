<!DOCTYPE html>
<html lang="pt-br">
    @include('partials.head', ['data_tables' => true])




<body class="bg-black bg-gradient">
  <!-- Menu superior -->
  @include('partials.header')






    <div class="d-flex align-items-center justify-content-center " style="height: 92vh;">
        <div class="container mt-5 col-lg-6 col-md-8 col-sm-12 col-12 ">
            <div class="row align-items-center justify-content-center">
                <div class="card">
                    <div class="card-body">
                        <div class="container">
                            <div class="row justify-content-center">
                                <div class="card-body ">
                                    <h2 class="text-center">Finalizar conta</h2>
                                    <div>
                                        <form action="{{ route('contas.finalizarConta') }}" method="POST">
                                            @csrf
                                            <p> Credor: {{ $conta->id }}</p>
                                            <input type="hidden" name="id" value="{{ $conta->id }}">
                                            <p> Credor: {{ $conta->credor }}</p>
                                            <p> Valor: {{ $conta->valor }}</p>
                                            <p> Tipo: {{ $conta->tipo }}</p>
                                            <p> Data de vencimento: {{ \Carbon\Carbon::parse($conta->data_vencimento)->format('d/m/Y') }}
                                            </p>
                                                <div class="form-floating mb-3">
                                                    <select class="form-select" id="estado" name="estado">
                                                        <option selected disabled>Selecione o tipo de ação
                                                        </option>
                                                        <option value="Cancelada">Cancelar/Erro</option>
                                                        <option value="Paga">Conta paga</option>
                                                        <option value="Vencida">Vencida</option>
                                                    </select>
                                                    <label>Tipo:</label>
                                                </div>
                                                <div class="text-center mt-3">
                                                    <button type="submit" class="btn @include('partials.buttomCollor')">Finalizar</button>
                                                </div>
                                        </form>
                                        @if ($errors->any())
                                            <div class="alert alert-danger mt-3">

                                                @foreach ($errors->all() as $error)
                                                    {{ $error }}
                                                @endforeach

                                            </div>
                                        @endif


                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Features Section -->

    <!-- Inclua os arquivos JavaScript do Bootstrap -->

    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
        crossorigin="anonymous"></script>
    @vite('resources/js/app.js')
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.2/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.2/js/responsive.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#myTable').DataTable({
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.13.4/i18n/pt-BR.json'
                },
            });
        });
    </script>
</body>

</html>
