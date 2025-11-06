export function useFormatters() {
    const formatCurrency = (value: number) =>
        new Intl.NumberFormat('en-PH', {
            style: 'currency',
            currency: 'PHP',
            currencySign: 'accounting',
            minimumFractionDigits: 2,
        }).format(value);

    const formatNumber = (value: number) => new Intl.NumberFormat('en-PH').format(value);

    return { formatCurrency, formatNumber };
}
