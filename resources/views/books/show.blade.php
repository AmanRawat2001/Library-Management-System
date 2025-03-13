<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-center mr-4">
            <h2 class="font-semibold text-lg sm:text-xl text-gray-800 leading-tight mb-2 sm:mb-0">
                Book Details - {{ $book->title }}
            </h2>
            <div class="flex flex-col sm:flex-row items-center sm:space-x-4 w-full sm:w-auto">
                <div class="flex space-x-2">
                    <a href="{{ route('books.index') }}"
                        class="bg-gray-200 hover:bg-gray-300 text-black font-bold py-2 px-4 rounded sm:w-auto text-center">
                        Back to list
                    </a>
                    @if(Auth::user()->isAdmin())
                    <button id="book-history"
                        class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded  sm:w-auto text-center">
                        History
                    </button>
                    @endif
                </div>
            </div>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto py-10 sm:px-6 lg:px-8">
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
    <div id="book-history-model"
        class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto flex items-center justify-center">
        <div class="relative mx-auto p-5 border h-auto w-[95%] md:w-[80%] shadow-lg rounded-md bg-white">
            <button id="close-payment-modal" class="absolute top-2 right-2 text-gray-500">✕</button>
            @include('books.history')
        </div>
    </div>
    <script>
        document.getElementById('book-history').addEventListener('click', function() {
            document.getElementById('book-history-model').classList.remove('hidden');
        });
        document.getElementById('close-payment-modal').addEventListener('click', function() {
            document.getElementById('book-history-model').classList.add('hidden');
        });
    </script>
</x-app-layout>
