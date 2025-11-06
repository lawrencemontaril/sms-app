<script setup lang="ts">
import { DropdownMenuGroup, DropdownMenuItem, DropdownMenuLabel, DropdownMenuSeparator } from '@/components/ui/dropdown-menu';
import type { User } from '@/types';
import { router } from '@inertiajs/vue3';

interface Props {
    user: User;
}

defineProps<Props>();

function markNotificationAsRead(id: string) {
    router.post(route('notifications.read', id));
}
</script>

<template>
    <DropdownMenuLabel class="text-muted-foreground p-3 text-base font-semibold"> Notifications </DropdownMenuLabel>

    <DropdownMenuSeparator />

    <DropdownMenuGroup>
        <div
            v-if="user.notifications.length"
            class="flex flex-col"
        >
            <DropdownMenuItem
                v-for="notification in user.notifications"
                :key="notification.id"
                :as-child="true"
                class="group hover:bg-muted focus:bg-muted rounded-md px-3 py-2 transition-colors"
            >
                <button
                    class="block w-full text-left focus:outline-none"
                    @click="markNotificationAsRead(notification.id)"
                >
                    <p class="text-foreground group-hover:text-primary text-sm font-medium">
                        {{ notification.message }}
                    </p>
                    <p class="text-muted-foreground mt-0.5 text-xs">
                        {{ notification.created_at }}
                    </p>
                </button>
            </DropdownMenuItem>
        </div>

        <div
            v-else
            class="text-muted-foreground px-4 py-3 text-sm"
        >
            No new notifications.
        </div>
    </DropdownMenuGroup>
</template>
