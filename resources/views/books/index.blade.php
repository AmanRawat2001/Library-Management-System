<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 text-center md:text-left leading-tight">
            {{ __('Books') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
        <!-- Top Bar: Search & Add Button -->
        <div class="flex flex-wrap justify-between gap-4 items-center mb-6 px-4">
            <form method="GET" action="{{ route('books.index') }}" class="flex items-center w-full md:w-auto">
                <input type="text" name="search" value="{{ request('search') }}"
                    class="border border-gray-300 rounded-l px-4 py-2 focus:ring-blue-500 focus:border-blue-500 w-full md:w-64"
                    placeholder="Search ...">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white px-4 py-2 rounded-r">
                    Search
                </button>
            </form>
            @if (Auth::user()->isAdmin())
                <a href="{{ route('books.create') }}"
                    class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded flex items-center">
                    Add books
                </a>
            @endif
        </div>

        <!-- User Table -->
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <table class="min-w-full border-collapse divide-y divide-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        
                        <th class="block md:hidden px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">Book Details </th>
                        <th class="hidden md:table-cell px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">ID</th>
                        <th class="hidden md:table-cell px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">Title</th>
                        <th class="hidden md:table-cell px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">Author</th>
                        <th class="hidden md:table-cell px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">Stock</th>
                        <th class="hidden md:table-cell px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">Category Name</th>
                        <th class=" px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse ($books as $book)
                        <tr class="hover:bg-gray-50">
                            <td class="md:hidden px-2 py-4 text-sm text-gray-900">Book Title -:{{ $book->title }} <br> Book Author-: {{ $book->author }} <br>Book Stock -: {{ $book->stock }}</td>
                            <td class="hidden md:table-cell px-6 py-4 text-sm text-gray-900">{{ $book->id }}</td>
                            <td class="hidden md:table-cell px-6 py-4 text-sm text-gray-900">{{ $book->title }}</td>
                            <td class="hidden md:table-cell px-6 py-4 text-sm font-semibold text-gray-900">{{ $book->author }}</td>
                            <td class="hidden md:table-cell px-6 py-4 text-sm text-gray-600">{{ $book->stock }}</td>
                            <td class="hidden md:table-cell px-6 py-4 text-sm text-gray-600">{{ $book->category?->name }}</td>
                            <td class="px-6 py-4 text-sm font-medium flex space-x-3">
                                <a href="{{ route('books.show', $book->id) }}"
                                    class="text-blue-500 hover:text-blue-700">View</a>
                                @if (auth()->user()->role == 'visitor')
                                    @if ($book->stock > 0)
                                        <form action="{{ route('books.book', $book->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="text-green-500 hover:text-green-700">
                                                Booked</button>
                                        </form>
                                    @else
                                        <form action="{{ route('books.reserve', $book->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="text-yellow-500 hover:text-yellow-700">                                                Reserve</button>
                                        </form>
                                    @endif
                                @endif
                                @if (auth()->user()->isAdmin())
                                    <a href="{{ route('books.edit', $book->id) }}"
                                        class="text-yellow-500 hover:text-yellow-700">Edit</a>

                                    <button type="button" class="text-red-500 hover:text-red-700 deleteButton"
                                        data-id="{{ $book->id }}">
                                        Delete
                                    </button>
                                    <form id="deleteForm-{{ $book->id }}"
                                        action="{{ route('books.destroy', $book->id) }}" method="POST" class="hidden">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-gray-500">No books found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $books->links() }}
        </div>
    </div>

    <!-- SweetAlert Delete Confirmation -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.deleteButton').forEach(button => {
                button.addEventListener('click', function() {
                    let userId = this.getAttribute('data-id');
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            document.getElementById('deleteForm-' + userId).submit();
                        }
                    });
                });
            });
        });
    </script>
</x-app-layout>
