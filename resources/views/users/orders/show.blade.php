@extends('layouts.app')

@section('meta-desc')
    <meta name="description" content="Lorem ipsum dolor sit amet consectetur adipisicing elit. Autem nam veniam tempora fugit fuga pariatur atque maiores consequuntur asperiores dolores! Facere natus vitae odit, quis corporis recusandae ad consectetur numquam!"/>
@endsection

@section('meta-title')
{{ __('Order n°') . $order->id }}
@endsection

@section('breadcrumb')
    <x-breadcrumb-item route="{{ route('users.dashboard') }}" label="{{ __('Account') }}" />
    <x-breadcrumb-item route="{{ route('users.orders.index') }}" label="{{ __('Orders') }}" />
    <x-breadcrumb-item route="{{ route('users.orders.show', $order) }}" label="{{ __('Order n°') . $order->id }}" active />
@endsection

@section('content')

<section class="my-12 min-h-full px-6 py-10 relative">
    <div class="flex flex-col text-center w-full mb-10 md:mb-20">
        <h2 class="text-2xl font-medium title-font mb-4 tracking-widest uppercase">
            {{ __('Order n°') . $order->id }} 
            <span class="text-gray-500">({{ Format::date($order->created_at) }})</span>
        </h2>
        <p class="lg:w-2/3 mx-auto leading-relaxed text-base">
            Whatever cardigan tote bag tumblr hexagon brooklyn asymmetrical gentrify, subway tile poke farm-to-table. Franzen you probably haven't heard of them.
        </p>
    </div>

    <article class="text-right mb-6 md:mb-0">
        <a href="#" class="text-blue-500 hover:underline inline-flex items-center">
            <span class="mdi mdi-file-download-outline mr-2 text-xl"></span>
            {{ __('Download invoice') }}
        </a>
    </article>

    <section class="flex flex-col">
        <article class="flex flex-col pl-3 border-l-2 border-gray-700 w-full pb-3">
            <h3 class="text-xl tracking-widest font-semibold text-gray-700 mb-4">{{ __('Products details') }}</h3>
            <div class="mt-2">
                @foreach ($order->order_items as $item)
                    <div class="p-3 mb-2 bg-gray-200 flex flex-col md:flex-row items-center md:justify-between">
                        <p>
                            @if ($item->product)
                                <a href="{{ route('products.show', $item->product) }}" class="text-blue-500 hover:underline">{{ $item->product->name }}</a>
                            @else
                                {{ $item->name }}
                            @endif
                        </p>
                        <p class="mt-2 md:mt-0">
                            <span class="text-sm text-gray-600">
                                Quantity: {{ $item->quantity }}
                            </span>
                            <span class="md:ml-3">
                                Price: <span class="font-semibold">{{ Format::priceWithTaxAndCurrency($item->price) }}</span>
                            </span>
                        </p>
                    </div>
                @endforeach
            </div>
        </article>
        <div class="flex flex-col md:flex-row justify-between md:my-8">
            <article class="my-6 md:my-0 flex flex-col pl-3 border-l-2 border-gray-700 w-full md:w-1/3 pb-3">
                <h3 class="text-xl tracking-widest font-semibold text-gray-700 mb-4">{{ __('Billing details') }}</h3>
                @if ($order->address)
                <div class="mt-2">
                    <div class="space-y-6">
                        <h3 class="title-font font-medium text-lg text-gray-900 flex items-center uppercase">
                            <span class="mdi mdi-account-details-outline text-gray-600 text-xl font-semibold mr-6" title="User name"></span>
                            {{ $order->address->full_name }}
                            <span class="text-xs text-gray-500 ml-1 normal-case">({{ $order->address->city }}, {{ $order->address->country->name }})</span>
                            @if($order->address->professionnal)
                                <span class="text-xs text-gray-500 ml-1 normal-case">{{ $order->address->company }}</span>
                            @endif
                        </h3>
                        <h4 class="text-gray-500 mb-3 text-sm"></h4>
                        <p class="flex items-center">
                            <span class="mdi mdi-home-city-outline text-gray-600 text-xl font-semibold mr-6" title="address"></span>
                            {{ $order->address->full_address }}
                        </p>
                        <p class="flex items-center">
                            <span class="mdi mdi-cellphone-iphone text-gray-600 text-xl font-semibold mr-6" title="phone number"></span>
                            {{ $order->address->phone }}
                        </p>
                    </div>
                </div>
                @else
                    <p class="text-red-500">{{ __('Address not found') }}</p>
                @endif
            </article>
            <article class="flex flex-col pl-3 border-l-2 border-gray-700 w-full md:w-5/12 pb-3">
                <h3 class="text-xl tracking-widest font-semibold text-gray-700 mb-4">{{ __('Shipping details') }}</h3>
                <div class="space-y-6">
                    <p class="mt-2">
                        <span class="font-semibold text-green-500 rounded-lg p-2 bg-gray-100">{{ $order->state->name }}</span>
                    </p>
                    <p class="flex items-center">
                        <span class="mdi mdi-cash-marker text-gray-600 font-semibold text-xl mr-3"></span>
                        {{ __('Shipping fees') }}: <span class="font-semibold ml-1">{{ Format::priceWithCurrency($order->shipping) }}</span>
                    </p>
                    <p class="flex items-center">
                        <span class="mdi mdi-domain text-gray-600 font-semibold text-xl mr-3"></span>
                        {{ __('Shipping company') }}: <span class="font-semibold ml-1">{{ $order->shipping_company }}</span>
                    </p>
                    <p class="flex items-center">
                        <span class="mdi mdi-truck text-gray-600 font-semibold text-xl mr-3"></span>
                        {{ __('Tracking number') }}: <span class="font-semibold ml-1">{{ $order->reference }}</span>
                    </p>
                </div>
            </article>
        </div>
        <article class="flex flex-col pl-3 border-l-2 border-gray-700 w-full pb-3 mt-8 md:mt-0">
            <h3 class="text-xl tracking-widest font-semibold text-gray-700 mb-4">{{ __('Total') }}</h3>
            <ul class="space-y-4 text-center">
                <li class="px-2 py-3 bg-gray-200">
                    <span class="text-gray-600 mr-2">{{ __('Shipping fees') }}:</span> 
                    <span class="font-semibold">{{ Format::priceWithCurrency($order->shipping) }}</span>
                </li>
                <li class="px-2 py-3 bg-gray-200">
                    <span class="text-gray-600 mr-2">{{ __('Price without taxes') }}:</span> 
                    <span class="font-semibold">{{ Format::priceWithoutTaxAndWithCurrency($order->total) }}</span>
                </li>
                <li class="px-2 py-3 bg-gray-200">
                    <span class="text-gray-600 mr-2">{{ __('Price with taxes') }}:</span> 
                    <span class="font-semibold">{{ Format::priceWithCurrency($order->total) }}</span>
                </li>
                <li class="px-2 py-3 bg-gray-800 text-gray-100">
                    <span class="mr-2">{{ __('Total price with taxes and shipping fees') }}:</span> 
                    <span class="font-semibold">{{ Format::priceWithCurrency($order->price) }}</span>
                </li>
            </ul>
        </article>
    </section>
</section>


@endsection
