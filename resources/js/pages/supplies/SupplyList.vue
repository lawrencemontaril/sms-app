<script lang="ts" setup>
import Pagination from '@/components/Pagination.vue';
import TextLink from '@/components/TextLink.vue';
import Button from '@/components/ui/button/Button.vue';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import Input from '@/components/ui/input/Input.vue';
import { Select, SelectContent, SelectGroup, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import { Table, TableBody, TableCell, TableEmpty, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { useFormatters } from '@/composables/useFormatters';
import { usePermissions } from '@/composables/usePermissions';
import AppLayout from '@/layouts/AppLayout.vue';
import { cn } from '@/lib/utils';
import { PaginatedData, Supply } from '@/types';
import { Head, Link, router } from '@inertiajs/vue3';
import { Search } from 'lucide-vue-next';
import { ref, watch } from 'vue';

interface Props {
    supplies: PaginatedData<Supply>;
}

const props = defineProps<
    Props & {
        filters: {
            search?: string;
            stock_status?: string;
        };
    }
>();

const { hasPermissionTo } = usePermissions();
const { formatCurrency } = useFormatters();

const search = ref(props.filters.search ?? '');
const stockStatus = ref(props.filters.stock_status ?? 'all');

watch([search, stockStatus], () => {
    router.get(
        '/supplies',
        {
            search: search.value,
            stock_status: stockStatus.value,
        },
        {
            preserveState: true,
            replace: true,
        },
    );
});
</script>

<template>
    <AppLayout>
        <Head title="Supplies" />

        <Card>
            <CardHeader>
                <div class="flex items-center justify-between gap-4">
                    <CardTitle>Supplies</CardTitle>

                    <Link
                        v-if="hasPermissionTo('supplies.create')"
                        href="/supplies/create"
                        as-child
                    >
                        <Button> Create a supply </Button>
                    </Link>
                </div>
            </CardHeader>

            <CardContent>
                <div class="mb-4 flex flex-wrap items-center justify-between gap-4">
                    <div class="flex items-center gap-2">
                        <div class="relative min-w-64">
                            <Search class="text-muted-foreground absolute top-1/2 left-3 h-4 w-4 -translate-y-1/2" />

                            <Input
                                v-model="search"
                                :default-value="filters.search"
                                type="text"
                                placeholder="Search supplies..."
                                class="h-10 pl-10"
                            />
                        </div>

                        <Select
                            v-model="stockStatus"
                            :default-value="filters.stock_status"
                        >
                            <SelectTrigger>
                                <SelectValue placeholder="Select a filter" />
                            </SelectTrigger>

                            <SelectContent>
                                <SelectGroup>
                                    <SelectItem value="all">All stock</SelectItem>
                                    <SelectItem value="no">No stock</SelectItem>
                                    <SelectItem value="low">Low stock</SelectItem>
                                    <SelectItem value="sufficient">Sufficient stock</SelectItem>
                                </SelectGroup>
                            </SelectContent>
                        </Select>
                    </div>
                </div>

                <Table>
                    <TableHeader>
                        <TableRow>
                            <TableHead>#</TableHead>
                            <TableHead>Name</TableHead>
                            <TableHead>Price</TableHead>
                            <TableHead>Quantity</TableHead>
                            <TableHead>Reorder Level</TableHead>
                            <TableHead>Actions</TableHead>
                        </TableRow>
                    </TableHeader>

                    <TableBody>
                        <TableRow
                            v-for="(supply, index) in supplies.data"
                            :class="
                                cn(
                                    supply.is_low_stock && 'border-b-yellow-500/50 bg-yellow-500/25 hover:bg-yellow-500/15',
                                    supply.is_no_stock && 'border-b-red-500/50 bg-red-500/25 hover:bg-red-500/15',
                                )
                            "
                            :key="supply.id"
                        >
                            <TableCell>{{ (supplies.meta.from ?? 0) + index }}</TableCell>

                            <TableCell>{{ supply.name }}</TableCell>

                            <TableCell>{{ formatCurrency(supply.price) }}</TableCell>

                            <TableCell>{{ supply.quantity }}pcs</TableCell>

                            <TableCell>{{ supply.reorder_level }}pcs</TableCell>

                            <TableCell><TextLink :href="`/supplies/${supply.id}/edit`">Edit</TextLink></TableCell>
                        </TableRow>

                        <TableEmpty
                            v-if="!supplies.data.length"
                            :colspan="6"
                        >
                            No supplies.
                        </TableEmpty>
                    </TableBody>
                </Table>

                <Pagination :meta="supplies.meta" />
            </CardContent>
        </Card>
    </AppLayout>
</template>
