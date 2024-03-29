@extends('layouts.app')

@section('meta-desc')
    <meta name="description" content="Lorem ipsum dolor sit amet consectetur adipisicing elit. Autem nam veniam tempora fugit fuga pariatur atque maiores consequuntur asperiores dolores! Facere natus vitae odit, quis corporis recusandae ad consectetur numquam!"/>
@endsection

@section('meta-title')
    {{ __('Contact') }}
@endsection

@section('breadcrumb')
    <x-breadcrumb-item route="{{ route('contact') }}" label="{{ __('Contact') }}" active />
@endsection

@section('content')

<section class="text-gray-700 body-font relative">
    <div class="container px-5 py-24 mx-auto flex sm:flex-no-wrap flex-wrap">
        <div class="lg:w-2/3 md:w-1/2 bg-gray-300 rounded-lg overflow-hidden sm:mr-10 p-10 flex items-end justify-start relative">
            <iframe class="absolute inset-0" style="filter: grayscale(1) contrast(1.2) opacity(0.4);" title="map" marginheight="0" marginwidth="0" scrolling="no" src="https://maps.google.com/maps?width=100%&amp;height=600&amp;hl=en&amp;q=%C4%B0zmir+(My%20Business%20Name)&amp;ie=UTF8&amp;t=&amp;z=14&amp;iwloc=B&amp;output=embed" width="100%" height="100%" frameborder="0"></iframe>
            <div class="bg-white relative flex flex-wrap py-6">
            <div class="lg:w-1/2 px-6">
                <h2 class="title-font font-medium text-gray-900 tracking-widest text-sm">ADDRESS</h2>
                <p class="leading-relaxed">Photo booth tattooed prism, portland taiyaki hoodie neutra typewriter</p>
            </div>
            <div class="lg:w-1/2 px-6 mt-4 lg:mt-0">
                <h2 class="title-font font-medium text-gray-900 tracking-widest text-sm">EMAIL</h2>
                <a class="text-indigo-500 leading-relaxed">example@email.com</a>
                <h2 class="title-font font-medium text-gray-900 tracking-widest text-sm mt-4">PHONE</h2>
                <p class="leading-relaxed">123-456-7890</p>
            </div>
            </div>
        </div>
        <div class="lg:w-1/3 md:w-1/2 bg-white flex flex-col md:ml-auto w-full md:py-8 mt-8 md:mt-0">
            <h2 class="text-gray-900 text-lg mb-1 font-medium title-font">Feedback</h2>
            <p class="leading-relaxed mb-5 text-gray-600">Post-ironic portland shabby chic echo park, banjo fashion axe</p>
            <input class="bg-white rounded border border-gray-400 focus:outline-none focus:border-indigo-500 text-base px-4 py-2 mb-4" placeholder="Name" type="text">
            <input class="bg-white rounded border border-gray-400 focus:outline-none focus:border-indigo-500 text-base px-4 py-2 mb-4" placeholder="Email" type="email">
            <textarea class="bg-white rounded border border-gray-400 focus:outline-none h-32 focus:border-indigo-500 text-base px-4 py-2 mb-4 resize-none" placeholder="Message"></textarea>
            <button class="text-white bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:bg-indigo-600 rounded text-lg">Button</button>
            <p class="text-xs text-gray-500 mt-3">Chicharrones blog helvetica normcore iceland tousled brook viral artisan.</p>
        </div>
    </div>
</section>

@endsection
