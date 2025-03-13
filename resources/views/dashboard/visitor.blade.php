@if (auth()->user()->isVisitor())
    <h3 class="text-lg font-semibold">My Borrowed Books</h3>
    <table class="min-w-full border-collapse divide-y divide-gray-200">
        <thead class="bg-gray-100">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">Book</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">Requested At</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">Borrowed At</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">Pending Return</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">Due Date</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @forelse (auth()->user()->books as $book)
                <tr>
                    <td class="px-6 py-4 text-sm text-gray-900">{{ $book->title }}</td>
                    <td class="px-6 py-4 text-sm text-gray-900">{{ $book->pivot->requested_at }}</td>
                    <td class="px-6 py-4 text-sm text-gray-600">{{ $book->pivot->borrowed_at }}</td>
                    <td class="px-6 py-4 text-sm text-gray-600">{{ $book->pivot->return_requested_at }}</td>
                    <td class="px-6 py-4 text-sm text-gray-600">{{ $book->pivot->due_date }}</td>
                    <td class="px-6 py-4 text-sm">
                        @if ($book->pivot->status === 'borrowed')
                            <form action="{{ route('books.return', $book->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="text-green-500 hover:text-green-700">🔄 Return</button>
                            </form>
                        @elseif($book->pivot->status === 'pending')
                            <span class="text-gray-500">🕒 Pending</span>
                        @elseif($book->pivot->status === 'pending_return')
                            <span class="text-gray-500">🕒 Pending Return</span>
                        @else
                            <span class="text-gray-500">✅ Returned</span>
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

    <h3 class="text-lg font-semibold mt-6">My Reserved Books</h3>
    <table class="min-w-full border-collapse divide-y divide-gray-200">
        <thead class="bg-gray-100">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">Book</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">Reserved At</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">Reserved Status</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @forelse (auth()->user()->reservations as $reservation)
                <tr>
                    <td class="px-6 py-4 text-sm text-gray-900">{{ $reservation->book->title }}</td>
                    <td class="px-6 py-4 text-sm text-gray-600">{{ $reservation->created_at }}</td>
                    <td class="px-6 py-4 text-sm text-gray-600">{{ $reservation->status }}</td>
                    @if ($reservation->status === 'pending')
                        <td class="px-6 py-4 text-sm">
                            <form action="{{ route('books.cancel', $reservation->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-green-500 hover:text-green-700">Cancel Reservation</button>
                            </form>
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
@endif
