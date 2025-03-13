@if (Auth::user()->isAdmin())
    <div class="container mx-auto px-4 py-6">
        <h1 class="text-3xl font-semibold text-center text-gray-900 mb-6">Admin Dashboard</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Total Books -->
            <div class="bg-blue-100 p-6 rounded-lg shadow-md text-center">
                <h3 class="text-lg font-semibold text-gray-700">Total Books</h3>
                <p class="text-3xl font-bold text-blue-600">{{ $totalBooks }}</p>
            </div>

            <!-- Total Customers -->
            <div class="bg-green-100 p-6 rounded-lg shadow-md text-center">
                <h3 class="text-lg font-semibold text-gray-700">Total Customers</h3>
                <p class="text-3xl font-bold text-green-600">{{ $totalUsers }}</p>
            </div>

            <!-- Borrowed Books -->
            <div class="bg-yellow-100 p-6 rounded-lg shadow-md text-center">
                <h3 class="text-lg font-semibold text-gray-700">Books Borrowed</h3>
                <p class="text-3xl font-bold text-yellow-600">{{ $borrowed }}</p>
            </div>

            <!-- Pending Returns -->
            <div class="bg-red-100 p-6 rounded-lg shadow-md text-center">
                <h3 class="text-lg font-semibold text-gray-700">Pending Returns</h3>
                <p class="text-3xl font-bold text-red-600">{{ $pendingReturn }}</p>
            </div>

            <!-- Pending Reservations -->
            <div class="bg-purple-100 p-6 rounded-lg shadow-md text-center">
                <h3 class="text-lg font-semibold text-gray-700">Reservations Pending</h3>
                <p class="text-3xl font-bold text-purple-600">{{ $pendingReservation }}</p>
            </div>

            <!-- Confirmed Reservations -->
            <div class="bg-indigo-100 p-6 rounded-lg shadow-md text-center">
                <h3 class="text-lg font-semibold text-gray-700">Reservations Confirmed</h3>
                <p class="text-3xl font-bold text-indigo-600">{{ $reserved }}</p>
            </div>
        </div>

        <!-- Pie Chart -->
        <div class="mt-8 flex justify-center">
            <canvas id="taskPieChart" class="w-80 h-80"></canvas>
        </div>

        <!-- Reports Section -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-10">
            <!-- Top 10 Most Read Books -->
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Top 10 Most Read Books</h2>
                <ul class="space-y-2">
                    @foreach ($topBooks as $book)
                        <li class="flex justify-between border-b py-2">
                            <span class="text-gray-700">{{ $book->book->title }}</span>
                            <span class="font-bold text-blue-600">{{ $book->times_read }} Reads</span>
                        </li>
                    @endforeach
                </ul>
            </div>

            <!-- Top 10 Active Readers -->
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Top 10 Active Readers</h2>
                <ul class="space-y-2">
                    @foreach ($topReaders as $reader)
                        <li class="flex justify-between border-b py-2">
                            <span class="text-gray-700">{{ $reader->user->name }}</span>
                            <span class="font-bold text-green-600">{{ $reader->books_read }} Books</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

    <script>
        var ctx = document.getElementById("taskPieChart").getContext("2d");
        var taskPieChart = new Chart(ctx, {
            type: "pie",
            data: {
                labels: ["Pending Booked", "Borrowed Book", "Pending Return", "Returned", "Pending Reservation",
                    "Reserved"
                ],
                datasets: [{
                    data: [{{ $pending }}, {{ $borrowed }}, {{ $pendingReturn }},
                        {{ $returned }}, {{ $pendingReservation }}, {{ $reserved }}
                    ],
                    backgroundColor: ["#3b82f6", "#facc15", "#34d399", "#ef4444", "#f87171", "#fbbf24"],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: "bottom"
                    }
                }
            }
        });
    </script>
@endif
