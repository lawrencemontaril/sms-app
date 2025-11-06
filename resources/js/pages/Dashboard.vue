<script setup lang="ts">
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { useFormatters } from '@/composables/useFormatters';
import { usePermissions } from '@/composables/usePermissions';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem, Supply } from '@/types';
import { Deferred, Head } from '@inertiajs/vue3';
import { ref } from 'vue';
import ApexChart from 'vue3-apexcharts';

interface Props {
    total_supplies: number;
    total_supply_cost: number;
    total_supply_requests: number;
    total_approved_supply_requests: number;
    total_rejected_supply_requests: number;
    approved_rejected_ratio: { pending: number; approved: number; rejected: number };
    supply_stock_ratio: { no_stock: number; low_stock: number; sufficient_stock: number };
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

const approvedRejectedDonutChartOptions = ref({
    labels: ['Pending', 'Approved', 'Rejected'],
    colors: ['#f59e0b', '#10b981', '#ef4444'], // Green & Red
    responsive: [
        {
            breakpoint: 480,
            options: {
                chart: {
                    width: 300,
                },
                legend: {
                    position: 'bottom',
                },
            },
        },
    ],
});

const supplyStockRatioChartOptions = ref({
    labels: ['Sufficient stock', 'Low stock', 'No stock'],
    colors: ['#22c55e', '#ef4444', '#6b7280'],
    responsive: [
        {
            breakpoint: 480,
            options: {
                chart: {
                    width: 300,
                },
                legend: {
                    position: 'bottom',
                },
            },
        },
    ],
});
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

                <!-- Donut Chart -->
                <Deferred data="approved_rejected_ratio">
                    <template #fallback>
                        <div class="p-4 text-center text-gray-500">Loading chart...</div>
                    </template>

                    <div class="overflow-hidden rounded-xl border border-zinc-700">
                        <div class="border-b border-zinc-700 px-4 py-2">Supply request approval chart</div>

                        <ApexChart
                            type="donut"
                            :options="approvedRejectedDonutChartOptions"
                            :series="[approved_rejected_ratio.pending, approved_rejected_ratio.approved, approved_rejected_ratio.rejected]"
                            width="380"
                        />
                    </div>
                </Deferred>

                <Deferred
                    v-if="hasAnyRole(['procurement', 'accountant'])"
                    data="supply_stock_ratio"
                >
                    <template #fallback>
                        <div class="p-4 text-center text-gray-500">Loading chart...</div>
                    </template>

                    <div class="overflow-hidden rounded-xl border border-zinc-700">
                        <div class="border-b border-zinc-700 px-4 py-2">Supplies stock status</div>

                        <ApexChart
                            type="donut"
                            :options="supplyStockRatioChartOptions"
                            :series="[supply_stock_ratio.sufficient_stock, supply_stock_ratio.low_stock, supply_stock_ratio.no_stock]"
                            width="380"
                        />
                    </div>
                </Deferred>
            </div>

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
