<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Borrowed Books') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mt-6">My Reserved Books</h3>
                    <table class="min-w-full border-collapse divide-y divide-gray-200">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">Book</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">Reserved At
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">Reserved
                                    Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse ($reservedBooks as $reservation)
                                <tr>
                                    <td class="px-6 py-4 text-sm text-gray-900">{{ $reservation->book->title }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-600">{{ $reservation->created_at }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-600">{{ $reservation->status }}</td>
                                    @if ($reservation->status === 'pending')
                                        <td class="px-6 py-4 text-sm">
                                            <form action="{{ route('books.cancel', $reservation->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="text-green-500 hover:text-green-700">Cancel
                                                    Reservation</button>
                                            </form>
                                        </td>
                                    @elseif($reservation->status === 'cancelled')
                                        <td class="px-6 py-4 text-sm">
                                            <span class="text-gray-500">🚫 Cancelled</span>
                                        </td>
                                    @else
                                        <td class="px-6 py-4 text-sm">
                                            <span class="text-gray-500">✅ Reserved</span>
                                        </td>
                                    @endif
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
</x-app-layout>
