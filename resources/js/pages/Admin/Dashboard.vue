<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';

interface Props {
    stats: {
        total_users: number;
    };
}

defineProps<Props>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Admin Dashboard',
        href: '/admin/dashboard',
    },
];
</script>

<template>
    <Head title="Admin Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4 overflow-x-auto">
            <div class="mb-6">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Admin Dashboard</h1>
                <p class="text-gray-600 dark:text-gray-400">Manage users and monitor system activities</p>
            </div>

            <!-- Stats Cards -->
            <div class="grid auto-rows-min gap-4 md:grid-cols-2">
                <div class="relative overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border bg-white dark:bg-gray-800 p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Users Under Management</p>
                            <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ stats.total_users }}</p>
                        </div>
                        <div class="h-12 w-12 rounded-full bg-blue-100 dark:bg-blue-900 flex items-center justify-center">
                            <svg class="h-6 w-6 text-blue-600 dark:text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="relative overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border bg-white dark:bg-gray-800 p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Active Sessions</p>
                            <p class="text-3xl font-bold text-gray-900 dark:text-white">24</p>
                        </div>
                        <div class="h-12 w-12 rounded-full bg-green-100 dark:bg-green-900 flex items-center justify-center">
                            <svg class="h-6 w-6 text-green-600 dark:text-green-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Management Panel -->
            <div class="relative min-h-[50vh] flex-1 rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border bg-white dark:bg-gray-800 p-6">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Admin Functions</h2>
                <div class="grid gap-4 md:grid-cols-3">
                    <div class="p-4 border border-gray-200 dark:border-gray-700 rounded-lg">
                        <h3 class="font-medium text-gray-900 dark:text-white mb-2">User Management</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">View and manage regular users</p>
                        <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium">
                            Manage Users
                        </button>
                    </div>
                    <div class="p-4 border border-gray-200 dark:border-gray-700 rounded-lg">
                        <h3 class="font-medium text-gray-900 dark:text-white mb-2">Reports</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">Generate and view system reports</p>
                        <button class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium">
                            View Reports
                        </button>
                    </div>
                    <div class="p-4 border border-gray-200 dark:border-gray-700 rounded-lg">
                        <h3 class="font-medium text-gray-900 dark:text-white mb-2">Monitoring</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">Monitor system performance and activities</p>
                        <button class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg text-sm font-medium">
                            Monitor System
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
