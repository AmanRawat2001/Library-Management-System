<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Return Requests
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <table class="min-w-full border-collapse divide-y divide-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">User</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">Book</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">Requested At</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse ($returnRequests as $request)
                        <tr>
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $request->user->name }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $request->book->title }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $request->requested_at }}</td>
                            <td class="px-6 py-4 text-sm">
                                <form action="{{ route('return.approve', [$request->book_id, $request->user_id]) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="text-green-500 hover:text-green-700">✔ Approve</button>
                                </form>
                                <form action="{{ route('return.deny', [$request->book_id, $request->user_id]) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="text-red-500 hover:text-red-700">❌ Deny</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="px-6 py-4 text-sm text-gray-900" colspan="4">No return requests</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
