<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">


                <!-- Inicio do card de busca -->
                <card-component titulo="Buscar de Marcas">

                        <template v-slot:conteudo>
                            <div class="row">
                                <div class="col mb-3">
                                    <input-container-component titulo="ID" id="inputId" id-help="IdHelp" texto-ajuda="Informe o ID da marca">
                                        <input type="number" class="form-control" id="InputId" aria-describedby="idHelp" placeholder="ID">
                                    </input-container-component>
                                </div>

                                <div class="col mb-3">
                                    <input-container-component titulo="Nome da marca" id="InputNome" id-help="nomeHelp" texto-ajuda="Informe o nome do registro">
                                        <input type="text" class="form-control" id="InputNome" aria-describedby="nomeHelp" placeholder="Nome da Marca">
                                    </input-container-component>

                                </div>
                            </div>
                        </template>

                        <template v-slot:rodape>
                            <button type="submit" class="btn btn-primary btn-sm float-end">Pesquisar</button>
                        </template>

                </card-component>
                <!-- Fim do card de busca -->



                <!-- Inicio do card de listagem de marcas -->
                <card-component titulo="Relação de Marcas">

                        <template v-slot:conteudo>
                            <table-component></table-component>
                        </template>

                        <template v-slot:rodape>
                            <button type="button" class="btn btn-primary btn-sm float-end">Adicionar</button>
                        </template>

                </card-component>

                <!-- Fim do card de listagem de marcas -->

            </div>
        </div>
    </div>
</template>

<script>

</script>
