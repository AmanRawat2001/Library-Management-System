<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            ➕ Add Books
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
        <div class="bg-white shadow-lg rounded-lg p-6">
            <!-- Form Title -->
            <h3 class="text-lg font-semibold text-gray-700 mb-4">Fill in the details below:</h3>

            <form method="POST" action="{{ route('books.store') }}" enctype="multipart/form-data">
                @csrf

                <!-- Grid Layout -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Employee Code -->
                    <div>
                        <label for="title" class="block font-medium text-gray-700">Book Title</label>
                        <input type="text" name="title" id="title"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-2"
                            value="{{ old('title') }}">
                        @error('title')
                            <p class="text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Employee Name -->
                    <div>
                        <label for="author" class="block font-medium text-gray-700">Book Author</label>
                        <input type="text" name="author" id="author"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-2"
                            value="{{ old('author') }}">
                        @error('author')
                            <p class="text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Employee Email -->
                    <div>
                        <label for="stock" class="block font-medium text-gray-700">Book Stock</label>
                        <input type="text" name="stock" id="stock"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-2"
                            value="{{ old('stock') }}">
                        @error('stock')
                            <p class="text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="category_id" class="block font-medium text-gray-700">Category Name</label>
                        <select name="category_id" id="category_id"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-2">
                            <option value="">Select Category Name</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <p class="text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex items-center justify-between px-4 py-3 bg-gray-50 text-right sm:px-6">
                    <a href="{{ route('books.index') }}"
                        class="inline-flex items-center px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold rounded-md shadow-md">
                        ⬅️ Back to List
                    </a>
                    <button type="submit"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-6 py-2 rounded-md shadow-md">
                        🚀 Create Books
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
