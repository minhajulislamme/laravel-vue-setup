<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Button } from '@/components/ui/button';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import { Settings, Shield, Users, Database, Bell, Lock } from 'lucide-vue-next';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'System Settings',
        href: '/super-admin/settings',
    },
];

const settingsCategories = [
    {
        title: 'User Management',
        description: 'Configure user roles, permissions, and default settings',
        icon: Users,
        status: 'Active',
        statusColor: 'bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-300',
        items: ['Role Management', 'User Defaults', 'Account Policies']
    },
    {
        title: 'Security Settings',
        description: 'Manage authentication, encryption, and security policies',
        icon: Lock,
        status: 'Secure',
        statusColor: 'bg-blue-100 text-blue-800 dark:bg-blue-900/20 dark:text-blue-300',
        items: ['2FA Settings', 'Password Policies', 'Session Management']
    },
    {
        title: 'Database Configuration',
        description: 'Database maintenance, backups, and optimization settings',
        icon: Database,
        status: 'Healthy',
        statusColor: 'bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-300',
        items: ['Backup Schedule', 'Maintenance', 'Performance Monitoring']
    },
    {
        title: 'Notification Settings',
        description: 'Configure system notifications and email templates',
        icon: Bell,
        status: 'Configured',
        statusColor: 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/20 dark:text-yellow-300',
        items: ['Email Templates', 'Push Notifications', 'Alert Preferences']
    }
];
</script>

<template>
    <Head title="System Settings" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4 overflow-x-auto">
            <div class="mb-6">
                <div class="flex items-center gap-3 mb-4">
                    <div class="p-3 bg-blue-100 dark:bg-blue-900/20 rounded-lg">
                        <Settings class="h-8 w-8 text-blue-600 dark:text-blue-400" />
                    </div>
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">System Settings</h1>
                        <p class="text-gray-600 dark:text-gray-400">Configure and manage system-wide settings</p>
                    </div>
                </div>
            </div>

            <!-- Settings Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <Card v-for="category in settingsCategories" :key="category.title" class="hover:shadow-lg transition-shadow duration-200">
                    <CardHeader class="space-y-4">
                        <div class="flex items-start justify-between">
                            <div class="flex items-center gap-3">
                                <div class="p-2 bg-gray-100 dark:bg-gray-800 rounded-lg">
                                    <component :is="category.icon" class="h-6 w-6 text-gray-600 dark:text-gray-400" />
                                </div>
                                <div>
                                    <CardTitle class="text-lg">{{ category.title }}</CardTitle>
                                    <CardDescription class="text-sm">{{ category.description }}</CardDescription>
                                </div>
                            </div>
                            <span :class="`px-2 py-1 text-xs font-medium rounded-full ${category.statusColor}`">
                                {{ category.status }}
                            </span>
                        </div>
                    </CardHeader>
                    <CardContent class="space-y-4">
                        <div class="space-y-2">
                            <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Configuration Options:</p>
                            <ul class="space-y-1">
                                <li v-for="item in category.items" :key="item" class="text-sm text-gray-600 dark:text-gray-400 flex items-center gap-2">
                                    <div class="w-1.5 h-1.5 bg-gray-400 rounded-full"></div>
                                    {{ item }}
                                </li>
                            </ul>
                        </div>
                        <Button variant="outline" size="sm" class="w-full">
                            Configure {{ category.title }}
                        </Button>
                    </CardContent>
                </Card>
            </div>

            <!-- System Information -->
            <Card class="mt-6">
                <CardHeader>
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-purple-100 dark:bg-purple-900/20 rounded-lg">
                            <Shield class="h-6 w-6 text-purple-600 dark:text-purple-400" />
                        </div>
                        <div>
                            <CardTitle>System Information</CardTitle>
                            <CardDescription>Current system status and version information</CardDescription>
                        </div>
                    </div>
                </CardHeader>
                <CardContent>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="text-center p-4 bg-gray-50 dark:bg-gray-800 rounded-lg">
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">v1.0.0</p>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Application Version</p>
                        </div>
                        <div class="text-center p-4 bg-gray-50 dark:bg-gray-800 rounded-lg">
                            <p class="text-2xl font-bold text-green-600 dark:text-green-400">Online</p>
                            <p class="text-sm text-gray-600 dark:text-gray-400">System Status</p>
                        </div>
                        <div class="text-center p-4 bg-gray-50 dark:bg-gray-800 rounded-lg">
                            <p class="text-2xl font-bold text-blue-600 dark:text-blue-400">99.9%</p>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Uptime</p>
                        </div>
                    </div>
                </CardContent>
            </Card>
        </div>
    </AppLayout>
</template>
