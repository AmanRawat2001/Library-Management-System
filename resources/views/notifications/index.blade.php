<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Books') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
        <div class="max-w-5xl mx-auto p-4">
            <h1 class="text-2xl font-bold mb-4">Notifications</h1>

            @if ($notifications->count() > 0)
                @if ($notifications->where('read_at', null)->count())
                    <form action="{{ route('notifications.readAll') }}" method="POST" class="mb-4">
                        @csrf
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">
                            Mark All as Read
                        </button>
                    </form>
                @endif
                <ul class="bg-white shadow rounded-lg divide-y">
                    @foreach ($notifications as $notification)
                        <li class="p-4">
                            📢 {{ $notification->data['message'] }}
                            <small class="text-gray-500">{{ $notification->created_at->diffForHumans() }}</small>

                            @if ($notification->unread())
                                <form action="{{ route('notifications.read', $notification->id) }}" method="POST"
                                    class="inline">
                                    @csrf
                                    <button type="submit" class="text-blue-500 ml-2">Mark as Read</button>
                                </form>
                            @endif
                    @endforeach
                </ul>

                <div class="mt-4">
                    {{ $notifications->links() }}
                </div>
            @else
                <p class="text-gray-600">No notifications available.</p>
            @endif
        </div>
    </div>
</x-app-layout>
