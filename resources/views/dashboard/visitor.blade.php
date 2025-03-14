@if (auth()->user()->isVisitor())
    <div class="container mx-auto px-4 py-6">
        <h1 class="text-3xl font-semibold text-center text-gray-900 mb-6">Visitor Dashboard</h1>
        <div class="flex flex-col md:flex-row gap-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="bg-blue-100 p-6 rounded-lg shadow-md text-center">
                    <h3 class="text-lg font-semibold text-gray-700">User Book Count</h3>
                    <p class="text-3xl font-bold text-blue-600">{{ $userBooksCount }}</p>
                </div>
                <div class="bg-yellow-100 p-6 rounded-lg shadow-md text-center">
                    <h3 class="text-lg font-semibold text-gray-700">Books Borrowed</h3>
                    <p class="text-3xl font-bold text-yellow-600">{{ $borrowed }}</p>
                </div>
                <div class="bg-red-100 p-6 rounded-lg shadow-md text-center">
                    <h3 class="text-lg font-semibold text-gray-700">Pending Returns</h3>
                    <p class="text-3xl font-bold text-red-600">{{ $pendingReturn }}</p>
                </div>
                <div class="bg-purple-100 p-6 rounded-lg shadow-md text-center">
                    <h3 class="text-lg font-semibold text-gray-700">Reservations Pending</h3>
                    <p class="text-3xl font-bold text-purple-600">{{ $pendingReservation }}</p>
                </div>
                <div class="bg-indigo-100 p-6 rounded-lg shadow-md text-center">
                    <h3 class="text-lg font-semibold text-gray-700">Reservations Confirmed</h3>
                    <p class="text-3xl font-bold text-indigo-600">{{ $reserved }}</p>
                </div>
            </div>
            <div class="w-full md:w-1/2 flex justify-center items-center">
                <canvas id="visitorTaskPieChart" class="w-80 h-80"></canvas>
            </div>
        </div>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                var pending = {{ $pending ?? 0 }};
                var borrowed = {{ $borrowed ?? 0 }};
                var pendingReturn = {{ $pendingReturn ?? 0 }};
                var returned = {{ $returned ?? 0 }};
                var pendingReservation = {{ $pendingReservation ?? 0 }};
                var reserved = {{ $reserved ?? 0 }};

                var totalCount = pending + borrowed + pendingReturn + returned + pendingReservation + reserved;

                var ctx = document.getElementById("visitorTaskPieChart").getContext("2d");

                if (totalCount === 0) {
                    var chartContainer = document.getElementById("visitorTaskPieChart").parentNode;
                    chartContainer.innerHTML =
                        `<p class="text-center text-gray-600 font-semibold text-lg">You haven't taken any books yet.</p>`;
                } else {
                    new Chart(ctx, {
                        type: "pie",
                        data: {
                            labels: ["Pending Booked", "Borrowed Book", "Pending Return", "Returned",
                                "Pending Reservation", "Reserved"
                            ],
                            datasets: [{
                                data: [pending, borrowed, pendingReturn, returned, pendingReservation,
                                    reserved
                                ],
                                backgroundColor: ["#3b82f6", "#facc15", "#34d399", "#ef4444", "#f87171",
                                    "#fbbf24"
                                ],
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
                }
            });
        </script>

    </div>
@endif
