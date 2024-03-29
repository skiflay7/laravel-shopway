@extends('layouts.app')

@section('meta-desc')
    <meta name="description" content="Lorem ipsum dolor sit amet consectetur adipisicing elit. Autem nam veniam tempora fugit fuga pariatur atque maiores consequuntur asperiores dolores! Facere natus vitae odit, quis corporis recusandae ad consectetur numquam!"/>
@endsection

@section('meta-title')
    {{ __('Our products') }}
@endsection

@section('breadcrumb')
    <x-breadcrumb-item route="{{ route('products.index') }}" label="{{ __('Products') }}" active />
@endsection

@section('content')

    <section class="bg-white py-6">
        <livewire:products.index />
    </section>
@endsection
