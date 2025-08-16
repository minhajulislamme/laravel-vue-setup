<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import Badge from '@/components/ui/badge/Badge.vue';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { 
    DropdownMenu, 
    DropdownMenuContent, 
    DropdownMenuItem, 
    DropdownMenuTrigger 
} from '@/components/ui/dropdown-menu';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table/index';
import { type BreadcrumbItem, type User } from '@/types';
import { Head, Link, router, useForm } from '@inertiajs/vue3';
import { Users, Plus, Search, Filter, Edit, Trash2, ToggleLeft, ToggleRight, Download, FileText, Sheet, ChevronDown } from 'lucide-vue-next';
import { ref, watch, computed } from 'vue';

interface Props {
    users: {
        data: User[];
        current_page: number;
        last_page: number;
        per_page: number;
        total: number;
        links: Array<{
            url: string | null;
            label: string;
            active: boolean;
        }>;
    };
    filters: {
        search?: string;
        role?: string;
        status?: string;
    };
}

const props = defineProps<Props>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Super Admin Dashboard',
        href: '/super-admin/dashboard',
    },
    {
        title: 'User Management',
        href: '/super-admin/users',
    },
];

// Search and filters
const searchForm = useForm({
    search: props.filters.search || '',
    role: props.filters.role || '',
    status: props.filters.status || '',
});

const performSearch = () => {
    searchForm.get('/super-admin/users', {
        preserveState: true,
        replace: true,
    });
};

// Watch for changes and auto-search
watch(() => searchForm.search, () => {
    if (searchForm.search.length === 0 || searchForm.search.length >= 3) {
        performSearch();
    }
});

watch(() => [searchForm.role, searchForm.status], () => {
    performSearch();
});

const clearFilters = () => {
    // Reset all form fields
    searchForm.search = '';
    searchForm.role = '';
    searchForm.status = '';
    
    // Force the form to reset and clear any processing state
    searchForm.clearErrors();
    
    // Perform search with cleared filters
    performSearch();
};

// Check if any filters are active
const hasActiveFilters = computed(() => {
    return searchForm.search || searchForm.role || searchForm.status;
});

// Download functions
const downloadPDF = () => {
    const queryParams = new URLSearchParams();
    
    if (searchForm.search) queryParams.append('search', searchForm.search);
    if (searchForm.role) queryParams.append('role', searchForm.role);
    if (searchForm.status) queryParams.append('status', searchForm.status);
    queryParams.append('format', 'pdf');
    
    window.open(`/super-admin/users/export?${queryParams.toString()}`, '_blank');
};

const downloadExcel = () => {
    const queryParams = new URLSearchParams();
    
    if (searchForm.search) queryParams.append('search', searchForm.search);
    if (searchForm.role) queryParams.append('role', searchForm.role);
    if (searchForm.status) queryParams.append('status', searchForm.status);
    queryParams.append('format', 'excel');
    
    window.open(`/super-admin/users/export?${queryParams.toString()}`, '_blank');
};

const toggleUserStatus = (user: User) => {
    router.patch(`/super-admin/users/${user.id}/toggle-status`, {}, {
        preserveScroll: true,
    });
};

const deleteUser = (user: User) => {
    if (confirm(`Are you sure you want to delete ${user.name}?`)) {
        router.delete(`/super-admin/users/${user.id}`, {
            preserveScroll: true,
        });
    }
};

const getRoleBadgeColor = (role: string) => {
    switch (role) {
        case 'super_admin':
            return 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300';
        case 'admin':
            return 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300';
        default:
            return 'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-300';
    }
};

const getStatusBadgeColor = (status: string) => {
    return status === 'active' 
        ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300'
        : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300';
};
</script>

<template>
    <Head title="User Management" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4 overflow-x-auto">
            <!-- Header -->
            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                        <Users class="h-8 w-8" />
                        User Management
                    </h1>
                    <p class="text-gray-600 dark:text-gray-400">Manage all users, roles, and permissions</p>
                </div>
                <Link :href="route('super-admin.users.create')">
                    <Button class="flex items-center gap-2">
                        <Plus class="h-4 w-4" />
                        Add New User
                    </Button>
                </Link>
            </div>

            <!-- Search and Filters -->
            <Card>
                <CardHeader>
                    <CardTitle class="flex items-center gap-2">
                        <Filter class="h-5 w-5" />
                        Search & Filters
                    </CardTitle>
                </CardHeader>
                <CardContent>
                    <div class="grid gap-4 md:grid-cols-4">
                        <div class="relative">
                            <Search class="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-gray-400" />
                            <Input
                                v-model="searchForm.search"
                                placeholder="Search by name or email..."
                                class="pl-10"
                            />
                        </div>
                        <select 
                            v-model="searchForm.role"
                            class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus:outline-none focus:ring-0 focus:border-primary disabled:cursor-not-allowed disabled:opacity-50"
                        >
                            <option value="">All Roles</option>
                            <option value="super_admin">Super Admin</option>
                            <option value="admin">Admin</option>
                            <option value="user">User</option>
                        </select>
                        <select 
                            v-model="searchForm.status"
                            class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus:outline-none focus:ring-0 focus:border-primary disabled:cursor-not-allowed disabled:opacity-50"
                        >
                            <option value="">All Status</option>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                        
                        <!-- Download Dropdown -->
                        <!-- <DropdownMenu>
                            <DropdownMenuTrigger asChild>
                                <Button variant="outline" class="h-10">
                                    <Download class="w-4 h-4 mr-2" />
                                    Download
                                    <ChevronDown class="w-4 h-4 ml-2" />
                                </Button>
                            </DropdownMenuTrigger>
                            <DropdownMenuContent align="end" class="w-48">
                                <DropdownMenuItem @click="downloadPDF" class="cursor-pointer">
                                    <FileText class="w-4 h-4 mr-2" />
                                    Download as PDF
                                </DropdownMenuItem>
                                <DropdownMenuItem @click="downloadExcel" class="cursor-pointer">
                                    <Sheet class="w-4 h-4 mr-2" />
                                    Download as Excel
                                </DropdownMenuItem>
                            </DropdownMenuContent>
                        </DropdownMenu> -->
                        
                        <Button 
                            variant="outline" 
                            @click="clearFilters" 
                            :disabled="searchForm.processing || !hasActiveFilters"
                            :class="{ 'opacity-50': !hasActiveFilters }"
                        >
                            {{ searchForm.processing ? 'Clearing...' : 'Clear Filters' }}
                        </Button>
                    </div>
                </CardContent>
            </Card>

            <!-- Users Table -->
            <Card>
                <CardHeader>
                    <CardTitle>
                        Users ({{ users.total }} total)
                    </CardTitle>
                </CardHeader>
                <CardContent>
                    <div class="overflow-x-auto">
                        <Table>
                            <TableHeader>
                                <TableRow>
                                    <TableHead>User</TableHead>
                                    <TableHead>Role</TableHead>
                                    <TableHead>Status</TableHead>
                                    <TableHead>Created</TableHead>
                                    <TableHead class="text-right">Actions</TableHead>
                                </TableRow>
                            </TableHeader>
                            <TableBody>
                                <TableRow v-for="user in users.data" :key="user.id">
                                    <TableCell>
                                        <div class="flex flex-col">
                                            <span class="font-medium">{{ user.name }}</span>
                                            <span class="text-sm text-gray-500">{{ user.email }}</span>
                                        </div>
                                    </TableCell>
                                    <TableCell>
                                        <Badge :class="getRoleBadgeColor(user.role)" variant="secondary">
                                            {{ user.role.replace('_', ' ').toUpperCase() }}
                                        </Badge>
                                    </TableCell>
                                    <TableCell>
                                        <Badge :class="getStatusBadgeColor(user.status)" variant="secondary">
                                            {{ user.status.toUpperCase() }}
                                        </Badge>
                                    </TableCell>
                                    <TableCell>
                                        {{ new Date(user.created_at).toLocaleDateString() }}
                                    </TableCell>
                                    <TableCell class="text-right">
                                        <div class="flex justify-end gap-2">
                                            <Button
                                                variant="outline"
                                                size="sm"
                                                @click="toggleUserStatus(user)"
                                                :title="user.status === 'active' ? 'Deactivate' : 'Activate'"
                                            >
                                                <ToggleRight v-if="user.status === 'active'" class="h-4 w-4" />
                                                <ToggleLeft v-else class="h-4 w-4" />
                                            </Button>
                                            <Link :href="route('super-admin.users.edit', user.id)">
                                                <Button variant="outline" size="sm">
                                                    <Edit class="h-4 w-4" />
                                                </Button>
                                            </Link>
                                            <Button
                                                variant="destructive"
                                                size="sm"
                                                @click="deleteUser(user)"
                                            >
                                                <Trash2 class="h-4 w-4" />
                                            </Button>
                                        </div>
                                    </TableCell>
                                </TableRow>
                            </TableBody>
                        </Table>
                    </div>

                    <!-- Pagination -->
                    <div v-if="users.last_page > 1" class="mt-6 flex items-center justify-between">
                        <div class="text-sm text-gray-500">
                            Showing {{ (users.current_page - 1) * users.per_page + 1 }} to 
                            {{ Math.min(users.current_page * users.per_page, users.total) }} of 
                            {{ users.total }} results
                        </div>
                        <div class="flex gap-2">
                            <Link
                                v-for="link in users.links"
                                :key="link.label"
                                :href="link.url || '#'"
                                :class="[
                                    'px-3 py-2 text-sm border rounded-md',
                                    link.active 
                                        ? 'bg-primary text-primary-foreground border-primary' 
                                        : 'bg-background text-foreground border-border hover:bg-accent',
                                    !link.url ? 'opacity-50 cursor-not-allowed' : ''
                                ]"
                                v-html="link.label"
                            />
                        </div>
                    </div>

                    <!-- Download Section -->
                    <div class="mt-6 flex items-center justify-between border-t pt-4">
                        <div class="text-sm text-gray-500">
                            Export {{ users.total }} users with current filters
                        </div>
                        <div class="flex gap-2">
                            <DropdownMenu>
                                <DropdownMenuTrigger asChild>
                                    <Button variant="outline" class="h-9">
                                        <Download class="w-4 h-4 mr-2" />
                                        Export Data
                                        <ChevronDown class="w-4 h-4 ml-2" />
                                    </Button>
                                </DropdownMenuTrigger>
                                <DropdownMenuContent align="end" class="w-48">
                                    <DropdownMenuItem @click="downloadPDF" class="cursor-pointer">
                                        <FileText class="w-4 h-4 mr-2" />
                                        Download as PDF
                                    </DropdownMenuItem>
                                    <DropdownMenuItem @click="downloadExcel" class="cursor-pointer">
                                        <Sheet class="w-4 h-4 mr-2" />
                                        Download as Excel
                                    </DropdownMenuItem>
                                </DropdownMenuContent>
                            </DropdownMenu>
                        </div>
                    </div>
                </CardContent>
            </Card>
        </div>
    </AppLayout>
</template>
