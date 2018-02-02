@extends('layout')

@section('content')
    <section class="issues">
        <div class="columns">
            <div class="column is-half-desktop is-half-widescreen is-half-fullhd">
                <issues :current_page="{{ $current_page }}"></issues>
            </div>
            <div class="column is-hidden-mobile is-hidden-tablet-only is-half-desktop is-half-widescreen is-half-fullhd">
                <div class="banner">
                    <div class="title">Full Stack Developer Task</div>
                    <div class="brand">by</div>
                </div>
            </div>
        </div>
    </section>
@endsection