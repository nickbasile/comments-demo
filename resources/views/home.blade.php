@extends('layouts.app')

@section('content')
    <comments-manager :user="{{ auth()->user() }}"></comments-manager>
@endsection
