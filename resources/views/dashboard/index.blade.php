@extends('container.app')
@section('includes')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
@endsection
@section('content')
    <div class="flex gap-2 items-center text-gray-50 tracking-tighter py-4 mt-2 mb-6 border-b border-gray-600 text-gray-200">
        <i class="fas fa-home text-xl"></i>
        <div class="text-lg">
            Dashboard : الصفحة الرئيسية        </div>
    </div>
    <div class="flex gap-4 mb-4">
        <div class="w-full md:w-3/4">
            @include('dashboard.partials.nav')
        </div>
    </div>
@endsection

