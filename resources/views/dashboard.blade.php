@extends('layouts.app')

@section('title', 'Dashboard - Social Plus')

@section('content')
<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="px-4 py-6 sm:px-0">
        <div class="bg-white dark:bg-[#161615] shadow-[inset_0px_0px_0px_1px_rgba(26,26,0,0.16)] dark:shadow-[inset_0px_0px_0px_1px_#fffaed2d] rounded-lg p-6">
            <h1 class="text-2xl font-bold text-[#1b1b18] dark:text-[#EDEDEC] mb-4">
                Welcome, {{ auth()->user()->name }}!
            </h1>
            <p class="text-[#706f6c] dark:text-[#A1A09A] mb-6">
                This is your dashboard. Here you can access your courses, sessions, and materials.
            </p>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-6">
                <div class="bg-[#FDFDFC] dark:bg-[#0a0a0a] border border-[#e3e3e0] dark:border-[#3E3E3A] rounded-lg p-4">
                    <h3 class="text-lg font-semibold text-[#1b1b18] dark:text-[#EDEDEC] mb-2">Courses</h3>
                    <p class="text-[#706f6c] dark:text-[#A1A09A] text-sm">Access your courses organized by subject</p>
                </div>
                <div class="bg-[#FDFDFC] dark:bg-[#0a0a0a] border border-[#e3e3e0] dark:border-[#3E3E3A] rounded-lg p-4">
                    <h3 class="text-lg font-semibold text-[#1b1b18] dark:text-[#EDEDEC] mb-2">Sessions</h3>
                    <p class="text-[#706f6c] dark:text-[#A1A09A] text-sm">View your learning sessions</p>
                </div>
                <div class="bg-[#FDFDFC] dark:bg-[#0a0a0a] border border-[#e3e3e0] dark:border-[#3E3E3A] rounded-lg p-4">
                    <h3 class="text-lg font-semibold text-[#1b1b18] dark:text-[#EDEDEC] mb-2">Calculator</h3>
                    <p class="text-[#706f6c] dark:text-[#A1A09A] text-sm">Use the built-in calculator</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
