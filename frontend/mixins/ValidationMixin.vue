<script>
export default {
    methods: {
        toastError(error){
            if([400, 401, 422].includes(error?.response?.status) ){
                this.$message.error(error?.response?.data?.message ?? "request failed");
            }
        }
    },
};
</script>