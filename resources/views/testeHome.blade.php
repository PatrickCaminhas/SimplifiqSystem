@extends('layouts.master')

@section('title', 'Página Inicial')

@push('styles')
    <link rel="stylesheet" href="home.css">
@endpush

@section('content')
    <h1>Bem-vindo!</h1>
    <p>Essa é a página inicial do sistema.</p>
@endsection
