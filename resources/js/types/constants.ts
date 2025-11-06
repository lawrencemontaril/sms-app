import { BadgeVariants } from '@/components/ui/badge';
import { SupplyRequest } from '.';

export const SUPPLY_REQUEST_STATUS: {
    label: string;
    value: SupplyRequest['status'];
    badge: BadgeVariants['variant'];
}[] = [
    { label: 'Pending', value: 'pending', badge: 'warning' },
    { label: 'Approved', value: 'approved', badge: 'success' },
    { label: 'Rejected', value: 'rejected', badge: 'destructive' },
];
