import type { PageProps } from '@inertiajs/core';
import type { LucideIcon } from 'lucide-vue-next';
import type { Config } from 'ziggy-js';

export interface Auth {
    user: User;
}

export interface BreadcrumbItem {
    title: string;
    href: string;
}

export type BreadcrumbItemType = BreadcrumbItem;

export interface NavItem {
    title: string;
    href: string;
    icon?: LucideIcon;
    isActive?: boolean;
    access: boolean;
}

export interface SharedData extends PageProps {
    name: string;
    auth: Auth;
    ziggy: Config & { location: string };
    sidebarOpen: boolean;
}

/*
| ---------------------
|  Backend data types.
| ---------------------
*/
export interface PaginatedData<T> {
    data: T[];
    meta: PaginationMetadata;
}

export interface PaginationMetadata {
    path: string;
    current_page: number;
    per_page: number;
    last_page: number;
    total: number;
    from: number | null;
    to: number | null;
}

export interface Notification {
    id: string;
    message: string;
    link: string;
    created_at: string;
}

export interface User {
    id: number;
    department_id: number;
    name: string;
    email: string;
    avatar?: string;
    role: string;
    permissions: string[];
    is_department_head: boolean;
    notifications: Notification[];

    department?: Department;
}

export interface Department {
    id: number;
    user_id: number | null;
    name: string;
    code: string;

    head?: User;
    members?: User[];
}

export interface Supply {
    id: number;
    name: string;
    description: string;
    price: number;
    quantity: number;
    reorder_level: number;

    is_low_stock: boolean;
    is_no_stock: boolean;
}

export interface SupplyRequest {
    id: number;
    department_id: number;
    user_id: number;
    subject: string;
    message: string | null;
    status: 'pending' | 'approved' | 'rejected';
    approved_at: string;
    created_at: string;
    updated_at: string;

    total_cost: number;

    department?: Department;
    user?: User;
    supply_request_items?: SupplyRequestItem[];
}

export interface SupplyRequestItem {
    id: number;
    supply_request_id: number;
    supply_id: number;
    quantity: number;
    cost: number;

    supply_request?: SupplyRequest;
    supply?: Supply;
}
