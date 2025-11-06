<script setup lang="ts">
import AppLogo from '@/components/AppLogo.vue';
import AppLogoIcon from '@/components/AppLogoIcon.vue';
import Breadcrumbs from '@/components/Breadcrumbs.vue';
import { Avatar, AvatarFallback, AvatarImage } from '@/components/ui/avatar';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { DropdownMenu, DropdownMenuContent, DropdownMenuTrigger } from '@/components/ui/dropdown-menu';
import {
    NavigationMenu,
    NavigationMenuItem,
    NavigationMenuLink,
    NavigationMenuList,
    navigationMenuTriggerStyle,
} from '@/components/ui/navigation-menu';
import { Sheet, SheetContent, SheetHeader, SheetTitle, SheetTrigger } from '@/components/ui/sheet';
import UserMenuContent from '@/components/UserMenuContent.vue';
import { getInitials } from '@/composables/useInitials';
import { usePermissions } from '@/composables/usePermissions';
import type { BreadcrumbItem, NavItem, SharedData } from '@/types';
import { Link, usePage } from '@inertiajs/vue3';
import { Bell, Building, Container, GitPullRequestArrow, LayoutGrid, Menu, User } from 'lucide-vue-next';
import { computed } from 'vue';
import NotificationMenuContent from './NotificationMenuContent.vue';

interface Props {
    breadcrumbs?: BreadcrumbItem[];
}

const props = withDefaults(defineProps<Props>(), {
    breadcrumbs: () => [],
});
const { hasPermissionTo } = usePermissions();

const page = usePage<SharedData>();
const auth = computed(() => page.props.auth);

const isCurrentRoute = computed(() => (navItem: NavItem) => page.url === navItem.href || navItem.isActive);

const activeItemStyles = computed(
    () => (navItem: NavItem) =>
        isCurrentRoute.value(navItem) || navItem.isActive ? 'text-neutral-900 dark:bg-neutral-800 dark:text-neutral-100' : '',
);

const mainNavItems: NavItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
        icon: LayoutGrid,
        access: true,
    },
    {
        title: 'Supply Requests',
        href: '/supply-requests',
        icon: GitPullRequestArrow,
        access: hasPermissionTo('supplyRequests.viewAny'),
        isActive: route().current('supply-request.*'),
    },
    {
        title: 'Supplies',
        href: '/supplies',
        icon: Container,
        access: hasPermissionTo('supplies.viewAny'),
        isActive: route().current('supplies.*'),
    },
    {
        title: 'Users',
        href: '/users',
        icon: User,
        access: hasPermissionTo('users.viewAny'),
        isActive: route().current('users.*'),
    },
    {
        title: 'Departments',
        href: '/departments',
        icon: Building,
        access: hasPermissionTo('departments.viewAny'),
        isActive: route().current('departments.*'),
    },
];
</script>

<template>
    <div class="sticky top-0 z-50">
        <div class="bg-background border-sidebar-border/80 border-b">
            <div class="mx-auto flex h-16 items-center px-4 md:max-w-7xl">
                <!-- Mobile Menu -->
                <div class="lg:hidden">
                    <Sheet>
                        <SheetTrigger :as-child="true">
                            <Button
                                variant="ghost"
                                size="icon"
                                class="mr-2 h-9 w-9"
                            >
                                <Menu class="h-5 w-5" />
                            </Button>
                        </SheetTrigger>
                        <SheetContent
                            side="left"
                            class="w-[300px] p-6"
                        >
                            <SheetTitle class="sr-only">Navigation Menu</SheetTitle>
                            <SheetHeader class="flex justify-start text-left">
                                <AppLogoIcon class="size-12 fill-current text-black dark:text-white" />
                            </SheetHeader>
                            <div class="flex h-full flex-1 flex-col justify-between space-y-4 py-6">
                                <nav class="-mx-3 space-y-1">
                                    <template v-for="item in mainNavItems">
                                        <Link
                                            v-if="item.access"
                                            :key="item.title"
                                            :href="item.href"
                                            class="hover:bg-accent flex items-center gap-x-3 rounded-lg px-3 py-2 text-sm font-medium"
                                            :class="activeItemStyles(item)"
                                        >
                                            <component
                                                v-if="item.icon"
                                                :is="item.icon"
                                                class="h-5 w-5"
                                            />
                                            {{ item.title }}
                                        </Link>
                                    </template>
                                </nav>
                            </div>
                        </SheetContent>
                    </Sheet>
                </div>

                <Link
                    :href="route('dashboard')"
                    class="flex items-center gap-x-2"
                >
                    <AppLogo />
                </Link>

                <!-- Desktop Menu -->
                <div class="hidden h-full lg:flex lg:flex-1">
                    <NavigationMenu class="ml-10 flex h-full items-stretch">
                        <NavigationMenuList class="flex h-full items-stretch space-x-2">
                            <NavigationMenuItem
                                v-for="(item, index) in mainNavItems"
                                :key="index"
                                class="relative flex h-full items-center"
                            >
                                <Link
                                    v-if="item.access"
                                    :href="item.href"
                                >
                                    <NavigationMenuLink :class="[navigationMenuTriggerStyle(), activeItemStyles(item), 'h-9 cursor-pointer px-3']">
                                        <component
                                            v-if="item.icon"
                                            :is="item.icon"
                                            class="mr-2 h-4 w-4"
                                        />
                                        {{ item.title }}
                                    </NavigationMenuLink>
                                </Link>
                                <div
                                    v-if="isCurrentRoute(item)"
                                    class="absolute bottom-0 left-0 h-0.5 w-full translate-y-px bg-black dark:bg-white"
                                ></div>
                            </NavigationMenuItem>
                        </NavigationMenuList>
                    </NavigationMenu>
                </div>

                <div class="ml-auto flex items-center space-x-2">
                    <Badge
                        variant="zinc"
                        class="capitalize"
                    >
                        {{ auth.user?.role }} {{ auth.user?.is_department_head ? 'Head' : '' }}
                    </Badge>

                    <DropdownMenu>
                        <DropdownMenuTrigger>
                            <div class="relative">
                                <Button
                                    variant="secondary"
                                    size="icon"
                                >
                                    <Bell />
                                </Button>

                                <span
                                    v-if="auth.user.notifications?.length"
                                    class="bg-destructive absolute -top-1 -right-1 flex h-4 w-4 items-center justify-center rounded-full text-[10px] leading-none font-semibold text-white"
                                >
                                    {{ auth.user.notifications.length }}
                                </span>
                            </div>
                        </DropdownMenuTrigger>

                        <DropdownMenuContent align="center">
                            <NotificationMenuContent :user="auth.user" />
                        </DropdownMenuContent>
                    </DropdownMenu>

                    <DropdownMenu>
                        <DropdownMenuTrigger :as-child="true">
                            <Button
                                variant="ghost"
                                size="icon"
                                class="focus-within:ring-primary relative size-10 w-auto rounded-full p-1 focus-within:ring-2"
                            >
                                <Avatar class="size-8 overflow-hidden rounded-full">
                                    <AvatarImage
                                        v-if="auth.user.avatar"
                                        :src="auth.user.avatar"
                                        :alt="auth.user.name"
                                    />
                                    <AvatarFallback class="rounded-lg bg-neutral-200 font-semibold text-black dark:bg-neutral-700 dark:text-white">
                                        {{ getInitials(auth.user?.name) }}
                                    </AvatarFallback>
                                </Avatar>
                            </Button>
                        </DropdownMenuTrigger>
                        <DropdownMenuContent
                            align="end"
                            class="w-56"
                        >
                            <UserMenuContent :user="auth.user" />
                        </DropdownMenuContent>
                    </DropdownMenu>
                </div>
            </div>
        </div>

        <div
            v-if="props.breadcrumbs.length > 1"
            class="border-sidebar-border/70 flex w-full border-b"
        >
            <div class="mx-auto flex h-12 w-full items-center justify-start px-4 text-neutral-500 md:max-w-7xl">
                <Breadcrumbs :breadcrumbs="breadcrumbs" />
            </div>
        </div>
    </div>
</template>
