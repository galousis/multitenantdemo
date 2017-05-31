<template>
    <footer class="main-footer">
        <div class="text-center footer">
            {{message}}
        </div>
    </footer>
</template>
<style>
    .footer {
        background: #fff;
        padding: 10px 0;
    }
</style>
<script>
    export default {
        ready() {
            console.log('Component ready.')
        },
        data(){
            return {
                message: "demo"
            }

        }
    }
</script>
