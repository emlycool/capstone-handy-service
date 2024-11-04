<script>
export default {
    methods: {
        formatCurrency(amount) {
            return new Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' }).format(amount);
        },
        
        formatToLocalTime(dateString) {
            const options = {
                year: 'numeric',
                month: '2-digit',
                day: '2-digit',
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit',
                hour12: false // Use true for 12-hour format
            };
            return new Date(dateString).toLocaleString(undefined, options);
        }
    },
};
</script>