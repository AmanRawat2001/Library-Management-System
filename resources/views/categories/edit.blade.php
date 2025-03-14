<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-center mr-4">
            <h2 class="font-semibold text-lg sm:text-xl text-gray-800 leading-tight mb-2 sm:mb-0">
                Category - {{ $category->id }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('categories.index') }}"
                    class="bg-gray-200 hover:bg-gray-300 text-black font-bold py-2 px-4 rounded sm:w-auto text-center">
                    Back to List
                </a>
            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
        <div class="bg-white shadow-lg rounded-lg p-6">
            <h3 class="text-lg font-semibold text-gray-700 mb-4">Category details below:</h3>

            <form method="POST" action="{{ route('categories.update', $category->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div>
                        <label for="name" class="block font-medium text-gray-700">Category Name</label>
                        <input type="text" name="name" id="name"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-2"
                            value="{{ old('name', $category->name) }}">
                        @error('name')
                            <p class="text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex items-center justify-between px-4 py-3 bg-gray-50 text-right sm:px-6">
                    <a href="{{ route('categories.index') }}"
                        class="inline-flex items-center px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold rounded-md shadow-md">
                        Back to List
                    </a>
                    <button type="submit"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-6 py-2 rounded-md shadow-md">
                        Update Category
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
