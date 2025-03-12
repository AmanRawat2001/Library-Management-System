<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Book Details - {{ $book->title }}
        </h2>
    </x-slot>

    <div class="max-w-4xl mx-auto py-10 sm:px-6 lg:px-8">
        <!-- Back Button -->
        <div class="mb-6">
            <a href="{{ route('books.index') }}"
                class="inline-flex items-center px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold rounded-md shadow-md">
                ⬅️ Back to List
            </a>
        </div>

        <!-- role Details Card -->
        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
            <div class="px-6 py-4">
                <h3 class="text-lg font-semibold text-gray-700 mb-4">Book Information</h3>

                <table class="w-full border-collapse">
                    <tbody>
                        <tr class="border-b">
                            <th class="px-4 py-3 text-left font-medium text-gray-600 bg-gray-100 w-1/3">ID</th>
                            <td class="px-4 py-3 text-gray-800">{{ $book->id }}</td>
                        </tr>
                        <tr class="border-b">
                            <th class="px-4 py-3 text-left font-medium text-gray-600 bg-gray-100">Books Name</th>
                            <td class="px-4 py-3 text-gray-800">{{ $book->title }}</td>
                        </tr>
                        <tr class="border-b">
                            <th class="px-4 py-3 text-left font-medium text-gray-600 bg-gray-100">Books Author</th>
                            <td class="px-4 py-3 text-gray-800">{{ $book->author }}</td>
                        </tr>
                        <tr class="border-b">
                            <th class="px-4 py-3 text-left font-medium text-gray-600 bg-gray-100">Books Stock</th>
                            <td class="px-4 py-3 text-gray-800">{{ $book->stock }}</td>
                        </tr>
                        <tr class="border-b">
                            <th class="px-4 py-3 text-left font-medium text-gray-600 bg-gray-100">Books Category</th>
                            <td class="px-4 py-3 text-gray-800">{{ $book->category?->name }}</td>
                        </tr>
                        <tr class="border-b">
                            <th class="px-4 py-3 text-left font-medium text-gray-600 bg-gray-100 w-1/3">Created At</th>
                            <td class="px-4 py-3 text-gray-800">
                                {{ Illuminate\Support\Carbon::parse($book['created_at'])->format('jS M Y h:i A') }}</td>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
