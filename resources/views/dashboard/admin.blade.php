@if (Auth::user()->isAdmin())
    <div class="p-6 lg:p-8 bg-white border-b border-gray-200 shadow-md rounded-lg">
        <h1 class="mt-6 text-3xl font-semibold text-gray-900">Admin Dashboard</h1>

        @php
            $totalBooks = App\Models\Book::count();
            $totalUsers = App\Models\User::where('role', 'visitor')->count();
            $pending = App\Models\BookUser::where('status', 'pending')->count();
            $borrowed = App\Models\BookUser::where('status', 'borrowed')->count();
            $returned = App\Models\BookUser::where('status', 'returned')->count();
            $pendingReturn = App\Models\BookUser::where('status', 'pending_return')->count();
            $pendingReservation = App\Models\Reservation::where('status', 'pending')->count();
            $reserved = App\Models\Reservation::where('status', 'reserved')->count();
        @endphp

        <!-- Flexbox for Layout -->
        <div class="flex flex-col md:flex-row gap-6">
            <!-- Left Side: Statistics -->
            <div class=" w-full md:w-1/2 grid grid-cols-2 gap-6">
                <div class="bg-white shadow-lg rounded-lg p-6 text-center">
                    <h3 class="text-lg font-semibold text-gray-700">Total Books</h3>
                    <p class="text-3xl font-bold text-blue-600">{{ $totalBooks }}</p>
                </div>
                <div class="bg-white shadow-lg rounded-lg p-6 text-center">
                    <h3 class="text-lg font-semibold text-gray-700">Total Customers</h3>
                    <p class="text-3xl font-bold text-green-600">{{ $totalUsers }}</p>
                </div>
                <div class="bg-white shadow-lg rounded-lg p-6 text-center">
                    <h3 class="text-lg font-semibold text-gray-700">Books Borrowed</h3>
                    <p class="text-3xl font-bold text-yellow-600">{{ $borrowed }}</p>
                </div>
                <div class="bg-white shadow-lg rounded-lg p-6 text-center">
                    <h3 class="text-lg font-semibold text-gray-700">Pending Returns</h3>
                    <p class="text-3xl font-bold text-red-600">{{ $pendingReturn }}</p>
                </div>
                <div class="bg-white shadow-lg rounded-lg p-6 text-center">
                    <h3 class="text-lg font-semibold text-gray-700">Reservations Pending</h3>
                    <p class="text-3xl font-bold text-purple-600">{{ $pendingReservation }}</p>
                </div>
                <div class="bg-white shadow-lg rounded-lg p-6 text-center">
                    <h3 class="text-lg font-semibold text-gray-700">Reservations Confirmed</h3>
                    <p class="text-3xl font-bold text-indigo-600">{{ $reserved }}</p>
                </div>
            </div>

            <!-- Right Side: Pie Chart -->
            <div class="w-full md:w-1/2 flex justify-center items-center">
                <canvas id="taskPieChart" class="w-80 h-80"></canvas>
            </div>
        </div>

        <!-- Chart Script -->
        <script>
            var ctx = document.getElementById("taskPieChart").getContext("2d");
            var taskPieChart = new Chart(ctx, {
                type: "pie",
                data: {
                    labels: ["Pending Booked", "Borrowed Book", "Pending Return", "Returned", "Pending Reservation", "Reserved"],
                    datasets: [{
                        data: [{{ $pending }}, {{ $borrowed }}, {{ $pendingReturn }}, {{ $returned }}, {{ $pendingReservation }}, {{ $reserved }}],
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
    </div>
@endif
