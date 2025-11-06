<script lang="ts" setup>
import InputError from '@/components/InputError.vue';
import Button from '@/components/ui/button/Button.vue';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Form, FormField } from '@/components/ui/form';
import Input from '@/components/ui/input/Input.vue';
import Label from '@/components/ui/label/Label.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { Storage, StorageItem } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';

interface Props {
    storage: Storage;
    storageItem: StorageItem;
}

const props = defineProps<Props>();

const form = useForm({
    quantity: props.storage.description,
});

function updateSupply() {
    form.patch(route('storages.items.update', props.storage.id));
}
</script>

<template>
    <AppLayout>
        <Head :title="`Edit ${storage.name}'s ${storageItem.supply?.name} stock'`" />

        <Card>
            <CardHeader>
                <CardTitle>Edit {{ storage.name }}'s {{ storageItem.supply?.name }} stock</CardTitle>
            </CardHeader>

            <CardContent>
                <Form @submit.prevent="updateSupply">
                    <FormField>
                        <Label>Storage</Label>

                        <Input
                            :default-value="storage.name"
                            disabled
                        />
                    </FormField>

                    <FormField>
                        <Label>Supply</Label>

                        <Input
                            :default-value="storageItem.supply?.name"
                            disabled
                        />
                    </FormField>

                    <FormField>
                        <Label required>Quantity</Label>

                        <Input
                            type="number"
                            v-model="form.quantity"
                            :default-value="storageItem.quantity"
                            placeholder="Quantity"
                        />

                        <InputError :message="form.errors.quantity" />
                    </FormField>

                    <Button :disabled="form.processing"> Update supply </Button>
                </Form>
            </CardContent>
        </Card>
    </AppLayout>
</template>
