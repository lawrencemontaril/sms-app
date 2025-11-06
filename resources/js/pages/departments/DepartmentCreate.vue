<script lang="ts" setup>
import InputError from '@/components/InputError.vue';
import Button from '@/components/ui/button/Button.vue';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Form, FormField } from '@/components/ui/form';
import Input from '@/components/ui/input/Input.vue';
import Label from '@/components/ui/label/Label.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';

const form = useForm({
    name: '',
    code: '',
});

function createDepartment() {
    form.post('/departments');
}
</script>

<template>
    <AppLayout>
        <Head title="Create department" />

        <Card>
            <CardHeader>
                <CardTitle>Create a department</CardTitle>
            </CardHeader>

            <CardContent>
                <Form @submit.prevent="createDepartment">
                    <FormField>
                        <Label required>Name</Label>

                        <Input v-model="form.name" placeholder="Name" />

                        <InputError :message="form.errors.name" />
                    </FormField>

                    <FormField>
                        <Label required>Code</Label>

                        <Input v-model="form.code" type="text" placeholder="Code" />

                        <InputError :message="form.errors.code" />
                    </FormField>

                    <Button :disabled="form.processing"> Create department </Button>
                </Form>
            </CardContent>
        </Card>
    </AppLayout>
</template>
