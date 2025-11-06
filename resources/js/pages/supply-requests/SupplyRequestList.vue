<script lang="ts" setup>
import Pagination from '@/components/Pagination.vue';
import Badge from '@/components/ui/badge/Badge.vue';
import Button from '@/components/ui/button/Button.vue';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Table, TableBody, TableCell, TableEmpty, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { usePermissions } from '@/composables/usePermissions';
import AppLayout from '@/layouts/AppLayout.vue';
import { PaginatedData, SupplyRequest } from '@/types';
import { Head, Link } from '@inertiajs/vue3';
import { Eye } from 'lucide-vue-next';

defineProps<{
    supply_requests: PaginatedData<SupplyRequest>;
}>();

const { hasAnyPermissionTo, hasPermissionTo } = usePermissions();

const statusBadge: any = {
    pending: 'warning',
    rejected: 'destructive',
    approved: 'success',
};
</script>

<template>
    <AppLayout>
        <Head title="Supply Requests" />

        <Card>
            <CardHeader>
                <div class="flex items-center justify-between gap-4">
                    <CardTitle>Supply Requests</CardTitle>

                    <Link
                        :href="route('supply-requests.create')"
                        v-if="hasPermissionTo('supplyRequests.create')"
                    >
                        <Button> Request supplies </Button>
                    </Link>
                </div>
            </CardHeader>

            <CardContent>
                <Table>
                    <TableHeader>
                        <TableRow>
                            <TableHead>#</TableHead>
                            <TableHead>Subject</TableHead>
                            <TableHead>Requested By</TableHead>
                            <TableHead>Department</TableHead>
                            <TableHead>Status</TableHead>
                            <TableHead v-if="hasAnyPermissionTo(['supply_requsts.view'])">Actions</TableHead>
                        </TableRow>
                    </TableHeader>

                    <TableBody>
                        <TableRow
                            v-for="(supply_request, index) in supply_requests.data"
                            :key="supply_request.id"
                        >
                            <TableCell>{{ (supply_requests.meta.from ?? 0) + index }}</TableCell>

                            <TableCell>{{ supply_request.subject }}</TableCell>

                            <TableCell>{{ supply_request.user?.name }}</TableCell>

                            <TableCell>{{ supply_request.department?.code }}</TableCell>

                            <TableCell>
                                <Badge
                                    :variant="statusBadge[supply_request.status]"
                                    class="capitalize"
                                >
                                    {{ supply_request.status }}
                                </Badge>
                            </TableCell>

                            <TableCell>
                                <Button
                                    v-if="hasPermissionTo('supply_requests.view')"
                                    variant="warning"
                                    size="icon"
                                    as-child
                                >
                                    <Link
                                        :href="route('supplies.show', supply_request.id)"
                                        prefetch
                                    >
                                        <Eye />
                                    </Link>
                                </Button>
                            </TableCell>
                        </TableRow>

                        <TableEmpty
                            v-if="!supply_requests.data.length"
                            :colspan="6"
                        >
                            No supply requests.
                        </TableEmpty>
                    </TableBody>
                </Table>

                <Pagination :meta="supply_requests.meta" />
            </CardContent>
        </Card>
    </AppLayout>
</template>
