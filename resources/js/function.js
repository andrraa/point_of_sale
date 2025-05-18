export function formatNumberToRupiah(number) {
    if (!number) return '';
    return number
            .toString().replace(/\D/g, '')
            .replace(/\B(?=(\d{3})+(?!\d))/g, '.');
}

window.formatNumberToRupiah = formatNumberToRupiah;