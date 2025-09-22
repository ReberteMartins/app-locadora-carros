<template>
    <div class="modal fade" :id="id" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">{{titulo}}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <slot name="alertas"/>

                    <slot name="conteudo"/>
                </div>
                <div class="modal-footer">
                    <slot name="rodape"/>

                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['id', 'titulo']
    }
</script>
