<script lang="ts" setup>
import Pagination from '@/components/Pagination.vue';
import TextLink from '@/components/TextLink.vue';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Table, TableBody, TableCell, TableEmpty, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import AppLayout from '@/layouts/AppLayout.vue';
import { PaginatedData, Storage, StorageItem } from '@/types';
import { Head, Link } from '@inertiajs/vue3';

interface Props {
    storage: Storage;
    storage_items: PaginatedData<StorageItem>;
}

defineProps<Props>();
</script>

<template>
    <AppLayout>
        <Head :title="storage.name" />

        <Card>
            <CardHeader>
                <div class="flex items-center justify-between gap-4">
                    <CardTitle>{{ storage.name }}</CardTitle>

                    <Link
                        :href="`/storages/${storage.id}/stocks/create`"
                        as-child
                    >
                        <Button> Add a stock </Button>
                    </Link>
                </div>
            </CardHeader>

            <CardContent>
                <Table>
                    <TableHeader>
                        <TableRow>
                            <TableHead>#</TableHead>
                            <TableHead>Supply</TableHead>
                            <TableHead>Quantity</TableHead>
                            <TableHead>Reorder Level</TableHead>
                            <TableHead>Actions</TableHead>
                        </TableRow>
                    </TableHeader>

                    <TableBody>
                        <TableRow
                            v-for="(storage_item, index) in storage_items.data"
                            :key="storage_item.id"
                        >
                            <TableCell>{{ index + 1 }}</TableCell>

                            <TableCell>{{ storage_item.supply?.name }}</TableCell>

                            <TableCell>{{ storage_item.quantity }}</TableCell>

                            <TableCell>{{ storage_item.supply?.reorder_level }}</TableCell>

                            <TableCell>
                                <TextLink :href="route('storages.items.edit', [storage.id, storage_item.id])"> Edit </TextLink>
                            </TableCell>
                        </TableRow>

                        <TableEmpty
                            v-if="!storage_items?.data.length"
                            :colspan="6"
                        >
                            Select a supply.
                        </TableEmpty>
                    </TableBody>

                    <!-- <TableFooter>
                            <TableRow>
                                <TableCell :colspan="4"></TableCell>
                                <TableCell>Total</TableCell>
                                <TableCell>
                                    {{ formatCurrency(supply_request.total_cost) }}
                                </TableCell>
                            </TableRow>
                        </TableFooter> -->
                </Table>

                <Pagination :meta="storage_items.meta" />
            </CardContent>
        </Card>
    </AppLayout>
</template>
