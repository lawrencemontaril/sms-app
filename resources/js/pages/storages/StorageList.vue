<script lang="ts" setup>
import Pagination from '@/components/Pagination.vue';
import TextLink from '@/components/TextLink.vue';
import Button from '@/components/ui/button/Button.vue';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Table, TableBody, TableCell, TableEmpty, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { usePermissions } from '@/composables/usePermissions';
import AppLayout from '@/layouts/AppLayout.vue';
import { PaginatedData, Storage } from '@/types';
import { Head, Link } from '@inertiajs/vue3';

interface Props {
    storages: PaginatedData<Storage>;
}

defineProps<Props>();

const { hasPermissionTo } = usePermissions();
</script>

<template>
    <AppLayout>
        <Head title="Storages" />

        <Card>
            <CardHeader>
                <div class="flex items-center justify-between gap-4">
                    <CardTitle>Storages</CardTitle>

                    <Link
                        v-if="hasPermissionTo('storages.create')"
                        href="/storages/create"
                        as-child
                    >
                        <Button> Create a storage </Button>
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
                            <TableHead>Actions</TableHead>
                        </TableRow>
                    </TableHeader>

                    <TableBody>
                        <TableRow
                            v-for="(storage, index) in storages.data"
                            :key="storage.id"
                        >
                            <TableCell>{{ (storages.meta.from ?? 0) + index }}</TableCell>

                            <TableCell>{{ storage.name }}</TableCell>

                            <TableCell>{{ storage.code }}</TableCell>

                            <TableCell class="inline-flex gap-2">
                                <TextLink :href="`/storages/${storage.id}/stocks`">View</TextLink>
                                <TextLink :href="`/storages/${storage.id}/edit`">Edit</TextLink>
                            </TableCell>
                        </TableRow>

                        <TableEmpty
                            v-if="!storages.data.length"
                            :colspan="5"
                        >
                            No storages.
                        </TableEmpty>
                    </TableBody>
                </Table>

                <Pagination :meta="storages.meta" />
            </CardContent>
        </Card>
    </AppLayout>
</template>
