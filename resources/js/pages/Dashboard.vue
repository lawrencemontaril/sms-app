<script setup lang="ts">
import ChartCard from '@/components/ChartCard.vue';
import ChartGrid from '@/components/ChartGrid.vue';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { useFormatters } from '@/composables/useFormatters';
import { usePermissions } from '@/composables/usePermissions';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem, Supply } from '@/types';
import { Deferred, Head } from '@inertiajs/vue3';

interface Props {
    total_supplies: number;
    total_supply_cost: number;
    total_supply_requests: number;
    total_approved_supply_requests: number;
    total_rejected_supply_requests: number;
    supplyRequestStatusChart: any;
    supplyStatusChart: any;
    low_stock_supplies: Supply[];
}

defineProps<Props>();

const { formatCurrency } = useFormatters();
const { hasAnyRole } = usePermissions();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
];
</script>

<template>
    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="p-4">
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3">
                <!-- Supply Cards -->
                <Deferred
                    v-if="hasAnyRole(['procurement', 'accountant'])"
                    data="total_supplies"
                >
                    <template #fallback>
                        <div class="flex h-16 overflow-hidden rounded-xl border border-zinc-700">
                            <div class="flex min-w-16 items-center justify-center bg-zinc-700 text-white">
                                <h1 class="text-2xl">#</h1>
                            </div>
                            <div class="flex items-center justify-center p-4">
                                <p class="uppercase">...</p>
                            </div>
                        </div>
                    </template>
                    <div class="flex h-16 overflow-hidden rounded-xl border border-sky-700">
                        <div class="flex min-w-16 items-center justify-center bg-sky-700 text-white">
                            <h1 class="text-2xl">{{ total_supplies }}</h1>
                        </div>
                        <div class="flex items-center justify-center p-4">
                            <p class="uppercase">TOTAL SUPPLIES</p>
                        </div>
                    </div>
                </Deferred>

                <Deferred data="total_supply_cost">
                    <template #fallback>
                        <div class="flex h-16 overflow-hidden rounded-xl border border-zinc-700">
                            <div class="flex min-w-16 items-center justify-center bg-zinc-700 text-white">
                                <h1 class="text-2xl">#</h1>
                            </div>
                            <div class="flex items-center justify-center p-4">
                                <p class="uppercase">...</p>
                            </div>
                        </div>
                    </template>
                    <div class="flex h-16 overflow-hidden rounded-xl border border-orange-700">
                        <div class="flex w-fit min-w-16 items-center justify-center bg-orange-700 p-4 text-white">
                            <h1 class="text-2xl">{{ formatCurrency(total_supply_cost) }}</h1>
                        </div>
                        <div class="flex items-center justify-center p-4">
                            <p class="uppercase">TOTAL SUPPLY COST</p>
                        </div>
                    </div>
                </Deferred>

                <Deferred data="total_supply_requests">
                    <template #fallback>
                        <div class="flex h-16 overflow-hidden rounded-xl border border-zinc-700">
                            <div class="flex min-w-16 items-center justify-center bg-zinc-700 text-white">
                                <h1 class="text-2xl">#</h1>
                            </div>
                            <div class="flex items-center justify-center p-4">
                                <p class="uppercase">...</p>
                            </div>
                        </div>
                    </template>

                    <div class="flex h-16 overflow-hidden rounded-xl border border-orange-700">
                        <div class="flex w-fit min-w-16 items-center justify-center bg-orange-700 p-4 text-white">
                            <h1 class="text-2xl">{{ total_supply_requests }}</h1>
                        </div>
                        <div class="flex items-center justify-center p-4">
                            <p class="uppercase">TOTAL SUPPLY REQUESTS</p>
                        </div>
                    </div>
                </Deferred>
            </div>

            <ChartGrid :columns="2">
                <ChartCard
                    chartKey="supplyRequestStatusChart"
                    :chart="supplyRequestStatusChart"
                    :col-span="1"
                />

                <ChartCard
                    chartKey="supplyStatusChart"
                    :chart="supplyStatusChart"
                    :col-span="1"
                />
            </ChartGrid>

            <Deferred data="low_stock_supplies">
                <template #fallback> Loading... </template>

                <div
                    class="mt-4"
                    v-if="low_stock_supplies.length"
                >
                    <h1 class="mb-4 text-xl font-medium">Low stock supplies</h1>

                    <Table>
                        <TableHeader>
                            <TableRow>
                                <TableHead>#</TableHead>
                                <TableHead>Name</TableHead>
                                <TableHead>Quantity</TableHead>
                            </TableRow>
                        </TableHeader>

                        <TableBody>
                            <TableRow
                                v-for="(supply, index) in low_stock_supplies"
                                :key="supply.id"
                            >
                                <TableCell>{{ index + 1 }}</TableCell>
                                <TableCell>{{ supply.name }}</TableCell>
                                <TableCell>{{ supply.quantity }}</TableCell>
                            </TableRow>
                        </TableBody>
                    </Table>
                </div>
            </Deferred>
        </div>
    </AppLayout>
</template>
