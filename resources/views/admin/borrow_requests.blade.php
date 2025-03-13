<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Borrow Requests
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <table class="min-w-full border-collapse divide-y divide-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="md:hidden px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">Borrow
                            Details</th>
                        <th class="hidden md:table-cell px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">
                            User</th>
                        <th class="hidden md:table-cell px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">
                            Book</th>
                        <th class="hidden md:table-cell px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">
                            Requested At</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse ($borrowRequests as $request)
                        <tr>
                            <td class="md:hidden px-2 py-4 text-sm text-gray-900">User Name -:{{ $request->user->name }}
                                <br> Book Title-: {{ $request->book->title }} <br> Requested Date -:
                                {{ $request->requested_at }}
                            </td>
                            <td class="hidden md:table-cell px-6 py-4 text-sm text-gray-900">{{ $request->user->name }}
                            </td>
                            <td class="hidden md:table-cell px-6 py-4 text-sm text-gray-900">{{ $request->book->title }}
                            </td>
                            <td class="hidden md:table-cell px-6 py-4 text-sm text-gray-600">
                                {{ $request->requested_at }}</td>
                            <td class="px-6 py-4 text-sm">
                                <form action="{{ route('books.approve', [$request->book_id, $request->user_id]) }}"
                                    method="POST" class="approveForm">
                                    @csrf
                                    <button type="submit" class="text-green-500 hover:text-green-700 approveButton">✔
                                        Approve</button>
                                </form>
                                <form action="{{ route('books.deny', [$request->book_id, $request->user_id]) }}"
                                    method="POST" class="denyForm">
                                    @csrf
                                    <button type="submit" class="text-red-500 hover:text-red-700 denyButton">❌
                                        Deny</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="px-6 py-4 text-sm text-gray-900" colspan="4">No borrow requests found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Approve confirmation alert
            document.querySelectorAll('.approveForm').forEach(form => {
                form.addEventListener('submit', function(event) {
                    event.preventDefault();
                    Swal.fire({
                        title: 'Approve Borrow Request?',
                        text: "Are you sure you want to approve this request?",
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

            // Deny confirmation alert
            document.querySelectorAll('.denyForm').forEach(form => {
                form.addEventListener('submit', function(event) {
                    event.preventDefault();
                    Swal.fire({
                        title: 'Deny Borrow Request?',
                        text: "Are you sure you want to deny this request?",
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
