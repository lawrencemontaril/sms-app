<script lang="ts" setup>
import Pagination from '@/components/Pagination.vue';
import TextLink from '@/components/TextLink.vue';
import Button from '@/components/ui/button/Button.vue';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { usePermissions } from '@/composables/usePermissions';
import AppLayout from '@/layouts/AppLayout.vue';
import { Department, PaginatedData } from '@/types';
import { Head, Link } from '@inertiajs/vue3';

interface Props {
    departments: PaginatedData<Department>;
}

defineProps<Props>();

const { hasPermissionTo } = usePermissions();
</script>

<template>
    <AppLayout>
        <Head title="Departments" />

        <Card>
            <CardHeader>
                <div class="flex items-center justify-between gap-4">
                    <CardTitle>Departments</CardTitle>

                    <Link
                        v-if="hasPermissionTo('departments.create')"
                        href="/departments/create"
                        as-child
                    >
                        <Button> Create a department </Button>
                    </Link>
                </div>
            </CardHeader>

            <CardContent>
                <Table>
                    <TableHeader>
                        <TableRow>
                            <TableHead>#</TableHead>
                            <TableHead>Name</TableHead>
                            <TableHead>Code</TableHead>
                            <TableHead>Head</TableHead>
                            <TableHead>Actions</TableHead>
                        </TableRow>
                    </TableHeader>

                    <TableBody>
                        <TableRow
                            v-for="(department, index) in departments.data"
                            :key="department.id"
                        >
                            <TableCell>{{ (departments.meta.from ?? 0) + index }}</TableCell>

                            <TableCell>{{ department.name }}</TableCell>

                            <TableCell>{{ department.code }}</TableCell>

                            <TableCell>{{ department.head?.name ?? 'N/A' }}</TableCell>

                            <TableCell><TextLink :href="`/departments/${department.id}/edit`">Edit</TextLink></TableCell>
                        </TableRow>
                    </TableBody>
                </Table>

                <Pagination :meta="departments.meta" />
            </CardContent>
        </Card>
    </AppLayout>
</template>
