<template>
    <div class="card mb-3">
        <div class="card-header">{{titulo}}</div>

        <div class="card-body">
            <slot name="conteudo"/>
        </div>

        <div class="card-footer">
            <slot name="rodape"/>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['titulo']
    }
</script>
