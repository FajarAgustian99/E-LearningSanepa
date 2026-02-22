@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-6">

    {{-- ================= STATISTIC CARDS ================= --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4 mb-8">

        <div class="bg-gray-800 text-white rounded-lg shadow p-4 text-center">
            <h6>Total Admin</h6>
            <h2 class="text-2xl font-bold">{{ $totalAdmins }}</h2>
        </div>

        <div class="bg-blue-500 text-white rounded-lg shadow p-4 text-center">
            <h6>Total Guru</h6>
            <h2 class="text-2xl font-bold">{{ $totalTeachers }}</h2>
        </div>

        <div class="bg-green-500 text-white rounded-lg shadow p-4 text-center">
            <h6>Total Siswa</h6>
            <h2 class="text-2xl font-bold">{{ $totalStudents }}</h2>
        </div>

        <div class="bg-yellow-400 text-gray-800 rounded-lg shadow p-4 text-center">
            <h6>Total Mapel</h6>
            <h2 class="text-2xl font-bold">{{ $totalCourses }}</h2>
        </div>

        <div class="bg-indigo-500 text-white rounded-lg shadow p-4 text-center">
            <h6>Total Kelas</h6>
            <h2 class="text-2xl font-bold">{{ $totalClasses }}</h2>
        </div>

        <div class="bg-gray-500 text-white rounded-lg shadow p-4 text-center">
            <h6>Total User</h6>
            <h2 class="text-2xl font-bold">{{ $totalUsers }}</h2>
        </div>

    </div>

    {{-- ================= CHART SECTION ================= --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-12">

        {{-- USER COMPOSITION --}}
        <div
            class="bg-white rounded-2xl shadow-sm hover:shadow-md transition p-6 border border-gray-100">

            <div class="flex items-center justify-between mb-4">
                <h4 class="font-semibold text-gray-700 flex items-center gap-2">
                    📊 Komposisi User
                </h4>
                <span class="text-xs text-gray-400">Realtime</span>
            </div>

            <hr class="mb-4">

            <div class="flex justify-center">
                <canvas id="userChart" height="220"></canvas>
            </div>

        </div>

        {{-- CLASS COURSE --}}
        <div
            class="bg-white rounded-2xl shadow-sm hover:shadow-md transition p-6 border border-gray-100">

            <div class="flex items-center justify-between mb-4">
                <h4 class="font-semibold text-gray-700 flex items-center gap-2">
                    📚 Jumlah Mapel per Kelas
                </h4>
                <span class="text-xs text-gray-400">Statistik</span>
            </div>

            <hr class="mb-4">

            <div>
                <canvas id="classChart" height="220"></canvas>
            </div>

        </div>

    </div>

    {{-- ================= MINI STATISTICS ================= --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-12">

        <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100">
            <p class="text-sm text-gray-400">Rata-rata Mapel</p>
            <h3 class="text-2xl font-bold text-blue-600 mt-1">
                {{ $avgCourses }}
            </h3>
        </div>

        <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100">
            <p class="text-sm text-gray-400">Kelas Terbanyak</p>
            <h3 class="text-lg font-semibold text-gray-700 mt-1">
                {{ $maxClassName }}
            </h3>
            <span class="text-xs text-gray-400">
                {{ $maxClassCount }} mapel
            </span>
        </div>

        <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100">
            <p class="text-sm text-gray-400">Total Kelas</p>
            <h3 class="text-2xl font-bold text-indigo-600 mt-1">
                {{ $totalClasses }}
            </h3>
        </div>

        <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100">
            <p class="text-sm text-gray-400">Absensi</p>
            <h3 class="text-2xl font-bold text-green-600 mt-1">
                {{ $todayAttendance }}

            </h3>
        </div>

        <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100">
            <p class="text-sm text-gray-400">Kelas Teraktif</p>
            <h3 class="text-2xl font-bold text-green-600 mt-1">
                {{ $activeClassName }} ({{ $activeClassTotal }} aktivitas)
            </h3>
        </div>

    </div>


    {{-- ================= QUICK LINKS ================= --}}
    <h4 class="text-lg font-semibold mb-3">Quick Links</h4>

    <div class="flex flex-wrap gap-3">

        <a href="{{ route('admin.users.index') }}" class="px-4 py-2 bg-blue-600 text-white rounded">
            Kelola User
        </a>

        <a href="{{ route('admin.courses.index') }}" class="px-4 py-2 bg-yellow-500 rounded">
            Kelola Mapel
        </a>

        <a href="{{ route('admin.classes.index') }}" class="px-4 py-2 bg-green-500 text-white rounded">
            Kelola Kelas
        </a>

        <a href="{{ route('admin.students.index') }}" class="px-4 py-2 bg-teal-500 text-white rounded">
            Kelola Siswa
        </a>

        <a href="{{ route('admin.attendance.index') }}" class="px-4 py-2 bg-gray-700 text-white rounded">
            Kelola Absensi
        </a>

    </div>

</div>
@endsection

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", () => {

        let teachers = Number(@json($totalTeachers));
        let students = Number(@json($totalStudents));
        let admins = Number(@json($totalAdmins));

        let classNames = @json($classNames);
        let classCounts = @json($classCourseCounts);

        console.log(teachers, students, admins);
        console.log(classNames, classCounts);

        const userChart = document.getElementById("userChart");
        const classChart = document.getElementById("classChart");

        if (!userChart || !classChart) return;

        new Chart(userChart, {
            type: "pie",
            data: {
                labels: ["Guru", "Siswa", "Admin"],
                datasets: [{
                    data: [teachers, students, admins]
                }]
            }
        });

        new Chart(classChart, {
            type: "bar",
            data: {
                labels: classNames,
                datasets: [{
                    label: "Jumlah Mapel",
                    data: classCounts
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

    });
</script>
@endpush