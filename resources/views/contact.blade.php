@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100 py-10 px-6 md:px-10">
    <h1 class="text-4xl font-bold text-green-700 mb-8">Contact Directory</h1>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        {{-- Contact Card --}}
        @foreach ($contact as $contacts)
        <div class="bg-white rounded-2xl shadow-md p-6">
            <div class="mb-4">
                <h2 class="text-xl font-semibold text-gray-800">{{ $contacts['name'] }}</h2>
                <p class="text-gray-500">{{ $contacts['role'] }}</p>
            </div>
            <div class="text-sm text-gray-700">
                <p><strong>Email:</strong> <a href="mailto:{{ $contacts['email'] }}" class="text-green-600 hover:underline">{{ $contacts['email'] }}</a></p>
                <p><strong>Phone:</strong> <a href="tel:{{ $contacts['phone'] }}" class="text-green-600 hover:underline">{{ $contacts['phone'] }}</a></p>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
