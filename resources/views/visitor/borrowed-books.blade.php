<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center md:text-left">
            {{ __('Borrowed Books') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg text-center md:text-left font-semibold mb-4">My Borrowed Books</h3>
                    <table class="min-w-full border-collapse divide-y divide-gray-200">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="md:hidden px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">
                                    Borrow
                                    Details</th>
                                <th
                                    class="hidden md:table-cell px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">
                                    Book</th>
                                <th
                                    class="hidden md:table-cell px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">
                                    Requested At
                                </th>
                                <th
                                    class="hidden md:table-cell px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">
                                    Borrowed At
                                </th>
                                <th
                                    class="hidden md:table-cell px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">
                                    Pending
                                    Return</th>
                                <th
                                    class="hidden md:table-cell px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">
                                    Due Date
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse ($borrowedBooks as $book)
                                <tr>
                                    <td class="md:hidden px-2 py-4 text-sm text-gray-900">Book Title-:
                                        {{ $book->title }}
                                        <br>
                                        Requested At-:
                                        {{ $book->pivot->requested_at ? Illuminate\Support\Carbon::parse($book->pivot->requested_at)->format('jS M Y') : '--' }}
                                        <br>
                                        Borrowed At-:
                                        {{ $book->pivot->borrowed_at ? Illuminate\Support\Carbon::parse($book->pivot->borrowed_at)->format('jS M Y') : '--' }}
                                        <br>
                                        Pending Return At -:
                                        {{ $book->pivot->return_requested_at ? Illuminate\Support\Carbon::parse($book->pivot->return_requested_at)->format('jS M Y') : '--' }}
                                        <br>
                                        Due Date-:
                                        {{ $book->pivot->due_date ? Illuminate\Support\Carbon::parse($book->pivot->due_date)->format('jS M Y') : '--' }}
                                        <br>
                                        Return Date-:
                                        {{ $book->pivot->returned_at ? Illuminate\Support\Carbon::parse($book->pivot->returned_at)->format('jS M Y') : '--' }}
                                    </td>
                                    <td class="hidden md:table-cell px-6 py-4 text-sm text-gray-900">{{ $book->title }}
                                    </td>
                                    <td class="hidden md:table-cell px-6 py-4 text-sm text-gray-900">
                                        {{ $book->pivot->requested_at ? Illuminate\Support\Carbon::parse($book->pivot->requested_at)->format('jS M Y') : '--' }}
                                    </td>
                                    <td class="hidden md:table-cell px-6 py-4 text-sm text-gray-600">
                                        {{ $book->pivot->borrowed_at ? Illuminate\Support\Carbon::parse($book->pivot->borrowed_at)->format('jS M Y') : '--' }}
                                    </td>
                                    <td class="hidden md:table-cell px-6 py-4 text-sm text-gray-600">
                                        {{ $book->pivot->return_requested_at ? Illuminate\Support\Carbon::parse($book->pivot->return_requested_at)->format('jS M Y') : '--' }}
                                    </td>
                                    <td class="hidden md:table-cell px-6 py-4 text-sm text-gray-600">
                                        {{ $book->pivot->due_date ? Illuminate\Support\Carbon::parse($book->pivot->due_date)->format('jS M Y') : '--' }}
                                    </td>
                                    <td class="text-center px-6 py-4 text-sm font-semibold">
                                        @if ($book->pivot->status === 'borrowed')
                                            <form action="{{ route('books.return', $book->id) }}" method="POST" class="returnForm">
                                                @csrf
                                                <button type="submit"
                                                    class="text-green-600 bg-green-100 px-3 py-1 rounded-md hover:bg-green-200">
                                                    Return
                                                </button>
                                            </form>
                                        @elseif($book->pivot->status === 'pending')
                                            <span class="text-yellow-600 bg-yellow-100 px-3 py-1 rounded-md"> Pending
                                            </span>
                                        @elseif($book->pivot->status === 'pending_return')
                                            <span class="text-orange-600 bg-orange-100 px-3 py-1 rounded-md"> Pending
                                                Return </span>
                                        @else
                                            <span class="text-gray-600 bg-gray-100 px-3 py-1 rounded-md"> Returned
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="px-6 py-4 text-sm text-gray-900" colspan="3">No borrowed books</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="mt-4">
                {{ $borrowedBooks->links() }}
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Approve confirmation alert
            document.querySelectorAll('.returnForm').forEach(form => {
                form.addEventListener('submit', function(event) {
                    event.preventDefault();
                    Swal.fire({
                        title: 'Return Request?',
                        text: "Are you sure you want to return this book?",
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#28a745',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, Approve'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        });
    </script>
</x-app-layout>
