<script lang="ts" setup>
import InputError from '@/components/InputError.vue';
import Button from '@/components/ui/button/Button.vue';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Combobox, ComboboxAnchor, ComboboxEmpty, ComboboxGroup, ComboboxInput, ComboboxItem, ComboboxList } from '@/components/ui/combobox';
import { Form, FormField } from '@/components/ui/form';
import Input from '@/components/ui/input/Input.vue';
import Label from '@/components/ui/label/Label.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { Supply } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';
import axios from 'axios';
import { debounce } from 'lodash';
import { ref } from 'vue';

interface Props {
    storage: Storage;
}

const props = defineProps<Props>();
const form = useForm({
    storage_id: props.storage.id,
    supply_id: 0,
    quantity: 0,
});
const supplies = ref<Supply[]>();

function createSupply() {
    form.post(route('storages.items.store', props.storage.id));
}

const fetchSupplies = debounce(async (query: string) => {
    try {
        const response = await axios.get(`/supplies/search?q=${query}`);
        supplies.value = response.data;
    } catch (err: any) {
        console.error(err.message);
    }
}, 500);
</script>

<template>
    <AppLayout>
        <Head title="Add a stock" />

        <Card>
            <CardHeader>
                <CardTitle>Add a stock to '{{ storage.name }}'</CardTitle>
            </CardHeader>

            <CardContent>
                <Form @submit.prevent="createSupply">
                    <FormField>
                        <Label required>Supply</Label>

                        <Combobox>
                            <ComboboxAnchor>
                                <ComboboxInput
                                    @update:modelValue="fetchSupplies"
                                    :display-value="(v) => v.name"
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
                                        @select="() => (form.supply_id = supply.id)"
                                    >
                                        {{ supply.name }}
                                    </ComboboxItem>
                                </ComboboxGroup>
                            </ComboboxList>
                        </Combobox>

                        <InputError :message="form.errors.supply_id" />
                    </FormField>

                    <FormField>
                        <Label required>Quantity</Label>

                        <Input
                            type="number"
                            v-model="form.quantity"
                            placeholder="Quantity"
                        />

                        <InputError :message="form.errors.quantity" />
                    </FormField>

                    <Button :disabled="form.processing"> Create supply </Button>
                </Form>
            </CardContent>
        </Card>
    </AppLayout>
</template>
