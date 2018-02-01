@extends('layout')

@section('content')
    <section class="login">
        <a href="{{ url('') }}" class="logo" title="FullStack Party"></a>
        <a href="{{ route('github.login') }}" class="button is-success">Login With GitHub</a>
    </section>
@endsection
