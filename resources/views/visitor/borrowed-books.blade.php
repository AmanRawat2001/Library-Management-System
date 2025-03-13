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
                    <h3 class="text-lg font-semibold">My Borrowed Books</h3>
                    <table class="min-w-full border-collapse divide-y divide-gray-200">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">Book</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">Requested At
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">Borrowed At
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">Pending
                                    Return</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">Due Date
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse ($borrowedBooks as $book)
                                <tr>
                                    <td class="px-6 py-4 text-sm text-gray-900">{{ $book->title }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-900">{{ $book->pivot->requested_at ?? '--' }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600">{{ $book->pivot->borrowed_at ?? '--' }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600">
                                        {{ $book->pivot->return_requested_at ?? '--' }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-600">{{ $book->pivot->due_date ?? '--' }}
                                    </td>
                                    <td class="px-6 py-4 text-sm">
                                        @if ($book->pivot->status === 'borrowed')
                                            <form action="{{ route('books.return', $book->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="text-green-500 hover:text-green-700">🔄
                                                    Return</button>
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
                </div>
            </div>
            <div class="mt-4">
                {{ $borrowedBooks->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
