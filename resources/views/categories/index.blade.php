<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Category') }}
        </h2>
    </x-slot>

    <div class="max-w-4xl mx-auto py-10 sm:px-6 lg:px-8">
        <!-- Top Bar: Search & Add Button -->
        <div class="flex flex-wrap justify-between items-center mb-6 px-4">
            <form method="GET" action="{{ route('categories.index') }}" class="flex items-center w-full md:w-auto">
                <input type="text" name="search" value="{{ request('search') }}"
                    class="border border-gray-300 rounded-l px-4 py-2 focus:ring-blue-500 focus:border-blue-500 w-full md:w-64"
                    placeholder="Search ...">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white px-4 py-2 rounded-r">
                    Search
                </button>
            </form>
            <a href="{{ route('categories.create') }}"
                class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded flex items-center">
             Add categories
            </a>
        </div>

        <!-- User Table -->
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <table class=" min-w-full border-collapse divide-y divide-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-600 uppercase">ID</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-600 uppercase">Category Name</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-600 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse ($categories as $category)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-center text-sm text-gray-900">{{ $category->id }}</td>
                            <td class="px-6 py-4 text-center text-sm text-gray-600">{{ $category->name }}</td>
                            <td class="px-6 py-4 text-center text-sm font-medium space-x-3">
                                <a href="{{ route('categories.show', $category->id) }}"
                                    class="text-blue-500 hover:text-blue-700"> View</a>
                                @if (auth()->user()->role == 'admin')
                                    <a href="{{ route('categories.edit', $category->id) }}"
                                        class="text-yellow-500 hover:text-yellow-700"> Edit</a>

                                    <button type="button" class="text-red-500 hover:text-red-700 deleteButton"
                                        data-id="{{ $category->id }}">
                                        Delete
                                    </button>
                                    <form id="deleteForm-{{ $category->id }}"
                                        action="{{ route('categories.destroy', $category->id) }}" method="POST" class="hidden">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-gray-500">No categories found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $categories->links() }}
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
