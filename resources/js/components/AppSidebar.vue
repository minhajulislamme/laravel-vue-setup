<script setup lang="ts">
import NavFooter from '@/components/NavFooter.vue';
import NavMain from '@/components/NavMain.vue';
import NavUser from '@/components/NavUser.vue';
import { Sidebar, SidebarContent, SidebarFooter, SidebarHeader, SidebarMenu, SidebarMenuButton, SidebarMenuItem } from '@/components/ui/sidebar';
import { type NavItem, type User } from '@/types';
import { Link, usePage } from '@inertiajs/vue3';
import { BookOpen, Folder, LayoutGrid, Users, Settings, Shield, UserCog } from 'lucide-vue-next';
import { computed } from 'vue';
import AppLogo from './AppLogo.vue';

const page = usePage();
const user = computed(() => page.props.auth.user as User);

const mainNavItems = computed((): NavItem[] => {
    const items: NavItem[] = [];
    const userRole = user.value?.role;

    // Role-specific dashboard links
    if (userRole === 'super_admin') {
        items.push({
            title: 'Super Admin Dashboard',
            href: '/super-admin/dashboard',
            icon: Shield,
        });
        items.push({
            title: 'User Management',
            href: '/super-admin/users',
            icon: Users,
        });
        items.push({
            title: 'System Settings',
            href: '/super-admin/settings',
            icon: Settings,
        });
    } else if (userRole === 'admin') {
        items.push({
            title: 'Admin Dashboard',
            href: '/admin/dashboard',
            icon: LayoutGrid,
        });
        items.push({
            title: 'User Management',
            href: '/admin/users',
            icon: Users,
        });
    } else {
        items.push({
            title: 'Dashboard',
            href: '/user/dashboard',
            icon: LayoutGrid,
        });
        items.push({
            title: 'Profile',
            href: '/user/profile',
            icon: UserCog,
        });
    }

    return items;
});

const footerNavItems: NavItem[] = [
    {
        title: 'Github Repo',
        href: 'https://github.com/laravel/vue-starter-kit',
        icon: Folder,
    },
    {
        title: 'Documentation',
        href: 'https://laravel.com/docs/starter-kits#vue',
        icon: BookOpen,
    },
];

const dashboardRoute = computed(() => {
    const userRole = user.value?.role;
    if (userRole === 'super_admin') {
        return '/super-admin/dashboard';
    } else if (userRole === 'admin') {
        return '/admin/dashboard';
    } else {
        return '/user/dashboard';
    }
});
</script>

<template>
    <Sidebar collapsible="icon" variant="inset">
        <SidebarHeader>
            <SidebarMenu>
                <SidebarMenuItem>
                    <SidebarMenuButton size="lg" as-child>
                        <Link :href="dashboardRoute">
                            <AppLogo />
                        </Link>
                    </SidebarMenuButton>
                </SidebarMenuItem>
            </SidebarMenu>
        </SidebarHeader>

        <SidebarContent>
            <NavMain :items="mainNavItems" />
        </SidebarContent>

        <SidebarFooter>
            <NavFooter :items="footerNavItems" />
            <NavUser />
        </SidebarFooter>
    </Sidebar>
    <slot />
</template>
