<h2 class="text-lg font-semibold mb-4">Borrowing History</h2>

<div class="overflow-x-auto">
    <table class="min-w-full divide-y divide-gray-200">
        <thead>
            <tr>
                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase">User</th>
                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @if ($book->bookUsers->count() == 0)
                <tr>
                    <td class="px-6 py-4 text-sm text-gray-900" colspan="3">No history found.</td>
                </tr>
            @else
                @foreach ($book->bookUsers as $history)
                    <tr>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ $history->user->name }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ ucfirst($history->status) }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900">
                            @if ($history->status == 'borrowed')
                                Borrowed on {{ \Carbon\Carbon::parse($history->borrowed_at)->format('jS M Y') }}
                            @elseif($history->status == 'returned')
                                Returned on {{ \Carbon\Carbon::parse($history->returned_at)->format('jS M Y') }}
                            @elseif($history->status == 'pending_return')
                                Requested on
                                {{ \Carbon\Carbon::parse($history->return_requested_at)->format('jS M Y') }}
                            @elseif($history->status == 'pending')
                                Requested on {{ \Carbon\Carbon::parse($history->requested_at)->format('jS M Y') }}
                            @endif
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</div>
