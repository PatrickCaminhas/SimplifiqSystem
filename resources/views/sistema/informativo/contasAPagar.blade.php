<!DOCTYPE html>
<html lang="pt-br">

@include('partials.head', ['data_tables' => true])



<body class="bg-black bg-gradient">
  <!-- Menu superior -->
  @include('partials.header')






    <div class="d-flex align-items-center justify-content-center" style="height: 92vh;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-6 col-8">
                    <div class="card shadow-sm">
                        <div class="card-body" style="overflow-x: auto;">
                            <h2 class="text-center">Contas</h2>
                            <p>Deseja cadastar uma nova conta? <a class ="btn btn-primary"
                                    href="{{ route('contas.create') }}">Clique aqui</a></p>
                            <table id="myTable" class="display">
                                <thead>
                                    <tr>
                                        <th>Credor</th>
                                        <th>Vencimento</th>
                                        <th>Valor</th>
                                        <th>Estado</th>
                                        <th>Ação</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($contas as $conta)
                                        <tr>
                                            <td style="overflow-x: auto;">{{ $conta->credor }}</td>
                                            <td>{{ \Carbon\Carbon::parse($conta->data_vencimento)->format('d/m/Y') }}
                                            </td>
                                            <td>{{ $conta->valor }}</td>
                                            <td>{{ $conta->estado }}</td>
                                            <td>
                                                <form method="GET"
                                                    action="{{ route('contas.update', $conta->id) }}">
                                                    @csrf
                                                    <input type="hidden" name="id"
                                                        value="{{ $conta->id }}">
                                                    <button type="submit" class="btn btn-primary"
                                                        @if ($conta->estado != 'Pendente') disabled @endif>
                                                        Finalizar</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>





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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.2/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.2/js/responsive.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#myTable').DataTable({
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.13.4/i18n/pt-BR.json'
                },
                order: [[1, 'desc']],
            });
        });
    </script>
</body>

</html>
