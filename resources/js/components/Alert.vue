<template>
    <div :class="estilo" role="alert">
        {{texto}}
    </div>
</template>

<script>
    export default {
        props: ['tipo', 'texto'],
        computed: {
            estilo() {
                return 'alert alert-'+this.tipo
            }
        }
    }
</script>
