<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 text-center md:text-left leading-tight">
            {{ __('Borrowed Books') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg text-center md:text-left font-semibold mt-6 mb-4">My Reserved Books</h3>
                    <table class="min-w-full border-collapse divide-y divide-gray-200">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="md:hidden px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">
                                    Reserved
                                    Details</th>
                                <th
                                    class="hidden md:table-cell px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">
                                    Book</th>
                                <th
                                    class="hidden md:table-cell px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">
                                    Reserved At
                                </th>
                                <th
                                    class="hidden md:table-cell px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">
                                    Reserved
                                    Status</th>
                                <th class=" px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse ($reservedBooks as $reservation)
                                <tr>
                                    <td class="md:hidden px-2 py-4 text-sm text-gray-900">Book Title-:
                                        {{ $reservation->book->title }}
                                        <br>
                                        Reserved At-:
                                        {{ Illuminate\Support\Carbon::parse($reservation->created_at)->format('jS M Y') }}

                                    </td>
                                    <td class="hidden md:table-cell px-6 py-4 text-sm text-gray-900">
                                        {{ $reservation->book->title }}</td>
                                    <td class="hidden md:table-cell px-6 py-4 text-sm text-gray-600">
                                        {{ $reservation->created_at }}</td>
                                    <td class="hidden md:table-cell px-6 py-4 text-sm text-gray-600">
                                        {{ $reservation->status }}</td>
                                    <td class="px-6 py-4 text-sm font-semibold">
                                        @if ($reservation->status === 'pending')
                                            <form action="{{ route('books.cancel', $reservation->id) }}" method="POST" class="cancelForm">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="text-red-600 bg-red-100 px-3 py-1 rounded-md hover:bg-red-200">
                                                    Cancel Reservation
                                                </button>
                                            </form>
                                        @elseif($reservation->status === 'cancelled')
                                            <span class="text-gray-600 bg-gray-100 px-3 py-1 rounded-md"> Cancelled
                                            </span>
                                        @else
                                            <span class="text-blue-600 bg-blue-100 px-3 py-1 rounded-md"> Reserved
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="px-6 py-4 text-sm text-gray-900" colspan="2">No reserved books</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="mt-4">
                {{ $reservedBooks->links() }}
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Deny confirmation alert
            document.querySelectorAll('.cancelForm').forEach(form => {
                form.addEventListener('submit', function(event) {
                    event.preventDefault();
                    Swal.fire({
                        title: 'Cancel Reservation Request?',
                        text: "Are you sure you want to cancel this request?",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Yes, Deny'
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
