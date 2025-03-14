<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-center mr-4">
            <h2 class="font-semibold text-lg sm:text-xl text-gray-800 leading-tight mb-2 sm:mb-0">
                Category Details - {{ $category->name }}
            </h2>
            <div class="flex flex-col sm:flex-row items-center sm:space-x-4 w-full sm:w-auto">
                <div class="flex space-x-2">
                    <a href="{{ route('categories.index') }}"
                        class="bg-gray-200 hover:bg-gray-300 text-black font-bold py-2 px-4 rounded sm:w-auto text-center">
                        Back to list
                    </a>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto py-10 sm:px-6 lg:px-8">
        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
            <div class="px-6 py-4">
                <h3 class="text-lg font-semibold text-gray-700 mb-4">Category Information</h3>

                <table class="w-full border-collapse">
                    <tbody>
                        <tr class="border-b">
                            <th class="px-4 py-3 text-left font-medium text-gray-600 bg-gray-100">Category Name</th>
                            <td class="px-4 py-3 text-gray-800">{{ $category->name }}</td>
                        </tr>
                        <tr class="border-b">
                            <th class="px-4 py-3 text-left font-medium text-gray-600 bg-gray-100">Created At</th>
                            <td class="px-4 py-3 text-gray-800">
                                {{ Illuminate\Support\Carbon::parse($category['created_at'])->format('jS M Y h:i A') }}
                            </td>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
