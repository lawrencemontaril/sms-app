<script lang="ts" setup>
import InputError from '@/components/InputError.vue';
import Button from '@/components/ui/button/Button.vue';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Form, FormField } from '@/components/ui/form';
import Input from '@/components/ui/input/Input.vue';
import Label from '@/components/ui/label/Label.vue';
import { NumberField, NumberFieldContent, NumberFieldDecrement, NumberFieldIncrement, NumberFieldInput } from '@/components/ui/number-field';
import Textarea from '@/components/ui/textarea/Textarea.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { Supply } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';

interface Props {
    supply: Supply;
}

const props = defineProps<Props>();

const form = useForm({
    name: props.supply.name,
    description: props.supply.description,
    price: props.supply.price,
    quantity: props.supply.quantity,
    reorder_level: props.supply.reorder_level,
});

function updateSupply() {
    form.patch(`/supplies/${props.supply.id}`);
}
</script>

<template>
    <AppLayout>
        <Head title="Create supply" />

        <Card>
            <CardHeader>
                <CardTitle>Edit supply</CardTitle>
            </CardHeader>

            <CardContent>
                <Form @submit.prevent="updateSupply">
                    <FormField>
                        <Label required>Name</Label>

                        <Input
                            v-model="form.name"
                            :default-value="supply.name"
                            placeholder="Name"
                        />

                        <InputError :message="form.errors.name" />
                    </FormField>

                    <FormField>
                        <Label>Description</Label>

                        <Textarea
                            v-model="form.description"
                            :default-value="supply.description"
                            placeholder="Description"
                        />

                        <InputError :message="form.errors.description" />
                    </FormField>

                    <FormField>
                        <Label required>Price</Label>

                        <NumberField
                            v-model="form.price"
                            :default-value="supply.price"
                            :step-snapping="false"
                            :format-options="{
                                style: 'currency',
                                currency: 'PHP',
                                currencyDisplay: 'code',
                                currencySign: 'accounting',
                                signDisplay: 'exceptZero',
                                minimumFractionDigits: 2,
                            }"
                        >
                            <NumberFieldContent>
                                <NumberFieldDecrement />
                                <NumberFieldInput />
                                <NumberFieldIncrement />
                            </NumberFieldContent>
                        </NumberField>

                        <InputError :message="form.errors.price" />
                    </FormField>

                    <FormField>
                        <Label required>Quantity</Label>

                        <Input
                            type="number"
                            v-model="form.quantity"
                            :default-value="supply.quantity"
                            placeholder="Quantity"
                        />

                        <InputError :message="form.errors.quantity" />
                    </FormField>

                    <FormField>
                        <Label required>Reorder Level</Label>

                        <Input
                            type="number"
                            v-model="form.reorder_level"
                            :default-value="supply.reorder_level"
                            placeholder="Reorder Level"
                        />

                        <InputError :message="form.errors.reorder_level" />
                    </FormField>

                    <Button :disabled="form.processing"> Update supply </Button>
                </Form>
            </CardContent>
        </Card>
    </AppLayout>
</template>
