<script lang="ts" setup>
import InputError from '@/components/InputError.vue';
import Button from '@/components/ui/button/Button.vue';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Combobox, ComboboxAnchor, ComboboxEmpty, ComboboxGroup, ComboboxInput, ComboboxItem, ComboboxList } from '@/components/ui/combobox';
import Input from '@/components/ui/input/Input.vue';
import Label from '@/components/ui/label/Label.vue';
import { NumberField, NumberFieldContent, NumberFieldDecrement, NumberFieldIncrement, NumberFieldInput } from '@/components/ui/number-field';
import { Table, TableBody, TableCell, TableEmpty, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import Textarea from '@/components/ui/textarea/Textarea.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { Supply } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';
import axios from 'axios';
import { debounce } from 'lodash';
import { ref } from 'vue';

interface SupplyRequestItem {
    supply_id: number;
    name: string;
    quantity: number;
    stock: number;
}

const supplies = ref<Supply[] | null>(null);
const supplyRequestItems = ref<SupplyRequestItem[]>([]);
const form = useForm({
    subject: '',
    message: '',
    supply_request_items: [] as any,
});

function createSupplyRequest() {
    form.supply_request_items = supplyRequestItems.value;

    form.post('/supply-requests');
}

const fetchSupplies = debounce(async (query: string) => {
    try {
        const response = await axios.get(`/supplies/search?q=${query}`);
        supplies.value = response.data;
    } catch (err: any) {
        console.error(err.message);
    }
}, 500);

function addSupply(supply: Supply) {
    const alreadyAdded = supplyRequestItems.value.some((s) => s.supply_id === supply.id);
    if (alreadyAdded) return;

    supplyRequestItems.value.push({
        supply_id: supply.id,
        name: supply.name,
        quantity: 1,
        stock: supply.quantity,
    });
}
</script>

<template>
    <AppLayout>
        <Head title="Request supplies" />

        <Card>
            <CardHeader>
                <CardTitle>Request supplies</CardTitle>
            </CardHeader>

            <CardContent>
                <form @submit.prevent="createSupplyRequest">
                    <div class="mb-6 flex flex-col gap-2">
                        <Label required>Subject</Label>

                        <Input
                            v-model="form.subject"
                            placeholder="Subject"
                        />

                        <InputError :message="form.errors.subject" />
                    </div>

                    <div class="mb-6 flex flex-col gap-2">
                        <Label>Message</Label>

                        <Textarea
                            v-model="form.message"
                            placeholder="Compose a convincing message"
                        />

                        <InputError :message="form.errors.message" />
                    </div>

                    <div class="mb-6 flex flex-col gap-2">
                        <Label required>Supplies</Label>

                        <div class="rounded-lg border">
                            <Combobox class="p-4">
                                <ComboboxAnchor>
                                    <ComboboxInput
                                        @update:modelValue="fetchSupplies"
                                        placeholder="Search supplies"
                                        autocomplete="off"
                                    />
                                </ComboboxAnchor>

                                <ComboboxList>
                                    <ComboboxEmpty v-if="!supplies?.length"> No Supplies found. </ComboboxEmpty>

                                    <ComboboxGroup>
                                        <ComboboxItem
                                            v-for="supply in supplies"
                                            :key="supply.id"
                                            :value="supply"
                                            @select="() => addSupply(supply)"
                                        >
                                            {{ supply.name }}
                                        </ComboboxItem>
                                    </ComboboxGroup>
                                </ComboboxList>
                            </Combobox>

                            <Table>
                                <TableHeader>
                                    <TableRow>
                                        <TableHead>#</TableHead>
                                        <TableHead>Name</TableHead>
                                        <TableHead>Stock</TableHead>
                                        <TableHead class="text-end">Quantity</TableHead>
                                    </TableRow>
                                </TableHeader>
                                <TableBody>
                                    <TableRow
                                        v-for="(supplyRequestItem, index) in supplyRequestItems"
                                        :key="supplyRequestItem.supply_id"
                                    >
                                        <TableCell>{{ index + 1 }}</TableCell>

                                        <TableCell>{{ supplyRequestItem.name }}</TableCell>

                                        <TableCell>{{ supplyRequestItem.stock }}</TableCell>

                                        <TableCell class="flex justify-end">
                                            <NumberField
                                                class="max-w-fit"
                                                v-model="supplyRequestItem.quantity"
                                                :min="1"
                                                :max="supplyRequestItem.stock"
                                            >
                                                <NumberFieldContent>
                                                    <NumberFieldDecrement />
                                                    <NumberFieldInput />
                                                    <NumberFieldIncrement />
                                                </NumberFieldContent>
                                            </NumberField>
                                        </TableCell>
                                    </TableRow>

                                    <TableEmpty
                                        v-if="!supplyRequestItems.length"
                                        :colspan="5"
                                    >
                                        Select a supply.
                                    </TableEmpty>
                                </TableBody>
                            </Table>
                        </div>

                        <InputError :message="form.errors.supply_request_items" />
                    </div>

                    <div class="flex items-center justify-end">
                        <Button :disabled="form.processing">Request supplies</Button>
                    </div>
                </form>
            </CardContent>
        </Card>
    </AppLayout>
</template>
