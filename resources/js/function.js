export class CustomFunction {
    formatNumberToRupiah(number) {
        if (!number) return 0;
        return number
            .toString()
            .replace(/\D/g, "")
            .replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

    numberOnly(data) {
        return data.replace(/[^0-9]/g, "");
    }
}

window.CustomFunction = new CustomFunction();
