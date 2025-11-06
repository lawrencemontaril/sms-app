<script lang="ts" setup>
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Table, TableBody, TableCell, TableEmpty, TableFooter, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { useFormatters } from '@/composables/useFormatters';
import { usePermissions } from '@/composables/usePermissions';
import AppLayout from '@/layouts/AppLayout.vue';
import { SupplyRequest } from '@/types';
import { Head, router } from '@inertiajs/vue3';

interface Props {
    supply_request: SupplyRequest;
}

const props = defineProps<Props>();
const { hasRole } = usePermissions();
const { formatCurrency } = useFormatters();

function approveRequest() {
    router.patch(`/supply-requests/${props.supply_request.id}/approve`);
}

function rejectRequest() {
    router.patch(`/supply-requests/${props.supply_request.id}/reject`);
}
</script>

<template>
    <AppLayout>
        <Head :title="supply_request.subject" />

        <Card>
            <CardHeader>
                <div class="flex flex-col-reverse items-center justify-between gap-4 md:flex-row">
                    <p class="mb-2 text-xs font-semibold text-gray-500 uppercase">
                        <template v-if="supply_request.user?.id === $page.props.auth.user.id"> Your request </template>

                        <template v-else> {{ supply_request.user?.name }}'s request </template>
                    </p>

                    <!-- Action buttons for procurement -->
                    <div
                        v-if="hasRole('procurement')"
                        class="flex gap-2"
                    >
                        <Button
                            v-if="supply_request.status !== 'rejected'"
                            @click="approveRequest"
                            :disabled="!!supply_request.approved_at"
                        >
                            <template v-if="!supply_request.approved_at">Approve request</template>
                            <template v-else>Request approved</template>
                        </Button>

                        <Button
                            variant="destructive"
                            v-if="!supply_request.approved_at"
                            @click="rejectRequest"
                            :disabled="supply_request.status === 'rejected'"
                        >
                            <template v-if="supply_request.status !== 'rejected'">Reject request</template>
                            <template v-else>Request rejected</template>
                        </Button>
                    </div>

                    <!-- Status display for faculty (read-only) -->
                    <div
                        v-else-if="hasRole('faculty') && (supply_request.status === 'rejected' || supply_request.approved_at)"
                        class="text-muted-foreground text-sm font-medium"
                    >
                        <Button
                            variant="destructive"
                            v-if="supply_request.status === 'rejected'"
                            disabled
                            >Request rejected</Button
                        >
                        <Button
                            v-else-if="supply_request.approved_at"
                            disabled
                            >Request approved</Button
                        >
                    </div>
                </div>

                <CardTitle class="mb-2 text-2xl">{{ supply_request.subject }}</CardTitle>

                <p class="text-lg">
                    {{ supply_request.message }}
                </p>
            </CardHeader>

            <CardContent>
                <div class="overflow-hidden rounded-lg border">
                    <div class="p-4">
                        <h1 class="text-lg font-medium">Supplies requested</h1>
                    </div>

                    <Table>
                        <TableHeader>
                            <TableRow>
                                <TableHead>#</TableHead>
                                <TableHead>Name</TableHead>
                                <TableHead>In Stock</TableHead>
                                <TableHead>Quantity Requested</TableHead>
                                <TableHead>Cost</TableHead>
                            </TableRow>
                        </TableHeader>
                        <TableBody>
                            <TableRow
                                v-for="(supply_request_item, index) in supply_request?.supply_request_items"
                                :key="supply_request_item.id"
                            >
                                <TableCell>{{ index + 1 }}</TableCell>

                                <TableCell>{{ supply_request_item.supply?.name }}</TableCell>

                                <TableCell>{{ supply_request_item.supply?.quantity }}</TableCell>

                                <TableCell>
                                    {{ supply_request_item.quantity }}
                                </TableCell>

                                <TableCell>{{ formatCurrency(supply_request_item.cost) }}</TableCell>
                            </TableRow>

                            <TableEmpty
                                v-if="!supply_request?.supply_request_items?.length"
                                :colspan="6"
                            >
                                Select a supply.
                            </TableEmpty>
                        </TableBody>

                        <TableFooter>
                            <TableRow>
                                <TableCell :colspan="3"></TableCell>
                                <TableCell>Total</TableCell>
                                <TableCell>
                                    {{ formatCurrency(supply_request.total_cost) }}
                                </TableCell>
                            </TableRow>
                        </TableFooter>
                    </Table>
                </div>
            </CardContent>
        </Card>
    </AppLayout>
</template>
