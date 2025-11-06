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
import { Head, useForm } from '@inertiajs/vue3';

const form = useForm({
    name: '',
    description: '',
    price: 0,
    quantity: 0,
    reorder_level: 0,
});

function createSupply() {
    form.post('/supplies');
}
</script>

<template>
    <AppLayout>
        <Head title="Create supply" />

        <Card>
            <CardHeader>
                <CardTitle>Create a supply</CardTitle>
            </CardHeader>

            <CardContent>
                <Form @submit.prevent="createSupply">
                    <FormField class="mb-6 flex flex-col gap-2">
                        <Label required>Name</Label>

                        <Input
                            v-model="form.name"
                            placeholder="Name"
                        />

                        <InputError :message="form.errors.name" />
                    </FormField>

                    <FormField class="mb-6 flex flex-col gap-2">
                        <Label>Description</Label>

                        <Textarea
                            v-model="form.description"
                            placeholder="Description"
                        />

                        <InputError :message="form.errors.description" />
                    </FormField>

                    <FormField class="mb-6 flex flex-col gap-2">
                        <Label required>Price</Label>

                        <NumberField
                            v-model="form.price"
                            :default-value="0.0"
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

                    <FormField class="mb-6 flex flex-col gap-2">
                        <Label required>Quantity</Label>

                        <Input
                            type="number"
                            v-model="form.quantity"
                            placeholder="Price"
                        />

                        <InputError :message="form.errors.quantity" />
                    </FormField>

                    <FormField class="mb-6 flex flex-col gap-2">
                        <Label required>Reorder Level</Label>

                        <Input
                            type="number"
                            v-model="form.reorder_level"
                            placeholder="Reorder Level"
                        />

                        <InputError :message="form.errors.reorder_level" />
                    </FormField>

                    <Button :disabled="form.processing"> Create supply </Button>
                </Form>
            </CardContent>
        </Card>
    </AppLayout>
</template>
