<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}
                    <br>
                    @if (auth()->user()->isVisitor())
                        <h3 class="text-lg font-semibold">My Borrowed Books</h3>
                        <table class="min-w-full border-collapse divide-y divide-gray-200">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">Book</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">Borrowed
                                        At</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">Due Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse (auth()->user()->books as $book)
                                    <tr>
                                        <td class="px-6 py-4 text-sm text-gray-900">{{ $book->title }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-600">{{ $book->pivot->borrowed_at }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-600">{{ $book->pivot->due_date }}</td>
                                        <td class="px-6 py-4 text-sm">
                                            @if ($book->pivot->status === 'borrowed')
                                                <form action="{{ route('books.return', $book->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit"
                                                        class="text-green-500 hover:text-green-700">🔄 Return</button>
                                                </form>
                                            @else
                                                <span class="text-gray-500">✅ Returned</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="px-6 py-4 text-sm text-gray-900" colspan="3">No borrowed books
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        <h3 class="text-lg font-semibold mt-6">My Reserved Books</h3>
                        <table class="min-w-full border-collapse divide-y divide-gray-200">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">Book
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">Reserved
                                        At</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse (auth()->user()->reservations as $reservation)
                                    <tr>
                                        <td class="px-6 py-4 text-sm text-gray-900">{{ $reservation->book->title }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-600">{{ $reservation->created_at }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="px-6 py-4 text-sm text-gray-900" colspan="2">No reserved books
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
