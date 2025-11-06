<script lang="ts" setup>
import Pagination from '@/components/Pagination.vue';
import TextLink from '@/components/TextLink.vue';
import Badge from '@/components/ui/badge/Badge.vue';
import Button from '@/components/ui/button/Button.vue';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import AppLayout from '@/layouts/AppLayout.vue';
import { PaginatedData, User } from '@/types';
import { Head, Link } from '@inertiajs/vue3';

interface Props {
    users: PaginatedData<User>;
}

defineProps<Props>();

const userRoles = {
    procurement: 'zinc',
    accounting: 'default',
    faculty: 'outline',
};
</script>

<template>
    <AppLayout>
        <Head title="Users" />

        <Card>
            <CardHeader>
                <div class="flex items-center justify-between gap-4">
                    <CardTitle>Users</CardTitle>

                    <Link href="/users/create" as-child>
                        <Button> Create a user </Button>
                    </Link>
                </div>
            </CardHeader>

            <CardContent>
                <Table>
                    <TableHeader>
                        <TableRow>
                            <TableHead>#</TableHead>
                            <TableHead>Name</TableHead>
                            <TableHead>Email</TableHead>
                            <TableHead>Role</TableHead>
                            <TableHead>Department</TableHead>
                            <TableHead>Actions</TableHead>
                        </TableRow>
                    </TableHeader>

                    <TableBody>
                        <TableRow v-for="(user, index) in users.data" :key="user.id">
                            <TableCell>{{ (users.meta.from ?? 0) + index }}</TableCell>

                            <TableCell>{{ user.name }}</TableCell>

                            <TableCell>{{ user.email }}</TableCell>

                            <TableCell>
                                <Badge :variant="userRoles[user.role]" class="capitalize">
                                    {{ user.role }} {{ user.is_department_head ? 'Head' : '' }}
                                </Badge>
                            </TableCell>

                            <TableCell>{{ user.department?.name }}</TableCell>

                            <TableCell><TextLink :href="`/users/${user.id}/edit`">Edit</TextLink></TableCell>
                        </TableRow>
                    </TableBody>
                </Table>

                <Pagination :meta="users.meta" />
            </CardContent>
        </Card>
    </AppLayout>
</template>
